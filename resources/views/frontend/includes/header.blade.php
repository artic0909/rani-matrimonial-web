<header x-data="headerAuth()" 
    @scroll.window="scrolled = (window.pageYOffset > 20)" 
    @open-login.window="openLoginModal()"
    @open-register.window="openRegisterModal()"
    class="fixed w-full top-0 z-50 transition-all duration-300"
    :class="{ 'bg-rani-light shadow-md py-2': scrolled, 'bg-transparent py-4': !scrolled }">
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
            <nav class="hidden md:flex space-x-7 items-center">
                <a href="{{ route('search') }}" class="font-serif text-base transition-colors hover:text-rani-gold font-medium flex items-center gap-1.5 {{ request()->routeIs('search*') ? 'text-rani-gold font-bold' : '' }}" :class="{ 'text-rani-primary-dark': scrolled && !'{{ request()->routeIs('search*') }}', 'text-rani-light': !scrolled && !'{{ request()->routeIs('search*') }}' }">
                    <svg class="w-4 h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    <span>Search</span>
                </a>
                <a href="{{ route('about') }}" class="font-serif text-base transition-colors hover:text-rani-gold font-medium {{ request()->routeIs('about*') ? 'text-rani-gold font-bold' : '' }}" :class="{ 'text-rani-primary-dark': scrolled && !'{{ request()->routeIs('about*') }}', 'text-rani-light': !scrolled && !'{{ request()->routeIs('about*') }}' }">About</a>
                <a href="{{ route('help.center') }}" class="font-serif text-base transition-colors hover:text-rani-gold font-medium {{ request()->routeIs('help.center*') ? 'text-rani-gold font-bold' : '' }}" :class="{ 'text-rani-primary-dark': scrolled && !'{{ request()->routeIs('help.center*') }}', 'text-rani-light': !scrolled && !'{{ request()->routeIs('help.center*') }}' }">Help</a>
                <a href="{{ route('stories') }}" class="font-serif text-base transition-colors hover:text-rani-gold font-medium {{ request()->routeIs('stories*') ? 'text-rani-gold font-bold' : '' }}" :class="{ 'text-rani-primary-dark': scrolled && !'{{ request()->routeIs('stories*') }}', 'text-rani-light': !scrolled && !'{{ request()->routeIs('stories*') }}' }">Success Stories</a>
            </nav>

            <!-- Auth Buttons -->
            <div class="hidden md:flex items-center space-x-4">
                @auth
                    <a href="{{ route('dashboard') }}" class="font-medium text-sm transition-colors" :class="{ 'text-rani-primary hover:text-rani-gold': scrolled, 'text-rani-light hover:text-rani-gold': !scrolled }">My Dashboard</a>
                    <!-- Profile Dropdown -->
                    <div class="relative">
                        <button @click="profileMenuOpen = !profileMenuOpen" @click.away="profileMenuOpen = false" class="flex items-center gap-2 focus:outline-none">
                            <img src="{{ Auth::user()->profile_picture ? asset('storage/' . Auth::user()->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode(Auth::user()->first_name).'&background=D4AF37&color=fff' }}" alt="Profile" class="w-10 h-10 rounded-full border-2 border-rani-gold object-cover shadow-sm">
                        </button>
                        
                        <!-- Dropdown Menu -->
                        <div x-show="profileMenuOpen" style="display: none;" x-transition class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-100 py-1 z-50 text-left">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-semibold text-gray-800">{{ Auth::user()->first_name }} {{ Auth::user()->last_name }}</p>
                            </div>
                            <a href="{{ route('dashboard') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-rani-primary/5 hover:text-rani-primary">Dashboard</a>
                            <a href="{{ route('search') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-rani-primary/5 hover:text-rani-primary">Search Profiles</a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50">Logout</button>
                            </form>
                        </div>
                    </div>
                @else
                    <a href="#" @click.prevent="openLoginModal()" class="font-serif text-base transition-colors hover:text-rani-gold font-medium" :class="{ 'text-rani-primary-dark': scrolled, 'text-rani-light': !scrolled }">Log In</a>
                    <a href="{{ route('register.page') }}" class="inline-flex items-center px-5 py-2.5 border border-rani-gold rounded-full shadow-md text-sm font-bold text-white bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary transition-all duration-300 transform hover:-translate-y-0.5">Register Now</a>
                @endauth
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
            <a href="{{ route('search') }}" class="flex items-center gap-2 px-3 py-3 rounded-md text-base font-serif font-semibold {{ request()->routeIs('search*') ? 'text-rani-primary bg-rani-primary/10' : 'text-rani-primary-dark hover:bg-rani-primary/5 hover:text-rani-primary' }}">
                <svg class="w-5 h-5 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                <span>Search Profiles</span>
            </a>
            <a href="{{ route('about') }}" class="block px-3 py-3 rounded-md text-base font-serif font-medium {{ request()->routeIs('about*') ? 'text-rani-primary font-bold bg-rani-primary/10' : 'text-rani-primary-dark' }} hover:bg-rani-primary/5 hover:text-rani-primary">About</a>
            <a href="{{ route('help.center') }}" class="block px-3 py-3 rounded-md text-base font-serif font-medium {{ request()->routeIs('help.center*') ? 'text-rani-primary font-bold' : 'text-rani-primary-dark' }} hover:bg-rani-primary/5 hover:text-rani-primary">Help</a>
            <a href="{{ route('stories') }}" class="block px-3 py-3 rounded-md text-base font-serif font-medium {{ request()->routeIs('stories*') ? 'text-rani-primary font-bold' : 'text-rani-primary-dark' }} hover:bg-rani-primary/5 hover:text-rani-primary">Success Stories</a>
            <div class="mt-4 pt-4 border-t border-rani-gold/30 flex flex-col gap-3">
                @auth
                    <a href="{{ route('dashboard') }}" class="block w-full text-center px-4 py-2 text-base font-medium text-rani-primary">My Dashboard</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="block w-full text-center px-4 py-2 text-base font-medium text-red-600">Logout</button>
                    </form>
                @else
                    <a href="#" @click.prevent="openLoginModal()" class="block w-full text-center px-4 py-2 text-base font-medium text-rani-primary">Log in</a>
                    <a href="{{ route('register.page') }}" class="block w-full text-center px-4 py-2 border border-rani-gold rounded-full shadow-sm text-base font-medium text-white bg-gradient-to-r from-rani-primary to-rani-primary-dark">Register Now</a>
                @endauth
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div x-show="showLogin" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 p-4">
        <div class="bg-white rounded-2xl shadow-2xl p-6 sm:p-8 max-w-sm w-full relative transform transition-all flex flex-col" @click.away="showLogin = false">
            <!-- Modal Header with Back & Close icons -->
            <div class="flex justify-between items-center mb-5 shrink-0">
                <button @click="loginStep = 1; resetLoginOtp();" x-show="loginStep > 1" type="button" class="text-gray-400 hover:text-rani-primary transition-colors p-1 -ml-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <div x-show="loginStep === 1" class="w-8"></div>
                
                <h2 class="text-2xl font-serif font-bold text-rani-primary-dark text-center flex-1" x-text="loginStep === 1 ? 'Login' : 'Enter OTP'"></h2>
                
                <button @click="showLogin = false; loginStep = 1; authError = ''; resetLoginOtp();" type="button" class="text-gray-400 hover:text-red-500 transition-colors p-1 -mr-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div>
                <div x-show="authError" class="mb-4 text-sm text-red-600 bg-red-50 p-3 rounded-lg text-center border border-red-100" x-text="authError"></div>

                <!-- Step 1: Mobile -->
                <div x-show="loginStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <label class="block text-sm font-medium text-gray-700 mb-2">Mobile Number</label>
                    <div class="relative mb-5">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-gray-500 font-medium text-base">
                            +91
                        </div>
                        <input type="tel" 
                               x-model="loginMobile" 
                               @keyup.enter="sendOtp()"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')" 
                               placeholder="10-digit number" 
                               class="w-full pl-13 pr-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-rani-primary focus:border-transparent text-lg tracking-wider text-gray-800" 
                               maxlength="10"
                               autofocus>
                    </div>
                    <button @click="sendOtp()" 
                            :disabled="isSendingOtp || loginMobile.length !== 10" 
                            class="w-full bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white font-bold text-base sm:text-lg py-3 rounded-xl hover:shadow-lg transform transition hover:-translate-y-0.5 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                        <svg x-show="isSendingOtp" class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" style="display: none;">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span x-text="isSendingOtp ? 'Sending OTP...' : 'Continue'"></span>
                    </button>
                    
                    <div class="mt-4 text-center">
                        <span class="text-xs text-gray-500">Don't have an account? </span>
                        <a href="{{ route('register.page') }}" class="text-xs font-semibold text-rani-primary hover:underline">Register Free</a>
                    </div>
                </div>

                <!-- Step 2: 4-Box Auto-Jump & Auto-Verify OTP -->
                <div x-show="loginStep === 2" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <p class="text-sm text-gray-600 text-center mb-1">
                        Enter 4-digit code sent to
                    </p>
                    <p class="text-sm font-bold text-rani-primary-dark text-center mb-5">
                        +91 <span x-text="loginMobile"></span>
                    </p>

                    <!-- 4 Box OTP Inputs -->
                    <div class="flex justify-center items-center gap-2 sm:gap-3 mb-6" @paste="handleOtpPaste($event)">
                        <template x-for="i in [1, 2, 3, 4]" :key="i">
                            <input 
                                :id="'login-otp-' + i" 
                                type="text" 
                                inputmode="numeric" 
                                pattern="[0-9]*" 
                                maxlength="1" 
                                :value="$data['loginOtp' + i]"
                                @input="handleOtpInput(i, $event)" 
                                @keydown="handleOtpKeydown(i, $event)" 
                                class="w-12 h-14 sm:w-14 sm:h-16 text-center text-2xl sm:text-3xl font-bold font-mono text-rani-primary-dark bg-gray-50 border-2 border-gray-300 rounded-xl focus:bg-white focus:border-rani-primary focus:ring-4 focus:ring-rani-primary/20 focus:outline-none transition-all duration-200 shadow-sm"
                                :disabled="isVerifyingOtp"
                                autocomplete="one-time-code"
                            >
                        </template>
                    </div>

                    <!-- Auto-verifying state indicator -->
                    <div x-show="isVerifyingOtp" class="flex items-center justify-center gap-2 text-rani-primary font-medium py-2.5 mb-2 bg-pink-50/60 rounded-xl border border-pink-100" style="display: none;">
                        <svg class="animate-spin h-5 w-5 text-rani-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                        <span class="text-sm">Verifying OTP automatically...</span>
                    </div>

                    <!-- Options Footer -->
                    <div class="flex items-center justify-between text-xs sm:text-sm text-gray-500 pt-3 border-t border-gray-100 mt-2">
                        <button type="button" @click="loginStep = 1; resetLoginOtp();" class="text-gray-500 hover:text-rani-primary transition-colors flex items-center gap-1 font-medium">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            <span>Edit Number</span>
                        </button>
                        <button type="button" @click="sendOtp()" :disabled="isSendingOtp" class="text-rani-primary font-semibold hover:underline disabled:opacity-50">
                            Resend OTP
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div x-show="showRegister" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 p-4">
        <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 max-w-md w-full relative transform transition-all max-h-full flex flex-col" @click.away="showRegister = false">
            <!-- Modal Header with Back & Close icons -->
            <div class="flex justify-between items-center mb-4 md:mb-6 border-b pb-4 border-gray-100 shrink-0">
                <button @click="registerStep--" x-show="registerStep > 1" type="button" class="text-gray-400 hover:text-rani-primary transition-colors p-1 -ml-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <div x-show="registerStep === 1" class="w-8"></div>
                
                <div class="flex-1 text-center">
                    <h2 class="text-xl font-serif font-bold text-rani-primary-dark">Registration</h2>
                    <div class="text-xs text-gray-400 mt-1" x-text="`Step ${registerStep} of 6`"></div>
                </div>
                
                <button @click="showRegister = false; registerStep = 1; authError = '';" type="button" class="text-gray-400 hover:text-red-500 transition-colors p-1 -mr-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="overflow-y-auto custom-scrollbar flex-1 -mx-2 px-2 pb-2">
                <div x-show="authError" class="mb-5 text-sm text-red-600 bg-red-50 p-3 rounded-lg text-center border border-red-100" x-text="authError"></div>

                <!-- Step 1: Profile For -->
                <div x-show="registerStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <div class="w-16 h-16 mx-auto bg-pink-50 rounded-full flex items-center justify-center mb-6 shadow-sm border border-pink-100">
                        <svg class="w-8 h-8 text-rani-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                    </div>
                    <label class="block text-xl font-medium text-gray-800 mb-6 font-serif">This Profile is for</label>
                    <div class="flex flex-wrap gap-3 mb-8">
                        <template x-for="type in ['Myself', 'My Son', 'My Daughter', 'My Brother', 'My Sister', 'My Friend', 'My Relative']">
                            <label class="flex items-center gap-2 border rounded-full px-5 py-2.5 cursor-pointer transition-all duration-300" :class="registerData.profile_for === type ? 'bg-rani-primary/5 border-rani-primary shadow-sm' : 'hover:bg-pink-50/50 border-gray-200'">
                                <input type="radio" x-model="registerData.profile_for" :value="type" class="hidden">
                                <div class="w-5 h-5 rounded-full border flex items-center justify-center transition-colors duration-300" :class="registerData.profile_for === type ? 'bg-rani-primary border-rani-primary' : 'border-gray-300 bg-gray-50'">
                                    <svg x-show="registerData.profile_for === type" class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span x-text="type" :class="registerData.profile_for === type ? 'text-rani-primary-dark font-medium' : 'text-gray-600'"></span>
                            </label>
                        </template>
                    </div>
                    <button :disabled="!registerData.profile_for" @click="registerStep = 2" class="w-full text-white font-bold text-lg py-3.5 rounded-full transition-all duration-300" :class="registerData.profile_for ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:shadow-lg transform hover:-translate-y-0.5 border border-rani-gold/50' : 'bg-gray-300 cursor-not-allowed'">Continue</button>
                </div>

                <!-- Step 2: Gender -->
                <div x-show="registerStep === 2" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <div class="w-16 h-16 mx-auto bg-pink-50 rounded-full flex items-center justify-center mb-6 shadow-sm border border-pink-100">
                        <svg class="w-8 h-8 text-rani-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-4.418 0-8 3.582-8 8h16c0-4.418-3.582-8-8-8z"></path></svg>
                    </div>
                    <label class="block text-xl font-medium text-gray-800 mb-6 font-serif">Gender</label>
                    <div class="flex flex-wrap gap-3 mb-8">
                        <template x-for="g in ['Male', 'Female']">
                            <label class="flex items-center gap-2 border rounded-full px-5 py-2.5 cursor-pointer transition-all duration-300" :class="registerData.gender === g ? 'bg-rani-primary/5 border-rani-primary shadow-sm' : 'hover:bg-pink-50/50 border-gray-200'">
                                <input type="radio" x-model="registerData.gender" :value="g" class="hidden">
                                <div class="w-5 h-5 rounded-full border flex items-center justify-center transition-colors duration-300" :class="registerData.gender === g ? 'bg-rani-primary border-rani-primary' : 'border-gray-300 bg-gray-50'">
                                    <svg x-show="registerData.gender === g" class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                </div>
                                <span x-text="g" :class="registerData.gender === g ? 'text-rani-primary-dark font-medium' : 'text-gray-600'"></span>
                            </label>
                        </template>
                    </div>
                    <button :disabled="!registerData.gender" @click="registerStep = 3" class="w-full text-white font-bold text-lg py-3.5 rounded-full transition-all duration-300" :class="registerData.gender ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:shadow-lg transform hover:-translate-y-0.5 border border-rani-gold/50' : 'bg-gray-300 cursor-not-allowed'">Continue</button>
                </div>

                <!-- Step 3: Name -->
                <div x-show="registerStep === 3" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <div class="w-16 h-16 mx-auto bg-pink-50 rounded-full flex items-center justify-center mb-6 shadow-sm border border-pink-100">
                        <svg class="w-8 h-8 text-rani-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M12 4a4 4 0 100 8 4 4 0 000-8zm-7 14s1-4 7-4 7 4 7 4H5z"/></svg>
                    </div>
                    <label class="block text-xl font-medium text-gray-800 mb-6 font-serif" x-text="registerData.gender === 'Female' ? 'Her Name' : 'His Name'"></label>
                    <div class="space-y-5 mb-8">
                        <input type="text" x-model="registerData.first_name" placeholder="First Name" class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-rani-primary focus:border-transparent text-lg placeholder-gray-400 transition-shadow">
                        <input type="text" x-model="registerData.last_name" placeholder="Last Name" class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-rani-primary focus:border-transparent text-lg placeholder-gray-400 transition-shadow">
                    </div>
                    <button :disabled="!registerData.first_name || !registerData.last_name" @click="registerStep = 4" class="w-full text-white font-bold text-lg py-3.5 rounded-full transition-all duration-300" :class="(registerData.first_name && registerData.last_name) ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:shadow-lg transform hover:-translate-y-0.5 border border-rani-gold/50' : 'bg-gray-300 cursor-not-allowed'">Continue</button>
                </div>

                <!-- Step 4: DOB, Email & Mobile -->
                <div x-show="registerStep === 4" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <div class="w-16 h-16 mx-auto bg-pink-50 rounded-full flex items-center justify-center mb-4 shadow-sm border border-pink-100">
                        <svg class="w-8 h-8 text-rani-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 002 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2z"/></svg>
                    </div>
                    
                    <div class="space-y-4 mb-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-1 font-serif">Date of Birth</label>
                            <div class="flex gap-2">
                                <div class="w-1/3 relative border border-gray-300 rounded-xl focus-within:ring-2 focus-within:ring-rani-primary focus-within:border-transparent transition-all">
                                    <span class="absolute -top-2.5 left-2 bg-white px-1 text-[10px] text-rani-primary-dark font-medium">Day</span>
                                    <input type="tel" x-model="registerData.dob_day" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="DD" class="w-full px-2 py-3 bg-transparent rounded-xl text-center focus:outline-none text-base text-gray-800" maxlength="2">
                                </div>
                                <div class="w-1/3 relative border border-gray-300 rounded-xl focus-within:ring-2 focus-within:ring-rani-primary focus-within:border-transparent transition-all">
                                    <span class="absolute -top-2.5 left-2 bg-white px-1 text-[10px] text-rani-primary-dark font-medium">Month</span>
                                    <input type="tel" x-model="registerData.dob_month" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="MM" class="w-full px-2 py-3 bg-transparent rounded-xl text-center focus:outline-none text-base text-gray-800" maxlength="2">
                                </div>
                                <div class="w-1/3 relative border border-gray-300 rounded-xl focus-within:ring-2 focus-within:ring-rani-primary focus-within:border-transparent transition-all">
                                    <span class="absolute -top-2.5 left-2 bg-white px-1 text-[10px] text-rani-primary-dark font-medium">Year</span>
                                    <input type="tel" x-model="registerData.dob_year" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="YYYY" class="w-full px-2 py-3 bg-transparent rounded-xl text-center focus:outline-none text-base text-gray-800" maxlength="4">
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-1 font-serif">Email ID</label>
                            <input type="email" x-model="registerData.email" placeholder="Email Address" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-rani-primary focus:border-transparent text-base placeholder-gray-400 transition-shadow">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-800 mb-1 font-serif">Mobile Number</label>
                            <input type="tel" x-model="registerData.mobile" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="10-digit Mobile Number" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-rani-primary focus:border-transparent text-base placeholder-gray-400 transition-shadow" maxlength="10">
                        </div>
                    </div>
                    
                    <button :disabled="!(registerData.dob_day && registerData.dob_month && registerData.dob_year && registerData.mobile && registerData.email)" @click="sendRegistrationOtp()" class="w-full text-white font-bold text-lg py-3.5 rounded-full transition-all duration-300" :class="(registerData.dob_day && registerData.dob_month && registerData.dob_year && registerData.mobile && registerData.email) ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:shadow-lg transform hover:-translate-y-0.5 border border-rani-gold/50' : 'bg-gray-300 cursor-not-allowed'">Send OTP</button>
                </div>

                <!-- Step 5: OTP Verification -->
                <div x-show="registerStep === 5" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <div class="w-16 h-16 mx-auto bg-pink-50 rounded-full flex items-center justify-center mb-6 shadow-sm border border-pink-100">
                        <svg class="w-8 h-8 text-rani-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-xl font-medium text-gray-800 mb-2 font-serif text-center">Verify Mobile Number</h3>
                    <p class="text-sm text-gray-500 text-center mb-6">Enter the 4-digit code sent to <span class="font-bold text-gray-700" x-text="registerData.mobile"></span></p>
                    
                    <input type="tel" x-model="registerOtp" oninput="this.value = this.value.replace(/[^0-9]/g, '')" placeholder="4-digit OTP" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-rani-primary focus:border-transparent mb-8 text-center text-2xl tracking-[0.5em]" maxlength="4">
                    
                    <button :disabled="registerOtp.length !== 4" @click="verifyRegistrationOtp()" class="w-full text-white font-bold text-lg py-3.5 rounded-full transition-all duration-300" :class="registerOtp.length === 4 ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:shadow-lg transform hover:-translate-y-0.5 border border-rani-gold/50' : 'bg-gray-300 cursor-not-allowed'">Verify & Continue</button>
                </div>

                <!-- Step 6: Religion & Community -->
                <div x-show="registerStep === 6" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                    <div class="w-16 h-16 mx-auto bg-pink-50 rounded-full flex items-center justify-center mb-6 shadow-sm border border-pink-100">
                        <svg class="w-8 h-8 text-rani-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                    </div>
                    <label class="block text-xl font-medium text-gray-800 mb-6 font-serif" x-text="registerData.gender === 'Female' ? 'Her Religion & Community' : 'His Religion & Community'"></label>
                    
                    <div class="space-y-6 mb-8">
                        <!-- Searchable Religion -->
                        <div class="relative" x-data="{ 
                            open: false, search: '', 
                            options: ['Hindu', 'Muslim', 'Christian', 'Sikh', 'Jain', 'Buddhist', 'Parsi', 'Jewish', 'Spiritual', 'Other'],
                            get filteredOptions() { return this.options.filter(i => i.toLowerCase().includes(this.search.toLowerCase())) }
                        }" @click.away="open = false">
                            <label class="block text-sm font-medium text-gray-800 mb-1 font-serif">Religion</label>
                            <div @click="open = !open" class="w-full px-5 py-3 border border-gray-300 rounded-xl cursor-pointer flex justify-between items-center bg-white" :class="open ? 'ring-2 ring-rani-primary border-transparent' : ''">
                                <span x-text="registerData.religion || 'Select Religion'" :class="registerData.religion ? 'text-gray-800' : 'text-gray-400'"></span>
                                <svg class="h-5 w-5 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180 text-rani-primary' : ''" fill="currentColor" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                            <div x-show="open" style="display: none;" class="absolute z-20 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg">
                                <div class="p-2 border-b border-gray-100">
                                    <input type="text" x-model="search" placeholder="Search religion..." class="w-full px-3 py-2 bg-gray-50 rounded-lg focus:outline-none focus:ring-1 focus:ring-rani-primary text-sm">
                                </div>
                                <ul class="max-h-48 overflow-y-auto custom-scrollbar p-1">
                                    <template x-for="r in filteredOptions">
                                        <li @click="registerData.religion = r; open = false; search = '';" class="px-4 py-2 hover:bg-rani-primary/10 rounded-lg cursor-pointer text-gray-700 transition-colors" x-text="r"></li>
                                    </template>
                                    <li x-show="filteredOptions.length === 0" class="px-4 py-3 text-sm text-gray-500 text-center">No results found</li>
                                </ul>
                            </div>
                        </div>

                        <!-- Searchable Community -->
                        <div class="relative" x-data="{ 
                            open: false, search: '', 
                            options: ['Bengali', 'Punjabi', 'Gujarati', 'Marathi', 'Tamil', 'Telugu', 'Malayalam', 'Kannada', 'Hindi', 'Urdu', 'Sindhi', 'Marwari', 'Bihari', 'Oriya', 'Assamese'],
                            get filteredOptions() { return this.options.filter(i => i.toLowerCase().includes(this.search.toLowerCase())) }
                        }" @click.away="open = false">
                            <label class="block text-sm font-medium text-gray-800 mb-1 font-serif">Community / Mother Tongue</label>
                            <div @click="open = !open" class="w-full px-5 py-3 border border-gray-300 rounded-xl cursor-pointer flex justify-between items-center bg-white" :class="open ? 'ring-2 ring-rani-primary border-transparent' : ''">
                                <span x-text="registerData.community || 'Select Community'" :class="registerData.community ? 'text-gray-800' : 'text-gray-400'"></span>
                                <svg class="h-5 w-5 text-gray-400 transition-transform duration-200" :class="open ? 'rotate-180 text-rani-primary' : ''" fill="currentColor" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                            </div>
                            <div x-show="open" style="display: none;" class="absolute z-10 w-full mt-1 bg-white border border-gray-200 rounded-xl shadow-lg">
                                <div class="p-2 border-b border-gray-100">
                                    <input type="text" x-model="search" placeholder="Search community..." class="w-full px-3 py-2 bg-gray-50 rounded-lg focus:outline-none focus:ring-1 focus:ring-rani-primary text-sm">
                                </div>
                                <ul class="max-h-48 overflow-y-auto custom-scrollbar p-1">
                                    <template x-for="c in filteredOptions">
                                        <li @click="registerData.community = c; open = false; search = '';" class="px-4 py-2 hover:bg-rani-primary/10 rounded-lg cursor-pointer text-gray-700 transition-colors" x-text="c"></li>
                                    </template>
                                    <li x-show="filteredOptions.length === 0" class="px-4 py-3 text-sm text-gray-500 text-center">No results found</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <button :disabled="!(registerData.religion && registerData.community)" @click="registerCandidate()" class="w-full text-white font-bold text-lg py-3.5 rounded-full transition-all duration-300" :class="(registerData.religion && registerData.community) ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:shadow-lg transform hover:-translate-y-0.5 border border-rani-gold/50' : 'bg-gray-300 cursor-not-allowed'">Save & Continue to Profile</button>
                </div>
            </div>
        </div>
    </div>
    
    <style>
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: transparent;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background-color: #cbd5e1;
            border-radius: 10px;
        }
    </style>
</header>

<script>
    window.headerAuth = function() {
        return {
            scrolled: false,
            mobileMenuOpen: false,
            profileMenuOpen: false,
            showLogin: false,
            loginStep: 1,
            loginMobile: '',
            loginOtp1: '',
            loginOtp2: '',
            loginOtp3: '',
            loginOtp4: '',
            isSendingOtp: false,
            isVerifyingOtp: false,
            showRegister: false,
            registerStep: 1,
            registerOtp: '',
            registerData: {
                profile_for: '',
                gender: '',
                first_name: '',
                last_name: '',
                dob_day: '',
                dob_month: '',
                dob_year: '',
                email: '',
                mobile: '',
                religion: '',
                community: '',
                sub_community: '',
                country: 'India',
                state: '',
                city: '',
                marital_status: '',
                height: '',
                diet: '',
                highest_qualification: '',
                college_name: ''
            },
            authError: '',

            getLoginOtp() {
                return (this.loginOtp1 || '') + (this.loginOtp2 || '') + (this.loginOtp3 || '') + (this.loginOtp4 || '');
            },

            resetLoginOtp() {
                this.loginOtp1 = '';
                this.loginOtp2 = '';
                this.loginOtp3 = '';
                this.loginOtp4 = '';
                this.isVerifyingOtp = false;
            },

            openLoginModal() {
                this.showLogin = true;
                this.loginStep = 1;
                this.authError = '';
                this.resetLoginOtp();
            },

            openRegisterModal() {
                this.showRegister = true;
                this.registerStep = 1;
                this.authError = '';
            },

            sendOtp() {
                if (!this.loginMobile || this.loginMobile.length !== 10) {
                    this.authError = 'Please enter a valid 10-digit mobile number';
                    return;
                }
                this.authError = '';
                this.isSendingOtp = true;
                fetch('/api/send-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ mobile: this.loginMobile })
                })
                .then(res => res.json())
                .then(data => {
                    this.isSendingOtp = false;
                    if (data.success) {
                        this.loginStep = 2;
                        this.resetLoginOtp();
                        this.$nextTick(() => {
                            const firstInput = document.getElementById('login-otp-1');
                            if (firstInput) firstInput.focus();
                        });
                    } else {
                        this.authError = data.message || 'Failed to send OTP.';
                    }
                })
                .catch(err => {
                    this.isSendingOtp = false;
                    this.authError = 'Network error. Please try again.';
                });
            },

            handleOtpInput(index, event) {
                let val = event.target.value.replace(/[^0-9]/g, '');
                if (val.length > 1) {
                    val = val.slice(-1);
                }
                this['loginOtp' + index] = val;
                event.target.value = val;

                if (val && index < 4) {
                    const nextInput = document.getElementById('login-otp-' + (index + 1));
                    if (nextInput) {
                        nextInput.focus();
                        nextInput.select();
                    }
                }

                // Auto-verify as soon as 4 digits are entered
                const fullOtp = this.getLoginOtp();
                if (fullOtp.length === 4) {
                    this.verifyOtp();
                }
            },

            handleOtpKeydown(index, event) {
                if (event.key === 'Backspace') {
                    if (!this['loginOtp' + index] && index > 1) {
                        const prevInput = document.getElementById('login-otp-' + (index - 1));
                        if (prevInput) {
                            prevInput.focus();
                            this['loginOtp' + (index - 1)] = '';
                        }
                    } else {
                        this['loginOtp' + index] = '';
                    }
                } else if (event.key === 'ArrowLeft' && index > 1) {
                    const prevInput = document.getElementById('login-otp-' + (index - 1));
                    if (prevInput) prevInput.focus();
                } else if (event.key === 'ArrowRight' && index < 4) {
                    const nextInput = document.getElementById('login-otp-' + (index + 1));
                    if (nextInput) nextInput.focus();
                }
            },

            handleOtpPaste(event) {
                event.preventDefault();
                const clipboardData = (event.clipboardData || window.clipboardData).getData('text').trim().replace(/[^0-9]/g, '');
                if (clipboardData) {
                    const digits = clipboardData.slice(0, 4).split('');
                    digits.forEach((digit, i) => {
                        if (i < 4) {
                            this['loginOtp' + (i + 1)] = digit;
                            const el = document.getElementById('login-otp-' + (i + 1));
                            if (el) el.value = digit;
                        }
                    });
                    const targetIdx = Math.min(digits.length, 4);
                    const targetEl = document.getElementById('login-otp-' + targetIdx);
                    if (targetEl) targetEl.focus();

                    if (this.getLoginOtp().length === 4) {
                        this.verifyOtp();
                    }
                }
            },

            verifyOtp() {
                const otpCode = this.getLoginOtp();
                if (otpCode.length !== 4) {
                    this.authError = 'Please enter a valid 4-digit OTP';
                    return;
                }
                if (this.isVerifyingOtp) return;
                this.isVerifyingOtp = true;
                this.authError = '';

                fetch('/api/verify-otp', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ otp: otpCode })
                })
                .then(res => res.json())
                .then(data => {
                    this.isVerifyingOtp = false;
                    if (data.success) {
                        this.showLogin = false;
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Login Successful!',
                                text: 'Welcome to Rani Matrimonial. Redirecting to your dashboard...',
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true,
                                customClass: {
                                    popup: 'rani-swal-popup',
                                    title: 'rani-swal-title'
                                }
                            }).then(() => {
                                window.location.href = data.redirect || '{{ route("dashboard") }}';
                            });
                        } else {
                            window.location.href = data.redirect || '{{ route("dashboard") }}';
                        }
                    } else {
                        this.authError = data.message || 'Invalid OTP. Please try again.';
                        this.resetLoginOtp();
                        this.$nextTick(() => {
                            const firstInput = document.getElementById('login-otp-1');
                            if (firstInput) firstInput.focus();
                        });
                    }
                })
                .catch(err => {
                    this.isVerifyingOtp = false;
                    this.authError = 'Verification failed. Please try again.';
                    this.resetLoginOtp();
                });
            },

            sendRegistrationOtp() {
                this.authError = '';
                fetch('/api/send-registration-otp', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ mobile: this.registerData.mobile, email: this.registerData.email })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) { this.registerStep = 5; }
                    else { this.authError = data.message; }
                });
            },

            verifyRegistrationOtp() {
                this.authError = '';
                fetch('/api/verify-registration-otp', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify({ otp: this.registerOtp })
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) { this.registerStep = 6; }
                    else { this.authError = data.message; }
                });
            },

            registerCandidate() {
                this.authError = '';
                let dob = this.registerData.dob_year + '-' + this.registerData.dob_month + '-' + this.registerData.dob_day;
                let payload = { ...this.registerData, dob: dob };
                
                fetch('/api/register-phase-1', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                    body: JSON.stringify(payload)
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'success',
                                title: 'Registration Successful!',
                                text: 'Your account has been created. Redirecting...',
                                showConfirmButton: false,
                                timer: 1500,
                                timerProgressBar: true,
                                customClass: {
                                    popup: 'rani-swal-popup',
                                    title: 'rani-swal-title'
                                }
                            }).then(() => {
                                window.location.href = data.redirect;
                            });
                        } else {
                            window.location.href = data.redirect;
                        }
                    } else {
                        this.authError = data.message || 'Error occurred';
                    }
                });
            }
        };
    };

    document.addEventListener('alpine:init', () => {
        Alpine.data('headerAuth', window.headerAuth);
    });
</script>
