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

    /* Custom Themed SweetAlert2 for Spark Admin */
    .swal2-popup {
      border-radius: 1.25rem !important;
      font-family: inherit !important;
      border: 1px solid rgba(11, 19, 15, 0.08) !important;
      padding: 1.75rem !important;
      box-shadow: 0 20px 45px rgba(0, 0, 0, 0.12) !important;
    }
    .swal2-title {
      font-weight: 700 !important;
      color: #0B130F !important;
      font-size: 1.25rem !important;
    }
    .swal2-html-container {
      color: #4F5E56 !important;
      font-size: 0.925rem !important;
      line-height: 1.5 !important;
    }
    .swal2-confirm {
      background-color: #0F4A32 !important;
      border-color: #0F4A32 !important;
      border-radius: 50px !important;
      font-weight: 600 !important;
      font-size: 0.875rem !important;
      padding: 0.6rem 1.6rem !important;
      box-shadow: 0 4px 12px rgba(15, 74, 50, 0.25) !important;
      color: #FFFFFF !important;
    }
    .swal2-confirm:hover {
      background-color: #072F1F !important;
      border-color: #072F1F !important;
    }
    .swal2-cancel {
      background-color: #EEF2F0 !important;
      color: #33413B !important;
      border: 1px solid rgba(11, 19, 15, 0.08) !important;
      border-radius: 50px !important;
      font-weight: 600 !important;
      font-size: 0.875rem !important;
      padding: 0.6rem 1.4rem !important;
    }
    .swal2-cancel:hover {
      background-color: #E2E8E5 !important;
      color: #0B130F !important;
    }

    /* Global Spark Admin Pagination Overrides */
    .pagination {
      margin-bottom: 0;
      gap: 4px;
    }
    .pagination .page-item .page-link {
      border-radius: 8px !important;
      border: 1px solid rgba(11, 19, 15, 0.08) !important;
      color: #0F4A32 !important;
      background-color: #FFFFFF !important;
      font-weight: 600 !important;
      font-size: 0.85rem !important;
      padding: 0.375rem 0.75rem !important;
      transition: all 0.2s ease-in-out !important;
      box-shadow: none !important;
    }
    .pagination .page-item:hover:not(.disabled) .page-link {
      background-color: #EEF2F0 !important;
      border-color: #0F4A32 !important;
      color: #072F1F !important;
    }
    .pagination .page-item.active .page-link {
      background-color: #0F4A32 !important;
      border-color: #0F4A32 !important;
      color: #FFFFFF !important;
      box-shadow: 0 2px 6px rgba(15, 74, 50, 0.25) !important;
    }
    .pagination .page-item.disabled .page-link {
      opacity: 0.45 !important;
      background-color: #F8FAF9 !important;
      border-color: rgba(11, 19, 15, 0.05) !important;
      color: #879A91 !important;
      pointer-events: none !important;
    }

    /* Form & Search Inputs Focused Styles */
    .table-search-box:focus-within {
      border-color: #0F4A32 !important;
      box-shadow: 0 0 0 3px rgba(15, 74, 50, 0.12) !important;
    }
    .form-control:focus, .form-select:focus {
      border-color: #0F4A32 !important;
      box-shadow: 0 0 0 0.2rem rgba(15, 74, 50, 0.12) !important;
    }

    /* Bootstrap Primary Button fallback to Spark Forest Green */
    .btn-primary {
      background-color: #0F4A32 !important;
      border-color: #0F4A32 !important;
      color: #FFFFFF !important;
    }
    .btn-primary:hover, .btn-primary:focus, .btn-primary:active {
      background-color: #072F1F !important;
      border-color: #072F1F !important;
      color: #FFFFFF !important;
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
