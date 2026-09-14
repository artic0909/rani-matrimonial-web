<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Dashboard | Rani Matrimonial</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        [x-cloak] { display: none !important; }
    </style>
</head>
<body class="bg-gray-950 font-sans text-gray-200 min-h-screen flex flex-col selection:bg-rani-primary selection:text-white"
      x-data="adminDashboard()">
    
    <!-- Top Nav -->
    <header class="bg-gray-900 border-b border-gray-800 sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center gap-3">
                    <img src="{{ asset('logo.png') }}" class="w-9 h-9 object-contain rounded-full border border-rani-gold/40" alt="Logo">
                    <span class="text-lg font-serif font-bold text-white tracking-wide">Rani Matrimonial <span class="text-xs font-sans text-rani-gold font-semibold uppercase px-2 py-0.5 rounded-full bg-rani-gold/10 border border-rani-gold/30">Admin</span></span>
                </div>

                <div class="flex items-center gap-4">
                    <a href="{{ route('dashboard') }}" target="_blank" class="text-xs font-semibold text-gray-400 hover:text-white flex items-center gap-1">
                        <span>Candidate View</span>
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button type="submit" class="px-3.5 py-1.5 rounded-lg bg-gray-800 hover:bg-red-950 hover:text-red-300 text-xs font-semibold text-gray-300 transition-colors">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-8">
        
        <!-- Metrics Row -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">
            <div class="bg-gray-900/90 border border-gray-800 rounded-2xl p-5 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold">Total Candidates</p>
                    <p class="text-3xl font-bold font-serif text-white mt-1">{{ $totalCandidates }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-blue-500/10 text-blue-400 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                </div>
            </div>

            <div class="bg-gray-900/90 border border-amber-500/30 rounded-2xl p-5 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wider text-amber-400 font-semibold">Pending Blue Ticks</p>
                    <p class="text-3xl font-bold font-serif text-amber-300 mt-1">{{ count($pendingBlueTicks) }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-amber-500/10 text-amber-400 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <div class="bg-gray-900/90 border border-gray-800 rounded-2xl p-5 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold">Approved Blue Ticks</p>
                    <p class="text-3xl font-bold font-serif text-emerald-400 mt-1">{{ $approvedBlueTicks }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-emerald-500/10 text-emerald-400 flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>

            <div class="bg-gray-900/90 border border-gray-800 rounded-2xl p-5 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs uppercase tracking-wider text-gray-400 font-semibold">Total Connections</p>
                    <p class="text-3xl font-bold font-serif text-rani-gold mt-1">{{ $totalConnections }}</p>
                </div>
                <div class="w-12 h-12 rounded-xl bg-rani-gold/10 text-rani-gold flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Blue Tick Verification Requests Table -->
        <div class="bg-gray-900/90 border border-gray-800 rounded-3xl overflow-hidden shadow-xl mb-8">
            <div class="px-6 py-5 border-b border-gray-800 flex flex-col sm:flex-row items-start sm:items-center justify-between gap-3">
                <div>
                    <h2 class="text-lg font-serif font-bold text-white flex items-center gap-2">
                        <span>Blue Tick Verification Requests</span>
                        @if(count($pendingBlueTicks) > 0)
                            <span class="bg-amber-500 text-gray-950 font-bold text-xs px-2.5 py-0.5 rounded-full">{{ count($pendingBlueTicks) }} Needs Action</span>
                        @endif
                    </h2>
                    <p class="text-xs text-gray-400 mt-0.5">Review Aadhaar card photos and approve/reject genuine candidate profiles.</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs text-gray-300">
                    <thead class="bg-gray-950/80 uppercase text-[10px] tracking-wider text-gray-400 border-b border-gray-800">
                        <tr>
                            <th class="py-3.5 px-5">Candidate</th>
                            <th class="py-3.5 px-4">Aadhaar No.</th>
                            <th class="py-3.5 px-4">Front Card</th>
                            <th class="py-3.5 px-4">Back Card</th>
                            <th class="py-3.5 px-4">Submitted Date</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-5 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-800/60">
                        @forelse($recentRequests as $req)
                            <tr class="hover:bg-gray-800/40 transition-colors" id="row-{{ $req->id }}">
                                <td class="py-4 px-5">
                                    <div class="flex items-center gap-3">
                                        <img src="{{ $req->candidate && $req->candidate->profile_picture ? (str_starts_with($req->candidate->profile_picture, 'http') ? $req->candidate->profile_picture : asset('storage/' . $req->candidate->profile_picture)) : 'https://ui-avatars.com/api/?name=' . urlencode($req->candidate->first_name ?? 'C') . '&background=D4AF37&color=fff' }}" 
                                             class="w-10 h-10 rounded-full object-cover border border-gray-700">
                                        <div>
                                            <p class="font-bold text-white text-sm">{{ $req->candidate->first_name ?? 'Candidate' }} {{ $req->candidate->last_name ?? '' }}</p>
                                            <p class="text-[11px] text-gray-400 font-mono">{{ $req->candidate->getDisplayCodeAttribute() ?? 'ID' }} • {{ $req->candidate->mobile ?? 'No Mobile' }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-4 font-mono font-bold text-gray-200">
                                    {{ preg_replace('/(\d{4})(\d{4})(\d{4})/', '$1 $2 $3', $req->aadhar_number) }}
                                </td>
                                <td class="py-4 px-4">
                                    @if($req->aadhar_photo_front)
                                        <button type="button" @click="openImage('{{ asset('storage/' . $req->aadhar_photo_front) }}', 'Front Side - {{ $req->candidate->first_name ?? '' }}')" class="group relative rounded-xl overflow-hidden border border-gray-700 hover:border-rani-gold transition-all block w-20 h-14 bg-gray-950">
                                            <img src="{{ asset('storage/' . $req->aadhar_photo_front) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                            <span class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-[10px] text-white font-bold transition-opacity">View</span>
                                        </button>
                                    @else
                                        <span class="text-gray-500 italic">No Front</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4">
                                    @if($req->aadhar_photo_back)
                                        <button type="button" @click="openImage('{{ asset('storage/' . $req->aadhar_photo_back) }}', 'Back Side - {{ $req->candidate->first_name ?? '' }}')" class="group relative rounded-xl overflow-hidden border border-gray-700 hover:border-rani-gold transition-all block w-20 h-14 bg-gray-950">
                                            <img src="{{ asset('storage/' . $req->aadhar_photo_back) }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform">
                                            <span class="absolute inset-0 bg-black/40 opacity-0 group-hover:opacity-100 flex items-center justify-center text-[10px] text-white font-bold transition-opacity">View</span>
                                        </button>
                                    @else
                                        <span class="text-gray-500 italic">No Back</span>
                                    @endif
                                </td>
                                <td class="py-4 px-4 text-gray-400">
                                    <p>{{ $req->created_at ? $req->created_at->format('d M Y') : 'N/A' }}</p>
                                    <p class="text-[10px] text-gray-500">{{ $req->created_at ? $req->created_at->format('h:i A') : '' }}</p>
                                </td>
                                <td class="py-4 px-4" id="status-{{ $req->id }}">
                                    @if($req->is_accept === 1)
                                        <span class="inline-flex items-center gap-1 bg-emerald-950 text-emerald-300 border border-emerald-800 text-[11px] font-bold px-2.5 py-1 rounded-full">
                                            <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg>
                                            Verified
                                        </span>
                                    @elseif($req->is_accept === 2)
                                        <span class="inline-flex items-center gap-1 bg-red-950 text-red-300 border border-red-800 text-[11px] font-bold px-2.5 py-1 rounded-full">
                                            Rejected
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 bg-amber-950 text-amber-300 border border-amber-800 text-[11px] font-bold px-2.5 py-1 rounded-full">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                                            Pending Review
                                        </span>
                                    @endif
                                </td>
                                <td class="py-4 px-5 text-right">
                                    <div class="inline-flex items-center gap-2" id="actions-{{ $req->id }}">
                                        @if($req->is_accept === 0)
                                            <button type="button" @click="approveRequest({{ $req->id }}, '{{ $req->candidate->first_name ?? 'Candidate' }}')" class="px-3 py-1.5 rounded-lg bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-xs shadow-xs transition-colors">
                                                Approve
                                            </button>
                                            <button type="button" @click="rejectRequest({{ $req->id }}, '{{ $req->candidate->first_name ?? 'Candidate' }}')" class="px-3 py-1.5 rounded-lg bg-red-900/60 hover:bg-red-800 text-red-200 font-bold text-xs transition-colors">
                                                Reject
                                            </button>
                                        @elseif($req->is_accept === 1)
                                            <span class="text-xs text-emerald-400 font-semibold">Active Blue Tick</span>
                                        @else
                                            <button type="button" @click="approveRequest({{ $req->id }}, '{{ $req->candidate->first_name ?? 'Candidate' }}')" class="px-3 py-1.5 rounded-lg bg-gray-800 hover:bg-emerald-600 text-gray-300 hover:text-white text-xs font-bold transition-colors">
                                                Re-Approve
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-12 text-center text-gray-500 text-sm">
                                    No Blue Tick verification requests submitted yet.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

    </main>

    <!-- Image Preview Modal -->
    <div x-show="imageModalOpen" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/90 backdrop-blur-md"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0">
        
        <div @click.away="imageModalOpen = false" class="relative max-w-4xl max-h-[90vh] flex flex-col items-center">
            <button @click="imageModalOpen = false" class="absolute -top-12 right-0 text-white hover:text-gray-300 p-2 text-sm font-bold flex items-center gap-1">
                <span>Close</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <p class="text-xs text-gray-400 mb-2 font-mono" x-text="modalTitle"></p>
            <img :src="modalImage" class="max-h-[80vh] max-w-full rounded-2xl border-2 border-rani-gold shadow-2xl object-contain">
        </div>
    </div>

    <!-- Admin Dashboard Alpine Script -->
    <script>
    function adminDashboard() {
        return {
            imageModalOpen: false,
            modalImage: '',
            modalTitle: '',

            openImage(url, title) {
                this.modalImage = url;
                this.modalTitle = title || 'Aadhaar Document';
                this.imageModalOpen = true;
            },

            async approveRequest(id, name) {
                const confirm = await Swal.fire({
                    title: 'Approve Blue Tick?',
                    text: 'Verify ' + name + ' and activate the Blue Tick on their profile?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Yes, Approve',
                    cancelButtonText: 'Cancel',
                    background: '#111827',
                    color: '#fff',
                    confirmButtonColor: '#059669',
                    cancelButtonColor: '#374151'
                });

                if (!confirm.isConfirmed) return;

                try {
                    const res = await fetch('/admin/bluetick/' + id + '/approve', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        }
                    });

                    const data = await res.json();

                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Approved!',
                            text: data.message,
                            background: '#111827',
                            color: '#fff',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        document.getElementById('status-' + id).innerHTML = '<span class="inline-flex items-center gap-1 bg-emerald-950 text-emerald-300 border border-emerald-800 text-[11px] font-bold px-2.5 py-1 rounded-full"><svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path></svg> Verified</span>';
                        document.getElementById('actions-' + id).innerHTML = '<span class="text-xs text-emerald-400 font-semibold">Active Blue Tick</span>';
                    }
                } catch (e) {
                    console.error(e);
                }
            },

            async rejectRequest(id, name) {
                const { value: reason } = await Swal.fire({
                    title: 'Reject Blue Tick Request',
                    input: 'textarea',
                    inputLabel: 'Reason for Rejection',
                    inputPlaceholder: 'Enter reason (e.g. Aadhaar image is blurry or details mismatched)...',
                    showCancelButton: true,
                    confirmButtonText: 'Reject Request',
                    cancelButtonText: 'Cancel',
                    background: '#111827',
                    color: '#fff',
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#374151',
                    inputValidator: (value) => {
                        if (!value) {
                            return 'Please provide a reason for rejection.';
                        }
                    }
                });

                if (!reason) return;

                try {
                    const res = await fetch('/admin/bluetick/' + id + '/reject', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({ reason: reason })
                    });

                    const data = await res.json();

                    if (data.success) {
                        Swal.fire({
                            icon: 'info',
                            title: 'Rejected',
                            text: data.message,
                            background: '#111827',
                            color: '#fff',
                            timer: 2000,
                            showConfirmButton: false
                        });

                        document.getElementById('status-' + id).innerHTML = '<span class="inline-flex items-center gap-1 bg-red-950 text-red-300 border border-red-800 text-[11px] font-bold px-2.5 py-1 rounded-full">Rejected</span>';
                        document.getElementById('actions-' + id).innerHTML = '<button type="button" onclick="window.location.reload()" class="px-3 py-1.5 rounded-lg bg-gray-800 text-xs text-gray-300">Refresh</button>';
                    }
                } catch (e) {
                    console.error(e);
                }
            }
        };
    }
    </script>
</body>
</html>
