@extends('frontend.layouts.auth_app')

@section('title', 'My Wallet & Royal Privilege Card | Rani Matrimonial')

@section('content')
<div class="relative pt-6 pb-20" x-data="walletManager({
    avlBalance: {{ (float) $wallet->avl_balance }},
    totalCredit: {{ (float) $totalCredit }},
    totalDebit: {{ (float) $totalDebit }}
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

    <div class="relative z-10 max-w-6xl mx-auto px-2.5 sm:px-6 lg:px-8">
        
        <!-- Main Card Container -->
        <div class="bg-white/95 backdrop-blur-md rounded-2xl sm:rounded-3xl shadow-2xl border border-white/60 mb-10 overflow-hidden relative z-10">
            
            <!-- Royal accent top bar -->
            <div class="absolute top-0 left-0 w-full h-2 sm:h-2.5 bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-95"></div>
            
            <!-- Page Header -->
            <div class="px-3 sm:px-6 md:px-10 pt-4 sm:pt-8 pb-3 sm:pb-6 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2.5 sm:gap-4">
                <div>
                    <div class="flex items-center gap-2 sm:gap-3">
                        <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl bg-gradient-to-br from-rani-primary to-rani-primary-dark flex items-center justify-center text-rani-gold shadow-xs shrink-0">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        </div>
                        <div>
                            <h1 class="text-lg sm:text-2xl md:text-3xl font-bold font-serif text-rani-primary-dark tracking-wide">My Wallet</h1>
                            <p class="text-[10px] sm:text-xs text-gray-500 font-sans mt-0.5">Exclusive privilege card & digital balance</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="p-3 sm:p-6 md:p-10 space-y-4 sm:space-y-8 md:space-y-10">

                <!-- ================= SECTION 1: CREDIT CARD & QUICK STATS ================= -->
                <div class="grid grid-cols-1 lg:grid-cols-12 gap-4 sm:gap-8 items-center">
                    
                    <!-- Left: Authentic Rani Matrimonial Credit Card UI -->
                    <div class="lg:col-span-7 flex justify-center">
                        <div class="w-full max-w-[480px]">
                            <!-- The Card Container with 3D shadow & subtle tilt -->
                            <div class="group relative aspect-[1.586/1] w-full rounded-2xl md:rounded-3xl p-3.5 sm:p-5 md:p-6 lg:p-7 text-white shadow-xl overflow-hidden transition-all duration-500 hover:shadow-[0_20px_50px_rgba(117,0,0,0.45)] hover:-translate-y-1 border border-rani-gold/60 select-none"
                                 style="background: radial-gradient(circle at 10% 20%, #7d0000 0%, #4a0004 50%, #1d0003 100%);">
                                
                                <!-- Background Groom & Bride Royal Artwork Overlay -->
                                <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-30 mix-blend-screen pointer-events-none transition-transform duration-700 group-hover:scale-105"
                                     style="background-image: url('{{ asset('img/card_couple_bg.jpg') }}');"></div>

                                <!-- Soft Vignette Gradient to ensure high text contrast -->
                                <div class="absolute inset-0 bg-gradient-to-r from-rani-dark/75 via-transparent to-rani-dark/60 pointer-events-none"></div>

                                <!-- Background Royal Mandala Watermark -->
                                <div class="absolute -right-16 -bottom-16 w-64 h-64 opacity-15 pointer-events-none rounded-full border-[18px] border-dashed border-rani-gold"></div>
                                <div class="absolute right-8 bottom-8 w-40 h-40 opacity-10 pointer-events-none rounded-full border-[6px] border-rani-gold"></div>

                                <!-- Metallic Glare / Shimmer Effect -->
                                <div class="absolute inset-0 bg-gradient-to-tr from-transparent via-white/10 to-transparent pointer-events-none opacity-60 group-hover:opacity-90 transition-opacity"></div>
                                
                                <!-- Card Inner Content -->
                                <div class="relative z-10 flex flex-col justify-between h-full">
                                    
                                    <!-- Card Header (Brand + Contactless Icon) -->
                                    <div class="flex justify-between items-start">
                                        <div class="flex items-center gap-1.5 sm:gap-2">
                                            <div>
                                                <div class="flex items-baseline">
                                                    <span class="text-xs sm:text-base md:text-lg font-serif italic font-bold text-white tracking-wide">Rani</span>
                                                    <span class="text-[8px] sm:text-[10px] md:text-xs font-serif text-rani-gold tracking-widest ml-1 uppercase">matrimonial</span>
                                                </div>
                                                <p class="text-[6.5px] sm:text-[8px] md:text-[9px] uppercase tracking-[0.12em] sm:tracking-[0.2em] text-rani-gold/90 font-mono font-semibold">Privilege Card</p>
                                            </div>
                                        </div>

                                        <!-- Contactless Wave & Card Tier Badge -->
                                        <div class="flex items-center gap-1.5 sm:gap-2">
                                            <span class="px-1.5 sm:px-2 py-0.2 sm:py-0.5 rounded-md bg-gradient-to-r from-rani-gold to-yellow-500 text-rani-dark text-[7.5px] sm:text-[9px] md:text-[10px] font-extrabold uppercase tracking-wider shadow-2xs">
                                                VIP
                                            </span>
                                            <svg class="w-3.5 h-3.5 sm:w-5 sm:h-5 md:w-6 md:h-6 text-rani-gold/90 transform rotate-90 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M8.111 16.404a5.5 5.5 0 017.778 0M12 20h.01m-7.08-7.071c3.904-3.905 10.236-3.905 14.141 0M1.393 9.393c5.857-5.857 15.355-5.857 21.213 0"></path>
                                            </svg>
                                        </div>
                                    </div>

                                    <!-- Middle Row: Realistic Gold EMV Smart Chip & Balance -->
                                    <div class="my-auto flex items-center justify-between pt-0.5 sm:pt-2">
                                        <div class="relative w-8 h-5 sm:w-11 sm:h-8 md:w-13 md:h-9 rounded-md bg-gradient-to-br from-amber-200 via-yellow-400 to-amber-600 p-[1px] sm:p-[1.5px] shadow-sm border border-yellow-200/80 shrink-0">
                                            <!-- Chip Grid Circuit Lines -->
                                            <div class="w-full h-full rounded-[2px] sm:rounded-[3px] border border-amber-700/40 grid grid-cols-3 grid-rows-2 gap-[1px] sm:gap-[2px] p-[1px] sm:p-[2px] opacity-80">
                                                <div class="border-r border-b border-amber-800/40 rounded-tl-[1px]"></div>
                                                <div class="border-r border-b border-amber-800/40"></div>
                                                <div class="border-b border-amber-800/40 rounded-tr-[1px]"></div>
                                                <div class="border-r border-amber-800/40 rounded-bl-[1px]"></div>
                                                <div class="border-r border-amber-800/40"></div>
                                                <div class="rounded-br-[1px]"></div>
                                            </div>
                                        </div>

                                        <!-- Available Balance Tag on Card -->
                                        <div class="text-right">
                                            <p class="text-[7.5px] sm:text-[9px] md:text-[10px] uppercase text-gray-300 font-sans tracking-wider">Card Balance</p>
                                            <p class="text-xs sm:text-lg md:text-2xl font-bold font-serif text-white tracking-wide text-shadow" x-text="formatCurrency(avlBalance)"></p>
                                        </div>
                                    </div>

                                    <!-- Card Number (Embossed Monospace Look, No Wrap) -->
                                    <div class="mt-0.5 sm:mt-2 flex items-center justify-between">
                                        <div class="flex items-center gap-1.5 sm:gap-2 w-full justify-between">
                                            <p class="font-mono text-[10px] xs:text-[12px] sm:text-base md:text-xl font-bold tracking-[0.05em] xs:tracking-[0.1em] sm:tracking-[0.14em] md:tracking-[0.18em] text-white/95 drop-shadow-md whitespace-nowrap overflow-hidden">
                                                {{ $wallet->formatted_card_number }}
                                            </p>
                                            <button @click="copyCardNumber('{{ $wallet->wallet_id }}')" 
                                                    type="button" 
                                                    title="Copy Card Number"
                                                    class="p-0.5 sm:p-1 rounded-md bg-white/10 hover:bg-white/25 text-rani-gold transition-colors shrink-0">
                                                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                            </button>
                                        </div>
                                    </div>

                                    <!-- Card Footer: Cardholder Name, Candidate RM ID & Logo Seal -->
                                    <div class="flex justify-between items-end pt-0.5 sm:pt-2 border-t border-white/15">
                                        <div class="min-w-0 pr-2">
                                            <p class="text-[6.5px] sm:text-[8px] md:text-[9px] uppercase tracking-wider sm:tracking-widest text-rani-gold/80 font-mono">Cardholder / ID</p>
                                            <p class="text-[10px] sm:text-xs md:text-sm font-bold uppercase tracking-wide text-white truncate max-w-[120px] xs:max-w-[160px] sm:max-w-[220px]">
                                                {{ $candidate->first_name }} {{ $candidate->last_name }}
                                            </p>
                                            <p class="text-[8px] sm:text-[10px] md:text-xs font-mono text-gray-300 font-semibold tracking-wide">
                                                ID: {{ $candidate->candidate_code ?? ('RM' . str_pad($candidate->id, 5, '0', STR_PAD_LEFT)) }}
                                            </p>
                                        </div>

                                        <div class="text-right flex items-center shrink-0">
                                            <!-- Holographic Gold Seal Emblem -->
                                            <div class="w-6 h-6 sm:w-8 sm:h-8 md:w-10 md:h-10 rounded-full bg-gradient-to-tr from-yellow-600 via-yellow-200 to-amber-500 p-[1px] sm:p-[1.5px] shadow-md flex items-center justify-center shrink-0">
                                                <div class="w-full h-full rounded-full bg-rani-primary-dark/90 flex flex-col items-center justify-center p-0.5">
                                                    <img src="{{ asset('logo.png') }}" alt="Rani" class="h-4 sm:h-6 md:h-8 w-auto rounded-full object-contain">
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Right: Wallet Quick Overview & Privileges -->
                    <div class="lg:col-span-5 space-y-3 sm:space-y-4">
                        <div class="bg-gradient-to-br from-rani-light/40 via-white to-rani-light/20 p-3.5 sm:p-6 rounded-2xl sm:rounded-3xl border border-rani-gold/30 shadow-2xs space-y-3 sm:space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-[10px] sm:text-xs font-bold text-gray-500 uppercase tracking-wider">Wallet Account</span>
                                <span class="inline-flex items-center gap-1.5 px-2 py-0.5 sm:px-2.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">
                                    <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                                    Active & Verified
                                </span>
                            </div>

                            <div>
                                <p class="text-[10px] sm:text-xs text-gray-500 font-medium">Available Balance</p>
                                <div class="flex items-baseline gap-1.5 sm:gap-2">
                                    <h2 class="text-2xl sm:text-3xl md:text-4xl font-extrabold font-serif text-rani-primary-dark tracking-tight" x-text="formatCurrency(avlBalance)"></h2>
                                    <span class="text-[10px] sm:text-xs text-gray-400 uppercase font-semibold">INR</span>
                                </div>
                            </div>

                            <!-- Privilege perks list -->
                            <div class="pt-2 sm:pt-3 border-t border-gray-100 space-y-1.5 sm:space-y-2.5">
                                <p class="text-[10px] sm:text-xs font-bold text-gray-700 uppercase tracking-wide">Privilege Card Benefits:</p>
                                <div class="grid grid-cols-1 gap-1.5 sm:gap-2 text-[10px] sm:text-xs text-gray-600">
                                    <div class="flex items-center gap-1.5 sm:gap-2">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-rani-gold shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        <span class="truncate">Instant verified contact number unlocks</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 sm:gap-2">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-rani-gold shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        <span class="truncate">Highlight profile to top matched matches</span>
                                    </div>
                                    <div class="flex items-center gap-1.5 sm:gap-2">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-rani-gold shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                        <span class="truncate">100% secure automated checkout</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Quick Action Buttons -->
                            <div class="pt-1.5 sm:pt-2 flex gap-2 sm:gap-3">
                                <button @click="openAddMoneyModal = true" 
                                        type="button" 
                                        class="flex-1 py-2 sm:py-3 px-3 sm:px-4 rounded-lg sm:rounded-xl bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white text-[11px] sm:text-sm font-bold shadow-xs hover:shadow-md transition-all text-center">
                                    Recharge Wallet
                                </button>
                                <button @click="quickAdd(500)" 
                                        type="button" 
                                        class="py-2 sm:py-3 px-2.5 sm:px-3 rounded-lg sm:rounded-xl bg-rani-gold-light/60 hover:bg-rani-gold-light text-rani-primary-dark border border-rani-gold/40 text-[11px] sm:text-xs font-bold transition-all whitespace-nowrap">
                                    + ₹500 Quick
                                </button>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- ================= SECTION 2: TOTAL STATS COUNTERS & STATEMENTS ================= -->
                <div class="space-y-3 sm:space-y-4">
                    <div class="grid grid-cols-3 gap-2 sm:gap-5">
                        
                        <!-- Card 1: Available Balance -->
                        <div class="p-2.5 sm:p-4 md:p-5 rounded-xl sm:rounded-2xl bg-gradient-to-br from-amber-50 to-white border border-amber-200/80 shadow-2xs flex flex-col justify-between">
                            <div class="flex items-center justify-between">
                                <p class="text-[9px] xs:text-[10px] sm:text-xs font-semibold text-gray-600 uppercase tracking-tight sm:tracking-wider truncate">Balance</p>
                                <div class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-gradient-to-br from-rani-gold to-yellow-500 text-rani-dark hidden sm:flex items-center justify-center shadow-xs shrink-0">
                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                            </div>
                            <h3 class="text-xs xs:text-sm sm:text-xl md:text-2xl font-extrabold sm:font-bold font-serif text-gray-800 mt-1 truncate" x-text="formatCurrency(avlBalance)"></h3>
                            <p class="text-[10px] sm:text-[11px] text-gray-400 font-sans mt-0.5 hidden sm:block">Spendable funds</p>
                        </div>

                        <!-- Card 2: Total Credit (Links to Credit Page) -->
                        <a href="{{ route('wallet.credit') }}" class="p-2.5 sm:p-4 md:p-5 rounded-xl sm:rounded-2xl bg-gradient-to-br from-emerald-50 to-white border border-emerald-200/80 shadow-2xs flex flex-col justify-between hover:shadow-md transition-all group">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1 min-w-0">
                                    <p class="text-[9px] xs:text-[10px] sm:text-xs font-semibold text-emerald-800 uppercase tracking-tight sm:tracking-wider truncate">Credits (+)</p>
                                    <span class="text-[10px] text-emerald-600 font-bold group-hover:translate-x-0.5 transition-transform hidden xs:inline">→</span>
                                </div>
                                <div class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-emerald-500 text-white hidden sm:flex items-center justify-center shadow-xs shrink-0">
                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 11l5-5m0 0l5 5m-5-5v12"></path></svg>
                                </div>
                            </div>
                            <h3 class="text-xs xs:text-sm sm:text-xl md:text-2xl font-extrabold sm:font-bold font-serif text-emerald-700 mt-1 truncate" x-text="'+ ' + formatCurrency(totalCredit)"></h3>
                            <p class="text-[10px] sm:text-[11px] text-emerald-600/80 font-sans mt-0.5 hidden sm:block">Deposit statements</p>
                        </a>

                        <!-- Card 3: Total Debit (Links to Debit Page) -->
                        <a href="{{ route('wallet.debit') }}" class="p-2.5 sm:p-4 md:p-5 rounded-xl sm:rounded-2xl bg-gradient-to-br from-rose-50 to-white border border-rose-200/80 shadow-2xs flex flex-col justify-between hover:shadow-md transition-all group">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-1 min-w-0">
                                    <p class="text-[9px] xs:text-[10px] sm:text-xs font-semibold text-rose-800 uppercase tracking-tight sm:tracking-wider truncate">Debits (-)</p>
                                    <span class="text-[10px] text-rose-600 font-bold group-hover:translate-x-0.5 transition-transform hidden xs:inline">→</span>
                                </div>
                                <div class="w-8 h-8 md:w-10 md:h-10 rounded-xl bg-rose-600 text-white hidden sm:flex items-center justify-center shadow-xs shrink-0">
                                    <svg class="w-4 h-4 md:w-5 md:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"></path></svg>
                                </div>
                            </div>
                            <h3 class="text-xs xs:text-sm sm:text-xl md:text-2xl font-extrabold sm:font-bold font-serif text-rose-700 mt-1 truncate" x-text="'- ' + formatCurrency(totalDebit)"></h3>
                            <p class="text-[10px] sm:text-[11px] text-rose-600/80 font-sans mt-0.5 hidden sm:block">Service expenses</p>
                        </a>

                    </div>

                    <!-- Quick Statement Navigation Banner -->
                    <div class="mt-3 sm:mt-4 p-3 sm:p-5 rounded-xl sm:rounded-2xl bg-gradient-to-r from-gray-50 via-amber-50/30 to-gray-50 border border-gray-200/80 flex flex-col sm:flex-row items-center justify-between gap-2.5 sm:gap-3">
                        <div class="flex items-center gap-2.5 sm:gap-3 text-center sm:text-left">
                            <div class="w-7 h-7 sm:w-9 sm:h-9 rounded-lg sm:rounded-xl bg-rani-gold/20 text-rani-primary-dark flex items-center justify-center shrink-0">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div>
                                <h4 class="text-[11px] sm:text-sm font-bold text-gray-800">Looking for Transaction Invoices?</h4>
                                <p class="text-[9px] sm:text-[11px] text-gray-500">Download official tax invoices and review your audit statement</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-1.5 sm:gap-2 flex-wrap justify-center">
                            <a href="{{ route('wallet.all') }}" class="px-2.5 py-1.5 sm:px-3.5 sm:py-2 rounded-lg sm:rounded-xl bg-white hover:bg-rani-primary hover:text-white text-gray-700 text-[10px] sm:text-xs font-bold border border-gray-200 shadow-2xs transition-all flex items-center gap-1">
                                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                                <span>All History</span>
                            </a>
                            <a href="{{ route('wallet.credit') }}" class="px-2.5 py-1.5 sm:px-3.5 sm:py-2 rounded-lg sm:rounded-xl bg-emerald-50 hover:bg-emerald-600 hover:text-white text-emerald-800 text-[10px] sm:text-xs font-bold border border-emerald-200 transition-all flex items-center gap-1">
                                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 11l5-5m0 0l5 5m-5-5v12"/></svg>
                                <span>Credits</span>
                            </a>
                            <a href="{{ route('wallet.debit') }}" class="px-2.5 py-1.5 sm:px-3.5 sm:py-2 rounded-lg sm:rounded-xl bg-rose-50 hover:bg-rose-700 hover:text-white text-rose-800 text-[10px] sm:text-xs font-bold border border-rose-200 transition-all flex items-center gap-1">
                                <svg class="w-3 h-3 sm:w-3.5 sm:h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 13l-5 5m0 0l-5-5m5 5V6"/></svg>
                                <span>Debits</span>
                            </a>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- ================= MODAL 1: ADD MONEY (TOP UP VIA RAZORPAY) ================= -->
    <div x-show="openAddMoneyModal" 
         style="display: none;" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-3 sm:p-4 bg-black/60 backdrop-blur-xs">
        
        <div @click.away="!isProcessingRecharge && (openAddMoneyModal = false)" 
             class="bg-white rounded-2xl sm:rounded-3xl shadow-2xl border border-rani-gold/30 max-w-md w-full p-4 sm:p-6 md:p-8 relative overflow-y-auto max-h-[92vh] space-y-3 sm:space-y-6">
            
            <!-- Modal Header -->
            <div class="flex items-center justify-between pb-2.5 sm:pb-4 border-b border-gray-100">
                <div class="flex items-center gap-2 sm:gap-2.5">
                    <div class="w-8 h-8 sm:w-10 sm:h-10 rounded-xl bg-gradient-to-br from-rani-primary to-rani-primary-dark text-rani-gold flex items-center justify-center shadow-xs shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-sm sm:text-lg font-bold font-serif text-rani-primary-dark">Add Money to Wallet</h3>
                        <p class="text-[9px] sm:text-[11px] text-gray-500">Fast & 100% Secure via Razorpay Gateway</p>
                    </div>
                </div>
                <button @click="openAddMoneyModal = false" :disabled="isProcessingRecharge" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition-colors disabled:opacity-30">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Predefined Amount Pills -->
            <div class="space-y-1.5 sm:space-y-2">
                <label class="text-[10px] sm:text-xs font-bold text-gray-700 uppercase tracking-wider">Select Amount (INR)</label>
                <div class="grid grid-cols-4 gap-1.5 sm:gap-2">
                    <button type="button" @click="rechargeAmount = 200" :class="rechargeAmount === 200 ? 'bg-rani-primary text-white font-bold border-rani-primary shadow-xs' : 'bg-gray-50 hover:bg-gray-100 text-gray-700 border-gray-200'" class="py-1.5 sm:py-2.5 rounded-lg sm:rounded-xl border text-[11px] sm:text-xs font-semibold transition-all">₹ 200</button>
                    <button type="button" @click="rechargeAmount = 500" :class="rechargeAmount === 500 ? 'bg-rani-primary text-white font-bold border-rani-primary shadow-xs' : 'bg-gray-50 hover:bg-gray-100 text-gray-700 border-gray-200'" class="py-1.5 sm:py-2.5 rounded-lg sm:rounded-xl border text-[11px] sm:text-xs font-semibold transition-all">₹ 500</button>
                    <button type="button" @click="rechargeAmount = 1000" :class="rechargeAmount === 1000 ? 'bg-rani-primary text-white font-bold border-rani-primary shadow-xs' : 'bg-gray-50 hover:bg-gray-100 text-gray-700 border-gray-200'" class="py-1.5 sm:py-2.5 rounded-lg sm:rounded-xl border text-[11px] sm:text-xs font-semibold transition-all">₹ 1,000</button>
                    <button type="button" @click="rechargeAmount = 2500" :class="rechargeAmount === 2500 ? 'bg-rani-primary text-white font-bold border-rani-primary shadow-xs' : 'bg-gray-50 hover:bg-gray-100 text-gray-700 border-gray-200'" class="py-1.5 sm:py-2.5 rounded-lg sm:rounded-xl border text-[11px] sm:text-xs font-semibold transition-all">₹ 2,500</button>
                </div>
            </div>

            <!-- Custom Amount Input -->
            <div class="space-y-1 sm:space-y-1.5">
                <label class="text-[10px] sm:text-xs font-bold text-gray-700 uppercase tracking-wider">Or Enter Custom Amount</label>
                <div class="relative">
                    <span class="absolute left-3 top-2 sm:top-2.5 font-serif font-bold text-gray-500 text-base sm:text-lg">₹</span>
                    <input type="number" 
                           x-model.number="rechargeAmount" 
                           min="1" 
                           max="100000" 
                           placeholder="500" 
                           class="w-full pl-8 sm:pl-9 pr-3 sm:pr-4 py-2 sm:py-2.5 rounded-lg sm:rounded-xl border border-gray-300 focus:outline-none focus:ring-2 focus:ring-rani-gold text-sm sm:text-base font-bold text-gray-800">
                </div>
                <p class="text-[10px] sm:text-[11px] text-gray-400">Min: ₹ 1 | Max: ₹ 1,00,000</p>
            </div>

            <!-- Razorpay Gateway Info Banner -->
            <div class="p-2.5 sm:p-3.5 rounded-xl sm:rounded-2xl bg-gradient-to-br from-amber-50/70 via-gray-50 to-white border border-amber-200/70 space-y-1 sm:space-y-2">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-1.5 sm:gap-2">
                        <span class="w-1.5 h-1.5 sm:w-2 sm:h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span class="text-[11px] sm:text-xs font-bold text-gray-800">Razorpay Secure Checkout</span>
                    </div>
                    <span class="text-[9px] sm:text-[10px] font-extrabold uppercase tracking-wider bg-rani-gold/20 text-rani-primary-dark px-1.5 sm:px-2 py-0.2 sm:py-0.5 rounded">256-Bit SSL</span>
                </div>
                <p class="text-[10px] sm:text-[11px] text-gray-600 leading-relaxed">
                    Supports <strong>UPI</strong> (GPay, PhonePe, Paytm), <strong>Cards</strong> (Visa, MC, RuPay), and <strong>Net Banking</strong>.
                </p>
            </div>

            <!-- Action Button -->
            <div class="pt-0.5 sm:pt-2">
                <button type="button" 
                        @click="submitRecharge()" 
                        :disabled="isProcessingRecharge || !rechargeAmount || rechargeAmount <= 0"
                        class="w-full py-2.5 sm:py-3.5 rounded-lg sm:rounded-xl bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white font-bold text-xs sm:text-sm shadow-xs hover:shadow-md transition-all flex items-center justify-center gap-2 disabled:opacity-50">
                    <span x-show="!isProcessingRecharge" class="flex items-center gap-1.5 sm:gap-2">
                        <span>Pay</span>
                        <span x-text="'₹ ' + Number(rechargeAmount || 0).toLocaleString('en-IN')"></span>
                        <span>via Razorpay</span>
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                    </span>
                    <span x-show="isProcessingRecharge" class="flex items-center gap-2">
                        <svg class="animate-spin h-3.5 w-3.5 sm:h-4 sm:w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Initializing Razorpay Gateway...
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
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-3 sm:p-4 bg-black/60 backdrop-blur-xs">
        
        <div @click.away="openSpendModal = false" 
             class="bg-white rounded-2xl sm:rounded-3xl shadow-2xl border border-rani-gold/30 max-w-md w-full p-4 sm:p-6 md:p-8 relative overflow-y-auto max-h-[92vh] space-y-3 sm:space-y-6">
            
            <div class="flex items-center justify-between pb-2.5 sm:pb-4 border-b border-gray-100">
                <div class="flex items-center gap-2 sm:gap-2.5">
                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center shrink-0">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-sm sm:text-lg font-bold font-serif text-rani-primary-dark">Use Wallet Credits</h3>
                        <p class="text-[9px] sm:text-xs text-gray-500">Spend balance for matrimonial services</p>
                    </div>
                </div>
                <button @click="openSpendModal = false" class="text-gray-400 hover:text-gray-600 p-1 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Predefined Services -->
            <div class="space-y-2 sm:space-y-3">
                <label class="text-[10px] sm:text-xs font-bold text-gray-700 uppercase tracking-wider">Choose Matrimonial Service</label>
                
                <div class="space-y-1.5 sm:space-y-2">
                    <div @click="spendService = { title: 'Contact Number Unlock', amount: 199, category: 'Contact View', desc: 'Direct phone number and WhatsApp unlock for 1 match' }"
                         :class="spendService.title === 'Contact Number Unlock' ? 'border-rani-primary bg-rani-primary/5' : 'border-gray-200 hover:border-gray-300'"
                         class="p-2.5 sm:p-3.5 rounded-xl sm:rounded-2xl border cursor-pointer transition-all flex items-center justify-between">
                        <div>
                            <h4 class="text-[11px] sm:text-xs font-bold text-gray-800">Verified Contact Unlock</h4>
                            <p class="text-[9px] sm:text-[11px] text-gray-500">Unlock direct mobile & WhatsApp contact</p>
                        </div>
                        <span class="font-bold text-xs sm:text-sm text-rani-primary font-mono">₹ 199</span>
                    </div>

                    <div @click="spendService = { title: 'Profile Spotlight 15-Days', amount: 499, category: 'Profile Boost', desc: 'Boost profile visibility to 5x more verified candidates' }"
                         :class="spendService.title === 'Profile Spotlight 15-Days' ? 'border-rani-primary bg-rani-primary/5' : 'border-gray-200 hover:border-gray-300'"
                         class="p-2.5 sm:p-3.5 rounded-xl sm:rounded-2xl border cursor-pointer transition-all flex items-center justify-between">
                        <div>
                            <h4 class="text-[11px] sm:text-xs font-bold text-gray-800">Profile Spotlight (15 Days)</h4>
                            <p class="text-[9px] sm:text-[11px] text-gray-500">Feature profile at the top of search results</p>
                        </div>
                        <span class="font-bold text-xs sm:text-sm text-rani-primary font-mono">₹ 499</span>
                    </div>

                    <div @click="spendService = { title: 'Personalized Matchmaker Consult', amount: 999, category: 'Matchmaking', desc: '1-on-1 dedicated matchmaking consultation call' }"
                         :class="spendService.title === 'Personalized Matchmaker Consult' ? 'border-rani-primary bg-rani-primary/5' : 'border-gray-200 hover:border-gray-300'"
                         class="p-2.5 sm:p-3.5 rounded-xl sm:rounded-2xl border cursor-pointer transition-all flex items-center justify-between">
                        <div>
                            <h4 class="text-[11px] sm:text-xs font-bold text-gray-800">Matchmaker Consultation</h4>
                            <p class="text-[9px] sm:text-[11px] text-gray-500">Dedicated relationship manager assistance</p>
                        </div>
                        <span class="font-bold text-xs sm:text-sm text-rani-primary font-mono">₹ 999</span>
                    </div>
                </div>
            </div>

            <!-- Action Button -->
            <div class="pt-1 sm:pt-2">
                <button type="button" 
                        @click="submitSpend()" 
                        :disabled="isProcessingSpend || avlBalance < spendService.amount"
                        class="w-full py-2.5 sm:py-3.5 rounded-lg sm:rounded-xl bg-gradient-to-r from-rose-700 to-red-800 hover:from-red-800 hover:to-rose-700 text-white font-bold text-xs sm:text-sm shadow-xs hover:shadow-md transition-all flex items-center justify-center gap-2 disabled:opacity-50">
                    <span x-show="!isProcessingSpend">Deduct <span x-text="'₹ ' + spendService.amount"></span> from Balance</span>
                    <span x-show="isProcessingSpend" class="flex items-center gap-2">
                        <svg class="animate-spin h-3.5 w-3.5 sm:h-4 sm:w-4 text-white" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Processing Deduction...
                    </span>
                </button>
                <p x-show="avlBalance < spendService.amount" class="text-[10px] sm:text-[11px] text-rose-600 text-center mt-1.5 font-medium">Insufficient balance. Please recharge your wallet first.</p>
            </div>

        </div>
    </div>

</div>

<!-- Razorpay Checkout Official SDK -->
<script src="https://checkout.razorpay.com/v1/checkout.js"></script>

<!-- Alpine Wallet Manager JS Component -->
<script>
function walletManager(initialData) {
    const urlParams = new URLSearchParams(window.location.search);
    const urlTab = (urlParams.get('tab') || '').toLowerCase();
    const isRecharge = urlTab === 'recharge' || urlParams.get('action') === 'recharge';

    return {
        avlBalance: initialData.avlBalance,
        totalCredit: initialData.totalCredit,
        totalDebit: initialData.totalDebit,

        // Add Money Modal State
        openAddMoneyModal: isRecharge,
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
            this.openAddMoneyModal = true;
        },

        async submitRecharge() {
            const amount = parseFloat(this.rechargeAmount);
            if (isNaN(amount) || amount < 1) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Invalid Amount',
                    text: 'Please enter a valid recharge amount of at least ₹1.',
                    customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                });
                return;
            }

            this.isProcessingRecharge = true;

            try {
                // Step 1: Create Order on backend via Razorpay Orders API
                const res = await fetch('{{ route("wallet.razorpay.create-order") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        amount: amount
                    })
                });

                const orderData = await res.json();

                if (!orderData.success) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Order Creation Failed',
                        text: orderData.message || 'Unable to initialize Razorpay payment. Please try again.',
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    });
                    this.isProcessingRecharge = false;
                    return;
                }

                // Step 2: Configure & Open Razorpay Standard Checkout Popup
                const self = this;
                const options = {
                    key: orderData.key,
                    amount: orderData.amount,
                    currency: orderData.currency || 'INR',
                    name: orderData.name || 'Rani Matrimonial',
                    description: orderData.description || ('Wallet Top-up - ₹' + amount),
                    image: '{{ asset("logo.png") }}',
                    order_id: orderData.order_id,
                    prefill: {
                        name: orderData.prefill?.name || '',
                        email: orderData.prefill?.email || '',
                        contact: orderData.prefill?.contact || ''
                    },
                    theme: {
                        color: orderData.theme?.color || '#750000'
                    },
                    modal: {
                        ondismiss: function () {
                            self.isProcessingRecharge = false;
                        }
                    },
                    handler: async function (response) {
                        // Step 3: Verify Payment Signature on server & credit wallet
                        try {
                            const verifyRes = await fetch('{{ route("wallet.razorpay.verify-payment") }}', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                                    'Accept': 'application/json'
                                },
                                body: JSON.stringify({
                                    razorpay_payment_id: response.razorpay_payment_id,
                                    razorpay_order_id: response.razorpay_order_id,
                                    razorpay_signature: response.razorpay_signature,
                                    amount: amount
                                })
                            });

                            const verifyData = await verifyRes.json();

                            if (verifyData.success) {
                                self.avlBalance = verifyData.wallet.avl_balance;
                                self.totalCredit = verifyData.wallet.total_credit;
                                self.totalDebit = verifyData.wallet.total_debit;
                                self.transactions.unshift(verifyData.transaction);
                                self.openAddMoneyModal = false;

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Payment Successful!',
                                    text: verifyData.message,
                                    customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                                });
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Verification Failed',
                                    text: verifyData.message || 'Payment verification failed. Please reach out to support.',
                                    customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                                });
                            }
                        } catch (vErr) {
                            console.error(vErr);
                            Swal.fire({
                                icon: 'error',
                                title: 'Verification Error',
                                text: 'Failed to verify transaction. If your account was debited, it will be automatically credited.',
                                customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                            });
                        } finally {
                            self.isProcessingRecharge = false;
                        }
                    }
                };

                const rzp = new Razorpay(options);
                rzp.on('payment.failed', function (failResp) {
                    self.isProcessingRecharge = false;
                    Swal.fire({
                        icon: 'error',
                        title: 'Payment Failed',
                        text: failResp.error?.description || 'Your payment was not completed.',
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    });
                });
                rzp.open();

            } catch (err) {
                console.error(err);
                this.isProcessingRecharge = false;
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'A network error occurred. Please check your connection and try again.',
                    customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                });
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
