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
                    
                    <!-- Nama Produk & Qty -->
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                        <div class="group md:col-span-3">
                            <label for="name" class="block text-sm font-semibold text-slate-700 mb-2">Nama Produk</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                </div>
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-slate-800 placeholder-slate-400 font-medium" placeholder="Contoh: Pulsa 10k" required>
                            </div>
                        </div>
                        
                        <!-- Quantity -->
                         <div class="group">
                            <label for="quantity" class="block text-sm font-semibold text-slate-700 mb-2">Jumlah (Qty)</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-slate-400 font-bold text-xs uppercase">x</span>
                                </div>
                                <input type="number" name="quantity" id="quantity" value="1" min="1" class="w-full pl-8 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-slate-800 font-bold text-center" required>
                            </div>
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
                                    @foreach(['Telkomsel', 'By.U', 'Three', 'XL', 'Axis', 'Smartfren', 'Indosat', 'Dana', 'Gopay', 'ShopeePay', 'Token', 'Pajak', 'Tarik Tunai', 'Free Fire', 'Mobile Legends'] as $provider)
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
                                <input type="text" name="cost_price" id="cost_price" value="" placeholder="0" class="rupiah-input w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all text-slate-800 font-mono font-bold" required>
                            </div>
                        </div>

                        <!-- Harga Jual -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Harga Jual</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-slate-400 font-bold group-focus-within:text-green-500 transition-colors">Rp</span>
                                </div>
                                <input type="text" name="price" id="price" value="" placeholder="0" class="rupiah-input w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-all text-slate-800 font-mono font-bold" required>
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

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const nameInput = document.getElementById('name');
        const costInput = document.getElementById('cost_price');
        const priceInput = document.getElementById('price');
        const providerSelect = document.querySelector('select[name="code"]');
        const categorySelect = document.querySelector('select[name="category_id"]');

        // 1. Inisialisasi Database Struktur
        const pricingDatabase = {
            'telkomsel': { patterns: ['tsel', 'telkomsel', 'simpati', 'as'], products: [] },
            'three':     { patterns: ['tri', 'three', '3 '], products: [] },
            'indosat':   { patterns: ['indosat', 'isat', 'im3'], products: [] },
            'xl':        { patterns: ['xl'], products: [] },
            'axis':      { patterns: ['axis'], products: [] },
            'smartfren': { patterns: ['smartfren'], products: [] },
            'byu':       { patterns: ['byu', 'by.u'], products: [] },
            'dana':      { patterns: ['dana'], products: [] },
            'gopay':     { patterns: ['gopay'], products: [] },
            'shopeepay': { patterns: ['shopee', 'shopeepay'], products: [] },
            'token':     { patterns: ['token', 'pln'], products: [] },
        };

        // 2. Load Data dari Database (Dynamic)
        const dbTemplates = @json($priceTemplates ?? []);

        dbTemplates.forEach(template => {
            // Mapping Provider Name dari DB ke Key pricingDatabase
            let key = null;
            const p = template.provider.toLowerCase();
            
            if (p === 'three') key = 'three';
            else if (p === 'by.u') key = 'byu';
            else if (pricingDatabase[p]) key = p;
            
            if (key && pricingDatabase[key]) {
                const keywords = template.pattern.toLowerCase().split(' ').map(k => k.trim());
                
                pricingDatabase[key].products.push({
                    check: keywords,
                    cost: parseFloat(template.cost_price),
                    price: parseFloat(template.price)
                });
            }
        });

        // Helper Functions for Rupiah Formatting
        function formatRupiah(angka) {
            if (!angka) return '';
            
            // Ensure input is a string
            let number_string = angka.toString().replace(/[^,\d]/g, '');
            
            // Remove leading zeros by parsing to int then back to string, unless it's just "0" or empty
            if (number_string === '') return '';
            
            // Parse integer to remove leading zeros (e.g., "05" -> 5)
            // But be careful if user is typing "0" intentionally as first char of nothing? 
            // Actually standard behavior: typing 5 when value is empty -> 5. 
            // If placeholder is 0, value is empty.
            
            let value = parseInt(number_string);
            if (isNaN(value)) return '';
            
            number_string = value.toString();
            
            let split = number_string.split(','),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
            return rupiah;
        }

        function cleanRupiah(angka) {
            return angka.replace(/\./g, '');
        }

        // Apply formatting logic to inputs
        [costInput, priceInput].forEach(input => {
            input.addEventListener('input', function(e) {
                e.target.value = formatRupiah(e.target.value);
            });
            
            // Handle focus: if empty, keep empty (placeholder '0' handles visual).
            // Logic "tidak perlu menghapus angka 0" is handled by the fact that
            // we removed value="0" and used placeholder="0".
            // If we had value="0", we would need to clear it on focus or intelligent formatting.
            // With placeholder, the user just types "5" and it becomes "5".
        });

        // 3. Logic Event Input (Product Name)
        nameInput.addEventListener('input', (e) => {
            const text = e.target.value.toLowerCase();
            
            // A. Deteksi Provider
            let foundProviderKey = null;
            
            for (const [key, data] of Object.entries(pricingDatabase)) {
                if (data.patterns.some(pattern => text.includes(pattern))) {
                    foundProviderKey = key;
                    
                    // Auto-select Provider di Dropdown
                    const providerMap = {
                        'three': 'Three',
                        'telkomsel': 'Telkomsel', 
                        'xl': 'XL',
                        'indosat': 'Indosat',
                        'axis': 'Axis',
                        'smartfren': 'Smartfren',
                        'byu': 'By.U',
                        'dana': 'Dana',
                        'gopay': 'Gopay',
                        'shopeepay': 'ShopeePay',
                        'token': 'Token',
                    };
                    
                    if (providerMap[key]) {
                        for(let i=0; i<providerSelect.options.length; i++) {
                            if(providerSelect.options[i].value === providerMap[key]) {
                                providerSelect.selectedIndex = i;
                                break;
                            }
                        }
                    }
                    break; 
                }
            }

            // B. Deteksi Harga Berdasarkan Keyword Produk
            if (foundProviderKey) {
                const products = pricingDatabase[foundProviderKey].products;
                let matchedProduct = null;
                
                products.sort((a, b) => b.check.length - a.check.length);

                for (const product of products) {
                    const allKeywordsMatch = product.check.every(keyword => text.includes(keyword));
                    if (allKeywordsMatch) {
                        matchedProduct = product;
                        break; 
                    }
                }

                if (matchedProduct) {
                    // Update values with formatting
                    costInput.value = formatRupiah(matchedProduct.cost);
                    priceInput.value = formatRupiah(matchedProduct.price);
                    
                    // Visual feedback
                    costInput.classList.add('bg-green-50', 'text-green-700');
                    setTimeout(() => costInput.classList.remove('bg-green-50', 'text-green-700'), 500);
                }
            }
        });

        // 4. Clean inputs on submit
        const form = document.querySelector('form');
        form.addEventListener('submit', function() {
            [costInput, priceInput].forEach(input => {
                input.value = cleanRupiah(input.value);
            });
        });
    });
</script>
