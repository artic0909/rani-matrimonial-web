@extends('frontend.layouts.auth_app')

@section('title', 'My Photos | Ranimatrimonial')

@section('content')
<div class="relative pt-8 pb-20" x-data="galleryManager()">
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
        <div class="heart-floating delay-3" style="left: 60%; animation-delay: 2s;"></div>
        <div class="heart-floating delay-4" style="left: 80%; animation-delay: 14s;"></div>
    </div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Main Card Container -->
        <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl border border-white/60 mb-10 overflow-hidden relative z-10">
            <!-- Subtle royal accent top -->
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-90"></div>
            
            <!-- Tab Navigation Header -->
            <div class="px-6 md:px-10 pt-8 pb-4 border-b border-gray-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <h1 class="text-2xl md:text-3xl font-bold font-serif text-rani-primary-dark tracking-wide">My Photos</h1>
                    <p class="text-xs text-gray-500 font-sans mt-0.5">Manage your profile photo, gallery pictures, and privacy settings</p>
                </div>

                <!-- Sub-Tabs: Photo & Settings -->
                <div class="flex items-center space-x-2 bg-gray-100/80 p-1.5 rounded-2xl border border-gray-200/60 self-start sm:self-auto">
                    <button type="button" 
                            @click="activeTab = 'photo'" 
                            :class="activeTab === 'photo' ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white shadow-md font-bold' : 'text-gray-600 hover:text-rani-primary font-medium'"
                            class="px-6 py-2 rounded-xl text-sm transition-all duration-300 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                        Photo
                    </button>
                    <button type="button" 
                            @click="activeTab = 'settings'" 
                            :class="activeTab === 'settings' ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white shadow-md font-bold' : 'text-gray-600 hover:text-rani-primary font-medium'"
                            class="px-6 py-2 rounded-xl text-sm transition-all duration-300 flex items-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Settings
                    </button>
                </div>
            </div>

            <!-- ================= TAB 1: PHOTO ================= -->
            <div x-show="activeTab === 'photo'" class="p-6 md:p-10 space-y-10">
                
                <!-- Hero Message & Upload Section -->
                <div class="text-center max-w-2xl mx-auto space-y-4">
                    <h2 class="text-2xl md:text-3xl font-bold font-serif text-rani-primary-dark tracking-wide">
                        Get more responses by uploading up to 20 photos on your profile.
                    </h2>
                </div>

                <!-- Spotlight: Profile Photo & Upload Box Card -->
                <div class="bg-gradient-to-br from-rani-light/30 via-white to-rani-light/20 rounded-3xl p-6 md:p-8 border border-rani-gold/30 shadow-md">
                    <div class="grid grid-cols-1 md:grid-cols-12 gap-8 items-center">
                        
                        <!-- 1st: Logged-in Candidate Profile Picture Display -->
                        <div class="md:col-span-4 flex flex-col items-center justify-center text-center p-4 bg-white/80 backdrop-blur-xs rounded-2xl border border-gray-100 shadow-sm relative group">
                            <div class="relative mb-3">
                                <img :src="profileImageUrl" 
                                     alt="{{ $candidate->first_name }}" 
                                     class="w-36 h-36 md:w-40 md:h-40 rounded-full border-4 border-rani-gold object-cover shadow-lg bg-white">
                                
                                <!-- Profile Badge -->
                                <span class="absolute -bottom-2 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-rani-gold to-yellow-500 text-rani-dark text-[11px] font-bold px-3 py-0.5 rounded-full shadow border border-white whitespace-nowrap">
                                    Profile Picture
                                </span>
                            </div>

                            <h3 class="font-serif font-bold text-gray-800 text-lg mt-2">{{ $candidate->first_name }}{{ $candidate->middle_name ? ' ' . $candidate->middle_name : '' }} {{ $candidate->last_name }}</h3>
                            <p class="text-xs text-gray-500 font-sans">ID: RANI{{ str_pad($candidate->id, 6, '0', STR_PAD_LEFT) }}</p>

                            <!-- Change Profile Photo Button -->
                            <label for="direct_profile_input" class="mt-3 cursor-pointer text-xs font-bold text-rani-primary hover:text-rani-primary-dark hover:underline flex items-center gap-1.5 transition-colors">
                                <svg class="w-4 h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                Change Profile Photo
                                <input type="file" id="direct_profile_input" class="hidden" accept="image/*" @change="uploadProfilePhotoDirect">
                            </label>
                        </div>

                        <!-- Drag & Drop Upload Container -->
                        <div class="md:col-span-8 flex flex-col justify-center">
                            <div class="border-2 border-dashed border-rani-gold/50 hover:border-rani-primary bg-white/90 hover:bg-white rounded-2xl p-6 md:p-8 text-center transition-all duration-300 cursor-pointer shadow-sm hover:shadow-md group"
                                 @click="document.getElementById('gallery_file_input').click()"
                                 @dragover.prevent="isDragging = true"
                                 @dragleave.prevent="isDragging = false"
                                 @drop.prevent="handleFileDrop($event)">
                                
                                <p class="text-sm md:text-base font-semibold text-gray-700 mb-3">Upload photos from your computer or phone</p>
                                
                                <button type="button" class="inline-flex items-center gap-2 px-7 py-3 rounded-full bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white font-bold text-sm shadow-md hover:shadow-lg hover:scale-105 active:scale-95 transition-all border border-rani-gold/30">
                                    <svg class="w-4 h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path></svg>
                                    Browse Photos
                                </button>
                                
                                <input type="file" id="gallery_file_input" class="hidden" accept="image/*" multiple @change="handleFileUpload">

                                <!-- Spinner -->
                                <div x-show="isUploading" style="display: none;" class="mt-4 flex items-center justify-center gap-2 text-xs font-bold text-rani-primary animate-pulse">
                                    <svg class="animate-spin h-4 w-4 text-rani-primary" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                                    Uploading & Compressing Photos...
                                </div>
                            </div>

                            <p class="text-xs text-gray-500 mt-3 leading-relaxed text-center md:text-left">
                                <strong>Note:</strong> You can upload up to 20 photos to your profile. Each photo must be less than 15 MB and in JPG, JPEG, PNG, or WEBP format. All photos uploaded are screened as per Photo Guidelines and 98% of those get activated within 2 hours.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Gallery Photos Section (1st profile picture, 2nd, 3rd... from database) -->
                <div class="space-y-6">
                    <div class="flex items-center justify-between border-b border-gray-100 pb-3">
                        <h3 class="text-xl font-bold font-serif text-gray-800 tracking-wide flex items-center gap-2">
                            <span>Uploaded Photos</span>
                            <span class="text-xs font-sans px-2.5 py-0.5 rounded-full bg-rani-light/60 text-rani-primary-dark font-bold">(<span x-text="photos.length"></span> Photos)</span>
                        </h3>
                    </div>

                    <!-- Gallery Grid -->
                    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-5 gap-4 md:gap-6">
                        <template x-for="(photo, index) in photos" :key="photo.id">
                            <div class="bg-white rounded-2xl shadow-md overflow-hidden border border-gray-100 group hover:shadow-xl transition-all duration-300 flex flex-col justify-between">
                                
                                <!-- Photo Box -->
                                <div class="relative aspect-4/5 overflow-hidden bg-gray-100 cursor-pointer" @click="previewPhoto(photo)">
                                    <img :src="photo.url" :alt="'Photo #' + photo.id" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    
                                    <!-- 1st Badge or Active Profile Badge -->
                                    <template x-if="photo.is_profile_picture">
                                        <span class="absolute top-2 left-2 bg-gradient-to-r from-rani-gold to-yellow-500 text-rani-dark text-[10px] font-bold px-2 py-0.5 rounded-full shadow border border-white flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                            Profile Photo
                                        </span>
                                    </template>

                                    <!-- Index position badge -->
                                    <span class="absolute bottom-2 right-2 bg-black/60 text-white text-[10px] font-bold px-1.5 py-0.5 rounded backdrop-blur-xs" x-text="'#' + (index + 1)"></span>

                                    <!-- Hover Zoom Icon -->
                                    <div class="absolute inset-0 bg-black/25 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                                        <span class="p-2 bg-black/50 rounded-full backdrop-blur-xs">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                        </span>
                                    </div>
                                </div>

                                <!-- Actions -->
                                <div class="p-2.5 bg-gray-50/50 flex items-center justify-between border-t border-gray-100 gap-1">
                                    <template x-if="!photo.is_profile_picture">
                                        <button type="button" @click="setAsProfile(photo)" class="text-[11px] font-bold text-rani-primary hover:text-rani-primary-dark hover:underline flex items-center gap-1 transition-colors">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                            Set Profile
                                        </button>
                                    </template>
                                    <template x-if="photo.is_profile_picture">
                                        <span class="text-[11px] font-bold text-emerald-600 flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                            Active
                                        </span>
                                    </template>

                                    <button type="button" @click="deletePhoto(photo)" class="text-gray-400 hover:text-red-600 p-1 rounded hover:bg-red-50 transition-colors" title="Delete Photo">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Other Ways to Upload Note -->
                <div class="bg-amber-50/70 border border-amber-200/80 rounded-2xl p-4 flex items-start gap-3">
                    <span class="text-xl">✉️</span>
                    <div>
                        <h4 class="text-xs font-bold text-amber-900 uppercase tracking-wide">Other ways to upload your photos</h4>
                        <p class="text-xs text-amber-800 mt-0.5">
                            Send your photos through post or courier to our registered office. Please mention your <strong>Profile ID (RANI{{ str_pad($candidate->id, 6, '0', STR_PAD_LEFT) }})</strong> and Name on the back of the physical photographs.
                        </p>
                    </div>
                </div>

                <!-- ================= BOTTOM INSTRUCTIONS / GUIDELINES ================= -->
                @php
                    $genderFolder = strtolower($candidate->gender ?? 'male') === 'female' ? 'female' : 'male';
                @endphp
                <div class="pt-8 border-t border-gray-200 space-y-6">
                    <div class="text-center">
                        <h3 class="text-lg md:text-xl font-bold font-serif text-gray-800">Photo Upload Instructions & Guidelines</h3>
                        <p class="text-xs text-gray-500 mt-1">Please ensure your pictures follow these standard matrimonial guidelines for fast approval</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-12 gap-6 items-stretch">
                        
                        <!-- Photos you CAN upload -->
                        <div class="md:col-span-5 bg-emerald-50/60 border border-emerald-200/80 rounded-2xl p-5 flex flex-col justify-between">
                            <div class="flex items-center gap-2 mb-4 text-emerald-800 font-bold text-sm">
                                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                                <span>Photos you CAN upload</span>
                            </div>

                            <div class="flex items-center gap-3">
                                <div class="text-center bg-white rounded-xl p-2.5 border border-emerald-100 shadow-sm w-24 sm:w-28">
                                    <div class="w-full aspect-square bg-gray-100 rounded-lg mb-1.5 overflow-hidden flex items-center justify-center">
                                        <img src="{{ asset('img/' . $genderFolder . '/correct1.png') }}" alt="Close Up" class="w-full h-full object-cover">
                                    </div>
                                    <span class="text-[11px] font-bold text-gray-700 block">Close Up</span>
                                </div>

                                <div class="text-center bg-white rounded-xl p-2.5 border border-emerald-100 shadow-sm w-24 sm:w-28">
                                    <div class="w-full aspect-square bg-gray-100 rounded-lg mb-1.5 overflow-hidden flex items-center justify-center">
                                        <img src="{{ asset('img/' . $genderFolder . '/correct2.png') }}" alt="Full View" class="w-full h-full object-cover">
                                    </div>
                                    <span class="text-[11px] font-bold text-gray-700 block">Full View</span>
                                </div>
                            </div>
                        </div>

                        <!-- Photos you CANNOT upload -->
                        <div class="md:col-span-7 bg-red-50/60 border border-red-200/80 rounded-2xl p-5 flex flex-col justify-between">
                            <div class="flex items-center gap-2 mb-4 text-red-800 font-bold text-sm">
                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"></path></svg>
                                <span>Photos you CANNOT upload</span>
                            </div>

                            <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                                <div class="text-center bg-white rounded-xl p-2.5 border border-red-100 shadow-sm">
                                    <div class="w-full aspect-square bg-gray-100 rounded-lg mb-1.5 overflow-hidden flex items-center justify-center">
                                        <img src="{{ asset('img/' . $genderFolder . '/side.png') }}" alt="Side Face" class="w-full h-full object-cover">
                                    </div>
                                    <span class="text-[11px] font-bold text-gray-700 block">Side Face</span>
                                </div>

                                <div class="text-center bg-white rounded-xl p-2.5 border border-red-100 shadow-sm">
                                    <div class="w-full aspect-square bg-gray-100 rounded-lg mb-1.5 overflow-hidden flex items-center justify-center">
                                        <img src="{{ asset('img/' . $genderFolder . '/blur.png') }}" alt="Blur" class="w-full h-full object-cover">
                                    </div>
                                    <span class="text-[11px] font-bold text-gray-700 block">Blur</span>
                                </div>

                                <div class="text-center bg-white rounded-xl p-2.5 border border-red-100 shadow-sm">
                                    <div class="w-full aspect-square bg-gray-100 rounded-lg mb-1.5 overflow-hidden flex items-center justify-center">
                                        <img src="{{ asset('img/' . $genderFolder . '/group.png') }}" alt="Group" class="w-full h-full object-cover">
                                    </div>
                                    <span class="text-[11px] font-bold text-gray-700 block">Group</span>
                                </div>

                                <div class="text-center bg-white rounded-xl p-2.5 border border-red-100 shadow-sm">
                                    <div class="w-full aspect-square bg-gray-100 rounded-lg mb-1.5 overflow-hidden flex items-center justify-center">
                                        <img src="{{ file_exists(public_path('img/' . $genderFolder . '/stock.png')) ? asset('img/' . $genderFolder . '/stock.png') : asset('img/male/stock.png') }}" alt="Watermark" class="w-full h-full object-cover">
                                    </div>
                                    <span class="text-[11px] font-bold text-gray-700 block">Watermark</span>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- Footer Help Links -->
                    <div class="flex items-center justify-center gap-4 text-xs font-semibold text-gray-500 pt-2">
                        <a href="#" class="text-rani-primary hover:underline">Photo Guidelines</a>
                        <span>•</span>
                        <a href="#" class="text-rani-primary hover:underline">Photo FAQ</a>
                    </div>
                </div>

            </div>

            <!-- ================= TAB 2: SETTINGS ================= -->
            <div x-show="activeTab === 'settings'" style="display: none;" class="p-6 md:p-10 space-y-8 max-w-2xl mx-auto">
                <div>
                    <h2 class="text-2xl font-bold font-serif text-rani-primary-dark">Photo Privacy Settings</h2>
                    <p class="text-sm text-gray-500 mt-1">Control who can see your photos on Ranimatrimonial</p>
                </div>

                <form @submit.prevent="saveSettings" class="space-y-8">
                    
                    <!-- Profile Photo Privacy -->
                    <div class="bg-gray-50/70 p-6 rounded-2xl border border-gray-200/80 space-y-4">
                        <h3 class="text-base font-bold text-gray-800 font-serif">Profile Photo</h3>
                        
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" value="Visible to all Members (Recommended)" x-model="settings.photo_privacy" class="w-4 h-4 text-rani-primary focus:ring-rani-primary border-gray-300">
                                <span class="text-sm text-gray-700 font-medium">Visible to all Members (Recommended)</span>
                            </label>
                            
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" value="Visible to Members I like and to all Premium Members" x-model="settings.photo_privacy" class="w-4 h-4 text-rani-primary focus:ring-rani-primary border-gray-300">
                                <span class="text-sm text-gray-700 font-medium">Visible to Members I like and to all Premium Members</span>
                            </label>
                        </div>
                    </div>

                    <!-- Album Privacy -->
                    <div class="bg-gray-50/70 p-6 rounded-2xl border border-gray-200/80 space-y-4">
                        <h3 class="text-base font-bold text-gray-800 font-serif">Album</h3>
                        
                        <div class="space-y-3">
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" value="Visible to Members I like and to all Premium Members" x-model="settings.album_privacy" class="w-4 h-4 text-rani-primary focus:ring-rani-primary border-gray-300">
                                <span class="text-sm text-gray-700 font-medium">Visible to Members I like and to all Premium Members</span>
                            </label>
                            
                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" value="Only visible to members I like" x-model="settings.album_privacy" class="w-4 h-4 text-rani-primary focus:ring-rani-primary border-gray-300">
                                <span class="text-sm text-gray-700 font-medium">Only visible to members I like</span>
                            </label>

                            <label class="flex items-center gap-3 cursor-pointer">
                                <input type="radio" value="Visible to all Members" x-model="settings.album_privacy" class="w-4 h-4 text-rani-primary focus:ring-rani-primary border-gray-300">
                                <span class="text-sm text-gray-700 font-medium">Visible to all Members</span>
                            </label>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div>
                        <button type="submit" :disabled="isSavingSettings" class="px-8 py-3 rounded-full bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white font-bold text-sm shadow-md hover:shadow-lg transition-all disabled:opacity-50">
                            <span x-show="!isSavingSettings">Save my settings</span>
                            <span x-show="isSavingSettings">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>

    </div>

    <!-- Lightbox Fullscreen Preview Modal -->
    <div x-show="previewModalOpen" style="display: none;" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/85 backdrop-blur-md p-4" x-transition.opacity>
        <div class="relative max-w-4xl w-full mx-auto" @click.away="previewModalOpen = false">
            <button @click="previewModalOpen = false" class="absolute -top-12 right-0 text-white/80 hover:text-white p-2 rounded-full transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="bg-black/50 rounded-2xl overflow-hidden shadow-2xl flex items-center justify-center p-2 border border-white/20">
                <img :src="activePreviewUrl" alt="Preview Photo" class="max-h-[80vh] w-auto rounded-xl object-contain">
            </div>
        </div>
    </div>
</div>

<script>
window.galleryManager = function() {
    return {
        activeTab: 'photo',
        profileImageUrl: '{{ $candidate->profile_picture ? asset('storage/' . $candidate->profile_picture) : "https://ui-avatars.com/api/?name=".urlencode($candidate->first_name)."&background=D4AF37&color=fff" }}',
        photos: @json($formattedPhotos ?? []),
        isUploading: false,
        isDragging: false,
        isSavingSettings: false,
        previewModalOpen: false,
        activePreviewUrl: '',

        settings: {
            photo_privacy: @json($candidate->photo_privacy ?? 'Visible to all Members (Recommended)'),
            album_privacy: @json($candidate->album_privacy ?? 'Visible to Members I like and to all Premium Members')
        },

        previewPhoto(photo) {
            this.activePreviewUrl = photo.url;
            this.previewModalOpen = true;
        },

        handleFileDrop(event) {
            this.isDragging = false;
            const files = event.dataTransfer.files;
            if (files && files.length > 0) {
                this.uploadFiles(files);
            }
        },

        handleFileUpload(event) {
            const files = event.target.files;
            if (files && files.length > 0) {
                this.uploadFiles(files);
            }
            event.target.value = '';
        },

        async uploadProfilePhotoDirect(event) {
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
                if (result.success) {
                    this.profileImageUrl = result.image_url;
                    window.location.reload();
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Upload Failed',
                        text: result.message || 'Could not update profile picture.',
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    });
                }
            } catch (e) {
                console.error(e);
            }
        },

        async uploadFiles(files) {
            if (this.photos.length + files.length > 20) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Limit Exceeded',
                    text: 'You can have a maximum of 20 photos in your gallery.',
                    customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                });
                return;
            }

            const formData = new FormData();
            for (let i = 0; i < files.length; i++) {
                if (files[i].size > 15 * 1024 * 1024) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'File Too Large',
                        text: `${files[i].name} exceeds 15MB. Please choose smaller files.`,
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    });
                    return;
                }
                formData.append('photos[]', files[i]);
            }

            this.isUploading = true;

            try {
                const response = await fetch('{{ route("photos.upload") }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    },
                    body: formData
                });

                const result = await response.json();
                if (result.success) {
                    this.photos = [...result.photos, ...this.photos];
                    Swal.fire({
                        icon: 'success',
                        title: 'Photos Uploaded!',
                        text: result.message || 'Your photos have been added to your gallery.',
                        timer: 2000,
                        showConfirmButton: false,
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    const errorMsg = result.message || (result.errors ? Object.values(result.errors).flat().join('<br>') : 'Error uploading photos');
                    Swal.fire({
                        icon: 'error',
                        title: 'Upload Failed',
                        html: errorMsg,
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    });
                }
            } catch (error) {
                console.error('Upload Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'An error occurred while uploading. Please try again.',
                    customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                });
            } finally {
                this.isUploading = false;
            }
        },

        async setAsProfile(photo) {
            try {
                const response = await fetch('{{ route("photos.set-profile") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ photo_id: photo.id })
                });

                const result = await response.json();
                if (result.success) {
                    this.profileImageUrl = result.image_url;
                    this.photos = this.photos.map(p => {
                        p.is_profile_picture = (p.id === photo.id);
                        return p;
                    });

                    Swal.fire({
                        icon: 'success',
                        title: 'Profile Picture Updated!',
                        text: 'This photo is now your main profile picture.',
                        timer: 2000,
                        showConfirmButton: false,
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: result.message || 'Could not update profile picture.',
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    });
                }
            } catch (error) {
                console.error('Error setting profile photo:', error);
            }
        },

        async deletePhoto(photo) {
            const confirmation = await Swal.fire({
                title: 'Delete this photo?',
                text: 'This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it',
                cancelButtonText: 'Cancel',
                customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
            });

            if (!confirmation.isConfirmed) return;

            try {
                const response = await fetch('{{ route("photos.delete") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({ photo_id: photo.id })
                });

                const result = await response.json();
                if (result.success) {
                    this.photos = this.photos.filter(p => p.id !== photo.id);
                    if (result.was_profile_picture && result.new_profile_url) {
                        this.profileImageUrl = result.new_profile_url;
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Photo has been removed from your gallery.',
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    }).then(() => {
                        window.location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Failed',
                        text: result.message || 'Could not delete photo.',
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    });
                }
            } catch (error) {
                console.error('Delete Error:', error);
            }
        },

        async saveSettings() {
            this.isSavingSettings = true;
            try {
                const response = await fetch('{{ route("photos.settings") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify(this.settings)
                });

                const result = await response.json();
                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Settings Saved!',
                        text: result.message || 'Your photo privacy settings have been updated.',
                        timer: 2000,
                        showConfirmButton: false,
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.message || 'Could not save settings.',
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
                    });
                }
            } catch (error) {
                console.error(error);
            } finally {
                this.isSavingSettings = false;
            }
        }
    };
};

if (window.Alpine) {
    Alpine.data('galleryManager', window.galleryManager);
} else {
    document.addEventListener('alpine:init', () => {
        Alpine.data('galleryManager', window.galleryManager);
    });
}
</script>
@endsection
