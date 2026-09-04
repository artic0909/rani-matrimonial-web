<header x-data="{ 
    mobileMenuOpen: false,
    profileMenuOpen: false
}" class="fixed w-full top-0 z-50 bg-rani-dark border-b-4 border-rani-gold shadow-md">
    
    <!-- Top Bar -->
    <div class="border-b border-white/10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                
                <!-- Logo & Primary Nav -->
                <div class="flex items-center gap-8">
                    <!-- Logo -->
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group shrink-0">
                        <img src="{{ asset('logo.png') }}" alt="Ranimatrimonial" class="h-10 w-auto transition-transform duration-300 group-hover:scale-105 shadow-sm rounded-full" />
                        <div class="flex items-baseline hidden sm:flex">
                            <span class="text-xl font-serif italic font-bold text-white tracking-wide">Rani</span>
                            <span class="text-xs font-serif text-rani-gold tracking-wider ml-1">matrimonial</span>
                        </div>
                    </a>

                    <!-- Desktop Top Nav -->
                    <nav class="hidden md:flex space-x-6">
                        <a href="{{ route('dashboard') }}" class="text-white hover:text-rani-gold font-medium text-sm transition-colors border-b-2 border-rani-gold pb-[21px] pt-[22px]">My Rani</a>
                        <a href="#" class="text-gray-300 hover:text-rani-gold font-medium text-sm transition-colors py-[22px] flex items-center gap-1">Matches <span class="bg-rani-gold text-rani-dark text-[10px] font-bold px-1.5 rounded-full">New</span></a>
                        <a href="#" class="text-gray-300 hover:text-rani-gold font-medium text-sm transition-colors py-[22px]">Search</a>
                        <a href="#" class="text-gray-300 hover:text-rani-gold font-medium text-sm transition-colors py-[22px] flex items-center gap-1">Inbox <span class="bg-white text-rani-dark text-[10px] font-bold px-1.5 rounded-full">0</span></a>
                    </nav>
                </div>

                <!-- Right Actions -->
                <div class="flex items-center space-x-4 md:space-x-6">
                    <a href="#" class="hidden md:inline-flex items-center gap-1 bg-gradient-to-r from-rani-gold to-yellow-500 text-rani-dark px-3 py-1.5 rounded text-xs font-bold uppercase shadow-sm hover:shadow-md transform hover:-translate-y-0.5 transition-all">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Upgrade
                    </a>
                    
                    <div class="hidden md:flex items-center gap-1 text-gray-300 hover:text-white cursor-pointer text-sm">
                        Help
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                    </div>

                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button @click="profileMenuOpen = !profileMenuOpen" @click.away="profileMenuOpen = false" class="flex items-center gap-2 focus:outline-none">
                            <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->first_name).'&background=D4AF37&color=fff' }}" alt="Profile" class="w-8 h-8 rounded-full border border-rani-gold object-cover">
                            <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="profileMenuOpen" style="display: none;" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 py-1 z-50">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                                <p class="text-xs text-gray-500 truncate">{{ Auth::user()->email }}</p>
                            </div>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-rani-primary/5 hover:text-rani-primary">My Profile</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-rani-primary/5 hover:text-rani-primary">Account Settings</a>
                            <form method="POST" action="/logout">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</button>
                            </form>
                        </div>
                    </div>

                    <!-- Mobile menu button -->
                    <button @click="mobileMenuOpen = !mobileMenuOpen" type="button" class="md:hidden inline-flex items-center justify-center p-2 rounded-md text-rani-gold focus:outline-none">
                        <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                            <path x-show="!mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                            <path x-show="mobileMenuOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" style="display: none;"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Sub Header (Nav Tabs) -->
    <div class="bg-white shadow-sm hidden md:block">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <nav class="flex space-x-8">
                <a href="{{ route('dashboard') }}" class="border-b-2 border-rani-primary text-rani-primary font-medium text-sm py-3 px-1 transition-colors">Dashboard</a>
                <a href="#" class="border-b-2 border-transparent text-gray-600 hover:text-rani-primary hover:border-gray-300 font-medium text-sm py-3 px-1 transition-colors">My Profile</a>
                <a href="#" class="border-b-2 border-transparent text-gray-600 hover:text-rani-primary hover:border-gray-300 font-medium text-sm py-3 px-1 transition-colors">My Photos</a>
                <a href="#" class="border-b-2 border-transparent text-gray-600 hover:text-rani-primary hover:border-gray-300 font-medium text-sm py-3 px-1 transition-colors">Partner Preferences</a>
                <a href="#" class="border-b-2 border-transparent text-gray-600 hover:text-rani-primary hover:border-gray-300 font-medium text-sm py-3 px-1 transition-colors">Settings</a>
                <a href="#" class="border-b-2 border-transparent text-gray-600 hover:text-rani-primary hover:border-gray-300 font-medium text-sm py-3 px-1 transition-colors">More</a>
            </nav>
        </div>
    </div>

    <!-- Mobile Menu Dropdown -->
    <div x-show="mobileMenuOpen" style="display: none;" class="md:hidden absolute w-full bg-white shadow-xl border-t border-gray-100">
        <div class="px-4 py-2 bg-gray-50 flex items-center justify-between">
            <span class="text-sm font-semibold text-gray-800">Hi, {{ Auth::user()->first_name }}</span>
            <a href="#" class="text-xs bg-rani-gold text-rani-dark font-bold px-2 py-1 rounded">UPGRADE</a>
        </div>
        <div class="px-2 pt-2 pb-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-md text-base font-medium text-rani-primary bg-rani-primary/10">Dashboard</a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-rani-primary hover:bg-gray-50">Matches</a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-rani-primary hover:bg-gray-50">Search</a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-rani-primary hover:bg-gray-50">Inbox</a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-rani-primary hover:bg-gray-50">My Profile</a>
            <a href="#" class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-rani-primary hover:bg-gray-50">Partner Preferences</a>
            <div class="border-t border-gray-200 my-2"></div>
            <form method="POST" action="/logout">
                @csrf
                <button type="submit" class="block w-full text-left px-3 py-2 rounded-md text-base font-medium text-red-600 hover:bg-red-50">Logout</button>
            </form>
        </div>
    </div>
</header>
