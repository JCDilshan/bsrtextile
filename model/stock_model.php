<?php

require_once("../common/dbConnection.php");

class Stock
{
    private $conn;
    private $table = "stocks";

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    protected function getStock_ByProductId($productId)
    {
        $sql = "SELECT * FROM $this->table WHERE product_productId = $productId";
        $result = $this->conn->query($sql);

        return $result;
    }

    protected function getStock_ByProductAndSize($productId, $sizeId)
    {
        $sql = "SELECT * FROM $this->table WHERE product_productId = $productId AND size_sizeId = $sizeId";
        $result = $this->conn->query($sql);

        return $result;
    }

    protected function getStock_ByStockId($stockId)
    {
        $sql = "SELECT * FROM $this->table WHERE stock_id = $stockId";
        $result = $this->conn->query($sql);

        return $result;
    }

    protected function decreaseQty_FromStock($stockId, $qty)
    {
        $sql = "UPDATE $this->table SET stock_count = stock_count - $qty WHERE stock_id = $stockId";
        $result = $this->conn->query($sql);
        return $result;
    }

    ///////////////////////////// Public Access ///////////////////////////
    public function giveStock_ByProductId($productId)
    {
        $result = $this->getStock_ByProductId($productId);

        return $result;
    }

    public function removeQty_FromStock($stockId, $qty)
    {
        $result = $this->decreaseQty_FromStock($stockId, $qty);

        return $result;
    }
}
