<header class="fixed w-full top-0 z-50 transition-all duration-300" x-data="{ scrolled: false, mobileMenuOpen: false }" @scroll.window="scrolled = (window.pageYOffset > 20)" :class="{ 'bg-rani-light/95 backdrop-blur-md shadow-md py-2 border-b border-rani-gold/30': scrolled, 'bg-transparent py-4': !scrolled }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center">
            <!-- Logo -->
            <div class="flex-shrink-0 flex items-center">
                <a href="/" class="flex items-center gap-2 md:gap-3 group">
                    <img src="{{ asset('logo.png') }}" alt="Ranimatrimonial" class="h-12 md:h-14 w-auto transition-transform duration-300 group-hover:scale-105 shadow-sm rounded-full" />
                    <div class="flex items-baseline">
                        <span class="text-2xl md:text-3xl font-serif italic font-bold tracking-wide transition-colors" :class="{ 'text-rani-primary-dark': scrolled, 'text-white': !scrolled }">Rani</span>
                        <span class="text-base md:text-lg font-serif tracking-wider ml-1 transition-colors" :class="{ 'text-rani-gold': scrolled, 'text-rani-gold-light': !scrolled }">matrimonial</span>
                    </div>
                </a>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden md:flex space-x-8 items-center">
                <a href="#" class="font-serif text-base transition-colors hover:text-rani-gold font-medium" :class="{ 'text-rani-primary-dark': scrolled, 'text-rani-light': !scrolled }">Home</a>
                <a href="#" class="font-serif text-base transition-colors hover:text-rani-gold font-medium" :class="{ 'text-rani-primary-dark': scrolled, 'text-rani-light': !scrolled }">Search</a>
                <a href="#" class="font-serif text-base transition-colors hover:text-rani-gold font-medium" :class="{ 'text-rani-primary-dark': scrolled, 'text-rani-light': !scrolled }">Success Stories</a>
                <a href="#" class="font-serif text-base transition-colors hover:text-rani-gold font-medium" :class="{ 'text-rani-primary-dark': scrolled, 'text-rani-light': !scrolled }">Membership</a>
            </nav>

            <!-- Auth Buttons -->
            <div class="hidden md:flex items-center space-x-4">
                <a href="#" class="font-medium text-sm transition-colors" :class="{ 'text-rani-primary hover:text-rani-gold': scrolled, 'text-rani-light hover:text-rani-gold': !scrolled }">Log in</a>
                <a href="#" class="px-6 py-2 rounded-full text-sm font-semibold transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 border border-rani-gold text-white bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary">
                    Register Free
                </a>
            </div>

            <!-- Mobile menu button -->
            <div class="md:hidden flex items-center">
                <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="inline-flex items-center justify-center p-2 rounded-md focus:outline-none transition-colors" :class="{ 'text-rani-primary-dark': scrolled, 'text-rani-gold': !scrolled }">
                    <svg class="h-7 w-7" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;"></path>
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <div x-show="mobileMenuOpen" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 -translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 -translate-y-2" class="md:hidden absolute w-full bg-rani-light shadow-2xl border-t border-rani-gold/30" style="display: none;">
        <div class="px-4 pt-2 pb-6 space-y-1">
            <a href="#" class="block px-3 py-3 rounded-md text-base font-serif font-medium text-rani-primary-dark hover:bg-rani-primary/5 hover:text-rani-primary">Home</a>
            <a href="#" class="block px-3 py-3 rounded-md text-base font-serif font-medium text-rani-primary-dark hover:bg-rani-primary/5 hover:text-rani-primary">Search</a>
            <a href="#" class="block px-3 py-3 rounded-md text-base font-serif font-medium text-rani-primary-dark hover:bg-rani-primary/5 hover:text-rani-primary">Success Stories</a>
            <a href="#" class="block px-3 py-3 rounded-md text-base font-serif font-medium text-rani-primary-dark hover:bg-rani-primary/5 hover:text-rani-primary">Membership</a>
            <div class="mt-4 pt-4 border-t border-rani-gold/30 flex flex-col gap-3">
                <a href="#" class="block w-full text-center px-4 py-2 text-base font-medium text-rani-primary">Log in</a>
                <a href="#" class="block w-full text-center px-4 py-2 border border-rani-gold rounded-full shadow-sm text-base font-medium text-white bg-gradient-to-r from-rani-primary to-rani-primary-dark">Register Free</a>
            </div>
        </div>
    </div>
</header>
