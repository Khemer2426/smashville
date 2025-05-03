<nav id="sidebar" aria-label="Main Navigation">
    <!-- Side Header -->
    <div class="content-header">
      <!-- Logo -->
      <a class="font-semibold text-dual" href="/">
        <span class="smini-visible">
          <i class="fa fa-circle-notch text-primary"></i>
        </span>
        <span class="smini-hide fs-5 tracking-wider">
          <!-- <img src="{{ asset('media/logo.jpg') }}" alt="Logo" class="logo"> -->
          <h2 class="logo-title fw-black text-primary">SMASHVILLE</h2>
        </span>
      </a>
      <!-- END Logo -->

      <!-- Extra -->
      <div>
        <!-- Close Sidebar, Visible only on mobile screens -->
        <!-- Layout API, functionality initialized in Template._uiApiLayout() -->
        <a class="d-lg-none btn btn-sm btn-alt-secondary ms-1" data-toggle="layout" data-action="sidebar_close" href="javascript:void(0)">
          <i class="fa fa-fw fa-times"></i>
        </a>
        <!-- END Close Sidebar -->
      </div>
      <!-- END Extra -->
    </div>
    <!-- END Side Header -->

    <!-- Sidebar Scrolling -->
    <div class="js-sidebar-scroll">
      <!-- Side Navigation -->
      <div class="content-side">
        <ul class="nav-main">
              
            <li class="nav-main-item">
                <a class="nav-main-link{{ request()->is('dashboard') ? ' active' : '' }}" href="{{ route('dashboard') }}">
                    <i class="nav-main-link-icon si si-speedometer"></i>
                    <span class="nav-main-link-name">Dashboard</span>
                </a>
            </li>           
            
            <li class="nav-main-item open">
              <a class="nav-main-link" aria-haspopup="true" aria-expanded="true" href="#">
                <i class="nav-main-link-icon fas fa-user-clock"></i>
                <span class="nav-main-link-name">Attendance Monitoring</span>
              </a>
            </li>            

            <li class="nav-main-item open">
              <a class="nav-main-link" aria-haspopup="true" aria-expanded="true" href="#">
                <i class="nav-main-link-icon fa-solid fa-users"></i>
                <span class="nav-main-link-name">Customers</span>
              </a>
              <ul class="nav-main-submenu">
                <li class="nav-main-item">
                  <a class="nav-main-link{{ route('admin.customers.all') ? ' active' : '' }}" href="{{ route('admin.customers.all') }}">
                    <span class="nav-main-link-name">All Customers</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" href="">
                    <span class="nav-main-link-name">Customer Bookings</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link{{ route('admin.customers.all.comments') ? ' active' : '' }}" href="{{ route('admin.customers.all.comments') }}">
                    <span class="nav-main-link-name">Customer Comments</span>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-main-item open">
              <a class="nav-main-link" aria-haspopup="true" aria-expanded="true" href="#">
                <i class="nav-main-link-icon fas fa-chalkboard-teacher"></i>
                <span class="nav-main-link-name">Coaches</span>
              </a>
              <ul class="nav-main-submenu">
                <li class="nav-main-item">
                  <a class="nav-main-link{{ request()->is('admin/users*') ? ' active' : '' }}" href="{{ route('admin.users') }}">
                    <span class="nav-main-link-name">All Coaches</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" href="">
                    <span class="nav-main-link-name">Coach Schedules</span>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-main-item open">
              <a class="nav-main-link" aria-haspopup="true" aria-expanded="true" href="#">
                <i class="nav-main-link-icon fas fa-table-tennis-paddle-ball"></i>
                <span class="nav-main-link-name">Court Management</span>
              </a>
              <ul class="nav-main-submenu">
                <li class="nav-main-item">
                  <a class="nav-main-link" href="">
                    <span class="nav-main-link-name">All Court Bookings</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" href="">
                    <span class="nav-main-link-name">Manage Calendar</span>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-main-item open">
              <a class="nav-main-link" aria-haspopup="true" aria-expanded="true" href="#">
                <i class="nav-main-link-icon fas fa-dumbbell"></i>
                <span class="nav-main-link-name">Gym Management</span>
              </a>
              <ul class="nav-main-submenu">
                <li class="nav-main-item">
                  <a class="nav-main-link" href="">
                    <span class="nav-main-link-name">All Gym Bookings</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link" href="">
                    <span class="nav-main-link-name">Manage Calendar</span>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-main-item open">
              <a class="nav-main-link" aria-haspopup="true" aria-expanded="true" href="#">
                <i class="nav-main-link-icon fas fa-file-alt"></i>
                <span class="nav-main-link-name">Reports</span>
              </a>
              <ul class="nav-main-submenu">
                <li class="nav-main-item">
                  <a class="nav-main-link{{ route('admin.customers.all') ? ' active' : '' }}" href="{{ route('admin.customers.all') }}">
                    <span class="nav-main-link-name">Sales Report</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link{{ route('admin.customers.all') ? ' active' : '' }}" href="{{ route('admin.customers.all') }}">
                    <span class="nav-main-link-name">Maintenance Report</span>
                  </a>
                </li>
                <li class="nav-main-item">
                  <a class="nav-main-link{{ route('admin.customers.all') ? ' active' : '' }}" href="{{ route('admin.customers.all') }}">
                    <span class="nav-main-link-name">Attendance Report</span>
                  </a>
                </li>
              </ul>
            </li>

            <li class="nav-main-item open">
              <a class="nav-main-link" aria-haspopup="true" aria-expanded="true" href="#">
                <i class="nav-main-link-icon fa fa-table"></i>
                <span class="nav-main-link-name">Admin</span>
              </a>
              <ul class="nav-main-submenu">
                <li class="nav-main-item">
                  <a class="nav-main-link{{ request()->is('admin/users*') ? ' active' : '' }}" href="{{ route('admin.users') }}">
                    <span class="nav-main-link-name">Users</span>
                  </a>
                </li>
              </ul>
            </li>

        </ul>
      </div>
    </div>
    <!-- END Sidebar Scrolling -->
  </nav>
  <!-- END Sidebar -->