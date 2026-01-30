<section class="bg-white rounded-2xl shadow-sm border border-slate-100 p-8">
    <header class="mb-6">
        <h2 class="text-xl font-bold text-slate-800">
            {{ __('Informasi Profil') }}
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            {{ __("Perbarui informasi akun dan alamat email Anda.") }}
        </p>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
        @csrf
        @method('patch')

        <div>
            <x-input-label for="name" :value="__('Nama Lengkap')" class="text-slate-700 font-semibold mb-2" />
            <x-text-input id="name" name="name" type="text" class="mt-1 block w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition-all text-sm" :value="old('name', $user->name)" required autofocus autocomplete="name" />
            <x-input-error class="mt-2" :messages="$errors->get('name')" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" class="text-slate-700 font-semibold mb-2" />
            <x-text-input id="email" name="email" type="email" class="mt-1 block w-full rounded-xl border-slate-200 focus:border-blue-500 focus:ring-blue-500 transition-all text-sm" :value="old('email', $user->email)" required autocomplete="username" />
            <x-input-error class="mt-2" :messages="$errors->get('email')" />

            @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
                <div>
                    <p class="text-sm mt-2 text-red-600 bg-red-50 p-3 rounded-lg">
                        {{ __('Alamat email Anda belum diverifikasi.') }}

                        <button form="send-verification" class="underline text-sm text-red-600 hover:text-red-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                            {{ __('Klik di sini untuk mengirim ulang email verifikasi.') }}
                        </button>
                    </p>

                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-2 font-medium text-sm text-green-600">
                            {{ __('Tautan verifikasi baru telah dikirim ke alamat email Anda.') }}
                        </p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4 pt-4 border-t border-slate-100">
            <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transition-all transform hover:scale-[1.02]">
                {{ __('Simpan Perubahan') }}
            </button>

            @if (session('status') === 'profile-updated')
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
