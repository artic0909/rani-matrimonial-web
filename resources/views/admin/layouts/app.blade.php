<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', 'Spark Admin - Premium Bootstrap 5 Admin Dashboard Template')</title>

  <!-- Favicon -->
  <link rel="icon" type="image/png" href="{{ asset('admin/images/favicon.ico') }}">

  <!-- Local Third-Party Libraries (100% Offline Compatible) -->
  <link rel="stylesheet" href="{{ asset('admin/libs/bootstrap/css/bootstrap.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/libs/bootstrap-icons/bootstrap-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/libs/apexcharts/apexcharts.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/libs/flatpickr/flatpickr.min.css') }}">

  <!-- Main Design System & Custom Stylesheet -->
  <link rel="stylesheet" href="{{ asset('admin/css/main.css') }}">

  @stack('styles')
</head>
<body>

  <!-- START: Sidebar Component -->
  @include('admin.includes.sidebar')
  <!-- END: Sidebar Component -->

  <!-- START: Main Content Area -->
  <div class="main-wrapper">

    <!-- START: Top Navbar Component -->
    @include('admin.includes.header')
    <!-- END: Top Navbar Component -->

    <!-- START: Content Body -->
    <main class="content-body">
      @yield('content')
    </main>
    <!-- END: Content Body -->

    <!-- START: Footer Component -->
    @include('admin.includes.footer')
    <!-- END: Footer Component -->

  </div>
  <!-- END: Main Content Area -->

  <!-- Local Third-Party Libraries Script dependencies -->
  <script src="{{ asset('admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <script src="{{ asset('admin/libs/apexcharts/apexcharts.min.js') }}"></script>
  <script src="{{ asset('admin/libs/flatpickr/flatpickr.min.js') }}"></script>

  <!-- Local dashboard interactions controller -->
  <script src="{{ asset('admin/js/dashboard.js') }}"></script>

  @stack('scripts')
</body>
</html>
