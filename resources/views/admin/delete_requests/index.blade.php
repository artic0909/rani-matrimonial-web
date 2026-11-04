@extends('admin.layouts.app')

@section('title', 'Account Deletion Requests - Admin Panel')

@push('styles')
<style>
    .badge-pending {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
    }
    .badge-approved {
        background-color: #f8d7da;
        color: #721c24;
        border: 1px solid #f5c6cb;
    }
    .badge-rejected {
        background-color: #e2e3e5;
        color: #383d41;
        border: 1px solid #d6d8db;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">

    <!-- Page Title & Header Actions -->
    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
            <h1 class="h3 d-inline align-middle text-dark fw-bold">Account Deletion Requests</h1>
            <p class="text-muted small mb-0">Review candidate account deletion requests, verify reasons, and approve or reject.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="{{ route('admin.delete-requests.index') }}" class="btn-custom btn-custom-light btn-custom-sm rounded-pill px-3">
                <i class="bi bi-arrow-clockwise"></i> Refresh List
            </a>
        </div>
    </div>

    <!-- Stats Overview Tiles -->
    <div class="row mb-4">
        <div class="col-sm-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary-subtle text-primary p-3 rounded-4 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-person-x fs-4"></i>
                        </div>
                        <div>
                            <span class="text-muted small text-uppercase fw-bold">Total Requests</span>
                            <h3 class="fw-bold mb-0 text-dark">{{ $counts['total'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning-subtle text-warning p-3 rounded-4 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-clock-history fs-4"></i>
                        </div>
                        <div>
                            <span class="text-muted small text-uppercase fw-bold">Pending Review</span>
                            <h3 class="fw-bold mb-0 text-warning">{{ $counts['pending'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-danger-subtle text-danger p-3 rounded-4 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-check2-circle fs-4"></i>
                        </div>
                        <div>
                            <span class="text-muted small text-uppercase fw-bold">Approved</span>
                            <h3 class="fw-bold mb-0 text-danger">{{ $counts['approved'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-secondary-subtle text-secondary p-3 rounded-4 me-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px;">
                            <i class="bi bi-x-circle fs-4"></i>
                        </div>
                        <div>
                            <span class="text-muted small text-uppercase fw-bold">Rejected</span>
                            <h3 class="fw-bold mb-0 text-secondary">{{ $counts['rejected'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.delete-requests.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-6">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i class="bi bi-search text-muted"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-0" placeholder="Search by candidate name, code, phone, or reason..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select bg-light border-0" onchange="this.form.submit()">
                        <option value="">All Statuses</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending Review</option>
                        <option value="approved" {{ request('status') === 'approved' ? 'selected' : '' }}>Approved</option>
                        <option value="rejected" {{ request('status') === 'rejected' ? 'selected' : '' }}>Rejected</option>
                    </select>
                </div>
                <div class="col-md-3 text-md-end">
                    <button type="submit" class="btn-custom btn-custom-primary btn-custom-sm px-3">Filter</button>
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.delete-requests.index') }}" class="btn-custom btn-custom-light btn-custom-sm px-2">Clear</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Deletion Requests Table Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white border-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold text-dark mb-0">Deletion Requests Ledger</h5>
            <span class="badge bg-light text-muted border px-2 py-1">{{ $requests->total() }} Total</span>
        </div>
        <div class="card-body px-0 pt-0 pb-3">
            <div class="table-responsive">
                <table class="table-custom">
                    <thead>
                        <tr>
                            <th class="ps-4" style="width: 60px;">#ID</th>
                            <th>Candidate Details</th>
                            <th>Deletion Reason</th>
                            <th>Status</th>
                            <th>Requested At</th>
                            <th class="text-center pe-4" style="width: 170px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($requests as $req)
                            <tr id="req-row-{{ $req->id }}">
                                <td class="ps-4 font-monospace fw-bold text-muted">#{{ $req->id }}</td>
                                <td>
                                    @if($req->candidate)
                                        <div class="d-flex align-items-center">
                                            <div class="me-2">
                                                <img src="{{ $req->candidate->avatar_url }}" alt="avatar" class="rounded-circle" style="width: 38px; height: 38px; object-fit: cover;">
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark">
                                                    <a href="{{ route('admin.candidates.show', $req->candidate->id) }}" class="text-dark text-decoration-none">
                                                        {{ $req->candidate->first_name }} {{ $req->candidate->last_name }}
                                                    </a>
                                                </div>
                                                <div class="small text-muted font-monospace">
                                                    {{ $req->candidate->display_code }}
                                                </div>
                                                <div class="small text-muted">
                                                    <i class="bi bi-telephone text-success me-1"></i> {{ $req->candidate->phone }}
                                                </div>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted">Deleted Candidate (#{{ $req->candidate_id }})</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="p-2 rounded bg-light border text-dark small" style="max-width: 340px; word-break: break-word;">
                                        {{ $req->reason }}
                                    </div>
                                    @if($req->admin_notes)
                                        <div class="small text-muted mt-1">
                                            <i class="bi bi-info-circle me-1"></i> Note: {{ $req->admin_notes }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($req->status === 'approved')
                                        <span class="badge badge-approved rounded-pill px-3 py-1 fw-bold">
                                            <i class="bi bi-check-circle-fill me-1"></i> Approved
                                        </span>
                                    @elseif($req->status === 'rejected')
                                        <span class="badge badge-rejected rounded-pill px-3 py-1 fw-bold">
                                            <i class="bi bi-x-circle-fill me-1"></i> Rejected
                                        </span>
                                    @else
                                        <span class="badge badge-pending rounded-pill px-3 py-1 fw-bold">
                                            <i class="bi bi-clock-fill me-1"></i> Pending
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="table-user-sub">{{ $req->created_at ? $req->created_at->format('d M, Y') : 'N/A' }}</div>
                                    <div class="text-muted small">{{ $req->created_at ? $req->created_at->format('h:i A') : '' }}</div>
                                </td>
                                <td class="text-center pe-4">
                                    <div class="d-flex align-items-center justify-content-center gap-1.5">
                                        @if($req->status === 'pending')
                                            <form action="{{ route('admin.delete-requests.approve', $req->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Approve account deletion for this candidate? Their profile will remain deactivated.')">
                                                @csrf
                                                <button type="submit" class="btn-custom btn-custom-danger btn-custom-sm py-1 px-2.5" title="Approve Deletion">
                                                    <i class="bi bi-check-lg"></i> Approve
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.delete-requests.reject', $req->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Reject deletion request and reactivate candidate profile?')">
                                                @csrf
                                                <button type="submit" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2 text-secondary" title="Reject Deletion">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        @endif
                                        <form action="{{ route('admin.delete-requests.destroy', $req->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this deletion request record?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2 text-danger" title="Delete Record">
                                                <i class="bi bi-trash3-fill"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i class="bi bi-inbox fs-1 d-block mb-2 text-muted"></i>
                                    <p class="mb-0">No account deletion requests found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($requests->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                {{ $requests->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

</div>
@endsection

