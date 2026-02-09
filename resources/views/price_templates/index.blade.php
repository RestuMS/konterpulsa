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

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 rounded-xl flex items-center gap-3">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            {{ session('success') }}
        </div>
    @endif

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
                                    <a href="{{ route('price-templates.edit', $template->id) }}" class="text-blue-400 hover:text-blue-300 font-medium text-sm transition-colors">Edit</a>
                                    <form action="{{ route('price-templates.destroy', $template->id) }}" method="POST" onsubmit="return confirm('Hapus template ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-400 hover:text-red-300 font-medium text-sm transition-colors">Hapus</button>
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
</x-admin-layout>
