<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <style>
        /* Override Chrome Autofill Yellow Background */
        input:-webkit-autofill,
        input:-webkit-autofill:hover, 
        input:-webkit-autofill:focus, 
        input:-webkit-autofill:active {
            -webkit-background-clip: text;
            -webkit-text-fill-color: #ffffff !important;
            transition: background-color 5000s ease-in-out 0s;
            box-shadow: inset 0 0 20px 20px #23232329;
        }
    </style>

    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <!-- Email Address -->
        <div class="space-y-2">
            <label for="email" class="block text-sm font-medium text-purple-100/80 pl-1">Email</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                    <svg class="h-5 w-5 text-white/50 group-focus-within:text-pink-400 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12a4 4 0 10-8 0 4 4 0 008 0zm0 0v1.5a2.5 2.5 0 005 0V12a9 9 0 10-9 9m4.5-1.206a8.959 8.959 0 01-4.5 1.207"></path></svg>
                </div>
                <!-- Input with peer class for sibling styling if needed, though group-focus-within handles icon -->
                <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" 
                class="block w-full pl-11 pr-4 py-3.5 rounded-2xl bg-white/5 border border-white/10 text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-pink-500/50 focus:border-pink-500/50 focus:bg-white/10 transition-all duration-300 backdrop-blur-md shadow-inner" 
                placeholder="masukkan email anda...">
            </div>
            <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-300 text-sm pl-1" />
        </div>

        <!-- Password -->
        <div class="space-y-2" x-data="{ show: false }">
            <label for="password" class="block text-sm font-medium text-purple-100/80 pl-1">Password</label>
            <div class="relative group">
                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none z-10">
                    <svg class="h-5 w-5 text-white/50 group-focus-within:text-pink-400 transition-colors duration-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                </div>
                <input id="password" :type="show ? 'text' : 'password'" name="password" required autocomplete="current-password" 
                class="block w-full pl-11 pr-12 py-3.5 rounded-2xl bg-white/5 border border-white/10 text-white placeholder-white/30 focus:outline-none focus:ring-2 focus:ring-pink-500/50 focus:border-pink-500/50 focus:bg-white/10 transition-all duration-300 backdrop-blur-md shadow-inner"
                placeholder="••••••••">
                
                <!-- Toggle Button -->
                <button type="button" @click="show = !show" 
                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-white/40 hover:text-white transition-colors focus:outline-none cursor-pointer z-10">
                    <svg x-show="!show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                    <svg x-show="show" class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a10.059 10.059 0 013.999-5.325m-6.228 6.228l3.65-3.65m9.981-9.981l3.65 3.65M9 13.5l1.5-1.5m5.25 0l1.5 1.5m-3-12.75l-6 6"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3l18 18"></path></svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-300 text-sm pl-1" />
        </div>

        <!-- Remember Me -->
        <div class="block">
            <label for="remember_me" class="inline-flex items-center cursor-pointer group">
                <div class="relative flex items-center">
                    <input id="remember_me" type="checkbox" class="peer sr-only" name="remember">
                    <div class="w-5 h-5 border-2 border-white/30 rounded bg-white/10 peer-checked:bg-pink-500 peer-checked:border-pink-500 transition-all duration-200 pointer-events-none"></div>
                    <svg class="absolute w-3 h-3 text-white opacity-0 peer-checked:opacity-100 left-1 top-1 pointer-events-none transition-opacity duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"></path></svg>
                </div>
                <span class="ms-2 text-sm text-purple-200 group-hover:text-white transition-colors">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-8 pt-6 border-t border-white/10">
            @if (Route::has('password.request'))
                <a class="text-xs font-semibold text-pink-200 hover:text-white transition-colors" href="{{ route('password.request') }}">
                    {{ __('Forgot password?') }}
                </a>
            @endif

            <div class="flex gap-3">
                 <a href="{{ route('register') }}" class="px-5 py-2.5 rounded-xl border border-white/20 text-white font-semibold text-xs uppercase tracking-wider hover:bg-white/10 transition-all duration-300">
                    {{ __('Register') }}
                </a>

                <button type="submit" class="px-8 py-2.5 bg-gradient-to-r from-pink-500 to-violet-600 hover:from-pink-600 hover:to-violet-700 text-white font-bold rounded-xl shadow-lg shadow-pink-500/30 transform hover:scale-[1.02] active:scale-95 transition-all duration-300 text-sm tracking-wide">
                    {{ __('Log in') }}
                </button>
            </div>
        </div>
    </form>
</x-guest-layout>
