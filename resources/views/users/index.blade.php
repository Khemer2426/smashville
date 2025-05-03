@extends('layouts.backend')

@section('content')

    @include('components.page-title', [
        'page_title' => 'Users',
    ])

    <div class="content">
        @include('layouts.alert')
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">Users</h3>
                <div class="block-options">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-user-modal">Create User</button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-users">
                    <thead>
                        <tr>
                            <th>Surname & Name</th>
                            <th>Username</th>
                            <th>Job Role</th>
                            <th>Active</th>
                            <th style="width: 250px">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        @include('components.users.create')
    </div>
@endsection

@section('js')
  @vite(['resources/js/pages/users/users.datatables.js'])
@endsection