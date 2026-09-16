@extends('frontend.layouts.auth_app')

@section('title', 'Debit Transactions & Service Expenses | Rani Matrimonial')

@section('content')
<div class="relative pt-6 pb-20">
    <!-- Background Image & Overlay -->
    <div class="fixed inset-0 z-0 bg-cover bg-top bg-no-repeat" style="background-image: url('{{ asset('img/hero.png') }}');"></div>
    <div class="fixed inset-0 z-0 bg-gradient-to-t from-rani-dark/85 via-rani-primary-dark/45 to-rani-primary-dark/25"></div>
    
    <!-- Floating Hearts -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none heart-container opacity-40">
        <div class="heart-floating delay-1"></div>
        <div class="heart-floating heart-maroon delay-2"></div>
        <div class="heart-floating delay-3"></div>
        <div class="heart-floating heart-maroon delay-4"></div>
        <div class="heart-floating delay-5"></div>
    </div>

    <div class="relative z-10 max-w-6xl mx-auto px-2.5 sm:px-6 lg:px-8">
        
        <!-- Main Card Container -->
        <div class="bg-white/95 backdrop-blur-md rounded-2xl sm:rounded-3xl shadow-2xl border border-white/60 mb-10 overflow-hidden relative z-10">
            
            <!-- Ruby & Gold Accent Top Bar -->
            <div class="absolute top-0 left-0 w-full h-2 sm:h-2.5 bg-gradient-to-r from-rose-700 via-red-800 to-rani-gold opacity-95"></div>
            
            <!-- Page Header -->
            <div class="px-4 sm:px-6 md:px-10 pt-6 sm:pt-8 pb-5 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-2xl bg-gradient-to-br from-rose-700 to-red-800 flex items-center justify-center text-white shadow-md shrink-0">
                        <svg class="w-5 h-5 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold font-serif text-gray-900 tracking-wide">Debit History</h1>
                            <span class="px-2.5 py-0.5 rounded-full text-[11px] font-extrabold bg-rose-100 text-rose-800 border border-rose-200">
                                Service Spends
                            </span>
                        </div>
                        <p class="text-[11px] sm:text-xs text-gray-500 font-sans mt-0.5">All deductions for verified contact unlocks and matrimony features</p>
                    </div>
                </div>

                <div class="flex items-center gap-2 sm:gap-3 self-start md:self-auto">
                    <a href="{{ route('wallet', ['tab' => 'recharge']) }}" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white text-xs sm:text-sm font-bold shadow-md hover:shadow-lg transition-all">
                        <svg class="w-4 h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        <span>Recharge Wallet</span>
                    </a>
                    <a href="{{ route('wallet') }}" class="inline-flex items-center gap-1.5 px-3.5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-xs sm:text-sm font-semibold transition-all">
                        <span>Card Overview</span>
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            <div class="p-4 sm:p-6 md:p-10 space-y-6 sm:space-y-8">

                <!-- Summary Metrics Bar -->
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    
                    <!-- Metric 1: Total Debits -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-br from-rose-50 to-white border border-rose-200/80 shadow-xs flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-rose-800 uppercase tracking-wider">Total Services Spent</p>
                            <h3 class="text-2xl sm:text-3xl font-bold font-serif text-rose-700 mt-1">- ₹ {{ number_format($totalDebit, 2) }}</h3>
                            <p class="text-[11px] text-gray-400 font-sans mt-0.5">Total matrimonial deductions</p>
                        </div>
                        <div class="w-11 h-11 rounded-2xl bg-rose-600 text-white flex items-center justify-center shadow-sm shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                        </div>
                    </div>

                    <!-- Metric 2: Available Balance -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-br from-amber-50 to-white border border-amber-200/80 shadow-xs flex items-center justify-between">
                        <div>
                            <p class="text-xs font-bold text-gray-600 uppercase tracking-wider">Current Available Balance</p>
                            <h3 class="text-2xl sm:text-3xl font-bold font-serif text-rani-primary-dark mt-1">₹ {{ number_format($wallet->avl_balance, 2) }}</h3>
                            <p class="text-[11px] text-gray-400 font-sans mt-0.5">Remaining spendable credits</p>
                        </div>
                        <div class="w-11 h-11 rounded-2xl bg-gradient-to-br from-rani-gold to-yellow-500 text-rani-dark flex items-center justify-center shadow-sm shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                        </div>
                    </div>

                    <!-- Metric 3: Total Debit Transactions Count -->
                    <div class="p-4 sm:p-5 rounded-2xl bg-gradient-to-br from-slate-50 to-white border border-slate-200 shadow-xs flex items-center justify-between sm:col-span-2 lg:col-span-1">
                        <div>
                            <p class="text-xs font-bold text-gray-500 uppercase tracking-wider">Debit Transactions</p>
                            <h3 class="text-2xl sm:text-3xl font-bold font-serif text-gray-800 mt-1">{{ $debitTransactions->total() }} Records</h3>
                            <p class="text-[11px] text-gray-400 font-sans mt-0.5">Service receipts generated</p>
                        </div>
                        <div class="w-11 h-11 rounded-2xl bg-slate-100 text-gray-600 flex items-center justify-center shadow-sm shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        </div>
                    </div>

                </div>

                <!-- Search Filter Form -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 bg-gray-50/80 p-3 rounded-2xl border border-gray-200/70">
                    <form method="GET" action="{{ route('wallet.debit') }}" class="relative flex-1">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Search by Transaction ID, service title, category..." 
                               class="w-full pl-9 pr-24 py-2 text-xs sm:text-sm rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-rose-500 bg-white shadow-xs">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <button type="submit" class="absolute right-1.5 top-1 px-3 py-1.5 bg-rose-700 hover:bg-rose-800 text-white rounded-lg text-xs font-bold transition-colors">
                            Search
                        </button>
                    </form>
                    @if(request('search'))
                        <a href="{{ route('wallet.debit') }}" class="px-3 py-2 text-xs font-bold text-gray-500 hover:text-red-600 bg-white border border-gray-200 rounded-xl transition-colors text-center">
                            Clear Filter
                        </a>
                    @endif
                </div>

                <!-- Debit Transactions List -->
                <div class="overflow-hidden rounded-2xl border border-gray-200 shadow-sm bg-white">
                    
                    <!-- Table Header (Desktop) -->
                    <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-3.5 bg-gray-50/90 border-b border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider">
                        <div class="col-span-5">Service & Deduction Details</div>
                        <div class="col-span-2 text-center">Service Category</div>
                        <div class="col-span-2 text-center">Status</div>
                        <div class="col-span-2 text-right">Amount Debited</div>
                        <div class="col-span-1 text-center">Invoice</div>
                    </div>

                    <!-- Transactions Rows -->
                    <div class="divide-y divide-gray-100">
                        @forelse($debitTransactions as $txn)
                            <div class="p-3 sm:px-5 sm:py-3.5 transition-colors hover:bg-rose-50/40 flex items-center justify-between gap-2.5 sm:gap-4">
                                
                                <!-- Left: Icon + Title + Meta -->
                                <div class="flex items-center gap-2.5 sm:gap-3.5 min-w-0 flex-1">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl bg-rose-100 text-rose-700 border border-rose-200 flex items-center justify-center shrink-0 shadow-2xs">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            <h4 class="text-xs sm:text-sm font-bold text-gray-900 truncate max-w-[140px] xs:max-w-[200px] sm:max-w-none">{{ $txn->title }}</h4>
                                            <span class="inline-block px-1.5 py-0.2 rounded text-[9px] sm:text-[10px] font-semibold bg-rose-50 text-rose-700 border border-rose-100">
                                                {{ $txn->category ?? 'Service Deduction' }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-1.5 text-[10px] sm:text-[11px] text-gray-400 mt-0.5">
                                            <span class="font-mono text-gray-500 font-semibold">#{{ $txn->transaction_id }}</span>
                                            <span>•</span>
                                            <span class="whitespace-nowrap">{{ $txn->created_at->format('d M, h:i A') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right: Amount + Bal + Download Button -->
                                <div class="flex items-center gap-2 sm:gap-4 shrink-0 text-right">
                                    <div>
                                        <div class="text-xs sm:text-sm md:text-base font-extrabold font-mono text-rose-600 whitespace-nowrap">
                                            - ₹ {{ number_format($txn->amount, 2) }}
                                        </div>
                                        <div class="text-[9px] sm:text-[10px] text-gray-400 font-mono whitespace-nowrap">
                                            Bal: ₹ {{ number_format($txn->balance_after, 2) }}
                                        </div>
                                    </div>

                                    <a href="{{ route('wallet.transaction.receipt', $txn->id) }}" 
                                       target="_blank"
                                       title="Download Official PDF Receipt"
                                       class="p-1.5 sm:p-2 rounded-lg sm:rounded-xl bg-gray-100 hover:bg-rose-700 hover:text-white text-gray-600 transition-all shrink-0 shadow-2xs group">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    </a>
                                </div>

                            </div>
                        @empty
                            <div class="p-12 text-center space-y-3">
                                <div class="w-16 h-16 rounded-full bg-rose-50 flex items-center justify-center mx-auto text-rose-500">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <h4 class="text-base font-bold text-gray-700 font-serif">No Debit Transactions Found</h4>
                                <p class="text-xs text-gray-500 max-w-sm mx-auto">You have not spent any wallet credits on matrimonial services yet or no records match your search filter.</p>
                                <a href="{{ route('search') }}" class="mt-2 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white text-xs font-bold shadow hover:shadow-md transition-all">
                                    Explore Matches & Services
                                </a>
                            </div>
                        @endforelse
                    </div>

                </div>

                <!-- Pagination -->
                @if($debitTransactions->hasPages())
                    <div class="mt-4">
                        {{ $debitTransactions->links() }}
                    </div>
                @endif

            </div>

        </div>

    </div>
</div>
@endsection
