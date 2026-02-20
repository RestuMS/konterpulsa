@push('head-scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush

<x-admin-layout>
    <div class="min-h-screen p-3 sm:p-4 md:p-8 bg-slate-50">
        
        <!-- Header -->
        <div class="max-w-7xl mx-auto mb-6 md:mb-8">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                <div>
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-bold text-slate-800 tracking-tight font-display">Mode Transaksi Banyak</h2>
                    <p class="text-slate-500 mt-1 text-sm">Input beberapa transaksi sekaligus untuk efisiensi waktu.</p>
                </div>
                <div class="flex gap-3 w-full sm:w-auto">
                    <a href="{{ route('products.index') }}" class="flex-1 sm:flex-none text-center px-4 sm:px-5 py-2.5 bg-white border border-slate-200 text-slate-600 rounded-xl hover:bg-slate-50 font-medium transition-all shadow-sm text-sm">
                        Kembali
                    </a>
                    <button type="button" onclick="submitForm()" class="flex-1 sm:flex-none px-4 sm:px-6 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-bold rounded-xl shadow-lg shadow-blue-200 transform hover:scale-[1.02] transition-all flex items-center justify-center gap-2 text-sm">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"></path></svg>
                        Simpan Semua
                    </button>
                </div>
            </div>
        </div>

        <!-- Form Container -->
        <div class="max-w-full mx-auto bg-white rounded-2xl md:rounded-3xl shadow-xl border border-slate-100 overflow-hidden">
            
            <form id="bulkForm" action="{{ route('products.store') }}" method="POST">
                @csrf

                @if ($errors->any())
                    <div class="p-4 md:p-6 bg-red-50 border-b border-red-100">
                        <div class="flex">
                            <svg class="h-5 w-5 text-red-400 mr-3 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            <div>
                                <h3 class="text-sm font-medium text-red-800">Terdapat kesalahan input. Mohon periksa kembali.</h3>
                                <ul class="mt-1 text-sm text-red-700 list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                {{-- ══ DESKTOP TABLE (hidden on mobile) ══ --}}
                <div class="hidden md:block overflow-x-auto">
                    <div class="overflow-hidden rounded-xl border border-slate-200 shadow-sm">
                        <table class="w-full text-left border-collapse" id="transactionTable">
                            <thead>
                                <tr class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-xs uppercase tracking-wider font-bold shadow-sm">
                                    <th class="p-4 w-14 text-center border-r border-blue-500/30 text-blue-50">#</th>
                                    <th class="p-4 min-w-[220px] whitespace-nowrap">Nama Produk</th>
                                    <th class="p-4 w-24 text-center whitespace-nowrap text-blue-50">Qty</th>
                                    <th class="p-4 min-w-[180px] whitespace-nowrap">Kategori & Operator</th>
                                    <th class="p-4 min-w-[140px] whitespace-nowrap">Harga Beli (Modal)</th>
                                    <th class="p-4 min-w-[140px] whitespace-nowrap">Harga Jual</th>
                                    <th class="p-4 min-w-[160px] whitespace-nowrap">Status & Pelanggan</th>
                                    <th class="p-4 w-24 text-center whitespace-nowrap border-l border-blue-500/30">Aksi</th>
                                </tr>
                            </thead>
                            <tbody id="tableBody" class="divide-y divide-slate-100 text-slate-700 bg-white">
                                <!-- Rows will be injected here via JS -->
                            </tbody>
                            <tfoot>
                                <tr class="bg-slate-50 border-t border-slate-200">
                                    <td colspan="8" class="p-4 text-center">
                                        <button type="button" onclick="addRow()" class="inline-flex items-center gap-2 px-6 py-2.5 bg-white border border-slate-300 rounded-lg text-slate-600 font-bold hover:border-blue-500 hover:text-blue-600 hover:bg-blue-50/50 hover:shadow-sm transition-all text-sm w-full md:w-auto justify-center group">
                                            <div class="p-0.5 bg-slate-100 rounded group-hover:bg-blue-200 transition-colors">
                                                <svg class="w-4 h-4 text-slate-500 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                                            </div>
                                            <span>Tambah Baris</span>
                                        </button>
                                    </td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>

                {{-- ══ MOBILE CARD VIEW (hidden on desktop) ══ --}}
                <div class="md:hidden">
                    <div id="mobileCardContainer" class="p-3 space-y-3">
                        <!-- Mobile cards injected here via JS -->
                    </div>
                    <div class="p-3 border-t border-slate-100">
                        <button type="button" onclick="addRow()" class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-white border-2 border-dashed border-slate-300 rounded-xl text-slate-500 font-bold hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50/30 transition-all text-sm group">
                            <div class="w-6 h-6 rounded-lg bg-slate-100 group-hover:bg-blue-100 flex items-center justify-center transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                            </div>
                            Tambah Transaksi
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>
</x-admin-layout>

<!-- Hidden Desktop Template -->
<template id="rowTemplate">
    <tr class="group hover:bg-blue-50/30 transition-all duration-300 align-top row-item border-b border-indigo-50 last:border-0 odd:bg-white even:bg-slate-50/30">
        <td class="p-4 text-center border-r border-indigo-50 align-top pt-5">
            <span class="row-number inline-flex items-center justify-center w-8 h-8 rounded-full bg-blue-100 text-blue-600 font-bold text-xs shadow-sm ring-2 ring-white">1</span>
        </td>
        
        <!-- Product Name & Date -->
        <td class="p-4 space-y-2 align-top">
            <div class="relative group/input">
                <input type="text" name="items[INDEX][name]" class="input-name w-full px-4 py-2.5 bg-white border border-slate-200/80 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm font-semibold text-slate-700 placeholder-slate-400 transition-all shadow-sm hover:border-indigo-300" placeholder="Ketik nama produk..." required>
                <div class="absolute inset-0 rounded-xl ring-1 ring-indigo-500/0 group-focus-within/input:ring-indigo-500/50 pointer-events-none transition-all"></div>
            </div>
            <div class="relative group/date w-fit">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-3.5 h-3.5 text-slate-400 group-focus-within/date:text-indigo-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                </div>
                 <input type="date" name="items[INDEX][created_at]" class="pl-9 pr-3 py-1.5 bg-slate-50 border border-transparent rounded-lg text-xs font-medium text-slate-500 hover:bg-white hover:border-slate-200 hover:shadow-sm focus:bg-white focus:ring-1 focus:ring-indigo-500 focus:text-indigo-600 transition-all cursor-pointer" title="Tanggal Transaksi (Opsi)">
            </div>
        </td>

        <!-- Quantity -->
        <td class="p-4 align-top pt-5">
            <div class="flex items-center justify-center">
                <div class="relative w-20 group/qty">
                    <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs font-bold pointer-events-none group-focus-within/qty:text-indigo-500 transition-colors">x</span>
                    <input type="number" name="items[INDEX][quantity]" value="1" min="1" class="w-full pl-7 pr-3 py-2 bg-white border border-slate-200 rounded-lg text-center font-bold text-slate-700 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all shadow-sm hover:border-indigo-300">
                </div>
            </div>
        </td>

        <!-- Category & Operator -->
        <td class="p-4 space-y-2 align-top">
            <div class="relative group/cat">
                <select name="items[INDEX][category_id]" class="input-category w-full pl-3 pr-8 py-2 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all appearance-none cursor-pointer hover:border-indigo-300 shadow-sm" required>
                    <option value="" disabled selected>Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" data-name="{{ $category->name }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none text-slate-400 group-focus-within/cat:text-indigo-500 transition-colors">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
            
            <div class="relative group/op">
                <select name="items[INDEX][code]" class="input-provider w-full pl-3 pr-8 py-2 bg-white border border-slate-200 rounded-lg text-xs font-bold text-slate-600 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all appearance-none cursor-pointer hover:border-indigo-300 shadow-sm" required>
                    <option value="" disabled selected>Pilih Operator</option>
                    @foreach(['Telkomsel', 'Indosat', 'Three', 'XL', 'Axis', 'Smartfren', 'By.U', 'Dana', 'Gopay', 'ShopeePay', 'Token', 'Listrik', 'BNI', 'BCA', 'Mandiri', 'BRI', 'BTN', 'Pajak', 'BPJS', 'Free Fire', 'Mobile Legends', 'Voucher', 'Paket Data', 'Kartu Perdana', 'Lainnya'] as $provider)
                        <option value="{{ $provider }}">{{ $provider }}</option>
                    @endforeach
                </select>
                <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none text-slate-400 group-focus-within/op:text-indigo-500 transition-colors">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
        </td>

        <!-- Cost Price -->
        <td class="p-4 align-top pt-5">
            <div class="relative group/price">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs font-bold transition-colors group-focus-within/price:text-red-500">Rp</span>
                <input type="text" name="items[INDEX][cost_price]" placeholder="0" class="input-cost w-full pl-8 pr-3 py-2 bg-slate-50/30 border border-slate-200 rounded-lg text-sm font-mono font-medium text-slate-600 focus:bg-white focus:ring-2 focus:ring-red-500/20 focus:border-red-500 focus:text-slate-900 transition-all shadow-sm hover:border-red-200 rupiah-input" required>
            </div>
        </td>

        <!-- Selling Price -->
        <td class="p-4 align-top pt-5">
             <div class="relative group/price">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 text-xs font-bold transition-colors group-focus-within/price:text-emerald-500">Rp</span>
                <input type="text" name="items[INDEX][price]" placeholder="0" class="input-price w-full pl-8 pr-3 py-2 bg-emerald-50/30 border border-emerald-100 rounded-lg text-sm font-mono font-bold text-slate-800 focus:bg-white focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all shadow-sm hover:border-emerald-300 rupiah-input" required>
            </div>
        </td>

        <!-- Status & Customer -->
        <td class="p-4 space-y-2 align-top">
            <div class="relative group/status">
                <select name="items[INDEX][payment_status]" class="input-status w-full pl-9 pr-8 py-2 bg-white border border-slate-200 rounded-lg text-xs font-bold focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all appearance-none cursor-pointer shadow-sm hover:border-indigo-300" onchange="toggleCustomerInput(this)">
                    <option value="paid" class="text-emerald-600 font-bold">LUNAS</option>
                    <option value="unpaid" class="text-rose-600 font-bold">BELUM LUNAS</option>
                </select>
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none status-icon-container">
                     <svg class="w-3.5 h-3.5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                 <div class="absolute inset-y-0 right-0 flex items-center pr-2 pointer-events-none text-slate-400 group-focus-within/status:text-indigo-500">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                </div>
            </div>
            
            <div class="relative input-customer-wrapper hidden animate-fade-in-down group/cust">
                <div class="absolute inset-y-0 left-0 pl-2.5 flex items-center pointer-events-none">
                    <svg class="w-3.5 h-3.5 text-orange-400 group-focus-within/cust:text-orange-500 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <input type="text" name="items[INDEX][customer_name]" class="input-customer w-full pl-8 pr-3 py-2 bg-orange-50 border border-orange-200 rounded-lg text-xs font-bold text-orange-800 placeholder-orange-400 focus:bg-white focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 transition-all shadow-sm" placeholder="Nama Pelanggan">
            </div>
        </td>

        <!-- Actions -->
        <td class="p-4 text-center align-middle border-l border-indigo-50/50">
            <button type="button" onclick="removeRow(this)" class="group inline-flex items-center justify-center p-2 rounded-lg bg-white border border-slate-200 text-slate-400 hover:bg-rose-50 hover:text-rose-500 hover:border-rose-200 transition-all shadow-sm hover:shadow-md transform hover:-translate-y-0.5" title="Hapus Baris">
                <svg class="w-5 h-5 transition-transform group-hover:rotate-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
            </button>
            <input type="hidden" name="items[INDEX][stock]" value="100">
        </td>
    </tr>
</template>

<!-- Hidden Mobile Card Template -->
<template id="mobileCardTemplate">
    <div class="mobile-card-item bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden" style="animation: slideIn 0.3s ease-out;">
        <!-- Card Header -->
        <div class="flex items-center justify-between px-4 py-2.5 bg-gradient-to-r from-blue-600 to-indigo-600">
            <div class="flex items-center gap-2">
                <span class="mobile-row-number inline-flex items-center justify-center w-6 h-6 rounded-full bg-white/20 text-white font-bold text-xs">1</span>
                <span class="text-white/80 text-xs font-medium">Transaksi</span>
            </div>
            <button type="button" onclick="removeRow(this)" class="p-1.5 rounded-lg bg-white/10 text-white/70 hover:bg-red-500 hover:text-white transition-all" title="Hapus">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <!-- Card Body -->
        <div class="p-4 space-y-3">
            <!-- Produk & Tanggal -->
            <div>
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1 block">Nama Produk</label>
                <input type="text" name="items[INDEX][name]" class="input-name w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 text-sm font-semibold text-slate-700 placeholder-slate-400 transition-all" placeholder="Ketik nama produk..." required>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <!-- Qty -->
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1 block">Qty</label>
                    <input type="number" name="items[INDEX][quantity]" value="1" min="1" class="w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-center font-bold text-slate-700 text-sm focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all">
                </div>
                <!-- Tanggal -->
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1 block">Tanggal</label>
                    <input type="date" name="items[INDEX][created_at]" class="w-full px-3 py-2.5 bg-slate-50 border border-slate-200 rounded-xl text-xs font-medium text-slate-500 focus:ring-1 focus:ring-indigo-500 transition-all cursor-pointer">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <!-- Kategori -->
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1 block">Kategori</label>
                    <select name="items[INDEX][category_id]" class="input-category w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all appearance-none cursor-pointer" required>
                        <option value="" disabled selected>Pilih</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" data-name="{{ $category->name }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
                <!-- Operator -->
                <div>
                    <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1 block">Operator</label>
                    <select name="items[INDEX][code]" class="input-provider w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold text-slate-600 focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all appearance-none cursor-pointer" required>
                        <option value="" disabled selected>Pilih</option>
                        @foreach(['Telkomsel', 'Indosat', 'Three', 'XL', 'Axis', 'Smartfren', 'By.U', 'Dana', 'Gopay', 'ShopeePay', 'Token', 'Listrik', 'BNI', 'BCA', 'Mandiri', 'BRI', 'BTN', 'Pajak', 'BPJS', 'Free Fire', 'Mobile Legends', 'Voucher', 'Paket Data', 'Kartu Perdana', 'Lainnya'] as $provider)
                            <option value="{{ $provider }}">{{ $provider }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <!-- Modal -->
                <div>
                    <label class="text-[10px] font-bold text-red-400 uppercase tracking-wider mb-1 block">💰 Modal</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-red-400 text-xs font-bold">Rp</span>
                        <input type="text" name="items[INDEX][cost_price]" placeholder="0" class="input-cost w-full pl-8 pr-3 py-2.5 bg-red-50/30 border border-red-200/50 rounded-xl text-sm font-mono font-bold text-slate-700 focus:ring-2 focus:ring-red-500/20 focus:border-red-400 transition-all rupiah-input" required>
                    </div>
                </div>
                <!-- Jual -->
                <div>
                    <label class="text-[10px] font-bold text-emerald-500 uppercase tracking-wider mb-1 block">💵 Jual</label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-emerald-500 text-xs font-bold">Rp</span>
                        <input type="text" name="items[INDEX][price]" placeholder="0" class="input-price w-full pl-8 pr-3 py-2.5 bg-emerald-50/30 border border-emerald-200/50 rounded-xl text-sm font-mono font-bold text-slate-700 focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-400 transition-all rupiah-input" required>
                    </div>
                </div>
            </div>

            <!-- Status -->
            <div>
                <label class="text-[10px] font-bold text-slate-400 uppercase tracking-wider mb-1 block">Status</label>
                <select name="items[INDEX][payment_status]" class="input-status w-full px-3 py-2.5 bg-white border border-slate-200 rounded-xl text-xs font-bold focus:ring-2 focus:ring-indigo-500/20 focus:border-indigo-500 transition-all appearance-none cursor-pointer" onchange="toggleCustomerInput(this)">
                    <option value="paid" class="text-emerald-600 font-bold">LUNAS</option>
                    <option value="unpaid" class="text-rose-600 font-bold">BELUM LUNAS</option>
                </select>
            </div>

            <div class="relative input-customer-wrapper hidden">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-3.5 h-3.5 text-orange-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                </div>
                <input type="text" name="items[INDEX][customer_name]" class="input-customer w-full pl-9 pr-3 py-2.5 bg-orange-50 border border-orange-200 rounded-xl text-xs font-bold text-orange-800 placeholder-orange-400 focus:ring-2 focus:ring-orange-500/30 focus:border-orange-500 transition-all" placeholder="Nama Pelanggan">
            </div>

            <input type="hidden" name="items[INDEX][stock]" value="100">
        </div>
    </div>
</template>

<style>
    @keyframes slideIn {
        from { opacity: 0; transform: translateY(-8px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

<script>
    const dbTemplates = @json($priceTemplates ?? []);
    let rowIndex = 0;

    document.addEventListener('DOMContentLoaded', () => {
        addRow();
    });

    function isMobile() {
        return window.innerWidth < 768;
    }

    function addRow() {
        if (isMobile()) {
            addMobileCard();
        } else {
            addDesktopRow();
        }
        rowIndex++;
        updateRowNumbers();
    }

    function addDesktopRow() {
        const template = document.getElementById('rowTemplate');
        const tbody = document.getElementById('tableBody');
        const clone = template.content.cloneNode(true);
        const tr = clone.querySelector('tr');

        tr.innerHTML = tr.innerHTML.replace(/INDEX/g, rowIndex);
        const rowNum = tbody.children.length + 1;
        tr.querySelector('.row-number').textContent = rowNum;

        initializeRow(tr, rowIndex);
        tbody.appendChild(tr);

        if (rowIndex > 0) {
             const firstInput = tr.querySelector('.input-name');
             if(firstInput) firstInput.focus();
        }
    }

    function addMobileCard() {
        const template = document.getElementById('mobileCardTemplate');
        const container = document.getElementById('mobileCardContainer');
        const clone = template.content.cloneNode(true);
        const card = clone.querySelector('.mobile-card-item');

        card.innerHTML = card.innerHTML.replace(/INDEX/g, rowIndex);
        const rowNum = container.children.length + 1;
        card.querySelector('.mobile-row-number').textContent = rowNum;

        initializeRow(card, rowIndex);
        container.appendChild(card);

        if (rowIndex > 0) {
            const firstInput = card.querySelector('.input-name');
            if(firstInput) firstInput.focus();
        }
    }

    function removeRow(btn) {
        if (isMobile()) {
            const card = btn.closest('.mobile-card-item');
            const container = document.getElementById('mobileCardContainer');
            if (container.children.length > 1) {
                card.style.animation = 'slideOut 0.25s ease-in forwards';
                setTimeout(() => { card.remove(); updateRowNumbers(); }, 250);
            } else {
                alert("Minimal satu transaksi harus ada.");
            }
        } else {
            const tr = btn.closest('tr');
            const tbody = document.getElementById('tableBody');
            if (tbody.children.length > 1) {
                tr.remove();
                updateRowNumbers();
            } else {
                alert("Minimal satu baris transaksi harus ada.");
            }
        }
    }

    function updateRowNumbers() {
        // Desktop
        const rows = document.querySelectorAll('#tableBody tr');
        rows.forEach((row, index) => {
            const el = row.querySelector('.row-number');
            if (el) el.textContent = index + 1;
        });
        // Mobile
        const cards = document.querySelectorAll('#mobileCardContainer .mobile-card-item');
        cards.forEach((card, index) => {
            const el = card.querySelector('.mobile-row-number');
            if (el) el.textContent = index + 1;
        });
    }

    function toggleCustomerInput(selectInfo) {
        const container = selectInfo.closest('.mobile-card-item') || selectInfo.closest('tr');
        const customerWrapper = container.querySelector('.input-customer-wrapper');
        const customerInput = container.querySelector('.input-customer');
        
        if (selectInfo.value === 'unpaid') {
            customerWrapper.classList.remove('hidden');
            customerInput.required = true;
            customerInput.focus();
        } else {
            customerWrapper.classList.add('hidden');
            customerInput.required = false;
        }
    }

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

    function initializeRow(container, index) {
        const nameInput = container.querySelector('.input-name');
        const categorySelect = container.querySelector('.input-category');
        const providerSelect = container.querySelector('.input-provider');
        const costInput = container.querySelector('.input-cost');
        const priceInput = container.querySelector('.input-price');

        // Rupiah Formatters
        [costInput, priceInput].forEach(input => {
            input.addEventListener('input', function(e) {
                e.target.value = formatRupiah(e.target.value);
            });
        });

        // Template Matching Logic
        const checkTemplate = (specificProvider = null) => {
            const currentName = nameInput.value.toLowerCase().trim();
            if (!currentName) return;

            let bestMatch = null;
            let maxMatchLen = 0;
            
            const effectiveProvider = specificProvider || providerSelect.value;
            
            if (effectiveProvider) {
                 const providerTemplates = dbTemplates.filter(t => t.provider === effectiveProvider);
                 providerTemplates.forEach(template => {
                    const pattern = template.pattern.toLowerCase();
                    if (currentName.includes(pattern)) {
                         if (pattern.length > maxMatchLen) {
                             maxMatchLen = pattern.length;
                             bestMatch = template;
                         }
                    }
                });
            }

            if (!bestMatch && !specificProvider) {
                 dbTemplates.forEach(template => {
                    const pattern = template.pattern.toLowerCase();
                    if (currentName.includes(pattern)) {
                        if (pattern.length > maxMatchLen) {
                             maxMatchLen = pattern.length;
                             bestMatch = template;
                        }
                    }
                });
            }

            if (bestMatch) {
                if (!specificProvider) {
                     let providerFound = false;
                     for(let i=0; i<providerSelect.options.length; i++) {
                         if(providerSelect.options[i].value === bestMatch.provider) {
                             providerSelect.selectedIndex = i;
                             providerFound = true;
                             break;
                         }
                     }
                     if (!providerFound) {
                         const map = {'tri': 'Three', 'three': 'Three', '3': 'Three'};
                         const mapped = map[bestMatch.provider.toLowerCase()];
                         if (mapped) {
                             for(let i=0; i<providerSelect.options.length; i++) {
                                 if(providerSelect.options[i].value === mapped) {
                                     providerSelect.selectedIndex = i;
                                     break;
                                 }
                            }
                        }
                     }
                }

                for(let i=0; i<categorySelect.options.length; i++) {
                     if(categorySelect.options[i].getAttribute('data-name') === bestMatch.category) {
                         categorySelect.selectedIndex = i;
                         break;
                     }
                }

                costInput.value = formatRupiah(parseInt(bestMatch.cost_price));
                priceInput.value = formatRupiah(parseInt(bestMatch.price));

                [costInput, priceInput].forEach(el => {
                    el.classList.add('bg-green-50', 'text-green-700');
                    setTimeout(() => el.classList.remove('bg-green-50', 'text-green-700'), 500);
                });

            } else {
                if (!specificProvider) {
                     if (providerSelect.value === "") {
                        const providerMap = {
                            'tree': 'Three', 'tri': 'Three', '3 ': 'Three',
                            'telkomsel': 'Telkomsel', 'tsel': 'Telkomsel', 'simpati': 'Telkomsel', 'as ': 'Telkomsel',
                            'xl': 'XL', 'axis': 'Axis', 'smartfren': 'Smartfren', 'by.u': 'By.U', 'byu': 'By.U',
                            'dana': 'Dana', 'gopay': 'Gopay', 'shopeepay': 'ShopeePay', 
                            'token': 'Token', 'listrik': 'Listrik', 'pln': 'Listrik',
                            'bni': 'BNI', 'bca': 'BCA', 'mandiri': 'Mandiri', 'bri': 'BRI', 'btn': 'BTN'
                        };
                        for (const [key, val] of Object.entries(providerMap)) {
                            if (currentName.includes(key)) {
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

                    if (categorySelect.value === "") {
                        let detectedCategoryName = null;
                        if (['dana', 'gopay', 'shopeepay', 'ovo', 'linkaja', 'wallet'].some(k => currentName.includes(k))) detectedCategoryName = 'E-Wallet';
                        else if (['token', 'pln', 'listrik'].some(k => currentName.includes(k))) detectedCategoryName = 'Listrik';
                        else if (['bni', 'bca', 'mandiri', 'bri', 'btn', 'transfer', 'tf '].some(k => currentName.includes(k))) detectedCategoryName = 'Transfer';
                        else if (currentName.includes('voucher') || currentName.includes('vc') || currentName.includes('fisik')) detectedCategoryName = 'Voucher';
                        else if (currentName.includes('data') || currentName.includes('gb') || currentName.includes('quota') || currentName.includes('kuota')) detectedCategoryName = 'Paket Data';
                        else if (currentName.includes('pulsa') || currentName.includes('isi ulang')) detectedCategoryName = 'Pulsa';
                        else if (['ff', 'free fire', 'ml', 'mobile legends'].some(k => currentName.includes(k))) detectedCategoryName = 'Top Up Game'; 
                        
                        if (detectedCategoryName) {
                             for(let i=0; i<categorySelect.options.length; i++) {
                                if(categorySelect.options[i].getAttribute('data-name') === detectedCategoryName) {
                                    categorySelect.selectedIndex = i;
                                    break;
                                }
                            }
                        }
                    }
                }
            }
        };

        // Events  
        nameInput.addEventListener('blur', () => checkTemplate());
        providerSelect.addEventListener('change', function() {
             checkTemplate(this.value); 
        });
        nameInput.addEventListener('keydown', (e) => {
            if (e.key === 'Enter') {
                e.preventDefault();
                checkTemplate();
                if (nameInput.value.length > 2) {
                     addRow(); 
                }
            }
        });
    }

    function submitForm() {
        // Collect from both desktop and mobile
        const tableBody = document.getElementById('tableBody');
        const mobileContainer = document.getElementById('mobileCardContainer');
        
        let validRowsCount = 0;

        // Clean desktop rows
        if (tableBody) {
            tableBody.querySelectorAll('tr.row-item').forEach(row => {
                const nameInput = row.querySelector('.input-name');
                if (!nameInput.value.trim()) {
                    row.remove();
                } else {
                    validRowsCount++;
                }
            });
        }

        // Clean mobile cards
        if (mobileContainer) {
            mobileContainer.querySelectorAll('.mobile-card-item').forEach(card => {
                const nameInput = card.querySelector('.input-name');
                if (!nameInput.value.trim()) {
                    card.remove();
                } else {
                    validRowsCount++;
                }
            });
        }

        if (validRowsCount === 0) {
            Swal.fire({
                icon: 'warning',
                title: 'Tidak ada data',
                text: 'Mohon isi minimal satu transaksi sebelum menyimpan.',
                confirmButtonColor: '#3b82f6'
            });
            if((tableBody && tableBody.children.length === 0) || (mobileContainer && mobileContainer.children.length === 0)) addRow();
            return;
        }

        const form = document.getElementById('bulkForm');
        if (form.reportValidity()) {
            form.submit();
        }
    }
</script>
