
<!doctype html>
<html lang="{{ config('app.locale') }}">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0">

    <title>{{ config('app.name') }}</title>

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="assets/media/favicons/favicon.png">
    <link rel="icon" type="image/png" sizes="192x192" href="assets/media/favicons/favicon-192x192.png">
    <link rel="apple-touch-icon" sizes="180x180" href="assets/media/favicons/apple-touch-icon-180x180.png">
    <!-- END Icons -->

    <!-- Modules -->
    @yield('css')
    
    @vite(['resources/sass/main.scss', 'resources/sass/oneui/themes/modern.scss', 'resources/js/oneui/app.js', 'resources/js/js-validation.js'])

    <script src="{{ asset('js/lib/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery-validation/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery-validation/additional-methods.min.js') }}"></script>

    @yield('js')
  </head>

  <body>

    <div id="page-container">

      <div id="page-loader" class="show"></div>

      <!-- Main Container -->
      <main id="main-container">
        <!-- Page Content -->
        <div class="bg-image" style="background-image: url('{{ asset("media/photos/background-image.jpg") }}');">
          <div class="row g-0 bg-primary-dark-op">
            <!-- Meta Info Section -->
            <div class="hero-static col-lg-6 d-none d-lg-flex flex-column justify-content-center">
              <div class="p-4 p-xl-5 flex-grow-1 d-flex align-items-center">
                <div class="w-100">
                  <h1 class="fw-black text-white">{{ config('app.name') }}</h1>
                </div>
              </div>
              <div class="p-4 p-xl-5 d-xl-flex justify-content-between align-items-center fs-sm">
                <p class="text-white-50 mb-0">
                  <strong>{{ config('app.name') }}</strong> &copy; <span data-toggle="year-copy"></span>
                </p>
                </ul>
              </div>
            </div>
            <!-- END Meta Info Section -->

            <!-- Main Section -->
            <div class="hero-static col-lg-6 d-flex flex-column align-items-center bg-body-extra-light">
              <div class="p-3 w-100 d-lg-none text-center">
                <h1 class="fw-semibold fs-2 text-white">{{ config('app.name') }}</h1>
              </div>
              <div class="p-4 w-100 flex-grow-1 d-flex align-items-center">
                @yield('content')
              </div>
              <div class="px-4 py-3 w-100 d-lg-none d-flex flex-column flex-sm-row justify-content-between fs-sm text-center text-sm-start">
                <p class="text-white-50 py-2 mb-0">
                  <strong>{{ config('app.name') }}</strong> &copy; <span data-toggle="year-copy"></span>
                </p>
              </div>
            </div>
            <!-- END Main Section -->
          </div>
        </div>
        <!-- END Page Content -->
      </main>
      <!-- END Main Container -->
    </div>
  </body>
</html>
