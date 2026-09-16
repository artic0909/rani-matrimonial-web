<!-- ==========================================
     START: Sidebar Component
     Highly polished, dark-green sticky navigation
     ========================================== -->
<div class="sidebar-wrapper" id="sidebar">
  <!-- Brand Logo / Identity -->
  <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
    <i class="bi bi-asterisk"></i>
    <span>Spark Admin</span>
  </a>

  <!-- Navigation Menu -->
  <div class="flex-grow-1 overflow-y-auto">
    <!-- Group: Menu -->
    <div class="sidebar-menu-section">
      <div class="sidebar-menu-title">Menu</div>
      <ul class="sidebar-menu-list">
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" id="menu-overview" title="Overview">
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- Group: Components -->
    <div class="sidebar-menu-section">
      <div class="sidebar-menu-title">Components</div>
      <ul class="sidebar-menu-list">
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.tables.basic') }}" class="sidebar-menu-link {{ request()->routeIs('admin.tables.basic') ? 'active' : '' }}" id="menu-basictables" title="Basic Tables">
            <i class="bi bi-table"></i>
            <span>Basic Tables</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.ui.forms') }}" class="sidebar-menu-link {{ request()->routeIs('admin.ui.forms') ? 'active' : '' }}" id="menu-uiforms" title="Forms and Input">
            <i class="bi bi-input-cursor-text"></i>
            <span>Forms & Input</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.ui.buttons') }}" class="sidebar-menu-link {{ request()->routeIs('admin.ui.buttons') ? 'active' : '' }}" id="menu-uibuttons" title="Buttons">
            <i class="bi bi-menu-button-wide-fill"></i>
            <span>Buttons & Alerts</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- Group: Pages -->
    <div class="sidebar-menu-section">
      <div class="sidebar-menu-title">Pages</div>
      <ul class="sidebar-menu-list">
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.page.blank') }}" class="sidebar-menu-link {{ request()->routeIs('admin.page.blank') ? 'active' : '' }}" id="menu-blankpage" title="Blank Page">
            <i class="bi bi-file-earmark"></i>
            <span>Blank Page</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.login') }}" class="sidebar-menu-link {{ request()->routeIs('admin.login') ? 'active' : '' }}" id="menu-loginpage" title="Login Page">
            <i class="bi bi-box-arrow-in-right"></i>
            <span>Login Screen</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.page.404') }}" class="sidebar-menu-link {{ request()->routeIs('admin.page.404') ? 'active' : '' }}" id="menu-404" title="404 Page">
            <i class="bi bi-slash-circle"></i>
            <span>Error 404</span>
          </a>
        </li>
      </ul>
    </div>
  </div>

  <!-- Sidebar Profile Card (Dynamic Footer) -->
  <div class="sidebar-profile">
    <img src="{{ asset('admin/images/avatar.png') }}" alt="Administrator" class="sidebar-profile-img"
      onerror="this.src='https://images.unsplash.com/photo-1534528741775-53994a69daeb?q=80&w=256&auto=format&fit=crop'">
    <div class="sidebar-profile-info">
      <div class="sidebar-profile-name">{{ auth('admin')->user()->name ?? 'Administrator' }}</div>
      <div class="sidebar-profile-email">{{ auth('admin')->user()->email ?? 'admin@email.com' }}</div>
    </div>
  </div>
</div>
<!-- ==========================================
     END: Sidebar Component
     ========================================== -->
