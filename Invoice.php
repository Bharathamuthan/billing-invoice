<!-- Localhost Open -->

<?php
class Invoice
{
	private $host = 'localhost';
	private $user = 'root';
	private $password = "";
	private $database = "pcs_invoice";
	private $invoiceUserTable = 'invoice_user';
	private $invoiceOrderTable = 'invoice_order';
	private $invoiceOrderItemTable = 'invoice_order_item';
	private $dbConnect = false;

	// DBConnect
	public function __construct()
	{
		if (!$this->dbConnect) {
			$conn = new mysqli($this->host, $this->user, $this->password, $this->database);
			if ($conn->connect_error) {
				die("Error failed to connect to MySQL: " . $conn->connect_error);
			} else {
				$this->dbConnect = $conn;
			}
		}
	}
	private function getData($sqlQuery)
	{
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if (!$result) {
			die('Error in query: ' . mysqli_error());
		}
		$data = array();
		while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			$data[] = $row;
		}
		return $data;
	}
	private function getNumRows($sqlQuery)
	{
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		if (!$result) {
			die('Error in query: ' . mysqli_error());
		}
		$numRows = mysqli_num_rows($result);
		return $numRows;
	}

	// User login

	public function loginUsers($email, $password)
	{
		$sqlQuery = "
            SELECT id, email, first_name, last_name, address, mobile 
            FROM " . $this->invoiceUserTable . " 
            WHERE email='" . $email . "' AND password='" . $password . "'";
		return $this->getData($sqlQuery);
	}

	// After Loggedin

	public function checkLoggedIn()
	{
		if (!$_SESSION['userId']) {
			header("Location:index.php");
		}
	}

	// Create and Save 

	public function saveInvoice($POST)
	{

		$sqlInsert = "INSERT INTO " . $this->invoiceOrderTable . "(user_id, receiver_name, receiver_address, gst_no, pan_no, supply, rate, cgst_tax, cgst_amount, sgst_tax, sgst_amount, total, service_charge, note) VALUES ('" . $POST['userId'] . "', '" . $POST['receiverName'] . "', '" . $POST['receiverAddress'] . "', '" . $POST['gstNo'] . "','" . $POST['panNo'] . "','" . $POST['supply'] . "','" . $POST['rate'] . "', '" . $POST['cgstTax'] . "', '" . $POST['cgstAmount'] . "', '" . $POST['sgstTax'] . "', '" . $POST['sgstAmount'] . "', '" . $POST['total'] . "', '" . $POST['serviceCharge'] . "', '" . $POST['notes'] . "')";
		// var_dump($sqlInsert); die;
		mysqli_query($this->dbConnect, $sqlInsert);
		$lastInsertId = mysqli_insert_id($this->dbConnect);
		for ($i = 0; $i < count($POST['productCode']); $i++) {
			$sqlInsertItem = "INSERT INTO " . $this->invoiceOrderItemTable . "(order_id, hsn_sac, name, price, taxable_value) VALUES ('" . $lastInsertId . "', '" . $POST['productCode'][$i] . "', '" . $POST['productName'][$i] . "', '" . $POST['price'][$i] . "', '" . $POST['taxableValue'][$i] . "')";
			mysqli_query($this->dbConnect, $sqlInsertItem);
		}
	}

	// Edit and Update(Save)

	public function updateInvoice($POST)
	{
		if ($POST['invoiceId']) {
			$sqlInsert = "UPDATE " . $this->invoiceOrderTable . " 
                SET `receiver_name` = '" . $POST['receiverName'] . "', `receiver_address`= '" . $POST['receiverAddress'] . "', `gst_no` = '" . $POST['gstNo'] . "', `pan_no` = '" . $POST['panNo'] . "', `supply` = '" . $POST['supply'] . "', `rate` = '" . $POST['rate'] . "', `cgst_tax` = '" . $POST['cgstTax'] . "', `cgst_amount` = '" . $POST['cgstAmount'] . "', `sgst_tax` = '" . $POST['sgstTax'] . "', `sgst_amount` = '" . $POST['sgstAmount'] . "', `total` = '" . $POST['total'] . "', `service_charge` = '" . $POST['serviceCharge'] . "', `note` = '" . $POST['notes'] . "' 
                WHERE user_id = '" . $POST['userId'] . "' AND id = '" . $POST['invoiceId'] . "'";
			// echo $sqlInsert; die;
			mysqli_query($this->dbConnect, $sqlInsert);
		}
		$this->deleteInvoiceItems($POST['invoiceId']);
		for ($i = 0; $i < count($POST['productCode']); $i++) {
			$sqlInsertItem = "INSERT INTO " . $this->invoiceOrderItemTable . "(order_id, hsn_sac, name, price, taxable_value) 
                VALUES ('" . $POST['invoiceId'] . "', '" . $POST['productCode'][$i] . "', '" . $POST['productName'][$i] . "', '" . $POST['price'][$i] . "', '" . $POST['taxableValue'][$i] . "')";
			mysqli_query($this->dbConnect, $sqlInsertItem);
		}
	}
	public function getInvoiceList()
	{
		$sqlQuery = "SELECT * FROM " . $this->invoiceOrderTable . " 
            WHERE user_id = '" . $_SESSION['userId'] . "'";
		return $this->getData($sqlQuery);
	}
	public function getInvoice($invoiceId)
	{
		$sqlQuery = "SELECT * FROM " . $this->invoiceOrderTable . " 
            WHERE user_id = '" . $_SESSION['userId'] . "' AND id = '$invoiceId'";
		$result = mysqli_query($this->dbConnect, $sqlQuery);
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		return $row;
	}
	public function getInvoiceItems($invoiceId)
	{
		$sqlQuery = "SELECT * FROM " . $this->invoiceOrderItemTable . " 
            WHERE order_id = '$invoiceId'";
		return $this->getData($sqlQuery);
	}
	public function deleteInvoiceItems($invoiceId)
	{
		$sqlQuery = "DELETE FROM " . $this->invoiceOrderItemTable . " 
            WHERE order_id = '" . $invoiceId . "'";
		mysqli_query($this->dbConnect, $sqlQuery);
	}
	public function deleteInvoice($invoiceId)
	{
		$sqlQuery = "DELETE FROM " . $this->invoiceOrderTable . " 
            WHERE id = '" . $invoiceId . "'";
		mysqli_query($this->dbConnect, $sqlQuery);
		$this->deleteInvoiceItems($invoiceId);
		return 1;
	}
}
?>