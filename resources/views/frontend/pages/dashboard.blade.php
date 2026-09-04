@extends('frontend.layouts.auth_app')

@section('title', 'Dashboard | Ranimatrimonial')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="flex flex-col lg:flex-row gap-6">
        
        <!-- Left Column: Profile Snapshot -->
        <div class="w-full lg:w-1/4 flex flex-col gap-6">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 flex flex-col items-center border-b border-gray-100 relative">
                    <!-- Profile Image -->
                    <div class="relative mb-4">
                        <img src="{{ $candidate->profile_picture ? asset('storage/' . $candidate->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($candidate->first_name).'&background=D4AF37&color=fff' }}" 
                             alt="{{ $candidate->first_name }}" 
                             class="w-32 h-32 rounded-full border-4 border-rani-gold/20 object-cover shadow-sm">
                        
                        @if($candidate->selfie_verified)
                            <div class="absolute bottom-1 right-1 bg-green-500 text-white rounded-full p-1 border-2 border-white shadow-sm" title="Selfie Verified">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                        @else
                            <button class="absolute bottom-1 right-1 bg-rani-primary text-white rounded-full p-1 border-2 border-white shadow-sm hover:scale-110 transition-transform" title="Add Photo">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </button>
                        @endif
                    </div>
                    
                    <h2 class="text-xl font-bold text-gray-800 font-serif">{{ $candidate->first_name }} {{ $candidate->last_name }}</h2>
                    <p class="text-sm text-gray-500 mb-2">ID: RANI{{ str_pad($candidate->id, 6, '0', STR_PAD_LEFT) }}</p>
                    <a href="#" class="text-rani-primary text-sm font-medium hover:underline">Edit Profile</a>
                </div>
                
                <div class="p-4 bg-gray-50 flex justify-between items-center">
                    <div>
                        <p class="text-xs text-gray-500 mb-0.5">Account Type</p>
                        <p class="text-sm font-bold text-gray-700">Free Membership</p>
                    </div>
                    <a href="#" class="text-rani-primary text-sm font-medium hover:underline">Upgrade</a>
                </div>
                
                @if($candidate->selfie_verified)
                <div class="p-4 flex justify-between items-center border-t border-gray-100">
                    <p class="text-xs text-gray-600">Standout with Verification</p>
                    <div class="flex items-center gap-1 text-green-600 text-xs font-bold">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                        Verified
                    </div>
                </div>
                @else
                <div class="p-4 flex justify-between items-center border-t border-gray-100">
                    <p class="text-xs text-gray-600">Standout with Verification</p>
                    <a href="#" class="text-rani-primary text-xs font-bold hover:underline">Get Blue Tick</a>
                </div>
                @endif
            </div>
            
            <!-- Side Banner ad -->
            <div class="bg-gradient-to-br from-rani-primary-dark to-rani-primary rounded-xl p-6 text-white text-center shadow-sm relative overflow-hidden group cursor-pointer">
                <div class="absolute inset-0 bg-black/10 group-hover:bg-transparent transition-colors"></div>
                <h3 class="font-serif font-bold text-2xl italic mb-2 relative z-10">Rani Live</h3>
                <p class="text-sm text-rani-gold-light/90 mb-4 relative z-10">5 Minute Video Meetings</p>
                <div class="bg-white/20 rounded-lg p-3 backdrop-blur-sm relative z-10 border border-white/30">
                    <p class="text-xs font-medium uppercase tracking-widest text-rani-gold">Starts In</p>
                    <p class="text-lg font-bold">2 Days</p>
                </div>
            </div>
        </div>

        <!-- Middle Column: Main Feed -->
        <div class="w-full lg:w-2/4 flex flex-col gap-6">
            
            <!-- Activity Summary -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800 font-serif text-lg">Your Activity Summary</h3>
                </div>
                <div class="grid grid-cols-2 sm:grid-cols-4 divide-x divide-y sm:divide-y-0 divide-gray-100">
                    <!-- Item 1 -->
                    <div class="p-4 flex flex-col items-center justify-center text-center hover:bg-gray-50 cursor-pointer transition-colors">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-2xl font-bold text-gray-800">0</span>
                            <span class="bg-green-100 text-green-700 text-[10px] px-1.5 py-0.5 rounded font-bold">New</span>
                        </div>
                        <span class="text-xs text-gray-500">Pending Invitations</span>
                    </div>
                    <!-- Item 2 -->
                    <div class="p-4 flex flex-col items-center justify-center text-center hover:bg-gray-50 cursor-pointer transition-colors">
                        <span class="text-2xl font-bold text-gray-300 mb-1">0</span>
                        <span class="text-xs text-gray-500">Accepted Invitations</span>
                    </div>
                    <!-- Item 3 -->
                    <div class="p-4 flex flex-col items-center justify-center text-center hover:bg-gray-50 cursor-pointer transition-colors">
                        <div class="flex items-center gap-2 mb-1">
                            <span class="text-2xl font-bold text-gray-800">3</span>
                            <span class="bg-green-100 text-green-700 text-[10px] px-1.5 py-0.5 rounded font-bold">New</span>
                        </div>
                        <span class="text-xs text-gray-500">Recent Visitors</span>
                    </div>
                    <!-- Item 4 (Premium feature mock) -->
                    <div class="p-4 flex flex-col items-center justify-center text-center bg-gray-50 relative overflow-hidden group">
                        <div class="absolute inset-0 bg-white/60 flex items-center justify-center backdrop-blur-[1px] opacity-100 group-hover:opacity-0 transition-opacity z-10">
                            <svg class="w-5 h-5 text-rani-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path></svg>
                        </div>
                        <span class="text-2xl font-bold text-gray-300 mb-1 relative z-0">0</span>
                        <span class="text-xs text-gray-500 relative z-0">Contacts Viewed</span>
                    </div>
                </div>
            </div>

            <!-- Improve your Profile Banner -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100">
                    <h3 class="font-bold text-gray-800 font-serif text-lg">Improve your Profile</h3>
                </div>
                <div class="p-6 flex flex-col sm:flex-row items-center gap-6 bg-gradient-to-r from-orange-50 to-pink-50">
                    <div class="relative shrink-0">
                        <!-- Abstract illustration -->
                        <div class="w-24 h-24 rounded-full bg-white shadow-md flex items-center justify-center border-4 border-pink-100">
                            <svg class="w-12 h-12 text-pink-300" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                        </div>
                        <div class="absolute -bottom-2 -right-2 bg-blue-500 rounded-full p-1.5 border-2 border-white shadow-md">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    </div>
                    <div class="text-center sm:text-left flex-1">
                        <h4 class="font-bold text-gray-800 text-lg mb-1">Blue Tick Verification</h4>
                        <p class="text-sm text-gray-600 mb-4">Verify your profile with Selfie to get up to 2x more matches!</p>
                        @if($candidate->selfie_verified)
                            <button class="bg-gray-200 text-gray-500 font-semibold px-6 py-2 rounded-full cursor-not-allowed">Already Verified</button>
                        @else
                            <button class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white font-bold px-6 py-2 rounded-full hover:shadow-lg transform transition hover:-translate-y-0.5">Get Blue Tick</button>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Matches preview -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center">
                    <h3 class="font-bold text-gray-800 font-serif text-lg">New Matches For You</h3>
                    <a href="#" class="text-rani-primary text-sm font-medium hover:underline">See all</a>
                </div>
                <div class="p-6 text-center text-gray-500 py-12">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-full bg-gray-100 mb-4">
                        <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <p class="text-sm">We are analyzing your preferences to find the best matches.<br>Check back soon!</p>
                </div>
            </div>

        </div>

        <!-- Right Column: Ads & Notifications -->
        <div class="w-full lg:w-1/4 flex flex-col gap-6">
            
            <!-- VIP Banner -->
            <div class="bg-white rounded-xl shadow-sm border border-rani-gold overflow-hidden relative group cursor-pointer">
                <div class="bg-rani-light/50 p-6 flex flex-col items-center text-center border-b border-gray-100">
                    <div class="flex items-center gap-1 mb-1">
                        <svg class="w-5 h-5 text-rani-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                        <h3 class="font-serif font-bold text-rani-primary-dark tracking-wide">VIP RANI</h3>
                    </div>
                    <p class="text-[10px] text-gray-500 uppercase tracking-widest mb-4">Matchmaking Service for Elites</p>
                    
                    <ul class="text-xs text-gray-600 text-left space-y-2 mb-6">
                        <li class="flex items-start gap-1">
                            <span class="text-rani-gold mt-0.5">•</span> Top Rated Consultants
                        </li>
                        <li class="flex items-start gap-1">
                            <span class="text-rani-gold mt-0.5">•</span> 5X Success Rates
                        </li>
                        <li class="flex items-start gap-1">
                            <span class="text-rani-gold mt-0.5">•</span> Handpicked Matches
                        </li>
                    </ul>
                    
                    <button class="bg-rani-primary text-white w-full py-2 rounded-full font-bold text-sm shadow-sm group-hover:bg-rani-primary-dark transition-colors">Know More</button>
                </div>
                <!-- Mock image of consultant -->
                <div class="h-32 bg-gray-200 overflow-hidden">
                    <img src="https://images.unsplash.com/photo-1560250097-0b93528c311a?auto=format&fit=crop&q=80&w=400&h=300" class="w-full h-full object-cover opacity-90 group-hover:scale-105 transition-transform duration-500" alt="Consultant">
                </div>
            </div>

            <!-- Notifications -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-5 py-4 border-b border-gray-100 flex items-center justify-between">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
                        <h3 class="font-bold text-gray-800 text-base">Notifications</h3>
                    </div>
                    <span class="bg-rani-primary text-white text-[10px] px-1.5 py-0.5 rounded font-bold">2</span>
                </div>
                <div class="divide-y divide-gray-50">
                    <!-- Notification 1 -->
                    <div class="p-4 flex gap-3 hover:bg-gray-50 cursor-pointer transition-colors">
                        <img src="https://ui-avatars.com/api/?name=Anjali+M&background=fdf2f8&color=db2777" class="w-10 h-10 rounded-full shrink-0">
                        <div>
                            <p class="text-sm text-gray-700 leading-snug"><span class="font-semibold text-rani-primary">Anjali M</span> has viewed your profile.</p>
                            <p class="text-xs text-gray-400 mt-1">2 hours ago</p>
                        </div>
                    </div>
                    <!-- Notification 2 -->
                    <div class="p-4 flex gap-3 hover:bg-gray-50 cursor-pointer transition-colors">
                        <img src="https://ui-avatars.com/api/?name=Rahul+D&background=eff6ff&color=1d4ed8" class="w-10 h-10 rounded-full shrink-0">
                        <div>
                            <p class="text-sm text-gray-700 leading-snug"><span class="font-semibold text-rani-primary">Rahul D</span> sent you an Interest.</p>
                            <p class="text-xs text-gray-400 mt-1">Yesterday</p>
                        </div>
                    </div>
                </div>
                <a href="#" class="block w-full text-center py-3 text-sm text-rani-primary font-medium hover:bg-gray-50 transition-colors border-t border-gray-100">View All</a>
            </div>

        </div>

    </div>
</div>
@endsection
