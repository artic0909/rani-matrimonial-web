@extends('admin.layouts.app')

@section('title', 'Candidates Management - Rani Matrimonial')

@section('content')
<div class="container-fluid p-0">

    <!-- START: Page Header -->
    <div class="page-header d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <i class="bi bi-people-fill fs-4 text-primary"></i>
                <h1 class="page-title mb-0">Candidates Directory</h1>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 ms-2">
                    {{ number_format($counts['all'] ?? 0) }} Total
                </span>
            </div>
            <p class="page-subtitle mb-0">Browse, filter, and inspect registered candidate matrimony profiles.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1.5 px-3 py-2 rounded-3">
                <i class="bi bi-arrow-left"></i>
                <span>Dashboard</span>
            </a>
        </div>
    </div>
    <!-- END: Page Header -->

    <!-- START: Metric Filter Tabs & Search Bar -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-3">
            <div class="row g-3 align-items-center justify-content-between">
                
                <!-- Filter Tabs: All, Male, Female -->
                <div class="col-12 col-md-6">
                    <ul class="nav nav-pills gap-2" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link px-3 py-1.5 rounded-pill {{ $gender === 'all' ? 'active bg-primary text-white fw-semibold' : 'bg-light text-dark' }}" 
                               href="{{ route('admin.candidates.index', ['gender' => 'all', 'search' => $search]) }}">
                                All Profiles <span class="badge bg-white text-dark ms-1">{{ $counts['all'] ?? 0 }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 py-1.5 rounded-pill {{ $gender === 'male' ? 'active bg-primary text-white fw-semibold' : 'bg-light text-dark' }}" 
                               href="{{ route('admin.candidates.index', ['gender' => 'male', 'search' => $search]) }}">
                                <i class="bi bi-gender-male me-1 text-info"></i> Male / Grooms 
                                <span class="badge bg-white text-dark ms-1">{{ $counts['male'] ?? 0 }}</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 py-1.5 rounded-pill {{ $gender === 'female' ? 'active bg-primary text-white fw-semibold' : 'bg-light text-dark' }}" 
                               href="{{ route('admin.candidates.index', ['gender' => 'female', 'search' => $search]) }}">
                                <i class="bi bi-gender-female me-1 text-danger"></i> Female / Brides 
                                <span class="badge bg-white text-dark ms-1">{{ $counts['female'] ?? 0 }}</span>
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Live Search Form -->
                <div class="col-12 col-md-5 col-lg-4">
                    <form method="GET" action="{{ route('admin.candidates.index') }}" class="input-group">
                        <input type="hidden" name="gender" value="{{ $gender }}">
                        <span class="input-group-text bg-light border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               class="form-control bg-light border-start-0 ps-0" 
                               placeholder="Search by name, RM ID, city, phone..." 
                               value="{{ $search }}">
                        @if(!empty($search))
                            <a href="{{ route('admin.candidates.index', ['gender' => $gender]) }}" class="btn btn-light border border-start-0 text-muted">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Metric Filter Tabs & Search Bar -->

    <!-- START: Candidates Table Card -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="small text-muted text-uppercase">
                            <th class="ps-4" style="width: 70px;">#</th>
                            <th>Candidate</th>
                            <th>Code & Gender</th>
                            <th>Location</th>
                            <th>Religion / Caste</th>
                            <th>Verification</th>
                            <th>Joined</th>
                            <th class="text-end pe-4" style="width: 100px;">Details</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($candidates as $candidate)
                            <tr>
                                <td class="ps-4 fw-bold text-muted font-monospace">
                                    {{ (($candidates->currentPage() - 1) * $candidates->perPage()) + $loop->iteration }}
                                </td>
                                <td>
                                    <div class="d-flex align-items-center gap-2.5">
                                        <div class="position-relative">
                                            @php
                                                $photo = $candidate->photos->firstWhere('is_primary', true) ?? $candidate->photos->first();
                                                $photoUrl = $photo ? asset('storage/' . $photo->photo_path) : null;
                                            @endphp
                                            @if($photoUrl)
                                                <img src="{{ $photoUrl }}" alt="{{ $candidate->first_name }}" class="rounded-circle object-fit-cover" width="40" height="40" style="border: 2px solid #dee2e6;">
                                            @else
                                                <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-xs" 
                                                     style="width: 40px; height: 40px; background: {{ strtolower($candidate->gender) === 'female' ? '#dc3545' : '#0d6efd' }}; font-size: 14px;">
                                                    {{ strtoupper(substr($candidate->first_name ?? 'C', 0, 1)) }}
                                                </div>
                                            @endif
                                            @if($candidate->is_bluetick_verified ?? false)
                                                <i class="bi bi-patch-check-fill text-warning position-absolute" style="bottom: -2px; right: -2px; font-size: 14px; background: white; border-radius: 50%;"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="fw-bold text-dark">
                                                {{ $candidate->first_name }} {{ $candidate->last_name }}
                                            </div>
                                            <div class="small text-muted">
                                                <i class="bi bi-envelope me-1"></i>{{ $candidate->email ?? 'No email' }}
                                                @if($candidate->phone)
                                                    <span class="mx-1">•</span> <i class="bi bi-telephone me-1"></i>{{ $candidate->phone }}
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge bg-light text-dark border font-monospace px-2 py-1">
                                        {{ $candidate->candidate_code ?? ('RM' . str_pad($candidate->id, 5, '0', STR_PAD_LEFT)) }}
                                    </span>
                                    <div class="small mt-1">
                                        @if(strtolower($candidate->gender) === 'male')
                                            <span class="text-info fw-semibold"><i class="bi bi-gender-male me-0.5"></i> Male</span>
                                        @elseif(strtolower($candidate->gender) === 'female')
                                            <span class="text-danger fw-semibold"><i class="bi bi-gender-female me-0.5"></i> Female</span>
                                        @else
                                            <span class="text-muted">{{ ucfirst($candidate->gender ?? 'N/A') }}</span>
                                        @endif
                                        @if($candidate->age)
                                            <span class="text-muted">({{ $candidate->age }} yrs)</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $candidate->city ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $candidate->state ?? ($candidate->country ?? 'India') }}</small>
                                </td>
                                <td>
                                    <div class="fw-semibold text-dark">{{ $candidate->religion ?? 'N/A' }}</div>
                                    <small class="text-muted">{{ $candidate->community ?? 'N/A' }}</small>
                                </td>
                                <td>
                                    @if($candidate->is_bluetick_verified ?? false)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1">
                                            <i class="bi bi-patch-check-fill me-1"></i> Verified
                                        </span>
                                    @else
                                        <span class="badge bg-secondary-subtle text-secondary px-2 py-1">
                                            Standard
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">{{ $candidate->created_at ? $candidate->created_at->format('d M, Y') : 'N/A' }}</small>
                                </td>
                                <td class="text-end pe-4">
                                    <a href="{{ url('/candidate/' . ($candidate->candidate_code ?? $candidate->id)) }}" target="_blank" class="btn btn-sm btn-outline-secondary rounded-3" title="View Public Profile">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-people fs-2 text-muted d-block mb-2"></i>
                                    <span class="fw-semibold">No candidates match your criteria.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card Footer: Pagination -->
        @if($candidates->hasPages())
        <div class="card-footer bg-white border-top p-3 d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            <div class="small text-muted">
                Showing {{ $candidates->firstItem() ?? 0 }} to {{ $candidates->lastItem() ?? 0 }} of {{ number_format($candidates->total()) }} candidates
            </div>
            <div>
                {{ $candidates->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
    <!-- END: Candidates Table Card -->

</div>
@endsection
