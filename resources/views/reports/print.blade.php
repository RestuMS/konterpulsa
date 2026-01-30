<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Keuangan - {{ $monthName }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body { -webkit-print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body class="bg-white p-8 font-sans">
    
    <!-- Header Invoice-style -->
    <div class="border-b-2 border-slate-800 pb-6 mb-8 flex justify-between items-start">
        <div>
            <h1 class="text-3xl font-bold text-slate-900 uppercase tracking-widest">Laporan Keuangan</h1>
            <p class="text-slate-500 mt-1">KonterPOS - Management System</p>
        </div>
        <div class="text-right">
            <h2 class="text-xl font-semibold text-slate-700">{{ $monthName }}</h2>
            <p class="text-sm text-slate-500">Dicetak pada: {{ now()->format('d F Y, H:i') }}</p>
        </div>
    </div>

    <!-- Summary Table -->
    <div class="max-w-2xl mx-auto mt-12">
        <h3 class="text-lg font-bold text-slate-800 mb-4 border-b pb-2">Ringkasan Bulan Ini</h3>
        
        <table class="w-full text-left">
            <tbody class="divide-y divide-slate-100">
                <tr>
                    <td class="py-4 text-slate-600 font-medium">Total Pemasukan (Omset)</td>
                    <td class="py-4 text-right font-bold text-emerald-600 text-xl">
                        Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                    </td>
                </tr>
                <tr>
                    <td class="py-4 text-slate-600 font-medium">Total Pengeluaran (HPP/Modal Produk terjual)</td>
                    <td class="py-4 text-right font-bold text-rose-600 text-xl">
                        (Rp {{ number_format($totalCost, 0, ',', '.') }})
                    </td>
                </tr>
                <tr class="bg-slate-50">
                    <td class="py-6 text-slate-800 font-bold text-lg pl-4">LABA BERSIH</td>
                    <td class="py-6 text-right font-bold text-blue-600 text-2xl pr-4">
                        Rp {{ number_format($totalProfit, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Signature Area (Optional) -->
    <div class="mt-24 grid grid-cols-2 gap-8 text-center">
        <div>
            <p class="text-sm text-slate-500 mb-20">Dibuat Oleh,</p>
            <p class="font-bold text-slate-800 border-t border-slate-300 inline-block px-8 pt-2">{{ auth()->user()->name }}</p>
        </div>
        <div>
            <p class="text-sm text-slate-500 mb-20">Mengetahui,</p>
            <p class="font-bold text-slate-800 border-t border-slate-300 inline-block px-8 pt-2">Owner / Manager</p>
        </div>
    </div>

    <!-- Print Control -->
    <div class="fixed bottom-8 right-8 no-print">
        <button onclick="window.print()" class="bg-blue-600 text-white px-6 py-3 rounded-full shadow-lg font-bold hover:bg-blue-700 transition-colors flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"></path></svg>
            Print Sekarang
        </button>
    </div>

    <script>
        // Auto print when page loads
        window.onload = function() {
            setTimeout(function() {
                window.print();
            }, 500);
        }
    </script>
</body>
</html>
