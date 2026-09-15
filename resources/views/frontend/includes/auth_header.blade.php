@php
    $authCandidate = Auth::user();
    $headerWallet = $authCandidate ? ($authCandidate->wallet ?? $authCandidate->getOrCreateWallet()) : null;
    $walletBalance = $headerWallet ? number_format((float) $headerWallet->avl_balance, 2) : '0.00';
    $inboxPendingCount = $authCandidate ? \App\Models\ConnectionRequest::where('receiver_id', $authCandidate->id)->where('status', 'pending')->count() : 0;
    
    // Determine active tabs
    $currentTab = request()->query('tab');
    if (!$currentTab && request()->routeIs('matches.view-profile')) {
        if (isset($isAccepted) && $isAccepted) {
            $currentTab = 'accepted';
        } elseif (isset($isPending) && $isPending) {
            $currentTab = 'my_matches';
        } elseif (isset($isShortlisted) && $isShortlisted) {
            $currentTab = 'shortlisted';
        } else {
            $currentTab = 'todays';
        }
    } else {
        $currentTab = $currentTab ?: 'todays';
    }
    $currentInboxTab = request()->query('tab', 'received');
@endphp

<header x-data="{ 
    mobileMenuOpen: false,
    profileMenuOpen: false
}" class="fixed w-full top-0 z-50 bg-[#160000]/95 backdrop-blur-md border-b-2 border-rani-gold/70 shadow-xl transition-all duration-300">
    
    <!-- Top Bar -->
    <div class="border-b border-white/10">
        <div class="max-w-7xl mx-auto px-3 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                
                <!-- Logo & Primary Desktop Nav -->
                <div class="flex items-center gap-4 lg:gap-8">
                    <!-- Brand Logo -->
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 group shrink-0 py-1">
                        <div class="relative">
                            <img src="{{ asset('logo.png') }}" alt="Ranimatrimonial" class="h-9 sm:h-11 w-auto transition-transform duration-300 group-hover:scale-105 shadow-md rounded-full border border-rani-gold/40" />
                            <div class="absolute -bottom-0.5 -right-0.5 w-2.5 h-2.5 bg-emerald-500 rounded-full border-2 border-rani-dark"></div>
                        </div>
                        <div class="flex items-baseline">
                            <span class="text-lg sm:text-2xl font-serif italic font-bold text-white tracking-wide group-hover:text-rani-gold transition-colors">Rani</span>
                            <span class="text-xs sm:text-sm font-serif text-rani-gold tracking-wider ml-1">matrimonial</span>
                        </div>
                    </a>

                    <!-- Desktop Navigation Links -->
                    <nav class="hidden md:flex items-center space-x-1 lg:space-x-2">
                        <a href="{{ route('dashboard') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('dashboard', 'my-profile', 'my-photos', 'wallet') ? 'text-white bg-white/10 font-bold shadow-inner' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-4 h-4 text-rani-gold opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            <span>Profile</span>
                        </a>

                        <a href="{{ route('matches') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('matches*') ? 'text-white bg-white/10 font-bold shadow-inner' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-4 h-4 text-pink-400 opacity-90" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                            <span>Matches</span>
                            <span class="bg-gradient-to-r from-amber-400 to-yellow-500 text-rani-dark text-[10px] font-black px-1.5 py-0.2 rounded-full uppercase shadow-sm">New</span>
                        </a>

                        <a href="{{ route('inbox') }}" class="px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200 flex items-center gap-1.5 {{ request()->routeIs('inbox*') ? 'text-white bg-white/10 font-bold shadow-inner' : 'text-gray-300 hover:text-white hover:bg-white/5' }}">
                            <svg class="w-4 h-4 text-amber-400 opacity-90" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                            <span>Inbox</span>
                            <span class="{{ $inboxPendingCount > 0 ? 'bg-gradient-to-r from-amber-400 to-yellow-400 text-rani-dark font-black animate-pulse' : 'bg-white/20 text-gray-300 font-semibold' }} text-[10px] px-1.5 py-0.5 rounded-full min-w-[18px] text-center">
                                {{ $inboxPendingCount }}
                            </span>
                        </a>
                    </nav>
                </div>

                <!-- Right Action Controls (Desktop & Mobile) -->
                <div class="flex items-center gap-2 sm:gap-4 lg:gap-5">
                    
                    <!-- UPGRADE & WALLET ANIMATED BADGE (Visible across all screens) -->
                    <a href="{{ route('wallet') }}" 
                       x-data="{ showWallet: false }" 
                       x-init="setInterval(() => { showWallet = !showWallet }, 3200)"
                       class="relative overflow-hidden inline-flex items-center justify-center min-w-[96px] sm:min-w-[124px] h-8 sm:h-9 px-2.5 sm:px-3.5 rounded-full bg-gradient-to-r from-amber-400 via-rani-gold to-yellow-400 text-rani-dark text-[11px] sm:text-xs font-black uppercase tracking-wider border border-amber-200/90 golden-box-animate hover:scale-105 active:scale-95 transition-all duration-300 shadow-md">
                        
                        <!-- Continuous Shimmer Light Ray -->
                        <div class="absolute inset-0 w-full h-full pointer-events-none overflow-hidden rounded-full">
                            <div class="w-8 h-full bg-gradient-to-r from-transparent via-white/80 to-transparent golden-shine-beam"></div>
                        </div>

                        <!-- Sparkle Star Accent -->
                        <span class="golden-sparkle-dot absolute top-0.5 right-1.5 text-white font-bold text-[8px] pointer-events-none">✦</span>

                        <!-- State 1: UPGRADE -->
                        <div x-show="!showWallet" 
                             x-transition:enter="transition-all ease-out duration-400 transform"
                             x-transition:enter-start="opacity-0 -translate-y-2.5 scale-90"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition-all ease-in duration-250 transform absolute"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-2.5 scale-90"
                             class="flex items-center gap-1 sm:gap-1.5 whitespace-nowrap z-10 font-black">
                            <svg class="w-3 sm:w-3.5 h-3 sm:h-3.5 fill-current text-rani-dark animate-bounce" viewBox="0 0 24 24">
                                <path d="M13 10V3L4 14h7v7l9-11h-7z"/>
                            </svg>
                            <span>Upgrade</span>
                        </div>

                        <!-- State 2: WALLET BALANCE -->
                        <div x-show="showWallet" 
                             x-cloak
                             x-transition:enter="transition-all ease-out duration-400 transform"
                             x-transition:enter-start="opacity-0 -translate-y-2.5 scale-90"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition-all ease-in duration-250 transform absolute"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-2.5 scale-90"
                             class="flex items-center gap-1 sm:gap-1.5 whitespace-nowrap z-10 font-black">
                            <svg class="w-3 sm:w-3.5 h-3 sm:h-3.5 text-rani-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                            </svg>
                            <span>₹{{ $walletBalance }}</span>
                        </div>
                    </a>

                    <!-- Desktop User Profile Dropdown -->
                    <div class="relative hidden sm:block">
                        <button @click="profileMenuOpen = !profileMenuOpen" @click.away="profileMenuOpen = false" class="flex items-center gap-2 p-1 rounded-full hover:bg-white/10 transition-colors focus:outline-none">
                            <div class="relative">
                                <img src="{{ $authCandidate->profile_picture ? asset('storage/' . $authCandidate->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($authCandidate->first_name).'&background=D4AF37&color=fff' }}" alt="Profile" class="w-8 h-8 rounded-full border-2 border-rani-gold object-cover shadow-sm">
                                <span class="absolute bottom-0 right-0 w-2.5 h-2.5 bg-emerald-500 rounded-full border-2 border-rani-dark"></span>
                            </div>
                            <span class="text-xs font-semibold text-gray-200 hidden lg:inline-block max-w-[90px] truncate">{{ $authCandidate->first_name }}</span>
                            <svg class="w-3.5 h-3.5 text-gray-300 transition-transform duration-200" :class="profileMenuOpen ? 'rotate-180 text-rani-gold' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <!-- Desktop Dropdown Menu Card -->
                        <div x-show="profileMenuOpen" style="display: none;" 
                             x-transition:enter="transition ease-out duration-200"
                             x-transition:enter-start="opacity-0 translate-y-2 scale-95"
                             x-transition:enter-end="opacity-100 translate-y-0 scale-100"
                             x-transition:leave="transition ease-in duration-150"
                             x-transition:leave-start="opacity-100 translate-y-0 scale-100"
                             x-transition:leave-end="opacity-0 translate-y-2 scale-95"
                             class="absolute right-0 mt-3 w-64 bg-white rounded-2xl shadow-2xl border border-rani-gold/20 py-2 z-50 overflow-hidden text-gray-800">
                            
                            <!-- User Mini Card -->
                            <div class="px-4 py-3 bg-gradient-to-r from-rani-primary/5 via-amber-50/50 to-transparent border-b border-gray-100">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $authCandidate->profile_picture ? asset('storage/' . $authCandidate->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($authCandidate->first_name).'&background=D4AF37&color=fff' }}" class="w-10 h-10 rounded-full border border-rani-gold object-cover">
                                    <div class="min-w-0 flex-1">
                                        <p class="text-sm font-bold text-gray-900 truncate">{{ $authCandidate->first_name }} {{ $authCandidate->last_name }}</p>
                                        <p class="text-xs text-rani-primary font-mono font-bold tracking-wider">{{ $authCandidate->candidate_code ?? $authCandidate->profile_id }}</p>
                                    </div>
                                </div>
                                <div class="mt-2.5 pt-2 border-t border-gray-200/60 flex items-center justify-between text-xs">
                                    <span class="text-gray-500 font-medium">Wallet Balance</span>
                                    <span class="font-extrabold text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded-full">₹{{ $walletBalance }}</span>
                                </div>
                            </div>

                            <!-- Menu Links -->
                            <div class="p-1 space-y-0.5">
                                <a href="{{ route('dashboard') }}" class="flex items-center gap-2.5 px-3 py-2 text-sm text-gray-700 hover:bg-rani-primary/5 hover:text-rani-primary rounded-lg transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                    Dashboard
                                </a>
                                <a href="{{ route('my-profile') }}" class="flex items-center gap-2.5 px-3 py-2 text-sm text-gray-700 hover:bg-rani-primary/5 hover:text-rani-primary rounded-lg transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    My Profile
                                </a>
                                <a href="{{ route('my-photos') }}" class="flex items-center gap-2.5 px-3 py-2 text-sm text-gray-700 hover:bg-rani-primary/5 hover:text-rani-primary rounded-lg transition-colors">
                                    <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                    My Photos
                                </a>
                                <a href="{{ route('wallet') }}" class="flex items-center gap-2.5 px-3 py-2 text-sm text-gray-700 hover:bg-rani-primary/5 hover:text-rani-primary rounded-lg transition-colors">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                    My Wallet & Recharge
                                </a>
                                <a href="{{ route('bluetick.verify') }}" class="flex items-center gap-2.5 px-3 py-2 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors">
                                    <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                    Blue Tick Verification
                                </a>
                            </div>

                            <div class="border-t border-gray-100 mt-1 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="flex items-center gap-2.5 w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50 font-medium transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Menu Trigger Button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" 
                            type="button" 
                            aria-label="Toggle Menu"
                            class="md:hidden inline-flex items-center justify-center p-2 rounded-xl text-rani-gold hover:bg-white/10 active:scale-90 transition-all focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" style="display: none;"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sub Header: Responsive Touch-Scrollable Navigation Tabs -->
    <div class="bg-white/95 backdrop-blur-md shadow-sm border-b border-gray-100">
        <div class="max-w-7xl mx-auto px-2 sm:px-6 lg:px-8">
            <div class="flex items-center overflow-x-auto [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none] scroll-smooth py-1">
                @if(request()->routeIs('matches*'))
                    <!-- Matches Sub Navigation -->
                    <nav class="flex space-x-2 sm:space-x-4 min-w-full sm:min-w-0">
                        <a href="{{ route('matches', ['tab' => 'todays']) }}" class="{{ $currentTab === 'todays' ? 'bg-rani-primary text-white shadow-sm font-bold' : 'text-gray-600 hover:text-rani-primary hover:bg-gray-100/80 font-medium' }} text-xs sm:text-sm py-2 px-3.5 rounded-full transition-all whitespace-nowrap flex items-center gap-1.5">
                            <span>Today's</span>
                        </a>
                        <a href="{{ route('matches', ['tab' => 'shortlisted']) }}" class="{{ $currentTab === 'shortlisted' ? 'bg-rani-primary text-white shadow-sm font-bold' : 'text-gray-600 hover:text-rani-primary hover:bg-gray-100/80 font-medium' }} text-xs sm:text-sm py-2 px-3.5 rounded-full transition-all whitespace-nowrap flex items-center gap-1.5">
                            <span>Shortlisted</span>
                        </a>
                        <a href="{{ route('matches', ['tab' => 'my_matches']) }}" class="{{ $currentTab === 'my_matches' ? 'bg-rani-primary text-white shadow-sm font-bold' : 'text-gray-600 hover:text-rani-primary hover:bg-gray-100/80 font-medium' }} text-xs sm:text-sm py-2 px-3.5 rounded-full transition-all whitespace-nowrap flex items-center gap-1.5">
                            <span>My Matches</span>
                        </a>
                        <a href="{{ route('matches', ['tab' => 'accepted']) }}" class="{{ $currentTab === 'accepted' ? 'bg-rani-primary text-white shadow-sm font-bold' : 'text-gray-600 hover:text-rani-primary hover:bg-gray-100/80 font-medium' }} text-xs sm:text-sm py-2 px-3.5 rounded-full transition-all whitespace-nowrap flex items-center gap-1.5">
                            <span>Accepted</span>
                        </a>
                    </nav>
                @elseif(request()->routeIs('inbox*'))
                    <!-- Inbox Sub Navigation -->
                    <nav class="flex space-x-2 sm:space-x-4 min-w-full sm:min-w-0">
                        <a href="{{ route('inbox', ['tab' => 'received']) }}" class="{{ $currentInboxTab === 'received' ? 'bg-rani-primary text-white shadow-sm font-bold' : 'text-gray-600 hover:text-rani-primary hover:bg-gray-100/80 font-medium' }} text-xs sm:text-sm py-2 px-3.5 rounded-full transition-all whitespace-nowrap flex items-center gap-1.5">
                            <span>Received Interests</span>
                            @if($inboxPendingCount > 0)
                                <span class="bg-amber-400 text-rani-dark text-[10px] font-black px-1.5 rounded-full">{{ $inboxPendingCount }}</span>
                            @endif
                        </a>
                        <a href="{{ route('inbox', ['tab' => 'accepted']) }}" class="{{ $currentInboxTab === 'accepted' ? 'bg-rani-primary text-white shadow-sm font-bold' : 'text-gray-600 hover:text-rani-primary hover:bg-gray-100/80 font-medium' }} text-xs sm:text-sm py-2 px-3.5 rounded-full transition-all whitespace-nowrap flex items-center gap-1.5">
                            <span>Accepted</span>
                        </a>
                        <a href="{{ route('inbox', ['tab' => 'declined']) }}" class="{{ $currentInboxTab === 'declined' ? 'bg-rani-primary text-white shadow-sm font-bold' : 'text-gray-600 hover:text-rani-primary hover:bg-gray-100/80 font-medium' }} text-xs sm:text-sm py-2 px-3.5 rounded-full transition-all whitespace-nowrap flex items-center gap-1.5">
                            <span>Declined</span>
                        </a>
                    </nav>
                @else
                    <!-- Profile & Dashboard Sub Navigation -->
                    <nav class="flex space-x-2 sm:space-x-4 min-w-full sm:min-w-0">
                        <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'bg-rani-primary text-white shadow-sm font-bold' : 'text-gray-600 hover:text-rani-primary hover:bg-gray-100/80 font-medium' }} text-xs sm:text-sm py-2 px-3.5 rounded-full transition-all whitespace-nowrap flex items-center gap-1.5">
                            Dashboard
                        </a>
                        <a href="{{ route('my-profile') }}" class="{{ request()->routeIs('my-profile') ? 'bg-rani-primary text-white shadow-sm font-bold' : 'text-gray-600 hover:text-rani-primary hover:bg-gray-100/80 font-medium' }} text-xs sm:text-sm py-2 px-3.5 rounded-full transition-all whitespace-nowrap flex items-center gap-1.5">
                            My Profile
                        </a>
                        <a href="{{ route('my-photos') }}" class="{{ request()->routeIs('my-photos') ? 'bg-rani-primary text-white shadow-sm font-bold' : 'text-gray-600 hover:text-rani-primary hover:bg-gray-100/80 font-medium' }} text-xs sm:text-sm py-2 px-3.5 rounded-full transition-all whitespace-nowrap flex items-center gap-1.5">
                            My Photos
                        </a>
                        <a href="{{ route('wallet') }}" class="{{ request()->routeIs('wallet') ? 'bg-rani-primary text-white shadow-sm font-bold' : 'text-gray-600 hover:text-rani-primary hover:bg-gray-100/80 font-medium' }} text-xs sm:text-sm py-2 px-3.5 rounded-full transition-all whitespace-nowrap flex items-center gap-1.5">
                            Wallet
                        </a>
                    </nav>
                @endif
            </div>
        </div>
    </div>

    <!-- Mobile Navigation Drawer (Teleported directly to body for true full viewport overlay) -->
    <template x-teleport="body">
        <div x-show="mobileMenuOpen" 
             x-cloak
             class="md:hidden fixed inset-0 z-[99999] flex justify-end" 
             style="display: none;">
            
            <!-- Dark Backdrop -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="mobileMenuOpen = false" 
                 class="fixed inset-0 bg-black/75 backdrop-blur-sm z-[99998]"></div>

            <!-- Drawer Content Panel (Right Slide-in) -->
            <div x-show="mobileMenuOpen" 
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="relative flex flex-col w-[85vw] max-w-[320px] bg-white shadow-2xl h-[100dvh] z-[99999] overflow-y-auto overscroll-contain">
                
                <!-- User Header Card in Mobile Drawer -->
                <div class="p-5 bg-gradient-to-br from-rani-dark via-rani-primary-dark to-rani-primary text-white relative overflow-hidden shrink-0">
                    <div class="absolute top-0 right-0 w-32 h-32 bg-rani-gold/10 rounded-full blur-2xl pointer-events-none"></div>
                    
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-[11px] font-mono font-bold uppercase tracking-wider bg-rani-gold text-rani-dark px-2 py-0.5 rounded-full">
                            {{ $authCandidate->candidate_code ?? $authCandidate->profile_id }}
                        </span>
                        <button @click="mobileMenuOpen = false" class="p-1.5 rounded-full text-gray-300 hover:text-white bg-white/10 hover:bg-white/20 active:scale-95 transition-all">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <div class="flex items-center gap-3">
                        <img src="{{ $authCandidate->profile_picture ? asset('storage/' . $authCandidate->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($authCandidate->first_name).'&background=D4AF37&color=fff' }}" alt="Profile" class="w-12 h-12 rounded-full border-2 border-rani-gold object-cover shadow-md shrink-0">
                        <div class="min-w-0 flex-1">
                            <h4 class="font-serif font-bold text-base text-white truncate">{{ $authCandidate->first_name }} {{ $authCandidate->last_name }}</h4>
                            <p class="text-xs text-gray-300 truncate">{{ $authCandidate->email }}</p>
                        </div>
                    </div>

                    <!-- Quick Balance Chip in Mobile Drawer -->
                    <a href="{{ route('wallet') }}" @click="mobileMenuOpen = false" class="mt-4 flex items-center justify-between p-2.5 rounded-xl bg-white/10 border border-white/15 hover:bg-white/20 transition-all">
                        <div class="flex items-center gap-2">
                            <svg class="w-4 h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                            <span class="text-xs text-gray-200">Wallet Balance</span>
                        </div>
                        <span class="text-sm font-black text-amber-300">₹{{ $walletBalance }} →</span>
                    </a>
                </div>

                <!-- Drawer Links Sections -->
                <div class="flex-1 px-3 py-4 space-y-4 overflow-y-auto">
                    
                    <!-- Section 1: Matches -->
                    <div>
                        <p class="px-3 text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-1">Matchmaking</p>
                        <div class="space-y-1">
                            <a href="{{ route('matches', ['tab' => 'todays']) }}" @click="mobileMenuOpen = false" class="flex items-center justify-between px-3 py-2 rounded-xl text-sm font-medium {{ (request()->routeIs('matches*') && $currentTab === 'todays') ? 'text-rani-primary bg-rani-primary/10 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                                <span class="flex items-center gap-2.5">
                                    <svg class="w-4 h-4 text-pink-500" fill="currentColor" viewBox="0 0 24 24"><path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/></svg>
                                    Today's Matches
                                </span>
                                <span class="text-[10px] bg-amber-100 text-amber-800 font-bold px-1.5 rounded-full">New</span>
                            </a>
                            <a href="{{ route('matches', ['tab' => 'shortlisted']) }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium {{ (request()->routeIs('matches*') && $currentTab === 'shortlisted') ? 'text-rani-primary bg-rani-primary/10 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                                <svg class="w-4 h-4 text-amber-500" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                Shortlisted
                            </a>
                            <a href="{{ route('matches', ['tab' => 'my_matches']) }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium {{ (request()->routeIs('matches*') && $currentTab === 'my_matches') ? 'text-rani-primary bg-rani-primary/10 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                My Matches
                            </a>
                            <a href="{{ route('matches', ['tab' => 'accepted']) }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium {{ (request()->routeIs('matches*') && $currentTab === 'accepted') ? 'text-rani-primary bg-rani-primary/10 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                                <svg class="w-4 h-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Accepted Matches
                            </a>
                        </div>
                    </div>

                    <!-- Section 2: Inbox -->
                    <div class="pt-2 border-t border-gray-100">
                        <p class="px-3 text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-1">Inbox & Interests</p>
                        <div class="space-y-1">
                            <a href="{{ route('inbox', ['tab' => 'received']) }}" @click="mobileMenuOpen = false" class="flex items-center justify-between px-3 py-2 rounded-xl text-sm font-medium {{ (request()->routeIs('inbox*') && $currentInboxTab === 'received') ? 'text-rani-primary bg-rani-primary/10 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                                <span class="flex items-center gap-2.5">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                    Received Interests
                                </span>
                                @if($inboxPendingCount > 0)
                                    <span class="bg-gradient-to-r from-amber-400 to-yellow-400 text-rani-dark font-black text-xs px-2 py-0.5 rounded-full">{{ $inboxPendingCount }}</span>
                                @endif
                            </a>
                            <a href="{{ route('inbox', ['tab' => 'accepted']) }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium {{ (request()->routeIs('inbox*') && $currentInboxTab === 'accepted') ? 'text-rani-primary bg-rani-primary/10 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                                <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Accepted Interests
                            </a>
                            <a href="{{ route('inbox', ['tab' => 'declined']) }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium {{ (request()->routeIs('inbox*') && $currentInboxTab === 'declined') ? 'text-rani-primary bg-rani-primary/10 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                                <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                Declined
                            </a>
                        </div>
                    </div>

                    <!-- Section 3: My Account -->
                    <div class="pt-2 border-t border-gray-100">
                        <p class="px-3 text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-1">My Account</p>
                        <div class="space-y-1">
                            <a href="{{ route('dashboard') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('dashboard') ? 'text-rani-primary bg-rani-primary/10 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                                Dashboard
                            </a>
                            <a href="{{ route('my-profile') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('my-profile') ? 'text-rani-primary bg-rani-primary/10 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                My Profile
                            </a>
                            <a href="{{ route('my-photos') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('my-photos') ? 'text-rani-primary bg-rani-primary/10 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                My Photos
                            </a>
                            <a href="{{ route('wallet') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium {{ request()->routeIs('wallet') ? 'text-rani-primary bg-rani-primary/10 font-bold' : 'text-gray-700 hover:bg-gray-50' }}">
                                <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                                Wallet & Recharge
                            </a>
                            <a href="{{ route('bluetick.verify') }}" @click="mobileMenuOpen = false" class="flex items-center gap-2.5 px-3 py-2 rounded-xl text-sm font-medium text-blue-600 hover:bg-blue-50">
                                <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                Blue Tick Verification
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Drawer Bottom Logout Action -->
                <div class="p-4 border-t border-gray-100 bg-gray-50/70 shrink-0">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full flex items-center justify-center gap-2 py-2.5 px-4 rounded-xl text-sm font-bold text-red-600 bg-red-50 hover:bg-red-100 transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </template>
</header>
