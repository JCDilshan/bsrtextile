<?php

session_start();

include_once("../model/cart_model.php");

class CartController extends Cart
{
    public function createNewItem($session_id, $stockId)
    {
        $result = $this->setNewItem($session_id, $stockId);

        return $result;
    }

    public function checkCartItem($session_id, $stockId)
    {
        $result = $this->getItem_BySessionAndStockId($session_id, $stockId);

        return $result;
    }

    public function addItemtoCart($session_id, $stockId)
    {
        $result = $this->increaseCartItem($session_id, $stockId);

        return $result;
    }

    public function removeItem_FromCart($session_id, $stockId)
    {
        $result = $this->deleteItem_FromCart($session_id, $stockId);

        return $result;
    }

    public function removeQty_FromCart($session_id, $stockId)
    {
        $result = $this->decreaseCartItem($session_id, $stockId);

        return $result;
    }

    ///////////////////////////// Stock Controls ///////////////////////
    public function removeItem_FromStock($stockId)
    {
        $result = $this->decreaseItem_FromStock($stockId);

        return $result;
    }

    public function addQty_ToStock($stockId)
    {
        $result = $this->increaseItem_FromStock($stockId);

        return $result;
    }
}

$cartCont_obj = new CartController($conn);

//////////////////////////// Switch Status //////////////////////////////
$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "";

switch ($type) {

    case 'addItem':

        $session_id = session_id();
        $stockId = $_POST["stockId"];

        $result = $cartCont_obj->checkCartItem($session_id, $stockId);

        if ($result->num_rows > 0) {
            $result_2 = $cartCont_obj->addItemtoCart($session_id, $stockId);
        } else {
            $result_2 = $cartCont_obj->createNewItem($session_id, $stockId);
        }

        if ($result_2) {
            $cartCont_obj->removeItem_FromStock($stockId);
        }

        break;

    case 'removeItem':

        $session_id = session_id();
        $stockId = $_POST["itemId"];

        $cartCont_obj->removeItem_FromCart($session_id, $stockId);

        break;

    case 'decreaseQty':

        $session_id = session_id();
        $stockId = $_POST["stockId"];

        $result = $cartCont_obj->removeQty_FromCart($session_id, $stockId);

        if ($result) {
            $cartCont_obj->addQty_ToStock($stockId);
        }

        break;
}
