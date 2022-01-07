<?php

require_once("../model/faq_model.php");

class FAQController extends FAQ
{
    public function addFAQ($content, $name, $email)
    {
        $result = $this->setNewFAQ($content, $name, $email);

        if ($result) {
            $response = "Send Messege Successfully";
            $status = "1";
        } else {
            $response = "Something Went Wrong. Task Fail";
            $status = "0";
        }

        header("Location: ../view/contactUs.php?response=$response&res_status=$status");
    }
}

$faqCont_obj = new FAQController($conn);

//////////////////////////// Switch Status //////////////////////////////
$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "";

switch ($type) {

    case 'addFAQ':

        $content = trim($_POST["msg"]);
        $name = trim($_POST["cusName"]);
        $email = trim($_POST["cusEmail"]);

        $faqCont_obj->addFAQ($content, $name, $email);

        break;
}
