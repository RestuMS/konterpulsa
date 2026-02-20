<x-admin-layout>
    <x-slot name="header">
        {{ __('Edit Template Harga') }}
    </x-slot>

    <style>
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
    </style>

    <div class="max-w-xl mx-auto">
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl border border-slate-700/50 overflow-visible shadow-2xl shadow-black/30">
            
            <!-- Header -->
            <div class="px-8 pt-8 pb-6">
                <div class="flex items-center gap-4 mb-2">
                    <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-600 flex items-center justify-center shadow-lg shadow-blue-500/30">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-white">Edit Template</h2>
                        <p class="text-slate-400 text-sm">Perbarui data template harga</p>
                    </div>
                </div>
            </div>
            
            <form action="{{ route('price-templates.update', $priceTemplate->id) }}" method="POST" class="px-8 pb-8 space-y-5">
                @csrf
                @method('PUT')

                <!-- Operator (Custom Dropdown) -->
                <div class="space-y-2" style="position: relative; z-index: 30;">
                    <label class="flex items-center gap-2 text-sm font-bold text-white">
                        <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Operator
                    </label>

                    {{-- Hidden select for form submission --}}
                    <select name="provider" id="providerSelect" class="sr-only" tabindex="-1">
                        @foreach(['Telkomsel', 'Indosat', 'Three', 'XL', 'Axis', 'Smartfren', 'By.U', 'Dana', 'Gopay', 'ShopeePay', 'Token', 'Listrik', 'BNI', 'BCA', 'Mandiri', 'BRI', 'BTN', 'Top Up'] as $p)
                            <option value="{{ $p }}" {{ $priceTemplate->provider == $p ? 'selected' : '' }}>{{ $p }}</option>
                        @endforeach
                    </select>

                    {{-- Custom Dropdown --}}
                    <div class="relative">
                        <button type="button" id="providerDropdownBtn"
                            class="w-full px-4 py-4 rounded-xl bg-slate-900 border-2 border-slate-600 text-white text-lg font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all cursor-pointer text-left pr-12">
                            <span id="providerDropdownLabel" class="block truncate">{{ $priceTemplate->provider }}</span>
                        </button>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg id="providerChevron" class="w-5 h-5 text-slate-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>

                        {{-- Dropdown List --}}
                        <div id="providerDropdownList"
                            class="custom-dropdown-list hidden absolute left-0 right-0 mt-2 bg-slate-800 border-2 border-slate-600 rounded-xl shadow-2xl shadow-black/50 overflow-hidden"
                            style="z-index: 9999; max-height: 220px; overflow-y: auto;">
                            @foreach(['Telkomsel', 'Indosat', 'Three', 'XL', 'Axis', 'Smartfren', 'By.U', 'Dana', 'Gopay', 'ShopeePay', 'Token', 'Listrik', 'BNI', 'BCA', 'Mandiri', 'BRI', 'BTN', 'Top Up'] as $p)
                                <div class="provider-option px-4 py-3 cursor-pointer hover:bg-blue-500/20 hover:text-blue-300 transition-colors text-sm font-semibold text-slate-300 border-b border-slate-700/50 last:border-b-0 {{ $priceTemplate->provider == $p ? 'bg-blue-500/20 text-blue-300' : '' }}"
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
                            <option value="{{ $c }}" {{ $priceTemplate->category == $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>

                    {{-- Custom Dropdown --}}
                    <div class="relative">
                        <button type="button" id="categoryDropdownBtn"
                            class="w-full px-4 py-4 rounded-xl bg-slate-900 border-2 border-slate-600 text-white text-lg font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all cursor-pointer text-left pr-12">
                            <span id="categoryDropdownLabel" class="block truncate">{{ $priceTemplate->category }}</span>
                        </button>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg id="categoryChevron" class="w-5 h-5 text-slate-400 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>

                        {{-- Dropdown List --}}
                        <div id="categoryDropdownList"
                            class="custom-dropdown-list hidden absolute left-0 right-0 mt-2 bg-slate-800 border-2 border-slate-600 rounded-xl shadow-2xl shadow-black/50 overflow-hidden"
                            style="z-index: 9998; max-height: 220px; overflow-y: auto;">
                            @foreach(['Pulsa', 'E-Wallet', 'Transfer', 'Listrik', 'Pajak', 'BPJS', 'Free Fire', 'Mobile Legends', 'Voucher', 'Paket Data', 'Kartu Perdana'] as $c)
                                <div class="category-option px-4 py-3 cursor-pointer hover:bg-blue-500/20 hover:text-blue-300 transition-colors text-sm font-semibold text-slate-300 border-b border-slate-700/50 last:border-b-0 {{ $priceTemplate->category == $c ? 'bg-blue-500/20 text-blue-300' : '' }}"
                                    data-value="{{ $c }}">
                                    {{ $c }}
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Nama Produk -->
                <div class="space-y-2">
                    <label class="flex items-center gap-2 text-sm font-bold text-white">
                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                        Nama Produk
                    </label>
                    <input type="text" name="pattern" value="{{ $priceTemplate->pattern }}" class="w-full px-4 py-4 rounded-xl bg-slate-900 border-2 border-slate-600 text-white text-lg font-semibold placeholder-slate-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="Contoh: 10k, 20k, 50k" required>
                    <div class="flex items-start gap-3 p-4 rounded-xl bg-slate-700/40 border border-slate-600/50">
                        <span class="text-xl">💡</span>
                        <p class="text-sm text-slate-300 leading-relaxed">Pisahkan keyword dengan <span class="text-blue-400 font-bold">spasi</span>.</p>
                    </div>
                </div>

                <!-- Harga Grid -->
                <div class="grid grid-cols-2 gap-5">
                    <!-- Modal -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-bold text-white">
                            <svg class="w-4 h-4 text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Harga Modal
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-red-400 font-bold">Rp</span>
                            <input type="number" name="cost_price" value="{{ intval($priceTemplate->cost_price) }}" class="w-full pl-12 pr-4 py-4 rounded-xl bg-slate-900 border-2 border-slate-600 text-white text-lg font-mono font-bold focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-all" placeholder="0" required>
                        </div>
                    </div>
                    <!-- Jual -->
                    <div class="space-y-2">
                        <label class="flex items-center gap-2 text-sm font-bold text-white">
                            <svg class="w-4 h-4 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v3m0 0v3m0-3h3m-3 0H9m12 0a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                            Harga Jual
                        </label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-emerald-400 font-bold">Rp</span>
                            <input type="number" name="price" value="{{ intval($priceTemplate->price) }}" class="w-full pl-12 pr-4 py-4 rounded-xl bg-slate-900 border-2 border-slate-600 text-white text-lg font-mono font-bold focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-all" placeholder="0" required>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="pt-6 flex justify-end gap-4">
                    <a href="{{ route('price-templates.index') }}" class="px-6 py-3.5 rounded-xl border-2 border-slate-500 text-slate-300 font-bold hover:bg-slate-700 hover:text-white hover:border-slate-400 transition-all">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-3.5 rounded-xl bg-gradient-to-r from-blue-500 to-cyan-600 text-white font-bold text-lg hover:from-blue-600 hover:to-cyan-700 shadow-xl shadow-blue-500/30 hover:shadow-blue-500/50 transform hover:scale-[1.02] transition-all flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"></path></svg>
                        Update Template
                    </button>
                </div>
            </form>
        </div>
    </div>

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
            activeClass: ['bg-blue-500/20', 'text-blue-300'],
            ringClass: 'ring-blue-500',
            borderClass: 'border-blue-500',
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
                            Kombinasi Operator + Nama Produk ini sudah ada di template lain.
                        </p>
                    </div>
                `,
                confirmButtonText: 'Mengerti',
                confirmButtonColor: '#3b82f6',
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
