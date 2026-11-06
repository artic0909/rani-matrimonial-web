@extends('admin.layouts.app')

@section('title', 'Ground Partners (GP) Management - Rani Matrimonial Admin')

@section('content')
<div class="container-fluid p-0">
  
  <!-- START: Page Header Banner -->
  <div class="page-header d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <i class="bi bi-geo-alt-fill fs-4 text-info"></i>
        <h1 class="page-title mb-0">Ground Partners (GP)</h1>
        <span class="badge-table success ms-2">
          {{ number_format($counts['total']) }} Total GPs
        </span>
      </div>
      <p class="page-subtitle mb-0">Manage ground partners, map them under executive partners (EP), track status and contact numbers.</p>
    </div>

    <div class="d-flex align-items-center gap-2">
      <a href="{{ route('admin.executive-partners.index') }}" class="btn-custom btn-custom-light btn-custom-sm">
        <i class="bi bi-person-badge-fill text-primary"></i>
        <span>View Executive Partners</span>
      </a>
      <button type="button" class="btn-custom btn-custom-primary btn-custom-sm" data-bs-toggle="modal" data-bs-target="#createGpModal">
        <i class="bi bi-plus-lg"></i>
        <span>Add New GP</span>
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
            <span class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.725rem; letter-spacing: 0.06em; margin-bottom: 0.35rem;">Total Ground Partners</span>
            <h2 class="fw-bold mb-0" style="font-size: 1.75rem; color: var(--text-main); line-height: 1.2;">{{ number_format($counts['total']) }}</h2>
          </div>
          <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; background-color: rgba(13, 202, 240, 0.12); color: #0dcaf0; font-size: 1.35rem;">
            <i class="bi bi-geo-alt-fill"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-3">
      <div class="card p-3 p-xl-3.5 rounded-4 shadow-sm border-0 h-100 bg-white">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <span class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.725rem; letter-spacing: 0.06em; margin-bottom: 0.35rem;">Active GPs</span>
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
            <span class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.725rem; letter-spacing: 0.06em; margin-bottom: 0.35rem;">Inactive GPs</span>
            <h2 class="fw-bold mb-0 text-secondary" style="font-size: 1.75rem; line-height: 1.2;">{{ number_format($counts['inactive']) }}</h2>
          </div>
          <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; background-color: rgba(108, 117, 125, 0.12); color: #6c757d; font-size: 1.35rem;">
            <i class="bi bi-eye-slash-fill"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-3">
      <div class="card p-3 p-xl-3.5 rounded-4 shadow-sm border-0 h-100 bg-white">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <span class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.725rem; letter-spacing: 0.06em; margin-bottom: 0.35rem;">Executive Partners Represented</span>
            <h2 class="fw-bold mb-0 text-primary" style="font-size: 1.75rem; line-height: 1.2;">{{ number_format($counts['eps_count']) }}</h2>
          </div>
          <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; background-color: rgba(13, 110, 253, 0.1); color: #0d6efd; font-size: 1.35rem;">
            <i class="bi bi-person-badge-fill"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END: Metric Statistics Cards -->

  <!-- START: Main GP Container (Table Card Custom) -->
  <div class="table-card-custom mb-4">
    
    <!-- Header Controls & Filters -->
    <div class="table-header-control">
      <!-- Status Tabs -->
      <div class="d-flex flex-wrap align-items-center gap-2 flex-grow-1">
        <a href="{{ route('admin.ground-partners.index', ['search' => $search, 'status' => 'all', 'ep_id' => $epId]) }}" 
           class="btn-custom btn-custom-sm {{ ($status ?? 'all') === 'all' ? 'btn-custom-primary' : 'btn-custom-light' }}">
          All GPs ({{ $counts['total'] }})
        </a>
        <a href="{{ route('admin.ground-partners.index', ['search' => $search, 'status' => 'active', 'ep_id' => $epId]) }}" 
           class="btn-custom btn-custom-sm {{ ($status ?? '') === 'active' ? 'btn-custom-primary' : 'btn-custom-light' }}">
          <i class="bi bi-check2-circle"></i> Active ({{ $counts['active'] }})
        </a>
        <a href="{{ route('admin.ground-partners.index', ['search' => $search, 'status' => 'inactive', 'ep_id' => $epId]) }}" 
           class="btn-custom btn-custom-sm {{ ($status ?? '') === 'inactive' ? 'btn-custom-primary' : 'btn-custom-light' }}">
          <i class="bi bi-eye-slash"></i> Inactive ({{ $counts['inactive'] }})
        </a>
      </div>

      <div class="d-flex flex-wrap align-items-center gap-2 ms-auto">
        <!-- Filter by Executive Partner (EP) -->
        <div class="d-flex align-items-center gap-1.5">
          <label class="small text-muted fw-bold text-nowrap d-none d-sm-inline"><i class="bi bi-filter"></i> EP:</label>
          <div style="min-width: 220px;">
            <select id="filter_ep_select" class="form-select form-select-sm select2" data-placeholder="All Executive Partners">
              <option value="all" {{ ($epId ?? 'all') === 'all' ? 'selected' : '' }}>All Executive Partners</option>
              @foreach($executivePartners as $epItem)
                @if(strtolower((string)$epItem->status) === 'active')
                  <option value="{{ $epItem->id }}" {{ (string)$epId === (string)$epItem->id ? 'selected' : '' }}>
                    {{ $epItem->name }} ({{ $epItem->code }})
                  </option>
                @endif
              @endforeach
            </select>
          </div>
        </div>

        <!-- Search Box Form -->
        <form method="GET" action="{{ route('admin.ground-partners.index') }}" class="table-search-box m-0" style="min-width: 240px;">
          @if(($status ?? 'all') !== 'all')
            <input type="hidden" name="status" value="{{ $status }}">
          @endif
          @if(!empty($epId) && $epId !== 'all')
            <input type="hidden" name="ep_id" value="{{ $epId }}">
          @endif
          <i class="bi bi-search table-search-icon"></i>
          <input type="text" 
                 name="search" 
                 class="table-search-input" 
                 placeholder="Search GP, EP, mobile..." 
                 value="{{ $search }}">
        </form>

        @if(!empty($search) || (!empty($epId) && $epId !== 'all'))
          <a href="{{ route('admin.ground-partners.index', ['status' => $status]) }}" class="btn-custom btn-custom-light btn-custom-sm" title="Clear filters">
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
            <th class="ps-4" style="width: 140px;">GP Code</th>
            <th>Ground Partner Name</th>
            <th>Executive Partner (EP)</th>
            <th>Mobile Number</th>
            <th>Status</th>
            <th>Registered Date</th>
            <th class="text-center pe-4" style="width: 130px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($partners as $partner)
            <tr id="gp-row-{{ $partner->id }}">
              <td class="ps-4">
                <span class="badge bg-dark text-info border border-info border-opacity-25 font-monospace px-2.5 py-1">
                  {{ $partner->code }}
                </span>
              </td>
              <td>
                <div class="d-flex align-items-center gap-2.5">
                  <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-2xs" 
                       style="width: 36px; height: 36px; background: linear-gradient(135deg, #0dcaf0, #0aa2c0); font-size: 0.85rem;">
                    {{ strtoupper(substr($partner->name, 0, 1)) }}
                  </div>
                  <div>
                    <a href="{{ route('admin.ground-partners.show', $partner->id) }}" class="fw-bold text-decoration-none text-dark hover-primary">
                      {{ $partner->name }}
                    </a>
                  </div>
                </div>
              </td>
              <td>
                @if($partner->executivePartner)
                  <a href="{{ route('admin.executive-partners.show', $partner->executivePartner->id) }}" 
                     class="d-inline-flex align-items-center gap-1.5 text-decoration-none" title="View Executive Partner">
                    <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2 py-0.5 font-monospace small">
                      {{ $partner->executivePartner->code }}
                    </span>
                    <span class="text-dark fw-semibold small hover-primary">{{ $partner->executivePartner->name }}</span>
                  </a>
                @else
                  <span class="text-muted small italic">Not Assigned</span>
                @endif
              </td>
              <td>
                <a href="tel:{{ $partner->mobile }}" class="text-decoration-none text-dark fw-semibold">
                  <i class="bi bi-telephone text-muted me-1 small"></i>{{ $partner->mobile }}
                </a>
              </td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <div class="form-check form-switch mb-0">
                    <input class="form-check-input cursor-pointer toggle-status-btn" 
                           type="checkbox" 
                           role="switch" 
                           id="switch-gp-{{ $partner->id }}" 
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
                  <a href="{{ route('admin.ground-partners.show', $partner->id) }}" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2" title="View Details">
                    <i class="bi bi-eye text-info"></i>
                  </a>
                  <button type="button" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2 edit-gp-btn" 
                          title="Edit Partner" 
                          data-id="{{ $partner->id }}"
                          data-ep-id="{{ $partner->ep_id }}"
                          data-name="{{ htmlspecialchars($partner->name, ENT_QUOTES) }}"
                          data-code="{{ $partner->code }}"
                          data-mobile="{{ $partner->mobile }}"
                          data-status="{{ $partner->status }}">
                    <i class="bi bi-pencil-square text-primary"></i>
                  </button>
                  <button type="button" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2 delete-gp-btn" 
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
                  <i class="bi bi-geo-alt"></i>
                </div>
                <div class="fw-semibold fs-6">No Ground Partners Found</div>
                <p class="small text-muted mb-3">Try adjusting your filters or add a new Ground Partner.</p>
                <button type="button" class="btn-custom btn-custom-primary btn-custom-sm" data-bs-toggle="modal" data-bs-target="#createGpModal">
                  <i class="bi bi-plus-lg"></i> Add New GP
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
  <!-- END: Main GP Container -->

</div>

<!-- START: Create Ground Partner Modal -->
<div class="modal fade" id="createGpModal" tabindex="-1" aria-labelledby="createGpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="modal-header bg-dark text-white p-3.5 border-0">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-geo-alt-fill text-warning fs-5"></i>
          <h5 class="modal-title fw-bold text-white mb-0" id="createGpModalLabel">Add New Ground Partner</h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="createGpForm" method="POST" action="{{ route('admin.ground-partners.store') }}">
        @csrf
        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label fw-bold small text-muted text-uppercase">Assigned Executive Partner (EP) <span class="text-danger">*</span></label>
            <select name="ep_id" id="create_gp_ep_id" class="form-select select2 w-100" data-placeholder="-- Search & Select Executive Partner --" required>
              <option value=""></option>
              @foreach($executivePartners as $epItem)
                @if(strtolower((string)$epItem->status) === 'active')
                  <option value="{{ $epItem->id }}" {{ (string)$epId === (string)$epItem->id ? 'selected' : '' }}>
                    {{ $epItem->name }} ({{ $epItem->code }})
                  </option>
                @endif
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold small text-muted text-uppercase">Full Name <span class="text-danger">*</span></label>
            <input type="text" name="name" class="form-control" placeholder="Enter ground partner name" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold small text-muted text-uppercase">Partner Code</label>
            <input type="text" name="code" class="form-control font-monospace" placeholder="e.g. GP001 (Leave empty to auto-generate)">
            <small class="text-muted">If left blank, system generates an automated unique code (e.g. GP001).</small>
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
          <button type="submit" class="btn-custom btn-custom-primary btn-custom-sm" id="saveGpSubmitBtn">
            <i class="bi bi-check-lg"></i>
            <span>Create Ground Partner</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>
<!-- END: Create Modal -->

<!-- START: Edit Ground Partner Modal -->
<div class="modal fade" id="editGpModal" tabindex="-1" aria-labelledby="editGpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="modal-header bg-dark text-white p-3.5 border-0">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-pencil-square text-warning fs-5"></i>
          <h5 class="modal-title fw-bold text-white mb-0" id="editGpModalLabel">Edit Ground Partner</h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="editGpForm" method="POST" action="">
        @csrf
        @method('PUT')
        <input type="hidden" id="edit_gp_id" name="id">

        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label fw-bold small text-muted text-uppercase">Assigned Executive Partner (EP) <span class="text-danger">*</span></label>
            <select id="edit_gp_ep_id" name="ep_id" class="form-select select2 w-100" data-placeholder="-- Search & Select Executive Partner --" required>
              <option value=""></option>
              @foreach($executivePartners as $epItem)
                @if(strtolower((string)$epItem->status) === 'active')
                  <option value="{{ $epItem->id }}">
                    {{ $epItem->name }} ({{ $epItem->code }})
                  </option>
                @endif
              @endforeach
            </select>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold small text-muted text-uppercase">Full Name <span class="text-danger">*</span></label>
            <input type="text" id="edit_gp_name" name="name" class="form-control" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold small text-muted text-uppercase">Partner Code <span class="text-danger">*</span></label>
            <input type="text" id="edit_gp_code" name="code" class="form-control font-monospace" required>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold small text-muted text-uppercase">Mobile Number <span class="text-danger">*</span></label>
            <input type="text" id="edit_gp_mobile" name="mobile" class="form-control" required>
          </div>

          <div class="mb-2">
            <label class="form-label fw-bold small text-muted text-uppercase">Status <span class="text-danger">*</span></label>
            <select id="edit_gp_status" name="status" class="form-select" required>
              <option value="active">Active</option>
              <option value="inactive">Inactive</option>
            </select>
          </div>
        </div>

        <div class="modal-footer bg-light p-3 border-0">
          <button type="button" class="btn-custom btn-custom-light btn-custom-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-custom btn-custom-primary btn-custom-sm" id="updateGpSubmitBtn">
            <i class="bi bi-check-lg"></i>
            <span>Update Ground Partner</span>
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
function filterByEp(epId) {
    var url = new URL(window.location.href);
    if (epId && epId !== 'all') {
        url.searchParams.set('ep_id', epId);
    } else {
        url.searchParams.delete('ep_id');
    }
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

$(document).ready(function() {

    // Toggle Status
    $(document).on('change', '.toggle-status-btn', function() {
        var id = $(this).data('id');
        var isChecked = $(this).is(':checked');
        var switchEl = $(this);
        var pillEl = $('#status-pill-' + id);

        $.ajax({
            url: "{{ url('admin/ground-partners') }}/" + id + "/toggle-status",
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

    // Filter by EP select2 change
    $('#filter_ep_select').on('change', function() {
        filterByEp($(this).val());
    });

    // Reset Create Modal when hidden
    $('#createGpModal').on('hidden.bs.modal', function() {
        $('#createGpForm')[0].reset();
        $('#create_gp_ep_id').val('').trigger('change');
    });

    // Populate Edit Modal
    $(document).on('click', '.edit-gp-btn', function() {
        var id = $(this).data('id');
        var epId = $(this).data('ep-id');
        var name = $(this).data('name');
        var code = $(this).data('code');
        var mobile = $(this).data('mobile');
        var status = $(this).data('status');

        $('#edit_gp_id').val(id);
        $('#edit_gp_name').val(name);
        $('#edit_gp_code').val(code);
        $('#edit_gp_mobile').val(mobile);
        $('#edit_gp_status').val(status);
        $('#edit_gp_ep_id').val(epId).trigger('change');

        $('#editGpForm').attr('action', "{{ url('admin/ground-partners') }}/" + id);
        $('#editGpModal').modal('show');
    });

    // Handle AJAX Form Submit for Create
    $('#createGpForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var submitBtn = $('#saveGpSubmitBtn');
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Saving...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(resp) {
                if (resp.success) {
                    $('#createGpModal').modal('hide');
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
                submitBtn.prop('disabled', false).html('<i class="bi bi-check-lg"></i> <span>Create Ground Partner</span>');
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
    $('#editGpForm').on('submit', function(e) {
        e.preventDefault();
        var form = $(this);
        var submitBtn = $('#updateGpSubmitBtn');
        submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Updating...');

        $.ajax({
            url: form.attr('action'),
            type: 'POST',
            data: form.serialize(),
            success: function(resp) {
                if (resp.success) {
                    $('#editGpModal').modal('hide');
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
                submitBtn.prop('disabled', false).html('<i class="bi bi-check-lg"></i> <span>Update Ground Partner</span>');
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

    // Delete GP
    $(document).on('click', '.delete-gp-btn', function() {
        var id = $(this).data('id');
        var name = $(this).data('name');
        var code = $(this).data('code');

        Swal.fire({
            title: 'Delete Ground Partner?',
            html: 'Are you sure you want to delete <strong>' + name + '</strong> (' + code + ')?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, delete',
            cancelButtonText: 'Cancel'
        }).then(function(result) {
            if (result.isConfirmed) {
                $.ajax({
                    url: "{{ url('admin/ground-partners') }}/" + id,
                    type: 'DELETE',
                    data: {
                        _token: "{{ csrf_token() }}"
                    },
                    success: function(resp) {
                        if (resp.success) {
                            $('#gp-row-' + id).fadeOut(300, function() {
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

