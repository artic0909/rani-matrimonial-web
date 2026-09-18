<!-- START: Top Navbar Component -->
<header class="navbar-custom">
  <div class="navbar-left">
    <!-- Desktop sidebar toggle (visible on large screens only) -->
    <button class="btn-desktop-toggle d-none d-xl-flex align-items-center justify-content-center me-3"
      id="desktop-sidebar-toggle" aria-label="Minimize Sidebar">
      <i class="bi bi-chevron-bar-left"></i>
    </button>
    <!-- Mobile sidebar toggle -->
    <button class="sidebar-toggle-btn me-2" id="sidebar-toggle" aria-label="Toggle Navigation">
      <i class="bi bi-list"></i>
    </button>
  </div>

  <!-- Mid navbar: search pill -->
  <div class="navbar-search-wrapper">
    <input type="text" class="navbar-search-input" placeholder="Search anything in rani matrimonial..." id="main-search">
    <button class="navbar-search-btn" aria-label="Search">
      <i class="bi bi-search"></i>
    </button>
  </div>

  <!-- Right actions -->
  <div class="navbar-actions">
    <!-- Fullscreen Toggle -->
    <button class="navbar-action-btn me-1" aria-label="Toggle Fullscreen" id="btn-fullscreen">
      <i class="bi bi-arrows-fullscreen"></i>
    </button>


    <!-- Profile Dropdown -->
    <div class="dropdown ms-2">
      <button class="navbar-profile-btn dropdown-toggle" type="button" data-bs-toggle="dropdown"
        aria-expanded="false" id="profile-dropdown">
        <img src="{{ asset('logo.png') }}" alt="Profile Image" class="navbar-profile-img">
        <span class="navbar-profile-name d-none d-md-inline">{{ auth('admin')->user()->name ?? 'Administrator' }}</span>
        <i class="bi bi-chevron-down navbar-profile-caret"></i>
      </button>
      <ul class="dropdown-menu dropdown-menu-end dropdown-menu-profile" aria-labelledby="profile-dropdown">
        <li class="dropdown-header">Welcome !</li>
        <li><a class="dropdown-item" href="{{ route('admin.profile') }}"><i class="bi bi-person"></i> My Account</a></li>
        <li>
          <hr class="dropdown-divider">
        </li>
        <li>
          <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}">
            <i class="bi bi-box-arrow-right me-1"></i> Logout
          </a>
        </li>
      </ul>
    </div>
  </div>
</header>
<!-- END: Top Navbar Component -->
