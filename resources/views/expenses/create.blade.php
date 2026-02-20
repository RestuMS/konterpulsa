<x-admin-layout>
    <x-slot name="header">
        {{ __('Tambah Pengeluaran') }}
    </x-slot>

    <div class="max-w-2xl mx-auto">
        <div class="mb-6">
            <a href="{{ route('expenses.index') }}" class="inline-flex items-center gap-2 text-sm text-slate-500 hover:text-slate-700 font-medium transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
                Kembali ke Daftar
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-xl border border-slate-100 overflow-hidden">
            <!-- Header -->
            <div class="px-6 py-5 bg-gradient-to-r from-orange-500 to-red-500 text-white">
                <h3 class="text-lg font-bold flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    Catat Pengeluaran Baru
                </h3>
                <p class="text-white/70 text-sm mt-1">Isi detail pengeluaran operasional toko</p>
            </div>

            <!-- Form -->
            <form action="{{ route('expenses.store') }}" method="POST" class="p-6 space-y-5">
                @csrf

                <!-- Judul -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Judul Pengeluaran <span class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}" required
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all"
                        placeholder="Contoh: Beli bensin, Jajan siang, Beli pulsa...">
                    @error('title') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Kategori -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                        <select name="category" required
                            class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-semibold text-slate-700 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all appearance-none cursor-pointer">
                            <option value="" disabled selected>Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat }}" {{ old('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
                            @endforeach
                        </select>
                        @error('category') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>

                    <!-- Jumlah -->
                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-1.5">Jumlah (Rp) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-red-500 text-sm font-bold">Rp</span>
                            <input type="text" name="amount" value="{{ old('amount') }}" required id="amountInput"
                                class="w-full pl-10 pr-4 py-3 bg-red-50/30 border border-red-200/50 rounded-xl text-sm font-mono font-bold text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-red-500/20 focus:border-red-400 transition-all"
                                placeholder="0">
                        </div>
                        @error('amount') <p class="mt-1 text-xs text-red-500">{{ $message }}</p> @enderror
                    </div>
                </div>

                <!-- Tanggal -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Tanggal</label>
                    <input type="date" name="created_at" value="{{ old('created_at', now()->format('Y-m-d')) }}"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm font-medium text-slate-700 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all cursor-pointer">
                </div>

                <!-- Keterangan -->
                <div>
                    <label class="block text-sm font-bold text-slate-700 mb-1.5">Keterangan <span class="text-slate-400 font-normal">(opsional)</span></label>
                    <textarea name="description" rows="3"
                        class="w-full px-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-orange-500/20 focus:border-orange-500 transition-all resize-none"
                        placeholder="Tambahkan catatan tambahan...">{{ old('description') }}</textarea>
                </div>

                <!-- Submit -->
                <div class="flex gap-3 pt-2">
                    <a href="{{ route('expenses.index') }}" class="flex-1 text-center px-5 py-3 bg-white border border-slate-200 text-slate-600 rounded-xl font-bold hover:bg-slate-50 transition-all text-sm">
                        Batal
                    </a>
                    <button type="submit" class="flex-1 px-5 py-3 bg-gradient-to-r from-orange-500 to-red-500 hover:from-orange-600 hover:to-red-600 text-white font-bold rounded-xl shadow-lg shadow-orange-200 transition-all text-sm flex items-center justify-center gap-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Rupiah formatter
        document.getElementById('amountInput').addEventListener('input', function(e) {
            let value = e.target.value.replace(/[^0-9]/g, '');
            if (value === '') { e.target.value = ''; return; }
            let num = parseInt(value);
            e.target.value = num.toLocaleString('id-ID');
        });
    </script>
</x-admin-layout>
