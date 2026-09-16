@extends('admin.layouts.app')

@section('title', ($candidate->first_name ?? 'Candidate') . ' - Full Profile & Activity Details - Rani Matrimonial')

@section('content')
<div class="container-fluid p-0">

    <!-- START: Page Header Banner -->
    <div class="page-header d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h1 class="page-title mb-0">{{ $candidate->first_name }} {{ $candidate->last_name }}</h1>
                <span class="badge bg-light text-dark border font-monospace px-2.5 py-1">
                    {{ $candidate->candidate_code ?? $candidate->profile_id ?? ('RM' . str_pad($candidate->id, 5, '0', STR_PAD_LEFT)) }}
                </span>
                @if($candidate->is_bluetick_verified ?? false)
                    <span class="badge-table success ms-1">
                        <i class="bi bi-patch-check-fill"></i> Blue Tick Verified
                    </span>
                @endif
                @if(($stats['matched_connections_total'] ?? 0) > 0)
                    <span class="badge-table success ms-1">
                        <i class="bi bi-heart-fill"></i> {{ $stats['matched_connections_total'] }} Matched
                    </span>
                @endif
            </div>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none text-muted-green">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.candidates.index') }}" class="text-decoration-none text-muted-green">Candidates</a></li>
                    <li class="breadcrumb-item active text-main" aria-current="page">{{ $candidate->first_name }} {{ $candidate->last_name }}</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex align-items-center gap-2">
            @php
                $phoneNum = $candidate->mobile ?? ($candidate->phone ?? null);
            @endphp
            @if($phoneNum)
                <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $phoneNum) }}" target="_blank" class="btn-custom btn-custom-secondary btn-custom-sm">
                    <i class="bi bi-whatsapp"></i>
                    <span>WhatsApp</span>
                </a>
            @endif
            <a href="{{ url('/candidate/' . ($candidate->candidate_code ?? $candidate->id)) }}" target="_blank" class="btn-custom btn-custom-light btn-custom-sm">
                <i class="bi bi-box-arrow-up-right"></i>
                <span>Public Profile</span>
            </a>
            <a href="{{ route('admin.candidates.index') }}" class="btn-custom btn-custom-light btn-custom-sm">
                <i class="bi bi-arrow-left"></i>
                <span>Candidates List</span>
            </a>
        </div>
    </div>
    <!-- END: Page Header Banner -->

    <!-- START: Profile Hero Summary Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="border: 1px solid rgba(11, 19, 15, 0.06) !important;">
        <div class="card-body p-4 bg-white">
            <div class="row g-4 align-items-center">
                <!-- Avatar -->
                <div class="col-12 col-md-auto text-center text-md-start">
                    <div class="position-relative d-inline-block">
                        <img src="{{ $candidate->avatar_url }}" 
                             alt="{{ $candidate->first_name }}" 
                             class="rounded-circle object-fit-cover shadow-sm" 
                             width="110" height="110" 
                             style="border: 3.5px solid {{ strtolower($candidate->gender ?? '') === 'female' ? '#ffccd5' : '#cfe2ff' }};"
                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(($candidate->first_name ?? 'C').' '.($candidate->last_name ?? '')) }}&background=0F4A32&color=fff'">
                        @if($candidate->is_bluetick_verified ?? false)
                            <i class="bi bi-patch-check-fill text-warning position-absolute shadow-sm" 
                               style="bottom: 2px; right: 2px; font-size: 26px; background: white; border-radius: 50%;" 
                               title="Aadhaar / Blue Tick Verified"></i>
                        @endif
                    </div>
                </div>

                <!-- Primary Identity Details -->
                <div class="col-12 col-md">
                    <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
                        <h3 class="fw-bold mb-0" style="color: var(--text-main);">
                            {{ $candidate->first_name }} {{ $candidate->middle_name ? $candidate->middle_name . ' ' : '' }}{{ $candidate->last_name }}
                        </h3>
                        <span class="badge {{ strtolower($candidate->gender ?? '') === 'female' ? 'bg-danger-subtle text-danger' : 'bg-primary-subtle text-primary' }} rounded-pill px-3 py-1 fw-semibold">
                            <i class="bi {{ strtolower($candidate->gender ?? '') === 'female' ? 'bi-gender-female' : 'bi-gender-male' }} me-1"></i>
                            {{ ucfirst($candidate->gender ?? 'Profile') }}
                            @if($candidate->dob)
                                ({{ \Carbon\Carbon::parse($candidate->dob)->age }} yrs)
                            @endif
                        </span>
                        <span class="badge bg-light text-dark border rounded-pill px-2.5 py-1">
                            For: {{ ucfirst($candidate->profile_for ?? 'Self') }}
                        </span>
                        @if(($stats['matched_connections_total'] ?? 0) > 0)
                            <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-2.5 py-1 fw-bold">
                                💑 {{ $stats['matched_connections_total'] }} Accepted Matches
                            </span>
                        @endif
                    </div>

                    <!-- Contact & Essential Meta -->
                    <div class="row g-2 small mb-0" style="color: var(--text-muted-green);">
                        <div class="col-12 col-sm-6 col-lg-4">
                            <i class="bi bi-telephone-fill me-1.5" style="color: var(--brand-forest-medium);"></i>
                            <strong style="color: var(--text-main);">Mobile:</strong> 
                            <a href="tel:{{ $candidate->mobile ?? $candidate->phone }}" class="fw-bold font-monospace text-decoration-none" style="color: var(--brand-forest-dark);">
                                {{ $candidate->mobile ?? ($candidate->phone ?? 'N/A') }}
                            </a>
                        </div>
                        <div class="col-12 col-sm-6 col-lg-4">
                            <i class="bi bi-envelope-fill text-danger me-1.5"></i>
                            <strong style="color: var(--text-main);">Email:</strong> {{ $candidate->email ?? 'Not provided' }}
                        </div>
                        <div class="col-12 col-sm-6 col-lg-4">
                            <i class="bi bi-geo-alt-fill text-success me-1.5"></i>
                            <strong style="color: var(--text-main);">Location:</strong> {{ $candidate->city ?? 'N/A' }}, {{ $candidate->state ?? ($candidate->country ?? 'India') }}
                        </div>
                        <div class="col-12 col-sm-6 col-lg-4">
                            <i class="bi bi-brightness-high-fill text-warning me-1.5"></i>
                            <strong style="color: var(--text-main);">Religion:</strong> {{ $candidate->religion ?? 'N/A' }} ({{ $candidate->community ?? 'N/A' }})
                        </div>
                        <div class="col-12 col-sm-6 col-lg-4">
                            <i class="bi bi-briefcase-fill text-info me-1.5"></i>
                            <strong style="color: var(--text-main);">Profession:</strong> {{ $candidate->profession ?? ($candidate->designation ?? 'Not specified') }}
                        </div>
                        <div class="col-12 col-sm-6 col-lg-4">
                            <i class="bi bi-calendar-check-fill text-secondary me-1.5"></i>
                            <strong style="color: var(--text-main);">Registered:</strong> {{ $candidate->created_at ? $candidate->created_at->format('d M, Y h:i A') : 'N/A' }}
                        </div>
                    </div>
                </div>

                <!-- Wallet Box -->
                <div class="col-12 col-xl-3 text-center text-xl-start">
                    <div class="p-3 bg-light rounded-3 border">
                        <div class="small text-muted mb-1 d-flex align-items-center justify-content-between">
                            <span class="fw-semibold">Wallet Balance</span>
                            <i class="bi bi-wallet2" style="color: var(--brand-forest-medium);"></i>
                        </div>
                        <h3 class="fw-bold mb-1 font-monospace" style="color: var(--brand-forest-dark);">
                            ₹{{ number_format((float) ($candidate->wallet->avl_balance ?? 0), 2) }}
                        </h3>
                        <div class="table-user-sub font-monospace">
                            ID: {{ $candidate->wallet->wallet_id ?? 'No Active Wallet' }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Profile Hero Summary Card -->

    <!-- START: Activity Overview Stats Strip -->
    <div class="row g-3 mb-4">
        <!-- Matched / Accepted -->
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100" style="border: 1px solid rgba(11, 19, 15, 0.06) !important;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="table-user-sub fw-semibold">Matched / Accepted</span>
                    <span class="badge-table success">{{ $stats['matched_connections_total'] }} Accepted</span>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-2">
                    <h4 class="fw-bold mb-0 text-success font-monospace">💑 {{ $stats['matched_connections_total'] }}</h4>
                    <span class="text-success small fw-semibold">Mutual Connections</span>
                </div>
                <div class="table-user-sub d-flex justify-content-between">
                    <span><i class="bi bi-arrow-up-right text-primary me-1"></i> Sent Accepted: {{ $stats['sent_connections_accepted'] }}</span>
                    <span><i class="bi bi-arrow-down-left text-info me-1"></i> Received Accepted: {{ $stats['received_connections_accepted'] }}</span>
                </div>
            </div>
        </div>

        <!-- Sent Connections -->
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100" style="border: 1px solid rgba(11, 19, 15, 0.06) !important;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="table-user-sub fw-semibold">Sent Connections</span>
                    <span class="badge-table success">{{ $stats['sent_connections_total'] }} Total</span>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-2">
                    <h4 class="fw-bold mb-0 text-main">{{ $stats['sent_connections_total'] }}</h4>
                    <span class="text-success small fw-semibold">({{ $stats['sent_connections_accepted'] }} Accepted)</span>
                </div>
                <div class="table-user-sub d-flex justify-content-between">
                    <span><i class="bi bi-clock-history text-warning me-1"></i> Pending: {{ $stats['sent_connections_pending'] }}</span>
                    <span><i class="bi bi-x-circle text-danger me-1"></i> Declined: {{ $stats['sent_connections_declined'] }}</span>
                </div>
            </div>
        </div>

        <!-- Received Connections -->
        <div class="col-12 col-sm-6 col-xl-4">
            <div class="card border-0 shadow-sm rounded-3 p-3 bg-white h-100" style="border: 1px solid rgba(11, 19, 15, 0.06) !important;">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <span class="table-user-sub fw-semibold">Received Requests</span>
                    <span class="badge-table pending">{{ $stats['received_connections_total'] }} Total</span>
                </div>
                <div class="d-flex align-items-baseline gap-2 mb-2">
                    <h4 class="fw-bold mb-0 text-main">{{ $stats['received_connections_total'] }}</h4>
                    <span class="text-success small fw-semibold">({{ $stats['received_connections_accepted'] }} Accepted)</span>
                </div>
                <div class="table-user-sub d-flex justify-content-between">
                    <span><i class="bi bi-clock-history text-warning me-1"></i> Pending: {{ $stats['received_connections_pending'] }}</span>
                    <span><i class="bi bi-x-circle text-danger me-1"></i> Declined: {{ $stats['received_connections_declined'] }}</span>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Activity Overview Stats Strip -->

    <!-- START: Tabbed Content Container -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="border: 1px solid rgba(11, 19, 15, 0.06) !important;">
        <div class="card-header bg-white border-bottom p-0">
            <ul class="nav nav-tabs border-0 px-3 pt-2" id="candidateShowTabs" role="tablist">
                <!-- Tab 1: Complete Profile Details -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link active fw-bold text-dark border-bottom border-3" 
                            style="border-color: var(--brand-forest-medium) !important;"
                            id="tab-profile-details" data-bs-toggle="tab" data-bs-target="#pane-profile-details" type="button" role="tab">
                        <i class="bi bi-person-lines-fill me-1.5" style="color: var(--brand-forest-medium);"></i> Profile Details
                    </button>
                </li>

                <!-- Tab 2: Matched / Accepted Connections -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold text-muted" 
                            id="tab-matched-connections" data-bs-toggle="tab" data-bs-target="#pane-matched-connections" type="button" role="tab">
                        <i class="bi bi-heart-fill me-1.5 text-danger"></i> Matched (Accepted)
                        <span class="badge bg-success text-white rounded-pill ms-1">{{ $stats['matched_connections_total'] }}</span>
                    </button>
                </li>

                <!-- Tab 3: Sent Connection Requests -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold text-muted" 
                            id="tab-sent-connections" data-bs-toggle="tab" data-bs-target="#pane-sent-connections" type="button" role="tab">
                        <i class="bi bi-send-fill me-1.5" style="color: var(--brand-forest-medium);"></i> Sent Requests ({{ $stats['sent_connections_total'] }})
                    </button>
                </li>

                <!-- Tab 4: Received Connection Requests -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold text-muted" 
                            id="tab-received-connections" data-bs-toggle="tab" data-bs-target="#pane-received-connections" type="button" role="tab">
                        <i class="bi bi-inbox-fill me-1.5 text-info"></i> Received Requests ({{ $stats['received_connections_total'] }})
                    </button>
                </li>

                <!-- Tab 5: Sent WhatsApp Requests -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold text-muted" 
                            id="tab-sent-whatsapp" data-bs-toggle="tab" data-bs-target="#pane-sent-whatsapp" type="button" role="tab">
                        <i class="bi bi-whatsapp me-1.5 text-success"></i> Sent WhatsApp ({{ $stats['sent_whatsapp_total'] }})
                    </button>
                </li>

                <!-- Tab 6: Received WhatsApp Requests -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold text-muted" 
                            id="tab-received-whatsapp" data-bs-toggle="tab" data-bs-target="#pane-received-whatsapp" type="button" role="tab">
                        <i class="bi bi-chat-dots-fill me-1.5 text-success"></i> Received WhatsApp ({{ $stats['received_whatsapp_total'] }})
                    </button>
                </li>

                <!-- Tab 7: Photo Gallery -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold text-muted" 
                            id="tab-photos" data-bs-toggle="tab" data-bs-target="#pane-photos" type="button" role="tab">
                        <i class="bi bi-images me-1.5 text-warning"></i> Photos ({{ $candidate->photos->count() }})
                    </button>
                </li>

                <!-- Tab 8: Wallet Ledger -->
                <li class="nav-item" role="presentation">
                    <button class="nav-link fw-semibold text-muted" 
                            id="tab-wallet" data-bs-toggle="tab" data-bs-target="#pane-wallet" type="button" role="tab">
                        <i class="bi bi-wallet2 me-1.5 text-secondary"></i> Wallet
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-4">
            <div class="tab-content" id="candidateShowTabsContent">

                <!-- ========================================================
                     TAB PANE 1: COMPLETE PROFILE DETAILS
                     ======================================================== -->
                <div class="tab-pane fade show active" id="pane-profile-details" role="tabpanel">
                    <div class="row g-4">
                        
                        <!-- Section 1: Basic & Personal Info -->
                        <div class="col-12 col-lg-6">
                            <div class="card border rounded-3 h-100 p-3 bg-white" style="border: 1px solid rgba(11, 19, 15, 0.08) !important;">
                                <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                                    <i class="bi bi-person-badge fs-5" style="color: var(--brand-forest-medium);"></i>
                                    <h6 class="fw-bold mb-0 text-main">Basic & Personal Information</h6>
                                </div>
                                <table class="table table-sm table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="table-user-sub" style="width: 40%;">Full Name:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->first_name }} {{ $candidate->middle_name }} {{ $candidate->last_name }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Profile Created For:</td>
                                            <td class="fw-semibold text-main">{{ ucfirst($candidate->profile_for ?? 'Self') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Gender:</td>
                                            <td class="fw-semibold text-main">{{ ucfirst($candidate->gender ?? 'N/A') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Date of Birth:</td>
                                            <td class="fw-semibold text-main">
                                                {{ $candidate->dob ? \Carbon\Carbon::parse($candidate->dob)->format('d M, Y') : 'N/A' }}
                                                @if($candidate->dob)
                                                    <span class="table-user-sub">({{ \Carbon\Carbon::parse($candidate->dob)->age }} years old)</span>
                                                @endif
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Marital Status:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->marital_status ?? 'Never Married' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Height:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->height ?? 'Not specified' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Blood Group:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->blood_group ?? 'Not specified' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Health Information:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->health_info ?? 'Normal' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Disability:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->disability ?? 'None' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Grew Up In:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->grew_up_in ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Currently Living In:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->living_in ?? ($candidate->city ?? 'N/A') }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Section 2: Contact, Location & KYC -->
                        <div class="col-12 col-lg-6">
                            <div class="card border rounded-3 h-100 p-3 bg-white" style="border: 1px solid rgba(11, 19, 15, 0.08) !important;">
                                <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                                    <i class="bi bi-telephone-inbound fs-5" style="color: var(--brand-forest-medium);"></i>
                                    <h6 class="fw-bold mb-0 text-main">Contact, Location & KYC</h6>
                                </div>
                                <table class="table table-sm table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="table-user-sub" style="width: 40%;">Mobile Phone:</td>
                                            <td>
                                                <div class="d-flex align-items-center gap-2">
                                                    <a href="tel:{{ $candidate->mobile ?? $candidate->phone }}" class="fw-bold font-monospace text-decoration-none" style="color: var(--brand-forest-dark);">
                                                        {{ $candidate->mobile ?? ($candidate->phone ?? 'Not provided') }}
                                                    </a>
                                                    @if($candidate->mobile ?? $candidate->phone)
                                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $candidate->mobile ?? $candidate->phone) }}" target="_blank" class="btn-custom btn-custom-secondary btn-custom-sm py-0 px-1.5" style="font-size: 11px;">
                                                            <i class="bi bi-whatsapp"></i> Chat
                                                        </a>
                                                    @endif
                                                </div>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Email Address:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->email ?? 'Not provided' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Full Address:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->full_address ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">City / District:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->city ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">State:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->state ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Country:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->country ?? 'India' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Police Station:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->police_st ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Pincode / Zip:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->pincode ?? ($candidate->zip_code ?? 'N/A') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Residency Status:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->residency_status ?? 'Citizen / Permanent Resident' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Aadhaar Number:</td>
                                            <td class="fw-bold font-monospace text-main">
                                                {{ $candidate->aadhar_number ? (substr($candidate->aadhar_number, 0, 4) . ' ' . substr($candidate->aadhar_number, 4, 4) . ' ' . substr($candidate->aadhar_number, 8)) : 'Not uploaded' }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Blue Tick Status:</td>
                                            <td>
                                                @if($candidate->is_bluetick_verified ?? false)
                                                    <span class="badge-table success"><i class="bi bi-patch-check-fill"></i> Verified</span>
                                                @else
                                                    <span class="badge-table pending">Unverified / Pending</span>
                                                @endif
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Section 3: Religion & Astro -->
                        <div class="col-12 col-lg-6">
                            <div class="card border rounded-3 h-100 p-3 bg-white" style="border: 1px solid rgba(11, 19, 15, 0.08) !important;">
                                <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                                    <i class="bi bi-moon-stars fs-5 text-warning"></i>
                                    <h6 class="fw-bold mb-0 text-main">Religion, Community & Astro</h6>
                                </div>
                                <table class="table table-sm table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="table-user-sub" style="width: 40%;">Religion:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->religion ?? 'Not specified' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Community / Caste:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->community ?? 'Not specified' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Sub-Community:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->sub_community ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Gothra:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->gothra ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Mother Tongue:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->mother_tongue ?? 'Bengali' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Manglik Status:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->manglik ?? 'Not Manglik' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Birth Time & City:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->time_of_birth ?? 'N/A' }} @if($candidate->city_of_birth) ({{ $candidate->city_of_birth }}) @endif</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Section 4: Education & Profession -->
                        <div class="col-12 col-lg-6">
                            <div class="card border rounded-3 h-100 p-3 bg-white" style="border: 1px solid rgba(11, 19, 15, 0.08) !important;">
                                <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                                    <i class="bi bi-mortarboard fs-5 text-info"></i>
                                    <h6 class="fw-bold mb-0 text-main">Education & Career</h6>
                                </div>
                                <table class="table table-sm table-borderless mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="table-user-sub" style="width: 40%;">Highest Qualification:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->highest_qualification ?? 'Not specified' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">College / University:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->college_name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Working With:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->working_with ?? 'Private Sector' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Profession / Role:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->profession ?? ($candidate->designation ?? 'Not specified') }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Company Name:</td>
                                            <td class="fw-semibold text-main">{{ $candidate->company_name ?? 'N/A' }}</td>
                                        </tr>
                                        <tr>
                                            <td class="table-user-sub">Annual Income:</td>
                                            <td class="fw-bold" style="color: var(--brand-forest-dark);">{{ $candidate->annual_income ?? 'Not disclosed' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <!-- Section 5: Partner Preferences -->
                        <div class="col-12">
                            <div class="card border rounded-3 p-3 bg-white" style="border: 1px solid rgba(11, 19, 15, 0.08) !important;">
                                <div class="d-flex align-items-center gap-2 mb-3 pb-2 border-bottom">
                                    <i class="bi bi-heart fs-5 text-danger"></i>
                                    <h6 class="fw-bold mb-0 text-main">Partner Preferences</h6>
                                </div>
                                <div class="row g-3">
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="table-user-sub">Preferred Age:</div>
                                        <div class="fw-semibold text-main">{{ $candidate->pref_age_min ?? '18' }} to {{ $candidate->pref_age_max ?? '45' }} Yrs</div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="table-user-sub">Preferred Height:</div>
                                        <div class="fw-semibold text-main">{{ $candidate->pref_height_min ?? '4\'5"' }} to {{ $candidate->pref_height_max ?? '6\'5"' }}</div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="table-user-sub">Religion & Caste:</div>
                                        <div class="fw-semibold text-main">{{ $candidate->pref_religion ?? 'Any' }} ({{ $candidate->pref_community ?? 'Any' }})</div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="table-user-sub">Location:</div>
                                        <div class="fw-semibold text-main">{{ $candidate->pref_city ?? ($candidate->pref_state ?? 'Any') }}</div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="table-user-sub">Preferred Education & Job:</div>
                                        <div class="fw-semibold text-main">{{ $candidate->pref_education ?? 'Any' }} / {{ $candidate->pref_working_with ?? 'Any' }}</div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="table-user-sub">Preferred Income:</div>
                                        <div class="fw-semibold text-main">{{ $candidate->pref_annual_income ?? 'Any' }}</div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="table-user-sub">Preferred Diet:</div>
                                        <div class="fw-semibold text-main">{{ $candidate->pref_diet ?? 'Any' }}</div>
                                    </div>
                                    <div class="col-12 col-sm-6 col-md-4 col-lg-3">
                                        <div class="table-user-sub">Managed By:</div>
                                        <div class="fw-semibold text-main">{{ $candidate->pref_profile_managed_by ?? 'Self / Parents' }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ========================================================
                     TAB PANE 2: MATCHED / ACCEPTED CONNECTIONS
                     ======================================================== -->
                <div class="tab-pane fade" id="pane-matched-connections" role="tabpanel">
                    <div class="table-card-custom">
                        <div class="table-header-control">
                            <div>
                                <h6 class="fw-bold mb-0" style="color: var(--text-main);">
                                    <i class="bi bi-heart-fill text-danger me-1"></i> Matched Connections (Mutual Accepted)
                                </h6>
                                <div class="table-user-sub">Candidate pairs where connection requests have been successfully accepted.</div>
                            </div>
                            <span class="badge-table success">
                                {{ $stats['matched_connections_total'] }} Matched Profiles
                            </span>
                        </div>
                        <div class="table-responsive">
                            <table class="table-custom">
                                <thead>
                                    <tr>
                                        <th class="ps-4" style="width: 50px;">#</th>
                                        <th>Matched Partner</th>
                                        <th>Mobile / WhatsApp</th>
                                        <th>Location & Details</th>
                                        <th>Connection Type</th>
                                        <th>Matched / Accepted Date</th>
                                        <th class="text-center pe-4" style="width: 100px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($matchedConnections as $match)
                                        @php $partner = $match->partner; @endphp
                                        <tr>
                                            <td class="ps-4 text-muted fw-bold font-monospace">{{ $loop->iteration }}</td>
                                            <td>
                                                @if($partner)
                                                    <div class="table-user-cell">
                                                        <div class="position-relative flex-shrink-0">
                                                            <img src="{{ $partner->avatar_url }}" alt="{{ $partner->first_name }}" class="table-user-avatar"
                                                                 onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(($partner->first_name ?? 'C').' '.($partner->last_name ?? '')) }}&background=0F4A32&color=fff'">
                                                            @if($partner->is_bluetick_verified ?? false)
                                                                <i class="bi bi-patch-check-fill text-warning position-absolute" style="bottom: -3px; right: -3px; font-size: 13px; background: white; border-radius: 50%;"></i>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <a href="{{ route('admin.candidates.show', $partner->id) }}" class="table-user-name text-decoration-none">
                                                                {{ $partner->first_name }} {{ $partner->last_name }}
                                                            </a>
                                                            <div class="table-user-sub font-monospace">
                                                                {{ $partner->candidate_code ?? $partner->profile_id ?? ('RM' . str_pad($partner->id, 5, '0', STR_PAD_LEFT)) }} 
                                                                <span class="text-muted">({{ ucfirst($partner->gender ?? 'N/A') }})</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Profile removed (ID: {{ $match->request->receiver_id ?? $match->request->sender_id }})</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($partner && ($partner->mobile ?? $partner->phone))
                                                    @php $pPhone = $partner->mobile ?? $partner->phone; @endphp
                                                    <div class="d-flex align-items-center gap-1.5">
                                                        <a href="tel:{{ $pPhone }}" class="fw-bold font-monospace text-decoration-none" style="color: var(--brand-forest-dark);">
                                                            {{ $pPhone }}
                                                        </a>
                                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $pPhone) }}" target="_blank" class="btn-custom btn-custom-secondary btn-custom-sm py-0 px-1.5" style="font-size: 11px;">
                                                            <i class="bi bi-whatsapp"></i> Chat
                                                        </a>
                                                    </div>
                                                @else
                                                    <span class="table-user-sub">Not provided</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($partner)
                                                    <div class="fw-semibold text-main">{{ $partner->city ?? 'N/A' }}, {{ $partner->state ?? ($partner->country ?? 'India') }}</div>
                                                    <div class="table-user-sub">{{ $partner->profession ?? ($partner->religion ?? 'N/A') }}</div>
                                                @else
                                                    <span class="table-user-sub">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($match->type === 'sent')
                                                    <span class="badge bg-primary-subtle text-primary border border-primary-subtle px-2 py-1 rounded-pill small">
                                                        <i class="bi bi-arrow-up-right me-0.5"></i> Sent & Accepted
                                                    </span>
                                                @else
                                                    <span class="badge bg-info-subtle text-info border border-info-subtle px-2 py-1 rounded-pill small">
                                                        <i class="bi bi-arrow-down-left me-0.5"></i> Received & Accepted
                                                    </span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="table-user-sub fw-semibold text-main">
                                                    {{ $match->matched_at ? \Carbon\Carbon::parse($match->matched_at)->format('d M, Y') : 'N/A' }}
                                                </div>
                                                <div class="table-user-sub font-monospace">
                                                    {{ $match->matched_at ? \Carbon\Carbon::parse($match->matched_at)->format('h:i A') : '' }}
                                                </div>
                                            </td>
                                            <td class="text-center pe-4">
                                                @if($partner)
                                                    <a href="{{ route('admin.candidates.show', $partner->id) }}" class="btn-custom btn-custom-primary btn-custom-sm" title="View Matched Candidate">
                                                        <i class="bi bi-eye"></i> Details
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-5 text-muted">
                                                <i class="bi bi-heartbreak fs-2 d-block mb-2 text-muted-green"></i>
                                                <span class="fw-semibold">No accepted/matched connections for this candidate yet.</span>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ========================================================
                     TAB PANE 3: SENT CONNECTION REQUESTS
                     ======================================================== -->
                <div class="tab-pane fade" id="pane-sent-connections" role="tabpanel">
                    <div class="table-card-custom">
                        <div class="table-header-control">
                            <div>
                                <h6 class="fw-bold mb-0" style="color: var(--text-main);">Connection Requests Sent by {{ $candidate->first_name }}</h6>
                                <div class="table-user-sub">All outgoing requests (Pending, Accepted, Declined).</div>
                            </div>
                            <span class="badge-table success">{{ $candidate->sentConnectionRequests->count() }} Sent Requests</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table-custom">
                                <thead>
                                    <tr>
                                        <th class="ps-4" style="width: 50px;">#</th>
                                        <th>Target Profile</th>
                                        <th>Mobile Number</th>
                                        <th>Target Location</th>
                                        <th>Status</th>
                                        <th>Sent Date</th>
                                        <th class="text-center pe-4" style="width: 100px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($candidate->sentConnectionRequests as $req)
                                        @php $target = $req->receiver; @endphp
                                        <tr>
                                            <td class="ps-4 text-muted fw-bold font-monospace">{{ $loop->iteration }}</td>
                                            <td>
                                                @if($target)
                                                    <div class="table-user-cell">
                                                        <img src="{{ $target->avatar_url }}" alt="{{ $target->first_name }}" class="table-user-avatar"
                                                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(($target->first_name ?? 'C').' '.($target->last_name ?? '')) }}&background=0F4A32&color=fff'">
                                                        <div>
                                                            <a href="{{ route('admin.candidates.show', $target->id) }}" class="table-user-name text-decoration-none">
                                                                {{ $target->first_name }} {{ $target->last_name }}
                                                            </a>
                                                            <div class="table-user-sub">
                                                                {{ $target->candidate_code ?? $target->profile_id ?? ('RM' . str_pad($target->id, 5, '0', STR_PAD_LEFT)) }} ({{ ucfirst($target->gender ?? 'N/A') }})
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Target ID: {{ $req->receiver_id }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($target && ($target->mobile ?? $target->phone))
                                                    @php $tPhone = $target->mobile ?? $target->phone; @endphp
                                                    <div class="d-flex align-items-center gap-1.5">
                                                        <a href="tel:{{ $tPhone }}" class="fw-bold font-monospace text-decoration-none" style="color: var(--brand-forest-dark);">
                                                            {{ $tPhone }}
                                                        </a>
                                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $tPhone) }}" target="_blank" class="btn-custom btn-custom-secondary btn-custom-sm py-0 px-1.5" style="font-size: 11px;">
                                                            <i class="bi bi-whatsapp"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <span class="table-user-sub">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($target)
                                                    <div class="fw-semibold text-main">{{ $target->city ?? 'N/A' }}</div>
                                                    <div class="table-user-sub">{{ $target->state ?? ($target->country ?? 'India') }}</div>
                                                @else
                                                    <span class="table-user-sub">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php $status = strtolower($req->status ?? 'pending'); @endphp
                                                @if($status === 'accepted')
                                                    <span class="badge-table success">Accepted</span>
                                                @elseif($status === 'pending')
                                                    <span class="badge-table pending">Pending</span>
                                                @else
                                                    <span class="badge-table failed">{{ ucfirst($status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="table-user-sub">{{ $req->created_at ? $req->created_at->format('d M, Y h:i A') : 'N/A' }}</div>
                                            </td>
                                            <td class="text-center pe-4">
                                                @if($target)
                                                    <a href="{{ route('admin.candidates.show', $target->id) }}" class="table-btn-action" title="View Target Candidate">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">
                                                No connection requests sent yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ========================================================
                     TAB PANE 4: RECEIVED CONNECTION REQUESTS
                     ======================================================== -->
                <div class="tab-pane fade" id="pane-received-connections" role="tabpanel">
                    <div class="table-card-custom">
                        <div class="table-header-control">
                            <div>
                                <h6 class="fw-bold mb-0" style="color: var(--text-main);">Incoming Connection Requests to {{ $candidate->first_name }}</h6>
                                <div class="table-user-sub">All incoming requests (Pending, Accepted, Declined).</div>
                            </div>
                            <span class="badge-table pending">{{ $candidate->receivedConnectionRequests->count() }} Incoming Requests</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table-custom">
                                <thead>
                                    <tr>
                                        <th class="ps-4" style="width: 50px;">#</th>
                                        <th>Sender Profile</th>
                                        <th>Mobile Number</th>
                                        <th>Sender Location</th>
                                        <th>Status</th>
                                        <th>Received Date</th>
                                        <th class="text-center pe-4" style="width: 100px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($candidate->receivedConnectionRequests as $req)
                                        @php $sender = $req->sender; @endphp
                                        <tr>
                                            <td class="ps-4 text-muted fw-bold font-monospace">{{ $loop->iteration }}</td>
                                            <td>
                                                @if($sender)
                                                    <div class="table-user-cell">
                                                        <img src="{{ $sender->avatar_url }}" alt="{{ $sender->first_name }}" class="table-user-avatar"
                                                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(($sender->first_name ?? 'C').' '.($sender->last_name ?? '')) }}&background=0F4A32&color=fff'">
                                                        <div>
                                                            <a href="{{ route('admin.candidates.show', $sender->id) }}" class="table-user-name text-decoration-none">
                                                                {{ $sender->first_name }} {{ $sender->last_name }}
                                                            </a>
                                                            <div class="table-user-sub">
                                                                {{ $sender->candidate_code ?? $sender->profile_id ?? ('RM' . str_pad($sender->id, 5, '0', STR_PAD_LEFT)) }} ({{ ucfirst($sender->gender ?? 'N/A') }})
                                                            </div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Sender ID: {{ $req->sender_id }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($sender && ($sender->mobile ?? $sender->phone))
                                                    @php $sPhone = $sender->mobile ?? $sender->phone; @endphp
                                                    <div class="d-flex align-items-center gap-1.5">
                                                        <a href="tel:{{ $sPhone }}" class="fw-bold font-monospace text-decoration-none" style="color: var(--brand-forest-dark);">
                                                            {{ $sPhone }}
                                                        </a>
                                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sPhone) }}" target="_blank" class="btn-custom btn-custom-secondary btn-custom-sm py-0 px-1.5" style="font-size: 11px;">
                                                            <i class="bi bi-whatsapp"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <span class="table-user-sub">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($sender)
                                                    <div class="fw-semibold text-main">{{ $sender->city ?? 'N/A' }}</div>
                                                    <div class="table-user-sub">{{ $sender->state ?? ($sender->country ?? 'India') }}</div>
                                                @else
                                                    <span class="table-user-sub">N/A</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php $status = strtolower($req->status ?? 'pending'); @endphp
                                                @if($status === 'accepted')
                                                    <span class="badge-table success">Accepted</span>
                                                @elseif($status === 'pending')
                                                    <span class="badge-table pending">Pending</span>
                                                @else
                                                    <span class="badge-table failed">{{ ucfirst($status) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="table-user-sub">{{ $req->created_at ? $req->created_at->format('d M, Y h:i A') : 'N/A' }}</div>
                                            </td>
                                            <td class="text-center pe-4">
                                                @if($sender)
                                                    <a href="{{ route('admin.candidates.show', $sender->id) }}" class="table-btn-action" title="View Sender Candidate">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">
                                                No incoming connection requests received.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ========================================================
                     TAB PANE 5: SENT WHATSAPP REQUESTS
                     ======================================================== -->
                <div class="tab-pane fade" id="pane-sent-whatsapp" role="tabpanel">
                    <div class="table-card-custom">
                        <div class="table-header-control">
                            <h6 class="fw-bold mb-0" style="color: var(--text-main);">WhatsApp Requests Sent by {{ $candidate->first_name }}</h6>
                            <span class="badge-table success">{{ $candidate->sentWhatsAppRequests->count() }} Total</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table-custom">
                                <thead>
                                    <tr>
                                        <th class="ps-4" style="width: 50px;">#</th>
                                        <th>Target Profile</th>
                                        <th>WhatsApp Mobile Number</th>
                                        <th>Status</th>
                                        <th>Sent Date</th>
                                        <th>Response Date</th>
                                        <th class="text-center pe-4" style="width: 100px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($candidate->sentWhatsAppRequests as $wa)
                                        @php $target = $wa->receiver; @endphp
                                        <tr>
                                            <td class="ps-4 text-muted fw-bold font-monospace">{{ $loop->iteration }}</td>
                                            <td>
                                                @if($target)
                                                    <div class="table-user-cell">
                                                        <img src="{{ $target->avatar_url }}" alt="{{ $target->first_name }}" class="table-user-avatar"
                                                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(($target->first_name ?? 'C').' '.($target->last_name ?? '')) }}&background=0F4A32&color=fff'">
                                                        <div>
                                                            <a href="{{ route('admin.candidates.show', $target->id) }}" class="table-user-name text-decoration-none">
                                                                {{ $target->first_name }} {{ $target->last_name }}
                                                            </a>
                                                            <div class="table-user-sub">{{ $target->candidate_code ?? $target->profile_id }}</div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Target ID: {{ $wa->receiver_id }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($target && ($target->mobile ?? $target->phone))
                                                    @php $tPhone = $target->mobile ?? $target->phone; @endphp
                                                    <div class="d-flex align-items-center gap-1.5">
                                                        <span class="fw-bold font-monospace" style="color: var(--brand-forest-dark);">{{ $tPhone }}</span>
                                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $tPhone) }}" target="_blank" class="btn-custom btn-custom-secondary btn-custom-sm py-0 px-1.5" style="font-size: 11px;">
                                                            <i class="bi bi-whatsapp"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <span class="table-user-sub">Not provided</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php $waStatus = strtolower($wa->status ?? 'pending'); @endphp
                                                @if($waStatus === 'accepted')
                                                    <span class="badge-table success">Accepted</span>
                                                @elseif($waStatus === 'pending')
                                                    <span class="badge-table pending">Pending</span>
                                                @else
                                                    <span class="badge-table failed">{{ ucfirst($waStatus) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="table-user-sub">{{ $wa->created_at ? $wa->created_at->format('d M, Y h:i A') : 'N/A' }}</div>
                                            </td>
                                            <td>
                                                <div class="table-user-sub">{{ $wa->responded_at ? $wa->responded_at->format('d M, Y h:i A') : 'Awaiting response' }}</div>
                                            </td>
                                            <td class="text-center pe-4">
                                                @if($target)
                                                    <a href="{{ route('admin.candidates.show', $target->id) }}" class="table-btn-action" title="View Target Profile">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">
                                                No WhatsApp chat requests sent yet.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ========================================================
                     TAB PANE 6: RECEIVED WHATSAPP REQUESTS
                     ======================================================== -->
                <div class="tab-pane fade" id="pane-received-whatsapp" role="tabpanel">
                    <div class="table-card-custom">
                        <div class="table-header-control">
                            <h6 class="fw-bold mb-0" style="color: var(--text-main);">Incoming WhatsApp Requests to {{ $candidate->first_name }}</h6>
                            <span class="badge-table pending">{{ $candidate->receivedWhatsAppRequests->count() }} Total</span>
                        </div>
                        <div class="table-responsive">
                            <table class="table-custom">
                                <thead>
                                    <tr>
                                        <th class="ps-4" style="width: 50px;">#</th>
                                        <th>Sender Profile</th>
                                        <th>Sender Mobile Number</th>
                                        <th>Status</th>
                                        <th>Date Received</th>
                                        <th>Response Date</th>
                                        <th class="text-center pe-4" style="width: 100px;">Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($candidate->receivedWhatsAppRequests as $wa)
                                        @php $sender = $wa->sender; @endphp
                                        <tr>
                                            <td class="ps-4 text-muted fw-bold font-monospace">{{ $loop->iteration }}</td>
                                            <td>
                                                @if($sender)
                                                    <div class="table-user-cell">
                                                        <img src="{{ $sender->avatar_url }}" alt="{{ $sender->first_name }}" class="table-user-avatar"
                                                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(($sender->first_name ?? 'C').' '.($sender->last_name ?? '')) }}&background=0F4A32&color=fff'">
                                                        <div>
                                                            <a href="{{ route('admin.candidates.show', $sender->id) }}" class="table-user-name text-decoration-none">
                                                                {{ $sender->first_name }} {{ $sender->last_name }}
                                                            </a>
                                                            <div class="table-user-sub">{{ $sender->candidate_code ?? $sender->profile_id }}</div>
                                                        </div>
                                                    </div>
                                                @else
                                                    <span class="text-muted">Sender ID: {{ $wa->sender_id }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if($sender && ($sender->mobile ?? $sender->phone))
                                                    @php $sPhone = $sender->mobile ?? $sender->phone; @endphp
                                                    <div class="d-flex align-items-center gap-1.5">
                                                        <span class="fw-bold font-monospace" style="color: var(--brand-forest-dark);">{{ $sPhone }}</span>
                                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $sPhone) }}" target="_blank" class="btn-custom btn-custom-secondary btn-custom-sm py-0 px-1.5" style="font-size: 11px;">
                                                            <i class="bi bi-whatsapp"></i>
                                                        </a>
                                                    </div>
                                                @else
                                                    <span class="table-user-sub">Not provided</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php $waStatus = strtolower($wa->status ?? 'pending'); @endphp
                                                @if($waStatus === 'accepted')
                                                    <span class="badge-table success">Accepted</span>
                                                @elseif($waStatus === 'pending')
                                                    <span class="badge-table pending">Pending</span>
                                                @else
                                                    <span class="badge-table failed">{{ ucfirst($waStatus) }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="table-user-sub">{{ $wa->created_at ? $wa->created_at->format('d M, Y h:i A') : 'N/A' }}</div>
                                            </td>
                                            <td>
                                                <div class="table-user-sub">{{ $wa->responded_at ? $wa->responded_at->format('d M, Y h:i A') : 'Awaiting response' }}</div>
                                            </td>
                                            <td class="text-center pe-4">
                                                @if($sender)
                                                    <a href="{{ route('admin.candidates.show', $sender->id) }}" class="table-btn-action" title="View Sender Profile">
                                                        <i class="bi bi-eye"></i>
                                                    </a>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">
                                                No incoming WhatsApp chat requests received.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- ========================================================
                     TAB PANE 7: PHOTO GALLERY
                     ======================================================== -->
                <div class="tab-pane fade" id="pane-photos" role="tabpanel">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="fw-bold mb-0 text-main">Uploaded Photo Gallery</h6>
                        <span class="badge-table success">{{ $candidate->photos->count() }} Photos</span>
                    </div>

                    <div class="row g-3">
                        @forelse($candidate->photos as $photo)
                            <div class="col-6 col-sm-4 col-md-3 col-lg-2">
                                <div class="card border rounded-3 overflow-hidden h-100 shadow-xs">
                                    <div class="position-relative" style="height: 160px;">
                                        <img src="{{ asset('storage/' . $photo->photo_path) }}" 
                                             alt="Candidate Photo" 
                                             class="w-100 h-100 object-fit-cover">
                                        @if($photo->is_profile_picture)
                                            <span class="badge position-absolute top-0 start-0 m-1.5 shadow-sm" 
                                                  style="background-color: var(--brand-forest-medium); color: #fff; font-size: 10px;">
                                                <i class="bi bi-star-fill me-0.5"></i> Primary
                                            </span>
                                        @endif
                                    </div>
                                    @if($photo->caption)
                                        <div class="p-1.5 text-center table-user-sub text-truncate">
                                            {{ $photo->caption }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <div class="col-12 text-center py-5 text-muted">
                                <i class="bi bi-images fs-2 d-block mb-2 text-muted-green"></i>
                                <span>No photo gallery images uploaded by this candidate.</span>
                            </div>
                        @endforelse
                    </div>
                </div>

                <!-- ========================================================
                     TAB PANE 8: WALLET LEDGER
                     ======================================================== -->
                <div class="tab-pane fade" id="pane-wallet" role="tabpanel">
                    <div class="table-card-custom">
                        <div class="table-header-control">
                            <div>
                                <h6 class="fw-bold mb-0 text-main">Wallet Transactions History</h6>
                                <div class="table-user-sub">Wallet ID: <strong class="font-monospace text-main">{{ $candidate->wallet->wallet_id ?? 'N/A' }}</strong></div>
                            </div>
                            <a href="{{ route('admin.transactions.index', ['search' => $candidate->candidate_code ?? $candidate->first_name]) }}" class="btn-custom btn-custom-light btn-custom-sm">
                                <i class="bi bi-search"></i> Full Ledger
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table-custom">
                                <thead>
                                    <tr>
                                        <th class="ps-4" style="width: 50px;">#</th>
                                        <th>Txn ID</th>
                                        <th>Type</th>
                                        <th>Amount</th>
                                        <th>Title & Details</th>
                                        <th>Status</th>
                                        <th class="text-end pe-4">Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($candidate->wallet && $candidate->wallet->transactions)
                                        @forelse($candidate->wallet->transactions as $txn)
                                            @php $isCredit = strtolower($txn->type) === 'credit'; @endphp
                                            <tr>
                                                <td class="ps-4 text-muted fw-bold font-monospace">{{ $loop->iteration }}</td>
                                                <td class="font-monospace fw-semibold text-main small">
                                                    {{ $txn->transaction_id ?? ('TXN-' . $txn->id) }}
                                                </td>
                                                <td>
                                                    <span class="badge-table {{ $isCredit ? 'success' : 'failed' }}">
                                                        {{ ucfirst($txn->type) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="fw-bold font-monospace {{ $isCredit ? 'text-success' : 'text-danger' }}">
                                                        {{ $isCredit ? '+' : '-' }}₹{{ number_format((float) $txn->amount, 2) }}
                                                    </span>
                                                </td>
                                                <td>
                                                    <div class="fw-semibold text-main small">{{ $txn->title ?? 'Transaction' }}</div>
                                                    <div class="table-user-sub">{{ $txn->description }}</div>
                                                </td>
                                                <td>
                                                    <span class="badge-table success">{{ ucfirst($txn->status ?? 'completed') }}</span>
                                                </td>
                                                <td class="text-end pe-4">
                                                    <div class="table-user-sub">{{ $txn->created_at ? $txn->created_at->format('d M, Y h:i A') : 'N/A' }}</div>
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center py-4 text-muted">
                                                    No transactions recorded on this candidate's wallet.
                                                </td>
                                            </tr>
                                        @endforelse
                                    @else
                                        <tr>
                                            <td colspan="7" class="text-center py-4 text-muted">
                                                No wallet transactions found.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Tabbed Content Container -->

</div>
@endsection
