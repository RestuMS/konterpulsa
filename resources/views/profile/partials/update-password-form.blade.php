<section class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
    <header class="mb-6">
        <h2 class="text-xl font-bold text-slate-800">
            {{ __('Perbarui Password') }}
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            {{ __('Pastikan akun Anda menggunakan password yang panjang dan acak agar tetap aman.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" :value="__('Password Saat Ini')" class="text-slate-700 font-semibold mb-2" />
            <x-text-input id="update_password_current_password" name="current_password" type="password" class="mt-1 block w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition-all text-sm" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password" :value="__('Password Baru')" class="text-slate-700 font-semibold mb-2" />
            <x-text-input id="update_password_password" name="password" type="password" class="mt-1 block w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition-all text-sm" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" :value="__('Konfirmasi Password')" class="text-slate-700 font-semibold mb-2" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" type="password" class="mt-1 block w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition-all text-sm" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="mt-2" />
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
            <button type="submit" class="px-6 py-2.5 bg-slate-800 hover:bg-slate-900 text-white font-bold rounded-xl shadow-lg shadow-slate-500/30 transition-all transform hover:scale-[1.02]">
                {{ __('Simpan Password') }}
            </button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-emerald-600 font-medium bg-emerald-50 px-3 py-1.5 rounded-lg border border-emerald-100"
                >{{ __('Berhasil Disimpan.') }}</p>
            @endif
        </div>
    </form>
</section>
