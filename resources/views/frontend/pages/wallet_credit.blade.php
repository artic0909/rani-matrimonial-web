@extends('frontend.layouts.auth_app')

@section('title', 'Credit Transactions & Deposit History | Rani Matrimonial')

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
            
            <!-- Emerald & Gold Accent Top Bar -->
            <div class="absolute top-0 left-0 w-full h-2 sm:h-2.5 bg-gradient-to-r from-emerald-500 via-teal-600 to-rani-gold opacity-95"></div>
            
            <!-- Page Header -->
            <div class="px-3 sm:px-6 md:px-10 pt-4 sm:pt-8 pb-3 sm:pb-5 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-3 sm:gap-4">
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-700 flex items-center justify-center text-white shadow-xs shrink-0">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5 sm:gap-2">
                            <h1 class="text-base sm:text-2xl md:text-3xl font-bold font-serif text-gray-900 tracking-wide">Credit History</h1>
                            <span class="px-2 py-0.5 rounded-full text-[9px] sm:text-[11px] font-extrabold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                Deposits
                            </span>
                        </div>
                        <p class="text-[10px] sm:text-xs text-gray-500 font-sans mt-0.5 line-clamp-1 sm:line-clamp-none">All funds credited to your Royal Privilege Card</p>
                    </div>
                </div>

                <div class="flex items-center gap-2 sm:gap-3 self-start md:self-auto">
                    <a href="{{ route('wallet', ['tab' => 'recharge']) }}" class="inline-flex items-center gap-1.5 sm:gap-2 px-3 py-1.5 sm:px-4 sm:py-2.5 rounded-lg sm:rounded-xl bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white text-[11px] sm:text-sm font-bold shadow-xs hover:shadow-md transition-all">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        <span>Recharge</span>
                    </a>
                    <a href="{{ route('wallet') }}" class="inline-flex items-center gap-1 sm:gap-1.5 px-2.5 py-1.5 sm:px-3.5 sm:py-2.5 rounded-lg sm:rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 text-[11px] sm:text-sm font-semibold transition-all">
                        <span>Overview</span>
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>

            <div class="p-3 sm:p-6 md:p-10 space-y-3 sm:space-y-6 md:space-y-8">

                <!-- Summary Metrics Bar (Compact 3-Column on Mobile & Desktop) -->
                <div class="grid grid-cols-3 gap-2 sm:gap-4">
                    
                    <!-- Metric 1: Total Credits -->
                    <div class="p-2.5 sm:p-4 md:p-5 rounded-xl sm:rounded-2xl bg-gradient-to-br from-emerald-50 to-white border border-emerald-200/80 shadow-2xs flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <p class="text-[9px] xs:text-[10px] sm:text-xs font-bold text-emerald-800 uppercase tracking-tight sm:tracking-wider truncate">Credited</p>
                            <div class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-emerald-500 text-white hidden sm:flex items-center justify-center shadow-xs shrink-0">
                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                            </div>
                        </div>
                        <h3 class="text-xs xs:text-sm sm:text-xl md:text-2xl font-extrabold sm:font-bold font-serif text-emerald-700 mt-1 truncate">+ ₹ {{ number_format($totalCredit, 2) }}</h3>
                        <p class="text-[10px] sm:text-[11px] text-gray-400 font-sans mt-0.5 hidden sm:block">Lifetime additions</p>
                    </div>

                    <!-- Metric 2: Available Balance -->
                    <div class="p-2.5 sm:p-4 md:p-5 rounded-xl sm:rounded-2xl bg-gradient-to-br from-amber-50 to-white border border-amber-200/80 shadow-2xs flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <p class="text-[9px] xs:text-[10px] sm:text-xs font-bold text-gray-600 uppercase tracking-tight sm:tracking-wider truncate">Balance</p>
                            <div class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-gradient-to-br from-rani-gold to-yellow-500 text-rani-dark hidden sm:flex items-center justify-center shadow-xs shrink-0">
                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            </div>
                        </div>
                        <h3 class="text-xs xs:text-sm sm:text-xl md:text-2xl font-extrabold sm:font-bold font-serif text-rani-primary-dark mt-1 truncate">₹ {{ number_format($wallet->avl_balance, 2) }}</h3>
                        <p class="text-[10px] sm:text-[11px] text-gray-400 font-sans mt-0.5 hidden sm:block">Spendable funds</p>
                    </div>

                    <!-- Metric 3: Total Credit Transactions Count -->
                    <div class="p-2.5 sm:p-4 md:p-5 rounded-xl sm:rounded-2xl bg-gradient-to-br from-slate-50 to-white border border-slate-200 shadow-2xs flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <p class="text-[9px] xs:text-[10px] sm:text-xs font-bold text-gray-500 uppercase tracking-tight sm:tracking-wider truncate">Records</p>
                            <div class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-slate-100 text-gray-600 hidden sm:flex items-center justify-center shadow-xs shrink-0">
                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                        </div>
                        <h3 class="text-xs xs:text-sm sm:text-xl md:text-2xl font-extrabold sm:font-bold font-serif text-gray-800 mt-1 truncate">{{ $creditTransactions->total() }} Txns</h3>
                        <p class="text-[10px] sm:text-[11px] text-gray-400 font-sans mt-0.5 hidden sm:block">Receipts available</p>
                    </div>

                </div>

                <!-- Search Filter Form -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 bg-gray-50/80 p-2 sm:p-3 rounded-xl sm:rounded-2xl border border-gray-200/70">
                    <form method="GET" action="{{ route('wallet.credit') }}" class="relative flex-1">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Search transaction ID, method..." 
                               class="w-full pl-8 sm:pl-9 pr-20 sm:pr-24 py-1.5 sm:py-2 text-xs sm:text-sm rounded-lg sm:rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-emerald-500 bg-white shadow-2xs">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 absolute left-2.5 sm:left-3 top-2 sm:top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <button type="submit" class="absolute right-1 top-1 sm:right-1.5 sm:top-1 px-2.5 sm:px-3 py-1 sm:py-1.5 bg-emerald-600 hover:bg-emerald-700 text-white rounded-md sm:rounded-lg text-[11px] sm:text-xs font-bold transition-colors">
                            Search
                        </button>
                    </form>
                    @if(request('search'))
                        <a href="{{ route('wallet.credit') }}" class="px-2.5 py-1.5 sm:px-3 sm:py-2 text-[11px] sm:text-xs font-bold text-gray-500 hover:text-red-600 bg-white border border-gray-200 rounded-lg sm:rounded-xl transition-colors text-center">
                            Clear Filter
                        </a>
                    @endif
                </div>

                <!-- Credit Transactions List -->
                <div class="overflow-hidden rounded-2xl border border-gray-200 shadow-sm bg-white">
                    
                    <!-- Table Header (Desktop) -->
                    <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-3.5 bg-gray-50/90 border-b border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider">
                        <div class="col-span-5">Credit Details & Reference</div>
                        <div class="col-span-2 text-center">Payment Gateway</div>
                        <div class="col-span-2 text-center">Status</div>
                        <div class="col-span-2 text-right">Amount Credited</div>
                        <div class="col-span-1 text-center">Invoice</div>
                    </div>

                    <!-- Transactions Rows -->
                    <div class="divide-y divide-gray-100">
                        @forelse($creditTransactions as $txn)
                            <div class="p-3 sm:px-5 sm:py-3.5 transition-colors hover:bg-emerald-50/40 flex items-center justify-between gap-2.5 sm:gap-4">
                                
                                <!-- Left: Type Icon + Title + Meta -->
                                <div class="flex items-center gap-2.5 sm:gap-3.5 min-w-0 flex-1">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl bg-emerald-100 text-emerald-700 border border-emerald-200 flex items-center justify-center shrink-0 shadow-2xs">
                                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            <h4 class="text-xs sm:text-sm font-bold text-gray-900 truncate max-w-[140px] xs:max-w-[200px] sm:max-w-none">{{ $txn->title }}</h4>
                                            <span class="inline-block px-1.5 py-0.2 rounded text-[9px] sm:text-[10px] font-semibold bg-emerald-50 text-emerald-800 border border-emerald-100">
                                                {{ $txn->payment_method ?? 'Razorpay' }}
                                            </span>
                                        </div>
                                        <div class="flex items-center gap-1.5 text-[10px] sm:text-[11px] text-gray-400 mt-0.5">
                                            <span class="font-mono text-gray-500 font-semibold">#{{ $txn->transaction_id }}</span>
                                            <span>•</span>
                                            <span class="whitespace-nowrap">{{ $txn->created_at->format('d M, h:i A') }}</span>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right: Amount + Balance + Download Button -->
                                <div class="flex items-center gap-2 sm:gap-4 shrink-0 text-right">
                                    <div>
                                        <div class="text-xs sm:text-sm md:text-base font-extrabold font-mono text-emerald-600 whitespace-nowrap">
                                            + ₹ {{ number_format($txn->amount, 2) }}
                                        </div>
                                        <div class="text-[9px] sm:text-[10px] text-gray-400 font-mono whitespace-nowrap">
                                            Bal: ₹ {{ number_format($txn->balance_after, 2) }}
                                        </div>
                                    </div>

                                    <a href="{{ route('wallet.transaction.receipt', $txn->id) }}" 
                                       target="_blank"
                                       title="Download Official PDF Receipt"
                                       class="p-1.5 sm:p-2 rounded-lg sm:rounded-xl bg-gray-100 hover:bg-emerald-600 hover:text-white text-gray-600 transition-all shrink-0 shadow-2xs group">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    </a>
                                </div>

                            </div>
                        @empty
                            <div class="p-12 text-center space-y-3">
                                <div class="w-16 h-16 rounded-full bg-emerald-50 flex items-center justify-center mx-auto text-emerald-500">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <h4 class="text-base font-bold text-gray-700 font-serif">No Credit Transactions Found</h4>
                                <p class="text-xs text-gray-500 max-w-sm mx-auto">You have not added any funds to your wallet yet or no transactions match your search filter.</p>
                                <a href="{{ route('wallet', ['tab' => 'recharge']) }}" class="mt-2 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white text-xs font-bold shadow hover:shadow-md transition-all">
                                    Recharge Wallet Now
                                </a>
                            </div>
                        @endforelse
                    </div>

                </div>

                <!-- Pagination -->
                @if($creditTransactions->hasPages())
                    <div class="mt-4">
                        {{ $creditTransactions->links() }}
                    </div>
                @endif

            </div>

        </div>

    </div>
</div>
@endsection
