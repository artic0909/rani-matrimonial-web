@extends('admin.layouts.app')

@section('title', $branch->name . ' (' . $branch->code . ') - Branch Details & Referrals - Rani Matrimonial')

@push('styles')
<style>
    /* Custom Styling for Branch View Page */
    .branch-hero-card {
        background: linear-gradient(135deg, #ffffff 0%, #f8faf9 100%);
        border: 1px solid rgba(15, 74, 50, 0.12) !important;
        position: relative;
        overflow: hidden;
    }
    .branch-hero-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 5px;
        background: linear-gradient(90deg, #0F4A32 0%, #16a34a 50%, #84cc16 100%);
    }
    .branch-avatar-box {
        width: 88px;
        height: 88px;
        border-radius: 20px;
        background: rgba(15, 74, 50, 0.08);
        color: #0F4A32;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 40px;
        border: 2px solid rgba(15, 74, 50, 0.15);
        flex-shrink: 0;
    }
    .branch-code-badge {
        background: rgba(15, 74, 50, 0.12);
        color: #0F4A32;
        border: 1.5px solid rgba(15, 74, 50, 0.25);
        font-family: var(--bs-font-monospace, monospace);
        font-weight: 800;
        letter-spacing: 0.8px;
        padding: 6px 14px;
        border-radius: 8px;
        font-size: 0.92rem;
        display: inline-flex;
        align-items: center;
        gap: 6px;
    }
    .doc-preview-card {
        border: 1px solid rgba(15, 74, 50, 0.12);
        border-radius: 16px;
        background: #ffffff;
        overflow: hidden;
        transition: all 0.2s ease-in-out;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }
    .doc-preview-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(15, 74, 50, 0.08);
        border-color: rgba(15, 74, 50, 0.25);
    }
    .doc-image-container {
        position: relative;
        height: 220px;
        background: #f1f5f3;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .doc-image-container img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        padding: 8px;
        transition: transform 0.3s ease;
    }
    .doc-preview-card:hover .doc-image-container img {
        transform: scale(1.03);
    }
    .doc-overlay-actions {
        position: absolute;
        inset: 0;
        background: rgba(15, 74, 50, 0.45);
        backdrop-filter: blur(2px);
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
        opacity: 0;
        transition: opacity 0.25s ease;
    }
    .doc-image-container:hover .doc-overlay-actions {
        opacity: 1;
    }
    .info-label {
        font-size: 0.78rem;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.6px;
        color: #64748b;
        margin-bottom: 4px;
    }
    .info-value {
        font-size: 0.98rem;
        font-weight: 600;
        color: #1e293b;
    }
    .meta-box {
        background: #f8faf9;
        border: 1px solid rgba(15, 74, 50, 0.08);
        border-radius: 12px;
        padding: 14px 18px;
    }
    .candidate-avatar-cell {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        object-fit: cover;
        border: 1.5px solid rgba(15, 74, 50, 0.15);
    }
    .quick-preset-pill {
        border-radius: 20px;
        padding: 4px 12px;
        font-size: 0.78rem;
        font-weight: 600;
        border: 1px solid rgba(15, 74, 50, 0.2);
        background: #ffffff;
        color: #0F4A32;
        text-decoration: none;
        transition: all 0.15s ease-in-out;
        display: inline-flex;
        align-items: center;
        gap: 4px;
    }
    .quick-preset-pill:hover,
    .quick-preset-pill.active {
        background: #0F4A32;
        color: #ffffff !important;
        border-color: #0F4A32;
    }
    .badge-recharged {
        background: rgba(34, 197, 94, 0.12);
        color: #15803d;
        border: 1px solid rgba(34, 197, 94, 0.25);
        font-weight: 700;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.82rem;
    }
    .badge-pending-recharge {
        background: rgba(245, 158, 11, 0.12);
        color: #b45309;
        border: 1px solid rgba(245, 158, 11, 0.25);
        font-weight: 600;
        padding: 4px 10px;
        border-radius: 6px;
        font-size: 0.82rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">

    <!-- START: Page Header & Breadcrumb -->
    <div class="page-header d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                <h1 class="page-title mb-0" id="branchHeaderTitle">{{ $branch->name }}</h1>
                <span class="branch-code-badge shadow-xs">
                    <i class="bi bi-qr-code"></i> <span id="branchHeaderCode">{{ $branch->code }}</span>
                </span>
                <span id="badgeBranchStatus" class="badge-table {{ $branch->is_active ? 'success' : 'failed' }} ms-1">
                    <i class="bi {{ $branch->is_active ? 'bi-check-circle-fill' : 'bi-pause-circle-fill' }}" id="iconBranchStatus"></i>
                    <span id="textBranchStatus">{{ $branch->is_active ? 'Operational (Active)' : 'Closed (Inactive)' }}</span>
                </span>
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted-green">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.branches.index') }}" class="text-decoration-none text-muted-green">Branch Management</a></li>
                    <li class="breadcrumb-item active text-main" aria-current="page">{{ $branch->name }} ({{ $branch->code }})</li>
                </ol>
            </nav>
        </div>

        <!-- Action Buttons -->
        <div class="d-flex flex-wrap align-items-center gap-2">
            <!-- Operational Status Toggle Button -->
            <button type="button" 
                    id="btnToggleStatus" 
                    onclick="toggleStatusAjax({{ $branch->id }})" 
                    class="btn-custom {{ $branch->is_active ? 'btn-custom-outline-danger' : 'btn-custom-primary' }} btn-custom-sm shadow-xs">
                <i class="bi {{ $branch->is_active ? 'bi-pause-circle-fill' : 'bi-play-circle-fill' }}" id="btnToggleIcon"></i>
                <span id="btnToggleText">{{ $branch->is_active ? 'Mark as Inactive' : 'Activate Branch' }}</span>
            </button>

            <!-- Edit Branch Button -->
            <button type="button" class="btn-custom btn-custom-primary btn-custom-sm shadow-xs" onclick="openEditModal()">
                <i class="bi bi-pencil-square"></i>
                <span>Edit Branch</span>
            </button>

            <!-- Delete Branch Button -->
            <button type="button" class="btn-custom btn-custom-danger btn-custom-sm" onclick="confirmDelete()">
                <i class="bi bi-trash3-fill"></i>
                <span>Delete</span>
            </button>

            <!-- Back to List -->
            <a href="{{ route('admin.branches.index') }}" class="btn-custom btn-custom-light btn-custom-sm">
                <i class="bi bi-arrow-left"></i>
                <span>All Branches</span>
            </a>
        </div>
    </div>
    <!-- END: Page Header & Breadcrumb -->

    <!-- Alert Message Container -->
    <div id="alertContainer">
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show rounded-3 shadow-xs mb-4" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
    </div>

    <!-- START: Hero Branch Information Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 branch-hero-card">
        <div class="card-body p-4">
            <div class="row g-4 align-items-center">
                <!-- Branch Icon Box -->
                <div class="col-12 col-md-auto text-center text-md-start">
                    <div class="branch-avatar-box mx-auto mx-md-0 shadow-xs">
                        <i class="bi bi-buildings-fill"></i>
                    </div>
                </div>

                <!-- Primary Branch Info -->
                <div class="col-12 col-md">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                        <h2 class="fw-bold mb-0 text-main" id="branchDisplayName">{{ $branch->name }}</h2>
                        <span class="badge bg-light text-dark border rounded-pill px-3 py-1 fw-semibold fs-xs" id="branchDisplayDesignation">
                            <i class="bi bi-person-badge me-1 text-forest-medium"></i>{{ $branch->designation ?? 'Branch Manager' }}
                        </span>
                    </div>

                    <div class="d-flex flex-wrap align-items-center gap-3 text-muted small mb-3">
                        <span class="d-inline-flex align-items-center gap-1">
                            <i class="bi bi-geo-alt-fill text-danger"></i> <span id="branchDisplayCityState">{{ $branch->city }}, {{ $branch->state }}</span>
                        </span>
                        <span>•</span>
                        <span class="d-inline-flex align-items-center gap-1">
                            <i class="bi bi-telephone-fill text-muted-green"></i> <a href="tel:{{ $branch->phone }}" class="text-decoration-none fw-semibold text-main font-monospace" id="branchDisplayPhone">{{ $branch->phone }}</a>
                        </span>
                        <span>•</span>
                        <span class="d-inline-flex align-items-center gap-1">
                            <i class="bi bi-shield-check text-success"></i> Aadhaar Docs: 
                            <strong>
                                @if($branch->aadhar_front && $branch->aadhar_back)
                                    <span class="text-success">2 of 2 Verified</span>
                                @elseif($branch->aadhar_front || $branch->aadhar_back)
                                    <span class="text-warning">1 of 2 Uploaded</span>
                                @else
                                    <span class="text-muted">Not Uploaded</span>
                                @endif
                            </strong>
                        </span>
                    </div>

                    <!-- Quick Actions Row -->
                    <div class="d-flex flex-wrap align-items-center gap-2">
                        <a href="tel:{{ $branch->phone }}" class="btn-custom btn-custom-light btn-custom-sm">
                            <i class="bi bi-telephone"></i> Call Office
                        </a>
                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $branch->phone) }}" target="_blank" class="btn-custom btn-custom-secondary btn-custom-sm">
                            <i class="bi bi-whatsapp"></i> WhatsApp Message
                        </a>
                        <button type="button" class="btn-custom btn-custom-light btn-custom-sm" onclick="copyToClipboard('{{ $branch->phone }}', 'Phone number copied!')">
                            <i class="bi bi-clipboard"></i> Copy Number
                        </button>
                        <a href="https://www.google.com/maps/search/?api=1&query={{ urlencode($branch->full_address . ', ' . $branch->city . ', ' . $branch->state) }}" target="_blank" class="btn-custom btn-custom-light btn-custom-sm">
                            <i class="bi bi-map"></i> View on Google Maps
                        </a>
                        <button type="button" class="btn-custom btn-custom-light btn-custom-sm" onclick="copyToClipboard('{{ $branch->code }}', 'Branch code copied!')">
                            <i class="bi bi-share-fill"></i> Copy Branch Code ({{ $branch->code }})
                        </button>
                    </div>
                </div>

                <!-- Fast Statistics / Code Display Box -->
                <div class="col-12 col-lg-auto border-top border-lg-top-0 border-lg-start pt-3 pt-lg-0 ps-lg-4 text-center text-lg-start">
                    <div class="info-label">Branch Referral Code</div>
                    <div class="fs-3 fw-bold font-monospace text-forest-medium mb-2" style="color: #0F4A32;">{{ $branch->code }}</div>
                    <div class="text-muted small">
                        <i class="bi bi-calendar3 me-1"></i> Registered: {{ $branch->created_at->format('d M, Y') }}
                    </div>
                    <div class="text-muted fs-xs mt-1">
                        ({{ $branch->created_at->diffForHumans() }})
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Hero Branch Information Card -->

    <!-- START: Referral Performance Analytics Stat Cards -->
    <div class="row g-3 mb-4">
        <!-- Stat 1: Total Candidates Referred -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card p-3 mb-0 h-100 shadow-sm border-0 rounded-4">
                <div class="kpa-card-inner">
                    <div>
                        <div class="kpa-stat-title">Total Referrals</div>
                        <div class="kpa-stat-value">{{ number_format($referralStats['total_referred'] ?? 0) }}</div>
                    </div>
                    <div class="kpa-icon-box" style="background-color: rgba(15, 74, 50, 0.1); color: var(--brand-forest-medium);">
                        <i class="bi bi-people-fill"></i>
                    </div>
                </div>
                <div class="kpa-stat-footer">
                    <span>Candidates signed up with {{ $branch->code }}</span>
                </div>
            </div>
        </div>

        <!-- Stat 2: Recharged Accounts (Conversions) -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card p-3 mb-0 h-100 shadow-sm border-0 rounded-4">
                <div class="kpa-card-inner">
                    <div>
                        <div class="kpa-stat-title">Recharged Accounts</div>
                        <div class="kpa-stat-value text-success">{{ number_format($referralStats['total_recharged'] ?? 0) }}</div>
                    </div>
                    <div class="kpa-icon-box" style="background-color: rgba(34, 197, 94, 0.1); color: #16a34a;">
                        <i class="bi bi-wallet2"></i>
                    </div>
                </div>
                <div class="kpa-stat-footer">
                    <span>Candidates with 1st wallet deposit</span>
                </div>
            </div>
        </div>

        <!-- Stat 3: Pending 1st Recharge -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card p-3 mb-0 h-100 shadow-sm border-0 rounded-4">
                <div class="kpa-card-inner">
                    <div>
                        <div class="kpa-stat-title">Pending 1st Recharge</div>
                        <div class="kpa-stat-value text-warning">{{ number_format($referralStats['pending_recharge'] ?? 0) }}</div>
                    </div>
                    <div class="kpa-icon-box" style="background-color: rgba(245, 158, 11, 0.12); color: #d97706;">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                </div>
                <div class="kpa-stat-footer">
                    <span>Registered, awaiting top-up</span>
                </div>
            </div>
        </div>

        <!-- Stat 4: Total 1st Recharge Revenue Generated -->
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card p-3 mb-0 h-100 shadow-sm border-0 rounded-4">
                <div class="kpa-card-inner">
                    <div>
                        <div class="kpa-stat-title">1st Recharge Revenue</div>
                        <div class="kpa-stat-value text-forest-medium">₹{{ number_format($referralStats['total_first_recharge_revenue'] ?? 0, 2) }}</div>
                    </div>
                    <div class="kpa-icon-box" style="background-color: rgba(15, 74, 50, 0.12); color: #0F4A32;">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
                <div class="kpa-stat-footer">
                    <span>Total 1st deposit volume</span>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Referral Performance Analytics Stat Cards -->

    <!-- START: Referral Details Table with Date Filter & Search -->
    <div class="table-card-custom mb-5 shadow-sm rounded-4 border-0">
        
        <!-- Table Header & Filter Toolbar -->
        <div class="p-4 border-bottom bg-white rounded-top-4">
            <div class="d-flex flex-column flex-lg-row align-items-lg-center justify-content-between gap-3 mb-3">
                <div>
                    <div class="d-flex align-items-center gap-2">
                        <div class="kpa-icon-box" style="background-color: rgba(15, 74, 50, 0.1); color: var(--brand-forest-medium); width: 36px; height: 36px; font-size: 16px;">
                            <i class="bi bi-diagram-3-fill"></i>
                        </div>
                        <div>
                            <h4 class="fw-bold mb-0 text-main">Branch Referral Register & Candidate Details</h4>
                            <p class="text-muted fs-xs mb-0">All candidates registered under branch code <strong class="font-monospace text-dark">{{ $branch->code }}</strong> with live wallet recharge tracking.</p>
                        </div>
                    </div>
                </div>

                <div class="d-flex align-items-center gap-2 flex-wrap">
                    <span class="badge bg-light text-dark border px-3 py-2 fw-semibold fs-xs">
                        <i class="bi bi-funnel me-1 text-forest-medium"></i> Showing {{ $filteredStats['count'] }} of {{ $referralStats['total_referred'] }} records
                    </span>
                    @if($filteredStats['recharge_sum'] > 0)
                        <span class="badge bg-success-subtle text-success border border-success-subtle px-3 py-2 fw-bold fs-xs">
                            <i class="bi bi-cash me-1"></i> Filtered Deposit: ₹{{ number_format($filteredStats['recharge_sum'], 2) }}
                        </span>
                    @endif
                </div>
            </div>

            <!-- Quick Date Presets Bar -->
            <div class="d-flex flex-wrap align-items-center gap-1 mb-3 pt-2 border-top">
                <span class="small fw-bold text-muted me-2"><i class="bi bi-clock-history me-1"></i> Quick Presets:</span>
                
                @php
                    $currentQuery = request()->except(['page', 'quick_range', 'start_date', 'end_date']);
                @endphp

                <a href="{{ route('admin.branches.show', array_merge(['id' => $branch->id], $currentQuery, ['quick_range' => 'all'])) }}" 
                   class="quick-preset-pill {{ ($quickRange === 'all' && empty($startDate) && empty($endDate)) ? 'active' : '' }}">
                    All Time
                </a>
                <a href="{{ route('admin.branches.show', array_merge(['id' => $branch->id], $currentQuery, ['quick_range' => 'today'])) }}" 
                   class="quick-preset-pill {{ $quickRange === 'today' ? 'active' : '' }}">
                    Today
                </a>
                <a href="{{ route('admin.branches.show', array_merge(['id' => $branch->id], $currentQuery, ['quick_range' => 'yesterday'])) }}" 
                   class="quick-preset-pill {{ $quickRange === 'yesterday' ? 'active' : '' }}">
                    Yesterday
                </a>
                <a href="{{ route('admin.branches.show', array_merge(['id' => $branch->id], $currentQuery, ['quick_range' => 'this_week'])) }}" 
                   class="quick-preset-pill {{ $quickRange === 'this_week' ? 'active' : '' }}">
                    This Week
                </a>
                <a href="{{ route('admin.branches.show', array_merge(['id' => $branch->id], $currentQuery, ['quick_range' => 'this_month'])) }}" 
                   class="quick-preset-pill {{ $quickRange === 'this_month' ? 'active' : '' }}">
                    This Month
                </a>
                <a href="{{ route('admin.branches.show', array_merge(['id' => $branch->id], $currentQuery, ['quick_range' => 'last_month'])) }}" 
                   class="quick-preset-pill {{ $quickRange === 'last_month' ? 'active' : '' }}">
                    Last Month
                </a>
                <a href="{{ route('admin.branches.show', array_merge(['id' => $branch->id], $currentQuery, ['quick_range' => 'this_year'])) }}" 
                   class="quick-preset-pill {{ $quickRange === 'this_year' ? 'active' : '' }}">
                    This Year
                </a>
            </div>

            <!-- Comprehensive Filter Form -->
            <form method="GET" action="{{ route('admin.branches.show', $branch->id) }}" class="row g-2 align-items-end">
                
                <!-- Search Input -->
                <div class="col-12 col-md-3">
                    <label class="form-label small fw-bold text-muted mb-1"><i class="bi bi-search me-1"></i> Search Candidate</label>
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-light"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control" placeholder="Name, RM code, phone, city..." value="{{ $search }}">
                    </div>
                </div>

                <!-- Date Type Selector -->
                <div class="col-6 col-md-2">
                    <label class="form-label small fw-bold text-muted mb-1"><i class="bi bi-calendar2-event me-1"></i> Date Type</label>
                    <select name="date_type" class="form-select form-select-sm">
                        <option value="created_at" {{ $dateType === 'created_at' ? 'selected' : '' }}>Registration Date</option>
                        <option value="first_amount_add_date" {{ $dateType === 'first_amount_add_date' ? 'selected' : '' }}>1st Recharge Date</option>
                    </select>
                </div>

                <!-- Start Date -->
                <div class="col-6 col-md-2">
                    <label class="form-label small fw-bold text-muted mb-1"><i class="bi bi-calendar-range me-1"></i> From Date</label>
                    <input type="date" name="start_date" class="form-control form-control-sm" value="{{ $startDate }}">
                </div>

                <!-- End Date -->
                <div class="col-6 col-md-2">
                    <label class="form-label small fw-bold text-muted mb-1"><i class="bi bi-calendar-range-fill me-1"></i> To Date</label>
                    <input type="date" name="end_date" class="form-control form-control-sm" value="{{ $endDate }}">
                </div>

                <!-- Recharge Status Filter -->
                <div class="col-6 col-md-2">
                    <label class="form-label small fw-bold text-muted mb-1"><i class="bi bi-wallet me-1"></i> Recharge Status</label>
                    <select name="recharge_status" class="form-select form-select-sm">
                        <option value="all" {{ $rechargeStatus === 'all' ? 'selected' : '' }}>All Status</option>
                        <option value="recharged" {{ $rechargeStatus === 'recharged' ? 'selected' : '' }}>Recharged Only</option>
                        <option value="pending" {{ $rechargeStatus === 'pending' ? 'selected' : '' }}>Pending Top-up</option>
                    </select>
                </div>

                <!-- Submit and Reset Buttons -->
                <div class="col-12 col-md-1 d-flex gap-1">
                    <button type="submit" class="btn-custom btn-custom-primary btn-custom-sm w-100 py-1.5" title="Apply Filter">
                        <i class="bi bi-funnel-fill"></i> Filter
                    </button>
                    @if(!empty($search) || !empty($startDate) || !empty($endDate) || $rechargeStatus !== 'all' || ($quickRange !== 'all' && $quickRange !== ''))
                        <a href="{{ route('admin.branches.show', $branch->id) }}" class="btn-custom btn-custom-light btn-custom-sm py-1.5 px-2 text-danger" title="Clear Filters">
                            <i class="bi bi-x-circle-fill"></i>
                        </a>
                    @endif
                </div>
            </form>

            <!-- Active Filter Indicators -->
            @if(!empty($search) || !empty($startDate) || !empty($endDate) || $rechargeStatus !== 'all')
                <div class="d-flex flex-wrap align-items-center gap-2 mt-3 pt-2 border-top">
                    <span class="fs-xs fw-bold text-muted">Active Filters:</span>
                    @if(!empty($search))
                        <span class="badge bg-light text-dark border rounded-pill px-2.5 py-1 fs-xs">
                            Search: "{{ $search }}"
                        </span>
                    @endif
                    @if(!empty($startDate) || !empty($endDate))
                        <span class="badge bg-light text-dark border rounded-pill px-2.5 py-1 fs-xs">
                            Date: {{ $startDate ?: 'Any' }} to {{ $endDate ?: 'Any' }} ({{ $dateType === 'first_amount_add_date' ? 'Recharge' : 'Joined' }})
                        </span>
                    @endif
                    @if($rechargeStatus !== 'all')
                        <span class="badge bg-light text-dark border rounded-pill px-2.5 py-1 fs-xs">
                            Status: {{ ucfirst($rechargeStatus) }}
                        </span>
                    @endif
                    <a href="{{ route('admin.branches.show', $branch->id) }}" class="text-danger text-decoration-none fs-xs fw-semibold ms-1">
                        <i class="bi bi-trash3 me-1"></i> Clear All Filters
                    </a>
                </div>
            @endif
        </div>

        <!-- Table Responsive Data List -->
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 50px;">#</th>
                        <th>Candidate Profile</th>
                        <th>Mobile / Contact</th>
                        <th>Location</th>
                        <th>Registration Date</th>
                        <th>1st Wallet Recharge</th>
                        <th>1st Recharge Date</th>
                        <th>Wallet Balance</th>
                        <th>Account Status</th>
                        <th class="text-center pe-4" style="width: 120px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($referrals as $index => $referral)
                        @php
                            $candidate = $referral->candidate;
                            $hasCandidate = (bool) $candidate;
                            $hasRecharged = ($referral->first_wallet_recharge_amount > 0 || !empty($referral->first_amount_add_date));
                            $phoneNum = $hasCandidate ? ($candidate->mobile ?? ($candidate->phone ?? null)) : null;
                            $cleanPhone = $phoneNum ? preg_replace('/[^0-9]/', '', $phoneNum) : null;
                        @endphp
                        <tr>
                            <!-- Row Number -->
                            <td class="ps-4 text-muted fw-semibold font-monospace small">
                                {{ $referrals->firstItem() + $index }}
                            </td>

                            <!-- Candidate Profile Column -->
                            <td>
                                @if($hasCandidate)
                                    <div class="d-flex align-items-center gap-2.5">
                                        <div class="position-relative">
                                            <img src="{{ $candidate->avatar_url }}" 
                                                 alt="{{ $candidate->first_name }} {{ $candidate->last_name }}" 
                                                 class="candidate-avatar-cell shadow-xs"
                                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode($candidate->first_name . ' ' . $candidate->last_name) }}&background=0d6efd&color=fff'">
                                            @if($candidate->is_bluetick_verified)
                                                <span class="position-absolute bottom-0 end-0 translate-middle-y badge rounded-pill bg-primary p-1 border border-2 border-white" title="Verified Blue Tick Profile">
                                                    <i class="bi bi-patch-check-fill text-white" style="font-size: 10px;"></i>
                                                </span>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-bold text-main d-flex align-items-center gap-1.5">
                                                <a href="{{ route('admin.candidates.show', $candidate->id) }}" class="text-decoration-none text-main hover-primary">
                                                    {{ $candidate->first_name }} {{ $candidate->last_name }}
                                                </a>
                                            </div>
                                            <div class="d-flex align-items-center gap-2 mt-0.5">
                                                <span class="badge bg-light text-dark font-monospace border px-1.5 py-0.5 rounded fs-xs">
                                                    {{ $candidate->display_code }}
                                                </span>
                                                <span class="text-muted fs-xs">
                                                    {{ $candidate->gender ?? 'N/A' }}
                                                    @if($candidate->dob)
                                                        • {{ \Carbon\Carbon::parse($candidate->dob)->age }} Yrs
                                                    @endif
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted fst-italic">Candidate record removed (ID #{{ $referral->candidate_id }})</span>
                                @endif
                            </td>

                            <!-- Mobile / Contact -->
                            <td>
                                @if($phoneNum)
                                    <div class="d-flex align-items-center gap-1.5">
                                        <span class="font-monospace fw-semibold text-main small">{{ $phoneNum }}</span>
                                        @if($cleanPhone)
                                            <a href="https://wa.me/{{ $cleanPhone }}" target="_blank" class="btn btn-sm btn-light p-1 px-1.5 rounded-circle text-success" title="Chat on WhatsApp">
                                                <i class="bi bi-whatsapp"></i>
                                            </a>
                                            <a href="tel:{{ $phoneNum }}" class="btn btn-sm btn-light p-1 px-1.5 rounded-circle text-primary" title="Call">
                                                <i class="bi bi-telephone-fill"></i>
                                            </a>
                                        @endif
                                    </div>
                                    @if($hasCandidate && $candidate->email)
                                        <div class="text-muted fs-xs mt-0.5 text-truncate" style="max-width: 170px;" title="{{ $candidate->email }}">
                                            {{ $candidate->email }}
                                        </div>
                                    @endif
                                @else
                                    <span class="text-muted fs-xs">-</span>
                                @endif
                            </td>

                            <!-- Location -->
                            <td>
                                @if($hasCandidate && ($candidate->city || $candidate->state))
                                    <div class="small fw-semibold text-dark">{{ $candidate->city ?? 'N/A' }}</div>
                                    <div class="text-muted fs-xs">{{ $candidate->state ?? 'India' }}</div>
                                @else
                                    <span class="text-muted fs-xs">Not Specified</span>
                                @endif
                            </td>

                            <!-- Registration Date with Branch Code -->
                            <td>
                                <div class="small fw-semibold text-dark">
                                    {{ $referral->created_at->format('d M, Y') }}
                                </div>
                                <div class="text-muted fs-xs">
                                    {{ $referral->created_at->format('h:i A') }} ({{ $referral->created_at->diffForHumans() }})
                                </div>
                            </td>

                            <!-- 1st Wallet Recharge Amount -->
                            <td>
                                @if($hasRecharged)
                                    <span class="badge-recharged d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-check-circle-fill"></i>
                                        <span>₹{{ number_format($referral->first_wallet_recharge_amount, 2) }}</span>
                                    </span>
                                @else
                                    <span class="badge-pending-recharge d-inline-flex align-items-center gap-1">
                                        <i class="bi bi-hourglass-split"></i>
                                        <span>₹0.00 (Pending)</span>
                                    </span>
                                @endif
                            </td>

                            <!-- 1st Recharge Date -->
                            <td>
                                @if($referral->first_amount_add_date)
                                    <div class="small fw-semibold text-success">
                                        {{ $referral->first_amount_add_date->format('d M, Y') }}
                                    </div>
                                    <div class="text-muted fs-xs">
                                        {{ $referral->first_amount_add_date->format('h:i A') }}
                                    </div>
                                @elseif($hasRecharged)
                                    <div class="small fw-semibold text-muted">
                                        {{ $referral->updated_at->format('d M, Y') }}
                                    </div>
                                @else
                                    <span class="text-muted small">-</span>
                                @endif
                            </td>

                            <!-- Current Wallet Available Balance -->
                            <td>
                                @if($hasCandidate && $candidate->wallet)
                                    <span class="fw-bold font-monospace text-dark small">
                                        ₹{{ number_format($candidate->wallet->avl_balance, 2) }}
                                    </span>
                                @else
                                    <span class="text-muted small">₹0.00</span>
                                @endif
                            </td>

                            <!-- Status -->
                            <td>
                                @if($hasCandidate)
                                    <span class="badge-table {{ $candidate->is_active ? 'success' : 'failed' }}">
                                        {{ $candidate->is_active ? 'Active' : 'Deactivated' }}
                                    </span>
                                @else
                                    <span class="badge-table failed">Deleted</span>
                                @endif
                            </td>

                            <!-- Actions -->
                            <td class="text-center pe-4">
                                @if($hasCandidate)
                                    <a href="{{ route('admin.candidates.show', $candidate->id) }}" 
                                       class="btn-custom btn-custom-light btn-custom-sm py-1 px-2.5 shadow-xs" 
                                       title="View Full Candidate Profile">
                                        <i class="bi bi-eye-fill me-1"></i> View
                                    </a>
                                @else
                                    <button class="btn btn-sm btn-light disabled" disabled>N/A</button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <div class="p-4">
                                    <i class="bi bi-people text-muted opacity-40 d-block mb-3" style="font-size: 3rem;"></i>
                                    @if(!empty($search) || !empty($startDate) || !empty($endDate) || $rechargeStatus !== 'all')
                                        <h5 class="fw-bold text-dark">No Referrals Matched Your Filters</h5>
                                        <p class="text-muted small mb-3">Try adjusting your date range, search query, or recharge status filter.</p>
                                        <a href="{{ route('admin.branches.show', $branch->id) }}" class="btn-custom btn-custom-light btn-custom-sm">
                                            <i class="bi bi-arrow-counterclockwise me-1"></i> Reset All Filters
                                        </a>
                                    @else
                                        <h5 class="fw-bold text-dark">No Candidate Referrals Recorded Yet</h5>
                                        <p class="text-muted small mb-0">When candidates register using branch code <strong class="font-monospace text-forest-medium">{{ $branch->code }}</strong>, their profile and wallet recharge history will automatically appear here.</p>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Table Footer Pagination -->
        @if($referrals->hasPages())
            <div class="p-3 bg-white border-top d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 rounded-bottom-4">
                <div class="text-muted fs-xs">
                    Showing <strong>{{ $referrals->firstItem() }}</strong> to <strong>{{ $referrals->lastItem() }}</strong> of <strong>{{ $referrals->total() }}</strong> referred candidates
                </div>
                <div>
                    {{ $referrals->links() }}
                </div>
            </div>
        @endif

    </div>
    <!-- END: Referral Details Table with Date Filter & Search -->

    <!-- START: Grid of Office Details & KYC Documents -->
    <div class="row g-4 mb-5">
        
        <!-- LEFT COLUMN: Location, Address & Manager Details -->
        <div class="col-12 col-lg-5">
            <!-- Center Details Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4">
                <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-info-circle-fill text-muted-green fs-5"></i>
                        <h5 class="fw-bold mb-0 text-main">Branch Office Overview</h5>
                    </div>
                    <button type="button" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2.5" onclick="openEditModal()">
                        <i class="bi bi-pencil"></i> Edit
                    </button>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex flex-column gap-3">
                        
                        <div class="meta-box">
                            <div class="info-label">Branch / Center Name</div>
                            <div class="info-value fs-5" id="viewBranchName">{{ $branch->name }}</div>
                        </div>

                        <div class="row g-3">
                            <div class="col-6">
                                <div class="meta-box h-100">
                                    <div class="info-label">Auto Generated Code</div>
                                    <div class="info-value font-monospace text-forest-medium fw-bold fs-6" style="color: #0F4A32;" id="viewBranchCode">
                                        {{ $branch->code }}
                                    </div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="meta-box h-100">
                                    <div class="info-label">Designation / Role</div>
                                    <div class="info-value" id="viewBranchDesignation">{{ $branch->designation ?? 'Branch Manager' }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="meta-box">
                            <div class="info-label">Contact Phone / Mobile</div>
                            <div class="d-flex align-items-center justify-content-between">
                                <div class="info-value font-monospace fs-5 text-forest-medium" id="viewBranchPhone">
                                    {{ $branch->phone }}
                                </div>
                                <div class="d-flex align-items-center gap-1">
                                    <a href="tel:{{ $branch->phone }}" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2" title="Call">
                                        <i class="bi bi-telephone-fill text-muted-green"></i>
                                    </a>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $branch->phone) }}" target="_blank" class="btn-custom btn-custom-secondary btn-custom-sm py-1 px-2" title="WhatsApp">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                </div>
                            </div>
                        </div>

                        <div class="row g-3">
                            <div class="col-6">
                                <div class="meta-box h-100">
                                    <div class="info-label">City</div>
                                    <div class="info-value" id="viewBranchCity">{{ $branch->city }}</div>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="meta-box h-100">
                                    <div class="info-label">State</div>
                                    <div class="info-value" id="viewBranchState">{{ $branch->state }}</div>
                                </div>
                            </div>
                        </div>

                        <div class="meta-box">
                            <div class="info-label">Full Physical Address</div>
                            <div class="info-value fw-normal text-muted-dark lh-base mt-1" id="viewBranchFullAddress" style="white-space: pre-line;">
                                {{ $branch->full_address }}
                            </div>
                        </div>

                    </div>
                </div>
            </div>

            <!-- Audit Trail & System Metadata Card -->
            <div class="card border-0 shadow-sm rounded-4">
                <div class="card-header bg-white py-3 px-4 border-bottom">
                    <div class="d-flex align-items-center gap-2">
                        <i class="bi bi-clock-history text-muted-green fs-5"></i>
                        <h5 class="fw-bold mb-0 text-main">System & Audit Records</h5>
                    </div>
                </div>
                <div class="card-body p-4">
                    <div class="d-flex flex-column gap-2 text-muted small">
                        <div class="d-flex justify-content-between py-1 border-bottom">
                            <span>System Record ID:</span>
                            <span class="fw-bold font-monospace text-dark">#{{ $branch->id }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-1 border-bottom">
                            <span>Code Prefix / Format:</span>
                            <span class="fw-bold font-monospace text-dark">BRM + Sequence</span>
                        </div>
                        <div class="d-flex justify-content-between py-1 border-bottom">
                            <span>Created At:</span>
                            <span class="fw-semibold text-dark">{{ $branch->created_at->format('d M, Y h:i A') }}</span>
                        </div>
                        <div class="d-flex justify-content-between py-1">
                            <span>Last Updated:</span>
                            <span class="fw-semibold text-dark" id="viewBranchUpdatedAt">{{ $branch->updated_at->format('d M, Y h:i A') }} ({{ $branch->updated_at->diffForHumans() }})</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- RIGHT COLUMN: Aadhaar Document Inspection Cards -->
        <div class="col-12 col-lg-7">
            <div class="card border-0 shadow-sm rounded-4 h-100">
                <div class="card-header bg-white py-3 px-4 border-bottom d-flex align-items-center justify-content-between">
                    <div>
                        <div class="d-flex align-items-center gap-2">
                            <i class="bi bi-person-vcard-fill text-muted-green fs-5"></i>
                            <h5 class="fw-bold mb-0 text-main">Aadhaar Card / KYC Documents</h5>
                        </div>
                        <p class="text-muted fs-xs mb-0 mt-0.5">Physical identity verification documents uploaded for this branch manager.</p>
                    </div>
                    <button type="button" class="btn-custom btn-custom-light btn-custom-sm" onclick="openEditModal()">
                        <i class="bi bi-cloud-arrow-up"></i> Upload / Replace
                    </button>
                </div>

                <div class="card-body p-4">
                    <div class="row g-4">
                        
                        <!-- Aadhaar Card Front -->
                        <div class="col-12 col-md-6">
                            <div class="doc-preview-card h-100 d-flex flex-column">
                                <div class="p-3 bg-light border-bottom d-flex align-items-center justify-content-between">
                                    <div class="fw-bold text-main d-flex align-items-center gap-2 fs-sm">
                                        <i class="bi bi-card-heading text-primary"></i>
                                        <span>Aadhaar Front Side</span>
                                    </div>
                                    @if($branch->aadhar_front)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-0.5 rounded-pill fs-xs">
                                            <i class="bi bi-check-circle me-1"></i> Uploaded
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-0.5 rounded-pill fs-xs">
                                            <i class="bi bi-exclamation-triangle me-1"></i> Missing
                                        </span>
                                    @endif
                                </div>

                                <div class="doc-image-container flex-grow-1" id="boxAadharFront">
                                    @if($branch->aadhar_front)
                                        <img src="{{ $branch->aadhar_front_url }}" alt="Aadhaar Front - {{ $branch->name }}" id="imgAadharFront">
                                        <div class="doc-overlay-actions">
                                            <button type="button" class="btn btn-light btn-sm shadow-sm rounded-pill px-3 fw-bold" onclick="viewLightbox('{{ $branch->aadhar_front_url }}', 'Aadhaar Card (Front) - {{ addslashes($branch->name) }}')">
                                                <i class="bi bi-zoom-in me-1"></i> Zoom
                                            </button>
                                            <a href="{{ $branch->aadhar_front_url }}" download="Aadhaar_Front_{{ $branch->code }}" target="_blank" class="btn btn-light btn-sm shadow-sm rounded-pill px-3 fw-bold">
                                                <i class="bi bi-download me-1"></i> Download
                                            </a>
                                        </div>
                                    @else
                                        <div class="text-center p-4 text-muted">
                                            <i class="bi bi-file-earmark-person fs-1 d-block mb-2 opacity-40"></i>
                                            <div class="fw-semibold small">No Front Document</div>
                                            <p class="fs-xs text-muted mb-2">Aadhaar front image has not been uploaded yet.</p>
                                            <button type="button" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2.5 fs-xs" onclick="openEditModal()">
                                                <i class="bi bi-upload"></i> Upload Now
                                            </button>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-3 bg-white border-top d-flex align-items-center justify-content-between">
                                    <span class="text-muted fs-xs">Front Identity Document</span>
                                    @if($branch->aadhar_front)
                                        <button type="button" class="btn btn-link text-decoration-none p-0 text-forest-medium fw-semibold fs-xs" onclick="viewLightbox('{{ $branch->aadhar_front_url }}', 'Aadhaar Card (Front) - {{ addslashes($branch->name) }}')">
                                            Full Resolution <i class="bi bi-box-arrow-up-right ms-1"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <!-- Aadhaar Card Back -->
                        <div class="col-12 col-md-6">
                            <div class="doc-preview-card h-100 d-flex flex-column">
                                <div class="p-3 bg-light border-bottom d-flex align-items-center justify-content-between">
                                    <div class="fw-bold text-main d-flex align-items-center gap-2 fs-sm">
                                        <i class="bi bi-card-text text-info"></i>
                                        <span>Aadhaar Back Side</span>
                                    </div>
                                    @if($branch->aadhar_back)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2 py-0.5 rounded-pill fs-xs">
                                            <i class="bi bi-check-circle me-1"></i> Uploaded
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-2 py-0.5 rounded-pill fs-xs">
                                            <i class="bi bi-exclamation-triangle me-1"></i> Missing
                                        </span>
                                    @endif
                                </div>

                                <div class="doc-image-container flex-grow-1" id="boxAadharBack">
                                    @if($branch->aadhar_back)
                                        <img src="{{ $branch->aadhar_back_url }}" alt="Aadhaar Back - {{ $branch->name }}" id="imgAadharBack">
                                        <div class="doc-overlay-actions">
                                            <button type="button" class="btn btn-light btn-sm shadow-sm rounded-pill px-3 fw-bold" onclick="viewLightbox('{{ $branch->aadhar_back_url }}', 'Aadhaar Card (Back) - {{ addslashes($branch->name) }}')">
                                                <i class="bi bi-zoom-in me-1"></i> Zoom
                                            </button>
                                            <a href="{{ $branch->aadhar_back_url }}" download="Aadhaar_Back_{{ $branch->code }}" target="_blank" class="btn btn-light btn-sm shadow-sm rounded-pill px-3 fw-bold">
                                                <i class="bi bi-download me-1"></i> Download
                                            </a>
                                        </div>
                                    @else
                                        <div class="text-center p-4 text-muted">
                                            <i class="bi bi-file-earmark-person fs-1 d-block mb-2 opacity-40"></i>
                                            <div class="fw-semibold small">No Back Document</div>
                                            <p class="fs-xs text-muted mb-2">Aadhaar back image has not been uploaded yet.</p>
                                            <button type="button" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2.5 fs-xs" onclick="openEditModal()">
                                                <i class="bi bi-upload"></i> Upload Now
                                            </button>
                                        </div>
                                    @endif
                                </div>

                                <div class="p-3 bg-white border-top d-flex align-items-center justify-content-between">
                                    <span class="text-muted fs-xs">Back Identity Document</span>
                                    @if($branch->aadhar_back)
                                        <button type="button" class="btn btn-link text-decoration-none p-0 text-forest-medium fw-semibold fs-xs" onclick="viewLightbox('{{ $branch->aadhar_back_url }}', 'Aadhaar Card (Back) - {{ addslashes($branch->name) }}')">
                                            Full Resolution <i class="bi bi-box-arrow-up-right ms-1"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Guidance notice -->
                    <div class="p-3 rounded-3 bg-light border mt-4 d-flex align-items-center gap-3">
                        <i class="bi bi-shield-lock-fill text-muted-green fs-4"></i>
                        <div class="small text-muted">
                            <strong>Official Franchise Documents:</strong> These identity cards verify authorization for regional matchmaking franchise activities and manager KYC. Document files are stored securely in protected storage.
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- END: Grid of Details & KYC Documents -->

</div>

<!-- START: Edit Branch Modal -->
<div class="modal fade" id="editBranchModal" tabindex="-1" aria-labelledby="editBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-white border-bottom py-3 px-4">
                <div class="d-flex align-items-center gap-2">
                    <div class="kpa-icon-box" style="background-color: rgba(15, 74, 50, 0.1); color: var(--brand-forest-medium); width: 36px; height: 36px; font-size: 16px;">
                        <i class="bi bi-pencil-square"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold text-main" id="editBranchModalLabel">Edit Branch Information</h5>
                        <p class="fs-xs text-muted mb-0">Update franchise center info, manager phone, location, and documents.</p>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            
            <form id="editBranchForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body p-4">
                    
                    <!-- Alert within modal -->
                    <div class="alert alert-danger d-none rounded-3 py-2 px-3 small mb-3" id="editModalErrorAlert"></div>

                    <div class="row g-3">
                        <!-- Branch Code (Read-Only) -->
                        <div class="col-12 col-md-4">
                            <label class="form-label small fw-bold text-main">Branch Code</label>
                            <input type="text" class="form-control bg-light font-monospace fw-bold" id="edit_branch_code" value="{{ $branch->code }}" readonly disabled>
                            <div class="form-text fs-xs">Auto-generated permanent code</div>
                        </div>

                        <!-- Branch Name -->
                        <div class="col-12 col-md-8">
                            <label for="edit_name" class="form-label small fw-bold text-main">Branch / Center Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_name" name="name" value="{{ $branch->name }}" required placeholder="e.g. Siliguri Regional Branch">
                        </div>

                        <!-- Manager Designation -->
                        <div class="col-12 col-md-6">
                            <label for="edit_designation" class="form-label small fw-bold text-main">Designation / Role <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_designation" name="designation" value="{{ $branch->designation }}" required placeholder="e.g. Branch Manager">
                        </div>

                        <!-- Contact Phone -->
                        <div class="col-12 col-md-6">
                            <label for="edit_phone" class="form-label small fw-bold text-main">Contact Phone / Mobile <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_phone" name="phone" value="{{ $branch->phone }}" required placeholder="e.g. +91 98765 43210">
                        </div>

                        <!-- City -->
                        <div class="col-12 col-md-6">
                            <label for="edit_city" class="form-label small fw-bold text-main">City <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_city" name="city" value="{{ $branch->city }}" required placeholder="e.g. Siliguri">
                        </div>

                        <!-- State -->
                        <div class="col-12 col-md-6">
                            <label for="edit_state" class="form-label small fw-bold text-main">State <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="edit_state" name="state" value="{{ $branch->state }}" required placeholder="e.g. West Bengal">
                        </div>

                        <!-- Full Address -->
                        <div class="col-12">
                            <label for="edit_full_address" class="form-label small fw-bold text-main">Full Physical Address <span class="text-danger">*</span></label>
                            <textarea class="form-control" id="edit_full_address" name="full_address" rows="3" required placeholder="Complete building, street, landmark, and pin code">{{ $branch->full_address }}</textarea>
                        </div>

                        <!-- Aadhaar Front File -->
                        <div class="col-12 col-md-6">
                            <label for="edit_aadhar_front" class="form-label small fw-bold text-main">
                                Aadhaar Card (Front)
                                <span class="text-muted fw-normal fs-xs">(Leave empty to keep current)</span>
                            </label>
                            <input type="file" class="form-control" id="edit_aadhar_front" name="aadhar_front" accept="image/jpeg,image/png,image/jpg,image/webp,application/pdf">
                        </div>

                        <!-- Aadhaar Back File -->
                        <div class="col-12 col-md-6">
                            <label for="edit_aadhar_back" class="form-label small fw-bold text-main">
                                Aadhaar Card (Back)
                                <span class="text-muted fw-normal fs-xs">(Leave empty to keep current)</span>
                            </label>
                            <input type="file" class="form-control" id="edit_aadhar_back" name="aadhar_back" accept="image/jpeg,image/png,image/jpg,image/webp,application/pdf">
                        </div>
                    </div>

                </div>
                <div class="modal-footer bg-light border-top py-3 px-4">
                    <button type="button" class="btn-custom btn-custom-light btn-custom-sm" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn-custom btn-custom-primary btn-custom-sm shadow-xs" id="btnSubmitEdit">
                        <i class="bi bi-check-lg"></i>
                        <span>Save Changes</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END: Edit Branch Modal -->

<!-- START: Lightbox Preview Modal -->
<div class="modal fade" id="docLightboxModal" tabindex="-1" aria-labelledby="docLightboxModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-white border-bottom py-3 px-4">
                <h5 class="modal-title fw-bold text-main" id="docLightboxModalLabel">Document Inspection</h5>
                <div class="d-flex align-items-center gap-2">
                    <a href="#" id="btnLightboxDownload" download class="btn-custom btn-custom-light btn-custom-sm py-1 px-2.5" target="_blank">
                        <i class="bi bi-download"></i> Download
                    </a>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            </div>
            <div class="modal-body p-3 text-center bg-dark" style="min-height: 380px; display: flex; align-items: center; justify-content: center;">
                <img id="lightboxImage" src="" alt="Document Preview" class="img-fluid rounded-3 shadow" style="max-height: 75vh; object-fit: contain;">
            </div>
        </div>
    </div>
</div>
<!-- END: Lightbox Preview Modal -->

<!-- Hidden Delete Form -->
<form id="deleteBranchForm" method="POST" action="{{ route('admin.branches.destroy', $branch->id) }}" class="d-none">
    @csrf
    @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
    const branchId = {{ $branch->id }};
    const csrfToken = '{{ csrf_token() }}';

    // Open Edit Modal
    function openEditModal() {
        const modal = new bootstrap.Modal(document.getElementById('editBranchModal'));
        modal.show();
    }

    // Lightbox image viewer
    function viewLightbox(url, title) {
        if (!url) return;
        document.getElementById('lightboxImage').src = url;
        document.getElementById('docLightboxModalLabel').innerText = title || 'Document Inspection';
        document.getElementById('btnLightboxDownload').href = url;
        const modal = new bootstrap.Modal(document.getElementById('docLightboxModal'));
        modal.show();
    }

    // Copy to clipboard helper
    function copyToClipboard(text, message) {
        navigator.clipboard.writeText(text).then(() => {
            showToast(message || 'Copied to clipboard!', 'success');
        }).catch(err => {
            console.error('Failed to copy: ', err);
        });
    }

    // Show temporary toast / banner
    function showToast(message, type = 'success') {
        const alertBox = document.createElement('div');
        alertBox.className = `alert alert-${type === 'success' ? 'success' : 'danger'} alert-dismissible fade show rounded-3 shadow-xs mb-3`;
        alertBox.innerHTML = `
            <i class="bi ${type === 'success' ? 'bi-check-circle-fill' : 'bi-exclamation-triangle-fill'} me-2"></i>
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        `;
        const container = document.getElementById('alertContainer');
        if (container) {
            container.prepend(alertBox);
            setTimeout(() => {
                const alertInstance = bootstrap.Alert.getOrCreateInstance(alertBox);
                if (alertInstance) alertInstance.close();
            }, 5000);
        }
    }

    // Toggle operational status via AJAX
    function toggleStatusAjax(id) {
        const btn = document.getElementById('btnToggleStatus');
        const icon = document.getElementById('btnToggleIcon');
        const text = document.getElementById('btnToggleText');
        
        btn.disabled = true;

        fetch(`/admin/branches/${id}/toggle-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            btn.disabled = false;
            if (data.success) {
                const isActive = data.is_active;
                
                // Update badge in header
                const badge = document.getElementById('badgeBranchStatus');
                const badgeIcon = document.getElementById('iconBranchStatus');
                const badgeText = document.getElementById('textBranchStatus');
                
                if (badge) {
                    badge.className = `badge-table ${isActive ? 'success' : 'failed'} ms-1`;
                }
                if (badgeIcon) {
                    badgeIcon.className = `bi ${isActive ? 'bi-check-circle-fill' : 'bi-pause-circle-fill'}`;
                }
                if (badgeText) {
                    badgeText.innerText = isActive ? 'Operational (Active)' : 'Closed (Inactive)';
                }

                // Update Toggle Button
                if (isActive) {
                    btn.className = 'btn-custom btn-custom-outline-danger btn-custom-sm shadow-xs';
                    icon.className = 'bi bi-pause-circle-fill';
                    text.innerText = 'Mark as Inactive';
                } else {
                    btn.className = 'btn-custom btn-custom-primary btn-custom-sm shadow-xs';
                    icon.className = 'bi bi-play-circle-fill';
                    text.innerText = 'Activate Branch';
                }

                showToast(data.message, 'success');
            } else {
                showToast(data.message || 'Error updating status', 'danger');
            }
        })
        .catch(err => {
            btn.disabled = false;
            console.error(err);
            showToast('Failed to update branch status.', 'danger');
        });
    }

    // Handle Edit Branch Form Submission
    document.getElementById('editBranchForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const btnSubmit = document.getElementById('btnSubmitEdit');
        const originalContent = btnSubmit.innerHTML;
        btnSubmit.disabled = true;
        btnSubmit.innerHTML = '<span class="spinner-border spinner-border-sm me-2"></span>Saving...';

        const errorAlert = document.getElementById('editModalErrorAlert');
        errorAlert.classList.add('d-none');
        errorAlert.innerHTML = '';

        const formData = new FormData(this);

        fetch(`/admin/branches/${branchId}`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = originalContent;

            if (data.success) {
                // Close modal
                const modalEl = document.getElementById('editBranchModal');
                const modal = bootstrap.Modal.getInstance(modalEl);
                if (modal) modal.hide();

                // Reload page to refresh all media and details seamlessly
                window.location.reload();
            } else {
                let errorHtml = data.message || 'Error saving changes.';
                if (data.errors) {
                    errorHtml = Object.values(data.errors).flat().join('<br>');
                }
                errorAlert.innerHTML = errorHtml;
                errorAlert.classList.remove('d-none');
            }
        })
        .catch(err => {
            btnSubmit.disabled = false;
            btnSubmit.innerHTML = originalContent;
            console.error(err);
            errorAlert.innerHTML = 'An unexpected error occurred while saving branch details.';
            errorAlert.classList.remove('d-none');
        });
    });

    // Confirm Delete
    function confirmDelete() {
        if (confirm(`Are you sure you want to permanently delete branch "${{ addslashes($branch->name) }}" (${{ $branch->code }})? This action cannot be undone.`)) {
            document.getElementById('deleteBranchForm').submit();
        }
    }
</script>
@endpush
