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
        <div class="heart-floating heart-maroon delay-3" style="left: 60%; animation-delay: 2s;"></div>
        <div class="heart-floating delay-4" style="left: 80%; animation-delay: 14s;"></div>
    </div>

    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Top Gallery Header Card -->
        <div class="bg-white/95 backdrop-blur-md rounded-3xl shadow-2xl border border-white/60 mb-10 p-6 md:p-10 relative overflow-hidden z-10 hover:shadow-rani-gold/10 transition-shadow duration-500">
            <!-- Subtle royal accent top -->
            <div class="absolute top-0 left-0 w-full h-2 bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold opacity-90"></div>
            
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div>
                    <div class="flex items-center gap-3 mb-2">
                        <span class="px-3.5 py-1 rounded-full text-xs font-bold uppercase tracking-wider bg-rani-light/50 text-rani-primary-dark border border-rani-gold/30">Photo Gallery</span>
                        <span class="text-sm font-semibold text-gray-500 font-sans">(<span x-text="photos.length"></span>/10 Photos Uploaded)</span>
                    </div>
                    <h1 class="text-3xl md:text-4xl font-bold text-rani-primary-dark font-serif tracking-wide drop-shadow-sm">Manage My Photos</h1>
                    <p class="text-sm text-gray-600 mt-1 max-w-xl">
                        Profiles with multiple photos receive up to <strong class="text-rani-primary">5x more connection requests</strong>. Upload clear, high-quality pictures.
                    </p>
                </div>

                <!-- Add Photos Button -->
                <div>
                    <label for="gallery_file_input" class="cursor-pointer inline-flex items-center gap-2.5 px-6 py-3.5 rounded-2xl bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white font-semibold text-sm shadow-xl hover:shadow-2xl hover:scale-105 active:scale-95 transition-all duration-300 border border-rani-gold/40">
                        <svg class="w-5 h-5 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        <span>Upload Photos</span>
                        <input type="file" id="gallery_file_input" class="hidden" accept="image/*" multiple @change="handleFileUpload">
                    </label>
                </div>
            </div>
        </div>

        <!-- Upload Drag & Drop Area (if under 10 photos) -->
        <div class="mb-10" x-show="photos.length < 10">
            <div class="border-2 border-dashed border-rani-gold/40 hover:border-rani-primary bg-white/80 hover:bg-white/95 backdrop-blur-md rounded-3xl p-8 md:p-12 text-center transition-all duration-300 cursor-pointer shadow-lg hover:shadow-xl group"
                 @click="document.getElementById('gallery_file_input').click()"
                 @dragover.prevent="isDragging = true"
                 @dragleave.prevent="isDragging = false"
                 @drop.prevent="handleFileDrop($event)">
                
                <div class="w-16 h-16 mx-auto mb-4 rounded-2xl bg-rani-light/40 border border-rani-gold/20 flex items-center justify-center text-rani-primary group-hover:scale-110 transition-transform">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>

                <h3 class="text-lg font-bold text-gray-800 font-serif mb-1">Drag and drop your photos here, or <span class="text-rani-primary underline">browse</span></h3>
                <p class="text-xs text-gray-500">Supports JPG, PNG, WEBP (Max 15MB each). You can select multiple images at once.</p>

                <!-- Loading State Indicator -->
                <div x-show="isUploading" style="display: none;" class="mt-4 inline-flex items-center gap-2 px-4 py-2 bg-rani-primary text-white rounded-full text-xs font-semibold shadow-md animate-pulse">
                    <svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                    Uploading & Compressing Photos...
                </div>
            </div>
        </div>

        <!-- Photos Grid -->
        <div class="space-y-6">
            <div class="flex items-center justify-between">
                <h2 class="text-2xl font-bold font-serif text-white tracking-wide drop-shadow-md">My Uploaded Photos</h2>
            </div>

            <!-- Empty State -->
            <template x-if="photos.length === 0">
                <div class="bg-white/95 backdrop-blur-md rounded-3xl p-12 text-center shadow-xl border border-white/60">
                    <div class="w-20 h-20 mx-auto mb-4 rounded-full bg-rani-light/40 flex items-center justify-center text-rani-gold border border-rani-gold/30">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-serif font-bold text-gray-800 mb-2">No Photos Uploaded Yet</h3>
                    <p class="text-gray-500 text-sm max-w-md mx-auto mb-6">Add your beautiful pictures to complete your profile and attract authentic matches.</p>
                    <button type="button" @click="document.getElementById('gallery_file_input').click()" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-rani-primary text-white font-semibold text-sm hover:bg-rani-primary-dark transition-all shadow-md">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                        Upload First Photo
                    </button>
                </div>
            </template>

            <!-- Gallery Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6" x-show="photos.length > 0">
                <template x-for="photo in photos" :key="photo.id">
                    <div class="bg-white/95 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden border border-white/60 group hover:shadow-2xl transition-all duration-300 flex flex-col justify-between">
                        
                        <!-- Image Frame -->
                        <div class="relative aspect-4/5 overflow-hidden bg-gray-100 cursor-pointer" @click="previewPhoto(photo)">
                            <img :src="photo.url" :alt="'Photo #' + photo.id" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            
                            <!-- Profile Picture Badge -->
                            <template x-if="photo.is_profile_picture">
                                <span class="absolute top-3 left-3 bg-gradient-to-r from-rani-gold to-yellow-500 text-rani-dark text-xs font-bold px-3 py-1 rounded-full shadow-lg border border-white flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"></path></svg>
                                    Main Profile
                                </span>
                            </template>

                            <!-- Hover Overlay -->
                            <div class="absolute inset-0 bg-black/30 opacity-0 group-hover:opacity-100 transition-opacity flex items-center justify-center text-white">
                                <span class="p-2.5 bg-black/50 rounded-full backdrop-blur-xs">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
                                </span>
                            </div>
                        </div>

                        <!-- Card Actions -->
                        <div class="p-4 bg-white flex items-center justify-between border-t border-gray-100 gap-2">
                            <template x-if="!photo.is_profile_picture">
                                <button type="button" @click="setAsProfile(photo)" class="text-xs font-bold text-rani-primary hover:text-rani-primary-dark hover:underline flex items-center gap-1 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Set Profile
                                </button>
                            </template>
                            <template x-if="photo.is_profile_picture">
                                <span class="text-xs font-semibold text-emerald-600 flex items-center gap-1">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                    Active Avatar
                                </span>
                            </template>

                            <button type="button" @click="deletePhoto(photo)" class="text-gray-400 hover:text-red-600 p-1.5 rounded-lg hover:bg-red-50 transition-colors" title="Delete Photo">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                            </button>
                        </div>
                    </div>
                </template>
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
        photos: @json($formattedPhotos ?? []),
        isUploading: false,
        isDragging: false,
        previewModalOpen: false,
        activePreviewUrl: '',

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

        async uploadFiles(files) {
            if (this.photos.length + files.length > 10) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Limit Exceeded',
                    text: 'You can have a maximum of 10 photos in your gallery.',
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
                    // Prepend newly uploaded photos
                    this.photos = [...result.photos, ...this.photos];
                    Swal.fire({
                        icon: 'success',
                        title: 'Photos Uploaded!',
                        text: result.message || 'Your photos have been added to your gallery.',
                        timer: 2000,
                        showConfirmButton: false,
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
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
                    if (result.was_profile_picture && this.photos.length > 0) {
                        this.photos[0].is_profile_picture = true;
                    }

                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted!',
                        text: 'Photo has been removed from your gallery.',
                        timer: 1500,
                        showConfirmButton: false,
                        customClass: { popup: 'rani-swal-popup', title: 'rani-swal-title', confirmButton: 'rani-swal-confirm' }
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
