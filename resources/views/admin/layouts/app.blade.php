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
  <link rel="stylesheet" href="{{ asset('admin/libs/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('admin/libs/select2/css/select2-bootstrap-5-theme.min.css') }}">

  <!-- Main Design System & Custom Stylesheet -->
  <link rel="stylesheet" href="{{ asset('admin/css/main.css') }}">

  <!-- jQuery & SweetAlert2 -->
  <script src="{{ asset('admin/libs/jquery/jquery.min.js') }}"></script>
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

    /* Select2 Theme Custom Overrides for Spark Admin */
    .select2-container--bootstrap-5 .select2-selection {
      border-color: #dee2e6;
      font-size: 0.875rem;
      border-radius: 0.5rem;
      min-height: 38px;
    }
    .select2-container--bootstrap-5.select2-container--focus .select2-selection,
    .select2-container--bootstrap-5.select2-container--open .select2-selection {
      border-color: #072F1F;
      box-shadow: 0 0 0 0.2rem rgba(7, 47, 31, 0.15);
    }
    .select2-container--bootstrap-5 .select2-dropdown {
      border-color: #dee2e6;
      border-radius: 0.5rem;
      box-shadow: 0 10px 25px rgba(0,0,0,0.08);
      font-size: 0.875rem;
      z-index: 9999;
    }
    .select2-container--bootstrap-5 .select2-dropdown .select2-search .select2-search__field {
      border-radius: 0.375rem;
      font-size: 0.85rem;
      padding: 6px 12px;
    }
    .select2-container--bootstrap-5 .select2-results__option--highlighted.select2-results__option--selectable {
      background-color: #072F1F;
      color: #B4F105;
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
  <script src="{{ asset('admin/libs/select2/js/select2.min.js') }}"></script>

  <!-- Local dashboard interactions controller -->
  <script src="{{ asset('admin/js/dashboard.js') }}"></script>

  <script>
    // -----------------------------------------------------------------
    // Global Select2 Initialization Helper
    // -----------------------------------------------------------------
    window.initSelect2 = function(context = document) {
      if (typeof jQuery === 'undefined' || typeof jQuery.fn.select2 === 'undefined') return;

      $(context).find('.select2, select.select2-search').each(function() {
        const $select = $(this);
        if ($select.hasClass('select2-hidden-accessible')) {
          $select.select2('destroy');
        }

        const isModal = $select.closest('.modal').length > 0;
        const placeholder = $select.data('placeholder') || $select.find('option[value=""]').text() || 'Select an option...';

        $select.select2({
          theme: 'bootstrap-5',
          width: $select.data('width') ? $select.data('width') : ($select.hasClass('w-100') || isModal ? '100%' : 'style'),
          placeholder: placeholder,
          allowClear: $select.data('allow-clear') !== false && Boolean($select.find('option[value=""]').length),
          dropdownParent: isModal ? $select.closest('.modal') : undefined
        });
      });
    };

    // Auto-init on page load and modal show events
    $(document).ready(function() {
      initSelect2();

      $(document).on('shown.bs.modal', '.modal', function() {
        initSelect2(this);
      });
    });

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
