<section class="bg-red-50 rounded-2xl shadow-sm border border-red-100 p-8 space-y-6">
    <header>
        <h2 class="text-xl font-bold text-red-700">
            {{ __('Hapus Akun') }}
        </h2>

        <p class="mt-2 text-sm text-red-600">
            {{ __('Setelah akun Anda dihapus, semua data akan hilang secara permanen. Harap unduh data penting sebelum menghapus akun.') }}
        </p>
    </header>

    <x-danger-button
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
        class="bg-red-600 hover:bg-red-700 focus:ring-red-500 rounded-xl px-6 py-3 shadow-lg shadow-red-500/30"
    >{{ __('Hapus Akun') }}</x-danger-button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-8 rounded-2xl">
            @csrf
            @method('delete')

            <h2 class="text-xl font-bold text-slate-800">
                {{ __('Apakah Anda yakin ingin menghapus akun ini?') }}
            </h2>

            <p class="mt-2 text-sm text-slate-500">
                {{ __('Setelah dihapus, data tidak bisa dikembalikan. Silakan masukkan password Anda untuk konfirmasi.') }}
            </p>

            <div class="mt-6">
                <x-input-label for="password" value="{{ __('Password') }}" class="sr-only" />

                <x-text-input
                    id="password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full rounded-xl border-slate-200 focus:border-red-500 focus:ring-red-500 text-sm py-3"
                    placeholder="{{ __('Password Anda') }}"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="mt-2" />
            </div>

            <div class="mt-8 flex justify-end gap-3">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>

                <x-danger-button class="bg-red-600 hover:bg-red-700">
                    {{ __('Hapus Akun Permanen') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</section>
