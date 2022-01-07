<?php

require_once("../common/dbConnection.php");

class Customer
{
    private $conn;
    private $table = "customers";
    private $table_login = "customer_login";

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    protected function getCustomer_ByEmail($email)
    {
        $sql = "SELECT * FROM $this->table_login WHERE login_email = '$email'";
        $result = $this->conn->query($sql);

        return $result;
    }

    protected function getCustomer_ByNIC($nic)
    {
        $sql = "SELECT * FROM $this->table WHERE customer_nic = '$nic'";
        $result = $this->conn->query($sql);

        return $result;
    }

    protected function getCustomer_ByCustomerID_FromCustomer($customerId)
    {
        $sql = "SELECT * FROM $this->table WHERE customer_id = $customerId";
        $result = $this->conn->query($sql);

        return $result;
    }

    protected function getCustomer_ByCustomerID_FromLogin($customerId)
    {
        $sql = "SELECT * FROM $this->table_login WHERE customer_customerId = $customerId";
        $result = $this->conn->query($sql);

        return $result;
    }

    protected function setNewCustomer($fname, $lname, $addr1, $addr2, $addr3, $postalId, $gender, $nic, $contact, $uimg)
    {
        $sql = "INSERT INTO $this->table(customer_fname, customer_lname, customer_addr1, customer_addr2, customer_addr3, customer_postal_id, customer_gender, customer_nic, customer_cno, customer_img) " .
            "VALUES('$fname','$lname','$addr1','$addr2','$addr3',$postalId, '$gender', '$nic', '$contact', '$uimg')";
        $this->conn->query($sql);
        $customerId = $this->conn->insert_id;
        return $customerId;
    }

    protected function setNewLogin($email, $pw, $customerId)
    {
        $sql = "INSERT INTO $this->table_login(login_email, login_password, customer_customerId) " .
            "VALUES('$email', '$pw', $customerId)";
        $result = $this->conn->query($sql);

        return $result;
    }

    protected function deleteCustomer($customerId)
    {
        $sql = "DELETE FROM $this->table WHERE customer_id = $customerId";
        $result = $this->conn->query($sql);

        return $result;
    }

    protected function setExistCustomer($customerId, $fname, $lname, $addr1, $addr2, $addr3, $postalId, $gender, $nic, $contact, $uimg)
    {
        $sql = "UPDATE $this->table SET customer_fname = '$fname', customer_lname = '$lname', customer_addr1 = '$addr1', customer_addr2 = '$addr2', customer_addr3 = '$addr3', customer_postal_id = '$postalId', customer_gender = '$gender', customer_nic = '$nic', customer_cno = '$contact', customer_img = '$uimg' " .
            "WHERE customer_id = $customerId";
        $result = $this->conn->query($sql);

        return $result;
    }

    protected function setNewPassword($customerId, $new_pw)
    {
        $sql = "UPDATE $this->table_login SET login_password = '$new_pw' WHERE customer_customerId = $customerId";
        $result = $this->conn->query($sql);

        return $result;
    }

    ///////////////////////////// Public Accesses /////////////////////////////
    public function giveCustomer_ByCustomerID_FromCustomer($customerId)
    {
        $result = $this->getCustomer_ByCustomerID_FromCustomer($customerId);

        return $result;
    }

    public function giveCustomer_ByCustomerID_FromLogin($customerId)
    {
        $result = $this->getCustomer_ByCustomerID_FromLogin($customerId);

        return $result;
    }
}
