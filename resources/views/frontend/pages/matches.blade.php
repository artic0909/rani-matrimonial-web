@extends('frontend.layouts.auth_app')

@section('title', 'Matches | Ranimatrimonial')

@section('content')
<div class="relative pt-6 pb-20" x-data="matchesManager({
    activeTab: '{{ $tab }}',
    matches: @js($matches),
    candidate: @js($candidate),
    counts: @js($counts),
    shortlistedIds: @js($shortlistedIds ?? [])
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
                        <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-rani-primary to-rani-primary-dark flex items-center justify-center text-rani-gold shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <div>
                            <h1 class="text-2xl md:text-3xl font-bold font-serif text-rani-primary-dark tracking-wide" x-text="tabTitle"></h1>
                            <p class="text-xs text-gray-500 font-sans mt-0.5" x-text="tabSubtitle"></p>
                        </div>
                    </div>
                </div>

                <!-- Search & Quick Filters -->
                <div class="flex items-center gap-3 w-full md:w-auto">
                    <div class="relative flex-1 md:w-64">
                        <input type="text" 
                               x-model="searchQuery" 
                               placeholder="Search name, city, job..." 
                               class="w-full pl-9 pr-4 py-2 text-xs md:text-sm rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-rani-gold focus:border-transparent bg-white shadow-sm">
                        <svg class="w-4 h-4 text-gray-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </div>
                    
                    <select x-model="selectedCity" class="py-2 px-3 text-xs md:text-sm rounded-xl border border-gray-200 bg-white focus:outline-none focus:ring-2 focus:ring-rani-gold shadow-sm text-gray-700">
                        <option value="">All Locations</option>
                        <option value="Mumbai">Mumbai</option>
                        <option value="Delhi">Delhi</option>
                        <option value="Pune">Pune</option>
                        <option value="Ahmedabad">Ahmedabad</option>
                        <option value="Bengaluru">Bengaluru</option>
                        <option value="Chennai">Chennai</option>
                    </select>
                </div>
            </div>

            <!-- In-Page Secondary Sub-Header Tabs (For quick switching + sync with subheader) -->
            <div class="px-6 md:px-10 pt-4 pb-2 bg-gray-50/70 border-b border-gray-100 flex items-center justify-between overflow-x-auto">
                <div class="flex items-center space-x-2 py-1">
                    <a href="{{ route('matches', ['tab' => 'todays']) }}" 
                       class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 flex items-center gap-1.5 whitespace-nowrap {{ $tab === 'todays' ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white shadow-md' : 'text-gray-600 hover:text-rani-primary hover:bg-white' }}">
                        <span>Today's Picks</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $tab === 'todays' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700' }}">{{ $counts['todays'] }}</span>
                    </a>

                    <a href="{{ route('matches', ['tab' => 'shortlisted']) }}" 
                       class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 flex items-center gap-1.5 whitespace-nowrap {{ $tab === 'shortlisted' ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white shadow-md' : 'text-gray-600 hover:text-rani-primary hover:bg-white' }}">
                        <span>Shortlisted</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $tab === 'shortlisted' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700' }}" x-text="shortlistedIds.length"></span>
                    </a>

                    <a href="{{ route('matches', ['tab' => 'my_matches']) }}" 
                       class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 flex items-center gap-1.5 whitespace-nowrap {{ $tab === 'my_matches' ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white shadow-md' : 'text-gray-600 hover:text-rani-primary hover:bg-white' }}">
                        <span>My Matches</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $tab === 'my_matches' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700' }}">{{ $counts['my_matches'] }}</span>
                    </a>

                    <a href="{{ route('matches', ['tab' => 'accepted']) }}" 
                       class="px-4 py-2 rounded-xl text-xs font-bold transition-all duration-300 flex items-center gap-1.5 whitespace-nowrap {{ $tab === 'accepted' ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white shadow-md' : 'text-gray-600 hover:text-rani-primary hover:bg-white' }}">
                        <span>Accepted</span>
                        <span class="px-1.5 py-0.2 rounded-full text-[10px] {{ $tab === 'accepted' ? 'bg-white/20 text-white' : 'bg-gray-200 text-gray-700' }}">{{ $counts['accepted'] }}</span>
                    </a>
                </div>

                <div class="hidden sm:flex items-center gap-2 text-xs text-gray-500 font-medium">
                    <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                    <span x-text="filteredMatches.length + ' Profiles Available'"></span>
                </div>
            </div>

            <!-- Matches Feed Grid -->
            <div class="p-6 md:p-10">
                
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <template x-for="match in filteredMatches" :key="match.id">
                        <div class="bg-white rounded-3xl border border-gray-200/90 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden flex flex-col justify-between group">
                            
                            <div>
                                <!-- Image & Spotlight Badges Container (Click to open Photo Gallery Modal) -->
                                <div class="relative h-64 sm:h-72 w-full overflow-hidden bg-gray-100 cursor-pointer group/photo select-none"
                                     @click="openPhotoGallery(match, 0)"
                                     title="Click to view all profile photos">
                                    <img :src="match.photo" 
                                         :alt="match.first_name" 
                                         class="w-full h-full object-cover object-top transition-transform duration-700 group-hover/photo:scale-105">
                                    
                                    <!-- Top Gradient Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent pointer-events-none"></div>

                                    <!-- Top Left: Match Score Badge -->
                                    <div class="absolute top-3 left-3 flex flex-col gap-1.5 z-10">
                                        <span class="px-3 py-1 rounded-full bg-gradient-to-r from-rani-gold to-yellow-500 text-rani-dark text-xs font-extrabold shadow-md flex items-center gap-1 border border-white/40">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            <span x-text="match.match_score + '% Match'"></span>
                                        </span>
                                        <span x-show="match.badge" class="px-2.5 py-0.5 rounded-full bg-black/60 backdrop-blur-xs text-white text-[10px] font-semibold tracking-wide" x-text="match.badge"></span>
                                    </div>

                                    <!-- Top Right: Shortlist Heart Action (click.stop prevents opening modal) -->
                                    <button type="button" 
                                            @click.stop="toggleShortlist(match)"
                                            class="absolute top-3 right-3 w-9 h-9 rounded-full bg-white/80 hover:bg-white backdrop-blur-xs text-gray-700 hover:text-rose-600 shadow-md flex items-center justify-center transition-all hover:scale-110 active:scale-95 z-20"
                                            :class="isShortlisted(match.id) ? 'text-rose-600 bg-white ring-2 ring-rose-300' : ''">
                                        <svg class="w-5 h-5" :fill="isShortlisted(match.id) ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                    </button>

                                    <!-- Bottom Image Overlay Text: Name & ID -->
                                    <div class="absolute bottom-3 left-4 right-4 text-white z-10 flex items-end justify-between">
                                        <div class="max-w-[70%]">
                                            <div class="flex items-center gap-2">
                                                <h3 class="text-xl font-bold font-serif drop-shadow-md truncate" x-text="match.first_name + ' ' + match.last_name"></h3>
                                                <svg x-show="match.verified" class="w-4 h-4 text-sky-400 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            </div>
                                            <div class="flex items-center gap-2 text-xs text-gray-200 font-mono mt-0.5">
                                                <span x-text="'ID: ' + match.id"></span>
                                                <span>•</span>
                                                <span x-text="match.active_ago"></span>
                                            </div>
                                        </div>

                                        <!-- Photo Count Badge Indicator -->
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
                                    <div class="grid grid-cols-2 gap-2 text-xs text-gray-700 bg-gray-50/80 p-3 rounded-2xl border border-gray-100">
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
                                            <span class="truncate" x-text="match.city + ', ' + match.state + ' (' + match.distance + ')'"></span>
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

                            <!-- Card Action Buttons -->
                            <div class="p-4 bg-gray-50/90 border-t border-gray-100 flex items-center gap-2">
                                <!-- Send Interest / Connect CTA -->
                                <button type="button" 
                                        @click="sendInterest(match)"
                                        :disabled="isInterestSent(match.id)"
                                        class="flex-1 py-2.5 px-3 rounded-xl text-xs font-bold shadow transition-all flex items-center justify-center gap-1.5"
                                        :class="isInterestSent(match.id) ? 'bg-emerald-600 text-white cursor-default' : 'bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white hover:shadow-md active:scale-95'">
                                    <template x-if="!isInterestSent(match.id)">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                            <span>Connect</span>
                                        </div>
                                    </template>
                                    <template x-if="isInterestSent(match.id)">
                                        <div class="flex items-center gap-1.5">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                            <span>Interest Sent</span>
                                        </div>
                                    </template>
                                </button>

                                <!-- View Contact / Unlock Phone CTA -->
                                <button type="button" 
                                        @click="openContactModal(match)"
                                        title="Unlock Contact Number"
                                        class="py-2.5 px-3 rounded-xl bg-white hover:bg-rani-light text-rani-primary text-xs font-bold border border-rani-gold/40 shadow-xs hover:shadow transition-all flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                    <span>Contact</span>
                                </button>
                            </div>

                        </div>
                    </template>
                </div>

                <!-- Empty State -->
                <div x-show="filteredMatches.length === 0" class="p-16 text-center space-y-4">
                    <div class="w-20 h-20 rounded-full bg-gray-100 flex items-center justify-center mx-auto text-gray-400">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 font-serif" x-text="activeTab === 'shortlisted' ? 'No Shortlisted Profiles Yet' : 'No matches found'"></h3>
                    <p class="text-xs text-gray-500 max-w-md mx-auto" x-text="activeTab === 'shortlisted' ? 'Click the heart icon on any candidate profile to save them here for quick access.' : 'No profiles match your current search or location filters. Try clearing your filters or check back tomorrow.'"></p>
                    <div class="pt-2">
                        <template x-if="activeTab === 'shortlisted'">
                            <a href="{{ route('matches', ['tab' => 'todays']) }}" class="px-6 py-2.5 rounded-full bg-rani-primary text-white text-xs font-bold shadow hover:bg-rani-primary-dark transition-all inline-block">
                                Explore Today's Matches
                            </a>
                        </template>
                        <template x-if="activeTab !== 'shortlisted'">
                            <button @click="searchQuery = ''; selectedCity = ''" type="button" class="px-6 py-2.5 rounded-full bg-rani-primary text-white text-xs font-bold shadow hover:bg-rani-primary-dark transition-all">
                                Reset Filters
                            </button>
                        </template>
                    </div>
                </div>

            </div>

        </div>

    </div>

    <!-- ================= MODAL: UNLOCK CONTACT NUMBER ================= -->
    <div x-show="contactModalOpen" 
         style="display: none;" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4 bg-black/60 backdrop-blur-xs">
        
        <div @click.away="contactModalOpen = false" 
             class="bg-white rounded-3xl shadow-2xl border border-rani-gold/30 max-w-md w-full p-6 md:p-8 relative overflow-hidden space-y-6">
            
            <div class="flex items-center justify-between pb-4 border-b border-gray-100">
                <div class="flex items-center gap-2.5">
                    <div class="w-10 h-10 rounded-xl bg-rani-primary/10 text-rani-primary flex items-center justify-center">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold font-serif text-rani-primary-dark">Contact Information</h3>
                        <p class="text-xs text-gray-500" x-text="selectedMatch ? selectedMatch.first_name + ' ' + selectedMatch.last_name : ''"></p>
                    </div>
                </div>
                <button @click="contactModalOpen = false" class="text-gray-400 hover:text-gray-600 p-1.5 rounded-lg hover:bg-gray-100 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Contact Box Details -->
            <div class="space-y-4">
                <div class="p-4 bg-gradient-to-br from-rani-light/60 to-white rounded-2xl border border-rani-gold/30 text-center space-y-2">
                    <div class="w-16 h-16 rounded-full mx-auto overflow-hidden border-2 border-rani-gold shadow">
                        <img :src="selectedMatch ? selectedMatch.photo : ''" class="w-full h-full object-cover">
                    </div>
                    <h4 class="font-serif font-bold text-gray-800 text-base" x-text="selectedMatch ? selectedMatch.first_name + ' ' + selectedMatch.last_name : ''"></h4>
                    <p class="text-xs text-gray-500 font-mono" x-text="selectedMatch ? 'ID: ' + selectedMatch.id : ''"></p>
                </div>

                <div class="space-y-2.5 text-xs text-gray-700">
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 border border-gray-100">
                        <span class="font-semibold text-gray-500">Phone Number:</span>
                        <span class="font-mono font-bold text-gray-800">+91 98•••• ••42</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 border border-gray-100">
                        <span class="font-semibold text-gray-500">WhatsApp:</span>
                        <span class="font-mono font-bold text-emerald-700">Available</span>
                    </div>
                    <div class="flex items-center justify-between p-3 rounded-xl bg-gray-50 border border-gray-100">
                        <span class="font-semibold text-gray-500">Profile Managed By:</span>
                        <span class="font-semibold text-gray-800">Self / Parents</span>
                    </div>
                </div>
            </div>

            <!-- Action Button -->
            <div class="pt-2">
                <button type="button" 
                        @click="unlockContactNow()" 
                        class="w-full py-3.5 rounded-xl bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white font-bold text-sm shadow-md hover:shadow-lg transition-all flex items-center justify-center gap-2">
                    <svg class="w-4 h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    <span>Unlock Full Number & WhatsApp</span>
                </button>
            </div>

        </div>
    </div>

    <!-- ================= MODAL: FULL PROFILE PHOTO GALLERY (NON-CLOSABLE EXCEPT CROSS BUTTON) ================= -->
    <div x-show="photoGalleryOpen" 
         style="display: none;" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 scale-95"
         x-transition:enter-end="opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 scale-100"
         x-transition:leave-end="opacity-0 scale-95"
         class="fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-3 sm:p-6 bg-black/85 backdrop-blur-md">
        
        <!-- Non-closable Modal Container (Must use the Cross button to close) -->
        <div class="bg-gray-900 border border-rani-gold/40 rounded-3xl shadow-2xl max-w-4xl w-full overflow-hidden flex flex-col relative max-h-[92vh]">
            
            <!-- Modal Header -->
            <div class="px-5 py-3.5 bg-gray-950/90 border-b border-white/10 flex items-center justify-between z-10 shrink-0">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-2xl bg-gradient-to-br from-rani-primary to-rani-primary-dark flex items-center justify-center text-rani-gold shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <div class="flex items-center gap-2">
                            <h3 class="text-white font-serif font-bold text-base md:text-lg tracking-wide" x-text="galleryCandidate ? galleryCandidate.first_name + ' ' + galleryCandidate.last_name : 'Profile Photos'"></h3>
                            <span class="text-[11px] text-rani-gold font-mono px-2 py-0.5 rounded-full bg-rani-gold/10 border border-rani-gold/30" x-text="galleryCandidate ? 'ID: ' + galleryCandidate.id : ''"></span>
                        </div>
                        <p class="text-xs text-gray-400 font-sans" x-text="'Photo ' + (activePhotoIndex + 1) + ' of ' + (galleryPhotos.length || 1) + ' • ' + (galleryCandidate ? galleryCandidate.profession : '')"></p>
                    </div>
                </div>

                <!-- REQUIRED EXPLICIT CROSS BUTTON (Only way to close) -->
                <button type="button" 
                        @click="closePhotoGallery()" 
                        class="w-9 h-9 rounded-full bg-white/10 hover:bg-rose-600 text-gray-200 hover:text-white flex items-center justify-center transition-all hover:scale-110 active:scale-95 shadow-md border border-white/20"
                        title="Close Gallery">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Main Image Viewport with Left/Right Nav Arrows -->
            <div class="relative flex-1 bg-black/95 flex items-center justify-center min-h-[260px] sm:min-h-[400px] max-h-[58vh] overflow-hidden p-2 sm:p-4 group/viewport">
                
                <!-- Main Active Photo -->
                <img :src="currentGalleryPhoto" 
                     :alt="galleryCandidate ? galleryCandidate.first_name : 'Candidate Photo'" 
                     class="max-h-[54vh] w-auto max-w-full object-contain rounded-xl shadow-2xl transition-all duration-300 select-none">

                <!-- Previous Photo Button -->
                <button type="button" 
                        x-show="galleryPhotos.length > 1" 
                        @click="prevPhoto()" 
                        class="absolute left-3 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/60 hover:bg-rani-primary text-white border border-white/20 hover:border-rani-gold flex items-center justify-center transition-all shadow-xl hover:scale-110 active:scale-95 z-20"
                        title="Previous Photo">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                </button>

                <!-- Next Photo Button -->
                <button type="button" 
                        x-show="galleryPhotos.length > 1" 
                        @click="nextPhoto()" 
                        class="absolute right-3 top-1/2 -translate-y-1/2 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-black/60 hover:bg-rani-primary text-white border border-white/20 hover:border-rani-gold flex items-center justify-center transition-all shadow-xl hover:scale-110 active:scale-95 z-20"
                        title="Next Photo">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                </button>

                <!-- Dot Indicator Pills -->
                <div x-show="galleryPhotos.length > 1" class="absolute bottom-3 left-1/2 -translate-x-1/2 flex items-center gap-1.5 px-3 py-1 rounded-full bg-black/70 backdrop-blur-xs border border-white/10 z-10">
                    <template x-for="(p, idx) in galleryPhotos" :key="idx">
                        <span class="h-2 rounded-full transition-all duration-300 cursor-pointer"
                              @click="activePhotoIndex = idx"
                              :class="activePhotoIndex === idx ? 'bg-rani-gold w-6' : 'bg-white/40 w-2 hover:bg-white/70'"></span>
                    </template>
                </div>
            </div>

            <!-- Thumbnails Gallery Strip (Click any to view) -->
            <div class="px-4 py-3 bg-gray-950 border-t border-white/10 flex items-center justify-center gap-2.5 overflow-x-auto shrink-0">
                <template x-for="(photoUrl, pIdx) in galleryPhotos" :key="pIdx">
                    <button type="button" 
                            @click="activePhotoIndex = pIdx" 
                            class="w-14 h-14 sm:w-16 sm:h-16 rounded-xl overflow-hidden border-2 transition-all shrink-0 cursor-pointer hover:opacity-100"
                            :class="activePhotoIndex === pIdx ? 'border-rani-gold scale-105 shadow-md shadow-rani-gold/30 opacity-100 ring-2 ring-rani-gold/50' : 'border-white/20 opacity-50 hover:border-white/50'">
                        <img :src="photoUrl" class="w-full h-full object-cover">
                    </button>
                </template>
            </div>

            <!-- Modal Bottom Action Bar -->
            <div class="px-5 py-3 bg-gray-900/95 border-t border-white/10 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-gray-300 shrink-0">
                <div class="flex items-center gap-2 text-center sm:text-left">
                    <span class="text-gray-300 font-medium" x-text="galleryCandidate ? galleryCandidate.age + ' yrs, ' + galleryCandidate.height + ' • ' + galleryCandidate.city + ', ' + galleryCandidate.state : ''"></span>
                </div>
                
                <div class="flex items-center gap-3 w-full sm:w-auto">
                    <button type="button" 
                            @click="toggleShortlist(galleryCandidate)" 
                            class="flex-1 sm:flex-initial px-4 py-2 rounded-xl border text-xs font-bold flex items-center justify-center gap-1.5 transition-all"
                            :class="galleryCandidate && isShortlisted(galleryCandidate.id) ? 'text-rose-400 border-rose-500 bg-rose-500/15' : 'border-white/20 hover:border-rose-400 text-white hover:bg-white/5'">
                        <svg class="w-4 h-4" :fill="galleryCandidate && isShortlisted(galleryCandidate.id) ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        <span x-text="galleryCandidate && isShortlisted(galleryCandidate.id) ? 'Shortlisted' : 'Shortlist'"></span>
                    </button>

                    <button type="button" 
                            @click="sendInterest(galleryCandidate)" 
                            :disabled="galleryCandidate && isInterestSent(galleryCandidate.id)"
                            class="flex-1 sm:flex-initial px-5 py-2 rounded-xl text-white font-bold text-xs shadow transition-all flex items-center justify-center gap-1.5"
                            :class="galleryCandidate && isInterestSent(galleryCandidate.id) ? 'bg-emerald-600 text-white' : 'bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary hover:shadow-md'">
                        <svg class="w-4 h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        <span x-text="galleryCandidate && isInterestSent(galleryCandidate.id) ? 'Interest Sent' : 'Connect'"></span>
                    </button>
                </div>
            </div>

        </div>
    </div>

</div>

<!-- Alpine Matches Manager Script -->
<script>
function matchesManager(initialData) {
    return {
        activeTab: initialData.activeTab || 'todays',
        matches: initialData.matches || [],
        candidate: initialData.candidate || {},
        counts: initialData.counts || {},
        searchQuery: '',
        selectedCity: '',
        
        shortlistedIds: initialData.shortlistedIds || [],
        sentInterestIds: [],

        contactModalOpen: false,
        selectedMatch: null,

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

        get tabTitle() {
            switch (this.activeTab) {
                case 'shortlisted': return 'Shortlisted Profiles';
                case 'my_matches': return 'My Matches';
                case 'accepted': return 'Accepted Matches';
                default: return "Today's Recommendations";
            }
        },

        get tabSubtitle() {
            switch (this.activeTab) {
                case 'shortlisted': return 'Profiles you have shortlisted and saved to your favorites';
                case 'my_matches': return 'Curated profiles strictly matching your partner preferences';
                case 'accepted': return 'Matches who have accepted your connection and express mutual interest';
                default: return 'Handpicked daily matchmaking recommendations based on high compatibility';
            }
        },

        get filteredMatches() {
            const query = this.searchQuery.toLowerCase().trim();
            const city = this.selectedCity;

            return this.matches.filter(m => {
                if (city && m.city !== city) return false;
                if (!query) return true;

                const name = (m.first_name + ' ' + m.last_name).toLowerCase();
                const profession = (m.profession || '').toLowerCase();
                const community = (m.community || '').toLowerCase();
                const religion = (m.religion || '').toLowerCase();
                const location = (m.city + ' ' + m.state).toLowerCase();
                const id = (m.id || '').toLowerCase();

                return name.includes(query) || profession.includes(query) || community.includes(query) || religion.includes(query) || location.includes(query) || id.includes(query);
            });
        },

        isShortlisted(id) {
            return this.shortlistedIds.includes(id);
        },

        isInterestSent(id) {
            return this.sentInterestIds.includes(id);
        },

        async toggleShortlist(match) {
            if (!match) return;
            const isCurrentlyShortlisted = this.shortlistedIds.includes(match.id);

            // Optimistic UI update
            if (isCurrentlyShortlisted) {
                this.shortlistedIds = this.shortlistedIds.filter(i => i !== match.id);
                if (this.activeTab === 'shortlisted') {
                    this.matches = this.matches.filter(m => m.id !== match.id);
                }
            } else {
                this.shortlistedIds.push(match.id);
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

        sendInterest(match) {
            if (!match) return;
            if (this.sentInterestIds.includes(match.id)) return;

            this.sentInterestIds.push(match.id);

            fetch('{{ route("matches.send-interest") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({
                    profile_id: match.id
                })
            }).catch(console.error);

            Swal.fire({
                icon: 'success',
                title: 'Interest Sent!',
                text: 'Your connection request has been sent to ' + match.first_name + '. We will notify you once accepted.',
                customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
            });
        },

        openContactModal(match) {
            this.selectedMatch = match;
            this.contactModalOpen = true;
        },

        unlockContactNow() {
            this.contactModalOpen = false;
            Swal.fire({
                icon: 'success',
                title: 'Contact Unlocked!',
                html: '<p class="text-sm">Mobile: <strong>+91 98201 49842</strong><br>Email: <strong>' + (this.selectedMatch.first_name).toLowerCase() + '@example.com</strong></p>',
                customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
            });
        }
    };
}
</script>
@endsection
