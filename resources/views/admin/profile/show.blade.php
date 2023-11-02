@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('title')@lang('quickadmin.users.profile') @endsection
@section('customCss')
<meta name="csrf-token" content="{{ csrf_token() }}" >
@endsection

@section('main-content')

<section class="section">
    <div class="section-body">
      <div class="row mt-sm-4">
        <div class="col-12 col-md12 col-lg6">
          <div class="card">
            <div class="row mt-sm-4 background-imagebody chooseFileGroup px-4">
                <div class="col-md8 col-12 col-lg8 boxcenter">
                    <form id="EditProfileImageForm" method="post" enctype="multipart/form-data" action="{{route('profile-image.update')}}">
                    <input type="file" id="profile_image" name="profile_image" hidden>

                    <label for="profile_image" class="row author-box align-items-center gap-4 " id="profile_error">
                        <div class="col-auto px-1">
                            <div class="rounded-circle author-box-picture box-center shadow-none">
                                <img alt="image" src=" {{ $user->profile_image_url ? $user->profile_image_url : asset('admintheme/assets/img/user.png') }}" alt="profile" class="w-100 h-100 rounded-circle profile-image" >
                            </div>
                        </div>
                        <div class="col px-1">
                            <div class="page-inner box-center text-left align-center">
                                <div class="profileName"><a href="#" class="text-dark">{{ $user->name }}</a></div>
                                <div class="edit_profile btn-outline-primary btn">@lang('quickadmin.profile.change')</div>
                            </div>
                        </div>
                    </label>

                    </form>
                </div>
            </div>
            <div class="card-header d-flex justify-content-between align-items-center" id="userhead">
              <h4>@lang('quickadmin.profile.fields.personal_detail')</h4>
              <a role="button" class="text-info" id="editButton"><i class="fas fa-edit"></i> @lang('quickadmin.qa_edit')</a>
            </div>
            <div class="card-body" id="userbody">
              <div class="py-4">
                <p class="clearfix">
                  <span class="float-left">
                    @lang('quickadmin.profile.fields.name')
                  </span>
                  <span class="float-right text-muted">
                    {{ $user->name }}
                  </span>
                </p>
                <p class="clearfix">
                  <span class="float-left">
                    @lang('quickadmin.profile.fields.usernameid')
                  </span>
                  <span class="float-right text-muted">
                    {{ $user->username }}
                  </span>
                </p>
                <p class="clearfix">
                  <span class="float-left">
                    @lang('quickadmin.profile.fields.email')
                  </span>
                  <span class="float-right text-muted">
                    {{ $user->email }}
                  </span>
                </p>
                <p class="clearfix">
                  <span class="float-left">
                    @lang('quickadmin.profile.fields.phone')
                  </span>
                  <span class="float-right text-muted">
                    {{ $user->phone ?? '' }}
                  </span>
                </p>
                <p class="clearfix">
                  <span class="float-left">
                    @lang('quickadmin.profile.fields.address')
                  </span>
                  <span class="float-right text-muted">
                    {{ $user->address->address ?? ''}}
                  </span>
                </p>
              </div>
            </div>

            <div class="card-header" id="edithead">
                <h4>@lang('quickadmin.profile.edit_profile') </h4>
              </div>
              <div class="card-body" id="editbody">
                  <form method="POST" action="{{route('profile.update')}}" id="EditprofileForm">
                      @csrf
                      <div class="form-group">
                          <label for="currentpassword">@lang('quickadmin.profile.fields.name')</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                <i class="fas fa-user"></i>
                              </div>
                            </div>
                            <input type="text" value="{{ old('name',$user->name) }}" id="name" class="form-control  @error('name') is-invalid @enderror" name="name" tabindex="1"   autofocus>
                            @error('name')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                            @enderror
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="password">@lang('quickadmin.profile.fields.usernameid')</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                <i class="fas fa-lock"></i>
                              </div>
                            </div>
                            <input type="text" value="{{ old('username',$user->username) }}" id="username" class="form-control  @error('username') is-invalid @enderror" name="username" tabindex="1"   autofocus>
                            @error('username')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                            @enderror
                          </div>
                      </div>
                      <div class="form-group">
                          <label for="email">@lang('quickadmin.profile.fields.email')</label>
                          <div class="input-group">
                            <div class="input-group-prepend">
                              <div class="input-group-text">
                                <i class="fas fa-envelope"></i>
                              </div>
                            </div>
                            <input type="email" value="{{ old('email',$user->email) }}" id="email" class="form-control @error('email') is-invalid @enderror" name="email" tabindex="1"   autofocus>
                            @error('email')
                            <div class="invalid-feedback">
                              {{ $message }}
                            </div>
                            @enderror
                          </div>
                      </div>
                      <div class="form-group">
                        <label for="phone">@lang('quickadmin.profile.fields.phone')</label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <div class="input-group-text">
                              <i class="fas fa-phone"></i>
                            </div>
                          </div>
                          <input type="text" value="{{ old('phone',$user->phone) }}" id="phone" class="form-control @error('phone') is-invalid @enderror" name="phone" tabindex="1"   autofocus>
                          @error('phone')
                          <div class="invalid-feedback">
                            {{ $message }}
                          </div>
                          @enderror
                        </div>
                    </div>
                      <div class="form-group">
                        <label>@lang('quickadmin.profile.fields.address')</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-map-marker-alt"></i>
                                </div>
                                </div>
                                <select class="form-control select2 @error('address_id') is-invalid @enderror" name="address_id" id="address_id" value={{ old('address_id')}}>
                                    @foreach($addresses as $address)
                                    <option value="{{ $address->id }}" {{ old('address_id', $user->address_id) == $address->id ? 'selected' : '' }}>
                                        {{ $address->address }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('address_id')
                                <div class="invalid-feedback">
                                {{ $message }}
                                </div>
                                @enderror
                          </div>
                      </div>

                      <div class="form-group">
                      <button type="submit" class="btn btn-auth-color btn-lg btn-block" tabindex="4">
                          @lang('quickadmin.qa_submit')
                      </button>
                      </div>
                  </form>
              </div>
          </div>

        </div>

      </div>

    </div>
  </section>



@endsection

@section('customJS')
<script>
$(document).ready(function() {
    $('#edithead, #editbody').hide();

    $('#profile_image').change(function(e) {
        e.preventDefault();
        $('#profile_error + div').empty().remove();
        console.log('hello');
        //var formData = $(this).serialize();
        var file = $(this).prop('files')[0];
        $(".error").remove();
        var selectedFile = this.files[0];

        var formData = new FormData($('#EditProfileImageForm')[0]);
        // formData.append('profile_image', selectedFile);
        var formAction = $('#EditProfileImageForm').attr('action');
        console.log(formData);
        console.log(formAction);
        $.ajax({
            url: formAction,
            type: 'POST',
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: formData,
            contentType: false,
            processData: false,
            success: function (response) {
                    var alertType = response['alert-type'];
                    var message = response['message'];
                    var title = response['title'];
                    showToaster(title,alertType,message);
                    $('#EditprofileForm')[0].reset();
                    location.reload();
            },
            error: function (xhr) {
                var errors= xhr.responseJSON.errors;
                console.log(xhr.responseJSON);
                console.log(2);
                var errorHtml = '<p class="error text-danger" style="line-height: 1;">';
                for (const elementId in errors) {
                    for (const error of errors[elementId]) {
                        errorHtml += error + '<br>';
                    }
                }
                errorHtml += '</p>';
                $(errorHtml).insertAfter($("#profile_error"));
            }
        });
    });

});

$('#editButton').click(function() {
                $('#userhead').removeClass('d-flex');
                $('#userhead, #userbody').hide();
                $('#edithead, #editbody').show();
});

$('#EditprofileForm').on('submit', function (e) {
        e.preventDefault();

        $("#EditprofileForm button[type=submit]").prop('disabled',true);
        $(".error").remove();
        $(".is-invalid").removeClass('is-invalid');
        var formData = $(this).serialize();
        var formAction = $(this).attr('action');
        console.log(formAction);

        $.ajax({
            url: formAction,
            type: 'POST',
            headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
            data: formData,
            success: function (response) {
                    var alertType = response['alert-type'];
                    var message = response['message'];
                    var title = response['title'];
                    showToaster(title,alertType,message);
                    $('#EditprofileForm')[0].reset();
                    location.reload();
            },
            error: function (xhr) {
                var errors= xhr.responseJSON.errors;
                console.log(xhr.responseJSON);

                for (const elementId in errors) {
                    $("#EditprofileForm #"+elementId).addClass('is-invalid');
                    var errorHtml = '<div><span class="error text-danger">'+errors[elementId]+'</span></';
                    $(errorHtml).insertAfter($("#EditprofileForm #"+elementId).parent());
                }
                $("#EditprofileForm button[type=submit]").prop('disabled',false);
            }
        });
});




</script>


@endsection
