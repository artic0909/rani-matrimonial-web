<footer class="relative z-10 bg-[#1f0103] text-white border-t-2 border-[#d4af37] mt-auto overflow-hidden">
    <!-- Ambient Red Faded Glow behind hands on right side -->
    <div class="absolute right-0 top-1/2 -translate-y-1/2 w-[380px] sm:w-[500px] lg:w-[700px] h-[300px] sm:h-[320px] pointer-events-none select-none z-0">
        <div class="absolute right-0 top-8 w-[320px] sm:w-[420px] lg:w-[520px] h-[200px] sm:h-[220px] rounded-full bg-[radial-gradient(ellipse_at_center,_rgba(180,20,40,0.55)_0%,_rgba(117,0,0,0.3)_40%,_transparent_75%)] blur-3xl"></div>
    </div>

    <!-- Right-Side Romantic Couple Hands Image (Anchored to right bottom, bigger size) -->
    <div class="absolute right-0 bottom-0 pointer-events-none select-none z-0 flex items-end justify-end overflow-hidden">
        <img src="{{ asset('img/footer-img.png') }}" 
             alt="Rani Matrimonial" 
             class="h-[230px] sm:h-[260px] md:h-[290px] lg:h-[320px] xl:h-[340px] w-auto max-w-none object-contain object-right-bottom opacity-85 sm:opacity-95 lg:opacity-100 transition-opacity duration-300" />
    </div>

    <!-- Top & Main Content Section -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-10 sm:pt-12 pb-6 sm:pb-8">
        <div class="w-full lg:max-w-[65%] xl:max-w-[62%]">
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-12 gap-8 items-start">
                <!-- Brand Column -->
                <div class="sm:col-span-2 md:col-span-5 lg:col-span-5 pr-0 sm:pr-4">
                    <div class="mb-4 flex items-center gap-3">
                        <img src="{{ asset('logo.png') }}" alt="Ranimatrimonial" class="h-12 sm:h-14 w-auto drop-shadow-sm" />
                        <div class="flex items-baseline">
                            <span class="text-2xl sm:text-3xl font-serif italic font-bold text-white tracking-wide">Rani</span>
                            <span class="text-base sm:text-lg font-serif text-rani-gold tracking-wider ml-1.5 font-normal">matrimonial</span>
                        </div>
                    </div>
                    <p class="text-rani-gold-light/75 text-xs sm:text-sm leading-relaxed font-light max-w-xs">
                        Bringing hearts together across India. A modern, safe, and beautiful way to find your forever partner, respecting all cultures and traditions.
                    </p>
                </div>

                <!-- Quick Links -->
                <div class="col-span-1 md:col-span-2 lg:col-span-2">
                    <h3 class="text-base sm:text-lg font-serif font-bold mb-3 sm:mb-4 text-rani-gold tracking-wide">Quick Links</h3>
                    <ul class="space-y-2 sm:space-y-2.5 text-xs sm:text-sm text-rani-gold-light/80">
                        <li><a href="{{ url('/') }}" class="hover:text-rani-gold hover:underline transition-colors">Home</a></li>
                        <li><a href="{{ route('about') }}" class="hover:text-rani-gold hover:underline transition-colors">About Us</a></li>
                        <li><a href="{{ route('register.page') }}" class="hover:text-rani-gold hover:underline transition-colors">Register Free</a></li>
                        <li><a href="{{ route('stories') }}" class="hover:text-rani-gold hover:underline transition-colors">Success Stories</a></li>
                        <li><a href="{{ route('search') }}" class="hover:text-rani-gold hover:underline transition-colors">Search Profiles</a></li>
                    </ul>
                </div>

                <!-- Legal & Support -->
                <div class="col-span-1 md:col-span-3 lg:col-span-3">
                    <h3 class="text-base sm:text-lg font-serif font-bold mb-3 sm:mb-4 text-rani-gold tracking-wide">Legal & Support</h3>
                    <ul class="space-y-2 sm:space-y-2.5 text-xs sm:text-sm text-rani-gold-light/80">
                        <li><a href="{{ Auth::check() ? route('support.index') : route('help.center') }}" class="hover:text-rani-gold hover:underline transition-colors">Support</a></li>
                        <li><a href="{{ route('help.center') }}" class="hover:text-rani-gold hover:underline transition-colors">Help Center</a></li>
                        <li><a href="{{ route('privacy.policy') }}" class="hover:text-rani-gold hover:underline transition-colors">Privacy Policy</a></li>
                        <li><a href="{{ route('terms.conditions') }}" class="hover:text-rani-gold hover:underline transition-colors">Terms & Conditions</a></li>
                        <li><a href="{{ route('child.safety') }}" class="hover:text-rani-gold hover:underline transition-colors text-amber-300 font-medium">Child Safety Standards</a></li>
                    </ul>
                </div>

                <!-- Connect With Us -->
                <div class="sm:col-span-2 md:col-span-2 lg:col-span-2">
                    <h3 class="text-base sm:text-lg font-serif font-bold mb-3 sm:mb-4 text-rani-gold tracking-wide whitespace-nowrap">Connect With Us</h3>
                    <div class="flex items-center space-x-3.5">
                        <a href="https://facebook.com" target="_blank" rel="noopener noreferrer" aria-label="Facebook"
                           class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white/10 hover:bg-rani-gold text-rani-gold-light hover:text-rani-primary-dark transition-all duration-300 flex items-center justify-center shadow-inner hover:scale-105">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                        <a href="https://instagram.com" target="_blank" rel="noopener noreferrer" aria-label="Instagram"
                           class="w-9 h-9 sm:w-10 sm:h-10 rounded-full bg-white/10 hover:bg-rani-gold text-rani-gold-light hover:text-rani-primary-dark transition-all duration-300 flex items-center justify-center shadow-inner hover:scale-105">
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path fill-rule="evenodd" d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.153 1.772c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.772-1.153c-.636-.247-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z" clip-rule="evenodd"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bottom Full-Width Divider Line & Copyright -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="border-t border-[#d4af37]/30 pt-6 pb-6 text-center text-xs sm:text-sm text-rani-gold-light/75 space-y-1">
            <p>&copy; {{ date('Y') }} <strong class="text-white font-semibold">Rani Matrimonial</strong>. All rights reserved. A brand owned & operated by <strong class="text-white font-semibold">Sumatra Sales Private Limited</strong>.</p>
            <p class="text-[11px] sm:text-xs text-rani-gold-light/50 font-light">Made with <span class="text-red-500">❤️</span> in India.</p>
        </div>
    </div>
</footer>
