<!-- WhatsApp / Facebook style Profile Picture Cropper Modal -->
<div x-show="isCropperOpen" 
     x-cloak 
     class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-black/85 backdrop-blur-md"
     x-transition:enter="transition ease-out duration-300"
     x-transition:enter-start="opacity-0"
     x-transition:enter-end="opacity-100"
     x-transition:leave="transition ease-in duration-200"
     x-transition:leave-start="opacity-100"
     x-transition:leave-end="opacity-0"
     @keydown.escape.window="closeCropper()">

    <div @click.away="closeCropper()" 
         class="bg-gray-900 text-white rounded-3xl max-w-2xl w-full shadow-2xl border border-rani-gold/40 relative overflow-hidden flex flex-col max-h-[92vh]">
        
        <!-- Top Accent Bar -->
        <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-rani-gold via-rani-primary to-rani-gold"></div>

        <!-- Header -->
        <div class="px-6 py-4 border-b border-gray-800 flex items-center justify-between bg-black/40 shrink-0">
            <div class="flex items-center gap-2.5">
                <div class="p-2 rounded-xl bg-rani-primary/20 text-rani-gold border border-rani-gold/30">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-lg font-bold font-serif text-white tracking-wide">Adjust Profile Photo</h3>
                    <p class="text-xs text-gray-400">Drag to position & scroll/slide to zoom (WhatsApp & Facebook style)</p>
                </div>
            </div>
            <button type="button" @click="closeCropper()" class="text-gray-400 hover:text-white p-2 rounded-full hover:bg-gray-800 transition-colors" title="Cancel & Close">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Cropper Canvas Body -->
        <div class="p-4 sm:p-6 overflow-y-auto flex-1 space-y-4">
            
            <div class="grid grid-cols-1 md:grid-cols-12 gap-4 items-center">
                <!-- Main Cropper Viewport -->
                <div class="md:col-span-8 bg-black/90 rounded-2xl overflow-hidden border border-gray-800 relative flex items-center justify-center min-h-[320px] max-h-[400px]">
                    <div id="cropper-viewport-wrapper" class="w-full h-full flex items-center justify-center overflow-hidden" :class="cropShape === 'circle' ? 'cropper-circle-mode' : 'cropper-square-mode'">
                        <img id="cropper-target-image" src="" alt="Crop Image" class="max-h-[380px] max-w-full block">
                    </div>
                </div>

                <!-- Right Side: Live Circular & Square Preview -->
                <div class="md:col-span-4 flex flex-col items-center justify-center p-4 bg-gray-800/60 rounded-2xl border border-gray-700/60 text-center space-y-3">
                    <span class="text-[11px] font-bold text-rani-gold uppercase tracking-wider">Live Profile Preview</span>
                    
                    <!-- Circular Preview (WhatsApp / Profile Card Style) -->
                    <div class="relative">
                        <div class="w-28 h-28 sm:w-32 sm:h-32 rounded-full border-3 border-rani-gold shadow-xl overflow-hidden bg-black flex items-center justify-center">
                            <canvas id="cropper-live-preview" class="w-full h-full object-cover"></canvas>
                        </div>
                        <span class="absolute -bottom-1.5 left-1/2 transform -translate-x-1/2 bg-rani-primary text-white text-[9px] font-bold px-2 py-0.5 rounded-full border border-rani-gold/40 shadow whitespace-nowrap">
                            As seen by others
                        </span>
                    </div>

                    <p class="text-[11px] text-gray-400 leading-snug pt-1">
                        Your face will appear centered in this circular frame across matches & profile cards.
                    </p>
                </div>
            </div>

            <!-- Toolbar Controls -->
            <div class="bg-gray-800/80 rounded-2xl p-4 border border-gray-700/70 space-y-3">
                
                <!-- Zoom Control Slider -->
                <div class="flex items-center gap-3">
                    <span class="text-xs font-semibold text-gray-300 shrink-0 flex items-center gap-1">
                        <svg class="w-4 h-4 text-rani-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v6m3-3H7"></path></svg>
                        Zoom
                    </span>
                    <button type="button" @click="cropperZoom(-0.1)" class="w-7 h-7 rounded-lg bg-gray-700 hover:bg-gray-600 text-white font-bold flex items-center justify-center text-sm transition-colors" title="Zoom Out">−</button>
                    <input type="range" min="0.5" max="3" step="0.05" x-model="cropperZoomLevel" @input="cropperZoomTo($event.target.value)" class="flex-1 accent-rani-gold cursor-pointer h-2 bg-gray-700 rounded-lg">
                    <button type="button" @click="cropperZoom(0.1)" class="w-7 h-7 rounded-lg bg-gray-700 hover:bg-gray-600 text-white font-bold flex items-center justify-center text-sm transition-colors" title="Zoom In">+</button>
                </div>

                <!-- Shape and Rotation Action Buttons -->
                <div class="flex flex-wrap items-center justify-between gap-2 pt-1 border-t border-gray-700/60">
                    <!-- Shape Switcher -->
                    <div class="flex items-center gap-1.5 bg-gray-900/80 p-1 rounded-xl border border-gray-700">
                        <button type="button" 
                                @click="setCropShape('circle')" 
                                :class="cropShape === 'circle' ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white font-bold shadow-xs' : 'text-gray-400 hover:text-white'"
                                class="px-3 py-1 rounded-lg text-xs flex items-center gap-1 transition-all">
                            <span>⭕</span> Circle Frame
                        </button>
                        <button type="button" 
                                @click="setCropShape('square')" 
                                :class="cropShape === 'square' ? 'bg-gradient-to-r from-rani-primary to-rani-primary-dark text-white font-bold shadow-xs' : 'text-gray-400 hover:text-white'"
                                class="px-3 py-1 rounded-lg text-xs flex items-center gap-1 transition-all">
                            <span>⬛</span> Square Frame
                        </button>
                    </div>

                    <!-- Rotate & Flip Buttons -->
                    <div class="flex items-center gap-1.5">
                        <button type="button" @click="cropperRotate(-90)" class="p-2 rounded-xl bg-gray-700 hover:bg-gray-600 text-gray-200 hover:text-white text-xs font-semibold flex items-center gap-1 transition-colors" title="Rotate Left 90°">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h10a8 8 0 018 8v2M3 10l6 6m-6-6l6-6"></path></svg>
                            <span class="hidden sm:inline">Rotate Left</span>
                        </button>
                        <button type="button" @click="cropperRotate(90)" class="p-2 rounded-xl bg-gray-700 hover:bg-gray-600 text-gray-200 hover:text-white text-xs font-semibold flex items-center gap-1 transition-colors" title="Rotate Right 90°">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 10h-10a8 8 0 00-8 8v2M21 10l-6 6m6-6l-6-6"></path></svg>
                            <span class="hidden sm:inline">Rotate Right</span>
                        </button>
                        <button type="button" @click="cropperReset()" class="p-2 rounded-xl bg-gray-700 hover:bg-gray-600 text-gray-200 hover:text-white text-xs font-semibold flex items-center gap-1 transition-colors" title="Reset to default">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path></svg>
                            <span class="hidden sm:inline">Reset</span>
                        </button>
                    </div>
                </div>

            </div>

        </div>

        <!-- Footer Buttons -->
        <div class="px-6 py-4 bg-black/40 border-t border-gray-800 flex items-center justify-between gap-4 shrink-0">
            <button type="button" 
                    @click="closeCropper()" 
                    class="px-5 py-2.5 rounded-xl bg-gray-800 hover:bg-gray-700 text-gray-300 font-semibold text-xs transition-colors">
                Cancel
            </button>

            <button type="button" 
                    @click="saveCroppedProfilePicture()" 
                    :disabled="isSavingCrop"
                    class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-rani-gold via-yellow-500 to-rani-gold text-rani-dark font-extrabold text-xs shadow-lg hover:shadow-rani-gold/30 hover:scale-[1.02] active:scale-95 transition-all flex items-center gap-2 cursor-pointer disabled:opacity-50 disabled:pointer-events-none">
                <template x-if="!isSavingCrop">
                    <span class="flex items-center gap-2">
                        <svg class="w-4 h-4 text-rani-dark" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                        Set as Profile Photo
                    </span>
                </template>
                <template x-if="isSavingCrop">
                    <span class="flex items-center gap-2">
                        <svg class="animate-spin w-4 h-4 text-rani-dark" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        Saving Photo...
                    </span>
                </template>
            </button>
        </div>

    </div>
</div>
