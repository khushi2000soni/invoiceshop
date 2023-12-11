@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('title')@lang('quickadmin.customer-management.fields.list')@endsection
@section('customCss')
<meta name="csrf-token" content="{{ csrf_token() }}" >
<link rel="stylesheet" href="{{ asset('admintheme/assets/css/printView-datatable.css')}}">

<style>
    /* @media print {
        table, table tr, table td {
            border: 1px solid #3d3c3c;
        }
    } */
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
    #centerModal, #editModal{
        z-index: 99999;
    }
    #centerModal::before, #editModal::before{
        display: none;
    }

    .modal-open .modal-backdrop.show{
        display: block !important;
        z-index: 9999;
    }

    .select2-dropdown{
        z-index: 99999;
    }
    .cart_filter_box{
        border-bottom: 1px solid #e5e9f2;
    }
    #editModal .select2-results{
        padding-top: 0px !important;
    }
</style>
@endsection
@section('main-content')

<section class="section roles" style="z-index: unset">
    <div class="section-body">
          <div class="row">
            <div class="col-12">
              <div class="card">
                {{-- <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>@lang('quickadmin.customer-management.fields.list')</h4>
                  @can('customer_create')
                  <button type="button" class="btn btn-outline-dark addRecordBtn" data-toggle="modal" data-target="#centerModal" data-href="{{ route('customers.create')}}"><i class="fas fa-plus"></i> @lang('quickadmin.roles.fields.add')</button>
                  @endcan
                </div> --}}

                <div class="card-body">
                    <div class="row align-items-center mb-4 cart_filter_box">
                        <div class="col">
                            <form id="citiwise-filter-form">
                                <div class="row align-items-end">
                                    <div class="col-md-3">
                                        <div class="form-group label-position">
                                            <label for="address_id">@lang('quickadmin.customers.fields.select_address')</label>
                                            <div class="input-group">
                                                <select class="form-control @error('address_id') is-invalid @enderror" name="address_id" id="address_id" value="">
                                                    <option value="">@lang('quickadmin.customers.fields.select_address')</option>
                                                    @foreach($addresses as $address)
                                                    <option value="{{ $address->id }}">{{ $address->address }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3 text-end">
                                        <div class="form-group d-flex justify-content-end">
                                            <button type="submit" class="btn btn-primary mr-1 col" id="apply-filter">@lang('quickadmin.qa_submit')</button>
                                            <button type="reset" class="btn btn-primary mr-1 col" id="reset-filter">@lang('quickadmin.qa_reset')</button>
                                            {{-- <button class="btn btn-primary mr-1 col"  id="print-button">Print</button> --}}
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <div class="col-md-auto col-12 mt-md-0 mt-3">
                            <div class="row align-items-center">
                                <div class="col-auto px-md-1 pr-1">
                                    @can('customer_create')
                                    <button type="button" class="btn btn-outline-dark addRecordBtn sm_btn"  data-href="{{ route('customers.create')}}"><i class="fas fa-plus"></i> @lang('quickadmin.customers.fields.add')</button>
                                    @endcan
                                </div>
                                <div class="col-auto px-1">
                                    <a href="{{ route('customers.print') }}" class="btn h-10 btn-success mr-1 col"  id="print-button"> <i class="fas fa-print"></i> @lang('quickadmin.qa_print')</a>
                                </div>
                                <div class="col-auto pl-1">
                                    <a href="{{ route('customers.export') }}" class="btn h-10 btn-warning mr-1 col"  id="excel-button"><i class="fas fa-file-excel"></i> @lang('quickadmin.qa_excel')</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="table-responsive fixed_Search">
                        {{$dataTable->table(['class' => 'table dt-responsive', 'style' => 'width:100%;','id'=>'dataaTable'])}}
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
  </section>
  <div class="popup_render_div"></div>
@endsection


@section('customJS')
{!! $dataTable->scripts() !!}
  <script src="{{ asset('admintheme/assets/bundles/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('admintheme/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>

  <!-- Page Specific JS File -->
  <script src="{{ asset('admintheme/assets/js/page/datatables.js') }}"></script>


<script>

$(document).ready(function () {
    ////********************** Select Box


    var DataaTable = $('#dataaTable').DataTable();

    $('#print-button').printPage();

    $(document).on('click' , 'excel-button' , function(e){
        e.preventDefault();
        var iframe = document.createElement('iframe');
        console.log('iframe');
        iframe.style.display = 'none';
        iframe.src = '/customers-export'; // Replace with the actual URL for your export route
        document.body.appendChild(iframe);
    });

    $(document).on('click', '.select2-container .get-city', function (e) {
        e.preventDefault();
        var gethis = $(this);
        var hrefUrl = "{{ route('address.create') }}";
        // Fetch data and populate the second modal
        $.ajax({
            type: 'get',
            url: hrefUrl,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    console.log('success');

                    $('.popup_render_div').after('<div class="addressmodalbody" style="display: block;"></div>');
                    $('.addressmodalbody').html(response.htmlView);

                    // $('.addressmodalbody #centerModal').modal('show');
                    // $('.addressmodalbody #centerModal').attr('style', 'z-index: 100000');
                    $('.popup_render_div #centerModal').modal('show');
                    $('.popup_render_div #centerModal').on('shown.bs.modal', function () {
                        $('.addressmodalbody #centerModal').modal('show');
                        $('.addressmodalbody #centerModal').attr('style', 'z-index: 100000');
                    });
                }
            }
        });
    });

    $(document).on('click', '.addRecordBtn', function (e) {
        e.preventDefault();
        var hrefUrl = $(this).attr('data-href');
        console.log(hrefUrl);
        $.ajax({
            type: 'get',
            url: hrefUrl,
            dataType: 'json',
            success: function (response) {
                if (response.success) {
                    // Render the modal content for the first modal
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
                        .append('<div class="select2-link2"><button class="btns get-city close-select2" data-toggle="modal" data-target="#centerModal"><i class="fa fa-plus-circle"></i> Add New</button></div>');
                    }
                    });
                }
            }
        });
    });


    $("body").on("click", ".edit-customers-btn", function () {
            var hrefUrl = $(this).attr('data-href');
            console.log(hrefUrl);
            $.ajax({
                type: 'get',
                url: hrefUrl,
                dataType: 'json',
                success: function (response) {
                    //$('#preloader').css('display', 'none');
                    if(response.success) {
                        console.log('success');
                        $('.popup_render_div').html(response.htmlView);
                        $('#editModal').modal('show');
                         // Initialize select2 for the first modal
                        $(".js-example-basic-single").select2({
                        dropdownParent: $('.popup_render_div #editModal') // Set the dropdown parent to the modal
                        });
                        setTimeout(() => {
                            $('.modal-backdrop').not(':first').remove();
                        }, 300);
                    }
                }
            });
    });

    $("body").on("click", ".edit-password-btn", function () {
            var hrefUrl = $(this).attr('data-href');
            console.log(hrefUrl);
            $.ajax({
                type: 'get',
                url: hrefUrl,
                dataType: 'json',
                success: function (response) {
                    //$('#preloader').css('display', 'none');
                    if(response.success) {
                        console.log('success');
                        $('.popup_render_div').html(response.htmlView);
                        $('#passwordModal').modal('show');
                    }
                }
            });
    });

    /// Add Party
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
                    var title = "{{ trans('quickadmin.customers.customer') }}";
                    showToaster(title,alertType,message);
                    $('#AddForm')[0].reset();
                   // location.reload();
                   DataaTable.ajax.reload();
                   $("#AddForm button[type=submit]").prop('disabled',false);
            },
            error: function (xhr) {
                var errors= xhr.responseJSON.errors;
                console.log(xhr.responseJSON);

                for (const elementId in errors) {
                    $("#"+elementId).addClass('is-invalid');
                    var errorHtml = '<div><span class="error text-danger">'+errors[elementId]+'</span></';
                    $(errorHtml).insertAfter($("#"+elementId).parent());
                }
                $("#AddForm button[type=submit]").prop('disabled',false);
            }
        });
    });


    $(document).on('submit', '#EditForm', function (e) {
        e.preventDefault();
        $("#EditForm button[type=submit]").prop('disabled',true);
        $(".error").remove();
        $(".is-invalid").removeClass('is-invalid');
        var formData = $(this).serialize();
        var formAction = $(this).attr('action');
        console.log(formAction);

        $.ajax({
            url: formAction,
            type: 'PUT',
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            data: formData,
            success: function (response) {
                    $('#editModal').modal('hide');
                    var alertType = response['alert-type'];
                    var message = response['message'];
                    var title = "{{ trans('quickadmin.customers.customer') }}";
                    showToaster(title,alertType,message);
                    $('#EditForm')[0].reset();
                    //location.reload();
                    DataaTable.ajax.reload();
                    $("#EditForm button[type=submit]").prop('disabled',false);
            },
            error: function (xhr) {
                var errors= xhr.responseJSON.errors;
                console.log(xhr.responseJSON);

                for (const elementId in errors) {
                    $("#EditForm #"+elementId).addClass('is-invalid');
                    var errorHtml = '<div><span class="error text-danger">'+errors[elementId]+'</span></';
                    $(errorHtml).insertAfter($("#EditForm #"+elementId).parent());
                }
                $("#EditForm button[type=submit]").prop('disabled',false);
            }
        });
    });

    $(document).on('submit', '#EditPasswordForm', function (e) {
        e.preventDefault();
        $("#EditPasswordForm button[type=submit]").prop('disabled',true);
        $(".error").remove();
        $(".is-invalid").removeClass('is-invalid');
        var formData = $(this).serialize();
        var formAction = $(this).attr('action');
        console.log(formAction);

        $.ajax({
            url: formAction,
            type: 'PUT',
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            data: formData,
            success: function (response) {
                    $('#passwordModal').modal('hide');
                    var alertType = response['alert-type'];
                    var message = response['message'];
                    var title = "{{ trans('quickadmin.customers.customer') }}";
                    showToaster(title,alertType,message);
                    $('#EditPasswordForm')[0].reset();
                    //location.reload();
                    DataaTable.ajax.reload();
                    $("#EditPasswordForm button[type=submit]").prop('disabled',false);
            },
            error: function (xhr) {
                var errors= xhr.responseJSON.errors;
                console.log(xhr.responseJSON);

                for (const elementId in errors) {
                    $("#EditPasswordForm #"+elementId).addClass('is-invalid');
                    var errorHtml = '<div><span class="error text-danger">'+errors[elementId]+'</span></';
                    $(errorHtml).insertAfter($("#EditPasswordForm #"+elementId).parent());
                }
                $("#EditPasswordForm button[type=submit]").prop('disabled',false);
            }
        });
    });

    $(document).on('submit', '.deleteForm', function(e) {
        e.preventDefault();
        console.log(2);
        var formAction = $(this).attr('action');
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
            $.ajax({
            url: formAction,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var alertType = response['alert-type'];
                    var message = response['message'];
                    var title = "{{ trans('quickadmin.customers.customer') }}";
                    showToaster(title,alertType,message);
                    DataaTable.ajax.reload();
                    // location.reload();

            },
            error: function (xhr) {
                // Handle error response
                swal("{{ trans('quickadmin.customers.customer') }}", 'some mistake is there.', 'error');
            }
            });
        }
        });
    });

    // Add Address Instatntly

    $(document).on('submit', '#AddaddressForm', function (e) {
        e.preventDefault();

        $("#AddaddressForm button[type=submit]").prop('disabled',true);
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
                    $('.addressmodalbody #centerModal').modal('hide');

                    if (!$('.js-example-basic-single').data('select2')) {
                        $('.js-example-basic-single').select2();
                    }
                    var newOption = new Option(response.address.address, response.address.id, true, true);
                    //console.log(newOption);
                    $('.popup_render_div #centerModal #address_id').append(newOption).trigger('change');
                    //$('#citiwise-filter-form #address_id').append(newOption).trigger('change');

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


    $('#reset-filter').on('click', function(e) {
        e.preventDefault();
        $('#citiwise-filter-form')[0].reset();
        var select2Element = $('#address_id');

        select2Element.val(null).trigger('change');

        DataaTable.ajax.url("{{ route('customers.index') }}").load();

        originalExportUrl = "{{ route('customers.export') }}";
        originalPrintUrl = "{{ route('customers.print') }}";
        $('#excel-button').attr('href', originalExportUrl);
        $('#print-button').attr('href', originalPrintUrl);
    });

    $('#citiwise-filter-form').on('submit', function(e) {
        e.preventDefault();

        // Collect filter values (customer, from_date, to_date) from the form
        var address_id = $('#address_id').val();
        if(address_id == undefined){
            address_id = '';
        }
        var params = {
            address_id      : address_id,
        };

        exportUrl = "{{ route('customers.export') }}" + '/' + address_id;
        printUrl = "{{ route('customers.print') }}" + '/' + address_id;
        console.log(exportUrl);
        // Apply filters to the DataTable
        DataaTable.ajax.url("{{ route('customers.index') }}?"+$.param(params)).load();
        $('#excel-button').attr('href', exportUrl);
        $('#print-button').attr('href', printUrl);
    });




});



</script>
@endsection
