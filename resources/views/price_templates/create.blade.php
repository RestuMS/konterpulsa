<x-admin-layout>
    <x-slot name="header">
        {{ __('Tambah Template Harga') }}
    </x-slot>

    <style>
        /* Custom Number Input Spinner Styling */
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        input[type="number"] {
            -moz-appearance: textfield;
        }

        /* Custom Dropdown Scrollbar */
        .custom-dropdown-list::-webkit-scrollbar {
            width: 6px;
        }
        .custom-dropdown-list::-webkit-scrollbar-track {
            background: #1e293b;
            border-radius: 0 12px 12px 0;
        }
        .custom-dropdown-list::-webkit-scrollbar-thumb {
            background: #475569;
            border-radius: 3px;
        }
        .custom-dropdown-list::-webkit-scrollbar-thumb:hover {
            background: #64748b;
        }

        /* Row animation */
        .product-row {
            animation: slideIn 0.3s ease-out;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .product-row.removing {
            animation: slideOut 0.25s ease-in forwards;
        }
        @keyframes slideOut {
            to { opacity: 0; transform: translateX(30px); height: 0; padding: 0; margin: 0; overflow: hidden; }
        }
    </style>

    <div class="max-w-3xl mx-auto">
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl border border-slate-700/50 overflow-visible shadow-2xl shadow-black/30">
            
            <!-- Header -->
            <div class="px-8 pt-8 pb-6">
                <div class="flex items-center gap-4 mb-2">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-pink-500 to-purple-600 flex items-center justify-center shadow-lg shadow-pink-500/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Template Harga Baru</h2>
                        <p class="text-slate-400 text-sm">Tambah banyak produk sekaligus dalam satu operator</p>
                    </div>
                </div>
            </div>
            
            <form id="bulkForm" action="{{ route('price-templates.store') }}" method="POST" class="px-8 pb-8 space-y-6">
                @csrf

                {{-- ═══ SHARED: Operator & Kategori ═══ --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    
                    <!-- Operator (Custom Dropdown) -->
                    <div class="space-y-2" style="position: relative; z-index: 30;">
                        <label class="flex items-center gap-2 text-sm font-bold text-white">
                            <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                            Operator
                        </label>

                        {{-- Hidden select for form submission --}}
                        <select name="provider" id="providerSelect" class="sr-only" tabindex="-1">
                            @foreach(['Telkomsel', 'Indosat', 'Three', 'XL', 'Axis', 'Smartfren', 'By.U', 'Dana', 'Gopay', 'ShopeePay', 'Token', 'Listrik', 'BNI', 'BCA', 'Mandiri', 'BRI', 'BTN', 'Top Up'] as $p)
                                <option value="{{ $p }}">{{ $p }}</option>
                            @endforeach
                        </select>

                        {{-- Custom Dropdown --}}
                        <div class="relative">
                            <button type="button" id="providerDropdownBtn"
                                class="w-full px-4 py-3.5 rounded-xl bg-slate-900 border-2 border-slate-600 text-white text-base font-semibold focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all cursor-pointer text-left pr-12">
                                <span id="providerDropdownLabel" class="block truncate">Telkomsel</span>
                            </button>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                <svg id="providerChevron" class="w-5 h-5 text-slate-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>

                            {{-- Dropdown List --}}
                            <div id="providerDropdownList"
                                class="custom-dropdown-list hidden absolute left-0 right-0 mt-2 bg-slate-800 border-2 border-slate-600 rounded-xl shadow-2xl shadow-black/50 overflow-hidden"
                                style="z-index: 9999; max-height: 220px; overflow-y: auto;">
                                @foreach(['Telkomsel', 'Indosat', 'Three', 'XL', 'Axis', 'Smartfren', 'By.U', 'Dana', 'Gopay', 'ShopeePay', 'Token', 'Listrik', 'BNI', 'BCA', 'Mandiri', 'BRI', 'BTN', 'Top Up'] as $p)
                                    <div class="provider-option px-4 py-3 cursor-pointer hover:bg-pink-500/20 hover:text-pink-300 transition-colors text-sm font-semibold text-slate-300 border-b border-slate-700/50 last:border-b-0 {{ $loop->first ? 'bg-pink-500/20 text-pink-300' : '' }}"
                                        data-value="{{ $p }}">
                                        {{ $p }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Kategori (Custom Dropdown) -->
                    <div class="space-y-2" style="position: relative; z-index: 20;">
                        <label class="flex items-center gap-2 text-sm font-bold text-white">
                            <svg class="w-4 h-4 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                            Kategori
                        </label>

                        {{-- Hidden select for form submission --}}
                        <select name="category" id="categorySelect" class="sr-only" tabindex="-1">
                            @foreach(['Pulsa', 'E-Wallet', 'Transfer', 'Listrik', 'Pajak', 'BPJS', 'Free Fire', 'Mobile Legends', 'Voucher', 'Paket Data', 'Kartu Perdana'] as $c)
                                <option value="{{ $c }}">{{ $c }}</option>
                            @endforeach
                        </select>

                        {{-- Custom Dropdown --}}
                        <div class="relative">
                            <button type="button" id="categoryDropdownBtn"
                                class="w-full px-4 py-3.5 rounded-xl bg-slate-900 border-2 border-slate-600 text-white text-base font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all cursor-pointer text-left pr-12">
                                <span id="categoryDropdownLabel" class="block truncate">Pulsa</span>
                            </button>
                            <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                                <svg id="categoryChevron" class="w-5 h-5 text-slate-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>

                            {{-- Dropdown List --}}
                            <div id="categoryDropdownList"
                                class="custom-dropdown-list hidden absolute left-0 right-0 mt-2 bg-slate-800 border-2 border-slate-600 rounded-xl shadow-2xl shadow-black/50 overflow-hidden"
                                style="z-index: 9998; max-height: 220px; overflow-y: auto;">
                                @foreach(['Pulsa', 'E-Wallet', 'Transfer', 'Listrik', 'Pajak', 'BPJS', 'Free Fire', 'Mobile Legends', 'Voucher', 'Paket Data', 'Kartu Perdana'] as $c)
                                    <div class="category-option px-4 py-3 cursor-pointer hover:bg-blue-500/20 hover:text-blue-300 transition-colors text-sm font-semibold text-slate-300 border-b border-slate-700/50 last:border-b-0 {{ $loop->first ? 'bg-blue-500/20 text-blue-300' : '' }}"
                                        data-value="{{ $c }}">
                                        {{ $c }}
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                {{-- ═══ DIVIDER ═══ --}}
                <div class="relative">
                    <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-slate-700/50"></div></div>
                    <div class="relative flex justify-center">
                        <span class="px-4 bg-gradient-to-br from-slate-800 to-slate-900 text-slate-400 text-xs font-bold uppercase tracking-widest flex items-center gap-2">
                            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path></svg>
                            Daftar Produk
                        </span>
                    </div>
                </div>

                {{-- ═══ PRODUCT ROWS ═══ --}}
                <div id="productRows" class="space-y-3">
                    <!-- Rows will be added by JS -->
                </div>

                {{-- ═══ ADD ROW BUTTON ═══ --}}
                <button type="button" onclick="addRow()" 
                    class="w-full py-3 rounded-xl border-2 border-dashed border-slate-600 text-slate-400 font-bold text-sm hover:border-pink-500/50 hover:text-pink-400 hover:bg-pink-500/5 transition-all flex items-center justify-center gap-2 group">
                    <div class="w-6 h-6 rounded-lg bg-slate-700 group-hover:bg-pink-500/20 flex items-center justify-center transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path></svg>
                    </div>
                    Tambah Produk Lagi
                </button>

                {{-- ═══ INFO ═══ --}}
                <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-700/40 border border-slate-600/50">
                    <span class="text-xl">💡</span>
                    <p class="text-sm text-slate-300 leading-relaxed">Pisahkan keyword dengan <span class="text-pink-400 font-bold">spasi</span>. Contoh: <code class="bg-pink-500/20 text-pink-300 px-2 py-1 rounded-lg font-bold">3,5 7h</code> berarti harga akan muncul jika input mengandung "3,5" <span class="text-pink-400 font-bold">DAN</span> "7h".</p>
                </div>

                {{-- ═══ COUNTER ═══ --}}
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-2 text-sm text-slate-400">
                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        Total: <span id="rowCounter" class="text-white font-bold">1</span> produk
                    </div>
                </div>

                <!-- Actions -->
                <div class="pt-2 flex justify-end gap-4">
                    <a href="{{ route('price-templates.index') }}" class="px-6 py-3.5 rounded-xl border-2 border-slate-500 text-slate-300 font-bold hover:bg-slate-700 hover:text-white hover:border-slate-400 transition-all">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3.5 rounded-xl bg-gradient-to-r from-pink-500 to-purple-600 text-white font-bold text-lg hover:from-pink-600 hover:to-purple-700 shadow-xl shadow-pink-500/30 hover:shadow-pink-500/50 transform hover:scale-[1.02] transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                        Simpan Semua
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- ═══ ROW TEMPLATE (hidden) ═══ --}}
    <template id="rowTemplate">
        <div class="product-row bg-slate-900/60 rounded-2xl border border-slate-700/60 p-5 relative group hover:border-slate-600 transition-all">
            {{-- Row Number Badge --}}
            <div class="absolute -top-2.5 -left-2.5 w-7 h-7 rounded-lg bg-gradient-to-br from-pink-500 to-purple-600 flex items-center justify-center shadow-lg">
                <span class="row-number text-white text-xs font-bold">1</span>
            </div>

            {{-- Remove Button --}}
            <button type="button" onclick="removeRow(this)" title="Hapus baris"
                class="remove-btn absolute -top-2.5 -right-2.5 w-7 h-7 rounded-lg bg-slate-700 border border-slate-600 flex items-center justify-center text-slate-400 hover:bg-red-500 hover:text-white hover:border-red-500 transition-all shadow-lg opacity-0 group-hover:opacity-100">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <div class="grid grid-cols-1 sm:grid-cols-5 gap-4 items-end">
                {{-- Nama Produk --}}
                <div class="sm:col-span-3 space-y-1.5">
                    <label class="flex items-center gap-1.5 text-xs font-bold text-slate-400 uppercase tracking-wider">
                        <svg class="w-3 h-3 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                        Nama Produk
                    </label>
                    <input type="text" name="items[INDEX][pattern]" 
                        class="w-full px-4 py-3 rounded-xl bg-slate-800 border-2 border-slate-600 text-white text-base font-semibold placeholder-slate-500 focus:ring-2 focus:ring-pink-500 focus:border-pink-500 transition-all" 
                        placeholder="Contoh: 10k, 20k, 50k" required>
                </div>

                {{-- Harga Modal --}}
                <div class="space-y-1.5">
                    <label class="flex items-center gap-1.5 text-xs font-bold text-slate-400 uppercase tracking-wider">
                        <svg class="w-3 h-3 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Modal
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-red-400 font-bold text-xs">Rp</span>
                        <input type="text" inputmode="numeric" name="items[INDEX][cost_price]" 
                            onkeypress="return onlyNumbers(event)" oninput="cleanNumber(this)"
                            class="input-cost w-full pl-9 pr-3 py-3 rounded-xl bg-slate-800 border-2 border-red-500/30 text-white text-base font-mono font-bold text-center focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" 
                            placeholder="0" required>
                    </div>
                </div>

                {{-- Harga Jual --}}
                <div class="space-y-1.5">
                    <label class="flex items-center gap-1.5 text-xs font-bold text-slate-400 uppercase tracking-wider">
                        <svg class="w-3 h-3 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Jual
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-emerald-400 font-bold text-xs">Rp</span>
                        <input type="text" inputmode="numeric" name="items[INDEX][price]" 
                            onkeypress="return onlyNumbers(event)" oninput="cleanNumber(this)"
                            class="input-price w-full pl-9 pr-3 py-3 rounded-xl bg-slate-800 border-2 border-emerald-500/30 text-white text-base font-mono font-bold text-center focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all" 
                            placeholder="0" required>
                    </div>
                </div>
            </div>
        </div>
    </template>

    {{-- ═══ JavaScript ═══ --}}
    <script>
        let rowIndex = 0;

        // Only allow number keys
        function onlyNumbers(e) {
            const charCode = e.which ? e.which : e.keyCode;
            if (charCode > 31 && (charCode < 48 || charCode > 57)) return false;
            return true;
        }

        function cleanNumber(el) {
            el.value = el.value.replace(/[^0-9]/g, '');
        }

        function addRow() {
            const template = document.getElementById('rowTemplate');
            const container = document.getElementById('productRows');
            const clone = template.content.cloneNode(true);
            const row = clone.querySelector('.product-row');

            // Replace INDEX placeholder
            row.innerHTML = row.innerHTML.replace(/INDEX/g, rowIndex);

            // Set row number
            const rowNum = container.children.length + 1;
            row.querySelector('.row-number').textContent = rowNum;

            // If only 1 row, hide the remove button
            container.appendChild(row);
            updateUI();

            // Focus on the name input (skip first load focus)
            if (rowIndex > 0) {
                const nameInput = row.querySelector('input[type="text"]');
                if (nameInput) nameInput.focus();
            }

            // Enter key to add next row
            const nameInput = row.querySelector('input[name*="pattern"]');
            if (nameInput) {
                nameInput.addEventListener('keydown', (e) => {
                    if (e.key === 'Enter') {
                        e.preventDefault();
                        addRow();
                    }
                });
            }

            rowIndex++;
        }

        function removeRow(btn) {
            const row = btn.closest('.product-row');
            const container = document.getElementById('productRows');
            
            if (container.children.length <= 1) return; // Keep at least 1

            row.classList.add('removing');
            setTimeout(() => {
                row.remove();
                updateUI();
            }, 250);
        }

        function updateUI() {
            const container = document.getElementById('productRows');
            const rows = container.querySelectorAll('.product-row');

            // Update row numbers
            rows.forEach((row, index) => {
                row.querySelector('.row-number').textContent = index + 1;
            });

            // Update counter
            document.getElementById('rowCounter').textContent = rows.length;

            // Show/hide remove buttons (hide if only 1 row)
            rows.forEach(row => {
                const removeBtn = row.querySelector('.remove-btn');
                if (removeBtn) {
                    removeBtn.style.display = rows.length <= 1 ? 'none' : '';
                }
            });
        }

        // Init: add first row
        document.addEventListener('DOMContentLoaded', () => {
            addRow();
        });
    </script>

    {{-- Custom Dropdown JavaScript --}}
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        // Generic dropdown initializer
        function initCustomDropdown(config) {
            const hiddenSelect = document.getElementById(config.selectId);
            const btn = document.getElementById(config.btnId);
            const list = document.getElementById(config.listId);
            const label = document.getElementById(config.labelId);
            const chevron = document.getElementById(config.chevronId);
            const options = document.querySelectorAll(config.optionSelector);
            const activeClass = config.activeClass;

            if (!btn || !list || !label) return;

            // Toggle
            btn.addEventListener('click', (e) => {
                e.stopPropagation();
                const isOpen = !list.classList.contains('hidden');
                // Close all dropdowns first
                document.querySelectorAll('.custom-dropdown-list').forEach(d => d.classList.add('hidden'));
                document.querySelectorAll('[id$="Chevron"]').forEach(c => c.style.transform = 'rotate(0deg)');

                if (!isOpen) {
                    list.classList.remove('hidden');
                    chevron.style.transform = 'rotate(180deg)';
                    btn.classList.add('ring-2', config.ringClass, config.borderClass);
                } else {
                    btn.classList.remove('ring-2', config.ringClass, config.borderClass);
                }
            });

            // Select option
            options.forEach(opt => {
                opt.addEventListener('click', (e) => {
                    e.stopPropagation();
                    const value = opt.getAttribute('data-value');

                    // Update hidden select
                    for (let i = 0; i < hiddenSelect.options.length; i++) {
                        if (hiddenSelect.options[i].value === value) {
                            hiddenSelect.selectedIndex = i;
                            break;
                        }
                    }

                    // Update label
                    label.textContent = value;

                    // Update active style
                    options.forEach(o => o.classList.remove(...activeClass));
                    opt.classList.add(...activeClass);

                    // Close
                    list.classList.add('hidden');
                    chevron.style.transform = 'rotate(0deg)';
                    btn.classList.remove('ring-2', config.ringClass, config.borderClass);
                });
            });
        }

        // Init Operator dropdown
        initCustomDropdown({
            selectId: 'providerSelect',
            btnId: 'providerDropdownBtn',
            listId: 'providerDropdownList',
            labelId: 'providerDropdownLabel',
            chevronId: 'providerChevron',
            optionSelector: '.provider-option',
            activeClass: ['bg-pink-500/20', 'text-pink-300'],
            ringClass: 'ring-pink-500',
            borderClass: 'border-pink-500',
        });

        // Init Kategori dropdown
        initCustomDropdown({
            selectId: 'categorySelect',
            btnId: 'categoryDropdownBtn',
            listId: 'categoryDropdownList',
            labelId: 'categoryDropdownLabel',
            chevronId: 'categoryChevron',
            optionSelector: '.category-option',
            activeClass: ['bg-blue-500/20', 'text-blue-300'],
            ringClass: 'ring-blue-500',
            borderClass: 'border-blue-500',
        });

        // Close all dropdowns when clicking outside
        document.addEventListener('click', () => {
            document.querySelectorAll('.custom-dropdown-list').forEach(d => d.classList.add('hidden'));
            document.querySelectorAll('[id$="Chevron"]').forEach(c => c.style.transform = 'rotate(0deg)');
        });
    });
    </script>

    {{-- SweetAlert2 untuk notifikasi duplikat --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        @if(session('duplicate'))
            Swal.fire({
                icon: 'error',
                title: '⚠️ Data Sudah Ada!',
                html: `
                    <div style="text-align:center; margin-top:8px;">
                        <p style="color:#f87171; font-weight:700; font-size:14px; margin-bottom:8px;">
                            {{ session('duplicate') }}
                        </p>
                        <p style="color:#94a3b8; font-size:12px;">
                            Produk yang duplikat dilewati. Gunakan menu Edit untuk mengubah harga.
                        </p>
                    </div>
                `,
                confirmButtonText: 'Mengerti',
                confirmButtonColor: '#ec4899',
                background: '#1e293b',
                color: '#f1f5f9',
                customClass: {
                    popup: 'rounded-2xl border border-red-500/30 shadow-2xl',
                    title: 'text-red-400',
                    confirmButton: 'rounded-xl font-bold px-8 py-2.5',
                },
            });
        @endif
    });
    </script>
</x-admin-layout>
