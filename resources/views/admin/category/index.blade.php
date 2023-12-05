@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('title')@lang('quickadmin.category.title')@endsection
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
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <div class="row align-items-center w-100 mx-0">
                            <div class="col pl-0">
                                <h4>@lang('quickadmin.category.list-title')</h4>
                            </div>
                            <div class="col-auto pe-0">
                                <div class="row align-items-center">
                                    <div class="col-auto px-1">
                                        @can('category_create')
                                        <button type="button" class="btn btn-outline-dark addRecordBtn sm_btn" data-toggle="modal" data-target="#centerModal" data-href="{{ route('categories.create')}}"><i class="fas fa-plus"></i> @lang('quickadmin.roles.fields.add')</button>
                                    @endcan
                                    </div>
                                    <div class="col-auto px-1">
                                        <a href="{{ route('categories.print') }}" class="btn h-10 btn-success mr-1 col"  id="print-button">@lang('quickadmin.qa_print')</a>
                                    </div>
                                    <div class="col-auto pl-1 pr-0">
                                        <a href="{{ route('categories.export')}}" class="btn h-10 btn-warning mr-1 col"  id="excel-button">@lang('quickadmin.qa_excel')</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                    <div class="table-responsive fixed_Search">
                        {{$dataTable->table(['class' => 'table dt-responsive subBodyTable', 'style' => 'width:100%;','id'=>'categoryTable'])}}
                    </div>
                    </div>
                </div>
            </div>
        </div>
          {{-- @dd(session()->all()) --}}
        </div>
  </section>
  <div class="popup_render_div"></div>
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
    var categoryDataTable = $('#categoryTable').DataTable();

    $('#print-button').printPage();

    $(document).on('click' , 'excel-button' , function(e){
        e.preventDefault();
        var iframe = document.createElement('iframe');
        console.log('iframe');
        iframe.style.display = 'none';
        iframe.src = '/categories-export'; // Replace with the actual URL for your export route
        document.body.appendChild(iframe);
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

    $("body").on("click", ".edit-category-btn", function () {
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
                        $('#editCategoryModal').modal('show');
                    }
                }
            });
    });


    $(document).on('submit', '#AddCategoryForm', function (e) {
        e.preventDefault();

        $("#AddCategoryForm button[type=submit]").prop('disabled',true);
        $(".error").remove();
        $(".is-invalid").removeClass('is-invalid');
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
                    $('#centerModal').modal('hide');
                    var alertType = response['alert-type'];
                    var message = response['message'];
                    var title = "{{ trans('quickadmin.category.category') }}";
                    showToaster(title,alertType,message);
                    $('#AddCategoryForm')[0].reset();
                   // location.reload();
                   categoryDataTable.ajax.reload();
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


    $(document).on('submit', '#EditCategoryForm', function (e) {
        e.preventDefault();

        $("#EditCategoryForm button[type=submit]").prop('disabled',true);
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
                    $('#editCategoryModal').modal('hide');
                    var alertType = response['alert-type'];
                    var message = response['message'];
                    var title = "{{ trans('quickadmin.category.category') }}";
                    showToaster(title,alertType,message);
                    $('#EditCategoryForm')[0].reset();
                    //location.reload();
                    categoryDataTable.ajax.reload();
                    $("#EditCategoryForm button[type=submit]").prop('disabled',false);
            },
            error: function (xhr) {
                var errors= xhr.responseJSON.errors;
                console.log(xhr.responseJSON);

                for (const elementId in errors) {
                    $("#EditCategoryForm #"+elementId).addClass('is-invalid');
                    var errorHtml = '<div><span class="error text-danger">'+errors[elementId]+'</span></';
                    $(errorHtml).insertAfter($("#EditCategoryForm #"+elementId).parent());
                }
                $("#EditCategoryForm button[type=submit]").prop('disabled',false);
            }
        });
    });


    $(document).on('submit', '.deleteCategoryForm', function(e) {
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
                    var title = "{{ trans('quickadmin.category.category') }}";
                    showToaster(title,alertType,message);
                    categoryDataTable.ajax.reload();
                    // location.reload();

            },
            error: function (xhr) {
                // Handle error response
                swal('Category', 'some mistake is there.', 'error');
            }
            });
        }
        });
    });




});



</script>
@endsection
