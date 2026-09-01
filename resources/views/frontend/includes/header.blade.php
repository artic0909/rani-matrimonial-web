<header x-data="{ 
    scrolled: false, 
    mobileMenuOpen: false,
    showLogin: false,
    loginStep: 1,
    loginMobile: '',
    loginOtp: '',
    showRegister: false,
    registerStep: 1,
    registerData: { profile_for: '', gender: '', first_name: '', last_name: '', dob_day: '', dob_month: '', dob_year: '', religion: '', mobile: '' },
    authError: '',
    
    sendOtp() {
        this.authError = '';
        fetch('/api/send-otp', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ mobile: this.loginMobile })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) { this.loginStep = 2; }
            else { this.authError = data.message; }
        });
    },

    verifyOtp() {
        this.authError = '';
        fetch('/api/verify-otp', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify({ otp: this.loginOtp })
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) { window.location.href = data.redirect; }
            else { this.authError = data.message; }
        });
    },

    registerCandidate() {
        this.authError = '';
        let dob = this.registerData.dob_year + '-' + this.registerData.dob_month + '-' + this.registerData.dob_day;
        let payload = { ...this.registerData, dob: dob };
        
        fetch('/api/register', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(data => {
            if(data.success) { window.location.href = data.redirect; }
            else { this.authError = data.message || 'Error occurred'; }
        });
    }
}" @scroll.window="scrolled = (window.pageYOffset > 20)" 
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
            <nav class="hidden md:flex space-x-8 items-center">
                <a href="#" class="font-serif text-base transition-colors hover:text-rani-gold font-medium" :class="{ 'text-rani-primary-dark': scrolled, 'text-rani-light': !scrolled }">About</a>
                <a href="#" class="font-serif text-base transition-colors hover:text-rani-gold font-medium" :class="{ 'text-rani-primary-dark': scrolled, 'text-rani-light': !scrolled }">Help</a>
                <a href="#" class="font-serif text-base transition-colors hover:text-rani-gold font-medium" :class="{ 'text-rani-primary-dark': scrolled, 'text-rani-light': !scrolled }">Success Stories</a>
            </nav>

            <!-- Auth Buttons -->
            <div class="hidden md:flex items-center space-x-4">
                <a href="#" @click.prevent="showLogin = true" class="font-medium text-sm transition-colors" :class="{ 'text-rani-primary hover:text-rani-gold': scrolled, 'text-rani-light hover:text-rani-gold': !scrolled }">Log in</a>
                <a href="#" @click.prevent="showRegister = true" class="px-6 py-2 rounded-full text-sm font-semibold transition-all duration-300 shadow-md hover:shadow-lg transform hover:-translate-y-0.5 border border-rani-gold text-white bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary">
                    Register Now
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
            <a href="#" class="block px-3 py-3 rounded-md text-base font-serif font-medium text-rani-primary-dark hover:bg-rani-primary/5 hover:text-rani-primary">About</a>
            <a href="#" class="block px-3 py-3 rounded-md text-base font-serif font-medium text-rani-primary-dark hover:bg-rani-primary/5 hover:text-rani-primary">Help</a>
            <a href="#" class="block px-3 py-3 rounded-md text-base font-serif font-medium text-rani-primary-dark hover:bg-rani-primary/5 hover:text-rani-primary">Success Stories</a>
            <div class="mt-4 pt-4 border-t border-rani-gold/30 flex flex-col gap-3">
                <a href="#" @click.prevent="showLogin = true" class="block w-full text-center px-4 py-2 text-base font-medium text-rani-primary">Log in</a>
                <a href="#" @click.prevent="showRegister = true" class="block w-full text-center px-4 py-2 border border-rani-gold rounded-full shadow-sm text-base font-medium text-white bg-gradient-to-r from-rani-primary to-rani-primary-dark">Register Now</a>
            </div>
        </div>
    </div>

    <!-- Login Modal -->
    <div x-show="showLogin" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 p-4">
        <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 max-w-sm w-full relative transform transition-all max-h-full flex flex-col">
            <!-- Modal Header with Back & Close icons -->
            <div class="flex justify-between items-center mb-6 shrink-0">
                <button @click="loginStep = 1" x-show="loginStep > 1" type="button" class="text-gray-400 hover:text-rani-primary transition-colors p-1 -ml-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <div x-show="loginStep === 1" class="w-8"></div> <!-- Spacer when back button is hidden -->
                
                <h2 class="text-2xl font-serif font-bold text-rani-primary-dark text-center flex-1" x-text="loginStep === 1 ? 'Login' : 'Enter OTP'"></h2>
                
                <button @click="showLogin = false; loginStep = 1; authError = '';" type="button" class="text-gray-400 hover:text-red-500 transition-colors p-1 -mr-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            
            <div class="overflow-y-auto custom-scrollbar flex-1 -mx-2 px-2">
                <div x-show="authError" class="mb-5 text-sm text-red-600 bg-red-50 p-3 rounded-lg text-center border border-red-100" x-text="authError"></div>

            <!-- Step 1: Mobile -->
            <div x-show="loginStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <label class="block text-sm font-medium text-gray-600 mb-2">Mobile Number</label>
                <input type="text" x-model="loginMobile" placeholder="10-digit number" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-rani-primary focus:border-transparent mb-6 text-lg tracking-wider" maxlength="10">
                <button @click="sendOtp()" class="w-full bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white font-bold text-lg py-3 rounded-xl hover:shadow-lg transform transition hover:-translate-y-0.5">Continue</button>
            </div>

            <!-- Step 2: OTP -->
            <div x-show="loginStep === 2" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <label class="block text-sm font-medium text-gray-600 mb-2">OTP Code</label>
                <input type="text" x-model="loginOtp" placeholder="4-digit OTP" class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-rani-primary focus:border-transparent mb-6 text-center text-2xl tracking-[0.5em]" maxlength="4">
                <button @click="verifyOtp()" class="w-full bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white font-bold text-lg py-3 rounded-xl hover:shadow-lg transform transition hover:-translate-y-0.5">Verify & Login</button>
            </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div x-show="showRegister" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/70 p-4">
        <div class="bg-white rounded-2xl shadow-2xl p-6 md:p-8 max-w-md w-full relative transform transition-all max-h-full flex flex-col">
            <!-- Modal Header with Back & Close icons -->
            <div class="flex justify-between items-center mb-4 md:mb-6 border-b pb-4 border-gray-100 shrink-0">
                <button @click="registerStep--" x-show="registerStep > 1" type="button" class="text-gray-400 hover:text-rani-primary transition-colors p-1 -ml-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <div x-show="registerStep === 1" class="w-8"></div>
                
                <div class="flex-1 text-center">
                    <h2 class="text-xl font-serif font-bold text-rani-primary-dark">Registration</h2>
                    <div class="text-xs text-gray-400 mt-1" x-text="`Step ${registerStep} of 5`"></div>
                </div>
                
                <button @click="showRegister = false; registerStep = 1; authError = '';" type="button" class="text-gray-400 hover:text-red-500 transition-colors p-1 -mr-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>

            <div class="overflow-y-auto custom-scrollbar flex-1 -mx-2 px-2 pb-2">
                <div x-show="authError" class="mb-5 text-sm text-red-600 bg-red-50 p-3 rounded-lg text-center border border-red-100" x-text="authError"></div>

            <!-- Step 1: Profile For -->
            <div x-show="registerStep === 1" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <!-- Eye-catchy icon top -->
                <div class="w-16 h-16 mx-auto bg-pink-50 rounded-full flex items-center justify-center mb-6 shadow-sm border border-pink-100">
                    <svg class="w-8 h-8 text-rani-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
                </div>
                <label class="block text-xl font-medium text-gray-800 mb-6 font-serif">This Profile is for</label>
                <div class="flex flex-wrap gap-3 mb-8">
                    <template x-for="type in ['Myself', 'My Son', 'My Daughter', 'My Brother', 'My Sister', 'My Friend', 'My Relative']">
                        <label class="flex items-center gap-2 border rounded-full px-5 py-2.5 cursor-pointer transition-all duration-300" :class="registerData.profile_for === type ? 'bg-rani-primary/5 border-rani-primary shadow-sm' : 'hover:bg-pink-50/50 border-gray-200'">
                            <input type="radio" x-model="registerData.profile_for" :value="type" class="hidden">
                            <!-- Custom Radio Checkmark -->
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
                    <!-- Male/Female icon combined -->
                    <svg class="w-8 h-8 text-rani-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zM12 14c-4.418 0-8 3.582-8 8h16c0-4.418-3.582-8-8-8z"></path></svg>
                </div>
                <label class="block text-xl font-medium text-gray-800 mb-6 font-serif">Gender</label>
                <div class="flex flex-wrap gap-3 mb-8">
                    <template x-for="g in ['Male', 'Female']">
                        <label class="flex items-center gap-2 border rounded-full px-5 py-2.5 cursor-pointer transition-all duration-300" :class="registerData.gender === g ? 'bg-rani-primary/5 border-rani-primary shadow-sm' : 'hover:bg-pink-50/50 border-gray-200'">
                            <input type="radio" x-model="registerData.gender" :value="g" class="hidden">
                            <!-- Custom Radio Checkmark -->
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

            <!-- Step 4: DOB & Mobile -->
            <div x-show="registerStep === 4" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <div class="w-16 h-16 mx-auto bg-pink-50 rounded-full flex items-center justify-center mb-6 shadow-sm border border-pink-100">
                    <svg class="w-8 h-8 text-rani-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20a2 2 0 002 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2z"/></svg>
                </div>
                <label class="block text-xl font-medium text-gray-800 mb-6 font-serif">Date of Birth</label>
                <div class="flex gap-4 mb-6">
                    <div class="w-1/3 relative border border-gray-300 rounded-xl focus-within:ring-2 focus-within:ring-rani-primary focus-within:border-transparent transition-all">
                        <span class="absolute -top-2.5 left-3 bg-white px-1 text-xs text-rani-primary-dark font-medium">Day</span>
                        <input type="text" x-model="registerData.dob_day" placeholder="DD" class="w-full px-4 py-3 bg-transparent rounded-xl text-center focus:outline-none text-lg text-gray-800" maxlength="2">
                    </div>
                    <div class="w-1/3 relative border border-gray-300 rounded-xl focus-within:ring-2 focus-within:ring-rani-primary focus-within:border-transparent transition-all">
                        <span class="absolute -top-2.5 left-3 bg-white px-1 text-xs text-rani-primary-dark font-medium">Month</span>
                        <input type="text" x-model="registerData.dob_month" placeholder="MM" class="w-full px-4 py-3 bg-transparent rounded-xl text-center focus:outline-none text-lg text-gray-800" maxlength="2">
                    </div>
                    <div class="w-1/3 relative border border-gray-300 rounded-xl focus-within:ring-2 focus-within:ring-rani-primary focus-within:border-transparent transition-all">
                        <span class="absolute -top-2.5 left-3 bg-white px-1 text-xs text-rani-primary-dark font-medium">Year</span>
                        <input type="text" x-model="registerData.dob_year" placeholder="YYYY" class="w-full px-4 py-3 bg-transparent rounded-xl text-center focus:outline-none text-lg text-gray-800" maxlength="4">
                    </div>
                </div>
                <label class="block text-xl font-medium text-gray-800 mb-6 mt-6 font-serif">Mobile Number</label>
                <input type="text" x-model="registerData.mobile" placeholder="10-digit Mobile Number" class="w-full px-5 py-3 border border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-rani-primary focus:border-transparent text-lg placeholder-gray-400 mb-8 transition-shadow" maxlength="10">
                <button :disabled="!(registerData.dob_day && registerData.dob_month && registerData.dob_year && registerData.mobile)" @click="registerStep = 5" class="w-full text-white font-bold text-lg py-3.5 rounded-full transition-all duration-300" :class="(registerData.dob_day && registerData.dob_month && registerData.dob_year && registerData.mobile) ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:shadow-lg transform hover:-translate-y-0.5 border border-rani-gold/50' : 'bg-gray-300 cursor-not-allowed'">Continue</button>
            </div>

            <!-- Step 5: Religion -->
            <div x-show="registerStep === 5" style="display: none;" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-4" x-transition:enter-end="opacity-100 translate-x-0">
                <div class="w-16 h-16 mx-auto bg-pink-50 rounded-full flex items-center justify-center mb-6 shadow-sm border border-pink-100">
                    <svg class="w-8 h-8 text-rani-primary" fill="currentColor" viewBox="0 0 24 24"><path d="M16 11c1.66 0 2.99-1.34 2.99-3S17.66 5 16 5c-1.66 0-3 1.34-3 3s1.34 3 3 3zm-8 0c1.66 0 2.99-1.34 2.99-3S9.66 5 8 5C6.34 5 5 6.34 5 8s1.34 3 3 3zm0 2c-2.33 0-7 1.17-7 3.5V19h14v-2.5c0-2.33-4.67-3.5-7-3.5zm8 0c-.29 0-.62.02-.97.05 1.16.84 1.97 1.97 1.97 3.45V19h6v-2.5c0-2.33-4.67-3.5-7-3.5z"/></svg>
                </div>
                <label class="block text-xl font-medium text-gray-800 mb-6 font-serif" x-text="registerData.gender === 'Female' ? 'Her Religion' : 'His Religion'"></label>
                
                <div class="relative border border-gray-300 rounded-xl mb-8 group focus-within:ring-2 focus-within:ring-rani-primary focus-within:border-transparent transition-all bg-white">
                    <span class="absolute -top-2.5 left-3 bg-white px-2 text-xs font-semibold text-rani-primary-dark">Religion</span>
                    <select x-model="registerData.religion" class="w-full px-5 py-4 bg-transparent focus:outline-none appearance-none text-lg text-gray-800 cursor-pointer">
                        <option value="">Select Religion</option>
                        <option>Hindu</option>
                        <option>Muslim</option>
                        <option>Christian</option>
                        <option>Sikh</option>
                        <option>Jain</option>
                        <option>Buddhist</option>
                        <option>Parsi</option>
                    </select>
                    <!-- Custom Arrow -->
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-400 group-hover:text-rani-primary transition-colors">
                        <svg class="fill-current h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>

                <button :disabled="!registerData.religion" @click="registerCandidate()" class="w-full text-white font-bold text-lg py-3.5 rounded-full transition-all duration-300" :class="registerData.religion ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:shadow-lg transform hover:-translate-y-0.5 border border-rani-gold/50' : 'bg-gray-300 cursor-not-allowed'">Complete Registration</button>
            </div>
            
            <div class="mt-8 p-4 bg-rani-light/50 border border-rani-gold/30 rounded-xl flex gap-3 shadow-sm">
                <span class="font-bold border border-rani-gold text-rani-primary-dark rounded-full w-5 h-5 flex items-center justify-center shrink-0 text-xs mt-0.5 bg-white">i</span>
                <p class="leading-relaxed text-sm text-gray-700">Ranimatrimonial.com is built for genuine match-seekers. Any falsification, commercial use or marriage bureaus is strictly prohibited & may be reported to law enforcement.</p>
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
