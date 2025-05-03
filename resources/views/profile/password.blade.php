@extends('layouts.backend')

@section('content')

    @include('components.page-title', [
        'page_title' => 'Change Password'
    ])

    <div class="content">
        <div class="row">
            <div class="col-lg-8 col-xl-5">
                @include('layouts.alert')
                
                @include('components.change-password', ['action' => route('profile.change.password')])
            </div>
        </div>
    </div>
@endsection
