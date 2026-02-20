@push('head-scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@endpush

<x-admin-layout>
    <x-slot name="header">
        Perbandingan Bulanan
    </x-slot>

    <div class="space-y-6">

        {{-- Header & Filter --}}
        <div class="bg-slate-800 p-4 lg:p-6 rounded-xl border border-slate-700 shadow-lg flex flex-col lg:flex-row lg:items-center justify-between gap-4 lg:gap-6">
            <div class="text-left">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-6 h-6 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg>
                    Perbandingan Bulanan
                </h2>
                <p class="text-slate-400 text-sm mt-1">
                    <span class="font-semibold text-indigo-400">{{ $currentMonthName }}</span>
                    <span class="text-slate-500 mx-1">vs</span>
                    <span class="font-semibold text-slate-300">{{ $prevMonthName }}</span>
                </p>
            </div>

            <div class="flex flex-col md:flex-row gap-3 w-full lg:w-auto">
                <form action="{{ route('reports.comparison') }}" method="GET" class="contents md:flex md:items-center md:gap-3">
                    <div class="grid grid-cols-2 gap-3 w-full md:w-auto">
                        {{-- Month --}}
                        <div class="relative group">
                            <select name="month" class="w-full appearance-none pl-4 pr-8 py-2.5 bg-slate-700 border border-slate-600 text-white text-sm font-semibold rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition-all cursor-pointer hover:bg-slate-600 hover:border-slate-500 shadow-sm">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ $month == $i ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                    </option>
                                @endfor
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400 group-hover:text-indigo-400 transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        {{-- Year --}}
                        <div class="relative group">
                            <select name="year" class="w-full appearance-none pl-4 pr-8 py-2.5 bg-slate-700 border border-slate-600 text-white text-sm font-semibold rounded-xl focus:ring-2 focus:ring-indigo-500/30 focus:border-indigo-500 transition-all cursor-pointer hover:bg-slate-600 hover:border-slate-500 shadow-sm">
                                @php $currentYear = now()->year; @endphp
                                @for($y = $currentYear - 2; $y <= $currentYear + 1; $y++)
                                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400 group-hover:text-indigo-400 transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full md:w-auto px-5 py-2.5 bg-indigo-600 text-white rounded-xl hover:bg-indigo-500 transition-all shadow-md hover:shadow-lg hover:shadow-indigo-500/20 transform hover:-translate-y-0.5 active:translate-y-0 flex justify-center items-center gap-2 font-semibold text-sm">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                        <span>Filter</span>
                    </button>
                </form>

                <a href="{{ route('reports.index') }}" class="w-full md:w-auto px-5 py-2.5 bg-gradient-to-r from-red-600 to-red-700 border border-red-500/50 text-white font-bold rounded-xl hover:from-red-500 hover:to-red-600 hover:border-red-400 shadow-lg shadow-red-500/20 transition-all flex items-center justify-center gap-2 group text-sm">
                    <svg class="w-4 h-4 text-white/80 group-hover:text-white transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"></path></svg>
                    <span>Laporan Utama</span>
                </a>
            </div>
        </div>

        {{-- Summary Cards --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            {{-- Pemasukan (Hijau) --}}
            <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl p-5 shadow-lg shadow-emerald-500/20 text-white relative overflow-hidden group">
                <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                <div class="absolute bottom-3 right-3 opacity-10">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        </div>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-white/20 text-white backdrop-blur-sm">
                            Omset
                        </span>
                    </div>
                    <p class="text-white/80 text-sm font-medium mb-1">Pemasukan</p>
                    <p class="text-2xl font-bold text-white">Rp {{ number_format($currentRevenue, 0, ',', '.') }}</p>
                    <div class="flex items-center justify-between mt-2">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-white/20 text-white backdrop-blur-sm">
                            <svg class="w-3 h-3 {{ $revenueChange >= 0 ? '' : 'rotate-180' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                            {{ $revenueChange >= 0 ? '+' : '' }}{{ $revenueChange }}%
                        </span>
                        <p class="text-xs text-white/60">Bln lalu: Rp {{ number_format($prevRevenue, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- Pengeluaran (Merah/Pink) --}}
            <div class="bg-gradient-to-br from-rose-500 to-pink-600 rounded-xl p-5 shadow-lg shadow-rose-500/20 text-white relative overflow-hidden group">
                <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                <div class="absolute bottom-3 right-3 opacity-10">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                        </div>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-white/20 text-white backdrop-blur-sm">
                            Modal
                        </span>
                    </div>
                    <p class="text-white/80 text-sm font-medium mb-1">Pengeluaran</p>
                    <p class="text-2xl font-bold text-white">Rp {{ number_format($currentCost, 0, ',', '.') }}</p>
                    <div class="flex items-center justify-between mt-2">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-white/20 text-white backdrop-blur-sm">
                            <svg class="w-3 h-3 {{ $costChange >= 0 ? '' : 'rotate-180' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                            {{ $costChange >= 0 ? '+' : '' }}{{ $costChange }}%
                        </span>
                        <p class="text-xs text-white/60">Bln lalu: Rp {{ number_format($prevCost, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- Laba (Cyan/Biru Muda) --}}
            <div class="bg-gradient-to-br from-cyan-400 to-blue-500 rounded-xl p-5 shadow-lg shadow-cyan-500/20 text-white relative overflow-hidden group">
                <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                <div class="absolute bottom-3 right-3 opacity-10">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"></path></svg>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        </div>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-white/20 text-white backdrop-blur-sm">
                            Bersih
                        </span>
                    </div>
                    <p class="text-white/80 text-sm font-medium mb-1">Laba</p>
                    <p class="text-2xl font-bold text-white">Rp {{ number_format($currentProfit, 0, ',', '.') }}</p>
                    <div class="flex items-center justify-between mt-2">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-white/20 text-white backdrop-blur-sm">
                            <svg class="w-3 h-3 {{ $profitChange >= 0 ? '' : 'rotate-180' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                            {{ $profitChange >= 0 ? '+' : '' }}{{ $profitChange }}%
                        </span>
                        <p class="text-xs text-white/60">Bln lalu: Rp {{ number_format($prevProfit, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            {{-- Total Produk (Biru) --}}
            <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl p-5 shadow-lg shadow-blue-500/20 text-white relative overflow-hidden group">
                <div class="absolute -bottom-6 -right-6 w-24 h-24 bg-white/10 rounded-full blur-xl"></div>
                <div class="absolute bottom-3 right-3 opacity-10">
                    <svg class="w-16 h-16" fill="currentColor" viewBox="0 0 24 24"><path d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
                <div class="relative z-10">
                    <div class="flex items-center justify-between mb-3">
                        <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                        </div>
                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-xs font-bold bg-white/20 text-white backdrop-blur-sm">
                            Item
                        </span>
                    </div>
                    <p class="text-white/80 text-sm font-medium mb-1">Total Produk</p>
                    <p class="text-2xl font-bold text-white">{{ number_format($currentItems) }}</p>
                    <div class="flex items-center justify-between mt-2">
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-bold bg-white/20 text-white backdrop-blur-sm">
                            <svg class="w-3 h-3 {{ $itemsChange >= 0 ? '' : 'rotate-180' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"></path></svg>
                            {{ $itemsChange >= 0 ? '+' : '' }}{{ $itemsChange }}%
                        </span>
                        <p class="text-xs text-white/60">Bln lalu: {{ number_format($prevItems) }} Item</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Revenue Comparison Line Chart --}}
        <div class="bg-slate-800 p-6 md:p-8 rounded-xl border border-slate-700 shadow-lg relative overflow-hidden">
            <div class="absolute top-0 right-0 p-8 opacity-[0.03] pointer-events-none">
                <svg class="w-32 h-32 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"></path></svg>
            </div>

            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-4 relative z-10">
                <div>
                    <h3 class="text-lg font-bold text-white tracking-tight">Tren Pendapatan Harian</h3>
                    <p class="text-sm text-slate-400 font-medium mt-0.5">Perbandingan omset per hari</p>
                </div>
                <div class="flex items-center gap-4">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-indigo-500"></span>
                        <span class="text-xs font-semibold text-slate-300">{{ $currentMonthName }}</span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full bg-slate-500"></span>
                        <span class="text-xs font-semibold text-slate-400">{{ $prevMonthName }}</span>
                    </div>
                </div>
            </div>

            <div class="h-72 md:h-80 w-full relative z-10">
                <canvas id="revenueComparisonChart"></canvas>
            </div>
        </div>

        {{-- Profit Comparison & Category Breakdown --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            {{-- Profit Line Chart --}}
            <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 shadow-lg relative overflow-hidden">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-3">
                    <div>
                        <h3 class="text-lg font-bold text-white tracking-tight">Tren Laba Harian</h3>
                        <p class="text-sm text-slate-400 font-medium mt-0.5">Keuntungan bersih per hari</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                            <span class="text-xs font-semibold text-slate-300">{{ $currentMonthName }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-slate-500"></span>
                            <span class="text-xs font-semibold text-slate-400">{{ $prevMonthName }}</span>
                        </div>
                    </div>
                </div>
                <div class="h-64 w-full">
                    <canvas id="profitComparisonChart"></canvas>
                </div>
            </div>

            {{-- Category Bar Chart --}}
            <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 shadow-lg relative overflow-hidden">
                <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-3">
                    <div>
                        <h3 class="text-lg font-bold text-white tracking-tight">Per Kategori</h3>
                        <p class="text-sm text-slate-400 font-medium mt-0.5">Pendapatan per kategori produk</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-indigo-500"></span>
                            <span class="text-xs font-semibold text-slate-300">Bulan Ini</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-3 h-3 rounded-full bg-slate-500"></span>
                            <span class="text-xs font-semibold text-slate-400">Bln Lalu</span>
                        </div>
                    </div>
                </div>
                <div class="h-64 w-full">
                    <canvas id="categoryComparisonChart"></canvas>
                </div>
            </div>
        </div>

        {{-- Top Products Table --}}
        <div class="bg-slate-800 p-6 rounded-xl border border-slate-700 shadow-lg">
            <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 gap-3">
                <div>
                    <h3 class="text-lg font-bold text-white tracking-tight">Produk Terlaris Bulan Ini</h3>
                    <p class="text-sm text-slate-400 font-medium mt-0.5">{{ $currentMonthName }}</p>
                </div>
                <span class="px-4 py-1.5 bg-gradient-to-r from-indigo-600 to-purple-600 text-white text-xs font-bold rounded-full shadow-lg shadow-indigo-500/20">
                    Top 5
                </span>
            </div>

            {{-- Desktop Table --}}
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-400">
                    <thead class="bg-slate-700/50 text-slate-200 uppercase tracking-wider text-xs">
                        <tr>
                            <th class="p-3 rounded-l-lg w-12">No</th>
                            <th class="p-3">Nama Produk</th>
                            <th class="p-3 text-center">Qty Terjual</th>
                            <th class="p-3 rounded-r-lg text-right">Total Laba</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @forelse($currentTopProducts as $i => $product)
                            <tr class="hover:bg-slate-700/20 transition-colors">
                                <td class="p-3">
                                    <span class="w-7 h-7 rounded-lg {{ $i === 0 ? 'bg-gradient-to-br from-amber-400 to-orange-500 text-white' : ($i === 1 ? 'bg-gradient-to-br from-slate-300 to-slate-400 text-white' : ($i === 2 ? 'bg-gradient-to-br from-orange-300 to-orange-400 text-white' : 'bg-slate-700 text-slate-400')) }} flex items-center justify-center text-xs font-bold">
                                        {{ $i + 1 }}
                                    </span>
                                </td>
                                <td class="p-3 font-semibold text-white">{{ $product->name }}</td>
                                <td class="p-3 text-center">
                                    <span class="px-2 py-1 rounded bg-blue-500/20 text-blue-400 text-xs font-bold border border-blue-500/30">
                                        {{ $product->total_qty }} Item
                                    </span>
                                </td>
                                <td class="p-3 text-right text-emerald-400 font-mono font-bold">
                                    + Rp {{ number_format($product->total_profit, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-10 text-center text-slate-500 italic">
                                    <svg class="w-12 h-12 mx-auto mb-3 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                                    Belum ada data produk
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Mobile List --}}
            <div class="md:hidden space-y-3">
                @forelse($currentTopProducts as $i => $product)
                    <div class="bg-slate-700/30 p-4 rounded-lg border border-slate-700">
                        <div class="flex justify-between items-start mb-2">
                            <span class="w-7 h-7 rounded-lg {{ $i === 0 ? 'bg-gradient-to-br from-amber-400 to-orange-500 text-white' : ($i === 1 ? 'bg-gradient-to-br from-slate-300 to-slate-400 text-white' : ($i === 2 ? 'bg-gradient-to-br from-orange-300 to-orange-400 text-white' : 'bg-slate-700 text-slate-400')) }} flex items-center justify-center text-xs font-bold">
                                {{ $i + 1 }}
                            </span>
                            <span class="px-2 py-1 rounded bg-blue-500/20 text-blue-400 text-xs font-bold border border-blue-500/30">
                                {{ $product->total_qty }} Terjual
                            </span>
                        </div>
                        <h4 class="font-bold text-white mb-1">{{ $product->name }}</h4>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-400">Laba</span>
                            <span class="text-emerald-400 font-bold font-mono">+ Rp {{ number_format($product->total_profit, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="py-10 text-center text-slate-500 italic">Belum ada data produk</div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Chart Scripts --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {

        // Shared config - Dark Theme
        const fontFamily = "'Inter', 'Outfit', sans-serif";
        const formatRupiah = (val) => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(val);
        const formatAxis = (value) => {
            if (value >= 1000000) return (value/1000000) + 'jt';
            if (value >= 1000) return (value/1000) + 'k';
            return value;
        };

        const tooltipConfig = {
            backgroundColor: 'rgba(15, 23, 42, 0.95)',
            titleColor: '#f8fafc',
            bodyColor: '#e2e8f0',
            borderColor: '#334155',
            borderWidth: 1,
            padding: 14,
            cornerRadius: 8,
            titleFont: { family: fontFamily, size: 13, weight: 'bold' },
            bodyFont: { family: fontFamily, size: 12, weight: '500' },
            displayColors: true,
            boxPadding: 4,
            callbacks: {
                label: function(ctx) {
                    let label = ctx.dataset.label || '';
                    if (label) label += ': ';
                    if (ctx.parsed.y !== null) label += formatRupiah(ctx.parsed.y);
                    return label;
                }
            }
        };

        const scaleY = {
            beginAtZero: true,
            border: { display: false },
            grid: { color: '#334155', borderDash: [5, 5], drawBorder: false },
            ticks: {
                color: '#64748b',
                font: { family: fontFamily, size: 10, weight: '500' },
                callback: formatAxis,
                padding: 10,
                maxTicksLimit: 6
            }
        };

        const scaleX = {
            grid: { display: false, drawBorder: false },
            ticks: {
                color: '#64748b',
                font: { family: fontFamily, size: 10, weight: '600' },
                maxRotation: 0,
                autoSkip: true,
                maxTicksLimit: 15
            }
        };

        // ==== 1. REVENUE LINE CHART ====
        const revCtx = document.getElementById('revenueComparisonChart').getContext('2d');

        const revGrad = revCtx.createLinearGradient(0, 0, 0, 320);
        revGrad.addColorStop(0, 'rgba(99, 102, 241, 0.3)');
        revGrad.addColorStop(1, 'rgba(99, 102, 241, 0.01)');

        new Chart(revCtx, {
            type: 'line',
            data: {
                labels: @json($lineLabels),
                datasets: [
                    {
                        label: '{{ $currentMonthName }}',
                        data: @json($currentRevenueDaily),
                        borderColor: '#818cf8',
                        backgroundColor: revGrad,
                        borderWidth: 2.5,
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#818cf8',
                        pointBorderColor: '#1e293b',
                        pointBorderWidth: 2,
                        pointRadius: 0,
                        pointHoverRadius: 6,
                        pointHoverBorderWidth: 3,
                    },
                    {
                        label: '{{ $prevMonthName }}',
                        data: @json($prevRevenueDaily),
                        borderColor: '#475569',
                        backgroundColor: 'rgba(71, 85, 105, 0.05)',
                        borderWidth: 2,
                        borderDash: [6, 4],
                        tension: 0.4,
                        fill: true,
                        pointBackgroundColor: '#475569',
                        pointBorderColor: '#1e293b',
                        pointBorderWidth: 2,
                        pointRadius: 0,
                        pointHoverRadius: 5,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: tooltipConfig
                },
                scales: { y: scaleY, x: scaleX }
            }
        });

        // ==== 2. PROFIT LINE CHART ====
        const profCtx = document.getElementById('profitComparisonChart').getContext('2d');

        const profGrad = profCtx.createLinearGradient(0, 0, 0, 260);
        profGrad.addColorStop(0, 'rgba(16, 185, 129, 0.25)');
        profGrad.addColorStop(1, 'rgba(16, 185, 129, 0.01)');

        new Chart(profCtx, {
            type: 'line',
            data: {
                labels: @json($lineLabels),
                datasets: [
                    {
                        label: '{{ $currentMonthName }}',
                        data: @json($currentProfitDaily),
                        borderColor: '#34d399',
                        backgroundColor: profGrad,
                        borderWidth: 2.5,
                        tension: 0.4,
                        fill: true,
                        pointRadius: 0,
                        pointHoverRadius: 5,
                    },
                    {
                        label: '{{ $prevMonthName }}',
                        data: @json($prevProfitDaily),
                        borderColor: '#475569',
                        backgroundColor: 'transparent',
                        borderWidth: 2,
                        borderDash: [6, 4],
                        tension: 0.4,
                        fill: false,
                        pointRadius: 0,
                        pointHoverRadius: 4,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: tooltipConfig
                },
                scales: { y: scaleY, x: scaleX }
            }
        });

        // ==== 3. CATEGORY BAR CHART ====
        new Chart(document.getElementById('categoryComparisonChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: @json($categoryLabels),
                datasets: [
                    {
                        label: '{{ $currentMonthName }}',
                        data: @json($currentCategoryRevenue),
                        backgroundColor: '#818cf8',
                        borderRadius: 6,
                        barPercentage: 0.6,
                        categoryPercentage: 0.7,
                    },
                    {
                        label: '{{ $prevMonthName }}',
                        data: @json($prevCategoryRevenue),
                        backgroundColor: '#334155',
                        borderRadius: 6,
                        barPercentage: 0.6,
                        categoryPercentage: 0.7,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                interaction: { mode: 'index', intersect: false },
                plugins: {
                    legend: { display: false },
                    tooltip: tooltipConfig
                },
                scales: {
                    y: scaleY,
                    x: {
                        grid: { display: false, drawBorder: false },
                        ticks: {
                            color: '#64748b',
                            font: { family: fontFamily, size: 11, weight: '600' },
                        }
                    }
                },
                elements: {
                    bar: { borderRadius: 6, borderSkipped: false }
                }
            }
        });
    });
    </script>

</x-admin-layout>
