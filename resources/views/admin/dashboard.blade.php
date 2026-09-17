@extends('admin.layouts.app')

@section('title', 'Rani Matrimonial - Dashboard')

@section('content')
    <script>
      window.dashboardData = {
        revenueCategories: @json($revenueCategories),
        revenueCredits: @json($revenueCredits),
        revenueDebits: @json($revenueDebits),
        incomeSparkline: @json($incomeSparkline),
        returnSparkline: @json($returnSparkline),
        donutSeries: @json($donutSeries),
        donutLabels: @json($donutLabels),
        donutTotal: '{{ $donutTotal }}',
        donutTotalLabel: @json($donutTotalLabel),
        dateRange: [
          '{{ now()->subDays(30)->format('Y-m-d') }}',
          '{{ now()->format('Y-m-d') }}'
        ]
      };
    </script>

    <!-- START: Dashboard Header Banner -->
    <div class="page-header">
      <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Real-time management for candidate profiles, verifications, match interactions & wallet finances.</p>
      </div>
      <button class="btn-date-picker" type="button" id="date-picker-trigger">
        <i class="bi bi-calendar4-event"></i>
        <span id="selected-date-range">{{ now()->subDays(30)->format('F j, Y') }} - {{ now()->format('F j, Y') }}</span>
        <i class="bi bi-chevron-down ms-1"></i>
      </button>
    </div>
    <!-- END: Dashboard Header Banner -->

    <!-- START: Main Layout Grid -->
    <div class="row g-4">

      <!-- TOP AREA: Primary Highlights (3 Cards) -->
      <div class="col-12">
        <div class="row g-4">
          <!-- Stat Card 1: Green Alert Banner -->
          <div class="col-lg-4 col-md-6">
            <div class="card alert-green-card">
              <div class="position-relative z-index-2">
                <span class="alert-green-badge">Live Platform Update</span>
                <div class="alert-green-date">{{ now()->format('M jS, Y') }}</div>
                <div class="alert-green-text">
                  @if($creditsGrowth > 0)
                    Wallet revenue grew +{{ $creditsGrowth }}% this month with ₹{{ number_format($totalCredits, 2) }} processed
                  @elseif($thisMonthCredits > 0)
                    ₹{{ number_format($thisMonthCredits, 2) }} revenue generated this month across {{ $activeCandidates }} active profiles
                  @else
                    ₹{{ number_format($totalCredits, 2) }} total processed across {{ $activeCandidates }} active candidate profiles
                  @endif
                </div>
              </div>
              <a href="{{ route('admin.transactions.index') }}" class="alert-green-link z-index-2" id="alert-link-statistics">
                <span>View Transactions Ledger</span>
                <i class="bi bi-arrow-right"></i>
              </a>

              <!-- Inline SVG geometric decoration -->
              <svg class="alert-green-bg-shape" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
                <g transform="translate(50,50)">
                  <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" />
                  <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" transform="rotate(60)" />
                  <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" transform="rotate(120)" />
                </g>
              </svg>
            </div>
          </div>

          <!-- Stat Card 2: Net Income (Credits) -->
          <div class="col-lg-4 col-md-6">
            <a href="{{ route('admin.transactions.index', ['type' => 'credit']) }}" class="card card-stat card-clickable d-flex flex-column justify-content-between text-decoration-none">
              <div>
                <div class="card-header">
                  <span class="stat-label">Net Income (Credits)</span>
                  <div class="kpa-badge bg-forest-medium text-white">
                    <i class="bi bi-wallet2"></i> Ledger
                  </div>
                </div>
                <div class="stat-value">₹{{ number_format($totalCredits, 2) }}</div>
                @if($creditsGrowth >= 0)
                  <div class="trend-badge trend-up">
                    <i class="bi bi-arrow-up-right"></i>
                    <span>+{{ $creditsGrowth }}% from last month</span>
                  </div>
                @else
                  <div class="trend-badge trend-down">
                    <i class="bi bi-arrow-down-left"></i>
                    <span>{{ $creditsGrowth }}% from last month</span>
                  </div>
                @endif
              </div>
              <div class="sparkline-container sparkline-card-footer">
                <div id="income-sparkline"></div>
              </div>
            </a>
          </div>

          <!-- Stat Card 3: Total Debits (Spent) -->
          <div class="col-lg-4 col-md-12">
            <a href="{{ route('admin.transactions.index', ['type' => 'debit']) }}" class="card card-stat card-clickable d-flex flex-column justify-content-between text-decoration-none">
              <div>
                <div class="card-header">
                  <span class="stat-label">Total Debits (Spent)</span>
                  <div class="kpa-badge bg-danger text-white">
                    <i class="bi bi-arrow-up-right-circle"></i> Debits
                  </div>
                </div>
                <div class="stat-value">₹{{ number_format($totalDebits, 2) }}</div>
                @if($debitsGrowth >= 0)
                  <div class="trend-badge trend-up">
                    <i class="bi bi-arrow-up-right"></i>
                    <span>+{{ $debitsGrowth }}% from last month</span>
                  </div>
                @else
                  <div class="trend-badge trend-down">
                    <i class="bi bi-arrow-down-left"></i>
                    <span>{{ $debitsGrowth }}% from last month</span>
                  </div>
                @endif
              </div>
              <div class="sparkline-container sparkline-card-footer">
                <div id="return-sparkline"></div>
              </div>
            </a>
          </div>
        </div>
      </div>
      <!-- END: TOP AREA -->

      <!-- START: Interactive KPA Metric Stat Boxes Row (Clickable Cards) -->
      <div class="col-12">
        <div class="d-flex align-items-center justify-content-between mb-3">
          <h2 class="fs-6 fw-bold text-uppercase text-muted-green mb-0" style="letter-spacing: 0.08em;">
            <i class="bi bi-speedometer2 me-1"></i> Key Performance Metrics (Click to inspect records)
          </h2>
          <span class="badge bg-light text-muted border px-2.5 py-1.5 rounded-pill fs-xs">
            Live Synchronized
          </span>
        </div>

        <div class="row g-3">
          <!-- KPA 1: Total Male Candidates -->
          <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="{{ route('admin.candidates.index', ['gender' => 'male']) }}" class="card card-clickable p-3 mb-0 h-100">
              <div class="kpa-card-inner">
                <div>
                  <div class="kpa-stat-title">Male Candidates</div>
                  <div class="kpa-stat-value">{{ number_format($maleCandidates) }}</div>
                </div>
                <div class="kpa-icon-box" style="background-color: rgba(14, 165, 233, 0.12); color: #0284c7;">
                  <i class="bi bi-gender-male"></i>
                </div>
              </div>
              <div class="kpa-stat-footer">
                <span>{{ $maleCandidatesPercent }}% of total candidates</span>
                <i class="bi bi-arrow-right kpa-arrow-icon"></i>
              </div>
            </a>
          </div>

          <!-- KPA 2: Total Female Candidates -->
          <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="{{ route('admin.candidates.index', ['gender' => 'female']) }}" class="card card-clickable p-3 mb-0 h-100">
              <div class="kpa-card-inner">
                <div>
                  <div class="kpa-stat-title">Female Candidates</div>
                  <div class="kpa-stat-value">{{ number_format($femaleCandidates) }}</div>
                </div>
                <div class="kpa-icon-box" style="background-color: rgba(244, 63, 94, 0.12); color: #e11d48;">
                  <i class="bi bi-gender-female"></i>
                </div>
              </div>
              <div class="kpa-stat-footer">
                <span>{{ $femaleCandidatesPercent }}% of total candidates</span>
                <i class="bi bi-arrow-right kpa-arrow-icon"></i>
              </div>
            </a>
          </div>

          <!-- KPA 3: Active Candidates -->
          <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="{{ route('admin.candidates.index', ['status' => 'active']) }}" class="card card-clickable p-3 mb-0 h-100">
              <div class="kpa-card-inner">
                <div>
                  <div class="kpa-stat-title">Active Profiles</div>
                  <div class="kpa-stat-value">{{ number_format($activeCandidates) }}</div>
                </div>
                <div class="kpa-icon-box" style="background-color: rgba(34, 197, 94, 0.12); color: #16a34a;">
                  <i class="bi bi-check-circle-fill"></i>
                </div>
              </div>
              <div class="kpa-stat-footer">
                <span>{{ $activeCandidatesPercent }}% public & visible</span>
                <i class="bi bi-arrow-right kpa-arrow-icon"></i>
              </div>
            </a>
          </div>

          <!-- KPA 4: Deactivated Candidates -->
          <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="{{ route('admin.candidates.index', ['status' => 'deactivated']) }}" class="card card-clickable p-3 mb-0 h-100">
              <div class="kpa-card-inner">
                <div>
                  <div class="kpa-stat-title">Deactivated Profiles</div>
                  <div class="kpa-stat-value">{{ number_format($deactivatedCandidates) }}</div>
                </div>
                <div class="kpa-icon-box" style="background-color: rgba(100, 116, 139, 0.12); color: #64748b;">
                  <i class="bi bi-person-x-fill"></i>
                </div>
              </div>
              <div class="kpa-stat-footer">
                <span>Hidden from search results</span>
                <i class="bi bi-arrow-right kpa-arrow-icon"></i>
              </div>
            </a>
          </div>

          <!-- KPA 5: Blue Tick Verified -->
          <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="{{ route('admin.candidates.index', ['verification' => 'verified']) }}" class="card card-clickable p-3 mb-0 h-100">
              <div class="kpa-card-inner">
                <div>
                  <div class="kpa-stat-title">Blue Tick Verified</div>
                  <div class="kpa-stat-value">{{ number_format($verifiedCandidates) }}</div>
                </div>
                <div class="kpa-icon-box" style="background-color: rgba(245, 158, 11, 0.15); color: #d97706;">
                  <i class="bi bi-patch-check-fill"></i>
                </div>
              </div>
              <div class="kpa-stat-footer">
                <span>{{ $verifiedCandidatesPercent }}% Aadhaar approved</span>
                <i class="bi bi-arrow-right kpa-arrow-icon"></i>
              </div>
            </a>
          </div>

          <!-- KPA 6: Unverified Profiles -->
          <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="{{ route('admin.candidates.index', ['verification' => 'unverified']) }}" class="card card-clickable p-3 mb-0 h-100">
              <div class="kpa-card-inner">
                <div>
                  <div class="kpa-stat-title">Unverified Profiles</div>
                  <div class="kpa-stat-value">{{ number_format($unverifiedCandidates) }}</div>
                </div>
                <div class="kpa-icon-box" style="background-color: rgba(239, 68, 68, 0.12); color: #dc2626;">
                  <i class="bi bi-shield-exclamation"></i>
                </div>
              </div>
              <div class="kpa-stat-footer">
                <span>{{ $unverifiedCandidatesPercent }}% pending document</span>
                <i class="bi bi-arrow-right kpa-arrow-icon"></i>
              </div>
            </a>
          </div>

          <!-- KPA 7: Blue Tick Pending Approvals -->
          <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="{{ route('admin.blueticks', ['status' => 'pending']) }}" class="card card-clickable p-3 mb-0 h-100">
              <div class="kpa-card-inner">
                <div>
                  <div class="kpa-stat-title">Pending Blue Ticks</div>
                  <div class="kpa-stat-value">{{ number_format($pendingBlueTicksCount) }}</div>
                </div>
                <div class="kpa-icon-box" style="background-color: rgba(217, 70, 239, 0.12); color: #c026d3;">
                  <i class="bi bi-hourglass-split"></i>
                </div>
              </div>
              <div class="kpa-stat-footer">
                <span class="text-danger fw-semibold">Action queue pending</span>
                <i class="bi bi-arrow-right kpa-arrow-icon"></i>
              </div>
            </a>
          </div>

          <!-- KPA 8: Total Branches -->
          <div class="col-xl-3 col-lg-4 col-sm-6">
            <a href="{{ route('admin.branches.index') }}" class="card card-clickable p-3 mb-0 h-100">
              <div class="kpa-card-inner">
                <div>
                  <div class="kpa-stat-title">Regional Branches</div>
                  <div class="kpa-stat-value">{{ number_format($totalBranches) }}</div>
                </div>
                <div class="kpa-icon-box" style="background-color: rgba(15, 74, 50, 0.12); color: var(--brand-forest-medium);">
                  <i class="bi bi-buildings-fill"></i>
                </div>
              </div>
              <div class="kpa-stat-footer">
                <span>Franchise centers & offices</span>
                <i class="bi bi-arrow-right kpa-arrow-icon"></i>
              </div>
            </a>
          </div>
        </div>
      </div>
      <!-- END: Interactive KPA Stat Boxes Row -->

      <!-- LEFT AREA: Primary Charts & Tables (9 Columns) -->
      <div class="col-xl-9 col-lg-8">

        <!-- START: Details Area (Transactions + Performance Charts) -->
        <div class="row g-4">
          <!-- Column: Revenue Chart (Full Width) -->
          <div class="col-12">
            <div class="card mb-0">
              <div class="card-header mb-2 d-flex align-items-center justify-content-between flex-wrap gap-2">
                <div>
                  <h2 class="card-title mb-0">Revenue & Debits (INR ₹)</h2>
                  <p class="text-muted fs-xs mb-0">Monthly credit top-ups vs service debits</p>
                </div>
                <!-- Custom Static Legends & Ledger Link -->
                <div class="d-flex gap-3 align-items-center">
                  <div class="chart-legend-item">
                    <span class="legend-dot bg-forest-medium"></span>
                    <span class="chart-legend-label">Income (Credits)</span>
                  </div>
                  <div class="chart-legend-item">
                    <span class="legend-dot bg-lime-accent"></span>
                    <span class="chart-legend-label">Expenses (Debits)</span>
                  </div>
                  <a href="{{ route('admin.transactions.index') }}" class="btn-custom btn-custom-light btn-custom-sm ms-2 py-1 px-2.5">
                    <i class="bi bi-wallet2"></i> Ledger
                  </a>
                </div>
              </div>
              <div class="d-flex align-items-baseline gap-2 mb-3">
                <span class="stat-value-amount">₹{{ number_format($totalCredits, 2) }}</span>
                @if($creditsGrowth >= 0)
                  <span class="trend-badge trend-up fs-xs">+{{ $creditsGrowth }}% from last month</span>
                @else
                  <span class="trend-badge trend-down fs-xs">{{ $creditsGrowth }}% from last month</span>
                @endif
              </div>
              <div id="revenue-chart"></div>
            </div>
          </div>

          <!-- Column: Transaction List -->
          <div class="col-md-7 d-flex flex-column">
            <div class="card h-100 flex-grow-1">
              <div class="card-header">
                <h2 class="card-title">Recent Transactions</h2>
                <div class="dropdown">
                  <button class="card-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                    aria-label="More Options" id="btn-more-transaction">
                    <i class="bi bi-three-dots"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                    <li><a class="dropdown-item" href="{{ route('admin.transactions.index') }}"><i class="bi bi-list-ul"></i> All Transactions</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.transactions.index', ['type' => 'credit']) }}"><i class="bi bi-plus-circle"></i> Filter Credits</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.transactions.index', ['type' => 'debit']) }}"><i class="bi bi-dash-circle"></i> Filter Debits</a></li>
                  </ul>
                </div>
              </div>

              <!-- Transaction Items List -->
              <div class="transaction-list">
                @forelse($recentTransactions as $tx)
                  @php
                    $candidate = $tx->candidate ?? ($tx->wallet->candidate ?? null);
                    $name = $candidate ? ($candidate->first_name . ' ' . $candidate->last_name) : 'Platform User';
                    $code = $candidate ? ($candidate->candidate_code ?? $candidate->profile_id ?? '') : '';
                    $isCredit = $tx->type === 'credit';
                    $isBonus = stripos($tx->category ?? '', 'bonus') !== false || stripos($tx->title ?? '', 'bonus') !== false;
                    $isChat = stripos($tx->category ?? '', 'chat') !== false || stripos($tx->category ?? '', 'whatsapp') !== false;
                  @endphp
                  <a href="{{ $candidate ? route('admin.candidates.show', $candidate->id) : route('admin.transactions.index') }}" 
                     class="transaction-item text-decoration-none text-reset">
                    <div class="transaction-icon {{ $isCredit ? 'bg-forest-light text-lime' : 'bg-forest-light text-warning' }}">
                      @if($isBonus)
                        <i class="bi bi-gift"></i>
                      @elseif($isCredit)
                        <i class="bi bi-wallet2"></i>
                      @elseif($isChat)
                        <i class="bi bi-whatsapp"></i>
                      @else
                        <i class="bi bi-arrow-up-right"></i>
                      @endif
                    </div>
                    <div class="transaction-info">
                      <div class="transaction-name">
                        {{ $name }}
                        @if($code)
                          <span class="text-muted fs-xs fw-normal ms-1">({{ $code }})</span>
                        @endif
                      </div>
                      <div class="transaction-date">
                        {{ $tx->title ?? ($isCredit ? 'Wallet Top-up' : 'Wallet Debit') }} • {{ $tx->created_at->format('M d, Y • h:i A') }}
                      </div>
                    </div>
                    <div class="transaction-amount {{ $isCredit ? 'text-success' : 'text-main' }}">
                      {{ $isCredit ? '+' : '-' }}₹{{ number_format($tx->amount, 2) }}
                    </div>
                  </a>
                @empty
                  <div class="text-center py-4 text-muted">
                    <i class="bi bi-receipt fs-2 mb-2 d-block opacity-50"></i>
                    <span>No wallet transactions recorded yet</span>
                  </div>
                @endforelse
              </div>

              @if($recentTransactions->count() > 0)
                <div class="mt-3 pt-2 text-center border-top border-light">
                  <a href="{{ route('admin.transactions.index') }}" class="text-decoration-none fs-xs fw-bold text-forest-medium">
                    View Complete Transaction Ledger <i class="bi bi-arrow-right ms-1"></i>
                  </a>
                </div>
              @endif

            </div>
          </div>

          <!-- Column: Candidate / Platform Overview Progress -->
          <div class="col-md-5 d-flex flex-column">
            <div class="card h-100 flex-grow-1">
              <div class="card-header">
                <h2 class="card-title">Candidate Overview</h2>
                <div class="dropdown">
                  <button class="card-more-btn" type="button" data-bs-toggle="dropdown" aria-expanded="false"
                    aria-label="More Options" id="btn-more-products">
                    <i class="bi bi-three-dots"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end dropdown-menu-custom">
                    <li><a class="dropdown-item" href="{{ route('admin.candidates.index') }}"><i class="bi bi-people"></i> Manage Candidates</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.blueticks') }}"><i class="bi bi-patch-check"></i> Blue Tick Requests</a></li>
                    <li><a class="dropdown-item" href="{{ route('admin.masters.index', ['type' => 'religions']) }}"><i class="bi bi-database-gear"></i> Master Data</a></li>
                  </ul>
                </div>
              </div>

              <!-- Clickable Progress 1: Total Registered -->
              <a href="{{ route('admin.candidates.index') }}" class="progress-container text-decoration-none d-block">
                <div class="progress-label-row">
                  <span class="progress-label">Total Registered</span>
                  <span class="progress-value">{{ number_format($totalCandidates) }} <i class="bi bi-arrow-right fs-xs text-muted ms-1"></i></span>
                </div>
                <div class="progress" role="progressbar" aria-label="Total Registered Progress" aria-valuenow="100"
                  aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-forest-medium" style="width: 100%;"></div>
                </div>
              </a>

              <!-- Clickable Progress 2: Active Profiles -->
              <a href="{{ route('admin.candidates.index', ['status' => 'active']) }}" class="progress-container text-decoration-none d-block">
                <div class="progress-label-row">
                  <span class="progress-label">Active Profiles</span>
                  <span class="progress-value">{{ number_format($activeCandidates) }} ({{ $activeCandidatesPercent }}%) <i class="bi bi-arrow-right fs-xs text-muted ms-1"></i></span>
                </div>
                <div class="progress" role="progressbar" aria-label="Active Profiles Progress" aria-valuenow="{{ $activeCandidatesPercent }}"
                  aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-lime-accent" style="width: {{ $activeCandidatesPercent }}%;"></div>
                </div>
              </a>

              <!-- Clickable Progress 3: Blue Tick Verified -->
              <a href="{{ route('admin.candidates.index', ['verification' => 'verified']) }}" class="progress-container text-decoration-none d-block">
                <div class="progress-label-row">
                  <span class="progress-label">Blue Tick Verified</span>
                  <span class="progress-value">{{ number_format($verifiedCandidates) }} ({{ $verifiedCandidatesPercent }}%) <i class="bi bi-arrow-right fs-xs text-muted ms-1"></i></span>
                </div>
                <div class="progress" role="progressbar" aria-label="Blue Tick Verified Progress" aria-valuenow="{{ $verifiedCandidatesPercent }}"
                  aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-lime-accent" style="width: {{ $verifiedCandidatesPercent }}%;"></div>
                </div>
              </a>

              <!-- Clickable Progress 4: Male Candidates -->
              <a href="{{ route('admin.candidates.index', ['gender' => 'male']) }}" class="progress-container text-decoration-none d-block">
                <div class="progress-label-row">
                  <span class="progress-label">Male Candidates</span>
                  <span class="progress-value">{{ number_format($maleCandidates) }} ({{ $maleCandidatesPercent }}%) <i class="bi bi-arrow-right fs-xs text-muted ms-1"></i></span>
                </div>
                <div class="progress" role="progressbar" aria-label="Male Candidates Progress" aria-valuenow="{{ $maleCandidatesPercent }}"
                  aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-forest-medium opacity-75" style="width: {{ $maleCandidatesPercent }}%;"></div>
                </div>
              </a>

              <!-- Clickable Progress 5: Female Candidates -->
              <a href="{{ route('admin.candidates.index', ['gender' => 'female']) }}" class="progress-container text-decoration-none d-block">
                <div class="progress-label-row">
                  <span class="progress-label">Female Candidates</span>
                  <span class="progress-value">{{ number_format($femaleCandidates) }} ({{ $femaleCandidatesPercent }}%) <i class="bi bi-arrow-right fs-xs text-muted ms-1"></i></span>
                </div>
                <div class="progress" role="progressbar" aria-label="Female Candidates Progress" aria-valuenow="{{ $femaleCandidatesPercent }}"
                  aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-lime-accent opacity-75" style="width: {{ $femaleCandidatesPercent }}%;"></div>
                </div>
              </a>

              <!-- Clickable Progress 6: Connection Requests -->
              <a href="{{ route('admin.candidates.index') }}" class="progress-container text-decoration-none d-block">
                <div class="progress-label-row">
                  <span class="progress-label">Connection Requests</span>
                  <span class="progress-value">{{ number_format($totalConnections) }} ({{ $acceptedConnections }} Accepted) <i class="bi bi-arrow-right fs-xs text-muted ms-1"></i></span>
                </div>
                <div class="progress" role="progressbar" aria-label="Connection Requests Progress" aria-valuenow="{{ $acceptedConnectionsPercent }}"
                  aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-brand-orange" style="width: {{ $acceptedConnectionsPercent }}%;"></div>
                </div>
              </a>

              <!-- Clickable Progress 7: WhatsApp Chat Requests -->
              <a href="{{ route('admin.candidates.index') }}" class="progress-container text-decoration-none d-block">
                <div class="progress-label-row">
                  <span class="progress-label">WhatsApp Contact Requests</span>
                  <span class="progress-value">{{ number_format($totalWhatsAppRequests) }} ({{ $acceptedWhatsAppRequests }} Accepted) <i class="bi bi-arrow-right fs-xs text-muted ms-1"></i></span>
                </div>
                <div class="progress" role="progressbar" aria-label="WhatsApp Contact Requests Progress" aria-valuenow="{{ $acceptedWhatsAppPercent }}"
                  aria-valuemin="0" aria-valuemax="100">
                  <div class="progress-bar bg-lime-accent opacity-75" style="width: {{ $acceptedWhatsAppPercent }}%;"></div>
                </div>
              </a>
            </div>

          </div>
        </div>
        <!-- END: Details Area -->

      </div>

      <!-- RIGHT AREA: Performance Details Sidebar Panel (3 Columns) -->
      <div class="col-xl-3 col-lg-4">
        <div class="right-panel-wrapper d-flex flex-column gap-4 h-100">

          <!-- Performance Donut Chart card -->
          <div class="card flex-grow-1 d-flex flex-column justify-content-between mb-0">
            <div class="card-header mb-1">
              <h2 class="card-title">Platform Health Performance</h2>
            </div>

            <div id="views-chart"></div>

            <!-- Custom Interactive Legends below the chart -->
            <div class="chart-legends-container">
              <a href="{{ route('admin.candidates.index', ['status' => 'active']) }}" class="chart-legend-item text-decoration-none text-reset" title="Click to view Active Profiles">
                <span class="legend-dot bg-lime-accent"></span>
                <span class="text-muted-green">Active ({{ $activeCandidates }})</span>
              </a>
              <a href="{{ route('admin.candidates.index', ['verification' => 'verified']) }}" class="chart-legend-item text-decoration-none text-reset" title="Click to view Verified Profiles">
                <span class="legend-dot bg-forest-medium"></span>
                <span class="text-muted-green">Verified ({{ $verifiedCandidates }})</span>
              </a>
              <a href="{{ route('admin.candidates.index') }}" class="chart-legend-item text-decoration-none text-reset" title="Click to view Candidates Directory">
                <span class="legend-dot bg-brand-orange"></span>
                <span class="text-muted-green">Matches ({{ $totalConnections + $totalWhatsAppRequests }})</span>
              </a>
            </div>
          </div>

          <!-- Level Up / Platform Management Banner -->
          <div class="promo-banner-card">
            <!-- Inline SVG geometric decoration -->
            <svg class="promo-banner-bg-shape" viewBox="0 0 100 100" fill="none" xmlns="http://www.w3.org/2000/svg">
              <g transform="translate(50,50)">
                <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" />
                <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" transform="rotate(60)" />
                <rect x="-6" y="-45" width="12" height="90" rx="6" ry="6" fill="#B4F105" transform="rotate(120)" />
              </g>
            </svg>

            <h3 class="promo-title">Manage Candidate Profiles & Verifications</h3>
            <p class="promo-desc">Review pending Aadhaar verifications, monitor wallet transactions and manage candidate matches seamlessly.</p>
            <a href="{{ route('admin.blueticks') }}" class="btn-promo text-decoration-none d-block" id="btn-promo-action">
              Review Verifications ({{ $pendingBlueTicksCount }} Pending)
            </a>
          </div>
        </div>
      </div>
      <!-- END: RIGHT AREA -->

    </div>
    <!-- END: Main Layout Grid -->

@endsection
