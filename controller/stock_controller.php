<?php

include_once("../model/stock_model.php");

class StockController extends Stock
{
    public function giveStockInfo($productId, $sizeId)
    {
        $result = $this->getStock_ByProductAndSize($productId, $sizeId);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            $row = "error";
        }

        return json_encode($row);
    }

    public function giveStockInfo_ByStockId($stockId)
    {
        $result = $this->getStock_ByStockId($stockId);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
        } else {
            $row = "error";
        }

        return json_encode($row);
    }
}

$stockCont_obj = new StockController($conn);

//////////////////////////// Switch Status //////////////////////////////
$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "";

switch ($type) {

    case 'getStockInfo':

        $productId = $_GET["productId"];
        $sizeId = $_GET["sizeId"];

        echo $stockCont_obj->giveStockInfo($productId, $sizeId);

        break;

    case 'getInfoByStockId':

        $stockId = $_GET["stockId"];

        echo $stockCont_obj->giveStockInfo_ByStockId($stockId);

        break;
}
