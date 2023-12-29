@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('title')@lang('quickadmin.user-management.title')@endsection
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
                        <div class="card-body">
                            <div class="row align-items-center mb-4 cart_filter_box">
                                <div class="col">
                                    <h4>@lang('quickadmin.user-management.title')</h4>
                                </div>
                                <div class="col-auto  mt-md-0 mt-3 ml-auto">
                                    <div class="row align-items-center">
                                        <div class="col-auto px-1">
                                            @can('staff_create')
                                            <button type="button" class="addnew-btn addRecordBtn sm_btn" data-toggle="modal" data-target="#centerModal" data-href="{{ route('staff.create')}}"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><circle cx="222.609" cy="111.304" r="111.304" fill="#000000" opacity="1" data-original="#000000" class=""></circle><path d="M351.758 295.081c-23.557 10.231-40.106 33.931-40.106 61.093-36.728 0-66.783 30.054-66.783 66.783 0 7.793 1.337 15.359 4.005 22.261h-137.57c-34.963 0-65.174-26.948-66.677-61.878-2.738-63.664 48.132-116.21 111.199-116.21h133.565c23.558 0 45.535 7.394 63.574 20.147 2.891 2.044 2.04 6.394-1.207 7.804zM467.478 422.957c0 12.239-10.016 22.261-22.261 22.261h-44.522v44.522c0 12.239-10.016 22.261-22.261 22.261s-22.261-10.022-22.261-22.261v-44.522h-44.522c-12.245 0-22.261-10.022-22.261-22.261s10.016-22.261 22.261-22.261h44.522v-44.522c0-12.239 10.016-22.261 22.261-22.261s22.261 10.022 22.261 22.261v44.522h44.522c12.245 0 22.261 10.021 22.261 22.261z" fill="#000000" opacity="1" data-original="#000000" class=""></path></g></svg></button>
                                            @endcan
                                        </div>
                                        <div class="col-auto px-1">
                                            <a href="{{ route('staff.print') }}" class="printbtn btn h-10 col"  id="print-button"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M422.5 99V75c0-41.355-33.645-75-75-75h-184c-41.355 0-75 33.645-75 75v24zM118.5 319v163c0 16.568 13.431 30 30 30h214c16.569 0 30-13.432 30-30V319zm177 128h-80c-8.284 0-15-6.716-15-15s6.716-15 15-15h80c8.284 0 15 6.716 15 15s-6.716 15-15 15zm0-64h-80c-8.284 0-15-6.716-15-15s6.716-15 15-15h80c8.284 0 15 6.716 15 15s-6.716 15-15 15z" fill="#000000" opacity="1" data-original="#000000"></path><path d="M436.5 129h-361c-41.355 0-75 33.645-75 75v120c0 41.355 33.645 75 75 75h13v-80h-9c-8.284 0-15-6.716-15-15s6.716-15 15-15h352c8.284 0 15 6.716 15 15s-6.716 15-15 15h-9v80h14c41.355 0 75-33.645 75-75V204c0-41.355-33.645-75-75-75zm-309 94h-48c-8.284 0-15-6.716-15-15s6.716-15 15-15h48c8.284 0 15 6.716 15 15s-6.716 15-15 15z" fill="#000000" opacity="1" data-original="#000000"></path></g></svg></a>
                                        </div>
                                        <div class="col-auto pl-1">
                                            <a href="{{ route('staff.export')}}" class="excelbtn btn h-10 col"  id="excel-button"><svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 26 26" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M25.162 3H16v2.984h3.031v2.031H16V10h3v2h-3v2h3v2h-3v2h3v2h-3v3h9.162c.461 0 .838-.391.838-.87V3.87c0-.479-.377-.87-.838-.87zM24 20h-4v-2h4v2zm0-4h-4v-2h4v2zm0-4h-4v-2h4v2zm0-4h-4V6h4v2zM0 2.889v20.223L15 26V0L0 2.889zM9.488 18.08l-1.745-3.299c-.066-.123-.134-.349-.205-.678h-.027a5.135 5.135 0 0 1-.234.707l-1.751 3.27H2.807l3.228-5.064-2.953-5.065h2.776l1.448 3.037c.113.24.214.525.304.854h.028c.057-.198.163-.492.318-.883l1.61-3.009h2.542l-3.037 5.022 3.122 5.107-2.705.001z" style="" fill="#030104" data-original="#030104" class=""></path></g></svg>
</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class=" fixed_Search">
                                {{$dataTable->table(['class' => 'table dt-responsive', 'style' => 'width:100%;','id'=>'dataaTable'])}}
                            </div>
                        </div>
                </div>
            <div class="popup_render_div"></div>
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


<script>
$(document).ready(function () {
    var DataaTable = $('#dataaTable').DataTable();
    $('#print-button').printPage();
    // Create Form

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

    $("body").on("click", ".edit-users-btn", function () {
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


    $(document).on('submit', '#AddForm', function (e) {
        e.preventDefault();

        $("#AddForm button[type=submit]").prop('disabled',true);
        $(".error").remove();
        $(".is-invalid").removeClass('is-invalid');
        var formData = $(this).serialize();
        var formAction = $(this).attr('action');
        $.ajax({
            url: '{{ route('staff.store') }}',
            type: 'POST',
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            success: function (response) {
                    $('#centerModal').modal('hide');
                    var alertType = response['alert-type'];
                    var message = response['message'];
                    var title = "{{ trans('quickadmin.users.users') }}";
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
                    var title = "{{ trans('quickadmin.users.users') }}";
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
                    var title = "{{ trans('quickadmin.users.users') }}";
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
                    var title = "{{ trans('quickadmin.users.users') }}";
                    showToaster(title,alertType,message);
                    DataaTable.ajax.reload();
                    // location.reload();

            },
            error: function (xhr) {
                // Handle error response
                swal("{{ trans('quickadmin.users.users') }}", 'some mistake is there.', 'error');
            }
            });
        }
        });
    });




});



</script>
@endsection
