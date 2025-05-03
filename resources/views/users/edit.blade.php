@extends('layouts.backend')

@section('content')

    @include('components.page-title', [
        'page_title' => 'Edit User'
    ])

    <div class="content">
        <div class="row">
            <div class="col-lg-8">
                @include('layouts.alert')
                <div class="block block-rounded">
                    <div class="block-header block-header-default">
                        <h3 class="block-title">Edit User</h3>
                    </div>
                    <div class="block-content block-content-full">
                        <form action="{{ route('admin.users.update', ['id' => $userVM->id]) }}" method="post" id="update-user">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-4">
                                        <input type="text" class="form-control form-control-alt" name="username" id="username" placeholder="Username" value="{{ $userVM->username }}" disabled>
                                        <label for="username">Username</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-4">
                                        <input type="text" class="form-control" name="full_name" id="full_name" placeholder="Surname & Name" value="{{ $userVM->fullname }}">
                                        <label for="full_name">Surname & Name</label>
                                    </div>
                                  </div>
                                <div class="col-6">
                                    <div class="form-floating mb-4">
                                        <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                                        <label for="password">Password</label>
                                    </div>
                                </div>
                                <div class="col-6">
                                  <div class="form-floating mb-4">
                                      <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Password Confirmation">
                                      <label for="password_confirmation">Password Confirmation</label>
                                  </div>
                                </div>
                                
                                <div class="col-lg-6">
                                  <div class="form-floating mb-4">
                                      <select name="role" class="form-control form-select {{ $errors->has('role') ? ' is-invalid' : '' }}" id="role" required>
                                          <option value="">Choose option</option> 
                                          @foreach ($roles as $role)
                                              <option value="{{ $role->name }}" {{ in_array($role->name, $userVM->roles) ? 'selected' : '' }}>{{ $role->name }}</option>
                                          @endforeach                      
                                      </select>
                                      <label for="role">Job Role</label>
                                  </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-floating mb-4">
                                      <select name="school" class="form-control form-select {{ $errors->has('school') ? ' is-invalid' : '' }}" id="school" required>
                                          <option value="">Choose option</option> 
                                          @foreach ($schools as $school)
                                              <option value="{{ $school->id }}" {{ isset($userVM->school->id) && $school->id == $userVM->school->id ? 'selected' : '' }}>{{ $school->sch_name }}</option>
                                          @endforeach                      
                                      </select>
                                      <label for="school">School</label>
                                  </div>
                                </div>
                                <div class="col-lg-6">
                                  <div class="form-floating mb-4">
                                      <select name="active" class="form-control form-select" id="active" required>
                                          <option value="">Choose option</option> 
                                          <option value="1" {{ $userVM->active == 1 ? 'selected' : '' }}>Yes</option>
                                          <option value="0" {{ $userVM->active != 1 ? 'selected' : '' }}>No</option>
                                      </select>
                                      <label for="active">Active</label>
                                  </div>
                                </div>
                                <div class="col-12 mt-3">
                                    <div class="d-flex justify-content-between">
                                        <button type="submit" class="btn btn-primary btn-submit">Update User</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
  @vite(['resources/js/pages/users/edit.user.js'])
@endsection