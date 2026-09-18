<!-- ==========================================
     START: Sidebar Component
     Highly polished, dark navigation
     ========================================== -->
<div class="sidebar-wrapper" id="sidebar">
  <!-- Brand Logo / Identity -->
  <a href="{{ route('admin.dashboard') }}" class="sidebar-brand d-flex align-items-center gap-2">
    <img src="{{ asset('logo.png') }}" class="rounded-circle" alt="Rani Logo" height="36" width="36" style="border: 1.5px solid #d4af37;">
    <span>Rani Matrimonial</span>
  </a>

  <!-- Navigation Menu -->
  <div class="flex-grow-1 overflow-y-auto sidebar-scroll-area" id="sidebar-scroll-area">
    <!-- Group: Menu -->
    <div class="sidebar-menu-section">
      <div class="sidebar-menu-title">Main</div>
      <ul class="sidebar-menu-list">
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.dashboard') }}" class="sidebar-menu-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" id="menu-overview" title="Dashboard">
            <i class="bi bi-grid-fill"></i>
            <span>Dashboard</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.candidates.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.candidates*') ? 'active' : '' }}" id="menu-candidates" title="Candidates">
            <i class="bi bi-people-fill"></i>
            <span>Candidates</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.transactions.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.transactions*') ? 'active' : '' }}" id="menu-transactions" title="Transactions">
            <i class="bi bi-wallet2"></i>
            <span>Transactions</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.branches.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.branches*') ? 'active' : '' }}" id="menu-branches" title="Branches">
            <i class="bi bi-buildings"></i>
            <span>Branches</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.blueticks') }}" class="sidebar-menu-link {{ request()->routeIs('admin.blueticks*') ? 'active' : '' }}" id="menu-blueticks" title="Blue Tick Requests">
            <i class="bi bi-patch-check-fill text-warning"></i>
            <span>Blue Tick Requests</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.stories.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.stories*') ? 'active' : '' }}" id="menu-stories" title="Success Stories">
            <i class="bi bi-stars text-danger"></i>
            <span>Success Stories</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.tickets.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.tickets*') ? 'active' : '' }}" id="menu-tickets" title="Support Tickets">
            <i class="bi bi-ticket-detailed-fill text-info"></i>
            <span>Support Tickets</span>
            @php
              $openTicketsCount = \App\Models\Ticket::whereIn('status', ['open', 'in_progress'])->count();
            @endphp
            @if($openTicketsCount > 0)
              <span class="badge bg-danger rounded-pill ms-auto small" style="font-size: 10px;">{{ $openTicketsCount }}</span>
            @endif
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.helps.index') }}" class="sidebar-menu-link {{ request()->routeIs('admin.helps*') ? 'active' : '' }}" id="menu-helps" title="Help & Contact Inquiries">
            <i class="bi bi-envelope-paper-fill text-warning"></i>
            <span>Help Inquiries</span>
            @php
              $pendingHelpsCount = \App\Models\Help::where('status', 'pending')->count();
            @endphp
            @if($pendingHelpsCount > 0)
              <span class="badge bg-warning text-dark rounded-pill ms-auto small" style="font-size: 10px;">{{ $pendingHelpsCount }}</span>
            @endif
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.profile') }}" class="sidebar-menu-link {{ request()->routeIs('admin.profile*') ? 'active' : '' }}" id="menu-profile" title="Admin Profile & Settings">
            <i class="bi bi-person-gear"></i>
            <span>Profile & Settings</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- Group: Locations -->
    <div class="sidebar-menu-section">
      <div class="sidebar-menu-title">Locations</div>
      <ul class="sidebar-menu-list">
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.masters.index', 'countries') }}" class="sidebar-menu-link {{ request()->is('admin/masters/countries*') ? 'active' : '' }}" title="Countries">
            <i class="bi bi-globe-americas"></i>
            <span>Countries</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.masters.index', 'states') }}" class="sidebar-menu-link {{ request()->is('admin/masters/states*') ? 'active' : '' }}" title="States">
            <i class="bi bi-geo-alt"></i>
            <span>States</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.masters.index', 'cities') }}" class="sidebar-menu-link {{ request()->is('admin/masters/cities*') ? 'active' : '' }}" title="Cities">
            <i class="bi bi-buildings"></i>
            <span>Cities</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- Group: Religion & Community -->
    <div class="sidebar-menu-section">
      <div class="sidebar-menu-title">Religion & Community</div>
      <ul class="sidebar-menu-list">
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.masters.index', 'religions') }}" class="sidebar-menu-link {{ request()->is('admin/masters/religions*') ? 'active' : '' }}" title="Religions">
            <i class="bi bi-brightness-high"></i>
            <span>Religions</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.masters.index', 'communities') }}" class="sidebar-menu-link {{ request()->is('admin/masters/communities*') ? 'active' : '' }}" title="Communities">
            <i class="bi bi-people"></i>
            <span>Communities</span>
          </a>
        </li>
      </ul>
    </div>

    <!-- Group: Profile Attributes & Masters -->
    <div class="sidebar-menu-section">
      <div class="sidebar-menu-title">Matrimony Masters</div>
      <ul class="sidebar-menu-list">
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.masters.index', 'diets') }}" class="sidebar-menu-link {{ request()->is('admin/masters/diets*') ? 'active' : '' }}" title="Diets">
            <i class="bi bi-cup-hot"></i>
            <span>Diets</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.masters.index', 'heights') }}" class="sidebar-menu-link {{ request()->is('admin/masters/heights*') ? 'active' : '' }}" title="Heights">
            <i class="bi bi-rulers"></i>
            <span>Heights</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.masters.index', 'hobbies') }}" class="sidebar-menu-link {{ request()->is('admin/masters/hobbies*') ? 'active' : '' }}" title="Hobbies">
            <i class="bi bi-palette"></i>
            <span>Hobbies</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.masters.index', 'incomes') }}" class="sidebar-menu-link {{ request()->is('admin/masters/incomes*') ? 'active' : '' }}" title="Incomes">
            <i class="bi bi-cash-coin"></i>
            <span>Incomes</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.masters.index', 'marital-statuses') }}" class="sidebar-menu-link {{ request()->is('admin/masters/marital-statuses*') || request()->is('admin/masters/marital_statuses*') ? 'active' : '' }}" title="Marital Statuses">
            <i class="bi bi-heart-half"></i>
            <span>Marital Statuses</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.masters.index', 'qualifications') }}" class="sidebar-menu-link {{ request()->is('admin/masters/qualifications*') ? 'active' : '' }}" title="Qualifications">
            <i class="bi bi-mortarboard"></i>
            <span>Qualifications</span>
          </a>
        </li>
        <li class="sidebar-menu-item">
          <a href="{{ route('admin.masters.index', 'working-withs') }}" class="sidebar-menu-link {{ request()->is('admin/masters/working-withs*') || request()->is('admin/masters/working_withs*') ? 'active' : '' }}" title="Working With">
            <i class="bi bi-briefcase"></i>
            <span>Working With</span>
          </a>
        </li>
      </ul>
    </div>

  </div>

  <!-- Sidebar Profile Card (Dynamic Footer) -->
  <div class="sidebar-profile d-flex align-items-center justify-content-between">
    <a href="{{ route('admin.profile') }}" class="d-flex align-items-center gap-2 overflow-hidden text-decoration-none flex-grow-1" title="View & Edit Profile Settings">
     
      <div class="sidebar-profile-info text-truncate">
        <div class="sidebar-profile-name text-truncate text-white">{{ auth('admin')->user()->name ?? 'Administrator' }}</div>
        <div class="sidebar-profile-email text-truncate">{{ auth('admin')->user()->email ?? 'admin@rm.com' }}</div>
      </div>
    </a>
    <a href="{{ route('admin.logout') }}" class="text-white-50 text-hover-white p-1 ms-2" title="Sign Out" aria-label="Sign Out">
      <i class="bi bi-box-arrow-right fs-5"></i>
    </a>
  </div>
</div>
<!-- ==========================================
     END: Sidebar Component
     ========================================== -->
