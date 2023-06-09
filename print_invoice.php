<?php
ob_start();
session_start();
include 'Invoice.php';
$invoice = new Invoice();
$invoice->checkLoggedIn();
if (!empty($_GET['invoice_id']) && $_GET['invoice_id']) {

    $invoiceValues = $invoice->getInvoice($_GET['invoice_id']);
    $invoiceItems = $invoice->getInvoiceItems($_GET['invoice_id']);

    // var_dump($invoiceValues);

    // var_dump($invoiceItems); die;
}

// Print

$invoiceDate = date("d/M/Y", strtotime($invoiceValues['created_at']));
$invoiceMonth = date("M", strtotime($invoiceValues['created_at']));
// total tax

$totalTax = $invoiceValues["cgst_amount"] + $invoiceValues["sgst_amount"];
$output = '';

$output = '<style>
body{
    font-family: Arial, Helvetica, sans-serif;
}
table,th,td{
border:1px solid cornflowerblue;
border-collapse: collapse;
}
tr.border-bottom td{
    border-bottom: 1px solid white;
}
table {
    margin-right: 40px; 
    margin-left: 20px;
}
</style>
    <img src="img/PCS-Logo.png" width="130px" height="47px" style="padding-left: 20px"/>
      <h3 style="padding-left: 29px">PAVITHA CONSULTANCY SERVICES Pvt.ltd.</h3>
      <p style="font-size: 14px; padding-left: 29px;">P.M.Complex, 14-1-123/7, Sankarankovil road,<br>
      Sangeetha mobiles upstairs, Surandai-627859, Tenkasi(Dt).<br>
      contact@pcstech.in</p>
    ';

$output .= '
<table>

    <tr>
        <td colspan="12"><b style="font-size: 14px; float: left;">GSTIN :  33AALCP8510A1ZS</b><b style="font-size: 17px; color: cornflowerblue; padding-left: 105px;">INVOICE</b><b style="font-size: 15px; float: right;">ORIGINAL FOR RECIPIENT</b></td>
    </tr>
    <tr>
        <td colspan="5" style="font-size:13px;"><center><b>Customer Details</b></center></td>
        <td colspan="7" rowspan="2" style="font-size:13px;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Invoice Date - <b>' . $invoiceDate . '</b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Invoice No -<b>  23/24 0025' . $invoiceValues['id'] . '</b><br>
        </td>
    </tr>
    <tr>
    <td colspan="1" style="font-size:12px; border-right: 1px solid white;">
        &nbsp;Name <br><br><br>
        &nbsp;Address <br><br><br><br>
        &nbsp;GSTIN <br><br>
        &nbsp;PAN <br><br>
        &nbsp;Place of <br>&nbsp;Supply
    </td>
    <td colspan="4" style="font-size:12px; padding-bottom: 16px">
        <b>' . $invoiceValues['receiver_name'] . ' </b><br><br>
        <b>' . $invoiceValues['receiver_address'] . '</b><br><br>
        <b>' . $invoiceValues['gst_no'] . '</b><br><br>
        <b>' . $invoiceValues["pan_no"] . '</b><br><br>
        <b>' . $invoiceValues["supply"] . '</b><br>
    </td>
    </tr>
    
    <tr>
    <td colspan="12" height="15px"></td>
    </tr>

    <tr style= "font-size: 13px; background-color:rgba(100,149,237,0.2);">
        <td align="center" colspan="2" rowspan="2" width="50px"><b>S.no.</b></td>
        <td align="center" colspan="2" rowspan="2" width="60px"><b>Name of Product</b></td>
        <td align="center" colspan="2" rowspan="2" width="70px"><b>HSN / SAC</b></td>
        <td align="center" colspan="2" rowspan="2" width="70px"><b>Month</b></td>
        <td align="center" colspan="2" rowspan="2" width="60px"><b>Rate</b></td>
        <td align="center" colspan="2" rowspan="2" width="60px"><b>Taxable Value</b></td>
    </tr>
   
 <tr style= "font-size: 14px";>
 </tr>';
//  Table 1 output

$count = 0;
foreach ($invoiceItems as $invoiceItem) {
    $count++;
    $output .= '
    <tr style="font-size: 14px" class="border-bottom">
    <td align="center" colspan="2" style="padding-top:7px;">' . $count . '</td>
    <td align="center" colspan="2">' . $invoiceItem["name"] . '</td>
    <td align="center" colspan="2">' . $invoiceItem["hsn_sac"] . '</td>
    <td align="center" colspan="2">' . $invoiceMonth . '</td>
    <td align="center" colspan="2">' . $invoiceItem["price"] . '</td>
    <td align="center" colspan="2" style="background-color:#D6EEEE; border-bottom: 1px solid #D6EEEE">' . $invoiceItem["taxable_value"] . '</td>
 </tr>';
}

$output .= '
    <tr>
    <th colspan="12" height="15px"style="border-top:1.1px solid cornflowerblue"></th>
    </tr>
    
    <tr style="font-size: 14px;">
        <td align="center" colspan="2"><b>CGST(%)</b></td>
        <td align="center" colspan="2"><b>CGST Amount</b></td>
        <td align="center" colspan="2"><b>SGST(%)</b></td>
        <td align="center" colspan="2"><b>SGST Amount</b></td>
        <td align="center" colspan="2"><b>Total Tax Amount</b></td>
        <td align="center" colspan="2" style="background-color:#D6EEEE;"><b>Total</b></td>
    </tr>';
    
$output .= '   
    <tr style="font-size: 14px;">
        <td align="center" colspan="2"">' . $invoiceValues["cgst_tax"] . '</td>
        <td align="center" colspan="2">' . $invoiceValues["cgst_amount"] . '</td>
        <td align="center" colspan="2">' . $invoiceValues["sgst_tax"] . '</td>
        <td align="center" colspan="2">' . $invoiceValues["sgst_amount"] . '</td>
        <td align="center" colspan="2">' . $totalTax . '</td>
        <td align="center" colspan="2" style="background-color:#D6EEEE;">' . $invoiceValues["total"] . '</td>
    </tr>';

// taxable total

$taxableTotal = $invoiceValues['rate'];

// total after tax

$TotalAfterTax = $invoiceValues["total"];

// total in words

$one = array(
    "",
    "ONE ",
    "TWO ",
    "THREE ",
    "FOUR ",
    "FIVE ",
    "SIX ",
    "SEVEN ",
    "EIGHT ",
    "NINE ",
    "TEN ",
    "ELEVEN ",
    "TWELVE ",
    "THIRTEEN ",
    "FOURTEEN ",
    "FIFTEEN ",
    "SIXTEEN ",
    "SEVENTEEN ",
    "EIGHTEEN ",
    "NINETEEN "
);

$ten = array(
    "",
    "",
    "TWENTY ",
    "THIRTY ",
    "FORTY ",
    "FIFTY ",
    "SIXTY ",
    "SEVENTY ",
    "EIGHTY ",
    "NINETY "
);

function numToWords($n, $s)
{
    global $one, $ten;
    $str = "";

    if ($n > 19) {
        $str .= $ten[(int) ($n / 10)];
        $str .= $one[$n % 10];
    } else
        $str .= $one[$n];

    if ($n != 0)
        $str .= $s;

    return $str;
}

function convertToWords($n)
{
    $out = "";
    $out .= numToWords((int) ($n / 10000000), "CRORE ");
    $out .= numToWords(((int) ($n / 100000) % 100), "LAKH ");
    $out .= numToWords(((int) ($n / 1000) % 100), "THOUSAND ");
    $out .= numToWords(((int) ($n / 100) % 10), "HUNDRED ");

    if ($n > 100 && $n % 100)
        $out .= "AND ";

    $out .= numToWords(($n % 100), "");

    return $out;
}

// $n = $roundoffAmount;

$roundoffAmount= round($TotalAfterTax);

// table 2

$output .= '
<tr>
<th colspan="12" height="15px"></th>
</tr>
        <tr style="font-size: 14px;">
            <td colspan="6" style="height:10px"><center>Total in words</center></td>
            <td colspan="6" style="background-color:#D6EEEE">&nbsp;Taxable Amount<b style="float: right"> ' . $taxableTotal . '</b></td>
        </tr>

        <tr style="font-size: 14px;">
            <th colspan="6" rowspan="2" style="font-size: 13px;"><center><b>' . convertToWords($roundoffAmount) . "\n" . '</b></center></th>
            <td colspan="6">&nbsp;CGST<b style="float: right">' . $invoiceValues['cgst_amount'] . '</b></td>
        </tr>

        <tr style="font-size: 14px;">
            <td colspan="6">&nbsp;SGST<b style="float: right;">' . $invoiceValues['sgst_amount'] . '</b></td>
        </tr>
        
        <tr style="font-size: 14px;">
            <td colspan="6"><center>Bank Detail</center></td>
            <td colspan="6">&nbsp;Total Tax<b style="float: right">' . $totalTax . '</b></td>
        </tr>

        <tr style="font-size: 14px;">
        <td colspan="6" rowspan="4" style="font-size:13px;height:40px">&nbsp;Name<b style="margin-left:70px">PAVITHA CONSULTANCY<br></b><b style="margin-left:108px">SERVICES OPC pvt ltd.</b><br>
            &nbsp;Branch<b style="margin-left:63px">SURANDAI</b><br>
            &nbsp;Acc. Number<b style="margin-left:24px"> 17480200004021</b><br>
            &nbsp;IFSC<b style="margin-left:74px">FDRL0001748</b><br>
            &nbsp;Swift Code<b style="margin-left:40px">FDRLINBBIBD</b></td>
             <td colspan="6" style="background-color:#D6EEEE">&nbsp;Total Amount After Tax<b style="float: right">' . $TotalAfterTax . '</b></td>
         </tr>

        <tr style="font-size: 14px;">
        <td colspan="6" style="background-color:#D6EEEE">&nbsp;Round off Amount<b style="float: right">' . $roundoffAmount . '</b></td>
        </tr>

        <tr>
        <td colspan="6"><b style="float: right;font-size:14px:">(E & O.E.)</b></td>
        </tr>

        <tr style="font-size: 14px;">
            <td colspan="6" style="font-size:14px"><center>Certified that the particulars given above are true and correct.
                For <br><b>PAVITHA CONSULTANCY SERVICES</b></center></td>
        </tr>

        <tr style="font-size: 14px;">
            <td colspan="6"><center>Terms and Conditions</center></td>
            <td colspan="6" height="10px"></td>
        </tr>

        <tr style="font-size: 14px; padding-top: 35px;">
        <td colspan="6" align="center"><p>&nbsp;<b>Thanks for Doing Business with Us!</b></p>
        </td>
        <td colspan="6" style="padding-top: 55px; height: 35px">
            <p><center><b>Authorised Signatory</b></center></p>
        </td>
        </tr>';
$output .= '
    </td>
    </tr>
    </table>
    <b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;*System Generated Invoice*</b>';
   

// create pdf of invoice    

echo $output;

$invoiceFileName = 'Invoice-' . $invoiceValues['id'] . '.pdf';
if (headers_sent()) {
    die("Unable to stream pdf: headers already sent");
}
$output = ob_get_clean();
if (headers_sent()) {
    echo $output;
}

require_once 'dompdf/src/Autoloader.php';
Dompdf\Autoloader::register();
use Dompdf\Dompdf;

$dompdf = new Dompdf();
$dompdf->loadHtml(html_entity_decode($output));
$dompdf->setPaper('A4', 'portrait');
$dompdf->render();
$dompdf->stream($invoiceFileName, array("Attachment" => false));
?>
 

