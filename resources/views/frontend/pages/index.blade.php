@extends('frontend.layouts.app')

@section('title', 'Rani Matrimonial - Find Your Perfect Match')

@section('content')

<!-- Hero Section -->
<section class="relative min-h-[100svh] flex flex-col justify-start md:justify-end overflow-x-hidden overflow-y-auto pt-28 md:pt-32 pb-16 md:pb-24">
    <!-- Background Image -->
    <div class="absolute inset-0 z-0 bg-cover bg-top bg-no-repeat" style="background-image: url('{{ asset('img/hero.png') }}');"></div>
    
    <!-- Maroon/Gold Gradient Overlay (Reduced Opacity) -->
    <div class="absolute inset-0 z-0 bg-gradient-to-t from-rani-dark/80 via-rani-primary-dark/20 to-transparent"></div>

    <!-- Floating Sweet Gestures (Hearts) -->
    <div class="heart-container">
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

    <!-- Decorative Royal Borders & Accents -->
    <div class="absolute inset-4 md:inset-8 border-2 border-rani-gold/30 rounded-3xl pointer-events-none z-0"></div>
    
    <!-- Content -->
    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4 md:mt-auto">
        <div class="text-center space-y-4 mb-8 md:mb-10">
            <h1 class="text-3xl sm:text-4xl md:text-6xl font-serif font-bold text-white leading-tight var(--animate-fade-in-up) tracking-wide drop-shadow-lg">
                Choose Your <span class="text-rani-gold">Forever</span>
            </h1>
            <p class="text-base sm:text-lg md:text-xl text-gray-200 font-light var(--animate-fade-in-up) drop-shadow-md" style="animation-delay: 0.2s;">
                Find love on your terms with millions of verified profiles
            </p>
        </div>

        <!-- Horizontal Search Widget (Shaadi Style) -->
        <div class="w-full bg-black/60 backdrop-blur-md p-4 sm:p-6 rounded-xl border border-white/10 shadow-2xl var(--animate-fade-in-up)" style="animation-delay: 0.4s;">
            <form action="#" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:flex lg:flex-row items-end gap-4 lg:gap-3 justify-center">
                
                <!-- Looking for -->
                <div class="w-full lg:w-48 text-left">
                    <label class="block text-xs font-semibold text-white mb-1 tracking-wide">I'm looking for a</label>
                    <div class="relative">
                        <select class="w-full rounded bg-white text-gray-800 py-2.5 px-3 text-sm outline-none focus:ring-2 focus:ring-rani-gold appearance-none cursor-pointer">
                            <option>Woman</option>
                            <option>Man</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Aged -->
                <div class="w-full lg:w-auto text-left flex items-end gap-3 sm:col-span-2 lg:col-span-1">
                    <div class="flex-1 lg:w-24">
                        <label class="block text-xs font-semibold text-white mb-1 tracking-wide">aged</label>
                        <div class="relative">
                            <select class="w-full rounded bg-white text-gray-800 py-2.5 px-3 text-sm outline-none focus:ring-2 focus:ring-rani-gold appearance-none cursor-pointer">
                                <option>20</option>
                                <option>21</option>
                                <option>22</option>
                                <option selected>25</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                    <span class="text-white text-sm pb-2.5 font-medium">to</span>
                    <div class="flex-1 lg:w-24">
                        <label class="block text-xs font-semibold text-white mb-1 tracking-wide">&nbsp;</label>
                        <div class="relative">
                            <select class="w-full rounded bg-white text-gray-800 py-2.5 px-3 text-sm outline-none focus:ring-2 focus:ring-rani-gold appearance-none cursor-pointer">
                                <option selected>30</option>
                                <option>35</option>
                                <option>40</option>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Religion -->
                <div class="w-full lg:w-48 text-left">
                    <label class="block text-xs font-semibold text-white mb-1 tracking-wide">of religion</label>
                    <div class="relative">
                        <select class="w-full rounded bg-white text-gray-800 py-2.5 px-3 text-sm outline-none focus:ring-2 focus:ring-rani-gold appearance-none cursor-pointer">
                            <option>Select</option>
                            <option>Hindu</option>
                            <option>Muslim</option>
                            <option>Christian</option>
                            <option>Sikh</option>
                            <option>Jain</option>
                            <option>Buddhist</option>
                            <option>Parsi</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Mother Tongue -->
                <div class="w-full lg:w-48 text-left">
                    <label class="block text-xs font-semibold text-white mb-1 tracking-wide">and mother tongue</label>
                    <div class="relative">
                        <select class="w-full rounded bg-white text-gray-800 py-2.5 px-3 text-sm outline-none focus:ring-2 focus:ring-rani-gold appearance-none cursor-pointer">
                            <option>Select</option>
                            <option>Hindi</option>
                            <option>Bengali</option>
                            <option>Marathi</option>
                            <option>Telugu</option>
                            <option>Tamil</option>
                            <option>Gujarati</option>
                            <option>Urdu</option>
                            <option>Kannada</option>
                            <option>Odia</option>
                            <option>Malayalam</option>
                        </select>
                        <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-500">
                            <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                        </div>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="w-full sm:col-span-2 lg:col-span-1 lg:w-40 mt-2 lg:mt-0">
                    <a href="{{ route('register.page') }}" class="block text-center w-full bg-rani-gold hover:bg-[#c59b27] text-rani-primary-dark font-bold text-sm py-2.5 px-4 rounded shadow-lg transition-colors">
                        Let's Begin
                    </a>
                </div>
            </form>
        </div>
    </div>
</section>

<!-- Features / How it works -->
<section class="py-24 bg-rani-light relative">
    <!-- Top ornamental divider -->
    <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-rani-primary-dark via-rani-gold to-rani-primary-dark"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl md:text-5xl font-serif font-bold text-rani-primary-dark mb-4">Your Journey to Happiness</h2>
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="h-[1px] w-12 bg-rani-gold"></div>
                <div class="w-2 h-2 rounded-full bg-rani-gold"></div>
                <div class="h-[1px] w-12 bg-rani-gold"></div>
            </div>
            <p class="text-gray-600 max-w-2xl mx-auto font-light text-lg">We've made finding your soulmate a beautiful, respectful, and effortless experience.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-12">
            <!-- Step 1 -->
            <div class="text-center group">
                <div class="w-24 h-24 mx-auto bg-white rounded-full flex items-center justify-center mb-6 relative group-hover:scale-110 transition-transform duration-500 shadow-lg border-2 border-rani-gold/40 group-hover:border-rani-gold group-hover:shadow-rani-gold/30">
                    <svg class="w-10 h-10 text-rani-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <h3 class="text-2xl font-serif font-bold text-rani-primary-dark mb-3">Create a Profile</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Sign up and tell us about yourself. Share your values, traditions, and what you seek in a partner.</p>
            </div>

            <!-- Step 2 -->
            <div class="text-center group">
                <div class="w-24 h-24 mx-auto bg-white rounded-full flex items-center justify-center mb-6 relative group-hover:scale-110 transition-transform duration-500 shadow-lg border-2 border-rani-gold/40 group-hover:border-rani-gold group-hover:shadow-rani-gold/30">
                    <svg class="w-10 h-10 text-rani-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                </div>
                <h3 class="text-2xl font-serif font-bold text-rani-primary-dark mb-3">Search & Connect</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Explore thousands of verified profiles across India. Filter by community, education, and profession.</p>
            </div>

            <!-- Step 3 -->
            <div class="text-center group">
                <div class="w-24 h-24 mx-auto bg-white rounded-full flex items-center justify-center mb-6 relative group-hover:scale-110 transition-transform duration-500 shadow-lg border-2 border-rani-gold/40 group-hover:border-rani-gold group-hover:shadow-rani-gold/30">
                    <svg class="w-10 h-10 text-rani-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </div>
                <h3 class="text-2xl font-serif font-bold text-rani-primary-dark mb-3">Start Your Story</h3>
                <p class="text-gray-600 text-sm leading-relaxed">Interact securely and take the first step towards a beautiful lifelong commitment.</p>
            </div>
        </div>
    </div>
</section>

<!-- Success Stories Showcase Section (Carousel) -->
@if(isset($stories) && $stories->count() > 0)
<section class="py-24 bg-white relative overflow-hidden" x-data="{
    storyModalOpen: false,
    selectedStory: null,
    activePhotoIdx: 0,
    currentIndex: 0,
    totalItems: {{ $stories->count() }},
    itemsPerView: 3,
    autoplayInterval: null,
    isHovered: false,
    touchStartX: 0,
    touchEndX: 0,

    init() {
        this.updateItemsPerView();
        window.addEventListener('resize', () => this.updateItemsPerView());
        this.startAutoplay();
    },

    updateItemsPerView() {
        if (window.innerWidth < 640) {
            this.itemsPerView = 1;
        } else if (window.innerWidth < 1024) {
            this.itemsPerView = 2;
        } else {
            this.itemsPerView = 3;
        }
        if (this.currentIndex > this.maxIndex()) {
            this.currentIndex = this.maxIndex();
        }
    },

    maxIndex() {
        return Math.max(0, this.totalItems - this.itemsPerView);
    },

    totalPages() {
        return this.maxIndex() + 1;
    },

    next() {
        if (this.currentIndex >= this.maxIndex()) {
            this.currentIndex = 0;
        } else {
            this.currentIndex++;
        }
    },

    prev() {
        if (this.currentIndex <= 0) {
            this.currentIndex = this.maxIndex();
        } else {
            this.currentIndex--;
        }
    },

    goTo(idx) {
        this.currentIndex = Math.min(Math.max(0, idx), this.maxIndex());
    },

    startAutoplay() {
        this.stopAutoplay();
        this.autoplayInterval = setInterval(() => {
            if (!this.storyModalOpen && !this.isHovered && this.totalItems > this.itemsPerView) {
                this.next();
            }
        }, 5000);
    },

    stopAutoplay() {
        if (this.autoplayInterval) {
            clearInterval(this.autoplayInterval);
            this.autoplayInterval = null;
        }
    },

    openStory(story) {
        this.selectedStory = story;
        this.activePhotoIdx = 0;
        this.storyModalOpen = true;
        document.body.style.overflow = 'hidden';
    },

    closeStory() {
        this.storyModalOpen = false;
        document.body.style.overflow = 'auto';
    }
}">
    <!-- Decorative background elements -->
    <div class="absolute top-0 right-0 w-96 h-96 bg-rani-gold/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-0 left-0 w-96 h-96 bg-rani-primary/5 rounded-full blur-3xl pointer-events-none"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        
        <!-- Section Header -->
        <div class="text-center mb-12 sm:mb-16">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-rani-primary/10 border border-rani-gold/40 text-rani-primary font-bold text-xs uppercase tracking-widest mb-3 shadow-xs">
                <i class="bi bi-stars text-rani-gold"></i>
                Real Matches, Forever Bond
            </div>
            <h2 class="text-3xl md:text-5xl font-serif font-bold text-rani-primary-dark mb-3">Matrimonial Success Stories</h2>
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="h-[1px] w-12 bg-rani-gold"></div>
                <div class="w-2 h-2 rounded-full bg-rani-gold"></div>
                <div class="h-[1px] w-12 bg-rani-gold"></div>
            </div>
            <p class="text-gray-600 max-w-2xl mx-auto font-light text-base md:text-lg">
                Be inspired by the beautiful journeys of couples who met through Rani Matrimonial and stepped into their happily ever after.
            </p>
        </div>

        <!-- Stories Carousel Container -->
        <div class="relative" 
             @mouseenter="isHovered = true" 
             @mouseleave="isHovered = false"
             @touchstart="touchStartX = $event.changedTouches[0].screenX"
             @touchend="touchEndX = $event.changedTouches[0].screenX; if (touchStartX - touchEndX > 45) next(); if (touchEndX - touchStartX > 45) prev();">
            
            <!-- Left Navigation Arrow Button -->
            <button type="button" 
                    @click="prev()" 
                    x-show="totalItems > itemsPerView"
                    class="absolute -left-2 sm:-left-5 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white/95 hover:bg-white text-rani-primary shadow-xl border-2 border-rani-gold/40 flex items-center justify-center hover:scale-110 active:scale-95 transition-all group cursor-pointer"
                    title="Previous Story">
                <svg class="w-5 h-5 text-rani-primary group-hover:-translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"></path></svg>
            </button>

            <!-- Right Navigation Arrow Button -->
            <button type="button" 
                    @click="next()" 
                    x-show="totalItems > itemsPerView"
                    class="absolute -right-2 sm:-right-5 top-1/2 -translate-y-1/2 z-20 w-10 h-10 sm:w-12 sm:h-12 rounded-full bg-white/95 hover:bg-white text-rani-primary shadow-xl border-2 border-rani-gold/40 flex items-center justify-center hover:scale-110 active:scale-95 transition-all group cursor-pointer"
                    title="Next Story">
                <svg class="w-5 h-5 text-rani-primary group-hover:translate-x-0.5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"></path></svg>
            </button>

            <!-- Carousel Track Viewport -->
            <div class="overflow-hidden py-3 -mx-3 px-3">
                <div class="flex transition-transform duration-500 ease-out"
                     :style="`transform: translateX(-${currentIndex * (100 / itemsPerView)}%);`">
                    @foreach($stories as $story)
                        @php
                            $storyPayload = [
                                'id' => $story->id,
                                'title' => $story->title,
                                'couple_names' => $story->couple_names,
                                'wedding_date' => $story->formatted_wedding_date,
                                'image_url' => $story->image_url,
                                'gallery_images' => $story->gallery_images,
                                'descriptions' => $story->descriptions,
                            ];
                        @endphp
                        <div class="w-full sm:w-1/2 lg:w-1/3 shrink-0 px-3 flex">
                            <div class="bg-rani-light/40 rounded-3xl overflow-hidden shadow-lg hover:shadow-2xl border border-rani-gold/30 flex flex-col justify-between group hover:-translate-y-1.5 transition-all duration-500 w-full">
                                
                                <div>
                                    <!-- Cover Image Box -->
                                    <div class="relative h-60 sm:h-68 w-full overflow-hidden bg-black/60 cursor-pointer select-none"
                                         @click="openStory(@js($storyPayload))">
                                        <img src="{{ $story->image_url }}" alt="{{ $story->title }}" class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105">
                                        
                                        <!-- Gradient Overlay -->
                                        <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/20 to-transparent pointer-events-none"></div>

                                        <!-- Top Badges -->
                                        @if($story->couple_names)
                                            <div class="absolute top-3 left-3 z-10">
                                                <span class="px-3 py-1 rounded-full bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white text-xs font-bold shadow-md border border-rani-gold/40 flex items-center gap-1.5">
                                                    <svg class="w-3.5 h-3.5 text-rani-gold fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                                                    <span>{{ $story->couple_names }}</span>
                                                </span>
                                            </div>
                                        @endif

                                        <div class="absolute top-3 right-3 z-10">
                                            <span class="px-2.5 py-1 rounded-full bg-black/60 backdrop-blur-sm text-rani-gold text-[11px] font-semibold flex items-center gap-1 border border-white/20">
                                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                                <span>{{ count($story->gallery_images) }} Photos</span>
                                            </span>
                                        </div>

                                        <!-- Bottom Title in Box -->
                                        <div class="absolute bottom-3 left-4 right-4 text-white z-10">
                                            @if($story->formatted_wedding_date)
                                                <p class="text-xs text-rani-gold font-serif italic mb-0.5">💍 Married on {{ $story->formatted_wedding_date }}</p>
                                            @endif
                                            <h3 class="text-lg font-serif font-bold text-white drop-shadow-md truncate">{{ $story->title }}</h3>
                                        </div>
                                    </div>

                                    <!-- Excerpt Content -->
                                    <div class="p-5 sm:p-6">
                                        <p class="text-gray-600 text-sm leading-relaxed line-clamp-3 font-light mb-4">
                                            {{ Str::limit(strip_tags($story->descriptions), 130) }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Action Button -->
                                <div class="px-5 sm:px-6 pb-6 pt-0">
                                    <button type="button" 
                                            @click="openStory(@js($storyPayload))" 
                                            class="w-full py-2.5 px-4 rounded-xl bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white font-serif font-bold text-xs shadow-md transition-all flex items-center justify-center gap-2 group/btn border border-rani-gold/30">
                                        <span>Read Story</span>
                                        <svg class="w-3.5 h-3.5 text-rani-gold group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                                    </button>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Carousel Pagination Indicators -->
            <div class="flex items-center justify-center gap-2 mt-4 mb-10" x-show="totalItems > itemsPerView">
                <template x-for="pIndex in totalPages()" :key="pIndex">
                    <button type="button" 
                            @click="goTo(pIndex - 1)" 
                            class="h-2.5 rounded-full transition-all duration-300 cursor-pointer"
                            :class="currentIndex === (pIndex - 1) ? 'w-8 bg-gradient-to-r from-rani-gold to-yellow-500 shadow-sm' : 'w-2.5 bg-rani-primary/20 hover:bg-rani-primary/40'"
                            :title="'Go to slide ' + pIndex">
                    </button>
                </template>
            </div>

        </div>

        <!-- View All Stories CTA -->
        <div class="text-center mt-2">
            <a href="{{ route('stories') }}" class="inline-flex items-center gap-2 px-8 py-3.5 rounded-full border-2 border-rani-primary text-rani-primary-dark font-serif font-bold text-sm hover:bg-rani-primary hover:text-white transition-all shadow-sm hover:shadow-lg">
                <span>View All Success Stories</span>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
            </a>
        </div>

    </div>

    <!-- ================= FULL STORY READING MODAL ================= -->
    <template x-teleport="body">
        <div x-show="storyModalOpen" 
             x-cloak
             style="display: none; position: fixed !important; inset: 0 !important; width: 100vw !important; height: 100vh !important; z-index: 99999999 !important; background-color: rgba(15, 0, 0, 0.88) !important; backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);" 
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="flex items-center justify-center p-2.5 sm:p-5 md:p-6 overflow-y-auto">
            
            <div @click.away="closeStory()"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 style="position: relative !important; z-index: 100000000 !important; background-color: #ffffff !important;"
                 class="bg-white rounded-2xl sm:rounded-3xl shadow-[0_25px_70px_rgba(0,0,0,0.85)] border-2 border-rani-gold max-w-2xl lg:max-w-3xl w-full max-h-[92dvh] sm:max-h-[88vh] overflow-hidden flex flex-col my-auto text-gray-800">
                
                <!-- Gold Accent Top Bar -->
                <div class="h-1.5 sm:h-2 w-full bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold shrink-0"></div>

                <!-- Modal Header -->
                <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-rani-dark via-rani-primary-dark to-rani-primary text-white flex items-start justify-between gap-3 shrink-0 border-b border-rani-gold/30">
                    <div class="flex-1 min-w-0 pr-1">
                        <div class="flex flex-wrap items-center gap-2 mb-1">
                            <span class="inline-flex items-center gap-1 px-2.5 py-0.5 rounded-full bg-rani-gold/20 border border-rani-gold/40 text-[10px] font-bold text-rani-gold uppercase tracking-wider">
                                <svg class="w-3 h-3 text-rani-gold fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg>
                                Verified Story
                            </span>
                            <span class="text-xs text-amber-200/90 font-serif italic truncate" x-show="selectedStory && selectedStory.couple_names" x-text="selectedStory ? '• ' + selectedStory.couple_names : ''"></span>
                        </div>
                        <h3 class="font-serif font-bold text-base sm:text-xl text-white tracking-wide leading-snug line-clamp-2" x-text="selectedStory ? selectedStory.title : 'Success Story'"></h3>
                    </div>

                    <button type="button" 
                            @click="closeStory()" 
                            class="w-8 h-8 sm:w-9 sm:h-9 rounded-full bg-white/10 hover:bg-rose-600 text-white flex items-center justify-center shrink-0 transition-all hover:scale-110 active:scale-95 border border-white/20 mt-0.5"
                            title="Close">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

                <!-- Modal Body Scrollable -->
                <div class="p-4 sm:p-6 overflow-y-auto overscroll-contain flex-1 min-h-0 space-y-4 sm:space-y-5 text-gray-800 bg-[#faf8f5]">
                    
                    <!-- Main High-Res Photo Showcase -->
                    <div class="rounded-xl sm:rounded-2xl overflow-hidden border border-rani-gold/40 shadow-md bg-black/80 relative h-48 sm:h-64 md:h-80 w-full shrink-0">
                        <img :src="selectedStory && selectedStory.gallery_images ? (selectedStory.gallery_images[activePhotoIdx] || selectedStory.image_url) : ''" 
                             class="w-full h-full object-cover object-center">
                        
                        <div class="absolute bottom-2.5 left-2.5 sm:bottom-3 sm:left-3 bg-black/75 backdrop-blur-sm px-2.5 sm:px-3 py-1 rounded-full text-white text-[11px] sm:text-xs font-serif italic border border-white/20 flex items-center gap-1.5" x-show="selectedStory && selectedStory.wedding_date">
                            <span>💍</span>
                            <span x-text="'Married on ' + (selectedStory ? selectedStory.wedding_date : '')"></span>
                        </div>
                    </div>

                    <!-- Multiple Photos Thumbnails Strip -->
                    <div class="flex gap-2 overflow-x-auto py-1" x-show="selectedStory && selectedStory.gallery_images && selectedStory.gallery_images.length > 1">
                        <template x-for="(gPhoto, pIndex) in (selectedStory ? selectedStory.gallery_images : [])" :key="pIndex">
                            <button type="button" 
                                    @click="activePhotoIdx = pIndex"
                                    class="w-12 h-12 sm:w-14 sm:h-14 rounded-lg sm:rounded-xl overflow-hidden border-2 transition-all shrink-0 cursor-pointer"
                                    :class="activePhotoIdx === pIndex ? 'border-rani-gold ring-2 ring-rani-gold/60 scale-105 shadow-md' : 'border-gray-200 opacity-60 hover:opacity-100'">
                                <img :src="gPhoto" class="w-full h-full object-cover">
                            </button>
                        </template>
                    </div>

                    <!-- Detailed Story Narrative -->
                    <div class="bg-white p-4 sm:p-6 rounded-xl sm:rounded-2xl border border-gray-200 shadow-xs space-y-2.5 sm:space-y-3">
                        <div class="flex items-center gap-2 border-b border-gray-100 pb-2">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-rani-primary shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                            <h4 class="font-serif font-bold text-sm sm:text-base text-rani-primary-dark">How We Met & Our Journey</h4>
                        </div>
                        <div class="text-gray-700 text-xs sm:text-sm leading-relaxed font-sans" style="white-space: pre-line;" x-text="selectedStory ? selectedStory.descriptions : ''"></div>
                    </div>

                    <!-- Inspiring CTA Box inside Modal -->
                    <div class="p-3.5 sm:p-4 rounded-xl sm:rounded-2xl bg-gradient-to-r from-rani-primary/10 via-amber-50 to-rani-primary/10 border border-rani-gold/40 text-center space-y-1.5 sm:space-y-2">
                        <h5 class="font-serif font-bold text-rani-primary-dark text-xs sm:text-sm">Ready to find your own life partner?</h5>
                        <p class="text-[11px] sm:text-xs text-gray-600 max-w-md mx-auto font-light">Join thousands of verified profiles on Rani Matrimonial today.</p>
                        <a href="{{ route('register.page') }}" class="inline-block px-5 py-1.5 sm:px-6 sm:py-2 rounded-full bg-gradient-to-r from-rani-gold to-yellow-500 text-rani-dark font-serif font-bold text-xs shadow hover:scale-105 transition-transform">
                            Create Free Profile
                        </a>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="px-4 sm:px-6 py-2.5 sm:py-3 bg-white border-t border-gray-200 flex items-center justify-between shrink-0">
                    <span class="text-[11px] sm:text-xs text-gray-500 font-serif italic truncate mr-2">Rani Matrimonial • Verified Happy Couples</span>
                    <button type="button" 
                            @click="closeStory()" 
                            class="inline-flex items-center gap-1.5 px-5 sm:px-6 py-2 sm:py-2.5 rounded-full bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white font-serif font-bold text-xs sm:text-sm shadow-md hover:shadow-lg border border-rani-gold/40 hover:scale-105 active:scale-95 transition-all shrink-0 cursor-pointer">
                        <span>Close</span>
                        <svg class="w-3.5 h-3.5 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
                    </button>
                </div>

            </div>
        </div>
    </template>

</section>
@endif

<!-- Trust & Stats Section -->
<section class="py-20 bg-rani-primary-dark text-white relative overflow-hidden border-y border-rani-gold/40">
    <!-- Subtle pattern -->
    <div class="absolute inset-0 opacity-10 bg-[url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMjAiIGhlaWdodD0iMjAiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+PGNpcmNsZSBjeD0iMiIgY3k9IjIiIHI9IjIiIGZpbGw9IiNkNGFmMzciIGZpbGwtb3BhY2l0eT0iMSIvPjwvc3ZnPg==')]"></div>
    
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-rani-gold/20">
            <div class="p-4">
                <div class="text-4xl md:text-6xl font-serif font-bold text-rani-gold mb-3 text-shadow-sm">2M+</div>
                <div class="text-rani-gold-light text-sm uppercase tracking-[0.2em] font-medium">Verified Profiles</div>
            </div>
            <div class="p-4">
                <div class="text-4xl md:text-6xl font-serif font-bold text-rani-gold mb-3 text-shadow-sm">500k</div>
                <div class="text-rani-gold-light text-sm uppercase tracking-[0.2em] font-medium">Success Stories</div>
            </div>
            <div class="p-4">
                <div class="text-4xl md:text-6xl font-serif font-bold text-rani-gold mb-3 text-shadow-sm">100%</div>
                <div class="text-rani-gold-light text-sm uppercase tracking-[0.2em] font-medium">Privacy & Security</div>
            </div>
            <div class="p-4 border-none">
                <div class="text-4xl md:text-6xl font-serif font-bold text-rani-gold mb-3 text-shadow-sm">24/7</div>
                <div class="text-rani-gold-light text-sm uppercase tracking-[0.2em] font-medium">Customer Support</div>
            </div>
        </div>
    </div>
</section>

<!-- Beautiful CTA -->
<section class="py-28 bg-white relative">
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="bg-gradient-to-br from-rani-primary to-rani-primary-dark rounded-2xl shadow-2xl p-10 md:p-16 text-center relative overflow-hidden border border-rani-gold/50">
            <!-- Decorative borders inside CTA -->
            <div class="absolute inset-4 border border-rani-gold/20 pointer-events-none"></div>
            
            <h2 class="text-3xl md:text-5xl font-serif font-bold text-white mb-6 relative z-10 leading-tight">
                Ready to find your <span class="text-rani-gold">soulmate?</span>
            </h2>
            <p class="text-rani-gold-light/90 mb-10 max-w-2xl mx-auto relative z-10 text-lg font-light">
                Join thousands of Indians who have found their perfect match on Ranimatrimonial. Your beautiful love story is just a click away.
            </p>
            
            <a href="{{ route('register.page') }}" class="inline-block bg-gradient-to-r from-rani-gold to-[#c59b27] hover:from-[#c59b27] hover:to-rani-gold text-rani-primary-dark font-serif font-bold text-xl py-4 px-12 rounded shadow-xl transform transition hover:-translate-y-1 relative z-10">
                Register Now for Free
            </a>
            <p class="mt-5 text-sm text-rani-gold-light/60 relative z-10 tracking-wide uppercase">No credit card required</p>
        </div>
    </div>
</section>

@endsection
