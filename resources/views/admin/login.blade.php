<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Rani Matrimonial</title>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,400&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 font-sans text-gray-100 min-h-screen flex items-center justify-center p-4 selection:bg-rani-primary selection:text-white relative overflow-hidden">
    <!-- Glow effects -->
    <div class="absolute -top-40 -left-40 w-96 h-96 bg-rani-primary/20 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute -bottom-40 -right-40 w-96 h-96 bg-rani-gold/15 rounded-full blur-3xl pointer-events-none"></div>

    <div class="w-full max-w-md bg-gray-900/90 backdrop-blur-xl border border-gray-800 rounded-3xl p-8 shadow-2xl relative z-10">
        <!-- Logo -->
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-rani-primary/10 text-rani-gold mb-3 border border-rani-gold/30">
                <img src="{{ asset('logo.png') }}" class="w-10 h-10 object-contain rounded-full" alt="Rani Matrimonial">
            </div>
            <h1 class="text-2xl font-serif font-bold text-white tracking-wide">Rani Matrimonial</h1>
            <p class="text-xs text-rani-gold tracking-widest uppercase mt-1">Admin Portal</p>
        </div>

        @if($errors->any())
            <div class="mb-5 p-4 rounded-xl bg-red-950/80 border border-red-800/80 text-xs text-red-200">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Admin Email</label>
                <input type="email" name="email" value="{{ old('email', 'admin@ranimatrimonial.com') }}" required 
                       class="w-full px-4 py-3 rounded-xl bg-gray-950/80 border border-gray-800 text-white placeholder-gray-500 text-sm focus:outline-none focus:ring-2 focus:ring-rani-gold focus:border-transparent">
            </div>

            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-gray-400 mb-1.5">Password</label>
                <input type="password" name="password" required 
                       class="w-full px-4 py-3 rounded-xl bg-gray-950/80 border border-gray-800 text-white placeholder-gray-500 text-sm focus:outline-none focus:ring-2 focus:ring-rani-gold focus:border-transparent">
            </div>

            <div class="flex items-center justify-between text-xs text-gray-400">
                <label class="flex items-center gap-2 cursor-pointer">
                    <input type="checkbox" name="remember" class="rounded border-gray-700 bg-gray-950 text-rani-primary focus:ring-0">
                    <span>Remember me</span>
                </label>
            </div>

            <button type="submit" class="w-full py-3.5 rounded-xl bg-gradient-to-r from-rani-primary to-rani-primary-dark hover:from-rani-primary-dark hover:to-rani-primary text-white font-bold text-sm shadow-lg hover:shadow-xl transition-all">
                Login to Admin Panel
            </button>
        </form>
    </div>
</body>
</html>
