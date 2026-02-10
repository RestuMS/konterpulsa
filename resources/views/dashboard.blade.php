<x-admin-layout>
    <x-slot name="header">
        Dashboard
    </x-slot>

    <!-- Top Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
        
        <!-- Total Potensi Omset -->
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-lg relative overflow-hidden group">
            <div class="flex justify-between items-start z-10 relative">
                <div>
                    <p class="text-slate-400 text-sm font-medium mb-1">Total Potensi Omset</p>
                    <h3 class="text-2xl font-bold text-white">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-slate-700/50 flex items-center justify-center text-slate-300">
                   <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Total Item Produk -->
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-lg relative overflow-hidden">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-sm font-medium mb-1">Total Produk</p>
                    <div class="flex items-center gap-2">
                        <h3 class="text-2xl font-bold text-white">{{ $totalProducts }}</h3>
                        <span class="text-xs font-medium text-blue-400 bg-blue-400/10 px-1.5 py-0.5 rounded">Item</span>
                    </div>
                </div>
                <div class="w-10 h-10 rounded-lg bg-slate-700/50 flex items-center justify-center text-slate-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
                </div>
            </div>
        </div>

        <!-- Stok Habis (Red) -->
        <div class="bg-gradient-to-br from-red-600 to-red-700 rounded-xl p-5 shadow-lg shadow-red-500/20 text-white relative overflow-hidden">
             <div class="flex justify-between items-start z-10 relative">
                <div>
                    <p class="text-white/80 text-sm font-medium mb-1 flex items-center gap-1">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                        Stok Habis
                    </p>
                    <h3 class="text-2xl font-bold">{{ $outOfStockCount }} Item</h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-white/20 flex items-center justify-center text-white">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
                </div>
            </div>
            <!-- Decor -->
            <div class="absolute -bottom-4 -right-4 w-20 h-20 bg-white/10 rounded-full blur-xl"></div>
        </div>

        <!-- Total Potensi Laba -->
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-lg relative overflow-hidden">
            <div class="flex justify-between items-start">
                <div>
                    <p class="text-slate-400 text-sm font-medium mb-1">Total Potensi Laba</p>
                    <h3 class="text-2xl font-bold text-emerald-400">+ Rp {{ number_format($totalProfit, 0, ',', '.') }}</h3>
                </div>
                <div class="w-10 h-10 rounded-lg bg-slate-700/50 flex items-center justify-center text-slate-300">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Section: Chart & Info -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        
        <!-- Grafik Penjualan (Chart) -->
        <div class="lg:col-span-3 bg-slate-800 rounded-xl border border-slate-700 shadow-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-bold text-white">Grafik Penjualan</h3>
                <div class="flex gap-2">
                     <button class="p-1 rounded bg-slate-700 hover:bg-slate-600 text-slate-300"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path></svg></button>
                </div>
            </div>
            
            <div class="h-64 w-full">
                <canvas id="salesChart"></canvas>
            </div>
        </div>
    </div>

    <!-- Bottom Section: Table & Widget -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <!-- Produk Laris Table -->
        <div class="lg:col-span-2 bg-slate-800 rounded-xl border border-slate-700 shadow-lg p-6">
            <h3 class="text-lg font-bold text-white mb-4">Produk Laris (Top 5)</h3>
            <!-- Desktop Table -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full text-left text-sm text-slate-400">
                    <thead class="bg-slate-700/50 text-slate-200 uppercase tracking-wider text-xs">
                        <tr>
                            <th class="p-3 rounded-l-lg">No</th>
                            <th class="p-3">Nama Produk</th>
                            <th class="p-3 text-center">Terjual (Qty)</th>
                            <th class="p-3 rounded-r-lg text-right">Total Laba (Keuntungan)</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-700/50">
                        @forelse($topProducts as $index => $product)
                            <tr class="hover:bg-slate-700/20 transition-colors">
                                <td class="p-3">{{ $index + 1 }}</td>
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
                                <td colspan="4" class="p-6 text-center text-slate-500 italic">Belum ada transaksi</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Mobile List -->
            <div class="md:hidden space-y-3">
                @forelse($topProducts as $index => $product)
                    <div class="bg-slate-700/30 p-4 rounded-lg border border-slate-700">
                        <div class="flex justify-between items-start mb-2">
                            <span class="text-xs font-bold text-slate-500">#{{ $index + 1 }}</span>
                            <span class="px-2 py-1 rounded bg-blue-500/20 text-blue-400 text-xs font-bold border border-blue-500/30">
                                {{ $product->total_qty }} Terjual
                            </span>
                        </div>
                        <h4 class="text-white font-bold mb-1">{{ $product->name }}</h4>
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-slate-400">Total Laba</span>
                            <span class="text-emerald-400 font-mono font-bold">+ Rp {{ number_format($product->total_profit, 0, ',', '.') }}</span>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-slate-500 italic">Belum ada transaksi</div>
                @endforelse
            </div>
        </div>

        <!-- Info Pemesanan Online -->
        <div class="bg-slate-800 rounded-xl border border-slate-700 shadow-lg p-6">
            <h3 class="text-lg font-bold text-white mb-4">Info Pemesanan Online</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-slate-700/50">
                    <div class="flex items-center gap-3">
                         <div class="w-2 h-2 rounded-full bg-yellow-500"></div>
                         <span class="text-slate-300">Pesanan Baru</span>
                    </div>
                    <span class="font-bold text-white text-lg">5</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-slate-700/50">
                    <div class="flex items-center gap-3">
                         <div class="w-2 h-2 rounded-full bg-blue-500"></div>
                         <span class="text-slate-300">Dalam Proses</span>
                    </div>
                    <span class="font-bold text-white text-lg">2</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <div class="flex items-center gap-3">
                         <div class="w-2 h-2 rounded-full bg-red-400"></div>
                         <span class="text-slate-300">Dikirim</span>
                    </div>
                    <span class="font-bold text-white text-lg">10</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Chart Config -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            
            // Data passed from DashboardController
            const chartLabels = @json($chartLabels);
            const chartDatasets = @json($chartDatasets);

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: chartLabels,
                    datasets: chartDatasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            align: 'center',
                            labels: {
                                usePointStyle: true,
                                pointStyle: 'circle',
                                padding: 25,
                                font: { family: "'Inter', sans-serif", weight: 600, size: 12 },
                                color: '#94a3b8', // Slate 400
                                boxWidth: 8,
                                boxHeight: 8
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(15, 23, 42, 0.95)', // Slate 900
                            titleColor: '#f8fafc',
                            bodyColor: '#e2e8f0',
                            borderColor: '#334155',
                            borderWidth: 1,
                            padding: 14,
                            cornerRadius: 8,
                            titleFont: { family: "'Inter', sans-serif", size: 13, weight: 'bold' },
                            bodyFont: { family: "'Inter', sans-serif", size: 12 },
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
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            border: { display: false },
                            grid: { 
                                color: '#334155', // Slate 700
                                borderDash: [5, 5],
                                drawBorder: false,
                                tickLength: 0
                            },
                             ticks: { 
                                color: '#64748b', // Slate 500
                                font: { family: "'Inter', sans-serif", size: 11, weight: 500 },
                                padding: 10,
                                callback: function(value) {
                                    if (value >= 1000000) return (value/1000000) + 'jt';
                                    if (value >= 1000) return (value/1000) + 'k';
                                    return value;
                                }
                            }
                        },
                        x: {
                            border: { display: false },
                            grid: { display: false },
                             ticks: { 
                                color: '#64748b',
                                font: { family: "'Inter', sans-serif", size: 11 },
                                maxRotation: 0,
                                autoSkip: false,
                                maxTicksLimit: 31
                            }
                        }
                    },
                    interaction: {
                        mode: 'index',
                        intersect: false,
                    },
                    elements: {
                        bar: {
                            borderRadius: 4, // Rounded bars like the image
                            borderSkipped: false
                        }
                    }
                }
            });
        });
    </script>
</x-admin-layout>
