@extends('frontend.layouts.auth_app')

@section('title', 'Inbox & Connection Requests | Rani Matrimonial')

@section('content')
<div class="relative pt-6 pb-20" x-data="inboxManager({
    subTab: '{{ $subTab }}',
    matches: @js($receivedMatches),
    candidate: @js($candidate),
    counts: @js($counts)
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
        <div class="heart-floating heart-maroon delay-1" style="left: 20%; animation-delay: 7s;"></div>
        <div class="heart-floating delay-3" style="left: 70%; animation-delay: 4s;"></div>
    </div>

    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Main Container Card -->
        <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl border border-white/60 mb-10 overflow-hidden relative z-10">
            
            <!-- Royal accent top bar -->
            <div class="absolute top-0 left-0 w-full h-2.5 bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-95"></div>
            
            <!-- Page Header & Filter Toolbar -->
            <div class="px-6 md:px-10 pt-8 pb-6 border-b border-gray-100 flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-rani-gold to-yellow-500 flex items-center justify-center text-rani-dark shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold font-serif text-rani-primary-dark tracking-wide">Inbox & Requests</h1>
                            <p class="text-xs text-gray-500 font-sans mt-0.5">Candidates who have expressed interest in connecting with your profile</p>
                        </div>
                    </div>
                </div>

                <!-- Search Filter -->
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <div class="relative flex-1 md:w-64">
                        <input type="text" 
                               x-model="searchQuery" 
                               placeholder="Search name, city, job..." 
                               class="w-full pl-9 pr-4 py-2 text-xs md:text-sm rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-rani-gold focus:border-transparent bg-white shadow-sm">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                </div>
            </div>

            <!-- In-Page Secondary Sub-Header Tabs -->
            <div class="px-6 md:px-10 pt-4 pb-2 bg-gray-50/70 border-b border-gray-100 flex items-center justify-between overflow-x-auto">
                <div class="flex items-center space-x-2 py-1">
                    <a href="{{ route('inbox', ['tab' => 'received']) }}" 
                       class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 flex items-center gap-1.5 whitespace-nowrap {{ $subTab === 'received' ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white shadow-md' : 'text-gray-600 hover:text-rani-primary hover:bg-white' }}">
                        <span>Received Interests</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $subTab === 'received' ? 'bg-rani-gold text-rani-dark font-extrabold' : 'bg-amber-100 text-amber-800 font-bold' }}">{{ $counts['pending'] }}</span>
                    </a>

                    <a href="{{ route('inbox', ['tab' => 'accepted']) }}" 
                       class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 flex items-center gap-1.5 whitespace-nowrap {{ $subTab === 'accepted' ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white shadow-md' : 'text-gray-600 hover:text-rani-primary hover:bg-white' }}">
                        <span>Accepted</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $subTab === 'accepted' ? 'bg-white/20 text-white' : 'bg-emerald-100 text-emerald-800 font-bold' }}">{{ $counts['accepted'] }}</span>
                    </a>

                    <a href="{{ route('inbox', ['tab' => 'declined']) }}" 
                       class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 flex items-center gap-1.5 whitespace-nowrap {{ $subTab === 'declined' ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white shadow-md' : 'text-gray-600 hover:text-rani-primary hover:bg-white' }}">
                        <span>Declined</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $subTab === 'declined' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700' }}">{{ $counts['declined'] }}</span>
                    </a>
                </div>

                <div class="hidden sm:flex items-center gap-2 text-xs text-gray-500 font-medium">
                    <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                    <span x-text="filteredMatches.length + ' Received Requests'"></span>
                </div>
            </div>

            <!-- Inbox Feed Grid -->
            <div class="p-6 md:p-10">
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <template x-for="match in filteredMatches" :key="match.id">
                        <div class="bg-white rounded-3xl border border-rani-gold/40 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden flex flex-col justify-between group ring-2 ring-rani-gold/30">
                            
                            <div>
                                <!-- Image & Spotlight Badges Container (Click to open Photo Gallery Modal) -->
                                <div class="relative h-64 sm:h-72 w-full overflow-hidden bg-gray-100 cursor-pointer group/photo select-none"
                                     @click="match.is_accepted ? openFullProfile(match) : openPhotoGallery(match, 0)"
                                     :title="match.is_accepted ? 'Click to view complete unlocked profile' : 'Click to view profile photos'">
                                     
                                    <img :src="match.photo" 
                                         :alt="match.first_name" 
                                         class="w-full h-full object-cover object-top transition-transform duration-700 group-hover/photo:scale-105">
                                    
                                    <!-- Top Gradient Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent pointer-events-none"></div>

                                    <!-- Top Left: Received Interest Badge -->
                                    <div class="absolute top-3 left-3 flex flex-col gap-1.5 z-10">
                                        <template x-if="match.is_accepted">
                                            <span class="px-3 py-1 rounded-full bg-gradient-to-r from-emerald-600 to-teal-700 text-white text-xs font-bold shadow-md flex items-center gap-1.5 border border-emerald-300/40">
                                                <svg class="w-3.5 h-3.5 text-emerald-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                                <span>Accepted Connection</span>
                                            </span>
                                        </template>

                                        <template x-if="!match.is_accepted && match.status !== 'declined'">
                                            <span class="px-3 py-1 rounded-full bg-gradient-to-r from-rani-gold via-yellow-400 to-rani-gold text-rani-dark text-xs font-bold shadow-md flex items-center gap-1.5 border border-white/60 animate-pulse-slow">
                                                <svg class="w-3.5 h-3.5 text-rani-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                                                <span>Received Interest</span>
                                            </span>
                                        </template>

                                        <template x-if="match.status === 'declined'">
                                            <span class="px-3 py-1 rounded-full bg-gray-700 text-white text-xs font-bold shadow-md">
                                                <span>Declined</span>
                                            </span>
                                        </template>

                                        <span class="px-2.5 py-0.5 rounded-full bg-black/60 backdrop-blur-xs text-rani-gold text-[10px] font-semibold tracking-wide" x-text="'Received ' + match.received_ago"></span>
                                    </div>

                                    <!-- Bottom Image Overlay Text: Name & ID -->
                                    <div class="absolute bottom-3 left-4 right-4 text-white z-10 flex items-end justify-between">
                                        <div class="max-w-[70%]">
                                            <div class="flex items-center gap-2">
                                                <h3 class="text-xl font-bold font-serif drop-shadow-md truncate" x-text="match.first_name + ' ' + match.last_name"></h3>
                                                <svg x-show="match.verified" class="w-4 h-4 text-sky-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            </div>
                                            <div class="flex items-center gap-2 text-xs text-gray-200 font-mono mt-0.5">
                                                <span x-text="'ID: ' + match.id"></span>
                                                <span>•</span>
                                                <span x-text="match.match_score + '% Match'"></span>
                                            </div>
                                        </div>

                                        <!-- Photo Count Badge -->
                                        <div class="shrink-0">
                                            <span class="px-2.5 py-1 rounded-full bg-black/60 backdrop-blur-xs text-white text-[11px] font-semibold flex items-center gap-1 border border-white/20 group-hover/photo:bg-rani-primary group-hover/photo:border-rani-gold transition-colors shadow-sm">
                                                <svg class="w-3.5 h-3.5 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <span x-text="(match.photos ? match.photos.length : 1) + ' Photos'"></span>
                                            </span>
                                        </div>
                                    </div>

                                </div>

                                <!-- Card Bio & Particulars -->
                                <div class="p-5 space-y-3.5">
                                    
                                    <!-- Basic Specs Grid -->
                                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-700 bg-amber-50/50 p-3 rounded-2xl border border-amber-200/50">
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-gray-400">Age / Ht:</span>
                                            <span class="font-bold" x-text="match.age + ' yrs, ' + match.height"></span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-gray-400">Religion:</span>
                                            <span class="font-bold truncate" x-text="match.religion + ', ' + match.community"></span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-gray-400">Tongue:</span>
                                            <span class="font-bold truncate" x-text="match.mother_tongue"></span>
                                        </div>
                                        <div class="flex items-center gap-1.5">
                                            <span class="text-gray-400">Diet:</span>
                                            <span class="font-bold truncate" x-text="match.diet"></span>
                                        </div>
                                    </div>

                                    <!-- Career & Education -->
                                    <div class="space-y-1.5 text-xs">
                                        <div class="flex items-start gap-2 text-gray-800">
                                            <svg class="w-4 h-4 text-rani-primary shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                            <div class="truncate">
                                                <p class="font-bold text-gray-900 truncate" x-text="match.profession"></p>
                                                <p class="text-gray-500 text-[11px] truncate" x-text="match.company_name + ' • ' + match.annual_income"></p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-2 text-gray-600">
                                            <svg class="w-4 h-4 text-rani-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                                            <span class="truncate" x-text="match.highest_qualification"></span>
                                        </div>

                                        <div class="flex items-center gap-2 text-gray-600">
                                            <svg class="w-4 h-4 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            <span class="truncate" x-text="match.city + ', ' + match.state"></span>
                                        </div>
                                    </div>

                                    <!-- Match Reasons Pill Badges -->
                                    <div class="flex flex-wrap gap-1.5 pt-1">
                                        <template x-for="reason in match.match_reasons" :key="reason">
                                            <span class="px-2.5 py-0.5 rounded-full text-[10px] font-semibold bg-rani-light text-rani-primary-dark border border-rani-gold/30" x-text="'✓ ' + reason"></span>
                                        </template>
                                    </div>

                                </div>
                            </div>

                            <!-- Card Action Buttons (Accept / Decline / Unlocked) -->
                            <div class="p-4 bg-gray-50/90 border-t border-gray-100 space-y-2">
                                
                                <!-- State 1: Mutual Accepted Match (Opens Unlocked Full Profile Details) -->
                                <template x-if="match.is_accepted">
                                    <div class="space-y-2">
                                        <!-- WhatsApp Chat Request Action Box (If WhatsApp chat is requested by candidate) -->
                                        <template x-if="match.is_wp_chat_received_by_me && match.wp_chat_status === 'pending'">
                                            <div class="p-3 rounded-2xl bg-gradient-to-r from-emerald-50 to-teal-50 border border-emerald-300 flex flex-col gap-2">
                                                <div class="flex items-center justify-between">
                                                    <div class="flex items-center gap-1.5 text-xs font-bold text-emerald-900">
                                                        <svg class="w-4 h-4 text-[#25D366] fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                                        <span>WhatsApp Chat Request</span>
                                                    </div>
                                                    <span class="text-[10px] px-2 py-0.5 rounded-full bg-emerald-600 text-white font-bold">New</span>
                                                </div>
                                                <p class="text-[11px] text-gray-600">Candidate wants to chat directly on WhatsApp.</p>
                                                <div class="grid grid-cols-2 gap-2 mt-1">
                                                    <button type="button" @click="respondWhatsAppChat(match, 'accept')" class="py-2 rounded-xl bg-gradient-to-r from-[#25D366] to-[#128C7E] text-white font-bold text-xs shadow hover:opacity-95 cursor-pointer">
                                                        Accept WhatsApp
                                                    </button>
                                                    <button type="button" @click="respondWhatsAppChat(match, 'decline')" class="py-2 rounded-xl bg-gray-200 hover:bg-gray-300 text-gray-700 font-bold text-xs cursor-pointer">
                                                        Decline
                                                    </button>
                                                </div>
                                            </div>
                                        </template>

                                        <!-- If WhatsApp Chat is accepted -> Direct WhatsApp button -->
                                        <template x-if="match.is_wp_chat_accepted">
                                            <a :href="'https://wa.me/91' + match.details.raw_mobile" 
                                               target="_blank" 
                                               class="w-full py-2.5 px-4 rounded-xl text-xs font-bold shadow transition-all flex items-center justify-center gap-2 bg-[#25D366] hover:bg-[#128C7E] text-white cursor-pointer">
                                                <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981zm11.387-5.464c-.074-.124-.272-.198-.57-.347-.297-.149-1.758-.868-2.031-.967-.272-.099-.47-.149-.669.149-.198.297-.768.967-.941 1.165-.173.198-.347.223-.644.074-.297-.149-1.255-.462-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.297-.347.446-.521.151-.172.2-.296.3-.495.099-.198.05-.372-.025-.521-.075-.148-.669-1.611-.916-2.206-.242-.579-.487-.501-.669-.51l-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.095 3.2 5.076 4.487.709.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.695.248-1.29.173-1.414z"/></svg>
                                                <span>Chat on WhatsApp</span>
                                            </a>
                                        </template>

                                        <button type="button" 
                                                @click="openFullProfile(match)"
                                                class="w-full py-3 px-4 rounded-xl text-xs font-bold shadow-md transition-all flex items-center justify-center gap-2 bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 hover:from-emerald-700 hover:to-teal-700 text-white active:scale-98 cursor-pointer">
                                            <svg class="w-4 h-4 text-emerald-200" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            <span>Mutual Match • View Details</span>
                                        </button>
                                    </div>
                                </template>

                                <!-- State 2: Received Interest (Accept or Decline) -->
                                <template x-if="!match.is_accepted && match.status !== 'declined'">
                                    <div class="flex items-center gap-2">
                                        <button type="button" 
                                                @click="respondInterest(match, 'accept')"
                                                class="flex-1 py-3 px-3 rounded-xl text-xs font-bold shadow-md transition-all flex items-center justify-center gap-1.5 bg-gradient-to-r from-emerald-600 via-teal-600 to-emerald-700 hover:from-emerald-700 hover:to-teal-700 text-white active:scale-95 cursor-pointer">
                                            <svg class="w-4 h-4 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            <span>Accept Connection</span>
                                        </button>
                                        
                                        <button type="button" 
                                                @click="respondInterest(match, 'decline')"
                                                class="px-3.5 py-3 rounded-xl text-xs font-bold text-gray-500 hover:text-rose-600 bg-gray-100 hover:bg-rose-50 border border-gray-200 transition-all active:scale-95 cursor-pointer"
                                                title="Decline Request">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                        </button>
                                    </div>
                                </template>

                                <!-- State 3: Declined -->
                                <template x-if="match.status === 'declined'">
                                    <div class="py-2.5 px-3 rounded-xl bg-gray-100 text-gray-500 text-center text-xs font-semibold">
                                        Request Declined
                                    </div>
                                </template>

                            </div>

                        </div>
                    </template>
                </div>

                <!-- Empty State -->
                <div x-show="filteredMatches.length === 0" class="p-16 text-center space-y-4">
                    <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto text-gray-400">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 font-serif">No Received Requests Yet</h3>
                    <p class="text-xs text-gray-500 max-w-md mx-auto">When candidates send a connection request to you, they will appear here. You can also explore today's recommended matches.</p>
                    <div class="pt-2">
                        <a href="{{ route('matches', ['tab' => 'todays']) }}" class="px-6 py-2.5 rounded-full bg-rani-primary text-white text-xs font-bold shadow hover:bg-rani-primary-dark transition-all inline-block">
                            Explore Recommendations
                        </a>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- ================= MODAL: UNLOCKED CANDIDATE COMPLETE PROFILE ================= -->
    <template x-teleport="body">
        <div x-show="fullProfileModalOpen" 
             x-cloak
             style="display: none; position: fixed !important; top: 0 !important; left: 0 !important; right: 0 !important; bottom: 0 !important; width: 100vw !important; height: 100vh !important; z-index: 99999999 !important; background-color: rgba(0, 0, 0, 0.85) !important; backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="flex items-center justify-center p-3 sm:p-5 overflow-y-auto">
            
            <div @click.away="closeFullProfile()"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 style="position: relative !important; z-index: 100000000 !important; max-height: 88vh !important; background-color: #ffffff !important;"
                 class="bg-white rounded-3xl shadow-[0_25px_70px_rgba(0,0,0,0.8)] border-2 border-rani-gold max-w-2xl w-full overflow-hidden flex flex-col my-auto text-gray-800">
                
                <!-- Top Royal Gold Shine Bar -->
                <div class="h-1.5 w-full bg-gradient-to-r from-emerald-500 via-rani-gold to-emerald-500"></div>

                <!-- Modal Header -->
                <div class="px-5 py-4 bg-gradient-to-r from-rani-dark via-rani-primary-dark to-rani-primary text-white flex items-center justify-between z-10 shrink-0 border-b border-rani-gold/30">
                    <div class="flex items-center gap-3.5">
                        <div class="w-12 h-12 rounded-full border-2 border-rani-gold overflow-hidden shrink-0 shadow-md bg-white/10">
                            <img :src="selectedProfile ? selectedProfile.photo : ''" class="w-full h-full object-cover">
                        </div>
                        <div>
                            <div class="flex items-center gap-2">
                                <h3 class="font-serif font-bold text-lg md:text-xl text-white tracking-wide" x-text="selectedProfile ? selectedProfile.first_name + ' ' + selectedProfile.last_name : 'Candidate Profile'"></h3>
                                <span class="px-2 py-0.5 rounded-full bg-emerald-500 text-[10px] font-bold text-white uppercase tracking-wider flex items-center gap-1 shadow-xs">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                    Unlocked
                                </span>
                            </div>
                            <p class="text-xs text-rani-gold font-mono font-medium mt-0.5" x-text="selectedProfile ? 'ID: ' + selectedProfile.id + ' • ' + selectedProfile.profession : ''"></p>
                        </div>
                    </div>

                    <button type="button" 
                            @click="closeFullProfile()" 
                            class="w-9 h-9 rounded-full bg-white/10 hover:bg-rose-600 text-white flex items-center justify-center transition-all hover:scale-110 active:scale-95 border border-white/20"
                            title="Close Profile">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Profile Body -->
                <div class="p-5 md:p-6 overflow-y-auto space-y-4 text-gray-800 bg-[#faf8f5]">
                    
                    <!-- Direct Contact Action Bar -->
                    <div class="p-4 rounded-2xl bg-gradient-to-r from-emerald-50 via-teal-50 to-emerald-50 border border-emerald-300 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-3">
                        <div class="space-y-0.5 text-center sm:text-left">
                            <div class="flex items-center gap-2 justify-center sm:justify-start">
                                <span class="text-[11px] font-bold text-emerald-800 uppercase tracking-wider">Direct Contact:</span>
                                <span class="font-mono font-bold text-sm text-gray-900" x-text="selectedProfile && selectedProfile.details ? selectedProfile.details.mobile : ''"></span>
                            </div>
                            <p class="text-xs text-emerald-700 flex items-center gap-1 justify-center sm:justify-start font-medium">
                                <svg class="w-3.5 h-3.5 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path><path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path></svg>
                                <span x-text="selectedProfile && selectedProfile.details ? selectedProfile.details.email : ''"></span>
                            </p>
                        </div>

                        <div class="flex items-center gap-2 w-full sm:w-auto shrink-0">
                            <a :href="'https://wa.me/91' + (selectedProfile && selectedProfile.details ? selectedProfile.details.raw_mobile : '')" 
                               target="_blank"
                               class="flex-1 sm:flex-initial px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-xs shadow flex items-center justify-center gap-1.5 transition-all active:scale-95">
                                <svg class="w-3.5 h-3.5 fill-current" viewBox="0 0 24 24"><path d="M.057 24l1.687-6.163c-1.041-1.804-1.588-3.849-1.587-5.946.003-6.556 5.338-11.891 11.893-11.891 3.181.001 6.167 1.24 8.413 3.488 2.245 2.248 3.481 5.236 3.48 8.414-.003 6.557-5.338 11.892-11.893 11.892-1.99-.001-3.951-.5-5.688-1.448l-6.305 1.654zm6.597-3.807c1.676.995 3.276 1.591 5.392 1.592 5.448 0 9.886-4.434 9.889-9.885.002-5.462-4.415-9.89-9.881-9.892-5.452 0-9.887 4.434-9.889 9.884-.001 2.225.651 3.891 1.746 5.634l-.999 3.648 3.742-.981z"/></svg>
                                <span>WhatsApp</span>
                            </a>

                            <a :href="'tel:' + (selectedProfile && selectedProfile.details ? selectedProfile.details.raw_mobile : '')" 
                               class="flex-1 sm:flex-initial px-3.5 py-2 rounded-xl bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white font-bold text-xs shadow flex items-center justify-center gap-1.5 transition-all active:scale-95">
                                <svg class="w-3.5 h-3.5 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                <span>Call</span>
                            </a>
                        </div>
                    </div>

                    <!-- Address Details -->
                    <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-xs space-y-2.5">
                        <h4 class="font-serif font-bold text-rani-primary-dark text-xs uppercase tracking-wider border-b border-gray-100 pb-1.5 flex items-center gap-1.5">
                            <svg class="w-4 h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                            Location & Residence
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs">
                            <div>
                                <span class="text-gray-400 block text-[11px]">Address:</span>
                                <span class="font-semibold text-gray-800" x-text="selectedProfile && selectedProfile.details ? selectedProfile.details.full_address : ''"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[11px]">City & State:</span>
                                <span class="font-semibold text-gray-800" x-text="selectedProfile ? selectedProfile.city + ', ' + selectedProfile.state : ''"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Personal & Astro Details -->
                    <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-xs space-y-2.5">
                        <h4 class="font-serif font-bold text-rani-primary-dark text-xs uppercase tracking-wider border-b border-gray-100 pb-1.5">Personal & Astro Details</h4>
                        <div class="grid grid-cols-2 sm:grid-cols-3 gap-2.5 text-xs">
                            <div>
                                <span class="text-gray-400 block text-[11px]">Age / Height:</span>
                                <span class="font-bold text-gray-800" x-text="selectedProfile ? selectedProfile.age + ' yrs, ' + selectedProfile.height : ''"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[11px]">Religion & Community:</span>
                                <span class="font-bold text-gray-800" x-text="selectedProfile ? selectedProfile.religion + ', ' + selectedProfile.community : ''"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[11px]">Gothra:</span>
                                <span class="font-bold text-gray-800" x-text="selectedProfile && selectedProfile.details ? selectedProfile.details.gothra : ''"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[11px]">Diet:</span>
                                <span class="font-bold text-gray-800" x-text="selectedProfile ? selectedProfile.diet : ''"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[11px]">Manglik:</span>
                                <span class="font-bold text-gray-800" x-text="selectedProfile && selectedProfile.details ? selectedProfile.details.manglik : ''"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[11px]">Mother Tongue:</span>
                                <span class="font-bold text-gray-800" x-text="selectedProfile ? selectedProfile.mother_tongue : ''"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Career & Education -->
                    <div class="bg-white p-4 rounded-2xl border border-gray-200 shadow-xs space-y-2.5">
                        <h4 class="font-serif font-bold text-rani-primary-dark text-xs uppercase tracking-wider border-b border-gray-100 pb-1.5">Education & Career</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2.5 text-xs">
                            <div>
                                <span class="text-gray-400 block text-[11px]">Highest Qualification:</span>
                                <span class="font-bold text-gray-800" x-text="selectedProfile ? selectedProfile.highest_qualification : ''"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[11px]">Profession & Role:</span>
                                <span class="font-bold text-gray-800" x-text="selectedProfile ? selectedProfile.profession : ''"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[11px]">Company:</span>
                                <span class="font-semibold text-gray-800" x-text="selectedProfile ? selectedProfile.company_name : ''"></span>
                            </div>
                            <div>
                                <span class="text-gray-400 block text-[11px]">Annual Income:</span>
                                <span class="font-bold text-emerald-700" x-text="selectedProfile ? selectedProfile.annual_income : ''"></span>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="px-5 py-3 bg-white border-t border-gray-200 flex items-center justify-between shrink-0">
                    <button type="button" 
                            @click="openPhotoGallery(selectedProfile, 0)" 
                            class="px-4 py-2 rounded-xl border border-rani-gold bg-white hover:bg-rani-light text-rani-primary-dark font-bold text-xs shadow-xs flex items-center gap-1.5 transition-all active:scale-95">
                        <svg class="w-4 h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        <span>View Photos</span>
                    </button>

                    <button type="button" 
                            @click="closeFullProfile()" 
                            class="px-5 py-2 rounded-xl bg-gray-800 hover:bg-gray-900 text-white font-bold text-xs shadow transition-all active:scale-95">
                        Close
                    </button>
                </div>

            </div>
        </div>
    </template>

    <!-- ================= MODAL: RANI MATRIMONIAL THEMED PHOTO LIGHTBOX ================= -->
    <template x-teleport="body">
        <div x-show="photoGalleryOpen" 
             x-cloak
             style="display: none; position: fixed !important; top: 0 !important; left: 0 !important; right: 0 !important; bottom: 0 !important; width: 100vw !important; height: 100vh !important; z-index: 99999999 !important; background: radial-gradient(circle at center, rgba(65, 10, 10, 0.95) 0%, rgba(15, 3, 3, 0.98) 100%) !important; backdrop-filter: blur(14px); -webkit-backdrop-filter: blur(14px);" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             @keydown.escape.window="closePhotoGallery()"
             @keydown.left.window="prevPhoto()"
             @keydown.right.window="nextPhoto()"
             class="flex flex-col justify-between items-center p-4 sm:p-6 select-none overflow-hidden">
            
            <!-- Top Elegant Bar (Profile Name, ID & Close) -->
            <div class="w-full max-w-5xl flex items-center justify-between z-20 shrink-0 pb-2">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-rani-gold via-yellow-400 to-amber-600 flex items-center justify-center text-rani-dark shadow-md">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"></path></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="font-serif font-bold text-lg sm:text-xl text-white tracking-wide" x-text="galleryCandidate ? galleryCandidate.first_name + ' ' + galleryCandidate.last_name : 'Photo Viewer'"></h3>
                            <span class="text-xs text-rani-gold font-mono font-bold px-2.5 py-0.5 rounded-full bg-rani-gold/15 border border-rani-gold/40" x-text="galleryCandidate ? 'ID: ' + galleryCandidate.id : ''"></span>
                        </div>
                        <p class="text-xs text-amber-200/70" x-text="'Photo ' + (activePhotoIndex + 1) + ' of ' + (galleryPhotos.length || 1)"></p>
                    </div>
                </div>

                <button type="button" 
                        @click="closePhotoGallery()" 
                        class="w-11 h-11 rounded-full bg-white/10 hover:bg-rose-600 text-white/90 hover:text-white flex items-center justify-center transition-all hover:scale-110 active:scale-95 border border-white/20 hover:border-transparent shadow-lg cursor-pointer"
                        title="Close (Esc)">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Center Image Showcase -->
            <div class="relative w-full max-w-5xl flex-1 flex items-center justify-center p-2 min-h-0">
                
                <!-- Floating Left Arrow -->
                <button type="button" 
                        x-show="galleryPhotos.length > 1" 
                        @click.stop="prevPhoto()" 
                        class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-black/70 hover:bg-rani-primary text-rani-gold hover:text-white border border-rani-gold/60 flex items-center justify-center transition-all hover:scale-110 active:scale-95 shadow-2xl z-30 cursor-pointer backdrop-blur-md"
                        title="Previous Photo">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                </button>

                <!-- High-res Centered Image -->
                <div class="relative max-h-[72vh] sm:max-h-[76vh] flex items-center justify-center">
                    <img :src="currentGalleryPhoto" 
                         :alt="galleryCandidate ? galleryCandidate.first_name : 'Photo'" 
                         class="max-h-[72vh] sm:max-h-[76vh] max-w-[92vw] sm:max-w-3xl object-contain rounded-2xl border-2 border-rani-gold/50 shadow-[0_25px_60px_rgba(0,0,0,0.9)] transition-transform duration-300">
                </div>

                <!-- Floating Right Arrow -->
                <button type="button" 
                        x-show="galleryPhotos.length > 1" 
                        @click.stop="nextPhoto()" 
                        class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 w-12 h-12 rounded-full bg-black/70 hover:bg-rani-primary text-rani-gold hover:text-white border border-rani-gold/60 flex items-center justify-center transition-all hover:scale-110 active:scale-95 shadow-2xl z-30 cursor-pointer backdrop-blur-md"
                        title="Next Photo">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                </button>

            </div>

            <!-- Bottom Thumbnails Strip -->
            <div class="w-full max-w-2xl flex items-center justify-center gap-2.5 py-2 overflow-x-auto shrink-0 z-20" x-show="galleryPhotos.length > 1">
                <template x-for="(photoUrl, pIdx) in galleryPhotos" :key="pIdx">
                    <button type="button" 
                            @click="activePhotoIndex = pIdx" 
                            class="w-13 h-13 sm:w-16 sm:h-16 rounded-xl overflow-hidden border-2 transition-all shrink-0 cursor-pointer bg-black/40"
                            :class="activePhotoIndex === pIdx ? 'border-rani-gold scale-110 shadow-[0_0_16px_rgba(212,175,55,0.85)] ring-2 ring-rani-gold/70 opacity-100' : 'border-white/25 opacity-50 hover:opacity-90 hover:border-rani-gold/60'">
                        <img :src="photoUrl" class="w-full h-full object-cover">
                    </button>
                </template>
            </div>

        </div>
    </template>

</div>

<!-- Alpine Inbox Manager Script -->
<script>
function inboxManager(initialData) {
    return {
        subTab: initialData.subTab || 'received',
        matches: initialData.matches || [],
        candidate: initialData.candidate || {},
        counts: initialData.counts || {},
        searchQuery: '',

        // Full Profile Modal State
        fullProfileModalOpen: false,
        selectedProfile: null,

        // Photo Gallery Modal State
        photoGalleryOpen: false,
        galleryCandidate: null,
        galleryPhotos: [],
        activePhotoIndex: 0,

        get currentGalleryPhoto() {
            if (this.galleryPhotos && this.galleryPhotos.length > 0) {
                return this.galleryPhotos[this.activePhotoIndex] || this.galleryPhotos[0];
            }
            return this.galleryCandidate ? this.galleryCandidate.photo : '';
        },

        openFullProfile(match) {
            if (match.profile_url) {
                window.location.href = match.profile_url;
            } else {
                const targetId = match.id || match.db_id || match.profile_id;
                window.location.href = '/profile/' + targetId;
            }
        },

        closeFullProfile() {
            this.fullProfileModalOpen = false;
            document.body.style.overflow = 'auto';
        },

        openPhotoGallery(match, initialIndex = 0) {
            this.galleryCandidate = match;
            this.galleryPhotos = (match.photos && match.photos.length > 0) ? match.photos : [match.photo];
            this.activePhotoIndex = (initialIndex >= 0 && initialIndex < this.galleryPhotos.length) ? initialIndex : 0;
            this.photoGalleryOpen = true;
            document.body.style.overflow = 'hidden';
        },

        closePhotoGallery() {
            this.photoGalleryOpen = false;
            document.body.style.overflow = 'auto';
        },

        nextPhoto() {
            if (!this.galleryPhotos || !this.galleryPhotos.length) return;
            this.activePhotoIndex = (this.activePhotoIndex + 1) % this.galleryPhotos.length;
        },

        prevPhoto() {
            if (!this.galleryPhotos || !this.galleryPhotos.length) return;
            this.activePhotoIndex = (this.activePhotoIndex - 1 + this.galleryPhotos.length) % this.galleryPhotos.length;
        },

        get filteredMatches() {
            const query = this.searchQuery.toLowerCase().trim();

            return this.matches.filter(m => {
                if (!query) return true;
                const name = (m.first_name + ' ' + m.last_name).toLowerCase();
                const profession = (m.profession || '').toLowerCase();
                const location = (m.city + ' ' + m.state).toLowerCase();
                const id = (m.id || '').toLowerCase();

                return name.includes(query) || profession.includes(query) || location.includes(query) || id.includes(query);
            });
        },

        async respondInterest(match, action) {
            if (!match) return;

            if (action === 'accept') {
                match.is_accepted = true;
                match.status = 'accepted';
                match.badge = 'Accepted Connection';
            } else {
                match.status = 'declined';
                this.matches = this.matches.filter(m => m.id !== match.id);
            }

            try {
                const res = await fetch('{{ route("matches.respond-interest") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        profile_id: match.id,
                        action: action
                    })
                });

                const data = await res.json();

                if (data.success) {
                    if (action === 'accept') {
                        Swal.fire({
                            icon: 'success',
                            title: 'Connection Accepted!',
                            html: '<p class="text-sm">You are now connected with <strong>' + match.first_name + '</strong>.<br><span class="text-xs text-gray-300 mt-1 block">WhatsApp notification dispatched. Complete contact and family particulars are unlocked.</span></p>',
                            confirmButtonText: 'OK',
                            showCancelButton: false,
                            customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                        });
                    } else {
                        Swal.fire({
                            icon: 'info',
                            title: 'Request Declined',
                            text: data.message,
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 2000,
                            customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title' }
                        });
                    }
                }
            } catch (e) {
                console.error('Respond Interest error:', e);
            }
        },

        async respondWhatsAppChat(match, action) {
            if (!match) return;

            try {
                const res = await fetch('{{ route("matches.respond-whatsapp-chat") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        profile_id: match.id,
                        action: action
                    })
                });

                const data = await res.json();

                if (data.success) {
                    if (action === 'accept') {
                        match.is_wp_chat_accepted = true;
                        match.is_wp_chat_received_by_me = false;
                        match.wp_chat_status = 'accepted';
                        if (data.clean_mobile) {
                            match.details.raw_mobile = data.clean_mobile;
                        }
                        Swal.fire({
                            icon: 'success',
                            title: 'WhatsApp Request Accepted!',
                            html: '<p class="text-sm">You have accepted the WhatsApp chat request. Direct WhatsApp chat is now unlocked with <strong>' + match.first_name + '</strong>.</p>',
                            confirmButtonText: 'OK',
                            customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                        });
                    } else {
                        match.is_wp_chat_received_by_me = false;
                        match.wp_chat_status = 'declined';
                        Swal.fire({
                            icon: 'info',
                            title: 'WhatsApp Request Declined',
                            text: data.message,
                            confirmButtonText: 'OK',
                            customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                        });
                    }
                }
            } catch (e) {
                console.error('Respond WhatsApp Chat error:', e);
            }
        }
    };
}
</script>
@endsection
