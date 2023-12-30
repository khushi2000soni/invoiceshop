@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('title')@lang('quickadmin.report-management.title')@endsection
@section('customCss')
<meta name="csrf-token" content="{{ csrf_token() }}" >
@endsection

@section('main-content')

<section class="section roles" style="z-index: unset">
    <div class="section-body">
          <div class="row">

          </div>
    </div>
  </section>
@endsection


@section('customJS')

@endsection
