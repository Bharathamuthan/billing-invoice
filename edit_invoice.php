<?php
session_start();
include('header.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
if (!empty($_POST['receiverName']) && $_POST['receiverName'] && !empty($_POST['invoiceId']) && $_POST['invoiceId']) {
    $invoice->updateInvoice($_POST);
    header("Location:invoice_list.php");
}
if (!empty($_GET['update_id']) && $_GET['update_id']) {
    $invoiceValues = $invoice->getInvoice($_GET['update_id']);
    $invoiceItems = $invoice->getInvoiceItems($_GET['update_id']);
}
?>

<!-- Invoice-Edit head -->

<title>PCS Invoice-Edit</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php'); ?>
<div class="container content-invoice">
    <div class="cards">
        <div class="card-bodys">
            <form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate="">
                <div class="load-animate animated fadeInUp">
                    <div class="row">
                        <div class="col-xs-12">
                            <h1 class="title">PHP Invoice System</h1>
                            <?php include('menu.php'); ?>
                        </div>
                    </div>

                    <!-- Form -->

                    <input id="currency" type="hidden" value="$">
                    <div class="row">
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                            <h3>From,</h3>
                            <?php echo $_SESSION['user']; ?><br>
                            <?php echo $_SESSION['address']; ?><br>
                            <?php echo $_SESSION['mobile']; ?><br>
                            <?php echo $_SESSION['email']; ?><br>
                        </div>
                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">

                            <!-- To -->

                            <h3>To,</h3>
                            <div class="form-group">
                                <input value="<?php echo $invoiceValues['receiver_name']; ?>" type="text"
                                    class="form-control" name="receiverName" id="receiverName" placeholder="Your Name"
                                    autocomplete="off">
                            </div>
                            <div class="form-group">
                                <textarea class="form-control" rows="3" name="receiverAddress" id="receiverAddress"
                                    placeholder="Your Address"><?php echo
                                        $invoiceValues['receiver_address']; ?></textarea>
                            </div>
                            <div class="form-group">
                                <input value="<?php echo $invoiceValues['gst_no']; ?>" type="text" class="form-control"
                                    name="gstNo" id="gstNo" placeholder="GSTIN" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input value="<?php echo $invoiceValues['pan_no']; ?>" type="text" class="form-control"
                                    name="panNo" id="panNo" placeholder="PAN" autocomplete="off">
                            </div>
                            <div class="form-group">
                                <input value="<?php echo $invoiceValues['supply']; ?>" type="text" class="form-control"
                                    name="supply" id="supply" placeholder="Place of Supply" autocomplete="off">
                            </div>
                        </div>
                    </div>

                    <!-- Editing Invoice-input Table 1  -->

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <table class="table table-condensed table-striped" id="invoiceItem">
                                <tr>
                                    <th width="2%">
                                        <div class="custom-control custom-checkbox mb-3">
                                            <input type="checkbox" class="custom-control-input" id="checkAll"
                                                name="checkAll">
                                            <label class="custom-control-label" for="checkAll"></label>
                                        </div>
                                    </th>
                                    <th width="38%">Name of the Product / Service</th>
                                    <th width="15%">HSN / SAC</th>
                                    <th width="15%">Price</th>
                                    <th width="15%">Taxable Value</th>
                                </tr>
                                <?php
                                $count = 0;
                                foreach ($invoiceItems as $invoiceItem) {
                                    $count++;
                                    ?>
                                        <tr>
                                            <td>
                                                <div class="custom-control custom-checkbox">
                                                    <input type="checkbox" class="custom-control-input itemRow" id="itemRow">
                                                    <label class="custom-control-label" for="itemRow"></label>
                                                </div>
                                            </td>
                                            <td><input type="text" value="<?php echo $invoiceItem["name"]; ?>"
                                                    name="productName[]" id="productName_<?php echo $count; ?>"
                                                    class="form-control" autocomplete="off"></td>

                                            <td><input type="text" value="<?php echo $invoiceItem["hsn_sac"]; ?>"
                                                    name="productCode[]" id="productCode_<?php echo $count; ?>"
                                                    class="form-control" value="998314"></td>

                                            <td><input type="number" value="<?php echo $invoiceItem["price"]; ?>" name="price[]"
                                                    id="price_<?php echo $count; ?>" class="form-control price"
                                                    autocomplete="off"></td>

                                            <td><input type="number" value="<?php echo $invoiceItem["taxable_value"]; ?>"
                                                    name="taxableValue[]" id="taxableValue_<?php echo $count; ?>"
                                                    class="form-control taxableValue" autocomplete="off"></td>

                                            <input type="hidden" value="<?php echo $invoiceItem['id']; ?>">
                                        </tr>
                                <?php } ?>
                            </table>
                        </div>
                    </div>

                    <!-- Add Delete Button -->

                    <div class="row mt-3 mb-3">
                        <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
                            <button class="btn btn-danger delete" id="removeRows" type="button">- Delete</button>
                            <button class="btn btn-primary border-0" id="addRows" type="button">+ Add More</button>
                        </div>
                    </div>

                    <!-- Invoice-Edit Table 2-->
                    <!-- Rate -->

                    <div class="row">
                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group mt-3 mb-3">
                                <label>Rate: &nbsp;</label>
                                <div class="input-group">
                                    <div class="input-group-prepend currency">
                                        <span class="input-group-text currency">₹</span>
                                    </div>
                                    <input value="<?php echo $invoiceValues['rate']; ?>" type="number"
                                        class="form-control" name="rate" id="rate" placeholder="rate">
                                </div>
                            </div>
                        </div>


                        <!-- CGST Tax -->

                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>CGST(%): &nbsp;</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    <input value="<?php echo $invoiceValues['cgst_tax']; ?>" type="number"
                                        class="form-control" name="cgstTax" id="cgstTax" placeholder="CGST Tax">
                                </div>
                            </div>
                        </div>

                        <!-- CGST Amount -->

                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>CGST Amount: &nbsp;</label>
                                <div class="input-group">
                                    <div class="input-group-append currency"><span class="input-group-text">₹</span>
                                    </div>
                                    <input value="<?php echo $invoiceValues['cgst_amount']; ?>" type="number"
                                        class="form-control" name="cgstAmount" id="cgstAmount"
                                        placeholder="CGST Amount">
                                </div>
                            </div>
                        </div>

                        <!-- SGST Tax -->

                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>SGST(%): &nbsp;</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">%</span>
                                    </div>
                                    <input value="<?php echo $invoiceValues['sgst_tax']; ?>" type="number"
                                        class="form-control" name="sgstTax" id="sgstTax" placeholder="SGST Tax">
                                </div>
                            </div>
                        </div>

                        <!-- SGST Amount -->

                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>SGST Amount: &nbsp;</label>
                                <div class="input-group">
                                    <div class="input-group-append currency"><span class="input-group-text">₹</span>
                                    </div>
                                    <input value="<?php echo $invoiceValues['sgst_amount']; ?>" type="number"
                                        class="form-control" name="sgstAmount" id="sgstAmount"
                                        placeholder="SGST Amount">
                                </div>
                            </div>
                        </div>

                        <!-- Total -->

                        <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Total: &nbsp;</label>
                                <div class="input-group">
                                    <div class="input-group-append currency"><span class="input-group-text">₹</span>
                                    </div>
                                    <input value="<?php echo $invoiceValues['total']; ?>" type="number"
                                        class="form-control" name="total" id="total" placeholder="Total">
                                </div>
                            </div>
                        </div>

                        <!-- Service Charge -->

                        <!-- <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                            <div class="form-group">
                                <label>Service Charge: &nbsp;</label>
                                <div class="input-group">
                                    <div class="input-group-append currency"><span class="input-group-text">₹</span>
                                    </div>
                                    <input value="" type="number"
                                        class="form-control" name="serviceCharge" id="serviceCharge"
                                        placeholder="Service Charge">
                                </div>
                            </div>
                        </div> -->

                        <!-- Notes -->

                        <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                            <h3>Notes: </h3>
                            <div class="form-group">
                                <textarea class="form-control txt" rows="5" name="notes" id="notes"
                                    placeholder="Your Notes"><?php echo $invoiceValues['note']; ?></textarea>
                            </div>
                            <br>

                            <!-- Save -->
                            <div class="form-group">
                                <input type="hidden" value="<?php echo $_SESSION['userId']; ?>" class="form-control"
                                    name="userId">
                                <input type="hidden" value="<?php echo $invoiceValues['id']; ?>" class="form-control"
                                    name="invoiceId" id="invoiceId">
                                <input data-loading-text="Updating Invoice..." type="submit" name="invoice_btn"
                                    value="Save Invoice" class="btn btn-success submit_btn invoice-save-btm">
                            </div>

                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<?php include('footer.php'); ?>