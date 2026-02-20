<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Konter POS</title>
        <link rel="icon" href="{{ asset('images/logo.png') }}" type="image/png">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        <script src="https://cdn.tailwindcss.com"></script>

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <style>
            body { font-family: 'Outfit', sans-serif; }
            .glass-card {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.2);
            }
        </style>
    </head>
    <body class="antialiased text-gray-100">
        <!-- Vibrant Gradient Background -->
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-indigo-900 via-purple-900 to-pink-800 relative overflow-hidden">
            
            <!-- Animated decorative circles (optional for extra flair) -->
            <div class="absolute top-[-100px] left-[-100px] w-96 h-96 bg-purple-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob"></div>
            <div class="absolute top-[-100px] right-[-100px] w-96 h-96 bg-yellow-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-2000"></div>
            <div class="absolute -bottom-32 left-20 w-96 h-96 bg-pink-500 rounded-full mix-blend-multiply filter blur-3xl opacity-30 animate-blob animation-delay-4000"></div>

            <div class="relative z-10 flex flex-col items-center">
                <a href="/">
                    <!-- Logo Image -->
                    <div class="mb-6 transform hover:scale-105 transition-transform duration-300">
                         <img src="{{ asset('images/logo.png') }}" alt="Restu Cell Logo" class="w-24 h-24 object-contain drop-shadow-lg">
                    </div>
                </a>
                
                <h1 class="text-3xl font-bold mb-2 text-white drop-shadow-md">Restu Cell</h1>
                <p class="text-white/60 mb-8 font-light tracking-wide">Premium Point of Sale System</p>
            </div>

            <div class="relative z-10 w-full sm:max-w-md px-8 py-8 glass-card shadow-2xl overflow-hidden sm:rounded-2xl text-white">
                {{ $slot }}
            </div>
            
            <div class="mt-8 text-white/40 text-sm relative z-10">
                &copy; {{ date('Y') }} KonterPOS. All rights reserved.
            </div>
        </div>
    </body>
</html>
