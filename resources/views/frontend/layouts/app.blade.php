<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Ranimatrimonial - Find your perfect life partner. Uniting souls across India.">
    <title>@yield('title', 'Ranimatrimonial | Find Your Perfect Partner')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- Remix Icon -->
    <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .rani-swal-popup {
            background: #4a0404 !important;
            border: 1px solid #D4AF37 !important;
            color: #fff !important;
            border-radius: 18px !important;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.7) !important;
        }
        .rani-swal-title {
            color: #D4AF37 !important;
            font-family: 'Playfair Display', serif !important;
        }
        .rani-swal-confirm {
            background: linear-gradient(to right, #D4AF37, #C59B27) !important;
            color: #4a0404 !important;
            border-radius: 9999px !important;
            font-weight: bold !important;
            padding: 10px 28px !important;
            border: none !important;
        }
        [x-cloak] {
            display: none !important;
        }
    </style>

    <!-- AlpineJS for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-800 bg-rani-light overflow-x-hidden selection:bg-rani-primary selection:text-white">
    
    @include('frontend.includes.header')

    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('frontend.includes.footer')
</body>
</html>
