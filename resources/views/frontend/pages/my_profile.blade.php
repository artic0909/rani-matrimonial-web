@extends('frontend.layouts.auth_app')

@section('title', 'My Profile | Ranimatrimonial')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    
    <!-- Top Profile Header Card -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden mb-8">
        <div class="p-6 md:p-8 flex flex-col md:flex-row items-center md:items-start gap-6 md:gap-8 bg-gradient-to-r from-rani-light to-white">
            <!-- Avatar -->
            <div class="relative shrink-0">
                <img src="{{ $candidate->profile_picture ? asset('storage/' . $candidate->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($candidate->first_name).'&background=D4AF37&color=fff' }}" 
                     alt="{{ $candidate->first_name }}" 
                     class="w-32 h-32 md:w-40 md:h-40 rounded-full border-4 border-white shadow-md object-cover">
                @if($candidate->selfie_verified)
                    <div class="absolute bottom-2 right-2 bg-green-500 text-white rounded-full p-1.5 border-2 border-white shadow-md" title="Selfie Verified">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                @endif
            </div>
            
            <!-- Summary Info -->
            <div class="flex-1 text-center md:text-left">
                <div class="flex flex-col md:flex-row md:justify-between md:items-start gap-4">
                    <div>
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 font-serif mb-1">{{ $candidate->first_name }} {{ $candidate->last_name }} <span class="text-gray-400 font-sans text-lg font-normal ml-2">(RANI{{ str_pad($candidate->id, 6, '0', STR_PAD_LEFT) }})</span></h1>
                        <p class="text-sm text-gray-500 mb-4">{{ $candidate->profile_for === 'Myself' ? 'Profile created by Self' : 'Profile created by ' . $candidate->profile_for }}</p>
                        
                        <div class="grid grid-cols-2 gap-x-8 gap-y-2 text-sm text-gray-700">
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-rani-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                <span>{{ $age ? $age . ' yrs' : 'Age Not Specified' }}{{ $candidate->height ? ', ' . $candidate->height : '' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-rani-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                                <span>{{ $candidate->religion }}{{ $candidate->community ? ', ' . $candidate->community : '' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-rani-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                                <span>{{ $candidate->marital_status ?: 'Not Specified' }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <svg class="w-4 h-4 text-rani-gold shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                <span>{{ $candidate->city ? $candidate->city . ', ' : '' }}{{ $candidate->state ?: 'Location Not Specified' }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="flex gap-3 justify-center md:justify-end mt-4 md:mt-0 w-full md:w-auto">
                        <button class="bg-white border border-gray-200 text-gray-700 px-4 py-2 rounded-lg text-sm font-medium hover:bg-gray-50 transition shadow-sm">Manage Photos</button>
                        <button class="bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white px-6 py-2 rounded-lg text-sm font-bold shadow-sm hover:shadow-md transition transform hover:-translate-y-0.5">Edit Profile</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Content Sections -->
    <div class="space-y-6">
            
            <!-- Personality & About -->
            <div class="bg-white rounded-xl shadow-sm border-t-4 border-rani-gold overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800 text-lg">Personality, Family Details, Career, etc.</h3>
                    <button class="text-rani-primary text-sm font-medium hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6">
                    <p class="text-gray-600 leading-relaxed">
                        {{ $candidate->about_yourself ?: 'No description provided yet. Write something about yourself to attract better matches!' }}
                    </p>
                </div>
            </div>

            <!-- Basics & Lifestyle -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800 text-lg">Basics & Lifestyle</h3>
                    <button class="text-rani-primary text-sm font-medium hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Age</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $age ?: 'Not Specified' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Diet</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->diet ?: 'Not Specified' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Date of Birth</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->dob ? \Carbon\Carbon::parse($candidate->dob)->format('d-M-Y') : 'Not Specified' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Blood Group</div>
                        <div class="col-span-2 text-sm text-gray-800">@if($candidate->blood_group) {{ $candidate->blood_group }} @else <a href="#" class="text-rani-primary hover:underline">Add Now</a> @endif</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Marital Status</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->marital_status ?: 'Not Specified' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Health Info</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->health_info ?: 'Not Specified' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Height</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->height ?: 'Not Specified' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Grew up in</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->grew_up_in ?: 'Not Specified' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Disability</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->disability ?: 'None' }}</div>
                    </div>
                </div>
            </div>

            <!-- Religious Background -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800 text-lg">Religious Background</h3>
                    <button class="text-rani-primary text-sm font-medium hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Religion</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->religion ?: 'Not Specified' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Sub Community</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->sub_community ?: 'Not Specified' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Community</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->community ?: 'Not Specified' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Gothra / Gotram</div>
                        <div class="col-span-2 text-sm text-gray-800">@if($candidate->gothra) {{ $candidate->gothra }} @else <a href="#" class="text-rani-primary hover:underline">Add Now</a> @endif</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Mother Tongue</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->mother_tongue ?: 'Not Specified' }}</div>
                    </div>
                </div>
            </div>

            <!-- Astro Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800 text-lg">Astro Details</h3>
                    <button class="text-rani-primary text-sm font-medium hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Manglik</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->manglik ?: 'Don\'t Know' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Time of Birth</div>
                        <div class="col-span-2 text-sm text-gray-800">@if($candidate->time_of_birth) {{ $candidate->time_of_birth }} @else <a href="#" class="text-rani-primary hover:underline">Add Now</a> @endif</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">City of Birth</div>
                        <div class="col-span-2 text-sm text-gray-800">@if($candidate->city_of_birth) {{ $candidate->city_of_birth }} @else <a href="#" class="text-rani-primary hover:underline">Add Now</a> @endif</div>
                    </div>
                </div>
            </div>

            <!-- Family Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800 text-lg">Family Details</h3>
                    <button class="text-rani-primary text-sm font-medium hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Father's Details</div>
                        <div class="col-span-2 text-sm text-gray-800">@if($candidate->father_profession) {{ $candidate->father_profession }} @else <a href="#" class="text-rani-primary hover:underline">Add Now</a> @endif</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Mother's Details</div>
                        <div class="col-span-2 text-sm text-gray-800">@if($candidate->mother_profession) {{ $candidate->mother_profession }} @else <a href="#" class="text-rani-primary hover:underline">Add Now</a> @endif</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Family Location</div>
                        <div class="col-span-2 text-sm text-gray-800">@if($candidate->family_location) {{ $candidate->family_location }} @else <a href="#" class="text-rani-primary hover:underline">Add Now</a> @endif</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">No. of Brothers</div>
                        <div class="col-span-2 text-sm text-gray-800">@if($candidate->brothers_count !== null) {{ $candidate->brothers_count }} @else <a href="#" class="text-rani-primary hover:underline">Add Now</a> @endif</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">No. of Sisters</div>
                        <div class="col-span-2 text-sm text-gray-800">@if($candidate->sisters_count !== null) {{ $candidate->sisters_count }} @else <a href="#" class="text-rani-primary hover:underline">Add Now</a> @endif</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Financial Status</div>
                        <div class="col-span-2 text-sm text-gray-800">@if($candidate->family_financial_status) {{ $candidate->family_financial_status }} @else <a href="#" class="text-rani-primary hover:underline">Add Now</a> @endif</div>
                    </div>
                </div>
            </div>

            <!-- Education & Career -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800 text-lg">Education & Career</h3>
                    <button class="text-rani-primary text-sm font-medium hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Highest Qual.</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->highest_qualification ?: 'Not Specified' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Working With</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->working_with ?: 'Not Specified' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">College(s)</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->college_name ?: 'Not Specified' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Working As</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->designation ?: 'Not Specified' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Annual Income</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->annual_income ?: 'Not Specified' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Employer</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->company_name ?: 'Not Specified' }}</div>
                    </div>
                </div>
            </div>

            <!-- Location -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800 text-lg">Location</h3>
                    <button class="text-rani-primary text-sm font-medium hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Current City</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->city ?: 'Not Specified' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Residency Status</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->residency_status ?: 'Citizen' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">State</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->state ?: 'Not Specified' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Zip / Pin code</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->zip_code ?: 'Not Specified' }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Country</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->country ?: 'India' }}</div>
                    </div>
                </div>
            </div>
            


            <!-- Contact Details Settings -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                    <h3 class="font-bold text-gray-800 text-lg">My Contact Detail</h3>
                    <button class="text-rani-primary text-sm font-medium hover:underline flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Mobile</div>
                        <div class="col-span-2 text-sm text-gray-800">+91-{{ $candidate->mobile }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium">Display Option</div>
                        <div class="col-span-2 text-sm text-gray-800">{{ $candidate->contact_display_option ?: 'Premium Members Only' }}</div>
                    </div>
                </div>
            </div>
            
            <div class="text-left">
                <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })" class="text-rani-primary text-sm font-medium hover:underline inline-flex items-center gap-1">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    Back to Top
                </button>
            </div>
        </div>
</div>
@endsection
