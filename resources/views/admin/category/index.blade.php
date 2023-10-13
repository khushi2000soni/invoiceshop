@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('title')@lang('quickadmin.roles.title') @endsection
@section('customCss')
<meta name="csrf-token" content="{{ csrf_token() }}" >
@endsection

@section('main-content')

<section class="section roles" style="z-index: unset">
    <div class="section-header ">
      <h1> @lang('quickadmin.roles.title')</h1>
      <div class="section-header-breadcrumb ">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">@lang('quickadmin.qa_dashboard')</a></div>
        <div class="breadcrumb-item">@lang('quickadmin.roles.fields.list-title')</div>
      </div>
    </div>
    <div class="section-body">
          <div class="row">
            <div class="col-12">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>@lang('quickadmin.roles.fields.list-title')</h4>
                  @can('role_create')
                  <button type="button" class="btn btn-outline-dark" data-toggle="modal" data-target="#centerModal"><i class="fas fa-plus"></i> @lang('quickadmin.roles.fields.add')</button>
                  @endcan
                </div>
                <div class="card-body">
                  <div class="table-responsive">

                    {{$dataTable->table(['class' => 'table dt-responsive', 'style' => 'width:100%;'])}}
                  </div>


                </div>
              </div>

              <div class="modal fade px-3" id="centerModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">@lang('quickadmin.roles.fields.add')</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <form method="post" id="roleForm" action="">
                            @include('admin.roles.form')
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
  <script src="{{ asset('admintheme/assets/bundles/izitoast/js/iziToast.min.js') }}"></script>
<script src="{{ asset('admintheme/assets/js/page/toastr.js') }}"></script>

<script>

$('#roleForm').on('submit', function (e) {
    e.preventDefault();

    $("button[type=submit]").prop('disabled',true);
    var formData = $(this).serialize();

    $.ajax({
        url: '{{ route('roles.store') }}',
        type: 'POST',
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
        data: formData,
        success: function (response) {
                $('#centerModal').modal('hide');
                var alertType = response['alert-type'];
                var message = response['message'];
                var title = "{{ trans('quickadmin.roles.role') }}";

                showToaster(title,alertType,message);

                $('#roleForm')[0].reset();
                location.reload();
        },
        error: function (xhr) {
            var errors= xhr.responseJSON.errors;
            console.log(errors['name'][0]);

           $('.invalid-feedback').html("");
            if (errors['name']) {
            $("button[type=submit]").prop('disabled',false);
            $("#name").addClass('is-invalid')
            .siblings('div')
            .addClass('invalid-feedback')
            .html(errors['name'][0]);
            } else {
            $("#name").removeClass('is-invalid')
            .siblings('div')
            .removeClass('invalid-feedback').html("");
            }
        }
    });
});


</script>
@endsection
