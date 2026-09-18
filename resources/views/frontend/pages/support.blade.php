@extends('frontend.layouts.auth_app')

@section('title', 'Support Desk & Tickets | Rani Matrimonial')

@section('content')
<div class="relative pt-6 pb-20" x-data="{ 
    createModalOpen: false,
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
    <div class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <!-- Top Title & Raise Ticket Action Bar -->
        <div class="bg-white/95 backdrop-blur-md rounded-3xl p-6 sm:p-8 shadow-xl border border-rani-gold/30 mb-8 flex flex-col md:flex-row md:items-center justify-between gap-5">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-rani-primary to-rani-primary-dark text-rani-gold flex items-center justify-center text-2xl font-bold border border-rani-gold/40 shadow-md shrink-0">
                    <i class="ri-customer-service-2-line"></i>
                </div>
                <div>
                    <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-wider text-rani-primary mb-1">
                        <span>Candidate Support Desk</span>
                        <span>•</span>
                        <span class="font-mono text-gray-500">{{ $candidate->display_code }}</span>
                    </div>
                    <h1 class="text-2xl sm:text-3xl font-serif font-bold text-rani-dark">
                        Support & Help Tickets
                    </h1>
                    <p class="text-xs sm:text-sm text-gray-500 mt-0.5">
                        Track your queries, view admin replies, and submit new support tickets with screenshots.
                    </p>
                </div>
            </div>

            <!-- Raise Ticket Button -->
            <button @click="createModalOpen = true" 
                class="inline-flex items-center justify-center gap-2.5 bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white font-bold py-3.5 px-6 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 active:scale-95 text-sm border border-rani-gold/50 shrink-0">
                <i class="ri-add-circle-fill text-lg text-amber-300"></i>
                <span>Raise New Ticket</span>
            </button>
        </div>

        <!-- Success & Error Alerts -->
        @if(session('success'))
            <div class="mb-6 bg-emerald-950/80 border-2 border-emerald-500/80 text-emerald-100 px-6 py-4 rounded-2xl flex items-start gap-3.5 shadow-2xl backdrop-blur-md">
                <i class="ri-checkbox-circle-fill text-2xl text-emerald-400 mt-0.5 shrink-0"></i>
                <div>
                    <h4 class="font-serif font-bold text-base text-white">Ticket Submitted Successfully</h4>
                    <p class="text-sm text-emerald-200/90 mt-0.5 leading-relaxed">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if($errors->any())
            <div class="mb-6 bg-rose-950/80 border-2 border-rose-500/80 text-rose-100 px-6 py-4 rounded-2xl flex items-start gap-3.5 shadow-2xl backdrop-blur-md">
                <i class="ri-error-warning-fill text-2xl text-rose-400 mt-0.5 shrink-0"></i>
                <div>
                    <h4 class="font-serif font-bold text-base text-white">Please check the required fields:</h4>
                    <ul class="list-disc list-inside text-sm text-rose-200/90 mt-1 space-y-0.5">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <!-- Quick Summary Stats Grid -->
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
            <div class="bg-white/95 backdrop-blur-md rounded-2xl p-5 border border-rani-gold/30 shadow-md flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-gray-100 text-gray-800 flex items-center justify-center text-2xl font-bold">
                    <i class="ri-ticket-2-line"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-gray-400 uppercase tracking-wider">Total Tickets</span>
                    <div class="text-2xl font-bold text-gray-900">{{ $counts['total'] }}</div>
                </div>
            </div>

            <div class="bg-white/95 backdrop-blur-md rounded-2xl p-5 border border-amber-300/60 shadow-md flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-amber-50 text-amber-600 flex items-center justify-center text-2xl font-bold border border-amber-200">
                    <i class="ri-time-line"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-amber-700 uppercase tracking-wider">Open / In Progress</span>
                    <div class="text-2xl font-bold text-amber-900">{{ $counts['open'] }}</div>
                </div>
            </div>

            <div class="bg-white/95 backdrop-blur-md rounded-2xl p-5 border border-emerald-300/60 shadow-md flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-emerald-50 text-emerald-600 flex items-center justify-center text-2xl font-bold border border-emerald-200">
                    <i class="ri-checkbox-circle-line"></i>
                </div>
                <div>
                    <span class="text-xs font-bold text-emerald-700 uppercase tracking-wider">Resolved Tickets</span>
                    <div class="text-2xl font-bold text-emerald-900">{{ $counts['resolved'] }}</div>
                </div>
            </div>
        </div>

        <!-- Tickets List -->
        <div class="space-y-6">
            @forelse($tickets as $ticket)
                <div class="bg-white/95 backdrop-blur-md rounded-3xl p-6 sm:p-8 border-2 border-rani-gold/30 shadow-xl hover:shadow-2xl transition duration-200">
                    
                    <!-- Ticket Meta Header -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-4 border-b border-gray-100">
                        <div class="flex flex-wrap items-center gap-2.5">
                            <!-- Dynamic Ticket Code Pill -->
                            <span class="font-mono text-sm sm:text-base font-extrabold px-3.5 py-1 bg-gradient-to-r from-rani-dark to-rani-primary text-amber-300 rounded-xl border border-rani-gold/60 tracking-wider shadow-sm">
                                #{{ $ticket->ticket_code }}
                            </span>

                            <!-- Priority Badge -->
                            @if($ticket->priority === 'urgent')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-800 border border-rose-300 uppercase tracking-wider flex items-center gap-1.5 shadow-sm">
                                    <span class="w-2 h-2 rounded-full bg-rose-500 animate-ping"></span>
                                    <i class="ri-alarm-warning-fill text-rose-600"></i> Urgent Priority
                                </span>
                            @elseif($ticket->priority === 'high')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-100 text-amber-900 border border-amber-300 uppercase tracking-wider flex items-center gap-1">
                                    <i class="ri-alert-fill text-amber-600"></i> High Priority
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-sky-50 text-sky-800 border border-sky-200 uppercase tracking-wider">
                                    Low Priority
                                </span>
                            @endif

                            <!-- Status Badge -->
                            @if($ticket->status === 'resolved')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-300 uppercase tracking-wider flex items-center gap-1">
                                    <i class="ri-checkbox-circle-fill text-emerald-600"></i> Resolved
                                </span>
                            @elseif($ticket->status === 'in_progress')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-indigo-100 text-indigo-800 border border-indigo-300 uppercase tracking-wider flex items-center gap-1">
                                    <i class="ri-loader-2-line text-indigo-600 animate-spin"></i> In Progress
                                </span>
                            @elseif($ticket->status === 'closed')
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-200 text-gray-800 uppercase tracking-wider">
                                    Closed
                                </span>
                            @else
                                <span class="px-3 py-1 rounded-full text-xs font-bold bg-amber-50 text-amber-800 border border-amber-300 uppercase tracking-wider">
                                    Open
                                </span>
                            @endif
                        </div>

                        <div class="text-xs text-gray-400 font-medium">
                            Created on <span class="font-bold text-gray-700">{{ $ticket->created_at->format('M d, Y • h:i A') }}</span>
                        </div>
                    </div>

                    <!-- Subject & Description -->
                    <div class="mt-4">
                        <h3 class="text-lg sm:text-xl font-serif font-bold text-gray-900 mb-2">
                            {{ $ticket->subject ?? 'Support Inquiry' }}
                        </h3>
                        <div class="text-sm text-gray-700 whitespace-pre-line leading-relaxed bg-gray-50/80 p-4 sm:p-5 rounded-2xl border border-gray-200">
                            {{ $ticket->message }}
                        </div>
                    </div>

                    <!-- Attached Screenshots Gallery -->
                    @if(!empty($ticket->screenshot_urls))
                        <div class="mt-4">
                            <span class="block text-xs font-bold uppercase tracking-wider text-gray-400 mb-2 flex items-center gap-1">
                                <i class="ri-attachment-line text-rani-primary"></i> Attached Screenshots ({{ count($ticket->screenshot_urls) }}):
                            </span>
                            <div class="flex flex-wrap gap-3">
                                @foreach($ticket->screenshot_urls as $imgUrl)
                                    <button type="button" @click="selectedImageModal = '{{ $imgUrl }}'" class="group relative block w-20 h-20 rounded-xl overflow-hidden border-2 border-gray-200 hover:border-rani-primary shadow-sm transition">
                                        <img src="{{ $imgUrl }}" alt="Screenshot" class="w-full h-full object-cover group-hover:scale-105 transition duration-200">
                                        <div class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-white transition">
                                            <i class="ri-zoom-in-line text-xl"></i>
                                        </div>
                                    </button>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    <!-- Official Admin Reply Box (If Available) -->
                    @if($ticket->admin_reply)
                        <div class="mt-5 bg-gradient-to-r from-amber-50 to-orange-50 border-2 border-amber-300 rounded-2xl p-5 shadow-sm">
                            <div class="flex items-center justify-between gap-2 mb-2 pb-2 border-b border-amber-200">
                                <span class="text-xs font-bold uppercase tracking-wider text-rani-primary flex items-center gap-1.5">
                                    <i class="ri-customer-service-2-fill text-amber-600"></i>
                                    Official Admin Support Resolution
                                </span>
                                @if($ticket->replied_at)
                                    <span class="text-[11px] text-amber-900 font-bold font-mono">
                                        {{ $ticket->replied_at->format('M d, Y • h:i A') }}
                                    </span>
                                @endif
                            </div>
                            <div class="text-sm text-gray-800 whitespace-pre-line leading-relaxed font-medium">
                                {{ $ticket->admin_reply }}
                            </div>
                        </div>
                    @endif
                </div>
            @empty
                <div class="bg-white/95 backdrop-blur-md rounded-3xl p-12 text-center border-2 border-rani-gold/30 shadow-xl max-w-xl mx-auto">
                    <div class="w-16 h-16 rounded-full bg-rani-primary/10 text-rani-primary mx-auto flex items-center justify-center text-3xl mb-4 border border-rani-primary/20">
                        <i class="ri-inbox-line"></i>
                    </div>
                    <h3 class="text-xl font-serif font-bold text-rani-dark mb-1">No Support Tickets Raised Yet</h3>
                    <p class="text-xs sm:text-sm text-gray-500 mb-6 max-w-sm mx-auto">
                        Need assistance with your profile, matches, privacy or wallet? Submit a ticket and our support team will help you promptly.
                    </p>
                    <button @click="createModalOpen = true" 
                        class="inline-flex items-center gap-2 bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white font-bold py-3 px-6 rounded-xl text-sm shadow-md transition border border-rani-gold/40">
                        <i class="ri-add-circle-fill text-amber-300 text-base"></i>
                        <span>Raise Your First Ticket</span>
                    </button>
                </div>
            @endforelse

            <div class="mt-6">
                {{ $tickets->links() }}
            </div>
        </div>

        <!-- CREATE NEW TICKET MODAL -->
        <div x-show="createModalOpen" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/75 backdrop-blur-sm"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="opacity-0"
            x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-150"
            x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0">
            
            <div @click.away="createModalOpen = false"
                class="bg-white rounded-3xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto border-2 border-rani-gold/40">
                
                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-rani-dark via-rani-primary-dark to-rani-primary text-white p-6 rounded-t-3xl flex items-center justify-between border-b border-rani-gold/30">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-2xl bg-rani-gold/20 text-rani-gold flex items-center justify-center text-xl font-bold border border-rani-gold/30">
                            <i class="ri-ticket-line"></i>
                        </div>
                        <div>
                            <h2 class="text-lg font-serif font-bold text-white">Raise Support Ticket</h2>
                            <p class="text-xs text-rani-gold-light/80">Auto-generated dynamic ticket code will be assigned</p>
                        </div>
                    </div>
                    <button @click="createModalOpen = false" class="text-white/80 hover:text-white p-1 rounded-lg">
                        <i class="ri-close-line text-2xl"></i>
                    </button>
                </div>

                <!-- Modal Form -->
                <form action="{{ route('support.store') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8 space-y-5">
                    @csrf

                    <!-- Priority Choice -->
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-gray-700 uppercase tracking-wider mb-2">
                            Select Priority <span class="text-red-500">*</span>
                        </label>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="cursor-pointer">
                                <input type="radio" name="priority" value="low" checked class="peer sr-only">
                                <div class="p-3 text-center rounded-2xl border-2 border-gray-200 peer-checked:border-sky-500 peer-checked:bg-sky-50 transition">
                                    <div class="w-3 h-3 rounded-full bg-sky-500 mx-auto mb-1"></div>
                                    <span class="text-xs font-bold text-gray-800 block">Low</span>
                                    <span class="text-[10px] text-gray-400">General Inquiry</span>
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="priority" value="high" class="peer sr-only">
                                <div class="p-3 text-center rounded-2xl border-2 border-gray-200 peer-checked:border-amber-500 peer-checked:bg-amber-50 transition">
                                    <div class="w-3 h-3 rounded-full bg-amber-500 mx-auto mb-1"></div>
                                    <span class="text-xs font-bold text-gray-800 block">High</span>
                                    <span class="text-[10px] text-gray-400">Account / Matches</span>
                                </div>
                            </label>

                            <label class="cursor-pointer">
                                <input type="radio" name="priority" value="urgent" class="peer sr-only">
                                <div class="p-3 text-center rounded-2xl border-2 border-gray-200 peer-checked:border-rose-500 peer-checked:bg-rose-50 transition">
                                    <div class="w-3 h-3 rounded-full bg-rose-500 mx-auto mb-1"></div>
                                    <span class="text-xs font-bold text-gray-800 block">Urgent</span>
                                    <span class="text-[10px] text-gray-400">Payment / Access</span>
                                </div>
                            </label>
                        </div>
                    </div>

                    <!-- Subject -->
                    <div>
                        <label for="ticket_subject" class="block text-xs sm:text-sm font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Ticket Subject <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="ticket_subject" name="subject" required
                            placeholder="Brief summary (e.g., Question regarding photo privacy or match request)"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-rani-primary focus:ring-2 focus:ring-rani-primary/20 transition text-sm text-gray-900">
                    </div>

                    <!-- Message -->
                    <div>
                        <label for="ticket_message" class="block text-xs sm:text-sm font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Describe the Issue <span class="text-red-500">*</span>
                        </label>
                        <textarea id="ticket_message" name="message" rows="4" required
                            placeholder="Please provide full details of what you need help with..."
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 focus:border-rani-primary focus:ring-2 focus:ring-rani-primary/20 transition text-sm text-gray-900"></textarea>
                    </div>

                    <!-- Multiple Screenshots Upload -->
                    <div>
                        <label class="block text-xs sm:text-sm font-bold text-gray-700 uppercase tracking-wider mb-1.5">
                            Upload Screenshots (Optional - Max 5 images)
                        </label>
                        <div class="relative border-2 border-dashed border-gray-300 hover:border-rani-primary rounded-2xl p-4 text-center cursor-pointer transition bg-gray-50/70">
                            <input type="file" name="screenshots[]" multiple accept="image/*" @change="handleFiles($event)"
                                class="absolute inset-0 w-full h-full opacity-0 cursor-pointer">
                            <div class="space-y-1">
                                <i class="ri-image-add-line text-2xl text-rani-primary"></i>
                                <div class="text-xs text-gray-700 font-bold">
                                    Click or Drag & Drop multiple screenshots here
                                </div>
                                <p class="text-[11px] text-gray-400">PNG, JPG, JPEG, WEBP up to 5MB each</p>
                            </div>
                        </div>

                        <!-- Live File Preview -->
                        <template x-if="previewUrls.length > 0">
                            <div class="mt-3 flex flex-wrap gap-2">
                                <template x-for="(url, idx) in previewUrls" :key="idx">
                                    <div class="relative w-16 h-16 rounded-xl overflow-hidden border border-gray-300 shadow-sm">
                                        <img :src="url" class="w-full h-full object-cover">
                                    </div>
                                </template>
                            </div>
                        </template>
                    </div>

                    <!-- Modal Actions -->
                    <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                        <button type="button" @click="createModalOpen = false"
                            class="px-5 py-2.5 rounded-xl border border-gray-300 text-gray-700 font-semibold hover:bg-gray-100 text-sm transition">
                            Cancel
                        </button>
                        <button type="submit"
                            class="bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white font-bold py-2.5 px-6 rounded-xl shadow-md text-sm transition flex items-center gap-2 border border-rani-gold/40">
                            <i class="ri-check-line font-bold text-rani-gold"></i>
                            <span>Submit Ticket</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

        <!-- IMAGE PREVIEW LIGHTBOX MODAL -->
        <div x-show="selectedImageModal !== null" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/85 backdrop-blur-md"
            @click="selectedImageModal = null">
            <div class="relative max-w-4xl max-h-[90vh]" @click.stop>
                <button @click="selectedImageModal = null" class="absolute -top-10 right-0 text-white text-3xl hover:text-amber-400">
                    <i class="ri-close-circle-fill"></i>
                </button>
                <img :src="selectedImageModal" alt="Enlarged screenshot" class="max-w-full max-h-[85vh] rounded-2xl shadow-2xl object-contain border border-white/20">
            </div>
        </div>

    </div>
</div>
@endsection
