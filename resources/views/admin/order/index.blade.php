@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('title')@lang('quickadmin.order-management.title')@endsection
@section('customCss')
<meta name="csrf-token" content="{{ csrf_token() }}" >
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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
                <div class="card-header d-flex justify-content-between align-items-center">
                <h4>@lang('quickadmin.order-management.fields.list')</h4>
                @can('invoice_create')
                <a class="btn btn-outline-primary"  href="{{ route('orders.create') }}"><i class="fas fa-plus"></i> @lang('quickadmin.order.fields.add')</a>
                @endcan
                </div>
            </div>
            </div>
            <div class="col-12">
                <div class="card">
                <div class="card-body">
                    <form id="invoice-filter-form">
                        <div class="row align-items-end">
                            <div class="col-md-4">
                                <div class="form-group">
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
                                <div class="form-group">
                                    <label for="from_date">@lang('quickadmin.order.fields.from_date')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" name="from_date" value="" id="from_date" autocomplete="true">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label for="to_date">@lang('quickadmin.order.fields.to_date')</label>
                                    <div class="input-group">
                                        <input type="text" class="form-control datepicker" name="to_date" value="" id="to_date" autocomplete="true">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-2">
                                <div class="form-group ">
                                    <button type="submit" class="btn btn-primary" id="apply-filter">@lang('quickadmin.qa_submit')</button>
                                    <button type="reset" class="btn btn-primary" id="reset-filter">@lang('quickadmin.qa_reset')</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                    {{$dataTable->table(['class' => 'table dt-responsive invoicdatatable', 'style' => 'width:100%;','id'=>'dataaTable'])}}
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>

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

    $('#reset-filter').on('click', function(e) {
        e.preventDefault();
        $('#invoice-filter-form')[0].reset();

        dataTable.ajax.url("{{ route('orders.index') }}").load();
    });

    $('#invoice-filter-form').on('submit', function(e) {
        e.preventDefault();

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
        dataTable.ajax.url("{{ route('orders.index') }}?"+$.param(params)).load();

    });

});



</script>
@endsection
