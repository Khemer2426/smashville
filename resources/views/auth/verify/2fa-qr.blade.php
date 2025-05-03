@extends('layouts.auth')

@section('content')
  <div class="w-100 px-5">
    <!-- Header -->
    <div class="text-center mb-5">
      <h1 class="fw-bold text-primary mb-2">
        Two-Factor Authentication
      </h1>
      <p class="fw-medium text-muted">
        <p class="text-center">@lang('Please scan the QR code below using any authenticator app of your choice such as Authy, Google Authenticator, LastPass Authenticator. You can download these from Google Play and App Store.')</p>
        <p class="text-center">@lang('After scanning the QR code, input the verification code that appears in your authenticator.')</p>
      </p>
    </div>
    <!-- END Header -->

    <div class="row g-0 justify-content-center">
      <div class="col-sm-8 col-xl-4">
        @include('layouts.alert')

        <div class="text-center">
            <img src="{{ $data['qrCodeUrl'] }}" alt="">
            <p>@lang('Secret Key'): {{ $data['secret'] }}</p>

            <form action="{{ route('profile.enable.tfa', $data['secret']) }}" method="POST" class="js-validation">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                <label for="code" class="form-label">@lang('Verification code')</label>
                <input type="text" class="form-control form-control-lg form-control-alt py-3 tfa_code" id="code" name="code" placeholder="Verification code" autocomplete="off" required>
                </div>

                <button type="submit" class="btn btn-lg btn-primary">
                <i class="fa fa-fw fa-sign-in-alt me-1 opacity-50"></i> @lang('Continue')
                </button>
            </form>
            {{-- <a href="{{ auth()->user() ? route('user.account.profile') : route('user.login.form') }}" class="btn btn-primary">@lang("I'm done scanning the QR")</a> --}}
        </div>
      </div>
    </div>
  </div>
@endsection