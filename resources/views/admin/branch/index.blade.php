@extends('admin.layouts.app')

@section('title', 'Branch Management - Rani Matrimonial')

@section('content')
<div class="container-fluid p-0">

    <!-- START: Page Header Banner -->
    <div class="page-header d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h1 class="page-title mb-0">Branch Management</h1>
                <span class="badge-table success ms-2">
                    {{ number_format($counts['all'] ?? 0) }} Regional Centers
                </span>
            </div>
            <p class="page-subtitle mb-0">Manage physical franchise centers, office addresses, branch managers, and identity verification documents.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn-custom btn-custom-primary btn-custom-sm shadow-sm" data-bs-toggle="modal" data-bs-target="#addBranchModal">
                <i class="bi bi-plus-lg"></i>
                <span>Add New Branch</span>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn-custom btn-custom-light btn-custom-sm">
                <i class="bi bi-arrow-left"></i>
                <span>Dashboard</span>
            </a>
        </div>
    </div>
    <!-- END: Page Header Banner -->

    <!-- START: Stat Cards Row -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('admin.branches.index') }}" class="p-3 rounded-4 bg-white border shadow-sm d-flex align-items-center justify-content-between text-decoration-none card-clickable h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="kpa-icon-box" style="background-color: rgba(15, 74, 50, 0.1); color: var(--brand-forest-medium);">
                        <i class="bi bi-buildings-fill"></i>
                    </div>
                    <div>
                        <div class="kpa-stat-title">Total Branches</div>
                        <div class="kpa-stat-value fs-4 mb-0">{{ number_format($counts['all'] ?? 0) }}</div>
                    </div>
                </div>
                <i class="bi bi-arrow-right kpa-arrow-icon"></i>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('admin.branches.index', ['status' => 'active']) }}" class="p-3 rounded-4 bg-white border shadow-sm d-flex align-items-center justify-content-between text-decoration-none card-clickable h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="kpa-icon-box" style="background-color: rgba(34, 197, 94, 0.1); color: #16a34a;">
                        <i class="bi bi-check-circle-fill"></i>
                    </div>
                    <div>
                        <div class="kpa-stat-title">Active / Operational</div>
                        <div class="kpa-stat-value fs-4 mb-0">{{ number_format($counts['active'] ?? 0) }}</div>
                    </div>
                </div>
                <i class="bi bi-arrow-right kpa-arrow-icon"></i>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <a href="{{ route('admin.branches.index', ['status' => 'inactive']) }}" class="p-3 rounded-4 bg-white border shadow-sm d-flex align-items-center justify-content-between text-decoration-none card-clickable h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="kpa-icon-box" style="background-color: rgba(100, 116, 139, 0.12); color: #64748b;">
                        <i class="bi bi-pause-circle-fill"></i>
                    </div>
                    <div>
                        <div class="kpa-stat-title">Inactive / Closed</div>
                        <div class="kpa-stat-value fs-4 mb-0">{{ number_format($counts['inactive'] ?? 0) }}</div>
                    </div>
                </div>
                <i class="bi bi-arrow-right kpa-arrow-icon"></i>
            </a>
        </div>

        <div class="col-12 col-sm-6 col-xl-3">
            <div class="p-3 rounded-4 bg-white border shadow-sm d-flex align-items-center justify-content-between h-100">
                <div class="d-flex align-items-center gap-3">
                    <div class="kpa-icon-box" style="background-color: rgba(14, 165, 233, 0.12); color: #0284c7;">
                        <i class="bi bi-geo-alt-fill"></i>
                    </div>
                    <div>
                        <div class="kpa-stat-title">Cities Covered</div>
                        <div class="kpa-stat-value fs-4 mb-0">{{ number_format($counts['cities'] ?? 0) }}</div>
                    </div>
                </div>
                <span class="badge bg-light text-muted border px-2 py-1 rounded-pill fs-xs">Locations</span>
            </div>
        </div>
    </div>
    <!-- END: Stat Cards Row -->

    <!-- START: Refined Table Container -->
    <div class="table-card-custom">
        
        <!-- START: Header Control & Filters -->
        <div class="table-header-control">
            <!-- Filter Tabs -->
            <div class="d-flex flex-wrap align-items-center gap-2">
                <a href="{{ route('admin.branches.index', ['status' => 'all', 'search' => $search]) }}" 
                   class="btn-custom btn-custom-sm {{ ($status ?? 'all') === 'all' ? 'btn-custom-primary' : 'btn-custom-light' }}">
                    All Branches ({{ $counts['all'] ?? 0 }})
                </a>
                <a href="{{ route('admin.branches.index', ['status' => 'active', 'search' => $search]) }}" 
                   class="btn-custom btn-custom-sm {{ ($status ?? '') === 'active' ? 'btn-custom-primary' : 'btn-custom-light' }}">
                    <i class="bi bi-check-circle"></i> Active ({{ $counts['active'] ?? 0 }})
                </a>
                <a href="{{ route('admin.branches.index', ['status' => 'inactive', 'search' => $search]) }}" 
                   class="btn-custom btn-custom-sm {{ in_array(($status ?? ''), ['inactive', 'deactivated']) ? 'btn-custom-primary' : 'btn-custom-light' }}">
                    <i class="bi bi-pause-circle"></i> Inactive ({{ $counts['inactive'] ?? 0 }})
                </a>
            </div>

            <!-- Search Form -->
            <form method="GET" action="{{ route('admin.branches.index') }}" class="table-search-box m-0">
                @if(($status ?? 'all') !== 'all')<input type="hidden" name="status" value="{{ $status }}">@endif
                <i class="bi bi-search table-search-icon"></i>
                <input type="text" 
                       name="search" 
                       class="table-search-input" 
                       placeholder="Search branch name, code, city, phone..." 
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
                        <th>Code</th>
                        <th>Branch / Office Name</th>
                        <th>Designation</th>
                        <th>Contact Phone</th>
                        <th>Location (City, State)</th>
                        <th>Address</th>
                        <th>Aadhaar Docs</th>
                        <th>Status</th>
                        <th class="text-center pe-4" style="width: 130px;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($branches as $branch)
                        <tr id="branch-row-{{ $branch->id }}">
                            <td class="ps-4 text-muted fw-bold font-monospace">
                                {{ (($branches->currentPage() - 1) * $branches->perPage()) + $loop->iteration }}
                            </td>
                            <td>
                                <span class="badge bg-light text-forest-medium border font-monospace px-2 py-1 fw-bold fs-xs">
                                    {{ $branch->code }}
                                </span>
                            </td>
                            <td>
                                <div class="table-user-name fw-bold">{{ $branch->name }}</div>
                                <div class="table-user-sub text-muted fs-xs">
                                    <i class="bi bi-clock me-1"></i> Created {{ $branch->created_at->format('d M, Y') }}
                                </div>
                            </td>
                            <td>
                                <span class="badge bg-light text-dark border px-2 py-1 fs-xs fw-semibold">
                                    {{ $branch->designation ?? 'Branch Manager' }}
                                </span>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="tel:{{ $branch->phone }}" class="fw-bold font-monospace text-decoration-none text-forest-medium">
                                        <i class="bi bi-telephone-fill me-1 text-muted-green"></i>{{ $branch->phone }}
                                    </a>
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $branch->phone) }}" 
                                       target="_blank" 
                                       class="btn-custom btn-custom-secondary btn-custom-sm py-0 px-1.5" 
                                       title="Chat on WhatsApp" 
                                       style="font-size: 11px; height: 22px; line-height: 22px;">
                                        <i class="bi bi-whatsapp"></i>
                                    </a>
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold text-main">{{ $branch->city }}</div>
                                <div class="table-user-sub">{{ $branch->state }}</div>
                            </td>
                            <td>
                                <div class="text-truncate" style="max-width: 220px;" title="{{ $branch->full_address }}">
                                    {{ $branch->full_address }}
                                </div>
                            </td>
                            <td>
                                <div class="d-flex align-items-center gap-1.5">
                                    @if($branch->aadhar_front)
                                        <button type="button" 
                                                class="btn-custom btn-custom-light btn-custom-sm py-0.5 px-2 fs-xs" 
                                                onclick="previewDoc('{{ $branch->aadhar_front_url }}', 'Aadhaar Front - {{ addslashes($branch->name) }}')"
                                                title="View Aadhaar Front">
                                            <i class="bi bi-card-image text-primary"></i> Front
                                        </button>
                                    @endif

                                    @if($branch->aadhar_back)
                                        <button type="button" 
                                                class="btn-custom btn-custom-light btn-custom-sm py-0.5 px-2 fs-xs" 
                                                onclick="previewDoc('{{ $branch->aadhar_back_url }}', 'Aadhaar Back - {{ addslashes($branch->name) }}')"
                                                title="View Aadhaar Back">
                                            <i class="bi bi-card-image text-info"></i> Back
                                        </button>
                                    @endif

                                    @if(!$branch->aadhar_front && !$branch->aadhar_back)
                                        <span class="badge bg-light text-muted border px-2 py-1 fs-xs">No Docs</span>
                                    @endif
                                </div>
                            </td>
                            <td>
                                <button type="button" 
                                        id="btn-status-{{ $branch->id }}" 
                                        onclick="toggleBranchRowStatus({{ $branch->id }})" 
                                        class="badge-table {{ $branch->is_active ? 'success' : 'failed' }} border-0 cursor-pointer shadow-xs d-inline-flex align-items-center gap-1 text-decoration-none"
                                        title="Click to toggle status (Active / Inactive)">
                                    <i class="bi {{ $branch->is_active ? 'bi-check-circle-fill' : 'bi-pause-circle-fill' }}" id="icon-status-{{ $branch->id }}"></i>
                                    <span id="text-status-{{ $branch->id }}">{{ $branch->is_active ? 'Active' : 'Inactive' }}</span>
                                </button>
                            </td>
                            <td class="text-center pe-4">
                                <div class="d-flex align-items-center justify-content-center gap-1.5">
                                    <button type="button" 
                                            class="btn-custom btn-custom-light btn-custom-sm p-1.5" 
                                            onclick="openEditBranchModal({{ $branch->id }})" 
                                            title="Edit Branch Details">
                                        <i class="bi bi-pencil-square text-primary"></i>
                                    </button>
                                    <button type="button" 
                                            class="btn-custom btn-custom-light btn-custom-sm p-1.5" 
                                            onclick="deleteBranchRow({{ $branch->id }}, '{{ addslashes($branch->name) }}', '{{ $branch->code }}')" 
                                            title="Delete Branch">
                                        <i class="bi bi-trash3-fill text-danger"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="text-center py-5">
                                <div class="d-flex flex-column align-items-center justify-content-center text-muted">
                                    <i class="bi bi-buildings fs-1 mb-2 opacity-50"></i>
                                    <h6 class="fw-bold mb-1">No Branch Records Found</h6>
                                    <p class="small mb-3">No physical franchise centers match your search or filter parameters.</p>
                                    <button type="button" class="btn-custom btn-custom-primary btn-custom-sm" data-bs-toggle="modal" data-bs-target="#addBranchModal">
                                        <i class="bi bi-plus-lg"></i> Create First Branch
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- END: Responsive Custom Table -->

        <!-- START: Table Pagination Footer -->
        @if($branches->hasPages())
            <div class="p-3 border-top d-flex align-items-center justify-content-between flex-wrap gap-3">
                <div class="text-muted small">
                    Showing {{ $branches->firstItem() }} to {{ $branches->lastItem() }} of {{ $branches->total() }} branches
                </div>
                <div>
                    {{ $branches->links('pagination::bootstrap-5') }}
                </div>
            </div>
        @endif
        <!-- END: Table Pagination Footer -->

    </div>
    <!-- END: Refined Table Container -->

</div>

<!-- ============================================================== -->
<!-- MODAL 1: ADD NEW BRANCH MODAL                                  -->
<!-- ============================================================== -->
<div class="modal fade" id="addBranchModal" tabindex="-1" aria-labelledby="addBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-forest-medium text-white px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-white-10 p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="bi bi-buildings-fill text-lime"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0 text-white" id="addBranchModalLabel">Add New Branch Center</h5>
                        <p class="mb-0 text-white-50 fs-xs">Branch code will be auto-generated sequentially (e.g. BRM005)</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="addBranchForm" enctype="multipart/form-data">
                @csrf
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label class="form-label fw-bold small text-main">Branch / Center Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control rounded-3" placeholder="e.g. Kolkata Central Headquarter" required>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label fw-bold small text-main">Designation / Role <span class="text-danger">*</span></label>
                            <input type="text" name="designation" class="form-control rounded-3" placeholder="e.g. Branch Manager" value="Branch Manager" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-main">Contact Phone / Mobile <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-telephone"></i></span>
                                <input type="text" name="phone" class="form-control rounded-end-3" placeholder="e.g. 9830123456" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-main">City <span class="text-danger">*</span></label>
                            <input type="text" name="city" class="form-control rounded-3" placeholder="e.g. Kolkata" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-main">State <span class="text-danger">*</span></label>
                            <input type="text" name="state" class="form-control rounded-3" placeholder="e.g. West Bengal" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small text-main">Full Office Address <span class="text-danger">*</span></label>
                            <textarea name="full_address" class="form-control rounded-3" rows="2" placeholder="Enter complete physical address with landmarks and pincode..." required></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-main">Aadhaar Card (Front Photo)</label>
                            <input type="file" name="aadhar_front" class="form-control rounded-3" accept="image/*,.pdf">
                            <span class="text-muted fs-xs">JPG, PNG, WebP or PDF (Max 5MB)</span>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-main">Aadhaar Card (Back Photo)</label>
                            <input type="file" name="aadhar_back" class="form-control rounded-3" accept="image/*,.pdf">
                            <span class="text-muted fs-xs">JPG, PNG, WebP or PDF (Max 5MB)</span>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light px-4 py-3 border-top">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm" id="btnAddBranchSubmit">
                        <i class="bi bi-check-lg me-1"></i> Save Branch
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL 2: EDIT BRANCH MODAL                                     -->
<!-- ============================================================== -->
<div class="modal fade" id="editBranchModal" tabindex="-1" aria-labelledby="editBranchModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-forest-medium text-white px-4 py-3">
                <div class="d-flex align-items-center gap-2">
                    <div class="rounded-circle bg-white-10 p-2 d-flex align-items-center justify-content-center" style="width: 38px; height: 38px;">
                        <i class="bi bi-pencil-square text-lime"></i>
                    </div>
                    <div>
                        <h5 class="modal-title fw-bold mb-0 text-white" id="editBranchModalLabel">Edit Branch Details</h5>
                        <p class="mb-0 text-white-50 fs-xs" id="editBranchCodeHeader">Branch Code: BRM001</p>
                    </div>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form id="editBranchForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="editBranchId">
                <div class="modal-body p-4">
                    <div class="row g-3">
                        <div class="col-md-7">
                            <label class="form-label fw-bold small text-main">Branch / Center Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" id="editName" class="form-control rounded-3" required>
                        </div>

                        <div class="col-md-5">
                            <label class="form-label fw-bold small text-main">Designation / Role <span class="text-danger">*</span></label>
                            <input type="text" name="designation" id="editDesignation" class="form-control rounded-3" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-main">Contact Phone / Mobile <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0"><i class="bi bi-telephone"></i></span>
                                <input type="text" name="phone" id="editPhone" class="form-control rounded-end-3" required>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-main">City <span class="text-danger">*</span></label>
                            <input type="text" name="city" id="editCity" class="form-control rounded-3" required>
                        </div>

                        <div class="col-md-3">
                            <label class="form-label fw-bold small text-main">State <span class="text-danger">*</span></label>
                            <input type="text" name="state" id="editState" class="form-control rounded-3" required>
                        </div>

                        <div class="col-12">
                            <label class="form-label fw-bold small text-main">Full Office Address <span class="text-danger">*</span></label>
                            <textarea name="full_address" id="editFullAddress" class="form-control rounded-3" rows="2" required></textarea>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-main">Replace Aadhaar (Front Photo)</label>
                            <input type="file" name="aadhar_front" class="form-control rounded-3" accept="image/*,.pdf">
                            <div id="editFrontPreviewLink" class="mt-1 fs-xs"></div>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-bold small text-main">Replace Aadhaar (Back Photo)</label>
                            <input type="file" name="aadhar_back" class="form-control rounded-3" accept="image/*,.pdf">
                            <div id="editBackPreviewLink" class="mt-1 fs-xs"></div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer bg-light px-4 py-3 border-top">
                    <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm" id="btnEditBranchSubmit">
                        <i class="bi bi-check-lg me-1"></i> Update Branch
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- ============================================================== -->
<!-- MODAL 3: DOCUMENT PREVIEW MODAL                                -->
<!-- ============================================================== -->
<div class="modal fade" id="docPreviewModal" tabindex="-1" aria-labelledby="docPreviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
            <div class="modal-header bg-dark text-white px-4 py-3">
                <h6 class="modal-title fw-bold mb-0 text-white" id="docPreviewModalLabel">Document Inspection</h6>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0 text-center bg-light" style="min-height: 350px;">
                <div id="docPreviewContainer" class="p-3">
                    <img id="docPreviewImage" src="" alt="Document Preview" class="img-fluid rounded shadow-sm max-h-500" style="max-height: 500px; object-fit: contain;">
                </div>
            </div>
            <div class="modal-footer bg-light px-4 py-2.5 border-top d-flex justify-content-between">
                <a id="docPreviewDownloadBtn" href="" target="_blank" download class="btn btn-outline-dark btn-sm rounded-pill px-3">
                    <i class="bi bi-download me-1"></i> Open Full / Download
                </a>
                <button type="button" class="btn btn-secondary btn-sm rounded-pill px-3" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // -------------------------------------------------------------
    // 1. Preview Document Lightbox Modal
    // -------------------------------------------------------------
    window.previewDoc = function(url, title) {
        if (!url) return;
        $('#docPreviewModalLabel').text(title || 'Document Inspection');
        $('#docPreviewImage').attr('src', url);
        $('#docPreviewDownloadBtn').attr('href', url);
        const modal = new bootstrap.Modal(document.getElementById('docPreviewModal'));
        modal.show();
    };

    // -------------------------------------------------------------
    // 2. Add New Branch AJAX Handler
    // -------------------------------------------------------------
    $('#addBranchForm').on('submit', function(e) {
        e.preventDefault();
        const $form = $(this);
        const $btn = $('#btnAddBranchSubmit');
        const formData = new FormData(this);

        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Saving...');

        $.ajax({
            url: "{{ route('admin.branches.store') }}",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}'
            },
            success: function(response) {
                $btn.prop('disabled', false).html('<i class="bi bi-check-lg me-1"></i> Save Branch');
                if (response.success) {
                    $('#addBranchModal').modal('hide');
                    $form[0].reset();
                    Swal.fire({
                        icon: 'success',
                        title: 'Branch Created!',
                        text: response.message,
                        timer: 1800,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                }
            },
            error: function(xhr) {
                $btn.prop('disabled', false).html('<i class="bi bi-check-lg me-1"></i> Save Branch');
                let errMsg = 'Failed to create branch. Please check inputs.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errMsg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errMsg
                });
            }
        });
    });

    // -------------------------------------------------------------
    // 3. Open Edit Branch Modal & Populate Data
    // -------------------------------------------------------------
    window.openEditBranchModal = function(id) {
        Swal.fire({
            title: 'Loading branch data...',
            allowOutsideClick: false,
            didOpen: () => { Swal.showLoading(); }
        });

        $.ajax({
            url: "{{ url('admin/branches') }}/" + id,
            type: "GET",
            success: function(res) {
                Swal.close();
                if (res.success && res.branch) {
                    const b = res.branch;
                    $('#editBranchId').val(b.id);
                    $('#editBranchCodeHeader').text('Branch Code: ' + b.code);
                    $('#editName').val(b.name);
                    $('#editDesignation').val(b.designation || 'Branch Manager');
                    $('#editPhone').val(b.phone);
                    $('#editCity').val(b.city);
                    $('#editState').val(b.state);
                    $('#editFullAddress').val(b.full_address);

                    if (res.front_url) {
                        $('#editFrontPreviewLink').html('<a href="javascript:void(0)" onclick="previewDoc(\'' + res.front_url + '\', \'Aadhaar Front - ' + b.name + '\')" class="text-forest-medium fw-bold"><i class="bi bi-eye"></i> View Current Front Photo</a>');
                    } else {
                        $('#editFrontPreviewLink').html('<span class="text-muted">No front document uploaded</span>');
                    }

                    if (res.back_url) {
                        $('#editBackPreviewLink').html('<a href="javascript:void(0)" onclick="previewDoc(\'' + res.back_url + '\', \'Aadhaar Back - ' + b.name + '\')" class="text-forest-medium fw-bold"><i class="bi bi-eye"></i> View Current Back Photo</a>');
                    } else {
                        $('#editBackPreviewLink').html('<span class="text-muted">No back document uploaded</span>');
                    }

                    const modal = new bootstrap.Modal(document.getElementById('editBranchModal'));
                    modal.show();
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Unable to retrieve branch details.'
                });
            }
        });
    };

    // -------------------------------------------------------------
    // 4. Update Branch Form Submission (AJAX)
    // -------------------------------------------------------------
    $('#editBranchForm').on('submit', function(e) {
        e.preventDefault();
        const id = $('#editBranchId').val();
        const $btn = $('#btnEditBranchSubmit');
        const formData = new FormData(this);
        formData.append('_method', 'PUT');

        $btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Updating...');

        $.ajax({
            url: "{{ url('admin/branches') }}/" + id,
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}'
            },
            success: function(response) {
                $btn.prop('disabled', false).html('<i class="bi bi-check-lg me-1"></i> Update Branch');
                if (response.success) {
                    $('#editBranchModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Branch Updated!',
                        text: response.message,
                        timer: 1800,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.reload();
                    });
                }
            },
            error: function(xhr) {
                $btn.prop('disabled', false).html('<i class="bi bi-check-lg me-1"></i> Update Branch');
                let errMsg = 'Failed to update branch.';
                if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errMsg = Object.values(xhr.responseJSON.errors).flat().join('<br>');
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errMsg = xhr.responseJSON.message;
                }
                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errMsg
                });
            }
        });
    });

    // -------------------------------------------------------------
    // 5. Toggle Branch Active / Inactive Status
    // -------------------------------------------------------------
    window.toggleBranchRowStatus = function(id) {
        $.ajax({
            url: "{{ url('admin/branches') }}/" + id + "/toggle-status",
            type: "POST",
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}'
            },
            success: function(res) {
                if (res.success) {
                    const $btn = $('#btn-status-' + id);
                    const $icon = $('#icon-status-' + id);
                    const $text = $('#text-status-' + id);

                    if (res.is_active) {
                        $btn.removeClass('failed').addClass('success');
                        $icon.removeClass('bi-pause-circle-fill').addClass('bi-check-circle-fill');
                        $text.text('Active');
                    } else {
                        $btn.removeClass('success').addClass('failed');
                        $icon.removeClass('bi-check-circle-fill').addClass('bi-pause-circle-fill');
                        $text.text('Inactive');
                    }

                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2500,
                        timerProgressBar: true
                    });
                    Toast.fire({
                        icon: 'success',
                        title: res.message
                    });
                }
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to toggle branch status.'
                });
            }
        });
    };

    // -------------------------------------------------------------
    // 6. Delete Branch Row
    // -------------------------------------------------------------
    window.deleteBranchRow = function(id, name, code) {
        Swal.fire({
            title: 'Delete Branch?',
            html: 'Are you sure you want to delete <strong>' + name + ' (' + code + ')</strong>?<br><span class="text-danger small">This action cannot be undone.</span>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: '<i class="bi bi-trash3-fill me-1"></i> Yes, Delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/branches') }}/" + id,
                    type: "DELETE",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') || '{{ csrf_token() }}'
                    },
                    success: function(res) {
                        if (res.success) {
                            $('#branch-row-' + id).fadeOut(300, function() {
                                $(this).remove();
                            });
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: res.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to delete branch.'
                        });
                    }
                });
            }
        });
    };
</script>
@endpush
@endsection
