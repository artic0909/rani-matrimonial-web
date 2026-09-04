<!-- Alpine Modals for Profile Editing -->
<div x-show="editModalOpen" 
     style="display: none;" 
     class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden bg-black/60 backdrop-blur-sm p-4" 
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @keydown.escape.window="editModalOpen = false">
     
    <div class="relative w-full max-w-2xl mx-auto my-auto" 
         @click.away="editModalOpen = false" 
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
         x-transition:leave-end="opacity-0 translate-y-4 sm:scale-95">
        
        <!-- Modal Card -->
        <div class="relative bg-white rounded-2xl shadow-2xl overflow-hidden border border-rani-gold/20">
            <!-- Top Gradient Accent -->
            <div class="h-1.5 w-full bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold"></div>
            
            <!-- Header -->
            <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100 bg-gray-50/70">
                <h3 class="text-xl font-bold font-serif text-rani-primary-dark tracking-wide" x-text="getModalTitle()"></h3>
                <button @click="editModalOpen = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-full text-sm w-8 h-8 inline-flex justify-center items-center transition-colors">
                    <svg class="w-3.5 h-3.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
            
            <!-- Form Body -->
            <div class="p-6 max-h-[75vh] overflow-y-auto">
                <form @submit.prevent="submitForm">
                    
                    <!-- 1. About Yourself -->
                    <div x-show="currentSection === 'about'" class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">About Yourself</label>
                            <p class="text-xs text-gray-500 mb-2">Write a brief introduction describing your background, family values, and lifestyle.</p>
                            <textarea x-model="formData.about_yourself" rows="6" placeholder="Describe your personality, hobbies, background..." class="w-full border border-gray-300 rounded-xl px-4 py-3 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all"></textarea>
                        </div>
                    </div>

                    <!-- 2. Basics & Lifestyle -->
                    <div x-show="currentSection === 'basic'" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">First Name</label>
                                <input type="text" x-model="formData.first_name" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Last Name</label>
                                <input type="text" x-model="formData.last_name" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Marital Status</label>
                                <select x-model="formData.marital_status" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                                    <option value="">Select Marital Status</option>
                                    <option value="Never Married">Never Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Awaiting Divorce">Awaiting Divorce</option>
                                    <option value="Annulled">Annulled</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Diet</label>
                                <select x-model="formData.diet" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                                    <option value="">Select Diet</option>
                                    <option value="Veg">Veg</option>
                                    <option value="Non-Veg">Non-Veg</option>
                                    <option value="Occasionally Non-Veg">Occasionally Non-Veg</option>
                                    <option value="Eggetarian">Eggetarian</option>
                                    <option value="Jain">Jain</option>
                                    <option value="Vegan">Vegan</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Height</label>
                                <select x-model="formData.height" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                                    <option value="">Select Height</option>
                                    <option value="4ft 6in / 137 cm">4ft 6in / 137 cm</option>
                                    <option value="4ft 7in / 139 cm">4ft 7in / 139 cm</option>
                                    <option value="4ft 8in / 142 cm">4ft 8in / 142 cm</option>
                                    <option value="4ft 9in / 144 cm">4ft 9in / 144 cm</option>
                                    <option value="4ft 10in / 147 cm">4ft 10in / 147 cm</option>
                                    <option value="4ft 11in / 149 cm">4ft 11in / 149 cm</option>
                                    <option value="5ft 0in / 152 cm">5ft 0in / 152 cm</option>
                                    <option value="5ft 1in / 154 cm">5ft 1in / 154 cm</option>
                                    <option value="5ft 2in / 157 cm">5ft 2in / 157 cm</option>
                                    <option value="5ft 3in / 160 cm">5ft 3in / 160 cm</option>
                                    <option value="5ft 4in / 162 cm">5ft 4in / 162 cm</option>
                                    <option value="5ft 5in / 165 cm">5ft 5in / 165 cm</option>
                                    <option value="5ft 6in / 167 cm">5ft 6in / 167 cm</option>
                                    <option value="5ft 7in / 170 cm">5ft 7in / 170 cm</option>
                                    <option value="5ft 8in / 172 cm">5ft 8in / 172 cm</option>
                                    <option value="5ft 9in / 175 cm">5ft 9in / 175 cm</option>
                                    <option value="5ft 10in / 177 cm">5ft 10in / 177 cm</option>
                                    <option value="5ft 11in / 180 cm">5ft 11in / 180 cm</option>
                                    <option value="6ft 0in / 182 cm">6ft 0in / 182 cm</option>
                                    <option value="6ft 1in / 185 cm">6ft 1in / 185 cm</option>
                                    <option value="6ft 2in / 187 cm">6ft 2in / 187 cm</option>
                                    <option value="6ft 3in / 190 cm">6ft 3in / 190 cm</option>
                                    <option value="6ft 4in / 193 cm">6ft 4in / 193 cm</option>
                                    <option value="6ft 5in / 195 cm">6ft 5in / 195 cm</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Blood Group</label>
                                <select x-model="formData.blood_group" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                                    <option value="">Select Blood Group</option>
                                    <option value="A+">A+</option>
                                    <option value="A-">A-</option>
                                    <option value="B+">B+</option>
                                    <option value="B-">B-</option>
                                    <option value="AB+">AB+</option>
                                    <option value="AB-">AB-</option>
                                    <option value="O+">O+</option>
                                    <option value="O-">O-</option>
                                    <option value="Don't Know">Don't Know</option>
                                </select>
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Grew Up In</label>
                                <input type="text" x-model="formData.grew_up_in" placeholder="e.g. Kolkata, India" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Disability</label>
                                <select x-model="formData.disability" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                                    <option value="None">None</option>
                                    <option value="Physical Disability">Physical Disability</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Health Info</label>
                            <input type="text" x-model="formData.health_info" placeholder="e.g. Normal, No health issues" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                        </div>
                    </div>

                    <!-- 3. Religious Background -->
                    <div x-show="currentSection === 'religious'" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Religion</label>
                                <select x-model="formData.religion" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                                    <option value="">Select Religion</option>
                                    <option value="Hindu">Hindu</option>
                                    <option value="Muslim">Muslim</option>
                                    <option value="Christian">Christian</option>
                                    <option value="Sikh">Sikh</option>
                                    <option value="Jain">Jain</option>
                                    <option value="Buddhist">Buddhist</option>
                                    <option value="Parsi">Parsi</option>
                                    <option value="Jewish">Jewish</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Community / Caste</label>
                                <input type="text" x-model="formData.community" placeholder="e.g. Brahmin, Agarwal, Rajput" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Sub Community</label>
                                <input type="text" x-model="formData.sub_community" placeholder="e.g. Kulin, Deshastha" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Gothra / Gotram</label>
                                <input type="text" x-model="formData.gothra" placeholder="e.g. Kashyap, Bharadwaj" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Mother Tongue</label>
                            <input type="text" x-model="formData.mother_tongue" placeholder="e.g. Bengali, Hindi, English, Punjabi" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                        </div>
                    </div>

                    <!-- 4. Astro Details -->
                    <div x-show="currentSection === 'astro'" class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Manglik Status</label>
                            <select x-model="formData.manglik" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                                <option value="Don't Know">Don't Know</option>
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                                <option value="Anshik Manglik">Anshik Manglik</option>
                            </select>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Time of Birth</label>
                                <input type="time" x-model="formData.time_of_birth" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">City of Birth</label>
                                <input type="text" x-model="formData.city_of_birth" placeholder="e.g. Kolkata, West Bengal" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                            </div>
                        </div>
                    </div>

                    <!-- 5. Family Details -->
                    <div x-show="currentSection === 'family'" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Father's Status / Occupation</label>
                                <input type="text" x-model="formData.father_profession" placeholder="e.g. Businessman, Retired Officer" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Mother's Status / Occupation</label>
                                <input type="text" x-model="formData.mother_profession" placeholder="e.g. Homemaker, Teacher" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">No. of Brothers</label>
                                <input type="number" min="0" max="20" x-model="formData.brothers_count" placeholder="0" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">No. of Sisters</label>
                                <input type="number" min="0" max="20" x-model="formData.sisters_count" placeholder="0" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Family Location</label>
                                <input type="text" x-model="formData.family_location" placeholder="e.g. Kolkata, West Bengal" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Financial Status</label>
                                <select x-model="formData.family_financial_status" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                                    <option value="">Select Status</option>
                                    <option value="Middle Class">Middle Class</option>
                                    <option value="Upper Middle Class">Upper Middle Class</option>
                                    <option value="Rich / Affluent">Rich / Affluent</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- 6. Education & Career -->
                    <div x-show="currentSection === 'education_career'" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Highest Qualification</label>
                                <input type="text" x-model="formData.highest_qualification" placeholder="e.g. B.Tech, MBA, MBBS" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">College / Institute Name</label>
                                <input type="text" x-model="formData.college_name" placeholder="e.g. IIT Delhi, St. Xavier's" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Working With</label>
                                <select x-model="formData.working_with" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                                    <option value="">Select Working Sector</option>
                                    <option value="Private Company">Private Company</option>
                                    <option value="Government / Public Sector">Government / Public Sector</option>
                                    <option value="Defense / Civil Services">Defense / Civil Services</option>
                                    <option value="Business / Self Employed">Business / Self Employed</option>
                                    <option value="Non Working">Non Working</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Profession / Job Role</label>
                                <input type="text" x-model="formData.profession" placeholder="e.g. Software Engineer, Doctor, CA" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Designation</label>
                                <input type="text" x-model="formData.designation" placeholder="e.g. Senior Consultant, Manager" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Employer / Company Name</label>
                                <input type="text" x-model="formData.company_name" placeholder="e.g. TCS, Google, Private Ltd" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Annual Income</label>
                            <select x-model="formData.annual_income" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                                <option value="">Select Annual Income</option>
                                <option value="Below 2 Lakhs">Below 2 Lakhs</option>
                                <option value="2 - 4 Lakhs">2 - 4 Lakhs</option>
                                <option value="4 - 7 Lakhs">4 - 7 Lakhs</option>
                                <option value="7 - 10 Lakhs">7 - 10 Lakhs</option>
                                <option value="10 - 15 Lakhs">10 - 15 Lakhs</option>
                                <option value="15 - 20 Lakhs">15 - 20 Lakhs</option>
                                <option value="20 - 30 Lakhs">20 - 30 Lakhs</option>
                                <option value="30 - 50 Lakhs">30 - 50 Lakhs</option>
                                <option value="50 Lakhs - 1 Crore">50 Lakhs - 1 Crore</option>
                                <option value="Above 1 Crore">Above 1 Crore</option>
                            </select>
                        </div>
                    </div>

                    <!-- 7. Location -->
                    <div x-show="currentSection === 'location'" class="space-y-4">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Country</label>
                                <input type="text" x-model="formData.country" placeholder="e.g. India" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">State</label>
                                <input type="text" x-model="formData.state" placeholder="e.g. West Bengal" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                            </div>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">City</label>
                                <input type="text" x-model="formData.city" placeholder="e.g. Kolkata" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Zip / Pin Code</label>
                                <input type="text" x-model="formData.zip_code" placeholder="e.g. 700001" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-700 mb-1.5">Residency Status</label>
                                <select x-model="formData.residency_status" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                                    <option value="Citizen">Citizen</option>
                                    <option value="Permanent Resident">Permanent Resident</option>
                                    <option value="Work Permit">Work Permit</option>
                                    <option value="Student Visa">Student Visa</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Full Address</label>
                            <textarea x-model="formData.full_address" rows="3" placeholder="Enter residential address" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all"></textarea>
                        </div>
                    </div>

                    <!-- 8. Contact Details -->
                    <div x-show="currentSection === 'contact'" class="space-y-4">
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-1.5">Contact Privacy & Display Option</label>
                            <select x-model="formData.contact_display_option" class="w-full border border-gray-300 rounded-xl px-4 py-2.5 focus:ring-2 focus:ring-rani-primary/20 focus:border-rani-primary text-gray-800 transition-all">
                                <option value="Visible to all Premium Members">Visible to all Premium Members</option>
                                <option value="Visible only after I accept connection">Visible only after I accept connection</option>
                                <option value="Hide my contact details from all">Hide my contact details from all</option>
                            </select>
                        </div>
                        <p class="text-xs text-gray-500">Note: To update your primary registered mobile number or email address, please contact customer support for security verification.</p>
                    </div>

                    <!-- Footer Action Buttons -->
                    <div class="mt-8 flex items-center justify-end gap-3 border-t border-gray-100 pt-5">
                        <button type="button" @click="editModalOpen = false" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-xl hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-gray-200 transition-all">Cancel</button>
                        <button type="submit" :disabled="isSubmitting" class="text-white bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary focus:ring-4 focus:outline-none focus:ring-rani-primary/30 font-semibold rounded-xl text-sm px-7 py-2.5 text-center inline-flex items-center shadow-md hover:shadow-lg transition-all disabled:opacity-50">
                            <span x-show="!isSubmitting">Save Changes</span>
                            <span x-show="isSubmitting" class="flex items-center gap-2">
                                <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                Saving...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
window.profileEditor = function() {
    return {
        editModalOpen: false,
        currentSection: '',
        isSubmitting: false,
        isUploadingPhoto: false,
        profileImageUrl: '{{ $candidate->profile_picture ? asset('storage/' . $candidate->profile_picture) : "https://ui-avatars.com/api/?name=".urlencode($candidate->first_name)."&background=D4AF37&color=fff" }}',
        
        formData: {
            // Personality
            about_yourself: @json($candidate->about_yourself ?? ''),
            
            // Basics
            first_name: @json($candidate->first_name ?? ''),
            last_name: @json($candidate->last_name ?? ''),
            marital_status: @json($candidate->marital_status ?? ''),
            diet: @json($candidate->diet ?? ''),
            height: @json($candidate->height ?? ''),
            blood_group: @json($candidate->blood_group ?? ''),
            health_info: @json($candidate->health_info ?? ''),
            grew_up_in: @json($candidate->grew_up_in ?? ''),
            disability: @json($candidate->disability ?? 'None'),
            
            // Religious
            religion: @json($candidate->religion ?? ''),
            community: @json($candidate->community ?? ''),
            sub_community: @json($candidate->sub_community ?? ''),
            gothra: @json($candidate->gothra ?? ''),
            mother_tongue: @json($candidate->mother_tongue ?? ''),
            
            // Astro
            manglik: @json($candidate->manglik ?? "Don't Know"),
            time_of_birth: @json($candidate->time_of_birth ?? ''),
            city_of_birth: @json($candidate->city_of_birth ?? ''),
            
            // Family
            father_profession: @json($candidate->father_profession ?? ''),
            mother_profession: @json($candidate->mother_profession ?? ''),
            brothers_count: @json($candidate->brothers_count ?? ''),
            sisters_count: @json($candidate->sisters_count ?? ''),
            family_location: @json($candidate->family_location ?? ''),
            family_financial_status: @json($candidate->family_financial_status ?? ''),
            
            // Education & Career
            highest_qualification: @json($candidate->highest_qualification ?? ''),
            college_name: @json($candidate->college_name ?? ''),
            working_with: @json($candidate->working_with ?? ''),
            profession: @json($candidate->profession ?? ''),
            designation: @json($candidate->designation ?? ''),
            company_name: @json($candidate->company_name ?? ''),
            annual_income: @json($candidate->annual_income ?? ''),
            
            // Location
            country: @json($candidate->country ?? 'India'),
            state: @json($candidate->state ?? ''),
            city: @json($candidate->city ?? ''),
            zip_code: @json($candidate->zip_code ?? ''),
            residency_status: @json($candidate->residency_status ?? 'Citizen'),
            full_address: @json($candidate->full_address ?? ''),

            // Contact
            contact_display_option: @json($candidate->contact_display_option ?? 'Visible to all Premium Members'),
        },

        openModal(section) {
            this.currentSection = section;
            this.editModalOpen = true;
        },

        getModalTitle() {
            const titles = {
                'about': 'Edit Personality & About',
                'basic': 'Edit Basics & Lifestyle',
                'religious': 'Edit Religious Background',
                'astro': 'Edit Astro Details',
                'family': 'Edit Family Details',
                'education_career': 'Edit Education & Career',
                'location': 'Edit Location Details',
                'contact': 'Edit Contact Settings'
            };
            return titles[this.currentSection] || 'Edit Profile';
        },

        async submitForm() {
            this.isSubmitting = true;
            try {
                const response = await fetch('{{ route("profile.update") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        section: this.currentSection,
                        ...this.formData
                    })
                });
                
                const result = await response.json();
                if(result.success) {
                    this.editModalOpen = false;
                    Swal.fire({
                        icon: 'success',
                        title: 'Profile Updated!',
                        text: result.message || 'Your details have been saved successfully.',
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    const errorMsg = result.message || (result.errors ? Object.values(result.errors).flat().join('<br>') : 'Error updating profile');
                    Swal.fire({
                        icon: 'error',
                        title: 'Update Failed',
                        html: errorMsg,
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    });
                }
            } catch (error) {
                console.error('Fetch Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'An error occurred while saving profile. Please try again.',
                    customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                });
            } finally {
                this.isSubmitting = false;
            }
        },

        async uploadProfilePicture(event) {
            const file = event.target.files[0];
            if (!file) return;
            
            if (file.size > 15 * 1024 * 1024) {
                Swal.fire({
                    icon: 'warning',
                    title: 'File Too Large',
                    text: 'Profile picture must be under 15MB.',
                    customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                });
                return;
            }

            this.isUploadingPhoto = true;
            const formData = new FormData();
            formData.append('profile_picture', file);
            
            try {
                const response = await fetch('{{ route("profile.upload-photo") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                });
                
                const result = await response.json();
                if(result.success) {
                    this.profileImageUrl = result.image_url;
                    Swal.fire({
                        icon: 'success',
                        title: 'Photo Uploaded!',
                        text: result.message || 'Profile picture updated successfully.',
                        timer: 2000,
                        showConfirmButton: false,
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    });
                } else {
                    const errorMsg = result.message || (result.errors ? Object.values(result.errors).flat().join('<br>') : 'Error uploading picture');
                    Swal.fire({
                        icon: 'error',
                        title: 'Upload Failed',
                        html: errorMsg,
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    });
                }
            } catch (error) {
                console.error('Fetch Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Upload Error',
                    text: 'An error occurred while uploading picture.',
                    customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                });
            } finally {
                this.isUploadingPhoto = false;
            }
        }
    };
};

// Register for Alpine in both cases
if (window.Alpine) {
    Alpine.data('profileEditor', window.profileEditor);
} else {
    document.addEventListener('alpine:init', () => {
        Alpine.data('profileEditor', window.profileEditor);
    });
}
</script>
