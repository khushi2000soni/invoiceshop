@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('title')@lang('quickadmin.category.title')@endsection
@section('customCss')
<meta name="csrf-token" content="{{ csrf_token() }}" >
@endsection

@section('main-content')

<section class="section roles" style="z-index: unset">
    <div class="section-header ">
      <h1> @lang('quickadmin.category.title')</h1>
      <div class="section-header-breadcrumb ">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">@lang('quickadmin.qa_dashboard')</a></div>
        <div class="breadcrumb-item">@lang('quickadmin.category.list-title')</div>
      </div>
    </div>
    <div class="section-body">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>@lang('quickadmin.category.list-title')</h4>
                  @can('category_create')
                  <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#centerModal"><i class="fas fa-plus"></i> @lang('quickadmin.roles.fields.add')</button>
                  @endcan
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    {{$dataTable->table(['class' => 'table dt-responsive', 'style' => 'width:100%;','id'=>'categoryTable'])}}
                  </div>
                </div>
              </div>

              <div class="modal fade px-3" id="centerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalCenterTitle">@lang('quickadmin.category.fields.add')</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" id="AddCategoryForm" action="">
                                @include('admin.category.form')
                                </form>
                                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal fade px-3" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editModalCenterTitle">@lang('quickadmin.category.fields.edit')</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <form method="post" id="EditCategoryForm" action="route('categories.update')">
                                @include('admin.category.form')
                                </form>
                                {{-- <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button> --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>

          {{-- @dd(session()->all()) --}}

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
    var categoryDataTable = $('#categoryTable').DataTable();


    $("body").on("click", ".edit-category-btn", function () {
            let editAddressId;
            editId = $(this).data('id');
            let editName = $(this).data('name');
            console.log(editName);
            let form = $('#EditCategoryForm');
            let formAction = "{{ route('categories.update', ':id') }}"; // Define the route
            formAction = formAction.replace(':id', editId);
            form.attr('action', formAction);
            $(document).find('#EditCategoryForm #name').val(editName);

            $('#editCategoryModal').modal('show');
    });

    $('#AddCategoryForm').on('submit', function (e) {
        e.preventDefault();

        $("#AddCategoryForm button[type=submit]").prop('disabled',true);
        $(".error").remove();
        $(".is-invalid").removeClass('is-invalid');
        var formData = $(this).serialize();

        $.ajax({
            url: '{{ route('categories.store') }}',
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

    $('#EditCategoryForm').on('submit', function (e) {
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
