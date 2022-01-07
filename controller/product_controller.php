<?php

include_once("../model/product_model.php");

class ProductController extends Product
{
    public function giveFilteredProducts($brandId, $collTypeId, $categoryId, $collId)
    {
        $result = $this->filterProducts($brandId, $collTypeId, $categoryId, $collId);

        return $result;
    }
}

$prodCont_obj = new ProductController($conn);

/////////////////////////// Switch Status //////////////////////////////
$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "";

switch ($type) {

    case 'filterProducts':

        $collId = $_GET["collId"];
        $collTypeId = $_GET["collTypeId"];
        $brandId = $_GET["brandId"];
        $categoryId = $_GET["categoryId"];

        $productresult = $prodCont_obj->giveFilteredProducts($brandId, $collTypeId, $categoryId, $collId);

        if ($productresult->num_rows > 0) {
?>
            <div class="row">
                <?php
                while ($productRow = $productresult->fetch_assoc()) {

                    $productId = $productRow["product_id"];
                    $productImg = $prodCont_obj->giveAllImages_ByProductId($productId);
                    $imageRow = $productImg->fetch_assoc();

                    include_once("../model/stock_model.php");
                    $stock_obj = new Stock($conn);

                    $stockInfo = $stock_obj->giveStock_ByProductId($productId);
                    $stockRow = $stockInfo->fetch_assoc();

                    include_once("../model/size_model.php");
                    $size_obj = new Size($conn);

                    $sizeInfo = $size_obj->giveSize_BySizeId($stockRow["size_sizeId"]);
                    $sizeRow = $sizeInfo->fetch_assoc();
                ?>
                    <div class="col-sm-6 col-md-3 p-3">
                        <a href="viewItem.php?productId=<?php echo $productId; ?>" type="button" class="text-decoration-none text-muted w-100">
                            <div class="card shadow text-center">
                                <img style="height: 300px;" class="card-img-top zoom img-fluid" src="../image/pro_img/<?php echo $imageRow["img_name"]; ?>" />
                                <br>
                                <div class="card-body p-1">
                                    <span class="productName">
                                        <?php echo $productRow["product_name"]; ?>
                                    </span>
                                    <span class="productName">
                                        <?php echo "Size : " . $sizeRow["size_name"]; ?>
                                    </span>
                                    <span class="productName">
                                        <?php echo "Rs " . $stockRow["stock_sell_price"]; ?>
                                    </span>
                                </div>
                            </div>
                        </a>
                    </div>
                <?php } ?>
            </div>
        <?php
        } else {
        ?>
            <div class="row">
                <div class="col-sm-12">
                    <h2 class="text-danger text-center">Product Not Found</h2>
                </div>
            </div>
<?php
        }

        break;
}
