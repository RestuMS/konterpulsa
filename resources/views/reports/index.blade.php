<x-admin-layout>
    <x-slot name="header">
        {{ __('Laporan Keuangan') }}
    </x-slot>

    <div class="space-y-6">
        <!-- Header & Date Filter -->
        <!-- Header & Date Filter -->
        <!-- Header & Date Filter -->
        <div class="bg-white p-4 lg:p-6 rounded-2xl shadow-sm border border-slate-100 flex flex-col lg:flex-row lg:items-center justify-between gap-4 lg:gap-6">
            <div class="text-left">
                <h2 class="text-xl font-bold text-slate-800">Ringkasan Bulan Ini</h2>
                <p class="text-slate-500 text-sm mt-1">Laporan periode {{ \Carbon\Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y') }}</p>
            </div>
            
            <div class="flex flex-col md:flex-row gap-3 w-full lg:w-auto">
                <form action="{{ route('reports.index') }}" method="GET" class="contents md:flex md:items-center md:gap-3">
                    <div class="grid grid-cols-2 gap-3 w-full md:w-auto">
                        <!-- Month -->
                        <div class="relative group">
                            <select name="month" class="w-full appearance-none pl-4 pr-8 py-2.5 bg-slate-50 border border-slate-200 text-slate-700 text-sm font-semibold rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all cursor-pointer hover:bg-white hover:border-slate-300 shadow-sm">
                                @for($i = 1; $i <= 12; $i++)
                                    <option value="{{ $i }}" {{ request('month', now()->month) == $i ? 'selected' : '' }}>
                                        {{ date('F', mktime(0, 0, 0, $i, 1)) }}
                                    </option>
                                @endfor
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400 group-hover:text-blue-500 transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>

                        <!-- Year -->
                        <div class="relative group">
                            <select name="year" class="w-full appearance-none pl-4 pr-8 py-2.5 bg-slate-50 border border-slate-200 text-slate-700 text-sm font-semibold rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all cursor-pointer hover:bg-white hover:border-slate-300 shadow-sm">
                                @php $currentYear = now()->year; @endphp
                                @for($y = $currentYear - 2; $y <= $currentYear + 1; $y++)
                                    <option value="{{ $y }}" {{ request('year', $currentYear) == $y ? 'selected' : '' }}>
                                        {{ $y }}
                                    </option>
                                @endfor
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-3 text-slate-400 group-hover:text-blue-500 transition-colors">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="w-full md:w-auto p-2.5 bg-slate-900 text-white rounded-xl hover:bg-slate-800 transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 active:translate-y-0 flex justify-center items-center">
                        <span class="md:hidden mr-2 font-bold text-sm">Filter</span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"></path></svg>
                    </button>
                </form>
                
                <a href="{{ route('reports.print', ['month' => request('month', now()->month), 'year' => request('year', now()->year)]) }}" target="_blank" class="w-full md:w-auto px-5 py-2.5 bg-white border border-slate-200 text-slate-700 font-bold rounded-xl hover:bg-slate-50 hover:text-slate-900 hover:border-slate-300 shadow-sm transition-all flex items-center justify-center gap-2 group">
                    <svg class="w-5 h-5 text-slate-500 group-hover:text-slate-900 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
                    <span class="md:hidden lg:inline">Cetak PDF</span>
                    <span class="hidden md:inline lg:hidden">PDF</span>
                </a>
            </div>
        </div>

        <!-- Summary Cards -->
        <div class="flex flex-col gap-4">
            <!-- Pemasukan -->
            <div class="bg-green-600 rounded-2xl p-5 md:px-8 flex flex-col md:flex-row md:items-center justify-between shadow-lg relative overflow-hidden group hover:scale-[1.01] transition-transform duration-300">
                <div class="flex items-center gap-4 z-10 mb-4 md:mb-0">
                    <div class="w-12 h-12 rounded-full bg-slate-800 flex items-center justify-center border border-slate-700 shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-white tracking-wide uppercase">PEMASUKAN</h3>
                </div>
                <div class="text-left md:text-right z-10 pl-16 md:pl-0 -mt-2 md:mt-0">
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-1">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h2>
                    <div class="flex items-center md:justify-end gap-1 text-white/80 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        <span>Total Omset</span>
                    </div>
                </div>
            </div>

            <!-- Pengeluaran -->
            <div class="bg-red-600 rounded-2xl p-5 md:px-8 flex flex-col md:flex-row md:items-center justify-between shadow-lg relative overflow-hidden group hover:scale-[1.01] transition-transform duration-300">
                <div class="flex items-center gap-4 z-10 mb-4 md:mb-0">
                    <div class="w-12 h-12 rounded-xl bg-red-700/50 flex items-center justify-center border border-red-500/30 shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    </div>
                    <h3 class="text-lg md:text-xl font-bold text-white tracking-wide uppercase">PENGELUARAN</h3>
                </div>
                <div class="text-left md:text-right z-10 pl-16 md:pl-0 -mt-2 md:mt-0">
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-1">Rp {{ number_format($totalCost, 0, ',', '.') }}</h2>
                    <div class="flex items-center md:justify-end gap-1 text-white/80 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path></svg>
                        <span>Total Modal</span>
                    </div>
                </div>
            </div>

            <!-- Laba Bersih -->
            <div class="bg-blue-600 rounded-2xl p-5 md:px-8 flex flex-col md:flex-row md:items-center justify-between shadow-lg relative overflow-hidden group hover:scale-[1.01] transition-transform duration-300">
                <div class="flex items-center gap-4 z-10 mb-4 md:mb-0">
                    <div class="w-12 h-12 rounded-full bg-blue-700/50 flex items-center justify-center border border-blue-500/30 shrink-0">
                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    </div>
                    <div>
                        <h3 class="text-lg md:text-xl font-bold text-white tracking-wide uppercase">LABA BERSIH</h3>
                        <div class="md:hidden flex items-center gap-1 text-blue-100 text-xs font-medium mt-0.5">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                            <span>Keuntungan Bersih</span>
                        </div>
                    </div>
                </div>
                <div class="text-left md:text-right z-10 pl-16 md:pl-0 -mt-2 md:mt-0">
                    <h2 class="text-2xl md:text-3xl font-bold text-white mb-1">Rp {{ number_format($totalProfit, 0, ',', '.') }}</h2>
                    <div class="flex items-center md:justify-end gap-1 text-white/80 text-sm font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path></svg>
                        <span class="md:hidden">Total Laba</span>
                        <span class="hidden md:inline">Keuntungan Bersih</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sales Chart -->
        <!-- Sales Chart -->
        <div class="bg-white p-6 md:p-8 rounded-3xl shadow-xl border border-slate-100/50 mt-8 relative overflow-hidden">
            <div class="absolute top-0 right-0 p-8 opacity-5 pointer-events-none">
                <svg class="w-32 h-32" fill="currentColor" viewBox="0 0 24 24"><path d="M16 6l2.29 2.29-4.88 4.88-4-4L2 16.59 3.41 18l6-6 4 4 6.3-6.29L22 12V6z"></path></svg>
            </div>

            <div class="flex flex-col md:flex-row md:items-center justify-between mb-8 gap-4 relative z-10">
                <div>
                    <h3 class="text-xl font-bold text-slate-800 tracking-tight">Grafik Penjualan Harian</h3>
                    <p class="text-sm text-slate-500 font-medium mt-1">Periode: {{ \Carbon\Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y') }}</p>
                </div>
                <div class="flex items-center gap-2">
                    <span class="px-4 py-1.5 bg-gradient-to-r from-indigo-500 to-purple-500 text-white text-xs font-bold rounded-full shadow-lg shadow-indigo-200">
                        Bulan Ini
                    </span>
                </div>
            </div>
            
            <div class="h-80 w-full relative z-10">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            
            const chartData = {
                labels: @json($chartLabels),
                datasets: @json($chartDatasets)
            };

            new Chart(ctx, {
                type: 'bar',
                data: chartData,
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    layout: {
                        padding: {
                            top: 20
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'center',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                padding: 20,
                                font: { family: "'Outfit', sans-serif", weight: 600, size: 12 },
                                color: '#64748b',
                                boxWidth: 8,
                                boxHeight: 8
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(255, 255, 255, 0.98)',
                            titleColor: '#1e293b',
                            bodyColor: '#475569',
                            borderColor: '#e2e8f0',
                            borderWidth: 1,
                            padding: 12,
                            cornerRadius: 12,
                            titleFont: { family: "'Outfit', sans-serif", size: 13, weight: 'bold' },
                            bodyFont: { family: "'Outfit', sans-serif", size: 12, weight: '500' },
                            displayColors: true,
                            boxPadding: 4,
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) { label += ': '; }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            },
                            shadowOffsetX: 0,
                            shadowOffsetY: 10,
                            shadowBlur: 30,
                            shadowColor: 'rgba(0, 0, 0, 0.1)' 
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            border: { display: false },
                            grid: { 
                                color: '#f1f5f9', 
                                borderDash: [4, 4],
                                drawBorder: false 
                            },
                            ticks: {
                                color: '#94a3b8',
                                font: { family: "'Outfit', sans-serif", size: 10, weight: '500' },
                                callback: function(value) {
                                    if (value >= 1000000) return (value/1000000) + 'jt';
                                    if (value >= 1000) return (value/1000) + 'k';
                                    return value;
                                },
                                padding: 10,
                                maxTicksLimit: 6
                            }
                        },
                        x: {
                            grid: { display: false, drawBorder: false },
                             ticks: {
                                color: '#64748b',
                                font: { family: "'Outfit', sans-serif", size: 10, weight: '600' },
                                maxRotation: 45,
                                minRotation: 45
                            }
                        }
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    elements: {
                        bar: {
                            borderRadius: 6,
                            borderSkipped: false 
                        }
                    },
                    barThickness: 'flex',
                    maxBarThickness: 24
                }
            });
        });
    </script>
</x-admin-layout>
