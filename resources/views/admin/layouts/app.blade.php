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

  <!-- SweetAlert2 (Global for interactive alerts) -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    /* -------------------------------------------------------------
       Sidebar Scrollbar Removal (Cross-browser: Webkit, Firefox, IE)
       ------------------------------------------------------------- */
    .sidebar-wrapper,
    .sidebar-wrapper .overflow-y-auto,
    .sidebar-scroll-area {
      scrollbar-width: none !important; /* Firefox */
      -ms-overflow-style: none !important; /* IE & Edge */
    }
    .sidebar-wrapper::-webkit-scrollbar,
    .sidebar-scroll-area::-webkit-scrollbar,
    .sidebar-wrapper .overflow-y-auto::-webkit-scrollbar,
    .sidebar-wrapper *::-webkit-scrollbar {
      display: none !important; /* Chrome, Safari, Opera */
      width: 0 !important;
      height: 0 !important;
      background: transparent !important;
    }
  </style>

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

  <script>
    // -----------------------------------------------------------------
    // Sidebar Scroll Position Preservation & Active Item Visibility
    // -----------------------------------------------------------------
    (function () {
      function initSidebarScroll() {
        const scrollContainer = document.getElementById('sidebar-scroll-area') || document.querySelector('.sidebar-wrapper .overflow-y-auto');
        if (!scrollContainer) return;

        // 1. Restore previous scroll position from sessionStorage
        const savedScroll = sessionStorage.getItem('admin_sidebar_scroll');
        if (savedScroll !== null) {
          scrollContainer.scrollTop = parseInt(savedScroll, 10);
        }

        // 2. If active item exists, ensure it is visible without jumping awkwardly
        const activeLink = scrollContainer.querySelector('.sidebar-menu-link.active');
        if (activeLink) {
          const containerRect = scrollContainer.getBoundingClientRect();
          const linkRect = activeLink.getBoundingClientRect();
          
          if (linkRect.top < containerRect.top || linkRect.bottom > containerRect.bottom) {
            activeLink.scrollIntoView({ block: 'nearest', behavior: 'instant' });
          }
        }

        // 3. Save scroll position on scroll event
        scrollContainer.addEventListener('scroll', function () {
          sessionStorage.setItem('admin_sidebar_scroll', scrollContainer.scrollTop);
        }, { passive: true });

        // 4. Save scroll position when clicking any navigation link
        scrollContainer.querySelectorAll('a').forEach(function (link) {
          link.addEventListener('click', function () {
            sessionStorage.setItem('admin_sidebar_scroll', scrollContainer.scrollTop);
          });
        });
      }

      if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSidebarScroll);
      } else {
        initSidebarScroll();
      }
    })();
  </script>

  @stack('scripts')
</body>
</html>
