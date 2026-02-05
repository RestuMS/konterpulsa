<x-admin-layout>
    <x-slot name="header">
        {{ __('Edit Template Harga') }}
    </x-slot>

    <style>
        /* Custom Select Dropdown Styling */
        select option {
            background-color: #1e293b !important;
            color: white !important;
            padding: 12px !important;
        }
        select option:hover,
        select option:checked {
            background: linear-gradient(to right, #3b82f6, #06b6d4) !important;
            color: white !important;
        }
    </style>

    <div class="max-w-xl mx-auto">
        <div class="bg-gradient-to-br from-slate-800 to-slate-900 rounded-3xl border border-slate-700/50 overflow-hidden shadow-2xl shadow-black/30">
            
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

                <!-- Provider -->
                <div class="space-y-2">
                    <label class="flex items-center gap-2 text-sm font-bold text-white">
                        <svg class="w-4 h-4 text-pink-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Provider
                    </label>
                    <div class="relative">
                        <select name="provider" class="w-full px-4 py-4 rounded-xl bg-slate-900 border-2 border-slate-600 text-white text-lg font-semibold focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all appearance-none cursor-pointer">
                            @foreach(['Telkomsel', 'Indosat', 'Three', 'XL', 'Axis', 'Smartfren', 'By.U', 'Dana', 'Gopay', 'ShopeePay', 'Token'] as $p)
                                <option value="{{ $p }}" {{ $priceTemplate->provider == $p ? 'selected' : '' }} class="bg-slate-800 text-white py-3">{{ $p }}</option>
                            @endforeach
                        </select>
                        <div class="absolute right-4 top-1/2 -translate-y-1/2 pointer-events-none">
                            <svg class="w-5 h-5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                        </div>
                    </div>
                </div>

                <!-- Pattern -->
                <div class="space-y-2">
                    <label class="flex items-center gap-2 text-sm font-bold text-white">
                        <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"></path></svg>
                        Keyword / Pattern
                    </label>
                    <input type="text" name="pattern" value="{{ $priceTemplate->pattern }}" class="w-full px-4 py-4 rounded-xl bg-slate-900 border-2 border-slate-600 text-white text-lg font-semibold placeholder-slate-500 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all" placeholder="Contoh: 3,5 7h" required>
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
</x-admin-layout>
