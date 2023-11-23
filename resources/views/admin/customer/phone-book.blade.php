@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('title')@lang('quickadmin.phone-book.title')@endsection
@section('customCss')
<meta name="csrf-token" content="{{ csrf_token() }}" >
@endsection

@section('main-content')

<section class="section roles" style="z-index: unset">

    <div class="section-body">
          <div class="row">
            <div class="col-12">
              <div class="card">
                {{-- <div class="card-header d-flex justify-content-between align-items-center">
                  <h4>@lang('quickadmin.phone-book.fields.list')</h4>
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
                                </div>
                            </div>
                        </div>
                    </form>
                  <div class="table-responsive">
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

    $('#reset-filter').on('click', function(e) {
        e.preventDefault();
        $('#citiwise-filter-form')[0].reset();

        DataaTable.ajax.url("{{ route('showPhoneBook') }}").load();
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
        // Apply filters to the DataTable
        DataaTable.ajax.url("{{ route('showPhoneBook') }}?"+$.param(params)).load();

    });

});
</script>

@endsection
