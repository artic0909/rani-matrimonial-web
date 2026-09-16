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
                    Regional Centers
                </span>
            </div>
            <p class="page-subtitle mb-0">Manage franchise centers, regional helpdesks, and branch representative teams across locations.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <button type="button" class="btn-custom btn-custom-primary btn-custom-sm" data-bs-toggle="modal" data-bs-target="#addBranchModal">
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

    <!-- START: Navigation Tabs Card -->
    <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="border: 1px solid rgba(11, 19, 15, 0.06) !important;">
        <div class="card-header bg-white border-bottom p-0">
            <ul class="nav nav-tabs border-0 px-3 pt-2" id="branchNavTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ ($activeTab ?? 'overview') === 'overview' ? 'active fw-bold text-dark border-bottom border-3' : 'text-muted' }}" 
                            style="{{ ($activeTab ?? 'overview') === 'overview' ? 'border-color: var(--brand-forest-medium) !important;' : '' }}"
                            id="tab-overview" data-bs-toggle="tab" data-bs-target="#pane-overview" type="button" role="tab">
                        <i class="bi bi-grid-1x2 me-1.5" style="color: var(--brand-forest-medium);"></i> All Branches Overview
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ ($activeTab ?? '') === 'offices' ? 'active fw-bold text-dark border-bottom border-3' : 'text-muted' }}" 
                            style="{{ ($activeTab ?? '') === 'offices' ? 'border-color: var(--brand-forest-medium) !important;' : '' }}"
                            id="tab-offices" data-bs-toggle="tab" data-bs-target="#pane-offices" type="button" role="tab">
                        <i class="bi bi-building me-1.5" style="color: var(--brand-forest-medium);"></i> Office Directory & Addresses
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ ($activeTab ?? '') === 'staff' ? 'active fw-bold text-dark border-bottom border-3' : 'text-muted' }}" 
                            style="{{ ($activeTab ?? '') === 'staff' ? 'border-color: var(--brand-forest-medium) !important;' : '' }}"
                            id="tab-staff" data-bs-toggle="tab" data-bs-target="#pane-staff" type="button" role="tab">
                        <i class="bi bi-people me-1.5" style="color: var(--brand-forest-medium);"></i> Branch Managers & Staff
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ ($activeTab ?? '') === 'coverage' ? 'active fw-bold text-dark border-bottom border-3' : 'text-muted' }}" 
                            style="{{ ($activeTab ?? '') === 'coverage' ? 'border-color: var(--brand-forest-medium) !important;' : '' }}"
                            id="tab-coverage" data-bs-toggle="tab" data-bs-target="#pane-coverage" type="button" role="tab">
                        <i class="bi bi-geo-alt me-1.5" style="color: var(--brand-forest-medium);"></i> Service Coverage Areas
                    </button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link {{ ($activeTab ?? '') === 'settings' ? 'active fw-bold text-dark border-bottom border-3' : 'text-muted' }}" 
                            style="{{ ($activeTab ?? '') === 'settings' ? 'border-color: var(--brand-forest-medium) !important;' : '' }}"
                            id="tab-settings" data-bs-toggle="tab" data-bs-target="#pane-settings" type="button" role="tab">
                        <i class="bi bi-gear me-1.5" style="color: var(--brand-forest-medium);"></i> Branch Settings & Permissions
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
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 20px; background-color: rgba(15, 74, 50, 0.1); color: var(--brand-forest-medium);">
                                    <i class="bi bi-buildings"></i>
                                </div>
                                <div>
                                    <div class="table-user-sub">Active Branches</div>
                                    <div class="fw-bold fs-5 text-main">4 Centers</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 20px; background-color: rgba(34, 197, 94, 0.1); color: var(--sys-green);">
                                    <i class="bi bi-person-badge"></i>
                                </div>
                                <div>
                                    <div class="table-user-sub">Branch Coordinators</div>
                                    <div class="fw-bold fs-5 text-main">12 Staff</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 20px; background-color: rgba(14, 165, 233, 0.1); color: #0284c7;">
                                    <i class="bi bi-pin-map"></i>
                                </div>
                                <div>
                                    <div class="table-user-sub">Cities Covered</div>
                                    <div class="fw-bold fs-5 text-main">8 Districts</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-6 col-xl-3">
                            <div class="p-3 rounded-3 bg-light border d-flex align-items-center gap-3">
                                <div class="rounded-circle d-flex align-items-center justify-content-center" style="width: 44px; height: 44px; font-size: 20px; background-color: rgba(245, 158, 11, 0.1); color: #d97706;">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                                <div>
                                    <div class="table-user-sub">Pending Queries</div>
                                    <div class="fw-bold fs-5 text-main">0 Queries</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Branches Table -->
                    <div class="table-responsive border rounded-3">
                        <table class="table-custom">
                            <thead>
                                <tr>
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
                                    <td class="ps-3 text-muted fw-bold">1</td>
                                    <td>
                                        <div class="table-user-name">Main Headquarter (Kolkata)</div>
                                        <div class="table-user-sub font-monospace">Code: BR-KOL-001</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-main">Kolkata</div>
                                        <div class="table-user-sub">West Bengal, India</div>
                                    </td>
                                    <td>
                                        <div><i class="bi bi-telephone me-1 text-muted"></i> +91 98765 43210</div>
                                        <div class="table-user-sub"><i class="bi bi-envelope me-1"></i> kolkata@ranimatrimonial.com</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">Admin Officer</span>
                                    </td>
                                    <td>
                                        <span class="badge-table success">Operational</span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <button class="table-btn-action" title="Edit branch"><i class="bi bi-pencil"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-3 text-muted fw-bold">2</td>
                                    <td>
                                        <div class="table-user-name">South Bengal Regional Office</div>
                                        <div class="table-user-sub font-monospace">Code: BR-HWH-002</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-main">Howrah</div>
                                        <div class="table-user-sub">West Bengal, India</div>
                                    </td>
                                    <td>
                                        <div><i class="bi bi-telephone me-1 text-muted"></i> +91 98765 43211</div>
                                        <div class="table-user-sub"><i class="bi bi-envelope me-1"></i> howrah@ranimatrimonial.com</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">Regional Lead</span>
                                    </td>
                                    <td>
                                        <span class="badge-table success">Operational</span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <button class="table-btn-action" title="Edit branch"><i class="bi bi-pencil"></i></button>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="ps-3 text-muted fw-bold">3</td>
                                    <td>
                                        <div class="table-user-name">North Bengal Center (Siliguri)</div>
                                        <div class="table-user-sub font-monospace">Code: BR-SLG-003</div>
                                    </td>
                                    <td>
                                        <div class="fw-semibold text-main">Siliguri</div>
                                        <div class="table-user-sub">West Bengal, India</div>
                                    </td>
                                    <td>
                                        <div><i class="bi bi-telephone me-1 text-muted"></i> +91 98765 43212</div>
                                        <div class="table-user-sub"><i class="bi bi-envelope me-1"></i> siliguri@ranimatrimonial.com</div>
                                    </td>
                                    <td>
                                        <span class="badge bg-light text-dark border">Coordinator</span>
                                    </td>
                                    <td>
                                        <span class="badge-table success">Operational</span>
                                    </td>
                                    <td class="text-end pe-3">
                                        <button class="table-btn-action" title="Edit branch"><i class="bi bi-pencil"></i></button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 2. Office Directory Tab -->
                <div class="tab-pane fade {{ ($activeTab ?? '') === 'offices' ? 'show active' : '' }}" id="pane-offices" role="tabpanel">
                    <div class="alert-custom alert-custom-primary mb-4">
                        <i class="bi bi-info-circle-fill alert-custom-icon"></i>
                        <div class="alert-custom-content">
                            Physical branch addresses and GPS locations for candidates visiting for offline matchmaking consultations.
                        </div>
                    </div>
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="card border rounded-3 p-3 h-100">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold text-main mb-0">Central Office - Kolkata</h6>
                                    <span class="badge-table success">HQ</span>
                                </div>
                                <p class="table-user-sub mb-2">Park Street Commercial Complex, 4th Floor, Suite 402, Kolkata - 700016</p>
                                <div class="table-user-sub mb-1"><i class="bi bi-clock me-1"></i> Mon - Sat: 10:00 AM - 07:00 PM</div>
                                <div class="table-user-sub"><i class="bi bi-telephone me-1"></i> +91 33 2234 5678</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="card border rounded-3 p-3 h-100">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h6 class="fw-bold text-main mb-0">Sub Branch - Howrah</h6>
                                    <span class="badge-table pending">Branch</span>
                                </div>
                                <p class="table-user-sub mb-2">GT Road, Near Howrah AC Market, 2nd Floor, Howrah - 711101</p>
                                <div class="table-user-sub mb-1"><i class="bi bi-clock me-1"></i> Mon - Sat: 10:30 AM - 06:30 PM</div>
                                <div class="table-user-sub"><i class="bi bi-telephone me-1"></i> +91 33 2654 8901</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- 3. Staff Tab -->
                <div class="tab-pane fade {{ ($activeTab ?? '') === 'staff' ? 'show active' : '' }}" id="pane-staff" role="tabpanel">
                    <div class="d-flex align-items-center justify-content-between mb-3">
                        <h6 class="fw-bold text-main mb-0">Branch Staff & Relationship Managers</h6>
                        <button class="btn-custom btn-custom-outline-primary btn-custom-sm"><i class="bi bi-person-plus"></i> Assign New Staff</button>
                    </div>
                    <div class="table-responsive border rounded-3">
                        <table class="table-custom">
                            <thead>
                                <tr>
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
                                        <div class="table-user-name">Sourav Mukherjee</div>
                                        <div class="table-user-sub font-monospace">ID: STF-101</div>
                                    </td>
                                    <td>Kolkata HQ</td>
                                    <td><span class="badge bg-light text-dark border">Relationship Manager</span></td>
                                    <td>sourav@ranimatrimonial.com</td>
                                    <td><span class="badge-table success">Active</span></td>
                                </tr>
                                <tr>
                                    <td class="ps-3">
                                        <div class="table-user-name">Priyanka Sen</div>
                                        <div class="table-user-sub font-monospace">ID: STF-102</div>
                                    </td>
                                    <td>Siliguri Branch</td>
                                    <td><span class="badge bg-light text-dark border">Verification Coordinator</span></td>
                                    <td>priyanka@ranimatrimonial.com</td>
                                    <td><span class="badge-table success">Active</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- 4. Coverage Areas Tab -->
                <div class="tab-pane fade {{ ($activeTab ?? '') === 'coverage' ? 'show active' : '' }}" id="pane-coverage" role="tabpanel">
                    <div class="p-3 bg-light rounded-3 border text-center py-5">
                        <i class="bi bi-geo-alt fs-1 d-block mb-2" style="color: var(--brand-forest-medium);"></i>
                        <h5 class="fw-bold text-main">Branch Coverage Zone Configurator</h5>
                        <p class="table-user-sub mb-3" style="max-width: 500px; margin: 0 auto;">Configure which districts and pin codes are serviced by each physical branch for document collection and family meetings.</p>
                        <span class="badge-table pending">Tab Navigation Ready For Backend Functionality</span>
                    </div>
                </div>

                <!-- 5. Branch Settings Tab -->
                <div class="tab-pane fade {{ ($activeTab ?? '') === 'settings' ? 'show active' : '' }}" id="pane-settings" role="tabpanel">
                    <div class="p-3 bg-light rounded-3 border text-center py-5">
                        <i class="bi bi-gear-wide-connected fs-1 d-block mb-2" style="color: var(--brand-forest-medium);"></i>
                        <h5 class="fw-bold text-main">Regional & Branch Permissions</h5>
                        <p class="table-user-sub mb-3" style="max-width: 500px; margin: 0 auto;">Manage access levels, offline registration receipt numbers, and operational working hours per branch.</p>
                        <span class="badge-table pending">Tab Navigation Ready For Backend Functionality</span>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Navigation Tabs Card -->

</div>
@endsection
