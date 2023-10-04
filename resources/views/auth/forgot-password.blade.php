@extends('layouts.auth')

@section('main-content')
<section class="section">
    <div class="container mt-5">
      <div class="row">
        <div class="col-12 col-sm-8 offset-sm-2 col-md-6 offset-md-3 col-lg-6 offset-lg-3 col-xl-4 offset-xl-4">
          <div class="login-brand login-brand-color">
              {{-- <img alt="image" src="{{ asset('admintheme/assets/img/logo.png') }}" /> --}}
            @lang('quickadmin.qa_company_name')
          </div>
          @include('admin.message')

          <div class="card">
                <div class="card-header card-header-auth">
                <h4>@lang('quickadmin.qa_forgot_password')</h4>
                </div>
                <!-- <center>
                <div class="logo-auth">
                    <img alt="image" src="assets/img/logo.png" />
                </div>
                <div>
                    <span class="logo-name-auth">Grexa</span>
                </div>
                </center> -->
                <div class="card-body">
                <p class="text-muted">@lang('quickadmin.qa_otp_line')</p>
                <form method="POST">
                    <div class="form-group">
                    <label for="email">@lang('quickadmin.qa_email')</label>
                    <input id="email" type="email" class="form-control" name="email" tabindex="1" required autofocus>
                    </div>
                    <div class="form-group">
                    <button type="submit" class="btn btn-lg btn-block btn-auth-color" tabindex="4">
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
