<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="mb-8 flex justify-between items-center">
                <h2 class="text-2xl font-bold text-slate-800">Pengaturan Akun</h2>
                <a href="{{ route('dashboard') }}" class="px-5 py-2.5 bg-slate-800 text-white font-medium rounded-xl hover:bg-slate-700 transition-colors shadow-lg shadow-slate-500/20">
                    &larr; Kembali ke Dashboard
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <!-- Kiri: Info Profil -->
                <div class="space-y-6">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <!-- Kanan: Password & Hapus Akun -->
                <div class="space-y-8">
                    @include('profile.partials.update-password-form')
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
