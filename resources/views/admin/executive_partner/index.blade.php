@extends('admin.layouts.app')

@section('title', 'Executive Partners (EP) Management - Rani Matrimonial Admin')

@section('content')
<div class="container-fluid p-0">
  
  <!-- START: Page Header Banner -->
  <div class="page-header d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <i class="bi bi-person-badge-fill fs-4 text-primary"></i>
        <h1 class="page-title mb-0">Executive Partners (EP)</h1>
        <span class="badge-table success ms-2">
          {{ number_format($counts['total']) }} Total EPs
        </span>
      </div>
      <p class="page-subtitle mb-0">Manage executive partner accounts, assign ground partners, track operational status and contact details.</p>
    </div>

    <div class="d-flex align-items-center gap-2">
      <a href="{{ route('admin.ground-partners.index') }}" class="btn-custom btn-custom-light btn-custom-sm">
        <i class="bi bi-geo-alt-fill text-info"></i>
        <span>View Ground Partners</span>
      </a>
      <button type="button" class="btn-custom btn-custom-primary btn-custom-sm" data-bs-toggle="modal" data-bs-target="#createEpModal">
        <i class="bi bi-plus-lg"></i>
        <span>Add New EP</span>
      </button>
    </div>
  </div>
  <!-- END: Page Header Banner -->

  <!-- START: Metric Statistics Cards -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
      <div class="card p-3 p-xl-3.5 rounded-4 shadow-sm border-0 h-100 bg-white">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <span class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.725rem; letter-spacing: 0.06em; margin-bottom: 0.35rem;">Total Executive Partners</span>
            <h2 class="fw-bold mb-0" style="font-size: 1.75rem; color: var(--text-main); line-height: 1.2;">{{ number_format($counts['total']) }}</h2>
          </div>
          <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; background-color: rgba(13, 110, 253, 0.1); color: #0d6efd; font-size: 1.35rem;">
            <i class="bi bi-person-badge-fill"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-3">
      <div class="card p-3 p-xl-3.5 rounded-4 shadow-sm border-0 h-100 bg-white">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <span class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.725rem; letter-spacing: 0.06em; margin-bottom: 0.35rem;">Active Partners</span>
            <h2 class="fw-bold mb-0 text-success" style="font-size: 1.75rem; line-height: 1.2;">{{ number_format($counts['active']) }}</h2>
          </div>
          <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; background-color: rgba(34, 197, 94, 0.12); color: var(--sys-green); font-size: 1.35rem;">
            <i class="bi bi-check-circle-fill"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-3">
      <div class="card p-3 p-xl-3.5 rounded-4 shadow-sm border-0 h-100 bg-white">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <span class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.725rem; letter-spacing: 0.06em; margin-bottom: 0.35rem;">Total Ground Partners</span>
            <h2 class="fw-bold mb-0 text-info" style="font-size: 1.75rem; line-height: 1.2;">{{ number_format($counts['total_gps']) }}</h2>
          </div>
          <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; background-color: rgba(13, 202, 240, 0.12); color: #0dcaf0; font-size: 1.35rem;">
            <i class="bi bi-people-fill"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-3">
      <div class="card p-3 p-xl-3.5 rounded-4 shadow-sm border-0 h-100 bg-white">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <span class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.725rem; letter-spacing: 0.06em; margin-bottom: 0.35rem;">Recharged Candidates</span>
            <h2 class="fw-bold mb-0 text-success" style="font-size: 1.75rem; line-height: 1.2;">{{ number_format($counts['paid_candidates']) }}</h2>
          </div>
          <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; background-color: rgba(34, 197, 94, 0.12); color: var(--sys-green); font-size: 1.35rem;">
            <i class="bi bi-patch-check-fill"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END: Metric Statistics Cards -->

  <!-- START: Main EP Container (Table Card Custom) -->
  <div class="table-card-custom mb-4">
    
    <!-- Header Controls & Filters -->
    <div class="table-header-control">
      <!-- Status Tabs -->
      <div class="d-flex flex-wrap align-items-center gap-2 flex-grow-1">
        <a href="{{ route('admin.executive-partners.index', ['search' => $search, 'status' => 'all']) }}" 
           class="btn-custom btn-custom-sm {{ ($status ?? 'all') === 'all' ? 'btn-custom-primary' : 'btn-custom-light' }}">
          All EPs ({{ $counts['total'] }})
        </a>
        <a href="{{ route('admin.executive-partners.index', ['search' => $search, 'status' => 'active']) }}" 
           class="btn-custom btn-custom-sm {{ ($status ?? '') === 'active' ? 'btn-custom-primary' : 'btn-custom-light' }}">
          <i class="bi bi-check2-circle"></i> Active ({{ $counts['active'] }})
        </a>
        <a href="{{ route('admin.executive-partners.index', ['search' => $search, 'status' => 'inactive']) }}" 
           class="btn-custom btn-custom-sm {{ ($status ?? '') === 'inactive' ? 'btn-custom-primary' : 'btn-custom-light' }}">
          <i class="bi bi-eye-slash"></i> Inactive ({{ $counts['inactive'] }})
        </a>
      </div>

      <div class="d-flex align-items-center gap-2 ms-auto">
        <!-- Search Box Form -->
        <form method="GET" action="{{ route('admin.executive-partners.index') }}" class="table-search-box m-0" style="min-width: 260px;">
          @if(($status ?? 'all') !== 'all')
            <input type="hidden" name="status" value="{{ $status }}">
          @endif
          <i class="bi bi-search table-search-icon"></i>
          <input type="text" 
                 name="search" 
                 class="table-search-input" 
                 placeholder="Search name, code, mobile..." 
                 value="{{ $search }}">
        </form>

        @if(!empty($search))
          <a href="{{ route('admin.executive-partners.index', ['status' => $status]) }}" class="btn-custom btn-custom-light btn-custom-sm" title="Clear search">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif
      </div>
    </div>

    <!-- Table Responsive View -->
    <div class="table-responsive">
      <table class="table-custom mb-0">
        <thead>
          <tr>
            <th class="ps-4" style="width: 140px;">Code</th>
            <th>Executive Partner Name</th>
            <th>Mobile Number</th>
            <th>Ground Partners (GP)</th>
            <th>Referred Candidates</th>
            <th>Status</th>
            <th>Registered Date</th>
            <th class="text-center pe-4" style="width: 130px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($partners as $partner)
            <tr id="ep-row-{{ $partner->id }}">
              <td class="ps-4">
                <span class="badge bg-dark text-warning border border-warning border-opacity-25 font-monospace px-2.5 py-1">
                  {{ $partner->code }}
                </span>
              </td>
              <td>
                <div class="d-flex align-items-center gap-2.5">
                  <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-2xs" 
                       style="width: 36px; height: 36px; background: linear-gradient(135deg, #0d6efd, #0b5ed7); font-size: 0.85rem;">
                    {{ strtoupper(substr($partner->name, 0, 1)) }}
                  </div>
                  <div>
                    <a href="{{ route('admin.executive-partners.show', $partner->id) }}" class="fw-bold text-decoration-none text-dark hover-primary">
                      {{ $partner->name }}
                    </a>
                  </div>
                </div>
              </td>
              <td>
                <a href="tel:{{ $partner->mobile }}" class="text-decoration-none text-dark fw-semibold">
                  <i class="bi bi-telephone text-muted me-1 small"></i>{{ $partner->mobile }}
                </a>
              </td>
              <td>
                <a href="{{ route('admin.ground-partners.index', ['ep_id' => $partner->id]) }}" 
                   class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 text-decoration-none px-2.5 py-1 fw-bold"
                   title="View Ground Partners assigned to this EP">
                  <i class="bi bi-people-fill me-1"></i> {{ $partner->ground_partners_count }} GPs
                </a>
              </td>
              <td>
                <a href="{{ route('admin.executive-partners.show', ['id' => $partner->id, 'tab' => 'candidates']) }}" class="text-decoration-none">
                  <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1 fw-bold" title="Recharged candidates under this EP's GPs">
                    <i class="bi bi-patch-check-fill me-1"></i> {{ $partner->paid_candidates_count ?? 0 }} Paid
                  </span>
                  @if(($partner->total_candidates_count ?? 0) > ($partner->paid_candidates_count ?? 0))
                    <span class="badge bg-light text-muted border px-2 py-1 small ms-1" title="Total candidates registered">
                      {{ $partner->total_candidates_count }} Total
                    </span>
                  @endif
                </a>
              </td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="form-check form-switch mb-0">
                    <input class="form-check-input cursor-pointer toggle-status-btn" 
                           type="checkbox" 
                           role="switch" 
                           id="switch-ep-{{ $partner->id }}" 
                           data-id="{{ $partner->id }}" 
                           {{ $partner->isActive() ? 'checked' : '' }}>
                  </div>
                  <span class="badge-table {{ $partner->isActive() ? 'success' : 'failed' }}" id="status-pill-{{ $partner->id }}">
                    {{ ucfirst($partner->status) }}
                  </span>
                </div>
              </td>
              <td>
                <div class="table-user-sub">{{ $partner->created_at->format('M d, Y') }}</div>
              </td>
              <td class="text-center pe-4">
                <div class="d-flex align-items-center justify-content-center gap-1.5">
                  <a href="{{ route('admin.executive-partners.show', $partner->id) }}" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2" title="View Details & Assigned GPs">
                    <i class="bi bi-eye text-info"></i>
                  </a>
                  <button type="button" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2 edit-ep-btn" 
                          title="Edit Partner" 
                          data-id="{{ $partner->id }}"
                          data-name="{{ htmlspecialchars($partner->name, ENT_QUOTES) }}"
                          data-code="{{ $partner->code }}"
                          data-mobile="{{ $partner->mobile }}"
                          data-status="{{ $partner->status }}">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </button>
                  <button type="button" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2 delete-ep-btn" 
                          title="Delete Partner" 
                          data-id="{{ $partner->id }}" 
                          data-name="{{ htmlspecialchars($partner->name, ENT_QUOTES) }}"
                          data-code="{{ $partner->code }}">
                    <i class="bi bi-trash text-danger"></i>
                  </button>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="7" class="text-center py-5 text-muted">
                <div class="w-16 h-16 rounded-circle bg-light text-muted d-inline-flex align-items-center justify-content-center fs-2 mb-2">
                  <i class="bi bi-person-x"></i>
                </div>
                <div class="fw-semibold fs-6">No Executive Partners Found</div>
                <p class="small text-muted mb-3">Try adjusting your search or add a new Executive Partner.</p>
                <button type="button" class="btn-custom btn-custom-primary btn-custom-sm" data-bs-toggle="modal" data-bs-target="#createEpModal">
                  <i class="bi bi-plus-lg"></i> Add New EP
                </button>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination -->
    @if($partners->hasPages())
      <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
        <div class="small text-muted">
          Showing <strong>{{ $partners->firstItem() }}</strong> to <strong>{{ $partners->lastItem() }}</strong> of <strong>{{ $partners->total() }}</strong> entries
        </div>
        <div>
          {{ $partners->links() }}
        </div>
      </div>
    @endif

  </div>
  <!-- END: Main EP Container -->

</div>

<!-- START: Create Executive Partner Modal -->
<div class="modal fade" id="createEpModal" tabindex="-1" aria-labelledby="createEpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="modal-header bg-dark text-white p-3.5 border-0">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-person-plus-fill text-warning fs-5"></i>
          <h5 class="modal-title fw-bold text-white mb-0" id="createEpModalLabel">Add New Executive Partner</h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="createEpForm" method="POST" action="{{ route('admin.executive-partners.store') }}">
        @csrf
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label fw-bold small text-muted text-uppercase">Full Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" placeholder="Enter executive partner full name" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold small text-muted text-uppercase">Partner Code</label>
            <input type="text" name="code" class="form-control font-monospace" placeholder="e.g. EP001 (Leave empty to auto-generate)">
            <small class="text-muted">If left blank, system generates an automated unique code (e.g. EP001).</small>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold small text-muted text-uppercase">Mobile Number <span class="text-danger">*</span></label>
            <input type="text" name="mobile" class="form-control" placeholder="e.g. 9876543210" required>
          </div>

          <div class="mb-2">
            <label class="form-label fw-bold small text-muted text-uppercase">Initial Status <span class="text-danger">*</span></label>
            <select name="status" class="form-select" required>
              <option value="active" selected>Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </div>

        <div class="modal-footer bg-light p-3 border-0">
          <button type="button" class="btn-custom btn-custom-light btn-custom-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-custom btn-custom-primary btn-custom-sm" id="saveEpSubmitBtn">
            <i class="bi bi-check-lg"></i>
            <span>Create Executive Partner</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- END: Create Modal -->

<!-- START: Edit Executive Partner Modal -->
<div class="modal fade" id="editEpModal" tabindex="-1" aria-labelledby="editEpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="modal-header bg-dark text-white p-3.5 border-0">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-pencil-square text-warning fs-5"></i>
          <h5 class="modal-title fw-bold text-white mb-0" id="editEpModalLabel">Edit Executive Partner</h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="editEpForm" method="POST" action="">
        @csrf
        @method('PUT')
        <input type="hidden" id="edit_ep_id" name="id">

        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label fw-bold small text-muted text-uppercase">Full Name <span class="text-danger">*</span></label>
            <input type="text" id="edit_ep_name" name="name" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold small text-muted text-uppercase">Partner Code <span class="text-danger">*</span></label>
            <input type="text" id="edit_ep_code" name="code" class="form-control font-monospace" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold small text-muted text-uppercase">Mobile Number <span class="text-danger">*</span></label>
            <input type="text" id="edit_ep_mobile" name="mobile" class="form-control" required>
          </div>

          <div class="mb-2">
            <label class="form-label fw-bold small text-muted text-uppercase">Status <span class="text-danger">*</span></label>
            <select id="edit_ep_status" name="status" class="form-select" required>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </div>

        <div class="modal-footer bg-light p-3 border-0">
          <button type="button" class="btn-custom btn-custom-light btn-custom-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-custom btn-custom-primary btn-custom-sm" id="updateEpSubmitBtn">
            <i class="bi bi-check-lg"></i>
            <span>Update Executive Partner</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- END: Edit Modal -->

@endsection

@push('scripts')
<script>
$(document).ready(function() {

    // Toggle Status
    $(document).on('change', '.toggle-status-btn', function() {
        var id = $(this).data('id');
        var isChecked = $(this).is(':checked');
        var switchEl = $(this);
        var pillEl = $('#status-pill-' + id);

        $.ajax({
            url: "{{ url('admin/executive-partners') }}/" + id + "/toggle-status",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}"
            },
            success: function(resp) {
                if (resp.success) {
                    if (resp.is_active) {
                        pillEl.removeClass('failed').addClass('success').text('Active');
                    } else {
                        pillEl.removeClass('success').addClass('failed').text('Inactive');
                    }
                    Swal.fire({
                        icon: 'success',
                        title: 'Status Updated',
                        text: resp.message,
                        timer: 2000,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end'
                    });
                }
            },
            error: function(err) {
                switchEl.prop('checked', !isChecked);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update partner status.'
                });
            }
        });
    });

    // Populate Edit Modal
    $(document).on('click', '.edit-ep-btn', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var code = $(this).data('code');
        var mobile = $(this).data('mobile');
        var status = $(this).data('status');

        $('#edit_ep_id').val(id);
        $('#edit_ep_name').val(name);
        $('#edit_ep_code').val(code);
        $('#edit_ep_mobile').val(mobile);
        $('#edit_ep_status').val(status);

        $('#editEpForm').attr('action', "{{ url('admin/executive-partners') }}/" + id);
        $('#editEpModal').modal('show');
    });

    // Handle AJAX Form Submit for Create
    $('#createEpForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var submitBtn = $('#saveEpSubmitBtn');
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Saving...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(resp) {
                if (resp.success) {
                    $('#createEpModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: resp.message,
                    }).then(function() {
                        window.location.reload();
                    });
                }
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html('<i class="bi bi-check-lg"></i> <span>Create Executive Partner</span>');
                var errMsg = 'An error occurred while saving.';
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

    // Handle AJAX Form Submit for Edit
    $('#editEpForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var submitBtn = $('#updateEpSubmitBtn');
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Updating...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(resp) {
                if (resp.success) {
                    $('#editEpModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Updated',
                        text: resp.message,
                    }).then(function() {
                        window.location.reload();
                    });
                }
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html('<i class="bi bi-check-lg"></i> <span>Update Executive Partner</span>');
                var errMsg = 'An error occurred while updating.';
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

    // Delete EP
    $(document).on('click', '.delete-ep-btn', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var code = $(this).data('code');

        Swal.fire({
            title: 'Delete Executive Partner?',
            html: 'Are you sure you want to delete <strong>' + name + '</strong> (' + code + ')?<br><small class="text-danger">Warning: Any linked Ground Partners will also be deleted!</small>',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/executive-partners') }}/" + id,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(resp) {
                        if (resp.success) {
                            $('#ep-row-' + id).fadeOut(300, function() {
                                $(this).remove();
                            });
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted',
                                text: resp.message,
                                timer: 2000,
                                showConfirmButton: false
                            });
                        }
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Failed to delete partner.'
                        });
                    }
                });
            }
        });
    });

});
</script>
@endpush

