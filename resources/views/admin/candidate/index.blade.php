@extends('admin.layouts.app')

@section('title', 'Candidates Management - Rani Matrimonial')

@section('content')
<div class="container-fluid p-0">

    <!-- START: Page Header Banner -->
    <div class="page-header d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h1 class="page-title mb-0">Candidates Directory</h1>
                <span class="badge-table success ms-2">
                    {{ number_format($counts['all'] ?? 0) }} Total Profiles
                </span>
            </div>
            <p class="page-subtitle mb-0">Browse, filter, inspect profiles, and manage matrimony candidates with live verification status.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn-custom btn-custom-light btn-custom-sm">
                <i class="bi bi-arrow-left"></i>
                <span>Dashboard</span>
            </a>
        </div>
    </div>
    <!-- END: Page Header Banner -->

    <!-- START: Refined Table Container -->
    <div class="table-card-custom">
        
        <!-- START: Header Control & Filters -->
        <div class="table-header-control">
            <!-- Filter Tabs: All, Male, Female -->
            <div class="d-flex flex-wrap align-items-center gap-2">
                <a href="{{ route('admin.candidates.index', ['gender' => 'all', 'search' => $search]) }}" 
                   class="btn-custom btn-custom-sm {{ $gender === 'all' ? 'btn-custom-primary' : 'btn-custom-light' }}">
                    All Candidates ({{ $counts['all'] ?? 0 }})
                </a>
                <a href="{{ route('admin.candidates.index', ['gender' => 'male', 'search' => $search]) }}" 
                   class="btn-custom btn-custom-sm {{ $gender === 'male' ? 'btn-custom-primary' : 'btn-custom-light' }}">
                    <i class="bi bi-gender-male"></i> Male / Grooms ({{ $counts['male'] ?? 0 }})
                </a>
                <a href="{{ route('admin.candidates.index', ['gender' => 'female', 'search' => $search]) }}" 
                   class="btn-custom btn-custom-sm {{ $gender === 'female' ? 'btn-custom-primary' : 'btn-custom-light' }}">
                    <i class="bi bi-gender-female"></i> Female / Brides ({{ $counts['female'] ?? 0 }})
                </a>
            </div>

            <!-- Search Form -->
            <form method="GET" action="{{ route('admin.candidates.index') }}" class="table-search-box m-0">
                <input type="hidden" name="gender" value="{{ $gender }}">
                <i class="bi bi-search table-search-icon"></i>
                <input type="text" 
                       name="search" 
                       class="table-search-input" 
                       placeholder="Search name, phone, RM code, city..." 
                       value="{{ $search }}">
            </form>
        </div>
        <!-- END: Header Control & Filters -->

        <!-- START: Responsive Custom Table -->
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 60px;">#</th>
                        <th>Candidate Profile</th>
                        <th>Mobile / Phone</th>
                        <th>RM Code & Gender</th>
                        <th>Location</th>
                        <th>Religion / Community</th>
                        <th>Verification</th>
                        <th>Registered Date</th>
                        <th class="text-center pe-4" style="width: 140px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($candidates as $candidate)
                        @php
                            $phoneNum = $candidate->mobile ?? ($candidate->phone ?? null);
                        @endphp
                        <tr>
                            <td class="ps-4 text-muted fw-bold font-monospace">
                                {{ (($candidates->currentPage() - 1) * $candidates->perPage()) + $loop->iteration }}
                            </td>
                            <td>
                                <div class="table-user-cell">
                                    <div class="position-relative flex-shrink-0">
                                        <img src="{{ $candidate->avatar_url }}" 
                                             alt="{{ $candidate->first_name }}" 
                                             class="table-user-avatar"
                                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(($candidate->first_name ?? 'C').' '.($candidate->last_name ?? '')) }}&background=0F4A32&color=fff'">
                                        @if($candidate->is_bluetick_verified ?? false)
                                            <i class="bi bi-patch-check-fill text-warning position-absolute" 
                                               style="bottom: -3px; right: -3px; font-size: 14px; background: #fff; border-radius: 50%;" 
                                               title="Aadhaar Verified"></i>
                                        @endif
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.candidates.show', $candidate->id) }}" class="table-user-name text-decoration-none d-block">
                                            {{ $candidate->first_name }} {{ $candidate->last_name }}
                                        </a>
                                        <div class="table-user-sub">
                                            <i class="bi bi-envelope me-1"></i>{{ $candidate->email ?? 'No email' }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                @if($phoneNum)
                                    <div class="d-flex align-items-center gap-2">
                                        <a href="tel:{{ $phoneNum }}" class="fw-bold font-monospace text-decoration-none" style="color: var(--brand-forest-dark);">
                                            <i class="bi bi-telephone-fill text-muted-green me-1"></i>{{ $phoneNum }}
                                        </a>
                                        <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $phoneNum) }}" 
                                           target="_blank" 
                                           class="btn-custom btn-custom-secondary btn-custom-sm py-0 px-1.5" 
                                           title="Chat on WhatsApp" 
                                           style="font-size: 11px; height: 22px; line-height: 22px;">
                                            <i class="bi bi-whatsapp"></i>
                                        </a>
                                    </div>
                                @else
                                    <span class="text-muted small italic">Not provided</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border font-monospace px-2 py-1">
                                    {{ $candidate->candidate_code ?? $candidate->profile_id ?? ('RM' . str_pad($candidate->id, 5, '0', STR_PAD_LEFT)) }}
                                </span>
                                <div class="table-user-sub mt-1">
                                    @if(strtolower($candidate->gender ?? '') === 'male')
                                        <span class="text-info fw-semibold"><i class="bi bi-gender-male"></i> Male</span>
                                    @elseif(strtolower($candidate->gender ?? '') === 'female')
                                        <span class="text-danger fw-semibold"><i class="bi bi-gender-female"></i> Female</span>
                                    @else
                                        <span>{{ ucfirst($candidate->gender ?? 'N/A') }}</span>
                                    @endif
                                    @if($candidate->dob)
                                        <span>({{ \Carbon\Carbon::parse($candidate->dob)->age }} yrs)</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold" style="color: var(--text-main);">{{ $candidate->city ?? 'N/A' }}</div>
                                <div class="table-user-sub">{{ $candidate->state ?? ($candidate->country ?? 'India') }}</div>
                            </td>
                            <td>
                                <div class="fw-semibold" style="color: var(--text-main);">{{ $candidate->religion ?? 'N/A' }}</div>
                                <div class="table-user-sub">{{ $candidate->community ?? 'N/A' }}</div>
                            </td>
                            <td>
                                @if($candidate->is_bluetick_verified ?? false)
                                    <span class="badge-table success">
                                        <i class="bi bi-patch-check-fill"></i> Verified
                                    </span>
                                @else
                                    <span class="badge-table pending">
                                        Standard
                                    </span>
                                @endif
                            </td>
                            <td>
                                <div class="table-user-sub">{{ $candidate->created_at ? $candidate->created_at->format('d M, Y') : 'N/A' }}</div>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex align-items-center justify-content-center gap-1.5">
                                    <a href="{{ route('admin.candidates.show', $candidate->id) }}" 
                                       class="btn-custom btn-custom-primary btn-custom-sm" 
                                       title="View Full Profile Details & Activity">
                                        <i class="bi bi-person-lines-fill"></i> Details
                                    </a>
                                    <a href="{{ url('/candidate/' . ($candidate->candidate_code ?? $candidate->id)) }}" 
                                       target="_blank" 
                                       class="table-btn-action" 
                                       title="Public Profile Preview">
                                        <i class="bi bi-box-arrow-up-right"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="bi bi-people fs-2 d-block mb-2 text-muted-green"></i>
                                <span class="fw-semibold">No candidates match your criteria.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- END: Responsive Custom Table -->

        <!-- START: Table Pagination Footer -->
        @if($candidates->hasPages())
        <div class="p-3 bg-white border-top d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            <div class="table-user-sub">
                Showing {{ $candidates->firstItem() ?? 0 }} to {{ $candidates->lastItem() ?? 0 }} of {{ number_format($candidates->total()) }} candidates
            </div>
            <div>
                {{ $candidates->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
        <!-- END: Table Pagination Footer -->

    </div>
    <!-- END: Refined Table Container -->

</div>
@endsection
