<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - {{ $monthName }}</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
        }
    </style>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-8 print:p-0 print:bg-white text-slate-800">
    
    <!-- A4 Paper Container -->
    <div class="print-container w-full max-w-[210mm] min-h-[297mm] bg-white p-[2.5cm] shadow-2xl relative flex flex-col justify-between overflow-hidden mx-auto">
        
        <!-- Watermark -->
        <div class="absolute inset-0 z-0 flex items-center justify-center opacity-[0.02] pointer-events-none">
            <svg class="w-[120%] h-[120%]" fill="currentcolor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"/></svg>
        </div>

        <!-- Main Content -->
        <div class="relative z-10 flex-1 flex flex-col">
            
            <!-- Header -->
            <div class="flex justify-between items-start border-b-[3px] border-slate-900 pb-8 mb-10">
                <div class="flex items-center gap-5">
                    <div class="bg-slate-900 text-white p-4 rounded-xl shadow-lg print:shadow-none">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                    </div>
                    <div>
                        <h1 class="text-3xl font-black uppercase tracking-wider text-slate-900 leading-none">Restu Cell</h1>
                        <p class="text-sm text-slate-500 font-bold tracking-[0.2em] uppercase mt-1.5">Management System</p>
                    </div>
                </div>
                <div class="text-right">
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight mb-2">LAPORAN KEUANGAN</h2>
                    <div class="text-sm font-medium text-slate-600 space-y-1">
                        <p>Periode: <strong class="text-slate-900">{{ $monthName }}</strong></p>
                        <p>Dicetak: <span class="text-slate-900 uppercase font-bold">{{ now()->format('d M Y • H:i') }}</span></p>
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="grid grid-cols-1 gap-10 flex-1">
                
                <!-- Financial Summary Section (With Chart) -->
                <div class="w-full">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-3">
                        <span class="w-6 h-[2px] bg-emerald-500 rounded-full inline-block"></span> Ringkasan Keuangan
                    </h3>
                    
                    <div class="bg-white rounded-2xl border-2 border-slate-100 p-8 shadow-sm print:shadow-none print:border-slate-200">
                        <div class="flex gap-8 items-center">
                            <!-- Chart Area -->
                            <div class="w-1/3 h-48 relative">
                                <canvas id="financeChart"></canvas>
                            </div>
                            
                            <!-- Legend/Data Area -->
                            <div class="flex-1 space-y-6">
                                <!-- Income -->
                                <div class="flex items-center justify-between group">
                                    <div class="flex items-center gap-3">
                                        <span class="w-3 h-3 rounded-full bg-emerald-500"></span>
                                        <span class="text-sm font-bold text-slate-500 uppercase tracking-wider">Pemasukan</span>
                                    </div>
                                    <span class="text-xl font-bold text-slate-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</span>
                                </div>

                                <!-- Expense -->
                                <div class="flex items-center justify-between group">
                                     <div class="flex items-center gap-3">
                                        <span class="w-3 h-3 rounded-full bg-rose-500"></span>
                                        <span class="text-sm font-bold text-slate-500 uppercase tracking-wider">Pengeluaran</span>
                                    </div>
                                    <span class="text-xl font-bold text-rose-600">(Rp {{ number_format($totalCost, 0, ',', '.') }})</span>
                                </div>
                                
                                <div class="border-t border-slate-100 pt-4 mt-2">
                                     <div class="flex items-center justify-between group">
                                        <div class="flex items-center gap-3">
                                            <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                                            <span class="text-sm font-bold text-slate-900 uppercase tracking-wider">Laba Bersih</span>
                                        </div>
                                        <span class="text-3xl font-black text-blue-600">Rp {{ number_format($totalProfit, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Products Section -->
                <div class="w-full pb-6">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-6 flex items-center gap-3">
                        <span class="w-6 h-[2px] bg-amber-500 rounded-full inline-block"></span> Top 3 Produk Terlaris
                    </h3>

                    <div class="grid grid-cols-3 gap-6">
                        @forelse($topProducts as $index => $product)
                            <div class="rounded-2xl p-5 border-2 flex flex-col items-center text-center relative overflow-hidden group {{ $index == 0 ? 'bg-amber-50/50 border-amber-200' : 'bg-white border-slate-100' }}">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-black mb-3 {{ $index == 0 ? 'bg-amber-500 text-white shadow-lg shadow-amber-200' : 'bg-slate-100 text-slate-600' }}">
                                    #{{ $index + 1 }}
                                </div>
                                <h4 class="text-sm font-bold text-slate-800 line-clamp-2 w-full mb-1 h-10 flex items-center justify-center" title="{{ $product->name }}">{{ $product->name }}</h4>
                                <div class="mt-auto pt-3 border-t w-full border-slate-100 border-dashed">
                                    <span class="block text-xl font-black text-slate-900">{{ $product->total_sold }}</span>
                                    <span class="text-[10px] text-slate-400 uppercase font-bold">Terjual</span>
                                </div>
                            </div>
                        @empty
                             <div class="col-span-3 text-center text-slate-400 italic text-sm py-8 border-2 border-dashed border-slate-100 rounded-xl bg-slate-50/50">
                                Belum ada data penjualan.
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <!-- Signature Area -->
        <div class="relative z-10 grid grid-cols-2 gap-20 mt-auto pt-8">
            <div class="text-center">
                <p class="text-[10px] text-slate-400 uppercase tracking-widest mb-16 font-bold">Dibuat Oleh</p>
                <div class="border-t-2 border-slate-200 pt-3 inline-block min-w-[180px]">
                    <p class="font-bold text-slate-900 text-sm">{{ auth()->user()->name }}</p>
                    <p class="text-[10px] text-slate-500 uppercase mt-0.5">Staff / Admin</p>
                </div>
            </div>
            <div class="text-center">
                <p class="text-[10px] text-slate-400 uppercase tracking-widest mb-16 font-bold">Mengetahui</p>
                <div class="border-t-2 border-slate-200 pt-3 inline-block min-w-[180px]">
                    <p class="font-bold text-slate-900 text-sm">.......................</p>
                    <p class="text-[10px] text-slate-500 uppercase mt-0.5">Owner / Manager</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Floating Print Button -->
    <div class="fixed bottom-10 right-10 no-print z-50">
        <button onclick="window.print()" class="group bg-slate-900 text-white pl-5 pr-6 py-4 rounded-full shadow-2xl hover:bg-slate-800 transition-all flex items-center gap-3">
             <div class="bg-white/10 p-2 rounded-full group-hover:bg-white/20 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            </div>
            <div class="text-left">
                <span class="block text-xs font-medium text-slate-400 uppercase tracking-wider">Ready to print</span>
                <span class="block font-bold">Cetak Laporan</span>
            </div>
        </button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('financeChart').getContext('2d');
            
            // Data for Chart
            const revenue = {{ $totalRevenue }};
            const cost = {{ $totalCost }};
            const profit = {{ $totalProfit }};

            new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: ['Pemasukan', 'Pengeluaran', 'Laba Bersih'],
                    datasets: [{
                        data: [revenue, cost, profit],
                        backgroundColor: [
                            '#10b981', // Emerald 500
                            '#f43f5e', // Rose 500
                            '#3b82f6'  // Blue 500
                        ],
                        borderWidth: 0,
                        hoverOffset: 4
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false // Hide default legend, using our custom one
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed !== null) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    cutout: '75%', // Thinner ring for modern look
                }
            });

            // Auto-print after a delay to ensure chart renders
            setTimeout(() => {
                // window.print(); 
                // Commented out auto-print to let user see preview first as mostly requested
            }, 1000);
        });
    </script>
</body>
</html>
