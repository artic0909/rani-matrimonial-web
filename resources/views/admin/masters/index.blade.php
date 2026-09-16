@extends('admin.layouts.app')

@section('title', 'Manage ' . $config['plural'] . ' - Rani Matrimonial Admin')

@section('content')
<div class="container-fluid p-0" id="master-crud-app">
    
    <!-- START: Page Header Banner -->
    <div class="page-header d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <i class="bi {{ $config['icon'] }} fs-4 text-primary"></i>
                <h1 class="page-title mb-0">{{ $config['plural'] }}</h1>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 ms-2" id="header-total-badge">
                    {{ number_format($totalRecords) }} Total
                </span>
            </div>
            <p class="page-subtitle mb-0">Manage and customize lookup options for {{ strtolower($config['plural']) }}.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1.5 px-3 py-2 rounded-3">
                <i class="bi bi-arrow-left"></i>
                <span>Dashboard</span>
            </a>
            <button type="button" class="btn btn-primary btn-sm d-flex align-items-center gap-1.5 px-3 py-2 rounded-3 shadow-sm" onclick="openCreateModal()">
                <i class="bi bi-plus-lg"></i>
                <span>Add {{ $config['singular'] }}</span>
            </button>
        </div>
    </div>
    <!-- END: Page Header Banner -->

    <!-- START: Filter and Search Toolbar -->
    <div class="card mb-4 border-0 shadow-sm rounded-3">
        <div class="card-body p-3">
            <div class="row g-3 align-items-center">
                <!-- Search Box -->
                <div class="col-12 col-md-4 col-lg-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" 
                               id="filter-search" 
                               class="form-control bg-light border-start-0 ps-0" 
                               placeholder="Search {{ strtolower($config['plural']) }}..." 
                               oninput="handleSearchInput(event)">
                        <button class="btn btn-light border border-start-0 text-muted d-none" type="button" id="btn-clear-search" onclick="clearSearch()">
                            <i class="bi bi-x-lg"></i>
                        </button>
                    </div>
                </div>

                <!-- Parent Filter Dropdown (If Applicable) -->
                @if(!empty($config['has_parent']))
                <div class="col-12 col-md-4 col-lg-3">
                    <select id="filter-parent" class="form-select bg-light select2" data-placeholder="All {{ $config['parent_label'] ?? 'Parents' }} (All)">
                        <option value="">All {{ $config['parent_label'] ?? 'Parents' }} (All)</option>
                        @foreach($parents as $parent)
                            <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif

                <!-- Per Page Selector -->
                <div class="col-6 col-md-2 col-lg-2 ms-auto">
                    <div class="d-flex align-items-center justify-content-end gap-2">
                        <label for="per-page-select" class="form-label mb-0 small text-muted text-nowrap">Show:</label>
                        <select id="per-page-select" class="form-select form-select-sm bg-light w-auto" onchange="handlePerPageChange()">
                            <option value="10" selected>10</option>
                            <option value="25">25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Filter and Search Toolbar -->

    <!-- START: Main Data Table Card -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="small text-muted text-uppercase">
                            <th class="ps-4" style="width: 80px;">#</th>
                            <th>{{ $config['singular'] }} Name</th>
                            @if(!empty($config['has_parent']))
                                <th>{{ $config['parent_label'] ?? 'Parent' }}</th>
                            @endif
                            <th style="width: 180px;">Created Date</th>
                            <th class="text-end pe-4" style="width: 140px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="master-table-body">
                        <!-- Dynamic Records Rendered via JS -->
                        <tr>
                            <td colspan="{{ !empty($config['has_parent']) ? '5' : '4' }}" class="text-center py-5 text-muted">
                                <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                                <span>Loading records...</span>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card Footer: Pagination Controls -->
        <div class="card-footer bg-white border-top p-3 d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            <div class="small text-muted" id="pagination-summary">
                Showing 0 to 0 of 0 records
            </div>
            <nav aria-label="Master records pagination">
                <ul class="pagination pagination-sm mb-0 gap-1" id="pagination-controls">
                    <!-- Dynamic Page Buttons -->
                </ul>
            </nav>
        </div>
    </div>
    <!-- END: Main Data Table Card -->

</div>

<!-- ==========================================
     START: CREATE MODAL
     ========================================== -->
<div class="modal fade" id="createMasterModal" tabindex="-1" aria-labelledby="createMasterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom px-4 py-3 bg-light">
                <h5 class="modal-title fw-bold" id="createMasterModalLabel">
                    <i class="bi bi-plus-circle text-primary me-1.5"></i> Add New {{ $config['singular'] }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createMasterForm" onsubmit="handleCreateSubmit(event)">
                @csrf
                <div class="modal-body p-4">
                    <!-- Form Error Alert -->
                    <div class="alert alert-danger py-2 px-3 mb-3 small d-none" id="create-modal-error">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                        <span id="create-modal-error-text"></span>
                    </div>

                    @if(!empty($config['has_parent']))
                    <div class="mb-3">
                        <label for="create_parent_id" class="form-label fw-semibold small">
                            Select {{ $config['parent_label'] ?? 'Parent' }} <span class="text-danger">*</span>
                        </label>
                        <select name="{{ $config['parent_key'] }}" id="create_parent_id" class="form-select select2 w-100" data-placeholder="-- Choose {{ $config['parent_label'] ?? 'Parent' }} --" required>
                            <option value="">-- Choose {{ $config['parent_label'] ?? 'Parent' }} --</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="create-error-parent"></div>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="create_name" class="form-label fw-semibold small">
                            {{ $config['singular'] }} Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="create_name" 
                               class="form-control" 
                               placeholder="e.g. {{ $config['singular'] === 'Country' ? 'India' : ($config['singular'] === 'Diet' ? 'Vegetarian' : 'Enter name') }}" 
                               required 
                               autocomplete="off">
                        <div class="invalid-feedback" id="create-error-name"></div>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3 bg-light">
                    <button type="button" class="btn btn-light px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4" id="btn-create-submit">
                        <span class="spinner-border spinner-border-sm d-none me-1" id="create-spinner" role="status"></span>
                        <span>Save {{ $config['singular'] }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END: CREATE MODAL -->

<!-- ==========================================
     START: EDIT MODAL
     ========================================== -->
<div class="modal fade" id="editMasterModal" tabindex="-1" aria-labelledby="editMasterModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg rounded-4">
            <div class="modal-header border-bottom px-4 py-3 bg-light">
                <h5 class="modal-title fw-bold" id="editMasterModalLabel">
                    <i class="bi bi-pencil-square text-primary me-1.5"></i> Edit {{ $config['singular'] }}
                </h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editMasterForm" onsubmit="handleEditSubmit(event)">
                @csrf
                <input type="hidden" id="edit_id" name="id">
                <div class="modal-body p-4">
                    <!-- Form Error Alert -->
                    <div class="alert alert-danger py-2 px-3 mb-3 small d-none" id="edit-modal-error">
                        <i class="bi bi-exclamation-triangle-fill me-1"></i>
                        <span id="edit-modal-error-text"></span>
                    </div>

                    @if(!empty($config['has_parent']))
                    <div class="mb-3">
                        <label for="edit_parent_id" class="form-label fw-semibold small">
                            Select {{ $config['parent_label'] ?? 'Parent' }} <span class="text-danger">*</span>
                        </label>
                        <select name="{{ $config['parent_key'] }}" id="edit_parent_id" class="form-select select2 w-100" data-placeholder="-- Choose {{ $config['parent_label'] ?? 'Parent' }} --" required>
                            <option value="">-- Choose {{ $config['parent_label'] ?? 'Parent' }} --</option>
                            @foreach($parents as $parent)
                                <option value="{{ $parent->id }}">{{ $parent->name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback" id="edit-error-parent"></div>
                    </div>
                    @endif

                    <div class="mb-3">
                        <label for="edit_name" class="form-label fw-semibold small">
                            {{ $config['singular'] }} Name <span class="text-danger">*</span>
                        </label>
                        <input type="text" 
                               name="name" 
                               id="edit_name" 
                               class="form-control" 
                               required 
                               autocomplete="off">
                        <div class="invalid-feedback" id="edit-error-name"></div>
                    </div>
                </div>
                <div class="modal-footer border-top px-4 py-3 bg-light">
                    <button type="button" class="btn btn-light px-3" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-4" id="btn-edit-submit">
                        <span class="spinner-border spinner-border-sm d-none me-1" id="edit-spinner" role="status"></span>
                        <span>Update {{ $config['singular'] }}</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- END: EDIT MODAL -->
@endsection

@push('scripts')
<script>
    // Global Master CRUD Controller State
    const MASTER_CONFIG = {
        type: "{{ $config['type'] }}",
        singular: "{{ $config['singular'] }}",
        plural: "{{ $config['plural'] }}",
        hasParent: {{ !empty($config['has_parent']) ? 'true' : 'false' }},
        parentKey: "{{ $config['parent_key'] ?? '' }}",
        parentLabel: "{{ $config['parent_label'] ?? '' }}",
        routes: {
            data: "{{ route('admin.masters.data', $config['type']) }}",
            store: "{{ route('admin.masters.store', $config['type']) }}",
            update: "{{ route('admin.masters.update', [$config['type'], ':id']) }}",
            destroy: "{{ route('admin.masters.destroy', [$config['type'], ':id']) }}",
            parents: "{{ route('admin.masters.parents', $config['type']) }}"
        },
        csrf: document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '{{ csrf_token() }}'
    };

    let state = {
        page: 1,
        perPage: 10,
        search: '',
        parentId: '',
        sortBy: 'id',
        sortDir: 'desc',
        searchTimeout: null,
        data: [],
        pagination: null
    };

    let createModalInstance = null;
    let editModalInstance = null;

    document.addEventListener('DOMContentLoaded', () => {
        createModalInstance = new bootstrap.Modal(document.getElementById('createMasterModal'));
        editModalInstance = new bootstrap.Modal(document.getElementById('editMasterModal'));
        
        // Select2 filter change listener
        $(document).on('change', '#filter-parent', function() {
            state.parentId = $(this).val() || '';
            fetchMasterData(1);
        });

        fetchMasterData();
    });

    /**
     * Fetch paginated records from the server via AJAX
     */
    function fetchMasterData(page = 1) {
        state.page = page;
        const tbody = document.getElementById('master-table-body');
        tbody.innerHTML = `
            <tr>
                <td colspan="${MASTER_CONFIG.hasParent ? 5 : 4}" class="text-center py-5 text-muted">
                    <div class="spinner-border spinner-border-sm text-primary me-2" role="status"></div>
                    <span>Loading ${MASTER_CONFIG.plural.toLowerCase()}...</span>
                </td>
            </tr>
        `;

        const params = new URLSearchParams({
            page: state.page,
            per_page: state.perPage,
            search: state.search,
            parent_id: state.parentId,
            sort_by: state.sortBy,
            sort_dir: state.sortDir
        });

        fetch(`${MASTER_CONFIG.routes.data}?${params.toString()}`, {
            headers: {
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(res => {
            if (res.success) {
                state.data = res.data;
                state.pagination = res.pagination;
                renderTable(res.data, res.pagination);
                renderPagination(res.pagination);
                updateTotalBadge(res.pagination.total);
            } else {
                showToast('error', res.message || 'Failed to load records');
            }
        })
        .catch(err => {
            console.error(err);
            tbody.innerHTML = `
                <tr>
                    <td colspan="${MASTER_CONFIG.hasParent ? 5 : 4}" class="text-center py-5 text-danger">
                        <i class="bi bi-exclamation-triangle fs-4 d-block mb-2"></i>
                        <span>Failed to load data. <a href="javascript:void(0)" onclick="fetchMasterData(state.page)" class="text-primary text-decoration-underline">Try again</a></span>
                    </td>
                </tr>
            `;
        });
    }

    /**
     * Render rows in the main table with continuous indexing
     */
    function renderTable(records, pagination) {
        const tbody = document.getElementById('master-table-body');
        
        if (!records || records.length === 0) {
            tbody.innerHTML = `
                <tr>
                    <td colspan="${MASTER_CONFIG.hasParent ? 5 : 4}" class="text-center py-5 text-muted">
                        <i class="bi bi-inbox fs-2 text-muted d-block mb-2"></i>
                        <span class="fw-semibold">No ${MASTER_CONFIG.plural.toLowerCase()} found.</span>
                        <div class="small mt-1 text-secondary">Try adjusting your search or filters, or create a new entry.</div>
                    </td>
                </tr>
            `;
            return;
        }

        const startIndex = (pagination.current_page - 1) * pagination.per_page;
        let html = '';

        records.forEach((row, idx) => {
            const continuousIndex = startIndex + idx + 1;
            const createdDate = row.created_at ? new Date(row.created_at).toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) : 'N/A';
            
            let parentCell = '';
            if (MASTER_CONFIG.hasParent) {
                let parentName = 'None';
                if (MASTER_CONFIG.type === 'states' && row.country) {
                    parentName = row.country.name;
                } else if (MASTER_CONFIG.type === 'cities' && row.state) {
                    parentName = `${row.state.name}${row.state.country ? ` <span class="text-muted small">(${row.state.country.name})</span>` : ''}`;
                } else if (MASTER_CONFIG.type === 'communities' && row.religion) {
                    parentName = row.religion.name;
                }
                parentCell = `<td><span class="badge bg-light text-dark border px-2 py-1">${parentName}</span></td>`;
            }

            html += `
                <tr id="row-${row.id}">
                    <td class="ps-4 fw-bold text-muted font-monospace">${continuousIndex}</td>
                    <td>
                        <span class="fw-bold text-dark">${escapeHtml(row.name)}</span>
                    </td>
                    ${parentCell}
                    <td>
                        <small class="text-muted"><i class="bi bi-clock me-1"></i>${createdDate}</small>
                    </td>
                    <td class="text-end pe-4">
                        <div class="btn-group btn-group-sm">
                            <button type="button" 
                                    class="btn btn-outline-primary" 
                                    title="Edit ${MASTER_CONFIG.singular}" 
                                    onclick="openEditModal(${row.id})">
                                <i class="bi bi-pencil"></i>
                            </button>
                            <button type="button" 
                                    class="btn btn-outline-danger" 
                                    title="Delete ${MASTER_CONFIG.singular}" 
                                    onclick="confirmDelete(${row.id}, '${escapeHtml(row.name)}')">
                                <i class="bi bi-trash3"></i>
                            </button>
                        </div>
                    </td>
                </tr>
            `;
        });

        tbody.innerHTML = html;
    }

    /**
     * Render pagination component
     */
    function renderPagination(pagination) {
        const summary = document.getElementById('pagination-summary');
        const controls = document.getElementById('pagination-controls');

        if (!pagination || pagination.total === 0) {
            summary.innerText = 'Showing 0 of 0 records';
            controls.innerHTML = '';
            return;
        }

        summary.innerText = `Showing ${pagination.from} to ${pagination.to} of ${pagination.total.toLocaleString()} ${MASTER_CONFIG.plural.toLowerCase()}`;

        const totalPages = pagination.last_page;
        const current = pagination.current_page;
        let html = '';

        // Prev Button
        html += `
            <li class="page-item ${current <= 1 ? 'disabled' : ''}">
                <button class="page-link" onclick="fetchMasterData(${current - 1})" aria-label="Previous">
                    <i class="bi bi-chevron-left"></i>
                </button>
            </li>
        `;

        // Page Range calculation (sliding window)
        let startPage = Math.max(1, current - 2);
        let endPage = Math.min(totalPages, current + 2);

        if (startPage > 1) {
            html += `<li class="page-item"><button class="page-link" onclick="fetchMasterData(1)">1</button></li>`;
            if (startPage > 2) {
                html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
        }

        for (let p = startPage; p <= endPage; p++) {
            html += `
                <li class="page-item ${p === current ? 'active' : ''}">
                    <button class="page-link" onclick="fetchMasterData(${p})">${p}</button>
                </li>
            `;
        }

        if (endPage < totalPages) {
            if (endPage < totalPages - 1) {
                html += `<li class="page-item disabled"><span class="page-link">...</span></li>`;
            }
            html += `<li class="page-item"><button class="page-link" onclick="fetchMasterData(${totalPages})">${totalPages}</button></li>`;
        }

        // Next Button
        html += `
            <li class="page-item ${current >= totalPages ? 'disabled' : ''}">
                <button class="page-link" onclick="fetchMasterData(${current + 1})" aria-label="Next">
                    <i class="bi bi-chevron-right"></i>
                </button>
            </li>
        `;

        controls.innerHTML = html;
    }

    /**
     * Update header total badge
     */
    function updateTotalBadge(total) {
        const badge = document.getElementById('header-total-badge');
        if (badge) {
            badge.innerText = `${Number(total).toLocaleString()} Total`;
        }
    }

    /**
     * Search Input Handling (Debounced)
     */
    function handleSearchInput(e) {
        const value = e.target.value;
        const clearBtn = document.getElementById('btn-clear-search');
        if (clearBtn) {
            clearBtn.classList.toggle('d-none', !value);
        }

        clearTimeout(state.searchTimeout);
        state.searchTimeout = setTimeout(() => {
            state.search = value.trim();
            fetchMasterData(1);
        }, 300);
    }

    function clearSearch() {
        const input = document.getElementById('filter-search');
        input.value = '';
        state.search = '';
        document.getElementById('btn-clear-search').classList.add('d-none');
        if ($('#filter-parent').length) {
            $('#filter-parent').val('').trigger('change');
        }
        fetchMasterData(1);
    }

    function handleParentFilterChange() {
        const select = document.getElementById('filter-parent');
        state.parentId = select ? select.value : '';
        fetchMasterData(1);
    }

    function handlePerPageChange() {
        const select = document.getElementById('per-page-select');
        state.perPage = select ? parseInt(select.value, 10) : 10;
        fetchMasterData(1);
    }

    /**
     * Modal Operations
     */
    function openCreateModal() {
        const form = document.getElementById('createMasterForm');
        form.reset();
        clearValidationErrors('create');
        if ($('#create_parent_id').length) {
            $('#create_parent_id').val('').trigger('change');
        }
        createModalInstance.show();
        setTimeout(() => document.getElementById('create_name').focus(), 300);
    }

    function handleCreateSubmit(e) {
        e.preventDefault();
        clearValidationErrors('create');

        const nameInput = document.getElementById('create_name');
        const nameVal = nameInput.value.trim();

        if (!nameVal) {
            showInputError('create', 'name', 'Please provide a valid name.');
            return;
        }

        const payload = {
            _token: MASTER_CONFIG.csrf,
            name: nameVal
        };

        if (MASTER_CONFIG.hasParent) {
            const parentSelect = document.getElementById('create_parent_id');
            if (!parentSelect.value) {
                showInputError('create', 'parent', `Please select a ${MASTER_CONFIG.parentLabel || 'Parent'}.`);
                return;
            }
            payload[MASTER_CONFIG.parentKey] = parentSelect.value;
        }

        const btn = document.getElementById('btn-create-submit');
        const spinner = document.getElementById('create-spinner');
        btn.disabled = true;
        spinner.classList.remove('d-none');

        fetch(MASTER_CONFIG.routes.store, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': MASTER_CONFIG.csrf
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json().then(data => ({ status: res.status, ok: res.ok, data })))
        .then(({ status, ok, data }) => {
            btn.disabled = false;
            spinner.classList.add('d-none');

            if (ok && data.success) {
                createModalInstance.hide();
                showToast('success', data.message);
                fetchMasterData(1); // Jump to top page to view newly created record
            } else {
                if (data.errors) {
                    if (data.errors.name) showInputError('create', 'name', data.errors.name[0]);
                    if (MASTER_CONFIG.hasParent && data.errors[MASTER_CONFIG.parentKey]) {
                        showInputError('create', 'parent', data.errors[MASTER_CONFIG.parentKey][0]);
                    }
                }
                const errorBox = document.getElementById('create-modal-error');
                const errorText = document.getElementById('create-modal-error-text');
                errorText.innerText = data.message || 'Unable to save record.';
                errorBox.classList.remove('d-none');
            }
        })
        .catch(err => {
            btn.disabled = false;
            spinner.classList.add('d-none');
            console.error(err);
            showToast('error', 'An error occurred while saving.');
        });
    }

    function openEditModal(id) {
        const record = state.data.find(r => r.id === id);
        if (!record) return;

        clearValidationErrors('edit');
        document.getElementById('edit_id').value = record.id;
        document.getElementById('edit_name').value = record.name;

        if (MASTER_CONFIG.hasParent) {
            const parentSelect = $('#edit_parent_id');
            if (parentSelect.length && record[MASTER_CONFIG.parentKey]) {
                parentSelect.val(record[MASTER_CONFIG.parentKey]).trigger('change');
            }
        }

        editModalInstance.show();
        setTimeout(() => document.getElementById('edit_name').focus(), 300);
    }

    function handleEditSubmit(e) {
        e.preventDefault();
        clearValidationErrors('edit');

        const id = document.getElementById('edit_id').value;
        const nameInput = document.getElementById('edit_name');
        const nameVal = nameInput.value.trim();

        if (!nameVal) {
            showInputError('edit', 'name', 'Please provide a valid name.');
            return;
        }

        const payload = {
            _token: MASTER_CONFIG.csrf,
            name: nameVal
        };

        if (MASTER_CONFIG.hasParent) {
            const parentSelect = document.getElementById('edit_parent_id');
            if (!parentSelect.value) {
                showInputError('edit', 'parent', `Please select a ${MASTER_CONFIG.parentLabel || 'Parent'}.`);
                return;
            }
            payload[MASTER_CONFIG.parentKey] = parentSelect.value;
        }

        const btn = document.getElementById('btn-edit-submit');
        const spinner = document.getElementById('edit-spinner');
        btn.disabled = true;
        spinner.classList.remove('d-none');

        const updateUrl = MASTER_CONFIG.routes.update.replace(':id', id);

        fetch(updateUrl, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': MASTER_CONFIG.csrf
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json().then(data => ({ status: res.status, ok: res.ok, data })))
        .then(({ status, ok, data }) => {
            btn.disabled = false;
            spinner.classList.add('d-none');

            if (ok && data.success) {
                editModalInstance.hide();
                showToast('success', data.message);
                fetchMasterData(state.page); // Refresh current page
            } else {
                if (data.errors) {
                    if (data.errors.name) showInputError('edit', 'name', data.errors.name[0]);
                    if (MASTER_CONFIG.hasParent && data.errors[MASTER_CONFIG.parentKey]) {
                        showInputError('edit', 'parent', data.errors[MASTER_CONFIG.parentKey][0]);
                    }
                }
                const errorBox = document.getElementById('edit-modal-error');
                const errorText = document.getElementById('edit-modal-error-text');
                errorText.innerText = data.message || 'Unable to update record.';
                errorBox.classList.remove('d-none');
            }
        })
        .catch(err => {
            btn.disabled = false;
            spinner.classList.add('d-none');
            console.error(err);
            showToast('error', 'An error occurred while updating.');
        });
    }

    /**
     * Delete confirmation & execution
     */
    function confirmDelete(id, name) {
        Swal.fire({
            title: `Delete ${MASTER_CONFIG.singular}?`,
            html: `Are you sure you want to delete <strong>${escapeHtml(name)}</strong>?<br><small class="text-danger">This action cannot be undone.</small>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                const deleteUrl = MASTER_CONFIG.routes.destroy.replace(':id', id);

                fetch(deleteUrl, {
                    method: 'DELETE',
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': MASTER_CONFIG.csrf
                    }
                })
                .then(res => res.json().then(data => ({ ok: res.ok, data })))
                .then(({ ok, data }) => {
                    if (ok && data.success) {
                        showToast('success', data.message);
                        // If current page now empty and not page 1, shift back 1 page
                        if (state.data.length === 1 && state.page > 1) {
                            fetchMasterData(state.page - 1);
                        } else {
                            fetchMasterData(state.page);
                        }
                    } else {
                        Swal.fire('Cannot Delete', data.message || 'This record cannot be deleted.', 'error');
                    }
                })
                .catch(err => {
                    console.error(err);
                    showToast('error', 'An error occurred while deleting.');
                });
            }
        });
    }

    /**
     * Helpers for validation display
     */
    function showInputError(prefix, field, message) {
        const input = document.getElementById(`${prefix}_${field}`) || document.getElementById(`${prefix}_${field}_id`);
        const feedback = document.getElementById(`${prefix}-error-${field}`);
        if (input) input.classList.add('is-invalid');
        if (feedback) {
            feedback.innerText = message;
            feedback.style.display = 'block';
        }
    }

    function clearValidationErrors(prefix) {
        const errorBox = document.getElementById(`${prefix}-modal-error`);
        if (errorBox) errorBox.classList.add('d-none');

        ['name', 'parent'].forEach(f => {
            const input = document.getElementById(`${prefix}_${f}`) || document.getElementById(`${prefix}_${f}_id`);
            const feedback = document.getElementById(`${prefix}-error-${f}`);
            if (input) input.classList.remove('is-invalid');
            if (feedback) {
                feedback.innerText = '';
                feedback.style.display = 'none';
            }
        });
    }

    function showToast(icon, title) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: icon,
                title: title,
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        } else {
            alert(title);
        }
    }

    function escapeHtml(str) {
        if (!str) return '';
        return String(str)
            .replace(/&/g, '&amp;')
            .replace(/</g, '&lt;')
            .replace(/>/g, '&gt;')
            .replace(/"/g, '&quot;')
            .replace(/'/g, '&#039;');
    }
</script>
@endpush
