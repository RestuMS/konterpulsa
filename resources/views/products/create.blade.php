<x-admin-layout>
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-slate-100 overflow-hidden relative">
            
            <!-- Header -->
            <div class="px-8 py-6 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                <div>
                    <h2 class="text-2xl font-bold text-slate-800 tracking-tight font-display">Tambah Transaksi</h2>
                    <p class="text-slate-500 text-sm mt-1">Input data transaksi baru ke dalam sistem</p>
                </div>
                <a href="{{ route('products.index') }}" class="group p-2 rounded-full hover:bg-red-50 transition-colors duration-200">
                    <svg class="w-6 h-6 text-slate-400 group-hover:text-red-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </a>
            </div>

            <!-- Form -->
            <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                @csrf

                <div class="space-y-6">

                    <!-- Tanggal Transaksi (Optional) -->
                    <div class="group">
                        <label for="created_at" class="block text-sm font-semibold text-slate-700 mb-2">Tanggal Transaksi <span class="text-slate-400 font-normal text-xs">(Opsional - Untuk input tanggal mundur)</span></label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                            </div>
                            <input type="date" name="created_at" id="created_at" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-slate-800 placeholder-slate-400 font-medium cursor-pointer">
                        </div>
                    </div>
                    
                    <!-- Nama Produk -->
                    <div class="group">
                        <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Produk</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                            </div>
                            <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-slate-800 placeholder-slate-400 font-medium" placeholder="Contoh: Pulsa 10k" required>
                        </div>
                    </div>

                    <!-- Kategori & Kode Provider Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                         <!-- Kategori -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Kategori</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-white z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                </div>
                                <select name="category_id" class="w-full pl-10 pr-10 py-3 bg-blue-600 border border-blue-600 text-white rounded-xl focus:ring-2 focus:ring-blue-500/40 focus:border-blue-700 transition-all font-semibold appearance-none cursor-pointer hover:bg-blue-700">
                                    <option value="" disabled selected class="text-slate-500 bg-white">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }} class="bg-white text-slate-800">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-white/80">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        <!-- Kode Provider -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Provider</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <select name="code" class="w-full pl-10 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-slate-800 font-medium appearance-none cursor-pointer">
                                    <option value="" disabled selected>Pilih Provider</option>
                                    @foreach(['Telkomsel', 'Three', 'XL', 'Axis', 'Smartfren', 'Indosat', 'Dana', 'Gopay', 'ShopeePay', 'Token', 'Pajak', 'Tarik Tunai'] as $provider)
                                        <option value="{{ $provider }}" {{ old('code') == $provider ? 'selected' : '' }}>{{ $provider }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Harga Grid -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Harga Beli -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Harga Beli (Modal)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-slate-400 font-bold group-focus-within:text-red-500 transition-colors">Rp</span>
                                </div>
                                <input type="number" name="cost_price" value="0" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all text-slate-800 font-mono font-bold" required>
                            </div>
                        </div>

                        <!-- Harga Jual -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Harga Jual</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-slate-400 font-bold group-focus-within:text-green-500 transition-colors">Rp</span>
                                </div>
                                <input type="number" name="price" value="0" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-all text-slate-800 font-mono font-bold" required>
                            </div>
                        </div>
                    </div>

                     <!-- Status & Pelanggan Grid -->
                     <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Status Pembayaran -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Status Pembayaran</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <select name="payment_status" class="w-full pl-10 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-slate-800 font-bold appearance-none cursor-pointer">
                                    <option value="paid" class="text-emerald-600 font-bold">LUNAS</option>
                                    <option value="unpaid" class="text-rose-600 font-bold">HUTANG / KASBON</option>
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                         <!-- Nama Pelanggan -->
                         <div class="group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Nama Pelanggan <span class="text-slate-400 font-normal text-xs">(Opsional)</span></label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                </div>
                                <input type="text" name="customer_name" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-slate-800 placeholder-slate-400" placeholder="Isi jika Kasbon">
                            </div>
                        </div>
                    </div>

                    <!-- Stok (Quick Select) -->
                    <div class="group">
                        <label class="block text-sm font-semibold text-slate-700 mb-2">Ketersediaan Stok</label>
                        <div class="grid grid-cols-2 gap-4">
                            <label class="cursor-pointer">
                                <input type="radio" name="stock_status" value="available" class="peer sr-only" checked onchange="document.getElementById('stock').value = 100">
                                <div class="flex items-center justify-center gap-2 p-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-600 peer-checked:bg-emerald-50 peer-checked:border-emerald-500 peer-checked:text-emerald-700 transition-all font-medium hover:bg-slate-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                    Stok Tersedia
                                </div>
                            </label>
                             <label class="cursor-pointer">
                                <input type="radio" name="stock_status" value="empty" class="peer sr-only" onchange="document.getElementById('stock').value = 0">
                                <div class="flex items-center justify-center gap-2 p-3 rounded-xl border border-slate-200 bg-slate-50 text-slate-600 peer-checked:bg-slate-800 peer-checked:border-slate-800 peer-checked:text-white transition-all font-medium hover:bg-slate-100">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    Stok Habis
                                </div>
                            </label>
                        </div>
                        <input type="hidden" name="stock" id="stock" value="100">
                    </div>

                </div>

                <!-- Footer Actions -->
                <div class="mt-8 pt-6 border-t border-slate-100 flex items-center justify-end gap-3">
                    <a href="{{ route('products.index') }}" class="px-6 py-3 rounded-xl text-slate-500 font-semibold hover:bg-slate-100 hover:text-slate-700 transition-all">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3 bg-gradient-to-r from-emerald-500 to-teal-500 hover:from-emerald-600 hover:to-teal-600 text-white font-bold rounded-xl shadow-lg shadow-emerald-200 transform hover:scale-[1.02] transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan Transaksi
                    </button>
                </div>

            </form>
        </div>
    </div>
</x-admin-layout>
