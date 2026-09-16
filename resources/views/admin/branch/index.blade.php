@extends('admin.layouts.app')

@section('title', 'Branch Management - Rani Matrimonial')

@section('content')
<div class="container-fluid p-0">

    <!-- START: Page Header -->
    <div class="page-header d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <i class="bi bi-buildings-fill fs-4 text-primary"></i>
                <h1 class="page-title mb-0">Branch Management</h1>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 ms-2">
                    Regional Centers
                </span>
            </div>
            <p class="page-subtitle mb-0">Manage franchise centers, regional helpdesks, and branch representative teams across locations.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-1.5 px-3 py-2 rounded-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#addBranchModal">
                <i class="bi bi-plus-lg"></i>
                <span>Add New Branch</span>
            </button>
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1.5 px-3 py-2 rounded-3">
                <i class="bi bi-arrow-left"></i>
                <span>Dashboard</span>
            </a>
        </div>
    </div>
    <!-- END: Page Header -->

    <!-- START: Navigation Tabs Card -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-header bg-white border-bottom p-0">
            <ul class="nav nav-tabs border-0 px-3 pt-2" id="branchNavTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ ($activeTab ?? 'overview') === 'overview' ? 'active fw-bold text-primary border-bottom border-primary border-2' : 'text-muted' }}" 
                            id="tab-overview" data-bs-toggle="tab" data-bs-target="#pane-overview" type="button" role="tab">
                        <i class="bi bi-grid-1x2 me-1.5"></i> All Branches Overview
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ ($activeTab ?? '') === 'offices' ? 'active fw-bold text-primary border-bottom border-primary border-2' : 'text-muted' }}" 
                            id="tab-offices" data-bs-toggle="tab" data-bs-target="#pane-offices" type="button" role="tab">
                        <i class="bi bi-building me-1.5"></i> Office Directory & Addresses
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ ($activeTab ?? '') === 'staff' ? 'active fw-bold text-primary border-bottom border-primary border-2' : 'text-muted' }}" 
                            id="tab-staff" data-bs-toggle="tab" data-bs-target="#pane-staff" type="button" role="tab">
                        <i class="bi bi-people me-1.5"></i> Branch Managers & Staff
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ ($activeTab ?? '') === 'coverage' ? 'active fw-bold text-primary border-bottom border-primary border-2' : 'text-muted' }}" 
                            id="tab-coverage" data-bs-toggle="tab" data-bs-target="#pane-coverage" type="button" role="tab">
                        <i class="bi bi-geo-alt me-1.5"></i> Service Coverage Areas
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ ($activeTab ?? '') === 'settings' ? 'active fw-bold text-primary border-bottom border-primary border-2' : 'text-muted' }}" 
                            id="tab-settings" data-bs-toggle="tab" data-bs-target="#pane-settings" type="button" role="tab">
                        <i class="bi bi-gear me-1.5"></i> Branch Settings & Permissions
                    </button>
                </li>
            </ul>
        </div>

        <div class="card-body p-4">
            <div class="tab-content" id="branchNavTabsContent">

                <!-- 1. Overview Tab -->
                <div class="tab-pane fade {{ ($activeTab ?? 'overview') === 'overview' ? 'show active' : '' }}" id="pane-overview" role="tabpanel">
                    <!-- Quick Stats -->
                    <div class="row g-3 mb-4">
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 20px;">
                                    <i class="bi bi-buildings"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Active Branches</div>
                                    <div class="fw-bold fs-5 text-dark">4 Centers</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 20px;">
                                    <i class="bi bi-person-badge"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Branch Coordinators</div>
                                    <div class="fw-bold fs-5 text-dark">12 Staff</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-info-subtle text-info d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 20px;">
                                    <i class="bi bi-pin-map"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Cities Covered</div>
                                    <div class="fw-bold fs-5 text-dark">8 Districts</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                <div class="rounded-circle bg-warning-subtle text-warning-emphasis d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 20px;">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <div>
                                    <div class="text-muted small">Pending Queries</div>
                                    <div class="fw-bold fs-5 text-dark">0 Queries</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Branches Table Placeholder -->
                    <div class="table-responsive border rounded-3">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="small text-muted text-uppercase">
                                    <th class="ps-3" style="width: 60px;">#</th>
                                    <th>Branch Name</th>
                                    <th>City & State</th>
                                    <th>Contact Details</th>
                                    <th>Branch Head</th>
                                    <th>Status</th>
                                    <th class="text-end pe-3" style="width: 120px;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-3 fw-bold text-muted">1</td>
                                    <td>
                                        <div class="fw-bold text-dark">Main Headquarter (Kolkata)</div>
                                        <small class="text-muted">Code: BR-KOL-001</small>
                                    </td>
                                    <td>
                                        <div class="fw-medium text-dark">Kolkata</div>
                                        <small class="text-muted">West Bengal, India</small>
                                    </td>
                                    <td>
                                        <div><i class="bi bi-telephone me-1 text-muted"></i> +91 98765 43210</div>
                                        <small class="text-muted"><i class="bi bi-envelope me-1"></i> kolkata@ranimatrimonial.com</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">Admin Officer</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success px-2.5 py-1">Operational</span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-sm btn-outline-primary rounded-2"><i class="bi bi-pencil"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-3 fw-bold text-muted">2</td>
                                    <td>
                                        <div class="fw-bold text-dark">South Bengal Regional Office</div>
                                        <small class="text-muted">Code: BR-HWH-002</small>
                                    </td>
                                    <td>
                                        <div class="fw-medium text-dark">Howrah</div>
                                        <small class="text-muted">West Bengal, India</small>
                                    </td>
                                    <td>
                                        <div><i class="bi bi-telephone me-1 text-muted"></i> +91 98765 43211</div>
                                        <small class="text-muted"><i class="bi bi-envelope me-1"></i> howrah@ranimatrimonial.com</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">Regional Lead</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success px-2.5 py-1">Operational</span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-sm btn-outline-primary rounded-2"><i class="bi bi-pencil"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-3 fw-bold text-muted">3</td>
                                    <td>
                                        <div class="fw-bold text-dark">North Bengal Center (Siliguri)</div>
                                        <small class="text-muted">Code: BR-SLG-003</small>
                                    </td>
                                    <td>
                                        <div class="fw-medium text-dark">Siliguri</div>
                                        <small class="text-muted">West Bengal, India</small>
                                    </td>
                                    <td>
                                        <div><i class="bi bi-telephone me-1 text-muted"></i> +91 98765 43212</div>
                                        <small class="text-muted"><i class="bi bi-envelope me-1"></i> siliguri@ranimatrimonial.com</small>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">Coordinator</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success-subtle text-success px-2.5 py-1">Operational</span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <button class="btn btn-sm btn-outline-primary rounded-2"><i class="bi bi-pencil"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 2. Office Directory Tab -->
                <div class="tab-pane fade {{ ($activeTab ?? '') === 'offices' ? 'show active' : '' }}" id="pane-offices" role="tabpanel">
                    <div class="alert alert-info border-0 rounded-3 d-flex align-items-center gap-2 mb-4">
                        <i class="bi bi-info-circle-fill fs-5 text-info"></i>
                        <span>Physical addresses and GPS locations for candidates visiting for offline matchmaking consultations.</span>
                    </div>
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="card border rounded-3 p-3 h-100">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold text-dark mb-0">Central Office - Kolkata</h6>
                                    <span class="badge bg-primary-subtle text-primary">HQ</span>
                                </div>
                                <p class="text-muted small mb-2">Park Street Commercial Complex, 4th Floor, Suite 402, Kolkata - 700016</p>
                                <div class="small text-muted mb-1"><i class="bi bi-clock me-1"></i> Mon - Sat: 10:00 AM - 07:00 PM</div>
                                <div class="small text-muted"><i class="bi bi-telephone me-1"></i> +91 33 2234 5678</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card border rounded-3 p-3 h-100">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold text-dark mb-0">Sub Branch - Howrah</h6>
                                    <span class="badge bg-secondary-subtle text-secondary">Branch</span>
                                </div>
                                <p class="text-muted small mb-2">GT Road, Near Howrah AC Market, 2nd Floor, Howrah - 711101</p>
                                <div class="small text-muted mb-1"><i class="bi bi-clock me-1"></i> Mon - Sat: 10:30 AM - 06:30 PM</div>
                                <div class="small text-muted"><i class="bi bi-telephone me-1"></i> +91 33 2654 8901</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Staff Tab -->
                <div class="tab-pane fade {{ ($activeTab ?? '') === 'staff' ? 'show active' : '' }}" id="pane-staff" role="tabpanel">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="fw-bold text-dark mb-0">Branch Staff & Relationship Managers</h6>
                        <button class="btn btn-sm btn-outline-primary rounded-2"><i class="bi bi-person-plus me-1"></i> Assign New Staff</button>
                    </div>
                    <div class="table-responsive border rounded-3">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr class="small text-muted text-uppercase">
                                    <th class="ps-3">Staff Name</th>
                                    <th>Assigned Branch</th>
                                    <th>Role</th>
                                    <th>Contact</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-bold text-dark">Sourav Mukherjee</div>
                                        <small class="text-muted">ID: STF-101</small>
                                    </td>
                                    <td>Kolkata HQ</td>
                                    <td><span class="badge bg-light text-dark border">Relationship Manager</span></td>
                                    <td>sourav@ranimatrimonial.com</td>
                                    <td><span class="badge bg-success-subtle text-success">Active</span></td>
                                </tr>
                                <tr>
                                    <td class="ps-3">
                                        <div class="fw-bold text-dark">Priyanka Sen</div>
                                        <small class="text-muted">ID: STF-102</small>
                                    </td>
                                    <td>Siliguri Branch</td>
                                    <td><span class="badge bg-light text-dark border">Verification Coordinator</span></td>
                                    <td>priyanka@ranimatrimonial.com</td>
                                    <td><span class="badge bg-success-subtle text-success">Active</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 4. Coverage Areas Tab -->
                <div class="tab-pane fade {{ ($activeTab ?? '') === 'coverage' ? 'show active' : '' }}" id="pane-coverage" role="tabpanel">
                    <div class="p-3 bg-light rounded-3 border text-center py-5">
                        <i class="bi bi-geo-alt fs-1 text-primary mb-2 d-block"></i>
                        <h5 class="fw-bold text-dark">Branch Coverage Zone Configurator</h5>
                        <p class="text-muted small mb-3" style="max-width: 500px; margin: 0 auto;">Configure which districts and pin codes are serviced by each physical branch for document collection and family meetings.</p>
                        <span class="badge bg-secondary-subtle text-secondary px-3 py-1.5">Tab Navigation Ready For Backend Functionality</span>
                    </div>
                </div>

                <!-- 5. Branch Settings Tab -->
                <div class="tab-pane fade {{ ($activeTab ?? '') === 'settings' ? 'show active' : '' }}" id="pane-settings" role="tabpanel">
                    <div class="p-3 bg-light rounded-3 border text-center py-5">
                        <i class="bi bi-gear-wide-connected fs-1 text-primary mb-2 d-block"></i>
                        <h5 class="fw-bold text-dark">Regional & Branch Permissions</h5>
                        <p class="text-muted small mb-3" style="max-width: 500px; margin: 0 auto;">Manage access levels, offline registration receipt numbers, and operational working hours per branch.</p>
                        <span class="badge bg-secondary-subtle text-secondary px-3 py-1.5">Tab Navigation Ready For Backend Functionality</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Navigation Tabs Card -->

</div>
@endsection
