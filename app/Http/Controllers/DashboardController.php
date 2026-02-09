<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Product;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. Total Penjualan (Omset) - Bulan Ini
        $totalRevenue = Product::whereMonth('created_at', now()->month)
                               ->whereYear('created_at', now()->year)
                               ->sum('price'); 
        
        // 2. Total Modal (Pengeluaran) - Bulan Ini
        $totalCost = Product::whereMonth('created_at', now()->month)
                            ->whereYear('created_at', now()->year)
                            ->sum('cost_price');

        // 3. Laba (Selisih)
        $totalProfit = $totalRevenue - $totalCost;

        // 4. Stok Habis
        $outOfStockCount = Product::where('stock', '<=', 0)->count();

        // 5. Total Item Produk
        $totalProducts = Product::sum('quantity');

        // --- Chart Logic (Same as ReportController) ---
        $month = now()->month;
        $year = now()->year;

        // We need raw product data for the chart loop to avoid N+1 or complex queries inside loop
        $productsForChart = Product::whereMonth('created_at', $month)
                           ->whereYear('created_at', $year)
                           ->get();

        $targetCategories = ['Pulsa', 'Paket Data', 'Kartu Perdana', 'Voucher'];
        $categories = \App\Models\Category::whereIn('name', $targetCategories)->get();
        
        $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;
        
        $chartLabels = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $chartLabels[] = $i;
        }

        $chartDatasets = [];
        $colors = [
            'Pulsa' => '#10b981', 
            'Paket Data' => '#3b82f6', 
            'Kartu Perdana' => '#a855f7', 
            'Voucher' => '#f97316'
        ];

        foreach ($categories as $category) {
            $data = [];
            for ($day = 1; $day <= $daysInMonth; $day++) {
                // Determine daily revenue for this category
                $dailyRevenue = $productsForChart->filter(function ($product) use ($day, $category) {
                    return $product->created_at->day == $day && $product->category_id == $category->id;
                })->sum('price');
                $data[] = $dailyRevenue;
            }

            $chartDatasets[] = [
                'label' => $category->name,
                'data' => $data,
                'backgroundColor' => $colors[$category->name] ?? '#64748b',
                'borderRadius' => 4,
                'barPercentage' => 0.7,
                'categoryPercentage' => 0.8
            ];
        }

        // 6. Produk Terlaris (Top 5 Best Selling by Quantity/Count)
        // Groups products by name, sums their quantity, and orders by total desc.
        // 6. Produk Terlaris (Top 5 Best Selling by Quantity/Count)
        // Groups products by name, sums their quantity, and orders by total desc.
        $topProducts = Product::select(
                'name', 
                \Illuminate\Support\Facades\DB::raw('SUM(quantity) as total_qty'), 
                \Illuminate\Support\Facades\DB::raw('SUM(price - COALESCE(cost_price, 0)) as total_profit')
            )
            ->groupBy('name')
            ->orderByDesc('total_qty')
            ->take(5)
            ->get();

        return view('dashboard', compact('totalRevenue', 'totalCost', 'totalProfit', 'outOfStockCount', 'totalProducts', 'chartLabels', 'chartDatasets', 'topProducts'));
    }
}
