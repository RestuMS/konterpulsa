<section class="bg-white rounded-2xl shadow-xl shadow-slate-900/10 border border-slate-200 p-0 relative overflow-hidden group">
    <!-- Header Gradient -->
    <div class="bg-gradient-to-r from-red-600 to-red-800 px-8 py-6 relative overflow-hidden">
        <div class="absolute top-0 right-0 p-4 opacity-10">
            <svg class="w-32 h-32 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1 15h-2v-2h2v2zm0-4h-2V7h2v6z"/></svg>
        </div>
        <div class="flex items-center gap-4 relative z-10">
            <div class="w-12 h-12 rounded-xl bg-white/10 backdrop-blur-sm flex items-center justify-center text-white border border-white/20 shadow-lg">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </div>
            <div>
                 <h2 class="text-xl font-black text-white tracking-tight">
                    {{ __('Hapus Akun') }}
                </h2>
                <p class="text-red-100 text-sm mt-0.5">
                    {{ __('Tindakan ini tidak dapat dibatalkan. Data akan hilang permanen.') }}
                </p>
            </div>
        </div>
    </div>

    <div class="p-8">
        <div class="bg-red-50 border border-red-100 rounded-xl p-4 mb-6 flex items-start gap-3">
             <svg class="w-6 h-6 text-red-500 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
             <p class="text-red-800 text-sm leading-relaxed">
                {{ __('Setelah akun Anda dihapus, semua data akan hilang secara permanen. Harap unduh data penting sebelum menghapus akun.') }}
            </p>
        </div>

        <x-danger-button
            x-data=""
            x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
            class="w-full sm:w-auto bg-red-600 hover:bg-red-700 focus:ring-red-500 rounded-xl px-6 py-3.5 shadow-lg shadow-red-500/30 font-bold transition-all transform hover:scale-[1.02] active:scale-[0.98] flex justify-center items-center gap-2"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            {{ __('Hapus Akun Saya') }}
        </x-danger-button>
    </div>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 rounded-2xl bg-white relative overflow-hidden">
            @csrf
            @method('delete')
            
            <!-- Modal Header -->
            <div class="flex items-center gap-4 mb-4 relative z-10">
                <div class="w-12 h-12 rounded-full bg-red-100 flex items-center justify-center text-red-600 flex-shrink-0">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                </div>
                <div>
                     <h2 class="text-xl font-black text-slate-800 tracking-tight">
                        {{ __('Konfirmasi Hapus Akun') }}
                    </h2>
                    <p class="mt-1 text-sm text-slate-500">
                        {{ __('Masukkan password Anda untuk mengonfirmasi penghapusan ini.') }}
                    </p>
                </div>
            </div>

            <div class="mt-6 relative z-10">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <div class="relative group">
                     <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="h-5 w-5 text-slate-400 group-focus-within:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>
                    </div>
                    <x-text-input
                        id="password"
                        name="password"
                        type="password"
                        class="pl-10 py-3.5 mt-1 block w-full rounded-xl border-slate-200 bg-slate-50 focus:bg-white focus:border-red-500 focus:ring-red-500 focus:ring-4 focus:ring-red-500/10 font-medium text-sm transition-all placeholder-slate-400"
                        placeholder="{{ __('Masukkan Password Anda...') }}"
                    />
                </div>

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-3 relative z-10">
                <button type="button" x-on:click="$dispatch('close')" class="px-5 py-2.5 bg-white border border-slate-300 rounded-xl text-slate-700 font-bold hover:bg-slate-50 transition-colors">
                    {{ __('Batal') }}
                </button>

                <button type="submit" class="px-5 py-2.5 bg-red-600 hover:bg-red-700 text-white font-bold rounded-xl shadow-lg shadow-red-500/30 transition-all transform hover:scale-[1.02]">
                    {{ __('Ya, Hapus Permanen') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
