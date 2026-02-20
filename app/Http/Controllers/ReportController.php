<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Product;
use App\Models\Expense;
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

            // Total pengeluaran operasional
            $totalExpense = Expense::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->sum('amount');

            // Laba = (Pemasukan - Modal) - Pengeluaran Operasional
            $totalProfit = $totalRevenue - $totalCost - $totalExpense;

            return compact('chartLabels', 'chartDatasets', 'totalRevenue', 'totalCost', 'totalExpense', 'totalProfit');
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

        // Total pengeluaran operasional
        $totalExpense = Expense::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->sum('amount');

        // Laba = (Pemasukan - Modal) - Pengeluaran Operasional
        $totalProfit = $totalRevenue - $totalCost - $totalExpense;

        $monthName = Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y');

        $topProducts = Product::whereMonth('created_at', $month)
                            ->whereYear('created_at', $year)
                            ->select('name', DB::raw('sum(quantity) as total_sold'))
                            ->groupBy('name')
                            ->orderByDesc('total_sold')
                            ->take(3)
                            ->get();

        return view('reports.print', compact('totalRevenue', 'totalCost', 'totalExpense', 'totalProfit', 'monthName', 'topProducts'));
    }

    /**
     * Monthly Comparison Report
     * Compares selected month vs previous month
     */
    public function comparison(Request $request)
    {
        $month = (int) $request->input('month', now()->month);
        $year = (int) $request->input('year', now()->year);

        // Calculate previous month/year
        $prevDate = Carbon::createFromDate($year, $month, 1)->subMonth();
        $prevMonth = $prevDate->month;
        $prevYear = $prevDate->year;

        $cacheKey = "comparison_{$year}_{$month}_" . now()->format('Y-m-d-H');

        $comparisonData = Cache::remember($cacheKey, 300, function () use ($month, $year, $prevMonth, $prevYear) {

            // ---- CURRENT MONTH TOTALS ----
            $currentTotals = Product::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->selectRaw('COALESCE(SUM(price), 0) as total_revenue, COALESCE(SUM(cost_price), 0) as total_cost, COUNT(*) as total_items')
                ->first();

            // ---- PREVIOUS MONTH TOTALS ----
            $prevTotals = Product::whereMonth('created_at', $prevMonth)
                ->whereYear('created_at', $prevYear)
                ->selectRaw('COALESCE(SUM(price), 0) as total_revenue, COALESCE(SUM(cost_price), 0) as total_cost, COUNT(*) as total_items')
                ->first();

            $currentRevenue = $currentTotals->total_revenue;
            $currentCost = $currentTotals->total_cost;
            $currentItems = $currentTotals->total_items;

            // Pengeluaran operasional bulan ini
            $currentExpense = Expense::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->sum('amount');
            $currentProfit = $currentRevenue - $currentCost - $currentExpense;

            $prevRevenue = $prevTotals->total_revenue;
            $prevCost = $prevTotals->total_cost;
            $prevItems = $prevTotals->total_items;

            // Pengeluaran operasional bulan lalu
            $prevExpense = Expense::whereMonth('created_at', $prevMonth)
                ->whereYear('created_at', $prevYear)
                ->sum('amount');
            $prevProfit = $prevRevenue - $prevCost - $prevExpense;

            // Percentage changes
            $revenueChange = $prevRevenue > 0 ? round((($currentRevenue - $prevRevenue) / $prevRevenue) * 100, 1) : ($currentRevenue > 0 ? 100 : 0);
            $costChange = $prevCost > 0 ? round((($currentCost - $prevCost) / $prevCost) * 100, 1) : ($currentCost > 0 ? 100 : 0);
            $profitChange = $prevProfit > 0 ? round((($currentProfit - $prevProfit) / $prevProfit) * 100, 1) : ($currentProfit > 0 ? 100 : 0);
            $itemsChange = $prevItems > 0 ? round((($currentItems - $prevItems) / $prevItems) * 100, 1) : ($currentItems > 0 ? 100 : 0);

            // ---- DAILY DATA FOR LINE CHART ----
            $daysInCurrentMonth = Carbon::createFromDate($year, $month, 1)->daysInMonth;
            $daysInPrevMonth = Carbon::createFromDate($prevYear, $prevMonth, 1)->daysInMonth;
            $maxDays = max($daysInCurrentMonth, $daysInPrevMonth);

            // Current month daily
            $currentDaily = Product::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->selectRaw('DAY(created_at) as day, COALESCE(SUM(price), 0) as revenue, COALESCE(SUM(cost_price), 0) as cost')
                ->groupBy(DB::raw('DAY(created_at)'))
                ->get()
                ->keyBy('day');

            // Previous month daily
            $prevDaily = Product::whereMonth('created_at', $prevMonth)
                ->whereYear('created_at', $prevYear)
                ->selectRaw('DAY(created_at) as day, COALESCE(SUM(price), 0) as revenue, COALESCE(SUM(cost_price), 0) as cost')
                ->groupBy(DB::raw('DAY(created_at)'))
                ->get()
                ->keyBy('day');

            $lineLabels = range(1, $maxDays);
            $currentRevenueDaily = [];
            $prevRevenueDaily = [];
            $currentProfitDaily = [];
            $prevProfitDaily = [];

            for ($d = 1; $d <= $maxDays; $d++) {
                $cr = isset($currentDaily[$d]) ? $currentDaily[$d]->revenue : 0;
                $cc = isset($currentDaily[$d]) ? $currentDaily[$d]->cost : 0;
                $pr = isset($prevDaily[$d]) ? $prevDaily[$d]->revenue : 0;
                $pc = isset($prevDaily[$d]) ? $prevDaily[$d]->cost : 0;

                $currentRevenueDaily[] = $cr;
                $prevRevenueDaily[] = $pr;
                $currentProfitDaily[] = $cr - $cc;
                $prevProfitDaily[] = $pr - $pc;
            }

            // ---- CATEGORY BREAKDOWN FOR BAR CHART ----
            $targetCategories = ['Pulsa', 'Paket Data', 'Kartu Perdana', 'Voucher'];
            $categories = \App\Models\Category::whereIn('name', $targetCategories)->get();

            $currentCategoryData = Product::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->whereIn('category_id', $categories->pluck('id'))
                ->selectRaw('category_id, COALESCE(SUM(price), 0) as revenue')
                ->groupBy('category_id')
                ->get()
                ->keyBy('category_id');

            $prevCategoryData = Product::whereMonth('created_at', $prevMonth)
                ->whereYear('created_at', $prevYear)
                ->whereIn('category_id', $categories->pluck('id'))
                ->selectRaw('category_id, COALESCE(SUM(price), 0) as revenue')
                ->groupBy('category_id')
                ->get()
                ->keyBy('category_id');

            $categoryLabels = [];
            $currentCategoryRevenue = [];
            $prevCategoryRevenue = [];
            foreach ($categories as $cat) {
                $categoryLabels[] = $cat->name;
                $currentCategoryRevenue[] = isset($currentCategoryData[$cat->id]) ? $currentCategoryData[$cat->id]->revenue : 0;
                $prevCategoryRevenue[] = isset($prevCategoryData[$cat->id]) ? $prevCategoryData[$cat->id]->revenue : 0;
            }

            // ---- TOP PRODUCTS COMPARISON ----
            $currentTopProducts = Product::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->select('name', DB::raw('SUM(quantity) as total_qty'), DB::raw('SUM(price - COALESCE(cost_price, 0)) as total_profit'))
                ->groupBy('name')
                ->orderByDesc('total_qty')
                ->take(5)
                ->get();

            return compact(
                'currentRevenue', 'currentCost', 'currentProfit', 'currentItems',
                'prevRevenue', 'prevCost', 'prevProfit', 'prevItems',
                'revenueChange', 'costChange', 'profitChange', 'itemsChange',
                'lineLabels', 'currentRevenueDaily', 'prevRevenueDaily',
                'currentProfitDaily', 'prevProfitDaily',
                'categoryLabels', 'currentCategoryRevenue', 'prevCategoryRevenue',
                'currentTopProducts'
            );
        });

        $currentMonthName = Carbon::createFromDate($year, $month, 1)->translatedFormat('F Y');
        $prevMonthName = Carbon::createFromDate($year, $month, 1)->subMonth()->translatedFormat('F Y');

        return view('reports.comparison', array_merge(
            ['month' => $month, 'year' => $year, 'currentMonthName' => $currentMonthName, 'prevMonthName' => $prevMonthName],
            $comparisonData
        ));
    }
}
