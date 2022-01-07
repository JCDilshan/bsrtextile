<?php

require_once("../common/dbConnection.php");

class Product
{
    private $conn;
    private $table = "products";
    private $table_img = "product_image";

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    protected function getNew_MaleProducts()
    {
        $sql = "SELECT * FROM $this->table WHERE collection_collectionId = 1 ORDER BY product_id DESC LIMIT 4";
        $result = $this->conn->query($sql);

        return $result;
    }

    protected function getNew_FemaleProducts()
    {
        $sql = "SELECT * FROM $this->table WHERE collection_collectionId = 2 ORDER BY product_id DESC LIMIT 4";
        $result = $this->conn->query($sql);

        return $result;
    }

    protected function getAllImages_ByProductId($productId)
    {
        $sql = "SELECT * FROM $this->table_img WHERE product_productId = $productId";
        $result = $this->conn->query($sql);

        return $result;
    }

    protected function getBrands_ByCollId($collId)
    {
        $sql = "SELECT p.brand_brandId, b.brand_id, b.brand_name FROM $this->table p, brands b WHERE " .
            "p.brand_brandId = b.brand_id AND p.collection_collectionId = $collId GROUP BY b.brand_id";

        $result = $this->conn->query($sql);

        return $result;
    }

    protected function getCollTypes_ByCollId($collId)
    {
        $sql = "SELECT p.collection_type_collectionTypeId, ct.collection_type_id, ct.collection_type_name FROM $this->table p, collection_types ct WHERE " .
            "p.collection_type_collectionTypeId = ct.collection_type_id AND " .
            "p.collection_collectionId = $collId GROUP BY ct.collection_type_id";

        $result = $this->conn->query($sql);

        return $result;
    }

    protected function getCategory_ByCollId($collId)
    {
        $sql = "SELECT p.category_categoryId, c.category_id, c.category_name FROM $this->table p, categories c WHERE " .
            "p.category_categoryId = c.category_id AND p.collection_collectionId = $collId GROUP BY c.category_id";

        $result = $this->conn->query($sql);

        return $result;
    }

    protected function filterProducts($brandId, $collTypeId, $categoryId, $collId)
    {
        $sql = "SELECT * FROM $this->table WHERE brand_brandId = $brandId AND " .
            "collection_type_collectionTypeId = $collTypeId AND " .
            "category_categoryId = $categoryId AND " .
            "collection_collectionId = $collId";

        $result = $this->conn->query($sql);

        return $result;
    }

    protected function getProductInfo_ByProductId($productId)
    {
        $sql = "SELECT * FROM $this->table p " .
            "INNER JOIN categories c ON p.category_categoryId = c.category_id " .
            "INNER JOIN brands b ON p.brand_brandId = b.brand_id " .
            "INNER JOIN collections cl ON p.collection_collectionId = cl.collection_id " .
            "INNER JOIN collection_types ct ON p.collection_type_collectionTypeId = ct.collection_type_id " .
            "AND p.product_id = $productId";

        $result = $this->conn->query($sql) or die($this->conn->error);

        return $result;
    }

    protected function getProduct_ByProductId($productId)
    {
        $sql = "SELECT * FROM $this->table WHERE product_id = $productId";

        $result = $this->conn->query($sql);
        return $result;
    }

    ///////////////////////////// Public Access //////////////////////////
    public function giveNew_MaleProducts()
    {
        $result = $this->getNew_MaleProducts();
        return $result;
    }

    public function giveNew_FemaleProducts()
    {
        $result = $this->getNew_FemaleProducts();
        return $result;
    }

    public function giveAllImages_ByProductId($productId)
    {
        $result = $this->getAllImages_ByProductId($productId);
        return $result;
    }

    public function giveBrands_ByCollId($collId)
    {
        $result = $this->getBrands_ByCollId($collId);
        return $result;
    }
    public function giveCollTypes_ByCollId($collId)
    {
        $result = $this->getCollTypes_ByCollId($collId);
        return $result;
    }
    public function giveCategory_ByCollId($collId)
    {
        $result = $this->getCategory_ByCollId($collId);
        return $result;
    }

    public function giveProductInfo_ByProductId($productId)
    {
        $result = $this->getProductInfo_ByProductId($productId);
        return $result;
    }

    public function giveProduct_ByProductId($productId)
    {
        $result = $this->getProduct_ByProductId($productId);
        return $result;
    }
}
