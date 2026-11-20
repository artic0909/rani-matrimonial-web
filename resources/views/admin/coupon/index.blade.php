@extends('admin.layouts.app')

@section('title', 'Coupon Codes Management - Rani Matrimonial Admin')

@section('content')
<div class="container-fluid p-0">
  
  <!-- START: Page Header Banner -->
  <div class="page-header d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <i class="bi bi-ticket-perforated-fill fs-4" style="color: var(--brand-forest-medium);"></i>
        <h1 class="page-title mb-0">Coupon Codes</h1>
        <span class="badge-table success ms-2">
          {{ number_format($counts['total']) }} Coupons
        </span>
      </div>
      <p class="page-subtitle mb-0">Manage promotional and welcome bonus coupons. Newly registered candidates automatically receive the active coupon amount into their wallet before the expiry date.</p>
    </div>

    <div class="d-flex align-items-center gap-2">
      <button type="button" class="btn-custom btn-custom-primary btn-custom-sm" data-bs-toggle="modal" data-bs-target="#createCouponModal">
        <i class="bi bi-plus-lg"></i>
        <span>Add New Coupon</span>
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
            <span class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.725rem; letter-spacing: 0.06em; margin-bottom: 0.35rem;">Total Coupons</span>
            <h2 class="fw-bold mb-0" style="font-size: 1.75rem; color: var(--text-main); line-height: 1.2;">{{ number_format($counts['total']) }}</h2>
          </div>
          <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; background-color: rgba(13, 202, 240, 0.12); color: #0dcaf0; font-size: 1.35rem;">
            <i class="bi bi-ticket-perforated"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-3">
      <div class="card p-3 p-xl-3.5 rounded-4 shadow-sm border-0 h-100 bg-white">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <span class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.725rem; letter-spacing: 0.06em; margin-bottom: 0.35rem;">Active Campaigns</span>
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
            <span class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.725rem; letter-spacing: 0.06em; margin-bottom: 0.35rem;">Candidates Benefited</span>
            <h2 class="fw-bold mb-0 text-primary" style="font-size: 1.75rem; line-height: 1.2;">{{ number_format($counts['total_usages']) }}</h2>
          </div>
          <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; background-color: rgba(13, 110, 253, 0.12); color: #0d6efd; font-size: 1.35rem;">
            <i class="bi bi-people-fill"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-3">
      <div class="card p-3 p-xl-3.5 rounded-4 shadow-sm border-0 h-100 bg-white">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <span class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.725rem; letter-spacing: 0.06em; margin-bottom: 0.35rem;">Total Bonus Distributed</span>
            <h2 class="fw-bold mb-0" style="font-size: 1.75rem; color: #b45309; line-height: 1.2;">₹{{ number_format($counts['total_distributed'], 2) }}</h2>
          </div>
          <div class="rounded-3 d-flex align-items-center justify-content-center flex-shrink-0" style="width: 46px; height: 46px; background-color: rgba(245, 158, 11, 0.12); color: #f59e0b; font-size: 1.35rem;">
            <i class="bi bi-wallet2"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- END: Metric Statistics Cards -->

  <!-- START: Main Data Table Container -->
  <div class="table-card-custom">
    
    <!-- Header Controls & Filters -->
    <div class="table-header-control">
      <form method="GET" action="{{ route('admin.coupons.index') }}" class="d-flex flex-wrap align-items-center gap-2.5 flex-grow-1" id="filterForm">
        <!-- Search Box -->
        <div class="table-search-box m-0" style="max-width: 320px; min-width: 240px;">
          <i class="bi bi-search table-search-icon"></i>
          <input type="text" 
                 name="search" 
                 value="{{ request('search') }}" 
                 class="table-search-input" 
                 placeholder="Search coupon code or name...">
        </div>

        <!-- Status Filter -->
        <div style="min-width: 170px;">
          <select name="status" class="form-select form-select-sm" onchange="document.getElementById('filterForm').submit()">
            <option value="">All Statuses</option>
            <option value="active" {{ request('status') === 'active' ? 'selected' : '' }}>Active Campaigns</option>
            <option value="inactive" {{ request('status') === 'inactive' ? 'selected' : '' }}>Inactive Campaigns</option>
            <option value="expired" {{ request('status') === 'expired' ? 'selected' : '' }}>Expired Coupons</option>
          </select>
        </div>

        @if(request()->hasAny(['search', 'status']))
          <a href="{{ route('admin.coupons.index') }}" class="btn btn-sm btn-outline-secondary rounded-pill px-3">
            <i class="bi bi-x-circle me-1"></i> Reset
          </a>
        @endif
      </form>

      <!-- Per Page Selector -->
      <div class="d-flex align-items-center gap-2 ms-auto">
        <label for="per-page-select" class="form-label mb-0 small text-muted text-nowrap">Show:</label>
        <select id="per-page-select" class="form-select form-select-sm bg-light w-auto border rounded-2" onchange="window.location.href = '{{ request()->fullUrlWithQuery(['per_page' => '']) }}' + this.value">
          <option value="10" {{ request('per_page', 10) == 10 ? 'selected' : '' }}>10</option>
          <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
          <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
        </select>
      </div>
    </div>

    <!-- Table -->
    <div class="table-responsive">
      <table class="table-custom">
        <thead>
          <tr>
            <th class="ps-4" style="width: 60px;">#</th>
            <th>Coupon Code</th>
            <th>Campaign Name</th>
            <th>Bonus Amount</th>
            <th>End / Expiry Date</th>
            <th>Candidates Benefited</th>
            <th>Status</th>
            <th class="text-center pe-4" style="width: 160px;">Actions</th>
          </tr>
        </thead>
        <tbody>
          @forelse($coupons as $index => $coupon)
            @php
              $isExpired = \Carbon\Carbon::parse($coupon->end_date)->endOfDay()->isPast();
              $daysLeft = now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($coupon->end_date)->startOfDay(), false);
            @endphp
            <tr>
              <td class="ps-4 text-muted small">{{ $coupons->firstItem() + $index }}</td>
              <td>
                <div class="d-flex align-items-center gap-2">
                  <span class="badge bg-dark bg-opacity-10 text-dark border border-secondary border-opacity-25 px-2.5 py-1.5 rounded-2 font-monospace fw-bold" style="font-size: 0.85rem; letter-spacing: 0.05em;">
                    <i class="bi bi-tag-fill text-success me-1"></i>{{ $coupon->code }}
                  </span>
                  <button type="button" class="btn btn-sm btn-link text-muted p-0" title="Copy Code" onclick="navigator.clipboard.writeText('{{ $coupon->code }}'); alert('Coupon code {{ $coupon->code }} copied!')">
                    <i class="bi bi-clipboard"></i>
                  </button>
                </div>
              </td>
              <td>
                <span class="fw-semibold text-main">{{ $coupon->title ?: '-' }}</span>
              </td>
              <td>
                <span class="fw-bold text-success" style="font-size: 0.95rem;">
                  ₹{{ number_format($coupon->amount, 2) }}
                </span>
              </td>
              <td>
                <div>
                  <span class="fw-medium text-main">{{ \Carbon\Carbon::parse($coupon->end_date)->format('d M, Y') }}</span>
                  <div class="mt-0.5">
                    @if($isExpired)
                      <span class="badge bg-danger bg-opacity-10 text-danger border border-danger border-opacity-25 px-2 py-0.5 rounded-pill" style="font-size: 0.7rem;">
                        <i class="bi bi-x-circle me-1"></i>Expired
                      </span>
                    @elseif($daysLeft == 0)
                      <span class="badge bg-warning bg-opacity-15 text-dark border border-warning border-opacity-50 px-2 py-0.5 rounded-pill" style="font-size: 0.7rem;">
                        <i class="bi bi-clock-history me-1"></i>Expires Today
                      </span>
                    @else
                      <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2 py-0.5 rounded-pill" style="font-size: 0.7rem;">
                        <i class="bi bi-clock me-1"></i>{{ $daysLeft }} {{ \Illuminate\Support\Str::plural('day', $daysLeft) }} left
                      </span>
                    @endif
                  </div>
                </div>
              </td>
              <td>
                <button type="button" 
                        class="btn btn-sm btn-outline-primary rounded-pill px-2.5 py-0.5" 
                        style="font-size: 0.785rem;"
                        onclick="viewCouponUsages({{ $coupon->id }})"
                        title="View Candidates">
                  <i class="bi bi-people-fill me-1"></i>{{ number_format($coupon->usages_count) }} {{ \Illuminate\Support\Str::plural('Candidate', $coupon->usages_count) }}
                </button>
              </td>
              <td>
                <div class="form-check form-switch m-0">
                  <input class="form-check-input" 
                         type="checkbox" 
                         role="switch" 
                         id="statusSwitch{{ $coupon->id }}" 
                         {{ $coupon->is_active ? 'checked' : '' }} 
                         onchange="toggleCouponStatus({{ $coupon->id }}, this)">
                  <label class="form-check-label small ms-1 text-muted" for="statusSwitch{{ $coupon->id }}" id="statusLabel{{ $coupon->id }}">
                    {{ $coupon->is_active ? 'Active' : 'Inactive' }}
                  </label>
                </div>
              </td>
              <td class="text-center pe-4">
                <div class="d-inline-flex align-items-center gap-1.5">
                  <button type="button" 
                          class="btn btn-sm btn-light border rounded-2 px-2 py-1 text-primary" 
                          title="Edit Coupon" 
                          onclick="openEditCouponModal({{ json_encode($coupon) }})">
                    <i class="bi bi-pencil-square"></i>
                  </button>
                  <button type="button" 
                          class="btn btn-sm btn-light border rounded-2 px-2 py-1 text-danger" 
                          title="Delete Coupon" 
                          onclick="deleteCoupon({{ $coupon->id }}, '{{ $coupon->code }}')">
                    <i class="bi bi-trash"></i>
                  </button>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" class="text-center py-5 text-muted">
                <i class="bi bi-ticket-perforated fs-1 d-block mb-2 text-muted opacity-50"></i>
                <h6 class="fw-semibold mb-1">No coupons found</h6>
                <p class="small text-muted mb-3">Create your first welcome bonus coupon code to reward newly registered candidates.</p>
                <button type="button" class="btn btn-sm btn-primary rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#createCouponModal">
                  <i class="bi bi-plus-lg me-1"></i> Add Coupon
                </button>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    <!-- Pagination Footer -->
    @if($coupons->hasPages())
      <div class="p-3 bg-white border-top d-flex flex-column flex-md-row align-items-center justify-content-between gap-3 table-footer-control">
        <div class="table-user-sub">
          Showing {{ $coupons->firstItem() }} to {{ $coupons->lastItem() }} of {{ $coupons->total() }} records
        </div>
        <div>
          {{ $coupons->links('pagination::bootstrap-5') }}
        </div>
      </div>
    @endif

  </div>
  <!-- END: Main Data Table Container -->

</div>

<!-- ==========================================
     CREATE COUPON MODAL
     ========================================== -->
<div class="modal fade" id="createCouponModal" tabindex="-1" aria-labelledby="createCouponModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="modal-header border-bottom px-4 py-3 bg-light">
        <h5 class="modal-title fw-bold text-main" id="createCouponModalLabel">
          <i class="bi bi-plus-circle me-1.5" style="color: var(--brand-forest-medium);"></i> Add New Coupon Code
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form action="{{ route('admin.coupons.store') }}" method="POST" id="createCouponForm">
        @csrf
        <div class="modal-body p-4">
          <div class="mb-3">
            <label for="create_code" class="form-label fw-semibold small text-main">
              Coupon Code <span class="text-danger">*</span>
            </label>
            <input type="text" 
                   name="code" 
                   id="create_code" 
                   class="form-control rounded-3 text-uppercase font-monospace fw-bold" 
                   placeholder="e.g. WELCOME100" 
                   required 
                   autocomplete="off"
                   oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9_]/g, '')">
            <div class="form-text small">Use letters and numbers (e.g. WELCOME50, NEWYEAR100).</div>
          </div>

          <div class="mb-3">
            <label for="create_title" class="form-label fw-semibold small text-main">
              Coupon / Campaign Name
            </label>
            <input type="text" 
                   name="title" 
                   id="create_title" 
                   class="form-control rounded-3" 
                   placeholder="e.g. Welcome Registration Bonus">
          </div>

          <div class="row g-3 mb-3">
            <div class="col-6">
              <label for="create_amount" class="form-label fw-semibold small text-main">
                Bonus Amount (₹) <span class="text-danger">*</span>
              </label>
              <div class="input-group">
                <span class="input-group-text bg-light fw-bold">₹</span>
                <input type="number" 
                       name="amount" 
                       id="create_amount" 
                       class="form-control rounded-end-3 fw-bold" 
                       placeholder="50" 
                       min="1" 
                       step="1" 
                       required>
              </div>
            </div>

            <div class="col-6">
              <label for="create_end_date" class="form-label fw-semibold small text-main">
                End / Expiry Date <span class="text-danger">*</span>
              </label>
              <input type="date" 
                     name="end_date" 
                     id="create_end_date" 
                     class="form-control rounded-3" 
                     min="{{ date('Y-m-d') }}" 
                     required>
            </div>
          </div>

          <div class="form-check form-switch pt-2">
            <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="create_is_active" value="1" checked>
            <label class="form-check-label small fw-semibold text-main" for="create_is_active">
              Activate this coupon immediately
            </label>
            <div class="form-text small">Candidates registering before the end date will automatically receive this amount in their wallet.</div>
          </div>
        </div>

        <div class="modal-footer border-top px-4 py-3 bg-light">
          <button type="button" class="btn-custom btn-custom-light btn-custom-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-custom btn-custom-primary btn-custom-sm" id="btn-create-submit">
            <i class="bi bi-check-circle me-1"></i>
            <span>Save Coupon</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ==========================================
     EDIT COUPON MODAL
     ========================================== -->
<div class="modal fade" id="editCouponModal" tabindex="-1" aria-labelledby="editCouponModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="modal-header border-bottom px-4 py-3 bg-light">
        <h5 class="modal-title fw-bold text-main" id="editCouponModalLabel">
          <i class="bi bi-pencil-square me-1.5" style="color: var(--brand-forest-medium);"></i> Edit Coupon Code
        </h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="editCouponForm" method="POST">
        @csrf
        @method('PUT')
        <div class="modal-body p-4">
          <div class="mb-3">
            <label for="edit_code" class="form-label fw-semibold small text-main">
              Coupon Code <span class="text-danger">*</span>
            </label>
            <input type="text" 
                   name="code" 
                   id="edit_code" 
                   class="form-control rounded-3 text-uppercase font-monospace fw-bold" 
                   required 
                   autocomplete="off"
                   oninput="this.value = this.value.toUpperCase().replace(/[^A-Z0-9_]/g, '')">
          </div>

          <div class="mb-3">
            <label for="edit_title" class="form-label fw-semibold small text-main">
              Coupon / Campaign Name
            </label>
            <input type="text" 
                   name="title" 
                   id="edit_title" 
                   class="form-control rounded-3">
          </div>

          <div class="row g-3 mb-3">
            <div class="col-6">
              <label for="edit_amount" class="form-label fw-semibold small text-main">
                Bonus Amount (₹) <span class="text-danger">*</span>
              </label>
              <div class="input-group">
                <span class="input-group-text bg-light fw-bold">₹</span>
                <input type="number" 
                       name="amount" 
                       id="edit_amount" 
                       class="form-control rounded-end-3 fw-bold" 
                       min="1" 
                       step="1" 
                       required>
              </div>
            </div>

            <div class="col-6">
              <label for="edit_end_date" class="form-label fw-semibold small text-main">
                End / Expiry Date <span class="text-danger">*</span>
              </label>
              <input type="date" 
                     name="end_date" 
                     id="edit_end_date" 
                     class="form-control rounded-3" 
                     required>
            </div>
          </div>

          <div class="form-check form-switch pt-2">
            <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="edit_is_active" value="1">
            <label class="form-check-label small fw-semibold text-main" for="edit_is_active">
              Campaign Active
            </label>
          </div>
        </div>

        <div class="modal-footer border-top px-4 py-3 bg-light">
          <button type="button" class="btn-custom btn-custom-light btn-custom-sm" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn-custom btn-custom-primary btn-custom-sm" id="btn-edit-submit">
            <i class="bi bi-check-circle me-1"></i>
            <span>Update Coupon</span>
          </button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- ==========================================
     USAGES MODAL (Candidates Benefited)
     ========================================== -->
<div class="modal fade" id="usagesModal" tabindex="-1" aria-labelledby="usagesModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content border-0 shadow-lg rounded-4 overflow-hidden">
      <div class="modal-header border-bottom px-4 py-3 bg-light">
        <div>
          <h5 class="modal-title fw-bold text-main mb-0" id="usagesModalLabel">
            <i class="bi bi-people-fill me-1.5 text-primary"></i> Candidates Who Received Coupon Bonus
          </h5>
          <span class="small text-muted" id="usagesModalSubtitle">Loading...</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body p-0">
        <div class="table-responsive" style="max-height: 420px;">
          <table class="table align-middle table-hover mb-0">
            <thead class="table-light sticky-top">
              <tr>
                <th class="ps-4">#</th>
                <th>Candidate ID</th>
                <th>Name</th>
                <th>Phone</th>
                <th>Bonus Credited</th>
                <th>Transaction ID</th>
                <th class="pe-4">Applied Date</th>
              </tr>
            </thead>
            <tbody id="usagesTableBody">
              <tr>
                <td colspan="7" class="text-center py-4 text-muted">
                  <div class="spinner-border spinner-border-sm me-2" role="status"></div>
                  <span>Loading candidate usages...</span>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
      <div class="modal-footer border-top px-4 py-2.5 bg-light">
        <button type="button" class="btn-custom btn-custom-light btn-custom-sm" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<!-- Hidden Delete Form -->
<form id="deleteCouponForm" method="POST" style="display: none;">
  @csrf
  @method('DELETE')
</form>

@endsection

@push('scripts')
<script>
  // Open Edit Modal with Pre-filled Data
  function openEditCouponModal(coupon) {
    const form = document.getElementById('editCouponForm');
    form.action = "{{ url('admin/coupons') }}/" + coupon.id;
    document.getElementById('edit_code').value = coupon.code;
    document.getElementById('edit_title').value = coupon.title || '';
    document.getElementById('edit_amount').value = Math.round(coupon.amount);
    
    // Format date YYYY-MM-DD
    if (coupon.end_date) {
      const dateStr = coupon.end_date.split('T')[0];
      document.getElementById('edit_end_date').value = dateStr;
    }
    
    document.getElementById('edit_is_active').checked = !!coupon.is_active;

    const modal = new bootstrap.Modal(document.getElementById('editCouponModal'));
    modal.show();
  }

  // Toggle Coupon Status via AJAX
  function toggleCouponStatus(id, switchEl) {
    const originalChecked = switchEl.checked;
    fetch("{{ url('admin/coupons') }}/" + id + "/toggle-status", {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        'X-CSRF-TOKEN': '{{ csrf_token() }}',
        'Accept': 'application/json'
      }
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        const label = document.getElementById('statusLabel' + id);
        if (label) {
          label.textContent = data.is_active ? 'Active' : 'Inactive';
        }
      } else {
        switchEl.checked = !originalChecked;
        alert(data.message || 'Failed to update status.');
      }
    })
    .catch(err => {
      switchEl.checked = !originalChecked;
      alert('Network error while toggling status.');
    });
  }

  // Delete Coupon
  function deleteCoupon(id, code) {
    if (confirm("Are you sure you want to delete coupon '" + code + "'? All usage records will also be removed.")) {
      const form = document.getElementById('deleteCouponForm');
      form.action = "{{ url('admin/coupons') }}/" + id;
      form.submit();
    }
  }

  // View Candidates who received this coupon
  function viewCouponUsages(couponId) {
    const modalEl = document.getElementById('usagesModal');
    const modal = new bootstrap.Modal(modalEl);
    const subtitle = document.getElementById('usagesModalSubtitle');
    const tbody = document.getElementById('usagesTableBody');

    subtitle.textContent = 'Loading...';
    tbody.innerHTML = `
      <tr>
        <td colspan="7" class="text-center py-4 text-muted">
          <div class="spinner-border spinner-border-sm me-2 text-primary" role="status"></div>
          <span>Loading candidate list...</span>
        </td>
      </tr>
    `;

    modal.show();

    fetch("{{ url('admin/coupons') }}/" + couponId + "/usages", {
      headers: {
        'Accept': 'application/json'
      }
    })
    .then(res => res.json())
    .then(data => {
      if (data.success) {
        subtitle.textContent = `Coupon: ${data.coupon.code} (₹${data.coupon.amount}) - Total Benefited: ${data.usages.length} candidates`;
        
        if (data.usages.length === 0) {
          tbody.innerHTML = `
            <tr>
              <td colspan="7" class="text-center py-4 text-muted">
                <i class="bi bi-inbox fs-3 d-block mb-1 opacity-50"></i>
                No candidates have registered under this coupon yet.
              </td>
            </tr>
          `;
          return;
        }

        let html = '';
        data.usages.forEach((u, i) => {
          html += `
            <tr>
              <td class="ps-4 text-muted small">${i + 1}</td>
              <td><span class="badge bg-light text-dark border font-monospace">${u.candidate_code}</span></td>
              <td class="fw-medium">${u.candidate_name || 'N/A'}</td>
              <td class="text-muted small">${u.candidate_mobile}</td>
              <td><span class="badge bg-success bg-opacity-15 text-success fw-bold">₹${Number(u.amount).toFixed(2)}</span></td>
              <td><span class="small font-monospace text-muted">${u.transaction_id}</span></td>
              <td class="pe-4 small text-muted">${u.applied_at}</td>
            </tr>
          `;
        });
        tbody.innerHTML = html;
      } else {
        tbody.innerHTML = `<tr><td colspan="7" class="text-center text-danger py-3">Failed to load candidate list.</td></tr>`;
      }
    })
    .catch(err => {
      tbody.innerHTML = `<tr><td colspan="7" class="text-center text-danger py-3">Error fetching coupon data.</td></tr>`;
    });
  }
</script>
@endpush
