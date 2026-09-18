@extends('frontend.layouts.auth_app')

@section('title', 'Support Desk & Tickets | Rani Matrimonial')

@section('content')
<div class="relative pt-4 sm:pt-6 pb-16 sm:pb-20" x-data="{ 
    showCreateForm: {{ $errors->any() ? 'true' : 'false' }},
    isSubmitting: false,
    selectedImageModal: null,
    previewUrls: [],
    handleFiles(event) {
        this.previewUrls = [];
        const files = event.target.files;
        if (files) {
            for (let i = 0; i < files.length; i++) {
                this.previewUrls.push(URL.createObjectURL(files[i]));
            }
        }
    },
    toggleCreateForm() {
        this.showCreateForm = !this.showCreateForm;
        if (this.showCreateForm) {
            this.$nextTick(() => {
                document.getElementById('ticketFormSection')?.scrollIntoView({ behavior: 'smooth', block: 'start' });
            });
        }
    }
}">
    <!-- Background Image -->
    <div class="fixed inset-0 z-0 bg-cover bg-top bg-no-repeat" style="background-image: url('{{ asset('img/hero.png') }}');"></div>
    
    <!-- Maroon/Gold Gradient Overlay (Subtle) -->
    <div class="fixed inset-0 z-0 bg-gradient-to-t from-rani-dark/85 via-rani-primary-dark/40 to-rani-primary-dark/20 pointer-events-none"></div>
    
    <!-- Floating Sweet Gestures (Hearts) -->
    <div class="fixed inset-0 z-0 overflow-hidden pointer-events-none heart-container opacity-40">
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

    <!-- Main Content Container -->
    <div class="relative z-10 max-w-6xl mx-auto px-3.5 sm:px-6 lg:px-8">
        
        <!-- Top Title & Raise Ticket Action Bar -->
        <div class="bg-white/95 backdrop-blur-md rounded-2xl sm:rounded-3xl p-5 sm:p-7 md:p-8 shadow-xl border border-rani-gold/30 mb-6 sm:mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4 sm:gap-5">
            <div class="flex items-center gap-3.5 sm:gap-4">
                <div class="w-12 h-12 sm:w-14 sm:h-14 rounded-xl sm:rounded-2xl bg-gradient-to-br from-rani-primary to-rani-primary-dark text-rani-gold flex items-center justify-center text-xl sm:text-2xl font-bold border border-rani-gold/40 shadow-md shrink-0">
                    <i class="ri-customer-service-2-line"></i>
                </div>
                <div>
                    <div class="flex items-center gap-1.5 sm:gap-2 text-[10px] sm:text-xs font-bold uppercase tracking-wider text-rani-primary mb-0.5 sm:mb-1">
                        <span>Candidate Support Desk</span>
                        <span>•</span>
                        <span class="font-mono text-gray-500">{{ $candidate->display_code }}</span>
                    </div>
                    <h1 class="text-xl sm:text-2xl md:text-3xl font-serif font-bold text-rani-dark leading-tight">
                        Support & Help Tickets
                    </h1>
                    <p class="text-[11px] sm:text-xs md:text-sm text-gray-500 mt-0.5 leading-snug">
                        Track your queries, view admin replies, and submit new support tickets with screenshots.
                    </p>
                </div>
            </div>

            <!-- Raise Ticket Button (Toggles Inline Form) -->
            <button @click="toggleCreateForm()" 
                class="inline-flex items-center justify-center gap-2 bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white font-bold py-3 sm:py-3.5 px-5 sm:px-6 rounded-xl sm:rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 active:scale-95 text-xs sm:text-sm border border-rani-gold/50 shrink-0">
                <i :class="showCreateForm ? 'ri-close-circle-fill text-amber-300' : 'ri-add-circle-fill text-amber-300'" class="text-base sm:text-lg"></i>
                <span x-text="showCreateForm ? 'Close Ticket' : 'Create Ticket'">Create Ticket</span>
            </button>
        </div>

        <!-- Themed Luxury Success & Error Alerts -->
        @if(session('success'))
            <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="mb-5 sm:mb-6 bg-gradient-to-r from-rani-dark via-rani-primary-dark to-rani-dark border-2 border-rani-gold/80 text-white p-4 sm:p-5 rounded-2xl sm:rounded-3xl shadow-2xl flex items-start justify-between gap-3.5 sm:gap-4 relative overflow-hidden backdrop-blur-md">
                <div class="absolute -right-8 -bottom-8 w-24 h-24 bg-rani-gold/15 rounded-full blur-xl pointer-events-none"></div>
                
                <div class="flex items-start gap-3 sm:gap-4 min-w-0">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-rani-gold/20 text-rani-gold flex items-center justify-center text-xl sm:text-2xl font-bold border border-rani-gold/40 shadow-inner shrink-0 mt-0.5">
                        <i class="ri-checkbox-circle-fill"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h4 class="font-serif font-bold text-sm sm:text-base md:text-lg text-rani-gold tracking-wide">
                            Ticket Submitted Successfully!
                        </h4>
                        <p class="text-xs sm:text-sm text-amber-100/90 mt-0.5 leading-relaxed font-light">
                            {{ session('success') }}
                        </p>
                    </div>
                </div>
                
                <button type="button" @click="show = false" class="text-rani-gold-light/70 hover:text-rani-gold p-1 rounded-lg transition shrink-0" title="Dismiss Alert">
                    <i class="ri-close-line text-xl sm:text-2xl"></i>
                </button>
            </div>
        @endif

        @if($errors->any())
            <div x-data="{ show: true }" x-show="show" x-transition.duration.300ms class="mb-5 sm:mb-6 bg-gradient-to-r from-rose-950 via-rani-dark to-rose-950 border-2 border-rose-500/70 text-white p-4 sm:p-5 rounded-2xl sm:rounded-3xl shadow-2xl flex items-start justify-between gap-3.5 sm:gap-4 relative overflow-hidden backdrop-blur-md">
                <div class="flex items-start gap-3 sm:gap-4 min-w-0">
                    <div class="w-10 h-10 sm:w-11 sm:h-11 rounded-xl bg-rose-500/20 text-rose-400 flex items-center justify-center text-xl sm:text-2xl font-bold border border-rose-500/40 shadow-inner shrink-0 mt-0.5">
                        <i class="ri-error-warning-fill"></i>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h4 class="font-serif font-bold text-sm sm:text-base md:text-lg text-rose-300 tracking-wide">
                            Please check the required fields:
                        </h4>
                        <ul class="list-disc list-inside text-xs sm:text-sm text-rose-200/90 mt-1 space-y-0.5">
                            @foreach($errors->all() as $err)
                                <li>{{ $err }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
                <button type="button" @click="show = false" class="text-rose-300/70 hover:text-rose-300 p-1 rounded-lg transition shrink-0" title="Dismiss Alert">
                    <i class="ri-close-line text-xl sm:text-2xl"></i>
                </button>
            </div>
        @endif

        <!-- Quick Summary Stats Grid (Side-by-Side on all viewports) -->
        <div class="grid grid-cols-3 gap-2 sm:gap-4 mb-6 sm:mb-8">
            
            <!-- Card 1: Total Tickets -->
            <div class="bg-white/95 backdrop-blur-md rounded-xl sm:rounded-2xl p-2.5 sm:p-5 border border-rani-gold/30 shadow-md flex flex-col sm:flex-row items-center sm:items-center text-center sm:text-left gap-1.5 sm:gap-4">
                <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-lg sm:rounded-xl bg-gray-100 text-gray-800 flex items-center justify-center text-sm sm:text-2xl font-bold shrink-0">
                    <i class="ri-ticket-2-line"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <span class="text-[8px] xs:text-[9px] sm:text-xs font-bold text-gray-400 uppercase tracking-wider block truncate">Total</span>
                    <div class="text-base xs:text-lg sm:text-2xl font-bold text-gray-900 leading-tight">{{ $counts['total'] }}</div>
                </div>
            </div>

            <!-- Card 2: Open / In Progress -->
            <div class="bg-white/95 backdrop-blur-md rounded-xl sm:rounded-2xl p-2.5 sm:p-5 border border-amber-300/60 shadow-md flex flex-col sm:flex-row items-center sm:items-center text-center sm:text-left gap-1.5 sm:gap-4">
                <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-lg sm:rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-sm sm:text-2xl font-bold border border-amber-200 shrink-0">
                    <i class="ri-time-line"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <span class="text-[8px] xs:text-[9px] sm:text-xs font-bold text-amber-700 uppercase tracking-wider block truncate">Open</span>
                    <div class="text-base xs:text-lg sm:text-2xl font-bold text-amber-900 leading-tight">{{ $counts['open'] }}</div>
                </div>
            </div>

            <!-- Card 3: Resolved -->
            <div class="bg-white/95 backdrop-blur-md rounded-xl sm:rounded-2xl p-2.5 sm:p-5 border border-emerald-300/60 shadow-md flex flex-col sm:flex-row items-center sm:items-center text-center sm:text-left gap-1.5 sm:gap-4">
                <div class="w-8 h-8 sm:w-12 sm:h-12 rounded-lg sm:rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-sm sm:text-2xl font-bold border border-emerald-200 shrink-0">
                    <i class="ri-checkbox-circle-line"></i>
                </div>
                <div class="min-w-0 flex-1">
                    <span class="text-[8px] xs:text-[9px] sm:text-xs font-bold text-emerald-700 uppercase tracking-wider block truncate">Resolved</span>
                    <div class="text-base xs:text-lg sm:text-2xl font-bold text-emerald-900 leading-tight">{{ $counts['resolved'] }}</div>
                </div>
            </div>

        </div>

        <!-- INLINE RAISE NEW TICKET FORM SECTION -->
        <div id="ticketFormSection" x-show="showCreateForm" x-cloak
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="opacity-0 -translate-y-4 scale-98"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100"
            x-transition:leave="transition ease-in duration-200 transform"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 -translate-y-4 scale-98"
            class="bg-white/95 backdrop-blur-md rounded-2xl sm:rounded-3xl border border-rani-gold/50 shadow-2xl overflow-hidden mb-6 sm:mb-8">
            
            <!-- Card Header -->
            <div class="bg-gradient-to-r from-rani-dark via-rani-primary-dark to-rani-primary text-white p-5 sm:p-6 flex items-center justify-between border-b border-rani-gold/30">
                <div class="flex items-center gap-2.5 sm:gap-3">
                    <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl sm:rounded-2xl bg-rani-gold/20 text-rani-gold flex items-center justify-center text-lg sm:text-xl font-bold border border-rani-gold/30 shrink-0">
                        <i class="ri-ticket-line"></i>
                    </div>
                    <div>
                        <h2 class="text-base sm:text-lg md:text-xl font-serif font-bold text-white">Raise New Support Ticket</h2>
                        <p class="text-[11px] sm:text-xs text-rani-gold-light/90">Auto-generated dynamic ticket code will be assigned upon submission</p>
                    </div>
                </div>
                <button type="button" @click="showCreateForm = false" class="text-white/80 hover:text-white p-1 rounded-lg transition" title="Close Form">
                    <i class="ri-close-line text-2xl"></i>
                </button>
            </div>

            <!-- Form Content -->
            <form action="{{ route('support.store') }}" method="POST" enctype="multipart/form-data" @submit="isSubmitting = true" class="p-5 sm:p-7 md:p-8 space-y-4 sm:space-y-5">
                @csrf

                <!-- Priority Choice -->
                <div>
                    <label class="block text-[11px] sm:text-xs font-bold text-gray-700 uppercase tracking-wider mb-2">
                        Select Priority <span class="text-red-500">*</span>
                    </label>
                    <div class="grid grid-cols-3 gap-2.5 sm:gap-3">
                        <label class="cursor-pointer">
                            <input type="radio" name="priority" value="low" checked class="peer sr-only">
                            <div class="p-2.5 sm:p-3 text-center rounded-xl sm:rounded-2xl border-2 border-gray-200 peer-checked:border-sky-500 peer-checked:bg-sky-50 transition hover:border-gray-300">
                                <div class="w-2.5 h-2.5 rounded-full bg-sky-500 mx-auto mb-1"></div>
                                <span class="text-xs font-bold text-gray-800 block">Low</span>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="priority" value="high" class="peer sr-only">
                            <div class="p-2.5 sm:p-3 text-center rounded-xl sm:rounded-2xl border-2 border-gray-200 peer-checked:border-amber-500 peer-checked:bg-amber-50 transition hover:border-gray-300">
                                <div class="w-2.5 h-2.5 rounded-full bg-amber-500 mx-auto mb-1"></div>
                                <span class="text-xs font-bold text-gray-800 block">High</span>
                            </div>
                        </label>

                        <label class="cursor-pointer">
                            <input type="radio" name="priority" value="urgent" class="peer sr-only">
                            <div class="p-2.5 sm:p-3 text-center rounded-xl sm:rounded-2xl border-2 border-gray-200 peer-checked:border-rose-500 peer-checked:bg-rose-50 transition hover:border-gray-300">
                                <div class="w-2.5 h-2.5 rounded-full bg-rose-500 mx-auto mb-1"></div>
                                <span class="text-xs font-bold text-gray-800 block">Urgent</span>
                            </div>
                        </label>
                    </div>
                </div>

                <!-- Subject -->
                <div>
                    <label for="ticket_subject" class="block text-[11px] sm:text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                        Ticket Subject <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="ticket_subject" name="subject" required
                        placeholder="Brief summary (e.g., Question regarding photo privacy or match request)"
                        class="w-full px-3.5 py-2.5 sm:py-3 rounded-xl border border-gray-300 focus:border-rani-primary focus:ring-2 focus:ring-rani-primary/20 transition text-xs sm:text-sm text-gray-900 bg-white">
                </div>

                <!-- Message -->
                <div>
                    <label for="ticket_message" class="block text-[11px] sm:text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                        Describe the Issue <span class="text-red-500">*</span>
                    </label>
                    <textarea id="ticket_message" name="message" rows="4" required
                        placeholder="Please provide full details of what you need help with..."
                        class="w-full px-3.5 py-2.5 sm:py-3 rounded-xl border border-gray-300 focus:border-rani-primary focus:ring-2 focus:ring-rani-primary/20 transition text-xs sm:text-sm text-gray-900 bg-white"></textarea>
                </div>

                <!-- Multiple Screenshots Upload -->
                <div>
                    <label class="block text-[11px] sm:text-xs font-bold text-gray-700 uppercase tracking-wider mb-1">
                        Upload Screenshots (Optional - Max 5 images)
                    </label>
                    <div class="relative border-2 border-dashed border-gray-300 hover:border-rani-primary rounded-xl sm:rounded-2xl p-3.5 sm:p-4 text-center cursor-pointer transition bg-gray-50/70">
                        <input type="file" name="screenshots[]" multiple accept="image/*" @change="handleFiles($event)"
                            class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                        <div class="space-y-1">
                            <i class="ri-image-add-line text-xl sm:text-2xl text-rani-primary"></i>
                            <div class="text-[11px] sm:text-xs text-gray-700 font-bold">
                                Click or Drag & Drop screenshots here
                            </div>
                            <p class="text-[10px] text-gray-400">PNG, JPG, JPEG, WEBP up to 5MB each</p>
                        </div>
                    </div>

                    <!-- Live File Preview -->
                    <template x-if="previewUrls.length > 0">
                        <div class="mt-2.5 sm:mt-3 flex flex-wrap gap-2">
                            <template x-for="(url, idx) in previewUrls" :key="idx">
                                <div class="relative w-14 h-14 sm:w-16 sm:h-16 rounded-xl overflow-hidden border border-gray-300 shadow-sm">
                                    <img :src="url" class="w-full h-full object-cover">
                                </div>
                            </template>
                        </div>
                    </template>
                </div>

                <!-- Form Actions -->
                <div class="flex items-center justify-end gap-2.5 sm:gap-4 pt-3.5 sm:pt-4 border-t border-gray-100">
                    <button type="button" @click="showCreateForm = false"
                        class="px-4 sm:px-5 py-2 sm:py-2.5 rounded-xl border border-gray-300 text-gray-700 font-semibold hover:bg-gray-100 text-xs sm:text-sm transition">
                        Cancel
                    </button>
                    <button type="submit"
                        class="bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white font-bold py-2 sm:py-2.5 px-5 sm:px-6 rounded-xl shadow-md text-xs sm:text-sm transition flex items-center gap-1.5 border border-rani-gold/40">
                        <i class="ri-check-line font-bold text-rani-gold"></i>
                        <span>Submit Ticket</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Tickets List -->
        <div class="space-y-4 sm:space-y-6">
            @forelse($tickets as $ticket)
                <div class="bg-white/95 backdrop-blur-md rounded-2xl sm:rounded-3xl p-5 sm:p-7 md:p-8 border border-rani-gold/30 shadow-xl hover:shadow-2xl transition duration-200">
                    
                    <!-- Ticket Meta Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 sm:gap-4 pb-3.5 sm:pb-4 border-b border-gray-100">
                        <div class="flex flex-wrap items-center gap-2 sm:gap-2.5">
                            <!-- Dynamic Ticket Code Pill -->
                            <span class="font-mono text-xs sm:text-sm md:text-base font-extrabold px-3 py-1 bg-gradient-to-r from-rani-dark to-rani-primary text-amber-300 rounded-xl border border-rani-gold/60 tracking-wider shadow-sm">
                                #{{ $ticket->ticket_code }}
                            </span>

                            <!-- Priority Badge -->
                            @if($ticket->priority === 'urgent')
                                <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold bg-rose-100 text-rose-800 border border-rose-300 uppercase tracking-wider flex items-center gap-1.5 shadow-sm">
                                    <span class="w-1.5 h-1.5 rounded-full bg-rose-500 animate-ping"></span>
                                    <i class="ri-alarm-warning-fill text-rose-600"></i> Urgent
                                </span>
                            @elseif($ticket->priority === 'high')
                                <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold bg-amber-100 text-amber-900 border border-amber-300 uppercase tracking-wider flex items-center gap-1">
                                    <i class="ri-alert-fill text-amber-600"></i> High
                                </span>
                            @else
                                <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold bg-sky-50 text-sky-800 border border-sky-200 uppercase tracking-wider">
                                    Low
                                </span>
                            @endif

                            <!-- Status Badge -->
                            @if($ticket->status === 'resolved')
                                <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300 uppercase tracking-wider flex items-center gap-1">
                                    <i class="ri-checkbox-circle-fill text-emerald-600"></i> Resolved
                                </span>
                            @elseif($ticket->status === 'in_progress')
                                <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold bg-indigo-100 text-indigo-800 border border-indigo-300 uppercase tracking-wider flex items-center gap-1">
                                    <i class="ri-loader-2-line text-indigo-600 animate-spin"></i> In Progress
                                </span>
                            @elseif($ticket->status === 'closed')
                                <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold bg-gray-200 text-gray-800 uppercase tracking-wider">
                                    Closed
                                </span>
                            @else
                                <span class="px-2.5 sm:px-3 py-0.5 sm:py-1 rounded-full text-[10px] sm:text-xs font-bold bg-amber-50 text-amber-800 border border-amber-300 uppercase tracking-wider">
                                    Open
                                </span>
                            @endif
                        </div>

                        <div class="text-[11px] sm:text-xs text-gray-400 font-medium">
                            Created on <span class="font-bold text-gray-700">{{ $ticket->created_at->format('M d, Y • h:i A') }}</span>
                        </div>
                    </div>

                    <!-- Subject & Description -->
                    <div class="mt-3 sm:mt-4">
                        <h3 class="text-base sm:text-lg md:text-xl font-serif font-bold text-gray-900 mb-1.5 sm:mb-2">
                            {{ $ticket->subject ?? 'Support Inquiry' }}
                        </h3>
                        <div class="text-xs sm:text-sm text-gray-700 whitespace-pre-line leading-relaxed bg-gray-50/80 p-3.5 sm:p-4 md:p-5 rounded-xl sm:rounded-2xl border border-gray-200">
                            {{ $ticket->message }}
                        </div>
                    </div>

                    <!-- Attached Screenshots Gallery -->
                    @if(!empty($ticket->screenshot_urls))
                        <div class="mt-3.5 sm:mt-4">
                            <span class="block text-[11px] sm:text-xs font-bold uppercase tracking-wider text-gray-400 mb-2 flex items-center gap-1">
                                <i class="ri-attachment-line text-rani-primary"></i> Attached Screenshots ({{ count($ticket->screenshot_urls) }}):
                            </span>
                            <div class="flex flex-wrap gap-2.5 sm:gap-3">
                                @foreach($ticket->screenshot_urls as $imgUrl)
                                    <button type="button" @click="selectedImageModal = '{{ $imgUrl }}'" class="group relative block w-16 h-16 sm:w-20 sm:h-20 rounded-xl overflow-hidden border-2 border-gray-200 hover:border-rani-primary shadow-sm transition">
                                        <img src="{{ $imgUrl }}" alt="Screenshot" class="w-full h-full object-cover group-hover:scale-105 transition duration-200">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white transition">
                                            <i class="ri-zoom-in-line text-lg sm:text-xl"></i>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Official Admin Reply Box (If Available) -->
                    @if($ticket->admin_reply)
                        <div class="mt-4 sm:mt-5 bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-300 rounded-xl sm:rounded-2xl p-4 sm:p-5 shadow-sm">
                            <div class="flex items-center justify-between gap-2 mb-2 pb-2 border-b border-amber-200">
                                <span class="text-[11px] sm:text-xs font-bold uppercase tracking-wider text-rani-primary flex items-center gap-1.5">
                                    <i class="ri-customer-service-2-fill text-amber-600"></i>
                                    Official Admin Support Resolution
                                </span>
                                @if($ticket->replied_at)
                                    <span class="text-[10px] sm:text-[11px] text-amber-900 font-bold font-mono">
                                        {{ $ticket->replied_at->format('M d, Y • h:i A') }}
                                    </span>
                                @endif
                            </div>
                            <div class="text-xs sm:text-sm text-gray-800 whitespace-pre-line leading-relaxed font-medium">
                                {{ $ticket->admin_reply }}
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white/95 backdrop-blur-md rounded-2xl sm:rounded-3xl p-8 sm:p-12 text-center border border-rani-gold/30 shadow-xl max-w-xl mx-auto">
                    <div class="w-14 h-14 sm:w-16 sm:h-16 rounded-full bg-rani-primary/10 text-rani-primary mx-auto flex items-center justify-center text-2xl sm:text-3xl mb-3 sm:mb-4 border border-rani-primary/20">
                        <i class="ri-inbox-line"></i>
                    </div>
                    <h3 class="text-lg sm:text-xl font-serif font-bold text-rani-dark mb-1">No Support Tickets Raised Yet</h3>
                    <p class="text-xs sm:text-sm text-gray-500 mb-5 sm:mb-6 max-w-sm mx-auto leading-relaxed">
                        Need assistance with your profile, matches, privacy or wallet? Submit a ticket and our support team will help you promptly.
                    </p>
                    <button @click="showCreateForm = true; $nextTick(() => { document.getElementById('ticketFormSection')?.scrollIntoView({ behavior: 'smooth', block: 'start' }); })" 
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white font-bold py-2.5 sm:py-3 px-5 sm:px-6 rounded-xl text-xs sm:text-sm shadow-md transition border border-rani-gold/40">
                        <i class="ri-add-circle-fill text-amber-300 text-sm sm:text-base"></i>
                        <span>Raise Your First Ticket</span>
                    </button>
                </div>
            @endforelse

            <div class="mt-6">
                {{ $tickets->links() }}
            </div>
        </div>

        <!-- IMAGE PREVIEW LIGHTBOX MODAL (FOR SCREENSHOT ATTACHMENTS ONLY) -->
        <div x-show="selectedImageModal !== null" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-3 sm:p-4 bg-black/85 backdrop-blur-md"
            @click="selectedImageModal = null">
            <div class="relative max-w-4xl max-h-[90vh]" @click.stop>
                <button @click="selectedImageModal = null" class="absolute -top-9 sm:-top-10 right-0 text-white text-2xl sm:text-3xl hover:text-amber-400">
                    <i class="ri-close-circle-fill"></i>
                </button>
                <img :src="selectedImageModal" alt="Enlarged screenshot" class="max-w-full max-h-[85vh] rounded-xl sm:rounded-2xl shadow-2xl object-contain border border-white/20">
            </div>
        </div>

    </div>

    <!-- Submission Loader Overlay Popup Modal -->
    <div x-show="isSubmitting" x-cloak
        class="fixed inset-0 z-[999] flex items-center justify-center p-4 bg-black/80 backdrop-blur-md"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100">
        
        <div class="bg-gradient-to-b from-rani-dark via-rani-primary-dark to-rani-dark p-7 sm:p-9 rounded-3xl border-2 border-rani-gold/60 shadow-2xl text-center max-w-sm w-full mx-auto relative overflow-hidden"
            x-transition:enter="transition ease-out duration-300 transform"
            x-transition:enter-start="scale-90 translate-y-4"
            x-transition:enter-end="scale-100 translate-y-0">
            
            <!-- Decorative glow rings -->
            <div class="absolute -top-12 -left-12 w-28 h-28 bg-rani-gold/20 rounded-full blur-2xl pointer-events-none"></div>
            <div class="absolute -bottom-12 -right-12 w-28 h-28 bg-rani-primary/40 rounded-full blur-2xl pointer-events-none"></div>

            <!-- Animated Royal Spinner & Icon -->
            <div class="relative w-20 h-20 mx-auto mb-5 flex items-center justify-center">
                <div class="absolute inset-0 rounded-full border-4 border-rani-gold/20"></div>
                <div class="absolute inset-0 rounded-full border-4 border-transparent border-t-rani-gold border-r-rani-gold animate-spin"></div>
                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-rani-primary to-rani-primary-dark flex items-center justify-center text-rani-gold text-2xl shadow-inner border border-rani-gold/40">
                    <i class="ri-ticket-fill animate-pulse"></i>
                </div>
            </div>

            <h3 class="text-lg sm:text-xl font-serif font-bold text-white mb-1.5 tracking-wide">
                Submitting Support Ticket...
            </h3>
            <div class="flex items-center justify-center gap-2 mb-3">
                <div class="h-[1px] w-8 bg-rani-gold/60"></div>
                <div class="w-1.5 h-1.5 rounded-full bg-rani-gold"></div>
                <div class="h-[1px] w-8 bg-rani-gold/60"></div>
            </div>
            <p class="text-xs sm:text-[13px] text-rani-gold-light/90 leading-relaxed font-light">
                Please wait a moment while your ticket is registered and confirmation emails are dispatched.
            </p>
        </div>
    </div>
</div>
@endsection
