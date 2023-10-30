@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('title')@lang('quickadmin.settings.manage_settings')@endsection
@section('customCss')
<meta name="csrf-token" content="{{ csrf_token() }}" >
@endsection

@section('main-content')

<section class="section roles" style="z-index: unset">
    <div class="section-header ">
      <h1> @lang('quickadmin.settings.manage_settings')</h1>
      <div class="section-header-breadcrumb ">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">@lang('quickadmin.qa_dashboard')</a></div>
        <div class="breadcrumb-item">@lang('quickadmin.settings.manage_settings')</div>
      </div>
    </div>
    <div class="section-body">
          <div class="row">
            <div class="col-12 col-sm-12 col-lg-12">
                <div class="card">
                  <div class="card-header">
                    <h4>@lang('quickadmin.settings.manage_settings')</h4>
                  </div>
                  <div class="card-body">
                    @if($allSettingType)
                    <!-- Step form tab menu -->
                    <ul class="nav nav-pills" id="myTab3" role="tablist">
                    @foreach ($allSettingType as $key=>$groupType)
                        @php
                            $groupName = str_replace('_',' ',$groupType)
                        @endphp
                        <li class="nav-item">
                            <a class="nav-link {{ $tab == $groupType  ? 'active' : '' }}" id="{{$groupType}}" data-toggle="tab" href="{{ route('settings', ['tab' => $groupType]) }}" role="tab"
                            aria-controls="{{$groupType}}" aria-selected="{{ $tab == $groupType  ? true : false }}">{{ ucwords($groupName) }}</a>
                        </li>
                    @endforeach
                    </ul>
                    @endif

                    <div class="tab-content" id="myTabContent2">
                        @foreach ($allSettingType as $groupType)
                        <div class="tab-pane fade {{ $tab == $groupType ? 'show active' : '' }}" id="{{ $groupType }}" role="tabpanel" aria-labelledby="{{ $groupType }}-tab">
                            @include('admin.setting.form')
                        </div>
                        @endforeach
                    </div>
                  </div>
                </div>
              </div>
          </div>
    </div>
  </section>
@endsection


@section('customJS')
<script src="{{ asset('admintheme/assets/bundles/jquery-ui/jquery-ui.min.js') }}"></script>

<script>
$(document).ready(function(){
    $(document).on('submit','#settingform',function(e){
        e.preventDefault();
        $("#settingform button[type=submit]").prop('disabled',true);
        $(".error").remove();
        $(".is-invalid").removeClass('is-invalid');

        var formData = new FormData(this);
        var formAction = $(this).attr('action');
        console.log(formAction);

        $.ajax({
            type: "POST",
            url: formAction,
            data: formData, // Choose the appropriate formData here
            processData: false,
            contentType: false,
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                    var alertType = response['alert-type'];
                    var message = response['message'];
                    var title = "{{ trans('quickadmin.settings.title') }}";
                    showToaster(title,alertType,message);
                    $('#settingform')[0].reset();
                    location.reload();
                    $("#settingform button[type=submit]").prop('disabled',false);
            },
            error: function (xhr) {
                var errors= xhr.responseJSON.errors;
                console.log(xhr.responseJSON);

                for (const elementId in errors) {
                    $("#settingform #"+elementId).addClass('is-invalid');
                    var errorHtml = '<div><span class="error text-danger">'+errors[elementId]+'</span></';
                    $(errorHtml).insertAfter($("#settingform #"+elementId).parent());
                }
                $("#settingform button[type=submit]").prop('disabled',false);
            }
        });
    });
});
</script>




@endsection
