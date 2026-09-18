@extends('admin.layouts.app')

@section('title', 'Candidate Support Tickets - Admin Panel')

@push('styles')
<style>
    .badge-urgent {
        background-color: #f8d7da;
        color: #842029;
        border: 1px solid #f5c2c7;
        font-weight: 700;
    }
    .badge-high {
        background-color: #fff3cd;
        color: #664d03;
        border: 1px solid #ffecb5;
        font-weight: 700;
    }
    .badge-low {
        background-color: #cff4fc;
        color: #055160;
        border: 1px solid #b6effb;
        font-weight: 700;
    }
    .screenshot-thumb {
        width: 64px;
        height: 64px;
        object-fit: cover;
        border-radius: 8px;
        cursor: pointer;
        border: 2px solid #dee2e6;
        transition: transform 0.2s, border-color 0.2s;
    }
    .screenshot-thumb:hover {
        transform: scale(1.05);
        border-color: #750000;
    }
    .ticket-code-pill {
        font-family: 'Courier New', Courier, monospace;
        font-weight: 800;
        background: #4a0404;
        color: #f9f1d8;
        padding: 3px 8px;
        border-radius: 6px;
        letter-spacing: 1px;
    }
    .candidate-card-box {
        background: #fdfbf7;
        border: 1px solid #ebd9b4;
        border-radius: 12px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">

    <!-- Page Title & Header Actions -->
    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
            <h1 class="h3 d-inline align-middle text-dark fw-bold">Candidate Support Desk</h1>
            <p class="text-muted small mb-0">Manage support tickets, track resolutions, and reply directly to candidate emails.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="{{ route('admin.tickets.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm rounded-pill px-3">
                <i class="align-middle" data-feather="rotate-cw"></i> Refresh Tickets
            </a>
        </div>
    </div>

    <!-- Stats Overview Tiles -->
    <div class="row mb-4">
        <div class="col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary-subtle text-primary p-3 rounded-4 me-3">
                            <i class="align-middle" data-feather="tag" style="width: 24px; height: 24px;"></i>
                        </div>
                        <div>
                            <span class="text-muted small text-uppercase fw-bold">Total Tickets</span>
                            <h3 class="fw-bold mb-0 text-dark">{{ $counts['total'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning-subtle text-warning p-3 rounded-4 me-3">
                            <i class="align-middle" data-feather="clock" style="width: 24px; height: 24px;"></i>
                        </div>
                        <div>
                            <span class="text-muted small text-uppercase fw-bold">Open / Pending</span>
                            <h3 class="fw-bold mb-0 text-warning">{{ $counts['open'] + $counts['in_progress'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-danger-subtle text-danger p-3 rounded-4 me-3">
                            <i class="align-middle" data-feather="alert-triangle" style="width: 24px; height: 24px;"></i>
                        </div>
                        <div>
                            <span class="text-muted small text-uppercase fw-bold">Urgent Attention</span>
                            <h3 class="fw-bold mb-0 text-danger">{{ $counts['urgent'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success-subtle text-success p-3 rounded-4 me-3">
                            <i class="align-middle" data-feather="check-circle" style="width: 24px; height: 24px;"></i>
                        </div>
                        <div>
                            <span class="text-muted small text-uppercase fw-bold">Resolved Tickets</span>
                            <h3 class="fw-bold mb-0 text-success">{{ $counts['resolved'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.tickets.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-4">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i data-feather="search" class="text-muted"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-0" placeholder="Search ticket code, candidate, subject..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select bg-light border-0" onchange="this.form.submit()">
                        <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Statuses</option>
                        <option value="open" {{ request('status') == 'open' ? 'selected' : '' }}>⏳ Open</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>🔄 In Progress</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>✅ Resolved</option>
                        <option value="closed" {{ request('status') == 'closed' ? 'selected' : '' }}>🔒 Closed</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="priority" class="form-select bg-light border-0" onchange="this.form.submit()">
                        <option value="all" {{ request('priority') == 'all' || !request('priority') ? 'selected' : '' }}>All Priorities</option>
                        <option value="urgent" {{ request('priority') == 'urgent' ? 'selected' : '' }}>🚨 Urgent Only</option>
                        <option value="high" {{ request('priority') == 'high' ? 'selected' : '' }}>⚡ High Only</option>
                        <option value="low" {{ request('priority') == 'low' ? 'selected' : '' }}>ℹ️ Low Only</option>
                    </select>
                </div>
                <div class="col-md-2 text-md-end">
                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-3">Filter</button>
                    @if(request()->hasAny(['search', 'status', 'priority']))
                        <a href="{{ route('admin.tickets.index') }}" class="btn btn-light btn-sm rounded-pill px-2">Clear</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Tickets Table Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white border-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold text-dark mb-0">Support Tickets</h5>
            <span class="badge bg-light text-muted border px-2 py-1">{{ $tickets->total() }} Total</span>
        </div>
        <div class="card-body px-0 pt-0 pb-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4">Ticket Code</th>
                            <th>Candidate</th>
                            <th>Priority</th>
                            <th>Subject & Details</th>
                            <th>Status</th>
                            <th>Raised At</th>
                            <th class="text-end pe-4" style="width: 140px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr id="ticket-row-{{ $ticket->id }}">
                                <td class="ps-4">
                                    <span class="ticket-code-pill">{{ $ticket->ticket_code }}</span>
                                </td>
                                <td>
                                    @if($ticket->candidate)
                                        <div class="d-flex align-items-center">
                                            <img src="{{ $ticket->candidate->profile_picture ? asset('storage/' . $ticket->candidate->profile_picture) : 'https://ui-avatars.com/api/?name='.urlencode($ticket->candidate->first_name).'&background=4a0404&color=d4af37' }}" 
                                                 alt="Candidate" class="rounded-circle me-2 border" style="width: 38px; height: 38px; object-fit: cover;">
                                            <div>
                                                <div class="fw-bold text-dark">
                                                    <a href="{{ route('admin.candidates.show', $ticket->candidate->id) }}" class="text-dark text-decoration-none hover-primary">
                                                        {{ $ticket->candidate->first_name }} {{ $ticket->candidate->last_name }}
                                                    </a>
                                                </div>
                                                <span class="text-muted small font-monospace">{{ $ticket->candidate->display_code }}</span>
                                            </div>
                                        </div>
                                    @else
                                        <span class="text-muted italic">Candidate Deleted</span>
                                    @endif
                                </td>
                                <td>
                                    @if($ticket->priority === 'urgent')
                                        <span class="badge badge-urgent rounded-pill px-3 py-1">
                                            <i data-feather="alert-triangle" style="width: 12px;"></i> URGENT
                                        </span>
                                    @elseif($ticket->priority === 'high')
                                        <span class="badge badge-high rounded-pill px-3 py-1">
                                            <i data-feather="arrow-up" style="width: 12px;"></i> HIGH
                                        </span>
                                    @else
                                        <span class="badge badge-low rounded-pill px-3 py-1">
                                            LOW
                                        </span>
                                    @endif
                                </td>
                                <td>
                                    <div class="fw-bold text-dark mb-1">{{ $ticket->subject ?? 'Support Inquiry' }}</div>
                                    <div class="text-muted small text-truncate" style="max-width: 280px;">
                                        {{ Str::limit($ticket->message, 75) }}
                                    </div>
                                    @if(!empty($ticket->screenshots) && count($ticket->screenshots) > 0)
                                        <div class="small text-primary mt-1">
                                            <i data-feather="paperclip" style="width: 12px;"></i> {{ count($ticket->screenshots) }} Screenshot(s)
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($ticket->status === 'resolved')
                                        <span class="badge bg-success-subtle text-success border border-success-subtle rounded-pill px-3 py-1 fw-bold">
                                            Resolved
                                        </span>
                                    @elseif($ticket->status === 'in_progress')
                                        <span class="badge bg-primary-subtle text-primary border border-primary-subtle rounded-pill px-3 py-1 fw-bold">
                                            In Progress
                                        </span>
                                    @elseif($ticket->status === 'closed')
                                        <span class="badge bg-secondary-subtle text-secondary border border-secondary-subtle rounded-pill px-3 py-1 fw-bold">
                                            Closed
                                        </span>
                                    @else
                                        <span class="badge bg-warning-subtle text-warning border border-warning-subtle rounded-pill px-3 py-1 fw-bold">
                                            Open
                                        </span>
                                    @endif
                                </td>
                                <td class="text-muted small">
                                    {{ $ticket->created_at ? $ticket->created_at->format('d M, Y') : 'N/A' }}<br>
                                    <span class="text-secondary small">{{ $ticket->created_at ? $ticket->created_at->format('h:i A') : '' }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 me-1 btn-inspect-ticket" data-id="{{ $ticket->id }}">
                                        <i data-feather="edit-3" class="align-middle" style="width: 14px;"></i> Reply
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-circle p-1 btn-delete-ticket" data-id="{{ $ticket->id }}" title="Delete">
                                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-muted">
                                    <i data-feather="inbox" class="mb-2" style="width: 40px; height: 40px;"></i>
                                    <p class="mb-0">No support tickets found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($tickets->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                {{ $tickets->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

</div>

<!-- INSPECT & EMAIL REPLY MODAL -->
<div class="modal fade" id="ticketModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header bg-dark text-white rounded-top-4 py-3 px-4">
                <div class="d-flex align-items-center gap-2">
                    <span class="ticket-code-pill font-monospace" id="modal-ticket-code">TKTRM000</span>
                    <h5 class="modal-title fw-bold text-white mb-0">Support Ticket Details</h5>
                </div>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                
                <!-- Candidate Info Card -->
                <div class="candidate-card-box p-3 mb-4">
                    <div class="d-flex align-items-center gap-3">
                        <img src="" id="modal-candidate-photo" class="rounded-circle border" style="width: 48px; height: 48px; object-fit: cover;">
                        <div class="flex-grow-1">
                            <h6 class="fw-bold text-dark mb-0" id="modal-candidate-name">---</h6>
                            <span class="badge bg-dark text-warning small" id="modal-candidate-code">---</span>
                            <span class="text-muted small ms-2" id="modal-candidate-email">---</span>
                            <span class="text-muted small ms-2" id="modal-candidate-mobile">---</span>
                        </div>
                        <div>
                            <span class="badge px-3 py-1 rounded-pill" id="modal-priority-badge">---</span>
                        </div>
                    </div>
                </div>

                <!-- Ticket Subject & Message -->
                <div class="mb-4">
                    <span class="text-muted small text-uppercase fw-bold">Subject:</span>
                    <h5 class="fw-bold text-dark mt-1" id="modal-ticket-subject">---</h5>

                    <span class="text-muted small text-uppercase fw-bold d-block mt-3 mb-1">Issue Description:</span>
                    <div class="p-3 bg-light rounded-3 border text-secondary" id="modal-ticket-message" style="white-space: pre-line; max-height: 180px; overflow-y: auto;">
                        ---
                    </div>
                </div>

                <!-- Screenshots Gallery -->
                <div id="modal-screenshots-container" class="mb-4 d-none">
                    <span class="text-muted small text-uppercase fw-bold d-block mb-2">Attached Screenshots:</span>
                    <div class="d-flex flex-wrap gap-2" id="modal-screenshots-list"></div>
                </div>

                <!-- Existing Reply Box -->
                <div id="modal-ticket-reply-history" class="mb-4 d-none">
                    <span class="text-success small text-uppercase fw-bold d-block mb-1">
                        <i data-feather="check-circle" style="width: 14px;"></i> Previous Resolution / Reply:
                    </span>
                    <div class="p-3 bg-white border border-success-subtle rounded-3 text-dark small" id="modal-prev-reply-text"></div>
                    <small class="text-muted d-block mt-1" id="modal-ticket-replied-at">Replied at: ---</small>
                </div>

                <!-- Status Update & Reply Form -->
                <form id="replyTicketForm">
                    @csrf
                    <input type="hidden" id="reply-ticket-id" name="ticket_id" value="">

                    <div class="row g-3 mb-3">
                        <div class="col-md-6">
                            <label for="ticket_status" class="form-label fw-bold text-dark">
                                Update Status <span class="text-danger">*</span>
                            </label>
                            <select class="form-select" id="ticket_status" name="status" required>
                                <option value="open">⏳ Open</option>
                                <option value="in_progress">🔄 In Progress</option>
                                <option value="resolved">✅ Resolved</option>
                                <option value="closed">🔒 Closed</option>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="admin_reply" class="form-label fw-bold text-dark">
                            Support Resolution / Reply Message <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="admin_reply" name="admin_reply" rows="4" required placeholder="Type the resolution or reply to send to the candidate via email..."></textarea>
                        <div class="form-text text-muted">
                            <i data-feather="send" style="width: 12px;"></i> This response will be saved and sent directly to the candidate's registered email address.
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-2">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4" id="btn-save-ticket-reply">
                            <i data-feather="check-circle" class="align-middle me-1" style="width: 14px;"></i> Save & Email Candidate
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<!-- Image Lightbox Modal -->
<div class="modal fade" id="imageLightboxModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-transparent border-0">
            <div class="modal-body p-0 text-center">
                <img src="" id="lightbox-img" class="img-fluid rounded-4 shadow-lg" style="max-height: 85vh;">
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        if (typeof feather !== 'undefined') {
            feather.replace();
        }

        const ticketModal = new bootstrap.Modal(document.getElementById('ticketModal'));
        const imageLightboxModal = new bootstrap.Modal(document.getElementById('imageLightboxModal'));

        // Open Inspect & Reply Modal
        $(document).on('click', '.btn-inspect-ticket', function() {
            const ticketId = $(this).data('id');
            const btn = $(this);
            btn.prop('disabled', true);

            $.ajax({
                url: `/admin/tickets/${ticketId}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    btn.prop('disabled', false);
                    if (response.success) {
                        const data = response.data;
                        $('#reply-ticket-id').val(data.id);
                        $('#modal-ticket-code').text(data.ticket_code);
                        $('#modal-ticket-subject').text(data.subject || 'Support Inquiry');
                        $('#modal-ticket-message').text(data.message);
                        $('#ticket_status').val(data.status);

                        // Candidate info
                        if (data.candidate) {
                            $('#modal-candidate-photo').attr('src', data.candidate.photo);
                            $('#modal-candidate-name').text(data.candidate.name);
                            $('#modal-candidate-code').text(data.candidate.code);
                            $('#modal-candidate-email').text(data.candidate.email);
                            $('#modal-candidate-mobile').text(data.candidate.mobile ? `+91 ${data.candidate.mobile}` : '');
                        }

                        // Priority badge
                        const pBadge = $('#modal-priority-badge');
                        pBadge.removeClass('badge-urgent badge-high badge-low');
                        if (data.priority === 'urgent') {
                            pBadge.addClass('badge-urgent').text('URGENT PRIORITY');
                        } else if (data.priority === 'high') {
                            pBadge.addClass('badge-high').text('HIGH PRIORITY');
                        } else {
                            pBadge.addClass('badge-low').text('LOW PRIORITY');
                        }

                        // Screenshots
                        const scList = $('#modal-screenshots-list');
                        scList.empty();
                        if (data.screenshots && data.screenshots.length > 0) {
                            $('#modal-screenshots-container').removeClass('d-none');
                            data.screenshots.forEach(url => {
                                scList.append(`<img src="${url}" class="screenshot-thumb btn-enlarge-img" data-url="${url}">`);
                            });
                        } else {
                            $('#modal-screenshots-container').addClass('d-none');
                        }

                        // Existing reply
                        if (data.admin_reply) {
                            $('#modal-ticket-reply-history').removeClass('d-none');
                            $('#modal-prev-reply-text').text(data.admin_reply);
                            $('#modal-ticket-replied-at').text(`Replied at: ${data.replied_at}`);
                            $('#admin_reply').val(data.admin_reply);
                        } else {
                            $('#modal-ticket-reply-history').addClass('d-none');
                            $('#admin_reply').val('');
                        }

                        ticketModal.show();
                    }
                },
                error: function() {
                    btn.prop('disabled', false);
                    Swal.fire({ icon: 'error', title: 'Error', text: 'Failed to fetch ticket data.' });
                }
            });
        });

        // Enlarge screenshot in lightbox
        $(document).on('click', '.btn-enlarge-img', function() {
            const url = $(this).data('url');
            $('#lightbox-img').attr('src', url);
            imageLightboxModal.show();
        });

        // Submit Ticket Reply Form
        $('#replyTicketForm').on('submit', function(e) {
            e.preventDefault();
            const ticketId = $('#reply-ticket-id').val();
            const status = $('#ticket_status').val();
            const replyMsg = $('#admin_reply').val().trim();
            const submitBtn = $('#btn-save-ticket-reply');

            if (!replyMsg) {
                Swal.fire({ icon: 'warning', text: 'Please type a resolution or reply message.' });
                return;
            }

            submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Updating & Sending Email...');

            $.ajax({
                url: `/admin/tickets/${ticketId}/reply`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    status: status,
                    admin_reply: replyMsg
                },
                dataType: 'json',
                success: function(res) {
                    submitBtn.prop('disabled', false).html('<i data-feather="check-circle" class="align-middle me-1" style="width: 14px;"></i> Save & Email Candidate');
                    if (typeof feather !== 'undefined') feather.replace();

                    ticketModal.hide();

                    Swal.fire({
                        icon: 'success',
                        title: 'Updated!',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    setTimeout(() => {
                        window.location.reload();
                    }, 1200);
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false).html('<i data-feather="check-circle" class="align-middle me-1" style="width: 14px;"></i> Save & Email Candidate');
                    if (typeof feather !== 'undefined') feather.replace();

                    let err = 'Failed to update ticket. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        err = xhr.responseJSON.message;
                    }
                    Swal.fire({ icon: 'error', title: 'Error', text: err });
                }
            });
        });

        // Delete Ticket
        $(document).on('click', '.btn-delete-ticket', function() {
            const ticketId = $(this).data('id');

            Swal.fire({
                title: 'Delete Ticket?',
                text: 'This support ticket and its attachments will be permanently deleted.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/tickets/${ticketId}`,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        dataType: 'json',
                        success: function(res) {
                            $(`#ticket-row-${ticketId}`).fadeOut(300, function() { $(this).remove(); });
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                        },
                        error: function() {
                            Swal.fire({ icon: 'error', text: 'Could not delete ticket.' });
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
