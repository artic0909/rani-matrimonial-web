@extends('admin.layouts.app')

@section('title', $partner->name . ' (' . $partner->code . ') - Ground Partner Details')

@section('content')
<div class="container-fluid p-0">

  <!-- START: Page Header -->
  <div class="page-header d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
    <div>
      <div class="d-flex align-items-center gap-2 mb-1">
        <a href="{{ route('admin.ground-partners.index') }}" class="btn btn-light btn-sm rounded-circle p-1" style="width: 32px; height: 32px;" title="Back to GPs List">
          <i class="bi bi-arrow-left"></i>
        </a>
        <h1 class="page-title mb-0">{{ $partner->name }}</h1>
        <span class="badge bg-dark text-info font-monospace px-2.5 py-1 border border-info border-opacity-25 ms-1">
          {{ $partner->code }}
        </span>
        <span class="badge-table {{ $partner->isActive() ? 'success' : 'failed' }} ms-1">
          {{ ucfirst($partner->status) }}
        </span>
      </div>
      <p class="page-subtitle mb-0">Ground Partner profile, onboarded candidates, first recharge payments, and monthly records.</p>
    </div>

    <div class="d-flex align-items-center gap-2">
      <a href="{{ route('admin.ground-partners.index') }}" class="btn-custom btn-custom-light btn-custom-sm">
        <i class="bi bi-list-ul"></i>
        <span>All GPs</span>
      </a>
      <a href="{{ route('admin.ground-partners.export', array_merge(['id' => $partner->id], request()->all())) }}" 
         class="btn-custom btn-custom-light btn-custom-sm text-success border-success border-opacity-25 shadow-2xs" 
         title="Export Candidate Records to Excel">
        <i class="bi bi-file-earmark-excel-fill text-success"></i>
        <span>Export to Excel</span>
      </a>
      @if($partner->executivePartner)
        <a href="{{ route('admin.executive-partners.show', $partner->executivePartner->id) }}" class="btn-custom btn-custom-primary btn-custom-sm">
          <i class="bi bi-person-badge-fill"></i>
          <span>View EP ({{ $partner->executivePartner->code }})</span>
        </a>
      @endif
    </div>
  </div>
  <!-- END: Page Header -->

  <!-- Top Info Overview Card -->
  <div class="card border-0 shadow-sm rounded-4 p-4 mb-4 bg-white">
    <div class="row g-4 align-items-center">
      <div class="col-12 col-md-auto text-center text-md-start">
        <div class="rounded-circle d-inline-flex align-items-center justify-content-center text-white fw-bold shadow-sm" 
             style="width: 72px; height: 72px; background: linear-gradient(135deg, #0dcaf0, #0aa2c0); font-size: 1.75rem;">
          {{ strtoupper(substr($partner->name, 0, 1)) }}
        </div>
      </div>
      <div class="col-12 col-md">
        <div class="d-flex flex-wrap align-items-center gap-2 mb-1">
          <h3 class="fw-bold mb-0 text-dark">{{ $partner->name }}</h3>
          <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 px-2.5 py-1">
            Ground Partner (GP)
          </span>
          @if($partner->executivePartner)
            <a href="{{ route('admin.executive-partners.show', $partner->executivePartner->id) }}" class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-25 px-2.5 py-1 text-decoration-none">
              <i class="bi bi-person-badge me-1"></i> EP: {{ $partner->executivePartner->name }} ({{ $partner->executivePartner->code }})
            </a>
          @endif
        </div>
        <div class="d-flex flex-wrap align-items-center gap-3 text-muted small mt-2">
          <div><i class="bi bi-qr-code text-warning me-1"></i> GP Code: <strong class="text-dark font-monospace">{{ $partner->code }}</strong></div>
          <div><i class="bi bi-telephone text-success me-1"></i> Mobile: <a href="tel:{{ $partner->mobile }}" class="text-dark text-decoration-none fw-semibold">{{ $partner->mobile }}</a></div>
          <div><i class="bi bi-calendar3 text-muted me-1"></i> Joined: <strong class="text-dark">{{ $partner->created_at->format('M d, Y') }}</strong></div>
        </div>
      </div>
      <div class="col-12 col-md-auto text-md-end">
        <div class="d-flex gap-2">
          <div class="p-3 bg-light rounded-4 border text-center" style="min-width: 120px;">
            <span class="text-uppercase fw-bold text-muted d-block small" style="font-size: 0.7rem; letter-spacing: 0.05em;">Paid Candidates</span>
            <h3 class="fw-bold text-success mb-0 mt-1">{{ number_format($counts['paid_candidates']) }}</h3>
          </div>
          <div class="p-3 bg-light rounded-4 border text-center" style="min-width: 120px;">
            <span class="text-uppercase fw-bold text-muted d-block small" style="font-size: 0.7rem; letter-spacing: 0.05em;">Total 1st Recharge</span>
            <h3 class="fw-bold text-primary mb-0 mt-1">₹{{ number_format($counts['total_earnings']) }}</h3>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Metric Statistics Cards -->
  <div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
      <div class="card p-3 rounded-4 shadow-sm border-0 h-100 bg-white">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <span class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.7rem; letter-spacing: 0.05em;">Total Onboarded</span>
            <h3 class="fw-bold mb-0 text-dark">{{ number_format($counts['total_candidates']) }}</h3>
          </div>
          <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background: rgba(13, 202, 240, 0.12); color: #0dcaf0; font-size: 1.25rem;">
            <i class="bi bi-people-fill"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-3">
      <div class="card p-3 rounded-4 shadow-sm border-0 h-100 bg-white">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <span class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.7rem; letter-spacing: 0.05em;">1st Payment Done</span>
            <h3 class="fw-bold mb-0 text-success">{{ number_format($counts['paid_candidates']) }}</h3>
          </div>
          <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background: rgba(34, 197, 94, 0.12); color: var(--sys-green); font-size: 1.25rem;">
            <i class="bi bi-patch-check-fill"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-3">
      <div class="card p-3 rounded-4 shadow-sm border-0 h-100 bg-white">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <span class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.7rem; letter-spacing: 0.05em;">Pending Payment</span>
            <h3 class="fw-bold mb-0 text-warning">{{ number_format($counts['pending_candidates']) }}</h3>
          </div>
          <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background: rgba(255, 193, 7, 0.12); color: #d39e00; font-size: 1.25rem;">
            <i class="bi bi-clock-history"></i>
          </div>
        </div>
      </div>
    </div>

    <div class="col-6 col-lg-3">
      <div class="card p-3 rounded-4 shadow-sm border-0 h-100 bg-white">
        <div class="d-flex align-items-center justify-content-between">
          <div>
            <span class="text-uppercase fw-bold text-muted d-block" style="font-size: 0.7rem; letter-spacing: 0.05em;">Revenue Generated</span>
            <h3 class="fw-bold mb-0 text-primary">₹ {{ number_format($counts['total_earnings'], 2) }}</h3>
          </div>
          <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 42px; height: 42px; background: rgba(13, 110, 253, 0.1); color: #0d6efd; font-size: 1.25rem;">
            <i class="bi bi-wallet-fill"></i>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Candidates List Table Container -->
  <div class="table-card-custom mb-4">
    
    <!-- Filter Controls -->
    <div class="table-header-control">
      <!-- Status Tabs -->
      <div class="d-flex flex-wrap align-items-center gap-2 flex-grow-1">
        <a href="{{ route('admin.ground-partners.show', ['id' => $partner->id, 'month' => $month, 'payment_status' => 'all', 'search' => $search]) }}" 
           class="btn-custom btn-custom-sm {{ ($payStatus ?? 'all') === 'all' ? 'btn-custom-primary' : 'btn-custom-light' }}">
          All Candidates ({{ $counts['total_candidates'] }})
        </a>
        <a href="{{ route('admin.ground-partners.show', ['id' => $partner->id, 'month' => $month, 'payment_status' => 'paid', 'search' => $search]) }}" 
           class="btn-custom btn-custom-sm {{ ($payStatus ?? '') === 'paid' ? 'btn-custom-primary' : 'btn-custom-light' }}">
          <i class="bi bi-patch-check-fill text-success"></i> 1st Payment Completed ({{ $counts['paid_candidates'] }})
        </a>
        <a href="{{ route('admin.ground-partners.show', ['id' => $partner->id, 'month' => $month, 'payment_status' => 'pending', 'search' => $search]) }}" 
           class="btn-custom btn-custom-sm {{ ($payStatus ?? '') === 'pending' ? 'btn-custom-primary' : 'btn-custom-light' }}">
          <i class="bi bi-hourglass-split text-warning"></i> Pending Payment ({{ $counts['pending_candidates'] }})
        </a>
      </div>

      <div class="d-flex flex-wrap align-items-center gap-2 ms-auto">
        <!-- Monthly Filter -->
        <div class="d-flex align-items-center gap-1.5">
          <label class="small text-muted fw-bold text-nowrap d-none d-sm-inline"><i class="bi bi-calendar-month"></i> Month:</label>
          <select class="form-select form-select-sm rounded-3" style="min-width: 170px;" onchange="filterMonthly(this.value)">
            <option value="all" {{ ($month ?? 'all') === 'all' ? 'selected' : '' }}>All Months Record</option>
            @foreach($months as $mKey => $mLabel)
              <option value="{{ $mKey }}" {{ ($month ?? '') === $mKey ? 'selected' : '' }}>{{ $mLabel }}</option>
            @endforeach
          </select>
        </div>

        <!-- Search Box Form -->
        <form method="GET" action="{{ route('admin.ground-partners.show', $partner->id) }}" class="table-search-box m-0" style="min-width: 220px;">
          @if(($payStatus ?? 'all') !== 'all')
            <input type="hidden" name="payment_status" value="{{ $payStatus }}">
          @endif
          @if(!empty($month) && $month !== 'all')
            <input type="hidden" name="month" value="{{ $month }}">
          @endif
          <i class="bi bi-search table-search-icon"></i>
          <input type="text" 
                 name="search" 
                 class="table-search-input" 
                 placeholder="Search candidate, mobile..." 
                 value="{{ $search }}">
        </form>

        @if(!empty($search) || (!empty($month) && $month !== 'all') || (($payStatus ?? 'all') !== 'all'))
          <a href="{{ route('admin.ground-partners.show', $partner->id) }}" class="btn-custom btn-custom-light btn-custom-sm" title="Clear filters">
            <i class="bi bi-x-lg"></i>
          </a>
        @endif

        <!-- Export to Excel Button -->
        <a href="{{ route('admin.ground-partners.export', array_merge(['id' => $partner->id], request()->all())) }}" 
           class="btn-custom btn-custom-light btn-custom-sm text-success border border-success border-opacity-25" 
           title="Export filtered records to Excel">
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
            <th>Registration Date</th>
            <th>1st Payment Date</th>
            <th>Recharge Amount</th>
            <th>Payment ID</th>
            <th class="pe-4">Payment Status</th>
          </tr>
        </thead>
        <tbody>
          @forelse($referrals as $ref)
            @php $candidate = $ref->candidate; @endphp
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
              <td colspan="8" class="text-center py-5 text-muted">
                <div class="w-16 h-16 rounded-circle bg-light text-muted d-inline-flex align-items-center justify-content-center fs-2 mb-2">
                  <i class="bi bi-people"></i>
                </div>
                <div class="fw-semibold fs-6">No Candidates Found</div>
                <p class="small text-muted mb-0">No referred candidates match the selected filters or month.</p>
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
@endsection

@push('scripts')
<script>
function filterMonthly(monthVal) {
    var url = new URL(window.location.href);
    if (monthVal && monthVal !== 'all') {
        url.searchParams.set('month', monthVal);
    } else {
        url.searchParams.delete('month');
    }
    url.searchParams.delete('page');
    window.location.href = url.toString();
}
</script>
@endpush
