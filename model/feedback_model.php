<?php

require_once("../common/dbConnection.php");

class Feedback
{
    private $conn;
    private $table = "feedbacks";

    public function __construct($conn)
    {
        $this->conn = $conn;
    }

    protected function setNewFeedback($content, $starCount, $customerId, $invoiceId)
    {
        $sql = "INSERT INTO $this->table(feedback_content, feedback_starcount, customer_customerId, invoice_invoiceId) " .
            "VALUES('$content', $starCount, $customerId, $invoiceId)";

        $result = $this->conn->query($sql);

        return $result;
    }

    protected function getFeedbacks_ByInvoiceId($invoiceId)
    {
        $sql = "SELECT * FROM $this->table WHERE invoice_invoiceId = $invoiceId";
        $result = $this->conn->query($sql);

        return $result;
    }

    protected function getFeedbacks_ByCustomerId($customerId)
    {
        $sql = "SELECT * FROM $this->table f INNER JOIN invoices inv ON f.invoice_invoiceId = inv.invoice_id " .
            "WHERE f.customer_customerId = $customerId";
        $result = $this->conn->query($sql) or die($this->conn->error);

        return $result;
    }

    /////////////////////////// Public Access //////////////////////
    public function giveFeedbacks_ByInvoiceId($invoiceId)
    {
        $result = $this->getFeedbacks_ByInvoiceId($invoiceId);

        return $result;
    }

    public function giveFeedbacks_ByCustomerId($customerId)
    {
        $result = $this->getFeedbacks_ByCustomerId($customerId);

        return $result;
    }
}
