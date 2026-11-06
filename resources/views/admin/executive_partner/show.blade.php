@extends('admin.layouts.app')

@section('title', $partner->name . ' (' . $partner->code . ') - Executive Partner Details')

@section('content')
<div class="container-fluid p-0">

  <!-- START: Page Header -->
  <div class="page-header d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <a href="{{ route('admin.executive-partners.index') }}" class="btn btn-light btn-sm rounded-circle p-1" style="width: 32px; height: 32px;" title="Back to EPs List">
          <i class="bi bi-arrow-left"></i>
        </a>
        <h1 class="page-title mb-0">{{ $partner->name }}</h1>
        <span class="badge bg-dark text-warning font-monospace px-2.5 py-1 border border-warning border-opacity-25 ms-1">
          {{ $partner->code }}
        </span>
        <span class="badge-table {{ $partner->isActive() ? 'success' : 'failed' }} ms-1">
          {{ ucfirst($partner->status) }}
        </span>
      </div>
      <p class="page-subtitle mb-0">Executive Partner profile, assigned Ground Partners (GP) network, and contact info.</p>
    </div>

    <div class="d-flex align-items-center gap-2">
      <a href="{{ route('admin.executive-partners.index') }}" class="btn-custom btn-custom-light btn-custom-sm">
        <i class="bi bi-list-ul"></i>
        <span>All EPs</span>
      </a>
      <button type="button" class="btn-custom btn-custom-primary btn-custom-sm" data-bs-toggle="modal" data-bs-target="#createGpModal">
        <i class="bi bi-plus-lg"></i>
        <span>Add Ground Partner</span>
      </button>
    </div>
  </div>
  <!-- END: Page Header -->

  <!-- Top Info Card -->
  <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
    <div class="row g-4 align-items-center">
      <div class="col-12 col-md-auto text-center text-md-start">
        <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white fw-bold shadow-sm" 
             style="width: 72px; height: 72px; background: linear-gradient(135deg, #0d6efd, #0b5ed7); font-size: 1.75rem;">
          {{ strtoupper(substr($partner->name, 0, 1)) }}
        </div>
      </div>
      <div class="col-12 col-md">
        <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
          <h3 class="fw-bold mb-0 text-dark">{{ $partner->name }}</h3>
          <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2.5 py-1">
            Executive Partner
          </span>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-3 text-muted small mt-2">
          <div><i class="bi bi-qr-code text-warning me-1"></i> Code: <strong class="text-dark font-monospace">{{ $partner->code }}</strong></div>
          <div><i class="bi bi-telephone text-success me-1"></i> Mobile: <a href="tel:{{ $partner->mobile }}" class="text-dark text-decoration-none fw-semibold">{{ $partner->mobile }}</a></div>
          <div><i class="bi bi-calendar3 text-muted me-1"></i> Registered: <strong class="text-dark">{{ $partner->created_at->format('M d, Y h:i A') }}</strong></div>
        </div>
      </div>
      <div class="col-12 col-md-auto text-md-end">
        <div class="p-3 bg-light rounded-4 border text-center" style="min-width: 140px;">
          <span class="text-uppercase fw-bold text-muted d-block small" style="font-size: 0.7rem; letter-spacing: 0.05em;">Assigned GPs</span>
          <h3 class="fw-bold text-primary mb-0 mt-1">{{ count($partner->groundPartners) }}</h3>
        </div>
      </div>
    </div>
  </div>

  <!-- Ground Partners List Table Container -->
  <div class="table-card-custom mb-4">
    <div class="p-3.5 border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
      <div class="d-flex align-items-center gap-2">
        <i class="bi bi-geo-alt-fill text-info fs-5"></i>
        <h5 class="fw-bold mb-0">Assigned Ground Partners ({{ count($partner->groundPartners) }})</h5>
      </div>
      <button type="button" class="btn-custom btn-custom-primary btn-custom-sm" data-bs-toggle="modal" data-bs-target="#createGpModal">
        <i class="bi bi-plus-lg"></i> Add GP Under {{ $partner->name }}
      </button>
    </div>

    <div class="table-responsive">
      <table class="table-custom mb-0">
        <thead>
          <tr>
            <th class="ps-4" style="width: 140px;">GP Code</th>
            <th>Ground Partner Name</th>
            <th>Mobile Number</th>
            <th>Status</th>
            <th>Registered Date</th>
            <th class="text-center pe-4" style="width: 120px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($partner->groundPartners as $gp)
            <tr id="gp-row-{{ $gp->id }}">
              <td class="ps-4">
                <span class="badge bg-dark text-info border border-info border-opacity-25 font-monospace px-2.5 py-1">
                  {{ $gp->code }}
                </span>
              </td>
              <td>
                <div class="d-flex align-items-center gap-2.5">
                  <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-2xs" 
                       style="width: 32px; height: 32px; background: linear-gradient(135deg, #0dcaf0, #0aa2c0); font-size: 0.8rem;">
                    {{ strtoupper(substr($gp->name, 0, 1)) }}
                  </div>
                  <span class="fw-bold text-dark">{{ $gp->name }}</span>
                </div>
              </td>
              <td>
                <a href="tel:{{ $gp->mobile }}" class="text-decoration-none text-dark fw-semibold">
                  <i class="bi bi-telephone text-muted me-1 small"></i>{{ $gp->mobile }}
                </a>
              </td>
              <td>
                <span class="badge-table {{ $gp->isActive() ? 'success' : 'failed' }}">
                  {{ ucfirst($gp->status) }}
                </span>
              </td>
              <td>
                <div class="table-user-sub">{{ $gp->created_at->format('M d, Y') }}</div>
              </td>
              <td class="text-center pe-4">
                <div class="d-flex align-items-center justify-content-center gap-1.5">
                  <a href="{{ route('admin.ground-partners.show', $gp->id) }}" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2" title="View GP Details">
                    <i class="bi bi-eye text-info"></i>
                  </a>
                  <button type="button" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2 delete-gp-btn" 
                          data-id="{{ $gp->id }}" 
                          data-name="{{ htmlspecialchars($gp->name, ENT_QUOTES) }}"
                          data-code="{{ $gp->code }}"
                          title="Delete GP">
                    <i class="bi bi-trash text-danger"></i>
                  </button>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="6" class="text-center py-5 text-muted">
                <div class="w-16 h-16 rounded-circle bg-light text-muted d-inline-flex align-items-center justify-content-center fs-2 mb-2">
                  <i class="bi bi-geo-alt"></i>
                </div>
                <div class="fw-semibold fs-6">No Ground Partners Assigned Yet</div>
                <p class="small text-muted mb-3">You can add and assign Ground Partners to {{ $partner->name }} directly.</p>
                <button type="button" class="btn-custom btn-custom-primary btn-custom-sm" data-bs-toggle="modal" data-bs-target="#createGpModal">
                  <i class="bi bi-plus-lg"></i> Add Ground Partner
                </button>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

</div>

<!-- START: Create GP Modal Pre-selected for this EP -->
<div class="modal fade" id="createGpModal" tabindex="-1" aria-labelledby="createGpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="modal-header bg-dark text-white p-3.5 border-0">
        <div class="d-flex align-items-center gap-2">
          <i class="bi bi-geo-alt-fill text-warning fs-5"></i>
          <h5 class="modal-title fw-bold text-white mb-0" id="createGpModalLabel">Add Ground Partner for {{ $partner->name }}</h5>
        </div>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="createGpForm" method="POST" action="{{ route('admin.ground-partners.store') }}">
        @csrf
        <input type="hidden" name="ep_id" value="{{ $partner->id }}">

        <div class="modal-body p-4">
          <div class="mb-3">
            <label class="form-label fw-bold small text-muted text-uppercase">Assigned Executive Partner (EP)</label>
            <input type="text" class="form-control bg-light" value="{{ $partner->name }} ({{ $partner->code }})" readonly>
          </div>

          <div class="mb-3">
            <label class="form-label fw-bold small text-muted text-uppercase">Ground Partner Full Name <span class="text-danger">*</span></label>
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
<!-- END: Create GP Modal -->

@endsection

@push('scripts')
<script>
$(document).ready(function() {

    // Submit Create GP
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
                        text: resp.message
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

