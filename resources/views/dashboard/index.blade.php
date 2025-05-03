@extends('layouts.backend')

@section('content')

    @include('components.page-title', [
        'page_title' => 'Dashboard',
        'sub_title' => 'Welcome, everything looks great.'
    ])

  <!-- Page Content -->
  <div class="content pt-5">
    <div class="row push">
      <div class="col-md-6 col-xl-3 mb-3">
        <a href="" class="h-100">
          <div class="block mb-0 h-100">
            <div class="block-content block-content-full">
              <div class="text-center py-4">
                  <p><i class="fas fa-user-clock" style="font-size: 50px;"></i></p>
                  <h4 class="mb-0 text-dark">
                    Attendance Monitoring
                  </h4>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-md-6 col-xl-3 mb-3">
        <a href="" class="h-100">
          <div class="block mb-0 h-100">
            <div class="block-content block-content-full">
              <div class="text-center py-4">
                  <p><i class="fa-solid fa-users" style="font-size: 50px;"></i></p>
                  <h4 class="mb-0 text-dark">
                    Manage Customers
                  </h4>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-md-6 col-xl-3 mb-3">
        <a href="" class="h-100">
          <div class="block mb-0 h-100">
            <div class="block-content block-content-full">
              <div class="text-center py-4">
                  <p><i class="fas fa-chalkboard-teacher" style="font-size: 50px;"></i></p>
                  <h4 class="mb-0 text-dark">
                    Manage Coaches
                  </h4>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-md-6 col-xl-3 mb-3">
        <a href="" class="h-100">
          <div class="block mb-0 h-100">
            <div class="block-content block-content-full">
              <div class="text-center py-4">
                  <p><i class="fas fa-table-tennis-paddle-ball" style="font-size: 50px;"></i></p>
                  <h4 class="mb-0 text-dark">
                    Court Management
                  </h4>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-md-6 col-xl-3 mb-3">
        <a href="" class="h-100">
          <div class="block mb-0 h-100">
            <div class="block-content block-content-full">
              <div class="text-center py-4">
                  <p><i class="fas fa-dumbbell" style="font-size: 50px;"></i></p>
                  <h4 class="mb-0 text-dark">
                    Gym Management
                  </h4>
              </div>
            </div>
          </div>
        </a>
      </div>

      <div class="col-md-6 col-xl-3 mb-3">
        <a href="" class="h-100">
          <div class="block mb-0 h-100">
            <div class="block-content block-content-full">
              <div class="text-center py-4">
                  <p><i class="fas fa-file-alt" style="font-size: 50px;"></i></p>
                  <h4 class="mb-0 text-dark">
                    Reports
                  </h4>
              </div>
            </div>
          </div>
        </a>
      </div>
    </div>
  </div>
  <!-- END Page Content -->
@endsection
