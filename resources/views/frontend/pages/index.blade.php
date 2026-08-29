@extends('frontend.layouts.app')

@section('title', 'Ranimatrimonial - Find Your Perfect Match')

@section('content')

<!-- Hero Section -->
<section class="relative min-h-screen flex flex-col justify-end overflow-hidden pb-16 md:pb-24">
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
    <div class="relative z-10 w-full max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-auto">
        <div class="text-center space-y-4 mb-10">
            <h1 class="text-4xl md:text-6xl font-serif font-bold text-white leading-tight var(--animate-fade-in-up) tracking-wide drop-shadow-lg">
                Choose Your <span class="text-rani-gold">Forever</span>
            </h1>
            <p class="text-lg md:text-xl text-gray-200 font-light var(--animate-fade-in-up) drop-shadow-md" style="animation-delay: 0.2s;">
                Find love on your terms with millions of verified profiles
            </p>
        </div>

        <!-- Horizontal Search Widget (Shaadi Style) -->
        <div class="w-full bg-black/60 backdrop-blur-md p-5 sm:p-6 rounded-xl border border-white/10 shadow-2xl var(--animate-fade-in-up)" style="animation-delay: 0.4s;">
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
                    <button type="button" class="w-full bg-rani-gold hover:bg-[#c59b27] text-rani-primary-dark font-bold text-sm py-2.5 px-4 rounded shadow-lg transition-colors">
                        Let's Begin
                    </button>
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
            
            <a href="#" class="inline-block bg-gradient-to-r from-rani-gold to-[#c59b27] hover:from-[#c59b27] hover:to-rani-gold text-rani-primary-dark font-serif font-bold text-xl py-4 px-12 rounded shadow-xl transform transition hover:-translate-y-1 relative z-10">
                Register Now for Free
            </a>
            <p class="mt-5 text-sm text-rani-gold-light/60 relative z-10 tracking-wide uppercase">No credit card required</p>
        </div>
    </div>
</section>

@endsection
