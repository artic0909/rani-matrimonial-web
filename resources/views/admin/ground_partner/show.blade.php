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
      <p class="page-subtitle mb-0">Ground Partner profile, associated Executive Partner (EP), and operational status.</p>
    </div>

    <div class="d-flex align-items-center gap-2">
      <a href="{{ route('admin.ground-partners.index') }}" class="btn-custom btn-custom-light btn-custom-sm">
        <i class="bi bi-list-ul"></i>
        <span>All GPs</span>
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

  <!-- Main Info Card -->
  <div class="row g-4 mb-4">
    <div class="col-12 col-lg-7">
      <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
        <div class="d-flex align-items-center gap-3 mb-3">
          <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-sm" 
               style="width: 64px; height: 64px; background: linear-gradient(135deg, #0dcaf0, #0aa2c0); font-size: 1.5rem;">
            {{ strtoupper(substr($partner->name, 0, 1)) }}
          </div>
          <div>
            <h4 class="fw-bold text-dark mb-0">{{ $partner->name }}</h4>
            <span class="badge bg-info bg-opacity-10 text-info border border-info border-opacity-25 mt-1">Ground Partner (GP)</span>
          </div>
        </div>

        <div class="list-group list-group-flush border-top pt-3">
          <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2.5 border-0">
            <span class="text-muted"><i class="bi bi-qr-code text-warning me-2"></i> Partner Code</span>
            <span class="font-monospace fw-bold text-dark">{{ $partner->code }}</span>
          </div>
          <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2.5 border-0 border-top">
            <span class="text-muted"><i class="bi bi-telephone text-success me-2"></i> Mobile Number</span>
            <a href="tel:{{ $partner->mobile }}" class="fw-bold text-decoration-none text-dark">{{ $partner->mobile }}</a>
          </div>
          <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2.5 border-0 border-top">
            <span class="text-muted"><i class="bi bi-activity text-primary me-2"></i> Operational Status</span>
            <span class="badge-table {{ $partner->isActive() ? 'success' : 'failed' }}">{{ ucfirst($partner->status) }}</span>
          </div>
          <div class="list-group-item d-flex justify-content-between align-items-center px-0 py-2.5 border-0 border-top">
            <span class="text-muted"><i class="bi bi-calendar3 text-muted me-2"></i> Registered Date</span>
            <span class="fw-semibold text-dark">{{ $partner->created_at->format('M d, Y h:i A') }}</span>
          </div>
        </div>
      </div>
    </div>

    <!-- Assigned EP Card -->
    <div class="col-12 col-lg-5">
      <div class="card border-0 shadow-sm rounded-4 p-4 h-100 bg-white">
        <h5 class="fw-bold text-dark mb-3"><i class="bi bi-person-badge-fill text-primary me-2"></i> Assigned Executive Partner (EP)</h5>
        
        @if($partner->executivePartner)
          <div class="p-3 bg-light rounded-4 border mb-3">
            <div class="d-flex align-items-center gap-3">
              <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold shadow-2xs" 
                   style="width: 44px; height: 44px; background: linear-gradient(135deg, #0d6efd, #0b5ed7); font-size: 1rem;">
                {{ strtoupper(substr($partner->executivePartner->name, 0, 1)) }}
              </div>
              <div>
                <a href="{{ route('admin.executive-partners.show', $partner->executivePartner->id) }}" class="fw-bold text-dark text-decoration-none hover-primary d-block">
                  {{ $partner->executivePartner->name }}
                </a>
                <span class="badge bg-dark text-warning font-monospace px-2 py-0.5 small border border-warning border-opacity-25">
                  {{ $partner->executivePartner->code }}
                </span>
              </div>
            </div>
          </div>

          <div class="small text-muted space-y-2">
            <div><strong>EP Mobile:</strong> <a href="tel:{{ $partner->executivePartner->mobile }}" class="text-dark text-decoration-none fw-semibold">{{ $partner->executivePartner->mobile }}</a></div>
            <div class="mt-1"><strong>EP Status:</strong> <span class="badge-table {{ $partner->executivePartner->isActive() ? 'success' : 'failed' }}">{{ ucfirst($partner->executivePartner->status) }}</span></div>
          </div>

          <div class="mt-4">
            <a href="{{ route('admin.executive-partners.show', $partner->executivePartner->id) }}" class="btn-custom btn-custom-light btn-custom-sm w-100 text-center">
              <i class="bi bi-arrow-up-right-square"></i>
              <span>View Executive Partner Profile</span>
            </a>
          </div>
        @else
          <div class="text-center py-4 text-muted">
            <i class="bi bi-exclamation-circle fs-2 d-block mb-2"></i>
            <p class="mb-0">No Executive Partner currently mapped.</p>
          </div>
        @endif
      </div>
    </div>
  </div>

</div>
@endsection

