@extends('admin.layouts.app')

@section('title', $partner->name . ' (' . $partner->code . ') - Executive Partner Network')

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
      <p class="page-subtitle mb-0">Executive Partner network, mapped Ground Partners (GP), referred candidates, and monthly recharge records.</p>
    </div>

    <div class="d-flex align-items-center gap-2">
      <a href="{{ route('admin.executive-partners.index') }}" class="btn-custom btn-custom-light btn-custom-sm">
        <i class="bi bi-list-ul"></i>
        <span>All EPs</span>
      </a>
      <a href="{{ route('admin.executive-partners.export', array_merge(['id' => $partner->id], request()->all())) }}" 
         class="btn-custom btn-custom-light btn-custom-sm text-success border-success border-opacity-25 shadow-2xs" 
         title="Export Candidate Records to Excel">
        <i class="bi bi-file-earmark-excel-fill text-success"></i>
        <span>Export to Excel</span>
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
            Executive Partner (EP)
          </span>
        </div>
        <div class="d-flex flex-wrap align-items-center gap-3 text-muted small mt-2">
          <div><i class="bi bi-qr-code text-warning me-1"></i> Code: <strong class="text-dark font-monospace">{{ $partner->code }}</strong></div>
          <div><i class="bi bi-telephone text-success me-1"></i> Mobile: <a href="tel:{{ $partner->mobile }}" class="text-dark text-decoration-none fw-semibold">{{ $partner->mobile }}</a></div>
          <div><i class="bi bi-calendar3 text-muted me-1"></i> Joined: <strong class="text-dark">{{ $partner->created_at->format('M d, Y') }}</strong></div>
        </div>
      </div>
      <div class="col-12 col-md-auto text-md-end">
        <div class="d-flex gap-2">
          <div class="p-3 bg-light rounded-4 border text-center" style="min-width: 110px;">
            <span class="text-uppercase fw-bold text-muted d-block small" style="font-size: 0.7rem; letter-spacing: 0.05em;">Assigned GPs</span>
            <h3 class="fw-bold text-info mb-0 mt-1">{{ count($partner->groundPartners) }}</h3>
          </div>
          <div class="p-3 bg-light rounded-4 border text-center" style="min-width: 120px;">
            <span class="text-uppercase fw-bold text-muted d-block small" style="font-size: 0.7rem; letter-spacing: 0.05em;">Paid Candidates</span>
            <h3 class="fw-bold text-success mb-0 mt-1">{{ number_format($counts['paid_candidates']) }}</h3>
          </div>
          <div class="p-3 bg-light rounded-4 border text-center" style="min-width: 130px;">
            <span class="text-uppercase fw-bold text-muted d-block small" style="font-size: 0.7rem; letter-spacing: 0.05em;">Total Recharges</span>
            <h3 class="fw-bold text-primary mb-0 mt-1">₹{{ number_format($counts['total_revenue']) }}</h3>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Navigation Tabs -->
  <ul class="nav nav-pills mb-4 gap-2 border-bottom pb-3" id="epTabs" role="tablist">
    <li class="nav-item" role="presentation">
      <button class="nav-link rounded-pill px-4 fw-bold {{ ($activeTab ?? 'gps') === 'gps' ? 'active bg-primary' : 'text-dark bg-white border shadow-2xs' }}" 
              id="gps-tab" 
              data-bs-toggle="tab" 
              data-bs-target="#gps-tab-pane" 
              type="button" 
              role="tab" 
              aria-selected="{{ ($activeTab ?? 'gps') === 'gps' ? 'true' : 'false' }}">
        <i class="bi bi-geo-alt-fill me-1.5"></i>
        Assigned Ground Partners ({{ count($partner->groundPartners) }})
      </button>
    </li>
    <li class="nav-item" role="presentation">
      <button class="nav-link rounded-pill px-4 fw-bold {{ ($activeTab ?? 'gps') === 'candidates' ? 'active bg-primary' : 'text-dark bg-white border shadow-2xs' }}" 
              id="candidates-tab" 
              data-bs-toggle="tab" 
              data-bs-target="#candidates-tab-pane" 
              type="button" 
              role="tab" 
              aria-selected="{{ ($activeTab ?? 'gps') === 'candidates' ? 'true' : 'false' }}">
        <i class="bi bi-people-fill me-1.5"></i>
        Referred Candidates Network ({{ $counts['total_candidates'] }})
      </button>
    </li>
  </ul>

  <!-- Tab Content -->
  <div class="tab-content" id="epTabContent">

    <!-- TAB 1: Ground Partners List -->
    <div class="tab-pane fade {{ ($activeTab ?? 'gps') === 'gps' ? 'show active' : '' }}" id="gps-tab-pane" role="tabpanel">
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
                <th>Referred Candidates</th>
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
                      <a href="{{ route('admin.ground-partners.show', $gp->id) }}" class="fw-bold text-dark text-decoration-none hover-primary">
                        {{ $gp->name }}
                      </a>
                    </div>
                  </td>
                  <td>
                    <a href="tel:{{ $gp->mobile }}" class="text-decoration-none text-dark fw-semibold">
                      <i class="bi bi-telephone text-muted me-1 small"></i>{{ $gp->mobile }}
                    </a>
                  </td>
                  <td>
                    <a href="{{ route('admin.ground-partners.show', $gp->id) }}" class="text-decoration-none">
                      <span class="badge bg-success bg-opacity-10 text-success border border-success border-opacity-25 px-2.5 py-1 fw-bold">
                        <i class="bi bi-patch-check-fill me-1"></i> {{ $gp->paid_referrals_count ?? 0 }} Paid
                      </span>
                      @if(($gp->referrals_count ?? 0) > ($gp->paid_referrals_count ?? 0))
                        <span class="badge bg-light text-muted border px-2 py-1 small ms-1">
                          {{ $gp->referrals_count }} Total
                        </span>
                      @endif
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
                      <a href="{{ route('admin.ground-partners.show', $gp->id) }}" class="btn-custom btn-custom-light btn-custom-sm py-1 px-2" title="View GP Details & Candidates">
                        <i class="bi bi-eye text-info"></i>
                      </a>
                    </div>
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="7" class="text-center py-5 text-muted">
                    <div class="w-16 h-16 rounded-circle bg-light text-muted d-inline-flex align-items-center justify-content-center fs-2 mb-2">
                      <i class="bi bi-geo-alt"></i>
                    </div>
                    <div class="fw-semibold fs-6">No Ground Partners Assigned Yet</div>
                    <p class="small text-muted mb-3">Add and assign Ground Partners to {{ $partner->name }} to build your referral network.</p>
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

    <!-- TAB 2: Referred Candidates Network -->
    <div class="tab-pane fade {{ ($activeTab ?? 'gps') === 'candidates' ? 'show active' : '' }}" id="candidates-tab-pane" role="tabpanel">
      <div class="table-card-custom mb-4">
        
        <!-- Filter Controls -->
        <div class="table-header-control">
          <!-- Status Tabs -->
          <div class="d-flex flex-wrap align-items-center gap-2 flex-grow-1">
            <a href="{{ route('admin.executive-partners.show', ['id' => $partner->id, 'tab' => 'candidates', 'month' => $month, 'payment_status' => 'all', 'gp_id' => $gpFilter, 'search' => $search]) }}" 
               class="btn-custom btn-custom-sm {{ ($payStatus ?? 'all') === 'all' ? 'btn-custom-primary' : 'btn-custom-light' }}">
              All Candidates ({{ $counts['total_candidates'] }})
            </a>
            <a href="{{ route('admin.executive-partners.show', ['id' => $partner->id, 'tab' => 'candidates', 'month' => $month, 'payment_status' => 'paid', 'gp_id' => $gpFilter, 'search' => $search]) }}" 
               class="btn-custom btn-custom-sm {{ ($payStatus ?? '') === 'paid' ? 'btn-custom-primary' : 'btn-custom-light' }}">
              <i class="bi bi-patch-check-fill text-success"></i> 1st Payment Done ({{ $counts['paid_candidates'] }})
            </a>
            <a href="{{ route('admin.executive-partners.show', ['id' => $partner->id, 'tab' => 'candidates', 'month' => $month, 'payment_status' => 'pending', 'gp_id' => $gpFilter, 'search' => $search]) }}" 
               class="btn-custom btn-custom-sm {{ ($payStatus ?? '') === 'pending' ? 'btn-custom-primary' : 'btn-custom-light' }}">
              <i class="bi bi-hourglass-split text-warning"></i> Pending ({{ $counts['pending_candidates'] }})
            </a>
          </div>

          <div class="d-flex flex-wrap align-items-center gap-2 ms-auto">
            <!-- Filter by GP -->
            <div class="d-flex align-items-center gap-1.5">
              <label class="small text-muted fw-bold text-nowrap d-none d-sm-inline"><i class="bi bi-geo-alt"></i> GP:</label>
              <select class="form-select form-select-sm rounded-3" style="min-width: 160px;" onchange="filterCandidateGp(this.value)">
                <option value="all" {{ ($gpFilter ?? 'all') === 'all' ? 'selected' : '' }}>All Assigned GPs</option>
                @foreach($partner->groundPartners as $gpItem)
                  <option value="{{ $gpItem->id }}" {{ (string)($gpFilter ?? '') === (string)$gpItem->id ? 'selected' : '' }}>
                    {{ $gpItem->name }} ({{ $gpItem->code }})
                  </option>
                @endforeach
              </select>
            </div>

            <!-- Filter by Month -->
            <div class="d-flex align-items-center gap-1.5">
              <label class="small text-muted fw-bold text-nowrap d-none d-sm-inline"><i class="bi bi-calendar-month"></i> Month:</label>
              <select class="form-select form-select-sm rounded-3" style="min-width: 160px;" onchange="filterCandidateMonth(this.value)">
                <option value="all" {{ ($month ?? 'all') === 'all' ? 'selected' : '' }}>All Months Record</option>
                @foreach($months as $mKey => $mLabel)
                  <option value="{{ $mKey }}" {{ ($month ?? '') === $mKey ? 'selected' : '' }}>{{ $mLabel }}</option>
                @endforeach
              </select>
            </div>

            <!-- Search Box Form -->
            <form method="GET" action="{{ route('admin.executive-partners.show', $partner->id) }}" class="table-search-box m-0" style="min-width: 200px;">
              <input type="hidden" name="tab" value="candidates">
              @if(($payStatus ?? 'all') !== 'all')
                <input type="hidden" name="payment_status" value="{{ $payStatus }}">
              @endif
              @if(!empty($month) && $month !== 'all')
                <input type="hidden" name="month" value="{{ $month }}">
              @endif
              @if(!empty($gpFilter) && $gpFilter !== 'all')
                <input type="hidden" name="gp_id" value="{{ $gpFilter }}">
              @endif
              <i class="bi bi-search table-search-icon"></i>
              <input type="text" 
                     name="search" 
                     class="table-search-input" 
                     placeholder="Search candidate, mobile..." 
                     value="{{ $search }}">
            </form>

            @if(!empty($search) || (!empty($month) && $month !== 'all') || (!empty($gpFilter) && $gpFilter !== 'all') || (($payStatus ?? 'all') !== 'all'))
              <a href="{{ route('admin.executive-partners.show', ['id' => $partner->id, 'tab' => 'candidates']) }}" class="btn-custom btn-custom-light btn-custom-sm" title="Clear filters">
                <i class="bi bi-x-lg"></i>
              </a>
            @endif

            <!-- Export to Excel Button -->
            <a href="{{ route('admin.executive-partners.export', array_merge(['id' => $partner->id], request()->all())) }}" 
               class="btn-custom btn-custom-light btn-custom-sm text-success border border-success border-opacity-25" 
               title="Export candidate network to Excel">
              <i class="bi bi-file-earmark-excel-fill text-success"></i>
              <span>Excel</span>
            </a>
          </div>
        </div>

        <!-- Table Responsive View -->
        <div class="table-responsive">
          <table class="table-custom mb-0">
            <thead>
              <tr>
                <th class="ps-4" style="width: 140px;">Candidate Code</th>
                <th>Candidate Name</th>
                <th>Mobile Number</th>
                <th>Ground Partner (GP)</th>
                <th>Registration Date</th>
                <th>1st Payment Date</th>
                <th>Recharge Amount</th>
                <th>Payment ID</th>
                <th class="pe-4">Payment Status</th>
              </tr>
            </thead>
            <tbody>
              @forelse($referrals as $ref)
                @php 
                  $candidate = $ref->candidate; 
                  $gp = $ref->groundPartner;
                @endphp
                <tr>
                  <td class="ps-4">
                    <span class="badge bg-dark text-warning border border-warning border-opacity-25 font-monospace px-2.5 py-1">
                      {{ $candidate->candidate_code ?? $candidate->profile_id ?? ('RM' . ($candidate->id ?? '')) }}
                    </span>
                  </td>
                  <td>
                    <div class="d-flex align-items-center gap-2.5">
                      <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-2xs" 
                           style="width: 32px; height: 32px; background: linear-gradient(135deg, #4a0404, #750000); font-size: 0.8rem;">
                        {{ strtoupper(substr($candidate->first_name ?? 'C', 0, 1)) }}
                      </div>
                      <div>
                        @if($candidate)
                          <a href="{{ route('admin.candidates.show', $candidate->id) }}" class="fw-bold text-decoration-none text-dark hover-primary">
                            {{ $candidate->first_name }} {{ $candidate->last_name }}
                          </a>
                        @else
                          <span class="text-muted italic">Unknown Candidate</span>
                        @endif
                      </div>
                    </div>
                  </td>
                  <td>
                    @if($candidate && $candidate->phone)
                      <a href="tel:{{ $candidate->phone }}" class="text-decoration-none text-dark fw-semibold">
                        <i class="bi bi-telephone text-muted me-1 small"></i>{{ $candidate->phone }}
                      </a>
                    @else
                      <span class="text-muted small">N/A</span>
                    @endif
                  </td>
                  <td>
                    @if($gp)
                      <a href="{{ route('admin.ground-partners.show', $gp->id) }}" class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 text-decoration-none px-2 py-1 font-monospace">
                        {{ $gp->code }} - {{ $gp->name }}
                      </a>
                    @else
                      <span class="text-muted small">N/A</span>
                    @endif
                  </td>
                  <td>
                    <div class="table-user-sub">{{ $ref->register_date ? $ref->register_date->format('M d, Y') : 'N/A' }}</div>
                  </td>
                  <td>
                    @if($ref->payment_date)
                      <div class="text-dark fw-semibold small">
                        <i class="bi bi-calendar-check text-success me-1"></i>{{ $ref->payment_date->format('M d, Y') }}
                      </div>
                    @else
                      <span class="badge bg-light text-muted border small">Pending</span>
                    @endif
                  </td>
                  <td>
                    @if($ref->isPaid())
                      <span class="fw-bold text-success font-monospace">₹ {{ number_format($ref->amount, 2) }}</span>
                    @else
                      <span class="text-muted small">₹ 0.00</span>
                    @endif
                  </td>
                  <td>
                    @if($ref->payment_id)
                      <span class="badge bg-light text-dark font-monospace border small px-2 py-1">
                        {{ Str::limit($ref->payment_id, 16) }}
                      </span>
                    @else
                      <span class="text-muted small">N/A</span>
                    @endif
                  </td>
                  <td class="pe-4">
                    @if($ref->isPaid())
                      <span class="badge-table success">
                        <i class="bi bi-check2-circle me-1"></i> Paid
                      </span>
                    @else
                      <span class="badge-table failed">
                        <i class="bi bi-clock me-1"></i> Pending
                      </span>
                    @endif
                  </td>
                </tr>
              @empty
                <tr>
                  <td colspan="9" class="text-center py-5 text-muted">
                    <div class="w-16 h-16 rounded-circle bg-light text-muted d-inline-flex align-items-center justify-content-center fs-2 mb-2">
                      <i class="bi bi-people"></i>
                    </div>
                    <div class="fw-semibold fs-6">No Candidates Found in Network</div>
                    <p class="small text-muted mb-0">No referred candidates match the selected GP, month, or filters.</p>
                  </td>
                </tr>
              @endforelse
            </tbody>
          </table>
        </div>

        <!-- Pagination -->
        @if($referrals->hasPages())
          <div class="p-3 border-top d-flex justify-content-between align-items-center flex-wrap gap-2">
            <div class="small text-muted">
              Showing <strong>{{ $referrals->firstItem() }}</strong> to <strong>{{ $referrals->lastItem() }}</strong> of <strong>{{ $referrals->total() }}</strong> candidates
            </div>
            <div>
              {{ $referrals->links() }}
            </div>
          </div>
        @endif

      </div>
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
function filterCandidateGp(gpVal) {
    var url = new URL(window.location.href);
    url.searchParams.set('tab', 'candidates');
    if (gpVal && gpVal !== 'all') {
        url.searchParams.set('gp_id', gpVal);
    } else {
        url.searchParams.delete('gp_id');
    }
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

function filterCandidateMonth(monthVal) {
    var url = new URL(window.location.href);
    url.searchParams.set('tab', 'candidates');
    if (monthVal && monthVal !== 'all') {
        url.searchParams.set('month', monthVal);
    } else {
        url.searchParams.delete('month');
    }
    url.searchParams.delete('page');
    window.location.href = url.toString();
}

$(document).ready(function() {
    // Preserve active tab state in URL when clicking tabs
    $('#epTabs button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
        var targetId = $(e.target).attr('id');
        var tabParam = targetId === 'candidates-tab' ? 'candidates' : 'gps';
        var url = new URL(window.location.href);
        url.searchParams.set('tab', tabParam);
        window.history.replaceState(null, null, url.toString());
    });

    // Handle AJAX Form Submit for Create GP
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
});
</script>
@endpush
