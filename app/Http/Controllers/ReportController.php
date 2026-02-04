<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Default to current month if not specified
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        // Filter Products created in the selected month
        $products = Product::with('category')
                           ->whereMonth('created_at', $month)
                           ->whereYear('created_at', $year)
                           ->get();

        // --- Chart Logic ---
        $targetCategories = ['Pulsa', 'Paket Data', 'Kartu Perdana', 'Voucher'];
        $categories = \App\Models\Category::whereIn('name', $targetCategories)->get();
        
        $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;
        
        $chartLabels = [];
        for ($i = 1; $i <= $daysInMonth; $i++) {
            $chartLabels[] = $i;
        }

        $chartDatasets = [];
        // Colors mapping: Pulsa (Green), Paket Data (Blue), Kartu Perdana (Purple), Voucher (Orange)
        $colors = [
            'Pulsa' => '#10b981', 
            'Paket Data' => '#3b82f6', 
            'Kartu Perdana' => '#a855f7', 
            'Voucher' => '#f97316'
        ];

        foreach ($categories as $category) {
            $data = [];
            for ($day = 1; $day <= $daysInMonth; $day++) {
                $dailyRevenue = $products->filter(function ($product) use ($day, $category) {
                    return $product->created_at->day == $day && $product->category_id == $category->id;
                })->sum('price');
                $data[] = $dailyRevenue;
            }

            $chartDatasets[] = [
                'label' => $category->name,
                'data' => $data,
                'backgroundColor' => $colors[$category->name] ?? '#64748b', // Fallback color
                'borderRadius' => 4,
                'barPercentage' => 0.7,
                'categoryPercentage' => 0.8
            ];
        }

        // Pemasukan based on Product Dashboard logic (Sum of prices of products added)
        // Adjust this if you want to include stock: $products->sum(fn($p) => $p->price * $p->stock);
        // For now, sticking to the simple Sum('price') as per ProductController logic
        $totalRevenue = $products->sum('price');
        $totalCost = $products->sum('cost_price');
        $totalProfit = $totalRevenue - $totalCost;

        // Order by latest
        $products = $products->sortByDesc('created_at');

        return view('reports.index', compact('products', 'totalRevenue', 'totalCost', 'totalProfit', 'month', 'year', 'chartLabels', 'chartDatasets'));
    }

    public function print(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        $products = Product::whereMonth('created_at', $month)
                           ->whereYear('created_at', $year)
                           ->get();

        $totalRevenue = $products->sum('price');
        $totalCost = $products->sum('cost_price');
        $totalProfit = $totalRevenue - $totalCost;
        
        $monthName = Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y');

        // Logic for Top 3 Best Selling Products
        $topProducts = Product::whereMonth('created_at', $month)
                            ->whereYear('created_at', $year)
                            ->select('name', \Illuminate\Support\Facades\DB::raw('count(*) as total_sold'))
                            ->groupBy('name')
                            ->orderByDesc('total_sold')
                            ->take(3)
                            ->get();

        return view('reports.print', compact('totalRevenue', 'totalCost', 'totalProfit', 'monthName', 'topProducts'));
    }
}
