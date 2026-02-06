<x-admin-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mb-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                <div>
                    <h2 class="text-3xl font-black text-white tracking-tight">Pengaturan Akun</h2>
                    <p class="text-slate-400 mt-1">Kelola informasi profil dan keamanan akun Anda</p>
                </div>
                <a href="{{ route('dashboard') }}" class="group px-5 py-2.5 bg-slate-800 text-slate-300 font-bold rounded-xl border border-slate-700 hover:border-blue-500 hover:text-blue-400 transition-all shadow-sm flex items-center gap-2">
                    <svg class="w-5 h-5 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                    Kembali ke Dashboard
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                <!-- Kiri: Info Profil (Width 7/12) -->
                <div class="lg:col-span-7 space-y-8">
                    @include('profile.partials.update-profile-information-form')
                </div>

                <!-- Kanan: Password & Hapus Akun (Width 5/12) -->
                <div class="lg:col-span-5 space-y-8">
                    @include('profile.partials.update-password-form')
                    @include('profile.partials.delete-user-form')
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
