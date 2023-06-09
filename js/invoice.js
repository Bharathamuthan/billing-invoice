// Calculate All of

$(document).ready(function () {
    $(document).on('click', '#checkAll', function () {
        $(".itemRow").prop("checked", this.checked);
    });
    $(document).on('click', '.itemRow', function () {
        if ($('.itemRow:checked').length == $('.itemRow').length) {
            $('#checkAll').prop('checked', true);
        } else {
            $('#checkAll').prop('checked', false);
        }
    });

    // Add Rows

    var count = $(".itemRow").length;
    $(document).on('click', '#addRows', function () {
        count++;
        var htmlRows = '';
        htmlRows += '<tr>';
        htmlRows += '<td><div class="custom-control custom-checkbox"> <input type="checkbox" class="custom-control-input itemRow" id="itemRow_' + count + '"> <label class="custom-control-label" for="itemRow_' + count + '"></label> </div></td>';
        htmlRows += '<td><input type="text" name="productName[]" id="productName_' + count + '" class="form-control" autocomplete="off"></td>';
        htmlRows += '<td><input type="text" name="productCode[]" id="productCode_' + count + '" class="form-control" value="998314"></td>';
        htmlRows += '<td><input type="number" name="price[]" id="price_' + count + '" class="form-control price" autocomplete="off"></td>';
        htmlRows += '<td><input type="number" name="taxableValue[]" id="taxableValue_' + count + '" class="form-control taxableValue" autocomplete="off"></td>';
        htmlRows += '</tr>';
        $('#invoiceItem').append(htmlRows);
    });

    // Remove Rows

    $(document).on('click', '#removeRows', function () {
        $(".itemRow:checked").each(function () {
            $(this).closest('tr').remove();
        });
        $('#checkAll').prop('checked', false);
        calculateTotal();
    });

 // value print

    $(document).on('blur', "[id^=price_]", function () {
        calculateTotal();
    });
    $(document).on('blur', "#cgstTax", function () {
        calculateTotal();
    });
    $(document).on('blur', "#sgstTax", function () {
        calculateTotal();
    });
    $(document).on('blur', "#cgstAmount", function () {
        calculateTotal();
    });
    $(document).on('blur', "#sgstAmount", function () {
        calculateTotal();
    });
    $(document).on('blur', "#taxableValue", function () {
        calculateTotal();
    });

    // Delete  

    $(document).on('click', '.deleteInvoice', function () {
        var id = $(this).attr("id");
        if (confirm("Are you sure you want to remove this?")) {
            $.ajax({
                url: "action.php",
                method: "POST",
                dataType: "json",
                data: { id: id, action: 'delete_invoice' },
                success: function (response) {
                    if (response.status == 1) {
                        $('#' + id).closest("tr").remove();
                    }
                }
            });
        } else {
            return false;
        }
    });
});

// Price Calculation

function calculateTotal() {
    var value = 0;
    $("[id^='price_']").each(function () {
        var id = $(this).attr('id');
        id = id.replace("price_", '');
        var price = $('#price_' + id).val();
        var quantity = $('#quantity_' + id).val();
        if (!quantity) {
            quantity = 1;
        }
        var taxableValue = price * quantity;
        $('#taxableValue_' + id).val(parseFloat(taxableValue));
        value += taxableValue;
    });

    // Tax Calculation

    $('#rate').val(parseFloat(value));
    var cgstTax = $("#cgstTax").val();
    var sgstTax = $("#sgstTax").val();
    var rate = $('#rate').val();
    if (rate) {
        var cgstAmount = rate * cgstTax / 100;
        $('#cgstAmount').val(cgstAmount);
        var sgstAmount = rate * sgstTax / 100;
        $('#sgstAmount').val(sgstAmount);
        rate = parseFloat(rate) + parseFloat(cgstAmount) + parseFloat(sgstAmount);
        $('#total').val(rate);
    } 

    var totalAmount = 0; 
	$("[id^='rate_']").each(function() {
		var id = $(this).attr('id');
		id = id.replace("rate_",'');
		var rate = $('#rate_'+id).val();
		if(!taxableTotal) {
            $('#taxabletotal_'+id).val(parseFloat(taxabletotal));
		totalAmount += taxableValue;
		}			
	});
        }

        
