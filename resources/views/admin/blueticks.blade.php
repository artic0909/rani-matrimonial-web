@extends('admin.layouts.app')

@section('title', 'Blue Tick Verification Requests - Rani Matrimonial')

@section('content')
<div class="container-fluid p-0">

    <!-- START: Page Header Banner -->
    <div class="page-header d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <i class="bi bi-patch-check-fill text-warning fs-4"></i>
                <h1 class="page-title mb-0">Blue Tick Verifications</h1>
                <span class="badge-table success ms-2">
                    {{ number_format($requests->total()) }} Total Requests
                </span>
            </div>
            <p class="page-subtitle mb-0">Review Aadhaar identity verification submissions and approve genuine Blue Tick Verified badges.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn-custom btn-custom-light btn-custom-sm">
                <i class="bi bi-arrow-left"></i>
                <span>Dashboard</span>
            </a>
        </div>
    </div>
    <!-- END: Page Header Banner -->

    <!-- START: Table Container -->
    <div class="table-card-custom">
        
        <!-- START: Header Control & Filters -->
        <div class="table-header-control">
            <!-- Filter Tabs -->
            <div class="d-flex flex-wrap align-items-center gap-2">
                <a href="{{ route('admin.blueticks', ['status' => 'all']) }}" 
                   class="btn-custom btn-custom-sm {{ ($status ?? 'all') === 'all' ? 'btn-custom-primary' : 'btn-custom-light' }}">
                    All Submissions
                </a>
                <a href="{{ route('admin.blueticks', ['status' => 'pending']) }}" 
                   class="btn-custom btn-custom-sm {{ ($status ?? '') === 'pending' ? 'btn-custom-warning' : 'btn-custom-light' }}">
                    <i class="bi bi-clock-history"></i> Pending Verification
                </a>
                <a href="{{ route('admin.blueticks', ['status' => 'approved']) }}" 
                   class="btn-custom btn-custom-sm {{ ($status ?? '') === 'approved' ? 'btn-custom-secondary' : 'btn-custom-light' }}">
                    <i class="bi bi-patch-check-fill"></i> Approved
                </a>
                <a href="{{ route('admin.blueticks', ['status' => 'rejected']) }}" 
                   class="btn-custom btn-custom-sm {{ ($status ?? '') === 'rejected' ? 'btn-custom-danger' : 'btn-custom-light' }}">
                    <i class="bi bi-x-circle"></i> Rejected
                </a>
            </div>
        </div>
        <!-- END: Header Control & Filters -->

        <!-- START: Responsive Custom Table -->
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 60px;">#</th>
                        <th>Candidate Profile</th>
                        <th>RM Code & Mobile</th>
                        <th>Aadhaar Number</th>
                        <th>Uploaded Documents</th>
                        <th>Status</th>
                        <th>Submission Date</th>
                        <th class="text-center pe-4" style="width: 160px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($requests as $req)
                        @php
                            $candidate = $req->candidate;
                            $statusVal = (int) $req->is_accept;
                        @endphp
                        <tr id="req-row-{{ $req->id }}">
                            <td class="ps-4 text-muted fw-bold font-monospace">
                                {{ (($requests->currentPage() - 1) * $requests->perPage()) + $loop->iteration }}
                            </td>
                            <td>
                                @if($candidate)
                                    <div class="table-user-cell">
                                        <img src="{{ $candidate->avatar_url }}" alt="{{ $candidate->first_name }}" class="table-user-avatar"
                                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(($candidate->first_name ?? 'C').' '.($candidate->last_name ?? '')) }}&background=0F4A32&color=fff'">
                                        <div>
                                            <a href="{{ route('admin.candidates.show', $candidate->id) }}" class="table-user-name text-decoration-none">
                                                {{ $candidate->first_name }} {{ $candidate->last_name }}
                                            </a>
                                            <div class="table-user-sub">
                                                <i class="bi bi-envelope me-1"></i>{{ $candidate->email ?? 'No email' }}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-muted">Deleted Candidate</span>
                                @endif
                            </td>
                            <td>
                                @if($candidate)
                                    <span class="badge bg-light text-dark border font-monospace px-2 py-1">
                                        {{ $candidate->candidate_code ?? $candidate->profile_id ?? ('RM' . str_pad($candidate->id, 5, '0', STR_PAD_LEFT)) }}
                                    </span>
                                    <div class="table-user-sub mt-1">
                                        <i class="bi bi-telephone-fill text-muted-green me-1"></i>{{ $candidate->mobile ?? ($candidate->phone ?? 'N/A') }}
                                    </div>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                            <td>
                                <div class="font-monospace fw-bold text-main">
                                    {{ $req->aadhar_number ? substr($req->aadhar_number, 0, 4) . ' ' . substr($req->aadhar_number, 4, 4) . ' ' . substr($req->aadhar_number, 8) : 'Not Provided' }}
                                </div>
                                @if($req->admin_notes)
                                    <div class="table-user-sub text-danger" title="Admin Notes">
                                        <i class="bi bi-info-circle me-1"></i>{{ Str::limit($req->admin_notes, 35) }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    @if($req->aadhar_photo_front)
                                        <a href="{{ asset($req->aadhar_photo_front) }}" target="_blank" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2" title="View Front Document">
                                            <i class="bi bi-card-image text-primary"></i> Front
                                        </a>
                                    @endif
                                    @if($req->aadhar_photo_back)
                                        <a href="{{ asset($req->aadhar_photo_back) }}" target="_blank" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2" title="View Back Document">
                                            <i class="bi bi-card-image text-info"></i> Back
                                        </a>
                                    @endif
                                    @if(!$req->aadhar_photo_front && !$req->aadhar_photo_back)
                                        <span class="text-muted small italic">No files attached</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                @if($statusVal === 1)
                                    <span class="badge-table success"><i class="bi bi-patch-check-fill"></i> Approved</span>
                                @elseif($statusVal === 2)
                                    <span class="badge-table failed"><i class="bi bi-x-circle-fill"></i> Rejected</span>
                                @else
                                    <span class="badge-table pending"><i class="bi bi-hourglass-split"></i> Pending</span>
                                @endif
                            </td>
                            <td>
                                <div class="table-user-sub fw-semibold text-main">{{ $req->created_at ? $req->created_at->format('d M, Y') : 'N/A' }}</div>
                                <div class="table-user-sub font-monospace">{{ $req->created_at ? $req->created_at->format('h:i A') : '' }}</div>
                            </td>
                            <td class="text-center pe-4">
                                @if($candidate)
                                    <a href="{{ route('admin.candidates.show', $candidate->id) }}" 
                                       class="btn-custom btn-custom-primary btn-custom-sm py-1 px-2.5" 
                                       title="View Full Profile & Verification Details">
                                        <i class="bi bi-person-lines-fill"></i> Details
                                    </a>
                                @else
                                    <span class="text-muted small">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-5 text-muted">
                                <i class="bi bi-patch-check fs-2 d-block mb-2 text-muted-green"></i>
                                <span class="fw-semibold">No Blue Tick verification requests found.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- END: Responsive Custom Table -->

        <!-- START: Table Pagination Footer -->
        @if($requests->hasPages())
        <div class="p-3 bg-white border-top d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 table-footer-control">
            <div class="table-user-sub">
                Showing {{ $requests->firstItem() ?? 0 }} to {{ $requests->lastItem() ?? 0 }} of {{ number_format($requests->total()) }} verification requests
            </div>
            <div>
                {{ $requests->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
        <!-- END: Table Pagination Footer -->

    </div>
    <!-- END: Table Container -->

</div>

@push('scripts')
<script>
function approveRequest(id, candidateName) {
    Swal.fire({
        title: 'Approve Blue Tick?',
        html: `Are you sure you want to verify and approve the Aadhaar badge for <strong>${candidateName}</strong>?`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-patch-check-fill me-1"></i> Yes, Approve',
        cancelButtonText: 'Cancel',
        reverseButtons: true,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            fetch(`{{ url('/admin/bluetick') }}/${id}/approve`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ notes: 'Approved by Admin' })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Approved!',
                        text: data.message,
                        timer: 1800,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Could not approve request'
                    });
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred during approval.'
                });
            });
        }
    });
}

function rejectRequest(id, candidateName) {
    Swal.fire({
        title: 'Reject Blue Tick Request',
        html: `Please provide a reason for rejecting the Aadhaar verification of <strong>${candidateName}</strong>:`,
        input: 'textarea',
        inputPlaceholder: 'e.g. Document photo is blurred or details do not match profile...',
        inputValidator: (value) => {
            if (!value || !value.trim()) {
                return 'You must enter a reason for rejection!';
            }
        },
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-x-circle me-1"></i> Confirm Reject',
        confirmButtonColor: '#dc2626',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed && result.value) {
            fetch(`{{ url('/admin/bluetick') }}/${id}/reject`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ reason: result.value.trim() })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Rejected',
                        text: data.message,
                        timer: 1800,
                        showConfirmButton: false
                    }).then(() => location.reload());
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message || 'Could not reject request'
                    });
                }
            })
            .catch(err => {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'An error occurred during rejection.'
                });
            });
        }
    });
}
</script>
@endpush
@endsection
