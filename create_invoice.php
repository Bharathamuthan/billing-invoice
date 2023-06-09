<?php
session_start();
include('header.php');
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
if (!empty($_POST['receiverName']) && $_POST['receiverName']) {
   $invoice->saveInvoice($_POST);
   header("Location:invoice_list.php");
}
?>

<!-- Invoice-Create head -->

<title>PCS Invoice-Create</title>
<script src="js/invoice.js"></script>
<link href="css/style.css" rel="stylesheet">
<?php include('container.php'); ?>
<div class="container content-invoice">
   <div class="cards">
      <div class="card-bodys">
         <form action="" id="invoice-form" method="post" class="invoice-form" role="form" novalidate="">
            <div class="load-animate animated fadeInUp">
               <div class="row">
                  <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                     <h2 class="title">PCS Billing Invoice</h2>
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

                  <!-- To -->

                  <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                     <h3>To,</h3>
                     <div class="form-group">
                        <input type="text" class="form-control" name="receiverName" id="receiverName"
                           placeholder="Your Name" autocomplete="off">
                     </div>
                     <div class="form-group">
                        <textarea class="form-control" rows="3" name="receiverAddress" id="receiverAddress"
                           placeholder="Your Address"></textarea>
                     </div>
                     <div class="form-group">
                        <input type="text" class="form-control" name="gstNo" id="gstNo" placeholder=" GSTIN"
                           autocomplete="off">
                     </div>
                     <div class="form-group">
                        <input type="text" class="form-control" name="panNo" id="panNo" placeholder="PAN"
                           autocomplete="off">
                     </div>
                     <div class="form-group">
                        <input type="text" class="form-control" name="supply" id="supply" placeholder="Place of Supply"
                           autocomplete="off">
                     </div>
                  </div>
               </div>

               <!-- Invoice-Create input total 1 -->

               <div class="row">
                  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                     <table class="table table-condensed table-striped" id="invoiceItem">
                        <tr>
                           <th width="2%">
                              <div class="custom-control custom-checkbox mb-3">
                                 <input type="checkbox" class="custom-control-input" id="checkAll" name="checkAll">
                                 <label class="custom-control-label" for="checkAll"></label>
                              </div>
                           </th>
                           <th width="38%">Name of the Product / Service</th>
                           <th width="15%">HSN / SAC</th>
                           <th width="15%">Price</th>
                           <th width="15%">Taxable Value</th>
                        </tr>
                        <tr>
                           <td>
                              <div class="custom-control custom-checkbox">
                                 <input type="checkbox" class="itemRow custom-control-input" id="itemRow_1">
                                 <label class="custom-control-label" for="itemRow_1"></label>
                              </div>
                           </td>
                           <td><input type="text" name="productName[]" id="productName_1" class="form-control"
                                 autocomplete="off"></td>
                           <td><input type="text" name="productCode[]" id="productCode_1" class="form-control"
                           value="998314"></td>
                           <td><input type="number" name="price[]" id="price_1" class="form-control price"
                                 autocomplete="off"></td>
                           <td><input type="number" name="taxableValue[]" id="taxableValue_1"
                                 class="form-control taxableValue" autocomplete="off"></td>
                        </tr>
                     </table>
                  </div>
               </div>

               <!-- ADD Delete Button-->

               <div class="row">
                  <div class="col-xs-12">
                     <button class="btn btn-danger delete" id="removeRows" type="button">- Delete</button>
                     <button class="btn btn-success" id="addRows" type="button">+ Add More</button>
                  </div>
               </div>

               <!-- Invoice-Create total 2 -->
               <!-- Rate -->

               <div class="row">
                  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                     <div class="form-group mt-3 mb-3 ">
                        <label>Rate: &nbsp;</label>
                        <div class="input-group mb-3">
                           <div class="input-group-prepend">
                              <span class="input-group-text currency">₹</span>
                           </div>
                           <input value="" type="number" class="form-control" name="rate" id="rate" placeholder="Rate">
                        </div>
                     </div>
                  </div>

                  <!-- CGST Tax -->

                  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                     <div class="form-group mt-3 mb-3 ">
                        <label>CGST(%): &nbsp;</label>
                        <div class="input-group mb-3">
                           <div class="input-group-prepend">
                              <span class="input-group-text currency">%</span>
                           </div>
                           <input value="" type="number" class="form-control" name="cgstTax" id="cgstTax"
                              placeholder="CGST Tax">
                        </div>
                     </div>
                  </div>

                  <!-- CGST Amount -->

                  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                     <div class="form-group mt-3 mb-3 ">
                        <label>CGST Amount: &nbsp;</label>
                        <div class="input-group mb-3">
                           <div class="input-group-prepend">
                              <span class="input-group-text currency">₹</span>
                           </div>
                           <input value="" type="number" class="form-control" name="cgstAmount" id="cgstAmount"
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
                           <input value="" type="number" class="form-control" name="sgstTax" id="sgstTax"
                              placeholder="SGST Tax">
                        </div>
                     </div>
                  </div>

                  <!-- SGST Amount -->

                  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                     <div class="form-group">
                        <label>SGST Amount: &nbsp;</label>
                        <div class="input-group">
                           <div class="input-group-append currency"><span class="input-group-text">₹</span></div>
                           <input value="" type="number" class="form-control" name="sgstAmount" id="sgstAmount"
                              placeholder="SGST Amount">
                        </div>
                     </div>
                  </div>

                  <!-- Total -->

                  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                     <div class="form-group mt-3 mb-3 ">
                        <label>Total: &nbsp;</label>
                        <div class="input-group mb-3">
                           <div class="input-group-prepend">
                              <span class="input-group-text currency">₹</span>
                           </div>
                           <input value="" type="number" class="form-control" name="total" id="total"
                              placeholder="Total">
                        </div>
                     </div>
                  </div>

                  <!-- Service Charge -->
<!-- 
                  <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                     <div class="form-group mt-3 mb-3 ">
                        <label>Service Charge: &nbsp;</label>
                        <div class="input-group mb-3">
                           <div class="input-group-prepend">
                              <span class="input-group-text currency">₹</span>
                           </div>
                           <input value="" type="number" class="form-control" name="serviceCharge" id="serviceCharge"
                              placeholder="Service Charge">
                        </div>
                     </div>
                  </div> -->

                  <!-- Notes -->

                  <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                     <h3>Notes: </h3>
                     <div class="form-group">
                        <textarea class="form-control txt" rows="5" name="notes" id="notes"
                           placeholder="Your Notes"></textarea>
                     </div>
                     <br>

                     <!-- Save -->

                     <div class="form-group">
                        <input type="hidden" value="<?php echo $_SESSION['userId']; ?>" class="form-control"
                           name="userId">
                        <input data-loading-text="Saving Invoice..." type="submit" name="invoice_btn"
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