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
    <div x-show="showLogin" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-2xl p-8 max-w-sm w-full mx-4">
            <h2 class="text-2xl font-serif font-bold text-rani-primary-dark mb-6 text-center" x-text="loginStep === 1 ? 'Login' : 'Enter OTP'"></h2>
            
            <div x-show="authError" class="mb-4 text-sm text-red-600 bg-red-50 p-2 rounded text-center" x-text="authError"></div>

            <!-- Step 1: Mobile -->
            <div x-show="loginStep === 1">
                <label class="block text-sm font-medium text-gray-700 mb-2">Mobile Number</label>
                <input type="text" x-model="loginMobile" placeholder="10-digit number" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-rani-gold mb-6" maxlength="10">
                <button @click="sendOtp()" class="w-full bg-rani-primary text-white font-bold py-2 rounded-md hover:bg-rani-primary-dark transition-colors">Continue</button>
            </div>

            <!-- Step 2: OTP -->
            <div x-show="loginStep === 2" style="display: none;">
                <label class="block text-sm font-medium text-gray-700 mb-2">OTP Code</label>
                <input type="text" x-model="loginOtp" placeholder="4-digit OTP" class="w-full px-4 py-2 border rounded-md focus:outline-none focus:ring-2 focus:ring-rani-gold mb-6" maxlength="4">
                <button @click="verifyOtp()" class="w-full bg-rani-primary text-white font-bold py-2 rounded-md hover:bg-rani-primary-dark transition-colors">Verify & Login</button>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div x-show="showRegister" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/60 backdrop-blur-sm">
        <div class="bg-white rounded-xl shadow-2xl p-8 max-w-md w-full mx-4">
            <h2 class="text-2xl font-serif font-bold text-rani-primary-dark mb-6 text-center">Registration</h2>

            <div x-show="authError" class="mb-4 text-sm text-red-600 bg-red-50 p-2 rounded text-center" x-text="authError"></div>

            <!-- Step 1: Profile For -->
            <div x-show="registerStep === 1">
                <label class="block text-lg font-medium text-gray-700 mb-4">This Profile is for</label>
                <div class="flex flex-wrap gap-3 mb-6">
                    <template x-for="type in ['Myself', 'My Son', 'My Daughter', 'My Brother', 'My Sister', 'My Friend', 'My Relative']">
                        <label class="flex items-center gap-2 border rounded-full px-4 py-2 cursor-pointer transition-colors" :class="registerData.profile_for === type ? 'bg-rani-primary/10 border-rani-primary' : 'hover:bg-gray-50'">
                            <input type="radio" x-model="registerData.profile_for" :value="type" class="hidden">
                            <span x-text="type" :class="registerData.profile_for === type ? 'text-rani-primary font-medium' : 'text-gray-600'"></span>
                        </label>
                    </template>
                </div>
                <button @click="if(registerData.profile_for) registerStep = 2" class="w-full bg-cyan-500 text-white font-bold py-3 rounded-full hover:bg-cyan-600 transition-colors">Continue</button>
            </div>

            <!-- Step 2: Gender -->
            <div x-show="registerStep === 2" style="display: none;">
                <label class="block text-lg font-medium text-gray-700 mb-4">Gender</label>
                <div class="flex flex-wrap gap-3 mb-6">
                    <template x-for="g in ['Male', 'Female']">
                        <label class="flex items-center gap-2 border rounded-full px-4 py-2 cursor-pointer transition-colors" :class="registerData.gender === g ? 'bg-rani-primary/10 border-rani-primary' : 'hover:bg-gray-50'">
                            <input type="radio" x-model="registerData.gender" :value="g" class="hidden">
                            <span x-text="g" :class="registerData.gender === g ? 'text-rani-primary font-medium' : 'text-gray-600'"></span>
                        </label>
                    </template>
                </div>
                <button @click="if(registerData.gender) registerStep = 3" class="w-full bg-cyan-500 text-white font-bold py-3 rounded-full hover:bg-cyan-600 transition-colors">Continue</button>
            </div>

            <!-- Step 3: Name -->
            <div x-show="registerStep === 3" style="display: none;">
                <label class="block text-lg font-medium text-gray-700 mb-4">Name</label>
                <div class="space-y-4 mb-6">
                    <input type="text" x-model="registerData.first_name" placeholder="First name" class="w-full px-4 py-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-rani-primary">
                    <input type="text" x-model="registerData.last_name" placeholder="Last name" class="w-full px-4 py-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-rani-primary">
                </div>
                <button @click="if(registerData.first_name && registerData.last_name) registerStep = 4" class="w-full bg-cyan-500 text-white font-bold py-3 rounded-full hover:bg-cyan-600 transition-colors">Continue</button>
            </div>

            <!-- Step 4: DOB & Mobile -->
            <div x-show="registerStep === 4" style="display: none;">
                <label class="block text-lg font-medium text-gray-700 mb-4">Date of birth & Mobile</label>
                <div class="flex gap-2 mb-4">
                    <input type="text" x-model="registerData.dob_day" placeholder="DD" class="w-1/3 px-4 py-3 border rounded-md text-center focus:outline-none focus:ring-2 focus:ring-rani-primary" maxlength="2">
                    <input type="text" x-model="registerData.dob_month" placeholder="MM" class="w-1/3 px-4 py-3 border rounded-md text-center focus:outline-none focus:ring-2 focus:ring-rani-primary" maxlength="2">
                    <input type="text" x-model="registerData.dob_year" placeholder="YYYY" class="w-1/3 px-4 py-3 border rounded-md text-center focus:outline-none focus:ring-2 focus:ring-rani-primary" maxlength="4">
                </div>
                <input type="text" x-model="registerData.mobile" placeholder="10-digit Mobile Number" class="w-full px-4 py-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-rani-primary mb-6" maxlength="10">
                <button @click="if(registerData.dob_day && registerData.dob_month && registerData.dob_year && registerData.mobile) registerStep = 5" class="w-full bg-cyan-500 text-white font-bold py-3 rounded-full hover:bg-cyan-600 transition-colors">Continue</button>
            </div>

            <!-- Step 5: Religion -->
            <div x-show="registerStep === 5" style="display: none;">
                <label class="block text-lg font-medium text-gray-700 mb-4">Religion</label>
                <select x-model="registerData.religion" class="w-full px-4 py-3 border rounded-md focus:outline-none focus:ring-2 focus:ring-rani-primary mb-6 appearance-none">
                    <option value="">Select Religion</option>
                    <option>Hindu</option>
                    <option>Muslim</option>
                    <option>Christian</option>
                    <option>Sikh</option>
                    <option>Jain</option>
                    <option>Buddhist</option>
                    <option>Parsi</option>
                </select>
                <button @click="if(registerData.religion) registerCandidate()" class="w-full bg-cyan-500 text-white font-bold py-3 rounded-full hover:bg-cyan-600 transition-colors">Complete Registration</button>
            </div>
            
            <div class="mt-6 p-3 border border-orange-200 bg-orange-50 text-orange-700 text-xs rounded-md flex gap-2">
                <span class="font-bold border border-orange-500 rounded-full w-4 h-4 flex items-center justify-center shrink-0">i</span>
                <p>Shaadi.com is built for genuine match-seekers. Any falsification, commercial use or marriage bureaus is strictly prohibited & may be reported to law enforcement.</p>
            </div>
        </div>
    </div>
</header>
