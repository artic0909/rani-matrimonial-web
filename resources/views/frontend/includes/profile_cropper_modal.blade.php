<!-- WhatsApp / Facebook style Profile Picture Cropper Modal (Royal Rani Theme) -->
<div x-show="isCropperOpen" 
     x-cloak 
     class="fixed inset-0 z-[100] flex items-center justify-center p-2.5 sm:p-4 bg-black/85 backdrop-blur-md"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @keydown.escape.window="closeCropper()">

    <div @click.away="closeCropper()" 
         class="bg-[#12070c] text-white rounded-2xl sm:rounded-3xl max-w-2xl w-full shadow-2xl border border-rani-gold/40 relative overflow-hidden flex flex-col max-h-[94vh]">
        
        <!-- Top Royal Gold Accent Bar -->
        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold"></div>

        <!-- Header -->
        <div class="px-4 sm:px-6 py-3 sm:py-4 border-b border-rani-gold/20 flex items-center justify-between bg-gradient-to-r from-rani-dark/90 via-[#1e0a13] to-rani-dark/90 shrink-0">
            <div class="flex items-center gap-2.5 sm:gap-3">
                <div class="p-1.5 sm:p-2 rounded-xl bg-rani-primary/30 text-rani-gold border border-rani-gold/30 shadow-xs">
                    <svg class="w-4 h-4 sm:w-5 sm:h-5 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base sm:text-lg font-bold font-serif text-white tracking-wide flex items-center gap-1.5">
                        <span>Adjust Profile Photo</span>
                    </h3>
                    <p class="text-[11px] sm:text-xs text-gray-300">Drag to position & scroll/slide to zoom</p>
                </div>
            </div>
            <button type="button" @click="closeCropper()" class="text-gray-400 hover:text-white p-1.5 sm:p-2 rounded-full hover:bg-white/10 transition-colors" title="Cancel & Close">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Cropper Canvas Body -->
        <div class="p-3 sm:p-5 md:p-6 overflow-y-auto flex-1 space-y-3 sm:space-y-4">
            
            <div class="grid grid-cols-1 md:grid-cols-12 gap-3 sm:gap-4 items-center">
                <!-- Main Cropper Viewport -->
                <div class="md:col-span-8 bg-black/95 rounded-2xl overflow-hidden border border-rani-gold/30 relative flex items-center justify-center min-h-[260px] sm:min-h-[320px] max-h-[360px] sm:max-h-[400px]">
                    <div id="cropper-viewport-wrapper" class="w-full h-full flex items-center justify-center overflow-hidden" :class="cropShape === 'circle' ? 'cropper-circle-mode' : 'cropper-square-mode'">
                        <img id="cropper-target-image" src="" alt="Crop Image" class="max-h-[360px] max-w-full block">
                    </div>
                </div>

                <!-- Right Side: Live Circular & Square Preview -->
                <div class="md:col-span-4 flex flex-col items-center justify-center p-3 sm:p-4 bg-rani-dark/60 rounded-2xl border border-rani-gold/20 text-center space-y-2.5 sm:space-y-3">
                    <span class="text-[10px] sm:text-[11px] font-bold text-rani-gold uppercase tracking-wider flex items-center gap-1">
                        <svg class="w-3.5 h-3.5 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                        Live Profile Preview
                    </span>
                    
                    <!-- Circular Preview -->
                    <div class="relative">
                        <div class="w-24 h-24 sm:w-32 sm:h-32 rounded-full border-3 border-rani-gold shadow-xl overflow-hidden bg-black flex items-center justify-center ring-2 ring-rani-gold/30">
                            <canvas id="cropper-live-preview" class="w-full h-full object-cover"></canvas>
                        </div>
                        <span class="absolute -bottom-1.5 left-1/2 transform -translate-x-1/2 bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white text-[9px] font-bold px-2.5 py-0.5 rounded-full border border-rani-gold/40 shadow-md whitespace-nowrap">
                            As seen by matches
                        </span>
                    </div>

                    <p class="text-[10px] sm:text-[11px] text-gray-300 leading-snug pt-1">
                        Centered frame displayed across search results & match cards.
                    </p>
                </div>
            </div>

            <!-- Toolbar Controls -->
            <div class="bg-rani-dark/80 rounded-2xl p-3 sm:p-4 border border-rani-gold/25 space-y-2.5 sm:space-y-3">
                
                <!-- Zoom Control Slider -->
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <span class="text-xs font-semibold text-gray-200 shrink-0 flex items-center gap-1.5">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path></svg>
                        Zoom
                    </span>
                    <button type="button" @click="cropperZoom(-0.1)" class="w-7 h-7 rounded-lg bg-white/10 hover:bg-white/20 text-white font-bold flex items-center justify-center text-sm transition-colors border border-white/10" title="Zoom Out">−</button>
                    <input type="range" min="0.5" max="3" step="0.05" x-model="cropperZoomLevel" @input="cropperZoomTo($event.target.value)" class="flex-1 accent-rani-gold cursor-pointer h-2 bg-black/50 rounded-lg">
                    <button type="button" @click="cropperZoom(0.1)" class="w-7 h-7 rounded-lg bg-white/10 hover:bg-white/20 text-white font-bold flex items-center justify-center text-sm transition-colors border border-white/10" title="Zoom In">+</button>
                </div>

                <!-- Shape and Rotation Action Buttons -->
                <div class="flex flex-wrap items-center justify-between gap-2 pt-1 border-t border-rani-gold/15">
                    <!-- Shape Switcher (With Royal SVG Icons) -->
                    <div class="flex items-center gap-1 bg-black/60 p-1 rounded-xl border border-rani-gold/20">
                        <button type="button" 
                                @click="setCropShape('circle')" 
                                :class="cropShape === 'circle' ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white font-bold shadow-xs border border-rani-gold/30' : 'text-gray-400 hover:text-white'"
                                class="px-2.5 sm:px-3 py-1 rounded-lg text-[11px] sm:text-xs flex items-center gap-1.5 transition-all">
                            <svg class="w-3.5 h-3.5 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9" stroke-width="2.5"></circle></svg>
                            <span>Circle</span>
                        </button>
                        <button type="button" 
                                @click="setCropShape('square')" 
                                :class="cropShape === 'square' ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white font-bold shadow-xs border border-rani-gold/30' : 'text-gray-400 hover:text-white'"
                                class="px-2.5 sm:px-3 py-1 rounded-lg text-[11px] sm:text-xs flex items-center gap-1.5 transition-all">
                            <svg class="w-3.5 h-3.5 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><rect x="4" y="4" width="16" height="16" rx="2" stroke-width="2.5"></rect></svg>
                            <span>Square</span>
                        </button>
                    </div>

                    <!-- Rotate & Flip Buttons (With SVG Icons) -->
                    <div class="flex items-center gap-1 sm:gap-1.5">
                        <button type="button" @click="cropperRotate(-90)" class="p-1.5 sm:p-2 rounded-xl bg-white/10 hover:bg-white/20 text-gray-200 hover:text-white text-xs font-semibold flex items-center gap-1.5 transition-colors border border-white/10" title="Rotate Left 90°">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                            <span class="hidden sm:inline">Rotate Left</span>
                        </button>
                        <button type="button" @click="cropperRotate(90)" class="p-1.5 sm:p-2 rounded-xl bg-white/10 hover:bg-white/20 text-gray-200 hover:text-white text-xs font-semibold flex items-center gap-1.5 transition-colors border border-white/10" title="Rotate Right 90°">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10h-10a8 8 0 00-8 8v2M21 10l-6 6m6-6l-6-6"></path></svg>
                            <span class="hidden sm:inline">Rotate Right</span>
                        </button>
                        <button type="button" @click="cropperReset()" class="p-1.5 sm:p-2 rounded-xl bg-white/10 hover:bg-white/20 text-gray-200 hover:text-white text-xs font-semibold flex items-center gap-1.5 transition-colors border border-white/10" title="Reset to default">
                            <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            <span class="hidden sm:inline">Reset</span>
                        </button>
                    </div>
                </div>

            </div>

        </div>

        <!-- Footer Buttons -->
        <div class="px-4 sm:px-6 py-3 sm:py-4 bg-gradient-to-r from-rani-dark via-[#1e0a13] to-rani-dark border-t border-rani-gold/20 flex items-center justify-between gap-3 sm:gap-4 shrink-0">
            <button type="button" 
                    @click="closeCropper()" 
                    class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-gray-200 font-semibold text-xs transition-colors border border-white/10">
                Cancel
            </button>

            <button type="button" 
                    @click="saveCroppedProfilePicture()" 
                    :disabled="isSavingCrop"
                    class="px-4 sm:px-6 py-2 sm:py-2.5 rounded-xl bg-gradient-to-r from-rani-primary via-rani-primary-dark to-rani-primary hover:from-rani-primary-dark hover:to-rani-primary text-white font-bold text-xs shadow-lg hover:shadow-rani-gold/20 hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-1.5 sm:gap-2 cursor-pointer disabled:opacity-50 disabled:pointer-events-none border border-rani-gold/40">
                <template x-if="!isSavingCrop">
                    <span class="flex items-center gap-1.5 sm:gap-2">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        <span>Set as Profile Photo</span>
                    </span>
                </template>
                <template x-if="isSavingCrop">
                    <span class="flex items-center gap-1.5 sm:gap-2">
                        <svg class="animate-spin w-3.5 h-3.5 sm:w-4 sm:h-4 text-rani-gold" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        <span>Saving Photo...</span>
                    </span>
                </template>
            </button>
        </div>

    </div>
</div>
