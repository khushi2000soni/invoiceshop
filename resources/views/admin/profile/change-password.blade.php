@inject('request', 'Illuminate\Http\Request')
@extends('layouts.app')
@section('title')@lang('quickadmin.qa_change_password') @endsection
@section('customCss')
<meta name="csrf-token" content="{{ csrf_token() }}" >
@endsection

@section('main-content')

<section class="section">
    <div class="section-header ">
      <h1>@lang('quickadmin.qa_change_password')</h1>
      <div class="section-header-breadcrumb ">
        <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">@lang('quickadmin.qa_dashboard')</a></div>
        <div class="breadcrumb-item">@lang('quickadmin.qa_change_password')</div>
      </div>
    </div>
    <div class="section-body">
      <div class="row mt-sm-4">
        <div class="col-12 col-md-12 col-lg-8">
          <div class="card">
            <div class="padding-20">
                  <form method="post" class="needs-validation">
                    <div class="card-header">
                      <h4>@lang('quickadmin.qa_reset_password') </h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{route('reset-new-password')}}">
                            @csrf
                            <div class="form-group">
                                <label for="currentpassword">@lang('quickadmin.qa_current_password')</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text">
                                      <i class="fas fa-lock"></i>
                                    </div>
                                  </div>
                                  <input type="password" value="{{ old('password') }}" id="currentpassword" class="form-control  @error('currentpassword') is-invalid @enderror" name="currentpassword" tabindex="1"   autofocus>
                                  @error('currentpassword')
                                  <div class="invalid-feedback">
                                    {{ $message }}
                                  </div>
                                  @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password">@lang('quickadmin.qa_new_password')</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text">
                                      <i class="fas fa-lock"></i>
                                    </div>
                                  </div>
                                  <input type="password" value="{{ old('password') }}" id="password" class="form-control  @error('password') is-invalid @enderror" name="password" tabindex="1"   autofocus>
                                  @error('password')
                                  <div class="invalid-feedback">
                                    {{ $message }}
                                  </div>
                                  @enderror
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="password-confirm">@lang('quickadmin.qa_confirm_password')</label>
                                <div class="input-group">
                                  <div class="input-group-prepend">
                                    <div class="input-group-text">
                                      <i class="fas fa-lock"></i>
                                    </div>
                                  </div>
                                  <input type="password" value="{{ old('password_confirmation') }}" id="password-confirm" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" tabindex="1"   autofocus>
                                  @error('password_confirmation')
                                  <div class="invalid-feedback">
                                    {{ $message }}
                                  </div>
                                  @enderror
                                </div>
                            </div>

                            <div class="form-group">
                            <button type="submit" class="btn btn-auth-color btn-lg btn-block" tabindex="4">
                                @lang('quickadmin.qa_change_password')
                            </button>
                            </div>
                        </form>
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
$('#roleForm').on('submit', function (e) {
    e.preventDefault();

    $("button[type=submit]").prop('disabled',true);
    var formData = $(this).serializeArray();

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
            console.log(xhr.responseJSON);

            for (const elementId in errors) {
                $("#"+elementId).addClass('is-invalid');
                var errorHtml = '<div><span class="error text-danger">'+errors[elementId]+'</span></';
                $(errorHtml).insertAfter($("#"+elementId).parent());
            }
            $("button[type=submit]").prop('disabled',false);
        }
    });
});

</script>

<script>
    var selectedPermissions = [];
    $(document).on('click', '.permission-checkbox', function() {
        var permissionId = $(this).val();
        if ($(this).is(':checked')) {
            // If the checkbox is checked, add the ID to the array
            if (selectedPermissions.indexOf(permissionId) === -1) {
                selectedPermissions.push(permissionId);
            }
        } else {
            // If the checkbox is unchecked, remove the ID from the array
            var index = selectedPermissions.indexOf(permissionId);
            if (index !== -1) {
                selectedPermissions.splice(index, 1);
            }
        }

        console.log('Selected Permission IDs:', selectedPermissions);
        $('#selectedPermissions').val(selectedPermissions);
    });
</script>
@endsection
