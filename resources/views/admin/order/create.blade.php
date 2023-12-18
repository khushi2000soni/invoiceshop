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
        .custom-select2 select{
			width: 200px;
            z-index: 1;
            position: relative;
		}
		.custom-select2 .form-control-inner{
			position: relative;
		}
		.custom-select2 .form-control-inner label{
			position: absolute;
			left: 10px;
			top: -8px;
			background-color: #fff;
			padding: 0 5px;
			z-index: 1;
			font-size: 12px;
		}
		.select2-results{
			padding-top: 48px;
			position: relative;
		}
		.select2-link2{
			position: absolute;
			top: 6px;
			left: 5px;
			width: 100%;
		}
		.select2-container--default .select2-selection--single,
		.select2-container--default .select2-selection--single .select2-selection__arrow{
			height: 40px;
		}
		.select2-container--default .select2-selection--single .select2-selection__rendered{
			line-height: 41px;
		}
		.select2-search--dropdown .select2-search__field{
			padding: 10px;
			font-size: 15px;
		}
		.select2-search--dropdown .select2-search__field:focus{
			outline: none;
		}
		.select2-link2 .btns {
			color: #3584a5;
			background-color: transparent;
			border: none;
			font-size: 14px;
			padding: 7px 15px;
			cursor: pointer;
			border: 1px solid #3584a5;
			border-radius: 60px;
		}
        #centerModal{
            z-index: 99999;
        }
        #centerModal::before{
            display: none;
        }
        .modal-open .modal-backdrop.show{
            display: block !important;
            z-index: 9999;
        }
</style>

@endsection

@section('main-content')

<section class="section">
    <div class="section-body">
        <form method="post" id="SaveInvoiceForm" action="{{route('orders.store')}}">
            <div class="invoice">
                <div class="invoice-print">
                <div class="row">
                    @can('order_product_create')
                    <div class="col-md-12">
                        @include('admin.order.form')
                    </div>
                    @endcan
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table tablestriped tablehover ordertable">
                            <thead>
                                <tr>
                                    <th data-width="40">@lang('quickadmin.qa_action')</th>
                                    <th class="text-center d-none">@lang('quickadmin.order.fields.product_id')</th>
                                    <th class="text-center">@lang('quickadmin.order.fields.product_name')</th>
                                    <th class="text-center">@lang('quickadmin.order.fields.quantity')</th>
                                    <th class="text-center">@lang('quickadmin.order.fields.price')</th>
                                    <th class="text-center">@lang('quickadmin.order.fields.sub_total')</th>
                                    <th class="text-center">
                                        <div class="form-group m-0">
                                        <div class="input-group">
                                            <button type="button" class="btn btn-success" id="addNewBlankRow"><i class="fas fa-plus"></i></button>
                                        </div>
                                    </div>
                                </th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr class="template-row">
                                    <td class="text-right">
                                        <div class="d-flex align-items-center buttonGroup justify-content-end">
                                            <button class="btn btn-dark btn-sm copy-product"><i class="fas fa-copy"></i></button>
                                            <button class="btn btn-danger btn-sm delete-product"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-0">
                                            <div class="custom-select2 fullselect2">
                                                <div class="form-control-inner">
                                                    <select class="js-product-basic-single @error('product_id') is-invalid @enderror" name="product_id" id="product_id">
                                                        <option value="">{{ trans('quickadmin.order.fields.select_product') }}</option>
                                                        @foreach($products as $product)
                                                        <option value="{{ $product->id }}">{{ $product->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-0">
                                            <input type="text" class="form-control" min="0" name="quantity" value="{{ isset($order) ? $order->quantity : old('quantity') }}" id="quantity" autocomplete="true" onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'">
                                        </div>
                                    </td>
                                    <td>
                                        <div class="form-group m-0">
                                            <input type="text" class="form-control" min="0" name="price" value="{{ isset($order) ? $order->price : old('price') }}" id="price" autocomplete="true" onkeydown="javascript: return ['Backspace','Delete','ArrowLeft','ArrowRight'].includes(event.code) ? true : !isNaN(Number(event.key)) && event.code!=='Space'">
                                        </div>
                                    </td>
                                    <td colspan="2">
                                        <div class="form-group m-0">
                                            <input type="numeric" class="form-control" name="total_price" value="{{ isset($order) ? $order->total_price : old('total_price') }}" id="total_price" autocomplete="true" readonly>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col">
                            <div class="custom-control custom-checkbox pt-4">
                                <input type="checkbox" class="custom-control-input" id="is_round_off" checked>

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
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </form>
    </div>
  </section>

<div class="popup_render_div"></div>
@endsection

@section('customJS')
  @include('admin.order.partials.script')

<script>
    var order = {
    products: [],
    thailaPrice: 0.00,
    is_round_off: 1,
    sub_total: 0.00,
    round_off_amount: 0,
    grand_total: 0.00
    };
    var rowIndex;
    $(document).ready(function(){
        localStorage.removeItem('order');
        order = JSON.parse(localStorage.getItem('order')) || {
        products: [],
        thailaPrice: 0.00,
        is_round_off: 1,
        sub_total: 0.00,
        round_off_amount: 0,
        grand_total: 0.00
        };

        order.sub_total = calculateSubtotal();
        // Update the subtotal in the UI
        $('#sub_total_amount').text(order.sub_total.toFixed(2));
        calculateGrandTotal();

        $("#customer_id").change(function (e) {
            e.preventDefault();
            order.customer_id = parseInt($(this).val());
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


        $('#addNewBlankRow').click(function () {
            // Clone the Template Row
            var newRow = $('.template-row').clone().removeClass('template-row');
            // Clear input values in the new row
            newRow.find('input').val('');
            // Append the new row to the table body
            $('.ordertable tbody').append(newRow);
            // Show the new row
            newRow.show();
        });


        function addBlankRow() {
            // Append a new row to the table body
            var tableBody = $(".table.table-striped.table-hover.ordertable").find("tbody");
            var newRowHtml = '<tr>' +
                '<td class="text-right">' +
                '<div class="d-flex align-items-center buttonGroup justify-content-end">' +
                '<button class="btn btn-dark btn-sm copy-product" title="@lang("quickadmin.qa_copy")"><i class="fas fa-copy"></i></button>' +
                '<button class="btn btn-danger btn-sm delete-product" title="@lang("quickadmin.qa_delete")"><i class="fas fa-trash"></i></button>' +
                '</div></td>' +
                '<td class="text-center d-none product-id"></td>' +
                '<td class="text-center product-name"></td>' +
                '<td class="text-center">' +
                '<div class="form-group m-0">' +
                '<select class="js-product-basic-single @error('product_id') is-invalid @enderror" name="product_id"></select>' +
                '</div></td>' +
                '<td class="text-center">' +
                '<div class="form-group m-0">' +
                '<input type="text" class="form-control" min="0" name="quantity" autocomplete="true" oninput="calculateAmount(this);" required>' +
                '</div></td>' +
                '<td class="text-center">' +
                '<div class="form-group m-0">' +
                '<input type="text" class="form-control" min="0" name="price" autocomplete="true" oninput="calculateAmount(this);" required>' +
                '</div></td>' +
                '<td class="text-center">' +
                '<div class="form-group m-0">' +
                '<input type="numeric" class="form-control" name="total_price" readonly>' +
                '</div></td>' +
                '</tr>';
            tableBody.append(newRowHtml);
        }

        // Initialize the thailaPrice from local storage if available
        if (localStorage.getItem("order")) {
            order = JSON.parse(localStorage.getItem("order"));
            $("#thaila_price").val(order.thailaPrice || 0.00);
        }

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
        // new



        // ***********Code Starts for select box modal of party and item ***********

        $(".js-customer-list").select2({
        }).on('select2:open', function () {
            let a = $(this).data('select2');
            if (!$('.select2-link').length) {
                a.$results.parents('.select2-results')
                    .append('<div class="select2-link2"><button class="btns addNewCustomerBtn get-customer" ><i class="fa fa-plus-circle"></i> Add New</button></div>');
            }
        });

        $(".js-product-basic-single").select2({
        }).on('select2:open', function () {
            let a = $(this).data('select2');
            if (!$('.select2-link').length) {
                a.$results.parents('.select2-results')
                    .append('<div class="select2-link2"><button class="btns addNewBtn get-product"><i class="fa fa-plus-circle"></i> Add New</button></div>');
            }
        });

        $(document).on('click', '.select2-container .get-customer', function (e) {
            e.preventDefault();
            var gethis = $(this);
            var hrefUrl = "{{ route('customers.create') }}";
            $('.modal-backdrop').remove();
            console.log(hrefUrl);
            $.ajax({
                type: 'get',
                url: hrefUrl,
                dataType: 'json',
                success: function (response) {
                    if(response.success) {
                        console.log('success');

                        //$("body").addClass("modal-open");
                        $('.popup_render_div').html(response.htmlView);

                        // Show the first modal
                        $('.popup_render_div #centerModal').modal('show');

                        // Initialize select2 for the first modal
                        $(".js-example-basic-single").select2({
                        dropdownParent: $('.popup_render_div #centerModal') // Set the dropdown parent to the modal
                        }).on('select2:open', function () {
                            let a = $(this).data('select2');
                            if (!$('.select2-link').length) {
                                a.$results.parents('.select2-results')
                                .append('<div class="select2-link2"><button class="btns get-city close-select2"><i class="fa fa-plus-circle"></i> Add New</button></div>');
                            }
                        });
                    }
                }
            });
        });

        $(document).on('click', '.select2-container .get-city', function (e) {
            e.preventDefault();
            var gethis = $(this);
            var hrefUrl = "{{ route('address.create') }}";
            $('.modal-backdrop').remove();
            // Fetch data and populate the second modal
            $.ajax({
                type: 'get',
                url: hrefUrl,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        console.log('success');
                        $('.addressmodalbody').remove();
                        $('.popup_render_div #address_id').select2('close');
                        $('.popup_render_div').after('<div class="addressmodalbody" style="display: block;"></div>');
                        $('.addressmodalbody').html(response.htmlView);
                        $('.addressmodalbody #centerModal').modal('show');
                        $('.addressmodalbody #centerModal').attr('style', 'z-index: 100000');
                    }
                }
            });
        });

        $(document).on('click', '.select2-container .get-product', function (e) {
            e.preventDefault();
            var gethis = $(this);
            var hrefUrl = "{{ route('products.create') }}";
            $('.modal-backdrop').remove();
            $.ajax({
                type: 'get',
                url: hrefUrl,
                dataType: 'json',
                success: function (response) {
                    if(response.success) {

                        //$("body").addClass("modal-open");
                        $('.popup_render_div').html(response.htmlView);
                        $('.popup_render_div #centerModal').modal('show');
                        $(".js-example-basic-single").select2({
                            dropdownParent: $('.popup_render_div #centerModal') // Set the dropdown parent to the modal
                        }).on('select2:open', function () {
                            let a = $(this).data('select2');
                            if (!$('.select2-link').length) {
                                a.$results.parents('.select2-results')
                                .append('<div class="select2-link2"><button class="btns AddCatBtn get-category close-select2" ><i class="fa fa-plus-circle"></i> Add New</button></div>');
                            }
                        });
                    }
                }
            });
        });

        $(document).on('click', '.select2-container .get-category', function (e) {
            e.preventDefault();
            var gethis = $(this);
            var hrefUrl = "{{ route('categories.create') }}";
            $('.modal-backdrop').remove();
            // Fetch data and populate the second modal
            $.ajax({
                type: 'get',
                url: hrefUrl,
                dataType: 'json',
                success: function (response) {
                    if (response.success) {
                        $('.categorymodalbody').remove();
                        $('.popup_render_div #category_id').select2('close');
                        $('.popup_render_div').after('<div class="categorymodalbody" style="display: block;"></div>');
                        $('.categorymodalbody').html(response.htmlView);
                        $('.categorymodalbody #centerModal').modal('show');
                        $('.categorymodalbody #centerModal').attr('style', 'z-index: 100000');
                    // $('.popup_render_div #centerModal').modal('show');
                        //$('.popup_render_div #centerModal').attr('style', 'z-index: 9999');
                        // $('.popup_render_div #centerModal').on('shown.bs.modal', function () {
                        //     $('.categorymodalbody #centerModal').modal('show');
                        //     $('.categorymodalbody #centerModal').attr('style', 'z-index: 100000');
                        // });
                    }
                }
            });
        });

        $(document).on('hidden.bs.modal','.categorymodalbody .modal', function (e) {
            e.preventDefault();
            $('.categorymodalbody').remove();
        });

        // Code Add New Customer or Product Both

        $(document).on('submit', '#AddForm', function (e) {
            e.preventDefault();
            $("#AddForm button[type=submit]").prop('disabled',true);
            $(".error").remove();
            $(".is-invalid").removeClass('is-invalid');
            var formData = $(this).serialize();
            var formAction = $(this).attr('action');
            $.ajax({
                url: formAction,
                type: 'POST',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                success: function (response) {
                        $('#centerModal').modal('hide');
                        var alertType = response['alert-type'];
                        var message = response['message'];
                        var title = response['title'];

                        var newOption = new Option(response.selectdata.name, response.selectdata.id, true, true);
                        //console.log(newOption);
                        if (response.selectdata.formtype == 'customer') {
                            $('#customer_id').append(newOption).trigger('change');
                        } else if (response.selectdata.formtype == 'product') {
                            $('#product_id').append(newOption).trigger('change');
                        }

                        showToaster(title,alertType,message);
                        $('#AddForm')[0].reset();
                        //location.reload();
                    $("#AddForm button[type=submit]").prop('disabled',false);
                },
                error: function (xhr) {
                    var errors= xhr.responseJSON.errors;
                    //console.log(xhr.responseJSON);

                    for (const elementId in errors) {
                        $("#"+elementId).addClass('is-invalid');
                        var errorHtml = '<div><span class="error text-danger">'+errors[elementId]+'</span></div>';
                        $(errorHtml).insertAfter($("#"+elementId).parent());
                    }
                    $("#AddForm button[type=submit]").prop('disabled',false);
                }
            });
        });

        // Add Address Instatntly

        $(document).on('submit', '#AddaddressForm', function (e) {
            e.preventDefault();

            $("#AddaddressForm button[type=submit]").prop('disabled',true);
            $(".error").remove();
            $(".is-invalid").removeClass('is-invalid');
            var form = $(this);
            var formData = $(this).serialize();
            var formAction = $(this).attr('action');
            $.ajax({
                url: formAction,
                type: 'POST',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
                data: formData,
                success: function (response) {
                        // $('.addressmodalbody #centerModal').modal('hide');
                        // $('.popup_render_div #centerModal').modal('hide');

                        form.closest('#centerModal').modal('hide');

                        var newOption = new Option(response.address.address, response.address.id, true, true);
                        //console.log(newOption);
                        $('.popup_render_div #centerModal #address_id').append(newOption).trigger('change');

                        var alertType = response['alert-type'];
                        var message = response['message'];
                        var title = "{{ trans('quickadmin.address.address') }}";
                        showToaster(title,alertType,message);
                        $('#AddaddressForm')[0].reset();
                        //location.reload();
                        //DataaTable.ajax.reload();
                        $("#AddaddressForm button[type=submit]").prop('disabled',false);
                },
                error: function (xhr) {
                    var errors= xhr.responseJSON.errors;
                    console.log(xhr.responseJSON);

                    for (const elementId in errors) {
                        $("#"+elementId).addClass('is-invalid');
                        var errorHtml = '<div><span class="error text-danger">'+errors[elementId]+'</span></';
                        $(errorHtml).insertAfter($("#"+elementId).parent());
                    }
                    $("#AddaddressForm button[type=submit]").prop('disabled',false);
                }
            });
        });

        // add new category
        $(document).on('submit', '#AddCategoryForm', function (e) {
            e.preventDefault();

            $("#AddCategoryForm button[type=submit]").prop('disabled',true);
            $(".error").remove();
            $(".is-invalid").removeClass('is-invalid');
            var form = $(this);
            var formData = $(this).serialize();
            var formAction = $(this).attr('action');
            console.log(formAction);
            console.log(formData);

            $.ajax({
                url: formAction,
                type: 'POST',
                headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                data: formData,
                success: function (response) {
                        // $('.categorymodalbody #centerModal').modal('hide');
                        // $('.popup_render_div #centerModal').modal('hide');

                        form.closest('#centerModal').modal('hide');

                        var alertType = response['alert-type'];
                        var message = response['message'];
                        var title = "{{ trans('quickadmin.category.category') }}";

                        var newOption = new Option(response.category.name, response.category.id, true, true);
                        //console.log(newOption);
                        $('.popup_render_div #category_id').append(newOption).trigger('change');
                        showToaster(title,alertType,message);
                        $('#AddCategoryForm')[0].reset();
                    // location.reload();

                    $("#AddCategoryForm button[type=submit]").prop('disabled',false);
                },
                error: function (xhr) {
                    var errors= xhr.responseJSON.errors;
                    console.log(xhr.responseJSON);

                    for (const elementId in errors) {
                        $("#"+elementId).addClass('is-invalid');
                        var errorHtml = '<div><span class="error text-danger">'+errors[elementId]+'</span></';
                        $(errorHtml).insertAfter($("#"+elementId).parent());
                    }
                    $("#AddCategoryForm button[type=submit]").prop('disabled',false);
                }
            });
        });





        // ***********Code End for select box modal of party and item***********
    });
</script>
@endsection
