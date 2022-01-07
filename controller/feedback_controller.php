<?php

session_start();

require_once("../model/feedback_model.php");

class FeedbackController extends Feedback
{

    public function addNewFeedback($content, $starCount, $customerId, $invoiceId)
    {
        $result = $this->setNewFeedback($content, $starCount, $customerId, $invoiceId);

        return $result;
    }
}

$feedbackCont_obj = new FeedbackController($conn);

//////////////////////////// Switch Status //////////////////////////////
$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "";

switch ($type) {

    case 'addFeedback':

        $starCount = $_POST["rate"];
        $content = trim($_POST["comment"]);
        $invoiceId = $_POST["invoiceId"];
        $customerId = $_SESSION["customer"]["userId"];

        $result = $feedbackCont_obj->addNewFeedback($content, $starCount, $customerId, $invoiceId);

        if ($result) {
            echo "ok";
        } else {
            echo "error";
        }

        break;
}
