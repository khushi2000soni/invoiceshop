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
              <h4>@lang('quickadmin.qa_login')</h4>
            </div>
            <div class="card-body">
              <form method="POST" action=""  novalidate="">
                @csrf
                <div class="form-group">
                  <label for="username">@lang('quickadmin.qa_username')</label>
                  <input type="username" value="{{ old('username') }}" class="form-control @error('username') is-invalid @enderror" name="username" tabindex="1" required autofocus>
                  @error('username')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror

                </div>
                <div class="form-group">
                  <div class="d-block">
                    <label for="password" class="control-label">@lang('quickadmin.qa_password')</label>
                    <div class="float-right">
                        <a href="auth-forgot-password.html" class="text-small">
                            @lang('quickadmin.qa_forgot_password')
                        </a>
                    </div>
                  </div>
                  <input type="password" class="form-control  @error('password') is-invalid @enderror" name="password" tabindex="2" required>

                  @error('password')
                  <div class="invalid-feedback">
                    {{ $message }}
                  </div>
                  @enderror
                </div>

                <div class="form-group">
                    <div class="custom-control custom-checkbox">
                      <input type="checkbox" name="remember" class="custom-control-input" tabindex="3" id="remember-me">
                      <label class="custom-control-label" for="remember-me">@lang('quickadmin.qa_remember_me')</label>
                    </div>
                </div>
                <div class="form-group">
                  <button type="submit" class="btn btn-lg btn-block btn-auth-color" tabindex="4">
                    @lang('quickadmin.qa_login')
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
