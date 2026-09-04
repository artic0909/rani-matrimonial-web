<!-- Alpine Modals for Profile Editing -->
<div x-show="editModalOpen" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center overflow-y-auto overflow-x-hidden bg-black/60 backdrop-blur-sm" x-transition.opacity>
    <div class="relative w-full max-w-2xl p-4 md:p-6 mx-auto my-8" @click.away="editModalOpen = false" x-transition.scale.origin.bottom>
        <!-- Modal content -->
        <div class="relative bg-white rounded-2xl shadow-2xl overflow-hidden">
            <!-- Header -->
            <div class="flex items-center justify-between p-5 border-b border-gray-100 bg-gray-50/50">
                <h3 class="text-xl font-bold font-serif text-rani-primary-dark" x-text="getModalTitle()"></h3>
                <button @click="editModalOpen = false" type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                </button>
            </div>
            
            <!-- Body -->
            <div class="p-6">
                <form @submit.prevent="submitForm">
                    
                    <!-- Basic Info -->
                    <div x-show="currentSection === 'basic'" class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">First Name</label>
                                <input type="text" x-model="formData.first_name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Last Name</label>
                                <input type="text" x-model="formData.last_name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Marital Status</label>
                                <select x-model="formData.marital_status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                                    <option value="Never Married">Never Married</option>
                                    <option value="Divorced">Divorced</option>
                                    <option value="Widowed">Widowed</option>
                                    <option value="Awaiting Divorce">Awaiting Divorce</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Diet</label>
                                <select x-model="formData.diet" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                                    <option value="Veg">Veg</option>
                                    <option value="Non-Veg">Non-Veg</option>
                                    <option value="Occasionally Non-Veg">Occasionally Non-Veg</option>
                                    <option value="Eggetarian">Eggetarian</option>
                                    <option value="Jain">Jain</option>
                                    <option value="Vegan">Vegan</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Height</label>
                            <input type="text" x-model="formData.height" placeholder="e.g. 5ft 8in" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">About Yourself</label>
                            <textarea x-model="formData.about_yourself" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary"></textarea>
                        </div>
                    </div>

                    <!-- Location -->
                    <div x-show="currentSection === 'location'" class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Country</label>
                                <input type="text" x-model="formData.country" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">State</label>
                                <input type="text" x-model="formData.state" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">City</label>
                                <input type="text" x-model="formData.city" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Residency Status</label>
                                <select x-model="formData.residency_status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                                    <option value="Citizen">Citizen</option>
                                    <option value="Permanent Resident">Permanent Resident</option>
                                    <option value="Work Permit">Work Permit</option>
                                    <option value="Student Visa">Student Visa</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Full Address</label>
                            <textarea x-model="formData.full_address" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary"></textarea>
                        </div>
                    </div>

                    <!-- Education & Career -->
                    <div x-show="currentSection === 'education_career'" class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Highest Qualification</label>
                                <input type="text" x-model="formData.highest_qualification" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">College Name</label>
                                <input type="text" x-model="formData.college_name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Profession</label>
                                <input type="text" x-model="formData.profession" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Designation</label>
                                <input type="text" x-model="formData.designation" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                                <input type="text" x-model="formData.company_name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Income Type</label>
                                <select x-model="formData.income_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                                    <option value="Salaried">Salaried</option>
                                    <option value="Business">Business</option>
                                    <option value="Not Working">Not Working</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Astro Details -->
                    <div x-show="currentSection === 'astro'" class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Manglik</label>
                                <select x-model="formData.manglik" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                                    <option value="No">No</option>
                                    <option value="Yes">Yes</option>
                                    <option value="Don't Know">Don't Know</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Star</label>
                                <input type="text" x-model="formData.star" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Time of Birth</label>
                                <input type="time" x-model="formData.time_of_birth" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">City of Birth</label>
                                <input type="text" x-model="formData.city_of_birth" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                            </div>
                        </div>
                    </div>

                    <!-- Family Details -->
                    <div x-show="currentSection === 'family'" class="space-y-4">
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Father's Status</label>
                                <input type="text" x-model="formData.fathers_status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Mother's Status</label>
                                <input type="text" x-model="formData.mothers_status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Brothers Count</label>
                                <input type="number" x-model="formData.brothers_count" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Sisters Count</label>
                                <input type="number" x-model="formData.sisters_count" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Family Location</label>
                            <input type="text" x-model="formData.family_location" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-rani-primary focus:border-rani-primary">
                        </div>
                    </div>

                    <!-- Footer -->
                    <div class="mt-8 flex items-center justify-end gap-3 border-t border-gray-100 pt-5">
                        <button type="button" @click="editModalOpen = false" class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-100">Cancel</button>
                        <button type="submit" class="text-white bg-rani-primary hover:bg-rani-primary-dark focus:ring-4 focus:outline-none focus:ring-rani-primary/30 font-medium rounded-lg text-sm px-6 py-2.5 text-center inline-flex items-center">
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
document.addEventListener('alpine:init', () => {
    Alpine.data('profileEditor', () => ({
        editModalOpen: false,
        currentSection: '',
        isSubmitting: false,
        profileImageUrl: '{{ $candidate->profile_picture ? asset('storage/' . $candidate->profile_picture) : "https://ui-avatars.com/api/?name=".urlencode($candidate->first_name)."&background=D4AF37&color=fff" }}',
        
        // Populate this from Blade or AJAX. For simplicity, we seed it with current blade values.
        formData: {
            first_name: @json($candidate->first_name),
            last_name: @json($candidate->last_name),
            marital_status: @json($candidate->marital_status),
            diet: @json($candidate->diet),
            height: @json($candidate->height),
            about_yourself: @json($candidate->about_yourself),
            
            country: @json($candidate->country),
            state: @json($candidate->state),
            city: @json($candidate->city),
            residency_status: @json($candidate->residency_status),
            full_address: @json($candidate->full_address),
            
            highest_qualification: @json($candidate->highest_qualification),
            college_name: @json($candidate->college_name),
            profession: @json($candidate->profession),
            designation: @json($candidate->designation),
            company_name: @json($candidate->company_name),
            income_type: @json($candidate->income_type),
            
            manglik: @json($candidate->manglik),
            star: @json($candidate->star),
            time_of_birth: @json($candidate->time_of_birth),
            city_of_birth: @json($candidate->city_of_birth),
            
            fathers_status: @json($candidate->father_profession),
            mothers_status: @json($candidate->mother_profession),
            brothers_count: @json($candidate->brothers_count),
            sisters_count: @json($candidate->sisters_count),
            family_location: @json($candidate->family_location),
        },

        openModal(section) {
            this.currentSection = section;
            this.editModalOpen = true;
        },

        getModalTitle() {
            const titles = {
                'basic': 'Edit Basic Info & Lifestyle',
                'location': 'Edit Location Details',
                'education_career': 'Edit Education & Career',
                'astro': 'Edit Astro Details',
                'family': 'Edit Family Details'
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
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        section: this.currentSection,
                        ...this.formData
                    })
                });
                
                const result = await response.json();
                if(result.success) {
                    this.editModalOpen = false;
                    // Reload page to reflect changes instantly everywhere (cleanest approach for now)
                    window.location.reload();
                } else {
                    alert(result.message || 'Error updating profile');
                }
            } catch (error) {
                console.error('Fetch Error:', error);
                alert('An error occurred.');
            }
            this.isSubmitting = false;
        },

        async uploadProfilePicture(event) {
            const file = event.target.files[0];
            if (!file) return;
            
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
                } else {
                    alert(result.message || 'Error uploading picture');
                }
            } catch (error) {
                console.error('Fetch Error:', error);
                alert('An error occurred while uploading.');
            }
        }
    }));
});
</script>
