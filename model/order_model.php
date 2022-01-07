<?php

require_once("../common/dbConnection.php");

class Order
{
    private $conn;
    private $table = "orders";

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    protected function getOrders_ByCustomerId($customerId)
    {
        $sql = "SELECT * FROM $this->table WHERE customer_customerId = $customerId";
        $result = $this->conn->query($sql);

        return $result;
    }

    protected function getOrderDetails_ByInvoiceId($invoiceId)
    {
        $sql = "SELECT * FROM $this->table ord, invoices inv, order_has_product ohp, products pro WHERE " .
            "ord.invoice_invoiceId = inv.invoice_id AND " .
            "ord.order_id = ohp.order_orderid AND " .
            "ohp.product_productId = pro.product_id AND " .
            "ord.invoice_invoiceId = $invoiceId";

        $result = $this->conn->query($sql);

        return $result;
    }

    protected function setNewOrder($date, $fname, $lname, $addr1, $addr2, $addr3, $postalId, $contact, $email, $customerId, $invoiceId)
    {
        $sql = "INSERT INTO $this->table(
            order_date, 
            order_cusFname, 
            order_cusLname, 
            order_cusAddr1, 
            order_cusAddr2, 
            order_cusAddr3, 
            order_cusPostalcode, 
            order_cusContact, 
            order_cusEmail, 
            customer_customerId, 
            invoice_invoiceId) VALUES('$date', '$fname', '$lname', '$addr1', '$addr2', '$addr3', $postalId, '$contact', '$email', $customerId, $invoiceId)";

        $this->conn->query($sql) or die($this->conn->error);

        $result = $this->conn->insert_id;
        return $result;
    }

    protected function setOrderItems($orderId, $productId, $qty, $price, $subTotal, $sizeId)
    {
        $sql = "INSERT INTO order_has_product(
            order_orderId, 
            product_productId, 
            product_qty, 
            product_price, sub_total, size_sizeId) VALUES($orderId, $productId, $qty, $price, $subTotal, $sizeId)";

        $result = $this->conn->query($sql) or die($this->conn->error);

        return $result;
    }

    /////////////////////////// Public Access //////////////////////
    public function giveOrders_ByCustomerId($customerId)
    {
        $result = $this->getOrders_ByCustomerId($customerId);

        return $result;
    }
}
