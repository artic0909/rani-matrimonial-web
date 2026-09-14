@extends('frontend.layouts.auth_app')

@section('title', 'Dashboard | Rani Matrimonial')

@section('content')
<div class="relative pt-6 pb-20" x-data="dashboardManager({
    candidate: @js($candidate),
    matches: @js($dashboardMatches ?? []),
    notifications: @js($notifications ?? []),
    unreadCount: {{ $unreadNotificationsCount ?? 0 }},
    shortlistedIds: @js($shortlistedIds ?? []),
    sentInterestIds: @js($sentInterestIds ?? []),
    receivedInterestIds: @js($receivedInterestIds ?? []),
    acceptedProfileCodes: @js($acceptedProfileCodes ?? [])
})">
    <!-- Background Image -->
    <div class="fixed inset-0 z-0 bg-cover bg-top bg-no-repeat" style="background-image: url('{{ asset('img/hero.png') }}');"></div>
    
    <!-- Maroon/Gold Gradient Overlay (Reduced Opacity) -->
    <div class="fixed inset-0 z-0 bg-gradient-to-t from-rani-dark/80 via-rani-primary-dark/40 to-rani-primary-dark/20"></div>
    
    <!-- Floating Sweet Gestures (Hearts) -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none heart-container opacity-50">
        <div class="heart-floating delay-1"></div>
        <div class="heart-floating heart-maroon delay-2"></div>
        <div class="heart-floating delay-3"></div>
        <div class="heart-floating heart-maroon delay-4"></div>
        <div class="heart-floating delay-5"></div>
        <div class="heart-floating heart-maroon delay-1" style="left: 20%; animation-delay: 7s;"></div>
        <div class="heart-floating delay-2" style="left: 40%; animation-delay: 9s;"></div>
        <div class="heart-floating heart-maroon delay-3" style="left: 60%; animation-delay: 2s;"></div>
        <div class="heart-floating delay-4" style="left: 80%; animation-delay: 14s;"></div>
    </div>

<div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col lg:flex-row gap-6">
        
        <!-- Left Column: Profile Snapshot -->
        <div class="w-full lg:w-1/4 flex flex-col gap-6">
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-sm border border-gray-100 overflow-hidden transition-all hover:shadow-md">
                <div class="p-6 flex flex-col items-center border-b border-gray-100 relative">
                    <!-- Profile Image -->
                    <div class="relative mb-4">
                        <img src="{{ $candidate->profile_picture ? (str_starts_with($candidate->profile_picture, 'http') ? $candidate->profile_picture : (str_starts_with($candidate->profile_picture, 'img/') ? asset($candidate->profile_picture) : asset('storage/' . $candidate->profile_picture))) : 'https://ui-avatars.com/api/?name='.urlencode($candidate->first_name).'&background=D4AF37&color=fff' }}" 
                             alt="{{ $candidate->first_name }}" 
                             class="w-32 h-32 rounded-full border-4 border-rani-gold/30 object-cover shadow-md">
                        
                        @if($candidate->is_bluetick_verified || ($candidateBluetick && (int)$candidateBluetick->is_accept === 1))
                            <div class="absolute bottom-1 right-1 bg-gradient-to-tr from-blue-600 via-sky-500 to-sky-400 text-white rounded-full p-1.5 border-2 border-white shadow-md flex items-center justify-center" title="Blue Tick Verified Profile">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </div>
                        @else
                            <a href="{{ route('my-photos') }}" class="absolute bottom-1 right-1 bg-rani-primary text-white rounded-full p-1.5 border-2 border-white shadow-md hover:scale-110 transition-transform flex items-center justify-center" title="Manage / Upload Photos">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </a>
                        @endif
                    </div>
                    
                    <h2 class="text-xl font-bold text-gray-800 font-serif text-center">{{ $candidate->first_name }}{{ $candidate->middle_name ? ' ' . $candidate->middle_name : '' }} {{ $candidate->last_name }}</h2>
                    <p class="text-xs text-gray-500 font-mono mb-2">ID: {{ $candidate->candidate_code ?? ('RM' . str_pad($candidate->id, 5, '0', STR_PAD_LEFT)) }}</p>
                    <a href="{{ route('my-profile') }}" class="text-rani-primary text-xs font-semibold hover:underline flex items-center gap-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                        Edit Profile
                    </a>
                </div>
                
                <!-- Account Type & Wallet -->
                <div class="p-4 bg-gray-50/80 flex justify-between items-center border-b border-gray-100">
                    <div>
                        <p class="text-[11px] uppercase tracking-wider text-gray-400 font-medium">Account Type</p>
                        <p class="text-sm font-bold text-gray-800 flex items-center gap-1.5">
                            <span>Free Membership</span>
                        </p>
                        <p class="text-[11px] text-gray-500 mt-0.5">Wallet: <span class="font-bold text-rani-primary font-mono">₹{{ number_format($wallet->avl_balance ?? 0, 2) }}</span></p>
                    </div>
                    <button @click="upgradeModalOpen = true" class="text-rani-primary text-xs font-bold bg-rani-primary/10 hover:bg-rani-primary hover:text-white px-3 py-1.5 rounded-lg transition-all">
                        Upgrade
                    </button>
                </div>

                <!-- Profile Completeness Bar -->
                <div class="p-4 border-b border-gray-100 bg-white">
                    <div class="flex justify-between items-center mb-1.5">
                        <span class="text-xs font-semibold text-gray-700">Profile Completeness</span>
                        <span class="text-xs font-bold text-rani-primary">{{ $profileCompleteness }}%</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2 overflow-hidden">
                        <div class="bg-gradient-to-r from-rani-primary to-rani-gold h-2 rounded-full transition-all duration-700" style="width: {{ $profileCompleteness }}%"></div>
                    </div>
                    @if($profileCompleteness < 100)
                        <a href="{{ route('my-profile') }}" class="text-[11px] text-gray-500 hover:text-rani-primary mt-1.5 block transition-colors">
                            Add details to boost matching accuracy &rarr;
                        </a>
                    @endif
                </div>
                
                <!-- Standout with Verification -->
                @if($candidate->is_bluetick_verified || ($candidateBluetick && (int)$candidateBluetick->is_accept === 1))
                <div class="p-4 flex justify-between items-center bg-blue-50/60 border-t border-blue-100/80">
                    <div>
                        <p class="text-xs font-semibold text-gray-800">Verification Status</p>
                        <p class="text-[11px] text-blue-600 font-medium">Blue Tick Active</p>
                    </div>
                    <div class="flex items-center gap-1.5 text-blue-700 bg-blue-100 border border-blue-200 px-2.5 py-1 rounded-full text-xs font-bold shadow-xs">
                        <svg class="w-3.5 h-3.5 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        Verified
                    </div>
                </div>
                @elseif($candidateBluetick && $candidateBluetick->is_accept === 0)
                <div class="p-4 flex justify-between items-center bg-amber-50/50">
                    <div>
                        <p class="text-xs font-semibold text-gray-800">Verification Status</p>
                        <p class="text-[11px] text-amber-700 font-medium">Under Review (24-48h)</p>
                    </div>
                    <a href="{{ route('bluetick.verify') }}" class="text-xs font-bold text-amber-800 bg-amber-100 hover:bg-amber-200 px-3 py-1.5 rounded-lg transition-all">
                        View Status
                    </a>
                </div>
                @else
                <div class="p-4 flex justify-between items-center">
                    <div>
                        <p class="text-xs font-semibold text-gray-800">Standout with Verification</p>
                        <p class="text-[11px] text-gray-500">Get 2x More Matches</p>
                    </div>
                    <a href="{{ route('bluetick.verify') }}" class="text-xs font-bold text-rani-primary hover:text-rani-primary-dark bg-rani-primary/10 hover:bg-rani-primary/20 px-3 py-1.5 rounded-lg transition-all">
                        Get Blue Tick
                    </a>
                </div>
                @endif
            </div>
            
            <!-- Side Banner: Rani Live Video Meetings -->
            <div @click="liveModalOpen = true" class="bg-gradient-to-br from-rani-primary-dark via-rani-primary to-rani-primary-dark rounded-2xl p-6 text-white text-center shadow-lg relative overflow-hidden group cursor-pointer border border-rani-gold/30 transform hover:-translate-y-0.5 transition-all">
                <div class="absolute -right-6 -bottom-6 w-28 h-28 bg-rani-gold/10 rounded-full blur-xl group-hover:scale-125 transition-transform"></div>
                <div class="inline-flex items-center gap-1.5 bg-white/15 backdrop-blur-md px-3 py-0.5 rounded-full text-[10px] font-bold uppercase tracking-wider text-rani-gold mb-2 border border-white/20">
                    <span class="w-1.5 h-1.5 rounded-full bg-emerald-400 animate-pulse"></span>
                    Live Speed Dating
                </div>
                <h3 class="font-serif font-bold text-2xl italic mb-1 text-white drop-shadow-sm">Rani Live</h3>
                <p class="text-xs text-rani-gold-light/95 mb-4">5 Minute Curated Video Meetings</p>
                <div class="bg-black/25 backdrop-blur-md rounded-xl p-3 border border-white/20 group-hover:border-rani-gold/50 transition-colors">
                    <p class="text-[10px] font-medium uppercase tracking-widest text-rani-gold">Next Event Starts In</p>
                    <p class="text-lg font-bold text-white font-serif">2 Days</p>
                </div>
                <div class="mt-3 text-[11px] text-white/80 group-hover:text-white flex items-center justify-center gap-1 font-medium">
                    <span>Learn how it works</span>
                    <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                </div>
            </div>
        </div>

        <!-- Middle Column: Main Feed -->
        <div class="w-full lg:w-2/4 flex flex-col gap-6">
            
            <!-- Activity Summary (Requirement 1 & 2) -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800 font-serif text-lg">Your Activity Summary</h3>
                    <span class="text-xs text-gray-400">Real-time stats</span>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-y sm:divide-y-0 divide-gray-100">
                    <!-- Item 1: Pending Invitations (When someone gives me connection request) -->
                    <a href="{{ route('inbox', ['tab' => 'received']) }}" class="p-4 flex flex-col items-center justify-center text-center hover:bg-rani-primary/5 cursor-pointer transition-colors group" title="View received connection requests">
                        <div class="flex items-center gap-1.5 mb-1">
                            <span class="text-2xl font-bold text-gray-800 font-serif group-hover:text-rani-primary transition-colors">{{ $pendingInvitationsCount }}</span>
                            @if($pendingInvitationsCount > 0)
                                <span class="bg-emerald-100 text-emerald-700 text-[10px] px-1.5 py-0.5 rounded-full font-bold">New</span>
                            @endif
                        </div>
                        <span class="text-xs text-gray-500 font-medium">Pending Invitations</span>
                    </a>

                    <!-- Item 2: Accepted Connections (Accepted by me or accepted by the other user) -->
                    <a href="{{ route('matches', ['tab' => 'accepted']) }}" class="p-4 flex flex-col items-center justify-center text-center hover:bg-rani-primary/5 cursor-pointer transition-colors group" title="View unlocked accepted matches">
                        <div class="flex items-center gap-1.5 mb-1">
                            <span class="text-2xl font-bold {{ $acceptedInvitationsCount > 0 ? 'text-gray-800 group-hover:text-rani-primary' : 'text-gray-400' }} font-serif transition-colors">{{ $acceptedInvitationsCount }}</span>
                            @if($acceptedInvitationsCount > 0)
                                <span class="bg-rani-gold/20 text-rani-primary-dark text-[10px] px-1.5 py-0.5 rounded-full font-bold">Active</span>
                            @endif
                        </div>
                        <span class="text-xs text-gray-500 font-medium">Accepted Connections</span>
                    </a>

                    <!-- Item 3: Recent Visitors / Shortlists -->
                    <a href="{{ route('matches', ['tab' => 'shortlisted']) }}" class="p-4 flex flex-col items-center justify-center text-center hover:bg-rani-primary/5 cursor-pointer transition-colors group" title="View your shortlisted profiles">
                        <div class="flex items-center gap-1.5 mb-1">
                            <span class="text-2xl font-bold text-gray-800 font-serif group-hover:text-rani-primary transition-colors">{{ $recentVisitorsCount }}</span>
                            <span class="bg-emerald-100 text-emerald-700 text-[10px] px-1.5 py-0.5 rounded-full font-bold">New</span>
                        </div>
                        <span class="text-xs text-gray-500 font-medium">Recent Visitors</span>
                    </a>

                    <!-- Item 4: Contacts Viewed -->
                    <a href="{{ route('wallet') }}" class="p-4 flex flex-col items-center justify-center text-center hover:bg-rani-primary/5 cursor-pointer transition-colors group" title="View contact views & transactions">
                        <div class="flex items-center gap-1.5 mb-1">
                            <span class="text-2xl font-bold text-gray-800 font-serif group-hover:text-rani-primary transition-colors">{{ $contactsViewedCount }}</span>
                            @if($contactsViewedCount > 0)
                                <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            @else
                                <svg class="w-4 h-4 text-gray-400" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                            @endif
                        </div>
                        <span class="text-xs text-gray-500 font-medium">Contacts Unlocked</span>
                    </a>
                </div>
            </div>

            <!-- Improve your Profile Banner (Requirement 4) -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex items-center justify-between">
                    <h3 class="font-bold text-gray-800 font-serif text-lg">Improve your Profile</h3>
                    <span class="text-xs font-semibold text-rani-primary">Trust & Safety</span>
                </div>
                
                @if($candidate->is_bluetick_verified || ($candidateBluetick && (int)$candidateBluetick->is_accept === 1))
                <!-- 1. Already Verified State (Blue Tick) -->
                <div class="p-6 flex flex-col sm:flex-row items-center gap-6 bg-gradient-to-r from-blue-50 via-sky-50 to-indigo-50 border-l-4 border-blue-500">
                    <div class="relative shrink-0">
                        <div class="w-20 h-20 rounded-full bg-gradient-to-tr from-blue-600 via-sky-500 to-sky-400 shadow-lg flex items-center justify-center border-4 border-white">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        </div>
                    </div>
                    <div class="text-center sm:text-left flex-1">
                        <div class="flex items-center justify-center sm:justify-start gap-2 mb-1">
                            <h4 class="font-bold text-gray-800 text-lg flex items-center gap-1.5">
                                <span>Blue Tick Verified</span>
                                <svg class="w-5 h-5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            </h4>
                            <span class="bg-blue-100 text-blue-800 text-xs px-2.5 py-0.5 rounded-full font-bold border border-blue-200">100% Genuine</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">Your Aadhaar verification is active. Your profile is prioritized in matchmaking algorithms and receives up to 2x more interests!</p>
                        <a href="{{ route('my-photos') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-blue-700 bg-white border border-blue-200 px-4 py-2 rounded-xl hover:bg-blue-50 transition-colors shadow-xs">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            Manage Gallery Photos
                        </a>
                    </div>
                </div>
                @elseif($candidateBluetick && $candidateBluetick->is_accept === 0)
                <!-- 2. Pending Review State (24-48 hours) -->
                <div class="p-6 flex flex-col sm:flex-row items-center gap-6 bg-gradient-to-r from-amber-50 via-yellow-50 to-amber-50">
                    <div class="relative shrink-0">
                        <div class="w-20 h-20 rounded-full bg-white shadow-md flex items-center justify-center border-4 border-amber-200">
                            <svg class="w-10 h-10 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                    </div>
                    <div class="text-center sm:text-left flex-1">
                        <div class="flex items-center justify-center sm:justify-start gap-2 mb-1">
                            <h4 class="font-bold text-gray-800 text-lg">Verification In Progress</h4>
                            <span class="bg-amber-100 text-amber-800 text-xs px-2.5 py-0.5 rounded-full font-bold">24-48 Hours</span>
                        </div>
                        <p class="text-sm text-gray-600 mb-3">Your Aadhaar card documents have been submitted and are currently being reviewed by our admin verification team.</p>
                        <a href="{{ route('bluetick.verify') }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-amber-900 bg-white border border-amber-200 px-4 py-2 rounded-xl hover:bg-amber-50 transition-colors shadow-xs">
                            View Verification Status &rarr;
                        </a>
                    </div>
                </div>
                @elseif($candidateBluetick && $candidateBluetick->is_accept === 2)
                <!-- 3. Rejected State -->
                <div class="p-6 flex flex-col sm:flex-row items-center gap-6 bg-gradient-to-r from-red-50 via-pink-50 to-red-50">
                    <div class="relative shrink-0">
                        <div class="w-20 h-20 rounded-full bg-white shadow-md flex items-center justify-center border-4 border-red-200">
                            <svg class="w-10 h-10 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        </div>
                    </div>
                    <div class="text-center sm:text-left flex-1">
                        <h4 class="font-bold text-red-900 text-lg mb-1">Verification Needs Attention</h4>
                        <p class="text-sm text-red-700 mb-3">{{ $candidateBluetick->admin_notes ?? 'Please upload clear photos of your Aadhaar card to get verified.' }}</p>
                        <a href="{{ route('bluetick.verify') }}" class="inline-flex items-center gap-2 bg-red-600 text-white font-bold text-xs px-5 py-2.5 rounded-xl hover:bg-red-700 shadow-sm transition-all">
                            Re-submit Verification Documents
                        </a>
                    </div>
                </div>
                @else
                <!-- 4. Default Not Verified State -->
                <div class="p-6 flex flex-col sm:flex-row items-center gap-6 bg-gradient-to-r from-orange-50 via-pink-50 to-amber-50">
                    <div class="relative shrink-0">
                        <div class="w-20 h-20 rounded-full bg-white shadow-md flex items-center justify-center border-4 border-pink-100">
                            <svg class="w-10 h-10 text-pink-400" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                        <div class="absolute -bottom-1 -right-1 bg-blue-500 rounded-full p-1.5 border-2 border-white shadow-md">
                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    <div class="text-center sm:text-left flex-1">
                        <h4 class="font-bold text-gray-800 text-lg mb-1">Blue Tick Verification</h4>
                        <p class="text-sm text-gray-600 mb-4">Verify your profile with your Aadhaar Card to get up to 2x more matches and build 100% trust with prospective partners!</p>
                        <a href="{{ route('bluetick.verify') }}" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-600 to-cyan-600 text-white font-bold text-sm px-6 py-2.5 rounded-xl hover:shadow-lg transform transition hover:-translate-y-0.5">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Apply for Blue Tick
                        </a>
                    </div>
                </div>
                @endif
            </div>

            <!-- Matches Preview Section -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <div class="flex items-center gap-2">
                        <h3 class="font-bold text-gray-800 font-serif text-lg">New Matches For You</h3>
                        @if(count($dashboardMatches) > 0)
                            <span class="bg-rani-primary text-white text-[10px] font-bold px-2 py-0.5 rounded-full">{{ count($dashboardMatches) }} New</span>
                        @endif
                    </div>
                    <a href="{{ route('matches') }}" class="text-rani-primary text-sm font-semibold hover:underline flex items-center gap-1 group">
                        <span>See all</span>
                        <svg class="w-4 h-4 transition-transform group-hover:translate-x-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    </a>
                </div>

                @if(count($dashboardMatches) > 0)
                    <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <template x-for="match in matches" :key="match.id">
                            <div class="bg-white rounded-2xl border border-gray-200/80 shadow-xs hover:shadow-md transition-all p-4 flex flex-col justify-between group relative overflow-hidden">
                                
                                <!-- Match Percentage Pill -->
                                <div class="flex items-center justify-between mb-3">
                                    <span class="inline-flex items-center gap-1 bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white text-[10px] font-bold px-2 py-0.5 rounded-full shadow-xs">
                                        <svg class="w-3 h-3 text-rani-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                        <span x-text="match.match_score + '% Match'"></span>
                                    </span>
                                    
                                    <!-- Shortlist Button -->
                                    <button type="button" 
                                            @click.stop="toggleShortlist(match)"
                                            class="p-1.5 rounded-full transition-colors"
                                            :class="isShortlisted(match) ? 'text-red-500 bg-red-50' : 'text-gray-400 hover:text-red-500 hover:bg-gray-100'"
                                            title="Shortlist Profile">
                                        <svg class="w-4 h-4" :fill="isShortlisted(match) ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                    </button>
                                </div>

                                <!-- Photo & Basic Info -->
                                <div class="flex items-center gap-3.5 mb-3 cursor-pointer" @click="openProfile(match)">
                                    <div class="relative shrink-0">
                                        <img :src="match.photo" :alt="match.first_name" class="w-16 h-16 rounded-full object-cover border-2 border-rani-gold/40 shadow-xs group-hover:scale-105 transition-transform">
                                        <template x-if="match.verified">
                                            <span class="absolute bottom-0 right-0 bg-gradient-to-tr from-blue-600 via-sky-500 to-sky-400 text-white rounded-full p-0.5 border border-white shadow-xs flex items-center justify-center" title="Blue Tick Verified">
                                                <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            </span>
                                        </template>
                                    </div>
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-1.5">
                                            <h4 class="font-bold text-gray-800 text-sm font-serif truncate group-hover:text-rani-primary transition-colors" x-text="match.first_name + ' ' + (match.last_name ? match.last_name.charAt(0) + '.' : '')"></h4>
                                            <span x-show="match.verified" class="inline-flex items-center justify-center w-4 h-4 rounded-full bg-gradient-to-tr from-blue-600 via-sky-500 to-sky-400 text-white shadow-xs shrink-0" title="Blue Tick Verified Profile">
                                                <svg class="w-2.5 h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            </span>
                                        </div>
                                        <p class="text-xs text-gray-600 mt-0.5" x-text="match.age + ' yrs, ' + match.height"></p>
                                        <p class="text-xs text-gray-500 truncate" x-text="(match.profession || match.highest_qualification) + ' • ' + match.city"></p>
                                    </div>
                                </div>

                                <!-- Match Highlights -->
                                <div class="flex flex-wrap gap-1 mb-3.5">
                                    <template x-for="(reason, rIdx) in match.match_reasons" :key="rIdx">
                                        <span class="text-[10px] bg-gray-100 text-gray-600 px-2 py-0.5 rounded-md" x-text="reason"></span>
                                    </template>
                                </div>

                                <!-- Action CTA Buttons -->
                                <div class="flex items-center gap-2 pt-2 border-t border-gray-100">
                                    <button type="button" 
                                            @click="openProfile(match)"
                                            class="flex-1 py-1.5 px-3 text-xs font-semibold text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-xl transition-colors text-center">
                                        View Profile
                                    </button>

                                    <!-- Connect Button with dynamic states -->
                                    <template x-if="isInterestSent(match.id)">
                                        <button type="button" class="flex-1 py-1.5 px-3 text-xs font-bold text-emerald-700 bg-emerald-100 rounded-xl cursor-default flex items-center justify-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                            Sent
                                        </button>
                                    </template>
                                    <template x-if="!isInterestSent(match.id)">
                                        <button type="button" 
                                                @click.stop="sendInterest(match)"
                                                class="flex-1 py-1.5 px-3 text-xs font-bold text-white bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:shadow-md rounded-xl transition-all flex items-center justify-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            Connect
                                        </button>
                                    </template>
                                </div>

                            </div>
                        </template>
                    </div>
                @else
                    <div class="p-8 text-center text-gray-500 py-12">
                        <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-rani-primary/10 text-rani-primary mb-4 shadow-xs">
                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h4 class="font-bold text-gray-800 text-base mb-1 font-serif">Discover Your Ideal Match</h4>
                        <p class="text-xs text-gray-500 max-w-sm mx-auto mb-5">Explore thousands of verified profiles filtered by your religious, educational, and community preferences.</p>
                        <div class="flex items-center justify-center gap-3">
                            <a href="{{ route('matches') }}" class="bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white font-bold text-xs px-5 py-2.5 rounded-xl shadow-sm hover:shadow-md transition-all">
                                Explore All Matches
                            </a>
                            <a href="{{ route('my-profile') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold text-xs px-4 py-2.5 rounded-xl transition-colors">
                                Edit Preferences
                            </a>
                        </div>
                    </div>
                @endif
            </div>

        </div>

        <!-- Right Column: VIP Rani & Notifications (Requirement 3) -->
        <div class="w-full lg:w-1/4 flex flex-col gap-6">
            
            <!-- VIP Banner -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-sm border border-rani-gold/60 overflow-hidden relative group transition-all hover:shadow-md">
                <div class="bg-gradient-to-b from-amber-50/60 to-transparent p-6 flex flex-col items-center text-center border-b border-gray-100">
                    <div class="flex items-center gap-1.5 mb-1">
                        <svg class="w-5 h-5 text-rani-gold animate-bounce" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        <h3 class="font-serif font-bold text-rani-primary-dark tracking-wide text-lg">VIP RANI</h3>
                    </div>
                    <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-4 font-semibold">Matchmaking Service for Elites</p>
                    
                    <ul class="text-xs text-gray-600 text-left space-y-2 mb-6 w-full px-2">
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-rani-gold"></span>
                            <span>Top Rated Personal Matchmakers</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-rani-gold"></span>
                            <span>5X Higher Connection Success Rate</span>
                        </li>
                        <li class="flex items-center gap-2">
                            <span class="w-1.5 h-1.5 rounded-full bg-rani-gold"></span>
                            <span>Handpicked Background-Checked Matches</span>
                        </li>
                    </ul>
                    
                    <button type="button" 
                            @click="vipModalOpen = true" 
                            class="bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white w-full py-2.5 rounded-xl font-bold text-xs shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all">
                        Know More & Consult
                    </button>
                </div>
                
                <!-- Image of consultant -->
                <div class="h-28 bg-gray-200 overflow-hidden relative">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80&w=400&h=300" class="w-full h-full object-cover opacity-90 group-hover:scale-105 transition-transform duration-500" alt="Consultant">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/40 to-transparent"></div>
                    <span class="absolute bottom-2 left-3 text-[10px] font-bold text-white tracking-wide uppercase">Dedicated Relationship Manager</span>
                </div>
            </div>

            <!-- Dynamic Notifications Feed (Database Driven & Click to Dismiss/Go) -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <h3 class="font-bold text-gray-800 text-base">Notifications</h3>
                    </div>
                    <template x-if="unreadCount > 0">
                        <span class="bg-rani-primary text-white text-[10px] px-2 py-0.5 rounded-full font-bold" x-text="unreadCount + ' New'"></span>
                    </template>
                </div>

                <div class="divide-y divide-gray-50 max-h-[380px] overflow-y-auto">
                    <template x-for="notif in notifications" :key="notif.id">
                        <div @click="dismissAndGo(notif)" 
                             class="p-3.5 flex gap-3 hover:bg-rani-primary/5 transition-all cursor-pointer group"
                             :class="notif.is_new ? 'bg-amber-50/40' : ''">
                            <img :src="notif.photo" class="w-10 h-10 rounded-full shrink-0 object-cover border border-rani-gold/30 shadow-xs" :alt="notif.name">
                            <div class="min-w-0 flex-1">
                                <p class="text-xs text-gray-700 leading-snug">
                                    <span class="font-bold text-rani-primary group-hover:underline" x-text="notif.name"></span>
                                    <span x-text="' ' + notif.text"></span>
                                </p>
                                <div class="flex items-center justify-between mt-1">
                                    <span class="text-[10px] text-gray-400" x-text="notif.time_ago"></span>
                                    <template x-if="notif.badge">
                                        <span class="text-[9px] font-bold text-gray-500 bg-gray-100 px-1.5 py-0.2 rounded" x-text="notif.badge"></span>
                                    </template>
                                </div>
                            </div>
                        </div>
                    </template>

                    <template x-if="notifications.length === 0">
                        <div class="p-6 text-center text-gray-400 text-xs">
                            No active notifications. You are all caught up!
                        </div>
                    </template>
                </div>
                
                <a href="{{ route('inbox') }}" class="block w-full text-center py-3 text-xs text-rani-primary font-bold hover:bg-gray-50 transition-colors border-t border-gray-100">
                    View All in Inbox &rarr;
                </a>
            </div>

        </div>

    </div>
</div>

<!-- ================= MODALS ================= -->

<!-- 1. VIP Rani Modal -->
<div x-show="vipModalOpen" 
     x-cloak 
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    
    <div @click.away="vipModalOpen = false" class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-rani-gold relative overflow-hidden">
        <!-- Top Accent Bar -->
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold"></div>
        
        <!-- Close Button -->
        <button @click="vipModalOpen = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-gray-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-amber-50 text-rani-gold mb-3 border border-amber-200">
                <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
            </div>
            <h3 class="text-2xl font-bold font-serif text-rani-primary-dark">VIP Rani Matchmaking</h3>
            <p class="text-xs text-gray-500 mt-1 uppercase tracking-wider">Exclusive Confidential Elite Service</p>
        </div>

        <div class="space-y-3.5 mb-6 text-sm text-gray-700">
            <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50">
                <span class="text-rani-gold font-bold text-base mt-0.5">✦</span>
                <div>
                    <strong class="text-gray-900 block font-semibold text-xs">Dedicated Relationship Manager</strong>
                    <span class="text-xs text-gray-600">A personal senior matchmaking advisor handles profile searches, shortlisting, and introduction calls.</span>
                </div>
            </div>
            <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50">
                <span class="text-rani-gold font-bold text-base mt-0.5">✦</span>
                <div>
                    <strong class="text-gray-900 block font-semibold text-xs">100% Verified Affluent Profiles</strong>
                    <span class="text-xs text-gray-600">High net-worth individuals, doctors, business families & senior corporate professionals.</span>
                </div>
            </div>
            <div class="flex items-start gap-3 p-3 rounded-xl bg-gray-50">
                <span class="text-rani-gold font-bold text-base mt-0.5">✦</span>
                <div>
                    <strong class="text-gray-900 block font-semibold text-xs">Complete Privacy & Discretion</strong>
                    <span class="text-xs text-gray-600">Photos & personal contacts are only shared with mutual consent.</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3">
            <a href="https://wa.me/919820149842?text={{ urlencode('Hello Rani Matrimonial VIP Team, I would like to know more about the VIP Elite Matchmaking service for profile ID: ' . ($candidate->candidate_code ?? $candidate->id)) }}" 
               target="_blank" 
               class="flex-1 py-3 px-4 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs text-center flex items-center justify-center gap-2 shadow-sm transition-colors">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                Chat on WhatsApp
            </a>
            <button @click="vipModalOpen = false" class="py-3 px-5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs transition-colors">
                Close
            </button>
        </div>
    </div>
</div>

<!-- 2. Rani Live Speed Dating Modal -->
<div x-show="liveModalOpen" 
     x-cloak 
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    
    <div @click.away="liveModalOpen = false" class="bg-white rounded-3xl max-w-lg w-full p-6 sm:p-8 shadow-2xl border border-rani-gold relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-rani-primary via-rani-gold to-rani-primary"></div>
        
        <button @click="liveModalOpen = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-gray-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-rani-primary/10 text-rani-primary mb-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
            </div>
            <h3 class="text-2xl font-bold font-serif text-rani-primary-dark">Rani Live Video Speed Dating</h3>
            <p class="text-xs text-gray-500 mt-1">Connect with Compatible Matches Face-to-Face</p>
        </div>

        <div class="space-y-3 mb-6 text-xs text-gray-600">
            <div class="p-3 bg-gray-50 rounded-xl flex items-center gap-3">
                <span class="w-7 h-7 rounded-full bg-rani-primary text-white flex items-center justify-center font-bold text-xs shrink-0">1</span>
                <span><strong>5-Minute Guided Calls:</strong> Short structured 1-on-1 video interactions with AI-curated compatible profiles.</span>
            </div>
            <div class="p-3 bg-gray-50 rounded-xl flex items-center gap-3">
                <span class="w-7 h-7 rounded-full bg-rani-primary text-white flex items-center justify-center font-bold text-xs shrink-0">2</span>
                <span><strong>Mutual Like Matching:</strong> Only if both individuals click "Connect" during the session will mutual phone numbers and profiles unlock.</span>
            </div>
            <div class="p-3 bg-gray-50 rounded-xl flex items-center gap-3">
                <span class="w-7 h-7 rounded-full bg-rani-primary text-white flex items-center justify-center font-bold text-xs shrink-0">3</span>
                <span><strong>100% Safe & Moderated:</strong> Real-time identity verification ensuring respectful, high-class matrimonial interactions.</span>
            </div>
        </div>

        <button type="button" 
                @click="Swal.fire({
                    icon: 'success',
                    title: 'Registered for Rani Live!',
                    text: 'You will receive an SMS and WhatsApp notification 1 hour before the session begins in 2 days.',
                    customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                }); liveModalOpen = false;" 
                class="w-full py-3 rounded-xl bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white font-bold text-xs shadow-md hover:shadow-lg transition-all">
            🔔 Register & Notify Me for Next Session
        </button>
    </div>
</div>

<!-- 3. Upgrade / Wallet Recharge Modal -->
<div x-show="upgradeModalOpen" 
     x-cloak 
     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/70 backdrop-blur-sm"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0">
    
    <div @click.away="upgradeModalOpen = false" class="bg-white rounded-3xl max-w-md w-full p-6 sm:p-8 shadow-2xl border border-rani-gold relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold"></div>
        
        <button @click="upgradeModalOpen = false" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 p-1 rounded-full hover:bg-gray-100">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <div class="text-center mb-6">
            <div class="inline-flex items-center justify-center w-14 h-14 rounded-2xl bg-amber-50 text-rani-primary mb-3">
                <svg class="w-8 h-8 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <h3 class="text-2xl font-bold font-serif text-rani-primary-dark">Upgrade Membership</h3>
            <p class="text-xs text-gray-500 mt-1">Unlock Instant Direct Contacts & Unlimited Connections</p>
        </div>

        <div class="p-4 bg-amber-50/60 rounded-2xl border border-amber-200/70 mb-5">
            <div class="flex justify-between items-center mb-2">
                <span class="text-xs text-gray-600">Current Wallet Balance:</span>
                <span class="text-base font-bold text-rani-primary font-mono">₹{{ number_format($wallet->avl_balance ?? 0, 2) }}</span>
            </div>
            <p class="text-[11px] text-gray-500 leading-snug">Each connection request utilizes ₹100 upon acceptance. Recharge your wallet balance to connect seamlessly.</p>
        </div>

        <div class="flex flex-col gap-3">
            <a href="{{ route('wallet') }}" class="w-full py-3 rounded-xl bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white font-bold text-xs text-center shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                <svg class="w-4 h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
                Recharge Wallet Balance
            </a>
            <button @click="upgradeModalOpen = false; vipModalOpen = true;" class="w-full py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-800 font-semibold text-xs transition-colors">
                View VIP Assisted Packages
            </button>
        </div>
    </div>
</div>

</div>

<!-- Alpine Dashboard Manager Script -->
<script>
function dashboardManager(initialData) {
    return {
        candidate: initialData.candidate || {},
        matches: initialData.matches || [],
        notifications: initialData.notifications || [],
        unreadCount: initialData.unreadCount || 0,
        shortlistedIds: initialData.shortlistedIds || [],
        sentInterestIds: initialData.sentInterestIds || [],
        receivedInterestIds: initialData.receivedInterestIds || [],
        acceptedProfileCodes: initialData.acceptedProfileCodes || [],
        
        vipModalOpen: false,
        liveModalOpen: false,
        upgradeModalOpen: false,

        openProfile(match) {
            if (match.profile_url) {
                window.location.href = match.profile_url;
            } else {
                const targetId = match.id || match.db_id || match.profile_id;
                window.location.href = '/profile/' + targetId;
            }
        },

        async dismissAndGo(notif) {
            // Instantly remove from local notification list & decrement unread count
            this.notifications = this.notifications.filter(n => n.id !== notif.id);
            if (notif.is_new && this.unreadCount > 0) {
                this.unreadCount--;
            }

            // Post to backend to mark read & dismissed
            try {
                fetch('/api/notifications/' + notif.id + '/read', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    }
                });
            } catch (e) {
                console.error(e);
            }

            // Navigate immediately
            if (notif.link) {
                window.location.href = notif.link;
            }
        },

        isShortlisted(match) {
            if (!match) return false;
            const id = (typeof match === 'object' && match.id) ? match.id : match;
            const dbId = (typeof match === 'object' && match.db_id) ? match.db_id : null;
            return this.shortlistedIds.includes(id) || 
                   this.shortlistedIds.includes(String(id)) || 
                   (dbId && (this.shortlistedIds.includes(dbId) || this.shortlistedIds.includes(String(dbId))));
        },

        isInterestSent(id) {
            return this.sentInterestIds.includes(id) || this.sentInterestIds.includes(String(id));
        },

        async toggleShortlist(match) {
            if (!match) return;
            const isCurrentlyShortlisted = this.isShortlisted(match);

            // Optimistic UI update
            if (isCurrentlyShortlisted) {
                this.shortlistedIds = this.shortlistedIds.filter(i => i !== match.id && String(i) !== String(match.id) && i !== match.db_id && String(i) !== String(match.db_id));
            } else {
                this.shortlistedIds.push(match.id);
                if (match.db_id) this.shortlistedIds.push(String(match.db_id));
            }

            try {
                const res = await fetch('{{ route("matches.shortlist") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        profile_id: match.id
                    })
                });

                const data = await res.json();

                if (data.success) {
                    Swal.fire({
                        icon: data.shortlisted ? 'success' : 'info',
                        title: data.shortlisted ? 'Shortlisted!' : 'Removed',
                        text: data.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title' }
                    });
                }
            } catch (e) {
                console.error('Shortlist error:', e);
            }
        },

        async sendInterest(match) {
            if (!match) return;
            if (this.isInterestSent(match.id)) return;

            try {
                const res = await fetch('{{ route("matches.send-interest") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        profile_id: match.id
                    })
                });

                const data = await res.json();

                if (data.success) {
                    if (!this.sentInterestIds.includes(match.id)) {
                        this.sentInterestIds.push(match.id);
                    }
                    match.is_interest_sent = true;

                    Swal.fire({
                        icon: 'success',
                        title: 'Connection Request Sent!',
                        html: '<p class="text-sm">Your connection request was dispatched to <strong>' + match.first_name + '</strong>.<br><span class="text-xs text-gray-400 mt-1 block">A WhatsApp notification with your profile summary has been delivered.</span></p>',
                        confirmButtonText: 'Great',
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    });
                } else if (data.insufficient_balance) {
                    Swal.fire({
                        icon: 'warning',
                        title: data.title || 'Insufficient Wallet Balance',
                        html: '<div class="text-left bg-black/40 border border-amber-500/30 rounded-xl p-3.5 mt-2">' +
                              '<p class="text-sm text-amber-200 leading-relaxed font-medium">' + data.message + '</p>' +
                              '</div>',
                        showCancelButton: true,
                        confirmButtonText: '💳 Recharge Wallet Now',
                        cancelButtonText: 'Maybe Later',
                        customClass: {
                            popup: 'rani-swal-popup',
                            title: 'rani-swal-title',
                            confirmButton: 'rani-swal-confirm',
                            cancelButton: 'rani-swal-cancel'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = data.redirect || '{{ route("wallet") }}';
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Notice',
                        text: data.message || 'Unable to send connection request.',
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    });
                }
            } catch (e) {
                console.error('Send interest error:', e);
            }
        }
    };
}
</script>
@endsection
