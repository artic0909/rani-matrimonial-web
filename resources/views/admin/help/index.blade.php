@extends('admin.layouts.app')

@section('title', 'Help & Contact Inquiries - Admin Panel')

@push('styles')
<style>
    .inquiry-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }
    .badge-pending {
        background-color: #fff3cd;
        color: #856404;
        border: 1px solid #ffeeba;
    }
    .badge-replied {
        background-color: #d4edda;
        color: #155724;
        border: 1px solid #c3e6cb;
    }
    .reply-preview-box {
        background: #fdfbf7;
        border-left: 4px solid #750000;
        padding: 12px 16px;
        border-radius: 6px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid p-0">

    <!-- Page Title & Header Actions -->
    <div class="row mb-3 align-items-center">
        <div class="col-md-6">
            <h1 class="h3 d-inline align-middle text-dark fw-bold">Help & Contact Inquiries</h1>
            <p class="text-muted small mb-0">Manage incoming visitor contact forms and send official email responses.</p>
        </div>
        <div class="col-md-6 text-md-end mt-3 mt-md-0">
            <a href="{{ route('admin.helps.index') }}" class="btn btn-outline-secondary btn-sm shadow-sm rounded-pill px-3">
                <i class="align-middle" data-feather="rotate-cw"></i> Refresh List
            </a>
        </div>
    </div>

    <!-- Stats Overview Tiles -->
    <div class="row mb-4">
        <div class="col-sm-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-primary-subtle text-primary p-3 rounded-4 me-3">
                            <i class="align-middle" data-feather="mail" style="width: 24px; height: 24px;"></i>
                        </div>
                        <div>
                            <span class="text-muted small text-uppercase fw-bold">Total Inquiries</span>
                            <h3 class="fw-bold mb-0 text-dark">{{ $counts['total'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-warning-subtle text-warning p-3 rounded-4 me-3">
                            <i class="align-middle" data-feather="clock" style="width: 24px; height: 24px;"></i>
                        </div>
                        <div>
                            <span class="text-muted small text-uppercase fw-bold">Pending Response</span>
                            <h3 class="fw-bold mb-0 text-warning">{{ $counts['pending'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-body p-3">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0 bg-success-subtle text-success p-3 rounded-4 me-3">
                            <i class="align-middle" data-feather="check-circle" style="width: 24px; height: 24px;"></i>
                        </div>
                        <div>
                            <span class="text-muted small text-uppercase fw-bold">Replied / Solved</span>
                            <h3 class="fw-bold mb-0 text-success">{{ $counts['replied'] }}</h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="card shadow-sm border-0 rounded-4 mb-4">
        <div class="card-body p-3">
            <form action="{{ route('admin.helps.index') }}" method="GET" class="row g-2 align-items-center">
                <div class="col-md-5">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-0"><i data-feather="search" class="text-muted"></i></span>
                        <input type="text" name="search" class="form-control bg-light border-0" placeholder="Search by name, email, mobile, subject..." value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <select name="status" class="form-select bg-light border-0" onchange="this.form.submit()">
                        <option value="all" {{ request('status') == 'all' || !request('status') ? 'selected' : '' }}>All Statuses</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>⏳ Pending Only</option>
                        <option value="replied" {{ request('status') == 'replied' ? 'selected' : '' }}>✅ Replied Only</option>
                    </select>
                </div>
                <div class="col-md-4 text-md-end">
                    <button type="submit" class="btn btn-primary btn-sm rounded-pill px-4">Apply Filter</button>
                    @if(request()->hasAny(['search', 'status']))
                        <a href="{{ route('admin.helps.index') }}" class="btn btn-light btn-sm rounded-pill px-3">Clear</a>
                    @endif
                </div>
            </form>
        </div>
    </div>

    <!-- Inquiries Table Card -->
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header bg-white border-0 pt-4 pb-2 px-4 d-flex justify-content-between align-items-center">
            <h5 class="card-title fw-bold text-dark mb-0">Inquiry Records</h5>
            <span class="badge bg-light text-muted border px-2 py-1">{{ $helps->total() }} Total</span>
        </div>
        <div class="card-body px-0 pt-0 pb-3">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-muted small text-uppercase">
                        <tr>
                            <th class="ps-4" style="width: 60px;">#ID</th>
                            <th>Sender & Contact</th>
                            <th>Subject & Preview</th>
                            <th>Status</th>
                            <th>Received At</th>
                            <th class="text-end pe-4" style="width: 140px;">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($helps as $help)
                            <tr id="help-row-{{ $help->id }}">
                                <td class="ps-4 font-monospace fw-bold text-muted">#{{ $help->id }}</td>
                                <td>
                                    <div class="fw-bold text-dark">{{ $help->name }}</div>
                                    <div class="small text-muted">
                                        <a href="mailto:{{ $help->email }}" class="text-decoration-none text-muted">
                                            <i class="align-middle text-primary" data-feather="mail" style="width: 12px;"></i> {{ $help->email }}
                                        </a>
                                    </div>
                                    <div class="small text-muted">
                                        <a href="tel:{{ $help->full_phone }}" class="text-decoration-none text-dark fw-semibold">
                                            <i class="align-middle text-success" data-feather="phone" style="width: 12px;"></i> {{ $help->full_phone }}
                                        </a>
                                    </div>
                                </td>
                                <td>
                                    <div class="fw-bold text-dark mb-1">{{ $help->subject }}</div>
                                    <div class="text-muted small text-truncate" style="max-width: 320px;">
                                        {{ Str::limit($help->message, 80) }}
                                    </div>
                                    @if($help->status === 'replied' && $help->reply_message)
                                        <div class="small text-success mt-1">
                                            <i data-feather="corner-down-right" style="width: 12px;"></i> Replied on {{ $help->replied_at ? $help->replied_at->format('M d, Y') : 'N/A' }}
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    @if($help->status === 'replied')
                                        <span class="badge badge-replied rounded-pill px-3 py-1 fw-bold">
                                            <i data-feather="check" style="width: 12px;"></i> Replied
                                        </span>
                                    @else
                                        <span class="badge badge-pending rounded-pill px-3 py-1 fw-bold">
                                            <i data-feather="clock" style="width: 12px;"></i> Pending
                                        </span>
                                    @endif
                                </td>
                                <td class="text-muted small">
                                    {{ $help->created_at ? $help->created_at->format('d M, Y') : 'N/A' }}<br>
                                    <span class="text-secondary small">{{ $help->created_at ? $help->created_at->format('h:i A') : '' }}</span>
                                </td>
                                <td class="text-end pe-4">
                                    <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 me-1 btn-view-help" data-id="{{ $help->id }}">
                                        <i data-feather="message-circle" class="align-middle" style="width: 14px;"></i> Reply
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger rounded-circle p-1 btn-delete-help" data-id="{{ $help->id }}" title="Delete">
                                        <i data-feather="trash-2" style="width: 14px; height: 14px;"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-5 text-muted">
                                    <i data-feather="inbox" class="mb-2" style="width: 40px; height: 40px;"></i>
                                    <p class="mb-0">No help or contact inquiries found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        @if($helps->hasPages())
            <div class="card-footer bg-white border-0 py-3 px-4">
                {{ $helps->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>

</div>

<!-- VIEW & EMAIL REPLY MODAL -->
<div class="modal fade" id="helpModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content rounded-4 border-0 shadow-lg">
            <div class="modal-header bg-dark text-white rounded-top-4 py-3 px-4">
                <h5 class="modal-title fw-bold text-white mb-0" id="helpModalLabel">Inquiry Details & Email Response</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4">
                
                <!-- Inquiry Details Header -->
                <div class="card bg-light border-0 rounded-3 mb-4 p-3">
                    <div class="row g-2">
                        <div class="col-sm-6">
                            <span class="text-muted small text-uppercase fw-bold">Sender Name:</span>
                            <div class="fw-bold text-dark" id="modal-name">---</div>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted small text-uppercase fw-bold">Email Address:</span>
                            <div class="fw-bold text-primary" id="modal-email">---</div>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted small text-uppercase fw-bold">Contact Mobile:</span>
                            <div class="fw-bold text-dark" id="modal-phone">---</div>
                        </div>
                        <div class="col-sm-6">
                            <span class="text-muted small text-uppercase fw-bold">Received At:</span>
                            <div class="fw-semibold text-muted" id="modal-date">---</div>
                        </div>
                    </div>
                </div>

                <!-- Subject & Message -->
                <div class="mb-4">
                    <span class="text-muted small text-uppercase fw-bold">Subject:</span>
                    <h5 class="fw-bold text-dark mt-1" id="modal-subject">---</h5>
                    
                    <span class="text-muted small text-uppercase fw-bold d-block mt-3 mb-1">Inquiry Message:</span>
                    <div class="p-3 bg-white rounded-3 border text-secondary" id="modal-message" style="white-space: pre-line; max-height: 180px; overflow-y: auto;">
                        ---
                    </div>
                </div>

                <!-- Existing Reply (If any) -->
                <div id="modal-existing-reply-box" class="mb-4 d-none">
                    <span class="text-success small text-uppercase fw-bold d-block mb-1">
                        <i data-feather="check-circle" style="width: 14px;"></i> Previous Reply Sent:
                    </span>
                    <div class="reply-preview-box text-dark small" id="modal-existing-reply-text">
                        ---
                    </div>
                    <small class="text-muted d-block mt-1" id="modal-replied-at">Replied at: ---</small>
                </div>

                <!-- Reply Form -->
                <form id="replyHelpForm">
                    @csrf
                    <input type="hidden" id="reply-help-id" name="help_id" value="">
                    
                    <div class="mb-3">
                        <label for="reply_message" class="form-label fw-bold text-dark">
                            Type Email Response <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="reply_message" name="reply_message" rows="5" required placeholder="Write your response here. This message will be immediately delivered to the sender's email address..."></textarea>
                        <div class="form-text text-muted">
                            <i data-feather="info" style="width: 12px;"></i> Email will be sent from Rani Matrimonial to the sender's email address.
                        </div>
                    </div>

                    <div class="d-flex justify-content-end gap-2 pt-2">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary rounded-pill px-4" id="btn-send-reply">
                            <i data-feather="send" class="align-middle me-1" style="width: 14px;"></i> Send Email Reply
                        </button>
                    </div>
                </form>

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

        const helpModal = new bootstrap.Modal(document.getElementById('helpModal'));

        // Open View & Reply Modal
        $(document).on('click', '.btn-view-help', function() {
            const helpId = $(this).data('id');
            const btn = $(this);
            btn.prop('disabled', true);

            $.ajax({
                url: `/admin/helps/${helpId}`,
                type: 'GET',
                dataType: 'json',
                success: function(response) {
                    btn.prop('disabled', false);
                    if (response.success) {
                        const data = response.data;
                        $('#reply-help-id').val(data.id);
                        $('#modal-name').text(data.name);
                        $('#modal-email').text(data.email);
                        $('#modal-phone').text(data.full_phone);
                        $('#modal-date').text(data.created_at);
                        $('#modal-subject').text(data.subject);
                        $('#modal-message').text(data.message);
                        
                        if (data.status === 'replied' && data.reply_message) {
                            $('#modal-existing-reply-box').removeClass('d-none');
                            $('#modal-existing-reply-text').text(data.reply_message);
                            $('#modal-replied-at').text(`Replied at: ${data.replied_at}`);
                            $('#reply_message').val(data.reply_message);
                        } else {
                            $('#modal-existing-reply-box').addClass('d-none');
                            $('#reply_message').val('');
                        }

                        helpModal.show();
                    }
                },
                error: function() {
                    btn.prop('disabled', false);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Failed to fetch inquiry details. Please try again.',
                    });
                }
            });
        });

        // Submit Reply Form
        $('#replyHelpForm').on('submit', function(e) {
            e.preventDefault();
            const helpId = $('#reply-help-id').val();
            const replyMsg = $('#reply_message').val().trim();
            const submitBtn = $('#btn-send-reply');

            if (!replyMsg) {
                Swal.fire({ icon: 'warning', text: 'Please type a response message.' });
                return;
            }

            submitBtn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-1"></span> Sending Email...');

            $.ajax({
                url: `/admin/helps/${helpId}/reply`,
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    reply_message: replyMsg
                },
                dataType: 'json',
                success: function(res) {
                    submitBtn.prop('disabled', false).html('<i data-feather="send" class="align-middle me-1" style="width: 14px;"></i> Send Email Reply');
                    if (typeof feather !== 'undefined') feather.replace();
                    
                    helpModal.hide();

                    Swal.fire({
                        icon: 'success',
                        title: 'Reply Sent!',
                        text: res.message,
                        timer: 2000,
                        showConfirmButton: false
                    });

                    setTimeout(() => {
                        window.location.reload();
                    }, 1200);
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false).html('<i data-feather="send" class="align-middle me-1" style="width: 14px;"></i> Send Email Reply');
                    if (typeof feather !== 'undefined') feather.replace();

                    let err = 'Failed to send reply. Please try again.';
                    if (xhr.responseJSON && xhr.responseJSON.message) {
                        err = xhr.responseJSON.message;
                    }
                    Swal.fire({ icon: 'error', title: 'Oops!', text: err });
                }
            });
        });

        // Delete Help Record
        $(document).on('click', '.btn-delete-help', function() {
            const helpId = $(this).data('id');

            Swal.fire({
                title: 'Delete Inquiry?',
                text: 'This inquiry record will be removed permanently.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/admin/helps/${helpId}`,
                        type: 'DELETE',
                        data: { _token: '{{ csrf_token() }}' },
                        dataType: 'json',
                        success: function(res) {
                            $(`#help-row-${helpId}`).fadeOut(300, function() { $(this).remove(); });
                            Swal.fire({
                                icon: 'success',
                                title: 'Deleted!',
                                text: res.message,
                                timer: 1500,
                                showConfirmButton: false
                            });
                        },
                        error: function() {
                            Swal.fire({ icon: 'error', text: 'Could not delete record.' });
                        }
                    });
                }
            });
        });
    });
</script>
@endpush
