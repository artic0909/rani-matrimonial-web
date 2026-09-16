@extends('admin.layouts.app')

@section('title', 'Admin Profile Settings - Rani Matrimonial')

@section('content')
<div class="container-fluid p-0">

    <!-- START: Page Header Banner -->
    <div class="page-header d-flex flex-column flex-md-row align-items-md-center justify-content-between gap-3 mb-4">
        <div>
            <div class="d-flex align-items-center gap-2 mb-1">
                <i class="bi bi-person-gear fs-4" style="color: var(--brand-forest-medium);"></i>
                <h1 class="page-title mb-0">Admin Profile & Settings</h1>
                <span class="badge-table success ms-2">
                    Super Admin
                </span>
            </div>
            <p class="page-subtitle mb-0">Manage administrator account credentials, security preferences, and system notification integrations.</p>
        </div>
        <div class="d-flex align-items-center gap-2">
            <a href="{{ route('admin.dashboard') }}" class="btn-custom btn-custom-light btn-custom-sm">
                <i class="bi bi-arrow-left"></i>
                <span>Dashboard</span>
            </a>
        </div>
    </div>
    <!-- END: Page Header Banner -->

    <div class="row g-4">
        
        <!-- START: Left Sidebar Profile Card -->
        <div class="col-12 col-lg-4">
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden mb-4" style="border: 1px solid rgba(11, 19, 15, 0.08) !important;">
                <div class="p-4 text-center" style="background: linear-gradient(135deg, #051C12 0%, #0F4A32 100%);">
                    <div class="position-relative d-inline-block mb-3">
                        <img src="{{ asset('logo.png') }}" 
                             alt="Administrator" 
                             class="rounded-circle shadow-md"
                             id="sidebar-admin-avatar"
                             style="width: 90px; height: 90px; object-fit: cover; border: 3px solid rgba(180, 241, 5, 0.6);">
                        <span class="position-absolute bottom-0 end-0 bg-success border border-2 border-white rounded-circle p-1.5" title="Online & Active"></span>
                    </div>
                    <h5 class="fw-bold text-white mb-1" id="profile-card-name">{{ $admin->name ?? 'Rani Admin' }}</h5>
                    <p class="text-white-50 small mb-2 font-monospace" id="profile-card-email">{{ $admin->email ?? 'admin@rm.com' }}</p>
                    <span class="badge" style="background-color: var(--brand-lime); color: #072F1F; font-weight: 700; font-size: 11px; padding: 4px 10px; border-radius: 50px;">
                        <i class="bi bi-shield-check me-1"></i> MASTER ADMINISTRATOR
                    </span>
                </div>

                <div class="p-4 bg-white">
                    <h6 class="fw-bold text-main mb-3 small text-uppercase" style="letter-spacing: 0.05em;">Account Overview</h6>
                    
                    <ul class="list-unstyled mb-4 d-flex flex-column gap-2.5">
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="table-user-sub"><i class="bi bi-person-badge me-1.5 text-muted-green"></i> Access Role</span>
                            <span class="fw-semibold text-main small">Root Superadmin</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="table-user-sub"><i class="bi bi-key me-1.5 text-muted-green"></i> Auth Guard</span>
                            <span class="font-monospace small bg-light px-2 py-0.5 rounded text-dark">admin</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="table-user-sub"><i class="bi bi-shield-lock me-1.5 text-muted-green"></i> Security Status</span>
                            <span class="badge-table success">Protected</span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2 border-bottom">
                            <span class="table-user-sub"><i class="bi bi-whatsapp me-1.5 text-success"></i> WhatsApp SID</span>
                            <span class="font-monospace small text-truncate" style="max-width: 130px;" title="Template SID: HX8d4dbf146474911dcac92ee877300408">
                                HX8d4...0408
                            </span>
                        </li>
                        <li class="d-flex justify-content-between align-items-center py-2">
                            <span class="table-user-sub"><i class="bi bi-calendar-check me-1.5 text-muted-green"></i> Member Since</span>
                            <span class="fw-semibold text-main small">{{ $admin->created_at ? $admin->created_at->format('M Y') : 'Sept 2026' }}</span>
                        </li>
                    </ul>

                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.logout') }}" class="btn-custom btn-custom-outline-danger btn-custom-sm" onclick="event.preventDefault(); confirmAdminLogout();">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Sign Out of Dashboard</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Quick Information Tip Card -->
            <div class="p-3.5 rounded-4 bg-white border" style="border: 1px solid rgba(11, 19, 15, 0.08) !important;">
                <div class="d-flex align-items-start gap-2.5">
                    <div class="rounded-circle d-flex align-items-center justify-content-center flex-shrink-0" style="width: 36px; height: 36px; background-color: rgba(15, 74, 50, 0.1); color: var(--brand-forest-medium);">
                        <i class="bi bi-info-circle-fill"></i>
                    </div>
                    <div>
                        <h6 class="fw-bold text-main mb-1 small">Admin Security Note</h6>
                        <p class="table-user-sub mb-0" style="font-size: 12px; line-height: 1.5;">
                            All profile updates and password modifications are encrypted. Changes take effect across active sessions immediately.
                        </p>
                    </div>
                </div>
            </div>
        </div>
        <!-- END: Left Sidebar Profile Card -->

        <!-- START: Right Settings Column -->
        <div class="col-12 col-lg-8">

            <!-- 1. Profile Information Form Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="border: 1px solid rgba(11, 19, 15, 0.08) !important;">
                <div class="card-header bg-white border-bottom px-4 py-3 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold text-main mb-0">
                            <i class="bi bi-person-lines-fill me-1.5" style="color: var(--brand-forest-medium);"></i> Profile Details
                        </h5>
                        <p class="table-user-sub mb-0 small">Update your official administrator display name and contact email address.</p>
                    </div>
                </div>
                
                <form id="adminProfileForm" onsubmit="handleProfileUpdate(event)">
                    @csrf
                    <div class="card-body p-4">
                        <!-- Alert Box -->
                        <div class="alert alert-danger py-2 px-3 mb-3 small d-none rounded-3" id="profile-error-alert">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>
                            <span id="profile-error-text"></span>
                        </div>

                        <div class="row g-3">
                            <div class="col-12 col-md-6">
                                <label for="admin_name" class="form-label fw-bold small text-main">
                                    Administrator Name <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-person"></i></span>
                                    <input type="text" 
                                           id="admin_name" 
                                           name="name" 
                                           class="form-control border-start-0 ps-0" 
                                           value="{{ old('name', $admin->name ?? '') }}" 
                                           required 
                                           placeholder="e.g. Rani Administrator">
                                </div>
                                <div class="invalid-feedback" id="error-name"></div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="admin_email" class="form-label fw-bold small text-main">
                                    Administrator Email <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-envelope"></i></span>
                                    <input type="email" 
                                           id="admin_email" 
                                           name="email" 
                                           class="form-control border-start-0 ps-0" 
                                           value="{{ old('email', $admin->email ?? '') }}" 
                                           required 
                                           placeholder="e.g. admin@rm.com">
                                </div>
                                <div class="invalid-feedback" id="error-email"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light border-top px-4 py-3 d-flex align-items-center justify-content-between">
                        <span class="table-user-sub small"><i class="bi bi-shield-check text-success me-1"></i> Email is used for admin login authentication.</span>
                        <button type="submit" class="btn-custom btn-custom-primary btn-custom-sm" id="btn-save-profile">
                            <span class="spinner-border spinner-border-sm d-none me-1" id="profile-spinner" role="status"></span>
                            <i class="bi bi-check2-circle"></i>
                            <span>Save Profile Changes</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- 2. Security & Change Password Card -->
            <div class="card border-0 shadow-sm rounded-4 mb-4 overflow-hidden" style="border: 1px solid rgba(11, 19, 15, 0.08) !important;">
                <div class="card-header bg-white border-bottom px-4 py-3 d-flex align-items-center justify-content-between">
                    <div>
                        <h5 class="fw-bold text-main mb-0">
                            <i class="bi bi-lock-fill me-1.5" style="color: var(--brand-forest-medium);"></i> Security & Password
                        </h5>
                        <p class="table-user-sub mb-0 small">Ensure your account uses a strong, secure password to protect dashboard operations.</p>
                    </div>
                </div>

                <form id="adminPasswordForm" onsubmit="handlePasswordUpdate(event)">
                    @csrf
                    <div class="card-body p-4">
                        <!-- Alert Box -->
                        <div class="alert alert-danger py-2 px-3 mb-3 small d-none rounded-3" id="password-error-alert">
                            <i class="bi bi-exclamation-triangle-fill me-1"></i>
                            <span id="password-error-text"></span>
                        </div>

                        <div class="row g-3">
                            <div class="col-12">
                                <label for="current_password" class="form-label fw-bold small text-main">
                                    Current Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-shield-lock"></i></span>
                                    <input type="password" 
                                           id="current_password" 
                                           name="current_password" 
                                           class="form-control border-start-0 border-end-0 px-0" 
                                           placeholder="Enter current password" 
                                           required>
                                    <button type="button" class="input-group-text bg-light border-start-0 text-muted" onclick="togglePasswordVisibility('current_password', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback" id="error-current_password"></div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="new_password" class="form-label fw-bold small text-main">
                                    New Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-key"></i></span>
                                    <input type="password" 
                                           id="new_password" 
                                           name="new_password" 
                                           class="form-control border-start-0 border-end-0 px-0" 
                                           placeholder="Minimum 8 characters" 
                                           minlength="8" 
                                           required>
                                    <button type="button" class="input-group-text bg-light border-start-0 text-muted" onclick="togglePasswordVisibility('new_password', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                                <div class="invalid-feedback" id="error-new_password"></div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="new_password_confirmation" class="form-label fw-bold small text-main">
                                    Confirm New Password <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-muted"><i class="bi bi-check-all"></i></span>
                                    <input type="password" 
                                           id="new_password_confirmation" 
                                           name="new_password_confirmation" 
                                           class="form-control border-start-0 border-end-0 px-0" 
                                           placeholder="Re-type new password" 
                                           minlength="8" 
                                           required>
                                    <button type="button" class="input-group-text bg-light border-start-0 text-muted" onclick="togglePasswordVisibility('new_password_confirmation', this)">
                                        <i class="bi bi-eye"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer bg-light border-top px-4 py-3 d-flex align-items-center justify-content-between">
                        <span class="table-user-sub small"><i class="bi bi-info-circle me-1"></i> Passwords must be at least 8 characters long.</span>
                        <button type="submit" class="btn-custom btn-custom-secondary btn-custom-sm" id="btn-save-password">
                            <span class="spinner-border spinner-border-sm d-none me-1" id="password-spinner" role="status"></span>
                            <i class="bi bi-key-fill"></i>
                            <span>Update Password</span>
                        </button>
                    </div>
                </form>
            </div>

            <!-- 3. System Integrations & Gateway Card -->
            <div class="card border-0 shadow-sm rounded-4 overflow-hidden" style="border: 1px solid rgba(11, 19, 15, 0.08) !important;">
                <div class="card-header bg-white border-bottom px-4 py-3">
                    <h5 class="fw-bold text-main mb-0">
                        <i class="bi bi-cpu me-1.5" style="color: var(--brand-forest-medium);"></i> System Notification Channels
                    </h5>
                    <p class="table-user-sub mb-0 small">Configured communication gateways and active dispatch templates.</p>
                </div>
                <div class="card-body p-4">
                    <div class="row g-3">
                        <div class="col-12 col-md-6">
                            <div class="p-3 bg-light rounded-3 border d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2.5">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-success" style="width: 40px; height: 40px; background: rgba(34, 197, 94, 0.1); font-size: 18px;">
                                        <i class="bi bi-whatsapp"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-main small">Meta WhatsApp Gateway</div>
                                        <div class="table-user-sub font-monospace" style="font-size: 11px;">SID: HX8d4dbf146474911dcac92ee877300408</div>
                                    </div>
                                </div>
                                <span class="badge-table success">Active</span>
                            </div>
                        </div>

                        <div class="col-12 col-md-6">
                            <div class="p-3 bg-light rounded-3 border d-flex align-items-center justify-content-between">
                                <div class="d-flex align-items-center gap-2.5">
                                    <div class="rounded-circle d-flex align-items-center justify-content-center text-primary" style="width: 40px; height: 40px; background: rgba(14, 165, 233, 0.1); font-size: 18px;">
                                        <i class="bi bi-shield-check"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-main small">Blue Tick Verification</div>
                                        <div class="table-user-sub" style="font-size: 11px;">Aadhaar Doc OCR & Inspection</div>
                                    </div>
                                </div>
                                <span class="badge-table success">Active</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- END: Right Settings Column -->

    </div>

</div>

@push('scripts')
<script>
function togglePasswordVisibility(inputId, btn) {
    const input = document.getElementById(inputId);
    const icon = btn.querySelector('i');
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('bi-eye');
        icon.classList.add('bi-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('bi-eye-slash');
        icon.classList.add('bi-eye');
    }
}

function handleProfileUpdate(e) {
    e.preventDefault();
    clearProfileErrors();

    const name = document.getElementById('admin_name').value.trim();
    const email = document.getElementById('admin_email').value.trim();

    const btn = document.getElementById('btn-save-profile');
    const spinner = document.getElementById('profile-spinner');
    btn.disabled = true;
    spinner.classList.remove('d-none');

    fetch("{{ route('admin.profile.update') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ name: name, email: email })
    })
    .then(res => res.json().then(data => ({ ok: res.ok, status: res.status, data })))
    .then(({ ok, status, data }) => {
        btn.disabled = false;
        spinner.classList.add('d-none');

        if (ok && data.success) {
            document.getElementById('profile-card-name').innerText = data.admin.name;
            document.getElementById('profile-card-email').innerText = data.admin.email;

            // Also update navbar if present
            const navName = document.querySelector('.navbar-profile-name');
            if (navName) navName.innerText = data.admin.name;

            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: data.message,
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
            });
        } else {
            if (data.errors) {
                if (data.errors.name) {
                    document.getElementById('admin_name').classList.add('is-invalid');
                    document.getElementById('error-name').innerText = data.errors.name[0];
                    document.getElementById('error-name').style.display = 'block';
                }
                if (data.errors.email) {
                    document.getElementById('admin_email').classList.add('is-invalid');
                    document.getElementById('error-email').innerText = data.errors.email[0];
                    document.getElementById('error-email').style.display = 'block';
                }
            }
            const alertBox = document.getElementById('profile-error-alert');
            document.getElementById('profile-error-text').innerText = data.message || 'Could not update profile.';
            alertBox.classList.remove('d-none');
        }
    })
    .catch(err => {
        console.error(err);
        btn.disabled = false;
        spinner.classList.add('d-none');
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while saving profile changes.'
        });
    });
}

function handlePasswordUpdate(e) {
    e.preventDefault();
    clearPasswordErrors();

    const currentPassword = document.getElementById('current_password').value;
    const newPassword = document.getElementById('new_password').value;
    const confirmation = document.getElementById('new_password_confirmation').value;

    if (newPassword !== confirmation) {
        document.getElementById('new_password').classList.add('is-invalid');
        document.getElementById('error-new_password').innerText = 'Password confirmation does not match.';
        document.getElementById('error-new_password').style.display = 'block';
        return;
    }

    const btn = document.getElementById('btn-save-password');
    const spinner = document.getElementById('password-spinner');
    btn.disabled = true;
    spinner.classList.remove('d-none');

    fetch("{{ route('admin.profile.password') }}", {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({
            current_password: currentPassword,
            new_password: newPassword,
            new_password_confirmation: confirmation
        })
    })
    .then(res => res.json().then(data => ({ ok: res.ok, status: res.status, data })))
    .then(({ ok, status, data }) => {
        btn.disabled = false;
        spinner.classList.add('d-none');

        if (ok && data.success) {
            document.getElementById('adminPasswordForm').reset();
            Swal.fire({
                icon: 'success',
                title: 'Password Updated!',
                text: data.message,
                confirmButtonText: 'Great!'
            });
        } else {
            if (data.errors) {
                if (data.errors.current_password) {
                    document.getElementById('current_password').classList.add('is-invalid');
                    document.getElementById('error-current_password').innerText = data.errors.current_password[0];
                    document.getElementById('error-current_password').style.display = 'block';
                }
                if (data.errors.new_password) {
                    document.getElementById('new_password').classList.add('is-invalid');
                    document.getElementById('error-new_password').innerText = data.errors.new_password[0];
                    document.getElementById('error-new_password').style.display = 'block';
                }
            }
            const alertBox = document.getElementById('password-error-alert');
            document.getElementById('password-error-text').innerText = data.message || 'Could not update password.';
            alertBox.classList.remove('d-none');
        }
    })
    .catch(err => {
        console.error(err);
        btn.disabled = false;
        spinner.classList.add('d-none');
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'An error occurred while updating password.'
        });
    });
}

function clearProfileErrors() {
    document.getElementById('profile-error-alert').classList.add('d-none');
    ['name', 'email'].forEach(f => {
        const el = document.getElementById(`admin_${f}`);
        const err = document.getElementById(`error-${f}`);
        if (el) el.classList.remove('is-invalid');
        if (err) { err.innerText = ''; err.style.display = 'none'; }
    });
}

function clearPasswordErrors() {
    document.getElementById('password-error-alert').classList.add('d-none');
    ['current_password', 'new_password'].forEach(f => {
        const el = document.getElementById(f);
        const err = document.getElementById(`error-${f}`);
        if (el) el.classList.remove('is-invalid');
        if (err) { err.innerText = ''; err.style.display = 'none'; }
    });
}

function confirmAdminLogout() {
    Swal.fire({
        title: 'Sign Out?',
        text: 'Are you sure you want to end your administrator session?',
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: '<i class="bi bi-box-arrow-right me-1"></i> Yes, Sign Out',
        cancelButtonText: 'Cancel',
        reverseButtons: true
    }).then((res) => {
        if (res.isConfirmed) {
            window.location.href = "{{ route('admin.logout') }}";
        }
    });
}
</script>
@endpush
@endsection
