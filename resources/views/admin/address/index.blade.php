@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('title')@lang('quickadmin.address.title') @endsection
@section('customCss')
<meta name="csrf-token" content="{{ csrf_token() }}" >
<link rel="stylesheet" href="{{ asset('admintheme/assets/css/printView-datatable.css')}}">

<style>
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

    .select2-dropdown{
        z-index: 99999;
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
                  <h4>@lang('quickadmin.address.title')</h4>
                </div> --}}
                <div class="card-body">
                    <div class="row align-items-center mb-4">
                        <div class="col">
                            <form id="citiwise-filter-form">
                                <div class="row align-items-center">
                                    <div class="col-xl-3 col-lg-4 col-md-5 col-sm-6 pr-sm-1 mb-sm-0 mb-3">
                                        {{-- <div class="form-group label-position m-0">
                                            <label for="address_id">@lang('quickadmin.customers.fields.select_address')</label>
                                            <div class="input-group">
                                                <select class="form-control @error('address_id') is-invalid @enderror" name="address_id" id="address_id" value="">
                                                    <option value="">@lang('quickadmin.customers.fields.select_address')</option>
                                                    @foreach($addresses as $address)
                                                    <option value="{{ $address->id }}">{{ $address->address }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div> --}}

                                        <div class="custom-select2 fullselect2">
                                            <div class="form-control-inner">
                                                <label for="address_id">@lang('quickadmin.customers.fields.select_address')</label>
                                                <select class="js-example-basic-single @error('address_id') is-invalid @enderror" name="address_id" id="address_id" >
                                                    <option value="">@lang('quickadmin.customers.fields.select_address')</option>
                                                    @foreach($addresses as $address)
                                                    <option value="{{ $address->id }}">{{ $address->address }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-xl-3 col-lg-4 col-sm-6 text-end pl-sm-1">
                                        <div class="form-group d-flex justify-content-end m-0">
                                            <button type="submit" class="btn btn-primary mr-1 col" id="apply-filter">@lang('quickadmin.qa_submit')</button>
                                            <button type="reset" class="btn btn-primary mr-1 col" id="reset-filter">@lang('quickadmin.qa_reset')</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-md-auto col-12 mt-md-0 mt-3">
                            <div class="row align-items-center">
                                <div class="col-auto px-md-1 pr-1">
                                    @can('address_create')
                                    <button type="button" class="btn h-10 btn-outline-dark addRecordBtn sm_btn" data-toggle="modal" data-target="#centerModal" data-href="{{ route('address.create')}}"><i class="fas fa-plus"></i> @lang('quickadmin.roles.fields.add')</button>
                                    @endcan
                                </div>
                                <div class="col-auto px-1">
                                    <a href="{{ route('address.print') }}" class="btn h-10 btn-success mr-1 col"  id="print-button">@lang('quickadmin.qa_print')</a>
                                </div>
                                <div class="col-auto pl-1">
                                    <a href="{{ route('address.export') }}" class="btn h-10 btn-warning mr-1 col"  id="excel-button">@lang('quickadmin.qa_excel')</a>
                                </div>
                            </div>
                        </div>
                    </div>
                  <div class="table-responsive fixed_Search">
                    {{$dataTable->table(['class' => 'table dt-responsive subBodyTable', 'style' => 'width:100%;','id'=>'addressTable'])}}
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
    var addressDataTable = $('#addressTable').DataTable();


    $('#print-button').printPage();

    $(document).on('click' , 'excel-button' , function(e){
        e.preventDefault();
        var iframe = document.createElement('iframe');
        console.log('iframe');
        iframe.style.display = 'none';
        iframe.src = '/address-export'; // Replace with the actual URL for your export route
        document.body.appendChild(iframe);
    });

    $(".js-example-basic-single").select2({
    }).on('select2:open', function () {
        let a = $(this).data('select2');
        if (!$('.select2-link').length) {
            a.$results.parents('.select2-results')
                .append('<div class="select2-link2"><button class="btns addNewBtn get-city" data-toggle="modal" data-target="#centerModal"><i class="fa fa-plus-circle"></i> Add New</button></div>');
        }
    });

    $(document).on('click', '.select2-container .get-city', function (e) {
        e.preventDefault();
        var gethis = $(this);
        var hrefUrl = "{{ route('address.create') }}";
        console.log(hrefUrl);
        $.ajax({
            type: 'get',
            url: hrefUrl,
            dataType: 'json',
            success: function (response) {
                if(response.success) {
                    console.log('success');
                    $('.popup_render_div').html(response.htmlView);
                    $('#centerModal').modal('show');
                    //$("body").addClass("modal-open");
                }
            }
        });
    });

    $(document).on('click', '.toggle-accordion', function (e) {
        e.preventDefault();
        var addressId = $(this).data('address-id');
        var accordionContent = $('#customers_' + addressId);
        console.log(addressId);
        // Check if the accordion content is already loaded
        if (!$(this).data('loaded')) {
            $('.accordion-content-row').remove();

            $.ajax({
                url: '{{ route("CustomerListOfAddress", ["address_id" => ":addressId"]) }}'.replace(':addressId', addressId),
                type: 'GET',
                success: function (data) {
                    var accordionRow = $(this).closest('tr');
                    var accordionContentRow = '<tr class="accordion-content-row"><td colspan="5"><div class="accordian-body collapse" id="customers_' + addressId + '">' + data + '</div></td></tr>';

                    // Append the new accordion content row
                    accordionRow.after(accordionContentRow);

                    // Update the loaded flag on the button element
                    $(this).data('loaded', true);

                    // Close any previously opened accordion
                    $('.toggle-accordion').not(this).each(function () {
                        var otherAddressId = $(this).data('address-id');
                        var otherAccordionContent = $('#customers_' + otherAddressId);
                        otherAccordionContent.collapse('hide');
                        $(this).data('loaded', false);
                    });

                    // Manually toggle the accordion visibility
                    var accordionContent = accordionRow.next('.accordion-content-row').find('.accordian-body');
                    accordionContent.collapse('toggle');
                }.bind(this),
                error: function (xhr, status, error) {
                    console.error('Error fetching customer list:', error);
                }
            });
        } else {
            // Use a custom attribute to track the accordion state
            var isOpen = accordionContent.hasClass('show');

            if (isOpen) {

                accordionContent.closest('.accordion-content-row').hide();
                accordionContent.collapse('hide');
                //$('.accordion-content-row').remove();
            } else {

                accordionContent.closest('.accordion-content-row').show();
                accordionContent.collapse('show');
            }
        }
    });

    $(document).on('click', '.close-accordion', function (e) {
        e.preventDefault();
        var addressId = $(this).data('address-id');
        var accordionContent = $('#customers_' + addressId);

        if (accordionContent.length) {
            accordionContent.collapse('hide');
            accordionContent.closest('.accordion-content-row').hide();
        }
    });

    $(document).on('click','.addRecordBtn', function(){
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
                    $('#centerModal').modal('show');
                }
            }
        });
    });

    $("body").on("click", ".edit-address-btn", function () {
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
                        $('#editAddressModal').modal('show');
                    }
                }
            });
    });

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
                    $('#centerModal').modal('hide');

                    if (!$('.js-example-basic-single').data('select2')) {
                        $('.js-example-basic-single').select2();
                    }
                    var newOption = new Option(response.address.address, response.address.id, true, true);
                    //console.log(newOption);
                    $('#address_id').append(newOption).trigger('change');

                    var alertType = response['alert-type'];
                    var message = response['message'];
                    var title = "{{ trans('quickadmin.address.address') }}";
                    showToaster(title,alertType,message);
                    $('#AddaddressForm')[0].reset();
                    //location.reload();
                    addressDataTable.ajax.reload();
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


    $(document).on('submit', '#EditaddressForm', function (e) {
        e.preventDefault();

        $("#EditaddressForm button[type=submit]").prop('disabled',true);
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
                    $('#editAddressModal').modal('hide');
                    var alertType = response['alert-type'];
                    var message = response['message'];
                    var title = "{{ trans('quickadmin.address.address') }}";
                    showToaster(title,alertType,message);
                    $('#EditaddressForm')[0].reset();
                   // location.reload();
                   addressDataTable.ajax.reload();
                   $("#EditaddressForm button[type=submit]").prop('disabled',false);
            },
            error: function (xhr) {
                var errors= xhr.responseJSON.errors;
                console.log(xhr.responseJSON);

                for (const elementId in errors) {
                    $("#EditaddressForm #"+elementId).addClass('is-invalid');
                    var errorHtml = '<div><span class="error text-danger">'+errors[elementId]+'</span></';
                    $(errorHtml).insertAfter($("#EditaddressForm #"+elementId).parent());
                }
                $("#EditaddressForm button[type=submit]").prop('disabled',false);
            }
        });
    });


    $(document).on('submit', '.deleteAddressForm', function(e) {
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
            // If the user confirms, send the DELETE request
            $.ajax({
            url: formAction,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                var alertType = response['alert-type'];
                    var message = response['message'];
                    var title = "{{ trans('quickadmin.address.address') }}";
                    showToaster(title,alertType,message);
                    addressDataTable.ajax.reload();

            },
            error: function (xhr) {
                // Handle error response
                swal('Address', 'some mistake is there.', 'error');
            }
            });
        }
        });
    });

    $('#reset-filter').on('click', function(e) {
        e.preventDefault();
        $('#citiwise-filter-form')[0].reset();

        addressDataTable.ajax.url("{{ route('address.index') }}").load();
    });

    $('#citiwise-filter-form').on('submit', function(e) {
        e.preventDefault();

        var address_id = $('#address_id').val();
        if(address_id == undefined){
            address_id = '';
        }
        var params = {
            address_id      : address_id,
        };
        // Apply filters to the DataTable
        addressDataTable.ajax.url("{{ route('address.index') }}?"+$.param(params)).load();

    });


});



</script>
@endsection
