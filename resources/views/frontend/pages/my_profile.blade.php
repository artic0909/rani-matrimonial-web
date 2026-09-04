@extends('frontend.layouts.auth_app')

@section('title', 'My Profile | Ranimatrimonial')

@section('content')
<div class="relative pt-8 pb-20" x-data="profileEditor()">
    <!-- Background Image -->
    <div class="fixed inset-0 z-0 bg-cover bg-top bg-no-repeat" style="background-image: url('{{ asset('img/hero.png') }}');"></div>
    
    <!-- Maroon/Gold Gradient Overlay -->
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
                <!-- Avatar with Camera Button & Loading State -->
                <div class="relative shrink-0 group">
                    <div class="absolute inset-0 bg-rani-gold rounded-full blur-md opacity-20 group-hover:opacity-40 transition-opacity duration-300"></div>
                    <img :src="profileImageUrl" 
                         alt="{{ $candidate->first_name }}" 
                         class="w-36 h-36 md:w-44 md:h-44 rounded-full border-[6px] border-white shadow-xl object-cover bg-white relative z-10 transform group-hover:scale-[1.02] transition-transform duration-300">
                    
                    <!-- Upload Spinner Overlay -->
                    <div x-show="isUploadingPhoto" style="display: none;" class="absolute inset-0 z-20 rounded-full bg-black/50 flex flex-col items-center justify-center text-white backdrop-blur-xs">
                        <svg class="animate-spin h-8 w-8 text-rani-gold mb-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span class="text-xs font-semibold">Uploading...</span>
                    </div>

                    <!-- Change Photo Camera Button -->
                    <label for="profile_upload" class="absolute bottom-1 right-1 md:bottom-2 md:right-2 bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white p-3 rounded-full shadow-2xl border-2 border-white cursor-pointer hover:scale-110 active:scale-95 transition-all duration-300 z-30 flex items-center justify-center group-hover:shadow-rani-gold/50" title="Change Profile Picture">
                        <svg class="w-5 h-5 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <input type="file" id="profile_upload" class="hidden" accept="image/*" @change="uploadProfilePicture">
                    </label>

                    @if($candidate->selfie_verified)
                        <div class="absolute bottom-1 left-1 md:bottom-2 md:left-2 bg-emerald-600 text-white rounded-full p-2 border-2 border-white shadow-lg z-20" title="Selfie Verified">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                        </div>
                    @endif
                </div>
                
                <!-- Summary Info -->
                <div class="flex-1 text-center md:text-left flex flex-col md:flex-row items-center md:items-stretch justify-between w-full gap-8">
                    <div class="flex flex-col justify-center items-center md:items-start space-y-2.5">
                        <h1 class="text-3xl md:text-4xl font-bold text-rani-primary-dark font-serif tracking-wide drop-shadow-sm">{{ $candidate->first_name }} {{ $candidate->last_name }}</h1>
                        <div class="text-sm md:text-base text-gray-500 font-semibold font-sans mb-1 uppercase tracking-wider">RANI{{ str_pad($candidate->id, 6, '0', STR_PAD_LEFT) }}</div>
                        <p class="text-xs text-rani-gold-dark font-bold bg-rani-light/40 px-3.5 py-1 rounded-full mb-4 border border-rani-gold/20">{{ $candidate->profile_for === 'Myself' ? 'Profile created by Self' : 'Profile created by ' . $candidate->profile_for }}</p>
                        
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-8 gap-y-3.5 text-sm text-gray-700 font-medium w-full max-w-md mt-2">
                            <div class="flex items-center gap-2.5 justify-center md:justify-start">
                                <div class="p-1.5 bg-gray-50 rounded-md text-rani-gold border border-gray-100"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg></div>
                                <span>{{ $age ? $age . ' yrs' : 'Age Not Specified' }}{{ $candidate->height ? ', ' . $candidate->height : '' }}</span>
                            </div>
                            <div class="flex items-center gap-2.5 justify-center md:justify-start">
                                <div class="p-1.5 bg-gray-50 rounded-md text-rani-gold border border-gray-100"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg></div>
                                <span>{{ $candidate->religion ?: 'Religion' }}{{ $candidate->community ? ', ' . $candidate->community : '' }}</span>
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
                </div>
            </div>
        </div>

        <!-- Profile Content Sections -->
        <div class="space-y-8">
            
            <!-- 1. Personality & About -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-white/40 overflow-hidden relative group hover:shadow-2xl transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-80"></div>
                
                <div class="px-6 md:px-8 py-5 border-b border-gray-100/50 flex justify-between items-center bg-gray-50/30">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-rani-light/40 rounded-xl text-rani-primary-dark shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                        </div>
                        <h3 class="font-serif font-bold text-gray-800 text-xl md:text-2xl tracking-wide">Personality & About</h3>
                    </div>
                    <button type="button" @click="openModal('about')" class="text-rani-primary text-sm font-semibold hover:text-rani-primary-dark flex items-center gap-1.5 transition-colors bg-rani-light/20 px-4 py-2 rounded-full hover:bg-rani-light/60 border border-rani-gold/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6 md:p-8">
                    @if($candidate->about_yourself)
                        <p class="text-gray-700 leading-relaxed text-base whitespace-pre-line">
                            {{ $candidate->about_yourself }}
                        </p>
                    @else
                        <div class="text-center py-6 bg-gray-50/50 rounded-xl border border-dashed border-gray-200">
                            <p class="text-gray-500 mb-3 text-sm">No description provided yet. Write something about yourself to attract better matches!</p>
                            <button type="button" @click="openModal('about')" class="inline-flex items-center gap-1.5 text-rani-primary font-semibold text-sm hover:underline">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                Add About Yourself
                            </button>
                        </div>
                    @endif
                </div>
            </div>

            <!-- 2. Basics & Lifestyle -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-white/40 overflow-hidden relative group hover:shadow-2xl transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-80"></div>
                
                <div class="px-6 md:px-8 py-5 border-b border-gray-100/50 flex justify-between items-center bg-gray-50/30">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-rani-light/40 rounded-xl text-rani-primary-dark shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                        </div>
                        <h3 class="font-serif font-bold text-gray-800 text-xl md:text-2xl tracking-wide">Basics & Lifestyle</h3>
                    </div>
                    <button type="button" @click="openModal('basic')" class="text-rani-primary text-sm font-semibold hover:text-rani-primary-dark flex items-center gap-1.5 transition-colors bg-rani-light/20 px-4 py-2 rounded-full hover:bg-rani-light/60 border border-rani-gold/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    @php
                        $basics = [
                            'Age' => $age ? $age . ' yrs' : 'Not Specified',
                            'Diet' => $candidate->diet ?: '<button type="button" @click="openModal(\'basic\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'Date of Birth' => $candidate->dob ? \Carbon\Carbon::parse($candidate->dob)->format('d-M-Y') : '<button type="button" @click="openModal(\'basic\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'Blood Group' => $candidate->blood_group ?: '<button type="button" @click="openModal(\'basic\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'Marital Status' => $candidate->marital_status ?: '<button type="button" @click="openModal(\'basic\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'Health Info' => $candidate->health_info ?: '<button type="button" @click="openModal(\'basic\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'Height' => $candidate->height ?: '<button type="button" @click="openModal(\'basic\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'Grew up in' => $candidate->grew_up_in ?: '<button type="button" @click="openModal(\'basic\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
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

            <!-- 3. Religious Background -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-white/40 overflow-hidden relative group hover:shadow-2xl transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-80"></div>
                <div class="px-6 md:px-8 py-5 border-b border-gray-100/50 flex justify-between items-center bg-gray-50/30">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-rani-light/40 rounded-xl text-rani-primary-dark shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                        </div>
                        <h3 class="font-serif font-bold text-gray-800 text-xl md:text-2xl tracking-wide">Religious Background</h3>
                    </div>
                    <button type="button" @click="openModal('religious')" class="text-rani-primary text-sm font-semibold hover:text-rani-primary-dark flex items-center gap-1.5 transition-colors bg-rani-light/20 px-4 py-2 rounded-full hover:bg-rani-light/60 border border-rani-gold/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    @php
                        $religious = [
                            'Religion' => $candidate->religion ?: '<button type="button" @click="openModal(\'religious\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'Community' => $candidate->community ?: '<button type="button" @click="openModal(\'religious\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'Sub Community' => $candidate->sub_community ?: '<button type="button" @click="openModal(\'religious\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'Gothra / Gotram' => $candidate->gothra ?: '<button type="button" @click="openModal(\'religious\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'Mother Tongue' => $candidate->mother_tongue ?: '<button type="button" @click="openModal(\'religious\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>'
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

            <!-- 4. Astro Details -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-white/40 overflow-hidden relative group hover:shadow-2xl transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-80"></div>
                <div class="px-6 md:px-8 py-5 border-b border-gray-100/50 flex justify-between items-center bg-gray-50/30">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-rani-light/40 rounded-xl text-rani-primary-dark shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
                        </div>
                        <h3 class="font-serif font-bold text-gray-800 text-xl md:text-2xl tracking-wide">Astro Details</h3>
                    </div>
                    <button type="button" @click="openModal('astro')" class="text-rani-primary text-sm font-semibold hover:text-rani-primary-dark flex items-center gap-1.5 transition-colors bg-rani-light/20 px-4 py-2 rounded-full hover:bg-rani-light/60 border border-rani-gold/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    @php
                        $astro = [
                            'Manglik' => $candidate->manglik ?: "Don't Know",
                            'Time of Birth' => $candidate->time_of_birth ?: '<button type="button" @click="openModal(\'astro\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'City of Birth' => $candidate->city_of_birth ?: '<button type="button" @click="openModal(\'astro\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>'
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

            <!-- 5. Family Details -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-white/40 overflow-hidden relative group hover:shadow-2xl transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-80"></div>
                <div class="px-6 md:px-8 py-5 border-b border-gray-100/50 flex justify-between items-center bg-gray-50/30">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-rani-light/40 rounded-xl text-rani-primary-dark shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                        </div>
                        <h3 class="font-serif font-bold text-gray-800 text-xl md:text-2xl tracking-wide">Family Details</h3>
                    </div>
                    <button type="button" @click="openModal('family')" class="text-rani-primary text-sm font-semibold hover:text-rani-primary-dark flex items-center gap-1.5 transition-colors bg-rani-light/20 px-4 py-2 rounded-full hover:bg-rani-light/60 border border-rani-gold/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    @php
                        $family = [
                            'Father\'s Details' => $candidate->father_profession ?: '<button type="button" @click="openModal(\'family\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'Mother\'s Details' => $candidate->mother_profession ?: '<button type="button" @click="openModal(\'family\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'Family Location' => $candidate->family_location ?: '<button type="button" @click="openModal(\'family\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'No. of Brothers' => $candidate->brothers_count !== null ? $candidate->brothers_count : '<button type="button" @click="openModal(\'family\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'No. of Sisters' => $candidate->sisters_count !== null ? $candidate->sisters_count : '<button type="button" @click="openModal(\'family\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'Financial Status' => $candidate->family_financial_status ?: '<button type="button" @click="openModal(\'family\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>'
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

            <!-- 6. Education & Career -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-white/40 overflow-hidden relative group hover:shadow-2xl transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-80"></div>
                <div class="px-6 md:px-8 py-5 border-b border-gray-100/50 flex justify-between items-center bg-gray-50/30">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-rani-light/40 rounded-xl text-rani-primary-dark shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="font-serif font-bold text-gray-800 text-xl md:text-2xl tracking-wide">Education & Career</h3>
                    </div>
                    <button type="button" @click="openModal('education_career')" class="text-rani-primary text-sm font-semibold hover:text-rani-primary-dark flex items-center gap-1.5 transition-colors bg-rani-light/20 px-4 py-2 rounded-full hover:bg-rani-light/60 border border-rani-gold/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    @php
                        $edu = [
                            'Highest Qual.' => $candidate->highest_qualification ?: '<button type="button" @click="openModal(\'education_career\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'Working With' => $candidate->working_with ?: '<button type="button" @click="openModal(\'education_career\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'College(s)' => $candidate->college_name ?: '<button type="button" @click="openModal(\'education_career\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'Working As' => $candidate->designation ?: '<button type="button" @click="openModal(\'education_career\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'Profession' => $candidate->profession ?: '<button type="button" @click="openModal(\'education_career\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'Annual Income' => $candidate->annual_income ?: '<button type="button" @click="openModal(\'education_career\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'Employer' => $candidate->company_name ?: '<button type="button" @click="openModal(\'education_career\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>'
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

            <!-- 7. Location -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-white/40 overflow-hidden relative group hover:shadow-2xl transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-80"></div>
                <div class="px-6 md:px-8 py-5 border-b border-gray-100/50 flex justify-between items-center bg-gray-50/30">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-rani-light/40 rounded-xl text-rani-primary-dark shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        </div>
                        <h3 class="font-serif font-bold text-gray-800 text-xl md:text-2xl tracking-wide">Location</h3>
                    </div>
                    <button type="button" @click="openModal('location')" class="text-rani-primary text-sm font-semibold hover:text-rani-primary-dark flex items-center gap-1.5 transition-colors bg-rani-light/20 px-4 py-2 rounded-full hover:bg-rani-light/60 border border-rani-gold/10">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                        Edit
                    </button>
                </div>
                <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-6">
                    @php
                        $loc = [
                            'Current City' => $candidate->city ?: '<button type="button" @click="openModal(\'location\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'Residency Status' => $candidate->residency_status ?: 'Citizen',
                            'State' => $candidate->state ?: '<button type="button" @click="openModal(\'location\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
                            'Zip / Pin code' => $candidate->zip_code ?: '<button type="button" @click="openModal(\'location\')" class="text-rani-primary font-semibold hover:underline inline-flex items-center gap-1"><svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>Add Now</button>',
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

            <!-- 8. Contact Details Settings -->
            <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl border border-white/40 overflow-hidden relative group hover:shadow-2xl transition-all duration-300">
                <div class="absolute top-0 left-0 w-full h-[3px] bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-80"></div>
                <div class="px-6 md:px-8 py-5 border-b border-gray-100/50 flex justify-between items-center bg-gray-50/30">
                    <div class="flex items-center gap-3">
                        <div class="p-2.5 bg-rani-light/40 rounded-xl text-rani-primary-dark shadow-sm">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                        </div>
                        <h3 class="font-serif font-bold text-gray-800 text-xl md:text-2xl tracking-wide">My Contact Details</h3>
                    </div>
                    <button type="button" @click="openModal('contact')" class="text-rani-primary text-sm font-semibold hover:text-rani-primary-dark flex items-center gap-1.5 transition-colors bg-rani-light/20 px-4 py-2 rounded-full hover:bg-rani-light/60 border border-rani-gold/10">
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
                        <div class="col-span-2 text-base text-gray-800 font-medium">{{ $candidate->contact_display_option ?: 'Visible to all Premium Members' }}</div>
                    </div>
                </div>
            </div>
            
            <div class="text-left pt-6">
                <button type="button" @click="window.scrollTo({ top: 0, behavior: 'smooth' })" class="text-rani-primary-dark text-sm font-bold tracking-wide hover:text-rani-primary flex items-center gap-2 hover:-translate-y-1 transition-all bg-white/80 backdrop-blur-sm px-6 py-3 rounded-full shadow-lg border border-white/80 hover:shadow-xl">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>
                    Back to Top
                </button>
            </div>
        </div>
    </div>

    <!-- Include Modal Component INSIDE x-data wrapper -->
    @include('frontend.includes.profile_modals')
</div>
@endsection
