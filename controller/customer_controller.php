<?php

session_start();

require_once("../model/customer_model.php");

class CustomerController extends Customer
{
    public function checkEmail_Existence($email)
    {
        $result = $this->getCustomer_ByEmail($email);

        if ($result->num_rows > 0) {
            $response = "yes";
        } else {
            $response = "no";
        }

        return $response;
    }

    public function checkNIC_Existence($nic)
    {
        $result = $this->getCustomer_ByNIC($nic);

        if ($result->num_rows > 0) {
            $response = "yes";
        } else {
            $response = "no";
        }

        return $response;
    }

    public function addNewCustomer($fname, $lname, $addr1, $addr2, $addr3, $postalId, $gender, $nic, $contact, $uimg)
    {
        $result = $this->setNewCustomer($fname, $lname, $addr1, $addr2, $addr3, $postalId, $gender, $nic, $contact, $uimg);
        return $result;
    }

    public function addNewLogin($email, $pw, $customerId)
    {
        $result = $this->setNewLogin($email, $pw, $customerId);
        return $result;
    }

    public function removeCustomer($customerId)
    {
        $result = $this->deleteCustomer($customerId);
        return $result;
    }

    public function updateCustomer($customerId, $fname, $lname, $addr1, $addr2, $addr3, $postalId, $gender, $nic, $contact, $uimg)
    {
        $result = $this->setExistCustomer($customerId, $fname, $lname, $addr1, $addr2, $addr3, $postalId, $gender, $nic, $contact, $uimg);

        if ($result) {
            $response = "Changes Applied";
            $status = "1";
        } else {
            $response = "Something Went Wrong. Task Fail";
            $status = "0";
        }

        header("Location: ../view/editCustomer.php?response=$response&res_status=$status");
    }

    public function changePassword($customerId, $new_pw, $curr_pw)
    {
        $getLogin_info = $this->getCustomer_ByCustomerID_FromLogin($customerId);
        $login_array = $getLogin_info->fetch_assoc();
        $curr_pass = $login_array["login_password"];

        if ($curr_pw == "") {
            $result = $this->setNewPassword($customerId, $new_pw);

            if ($result) {

                unset($_SESSION["resetkey"]);

                $getCusInfo = $this->getCustomer_ByCustomerID_FromCustomer($customerId);
                $cus_array = $getCusInfo->fetch_assoc();

                $customer = array(
                    "userId" => $customerId,
                    "userFname" => $cus_array["customer_fname"],
                    "userLname" => $cus_array["customer_lname"],
                    "userImage" => $cus_array["customer_img"],
                );

                $_SESSION["customer"] = $customer;

                $response = "Reset Password Successfully";
                $status = "1";
            } else {
                $response = "Something Went Wrong. Task Fail";
                $status = "0";
            }
        } else if ($curr_pass == $curr_pw) {
            $result = $this->setNewPassword($customerId, $new_pw);
            if ($result) {
                $response = "Change Password Successfully";
                $status = "1";
            } else {
                $response = "Something Went Wrong. Task Fail";
                $status = "0";
            }
        } else {
            $response = "Please Check Your Current Password";
            $status = "0";
        }

        header("Location: ../view/changePassword.php?response=$response&res_status=$status");
    }
}

$cusCont_obj = new CustomerController($conn);

/////////////////////////////// Switch Status ///////////////////////
$type = isset($_REQUEST["type"]) ? $_REQUEST["type"] : "";

switch ($type) {

    case 'checkEmail_Existence':

        $email = $_POST["email"];

        echo $cusCont_obj->checkEmail_Existence($email);

        break;

    case 'checkNic_Existence':

        $nic = $_POST["nic"];

        echo $cusCont_obj->checkNIC_Existence($nic);

        break;

    case 'addCustomer':

        $email = trim($_POST["email"]);
        $pw = trim($_POST["pw"]);
        $pw = sha1($pw);

        $fname = trim($_POST["fname"]);
        $lname = trim($_POST["lname"]);
        $nic = trim($_POST["nic"]);
        $gender = trim($_POST["gender"]);
        $contact = "0" . trim($_POST["contact"]);
        $addr1 = trim($_POST["addr1"]);
        $addr2 = trim($_POST["addr2"]);
        $addr3 = trim($_POST["addr3"]);
        $postalId = trim($_POST["postalcode"]);

        /// File Uploading ///
        if ($_FILES["uimg"]["name"] != "") {
            $uimg = $_FILES["uimg"]["name"];
            $uimg = time() . "_" . $uimg;
        } else {
            $uimg = ($gender == "M") ? "defaultImageM.jpg" : "defaultImageF.jpg";
        }

        $tmp_location = $_FILES["uimg"]["tmp_name"];
        $permanent = "../image/users/$uimg";

        move_uploaded_file($tmp_location, $permanent);

        $result = $cusCont_obj->addNewCustomer($fname, $lname, $addr1, $addr2, $addr3, $postalId, $gender, $nic, $contact, $uimg);

        if ($result) {
            $customerId = $result;
            $result_2 = $cusCont_obj->addNewLogin($email, $pw, $customerId);

            if ($result_2) {

                $customer = array(
                    "userId" => $customerId, "userFname" => $fname, "userLname" => $lname, "userImage" => $uimg
                );

                $_SESSION["customer"] = $customer;

                header("Location: ../view/dashboard.php");
            } else {
                $cusCont_obj->removeCustomer($customerId);
                $response = "Something went wrong. Task Fail";
                $status = "0";

                header("Location: ../view/registerForm.php?response=$response&res_status=$status&email=$email");
            }
        } else {
            $response = "Something went wrong. Task Fail";
            $status = "0";

            header("Location: ../view/registerForm.php?response=$response&res_status=$status&email=$email");
        }

        break;

    case 'editCustomer':

        $customerId = $_SESSION["customer"]["userId"];
        $fname = trim($_POST["fname"]);
        $lname = trim($_POST["lname"]);
        $nic = trim($_POST["nic"]);
        $gender = trim($_POST["gender"]);
        $contact = "0" . trim($_POST["contact"]);
        $addr1 = trim($_POST["addr1"]);
        $addr2 = trim($_POST["addr2"]);
        $addr3 = trim($_POST["addr3"]);
        $postalId = trim($_POST["postalcode"]);

        $uimg = $_SESSION["customer"]["userImage"];

        /// File Uploading ///
        if ($_FILES["uimg"]["name"] != "") {
            $uimg = $_FILES["uimg"]["name"];
            $uimg = time() . "_" . $uimg;

            $tmp_location = $_FILES["uimg"]["tmp_name"];
            $permanent = "../image/users/$uimg";

            move_uploaded_file($tmp_location, $permanent);

            if ($_SESSION["customer"]["userImage"] != "defaultImageM.jpg" && $_SESSION["customer"]["userImage"] != "defaultImageF.jpg") {
                unlink("../image/users/" . $_SESSION["customer"]["userImage"]);
            }

            $_SESSION["customer"]["userImage"] = $uimg;
        }

        $_SESSION["customer"]["userFname"] = $fname;
        $_SESSION["customer"]["userLname"] = $lname;

        $cusCont_obj->updateCustomer($customerId, $fname, $lname, $addr1, $addr2, $addr3, $postalId, $gender, $nic, $contact, $uimg);

        break;

    case 'changePW':

        $customerId = $_POST["customerId"];
        $curr_pw = (isset($_POST["pw"])) ? sha1($_POST["pw"]) : "";
        $new_pw = sha1($_POST["npw"]);

        $cusCont_obj->changePassword($customerId, $new_pw, $curr_pw);

        break;
}
