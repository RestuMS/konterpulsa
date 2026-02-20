<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::latest();

        // Filter by category
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Filter by month/year
        $month = $request->input('month', now()->month);
        $year = $request->input('year', now()->year);
        $query->whereMonth('created_at', $month)->whereYear('created_at', $year);

        $expenses = $query->paginate(15);

        // Summary for current filter
        $totalExpense = Expense::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->sum('amount');

        $expenseByCategory = Expense::whereMonth('created_at', $month)
            ->whereYear('created_at', $year)
            ->selectRaw('category, SUM(amount) as total, COUNT(*) as count')
            ->groupBy('category')
            ->orderByDesc('total')
            ->get();

        $categories = Expense::categories();

        return view('expenses.index', compact(
            'expenses', 'totalExpense', 'expenseByCategory', 'categories', 'month', 'year'
        ));
    }

    public function create()
    {
        $categories = Expense::categories();
        return view('expenses.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'amount' => 'required',
            'description' => 'nullable|string|max:1000',
            'created_at' => 'nullable|date',
        ]);

        $amount = (int) str_replace(['.', ',', 'Rp', ' '], '', $request->amount);

        Expense::create([
            'title' => $request->title,
            'category' => $request->category,
            'amount' => $amount,
            'description' => $request->description,
            'user_id' => auth()->id(),
            'created_at' => $request->created_at ?? now(),
        ]);

        // Clear cache agar Dashboard/Laporan langsung update laba
        Cache::flush();

        return redirect()->route('expenses.index')
            ->with('success', 'Pengeluaran berhasil ditambahkan!')
            ->with('action', 'store');
    }

    public function edit(Expense $expense)
    {
        $categories = Expense::categories();
        return view('expenses.edit', compact('expense', 'categories'));
    }

    public function update(Request $request, Expense $expense)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'required|string|max:100',
            'amount' => 'required',
            'description' => 'nullable|string|max:1000',
            'created_at' => 'nullable|date',
        ]);

        $amount = (int) str_replace(['.', ',', 'Rp', ' '], '', $request->amount);

        $expense->update([
            'title' => $request->title,
            'category' => $request->category,
            'amount' => $amount,
            'description' => $request->description,
            'created_at' => $request->created_at ?? $expense->created_at,
        ]);

        // Clear cache agar Dashboard/Laporan langsung update laba
        Cache::flush();

        return redirect()->route('expenses.index')
            ->with('success', 'Pengeluaran berhasil diperbarui!')
            ->with('action', 'update');
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();

        // Clear cache agar Dashboard/Laporan langsung update laba
        Cache::flush();

        return redirect()->route('expenses.index')
            ->with('success', 'Pengeluaran berhasil dihapus!')
            ->with('action', 'delete');
    }
}
