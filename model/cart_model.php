<?php

require_once("../common/dbConnection.php");

class Cart
{
    private $conn;
    private $table = "cart";

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    protected function setNewItem($session_id, $stockId)
    {
        $sql = "INSERT INTO $this->table(sess_id, stock_stockId) VALUES('$session_id', $stockId)";

        $result = $this->conn->query($sql);
        return $result;
    }

    protected function getItem_BySessionAndStockId($session_id, $stockId)
    {
        $sql = "SELECT * FROM $this->table WHERE sess_id = '$session_id' AND stock_stockId = $stockId";

        $result = $this->conn->query($sql);
        return $result;
    }

    protected function increaseCartItem($session_id, $stockId)
    {
        $sql = "UPDATE $this->table SET item_qty = item_qty + 1 WHERE sess_id = '$session_id' AND stock_stockId = $stockId";

        $result = $this->conn->query($sql);
        return $result;
    }

    protected function decreaseCartItem($session_id, $stockId)
    {
        $sql = "UPDATE $this->table SET item_qty = item_qty - 1 WHERE sess_id = '$session_id' AND stock_stockId = $stockId";

        $result = $this->conn->query($sql);
        return $result;
    }

    protected function deleteItem_FromCart($session_id, $stockId)
    {
        $sql = "DELETE FROM $this->table WHERE sess_id = '$session_id' AND stock_stockId = $stockId";

        $result = $this->conn->query($sql);
        return $result;
    }

    protected function removeCart($session_id)
    {
        $sql = "DELETE FROM $this->table WHERE sess_id = $session_id";

        $result = $this->conn->query($sql);
        return $result;
    }

    //////////////////////////// Stock Updates ////////////////////////////
    protected function decreaseItem_FromStock($stockId)
    {
        $sql = "UPDATE stocks SET stock_count = stock_count - 1 WHERE stock_id = $stockId";

        $result = $this->conn->query($sql);
        return $result;
    }

    protected function increaseItem_FromStock($stockId)
    {
        $sql = "UPDATE stocks SET stock_count = stock_count + 1 WHERE stock_id = $stockId";

        $result = $this->conn->query($sql);
        return $result;
    }

    public function deleteCart($session_id)
    {
        $result = $this->removeCart($session_id);
        return $result;
    }
}
