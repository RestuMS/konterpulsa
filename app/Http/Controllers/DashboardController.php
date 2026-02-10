<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
    public function index()
    {
        $month = now()->month;
        $year = now()->year;
        $cacheKey = "dashboard_{$year}_{$month}_" . now()->format('Y-m-d-H');

        $dashboardData = Cache::remember($cacheKey, 300, function () use ($month, $year) {
            // Single query for totals (instead of 3 separate queries)
            $totals = Product::whereMonth('created_at', $month)
                            ->whereYear('created_at', $year)
                            ->selectRaw('COALESCE(SUM(price), 0) as total_revenue, COALESCE(SUM(cost_price), 0) as total_cost')
                            ->first();

            $totalRevenue = $totals->total_revenue;
            $totalCost = $totals->total_cost;
            $totalProfit = $totalRevenue - $totalCost;

            // Single query for counts
            $outOfStockCount = Product::where('stock', '<=', 0)->count();
            $totalProducts = Product::sum('quantity');

            // --- Optimized Chart Logic ---
            // Use a single GROUP BY query instead of nested loops
            $targetCategories = ['Pulsa', 'Paket Data', 'Kartu Perdana', 'Voucher'];
            $categories = \App\Models\Category::whereIn('name', $targetCategories)->get();

            $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;
            $chartLabels = range(1, $daysInMonth);

            // Single grouped query for chart data (replaces O(categories × days × products) loop)
            $dailyData = Product::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->whereIn('category_id', $categories->pluck('id'))
                ->selectRaw('category_id, DAY(created_at) as day, SUM(price) as daily_revenue')
                ->groupBy('category_id', DB::raw('DAY(created_at)'))
                ->get()
                ->groupBy('category_id');

            $colors = [
                'Pulsa' => '#10b981',
                'Paket Data' => '#3b82f6',
                'Kartu Perdana' => '#a855f7',
                'Voucher' => '#f97316'
            ];

            $chartDatasets = [];
            foreach ($categories as $category) {
                $categoryDailyData = isset($dailyData[$category->id])
                    ? $dailyData[$category->id]->keyBy('day')
                    : collect();

                $data = [];
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $data[] = isset($categoryDailyData[$day]) ? $categoryDailyData[$day]->daily_revenue : 0;
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

            // Top Products
            $topProducts = Product::select(
                    'name',
                    DB::raw('SUM(quantity) as total_qty'),
                    DB::raw('SUM(price - COALESCE(cost_price, 0)) as total_profit')
                )
                ->groupBy('name')
                ->orderByDesc('total_qty')
                ->take(5)
                ->get();

            return compact('totalRevenue', 'totalCost', 'totalProfit', 'outOfStockCount', 'totalProducts', 'chartLabels', 'chartDatasets', 'topProducts');
        });

        return view('dashboard', $dashboardData);
    }
}
