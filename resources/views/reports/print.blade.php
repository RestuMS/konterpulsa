<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - {{ $monthName }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&display=swap');
        
        body { font-family: 'Inter', sans-serif; }

        @media print {
            @page { 
                size: A4; 
                margin: 0; 
            }
            body { 
                margin: 0; 
                background: white !important;
                -webkit-print-color-adjust: exact; 
            }
            .print-container {
                box-shadow: none !important;
                margin: 0 !important;
                width: 100% !important;
                max-width: none !important;
                min-height: 100vh !important;
                border-radius: 0 !important;
                padding: 2.5cm !important;
            }
            .no-print { display: none !important; }
            /* Force desktop layout for print */
            .print-header { flex-direction: row !important; text-align: right !important; }
            .print-header > div:last-child { text-align: right !important; }
            .print-finance-grid { flex-direction: row !important; }
            .print-chart-area { width: 33.33% !important; }
            .print-legend-area { flex: 1 !important; }
            .print-products-grid { grid-template-columns: repeat(3, minmax(0, 1fr)) !important; }
            .print-signature { grid-template-columns: repeat(2, minmax(0, 1fr)) !important; gap: 5rem !important; }
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-4 sm:p-6 md:p-8 print:p-0 print:bg-white text-slate-800">
    
    <!-- A4 Paper Container -->
    <div class="print-container w-full max-w-[210mm] md:min-h-[297mm] bg-white p-5 sm:p-8 md:p-[2.5cm] shadow-2xl relative flex flex-col justify-between overflow-hidden mx-auto rounded-2xl md:rounded-none">
        
        <!-- Watermark -->
        <div class="absolute inset-0 z-0 flex items-center justify-center opacity-[0.02] pointer-events-none">
            <svg class="w-[120%] h-[120%]" fill="currentcolor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"/></svg>
        </div>

        <!-- Main Content -->
        <div class="relative z-10 flex-1 flex flex-col">
            
            <!-- Header -->
            <div class="print-header flex flex-col sm:flex-row justify-between items-center sm:items-start border-b-[3px] border-slate-900 pb-5 sm:pb-8 mb-6 sm:mb-10 gap-4">
                <div class="flex items-center">
                    <img src="{{ asset('images/logo.png') }}" alt="Restu Cell Logo" class="h-20 sm:h-28 md:h-32 w-auto object-contain">
                </div>
                <div class="text-center sm:text-right">
                    <h2 class="text-xl sm:text-2xl md:text-3xl font-black text-slate-900 tracking-tight mb-2">LAPORAN KEUANGAN</h2>
                    <div class="text-xs sm:text-sm font-medium text-slate-600 space-y-1">
                        <p>Periode: <strong class="text-slate-900">{{ $monthName }}</strong></p>
                        <p>Dicetak: <span class="text-slate-900 uppercase font-bold">{{ now()->setTimezone('Asia/Jakarta')->format('d M Y • H:i') }} WIB</span></p>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 gap-6 sm:gap-10 flex-1">
                
                <!-- Financial Summary Section (With Chart) -->
                <div class="w-full">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 sm:mb-6 flex items-center gap-3">
                        <span class="w-6 h-[2px] bg-emerald-500 rounded-full inline-block"></span> Ringkasan Keuangan
                    </h3>
                    
                    <div class="bg-white rounded-2xl border-2 border-slate-100 p-4 sm:p-6 md:p-8 shadow-sm print:shadow-none print:border-slate-200">
                        <div class="print-finance-grid flex flex-col md:flex-row gap-6 md:gap-8 items-center">
                            <!-- Chart Area -->
                            <div class="print-chart-area w-full md:w-1/3 h-40 sm:h-48 relative">
                                <canvas id="financeChart"></canvas>
                            </div>
                            
                            <!-- Legend/Data Area -->
                            <div class="print-legend-area w-full md:flex-1 space-y-3 sm:space-y-4">
                                <!-- Income -->
                                <div class="flex items-center justify-between group">
                                    <div class="flex items-center gap-2 sm:gap-3">
                                        <span class="w-3 h-3 rounded-full bg-emerald-500 shrink-0"></span>
                                        <span class="text-xs sm:text-sm font-bold text-slate-500 uppercase tracking-wider">Pemasukan</span>
                                    </div>
                                    <span class="text-base sm:text-xl font-bold text-slate-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                                </div>

                                <!-- Modal -->
                                <div class="flex items-center justify-between group">
                                     <div class="flex items-center gap-2 sm:gap-3">
                                        <span class="w-3 h-3 rounded-full bg-rose-500 shrink-0"></span>
                                        <span class="text-xs sm:text-sm font-bold text-slate-500 uppercase tracking-wider">Modal</span>
                                    </div>
                                    <span class="text-base sm:text-xl font-bold text-rose-600">(Rp {{ number_format($totalCost, 0, ',', '.') }})</span>
                                </div>

                                <!-- Pengeluaran Operasional -->
                                <div class="flex items-center justify-between group">
                                     <div class="flex items-center gap-2 sm:gap-3">
                                        <span class="w-3 h-3 rounded-full bg-orange-500 shrink-0"></span>
                                        <span class="text-xs sm:text-sm font-bold text-slate-500 uppercase tracking-wider">Pengeluaran</span>
                                    </div>
                                    <span class="text-base sm:text-xl font-bold text-orange-600">(Rp {{ number_format($totalExpense, 0, ',', '.') }})</span>
                                </div>
                                
                                <div class="border-t border-slate-100 pt-3 mt-2">
                                     <div class="flex items-center justify-between group">
                                        <div class="flex items-center gap-2 sm:gap-3">
                                            <span class="w-3 h-3 rounded-full bg-blue-500 shrink-0"></span>
                                            <span class="text-xs sm:text-sm font-bold text-slate-900 uppercase tracking-wider">Laba Bersih</span>
                                        </div>
                                        <span class="text-xl sm:text-2xl md:text-3xl font-black text-blue-600">Rp {{ number_format($totalProfit, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Products Section -->
                <div class="w-full pb-4 sm:pb-6">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 sm:mb-6 flex items-center gap-3">
                        <span class="w-6 h-[2px] bg-amber-500 rounded-full inline-block"></span> Top 3 Produk Terlaris
                    </h3>

                    <div class="print-products-grid grid grid-cols-1 sm:grid-cols-3 gap-3 sm:gap-6">
                        @forelse($topProducts as $index => $product)
                            <div class="rounded-2xl p-4 sm:p-5 border-2 flex flex-row sm:flex-col items-center sm:text-center relative overflow-hidden group {{ $index == 0 ? 'bg-amber-50/50 border-amber-200' : 'bg-white border-slate-100' }}">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-black shrink-0 sm:mb-3 mr-4 sm:mr-0 {{ $index == 0 ? 'bg-amber-500 text-white shadow-lg shadow-amber-200' : 'bg-slate-100 text-slate-600' }}">
                                    #{{ $index + 1 }}
                                </div>
                                <div class="flex-1 sm:w-full">
                                    <h4 class="text-sm font-bold text-slate-800 line-clamp-2 sm:h-10 sm:flex sm:items-center sm:justify-center" title="{{ $product->name }}">{{ $product->name }}</h4>
                                </div>
                                <div class="sm:mt-auto sm:pt-3 sm:border-t sm:w-full sm:border-slate-100 sm:border-dashed ml-4 sm:ml-0 text-right sm:text-center shrink-0">
                                    <span class="block text-xl font-black text-slate-900">{{ $product->total_sold }}</span>
                                    <span class="text-[10px] text-slate-400 uppercase font-bold">Terjual</span>
                                </div>
                            </div>
                        @empty
                             <div class="col-span-1 sm:col-span-3 text-center text-slate-400 italic text-sm py-8 border-2 border-dashed border-slate-100 rounded-xl bg-slate-50/50">
                                Belum ada data penjualan.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Signature Area -->
        <div class="print-signature relative z-10 grid grid-cols-2 gap-8 sm:gap-12 md:gap-20 mt-auto pt-6 sm:pt-8">
            <div class="text-center">
                <p class="text-[10px] text-slate-400 uppercase tracking-widest mb-12 sm:mb-16 font-bold">Dibuat Oleh</p>
                <div class="border-t-2 border-slate-200 pt-3 inline-block min-w-[120px] sm:min-w-[180px]">
                    <p class="font-bold text-slate-900 text-xs sm:text-sm">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-500 uppercase mt-0.5">Staff / Admin</p>
                </div>
            </div>
            <div class="text-center">
                <p class="text-[10px] text-slate-400 uppercase tracking-widest mb-12 sm:mb-16 font-bold">Mengetahui</p>
                <div class="border-t-2 border-slate-200 pt-3 inline-block min-w-[120px] sm:min-w-[180px]">
                    <p class="font-bold text-slate-900 text-xs sm:text-sm">.......................</p>
                    <p class="text-[10px] text-slate-500 uppercase mt-0.5">Owner / Manager</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Print Button -->
    <div class="fixed bottom-4 right-4 sm:bottom-10 sm:right-10 no-print z-50">
        <button onclick="window.print()" class="group bg-slate-900 text-white px-4 sm:pl-5 sm:pr-6 py-3 sm:py-4 rounded-full shadow-2xl hover:bg-slate-800 transition-all flex items-center gap-2 sm:gap-3">
             <div class="bg-white/10 p-1.5 sm:p-2 rounded-full group-hover:bg-white/20 transition-colors">
                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            </div>
            <div class="text-left hidden sm:block">
                <span class="block text-xs font-medium text-slate-400 uppercase tracking-wider">Ready to print</span>
                <span class="block font-bold">Cetak Laporan</span>
            </div>
            <span class="sm:hidden text-sm font-bold">Cetak</span>
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('financeChart').getContext('2d');
            
            const revenue = {{ $totalRevenue }};
            const cost = {{ $totalCost }};
            const expense = {{ $totalExpense }};
            const profit = {{ $totalProfit }};

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pemasukan (Total)', 'Modal', 'Pengeluaran Operasional', 'Laba (Keuntungan)'],
                    datasets: [
                        {
                            data: [revenue],
                            backgroundColor: ['#10b981'],
                            borderWidth: 0,
                            weight: 0.2,
                            labels: 'Pemasukan'
                        },
                        {
                            data: [cost, expense, Math.max(profit, 0)], 
                            backgroundColor: [
                                '#f43f5e',
                                '#f97316',
                                '#3b82f6'
                            ],
                            borderWidth: 2,
                            borderColor: '#ffffff',
                            weight: 0.8
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let value = context.raw;
                                    let total = revenue;
                                    
                                    if (context.datasetIndex === 0) {
                                         return ' Total Pemasukan: ' + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(value);
                                    }

                                    let label = context.chart.data.labels[context.dataIndex + 1] || ''; 
                                    let percentage = revenue > 0 ? ((value / total) * 100).toFixed(1) + '%' : '0%';
                                    
                                    return label + ': ' + new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(value) + ' (' + percentage + ')';
                                }
                            }
                        }
                    },
                    cutout: '60%',
                },
                plugins: [{
                    id: 'textCenter',
                    beforeDraw: function(chart) {
                        var width = chart.width,
                            height = chart.height,
                            ctx = chart.ctx;
            
                        ctx.restore();
                        var fontSize = (height / 114).toFixed(2);
                        ctx.font = "bold " + fontSize + "em sans-serif";
                        ctx.textBaseline = "middle";
                        ctx.fillStyle = "#3b82f6";
            
                        var margin = revenue > 0 ? ((profit / revenue) * 100).toFixed(1) + "%" : "0%";
                        var text = margin,
                            textX = Math.round((width - ctx.measureText(text).width) / 2),
                            textY = height / 2;
            
                        ctx.fillText(text, textX, textY);
                        
                        ctx.font = "bold " + (fontSize*0.35).toFixed(2) + "em sans-serif";
                        ctx.fillStyle = "#64748b";
                        var subtext = "Laba Bersih",
                            subtextX = Math.round((width - ctx.measureText(subtext).width) / 2),
                            subtextY = height / 2 + 20;
                        ctx.fillText(subtext, subtextX, subtextY);

                        ctx.save();
                    }
                }]
            });
        });
    </script>
</body>
</html>
