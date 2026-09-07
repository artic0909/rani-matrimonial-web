@extends('frontend.layouts.auth_app')

@section('title', 'My Wallet & Royal Privilege Card | Ranimatrimonial')

@section('content')
<div class="relative pt-6 pb-20" x-data="walletManager({
    avlBalance: {{ (float) $wallet->avl_balance }},
    totalCredit: {{ (float) $totalCredit }},
    totalDebit: {{ (float) $totalDebit }},
    transactions: @js($allTransactions)
})">
    <!-- Background Image -->
    <div class="fixed inset-0 z-0 bg-cover bg-top bg-no-repeat" style="background-image: url('{{ asset('img/hero.png') }}');"></div>
    
    <!-- Maroon/Gold Gradient Overlay -->
    <div class="fixed inset-0 z-0 bg-gradient-to-t from-rani-dark/85 via-rani-primary-dark/45 to-rani-primary-dark/25"></div>
    
    <!-- Floating Sweet Gestures (Hearts) -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none heart-container opacity-40">
        <div class="heart-floating delay-1"></div>
        <div class="heart-floating heart-maroon delay-2"></div>
        <div class="heart-floating delay-3"></div>
        <div class="heart-floating heart-maroon delay-4"></div>
        <div class="heart-floating delay-5"></div>
        <div class="heart-floating heart-maroon delay-1" style="left: 25%; animation-delay: 7s;"></div>
        <div class="heart-floating delay-3" style="left: 65%; animation-delay: 3s;"></div>
    </div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Main Card Container -->
        <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl border border-white/60 mb-10 overflow-hidden relative z-10">
            
            <!-- Royal accent top bar -->
            <div class="absolute top-0 left-0 w-full h-2.5 bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-95"></div>
            
            <!-- Page Header -->
            <div class="px-6 md:px-10 pt-8 pb-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-rani-primary to-rani-primary-dark flex items-center justify-center text-rani-gold shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold font-serif text-rani-primary-dark tracking-wide">My Wallet</h1>
                            <!-- <p class="text-xs text-gray-500 font-sans mt-0.5">Your exclusive matrimonial privilege card & digital balance</p> -->
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-6 md:p-10 space-y-10">

                <!-- ================= SECTION 1: CREDIT CARD & QUICK STATS ================= -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center">
                    
                    <!-- Left: Authentic Rani Matrimonial Credit Card UI -->
                    <div class="lg:col-span-7 flex justify-center">
                        <div class="w-full max-w-[480px]">
                            <!-- The Card Container with 3D shadow & subtle tilt -->
                            <div class="group relative aspect-[1.586/1] w-full rounded-2xl md:rounded-3xl p-6 md:p-7 text-white shadow-2xl overflow-hidden transition-all duration-500 hover:shadow-[0_20px_50px_rgba(117,0,0,0.45)] hover:-translate-y-1 border border-rani-gold/60 select-none"
                                 style="background: radial-gradient(circle at 10% 20%, #7d0000 0%, #4a0004 50%, #1d0003 100%);">
                                
                                <!-- Background Royal Mandala Watermark -->
                                <div class="absolute -right-16 -bottom-16 w-64 h-64 opacity-15 pointer-events-none rounded-full border-[18px] border-dashed border-rani-gold"></div>
                                <div class="absolute right-8 bottom-8 w-40 h-40 opacity-10 pointer-events-none rounded-full border-[6px] border-rani-gold"></div>

                                <!-- Metallic Glare / Shimmer Effect -->
                                <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/10 to-transparent pointer-events-none opacity-60 group-hover:opacity-90 transition-opacity"></div>
                                
                                <!-- Card Inner Content -->
                                <div class="relative z-10 flex flex-col justify-between h-full">
                                    
                                    <!-- Card Header (Brand + Contactless Icon) -->
                                    <div class="flex justify-between items-start">
                                        <div class="flex items-center gap-2">
                                            <div>
                                                <div class="flex items-baseline">
                                                    <span class="text-base md:text-lg font-serif italic font-bold text-white tracking-wide">Rani</span>
                                                    <span class="text-[10px] md:text-xs font-serif text-rani-gold tracking-widest ml-1 uppercase">matrimonial</span>
                                                </div>
                                                <p class="text-[8px] md:text-[9px] uppercase tracking-[0.2em] text-rani-gold/90 font-mono font-semibold">Privilege Card</p>
                                            </div>
                                        </div>

                                        <!-- Contactless Wave & Card Tier Badge -->
                                        <div class="flex items-center gap-2">
                                            <span class="px-2 py-0.5 rounded-md bg-gradient-to-r from-rani-gold to-yellow-500 text-rani-dark text-[9px] md:text-[10px] font-extrabold uppercase tracking-wider shadow">
                                             VIP
                                            </span>
                                            <svg class="w-5 h-5 md:w-6 md:h-6 text-rani-gold/90 transform rotate-90" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.393 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Middle Row: Realistic Gold EMV Smart Chip -->
                                    <div class="my-auto flex items-center justify-between pt-2">
                                        <div class="relative w-11 h-8 md:w-13 md:h-9 rounded-md bg-gradient-to-br from-amber-200 via-yellow-400 to-amber-600 p-[1.5px] shadow-md border border-yellow-200/80">
                                            <!-- Chip Grid Circuit Lines -->
                                            <div class="w-full h-full rounded-[3px] border border-amber-700/40 grid grid-cols-3 grid-rows-2 gap-[2px] p-[2px] opacity-80">
                                                <div class="border-r border-b border-amber-800/40 rounded-tl-[2px]"></div>
                                                <div class="border-r border-b border-amber-800/40"></div>
                                                <div class="border-b border-amber-800/40 rounded-tr-[2px]"></div>
                                                <div class="border-r border-amber-800/40 rounded-bl-[2px]"></div>
                                                <div class="border-r border-amber-800/40"></div>
                                                <div class="rounded-br-[2px]"></div>
                                            </div>
                                        </div>

                                        <!-- Available Balance Tag on Card -->
                                        <div class="text-right">
                                            <p class="text-[9px] md:text-[10px] uppercase text-gray-300 font-sans tracking-wider">Card Balance</p>
                                            <p class="text-lg md:text-2xl font-bold font-serif text-white tracking-wide text-shadow" x-text="formatCurrency(avlBalance)"></p>
                                        </div>
                                    </div>

                                    <!-- Card Number (Embossed Monospace Look) -->
                                    <div class="mt-2 flex items-center justify-between">
                                        <div class="flex items-center gap-2">
                                            <p class="font-mono text-base md:text-xl font-bold tracking-[0.18em] text-white/95 drop-shadow-md">
                                                {{ $wallet->formatted_card_number }}
                                            </p>
                                            <button @click="copyCardNumber('{{ $wallet->wallet_id }}')" 
                                                    type="button" 
                                                    title="Copy Card Number"
                                                    class="p-1 rounded-md bg-white/10 hover:bg-white/25 text-rani-gold transition-colors">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Card Footer: Cardholder Name, Candidate RM ID, Expiry & Hologram Seal -->
                                    <div class="flex justify-between items-end pt-2 border-t border-white/15">
                                        <div>
                                            <p class="text-[8px] md:text-[9px] uppercase tracking-widest text-rani-gold/80 font-mono">Cardholder / ID</p>
                                            <p class="text-xs md:text-sm font-bold uppercase tracking-wider text-white truncate max-w-[190px] md:max-w-[220px]">
                                                {{ $candidate->first_name }} {{ $candidate->last_name }}
                                            </p>
                                            <p class="text-[10px] md:text-xs font-mono text-gray-300 font-semibold tracking-wide">
                                                ID: {{ $candidate->candidate_code ?? ('RM' . str_pad($candidate->id, 5, '0', STR_PAD_LEFT)) }}
                                            </p>
                                        </div>

                                        <div class="text-right flex items-center gap-3">

                                            <!-- Holographic Gold Seal Emblem -->
                                            <div class="w-9 h-9 md:w-11 md:h-11 rounded-full bg-gradient-to-tr from-yellow-600 via-yellow-200 to-amber-500 p-[1.5px] shadow-lg flex items-center justify-center">
                                                <div class="w-full h-full rounded-full bg-rani-primary-dark/80 flex flex-col items-center justify-center text-[7px] font-bold text-rani-gold tracking-tighter">
                                                    <img src="{{ asset('logo.png') }}" alt="Rani" class="h-8 md:h-10 w-auto rounded-full border border-rani-gold/80 shadow-md">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Wallet Quick Overview & Privileges -->
                    <div class="lg:col-span-5 space-y-4">
                        <div class="bg-gradient-to-br from-rani-light/40 via-white to-rani-light/20 p-6 rounded-3xl border border-rani-gold/30 shadow-sm space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Wallet Account</span>
                                <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Active & Verified
                                </span>
                            </div>

                            <div>
                                <p class="text-xs text-gray-500 font-medium">Available Balance</p>
                                <div class="flex items-baseline gap-2">
                                    <h2 class="text-3xl md:text-4xl font-extrabold font-serif text-rani-primary-dark tracking-tight" x-text="formatCurrency(avlBalance)"></h2>
                                    <span class="text-xs text-gray-400 uppercase font-semibold">INR</span>
                                </div>
                            </div>

                            <!-- Privilege perks list -->
                            <div class="pt-3 border-t border-gray-100 space-y-2.5">
                                <p class="text-xs font-bold text-gray-700 uppercase tracking-wide">Privilege Card Benefits:</p>
                                <div class="grid grid-cols-1 gap-2 text-xs text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-rani-gold shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        <span>Instant verified contact number unlocks</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-rani-gold shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        <span>Highlight profile to top matched brides / grooms</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <svg class="w-4 h-4 text-rani-gold shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        <span>100% secure automated matchmaking checkout</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Action Buttons -->
                            <div class="pt-2 flex gap-3">
                                <button @click="openAddMoneyModal = true" 
                                        type="button" 
                                        class="flex-1 py-3 px-4 rounded-xl bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white text-xs md:text-sm font-bold shadow-md hover:shadow-lg transition-all text-center">
                                    Recharge Wallet
                                </button>
                                <button @click="quickAdd(500)" 
                                        type="button" 
                                        class="py-3 px-3 rounded-xl bg-rani-gold-light/60 hover:bg-rani-gold-light text-rani-primary-dark border border-rani-gold/40 text-xs font-bold transition-all">
                                    + ₹500 Quick
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ================= SECTION 2: TOTAL STATS COUNTERS ================= -->
                <div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
                        
                        <!-- Card 1: Available Balance -->
                        <div class="p-5 rounded-2xl bg-gradient-to-br from-amber-50/80 to-white border border-amber-200/80 shadow-sm flex items-center gap-4 transition-all hover:shadow-md">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-rani-gold to-yellow-500 text-rani-dark flex items-center justify-center shadow-md shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Available Balance</p>
                                <h3 class="text-xl md:text-2xl font-bold font-serif text-gray-800" x-text="formatCurrency(avlBalance)"></h3>
                                <p class="text-[11px] text-gray-400 font-sans">Current spendable funds</p>
                            </div>
                        </div>

                        <!-- Card 2: Total Credit (Green/Upward) -->
                        <div class="p-5 rounded-2xl bg-gradient-to-br from-emerald-50/80 to-white border border-emerald-200/80 shadow-sm flex items-center gap-4 transition-all hover:shadow-md">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-500 to-teal-600 text-white flex items-center justify-center shadow-md shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-emerald-700 uppercase tracking-wider">Total Credits (+)</p>
                                <h3 class="text-xl md:text-2xl font-bold font-serif text-emerald-700" x-text="'+ ' + formatCurrency(totalCredit)"></h3>
                                <p class="text-[11px] text-gray-400 font-sans">Total money credited</p>
                            </div>
                        </div>

                        <!-- Card 3: Total Debit (Ruby/Downward) -->
                        <div class="p-5 rounded-2xl bg-gradient-to-br from-rose-50/80 to-white border border-rose-200/80 shadow-sm flex items-center gap-4 transition-all hover:shadow-md">
                            <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-rose-600 to-red-700 text-white flex items-center justify-center shadow-md shrink-0">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                            </div>
                            <div>
                                <p class="text-xs font-semibold text-rose-700 uppercase tracking-wider">Total Debits (-)</p>
                                <h3 class="text-xl md:text-2xl font-bold font-serif text-rose-700" x-text="'- ' + formatCurrency(totalDebit)"></h3>
                                <p class="text-[11px] text-gray-400 font-sans">Total spent on services</p>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- ================= SECTION 3: TRANSACTION TABS & LIST ================= -->
                <div class="space-y-6 pt-4">
                    
                    <!-- Tabs Header & Search Filter -->
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 border-b border-gray-200 pb-4">
                        
                        <!-- Navigation Tabs (All, Credit, Debit) -->
                        <div class="flex items-center space-x-2 bg-gray-100/90 p-1.5 rounded-2xl border border-gray-200/70 self-start">
                            <!-- Tab: All -->
                            <button type="button" 
                                    @click="activeTab = 'all'" 
                                    :class="activeTab === 'all' ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white shadow-md font-bold' : 'text-gray-600 hover:text-rani-primary font-medium'"
                                    class="px-5 py-2 rounded-xl text-xs md:text-sm transition-all duration-300 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                                <span>All History</span>
                                <span class="px-2 py-0.2 rounded-full text-[10px]" :class="activeTab === 'all' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700'" x-text="filteredTransactions.length"></span>
                            </button>

                            <!-- Tab: Credits -->
                            <button type="button" 
                                    @click="activeTab = 'credit'" 
                                    :class="activeTab === 'credit' ? 'bg-gradient-to-r from-emerald-600 to-teal-700 text-white shadow-md font-bold' : 'text-gray-600 hover:text-emerald-700 font-medium'"
                                    class="px-5 py-2 rounded-xl text-xs md:text-sm transition-all duration-300 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                                <span>Credits (+)</span>
                                <span class="px-2 py-0.2 rounded-full text-[10px]" :class="activeTab === 'credit' ? 'bg-white/20 text-white' : 'bg-emerald-100 text-emerald-800'" x-text="creditCount"></span>
                            </button>

                            <!-- Tab: Debits -->
                            <button type="button" 
                                    @click="activeTab = 'debit'" 
                                    :class="activeTab === 'debit' ? 'bg-gradient-to-r from-rose-700 to-red-800 text-white shadow-md font-bold' : 'text-gray-600 hover:text-rose-700 font-medium'"
                                    class="px-5 py-2 rounded-xl text-xs md:text-sm transition-all duration-300 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                                <span>Debits (-)</span>
                                <span class="px-2 py-0.2 rounded-full text-[10px]" :class="activeTab === 'debit' ? 'bg-white/20 text-white' : 'bg-rose-100 text-rose-800'" x-text="debitCount"></span>
                            </button>
                        </div>

                        <!-- Search Filter -->
                        <div class="relative w-full md:w-64">
                            <input type="text" 
                                   x-model="searchQuery" 
                                   placeholder="Search by title, ID..." 
                                   class="w-full pl-9 pr-4 py-2 text-xs md:text-sm rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-rani-gold focus:border-transparent bg-white shadow-sm">
                            <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>

                    </div>

                    <!-- Transactions Feed / Table -->
                    <div class="overflow-hidden rounded-2xl border border-gray-200/80 shadow-sm bg-white">
                        
                        <!-- Desktop Header -->
                        <div class="hidden md:grid grid-cols-12 gap-4 px-6 py-3.5 bg-gray-50/90 border-b border-gray-200 text-xs font-bold text-gray-500 uppercase tracking-wider">
                            <div class="col-span-5">Transaction Details</div>
                            <div class="col-span-2 text-center">Category</div>
                            <div class="col-span-2 text-center">Payment Method</div>
                            <div class="col-span-3 text-right">Amount & Status</div>
                        </div>

                        <!-- Transactions List -->
                        <div class="divide-y divide-gray-100">
                            <template x-for="txn in displayedTransactions" :key="txn.id">
                                <div class="p-4 md:px-6 md:py-4 transition-colors hover:bg-gray-50/80 flex flex-col md:grid md:grid-cols-12 md:gap-4 items-start md:items-center">
                                    
                                    <!-- Col 1: Icon, Title, Transaction ID, Date -->
                                    <div class="col-span-5 flex items-center gap-3.5 w-full">
                                        <!-- Type Icon Circle -->
                                        <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0 shadow-xs"
                                             :class="txn.type === 'credit' ? 'bg-emerald-100 text-emerald-700 border border-emerald-200' : 'bg-rose-100 text-rose-700 border border-rose-200'">
                                            <template x-if="txn.type === 'credit'">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                                            </template>
                                            <template x-if="txn.type === 'debit'">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                                            </template>
                                        </div>

                                        <div class="min-w-0 flex-1">
                                            <h4 class="text-sm font-bold text-gray-800 truncate" x-text="txn.title"></h4>
                                            <p class="text-xs text-gray-500 truncate" x-show="txn.description" x-text="txn.description"></p>
                                            <div class="flex items-center gap-2 mt-0.5">
                                                <span class="font-mono text-[11px] text-gray-400 font-medium" x-text="txn.transaction_id"></span>
                                                <span class="text-gray-300">•</span>
                                                <span class="text-[11px] text-gray-400" x-text="formatDate(txn.created_at || txn.created_at_formatted)"></span>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Col 2: Category Badge -->
                                    <div class="col-span-2 text-left md:text-center mt-2 md:mt-0">
                                        <span class="inline-block px-2.5 py-1 rounded-full text-[11px] font-semibold bg-gray-100 text-gray-700 border border-gray-200/80" x-text="txn.category || 'General'"></span>
                                    </div>

                                    <!-- Col 3: Payment Method -->
                                    <div class="col-span-2 text-left md:text-center mt-1 md:mt-0">
                                        <span class="text-xs font-medium text-gray-600 flex items-center md:justify-center gap-1">
                                            <svg class="w-3.5 h-3.5 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                                            <span x-text="txn.payment_method || 'Wallet'"></span>
                                        </span>
                                    </div>

                                    <!-- Col 4: Amount & Status -->
                                    <div class="col-span-3 text-left md:text-right mt-3 md:mt-0 w-full md:w-auto flex md:flex-col justify-between md:justify-center items-center md:items-end">
                                        <div class="text-sm md:text-base font-extrabold font-mono"
                                             :class="txn.type === 'credit' ? 'text-emerald-600' : 'text-rose-600'"
                                             x-text="(txn.type === 'credit' ? '+ ' : '- ') + formatCurrency(txn.amount)">
                                        </div>
                                        <div class="flex items-center gap-2 mt-0.5">
                                            <span class="text-[10px] text-gray-400 font-mono" x-text="'Bal: ' + formatCurrency(txn.balance_after)"></span>
                                            <span class="px-2 py-0.5 rounded-md text-[10px] font-bold uppercase"
                                                  :class="txn.status === 'completed' ? 'bg-emerald-50 text-emerald-700 border border-emerald-200' : 'bg-amber-50 text-amber-700 border border-amber-200'"
                                                  x-text="txn.status"></span>
                                        </div>
                                    </div>

                                </div>
                            </template>

                            <!-- Empty State -->
                            <div x-show="displayedTransactions.length === 0" class="p-12 text-center space-y-3">
                                <div class="w-16 h-16 rounded-full bg-gray-100 flex items-center justify-center mx-auto text-gray-400">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                                </div>
                                <h4 class="text-base font-bold text-gray-700 font-serif">No transactions found</h4>
                                <p class="text-xs text-gray-500 max-w-sm mx-auto">There are no transactions matching your selected tab or search criteria.</p>
                                <button @click="openAddMoneyModal = true" type="button" class="mt-2 inline-flex items-center gap-2 px-5 py-2 rounded-xl bg-rani-primary text-white text-xs font-bold shadow hover:bg-rani-primary-dark transition-all">
                                    Recharge Wallet Now
                                </button>
                            </div>
                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <!-- ================= MODAL 1: ADD MONEY (TOP UP) ================= -->
    <div x-show="openAddMoneyModal" 
         style="display: none;" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
        
        <div @click.away="openAddMoneyModal = false" 
             class="bg-white rounded-3xl shadow-2xl border border-rani-gold/30 max-w-md w-full p-6 md:p-8 relative overflow-hidden space-y-6">
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-rani-primary/10 text-rani-primary flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold font-serif text-rani-primary-dark">Add Money to Wallet</h3>
                    </div>
                </div>
                <button @click="openAddMoneyModal = false" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Predefined Amount Pills -->
            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Select Amount (INR)</label>
                <div class="grid grid-cols-4 gap-2">
                    <button type="button" @click="rechargeAmount = 500" :class="rechargeAmount === 500 ? 'bg-rani-primary text-white font-bold border-rani-primary' : 'bg-gray-50 hover:bg-gray-100 text-gray-700 border-gray-200'" class="py-2.5 rounded-xl border text-xs font-semibold transition-all">₹ 500</button>
                    <button type="button" @click="rechargeAmount = 1000" :class="rechargeAmount === 1000 ? 'bg-rani-primary text-white font-bold border-rani-primary' : 'bg-gray-50 hover:bg-gray-100 text-gray-700 border-gray-200'" class="py-2.5 rounded-xl border text-xs font-semibold transition-all">₹ 1,000</button>
                    <button type="button" @click="rechargeAmount = 2500" :class="rechargeAmount === 2500 ? 'bg-rani-primary text-white font-bold border-rani-primary' : 'bg-gray-50 hover:bg-gray-100 text-gray-700 border-gray-200'" class="py-2.5 rounded-xl border text-xs font-semibold transition-all">₹ 2,500</button>
                    <button type="button" @click="rechargeAmount = 5000" :class="rechargeAmount === 5000 ? 'bg-rani-primary text-white font-bold border-rani-primary' : 'bg-gray-50 hover:bg-gray-100 text-gray-700 border-gray-200'" class="py-2.5 rounded-xl border text-xs font-semibold transition-all">₹ 5,000</button>
                </div>
            </div>

            <!-- Custom Amount Input -->
            <div class="space-y-1.5">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Or Enter Custom Amount</label>
                <div class="relative">
                    <span class="absolute left-3.5 top-2.5 font-serif font-bold text-gray-500 text-lg">₹</span>
                    <input type="number" 
                           x-model="rechargeAmount" 
                           min="10" 
                           max="100000" 
                           placeholder="500" 
                           class="w-full pl-9 pr-4 py-2.5 rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-rani-gold text-base font-bold text-gray-800">
                </div>
            </div>

            <!-- Payment Method Selector -->
            <div class="space-y-2">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Payment Method</label>
                <div class="space-y-2">
                    <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 hover:border-rani-gold cursor-pointer transition-all bg-gray-50/50">
                        <input type="radio" value="UPI / QR (Instant)" x-model="paymentMethod" class="w-4 h-4 text-rani-primary focus:ring-rani-primary">
                        <div class="flex-1 flex justify-between items-center">
                            <span class="text-xs font-bold text-gray-800">UPI / QR Code (GPay, PhonePe, Paytm)</span>
                            <span class="text-[10px] bg-emerald-100 text-emerald-800 font-bold px-2 py-0.5 rounded">Fastest</span>
                        </div>
                    </label>

                    <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 hover:border-rani-gold cursor-pointer transition-all bg-gray-50/50">
                        <input type="radio" value="Debit / Credit Card" x-model="paymentMethod" class="w-4 h-4 text-rani-primary focus:ring-rani-primary">
                        <span class="text-xs font-bold text-gray-800">Debit / Credit Card (Visa, MasterCard, RuPay)</span>
                    </label>

                    <label class="flex items-center gap-3 p-3 rounded-xl border border-gray-200 hover:border-rani-gold cursor-pointer transition-all bg-gray-50/50">
                        <input type="radio" value="Net Banking" x-model="paymentMethod" class="w-4 h-4 text-rani-primary focus:ring-rani-primary">
                        <span class="text-xs font-bold text-gray-800">Net Banking / All Indian Banks</span>
                    </label>
                </div>
            </div>

            <!-- Action Button -->
            <div class="pt-2">
                <button type="button" 
                        @click="submitRecharge()" 
                        :disabled="isProcessingRecharge"
                        class="w-full py-3.5 rounded-xl bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white font-bold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 disabled:opacity-50">
                    <span x-show="!isProcessingRecharge">Proceed to Pay <span x-text="'₹ ' + (rechargeAmount || 0)"></span></span>
                    <span x-show="isProcessingRecharge" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Processing Payment...
                    </span>
                </button>
            </div>

        </div>
    </div>

    <!-- ================= MODAL 2: SPEND CREDITS (SERVICE UNLOCK SIMULATION) ================= -->
    <div x-show="openSpendModal" 
         style="display: none;" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
        
        <div @click.away="openSpendModal = false" 
             class="bg-white rounded-3xl shadow-2xl border border-rani-gold/30 max-w-md w-full p-6 md:p-8 relative overflow-hidden space-y-6">
            
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-9 h-9 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold font-serif text-rani-primary-dark">Use Wallet Credits</h3>
                        <p class="text-xs text-gray-500">Spend balance for matrimonial services</p>
                    </div>
                </div>
                <button @click="openSpendModal = false" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Predefined Services -->
            <div class="space-y-3">
                <label class="text-xs font-bold text-gray-700 uppercase tracking-wider">Choose Matrimonial Service</label>
                
                <div class="space-y-2">
                    <div @click="spendService = { title: 'Contact Number Unlock', amount: 199, category: 'Contact View', desc: 'Direct phone number and WhatsApp unlock for 1 match' }"
                         :class="spendService.title === 'Contact Number Unlock' ? 'border-rani-primary bg-rani-primary/5' : 'border-gray-200 hover:border-gray-300'"
                         class="p-3.5 rounded-2xl border cursor-pointer transition-all flex items-center justify-between">
                        <div>
                            <h4 class="text-xs font-bold text-gray-800">Verified Contact Unlock</h4>
                            <p class="text-[11px] text-gray-500">Unlock direct mobile & WhatsApp contact</p>
                        </div>
                        <span class="font-bold text-sm text-rani-primary font-mono">₹ 199</span>
                    </div>

                    <div @click="spendService = { title: 'Profile Spotlight 15-Days', amount: 499, category: 'Profile Boost', desc: 'Boost profile visibility to 5x more verified candidates' }"
                         :class="spendService.title === 'Profile Spotlight 15-Days' ? 'border-rani-primary bg-rani-primary/5' : 'border-gray-200 hover:border-gray-300'"
                         class="p-3.5 rounded-2xl border cursor-pointer transition-all flex items-center justify-between">
                        <div>
                            <h4 class="text-xs font-bold text-gray-800">Profile Spotlight (15 Days)</h4>
                            <p class="text-[11px] text-gray-500">Feature profile at the top of search results</p>
                        </div>
                        <span class="font-bold text-sm text-rani-primary font-mono">₹ 499</span>
                    </div>

                    <div @click="spendService = { title: 'Personalized Matchmaker Consult', amount: 999, category: 'Matchmaking', desc: '1-on-1 dedicated matchmaking consultation call' }"
                         :class="spendService.title === 'Personalized Matchmaker Consult' ? 'border-rani-primary bg-rani-primary/5' : 'border-gray-200 hover:border-gray-300'"
                         class="p-3.5 rounded-2xl border cursor-pointer transition-all flex items-center justify-between">
                        <div>
                            <h4 class="text-xs font-bold text-gray-800">Matchmaker Consultation</h4>
                            <p class="text-[11px] text-gray-500">Dedicated relationship manager assistance</p>
                        </div>
                        <span class="font-bold text-sm text-rani-primary font-mono">₹ 999</span>
                    </div>
                </div>
            </div>

            <!-- Action Button -->
            <div class="pt-2">
                <button type="button" 
                        @click="submitSpend()" 
                        :disabled="isProcessingSpend || avlBalance < spendService.amount"
                        class="w-full py-3.5 rounded-xl bg-gradient-to-r from-rose-700 to-red-800 hover:from-red-800 hover:to-rose-700 text-white font-bold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2 disabled:opacity-50">
                    <span x-show="!isProcessingSpend">Deduct <span x-text="'₹ ' + spendService.amount"></span> from Balance</span>
                    <span x-show="isProcessingSpend" class="flex items-center gap-2">
                        <svg class="animate-spin h-4 w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Processing Deduction...
                    </span>
                </button>
                <p x-show="avlBalance < spendService.amount" class="text-[11px] text-rose-600 text-center mt-2 font-medium">Insufficient balance. Please recharge your wallet first.</p>
            </div>

        </div>
    </div>

</div>

<!-- Alpine Wallet Manager JS Component -->
<script>
function walletManager(initialData) {
    return {
        activeTab: 'all',
        searchQuery: '',
        avlBalance: initialData.avlBalance,
        totalCredit: initialData.totalCredit,
        totalDebit: initialData.totalDebit,
        transactions: initialData.transactions || [],

        // Add Money Modal State
        openAddMoneyModal: false,
        rechargeAmount: 500,
        paymentMethod: 'UPI / QR (Instant)',
        isProcessingRecharge: false,

        // Spend Modal State
        openSpendModal: false,
        spendService: {
            title: 'Contact Number Unlock',
            amount: 199,
            category: 'Contact View',
            desc: 'Direct phone number and WhatsApp unlock for 1 match'
        },
        isProcessingSpend: false,

        get creditCount() {
            return this.transactions.filter(t => t.type === 'credit').length;
        },

        get debitCount() {
            return this.transactions.filter(t => t.type === 'debit').length;
        },

        get filteredTransactions() {
            return this.transactions.filter(t => {
                if (this.activeTab === 'credit' && t.type !== 'credit') return false;
                if (this.activeTab === 'debit' && t.type !== 'debit') return false;
                return true;
            });
        },

        get displayedTransactions() {
            const query = this.searchQuery.toLowerCase().trim();
            return this.filteredTransactions.filter(t => {
                if (!query) return true;
                const matchTitle = (t.title || '').toLowerCase().includes(query);
                const matchDesc = (t.description || '').toLowerCase().includes(query);
                const matchTxnId = (t.transaction_id || '').toLowerCase().includes(query);
                const matchCategory = (t.category || '').toLowerCase().includes(query);
                return matchTitle || matchDesc || matchTxnId || matchCategory;
            });
        },

        formatCurrency(num) {
            const val = parseFloat(num || 0);
            return '₹ ' + val.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
        },

        formatDate(dateStr) {
            if (!dateStr) return '';
            try {
                const d = new Date(dateStr);
                if (isNaN(d.getTime())) return dateStr;
                return d.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' }) + ', ' +
                       d.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
            } catch (e) {
                return dateStr;
            }
        },

        copyCardNumber(text) {
            navigator.clipboard.writeText(text).then(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Copied!',
                    text: 'Card number copied to clipboard',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 2000,
                    customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title' }
                });
            });
        },

        quickAdd(amount) {
            this.rechargeAmount = amount;
            this.submitRecharge();
        },

        async submitRecharge() {
            const amount = parseFloat(this.rechargeAmount);
            if (isNaN(amount) || amount <= 0) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Amount',
                    text: 'Please enter a valid recharge amount.',
                    customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                });
                return;
            }

            this.isProcessingRecharge = true;

            try {
                const res = await fetch('{{ route("wallet.add-money") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        amount: amount,
                        payment_method: this.paymentMethod,
                        custom_note: 'Online Top-up via ' + this.paymentMethod
                    })
                });

                const data = await res.json();

                if (data.success) {
                    this.avlBalance = data.wallet.avl_balance;
                    this.totalCredit = data.wallet.total_credit;
                    this.totalDebit = data.wallet.total_debit;
                    this.transactions.unshift(data.transaction);
                    this.openAddMoneyModal = false;

                    Swal.fire({
                        icon: 'success',
                        title: 'Payment Successful!',
                        text: data.message,
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Recharge Failed',
                        text: data.message || 'Unable to process recharge. Please try again.',
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    });
                }
            } catch (err) {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'A network error occurred. Please try again.',
                    customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                });
            } finally {
                this.isProcessingRecharge = false;
            }
        },

        async submitSpend() {
            if (this.avlBalance < this.spendService.amount) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Insufficient Balance',
                    text: 'Please recharge your wallet before spending credits.',
                    customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                });
                return;
            }

            this.isProcessingSpend = true;

            try {
                const res = await fetch('{{ route("wallet.spend-money") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        amount: this.spendService.amount,
                        title: this.spendService.title,
                        description: this.spendService.desc,
                        category: this.spendService.category
                    })
                });

                const data = await res.json();

                if (data.success) {
                    this.avlBalance = data.wallet.avl_balance;
                    this.totalCredit = data.wallet.total_credit;
                    this.totalDebit = data.wallet.total_debit;
                    this.transactions.unshift(data.transaction);
                    this.openSpendModal = false;

                    Swal.fire({
                        icon: 'success',
                        title: 'Service Activated!',
                        text: data.message,
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Transaction Failed',
                        text: data.message || 'Unable to deduct funds.',
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    });
                }
            } catch (err) {
                console.error(err);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'A network error occurred. Please try again.',
                    customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                });
            } finally {
                this.isProcessingSpend = false;
            }
        }
    };
}
</script>
@endsection
