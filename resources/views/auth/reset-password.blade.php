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
                <h4>@lang('quickadmin.qa_reset_password')</h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <div class="form-group">
                        <label for="password">@lang('quickadmin.qa_new_password')</label>
                        <input id="password" type="password" class="form-control pwstrength" data-indicator="pwindicator"
                            name="password" tabindex="2" required>
                        <div id="pwindicator" class="pwindicator">
                            <div class="bar"></div>
                            <div class="label"></div>
                        </div>
                        </div>
                        <div class="form-group">
                        <label for="password-confirm">@lang('quickadmin.qa_confirm_password')</label>
                        <input id="password-confirm" type="password" class="form-control" name="confirm-password"
                            tabindex="2" required>
                        </div>
                        <div class="form-group">
                        <button type="submit" class="btn btn-auth-color btn-lg btn-block" tabindex="4">
                            @lang('quickadmin.qa_reset_password')
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
