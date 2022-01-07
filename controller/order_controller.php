<?php

session_start();

require_once("../model/order_model.php");

class OrderController extends Order
{

    public function viewOrderDetails_ByInvoiceId($invoiceId)
    {
        $result = $this->getOrderDetails_ByInvoiceId($invoiceId);

        return $result;
    }

    public function createNewOrder($date, $fname, $lname, $addr1, $addr2, $addr3, $postalId, $contact, $email, $customerId, $invoiceId)
    {
        $result = $this->setNewOrder($date, $fname, $lname, $addr1, $addr2, $addr3, $postalId, $contact, $email, $customerId, $invoiceId);

        return $result;
    }

    public function createOrderItems($orderId, $productId, $qty, $price, $subTotal, $sizeId)
    {
        $result = $this->setOrderItems($orderId, $productId, $qty, $price, $subTotal, $sizeId);
        return $result;
    }
}

$ordCont_obj = new OrderController($conn);

//////////////////////////// Switch Status //////////////////////////////
$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "";

switch ($type) {

    case 'viewOrderDetails':

        $invoiceId = $_POST["invoiceId"];

        $getRecords = $ordCont_obj->viewOrderDetails_ByInvoiceId($invoiceId);
        $getRecordArray = $getRecords->fetch_assoc();

        $getRecords_2 = $ordCont_obj->viewOrderDetails_ByInvoiceId($invoiceId);

?>
        <div class="row mb-3 font-weight-bold">
            <div class="col-sm-3">
                <i class="fas fa-check"></i>
                <label for="">Date and Time :</label>
            </div>
            <div class="col-sm-4">
                <label for=""><?php echo $getRecordArray["invoice_time"]; ?></label>
            </div>
        </div>

        <table class="table font-weight-bold">
            <thead>
                <tr>
                    <td>#</td>
                    <td>Product</td>
                    <td>Product Price</td>
                    <td>Quantity</td>
                    <td>Sub Total</td>
                </tr>
            </thead>

            <tbody>
                <?php
                $count = 1;
                while ($getRecordArray_2 = $getRecords_2->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $count; ?></td>
                        <td><?php echo $getRecordArray_2["product_name"]; ?></td>
                        <td><?php echo $getRecordArray_2["product_price"]; ?></td>
                        <td><?php echo $getRecordArray_2["product_qty"]; ?></td>
                        <td class="text-right"><?php echo $getRecordArray_2["sub_total"]; ?></td>
                    </tr>
                <?php
                    $count++;
                }
                ?>
                <tr>
                    <td class="text-center" colspan="4">
                        Delivery Fee
                    </td>
                    <td class="text-right">
                        200.00
                    </td>
                </tr>
                <tr>
                    <td class="text-center" colspan="4">
                        <h5>Total</h5>
                    </td>
                    <td>
                        <h5 class="text-right"><?php echo $getRecordArray["invoice_net_total"]; ?></h5>
                    </td>
                </tr>
            </tbody>
        </table>

<?php
        break;

    case 'addOrder':

        $fname = $_POST["fname"];
        $lname = $_POST["lname"];
        $email = $_POST["email"];
        $contact = $_POST["contact"];

        $postalId = $_POST["postalcode"];
        $addr1 = $_POST["addr1"];
        $addr2 = $_POST["addr2"];
        $addr3 = $_POST["addr3"];

        $total = $_POST["total"];
        $payAmt = $_POST["AmtPay"];

        include_once("../model/invoice_model.php");
        $invoice_obj = new Invoice($conn);

        $getInv = $invoice_obj->giveInvoiceCount_ByDate();
        $getInvRow = $getInv->fetch_assoc();

        $count = $getInvRow["inv_count"];
        $count += 1;

        date_default_timezone_set("Asia/Colombo");
        $toDate = date("Y-m-d");

        $newInvNum = "INV" . str_replace("-", "", $toDate) . str_pad($count, 4, "0", STR_PAD_LEFT);

        $customerId = $_SESSION["customer"]["userId"];

        $invId = $invoice_obj->createNewInvoice($newInvNum, $total, $payAmt, $customerId);

        if ($invId) {
            $orderId = $ordCont_obj->createNewOrder($toDate, $fname, $lname, $addr1, $addr2, $addr3, $postalId, $contact, $email, $customerId, $invId);

            if ($orderId) {
                include_once("../model/cart_model.php");
                $cart_obj = new Cart($conn);

                $session_id = session_id();
                $cart_obj->deleteCart($session_id);

                /////////////////////// Customer Email //////////////////
                $subject = "Your Order has been received !";

                $body = '<div style="padding: 16px;">
                <h1 style="padding:16px; background-color: gold; color:white; text-align:center;">
                Thank You For Your Order
                </h1>
                <h2>Hi...' . $fname . ' ' . $lname . '</h2>
                <h3>
                Just to let you know — we have received your order #' . $newInvNum . ', and it is now being processed :
                </h3>
                <h5 style="color: gold;">
                Date  : ' . $toDate . '
                </h5>

                <table style="border: 1px solid black; padding: 16px; width: 100%" cell-spacing="0">
                <thead>
                  <tr>
                    <td style="border: 1px solid black; padding: 16px;">Product</td>
                    <td style="border: 1px solid black; padding: 16px;">Price</td>
                    <td style="border: 1px solid black; padding: 16px;">Quantity</td>
                    <td style="border: 1px solid black; padding: 16px;">SubTotal</td>
                  </tr>
                </thead>

                <tbody>
                ';

                foreach ($_SESSION["cart"] as $key => $value) {
                    include_once("../model/stock_model.php");
                    $stock_obj = new Stock($conn);

                    $stock_obj->removeQty_FromStock($value["itemId"], $value["productQty"]);

                    $ordCont_obj->createOrderItems($orderId, $value["productId"], $value["productQty"], $value["productPrice"], $value["productSubTotal"], $value["sizeId"]);

                    include_once("../model/product_model.php");
                    $prod_obj = new Product($conn);

                    $prodInfo = $prod_obj->giveProduct_ByProductId($value["productId"]);
                    $prodRow = $prodInfo->fetch_assoc();

                    include_once("../model/size_model.php");
                    $size_obj = new Size($conn);

                    $sizeInfo = $size_obj->giveSize_BySizeId($value["sizeId"]);
                    $sizeRow = $sizeInfo->fetch_assoc();

                    $body .= '
                <tr>
                    <td style="border: 1px solid black; padding: 16px;">' . $prodRow["product_name"] . ' Size : ' . $sizeRow["size_name"] . '</td>
                    <td style="border: 1px solid black; padding: 16px;">' . $value["productPrice"] . '</td>
                    <td style="border: 1px solid black; padding: 16px;">' . $value["productQty"] . '</td>
                    <td style="border: 1px solid black; padding: 16px;">' . $value["productSubTotal"] . '</td>
                </tr>
                    ';
                }

                $body .= '
                 <tr>
                  <td colspan="3" style="border: 1px solid black; padding: 16px;">Net Total</td>
                  <td style="border: 1px solid black; padding: 16px;">' . $total . '</td>
                 </tr>

                 <tr>
                 <td colspan="3" style="border: 1px solid black; padding: 16px;">Shipping</td>
                 <td style="border: 1px solid black; padding: 16px;">200.00</td>
                </tr>

                <tr>
                  <td colspan="3" style="border: 1px solid black; padding: 16px;">Total</td>
                  <td style="border: 1px solid black; padding: 16px;">' . $payAmt . '</td>
                 </tr>
                </tbody>
            </table>
        </div>
                ';

                include_once("../common/mailConfig.php");
                sendEmail($email, $subject, $body);

                unset($_SESSION["cart"]);

                $response = "Your Order Has Been Placed Successfully";

                header("Location: ../view/home.php?response=$response");
            } else {
                $response = "Something went wrong. Order Not Successful";
                $status = "0";

                header("Location: ../view/payment.php?response=$response&res_status=$status");
            }
        } else {
            $response = "Something went wrong. Order Not Successful";
            $status = "0";

            header("Location: ../view/payment.php?response=$response&res_status=$status");
        }

        break;
}
