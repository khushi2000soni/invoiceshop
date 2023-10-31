@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('title')@lang('quickadmin.order.create_new_order') @endsection
@section('customCss')
<meta name="csrf-token" content="{{ csrf_token() }}" >
<style>
    .buttonGroup{
        gap: 8px
    }
    .invoice hr {
    border-top-color: #ededed;
}
</style>

@endsection

@section('main-content')

<section class="section">
    <div class="section-header ">
      <h1>@lang('quickadmin.order.create_new_order') </h1>
      <div class="section-header-breadcrumb ">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">@lang('quickadmin.qa_dashboard')</a></div>
        <div class="breadcrumb-item"><a href="{{ route('orders.index') }}">@lang('quickadmin.order.list')</a></div>
        <div class="breadcrumb-item">@lang('quickadmin.order.new_order')</div>
      </div>
    </div>
    <div class="section-body">
        <form method="post" id="SaveInvoiceForm" action="{{route('orders.store')}}">
            <div class="invoice">
                <div class="invoice-print">
                <div class="row">
                    <div class="col-lg-12">
                        <h3>@lang('quickadmin.order.new_order')</h3>
                        <hr>
                        <div class="row">
                            @can('order_product_create')
                            <div class="col-md-12">
                                @include('admin.order.form')
                            </div>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-md">
                        <thead>
                            <tr>
                                <th data-width="40">@lang('quickadmin.qa_sn')</th>
                                <th class="text-center d-none">@lang('quickadmin.order.fields.product_id')</th>
                                <th class="text-center">@lang('quickadmin.order.fields.product_name')</th>
                                <th class="text-center">@lang('quickadmin.order.fields.quantity')</th>
                                <th class="text-center">@lang('quickadmin.order.fields.price')</th>
                                <th class="text-center">@lang('quickadmin.order.fields.sub_total')</th>
                                <th class="text-center">@lang('quickadmin.qa_action')</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <div class="custom-control custom-checkbox pt-4">
                                <input type="checkbox" class="custom-control-input" id="is_round_off">

                                <label class="custom-control-label" for="is_round_off">@lang('quickadmin.order.fields.round_off')</label>
                            </div>
                        </div>
                        <div class="col-lg-auto text-right">
                        <div class="invoice-detail-item mb-2">
                            <div class="d-flex align-items-center justify-content-between"><span class="invoice-detail-value">@lang('quickadmin.order.fields.thaila') : </span> <span class="px-2">
                            <input type="numeric" class="form-control form-control-sm col-md-3 float-right" id="thaila_price" name="thaila_price" value="0.00" min="0" step=".001">
                            </span></div>
                        </div>
                        <div class="invoice-detail-item mb-2">
                            <div class="d-flex align-items-center justify-content-between"><span class="invoice-detail-value">@lang('quickadmin.order.fields.sub_total_amount') : </span> <span class="px-2" id="sub_total_amount">0</span></div>
                        </div>
                        <div class="invoice-detail-item mb-2">
                            <div class="d-flex align-items-center justify-content-between"><span class="invoice-detail-value">@lang('quickadmin.order.fields.round_off') : </span> <span class="px-2" id="round_off_amount">0</span></div>
                        </div>
                        <hr class="mt-2 mb-2">
                        <div class="invoice-detail-item mb-2">
                            <div class="d-flex align-items-center justify-content-between"><span class="invoice-detail-value">@lang('quickadmin.order.fields.grand_total') : </span> <span class="px-2" id="grand_total_amount">0</span></div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div><hr>
                <div class="row mt-4">
                    <div class="text-md-right">
                        <div class="float-lg-left">
                            <button type="submit" class="btn btn-success btn-icon icon-left saveInvoicebtn" id="saveInvoicebtn"><i class="fas fa-credit-card"></i>@lang('quickadmin.qa_save_invoice')</button>
                            {{-- <button class="btn btn-light btn-icon icon-left"><i class="fas fa-print"></i>@lang('quickadmin.qa_print_invoice')</button> --}}
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </form>
    </div>
  </section>
@endsection

@section('customJS')
  @include('admin.order.partials.script')

  <script>

    var order = {
    products: [],
    thailaPrice: 0.00,
    is_round_off: 0,
    sub_total: 0.00,
    round_off_amount: 0,
    grand_total: 0.00
    };
    var rowIndex;

    $(document).ready(function() {
        localStorage.removeItem('order');
        order = JSON.parse(localStorage.getItem('order')) || {
        products: [],
        thailaPrice: 0.00,
        is_round_off: 0,
        sub_total: 0.00,
        round_off_amount: 0,
        grand_total: 0.00
        };


        // Calculate the subtotal
        order.sub_total = calculateSubtotal();
        // Update the subtotal in the UI
        $('#sub_total_amount').text(order.sub_total.toFixed(2));
        //$('#sub_total_amount').text(order.sub_total);


        calculateGrandTotal();

        $("#customer_id").change(function (e) {
        e.preventDefault();
        order.customer_id = parseInt($(this).val());
        });

        $("#product_id").change(function (e) {
            e.preventDefault();
            order.product_id = parseInt($(this).val());
            order.product_name = $(this).find("option:selected").text();
            $("#selectedProductName").text(order.product_name);
        });

        $("#is_round_off").change(function (e) {
            e.preventDefault();
            console.log('yes');
            order.is_round_off = this.checked ? 1 : 0;
            calculateGrandTotal();
        });

        // Event listener for the thaila_price input field change
        $("#thaila_price").on("input", function (e) {
            e.preventDefault();
            updateThailaPrice();
            calculateGrandTotal();
        });

        // Initialize the thailaPrice from local storage if available
        if (localStorage.getItem("order")) {
            order = JSON.parse(localStorage.getItem("order"));
            $("#thaila_price").val(order.thailaPrice || 0.00);
        }

        $(document).on('click','#addProductBtn', function(e){
            e.preventDefault();
            $(".error.text-danger").remove();
            $(".is-invalid").removeClass("is-invalid");
            var productRecord = {
                customer_id: order.customer_id,
                product_id: parseInt($("#product_id").val()),
                product_name: order.product_name,
                quantity: parseInt($("#quantity").val()),
                price: parseFloat($("#price").val()),
                total_price: parseFloat($("#total_price").val())
            };

            var errors = {
                customer_id: "The Customer Name is required.",
                product_id: "The Product Name is required.",
                quantity: "The Quantity is required.",
                price: "The Price is required.",
                total_price: "Please fill quantity or price."
            };

            var hasErrors = false;
            for (const elementId in productRecord) {
                if (!productRecord[elementId]) {
                    $("#" + elementId).addClass('is-invalid');
                    var errorHtml = '<div><span class="error text-danger">' + errors[elementId] + '</span></div>';
                    $(errorHtml).insertAfter($("#" + elementId).parent());
                    hasErrors = true;
                }
            }

            if (!hasErrors) {
                order.products.push(productRecord);
                order.sub_total = calculateSubtotal();
                $('#sub_total_amount').text(order.sub_total);
                updateLocalStorage();
                clearForm();
                displayOrder();
                calculateGrandTotal();
            }

            // console.log(order);
        });

        $(document).on('click', '.edit-product', function (e) {
            e.preventDefault();

            rowIndex = $(this).data('row-index');
            var productToEdit = order.products[rowIndex];

            $("#customer_id").val(productToEdit.customer_id);
            $("#product_id").val(productToEdit.product_id);
            var productToSelect = productToEdit.product_name;

            // Select the option in the #product_id <select> element based on product_name
            var productSelect = $("#product_id");
            productSelect.find("option").filter(function() {
                return $(this).text() === productToSelect;
            }).prop("selected", true);

            $("#quantity").val(productToEdit.quantity);
            $("#price").val(productToEdit.price);
            $("#total_price").val(productToEdit.total_price);

            $("#addProductBtn").replaceWith('<button id="editProductBtn" class="btn btn-info"><i class="fas fa-edit"></i></button>');
        });

        // Event handler for updating the product
        $(document).on('click', '#editProductBtn', function (e) {
            e.preventDefault();
            // Remove previous error messages and validation classes
            $(".error.text-danger").remove();
            $(".is-invalid").removeClass("is-invalid");

            var updatedProduct = {
                customer_id: parseInt($("#customer_id").val()),
                product_id: parseInt($("#product_id").val()),
                product_name: order.product_name,
                quantity: parseInt($("#quantity").val()),
                price: parseFloat($("#price").val()),
                total_price: parseFloat($("#total_price").val())
            };

            var errors = {
                customer_id: "The Customer Name is required.",
                product_id: "The Product Name is required.",
                quantity: "The Quantity is required.",
                price: "The Price is required.",
                total_price: "Please fill quantity or price."
            };
            console.log("updatproduct",updatedProduct);

            var hasErrors = false;
            for (const elementId in updatedProduct) {
                if (!updatedProduct[elementId]) {
                    $("#" + elementId).addClass('is-invalid');
                    var errorHtml = '<div><span class="error text-danger">' + errors[elementId] + '</span></div>';
                    $(errorHtml).insertAfter($("#" + elementId).parent());
                    hasErrors = true;
                }
            }

            if (!hasErrors) {
                // Retrieve the entire object from local storage
                order = JSON.parse(localStorage.getItem("order"));
                console.log("Order",order);
                // Update the product data in the array
                order.products[rowIndex] = updatedProduct;
                order.sub_total = calculateSubtotal();
                $('#sub_total_amount').text(order.sub_total.toFixed(2));
                // Update the table with the edited data
                updateLocalStorage();
                displayOrder();
                clearForm();
                calculateGrandTotal();
                $("#editProductBtn").replaceWith('<button id="addProductBtn" class="btn btn-success"><i class="fas fa-plus"></i></button>');
            }
            else{
                console.log('error',hasErrors);
            }


        });

        $(document).on('click', '.delete-product', function (e) {
            e.preventDefault();
            swal({
            title: "{{ trans('messages.deletetitle') }}",
            text: "{{ trans('messages.areYouSure') }}",
            icon: 'warning',
            buttons: {
            confirm: 'Yes, delete it',
            cancel: 'No, cancel',
            },
            dangerMode: true,
            }).then((willDelete) => {
                if (willDelete) {
                    // Get the row index from the data attribute
                    var rowIndex = $(this).data('row-index');
                    // Remove the row from the table
                    var rowToDelete = $(".table.table-striped.table-hover.table-md tbody tr").eq(rowIndex);
                    rowToDelete.remove();
                    // Remove the product from the order.products array
                    order.products.splice(rowIndex, 1);
                    order.sub_total = calculateSubtotal();
                    $('#sub_total_amount').text(order.sub_total.toFixed(2));
                    updateLocalStorage();
                    displayOrder();
                    calculateGrandTotal();
                }
            });

        });


        $(document).on('click', '.copy-product', function () {
        // Get the row index from the data attribute
            var rowIndex = $(this).data('row-index');
            // Find the product to copy based on the row index
            var productToCopy = order.products[rowIndex];
            // Find the product_id using the hidden field in the row
            var product_id = $('.product-id').eq(rowIndex).text();
            // Create the copied product
            var copiedProduct = {
                customer_id: productToCopy.customer_id,
                product_id: product_id,
                product_name: productToCopy.product_name,
                quantity: productToCopy.quantity,
                price: productToCopy.price,
                total_price: productToCopy.total_price
            };
            console.log("copiedproduct: "+copiedProduct);
            // Add the duplicated product to the order and update the table and local storage
            order.products.push(copiedProduct);
            order.sub_total = calculateSubtotal();
            $('#sub_total_amount').text(order.sub_total.toFixed(2));
            //$('#sub_total_amount').text(order.sub_total);
            updateLocalStorage();
            displayOrder();
            calculateGrandTotal();
        });

        $(document).on('submit', '#SaveInvoiceForm', function (e) {
            e.preventDefault();
            $("#SaveInvoiceForm button[type=submit]").prop('disabled',true);
            var formAction = $(this).attr('action');
            var orderData= JSON.stringify(localStorage.getItem('order'));
                if (typeof (Storage) !== 'undefined') {
                    // Create the invoiceData object
                    var invoiceData = {
                        customer_id: order.customer_id,
                        thaila_price: order.thailaPrice,
                        is_round_off: order.is_round_off,
                        round_off: order.round_off_amount,
                        sub_total: order.sub_total,
                        grand_total: order.grand_total,
                        products: order.products, // The products array as-is
                    };
                    if (navigator.onLine) {
                        // Send data to the server using AJAX
                        console.log("Sending data to the server");
                        $.ajax({
                            url: formAction,
                            type: 'POST',
                            data: invoiceData,
                            headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            },
                            success: function (response) {
                                console.log('Data stored in the database:', response);
                                // Remove data from localStorage after successful insertion
                                localStorage.removeItem('order');
                                var alertType = response['alert-type'];
                                var message = response['message'];
                                var title = "{{ trans('quickadmin.order.order') }}";
                                //showToaster(title,alertType,message);
                                //swal(title, message, alertType);

                                swal({
                                title: title,
                                text: message,
                                icon: alertType,
                                buttons: {
                                confirm: 'OK',
                                },
                                }).then((confirm) => {
                                if (confirm) {
                                    window.location.href = "{{ route('orders.index') }}";
                                }
                                });

                                $('#SaveInvoiceForm')[0].reset();
                                location.reload();
                                //DataaTable.ajax.reload();
                                $("#SaveInvoiceForm button[type=submit]").prop('disabled',false);
                                console.log('Data removed from localStorage.');
                            },
                            error: function (xhr) {
                                var errors= xhr.responseJSON.errors;
                                console.log(xhr.responseJSON);
                                swal("{{ trans('quickadmin.product.product') }}", 'Some mistake is there.', 'error');
                                // for (const elementId in errors) {
                                //     $("#"+elementId).addClass('is-invalid');
                                //     var errorHtml = '<div><span class="error text-danger">'+errors[elementId]+'</span></';
                                //     $(errorHtml).insertAfter($("#"+elementId).parent());
                                // }
                                // $("#AddForm button[type=submit]").prop('disabled',false);
                                var alertType = errors['alert-type'];
                                var message = errors['message'];
                                var title = "{{ trans('quickadmin.order.order') }}";
                                //showToaster(title,alertType,message);
                            }
                        });
                    }else {
                        // User is offline
                        alert("You have lost internet connection, Please connect with the internet to save your Temorary data");
                        $("#saveInvoicebtn").replaceWith('<button type="submit" class="btn btn-success btn-icon icon-left saveTempInvoiceDatabtn" id="saveTempInvoiceDatabtn"><i class="fas fa-credit-card"></i>@lang("quickadmin.qa_temp_save_invoice")</button>');

                    }
                } else {
                    alert('localStorage is not supported in this browser.');
                }

        });

        function updateThailaPrice() {
            var thailaPrice = parseFloat($("#thaila_price").val()) || 0.00;
            order.thailaPrice = thailaPrice;
            localStorage.setItem("order", JSON.stringify(order));
        }

        function calculateAmount() {
            var quantity = parseFloat($("#quantity").val()) || 0;
            var price = parseFloat($("#price").val()) || 0;
            var total_price = (quantity * price).toFixed(2);
            $("#total_price").val(total_price);
        }

        $("#quantity, #price").on("input", calculateAmount);

        function updateLocalStorage() {
            localStorage.setItem("order", JSON.stringify(order));
        }

        // Function to clear the form fields
        function clearForm() {
            $("#product_id, #quantity, #price, #total_price").val("");
            $(".is-invalid").removeClass("is-invalid");
            $(".error").remove();
        }

        function displayOrder() {
        // Get a reference to the table body where product rows will be added
            var tableBody = $(".table.table-striped.table-hover.table-md").find("tbody");
            // Clear existing rows
            tableBody.empty();
            if (order.products.length > 0) {
                var totalAmount = 0;

                for (var i = 0; i < order.products.length; i++) {
                    var product = order.products[i];
                    // var amount = product.quantity * product.price;
                    // totalAmount += amount;
                    var amount = (product.quantity * product.price).toFixed(2);
                    totalAmount += parseFloat(amount);

                    // Create a new row for each product
                    var rowHtml = '<tr>' +
                        '<td>' + (i + 1) + '</td>' +
                        '<td class="text-center d-none product-id">' + product.product_id + '</td>' +
                        '<td class="text-center product-name">' + product.product_name + '</td>' +
                        '<td class="text-center">' + product.quantity + '</td>' +
                        '<td class="text-center">' + product.price + '</td>' +
                        '<td class="text-center">' + amount + '</td>' +
                        '<td class="text-right">' +
                            '<div class="d-flex align-items-center buttonGroup justify-content-end">';
                            if (canCopy) {
                                rowHtml += '<button class="btn btn-dark btn-sm copy-product" title="@lang("quickadmin.qa_copy")" data-row-index="' + i + '"><i class="fas fa-copy"></i></button>';
                            }

                            if (canEdit) {
                                rowHtml += '<button class="btn btn-info btn-sm edit-product" title="@lang("quickadmin.qa_edit")" data-row-index="' + i + '"></a><i class="fas fa-edit"></i></button>';
                            }

                            if (canDelete) {
                                rowHtml += '<button class="btn btn-danger btn-sm delete-product" title="@lang("quickadmin.qa_delete")" data-row-index="' + i + '"><i class="fas fa-trash"></i></button>';
                            }
                            rowHtml += '</div></td></tr>';

                    // Append the row to the table
                    tableBody.append(rowHtml);
                }
            }
        }

        function calculateSubtotal() {
            let subtotal = 0;
            for (const product of order.products) {
                totalPrice=parseFloat(product.total_price);
                subtotal += totalPrice || 0;
            }
            return subtotal;
        }

        function calculateGrandTotal() {
            var subTotal = calculateSubtotal();
            var thailaPrice = parseFloat(order.thailaPrice);
            var isRoundOff = parseInt(order.is_round_off);

            if (isRoundOff) {
                // Calculate the Round Off amount
                var roundedSubtotal = Math.round(subTotal);
                // Update and display Round Off amount
                $("#round_off_amount").text(roundedSubtotal);
                order.round_off_amount = roundedSubtotal;
            } else {
                $("#round_off_amount").text("0");
                order.round_off_amount = 0;
            }
            console.log('thaila',thailaPrice);
            var grandTotal = thailaPrice + (isRoundOff ? roundedSubtotal : subTotal);

            // Update and display Sub Total and Grand Total on the page
            $("#sub_total_amount").text(isRoundOff ? subTotal.toFixed(2) : subTotal.toFixed(2));
            //$("#sub_total_amount").text(isRoundOff ? subTotal : subTotal);
            $("#grand_total_amount").text(isRoundOff ? grandTotal : grandTotal.toFixed(2));
            //$("#grand_total_amount").text(isRoundOff ? grandTotal : grandTotal);
            // Update the grand total in the order object
            order.grand_total = grandTotal;
            updateLocalStorage();
        }
        // Load and display the order from localStorage (if any)
        var storedOrder = JSON.parse(localStorage.getItem("order"));
        if (storedOrder && storedOrder.products) {
            order = storedOrder;
            displayOrder();
        }

        // Calculate the initial amount
        calculateAmount();
        calculateGrandTotal();



    });

  </script>

@endsection
