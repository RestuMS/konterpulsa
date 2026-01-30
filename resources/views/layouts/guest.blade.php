<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'KonterPOS') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
          <script src="https://cdn.tailwindcss.com"></script>
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">

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
                    <!-- Logo icon or generic -->
                    <div class="w-20 h-20 bg-white/20 rounded-2xl flex items-center justify-center shadow-lg backdrop-blur-sm mb-6 border border-white/30 text-white">
                        <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                </a>
                
                <h1 class="text-3xl font-bold mb-2 text-white drop-shadow-md">Konter POS</h1>
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
