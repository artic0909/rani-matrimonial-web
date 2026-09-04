<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Ranimatrimonial - Dashboard">
    <title>@yield('title', 'Dashboard | Ranimatrimonial')</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Playfair+Display:ital,wght@0,400;0,600;0,700;1,400&display=swap" rel="stylesheet">
    
    <!-- AlpineJS for interactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased text-gray-800 bg-[#f4f5f6] overflow-x-hidden selection:bg-rani-primary selection:text-white">
    
    @include('frontend.includes.auth_header')

    <main class="min-h-screen pt-[140px] pb-10">
        @yield('content')
    </main>

    <footer class="bg-rani-dark text-white py-8 border-t-4 border-rani-gold mt-auto">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center text-sm text-rani-gold-light/60 flex flex-col md:flex-row justify-between items-center">
            <p>&copy; {{ date('Y') }} Ranimatrimonial. All rights reserved.</p>
            <div class="flex space-x-4 mt-4 md:mt-0">
                <a href="#" class="hover:text-rani-gold transition-colors">Privacy Policy</a>
                <a href="#" class="hover:text-rani-gold transition-colors">Terms of Service</a>
                <a href="#" class="hover:text-rani-gold transition-colors">Help</a>
            </div>
        </div>
    </footer>
</body>
</html>
