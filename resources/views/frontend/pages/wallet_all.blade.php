@extends('frontend.layouts.auth_app')

@section('title', 'All Transactions History & Invoices | Rani Matrimonial')

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
            
            <!-- Royal Accent Top Bar -->
            <div class="absolute top-0 left-0 w-full h-2 sm:h-2.5 bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-95"></div>
            
            <!-- Page Header -->
            <div class="px-3 sm:px-6 md:px-10 pt-4 sm:pt-8 pb-3 sm:pb-5 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-3 sm:gap-4">
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-xl sm:rounded-2xl bg-gradient-to-br from-rani-primary to-rani-primary-dark flex items-center justify-center text-rani-gold shadow-xs shrink-0">
                        <svg class="w-4 h-4 sm:w-6 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-1.5 sm:gap-2">
                            <h1 class="text-base sm:text-2xl md:text-3xl font-bold font-serif text-gray-900 tracking-wide">All Transactions</h1>
                            <span class="px-2 py-0.5 rounded-full text-[9px] sm:text-[11px] font-extrabold bg-rani-primary/10 text-rani-primary border border-rani-primary/20">
                                Statement
                            </span>
                        </div>
                        <p class="text-[10px] sm:text-xs text-gray-500 font-sans mt-0.5 line-clamp-1 sm:line-clamp-none">Comprehensive audit log of all deposits & deductions</p>
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
                    
                    <!-- Metric 1: Available Balance -->
                    <div class="p-2.5 sm:p-4 md:p-5 rounded-xl sm:rounded-2xl bg-gradient-to-br from-amber-50 to-white border border-amber-200/80 shadow-2xs flex flex-col justify-between">
                        <div class="flex items-center justify-between">
                            <p class="text-[9px] xs:text-[10px] sm:text-xs font-bold text-gray-600 uppercase tracking-tight sm:tracking-wider truncate">Balance</p>
                            <div class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-gradient-to-br from-rani-gold to-yellow-500 text-rani-dark hidden sm:flex items-center justify-center shadow-xs shrink-0">
                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                        </div>
                        <h3 class="text-xs xs:text-sm sm:text-xl md:text-2xl font-extrabold sm:font-bold font-serif text-rani-primary-dark mt-1 truncate">₹ {{ number_format($wallet->avl_balance, 2) }}</h3>
                        <p class="text-[10px] sm:text-[11px] text-gray-400 font-sans mt-0.5 hidden sm:block">Active spendable</p>
                    </div>

                    <!-- Metric 2: Total Credits -->
                    <a href="{{ route('wallet.credit') }}" class="p-2.5 sm:p-4 md:p-5 rounded-xl sm:rounded-2xl bg-gradient-to-br from-emerald-50 to-white border border-emerald-200/80 shadow-2xs flex flex-col justify-between hover:shadow-md transition-all group">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-1 min-w-0">
                                <p class="text-[9px] xs:text-[10px] sm:text-xs font-bold text-emerald-800 uppercase tracking-tight sm:tracking-wider truncate">Credits (+)</p>
                                <span class="text-[10px] text-emerald-600 font-bold group-hover:translate-x-0.5 transition-transform hidden xs:inline">→</span>
                            </div>
                            <div class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-emerald-500 text-white hidden sm:flex items-center justify-center shadow-xs shrink-0">
                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                            </div>
                        </div>
                        <h3 class="text-xs xs:text-sm sm:text-xl md:text-2xl font-extrabold sm:font-bold font-serif text-emerald-700 mt-1 truncate">+ ₹ {{ number_format($totalCredit, 2) }}</h3>
                        <p class="text-[10px] sm:text-[11px] text-gray-400 font-sans mt-0.5 hidden sm:block">Total deposits</p>
                    </a>

                    <!-- Metric 3: Total Debits -->
                    <a href="{{ route('wallet.debit') }}" class="p-2.5 sm:p-4 md:p-5 rounded-xl sm:rounded-2xl bg-gradient-to-br from-rose-50 to-white border border-rose-200/80 shadow-2xs flex flex-col justify-between hover:shadow-md transition-all group">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-1 min-w-0">
                                <p class="text-[9px] xs:text-[10px] sm:text-xs font-bold text-rose-800 uppercase tracking-tight sm:tracking-wider truncate">Debits (-)</p>
                                <span class="text-[10px] text-rose-600 font-bold group-hover:translate-x-0.5 transition-transform hidden xs:inline">→</span>
                            </div>
                            <div class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-rose-600 text-white hidden sm:flex items-center justify-center shadow-xs shrink-0">
                                <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                            </div>
                        </div>
                        <h3 class="text-xs xs:text-sm sm:text-xl md:text-2xl font-extrabold sm:font-bold font-serif text-rose-700 mt-1 truncate">- ₹ {{ number_format($totalDebit, 2) }}</h3>
                        <p class="text-[10px] sm:text-[11px] text-gray-400 font-sans mt-0.5 hidden sm:block">Total deductions</p>
                    </a>

                </div>

                <!-- Search Filter Form -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 bg-gray-50/80 p-2 sm:p-3 rounded-xl sm:rounded-2xl border border-gray-200/70">
                    <form method="GET" action="{{ route('wallet.all') }}" class="relative flex-1">
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}" 
                               placeholder="Search transaction ID, title, mode..." 
                               class="w-full pl-8 sm:pl-9 pr-20 sm:pr-24 py-1.5 sm:py-2 text-xs sm:text-sm rounded-lg sm:rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-rani-primary bg-white shadow-2xs">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-gray-400 absolute left-2.5 sm:left-3 top-2 sm:top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <button type="submit" class="absolute right-1 top-1 sm:right-1.5 sm:top-1 px-2.5 sm:px-3 py-1 sm:py-1.5 bg-rani-primary hover:bg-rani-primary-dark text-white rounded-md sm:rounded-lg text-[11px] sm:text-xs font-bold transition-colors">
                            Search
                        </button>
                    </form>
                    @if(request('search'))
                        <a href="{{ route('wallet.all') }}" class="px-2.5 py-1.5 sm:px-3 sm:py-2 text-[11px] sm:text-xs font-bold text-gray-500 hover:text-red-600 bg-white border border-gray-200 rounded-lg sm:rounded-xl transition-colors text-center">
                            Clear Filter
                        </a>
                    @endif
                </div>

                <!-- Transactions List -->
                <div class="overflow-hidden rounded-2xl border border-gray-200 shadow-sm bg-white">
                    
                    <!-- Table Header (Desktop) -->
                    <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-3.5 bg-gray-50/90 border-b border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider">
                        <div class="col-span-5">Transaction Details</div>
                        <div class="col-span-2 text-center">Category / Mode</div>
                        <div class="col-span-2 text-center">Status</div>
                        <div class="col-span-2 text-right">Amount</div>
                        <div class="col-span-1 text-center">Invoice</div>
                    </div>

                    <!-- Transactions Rows -->
                    <div class="divide-y divide-gray-100">
                        @forelse($allTransactions as $txn)
                            <div class="p-3 sm:px-5 sm:py-3.5 transition-colors hover:bg-gray-50/80 flex items-center justify-between gap-2.5 sm:gap-4">
                                
                                <!-- Left: Type Icon + Title + Meta -->
                                <div class="flex items-center gap-2.5 sm:gap-3.5 min-w-0 flex-1">
                                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl flex items-center justify-center shrink-0 shadow-2xs {{ $txn->type === 'credit' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-rose-100 text-rose-700 border border-rose-200' }}">
                                        @if($txn->type === 'credit')
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                                        @else
                                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                                        @endif
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-1.5 flex-wrap">
                                            <h4 class="text-xs sm:text-sm font-bold text-gray-900 truncate max-w-[140px] xs:max-w-[200px] sm:max-w-none">{{ $txn->title }}</h4>
                                            <span class="inline-block px-1.5 py-0.2 rounded text-[9px] sm:text-[10px] font-semibold bg-gray-100 text-gray-600">
                                                {{ $txn->category ?? ($txn->type === 'credit' ? 'Recharge' : 'Service') }}
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
                                        <div class="text-xs sm:text-sm md:text-base font-extrabold font-mono {{ $txn->type === 'credit' ? 'text-emerald-600' : 'text-rose-600' }} whitespace-nowrap">
                                            {{ $txn->type === 'credit' ? '+ ' : '- ' }}₹ {{ number_format($txn->amount, 2) }}
                                        </div>
                                        <div class="text-[9px] sm:text-[10px] text-gray-400 font-mono whitespace-nowrap">
                                            Bal: ₹ {{ number_format($txn->balance_after, 2) }}
                                        </div>
                                    </div>

                                    <a href="{{ route('wallet.transaction.receipt', $txn->id) }}" 
                                       target="_blank"
                                       title="Download Official PDF Receipt"
                                       class="p-1.5 sm:p-2 rounded-lg sm:rounded-xl bg-gray-100 hover:bg-rani-primary hover:text-white text-gray-600 transition-all shrink-0 shadow-2xs group">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 transition-transform group-hover:scale-110" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    </a>
                                </div>

                            </div>
                        @empty
                            <div class="p-12 text-center space-y-3">
                                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto text-gray-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                </div>
                                <h4 class="text-base font-bold text-gray-700 font-serif">No Transactions Found</h4>
                                <p class="text-xs text-gray-500 max-w-sm mx-auto">There are no wallet transactions on your account yet or no records match your search filter.</p>
                                <a href="{{ route('wallet', ['tab' => 'recharge']) }}" class="mt-2 inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white text-xs font-bold shadow hover:shadow-md transition-all">
                                    Recharge Wallet Now
                                </a>
                            </div>
                        @endforelse
                    </div>

                </div>

                <!-- Pagination -->
                @if($allTransactions->hasPages())
                    <div class="mt-4">
                        {{ $allTransactions->links() }}
                    </div>
                @endif

            </div>

        </div>

    </div>
</div>
@endsection
