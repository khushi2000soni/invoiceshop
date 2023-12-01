@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('title')@lang('quickadmin.address.title') @endsection
@section('customCss')
<meta name="csrf-token" content="{{ csrf_token() }}" >
<link rel="stylesheet" href="{{ asset('admintheme/assets/css/printView-datatable.css')}}">
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
                                    @can('address_create')
                                    <button type="button" class="btn btn-outline-dark addRecordBtn" data-toggle="modal" data-target="#centerModal" data-href="{{ route('address.create')}}"><i class="fas fa-plus"></i> @lang('quickadmin.roles.fields.add')</button>
                                    @endcan
                                    {{-- <button class="btn btn-primary mr-1 col"  id="print-button">Print</button> --}}
                                </div>
                            </div>
                        </div>
                    </form>
                  <div class="table-responsive">
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

    // $('#addressTable tbody').on('click', 'tr', function () {
    //     var data = addressDataTable.row(this).data();
    //     //console.log(data.id);
    //     toggleAccordion(data.id);
    // });

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
