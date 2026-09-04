@extends('frontend.layouts.auth_app')

@section('title', 'My Profile | Ranimatrimonial')

@section('content')
<div class="relative pt-8 pb-20">
    <!-- Background Image -->
    <div class="fixed inset-0 z-0 bg-cover bg-top bg-no-repeat" style="background-image: url('{{ asset('img/hero.png') }}');"></div>
    
    <!-- Maroon/Gold Gradient Overlay (Reduced Opacity) -->
    <div class="fixed inset-0 z-0 bg-gradient-to-t from-rani-dark/80 via-rani-primary-dark/40 to-rani-primary-dark/20"></div>
    
    <!-- Floating Sweet Gestures (Hearts) -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none heart-container opacity-50">
        <div class="heart-floating delay-1"></div>
        <div class="heart-floating heart-maroon delay-2"></div>
        <div class="heart-floating delay-3"></div>
        <div class="heart-floating heart-maroon delay-4"></div>
        <div class="heart-floating delay-5"></div>
        <div class="heart-floating heart-maroon delay-1" style="left: 20%; animation-delay: 7s;"></div>
        <div class="heart-floating delay-2" style="left: 40%; animation-delay: 9s;"></div>
        <div class="heart-floating heart-maroon delay-3" style="left: 60%; animation-delay: 2s;"></div>
        <div class="heart-floating delay-4" style="left: 80%; animation-delay: 14s;"></div>
    </div>

<div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Top Profile Header Card -->
    <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl border border-white/60 mb-10 p-6 md:p-10 relative overflow-hidden z-10 hover:shadow-rani-gold/10 transition-shadow duration-500">
        <!-- Subtle royal accent top -->
        <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-90"></div>
        
        <div class="flex flex-col md:flex-row items-center gap-8 md:gap-12">
            <!-- Avatar -->
            <div class="relative shrink-0 group">
                <div class="absolute inset-0 bg-rani-gold rounded-full blur-md opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                <img src="{{ $candidate->profile_picture ? asset('storage/' . $candidate->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($candidate->first_name).'&background=D4AF37&color=fff' }}" 
                     alt="{{ $candidate->first_name }}" 
                     class="w-36 h-36 md:w-44 md:h-44 rounded-full border-[6px] border-white shadow-xl object-cover bg-white relative z-10 transform group-hover:scale-[1.02] transition-transform duration-300">
                @if($candidate->selfie_verified)
                    <div class="absolute bottom-3 right-3 bg-green-500 text-white rounded-full p-2 border-2 border-white shadow-lg z-20" title="Selfie Verified">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                    </div>
                @endif
            </div>
            
            <!-- Summary Info -->
            <div class="flex-1 text-center md:text-left flex flex-col md:flex-row items-center md:items-stretch justify-between w-full gap-8">
                <div class="flex flex-col justify-center items-center md:items-start space-y-2.5">
                    <h1 class="text-3xl md:text-4xl font-bold text-rani-primary-dark font-serif tracking-wide drop-shadow-sm">{{ $candidate->first_name }} {{ $candidate->last_name }}</h1>
                    <div class="text-sm md:text-base text-gray-500 font-medium font-sans mb-1 uppercase tracking-wider">(RANI{{ str_pad($candidate->id, 6, '0', STR_PAD_LEFT) }})</div>
                    <p class="text-xs text-rani-gold-dark font-semibold bg-rani-light/30 px-3 py-1 rounded-full mb-4">{{ $candidate->profile_for === 'Myself' ? 'Profile created by Self' : 'Profile created by ' . $candidate->profile_for }}</p>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-3.5 text-sm text-gray-700 font-medium w-full max-w-md mt-2">
                        <div class="flex items-center gap-2.5 justify-center md:justify-start">
                            <div class="p-1.5 bg-gray-50 rounded-md text-rani-gold border border-gray-100"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></div>
                            <span>{{ $age ? $age . ' yrs' : 'Age Not Specified' }}{{ $candidate->height ? ', ' . $candidate->height : '' }}</span>
                        </div>
                        <div class="flex items-center gap-2.5 justify-center md:justify-start">
                            <div class="p-1.5 bg-gray-50 rounded-md text-rani-gold border border-gray-100"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg></div>
                            <span>{{ $candidate->religion }}{{ $candidate->community ? ', ' . $candidate->community : '' }}</span>
                        </div>
                        <div class="flex items-center gap-2.5 justify-center md:justify-start">
                            <div class="p-1.5 bg-gray-50 rounded-md text-rani-gold border border-gray-100"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg></div>
                            <span>{{ $candidate->marital_status ?: 'Not Specified' }}</span>
                        </div>
                        <div class="flex items-center gap-2.5 justify-center md:justify-start">
                            <div class="p-1.5 bg-gray-50 rounded-md text-rani-gold border border-gray-100"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg></div>
                            <span>{{ $candidate->city ? $candidate->city . ', ' : '' }}{{ $candidate->state ?: 'Location Not Specified' }}</span>
                        </div>
                    </div>
                </div>
                
                <div class="flex gap-4 items-stretch h-full mt-6 md:mt-0 w-full md:w-auto shrink-0 justify-center">
                    <button class="bg-white border border-gray-200 text-gray-700 px-6 py-6 md:py-10 rounded-xl text-sm font-bold hover:bg-gray-50 hover:border-gray-300 transition-all shadow-sm w-36 flex items-center justify-center text-center">Manage Photos</button>
                    <button class="bg-gradient-to-br from-rani-primary-dark to-rani-primary text-white px-6 py-6 md:py-10 rounded-xl text-sm font-bold transition-all shadow-md hover:shadow-lg hover:scale-[1.02] w-36 flex items-center justify-center text-center border border-rani-primary-dark/50">Edit Profile</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Content Sections -->
    <div class="space-y-8">
            
            <!-- Personality & About -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-white/40 overflow-hidden relative group hover:shadow-2xl transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-80"></div>
                
                <div class="px-6 md:px-8 py-5 border-b border-gray-100/50 flex justify-between items-center bg-gray-50/30">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-rani-light/40 rounded-xl text-rani-primary-dark shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <h3 class="font-serif font-bold text-gray-800 text-xl md:text-2xl tracking-wide">Personality & About</h3>
                    </div>
                    <button class="text-rani-primary text-sm font-semibold hover:text-rani-primary-dark flex items-center gap-1.5 transition-colors bg-rani-light/20 px-4 py-2 rounded-full hover:bg-rani-light/60 border border-rani-gold/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6 md:p-8">
                    <p class="text-gray-600 leading-relaxed text-base font-light">
                        {{ $candidate->about_yourself ?: 'No description provided yet. Write something about yourself to attract better matches!' }}
                    </p>
                </div>
            </div>

            <!-- Basics & Lifestyle -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-white/40 overflow-hidden relative group hover:shadow-2xl transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-80"></div>
                
                <div class="px-6 md:px-8 py-5 border-b border-gray-100/50 flex justify-between items-center bg-gray-50/30">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-rani-light/40 rounded-xl text-rani-primary-dark shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h3 class="font-serif font-bold text-gray-800 text-xl md:text-2xl tracking-wide">Basics & Lifestyle</h3>
                    </div>
                    <button class="text-rani-primary text-sm font-semibold hover:text-rani-primary-dark flex items-center gap-1.5 transition-colors bg-rani-light/20 px-4 py-2 rounded-full hover:bg-rani-light/60 border border-rani-gold/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    <!-- Data Rows -->
                    @php
                        $basics = [
                            'Age' => $age ?: 'Not Specified',
                            'Diet' => $candidate->diet ?: 'Not Specified',
                            'Date of Birth' => $candidate->dob ? \Carbon\Carbon::parse($candidate->dob)->format('d-M-Y') : 'Not Specified',
                            'Blood Group' => $candidate->blood_group ?: '<a href="#" class="text-rani-primary hover:underline">Add Now</a>',
                            'Marital Status' => $candidate->marital_status ?: 'Not Specified',
                            'Health Info' => $candidate->health_info ?: 'Not Specified',
                            'Height' => $candidate->height ?: 'Not Specified',
                            'Grew up in' => $candidate->grew_up_in ?: 'Not Specified',
                            'Disability' => $candidate->disability ?: 'None'
                        ];
                    @endphp
                    @foreach($basics as $label => $val)
                    <div class="grid grid-cols-3 gap-2 border-b border-gray-50 pb-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium tracking-wide uppercase text-xs flex items-center">{{ $label }}</div>
                        <div class="col-span-2 text-base text-gray-800 font-medium">{!! $val !!}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Religious Background -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-white/40 overflow-hidden relative group hover:shadow-2xl transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-80"></div>
                <div class="px-6 md:px-8 py-5 border-b border-gray-100/50 flex justify-between items-center bg-gray-50/30">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-rani-light/40 rounded-xl text-rani-primary-dark shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h3 class="font-serif font-bold text-gray-800 text-xl md:text-2xl tracking-wide">Religious Background</h3>
                    </div>
                    <button class="text-rani-primary text-sm font-semibold hover:text-rani-primary-dark flex items-center gap-1.5 transition-colors bg-rani-light/20 px-4 py-2 rounded-full hover:bg-rani-light/60 border border-rani-gold/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    @php
                        $religious = [
                            'Religion' => $candidate->religion ?: 'Not Specified',
                            'Community' => $candidate->community ?: 'Not Specified',
                            'Sub Community' => $candidate->sub_community ?: 'Not Specified',
                            'Gothra / Gotram' => $candidate->gothra ?: '<a href="#" class="text-rani-primary hover:underline">Add Now</a>',
                            'Mother Tongue' => $candidate->mother_tongue ?: 'Not Specified'
                        ];
                    @endphp
                    @foreach($religious as $label => $val)
                    <div class="grid grid-cols-3 gap-2 border-b border-gray-50 pb-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium tracking-wide uppercase text-xs flex items-center">{{ $label }}</div>
                        <div class="col-span-2 text-base text-gray-800 font-medium">{!! $val !!}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Astro Details -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-white/40 overflow-hidden relative group hover:shadow-2xl transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-80"></div>
                <div class="px-6 md:px-8 py-5 border-b border-gray-100/50 flex justify-between items-center bg-gray-50/30">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-rani-light/40 rounded-xl text-rani-primary-dark shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h3 class="font-serif font-bold text-gray-800 text-xl md:text-2xl tracking-wide">Astro Details</h3>
                    </div>
                    <button class="text-rani-primary text-sm font-semibold hover:text-rani-primary-dark flex items-center gap-1.5 transition-colors bg-rani-light/20 px-4 py-2 rounded-full hover:bg-rani-light/60 border border-rani-gold/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    @php
                        $astro = [
                            'Manglik' => $candidate->manglik ?: "Don't Know",
                            'Time of Birth' => $candidate->time_of_birth ?: '<a href="#" class="text-rani-primary hover:underline">Add Now</a>',
                            'City of Birth' => $candidate->city_of_birth ?: '<a href="#" class="text-rani-primary hover:underline">Add Now</a>'
                        ];
                    @endphp
                    @foreach($astro as $label => $val)
                    <div class="grid grid-cols-3 gap-2 border-b border-gray-50 pb-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium tracking-wide uppercase text-xs flex items-center">{{ $label }}</div>
                        <div class="col-span-2 text-base text-gray-800 font-medium">{!! $val !!}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Family Details -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-white/40 overflow-hidden relative group hover:shadow-2xl transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-80"></div>
                <div class="px-6 md:px-8 py-5 border-b border-gray-100/50 flex justify-between items-center bg-gray-50/30">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-rani-light/40 rounded-xl text-rani-primary-dark shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="font-serif font-bold text-gray-800 text-xl md:text-2xl tracking-wide">Family Details</h3>
                    </div>
                    <button class="text-rani-primary text-sm font-semibold hover:text-rani-primary-dark flex items-center gap-1.5 transition-colors bg-rani-light/20 px-4 py-2 rounded-full hover:bg-rani-light/60 border border-rani-gold/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    @php
                        $family = [
                            'Father\'s Details' => $candidate->father_profession ?: '<a href="#" class="text-rani-primary hover:underline">Add Now</a>',
                            'Mother\'s Details' => $candidate->mother_profession ?: '<a href="#" class="text-rani-primary hover:underline">Add Now</a>',
                            'Family Location' => $candidate->family_location ?: '<a href="#" class="text-rani-primary hover:underline">Add Now</a>',
                            'No. of Brothers' => $candidate->brothers_count !== null ? $candidate->brothers_count : '<a href="#" class="text-rani-primary hover:underline">Add Now</a>',
                            'No. of Sisters' => $candidate->sisters_count !== null ? $candidate->sisters_count : '<a href="#" class="text-rani-primary hover:underline">Add Now</a>',
                            'Financial Status' => $candidate->family_financial_status ?: '<a href="#" class="text-rani-primary hover:underline">Add Now</a>'
                        ];
                    @endphp
                    @foreach($family as $label => $val)
                    <div class="grid grid-cols-3 gap-2 border-b border-gray-50 pb-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium tracking-wide uppercase text-xs flex items-center">{{ $label }}</div>
                        <div class="col-span-2 text-base text-gray-800 font-medium">{!! $val !!}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Education & Career -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-white/40 overflow-hidden relative group hover:shadow-2xl transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-80"></div>
                <div class="px-6 md:px-8 py-5 border-b border-gray-100/50 flex justify-between items-center bg-gray-50/30">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-rani-light/40 rounded-xl text-rani-primary-dark shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="font-serif font-bold text-gray-800 text-xl md:text-2xl tracking-wide">Education & Career</h3>
                    </div>
                    <button class="text-rani-primary text-sm font-semibold hover:text-rani-primary-dark flex items-center gap-1.5 transition-colors bg-rani-light/20 px-4 py-2 rounded-full hover:bg-rani-light/60 border border-rani-gold/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    @php
                        $edu = [
                            'Highest Qual.' => $candidate->highest_qualification ?: 'Not Specified',
                            'Working With' => $candidate->working_with ?: 'Not Specified',
                            'College(s)' => $candidate->college_name ?: 'Not Specified',
                            'Working As' => $candidate->designation ?: 'Not Specified',
                            'Annual Income' => $candidate->annual_income ?: 'Not Specified',
                            'Employer' => $candidate->company_name ?: 'Not Specified'
                        ];
                    @endphp
                    @foreach($edu as $label => $val)
                    <div class="grid grid-cols-3 gap-2 border-b border-gray-50 pb-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium tracking-wide uppercase text-xs flex items-center">{{ $label }}</div>
                        <div class="col-span-2 text-base text-gray-800 font-medium">{!! $val !!}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Location -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-white/40 overflow-hidden relative group hover:shadow-2xl transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-80"></div>
                <div class="px-6 md:px-8 py-5 border-b border-gray-100/50 flex justify-between items-center bg-gray-50/30">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-rani-light/40 rounded-xl text-rani-primary-dark shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="font-serif font-bold text-gray-800 text-xl md:text-2xl tracking-wide">Location</h3>
                    </div>
                    <button class="text-rani-primary text-sm font-semibold hover:text-rani-primary-dark flex items-center gap-1.5 transition-colors bg-rani-light/20 px-4 py-2 rounded-full hover:bg-rani-light/60 border border-rani-gold/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    @php
                        $loc = [
                            'Current City' => $candidate->city ?: 'Not Specified',
                            'Residency Status' => $candidate->residency_status ?: 'Citizen',
                            'State' => $candidate->state ?: 'Not Specified',
                            'Zip / Pin code' => $candidate->zip_code ?: 'Not Specified',
                            'Country' => $candidate->country ?: 'India'
                        ];
                    @endphp
                    @foreach($loc as $label => $val)
                    <div class="grid grid-cols-3 gap-2 border-b border-gray-50 pb-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium tracking-wide uppercase text-xs flex items-center">{{ $label }}</div>
                        <div class="col-span-2 text-base text-gray-800 font-medium">{!! $val !!}</div>
                    </div>
                    @endforeach
                </div>
            </div>

            <!-- Contact Details Settings -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-white/40 overflow-hidden relative group hover:shadow-2xl transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-80"></div>
                <div class="px-6 md:px-8 py-5 border-b border-gray-100/50 flex justify-between items-center bg-gray-50/30">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-rani-light/40 rounded-xl text-rani-primary-dark shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="font-serif font-bold text-gray-800 text-xl md:text-2xl tracking-wide">My Contact Detail</h3>
                    </div>
                    <button class="text-rani-primary text-sm font-semibold hover:text-rani-primary-dark flex items-center gap-1.5 transition-colors bg-rani-light/20 px-4 py-2 rounded-full hover:bg-rani-light/60 border border-rani-gold/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    <div class="grid grid-cols-3 gap-2 border-b border-gray-50 pb-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium tracking-wide uppercase text-xs flex items-center">Mobile</div>
                        <div class="col-span-2 text-base text-gray-800 font-bold tracking-wider">+91-{{ $candidate->mobile }}</div>
                    </div>
                    <div class="grid grid-cols-3 gap-2 border-b border-gray-50 pb-2">
                        <div class="col-span-1 text-sm text-gray-500 font-medium tracking-wide uppercase text-xs flex items-center">Display Option</div>
                        <div class="col-span-2 text-base text-gray-800 font-medium">{{ $candidate->contact_display_option ?: 'Premium Members Only' }}</div>
                    </div>
                </div>
            </div>
            
            <div class="text-left pt-6">
                <button @click="window.scrollTo({ top: 0, behavior: 'smooth' })" class="text-rani-primary-dark text-sm font-bold tracking-wide hover:text-rani-primary flex items-center gap-2 hover:-translate-y-1 transition-all bg-white/80 backdrop-blur-sm px-6 py-3 rounded-full shadow-lg border border-white/80 hover:shadow-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    Back to Top
                </button>
            </div>
        </div>

    </div>
</div>
</div>
@endsection
