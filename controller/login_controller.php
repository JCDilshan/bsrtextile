<?php

session_start();

require_once("../model/customer_model.php");

class LoginController extends Customer
{
    public function checkLogin($email, $pw)
    {
        $result = $this->getCustomer_ByEmail($email);

        if ($result->num_rows > 0) {

            $login_info = $result->fetch_assoc();
            $getPw = $login_info["login_password"];

            if ($getPw == sha1($pw)) {

                $customerId = $login_info["customer_customerId"];
                $cusInfo = $this->getCustomer_ByCustomerID_FromCustomer($customerId);
                $cus_array = $cusInfo->fetch_assoc();

                $customer = array(
                    "userId" => $customerId,
                    "userFname" => $cus_array["customer_fname"],
                    "userLname" => $cus_array["customer_lname"],
                    "userImage" => $cus_array["customer_img"],
                );

                $_SESSION["customer"] = $customer;

                unset($_SESSION["otp"]);

                header("Location: ../view/dashboard.php");
            } else {
                $response = "Email and Password doesn't Match";
                $status = "0";

                header("Location: ../view/login.php?response=$response&res_status=$status");
            }
        } else if (isset($_SESSION["otp"])) {

            $otp = $_SESSION["otp"]["num"];
            $se_email = $_SESSION["otp"]["email"];

            if ($se_email == $email && $otp == $pw) {
                unset($_SESSION["otp"]);
                header("Location: ../view/registerForm.php?email=$email");
            } else {
                $response = "OTP credentials doesn't match";
                $status = "0";

                header("Location: ../view/login.php?response=$response&res_status=$status");
            }
        } else {
            $response = "You Are Unregistered User";
            $status = "0";

            header("Location: ../view/login.php?response=$response&res_status=$status");
        }
    }

    public function checkCustomerEmail($email)
    {
        $result = $this->getCustomer_ByEmail($email);
        return $result;
    }
}

$loginCont_obj = new LoginController($conn);

/////////////////////////////// Switch Status ///////////////////////
$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "";

switch ($type) {

    case 'sendOTP':

        if (!isset($_SESSION["otp"])) {
            $email = trim($_POST["email"]);
            $otp_gen = rand(10000, 99999);

            $otp_array = array("email" => $email, "num" => $otp_gen);

            include_once("../common/mailConfig.php");

            $subject = "Email Verification Code";
            $body = "<h3>Your Verification Code is :- </h3><h2>" . $otp_gen . "</h2>";

            $MailResult = sendEmail($email, $subject, $body);

            if ($MailResult) {

                $_SESSION["otp"] = $otp_array;

                $response = "Email Has Been Sent";
                $status = "1";
            } else {
                $response = "Connection Error. Task Fail";
                $status = "0";
            }
        } else {
            $response = "Email Already Sent";
            $status = "0";
        }

        header("Location: ../view/login.php?response=$response&res_status=$status");

        break;

    case 'login':

        $email = trim($_POST["email"]);
        $pw = trim($_POST["pw"]);

        $loginCont_obj->checkLogin($email, $pw);

        break;

    case 'sendResetLink':

        $email = trim($_POST["email"]);

        $checkEmail = $loginCont_obj->checkCustomerEmail($email);

        if ($checkEmail->num_rows > 0) {

            $getInfo = $checkEmail->fetch_assoc();
            $cusId = base64_encode($getInfo["customer_customerId"]);
            $key = base64_encode(rand(10000, 99999));

            include_once("../common/mailConfig.php");

            $subject = "Reset Password";
            $body = "Reset your password via this link : http://localhost/final_project/view/changePassword.php?resetKey=$key&cusId=$cusId";

            $sendMail = sendEmail($email, $subject, $body);

            if ($sendMail) {

                $_SESSION["resetKey"] = $key;

                $response = "Reset Link has been sent";
                $status = "1";
            } else {
                $response = "Something Went Wrong. Try Again";
                $status = "0";
            }
        } else {
            $response = "Entered Email Doesn't Match With Our Records";
            $status = "0";
        }

        header("Location: ../view/passwordReset.php?response=$response&res_status=$status");

        break;

    case 'logout':

        unset($_SESSION["customer"]);

        header("Location: ../view/login.php");

        break;
}
