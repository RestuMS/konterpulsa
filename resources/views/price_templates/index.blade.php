<x-admin-layout>
    <x-slot name="header">
        {{ __('Setting Harga Otomatis') }}
    </x-slot>

    <div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h2 class="text-2xl font-bold text-white">Template Harga</h2>
            <p class="text-slate-400 text-sm mt-1">Atur pattern dan harga produk otomatis di sini.</p>
        </div>
        <a href="{{ route('price-templates.create') }}" class="px-5 py-2.5 bg-gradient-to-r from-pink-500 to-purple-600 hover:from-pink-600 hover:to-purple-700 text-white font-bold rounded-xl shadow-lg shadow-pink-500/20 transition-all flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path></svg>
            Tambah Template
        </a>
    </div>

    <div class="bg-slate-800/50 rounded-2xl border border-slate-700/50 overflow-hidden shadow-xl">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-700/30 border-b border-slate-700/50 text-xs uppercase tracking-widest text-slate-400 font-bold">
                        <th class="px-6 py-4">Operator</th>
                        <th class="px-6 py-4">Kategori</th>
                        <th class="px-6 py-4">Nama Produk</th>
                        <th class="px-6 py-4 text-right">Harga Modal</th>
                        <th class="px-6 py-4 text-right">Harga Jual</th>
                        <th class="px-6 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    @forelse($templates as $template)
                        <tr class="hover:bg-slate-700/30 transition-colors text-slate-300">
                            <td class="px-6 py-4 font-bold text-white">{{ $template->provider }}</td>
                            <td class="px-6 py-4">
                                <span class="bg-blue-500/20 text-blue-400 px-3 py-1 rounded-lg font-bold text-xs uppercase">{{ $template->category }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <span class="font-mono bg-pink-500/20 text-pink-400 px-3 py-1 rounded-lg font-bold text-sm">{{ $template->pattern }}</span>
                            </td>
                            <td class="px-6 py-4 text-right font-mono text-slate-400">Rp {{ number_format($template->cost_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-right font-mono font-bold text-emerald-400">Rp {{ number_format($template->price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 text-center">
                                <div class="flex items-center justify-center gap-3">
                                    <a href="{{ route('price-templates.edit', $template->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-blue-500/10 text-blue-400 hover:bg-blue-500/20 hover:text-blue-300 rounded-lg font-medium text-sm transition-all border border-blue-500/20 hover:border-blue-500/40">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                                        Edit
                                    </a>
                                    <form action="{{ route('price-templates.destroy', $template->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this)" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-red-500/10 text-red-400 hover:bg-red-500/20 hover:text-red-300 rounded-lg font-medium text-sm transition-all border border-red-500/20 hover:border-red-500/40">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="p-10 text-center text-slate-500">
                                <svg class="w-12 h-12 mx-auto mb-3 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                Belum ada template harga. Klik "Tambah Template" untuk memulai.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- SweetAlert2 CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // ✅ Konfirmasi Hapus dengan SweetAlert2
        function confirmDelete(btn) {
            Swal.fire({
                title: 'Hapus Template?',
                text: 'Template harga ini akan dihapus permanen dan tidak bisa dikembalikan!',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#64748b',
                confirmButtonText: '<span class="flex items-center gap-2">🗑️ Ya, Hapus!</span>',
                cancelButtonText: 'Batal',
                background: '#1e293b',
                color: '#f1f5f9',
                customClass: {
                    popup: 'rounded-2xl border border-slate-700',
                    title: 'text-white',
                    htmlContainer: 'text-slate-400',
                    confirmButton: 'rounded-xl font-bold px-6 py-2.5',
                    cancelButton: 'rounded-xl font-bold px-6 py-2.5',
                },
                showClass: {
                    popup: 'animate__animated animate__fadeInDown animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp animate__faster'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    btn.closest('form').submit();
                }
            });
        }

        // ✅ Notifikasi Otomatis dari Session Flash
        document.addEventListener('DOMContentLoaded', () => {
            @if(session('success'))
                const action = '{{ session('action', 'store') }}';
                
                let icon, title, iconColor, timer;

                if (action === 'store') {
                    icon = 'success';
                    title = '🎉 Berhasil Disimpan!';
                    iconColor = '#10b981';
                    timer = 3000;
                } else if (action === 'update') {
                    icon = 'success';
                    title = '✏️ Berhasil Diperbarui!';
                    iconColor = '#3b82f6';
                    timer = 3000;
                } else if (action === 'delete') {
                    icon = 'success';
                    title = '🗑️ Berhasil Dihapus!';
                    iconColor = '#ef4444';
                    timer = 3000;
                }

                Swal.fire({
                    icon: icon,
                    title: title,
                    text: '{{ session('success') }}',
                    iconColor: iconColor,
                    timer: timer,
                    timerProgressBar: true,
                    showConfirmButton: false,
                    background: '#1e293b',
                    color: '#f1f5f9',
                    toast: true,
                    position: 'top-end',
                    customClass: {
                        popup: 'rounded-2xl border border-slate-700 shadow-2xl',
                        title: 'text-sm font-bold',
                        htmlContainer: 'text-xs',
                        timerProgressBar: 'bg-emerald-500',
                    },
                    showClass: {
                        popup: 'animate__animated animate__slideInRight animate__faster'
                    },
                    hideClass: {
                        popup: 'animate__animated animate__slideOutRight animate__faster'
                    },
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });
            @endif
        });
    </script>
</x-admin-layout>
