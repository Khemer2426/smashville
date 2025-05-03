@extends('layouts.backend')

@section('content')

    @include('components.page-title', [
        'page_title' => 'Profile'
    ])

    <div class="content">
        @include('layouts.alert')
        <!-- <form action="{{-- route('admin.profile.update') --}}" method="post" class="js-validation">
            @csrf -->
            <div class="row">
                <div class="col-lg-8 col-xl-5">
                    <div class="block block-rounded">
                        <div class="block-content block-content-full">
                            <div class="mb-4">
                                <div class="form-group">
                                    <label for="username" class="form-label">Username</label>
                                    <input type="text" class="form-control  form-control-alt" id="username" value="{{ $userVM->username }}" disabled>
                                </div>
                            </div>
                        </div>
                        <div class="border-top p-3 d-flex gap-3">
                            <!-- <button type="submit" class="btn btn-primary me-3">Update Profile</button> -->
                            <div class="d-flex flex-wrap align-items-center justify-content-between flex-grow-1">
                                <!-- <a href="{{ route('profile.password') }}" class="text-muted fs-sm fw-medium d-lg-inline-block ml-3 mb-1">Change Password</a> -->
                                @if (config('google2fa.enabled'))
                                    <a href="#" class="text-muted fs-sm fw-medium d-lg-inline-block" data-bs-toggle="modal" data-bs-target="#tfa-modal">{{ !empty(auth()->user()->tfa_secret) && auth()->user()->tfa_notified == 1 ? 'Disable Two-Factor Authenticator' : 'Enable Two-Factor Authenticator' }}</a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <!-- </form> -->
    </div>

    @include('components.modals.tfa-modal', [
        'route' => !empty(auth()->user()->tfa_secret) ? route('profile.disable.tfa') : route('profile.tfa.generate')
    ])
@endsection

@section('js')
    @vite(['resources/js/password-toggle.js'])
    
    @if (session('tfa_error'))
        <script>
            $(document).ready(function() {
                $('#tfa-modal').modal('show');
            });
        </script>
    @endif
@endsection