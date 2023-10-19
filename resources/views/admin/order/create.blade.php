@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('title')@lang('quickadmin.order.create_new_order') @endsection
@section('customCss')
<meta name="csrf-token" content="{{ csrf_token() }}" >
@endsection

@section('main-content')

<section class="section">
    <div class="section-header ">
      <h1>@lang('quickadmin.order.create_new_order')</h1>
      <div class="section-header-breadcrumb ">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">@lang('quickadmin.qa_dashboard')</a></div>
        <div class="breadcrumb-item"><a href="{{ route('orders.index') }}">@lang('quickadmin.order.list')</a></div>
        <div class="breadcrumb-item">@lang('quickadmin.order.new_order')</div>
      </div>
    </div>
    <div class="section-body">
        <form>
            <div class="invoice">
                <div class="invoice-print">
                <div class="row">
                    <div class="col-lg-12">
                        <h3>@lang('quickadmin.order.new_order')</h3>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                @include('admin.order.form')
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover table-md">
                        <tr>
                            <th data-width="40">@lang('quickadmin.qa_sn')</th>
                            <th>@lang('quickadmin.order.fields.product_name')</th>
                            <th class="text-center">@lang('quickadmin.order.fields.product_name')</th>
                            <th class="text-center">@lang('quickadmin.order.fields.quantity')</th>
                            <th class="text-right">@lang('quickadmin.order.fields.sub_total')</th>
                            <th class="text-right">@lang('quickadmin.qa_action')</th>
                        </tr>
                        <tr>
                            <td>1</td>
                            <td>Card Reader</td>
                            <td class="text-center">$15.00</td>
                            <td class="text-center">2</td>
                            <td class="text-right">$30.00</td>
                            <td class="text-right">
                                <a href="" class="btn btn-dark btn-sm">@lang('quickadmin.qa_copy')</a>
                                <a href="" class="btn btn-info btn-sm">@lang('quickadmin.qa_edit')</a>
                                <a href="" class="btn btn-danger btn-sm">@lang('quickadmin.qa_delete')</a>
                            </td>
                        </tr>
                        </table>
                    </div>
                    <div class="row mt-4">
                        <div class="col-lg-8">
                            <div class="custom-control custom-checkbox pt-4">
                                <input type="checkbox" class="custom-control-input" id="is_round_off">
                                <label class="custom-control-label" for="is_round_off">@lang('quickadmin.order.fields.round_off')</label>
                            </div>
                        </div>
                        <div class="col-lg-4 text-right">
                        <div class="invoice-detail-item">
                            <div><span class="invoice-detail-value">@lang('quickadmin.order.fields.thaila') : </span> <span class="px-2">0.00</span></div>
                        </div>
                        <div class="invoice-detail-item">
                            <div><span class="invoice-detail-value">@lang('quickadmin.order.fields.round_off') : </span> <span class="px-2">0.00</span></div>
                        </div>
                        <hr class="mt-2 mb-2">
                        <div class="invoice-detail-item">
                            <div><span class="invoice-detail-value">@lang('quickadmin.order.fields.ground_total') : </span> <span class="px-2">$1530.00</span></div>
                        </div>
                        </div>
                    </div>
                    </div>
                </div><hr>
                <div class="row mt-4">
                    <div class="text-md-right">
                        <div class="float-lg-left">
                            <button class="btn btn-success btn-icon icon-left"><i class="fas fa-credit-card"></i>@lang('quickadmin.qa_save_invoice')</button>
                            {{-- <button class="btn btn-light btn-icon icon-left"><i class="fas fa-print"></i>@lang('quickadmin.qa_print_invoice')</button> --}}
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </form>
    </div>
  </section>
@endsection

@section('customJS')
  @include('admin.order.partials.script')
@endsection
