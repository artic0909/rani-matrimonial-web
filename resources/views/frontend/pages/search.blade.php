@extends(Auth::check() ? 'frontend.layouts.auth_app' : 'frontend.layouts.app')

@section('title', 'Search Matrimonial Profiles | Rani Matrimonial')

@section('content')
<style>
/* Rani Filter Modern Form Controls */
.rani-filter-select,
.rani-filter-input {
    width: 100%;
    font-size: 0.75rem; /* 12px */
    line-height: 1.15rem;
    padding-top: 0.5rem;
    padding-bottom: 0.5rem;
    padding-left: 0.75rem;
    padding-right: 0.75rem;
    background-color: #f8fafc; /* slate-50 */
    border: 1px solid #cbd5e1; /* slate-300 */
    border-radius: 0.75rem; /* rounded-xl */
    color: #1e293b; /* slate-800 */
    font-weight: 500;
    box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.04);
    outline: none;
    transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
}

.rani-filter-select:hover,
.rani-filter-input:hover {
    background-color: #ffffff;
    border-color: #94a3b8; /* slate-400 */
}

.rani-filter-select:focus,
.rani-filter-input:focus {
    background-color: #ffffff;
    border-color: #881337 !important; /* rani-primary */
    box-shadow: 0 0 0 3px rgba(136, 19, 55, 0.12) !important;
}

.rani-filter-select {
    appearance: none !important;
    -webkit-appearance: none !important;
    -moz-appearance: none !important;
    padding-right: 2rem !important;
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%2364748b' stroke-width='2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E") !important;
    background-repeat: no-repeat !important;
    background-position: right 0.65rem center !important;
    background-size: 0.95rem !important;
    cursor: pointer;
}

.rani-filter-select:focus {
    background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%23881337' stroke-width='2.2'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E") !important;
}

/* Looking For Segmented Pill Switcher */
.rani-gender-switch {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.35rem;
    padding: 0.25rem;
    background-color: #f1f5f9;
    border-radius: 0.875rem;
    border: 1px solid #cbd5e1;
}

.rani-gender-btn {
    padding-top: 0.45rem;
    padding-bottom: 0.45rem;
    font-size: 0.75rem;
    border-radius: 0.65rem;
    font-weight: 600;
    transition: all 0.18s ease;
    cursor: pointer;
    text-align: center;
    border: none;
    outline: none;
}
.rani-gender-btn.active {
    background-color: #881337;
    color: #ffffff;
    box-shadow: 0 2px 6px rgba(136, 19, 55, 0.25);
}
.rani-gender-btn:not(.active) {
    color: #475569;
    background-color: transparent;
}
.rani-gender-btn:not(.active):hover {
    color: #0f172a;
    background-color: #ffffff;
}
</style>
<div class="relative {{ Auth::check() ? 'pt-6 sm:pt-8' : 'pt-24 sm:pt-28 md:pt-32' }} pb-20 min-h-screen" x-data="searchManager()" x-init="initSearch()">
    
    <!-- Background Image (Exact same as matches & dashboard pages) -->
    <div class="fixed inset-0 z-0 bg-cover bg-top bg-no-repeat" style="background-image: url('{{ asset('img/hero.png') }}');"></div>
    
    <!-- Maroon/Gold Gradient Overlay (Exact same as matches & dashboard pages) -->
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

    <div class="relative z-10 max-w-7xl mx-auto px-2.5 sm:px-6 lg:px-8 space-y-4 sm:space-y-6">
        
        <!-- ================= TOP HERO BANNER & QUICK SEARCH ================= -->
        <div class="bg-white/95 backdrop-blur-md rounded-2xl sm:rounded-3xl shadow-2xl border border-white/60 p-4 sm:p-6 md:p-8 relative overflow-hidden">
            <!-- Top Royal Gold Accent Bar -->
            <div class="absolute top-0 left-0 w-full h-2 sm:h-2.5 bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-95"></div>

            <div class="flex flex-col lg:flex-row lg:items-center justify-between gap-4">
                <!-- Title & Headline -->
                <div class="space-y-1">
                    <div class="flex items-center gap-2.5 sm:gap-3 flex-wrap">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl bg-gradient-to-br from-rani-primary to-rani-primary-dark flex items-center justify-center text-rani-gold shadow-md shrink-0">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </div>
                        <div>
                            <h1 class="text-xl sm:text-2xl md:text-3xl font-bold font-serif text-rani-primary-dark tracking-wide flex items-center gap-2">
                                <span>Search Matrimonial Profiles</span>
                                <span class="hidden sm:inline-block text-[11px] font-sans font-bold px-2.5 py-0.5 rounded-full bg-rani-gold/20 text-amber-900 border border-rani-gold/40">Verified Profiles</span>
                            </h1>
                            <p class="text-[11px] sm:text-xs text-gray-500 font-sans mt-0.5 leading-snug">
                                Real-time dynamic filtering across verified brides & grooms. Changes apply automatically without clicking submit.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Top Stats Badge & Mobile Filter Trigger -->
                <div class="flex items-center gap-2.5 self-start lg:self-center shrink-0">
                    <div class="px-3.5 py-1.5 rounded-full bg-gradient-to-r from-rani-light to-amber-50/80 text-rani-primary-dark border border-rani-gold/40 text-xs sm:text-sm font-bold flex items-center gap-2 shadow-xs">
                        <span class="w-2.5 h-2.5 rounded-full bg-emerald-500 animate-pulse"></span>
                        <span x-text="isLoading ? 'Searching...' : totalCount + ' Profiles Found'"></span>
                    </div>

                    <!-- Mobile Filter Drawer Trigger -->
                    <button type="button" 
                            @click="mobileFilterOpen = true" 
                            class="lg:hidden px-4 py-2 rounded-full bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white font-bold text-xs shadow-md border border-rani-gold/40 flex items-center gap-1.5 active:scale-95 transition-all cursor-pointer">
                        <svg class="w-4 h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                        <span>Filters</span>
                        <span x-show="activeFilterCount > 0" class="bg-amber-400 text-rani-dark text-[10px] font-black px-1.5 py-0.2 rounded-full" x-text="activeFilterCount"></span>
                    </button>
                </div>
            </div>

            <!-- Instant Search Input & Quick Controls Bar -->
            <div class="mt-4 sm:mt-6 pt-4 border-t border-gray-100 flex flex-col md:flex-row items-stretch md:items-center gap-3">
                <!-- Search Keyword / ID Input -->
                <div class="relative flex-1 group">
                    <input type="text" 
                           x-model="filters.keyword" 
                           @input.debounce.300ms="fetchResults()" 
                           placeholder="Search by Profile ID (e.g. RM00001), Name, City, Profession, Education..." 
                           class="w-full pl-11 pr-10 py-2.5 sm:py-3 rounded-xl sm:rounded-2xl border border-slate-200 hover:border-slate-300 focus:outline-none focus:ring-3 focus:ring-rani-primary/15 focus:border-rani-primary bg-slate-50/70 hover:bg-white focus:bg-white text-xs sm:text-sm text-gray-800 placeholder-gray-400 shadow-2xs transition-all">
                    
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-gray-400 group-focus-within:text-rani-primary absolute left-3.5 top-1/2 -translate-y-1/2 pointer-events-none transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    
                    <button type="button" 
                            x-show="filters.keyword" 
                            @click="filters.keyword = ''; fetchResults()" 
                            class="absolute right-3.5 top-1/2 -translate-y-1/2 text-gray-400 hover:text-red-500 p-1 rounded-full hover:bg-gray-100 transition-colors cursor-pointer"
                            title="Clear search text">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Quick Toggle Switches & Reset -->
                <div class="flex items-center gap-2 sm:gap-2.5 flex-wrap">
                    <!-- Photo Available Filter -->
                    <button type="button"
                            @click="filters.has_photo = !filters.has_photo; fetchResults()"
                            class="px-3.5 py-2.5 rounded-xl border text-xs font-semibold flex items-center gap-2 select-none transition-all active:scale-95 shadow-2xs cursor-pointer"
                            :class="filters.has_photo ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white border-rani-gold shadow-md font-bold' : 'bg-gray-50 hover:bg-gray-100 border-gray-200 text-gray-700'">
                        <svg class="w-4 h-4" :class="filters.has_photo ? 'text-rani-gold' : 'text-gray-400'" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span>Photo Available</span>
                    </button>

                    <!-- Blue Tick Verified Only -->
                    <button type="button"
                            @click="filters.verified_only = !filters.verified_only; fetchResults()"
                            class="px-3.5 py-2.5 rounded-xl border text-xs font-semibold flex items-center gap-2 select-none transition-all active:scale-95 shadow-2xs cursor-pointer"
                            :class="filters.verified_only ? 'bg-sky-600 text-white border-sky-400 shadow-md font-bold' : 'bg-gray-50 hover:bg-gray-100 border-gray-200 text-gray-700'">
                        <svg class="w-4 h-4" :class="filters.verified_only ? 'text-sky-200' : 'text-sky-500'" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Blue Tick Verified</span>
                    </button>

                    <!-- Reset All Filters Button -->
                    <button type="button" 
                            x-show="activeFilterCount > 0" 
                            @click="resetAllFilters()" 
                            class="px-3.5 py-2.5 rounded-xl border border-rose-200 bg-rose-50/90 hover:bg-rose-100 text-rose-700 text-xs font-bold flex items-center gap-1.5 transition-all shadow-xs active:scale-95 cursor-pointer">
                        <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <span>Reset All (<span x-text="activeFilterCount"></span>)</span>
                    </button>
                </div>
            </div>

            <!-- Quick Filter Presets Row (Themed Icons) -->
            <div class="mt-3.5 pt-3 border-t border-gray-100/80 flex items-center gap-2 overflow-x-auto pb-1 text-xs [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                <span class="text-gray-400 font-semibold shrink-0 text-[11px] uppercase tracking-wider flex items-center gap-1">
                    <svg class="w-3.5 h-3.5 text-rani-gold" fill="currentColor" viewBox="0 0 20 20"><path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM14 11a1 1 0 011 1v1h1a1 1 0 110 2h-1v1a1 1 0 11-2 0v-1h-1a1 1 0 110-2h1v-1a1 1 0 011-1z"/></svg>
                    <span>Quick Filters:</span>
                </span>
                
                <!-- Brides Preset -->
                <button type="button" 
                        @click="filters.gender = 'Female'; fetchResults()"
                        class="px-3 py-1.5 rounded-full border transition-all shrink-0 select-none flex items-center gap-1.5 font-medium cursor-pointer"
                        :class="filters.gender === 'Female' ? 'bg-rose-50 border-rose-300 text-rose-800 font-bold shadow-2xs' : 'bg-gray-50 border-gray-200 text-gray-700 hover:bg-gray-100'">
                    <svg class="w-3.5 h-3.5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3.5a3 3 0 016 0"/></svg>
                    <span>Brides</span>
                </button>

                <!-- Grooms Preset -->
                <button type="button" 
                        @click="filters.gender = 'Male'; fetchResults()"
                        class="px-3 py-1.5 rounded-full border transition-all shrink-0 select-none flex items-center gap-1.5 font-medium cursor-pointer"
                        :class="filters.gender === 'Male' ? 'bg-sky-50 border-sky-300 text-sky-800 font-bold shadow-2xs' : 'bg-gray-50 border-gray-200 text-gray-700 hover:bg-gray-100'">
                    <svg class="w-3.5 h-3.5 text-sky-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    <span>Grooms</span>
                </button>

                <!-- Never Married Preset -->
                <button type="button" 
                        @click="filters.marital_status = 'Never Married'; fetchResults()"
                        class="px-3 py-1.5 rounded-full border transition-all shrink-0 select-none flex items-center gap-1.5 font-medium cursor-pointer"
                        :class="filters.marital_status === 'Never Married' ? 'bg-amber-50 border-amber-300 text-amber-900 font-bold shadow-2xs' : 'bg-gray-50 border-gray-200 text-gray-700 hover:bg-gray-100'">
                    <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/></svg>
                    <span>Never Married</span>
                </button>

                <!-- Vegetarian Preset -->
                <button type="button" 
                        @click="filters.diet = 'Vegetarian'; fetchResults()"
                        class="px-3 py-1.5 rounded-full border transition-all shrink-0 select-none flex items-center gap-1.5 font-medium cursor-pointer"
                        :class="filters.diet === 'Vegetarian' ? 'bg-emerald-50 border-emerald-300 text-emerald-800 font-bold shadow-2xs' : 'bg-gray-50 border-gray-200 text-gray-700 hover:bg-gray-100'">
                    <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/></svg>
                    <span>Vegetarian</span>
                </button>

                <!-- Non-Manglik Preset -->
                <button type="button" 
                        @click="filters.manglik = 'Non-Manglik'; fetchResults()"
                        class="px-3 py-1.5 rounded-full border transition-all shrink-0 select-none flex items-center gap-1.5 font-medium cursor-pointer"
                        :class="filters.manglik === 'Non-Manglik' ? 'bg-purple-50 border-purple-300 text-purple-800 font-bold shadow-2xs' : 'bg-gray-50 border-gray-200 text-gray-700 hover:bg-gray-100'">
                    <svg class="w-3.5 h-3.5 text-purple-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                    <span>Non-Manglik</span>
                </button>

                <!-- Post Graduate Preset -->
                <button type="button" 
                        @click="filters.highest_qualification = 'Masters'; fetchResults()"
                        class="px-3 py-1.5 rounded-full border transition-all shrink-0 select-none flex items-center gap-1.5 font-medium cursor-pointer"
                        :class="filters.highest_qualification === 'Masters' ? 'bg-indigo-50 border-indigo-300 text-indigo-800 font-bold shadow-2xs' : 'bg-gray-50 border-gray-200 text-gray-700 hover:bg-gray-100'">
                    <svg class="w-3.5 h-3.5 text-indigo-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>
                    <span>Post Graduate</span>
                </button>

                <!-- Govt / PSU Sector Preset -->
                <button type="button" 
                        @click="filters.working_with = 'Government / Public Sector'; fetchResults()"
                        class="px-3 py-1.5 rounded-full border transition-all shrink-0 select-none flex items-center gap-1.5 font-medium cursor-pointer"
                        :class="filters.working_with === 'Government / Public Sector' ? 'bg-teal-50 border-teal-300 text-teal-800 font-bold shadow-2xs' : 'bg-gray-50 border-gray-200 text-gray-700 hover:bg-gray-100'">
                    <svg class="w-3.5 h-3.5 text-teal-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                    <span>Govt / PSU</span>
                </button>
            </div>
        </div>

        <!-- ================= MAIN LAYOUT: LEFT SIDEBAR FILTERS + RIGHT PROFILES ================= -->
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 sm:gap-6 items-start">
            
            <!-- ================= DESKTOP STICKY FILTER PANEL (Scrollbar Cleanly Hidden) ================= -->
            <div class="hidden lg:block lg:col-span-4 sticky top-20 bg-white/95 backdrop-blur-md rounded-2xl sm:rounded-3xl shadow-xl border border-white/60 p-5 space-y-4 max-h-[85vh] overflow-y-auto [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                
                <!-- Filter Panel Header -->
                <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                    <div class="flex items-center gap-2">
                        <div class="w-7 h-7 rounded-lg bg-rani-primary/10 text-rani-primary flex items-center justify-center font-bold">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                        </div>
                        <h3 class="font-serif font-bold text-gray-900 text-base">Filter Profiles</h3>
                    </div>
                    
                    <button type="button" 
                            @click="resetAllFilters()" 
                            class="text-xs text-rani-primary hover:text-rani-primary-dark font-bold transition-colors cursor-pointer">
                        Reset All
                    </button>
                </div>

                <!-- Section 1: Basic & Profile Details -->
                <div class="border border-gray-100/80 rounded-2xl p-4 bg-gradient-to-br from-gray-50/60 to-white space-y-3.5 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs font-bold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-rani-primary"></span>
                            <span>Looking For & Basics</span>
                        </h4>
                        <span class="text-[10px] font-mono font-bold text-rani-gold bg-rani-primary/5 px-2 py-0.5 rounded-full">01</span>
                    </div>

                    <!-- Gender Option Buttons -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1.5">Looking For</label>
                        <div class="rani-gender-switch">
                            <button type="button" @click="filters.gender = 'all'; fetchResults()" :class="filters.gender === 'all' ? 'active' : ''" class="rani-gender-btn">All</button>
                            <button type="button" @click="filters.gender = 'Female'; fetchResults()" :class="filters.gender === 'Female' ? 'active' : ''" class="rani-gender-btn">Bride</button>
                            <button type="button" @click="filters.gender = 'Male'; fetchResults()" :class="filters.gender === 'Male' ? 'active' : ''" class="rani-gender-btn">Groom</button>
                        </div>
                    </div>

                    <!-- Profile Created For -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Profile Created By</label>
                        <select x-model="filters.profile_for" @change="fetchResults()" class="rani-filter-select">
                            <option value="all">All (Created By Anyone)</option>
                            @foreach($profileFors as $pf)
                                <option value="{{ $pf }}">{{ $pf }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Age Range -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Age Range</label>
                        <div class="grid grid-cols-2 gap-2">
                            <select x-model="filters.age_min" @change="fetchResults()" class="rani-filter-select">
                                <option value="">Min Age (Any)</option>
                                @for($a = 18; $a <= 65; $a++)
                                    <option value="{{ $a }}">{{ $a }} Yrs</option>
                                @endfor
                            </select>
                            <select x-model="filters.age_max" @change="fetchResults()" class="rani-filter-select">
                                <option value="">Max Age (Any)</option>
                                @for($a = 18; $a <= 70; $a++)
                                    <option value="{{ $a }}">{{ $a }} Yrs</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    <!-- Height Range -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Height Range</label>
                        <div class="grid grid-cols-2 gap-2">
                            <select x-model="filters.height_min" @change="fetchResults()" class="rani-filter-select">
                                <option value="all">Min Height (Any)</option>
                                @foreach($heights as $h)
                                    <option value="{{ $h->name }}">{{ $h->name }}</option>
                                @endforeach
                            </select>
                            <select x-model="filters.height_max" @change="fetchResults()" class="rani-filter-select">
                                <option value="all">Max Height (Any)</option>
                                @foreach($heights as $h)
                                    <option value="{{ $h->name }}">{{ $h->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Marital Status -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Marital Status</label>
                        <select x-model="filters.marital_status" @change="fetchResults()" class="rani-filter-select">
                            <option value="all">All Marital Statuses</option>
                            @foreach($maritalStatuses as $ms)
                                <option value="{{ $ms->name }}">{{ $ms->name }}</option>
                            @endforeach
                            <option value="Never Married">Never Married</option>
                            <option value="Divorced">Divorced</option>
                            <option value="Widowed">Widowed</option>
                            <option value="Awaiting Divorce">Awaiting Divorce</option>
                            <option value="Annulled">Annulled</option>
                        </select>
                    </div>
                </div>

                <!-- Section 2: Religion, Community & Astro -->
                <div class="border border-gray-100/80 rounded-2xl p-4 bg-gradient-to-br from-gray-50/60 to-white space-y-3.5 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs font-bold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-amber-500"></span>
                            <span>Religion & Astro</span>
                        </h4>
                        <span class="text-[10px] font-mono font-bold text-rani-gold bg-rani-primary/5 px-2 py-0.5 rounded-full">02</span>
                    </div>

                    <!-- Religion -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Religion</label>
                        <select x-model="filters.religion" @change="onReligionChange()" class="rani-filter-select">
                            <option value="all">All Religions</option>
                            @foreach($religions as $r)
                                <option value="{{ $r->name }}">{{ $r->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Community / Caste -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Community / Caste</label>
                        <select x-model="filters.community" @change="fetchResults()" class="rani-filter-select">
                            <option value="all">All Communities</option>
                            <template x-for="com in availableCommunities" :key="com.id || com.name">
                                <option :value="com.name" x-text="com.name"></option>
                            </template>
                        </select>
                    </div>

                    <!-- Sub-Community -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Sub-Community / Clan</label>
                        <input type="text" x-model.debounce.400ms="filters.sub_community" @input="fetchResults()" placeholder="e.g. Kulin, Vaishnav..." class="rani-filter-input">
                    </div>

                    <!-- Mother Tongue -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Mother Tongue</label>
                        <select x-model="filters.mother_tongue" @change="fetchResults()" class="rani-filter-select">
                            <option value="all">All Mother Tongues</option>
                            @foreach($motherTongues as $mt)
                                <option value="{{ $mt }}">{{ $mt }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Manglik Status -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Manglik Status</label>
                        <select x-model="filters.manglik" @change="fetchResults()" class="rani-filter-select">
                            <option value="all">All Manglik Statuses</option>
                            <option value="Non-Manglik">Non-Manglik</option>
                            <option value="Manglik">Manglik</option>
                            <option value="Anshik Manglik">Anshik Manglik</option>
                            <option value="Don't Know">Don't Know</option>
                        </select>
                    </div>

                    <!-- Gothra -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Gothra</label>
                        <input type="text" x-model.debounce.400ms="filters.gothra" @input="fetchResults()" placeholder="e.g. Kashyap, Shandilya..." class="rani-filter-input">
                    </div>
                </div>

                <!-- Section 3: Location Details -->
                <div class="border border-gray-100/80 rounded-2xl p-4 bg-gradient-to-br from-gray-50/60 to-white space-y-3.5 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs font-bold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-sky-500"></span>
                            <span>Location & Living</span>
                        </h4>
                        <span class="text-[10px] font-mono font-bold text-rani-gold bg-rani-primary/5 px-2 py-0.5 rounded-full">03</span>
                    </div>

                    <!-- Country -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Country</label>
                        <select x-model="filters.country" @change="onCountryChange()" class="rani-filter-select">
                            <option value="all">All Countries</option>
                            @foreach($countries as $c)
                                <option value="{{ $c->name }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- State -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">State</label>
                        <select x-model="filters.state" @change="onStateChange()" class="rani-filter-select">
                            <option value="all">All States</option>
                            <template x-for="st in availableStates" :key="st.id || st.name">
                                <option :value="st.name" x-text="st.name"></option>
                            </template>
                        </select>
                    </div>

                    <!-- City -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">City</label>
                        <select x-model="filters.city" @change="fetchResults()" class="rani-filter-select">
                            <option value="all">All Cities</option>
                            <template x-for="ct in availableCities" :key="ct.id || ct.name">
                                <option :value="ct.name" x-text="ct.name"></option>
                            </template>
                        </select>
                    </div>

                    <!-- Residency Status -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Residency Status</label>
                        <select x-model="filters.residency_status" @change="fetchResults()" class="rani-filter-select">
                            <option value="all">All Residency Types</option>
                            @foreach($residencyStatuses as $rs)
                                <option value="{{ $rs }}">{{ $rs }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Grew Up In -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Grew Up In (City / Region)</label>
                        <input type="text" x-model.debounce.400ms="filters.grew_up_in" @input="fetchResults()" placeholder="e.g. Kolkata, Mumbai..." class="rani-filter-input">
                    </div>
                </div>

                <!-- Section 4: Education, Profession & Income -->
                <div class="border border-gray-100/80 rounded-2xl p-4 bg-gradient-to-br from-gray-50/60 to-white space-y-3.5 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs font-bold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                            <span>Education & Career</span>
                        </h4>
                        <span class="text-[10px] font-mono font-bold text-rani-gold bg-rani-primary/5 px-2 py-0.5 rounded-full">04</span>
                    </div>

                    <!-- Highest Qualification -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Highest Qualification</label>
                        <select x-model="filters.highest_qualification" @change="fetchResults()" class="rani-filter-select">
                            <option value="all">All Qualifications</option>
                            <option value="Doctorate">Doctorate / PhD</option>
                            <option value="Masters">Masters / Post Graduate</option>
                            <option value="Bachelors">Bachelors / Graduate</option>
                            <option value="Diploma">Diploma / Vocational</option>
                            <option value="High School">High School</option>
                            <option value="MBBS">MBBS / Medical</option>
                            <option value="B.Tech">B.Tech / B.E. / Engineering</option>
                            <option value="MBA">MBA / PGDM</option>
                            <option value="CA">CA / CS / Finance</option>
                        </select>
                    </div>

                    <!-- Working Sector -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Working Sector</label>
                        <select x-model="filters.working_with" @change="fetchResults()" class="rani-filter-select">
                            <option value="all">All Sectors</option>
                            @foreach($workingWiths as $ww)
                                <option value="{{ $ww->name }}">{{ $ww->name }}</option>
                            @endforeach
                            <option value="Private Company">Private Company</option>
                            <option value="Government / Public Sector">Government / Public Sector</option>
                            <option value="Business / Self Employed">Business / Self Employed</option>
                            <option value="Defense / Civil Services">Defense / Civil Services</option>
                            <option value="Not Working">Not Working</option>
                        </select>
                    </div>

                    <!-- Profession / Designation Search -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Profession / Role</label>
                        <input type="text" x-model.debounce.400ms="filters.profession" @input="fetchResults()" placeholder="e.g. Software Engineer, Doctor, CA..." class="rani-filter-input">
                    </div>

                    <!-- Annual Income -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Annual Income</label>
                        <select x-model="filters.annual_income" @change="fetchResults()" class="rani-filter-select">
                            <option value="all">All Income Levels</option>
                            @foreach($incomes as $inc)
                                <option value="{{ $inc->name }}">{{ $inc->name }}</option>
                            @endforeach
                            <option value="0-3">₹0 - 3 Lakh</option>
                            <option value="3-6">₹3 - 6 Lakh</option>
                            <option value="6-10">₹6 - 10 Lakh</option>
                            <option value="10-15">₹10 - 15 Lakh</option>
                            <option value="15-25">₹15 - 25 Lakh</option>
                            <option value="25-50">₹25 - 50 Lakh</option>
                            <option value="50">₹50 Lakh - 1 Crore</option>
                            <option value="100">₹1 Crore & above</option>
                        </select>
                    </div>
                </div>

                <!-- Section 5: Lifestyle, Health & Habits -->
                <div class="border border-gray-100/80 rounded-2xl p-4 bg-gradient-to-br from-gray-50/60 to-white space-y-3.5 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs font-bold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-rose-500"></span>
                            <span>Lifestyle & Health</span>
                        </h4>
                        <span class="text-[10px] font-mono font-bold text-rani-gold bg-rani-primary/5 px-2 py-0.5 rounded-full">05</span>
                    </div>

                    <!-- Diet -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Diet</label>
                        <select x-model="filters.diet" @change="fetchResults()" class="rani-filter-select">
                            <option value="all">All Diets</option>
                            @foreach($diets as $d)
                                <option value="{{ $d->name }}">{{ $d->name }}</option>
                            @endforeach
                            <option value="Vegetarian">Vegetarian</option>
                            <option value="Non-Vegetarian">Non-Vegetarian</option>
                            <option value="Eggetarian">Eggetarian</option>
                            <option value="Jain">Jain</option>
                            <option value="Vegan">Vegan</option>
                        </select>
                    </div>

                    <!-- Blood Group -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Blood Group</label>
                        <select x-model="filters.blood_group" @change="fetchResults()" class="rani-filter-select">
                            <option value="all">All Blood Groups</option>
                            @foreach($bloodGroups as $bg)
                                <option value="{{ $bg }}">{{ $bg }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Disability / Special Needs -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Disability / Special Needs</label>
                        <select x-model="filters.disability" @change="fetchResults()" class="rani-filter-select">
                            <option value="all">Doesn't Matter (All)</option>
                            <option value="None">None (Normal)</option>
                            <option value="Physically Challenged">Physically Challenged</option>
                        </select>
                    </div>

                    <!-- Hobbies / Interests -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Hobbies & Interests</label>
                        <select x-model="filters.hobbies_interests" @change="fetchResults()" class="rani-filter-select">
                            <option value="all">All Hobbies</option>
                            @foreach($hobbies as $hb)
                                <option value="{{ $hb->name }}">{{ $hb->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Section 6: Family Background -->
                <div class="border border-gray-100/80 rounded-2xl p-4 bg-gradient-to-br from-gray-50/60 to-white space-y-3.5 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs font-bold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                            <span>Family Background</span>
                        </h4>
                        <span class="text-[10px] font-mono font-bold text-rani-gold bg-rani-primary/5 px-2 py-0.5 rounded-full">06</span>
                    </div>

                    <!-- Family Financial Status -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Family Financial Status</label>
                        <select x-model="filters.family_financial_status" @change="fetchResults()" class="rani-filter-select">
                            <option value="all">All Family Statuses</option>
                            @foreach($familyFinancialStatuses as $ffs)
                                <option value="{{ $ffs }}">{{ $ffs }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Father's Profession -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Father's Profession</label>
                        <input type="text" x-model.debounce.400ms="filters.father_profession" @input="fetchResults()" placeholder="e.g. Business, Retired, Govt..." class="rani-filter-input">
                    </div>

                    <!-- Mother's Profession -->
                    <div>
                        <label class="text-[11px] font-semibold text-slate-600 block mb-1">Mother's Profession</label>
                        <input type="text" x-model.debounce.400ms="filters.mother_profession" @input="fetchResults()" placeholder="e.g. Homemaker, Teacher..." class="rani-filter-input">
                    </div>
                </div>

                <!-- Section 7: Verification & Badges -->
                <div class="border border-gray-100/80 rounded-2xl p-4 bg-gradient-to-br from-gray-50/60 to-white space-y-3 shadow-2xs">
                    <div class="flex items-center justify-between">
                        <h4 class="text-xs font-bold text-gray-900 uppercase tracking-wider flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-blue-500"></span>
                            <span>Trust & Verification</span>
                        </h4>
                        <span class="text-[10px] font-mono font-bold text-rani-gold bg-rani-primary/5 px-2 py-0.5 rounded-full">07</span>
                    </div>

                    <label class="flex items-center justify-between p-2 rounded-xl bg-gray-50 hover:bg-gray-100/80 transition-colors cursor-pointer border border-gray-100">
                        <span class="text-xs font-semibold text-gray-800 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-rose-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            <span>Photo Available Only</span>
                        </span>
                        <input type="checkbox" x-model="filters.has_photo" @change="fetchResults()" class="w-4 h-4 rounded text-rani-primary focus:ring-rani-gold">
                    </label>

                    <label class="flex items-center justify-between p-2 rounded-xl bg-gray-50 hover:bg-gray-100/80 transition-colors cursor-pointer border border-gray-100">
                        <span class="text-xs font-semibold text-gray-800 flex items-center gap-1.5">
                            <svg class="w-3.5 h-3.5 text-blue-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                            <span>Blue Tick Verified Only</span>
                        </span>
                        <input type="checkbox" x-model="filters.verified_only" @change="fetchResults()" class="w-4 h-4 rounded text-rani-primary focus:ring-rani-gold">
                    </label>
                </div>

            </div>

            <!-- ================= RIGHT PROFILES RESULTS GRID ================= -->
            <div class="lg:col-span-8 space-y-4">
                
                <!-- Sort Toolbar & Active Filters Tags -->
                <div class="bg-white/95 backdrop-blur-md rounded-2xl sm:rounded-3xl shadow-md border border-white/60 p-4 space-y-3">
                    
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                        <!-- Applied Filters summary -->
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="text-xs font-bold text-gray-700">Filters Applied:</span>
                            
                            <span class="px-2.5 py-0.5 rounded-full bg-rani-primary/10 text-rani-primary-dark text-xs font-bold border border-rani-gold/30" 
                                  x-text="filters.gender === 'all' ? 'All Profiles' : (filters.gender === 'Female' ? 'Brides' : 'Grooms')"></span>

                            <template x-if="filters.religion !== 'all'">
                                <span class="px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-800 text-xs font-semibold border border-amber-200 flex items-center gap-1.5 shadow-2xs">
                                    <span x-text="filters.religion"></span>
                                    <button type="button" @click="filters.religion = 'all'; fetchResults()" class="hover:text-red-500 font-bold cursor-pointer">✕</button>
                                </span>
                            </template>

                            <template x-if="filters.community !== 'all'">
                                <span class="px-2.5 py-0.5 rounded-full bg-amber-50 text-amber-800 text-xs font-semibold border border-amber-200 flex items-center gap-1.5 shadow-2xs">
                                    <span x-text="filters.community"></span>
                                    <button type="button" @click="filters.community = 'all'; fetchResults()" class="hover:text-red-500 font-bold cursor-pointer">✕</button>
                                </span>
                            </template>

                            <template x-if="filters.state !== 'all'">
                                <span class="px-2.5 py-0.5 rounded-full bg-sky-50 text-sky-800 text-xs font-semibold border border-sky-200 flex items-center gap-1.5 shadow-2xs">
                                    <span x-text="filters.state"></span>
                                    <button type="button" @click="filters.state = 'all'; fetchResults()" class="hover:text-red-500 font-bold cursor-pointer">✕</button>
                                </span>
                            </template>

                            <template x-if="filters.city !== 'all'">
                                <span class="px-2.5 py-0.5 rounded-full bg-sky-50 text-sky-800 text-xs font-semibold border border-sky-200 flex items-center gap-1.5 shadow-2xs">
                                    <span x-text="filters.city"></span>
                                    <button type="button" @click="filters.city = 'all'; fetchResults()" class="hover:text-red-500 font-bold cursor-pointer">✕</button>
                                </span>
                            </template>

                            <template x-if="filters.marital_status !== 'all'">
                                <span class="px-2.5 py-0.5 rounded-full bg-purple-50 text-purple-800 text-xs font-semibold border border-purple-200 flex items-center gap-1.5 shadow-2xs">
                                    <span x-text="filters.marital_status"></span>
                                    <button type="button" @click="filters.marital_status = 'all'; fetchResults()" class="hover:text-red-500 font-bold cursor-pointer">✕</button>
                                </span>
                            </template>

                            <template x-if="filters.diet !== 'all'">
                                <span class="px-2.5 py-0.5 rounded-full bg-emerald-50 text-emerald-800 text-xs font-semibold border border-emerald-200 flex items-center gap-1.5 shadow-2xs">
                                    <span x-text="filters.diet"></span>
                                    <button type="button" @click="filters.diet = 'all'; fetchResults()" class="hover:text-red-500 font-bold cursor-pointer">✕</button>
                                </span>
                            </template>

                            <template x-if="filters.has_photo">
                                <span class="px-2.5 py-0.5 rounded-full bg-rose-50 text-rose-800 text-xs font-semibold border border-rose-200 flex items-center gap-1.5 shadow-2xs">
                                    <span>Photo Only</span>
                                    <button type="button" @click="filters.has_photo = false; fetchResults()" class="hover:text-red-500 font-bold cursor-pointer">✕</button>
                                </span>
                            </template>

                            <template x-if="filters.verified_only">
                                <span class="px-2.5 py-0.5 rounded-full bg-sky-50 text-sky-800 text-xs font-semibold border border-sky-200 flex items-center gap-1.5 shadow-2xs">
                                    <span>Verified Only</span>
                                    <button type="button" @click="filters.verified_only = false; fetchResults()" class="hover:text-red-500 font-bold cursor-pointer">✕</button>
                                </span>
                            </template>
                        </div>

                        <!-- Sort By Selector -->
                        <div class="flex items-center gap-2 self-end sm:self-center shrink-0">
                            <span class="text-xs text-slate-500 font-semibold">Sort By:</span>
                            <select x-model="filters.sort_by" @change="fetchResults()" class="rani-filter-select !w-auto !py-1.5 !text-xs font-semibold !rounded-xl !bg-white">
                                <option value="latest">Newest Registered</option>
                                <option value="age_asc">Age: Low to High</option>
                                <option value="age_desc">Age: High to Low</option>
                                <option value="oldest">Oldest Profiles</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- Shimmer Loading Skeletons (2 Side by Side) -->
                <div x-show="isLoading" class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                    <template x-for="i in 4" :key="i">
                        <div class="bg-white rounded-2xl sm:rounded-3xl border border-gray-200/90 shadow-sm overflow-hidden animate-pulse">
                            <div class="h-48 sm:h-52 bg-gray-200 relative">
                                <div class="absolute top-2.5 left-2.5 w-16 h-4 bg-gray-300 rounded-full"></div>
                                <div class="absolute top-2.5 right-2.5 w-7 h-7 bg-gray-300 rounded-full"></div>
                            </div>
                            <div class="p-3 sm:p-4 space-y-2.5">
                                <div class="h-12 bg-gray-100 rounded-xl"></div>
                                <div class="h-3.5 bg-gray-200 rounded w-3/4"></div>
                                <div class="h-3 bg-gray-200 rounded w-1/2"></div>
                                <div class="h-8 bg-gray-200 rounded-xl"></div>
                            </div>
                        </div>
                    </template>
                </div>

                <!-- Profile Cards Grid (2 Side by Side, Compact Height) -->
                <div x-show="!isLoading && candidates.length > 0" class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                    <template x-for="match in candidates" :key="match.id">
                        <div class="bg-white rounded-2xl sm:rounded-3xl border border-gray-200/90 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 overflow-hidden flex flex-col justify-between group">
                            
                            <div>
                                <!-- Image & Spotlight Badges Container (Click to open Photo Gallery Modal) -->
                                <div class="relative h-48 sm:h-52 w-full overflow-hidden bg-gray-100 cursor-pointer group/photo select-none"
                                     @click="openPhotoGallery(match, 0)"
                                     title="Click to view profile photos">
                                     
                                    <img :src="match.photo" 
                                         :alt="match.first_name" 
                                         class="w-full h-full object-cover object-top transition-transform duration-700 group-hover/photo:scale-105">
                                    
                                    <!-- Top Gradient Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent pointer-events-none"></div>

                                    <!-- Top Left: Match Percentage Badge -->
                                    <div class="absolute top-2 left-2 sm:top-2.5 sm:left-2.5 z-10">
                                        <span class="px-2.5 py-0.5 rounded-full bg-gradient-to-r from-rani-gold to-yellow-500 text-rani-dark text-[10px] font-bold shadow-md flex items-center gap-1 border border-white/40">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            <span x-text="match.match_score + '% Match'"></span>
                                        </span>
                                    </div>

                                    <!-- Top Right: Shortlist Heart Action -->
                                    @auth
                                    <button type="button" 
                                            @click.stop="toggleShortlist(match)"
                                            class="absolute top-2 right-2 sm:top-2.5 sm:right-2.5 w-7 h-7 sm:w-8 sm:h-8 rounded-full bg-white/80 hover:bg-white backdrop-blur-xs text-gray-700 hover:text-rose-600 shadow-md flex items-center justify-center transition-all hover:scale-110 active:scale-95 z-20 cursor-pointer"
                                            :class="match.is_shortlisted ? 'text-rose-600 bg-white ring-2 ring-rose-300' : ''"
                                            :title="match.is_shortlisted ? 'Remove from Shortlist' : 'Add to Shortlist'">
                                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" :fill="match.is_shortlisted ? 'currentColor' : 'none'" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                    </button>
                                    @endauth

                                    <!-- Bottom Image Overlay Text: Name & ID -->
                                    <div class="absolute bottom-2 left-2.5 right-2.5 sm:bottom-2.5 sm:left-3 sm:right-3 text-white z-10 flex items-end justify-between">
                                        <div class="max-w-[70%]">
                                            <a :href="match.token_url" class="group/name flex items-center gap-1.5 hover:text-rani-gold transition-colors" @click.stop>
                                                <h3 class="text-base sm:text-lg font-bold font-serif drop-shadow-md truncate" x-text="match.first_name + ' ' + match.last_name"></h3>
                                                <span x-show="match.verified" class="inline-flex items-center justify-center w-3.5 h-3.5 sm:w-4 sm:h-4 rounded-full bg-gradient-to-tr from-blue-600 via-sky-500 to-sky-400 text-white shadow shrink-0" title="Blue Tick Verified Profile">
                                                    <svg class="w-2 h-2 sm:w-2.5 sm:h-2.5 text-white" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                                </span>
                                            </a>
                                            <div class="text-[10px] text-gray-200 font-mono mt-0.5">
                                                <span x-text="'ID: ' + match.id"></span>
                                            </div>
                                        </div>

                                        <!-- Photo Count Badge Indicator -->
                                        <div class="shrink-0">
                                            <span class="px-2 py-0.5 rounded-full bg-black/60 backdrop-blur-xs text-white text-[9px] sm:text-[10px] font-semibold flex items-center gap-1 border border-white/20 group-hover/photo:bg-rani-primary group-hover/photo:border-rani-gold transition-colors shadow-sm">
                                                <svg class="w-3 h-3 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <span x-text="(match.photos ? match.photos.length : 1) + ' Photos'"></span>
                                            </span>
                                        </div>
                                    </div>

                                </div>

                                <!-- Card Bio & Particulars -->
                                <div class="p-3 sm:p-3.5 space-y-2 sm:space-y-2.5">
                                    
                                    <!-- Basic Specs Grid -->
                                    <div class="grid grid-cols-2 gap-1 sm:gap-1.5 text-[10px] sm:text-[11px] text-gray-700 bg-gray-50/90 p-2 sm:p-2.5 rounded-xl border border-gray-100">
                                        <div class="flex items-center gap-1 overflow-hidden">
                                            <span class="text-gray-400 shrink-0">Age / Ht:</span>
                                            <span class="font-bold truncate" x-text="match.age + ' yrs, ' + match.height"></span>
                                        </div>
                                        <div class="flex items-center gap-1 overflow-hidden">
                                            <span class="text-gray-400 shrink-0">Religion:</span>
                                            <span class="font-bold truncate" x-text="match.religion + (match.community && match.community !== 'All Communities' ? ', ' + match.community : '')"></span>
                                        </div>
                                        <div class="flex items-center gap-1 overflow-hidden">
                                            <span class="text-gray-400 shrink-0">Tongue:</span>
                                            <span class="font-bold truncate" x-text="match.mother_tongue"></span>
                                        </div>
                                        <div class="flex items-center gap-1 overflow-hidden">
                                            <span class="text-gray-400 shrink-0">Diet:</span>
                                            <span class="font-bold truncate" x-text="match.diet"></span>
                                        </div>
                                    </div>

                                    <!-- Career & Education -->
                                    <div class="space-y-1 text-[10px] sm:text-[11px]">
                                        <div class="flex items-start gap-1.5 text-gray-800">
                                            <svg class="w-3.5 h-3.5 text-rani-primary shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                                            <div class="truncate">
                                                <p class="font-bold text-gray-900 truncate" x-text="match.profession"></p>
                                                <p class="text-gray-500 text-[10px] truncate" x-text="match.company_name + ' • ' + match.annual_income"></p>
                                            </div>
                                        </div>

                                        <div class="flex items-center gap-1.5 text-gray-600">
                                            <svg class="w-3.5 h-3.5 text-rani-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path></svg>
                                            <span class="truncate" x-text="match.highest_qualification"></span>
                                        </div>

                                        <div class="flex items-center gap-1.5 text-gray-600">
                                            <svg class="w-3.5 h-3.5 text-rose-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                            <span class="truncate" x-text="match.city + ', ' + match.state"></span>
                                        </div>
                                    </div>

                                    <!-- Match Reasons Pill Badges -->
                                    <div class="flex flex-wrap gap-1 pt-0.5">
                                        <template x-for="reason in match.match_reasons" :key="reason">
                                            <span class="px-2 py-0.5 rounded-full text-[9px] font-semibold bg-rani-light text-rani-primary-dark border border-rani-gold/30 flex items-center gap-1">
                                                <svg class="w-2.5 h-2.5 text-rani-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                                <span x-text="reason"></span>
                                            </span>
                                        </template>
                                    </div>

                                </div>
                            </div>

                            <!-- Card Action Buttons -->
                            <div class="p-2.5 sm:p-3 bg-gray-50/90 border-t border-gray-100 flex items-center">
                                @auth
                                    <!-- Connect / Send Interest -->
                                    <template x-if="match.request_type === 'none'">
                                        <button type="button" 
                                                @click="sendInterest(match)"
                                                class="w-full py-2 sm:py-2.5 px-3 rounded-xl sm:rounded-2xl text-xs font-bold shadow-md transition-all flex items-center justify-center gap-1.5 bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white active:scale-98 cursor-pointer border border-rani-gold/30">
                                            <svg class="w-3.5 h-3.5 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                            <span>Connect</span>
                                        </button>
                                    </template>

                                    <template x-if="match.request_type === 'sent'">
                                        <span class="w-full py-2 sm:py-2.5 px-3 rounded-xl sm:rounded-2xl text-xs font-bold text-center bg-emerald-50 text-emerald-700 border border-emerald-200 flex items-center justify-center gap-1.5 shadow-2xs">
                                            <svg class="w-3.5 h-3.5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            <span>Interest Sent</span>
                                        </span>
                                    </template>

                                    <template x-if="match.request_type === 'accepted'">
                                        <span class="w-full py-2 sm:py-2.5 px-3 rounded-xl sm:rounded-2xl text-xs font-bold text-center bg-teal-50 text-teal-700 border border-teal-200 flex items-center justify-center gap-1.5 shadow-2xs">
                                            <svg class="w-3.5 h-3.5 text-teal-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                            <span>Mutual Match</span>
                                        </span>
                                    </template>
                                @else
                                    <a href="{{ route('register.page') }}" 
                                       class="w-full py-2 sm:py-2.5 px-3 rounded-xl sm:rounded-2xl text-xs font-bold shadow-md transition-all flex items-center justify-center gap-1 bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white border border-rani-gold/40 cursor-pointer">
                                        <span>Register to View Profile</span>
                                    </a>
                                @endauth
                            </div>

                        </div>
                    </template>
                </div>

                <!-- Empty State -->
                <div x-show="!isLoading && candidates.length === 0" 
                     class="bg-white/95 backdrop-blur-md rounded-3xl shadow-xl border border-white/60 p-8 sm:p-12 text-center space-y-4 max-w-xl mx-auto">
                    
                    <div class="w-20 h-20 mx-auto rounded-full bg-rani-light/80 border border-rani-gold/40 flex items-center justify-center text-rani-primary shadow-inner">
                        <svg class="w-10 h-10 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    </div>

                    <h3 class="text-xl font-bold font-serif text-gray-900">No Matched Profiles Found</h3>
                    <p class="text-xs sm:text-sm text-gray-600 leading-relaxed max-w-md mx-auto">
                        We couldn't find any profiles matching your exact filter combination. Try clearing some filters or searching by broader criteria.
                    </p>

                    <button type="button" 
                            @click="resetAllFilters()" 
                            class="inline-flex items-center gap-2 px-6 py-2.5 rounded-full bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white font-bold text-xs sm:text-sm shadow-md hover:shadow-lg hover:scale-105 active:scale-95 transition-all border border-rani-gold/40 cursor-pointer">
                        <svg class="w-4 h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                        <span>Reset All Filters</span>
                    </button>
                </div>

            </div>

        </div>

    </div>

    <!-- ================= MOBILE FILTER SLIDE-OVER DRAWER ================= -->
    <template x-teleport="body">
        <div x-show="mobileFilterOpen" 
             x-cloak
             class="lg:hidden fixed inset-0 z-[99999] flex justify-end" 
             style="display: none;">
            
            <!-- Backdrop -->
            <div x-show="mobileFilterOpen" 
                 x-transition:enter="transition-opacity ease-linear duration-300"
                 x-transition:enter-start="opacity-0"
                 x-transition:enter-end="opacity-100"
                 x-transition:leave="transition-opacity ease-linear duration-200"
                 x-transition:leave-start="opacity-100"
                 x-transition:leave-end="opacity-0"
                 @click="mobileFilterOpen = false" 
                 class="fixed inset-0 bg-black/80 backdrop-blur-sm z-[99998]"></div>

            <!-- Drawer Container -->
            <div x-show="mobileFilterOpen" 
                 x-transition:enter="transition ease-out duration-300 transform"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transition ease-in duration-200 transform"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="relative flex flex-col w-[88vw] max-w-[340px] bg-white shadow-2xl h-[100dvh] z-[99999] overflow-hidden">
                
                <!-- Drawer Header -->
                <div class="px-4 py-3.5 bg-gradient-to-r from-rani-dark via-rani-primary-dark to-rani-dark text-white flex items-center justify-between border-b border-rani-gold/30 shrink-0">
                    <div class="flex items-center gap-2">
                        <svg class="w-5 h-5 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/></svg>
                        <h3 class="font-serif font-bold text-base">Search Filters</h3>
                    </div>
                    <button type="button" @click="mobileFilterOpen = false" class="text-gray-300 hover:text-white p-1.5 rounded-full bg-white/10 active:scale-90 cursor-pointer">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                    </button>
                </div>

                <!-- Drawer Filter Body (Clean scrollbar) -->
                <!-- Drawer Filter Body (Clean scrollbar) -->
                <div class="flex-1 p-4 space-y-4 overflow-y-auto [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                    
                    <!-- Section 1: Looking For & Basics -->
                    <div class="space-y-3 pb-3 border-b border-gray-100">
                        <p class="text-[11px] font-bold text-rani-primary uppercase tracking-wider">01. Looking For & Basics</p>
                        
                        <!-- Gender -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1.5">Looking For</label>
                            <div class="rani-gender-switch">
                                <button type="button" @click="filters.gender = 'all'; fetchResults()" :class="filters.gender === 'all' ? 'active' : ''" class="rani-gender-btn">All</button>
                                <button type="button" @click="filters.gender = 'Female'; fetchResults()" :class="filters.gender === 'Female' ? 'active' : ''" class="rani-gender-btn">Bride</button>
                                <button type="button" @click="filters.gender = 'Male'; fetchResults()" :class="filters.gender === 'Male' ? 'active' : ''" class="rani-gender-btn">Groom</button>
                            </div>
                        </div>

                        <!-- Profile Created For -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Profile Created By</label>
                            <select x-model="filters.profile_for" @change="fetchResults()" class="rani-filter-select">
                                <option value="all">All (Created By Anyone)</option>
                                @foreach($profileFors as $pf)
                                    <option value="{{ $pf }}">{{ $pf }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Age Min/Max -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Age Range</label>
                            <div class="grid grid-cols-2 gap-2">
                                <select x-model="filters.age_min" @change="fetchResults()" class="rani-filter-select">
                                    <option value="">Min Age (Any)</option>
                                    @for($a = 18; $a <= 65; $a++)
                                        <option value="{{ $a }}">{{ $a }} Yrs</option>
                                    @endfor
                                </select>
                                <select x-model="filters.age_max" @change="fetchResults()" class="rani-filter-select">
                                    <option value="">Max Age (Any)</option>
                                    @for($a = 18; $a <= 70; $a++)
                                        <option value="{{ $a }}">{{ $a }} Yrs</option>
                                    @endfor
                                </select>
                            </div>
                        </div>

                        <!-- Height Range -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Height Range</label>
                            <div class="grid grid-cols-2 gap-2">
                                <select x-model="filters.height_min" @change="fetchResults()" class="rani-filter-select">
                                    <option value="all">Min Height (Any)</option>
                                    @foreach($heights as $h)
                                        <option value="{{ $h->name }}">{{ $h->name }}</option>
                                    @endforeach
                                </select>
                                <select x-model="filters.height_max" @change="fetchResults()" class="rani-filter-select">
                                    <option value="all">Max Height (Any)</option>
                                    @foreach($heights as $h)
                                        <option value="{{ $h->name }}">{{ $h->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <!-- Marital Status -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Marital Status</label>
                            <select x-model="filters.marital_status" @change="fetchResults()" class="rani-filter-select">
                                <option value="all">All Marital Statuses</option>
                                @foreach($maritalStatuses as $ms)
                                    <option value="{{ $ms->name }}">{{ $ms->name }}</option>
                                @endforeach
                                <option value="Never Married">Never Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Widowed">Widowed</option>
                                <option value="Awaiting Divorce">Awaiting Divorce</option>
                                <option value="Annulled">Annulled</option>
                            </select>
                        </div>
                    </div>

                    <!-- Section 2: Religion, Community & Astro -->
                    <div class="space-y-3 pb-3 border-b border-gray-100">
                        <p class="text-[11px] font-bold text-amber-600 uppercase tracking-wider">02. Religion & Astro</p>

                        <!-- Religion -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Religion</label>
                            <select x-model="filters.religion" @change="onReligionChange()" class="rani-filter-select">
                                <option value="all">All Religions</option>
                                @foreach($religions as $r)
                                    <option value="{{ $r->name }}">{{ $r->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Community -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Community / Caste</label>
                            <select x-model="filters.community" @change="fetchResults()" class="rani-filter-select">
                                <option value="all">All Communities</option>
                                <template x-for="com in availableCommunities" :key="com.id || com.name">
                                    <option :value="com.name" x-text="com.name"></option>
                                </template>
                            </select>
                        </div>

                        <!-- Sub-Community -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Sub-Community / Clan</label>
                            <input type="text" x-model.debounce.400ms="filters.sub_community" @input="fetchResults()" placeholder="e.g. Kulin, Vaishnav..." class="rani-filter-input">
                        </div>

                        <!-- Mother Tongue -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Mother Tongue</label>
                            <select x-model="filters.mother_tongue" @change="fetchResults()" class="rani-filter-select">
                                <option value="all">All Mother Tongues</option>
                                @foreach($motherTongues as $mt)
                                    <option value="{{ $mt }}">{{ $mt }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Manglik Status -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Manglik Status</label>
                            <select x-model="filters.manglik" @change="fetchResults()" class="rani-filter-select">
                                <option value="all">All Manglik Statuses</option>
                                <option value="Non-Manglik">Non-Manglik</option>
                                <option value="Manglik">Manglik</option>
                                <option value="Anshik Manglik">Anshik Manglik</option>
                                <option value="Don't Know">Don't Know</option>
                            </select>
                        </div>

                        <!-- Gothra -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Gothra</label>
                            <input type="text" x-model.debounce.400ms="filters.gothra" @input="fetchResults()" placeholder="e.g. Kashyap, Shandilya..." class="rani-filter-input">
                        </div>
                    </div>

                    <!-- Section 3: Location Details -->
                    <div class="space-y-3 pb-3 border-b border-gray-100">
                        <p class="text-[11px] font-bold text-sky-600 uppercase tracking-wider">03. Location & Living</p>

                        <!-- Country -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Country</label>
                            <select x-model="filters.country" @change="onCountryChange()" class="rani-filter-select">
                                <option value="all">All Countries</option>
                                @foreach($countries as $c)
                                    <option value="{{ $c->name }}">{{ $c->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- State -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">State</label>
                            <select x-model="filters.state" @change="onStateChange()" class="rani-filter-select">
                                <option value="all">All States</option>
                                <template x-for="st in availableStates" :key="st.id || st.name">
                                    <option :value="st.name" x-text="st.name"></option>
                                </template>
                            </select>
                        </div>

                        <!-- City -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">City</label>
                            <select x-model="filters.city" @change="fetchResults()" class="rani-filter-select">
                                <option value="all">All Cities</option>
                                <template x-for="ct in availableCities" :key="ct.id || ct.name">
                                    <option :value="ct.name" x-text="ct.name"></option>
                                </template>
                            </select>
                        </div>

                        <!-- Residency Status -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Residency Status</label>
                            <select x-model="filters.residency_status" @change="fetchResults()" class="rani-filter-select">
                                <option value="all">All Residency Types</option>
                                @foreach($residencyStatuses as $rs)
                                    <option value="{{ $rs }}">{{ $rs }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Grew Up In -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Grew Up In (City / Region)</label>
                            <input type="text" x-model.debounce.400ms="filters.grew_up_in" @input="fetchResults()" placeholder="e.g. Kolkata, Mumbai..." class="rani-filter-input">
                        </div>
                    </div>

                    <!-- Section 4: Education, Profession & Income -->
                    <div class="space-y-3 pb-3 border-b border-gray-100">
                        <p class="text-[11px] font-bold text-emerald-600 uppercase tracking-wider">04. Education & Career</p>

                        <!-- Highest Qualification -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Education</label>
                            <select x-model="filters.highest_qualification" @change="fetchResults()" class="rani-filter-select">
                                <option value="all">All Education</option>
                                <option value="Doctorate">Doctorate / PhD</option>
                                <option value="Masters">Masters / Post Graduate</option>
                                <option value="Bachelors">Bachelors / Graduate</option>
                                <option value="Diploma">Diploma / Vocational</option>
                                <option value="High School">High School</option>
                                <option value="MBBS">MBBS / Medical</option>
                                <option value="B.Tech">B.Tech / B.E. / Engineering</option>
                                <option value="MBA">MBA / PGDM</option>
                                <option value="CA">CA / CS / Finance</option>
                            </select>
                        </div>

                        <!-- Working Sector -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Working Sector</label>
                            <select x-model="filters.working_with" @change="fetchResults()" class="rani-filter-select">
                                <option value="all">All Sectors</option>
                                @foreach($workingWiths as $ww)
                                    <option value="{{ $ww->name }}">{{ $ww->name }}</option>
                                @endforeach
                                <option value="Private Company">Private Company</option>
                                <option value="Government / Public Sector">Government / Public Sector</option>
                                <option value="Business / Self Employed">Business / Self Employed</option>
                                <option value="Defense / Civil Services">Defense / Civil Services</option>
                                <option value="Not Working">Not Working</option>
                            </select>
                        </div>

                        <!-- Profession / Role -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Profession / Role</label>
                            <input type="text" x-model.debounce.400ms="filters.profession" @input="fetchResults()" placeholder="e.g. Software Engineer, Doctor..." class="rani-filter-input">
                        </div>

                        <!-- Annual Income -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Annual Income</label>
                            <select x-model="filters.annual_income" @change="fetchResults()" class="rani-filter-select">
                                <option value="all">All Income Levels</option>
                                @foreach($incomes as $inc)
                                    <option value="{{ $inc->name }}">{{ $inc->name }}</option>
                                @endforeach
                                <option value="0-3">₹0 - 3 Lakh</option>
                                <option value="3-6">₹3 - 6 Lakh</option>
                                <option value="6-10">₹6 - 10 Lakh</option>
                                <option value="10-15">₹10 - 15 Lakh</option>
                                <option value="15-25">₹15 - 25 Lakh</option>
                                <option value="25-50">₹25 - 50 Lakh</option>
                                <option value="50">₹50 Lakh - 1 Crore</option>
                                <option value="100">₹1 Crore & above</option>
                            </select>
                        </div>
                    </div>

                    <!-- Section 5: Lifestyle, Health & Habits -->
                    <div class="space-y-3 pb-3 border-b border-gray-100">
                        <p class="text-[11px] font-bold text-rose-600 uppercase tracking-wider">05. Lifestyle & Health</p>

                        <!-- Diet -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Diet</label>
                            <select x-model="filters.diet" @change="fetchResults()" class="rani-filter-select">
                                <option value="all">All Diets</option>
                                @foreach($diets as $d)
                                    <option value="{{ $d->name }}">{{ $d->name }}</option>
                                @endforeach
                                <option value="Vegetarian">Vegetarian</option>
                                <option value="Non-Vegetarian">Non-Vegetarian</option>
                                <option value="Eggetarian">Eggetarian</option>
                                <option value="Jain">Jain</option>
                                <option value="Vegan">Vegan</option>
                            </select>
                        </div>

                        <!-- Blood Group -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Blood Group</label>
                            <select x-model="filters.blood_group" @change="fetchResults()" class="rani-filter-select">
                                <option value="all">All Blood Groups</option>
                                @foreach($bloodGroups as $bg)
                                    <option value="{{ $bg }}">{{ $bg }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Disability -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Disability / Special Needs</label>
                            <select x-model="filters.disability" @change="fetchResults()" class="rani-filter-select">
                                <option value="all">Doesn't Matter (All)</option>
                                <option value="None">None (Normal)</option>
                                <option value="Physically Challenged">Physically Challenged</option>
                            </select>
                        </div>

                        <!-- Hobbies & Interests -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Hobbies & Interests</label>
                            <select x-model="filters.hobbies_interests" @change="fetchResults()" class="rani-filter-select">
                                <option value="all">All Hobbies</option>
                                @foreach($hobbies as $hb)
                                    <option value="{{ $hb->name }}">{{ $hb->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Section 6: Family Details -->
                    <div class="space-y-3 pb-3 border-b border-gray-100">
                        <p class="text-[11px] font-bold text-purple-600 uppercase tracking-wider">06. Family Background</p>

                        <!-- Family Financial Status -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Family Financial Status</label>
                            <select x-model="filters.family_financial_status" @change="fetchResults()" class="rani-filter-select">
                                <option value="all">All Family Statuses</option>
                                @foreach($familyFinancialStatuses as $ffs)
                                    <option value="{{ $ffs }}">{{ $ffs }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Father's Profession -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Father's Profession</label>
                            <input type="text" x-model.debounce.400ms="filters.father_profession" @input="fetchResults()" placeholder="e.g. Business, Retired, Govt..." class="rani-filter-input">
                        </div>

                        <!-- Mother's Profession -->
                        <div>
                            <label class="text-[11px] font-semibold text-slate-600 block mb-1">Mother's Profession</label>
                            <input type="text" x-model.debounce.400ms="filters.mother_profession" @input="fetchResults()" placeholder="e.g. Homemaker, Teacher..." class="rani-filter-input">
                        </div>
                    </div>

                    <!-- Section 7: Verification Badges -->
                    <div class="space-y-2 pt-1">
                        <p class="text-[11px] font-bold text-blue-600 uppercase tracking-wider">07. Trust & Verification</p>

                        <label class="flex items-center justify-between p-2 rounded-xl bg-gray-50 border border-gray-100 cursor-pointer">
                            <span class="text-xs font-semibold text-gray-800">Photo Available Only</span>
                            <input type="checkbox" x-model="filters.has_photo" @change="fetchResults()" class="w-4 h-4 rounded text-rani-primary">
                        </label>

                        <label class="flex items-center justify-between p-2 rounded-xl bg-gray-50 border border-gray-100 cursor-pointer">
                            <span class="text-xs font-semibold text-gray-800">Blue Tick Verified Only</span>
                            <input type="checkbox" x-model="filters.verified_only" @change="fetchResults()" class="w-4 h-4 rounded text-rani-primary">
                        </label>
                    </div>

                </div>

                <!-- Drawer Footer -->
                <div class="p-4 bg-gray-50 border-t border-gray-100 flex items-center gap-2.5 shrink-0">
                    <button type="button" 
                            @click="resetAllFilters()" 
                            class="flex-1 py-3 rounded-2xl border border-gray-300 text-xs font-bold text-gray-700 hover:bg-gray-100 active:scale-95 cursor-pointer">
                        Reset All
                    </button>
                    <button type="button" 
                            @click="mobileFilterOpen = false" 
                            class="flex-1 py-3 rounded-2xl bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white text-xs font-bold shadow-md active:scale-95 border border-rani-gold/30 cursor-pointer">
                        View Matches (<span x-text="totalCount"></span>)
                    </button>
                </div>

            </div>
        </div>
    </template>

    <!-- ================= PHOTO GALLERY LIGHTBOX MODAL ================= -->
    <template x-teleport="body">
        <div x-show="photoGalleryOpen" 
             x-cloak
             style="display: none; position: fixed !important; top: 0 !important; left: 0 !important; right: 0 !important; bottom: 0 !important; width: 100vw !important; height: 100vh !important; z-index: 99999999 !important; background: radial-gradient(circle at center, rgba(65, 10, 10, 0.96) 0%, rgba(15, 3, 3, 0.99) 100%) !important; backdrop-filter: blur(16px);" 
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
            
            <!-- Top Bar -->
            <div class="w-full max-w-5xl flex items-center justify-between z-20 shrink-0 pb-2">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-2xl bg-gradient-to-br from-rani-gold via-yellow-400 to-amber-600 flex items-center justify-center text-rani-dark shadow-md">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                    </div>
                    <div>
                        <h4 class="font-serif font-bold text-white text-base sm:text-lg flex items-center gap-2">
                            <span x-text="activeGalleryMatch ? activeGalleryMatch.first_name + ' ' + activeGalleryMatch.last_name : 'Profile Photos'"></span>
                            <span class="text-xs font-mono font-normal text-rani-gold" x-text="activeGalleryMatch ? '(' + activeGalleryMatch.id + ')' : ''"></span>
                        </h4>
                        <p class="text-xs text-amber-200/80">Rani Matrimonial Verified Photo Gallery</p>
                    </div>
                </div>

                <button type="button" 
                        @click="closePhotoGallery()" 
                        class="w-10 h-10 rounded-full bg-white/10 hover:bg-white/20 text-white flex items-center justify-center border border-white/20 transition-all hover:scale-110 active:scale-95 shadow-lg cursor-pointer">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <!-- Central Image Stage -->
            <div class="relative flex-1 w-full max-w-4xl flex items-center justify-center my-auto min-h-0 py-2">
                <template x-if="activeGalleryPhotos && activeGalleryPhotos.length > 0">
                    <img :src="activeGalleryPhotos[activePhotoIndex]" 
                         class="max-h-[68vh] sm:max-h-[72vh] max-w-full object-contain rounded-2xl shadow-2xl border border-rani-gold/30 ring-4 ring-black/40">
                </template>

                <!-- Left Arrow -->
                <button type="button" 
                        x-show="activeGalleryPhotos && activeGalleryPhotos.length > 1"
                        @click="prevPhoto()" 
                        class="absolute left-2 sm:left-4 top-1/2 -translate-y-1/2 w-11 h-11 sm:w-14 sm:h-14 rounded-full bg-black/60 hover:bg-rani-primary text-white border border-rani-gold/40 flex items-center justify-center transition-all hover:scale-110 active:scale-95 shadow-2xl cursor-pointer">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
                </button>

                <!-- Right Arrow -->
                <button type="button" 
                        x-show="activeGalleryPhotos && activeGalleryPhotos.length > 1"
                        @click="nextPhoto()" 
                        class="absolute right-2 sm:right-4 top-1/2 -translate-y-1/2 w-11 h-11 sm:w-14 sm:h-14 rounded-full bg-black/60 hover:bg-rani-primary text-white border border-rani-gold/40 flex items-center justify-center transition-all hover:scale-110 active:scale-95 shadow-2xl cursor-pointer">
                    <svg class="w-6 h-6 sm:w-8 sm:h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
                </button>
            </div>

            <!-- Bottom Thumbnail Strip & Counter -->
            <div class="w-full max-w-3xl shrink-0 pt-2 flex flex-col items-center gap-2">
                <span class="px-3.5 py-0.5 rounded-full bg-black/70 text-rani-gold text-xs font-bold border border-rani-gold/30"
                      x-text="'Photo ' + (activePhotoIndex + 1) + ' of ' + (activeGalleryPhotos ? activeGalleryPhotos.length : 1)"></span>
                
                <div class="flex items-center gap-2 overflow-x-auto max-w-full p-1.5 [&::-webkit-scrollbar]:hidden [-ms-overflow-style:none] [scrollbar-width:none]">
                    <template x-for="(pUrl, idx) in activeGalleryPhotos" :key="idx">
                        <button type="button" 
                                @click="activePhotoIndex = idx"
                                class="w-12 h-12 sm:w-14 sm:h-14 rounded-2xl overflow-hidden border-2 transition-all shrink-0 cursor-pointer"
                                :class="activePhotoIndex === idx ? 'border-rani-gold scale-110 shadow-lg ring-2 ring-white' : 'border-white/30 opacity-60 hover:opacity-100'">
                            <img :src="pUrl" class="w-full h-full object-cover">
                        </button>
                    </template>
                </div>
            </div>

        </div>
    </template>

</div>

<script>
window.searchManager = function() {
    return {
        masterData: {
            religions: @json($religions ?? []),
            countries: @json($countries ?? []),
            maritalStatuses: @json($maritalStatuses ?? []),
            heights: @json($heights ?? []),
            diets: @json($diets ?? []),
            incomes: @json($incomes ?? []),
            workingWiths: @json($workingWiths ?? []),
            hobbies: @json($hobbies ?? [])
        },

        filters: {
            keyword: '',
            gender: '{{ $defaultGender ?? "all" }}',
            profile_for: 'all',
            age_min: '',
            age_max: '',
            height_min: 'all',
            height_max: 'all',
            marital_status: 'all',
            religion: 'all',
            community: 'all',
            sub_community: '',
            mother_tongue: 'all',
            gothra: '',
            country: 'all',
            state: 'all',
            city: 'all',
            residency_status: 'all',
            grew_up_in: '',
            highest_qualification: 'all',
            working_with: 'all',
            profession: '',
            annual_income: 'all',
            diet: 'all',
            blood_group: 'all',
            disability: 'all',
            hobbies_interests: 'all',
            family_financial_status: 'all',
            father_profession: '',
            mother_profession: '',
            manglik: 'all',
            has_photo: false,
            verified_only: false,
            sort_by: 'latest'
        },

        candidates: [],
        totalCount: 0,
        isLoading: false,
        mobileFilterOpen: false,

        // Photo Gallery Lightbox State
        photoGalleryOpen: false,
        activeGalleryMatch: null,
        activeGalleryPhotos: [],
        activePhotoIndex: 0,

        initSearch() {
            this.fetchResults();
        },

        get activeFilterCount() {
            let count = 0;
            if (this.filters.keyword) count++;
            if (this.filters.gender !== 'all') count++;
            if (this.filters.profile_for !== 'all') count++;
            if (this.filters.age_min) count++;
            if (this.filters.age_max) count++;
            if (this.filters.height_min !== 'all') count++;
            if (this.filters.height_max !== 'all') count++;
            if (this.filters.marital_status !== 'all') count++;
            if (this.filters.religion !== 'all') count++;
            if (this.filters.community !== 'all') count++;
            if (this.filters.sub_community) count++;
            if (this.filters.mother_tongue !== 'all') count++;
            if (this.filters.gothra) count++;
            if (this.filters.country !== 'all') count++;
            if (this.filters.state !== 'all') count++;
            if (this.filters.city !== 'all') count++;
            if (this.filters.residency_status !== 'all') count++;
            if (this.filters.grew_up_in) count++;
            if (this.filters.highest_qualification !== 'all') count++;
            if (this.filters.working_with !== 'all') count++;
            if (this.filters.profession) count++;
            if (this.filters.annual_income !== 'all') count++;
            if (this.filters.diet !== 'all') count++;
            if (this.filters.blood_group !== 'all') count++;
            if (this.filters.disability !== 'all') count++;
            if (this.filters.hobbies_interests !== 'all') count++;
            if (this.filters.family_financial_status !== 'all') count++;
            if (this.filters.father_profession) count++;
            if (this.filters.mother_profession) count++;
            if (this.filters.manglik !== 'all') count++;
            if (this.filters.has_photo) count++;
            if (this.filters.verified_only) count++;
            return count;
        },

        get availableCommunities() {
            if (!this.filters.religion || this.filters.religion === 'all') {
                let allComms = [];
                this.masterData.religions.forEach(r => {
                    if (r.communities) allComms.push(...r.communities);
                });
                return allComms;
            }
            const rel = this.masterData.religions.find(r => r.name === this.filters.religion);
            return rel && rel.communities ? rel.communities : [];
        },

        get availableStates() {
            if (!this.filters.country || this.filters.country === 'all') {
                const india = this.masterData.countries.find(c => c.name === 'India');
                return india && india.states ? india.states : [];
            }
            const c = this.masterData.countries.find(item => item.name === this.filters.country);
            return c && c.states ? c.states : [];
        },

        get availableCities() {
            if (!this.filters.state || this.filters.state === 'all') return [];
            const states = this.availableStates;
            const st = states.find(s => s.name === this.filters.state);
            return st && st.cities ? st.cities : [];
        },

        onReligionChange() {
            this.filters.community = 'all';
            this.fetchResults();
        },

        onCountryChange() {
            this.filters.state = 'all';
            this.filters.city = 'all';
            this.fetchResults();
        },

        onStateChange() {
            this.filters.city = 'all';
            this.fetchResults();
        },

        resetAllFilters() {
            this.filters = {
                keyword: '',
                gender: 'all',
                profile_for: 'all',
                age_min: '',
                age_max: '',
                height_min: 'all',
                height_max: 'all',
                marital_status: 'all',
                religion: 'all',
                community: 'all',
                sub_community: '',
                mother_tongue: 'all',
                gothra: '',
                country: 'all',
                state: 'all',
                city: 'all',
                residency_status: 'all',
                grew_up_in: '',
                highest_qualification: 'all',
                working_with: 'all',
                profession: '',
                annual_income: 'all',
                diet: 'all',
                blood_group: 'all',
                disability: 'all',
                hobbies_interests: 'all',
                family_financial_status: 'all',
                father_profession: '',
                mother_profession: '',
                manglik: 'all',
                has_photo: false,
                verified_only: false,
                sort_by: 'latest'
            };
            this.fetchResults();
        },

        async fetchResults() {
            this.isLoading = true;

            try {
                const response = await fetch('{{ route("search.filter") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(this.filters)
                });

                const data = await response.json();
                if (data.success) {
                    this.candidates = data.candidates || [];
                    this.totalCount = data.count || 0;
                }
            } catch (err) {
                console.error('Search Filter Error:', err);
            } finally {
                this.isLoading = false;
            }
        },

        async toggleShortlist(match) {
            if (!match) return;
            const isCurrentlyShortlisted = match.is_shortlisted;

            // Optimistic UI update
            match.is_shortlisted = !isCurrentlyShortlisted;

            try {
                const res = await fetch('{{ route("matches.shortlist") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        profile_id: match.id
                    })
                });

                const data = await res.json();

                if (data.success) {
                    match.is_shortlisted = data.shortlisted !== undefined ? data.shortlisted : (data.is_shortlisted !== undefined ? data.is_shortlisted : !isCurrentlyShortlisted);
                    Swal.fire({
                        icon: match.is_shortlisted ? 'success' : 'info',
                        title: match.is_shortlisted ? 'Shortlisted!' : 'Removed',
                        text: data.message || (match.is_shortlisted ? 'Profile added to your shortlist.' : 'Profile removed from your shortlist.'),
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 2000,
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title' }
                    });
                } else {
                    // Revert if failed
                    match.is_shortlisted = isCurrentlyShortlisted;
                }
            } catch (e) {
                match.is_shortlisted = isCurrentlyShortlisted;
                console.error('Shortlist error:', e);
            }
        },

        async sendInterest(match) {
            if (!match) return;
            if (match.request_type === 'sent') return;

            try {
                const res = await fetch('{{ route("matches.send-interest") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]') ? document.querySelector('meta[name="csrf-token"]').content : '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        profile_id: match.id
                    })
                });

                const data = await res.json();

                if (data.success) {
                    match.is_interest_sent = true;
                    match.request_type = 'sent';

                    const fullName = (match.first_name || '') + (match.last_name ? ' ' + match.last_name : '');

                    Swal.fire({
                        icon: 'success',
                        title: 'Connection Request Sent!',
                        html: '<p class="text-sm text-gray-200">Your connection request was dispatched to <strong>' + (fullName || 'Candidate') + '</strong>.<br><span class="text-xs text-gray-400 mt-1 block">A WhatsApp notification with your name and profile summary has been delivered.</span></p>',
                        confirmButtonText: 'Great',
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    });
                } else if (data.insufficient_balance || data.redirect_wallet) {
                    Swal.fire({
                        icon: 'warning',
                        title: data.title || 'Insufficient Wallet Balance',
                        html: '<div class="text-left bg-black/40 border border-amber-500/30 rounded-xl p-3.5 mt-2">' +
                              '<p class="text-sm text-amber-200 leading-relaxed font-medium">' + (data.message || 'Please recharge your wallet to send connection requests.') + '</p>' +
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
            } catch (err) {
                console.error('Send Interest error:', err);
            }
        },

        openPhotoGallery(match, initialIdx = 0) {
            this.activeGalleryMatch = match;
            this.activeGalleryPhotos = match.photos && match.photos.length > 0 ? match.photos : [match.photo];
            this.activePhotoIndex = initialIdx;
            this.photoGalleryOpen = true;
        },

        closePhotoGallery() {
            this.photoGalleryOpen = false;
        },

        prevPhoto() {
            if (!this.activeGalleryPhotos || this.activeGalleryPhotos.length <= 1) return;
            this.activePhotoIndex = (this.activePhotoIndex - 1 + this.activeGalleryPhotos.length) % this.activeGalleryPhotos.length;
        },

        nextPhoto() {
            if (!this.activeGalleryPhotos || this.activeGalleryPhotos.length <= 1) return;
            this.activePhotoIndex = (this.activePhotoIndex + 1) % this.activeGalleryPhotos.length;
        }
    };
};

if (window.Alpine) {
    Alpine.data('searchManager', window.searchManager);
} else {
    document.addEventListener('alpine:init', () => {
        Alpine.data('searchManager', window.searchManager);
    });
}
</script>
@endsection
