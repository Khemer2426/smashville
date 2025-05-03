@extends('layouts.backend')

@section('content')

    @include('components.page-title', [
        'page_title' => 'Comments',
    ])

    <div class="content">
        @include('layouts.alert')
        <div class="block block-rounded">
            <div class="block-header block-header-default">
                <h3 class="block-title">All Comments</h3>
                <div class="block-options">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#add-comment-modal">Add Comment</button>
                </div>
            </div>
            <div class="block-content block-content-full">
                <table class="table table-bordered table-striped table-users">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Surname & Name</th>
                            <th>Title</th>
                            <th>Comments</th>
                            <th style="width: 250px">Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        @include('components.customer.create-comment')
    </div>
@endsection

@section('js')
  {{-- @vite(['resources/js/pages/users/users.datatables.js']) --}}
@endsection