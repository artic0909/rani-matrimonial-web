@extends('frontend.layouts.app')

@section('title', 'Success Stories | Rani Matrimonial')

@section('content')
<div class="relative min-h-[100svh] pt-28 md:pt-36 pb-20 overflow-x-hidden" x-data="{
    storyModalOpen: false,
    selectedStory: null,
    activePhotoIdx: 0,

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
    <!-- Background Image -->
    <div class="fixed inset-0 z-0 bg-cover bg-top bg-no-repeat pointer-events-none" style="background-image: url('{{ asset('img/hero.png') }}');"></div>
    
    <!-- Maroon/Gold Gradient Overlay -->
    <div class="fixed inset-0 z-0 bg-gradient-to-t from-rani-dark/95 via-rani-primary-dark/80 to-rani-primary-dark/55 pointer-events-none"></div>

    <!-- Floating Sweet Gestures (Hearts) -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none heart-container opacity-40">
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

    <!-- Container Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Hero Header Title -->
        <div class="text-center mb-12">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-white/10 backdrop-blur-md border border-rani-gold/40 text-rani-gold font-medium text-xs sm:text-sm uppercase tracking-widest mb-4 shadow-lg">
                <span class="w-2 h-2 rounded-full bg-rani-gold animate-ping"></span>
                Real Couples • Real Love
            </div>
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-serif font-bold text-white mb-4 tracking-tight drop-shadow-md">
                Matrimonial Success Stories
            </h1>
            <div class="flex items-center justify-center gap-4 mb-4">
                <div class="h-[1px] w-12 bg-rani-gold"></div>
                <div class="w-2 h-2 rounded-full bg-rani-gold"></div>
                <div class="h-[1px] w-12 bg-rani-gold"></div>
            </div>
            <p class="text-base sm:text-lg text-rani-gold-light/90 font-light max-w-2xl mx-auto drop-shadow">
                Witness how two souls, guided by destiny and trust on Rani Matrimonial, found their everlasting happiness together.
            </p>
        </div>

        <!-- Stories Grid -->
        @if($stories->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 lg:gap-8 mb-12">
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
                    <div class="bg-white/95 backdrop-blur-md rounded-3xl overflow-hidden shadow-2xl border border-rani-gold/30 flex flex-col justify-between group hover:-translate-y-1.5 transition-all duration-500 hover:shadow-rani-gold/20">
                        
                        <div>
                            <!-- Cover Photo Box -->
                            <div class="relative h-64 sm:h-72 w-full overflow-hidden bg-black/60 cursor-pointer select-none"
                                 @click="openStory(@js($storyPayload))">
                                <img src="{{ $story->image_url }}" alt="{{ $story->title }}" class="w-full h-full object-cover object-top transition-transform duration-700 group-hover:scale-105">
                                
                                <!-- Gradient Shadow Overlay -->
                                <div class="absolute inset-0 bg-gradient-to-t from-black/85 via-black/25 to-transparent pointer-events-none"></div>

                                <!-- Top Badges -->
                                <div class="absolute top-3 left-3 z-10 flex flex-col gap-1.5">
                                    @if($story->couple_names)
                                        <span class="px-3 py-1 rounded-full bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white text-xs font-bold shadow-md border border-rani-gold/40 flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-rani-gold fill-current" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                                            <span>{{ $story->couple_names }}</span>
                                        </span>
                                    @endif
                                </div>

                                <div class="absolute top-3 right-3 z-10">
                                    <span class="px-2.5 py-1 rounded-full bg-black/60 backdrop-blur-sm text-rani-gold text-[11px] font-semibold flex items-center gap-1 border border-white/20">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                        <span>{{ count($story->gallery_images) }} Photos</span>
                                    </span>
                                </div>

                                <!-- Bottom Info in Photo Box -->
                                <div class="absolute bottom-3 left-4 right-4 text-white z-10">
                                    @if($story->formatted_wedding_date)
                                        <p class="text-xs text-rani-gold font-serif italic mb-0.5 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                            <span>Married on {{ $story->formatted_wedding_date }}</span>
                                        </p>
                                    @endif
                                    <h3 class="text-lg font-serif font-bold text-white drop-shadow-md truncate">{{ $story->title }}</h3>
                                </div>
                            </div>

                            <!-- Text Content & Excerpt -->
                            <div class="p-5 sm:p-6">
                                <p class="text-gray-600 text-sm leading-relaxed line-clamp-3 font-light mb-4">
                                    {{ Str::limit(strip_tags($story->descriptions), 140) }}
                                </p>
                            </div>
                        </div>

                        <!-- Read Story Action Button -->
                        <div class="px-5 sm:px-6 pb-6 pt-0">
                            <button type="button" 
                                    @click="openStory(@js($storyPayload))" 
                                    class="w-full py-3 px-4 rounded-2xl bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white font-serif font-bold text-sm shadow-md transition-all flex items-center justify-center gap-2 group/btn border border-rani-gold/30">
                                <span>Read Love Story</span>
                                <svg class="w-4 h-4 text-rani-gold group-hover/btn:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                            </button>
                        </div>

                    </div>
                @endforeach
            </div>

            <!-- Pagination Links -->
            <div class="flex justify-center mt-6">
                {{ $stories->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white/90 backdrop-blur-md rounded-3xl p-12 text-center max-w-xl mx-auto shadow-2xl border border-white/60">
                <div class="w-20 h-20 rounded-full bg-rani-light flex items-center justify-center mx-auto text-rani-primary mb-4 border border-rani-gold/40">
                    <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M3.172 5.172a4 4 0 015.656 0L10 6.343l1.172-1.171a4 4 0 115.656 5.656L10 17.657l-6.828-6.829a4 4 0 010-5.656z" clip-rule="evenodd"></path></svg>
                </div>
                <h3 class="text-2xl font-serif font-bold text-rani-primary-dark mb-2">Our Love Stories Are Brewing!</h3>
                <p class="text-gray-600 text-sm mb-6 font-light leading-relaxed">
                    Thousands of verified candidates are connecting every day. Check back soon or be our next inspiring story!
                </p>
                <a href="{{ route('register.page') }}" class="inline-block px-8 py-3.5 rounded-full bg-gradient-to-r from-rani-gold to-yellow-500 text-rani-dark font-serif font-bold text-base shadow-xl hover:scale-105 transition-all">
                    Start Your Love Story
                </a>
            </div>
        @endif

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
                        
                        <!-- If wedding date present -->
                        <div class="absolute bottom-2.5 left-2.5 sm:bottom-3 sm:left-3 bg-black/75 backdrop-blur-sm px-2.5 sm:px-3 py-1 rounded-full text-white text-[11px] sm:text-xs font-serif italic border border-white/20 flex items-center gap-1.5" x-show="selectedStory && selectedStory.wedding_date">
                            <span>💍</span>
                            <span x-text="'Married on ' + (selectedStory ? selectedStory.wedding_date : '')"></span>
                        </div>
                    </div>

                    <!-- Multiple Photos Thumbnails Strip -->
                    <div class="flex gap-2 overflow-x-auto py-1 scrollbar-thin" x-show="selectedStory && selectedStory.gallery_images && selectedStory.gallery_images.length > 1">
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
                        <h5 class="font-serif font-bold text-rani-primary-dark text-xs sm:text-sm">Ready to write your own happy story?</h5>
                        <p class="text-[11px] sm:text-xs text-gray-600 max-w-md mx-auto font-light">Join Rani Matrimonial today and explore millions of genuine verified profiles.</p>
                        <a href="{{ route('register.page') }}" class="inline-block px-5 py-1.5 sm:px-6 sm:py-2 rounded-full bg-gradient-to-r from-rani-gold to-yellow-500 text-rani-dark font-serif font-bold text-xs shadow hover:scale-105 transition-transform">
                            Create Free Profile
                        </a>
                    </div>

                </div>

                <!-- Modal Footer -->
                <div class="px-4 sm:px-6 py-2.5 sm:py-3 bg-white border-t border-gray-200 flex items-center justify-between shrink-0">
                    <span class="text-[11px] sm:text-xs text-gray-500 font-serif italic truncate mr-2">Rani Matrimonial • Love Knows No Distance</span>
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

</div>
@endsection
