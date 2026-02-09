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
            <form id="productForm" action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="p-8">
                @csrf

                <div class="space-y-6">

                    <!-- Global Error Summary -->
                    @if ($errors->any())
                        <div class="bg-red-50 border-l-4 border-red-500 p-4 rounded-r-lg mb-6">
                            <div class="flex">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan pada input:</h3>
                                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </div>
                    @endif

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
                                <input type="text" name="name" id="name" value="{{ old('name') }}" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-slate-800 placeholder-slate-400 font-medium @error('name') border-red-500 ring-1 ring-red-500 @enderror" placeholder="Contoh: Pulsa 10k" required>
                                @error('name') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
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
                                <select name="category_id" id="category_id" class="w-full pl-10 pr-10 py-3 bg-blue-600 border border-blue-600 text-white rounded-xl focus:ring-2 focus:ring-blue-500/40 focus:border-blue-700 transition-all font-semibold appearance-none cursor-pointer hover:bg-blue-700 @error('category_id') border-red-500 ring-1 ring-red-500 @enderror">
                                    <option value="" disabled selected class="text-slate-500 bg-white">Pilih Kategori</option>
                                    @foreach($categories as $category)
                                        <option value="{{ $category->id }}" data-name="{{ $category->name }}" {{ old('category_id') == $category->id ? 'selected' : '' }} class="bg-white text-slate-800">
                                            {{ $category->name }}
                                        </option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-white/80">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            @error('category_id') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <!-- Kode Provider -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Operator</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-slate-400 group-focus-within:text-blue-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                </div>
                                <select name="code" id="provider_code" class="w-full pl-10 pr-10 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-slate-800 font-medium appearance-none cursor-pointer @error('code') border-red-500 ring-1 ring-red-500 @enderror">
                                    <option value="" disabled selected>Pilih Operator</option>
                                    @foreach(['Telkomsel', 'Indosat', 'Three', 'XL', 'Axis', 'Smartfren', 'By.U', 'Dana', 'Gopay', 'ShopeePay', 'Token', 'Listrik', 'Pajak', 'BPJS', 'Free Fire', 'Mobile Legends', 'Voucher', 'Paket Data', 'Kartu Perdana', 'Lainnya'] as $provider)
                                        <option value="{{ $provider }}" {{ old('code') == $provider ? 'selected' : '' }}>{{ $provider }}</option>
                                    @endforeach
                                </select>
                                <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none text-slate-400">
                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                            @error('code') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
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
                                <input type="text" name="cost_price" id="cost_price" value="{{ old('cost_price') }}" placeholder="0" class="rupiah-input w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-red-500 transition-all text-slate-800 font-mono font-bold @error('cost_price') border-red-500 ring-1 ring-red-500 @enderror" required>
                                @error('cost_price') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
                            </div>
                        </div>

                        <!-- Harga Jual -->
                        <div class="group">
                            <label class="block text-sm font-semibold text-slate-700 mb-2">Harga Jual</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-slate-400 font-bold group-focus-within:text-green-500 transition-colors">Rp</span>
                                </div>
                                <input type="text" name="price" id="price" value="{{ old('price') }}" placeholder="0" class="rupiah-input w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:bg-white focus:ring-2 focus:ring-green-500/20 focus:border-green-500 transition-all text-slate-800 font-mono font-bold @error('price') border-red-500 ring-1 ring-red-500 @enderror" required>
                                @error('price') <span class="text-red-500 text-xs mt-1 block">{{ $message }}</span> @enderror
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
        const providerSelect = document.getElementById('provider_code');
        const categorySelect = document.getElementById('category_id');

        // Load Templates from Database
        const dbTemplates = @json($priceTemplates ?? []);

        // Helper Functions for Rupiah Formatting
        function formatRupiah(angka) {
            if (!angka) return '';
            let number_string = angka.toString().replace(/[^,\d]/g, '');
            if (number_string === '') return '';
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

        [costInput, priceInput].forEach(input => {
            input.addEventListener('input', function(e) {
                e.target.value = formatRupiah(e.target.value);
            });
        });

        // --- Logic Pencarian Harga & Category Otomatis ---
        function checkAndApplyTemplate() {
            const currentName = nameInput.value.toLowerCase();
            if (!currentName) return;

            const currentProvider = providerSelect.value;
            // Note: We prioritize finding a match even if category is not selected yet
            
            // Filter templates that match the selected provider (if selected)
            // If provider is not selected, we look through all, but usually provider is auto-detected first
            let relevantTemplates = dbTemplates;
            if (currentProvider) {
                relevantTemplates = dbTemplates.filter(t => t.provider === currentProvider);
            }

            // Find matching product pattern
            const matchedTemplate = relevantTemplates.find(template => {
                const keywords = template.pattern.toLowerCase().split(' ').map(k => k.trim());
                return keywords.every(keyword => currentName.includes(keyword));
            });

            if (matchedTemplate) {
                console.log("Template found:", matchedTemplate);

                // 1. Auto-set Category if it matches the template's category
                for(let i=0; i<categorySelect.options.length; i++) {
                     if(categorySelect.options[i].getAttribute('data-name') === matchedTemplate.category) {
                         categorySelect.selectedIndex = i;
                         break;
                     }
                }

                // 2. Set Prices
                costInput.value = formatRupiah(parseInt(matchedTemplate.cost_price));
                priceInput.value = formatRupiah(parseInt(matchedTemplate.price));

                // Visual Feedback
                costInput.classList.add('bg-green-50', 'text-green-700');
                priceInput.classList.add('bg-green-50', 'text-green-700');
                
                setTimeout(() => {
                    costInput.classList.remove('bg-green-50', 'text-green-700');
                    priceInput.classList.remove('bg-green-50', 'text-green-700');
                }, 1000);
            } else {
                // If no template match, use legacy keyword fallback for category (only if empty)
                if (categorySelect.value === "") {
                    autoDetectCategoryFallback(currentName);
                }
            }
        }

        // --- Logic Auto-Detect Provider ---
        function autoDetectProvider(text) {
             if (providerSelect.value === "") {
                const providerMap = {
                    'tree': 'Three', 'tri': 'Three', '3 ': 'Three',
                    'telkomsel': 'Telkomsel', 'tsel': 'Telkomsel', 'simpati': 'Telkomsel', 'as ': 'Telkomsel',
                    'xl': 'XL', 'axis': 'Axis', 'smartfren': 'Smartfren', 'by.u': 'By.U', 'byu': 'By.U',
                    'dana': 'Dana', 'gopay': 'Gopay', 'shopeepay': 'ShopeePay', 
                    'token': 'Token', 
                    'listrik': 'Listrik', 'pln': 'Listrik'
                };
                
                for (const [key, val] of Object.entries(providerMap)) {
                    if (text.includes(key)) {
                        for(let i=0; i<providerSelect.options.length; i++) {
                            if(providerSelect.options[i].value === val) {
                                providerSelect.selectedIndex = i;
                                break;
                            }
                        }
                        break;
                    }
                }
            }
        }

        function autoDetectCategoryFallback(text) {
            let detectedCategoryName = null;
            if (['dana', 'gopay', 'shopeepay', 'ovo', 'linkaja', 'wallet'].some(k => text.includes(k))) detectedCategoryName = 'E-Wallet';
            else if (['token', 'pln', 'listrik'].some(k => text.includes(k))) detectedCategoryName = 'Listrik';
            else if (text.includes('voucher') || text.includes('vc') || text.includes('fisik')) detectedCategoryName = 'Voucher';
            else if (text.includes('data') || text.includes('gb') || text.includes('quota') || text.includes('kuota') || text.includes('freedom') || text.includes('unlimited')) detectedCategoryName = 'Paket Data';
            else if (text.includes('pulsa') || text.includes('isi ulang')) detectedCategoryName = 'Pulsa';
            else if (['ff', 'free fire', 'ml', 'mobile legends', 'game', 'top up'].some(k => text.includes(k))) detectedCategoryName = 'Top Up Game'; // Sesuaikan name di DB
            
            if (detectedCategoryName) {
                for(let i=0; i<categorySelect.options.length; i++) {
                        if(categorySelect.options[i].getAttribute('data-name') === detectedCategoryName) {
                            categorySelect.selectedIndex = i;
                            break;
                        }
                }
            }
        }

        // Attach Listeners
        nameInput.addEventListener('input', (e) => {
            const text = e.target.value.toLowerCase();
            autoDetectProvider(text); 
            checkAndApplyTemplate(); 
        });

        providerSelect.addEventListener('change', checkAndApplyTemplate);
        // We still check template on category change, though usually name+provider drives it
        categorySelect.addEventListener('change', checkAndApplyTemplate);

    });
</script>
