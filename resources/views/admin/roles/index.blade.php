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
                  <a href="{{route('roles.create')}}" class="btn btn-outline-primary" ><i class="fas fa-plus"></i> @lang('quickadmin.roles.fields.add')</a>
                  @endcan
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    {{$dataTable->table(['class' => 'table dt-responsive', 'style' => 'width:100%;'])}}
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
<script src="{{ asset('admintheme/assets/js/page/datatables.js') }}"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const urlParams = new URLSearchParams(window.location.search);
        const alertType = urlParams.get('alert_type');
        const alertMessage = urlParams.get('message');
        const alerttile = urlParams.get('title');

        if (alertType && alertMessage) {
            showToaster(alerttile,alertType,alertMessage);
        }
    });
</script>

@endsection
