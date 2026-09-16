@extends('admin.layouts.app')

@section('title', 'Transactions Ledger - Rani Matrimonial')

@section('content')
<div class="container-fluid p-0">

    <!-- START: Page Header Banner -->
    <div class="page-header d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <h1 class="page-title mb-0">Transactions Ledger</h1>
                <span class="badge-table success ms-2">
                    {{ number_format($stats['total_count'] ?? 0) }} Total Records
                </span>
            </div>
            <p class="page-subtitle mb-0">Complete audit log of all candidate wallet top-ups, package purchases, and contact view deductions.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn-custom btn-custom-light btn-custom-sm">
                <i class="bi bi-arrow-left"></i>
                <span>Dashboard</span>
            </a>
        </div>
    </div>
    <!-- END: Page Header Banner -->

    <!-- START: Summary Stats Cards -->
    <div class="row g-3 mb-4">
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-3 h-100 p-3 bg-white" style="border: 1px solid rgba(11, 19, 15, 0.06) !important;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 22px; background-color: rgba(15, 74, 50, 0.1); color: var(--brand-forest-medium);">
                        <i class="bi bi-receipt"></i>
                    </div>
                    <div>
                        <div class="table-user-sub">Total Transactions</div>
                        <h4 class="fw-bold mb-0 text-main">{{ number_format($stats['total_count'] ?? 0) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-3 h-100 p-3 bg-white" style="border: 1px solid rgba(11, 19, 15, 0.06) !important;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 22px; background-color: rgba(34, 197, 94, 0.1); color: var(--sys-green);">
                        <i class="bi bi-arrow-down-left-circle-fill"></i>
                    </div>
                    <div>
                        <div class="table-user-sub">Total Credits (Deposits / Additions)</div>
                        <h4 class="fw-bold mb-0 text-success font-monospace">₹{{ number_format($stats['total_credits'] ?? 0, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12 col-md-4">
            <div class="card border-0 shadow-sm rounded-3 h-100 p-3 bg-white" style="border: 1px solid rgba(11, 19, 15, 0.06) !important;">
                <div class="d-flex align-items-center gap-3">
                    <div class="rounded-3 d-flex align-items-center justify-content-center" style="width: 48px; height: 48px; font-size: 22px; background-color: rgba(239, 68, 68, 0.1); color: var(--sys-red);">
                        <i class="bi bi-arrow-up-right-circle-fill"></i>
                    </div>
                    <div>
                        <div class="table-user-sub">Total Debits (Spent / Deducted)</div>
                        <h4 class="fw-bold mb-0 text-danger font-monospace">₹{{ number_format($stats['total_debits'] ?? 0, 2) }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Summary Stats Cards -->

    <!-- START: Refined Table Container -->
    <div class="table-card-custom">
        
        <!-- START: Header Control & Filters -->
        <div class="table-header-control">
            <!-- Filter Tabs: All, Credit, Debit -->
            <div class="d-flex flex-wrap align-items-center gap-2">
                <a href="{{ route('admin.transactions.index', ['type' => 'all', 'search' => $search]) }}" 
                   class="btn-custom btn-custom-sm {{ $type === 'all' ? 'btn-custom-primary' : 'btn-custom-light' }}">
                    All Transactions
                </a>
                <a href="{{ route('admin.transactions.index', ['type' => 'credit', 'search' => $search]) }}" 
                   class="btn-custom btn-custom-sm {{ $type === 'credit' ? 'btn-custom-secondary' : 'btn-custom-light' }}">
                    <i class="bi bi-plus-circle"></i> Credits / Deposits
                </a>
                <a href="{{ route('admin.transactions.index', ['type' => 'debit', 'search' => $search]) }}" 
                   class="btn-custom btn-custom-sm {{ $type === 'debit' ? 'btn-custom-danger' : 'btn-custom-light' }}">
                    <i class="bi bi-dash-circle"></i> Debits / Deductions
                </a>
            </div>

            <!-- Search Form -->
            <form method="GET" action="{{ route('admin.transactions.index') }}" class="table-search-box m-0">
                <input type="hidden" name="type" value="{{ $type }}">
                <i class="bi bi-search table-search-icon"></i>
                <input type="text" 
                       name="search" 
                       class="table-search-input" 
                       placeholder="Search Txn ID, name, code..." 
                       value="{{ $search }}">
            </form>
        </div>
        <!-- END: Header Control & Filters -->

        <!-- START: Responsive Custom Table -->
        <div class="table-responsive">
            <table class="table-custom">
                <thead>
                    <tr>
                        <th class="ps-4" style="width: 60px;">#</th>
                        <th>Txn Reference</th>
                        <th>Candidate Profile</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Description</th>
                        <th>Status</th>
                        <th>Date & Time</th>
                        <th class="text-center pe-4" style="width: 120px;">Receipt</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transactions as $txn)
                        @php
                            $candidate = $txn->candidate ?? ($txn->wallet->candidate ?? null);
                            $isCredit = strtolower($txn->type) === 'credit';
                        @endphp
                        <tr>
                            <td class="ps-4 text-muted fw-bold font-monospace">
                                {{ (($transactions->currentPage() - 1) * $transactions->perPage()) + $loop->iteration }}
                            </td>
                            <td>
                                <div class="font-monospace fw-bold small" style="color: var(--brand-forest-dark);">
                                    {{ $txn->transaction_id ?? ('TXN-' . str_pad($txn->id, 8, '0', STR_PAD_LEFT)) }}
                                </div>
                                <div class="table-user-sub text-uppercase">
                                    <i class="bi bi-credit-card me-1"></i>{{ $txn->payment_method ?? ($txn->source ?? 'Wallet') }}
                                </div>
                            </td>
                            <td>
                                @if($candidate)
                                    <div class="table-user-cell">
                                        <img src="{{ $candidate->avatar_url }}" alt="{{ $candidate->first_name }}" class="table-user-avatar"
                                             onerror="this.src='https://ui-avatars.com/api/?name={{ urlencode(($candidate->first_name ?? 'C').' '.($candidate->last_name ?? '')) }}&background=0F4A32&color=fff'">
                                        <div>
                                            <a href="{{ route('admin.candidates.show', $candidate->id) }}" class="table-user-name text-decoration-none">
                                                {{ $candidate->first_name }} {{ $candidate->last_name }}
                                            </a>
                                            <div class="table-user-sub font-monospace">
                                                {{ $candidate->candidate_code ?? $candidate->profile_id ?? ('RM' . str_pad($candidate->id, 5, '0', STR_PAD_LEFT)) }}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="table-user-sub">System / Anonymous</span>
                                @endif
                            </td>
                            <td>
                                @if($isCredit)
                                    <span class="badge-table success">
                                        <i class="bi bi-arrow-down-left"></i> Credit
                                    </span>
                                @else
                                    <span class="badge-table failed">
                                        <i class="bi bi-arrow-up-right"></i> Debit
                                    </span>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold font-monospace {{ $isCredit ? 'text-success' : 'text-danger' }}">
                                    {{ $isCredit ? '+' : '-' }}₹{{ number_format((float) $txn->amount, 2) }}
                                </span>
                            </td>
                            <td>
                                <div class="fw-semibold text-main small">{{ $txn->title ?? ($txn->description ?? 'Transaction') }}</div>
                                @if($txn->description && $txn->title && $txn->description !== $txn->title)
                                    <div class="table-user-sub">{{ Str::limit($txn->description, 50) }}</div>
                                @endif
                            </td>
                            <td>
                                @php
                                    $status = strtolower($txn->status ?? 'completed');
                                @endphp
                                @if($status === 'completed' || $status === 'success')
                                    <span class="badge-table success">Completed</span>
                                @elseif($status === 'pending')
                                    <span class="badge-table pending">Pending</span>
                                @else
                                    <span class="badge-table failed">{{ ucfirst($status) }}</span>
                                @endif
                            </td>
                            <td>
                                <div class="table-user-sub fw-semibold text-main">
                                    {{ $txn->created_at ? $txn->created_at->format('d M, Y') : 'N/A' }}
                                </div>
                                <div class="table-user-sub font-monospace">
                                    {{ $txn->created_at ? $txn->created_at->format('h:i A') : '' }}
                                </div>
                            </td>
                            <td class="text-center pe-4">
                                <a href="{{ route('admin.transactions.receipt', $txn->id) }}" 
                                   target="_blank" 
                                   class="btn-custom btn-custom-secondary btn-custom-sm py-1 px-2.5 shadow-xs" 
                                   title="Download Official PDF Receipt">
                                    <i class="bi bi-download"></i> Receipt
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center py-5 text-muted">
                                <i class="bi bi-wallet2 fs-2 d-block mb-2 text-muted-green"></i>
                                <span class="fw-semibold">No transactions found matching the selected filter.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <!-- END: Responsive Custom Table -->

        <!-- START: Table Pagination Footer -->
        @if($transactions->hasPages())
        <div class="p-3 bg-white border-top d-flex flex-column flex-md-row align-items-center justify-content-between gap-3">
            <div class="table-user-sub">
                Showing {{ $transactions->firstItem() ?? 0 }} to {{ $transactions->lastItem() ?? 0 }} of {{ number_format($transactions->total()) }} transactions
            </div>
            <div>
                {{ $transactions->links('pagination::bootstrap-5') }}
            </div>
        </div>
        @endif
        <!-- END: Table Pagination Footer -->

    </div>
    <!-- END: Refined Table Container -->

</div>
@endsection
