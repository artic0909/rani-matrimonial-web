@extends('frontend.layouts.auth_app')

@php
    $profileCode = $profile->getDisplayCodeAttribute();
    $profileAge = $profile->dob ? \Carbon\Carbon::parse($profile->dob)->age : '26';
    $profileName = trim(($profile->first_name ?? 'Candidate') . ' ' . ($profile->last_name ?? ''));
    $profileProfession = $profile->profession ?? ($profile->highest_qualification ?? 'Professional');
    $profileCity = $profile->city ?? 'India';
    $profileLocation = $profile->city ? ($profile->city . ($profile->state ? ', ' . $profile->state : '')) : ($profile->state ?? 'India');
    $cleanMobile = preg_replace('/[^0-9]/', '', $profile->mobile ?? '');
    $whatsappMobile = strlen($cleanMobile) === 10 ? '91' . $cleanMobile : (str_starts_with($cleanMobile, '91') ? $cleanMobile : '91' . ltrim($cleanMobile, '0'));
@endphp

@section('title', $profileName . ' (' . $profileCode . ') | Rani Matrimonial')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 sm:py-6" 
     x-data="profileViewManager()">

    <!-- Top Navigation & Breadcrumbs Bar -->
    <div class="flex flex-wrap items-center justify-between gap-4 mb-6 pb-4 border-b border-gray-200">
        <div class="flex items-center gap-2 text-sm">
            <a href="{{ route('matches', ['tab' => $isAccepted ? 'accepted' : 'my_matches']) }}" class="inline-flex items-center gap-1.5 font-bold text-rani-primary hover:text-rani-primary-dark transition-colors group">
                <svg class="w-4 h-4 transform group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                <span>Back to Matches</span>
            </a>
            <span class="text-gray-300">/</span>
            <span class="text-gray-500 font-medium truncate">{{ $profileName }} ({{ $profileCode }})</span>
        </div>

        <div class="flex items-center gap-2.5">
            <!-- Shortlist Button -->
            <button type="button" 
                    @click="toggleShortlist()" 
                    class="px-4 py-2 rounded-full border text-xs font-bold flex items-center gap-1.5 transition-all shadow-sm"
                    :class="shortlisted ? 'bg-rose-50 border-rose-300 text-rose-600 hover:bg-rose-100' : 'bg-white border-gray-300 text-gray-700 hover:border-rani-gold hover:text-rani-primary'">
                <svg class="w-4 h-4" :fill="shortlisted ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                <span x-text="shortlisted ? 'Shortlisted' : 'Shortlist Profile'"></span>
            </button>

            <!-- Share Profile Link -->
            <button type="button" 
                    @click="copyToClipboard(window.location.href, 'Profile Link')" 
                    class="px-4 py-2 rounded-full bg-white border border-gray-300 hover:border-rani-gold text-gray-700 hover:text-rani-primary text-xs font-bold flex items-center gap-1.5 transition-all shadow-sm">
                <svg class="w-4 h-4 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path></svg>
                <span>Share</span>
            </button>
        </div>
    </div>

    <!-- Status Banner for Accepted Match -->
    @if($isAccepted)
    <div class="mb-8 rounded-2xl bg-gradient-to-r from-emerald-900 via-teal-900 to-emerald-950 p-5 sm:p-6 text-white shadow-xl border border-emerald-500/40 relative overflow-hidden flex flex-col md:flex-row items-center justify-between gap-4">
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-emerald-500/10 rounded-full blur-3xl pointer-events-none"></div>
        <div class="flex items-center gap-4 relative z-10">
            <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-emerald-400 to-emerald-600 flex items-center justify-center text-white shadow-lg flex-shrink-0">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <div class="inline-flex items-center gap-2 bg-emerald-500/20 text-emerald-300 px-3 py-0.5 rounded-full text-xs font-extrabold uppercase tracking-wider mb-1 border border-emerald-400/30">
                    <span class="w-2 h-2 rounded-full bg-emerald-400 animate-ping"></span>
                    Mutual Connection Established
                </div>
                <h3 class="text-xl sm:text-2xl font-serif font-bold text-white">Full Profile & Verified Contacts Unlocked</h3>
                <p class="text-xs sm:text-sm text-emerald-200 font-light">You and {{ $profile->first_name }} have mutually accepted. Direct phone, WhatsApp, and family particulars are fully disclosed below.</p>
            </div>
        </div>

        <div class="flex items-center gap-3 w-full md:w-auto relative z-10">
            <a href="https://wa.me/{{ $whatsappMobile }}?text={{ urlencode('Namaste ' . $profile->first_name . ', I connected with your profile (' . $profileCode . ') on Rani Matrimonial.') }}" 
               target="_blank" 
               class="flex-1 md:flex-initial px-6 py-3 rounded-xl bg-gradient-to-r from-[#25D366] to-[#128C7E] hover:from-[#128C7E] hover:to-[#25D366] text-white font-bold text-sm flex items-center justify-center gap-2 shadow-lg shadow-emerald-950/50 transform hover:-translate-y-0.5 transition-all">
                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                <span>Chat on WhatsApp</span>
            </a>
            <a href="tel:+91{{ $cleanMobile }}" 
               class="flex-1 md:flex-initial px-6 py-3 rounded-xl bg-white hover:bg-gray-100 text-gray-900 font-bold text-sm flex items-center justify-center gap-2 shadow-lg transition-all">
                <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.15 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                <span>Call Now</span>
            </a>
        </div>
    </div>
    @endif

    <!-- Main Profile Layout Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-start">
        
        <!-- LEFT COLUMN: Sticky Photo Showcase & Snapshot Card -->
        <div class="lg:col-span-4 space-y-6 lg:sticky lg:top-[160px]">
            
            <!-- Photo Card -->
            <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-100 p-4">
                
                <!-- Main Featured Photo with Lightbox trigger -->
                <div class="relative w-full aspect-[4/5] rounded-2xl overflow-hidden bg-gray-900 group cursor-pointer" 
                     @click="lightboxOpen = true">
                    <img :src="photos[activePhotoIndex] || '{{ $photo }}'" 
                         src="{{ $photo }}"
                         alt="{{ $profileName }}" 
                         onerror="this.src='{{ asset('img/' . (strtolower($profile->gender ?? 'female') === 'female' ? 'female' : 'male') . '/correct1.png') }}'"
                         class="w-full h-full object-cover object-top transition-transform duration-500 group-hover:scale-105">
                    
                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-transparent to-black/20 pointer-events-none"></div>

                    <!-- Verified Badge -->
                    @if($profile->selfie_verified)
                    <div class="absolute top-3 left-3 bg-emerald-500 text-white text-[11px] font-extrabold px-3 py-1 rounded-full shadow-lg flex items-center gap-1.5 backdrop-blur-md">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        <span>Verified Profile</span>
                    </div>
                    @endif

                    <!-- Zoom Icon Trigger -->
                    <div class="absolute bottom-3 right-3 bg-black/60 hover:bg-black/80 text-white text-xs p-2 rounded-full backdrop-blur-md transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                    </div>

                    <!-- Active Image Index Tag -->
                    <div class="absolute bottom-3 left-3 text-white/90 text-xs font-semibold px-2.5 py-0.5 rounded-full bg-black/50 backdrop-blur-md">
                        <span x-text="(activePhotoIndex + 1) + ' / ' + photos.length"></span> Photos
                    </div>
                </div>

                <!-- Thumbnail Strip -->
                <div class="grid grid-cols-4 gap-2 mt-3" x-show="photos.length > 1">
                    <template x-for="(pic, idx) in photos" :key="idx">
                        <button type="button" 
                                @click="activePhotoIndex = idx" 
                                class="relative aspect-square rounded-xl overflow-hidden border-2 transition-all bg-gray-100"
                                :class="activePhotoIndex === idx ? 'border-rani-gold shadow-md scale-95' : 'border-transparent opacity-60 hover:opacity-100'">
                            <img :src="pic" 
                                 onerror="this.src='{{ asset('img/' . (strtolower($profile->gender ?? 'female') === 'female' ? 'female' : 'male') . '/correct1.png') }}'" 
                                 class="w-full h-full object-cover">
                        </button>
                    </template>
                </div>

                <!-- Match Compatibility Bar -->
                <div class="mt-5 p-4 rounded-2xl bg-gradient-to-br from-[#5C0A0A]/5 via-amber-500/5 to-rani-gold/10 border border-rani-gold/30">
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs font-bold uppercase tracking-wider text-rani-primary">Compatibility Score</span>
                        <span class="text-base font-extrabold text-rani-primary font-serif">{{ $matchResult['score'] }}% Match</span>
                    </div>
                    <div class="w-full h-2.5 bg-gray-200 rounded-full overflow-hidden p-0.5">
                        <div class="h-full bg-gradient-to-r from-rani-primary via-rani-gold to-amber-500 rounded-full transition-all duration-1000" style="width: {{ $matchResult['score'] }}%;"></div>
                    </div>
                    <div class="flex flex-wrap gap-1.5 mt-3">
                        @foreach($matchResult['reasons'] as $reason)
                        <span class="text-[10px] font-bold px-2 py-0.5 rounded-md bg-white text-rani-primary-dark border border-rani-gold/40 shadow-xs">{{ $reason }}</span>
                        @endforeach
                    </div>
                </div>

                <!-- Main CTA Action Box -->
                <div class="mt-5 pt-4 border-t border-gray-100 space-y-2.5">
                    @if($isAccepted)
                        <div class="w-full py-3 px-4 rounded-xl bg-emerald-50 border border-emerald-300 text-emerald-800 text-center font-bold text-xs flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                            <span>Connected & Unlocked</span>
                        </div>
                    @elseif($isPending)
                        @if($isSentByMe)
                            <div class="w-full py-3 px-4 rounded-xl bg-amber-50 border border-amber-300 text-amber-800 text-center font-bold text-xs flex items-center justify-center gap-2">
                                <svg class="w-4 h-4 text-amber-600 animate-spin" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path></svg>
                                <span>Interest Sent • Awaiting Response</span>
                            </div>
                        @else
                            <div class="grid grid-cols-2 gap-2">
                                <button type="button" @click="respondRequest('accept')" class="py-3 rounded-xl bg-gradient-to-r from-emerald-600 to-teal-600 hover:from-emerald-700 hover:to-teal-700 text-white font-bold text-xs shadow-md">
                                    Accept Request
                                </button>
                                <button type="button" @click="respondRequest('decline')" class="py-3 rounded-xl bg-gray-100 hover:bg-gray-200 text-gray-700 font-bold text-xs">
                                    Decline
                                </button>
                            </div>
                        @endif
                    @else
                        <button type="button" 
                                @click="sendConnect()"
                                class="w-full py-3.5 px-4 rounded-xl bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white font-bold text-sm shadow-lg shadow-rani-primary/30 transition-all flex items-center justify-center gap-2 hover:scale-[1.02]">
                            <svg class="w-4 h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                            <span>Send Connection Request</span>
                        </button>
                    @endif
                </div>

            </div>

        </div>

        <!-- RIGHT COLUMN: Detailed Profile Attributes & Verified Particulars -->
        <div class="lg:col-span-8 space-y-8">
            
            <!-- Hero Header Summary Card -->
            <div class="bg-white rounded-3xl shadow-xl p-6 sm:p-8 border border-gray-100 relative overflow-hidden">
                <div class="flex flex-wrap items-start justify-between gap-4 pb-6 border-b border-gray-100">
                    <div>
                        <div class="flex items-center gap-2.5">
                            <h1 class="text-2xl sm:text-3xl font-serif font-extrabold text-rani-primary-dark">{{ $profileName }}</h1>
                            @if($profile->selfie_verified)
                            <span class="inline-flex items-center justify-center w-6 h-6 rounded-full bg-emerald-500 text-white shadow" title="Selfie Verified by Admin">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                            </span>
                            @endif
                        </div>
                        <p class="text-sm font-semibold text-gray-500 mt-1 flex items-center gap-2">
                            <span>ID: <strong class="text-rani-primary font-bold">{{ $profileCode }}</strong></span>
                            <span>•</span>
                            <span>Profile created for <strong class="text-gray-700 capitalize">{{ $profile->profile_for ?: 'Self' }}</strong></span>
                        </p>
                    </div>

                    <div class="text-right">
                        <span class="inline-block px-3.5 py-1.5 rounded-full bg-rani-primary/10 text-rani-primary font-bold text-xs tracking-wide">
                            {{ $profile->religion }} • {{ $profile->community }}
                        </span>
                    </div>
                </div>

                <!-- Quick Highlights Grid -->
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-6">
                    <div class="p-3.5 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Age & Height</span>
                        <span class="text-sm font-bold text-gray-800 mt-0.5 block">{{ $profileAge }} yrs, {{ $profile->height ?: "5' 6\"" }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Location</span>
                        <span class="text-sm font-bold text-gray-800 mt-0.5 block truncate">{{ $profileLocation }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Profession</span>
                        <span class="text-sm font-bold text-gray-800 mt-0.5 block truncate">{{ $profileProfession }}</span>
                    </div>

                    <div class="p-3.5 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-[11px] font-bold text-gray-400 uppercase tracking-wider block">Annual Income</span>
                        <span class="text-sm font-bold text-emerald-700 mt-0.5 block truncate">{{ $profile->annual_income ?: ($profile->income_type ?: 'Confidential') }}</span>
                    </div>
                </div>
            </div>

            <!-- UNLOCKED CONTACT & RESIDENTIAL CARD (Highlighted for Accepted Match) -->
            @if($isAccepted)
            <div class="bg-gradient-to-br from-white via-emerald-50/40 to-teal-50/30 rounded-3xl shadow-xl p-6 sm:p-8 border-2 border-emerald-400/60 relative overflow-hidden">
                <div class="flex items-center gap-3 mb-6 pb-4 border-b border-emerald-200">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-md">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.15 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                    </div>
                    <div>
                        <h2 class="text-xl font-serif font-bold text-gray-900">Verified Contact Particulars</h2>
                        <p class="text-xs text-emerald-700 font-semibold">Direct Communication Channels Unlocked</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <!-- Mobile Number -->
                    <div class="p-4 rounded-2xl bg-white border border-emerald-200 shadow-xs flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-gray-400 block">Mobile Phone / WhatsApp</span>
                            <span class="text-base font-extrabold text-gray-900 mt-0.5 block">+91 {{ preg_replace('/(\d{5})(\d{5})/', '$1 $2', $cleanMobile) }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" @click="copyToClipboard('+91{{ $cleanMobile }}', 'Phone Number')" class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700" title="Copy Number">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                            </button>
                            <a href="tel:+91{{ $cleanMobile }}" class="p-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white" title="Call Now">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M6.62 10.79c1.44 2.83 3.76 5.15 6.59 6.59l2.2-2.2c.27-.27.67-.36 1.02-.24 1.12.37 2.33.57 3.57.57.55 0 1 .45 1 1V20c0 .55-.45 1-1 1-9.39 0-17-7.61-17-17 0-.55.45-1 1-1h3.5c.55 0 1 .45 1 1 0 1.25.2 2.45.57 3.57.11.35.03.74-.25 1.02l-2.2 2.2z"/></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Email Address -->
                    <div class="p-4 rounded-2xl bg-white border border-emerald-200 shadow-xs flex items-center justify-between">
                        <div>
                            <span class="text-xs font-bold text-gray-400 block">Verified Email Address</span>
                            <span class="text-base font-extrabold text-gray-900 mt-0.5 block truncate max-w-[200px] sm:max-w-none">{{ $profile->email }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <button type="button" @click="copyToClipboard('{{ $profile->email }}', 'Email Address')" class="p-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-gray-700" title="Copy Email">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M8 5a2 2 0 002 2h2a2 2 0 002-2M8 5a2 2 0 012-2h2a2 2 0 012 2m0 0h2a2 2 0 012 2v3m2 4H10m0 0l3-3m-3 3l3 3"></path></svg>
                            </button>
                            <a href="mailto:{{ $profile->email }}" class="p-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white" title="Send Email">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                            </a>
                        </div>
                    </div>

                    <!-- Full Residential Address -->
                    <div class="p-4 rounded-2xl bg-white border border-emerald-200 shadow-xs sm:col-span-2">
                        <span class="text-xs font-bold text-gray-400 block mb-1">Full Residential Address</span>
                        <p class="text-sm font-semibold text-gray-800 leading-relaxed">{{ $profile->full_address ?: ($profile->city . ', ' . $profile->state . ', India') }}</p>
                        
                        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 mt-3 pt-3 border-t border-gray-100 text-xs">
                            <div>
                                <span class="text-gray-400 block">City & State</span>
                                <strong class="text-gray-700">{{ $profile->city }}, {{ $profile->state }}</strong>
                            </div>
                            <div>
                                <span class="text-gray-400 block">Pincode / Zip</span>
                                <strong class="text-gray-700">{{ $profile->pincode ?: ($profile->zip_code ?: '400001') }}</strong>
                            </div>
                            <div>
                                <span class="text-gray-400 block">Police Station</span>
                                <strong class="text-gray-700">{{ $profile->police_st ?: 'Local Station' }}</strong>
                            </div>
                            <div>
                                <span class="text-gray-400 block">Residency Status</span>
                                <strong class="text-gray-700">{{ $profile->residency_status ?: 'Citizen' }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- 1. About Yourself & Personality -->
            <div class="bg-white rounded-3xl shadow-xl p-6 sm:p-8 border border-gray-100">
                <h3 class="text-xl font-serif font-bold text-rani-primary-dark mb-4 flex items-center gap-2">
                    <svg class="w-5 h-5 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                    <span>About Myself</span>
                </h3>
                <p class="text-gray-700 text-sm sm:text-base leading-relaxed font-light whitespace-pre-line">
                    {{ $profile->about_yourself ?: 'I am a value-oriented, grounded individual looking for a caring, understanding partner to embark on a beautiful life journey together.' }}
                </p>

                @if(!empty($profile->hobbies_interests) && is_array($profile->hobbies_interests))
                <div class="mt-6 pt-6 border-t border-gray-100">
                    <h4 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-3">Hobbies & Interests</h4>
                    <div class="flex flex-wrap gap-2">
                        @foreach($profile->hobbies_interests as $hobby)
                        <span class="px-3.5 py-1.5 rounded-full bg-rani-primary/5 border border-rani-gold/30 text-rani-primary-dark font-semibold text-xs shadow-2xs">
                            ✨ {{ $hobby }}
                        </span>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>

            <!-- 2. Education & Career Information -->
            <div class="bg-white rounded-3xl shadow-xl p-6 sm:p-8 border border-gray-100">
                <h3 class="text-xl font-serif font-bold text-rani-primary-dark mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    <span>Education & Career Details</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 block">Highest Qualification</span>
                        <strong class="text-base text-gray-800 font-bold mt-1 block">{{ $profile->highest_qualification ?: 'Graduate' }}</strong>
                    </div>

                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 block">College / Institute Name</span>
                        <strong class="text-base text-gray-800 font-bold mt-1 block">{{ $profile->college_name ?: 'Reputed University' }}</strong>
                    </div>

                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 block">Working Sector</span>
                        <strong class="text-base text-gray-800 font-bold mt-1 block">{{ $profile->working_with ?: 'Private Company' }}</strong>
                    </div>

                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 block">Profession / Role</span>
                        <strong class="text-base text-gray-800 font-bold mt-1 block">{{ $profile->profession ?: 'Professional' }}</strong>
                    </div>

                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 block">Designation</span>
                        <strong class="text-base text-gray-800 font-bold mt-1 block">{{ $profile->designation ?: 'Senior Executive' }}</strong>
                    </div>

                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 block">Employer / Company Name</span>
                        <strong class="text-base text-gray-800 font-bold mt-1 block">{{ $profile->company_name ?: 'Established Organization' }}</strong>
                    </div>

                    <div class="p-4 rounded-2xl bg-emerald-50/50 border border-emerald-200 sm:col-span-2">
                        <span class="text-xs font-bold text-emerald-800 block">Annual Income</span>
                        <strong class="text-lg text-emerald-700 font-extrabold mt-1 block">{{ $profile->annual_income ?: ($profile->income_type ?: '₹ 20 - 30 Lakh') }}</strong>
                    </div>
                </div>
            </div>

            <!-- 3. Family Particulars & Background -->
            <div class="bg-white rounded-3xl shadow-xl p-6 sm:p-8 border border-gray-100">
                <h3 class="text-xl font-serif font-bold text-rani-primary-dark mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                    <span>Family Particulars</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 text-sm">
                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 block">Father's Profession</span>
                        <strong class="text-base text-gray-800 font-bold mt-1 block">{{ $profile->father_profession ?: 'Businessman' }}</strong>
                    </div>

                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 block">Mother's Profession</span>
                        <strong class="text-base text-gray-800 font-bold mt-1 block">{{ $profile->mother_profession ?: 'Homemaker' }}</strong>
                    </div>

                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 block">Family Location / Origin</span>
                        <strong class="text-base text-gray-800 font-bold mt-1 block">{{ $profile->family_location ?: ($profile->city . ', ' . $profile->state) }}</strong>
                    </div>

                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 block">Financial Status</span>
                        <strong class="text-base text-gray-800 font-bold mt-1 block">{{ $profile->family_financial_status ?: 'Upper Middle Class' }}</strong>
                    </div>

                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 block">Brothers</span>
                        <strong class="text-base text-gray-800 font-bold mt-1 block">{{ $profile->brothers_count ?? '1' }} Brother(s)</strong>
                    </div>

                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 block">Sisters</span>
                        <strong class="text-base text-gray-800 font-bold mt-1 block">{{ $profile->sisters_count ?? '0' }} Sister(s)</strong>
                    </div>
                </div>
            </div>

            <!-- 4. Horoscope & Astro Details -->
            <div class="bg-white rounded-3xl shadow-xl p-6 sm:p-8 border border-gray-100">
                <h3 class="text-xl font-serif font-bold text-rani-primary-dark mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"></path></svg>
                    <span>Horoscope & Astro Particulars</span>
                </h3>

                <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 text-sm">
                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 block">Gothra</span>
                        <strong class="text-base text-gray-800 font-bold mt-1 block">{{ $profile->gothra ?: 'Kashyap' }}</strong>
                    </div>

                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 block">Manglik Status</span>
                        <strong class="text-base text-gray-800 font-bold mt-1 block">{{ $profile->manglik ?: 'Non-Manglik' }}</strong>
                    </div>

                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 block">Time of Birth</span>
                        <strong class="text-base text-gray-800 font-bold mt-1 block">{{ $profile->time_of_birth ?: '08:30 AM' }}</strong>
                    </div>

                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 block">City of Birth</span>
                        <strong class="text-base text-gray-800 font-bold mt-1 block">{{ $profile->city_of_birth ?: ($profile->city ?? 'Mumbai') }}</strong>
                    </div>
                </div>
            </div>

            <!-- 5. Basic Lifestyle, Religious & Health Particulars -->
            <div class="bg-white rounded-3xl shadow-xl p-6 sm:p-8 border border-gray-100">
                <h3 class="text-xl font-serif font-bold text-rani-primary-dark mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                    <span>Basic Lifestyle & Health Particulars</span>
                </h3>

                <div class="grid grid-cols-2 sm:grid-cols-3 gap-5 text-sm">
                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 block">Marital Status</span>
                        <strong class="text-base text-gray-800 font-bold mt-1 block">{{ $profile->marital_status ?: 'Never Married' }}</strong>
                    </div>

                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 block">Diet Preference</span>
                        <strong class="text-base text-gray-800 font-bold mt-1 block">{{ $profile->diet ?: 'Vegetarian' }}</strong>
                    </div>

                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 block">Mother Tongue</span>
                        <strong class="text-base text-gray-800 font-bold mt-1 block">{{ $profile->mother_tongue ?: 'Hindi' }}</strong>
                    </div>

                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 block">Blood Group</span>
                        <strong class="text-base text-gray-800 font-bold mt-1 block">{{ $profile->blood_group ?: 'O+' }}</strong>
                    </div>

                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 block">Grew Up In</span>
                        <strong class="text-base text-gray-800 font-bold mt-1 block">{{ $profile->grew_up_in ?: ($profile->city . ', India') }}</strong>
                    </div>

                    <div class="p-4 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-xs font-bold text-gray-400 block">Health & Disability</span>
                        <strong class="text-base text-gray-800 font-bold mt-1 block">{{ $profile->disability ?: 'Normal / Healthy' }}</strong>
                    </div>
                </div>
            </div>

            <!-- 6. Partner Preferences -->
            <div class="bg-white rounded-3xl shadow-xl p-6 sm:p-8 border border-gray-100">
                <h3 class="text-xl font-serif font-bold text-rani-primary-dark mb-6 flex items-center gap-2">
                    <svg class="w-5 h-5 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h4.764a2 2 0 011.789 2.894l-3.5 7A2 2 0 0115.263 21h-4.017c-.163 0-.326-.02-.485-.06L7 20m7-10V5a2 2 0 00-2-2h-.095c-.5 0-.905.405-.905.905 0 .714-.211 1.412-.608 2.006L7 11v9m7-10h-2M7 20H5a2 2 0 01-2-2v-6a2 2 0 012-2h2.5"></path></svg>
                    <span>Desired Partner Preferences</span>
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-gray-500 text-xs font-medium">Preferred Age</span>
                        <strong class="text-gray-800 text-xs font-bold">{{ ($profile->pref_age_min ?? '21') . ' - ' . ($profile->pref_age_max ?? '32') . ' yrs' }}</strong>
                    </div>

                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-gray-500 text-xs font-medium">Preferred Height</span>
                        <strong class="text-gray-800 text-xs font-bold">{{ ($profile->pref_height_min ?? "4' 10\"") . ' - ' . ($profile->pref_height_max ?? "6' 2\"") }}</strong>
                    </div>

                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-gray-500 text-xs font-medium">Religion</span>
                        <strong class="text-gray-800 text-xs font-bold">{{ $profile->pref_religion ?: ($profile->religion ?: 'Any') }}</strong>
                    </div>

                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-gray-500 text-xs font-medium">Community</span>
                        <strong class="text-gray-800 text-xs font-bold">{{ $profile->pref_community ?: 'Any Community' }}</strong>
                    </div>

                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-gray-500 text-xs font-medium">Marital Status</span>
                        <strong class="text-gray-800 text-xs font-bold">{{ $profile->pref_marital_status ?: 'Never Married' }}</strong>
                    </div>

                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-gray-500 text-xs font-medium">Preferred Location</span>
                        <strong class="text-gray-800 text-xs font-bold truncate max-w-[160px]">{{ $profile->pref_city ?: ($profile->pref_state ?: ($profile->pref_country ?: 'Any Location')) }}</strong>
                    </div>

                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-gray-500 text-xs font-medium">Min. Qualification</span>
                        <strong class="text-gray-800 text-xs font-bold">{{ $profile->pref_education ?: 'Graduate & Above' }}</strong>
                    </div>

                    <div class="flex items-center justify-between p-3.5 rounded-2xl bg-gray-50 border border-gray-100">
                        <span class="text-gray-500 text-xs font-medium">Annual Income</span>
                        <strong class="text-emerald-700 text-xs font-bold">{{ $profile->pref_annual_income ?: '₹ 10 Lakh & above' }}</strong>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <!-- FULLSCREEN PHOTO LIGHTBOX MODAL -->
    <div x-show="lightboxOpen" 
         style="display: none;" 
         class="fixed inset-0 z-[200] bg-black/95 backdrop-blur-md flex items-center justify-center p-4"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         @keydown.escape.window="lightboxOpen = false">
        
        <!-- Close Button -->
        <button type="button" 
                @click="lightboxOpen = false" 
                class="absolute top-5 right-5 text-white/70 hover:text-white bg-white/10 hover:bg-white/20 p-2.5 rounded-full transition-all z-20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>

        <!-- Prev Button -->
        <button type="button" 
                x-show="photos.length > 1"
                @click="activePhotoIndex = (activePhotoIndex === 0) ? (photos.length - 1) : (activePhotoIndex - 1)" 
                class="absolute left-4 top-1/2 -translate-y-1/2 text-white/80 hover:text-white bg-black/40 hover:bg-black/80 p-3 rounded-full transition-all z-20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
        </button>

        <!-- Main Lightbox Image -->
        <div class="max-w-4xl max-h-[85vh] overflow-hidden rounded-2xl relative shadow-2xl">
            <img :src="photos[activePhotoIndex]" class="max-w-full max-h-[85vh] object-contain mx-auto">
        </div>

        <!-- Next Button -->
        <button type="button" 
                x-show="photos.length > 1"
                @click="activePhotoIndex = (activePhotoIndex === photos.length - 1) ? 0 : (activePhotoIndex + 1)" 
                class="absolute right-4 top-1/2 -translate-y-1/2 text-white/80 hover:text-white bg-black/40 hover:bg-black/80 p-3 rounded-full transition-all z-20">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
        </button>
    </div>

</div>

<!-- Alpine Profile View Manager Script -->
<script>
function profileViewManager() {
    return {
        activePhotoIndex: 0,
        photos: @json($allPhotos),
        lightboxOpen: false,
        shortlisted: {{ $isShortlisted ? 'true' : 'false' }},
        isAccepted: {{ $isAccepted ? 'true' : 'false' }},
        isPending: {{ $isPending ? 'true' : 'false' }},
        isSentByMe: {{ $isSentByMe ? 'true' : 'false' }},
        isReceivedByMe: {{ $isReceivedByMe ? 'true' : 'false' }},

        async toggleShortlist() {
            try {
                const res = await fetch('{{ route('matches.shortlist') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ profile_id: '{{ $profileCode }}' })
                });
                const data = await res.json();
                if (data.success) {
                    this.shortlisted = data.shortlisted;
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: this.shortlisted ? 'Profile Shortlisted!' : 'Removed from Shortlist',
                            text: data.message,
                            timer: 1800,
                            showConfirmButton: false,
                            customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title' }
                        });
                    }
                }
            } catch (e) {
                console.error('Shortlist error:', e);
            }
        },

        async sendConnect() {
            try {
                const res = await fetch('{{ route('matches.send-interest') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ profile_id: '{{ $profileCode }}' })
                });
                const data = await res.json();
                if (data.success) {
                    this.isPending = true;
                    this.isSentByMe = true;
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Connection Request Sent!',
                            html: '<p class="text-sm">Your request has been dispatched to <strong>{{ $profile->first_name }}</strong> via WhatsApp.</p>',
                            confirmButtonText: 'Great',
                            customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                        });
                    }
                } else if (data.insufficient_balance) {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'warning',
                            title: data.title || 'Insufficient Wallet Balance',
                            html: '<div class="text-left bg-black/40 border border-amber-500/30 rounded-xl p-3.5 mt-2"><p class="text-sm text-amber-200 leading-relaxed font-medium">' + data.message + '</p></div>',
                            showCancelButton: true,
                            confirmButtonText: '💳 Recharge Wallet Now',
                            cancelButtonText: 'Maybe Later',
                            customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm', cancelButton: 'rani-swal-cancel' }
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = data.redirect || '{{ route('wallet') }}';
                            }
                        });
                    }
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({ icon: 'error', title: 'Notice', text: data.message || 'Error occurred.' });
                    }
                }
            } catch (e) {
                console.error('Send connect error:', e);
            }
        },

        async respondRequest(action) {
            try {
                const res = await fetch('{{ route('matches.respond-interest') }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({ profile_id: '{{ $profileCode }}', action: action })
                });
                const data = await res.json();
                if (data.success) {
                    if (action === 'accept') {
                        this.isAccepted = true;
                        this.isPending = false;
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Connection Accepted!',
                                html: '<p class="text-sm">You are now mutually connected with <strong>{{ $profile->first_name }}</strong>. All verified contact and confidential details are unlocked!</p>',
                                confirmButtonText: 'View Details',
                                customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            window.location.reload();
                        }
                    } else {
                        window.location.href = '{{ route('matches') }}';
                    }
                }
            } catch (e) {
                console.error('Respond request error:', e);
            }
        },

        copyToClipboard(text, label) {
            navigator.clipboard.writeText(text);
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    icon: 'success',
                    title: label + ' Copied!',
                    timer: 1400,
                    showConfirmButton: false,
                    customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title' }
                });
            }
        }
    };
}
</script>
@endsection
