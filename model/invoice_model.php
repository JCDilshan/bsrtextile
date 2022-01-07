<?php

require_once("../common/dbConnection.php");

class Invoice
{
    private $conn;
    private $table = "invoices";

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    protected function getInvoices_ByInvoiceId($invoiceId)
    {
        $sql = "SELECT * FROM $this->table WHERE invoice_id = $invoiceId";
        $result = $this->conn->query($sql);

        return $result;
    }

    protected function getInvoiceCount_ByDate()
    {
        $sql = "SELECT count(invoice_id) as inv_count FROM $this->table WHERE DATE(invoice_time) = DATE(CURRENT_TIMESTAMP)";
        $result = $this->conn->query($sql);

        return $result;
    }

    protected function setNewInvoice($invNum, $invTotal, $payAmt, $customerId)
    {
        $sql = "INSERT INTO $this->table(
            invoice_number, 
            invoice_total, 
            invoice_net_total, 
            customer_customerId) VALUES('$invNum', $invTotal, $payAmt, $customerId)";

        $this->conn->query($sql);
        $result = $this->conn->insert_id;

        return $result;
    }

    /////////////////////////// Public Access //////////////////////
    public function giveInvoices_ByInvoiceId($invoiceId)
    {
        $result = $this->getInvoices_ByInvoiceId($invoiceId);

        return $result;
    }

    public function giveInvoiceCount_ByDate()
    {
        $result = $this->getInvoiceCount_ByDate();
        return $result;
    }

    public function createNewInvoice($invNum, $invTotal, $payAmt, $customerId)
    {
        $result = $this->setNewInvoice($invNum, $invTotal, $payAmt, $customerId);

        return $result;
    }
}
