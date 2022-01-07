<?php

require_once("../common/dbConnection.php");

class Size
{
    private $conn;
    private $table = "sizes";

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    protected function getSize_BySizeId($sizeId)
    {
        $sql = "SELECT * FROM $this->table WHERE size_id = $sizeId";
        $result = $this->conn->query($sql);

        return $result;
    }

    protected function getSizes_ByProductId($productId)
    {
        $sql = "SELECT * FROM $this->table s INNER JOIN product_has_size phs ON s.size_id = phs.size_sizeId " .
            "WHERE phs.product_productId = $productId";

        $result = $this->conn->query($sql) or die($this->conn->error);

        return $result;
    }

    ///////////////////////////// Public Access ///////////////////////////
    public function giveSize_BySizeId($sizeId)
    {
        $result = $this->getSize_BySizeId($sizeId);

        return $result;
    }

    public function giveSizes_ByProductId($productId)
    {
        $result = $this->getSizes_ByProductId($productId);

        return $result;
    }
}
