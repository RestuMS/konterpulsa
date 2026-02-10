<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);
        $cacheKey = "report_{$year}_{$month}_" . now()->format('Y-m-d-H');

        // Products query (needed for table display, not cacheable due to sorting)
        $products = Product::with('category')
                           ->whereMonth('created_at', $month)
                           ->whereYear('created_at', $year)
                           ->latest()
                           ->get();

        $reportData = Cache::remember($cacheKey, 300, function () use ($month, $year) {
            // --- Optimized Chart Logic (single GROUP BY query) ---
            $targetCategories = ['Pulsa', 'Paket Data', 'Kartu Perdana', 'Voucher'];
            $categories = \App\Models\Category::whereIn('name', $targetCategories)->get();

            $daysInMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;
            $chartLabels = range(1, $daysInMonth);

            $colors = [
                'Pulsa' => '#10b981',
                'Paket Data' => '#3b82f6',
                'Kartu Perdana' => '#a855f7',
                'Voucher' => '#f97316'
            ];

            // Single grouped query instead of nested loops
            $dailyData = Product::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->whereIn('category_id', $categories->pluck('id'))
                ->selectRaw('category_id, DAY(created_at) as day, SUM(price) as daily_revenue')
                ->groupBy('category_id', DB::raw('DAY(created_at)'))
                ->get()
                ->groupBy('category_id');

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

            // Totals via single query
            $totals = Product::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->selectRaw('COALESCE(SUM(price), 0) as total_revenue, COALESCE(SUM(cost_price), 0) as total_cost')
                ->first();

            $totalRevenue = $totals->total_revenue;
            $totalCost = $totals->total_cost;
            $totalProfit = $totalRevenue - $totalCost;

            return compact('chartLabels', 'chartDatasets', 'totalRevenue', 'totalCost', 'totalProfit');
        });

        return view('reports.index', array_merge(
            ['products' => $products, 'month' => $month, 'year' => $year],
            $reportData
        ));
    }

    public function print(Request $request)
    {
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);

        // Single query for totals
        $totals = Product::whereMonth('created_at', $month)
                         ->whereYear('created_at', $year)
                         ->selectRaw('COALESCE(SUM(price), 0) as total_revenue, COALESCE(SUM(cost_price), 0) as total_cost')
                         ->first();

        $totalRevenue = $totals->total_revenue;
        $totalCost = $totals->total_cost;
        $totalProfit = $totalRevenue - $totalCost;

        $monthName = Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y');

        $topProducts = Product::whereMonth('created_at', $month)
                            ->whereYear('created_at', $year)
                            ->select('name', DB::raw('sum(quantity) as total_sold'))
                            ->groupBy('name')
                            ->orderByDesc('total_sold')
                            ->take(3)
                            ->get();

        return view('reports.print', compact('totalRevenue', 'totalCost', 'totalProfit', 'monthName', 'topProducts'));
    }
}
