@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('title')@lang('quickadmin.order-management.title')@endsection
@section('customCss')
<meta name="csrf-token" content="{{ csrf_token() }}" >
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="{{ asset('admintheme/assets/css/printView-datatable.css')}}">
<style>
    .dropdown-toggle::after {
    display: none;
    }

</style>
@endsection

@section('main-content')

<section class="section roles" style="z-index: unset">
    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body pt-4">


                        <form id="invoice-filter-form">
                            <div class="row align-items-end">
                                <div class="col-md-3">
                                    <div class="form-group label-position">
                                        <label for="customer_id">@lang('quickadmin.order.fields.customer_name')</label>
                                        <div class="input-group">
                                            <select class="form-control @error('customer_id') is-invalid @enderror" name="customer_id" id="customer_id" value="">
                                                <option value="">@lang('quickadmin.order.fields.select_customer')</option>
                                                @foreach($customers as $customer)
                                                <option value="{{ $customer->id }}">{{ $customer->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-position">
                                        <label for="from_date">@lang('quickadmin.order.fields.from_date')</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker" name="from_date" value="" id="from_date" autocomplete="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group label-position">
                                        <label for="to_date">@lang('quickadmin.order.fields.to_date')</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control datepicker" name="to_date" value="" id="to_date" autocomplete="true">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3 text-end">
                                    <div class="form-group d-flex justify-content-end">
                                        <button type="submit" class="btn btn-primary mr-1 col" id="apply-filter">@lang('quickadmin.qa_submit')</button>
                                        <button type="reset" class="btn btn-primary mr-1 col" id="reset-filter">@lang('quickadmin.qa_reset')</button>
                                        @if ($type != 'deleted')
                                        <a class="btn btn-outline-primary col" href="{{ route('orders.getTypeOrder',['type'=>'deleted'])}}" id="trashed-data"><i class="fa fa-trash"></i> @lang('quickadmin.order.recycle')</a>
                                        @endif

                                    </div>
                                </div>
                            </div>
                        </form>

                        <div class="table-responsive fixed_Search">
                            {{$dataTable->table(['class' => 'table dt-responsive invoicdatatable dropdownBtnTable', 'style' => 'width:100%;','id'=>'dataaTable'])}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="popup_render_div"></div>
</section>
@endsection


@section('customJS')
{!! $dataTable->scripts() !!}
  <script src="{{ asset('admintheme/assets/bundles/datatables/datatables.min.js') }}"></script>
  <script src="{{ asset('admintheme/assets/bundles/datatables/DataTables-1.10.16/js/dataTables.bootstrap4.min.js') }}"></script>
  <script src="{{ asset('admintheme/assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>
  <!-- Page Specific JS File -->
  <script src="{{ asset('admintheme/assets/js/page/datatables.js') }}"></script>
  <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>

$(document).ready(function () {

    var dataTable = $('#dataaTable').DataTable();
   // $('#print-button-2').printPage();
    $(document).ready(function() {

        // $('.print-button').each(function() {
        //     var actionId = $(this).attr('id');
        //     $('#' + actionId).printPage();
        // });
        // document.querySelectorAll('.print-button').forEach(
        //     var actionid = $(this).attr('id');
        //     $('#'+actionid).printPage();
        // );

        // $(document).on('click', '.print-button', function(e) {
        //     var actionid = $(this).attr('id');
        //     console.log('actionid: ','#'+actionid);
        //     $('#print-button-2').printPage();
        // });

    });


    flatpickr('.datepicker', {
        dateFormat: 'Y-m-d', // Set the desired date format
        allowInput: true,    // Allow manual input
        defaultDate: null    // Set the default date to null (no default date)
    });
    document.querySelectorAll('.datepicker').forEach(function (element) {
        element.addEventListener('focus', function () {
            this.type = 'date';
        });
        element.addEventListener('blur', function () {
            this.type = 'text';
        });
    });

    $("body").on("click", ".edit-customers-btn", function () {
            var hrefUrl = $(this).attr('data-href');
            $('.modal-backdrop').remove();
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


    $(document).on('click', '.print-button', function(e) {
        e.preventDefault();
        var actionurl = $(this).data('href');
        console.log(actionurl);

        $.ajax({
            url: actionurl,
            method: 'GET',
            success: function(response) {
                var basestringpdf = response.pdf;
                var objbuilder= '';
                objbuilder += ('<object width = "100%" height="100%" data="data:application/pdf;base64,');
                objbuilder += (basestringpdf);
                objbuilder += ('" type="application/pdf" class="internal">');
                objbuilder += ('<embed type="application/pdf" src="data:application/pdf;base64,' + basestringpdf + '" />');
                objbuilder += ('</object>');

                var mywindow = window.open('', 'PRINT', 'height=600,width=800');
                mywindow.document.write('<html><head><title>PRINT PREVIEW</title>');
                mywindow.document.write('</head><body >');
                // mywindow.document.write('<embed type="application/pdf" width="100%" height="100%" src="data:application/pdf;base64,' + decodedPdfContent + '" />');
                mywindow.document.write(objbuilder);
                mywindow.document.write('</body></html>');
                layer = $(mywindow.document);
                // mywindow.print();
                // mywindow.close();
                },
                error: function(error) {
                    console.error('Error fetching invoice:', error);
                }
        });
    });


    $(document).on('click', '.share-email-btn', function(e) {
        e.preventDefault();
        var recipientMail = $(this).data('recipient-email');
        var orderId = $(this).data('order-id');
        var pdfDownloadUrl = $(this).data('href');
        var pdfLink = document.createElement('a');
        var mssg="{{ getSetting('share_invoice_mail_message')}}";
        pdfLink.href = pdfDownloadUrl;
        pdfLink.download = 'invoice.pdf';
        pdfLink.style.display = 'none';
        document.body.appendChild(pdfLink);
        pdfLink.click();
        document.body.removeChild(pdfLink);
        var mailtoUrl = 'mailto:' + recipientMail + '?subject=Invoice Detail&body='+mssg;
        window.location.href = mailtoUrl;
    });

    $(document).on('click','.share-whatsapp-btn',function(e){
        e.preventDefault();
        var recipientNumber = $(this).data('recipient-number');
        var orderId = $(this).data('order-id');
        var pdfDownloadUrl = $(this).data('href');
        var pdfLink = document.createElement('a');
        var mssg="{{ getSetting('share_invoice_whatsapp_message')}}";
        pdfLink.href = pdfDownloadUrl;
        pdfLink.download = 'invoice.pdf';
        pdfLink.style.display = 'none';
        document.body.appendChild(pdfLink);
        pdfLink.click();
        document.body.removeChild(pdfLink);
        var whatsappUrl = 'https://api.whatsapp.com/send?phone=' + recipientNumber + '&text='+mssg;
        window.open(whatsappUrl, '_blank');
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
                    var title = "{{ trans('quickadmin.order.invoice') }}";
                    showToaster(title,alertType,message);
                    dataTable.ajax.reload();
                    // location.reload();

            },
            error: function (xhr) {
                // Handle error response
                swal("{{ trans('quickadmin.order.invoice') }}", 'Some mistake is there.', 'error');
            }
            });
        }
        });
    });


    $(document).on('submit', '.restoreForm', function(e) {
        e.preventDefault();
        console.log(2);
        var formAction = $(this).attr('action');
        swal({
        title: "{{ trans('messages.restoretitle') }}",
        text: "{{ trans('messages.areYouSureRestore') }}",
        icon: 'warning',
        buttons: {
        confirm: 'Yes, Restore it',
        cancel: 'No, cancel',
         },
        dangerMode: true,
        }).then((willDelete) => {
        if (willDelete) {
            $.ajax({
            url: formAction,
            type: 'PATCH',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var alertType = response['alert-type'];
                    var message = response['message'];
                    var title = "{{ trans('quickadmin.order.invoice') }}";
                    showToaster(title,alertType,message);
                    dataTable.ajax.reload();
                    // location.reload();

            },
            error: function (xhr) {
                // Handle error response
                swal("{{ trans('quickadmin.order.invoice') }}", 'Some mistake is there.', 'error');
            }
            });
        }
        });
    });

    $('#reset-filter').on('click', function(e) {
        e.preventDefault();
        $('#invoice-filter-form')[0].reset();

        var select2Element = $('#customer_id');
        select2Element.val(null).trigger('change');
        var select2Elementfrom_date = $('#from_date');
        select2Elementfrom_date.val(null).trigger('change');
        var select2Elementto_date = $('#to_date');
        select2Elementto_date.val(null).trigger('change');

        var type = "{{$type}}";

        if(type == 'deleted'){
            var url = "{{ route('orders.getTypeOrder') }}/" + type;
            dataTable.ajax.url(url).load();
        }else{
            dataTable.ajax.url("{{ route('orders.index') }}").load();
        }


    });

    $('#invoice-filter-form').on('submit', function(e) {
        e.preventDefault();

        var type = "{{$type}}";
        console.log("{{$type}}");

        // Collect filter values (customer, from_date, to_date) from the form
        var customer_id = $('#customer_id').val();
        if(customer_id == undefined){
            customer_id = '';
        }
        var from_date = $('#from_date').val();
        if(from_date == undefined){
            from_date = '';
        }
        var to_date = $('#to_date').val();
        if(to_date == undefined){
            to_date = '';
        }

        var params = {
                customer_id      : customer_id,
                from_date        : from_date,
                to_date          : to_date,
        };
        // Apply filters to the DataTable
        if(type == 'deleted'){
            dataTable.ajax.url("{{ route('orders.getTypeOrder') }}/" + type + "?" +$.param(params)).load();
        }else{

            dataTable.ajax.url("{{ route('orders.index') }}?"+$.param(params)).load();
        }


    });

    $(document).on('click','.view-delete-orders', function(){
       // $('#preloader').css('display', 'flex');
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
                    $('#OrderModal').modal('show');
                }
            }
        });
    });

});



</script>
@endsection
