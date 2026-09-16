<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Rani Matrimonial</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('admin/images/favicon.ico') }}">
    
    <!-- Local Third-Party Libraries (100% Offline Compatible) -->
    <link rel="stylesheet" href="{{ asset('admin/libs/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/libs/bootstrap-icons/bootstrap-icons.css') }}">
    
    <!-- Main Design System & Custom Stylesheet -->
    <link rel="stylesheet" href="{{ asset('admin/css/main.css') }}">
</head>
<body>

    <!-- ==========================================
         START: Authentication Container & Login Card
         ========================================== -->
    <div class="login-wrapper">
        <!-- Glowing background shapes for modern visual appearance -->
        <div class="login-bg-shape login-bg-shape-1"></div>
        <div class="login-bg-shape login-bg-shape-2"></div>
        
        <!-- Main centered login card -->
        <div class="login-card">
            
            <!-- Brand Identity -->
            <a href="{{ url('/') }}" class="login-brand text-decoration-none">
                <img src="{{ asset('logo.png') }}" alt="Admin Logo" class="navbar-profile-img">
                <span>Rani Matrimonial</span>
            </a>

            @if ($errors->any())
                <div class="alert alert-danger py-2 px-3 mb-3 text-start small">
                    <i class="bi bi-exclamation-triangle-fill me-1"></i>
                    {{ $errors->first() }}
                </div>
            @endif
            
            <!-- Login Form -->
            <form action="{{ route('admin.login.submit') }}" method="POST" id="loginForm" class="needs-validation">
                @csrf
                
                <!-- Email Input Group -->
                <div class="login-form-group">
                    <label for="email" class="login-form-label">Email Address</label>
                    <div class="login-input-group">
                        <i class="bi bi-envelope input-icon"></i>
                        <input type="email" name="email" id="email" class="login-input @error('email') is-invalid @enderror" placeholder="Enter Email" value="{{ old('email') }}" required autofocus>
                    </div>
                </div>
                
                <!-- Password Input Group -->
                <div class="login-form-group">
                    <label for="password" class="login-form-label">Password</label>
                    <div class="login-input-group">
                        <i class="bi bi-shield-lock input-icon"></i>
                        <input type="password" name="password" id="password" class="login-input login-input-password" placeholder="••••••••" required>
                        <button type="button" class="password-toggle-btn" id="toggle-password" aria-label="Show password">
                            <i class="bi bi-eye"></i>
                        </button>
                    </div>
                </div>
                
                <!-- Submit Button -->
                <button type="submit" class="btn-login" id="btn-submit">
                    <span>Sign In to Dashboard</span>
                    <i class="bi bi-arrow-right"></i>
                </button>
                
            </form>
        </div>
    </div>
    <!-- END: Authentication Container -->

    <!-- Local Bootstrap bundle -->
    <script src="{{ asset('admin/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    
    <!-- Custom Authentication interactions script -->
    <script src="{{ asset('admin/js/auth.js') }}"></script>
</body>
</html>
