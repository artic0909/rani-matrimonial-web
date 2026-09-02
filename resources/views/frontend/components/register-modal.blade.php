<div x-data="{ 
        isOpen: false, 
        step: 1,
        formData: {
            profile_for: '', gender: '', first_name: '', middle_name: '', last_name: '', dob_day: '', dob_month: '', dob_year: '', religion: '', community: '', living_in: '', email: '', mobile: ''
        },
        openModal() {
            this.isOpen = true;
            this.step = 1;
            document.body.style.overflow = 'hidden';
        },
        closeModal() {
            this.isOpen = false;
            document.body.style.overflow = 'auto';
        },
        nextStep() { if(this.step < 4) this.step++; },
        prevStep() { if(this.step > 1) this.step--; },
        setProfileFor(val) {
            this.formData.profile_for = val;
            // The request says: 'all are selectable on select below show gender Male & female , after select this go next step automatic'
            // So selecting profile_for does NOT auto advance. It shows gender below. 
        },
        setGenderAndNext(val) {
            this.formData.gender = val;
            // After selecting gender, it auto advances.
            setTimeout(() => this.nextStep(), 300);
        },
        submitPhase1() {
            // Reformat DOB
            if(this.formData.dob_year && this.formData.dob_month && this.formData.dob_day) {
                const dob = `${this.formData.dob_year}-${this.formData.dob_month}-${this.formData.dob_day}`;
                $refs.dobHidden.value = dob;
            }
            $refs.phase1Form.submit();
        }
    }" 
    @open-register-modal.window="openModal()"
    x-show="isOpen" 
    class="fixed inset-0 z-50 overflow-y-auto" 
    style="display: none;"
    x-transition.opacity>
    
    <!-- Backdrop -->
    <div class="fixed inset-0 bg-black/50 backdrop-blur-sm" @click="closeModal()"></div>
    
    <!-- Modal Container -->
    <div class="relative min-h-screen flex items-center justify-center p-4">
        <div class="bg-white w-full max-w-lg rounded-[30px] shadow-2xl overflow-hidden transform transition-all p-8 relative"
             @click.stop
             x-show="isOpen" 
             x-transition:enter="ease-out duration-300" 
             x-transition:enter-start="opacity-0 translate-y-8" 
             x-transition:enter-end="opacity-100 translate-y-0" 
             x-transition:leave="ease-in duration-200" 
             x-transition:leave-start="opacity-100 translate-y-0" 
             x-transition:leave-end="opacity-0 translate-y-8">
             
            <!-- Header -->
            <div class="text-center relative mb-8">
                <button type="button" @click="prevStep()" x-show="step > 1" class="absolute left-0 top-1 text-gray-400 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                </button>
                <button type="button" @click="closeModal()" class="absolute right-0 top-1 text-gray-400 hover:text-gray-700">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
                
                <h3 class="text-2xl font-serif font-bold text-[#5C0A0A]">Registration</h3>
                <p class="text-xs text-gray-500 mt-1">Step <span x-text="step"></span> of 14</p>
            </div>

            <!-- Form Body -->
            <div>
                <form x-ref="phase1Form" action="{{ route('register.step1') }}" method="POST">
                    @csrf
                    
                    <input type="hidden" name="profile_for" x-model="formData.profile_for">
                    <input type="hidden" name="gender" x-model="formData.gender">
                    <input type="hidden" name="first_name" x-model="formData.first_name">
                    <input type="hidden" name="middle_name" x-model="formData.middle_name">
                    <input type="hidden" name="last_name" x-model="formData.last_name">
                    <input type="hidden" name="dob" x-ref="dobHidden">
                    <input type="hidden" name="religion" x-model="formData.religion">
                    <input type="hidden" name="community" x-model="formData.community">
                    <input type="hidden" name="living_in" x-model="formData.living_in">
                    <input type="hidden" name="email" x-model="formData.email">
                    <input type="hidden" name="mobile" x-model="formData.mobile">

                    <!-- Step 1: Profile For & Gender -->
                    <div x-show="step === 1" x-transition.opacity>
                        
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            </div>
                        </div>

                        <h4 class="text-sm text-gray-600 mb-3 text-center">This Profile is for</h4>
                        <div class="flex flex-wrap justify-center gap-3 mb-6">
                            <template x-for="type in ['Myself', 'My Son', 'My Daughter', 'My Brother', 'My Sister', 'My Friend']">
                                <button type="button" @click="setProfileFor(type)" 
                                        :class="formData.profile_for === type ? 'border-[#5C0A0A] bg-[#5C0A0A] text-white font-medium' : 'border-gray-200 text-gray-600 hover:border-[#5C0A0A] hover:text-[#5C0A0A]'"
                                        class="py-2 px-5 rounded-full border text-sm transition-all duration-200 shadow-sm">
                                    <span x-text="type"></span>
                                </button>
                            </template>
                        </div>
                        
                        <!-- Show Gender only after profile_for is selected -->
                        <div x-show="formData.profile_for !== ''" x-transition.opacity>
                            <h4 class="text-sm text-gray-600 mb-3 text-center mt-6 border-t pt-6">Gender</h4>
                            <div class="flex justify-center gap-4">
                                <button type="button" @click="setGenderAndNext('Male')" 
                                    :class="formData.gender === 'Male' ? 'border-[#5C0A0A] bg-red-50' : 'border-gray-200 hover:border-[#5C0A0A] hover:bg-gray-50'"
                                    class="w-32 py-3 rounded-xl border-2 flex flex-col items-center justify-center transition-all duration-200">
                                    <span class="text-2xl mb-1">👨</span>
                                    <span class="text-sm font-medium text-gray-700">Male</span>
                                </button>
                                <button type="button" @click="setGenderAndNext('Female')" 
                                    :class="formData.gender === 'Female' ? 'border-[#5C0A0A] bg-red-50' : 'border-gray-200 hover:border-[#5C0A0A] hover:bg-gray-50'"
                                    class="w-32 py-3 rounded-xl border-2 flex flex-col items-center justify-center transition-all duration-200">
                                    <span class="text-2xl mb-1">👩</span>
                                    <span class="text-sm font-medium text-gray-700">Female</span>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Step 2: Personal Info -->
                    <div x-show="step === 2" x-transition.opacity style="display: none;">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"></path></svg>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">First Name</label>
                                <input type="text" x-model="formData.first_name" required class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                            </div>
                            
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Middle Name (Optional)</label>
                                <input type="text" x-model="formData.middle_name" class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                            </div>

                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Last Name</label>
                                <input type="text" x-model="formData.last_name" required class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                            </div>
                            
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Date of Birth</label>
                                <div class="grid grid-cols-3 gap-3">
                                    <input type="text" x-model="formData.dob_day" placeholder="DD" maxlength="2" class="w-full px-4 py-3 rounded-lg bg-white border border-gray-300 focus:ring-2 focus:ring-[#5C0A0A] focus:border-transparent outline-none text-center">
                                    <input type="text" x-model="formData.dob_month" placeholder="MM" maxlength="2" class="w-full px-4 py-3 rounded-lg bg-white border border-gray-300 focus:ring-2 focus:ring-[#5C0A0A] focus:border-transparent outline-none text-center">
                                    <input type="text" x-model="formData.dob_year" placeholder="YYYY" maxlength="4" class="w-full px-4 py-3 rounded-lg bg-white border border-gray-300 focus:ring-2 focus:ring-[#5C0A0A] focus:border-transparent outline-none text-center">
                                </div>
                            </div>
                        </div>

                        <div class="mt-8">
                            <button type="button" @click="nextStep" class="w-full bg-[#5C0A0A] hover:bg-red-900 text-white font-semibold py-3.5 rounded-full shadow-md transition-all text-center">
                                Continue
                            </button>
                        </div>
                    </div>

                    <!-- Step 3: Religion -->
                    <div x-show="step === 3" x-transition.opacity style="display: none;">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            </div>
                        </div>

                        <div class="space-y-4">
                            <!-- In a real scenario, these would be custom searchable selects (e.g. using TomSelect or custom Alpine logic). Using standard select for demo as requested -->
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Your Religion</label>
                                <select x-model="formData.religion" class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                                    <option value="" disabled>Select Religion</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Muslim">Muslim</option>
                                    <option value="Christian">Christian</option>
                                    <option value="Sikh">Sikh</option>
                                    <option value="Jain">Jain</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Community</label>
                                <select x-model="formData.community" class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                                    <option value="" disabled>Select Community</option>
                                    <option value="Brahmin">Brahmin</option>
                                    <option value="Rajput">Rajput</option>
                                    <option value="Baniya">Baniya</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Living In</label>
                                <select x-model="formData.living_in" class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                                    <option value="" disabled>Select Country</option>
                                    <option value="India">India</option>
                                    <option value="USA">USA</option>
                                    <option value="UK">UK</option>
                                    <option value="Canada">Canada</option>
                                </select>
                            </div>
                        </div>

                        <div class="mt-8">
                            <button type="button" @click="nextStep" class="w-full bg-[#5C0A0A] hover:bg-red-900 text-white font-semibold py-3.5 rounded-full shadow-md transition-all text-center">
                                Continue
                            </button>
                        </div>
                    </div>

                    <!-- Step 4: Security (Email & Phone) -->
                    <div x-show="step === 4" x-transition.opacity style="display: none;">
                        <div class="flex justify-center mb-6">
                            <div class="w-16 h-16 bg-red-50 rounded-full flex items-center justify-center text-[#5C0A0A]">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                            </div>
                        </div>
                        
                        <div class="space-y-4">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Email ID</label>
                                <input type="email" x-model="formData.email" required placeholder="name@example.com" class="w-full px-4 py-3 rounded-lg bg-[#EAF1FF] border-0 focus:ring-2 focus:ring-[#5C0A0A] outline-none">
                            </div>
                            
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Mobile Number</label>
                                <input type="tel" x-model="formData.mobile" required placeholder="10-digit mobile number" class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-2 focus:ring-[#5C0A0A] focus:border-transparent outline-none">
                            </div>
                        </div>

                        <div class="mt-8">
                            <button type="button" @click="submitPhase1" class="w-full bg-[#5C0A0A] hover:bg-red-900 text-white font-semibold py-3.5 rounded-full shadow-md transition-all text-center">
                                Save & Continue
                            </button>
                        </div>
                    </div>

                </form>

                <div class="mt-6 text-center text-xs text-gray-500 flex items-center justify-center gap-1">
                    <svg class="w-4 h-4 text-[#5C0A0A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Ranimatrimonial.com is built for genuine match-seekers.
                </div>
            </div>
        </div>
    </div>
</div>
