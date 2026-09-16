@extends('admin.layouts.app')

@section('title', 'Transactions Ledger - Rani Matrimonial')

@section('content')
<div class="container-fluid p-0">

    <!-- START: Page Header -->
    <div class="page-header d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <i class="bi bi-wallet2 fs-4 text-primary"></i>
                <h1 class="page-title mb-0">Transactions Ledger</h1>
                <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 ms-2">
                    {{ number_format($stats['total_count'] ?? 0) }} Total Records
                </span>
            </div>
            <p class="page-subtitle mb-0">Complete audit log of all candidate wallet top-ups, package purchases, and contact view deductions.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm d-flex align-items-center gap-1.5 px-3 py-2 rounded-3">
                <i class="bi bi-arrow-left"></i>
                <span>Dashboard</span>
            </a>
        </div>
    </div>
    <!-- END: Page Header -->

    <!-- START: Summary Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-3 h-100 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-primary-subtle text-primary d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 22px;">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">Total Transactions</div>
                        <h4 class="fw-bold mb-0 text-dark">{{ number_format($stats['total_count'] ?? 0) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-3 h-100 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-success-subtle text-success d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 22px;">
                        <i class="bi bi-arrow-down-left-circle-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">Total Credits (Deposits / Additions)</div>
                        <h4 class="fw-bold mb-0 text-success">₹{{ number_format($stats['total_credits'] ?? 0, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-3 h-100 p-3 bg-white">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 bg-danger-subtle text-danger d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 22px;">
                        <i class="bi bi-arrow-up-right-circle-fill"></i>
                    </div>
                    <div>
                        <div class="text-muted small fw-medium">Total Debits (Spent / Deducted)</div>
                        <h4 class="fw-bold mb-0 text-danger">₹{{ number_format($stats['total_debits'] ?? 0, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Summary Stats Cards -->

    <!-- START: Metric Filter Tabs & Search Bar -->
    <div class="card border-0 shadow-sm rounded-3 mb-4">
        <div class="card-body p-3">
            <div class="row g-3 align-items-center justify-content-between">
                
                <!-- Filter Tabs: All, Credit, Debit -->
                <div class="col-12 col-md-6">
                    <ul class="nav nav-pills gap-2" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link px-3 py-1.5 rounded-pill {{ $type === 'all' ? 'active bg-primary text-white fw-semibold' : 'bg-light text-dark' }}" 
                               href="{{ route('admin.transactions.index', ['type' => 'all', 'search' => $search]) }}">
                                All Transactions
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 py-1.5 rounded-pill {{ $type === 'credit' ? 'active bg-success text-white fw-semibold' : 'bg-light text-dark' }}" 
                               href="{{ route('admin.transactions.index', ['type' => 'credit', 'search' => $search]) }}">
                                <i class="bi bi-plus-circle me-1 text-success"></i> Credits / Deposits
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link px-3 py-1.5 rounded-pill {{ $type === 'debit' ? 'active bg-danger text-white fw-semibold' : 'bg-light text-dark' }}" 
                               href="{{ route('admin.transactions.index', ['type' => 'debit', 'search' => $search]) }}">
                                <i class="bi bi-dash-circle me-1 text-danger"></i> Debits / Deductions
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- Search Form -->
                <div class="col-12 col-md-5 col-lg-4">
                    <form method="GET" action="{{ route('admin.transactions.index') }}" class="input-group">
                        <input type="hidden" name="type" value="{{ $type }}">
                        <span class="input-group-text bg-light border-end-0 text-muted">
                            <i class="bi bi-search"></i>
                        </span>
                        <input type="text" 
                               name="search" 
                               class="form-control bg-light border-start-0 ps-0" 
                               placeholder="Search Txn ID, name, code, description..." 
                               value="{{ $search }}">
                        @if(!empty($search))
                            <a href="{{ route('admin.transactions.index', ['type' => $type]) }}" class="btn btn-light border border-start-0 text-muted">
                                <i class="bi bi-x-lg"></i>
                            </a>
                        @endif
                        <button class="btn btn-primary" type="submit">Search</button>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <!-- END: Metric Filter Tabs & Search Bar -->

    <!-- START: Transactions Table Card -->
    <div class="card border-0 shadow-sm rounded-3">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="table-light">
                        <tr class="small text-muted text-uppercase">
                            <th class="ps-4" style="width: 70px;">#</th>
                            <th>Txn Reference</th>
                            <th>Candidate</th>
                            <th>Type</th>
                            <th>Amount</th>
                            <th>Description</th>
                            <th>Status</th>
                            <th class="text-end pe-4" style="width: 140px;">Date & Time</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transactions as $txn)
                            @php
                                $candidate = $txn->candidate ?? ($txn->wallet->candidate ?? null);
                                $isCredit = strtolower($txn->type) === 'credit';
                            @endphp
                            <tr>
                                <td class="ps-4 fw-bold text-muted font-monospace">
                                    {{ (($transactions->currentPage() - 1) * $transactions->perPage()) + $loop->iteration }}
                                </td>
                                <td>
                                    <div class="font-monospace fw-bold text-dark small">
                                        {{ $txn->transaction_id ?? ('TXN-' . str_pad($txn->id, 8, '0', STR_PAD_LEFT)) }}
                                    </div>
                                    <small class="text-muted text-uppercase">
                                        <i class="bi bi-credit-card me-1"></i>{{ $txn->payment_method ?? ($txn->source ?? 'Wallet') }}
                                    </small>
                                </td>
                                <td>
                                    @if($candidate)
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="rounded-circle d-flex align-items-center justify-content-center fw-bold text-white shadow-xs flex-shrink-0" 
                                                 style="width: 34px; height: 34px; background: {{ strtolower($candidate->gender ?? '') === 'female' ? '#dc3545' : '#0d6efd' }}; font-size: 12px;">
                                                {{ strtoupper(substr($candidate->first_name ?? 'C', 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="fw-bold text-dark text-truncate" style="max-width: 160px;">
                                                    {{ $candidate->first_name }} {{ $candidate->last_name }}
                                                </div>
                                                <small class="text-muted font-monospace">
                                                    {{ $candidate->candidate_code ?? ('RM' . str_pad($candidate->id, 5, '0', STR_PAD_LEFT)) }}
                                                </small>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted small">System / Anonymous</span>
                                    @endif
                                </td>
                                <td>
                                    @if($isCredit)
                                        <span class="badge bg-success-subtle text-success border border-success-subtle px-2.5 py-1">
                                            <i class="bi bi-arrow-down-left me-1"></i> Credit
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2.5 py-1">
                                            <i class="bi bi-arrow-up-right me-1"></i> Debit
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <span class="fw-bold font-monospace {{ $isCredit ? 'text-success' : 'text-danger' }}">
                                        {{ $isCredit ? '+' : '-' }}₹{{ number_format((float) $txn->amount, 2) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="fw-medium text-dark small">{{ $txn->title ?? ($txn->description ?? 'Transaction') }}</div>
                                    @if($txn->description && $txn->title && $txn->description !== $txn->title)
                                        <small class="text-muted">{{ Str::limit($txn->description, 50) }}</small>
                                    @endif
                                </td>
                                <td>
                                    @php
                                        $status = strtolower($txn->status ?? 'completed');
                                    @endphp
                                    @if($status === 'completed' || $status === 'success')
                                        <span class="badge bg-success-subtle text-success rounded-pill px-2.5 py-1">
                                            <i class="bi bi-check-circle-fill me-1 small"></i> Completed
                                        </span>
                                    @elseif($status === 'pending')
                                        <span class="badge bg-warning-subtle text-warning-emphasis rounded-pill px-2.5 py-1">
                                            <i class="bi bi-clock-history me-1 small"></i> Pending
                                        </span>
                                    @else
                                        <span class="badge bg-danger-subtle text-danger rounded-pill px-2.5 py-1">
                                            <i class="bi bi-x-circle-fill me-1 small"></i> {{ ucfirst($status) }}
                                        </span>
                                    @endif
                                </td>
                                <td class="text-end pe-4">
                                    <div class="small fw-semibold text-dark">
                                        {{ $txn->created_at ? $txn->created_at->format('d M, Y') : 'N/A' }}
                                    </div>
                                    <small class="text-muted font-monospace">
                                        {{ $txn->created_at ? $txn->created_at->format('h:i A') : '' }}
                                    </small>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-5 text-muted">
                                    <i class="bi bi-wallet2 fs-2 text-muted d-block mb-2"></i>
                                    <span class="fw-semibold">No transactions found matching the selected filter.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Card Footer: Pagination -->
        @if($transactions->hasPages())
        <div class="card-footer bg-white border-top p-3 d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            <div class="small text-muted">
                Showing {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }} of {{ number_format($transactions->total()) }} transactions
            </div>
            <div>
                {{ $transactions->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
    </div>
    <!-- END: Transactions Table Card -->

</div>
@endsection
