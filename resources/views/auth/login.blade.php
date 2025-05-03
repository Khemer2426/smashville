@extends('layouts.auth')

@section('content')
  <div class="w-100">
    <!-- Header -->
    <div class="text-center mb-5">
      <h1 class="fw-bold text-primary mb-2">
        Sign In
      </h1>
      <p class="fw-medium text-muted">
        Welcome, please login</a>.
      </p>
    </div>
    <!-- END Header -->

    <div class="row g-0 justify-content-center">
      <div class="col-sm-8 col-xl-4">
        
        @include('layouts.alert')

        <form class="js-validation" action="{{ route('login') }}" method="post">
          {{ csrf_field() }}

          <div class="form-floating mb-4">
            <input type="text" class="form-control {{ $errors->has('username') ? ' is-invalid' : '' }}" id="username" name="username" placeholder="Username" required>
            <label for="username">Username</label>
            @if ($errors->has('username'))
                <div class="invalid-feedback">@lang($errors->first('username'))</div>
            @endif
          </div>
          
          <div class="form-floating mb-4">
            <input type="password" class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" id="password" name="password" placeholder="Password" required>
            <label for="password">Password</label>
            @if ($errors->has('password'))
                <div class="invalid-feedback">@lang($errors->first('password'))</div>
            @endif
          </div>

          <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
              <button type="submit" class="btn btn-lg btn-primary">
                <i class="fa fa-fw fa-sign-in-alt me-1 opacity-50"></i> Sign In
              </button>
            </div>
          </div>
        </form>
      </div>
    </div>
    <!-- END Sign In Form -->
  </div>
@endsection