<?php
session_start();
include('header.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
?>

<!-- Invoice-Table-Page -->

<title>PCS Invoice</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php'); ?>
<div class="container">
  <h2 class="title mt-5">PCS Billing Invoice</h2>
  <?php include('menu.php'); ?>
  <table id="data-table" class="table table-condensed table-striped">
    <thead>
      <tr>
        <th>Invoice No.</th>
        <th>Create Date</th>
        <th>Customer Name</th>
        <th>Total</th>
        <th>Print</th>
        <th>Edit</th>
        <th>Delete</th>
      </tr>
    </thead>
    <?php
    $invoiceList = $invoice->getInvoiceList();
    foreach ($invoiceList as $invoiceDetails) {
      $invoiceDate = date("d/M/Y, H:i:s", strtotime($invoiceDetails["created_at"]));
      echo '
              <tr>
                <td>' . $invoiceDetails["id"] . '</td>
                <td>' . $invoiceDate . '</td>
                <td>' . $invoiceDetails["receiver_name"] . '</td>
                <td>' . $invoiceDetails["total"] . '</td>
                <td><a href="print_invoice.php?invoice_id=' . $invoiceDetails["id"] . '" title="Print Invoice"><i class="fas fa-print"></i></a></td>
                <td><a href="edit_invoice.php?update_id=' . $invoiceDetails["id"] . '"  title="Edit Invoice"><i class="fas fa-edit"></i></a></td>
                <td><a href="#" id="' . $invoiceDetails["id"] . '" class="deleteInvoice"  title="Delete Invoice"><i class="fas fa-trash"></i></a></td>
              </tr>
            ';
    }
    ?>
  </table>
</div>
<?php include('footer.php'); ?>