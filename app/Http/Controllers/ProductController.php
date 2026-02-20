<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Product::with('category')->latest();

        // Search Filter
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('code', 'like', '%' . $search . '%')
                  ->orWhere('name', 'like', '%' . $search . '%');
            });
        }

        // Date Filter
        if ($request->has('date') && $request->date != '') {
            $query->whereDate('created_at', $request->date);
        }

        // Clone query for totals to match the filtered results
        $totalsQuery = clone $query;
        $totalCost = $totalsQuery->sum('cost_price');
        $totalRevenue = $totalsQuery->sum('price');
        $totalProfit = $totalRevenue - $totalCost;

        $products = $query->paginate(10);
        $totalProducts = $totalsQuery->sum('quantity');

        return view('products.index', compact('products', 'totalCost', 'totalRevenue', 'totalProfit', 'totalProducts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Category::all();
        $priceTemplates = \App\Models\PriceTemplate::all();
        return view('products.create', compact('categories', 'priceTemplates'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Check if this is a Bulk Request (items array exists)
        if ($request->has('items') && is_array($request->items)) {
            
            $request->validate([
                'items' => 'required|array|min:1',
                'items.*.name' => 'required|string|max:255',
                'items.*.code' => 'required|string',
                'items.*.category_id' => 'required|exists:categories,id',
                'items.*.price' => 'required',
                'items.*.cost_price' => 'nullable',
                'items.*.stock' => 'required|integer|min:0',
                'items.*.quantity' => 'nullable|integer|min:1',
                'items.*.payment_status' => 'required|in:paid,unpaid',
                'items.*.customer_name' => 'nullable|string|max:255',
                'items.*.created_at' => 'nullable|date',
            ]);

            $createdCount = 0;

            \Illuminate\Support\Facades\DB::transaction(function () use ($request, &$createdCount) {
                foreach ($request->items as $item) {
                    // Sanitize currency inputs
                    $price = isset($item['price']) ? str_replace(['.', ','], ['', '.'], $item['price']) : 0;
                    $costPrice = isset($item['cost_price']) ? str_replace(['.', ','], ['', '.'], $item['cost_price']) : 0;

                    $data = [
                        'name' => $item['name'],
                        'code' => $item['code'],
                        'category_id' => $item['category_id'],
                        'price' => $price, // Initial unit price
                        'cost_price' => $costPrice, // Initial unit cost
                        'stock' => $item['stock'],
                        'payment_status' => $item['payment_status'],
                        'customer_name' => $item['customer_name'] ?? null,
                    ];

                    // Handle Qty & Totals
                    $quantity = (int) ($item['quantity'] ?? 1);
                    $data['quantity'] = $quantity;

                    if ($quantity > 1) {
                        $data['price'] = $price * $quantity;
                        $data['cost_price'] = $costPrice * $quantity;
                    }

                    // Handle Date
                    if (!empty($item['created_at'])) {
                        $data['created_at'] = $item['created_at'] . ' ' . now()->format('H:i:s');
                    }

                    Product::create($data);
                    $createdCount++;
                }
            });

            return redirect()->route('products.index')->with('success', $createdCount . ' Transaksi berhasil ditambahkan!');
        }

        // 2. Fallback to Single Item Logic (Existing)
        // Sanitize: remove thousand separators (.) and convert comma (,) to dot (.)
        $price = $request->filled('price') ? str_replace(['.', ','], ['', '.'], $request->price) : 0;
        $costPrice = $request->filled('cost_price') ? str_replace(['.', ','], ['', '.'], $request->cost_price) : 0;

        $request->merge([
            'price' => $price,
            'cost_price' => $costPrice,
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'quantity' => 'nullable|integer|min:1',
            'payment_status' => 'required|in:paid,unpaid',
            'customer_name' => 'nullable|string|max:255',
            'created_at' => 'nullable|date',
        ]);

        $data = $request->all();
        
        // Handle Quantity Logic
        // If quantity is provided and greater than 1, multiply the unit prices to store TOTALS
        $quantity = (int) $request->input('quantity', 1); // Ensure integer
        $data['quantity'] = $quantity;

        // The inputs 'price' and 'cost_price' are considered UNIT prices from the form.
        // We calculate the total stored value for reports.
        if ($quantity > 1) {
            $data['price'] = $price * $quantity;
            $data['cost_price'] = $costPrice * $quantity;
        }

        // If a custom date is provided, ensure it includes the current time or defaults
        if ($request->has('created_at') && $request->created_at != null) {
             $data['created_at'] = $request->created_at . ' ' . now()->format('H:i:s');
        }

        Product::create($data);

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $product = Product::with('category')->findOrFail($id);
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $product = Product::findOrFail($id);

        // Sanitize: remove thousand separators (.) and convert comma (,) to dot (.)
        $price = $request->filled('price') ? str_replace(['.', ','], ['', '.'], $request->price) : 0;
        $costPrice = $request->filled('cost_price') ? str_replace(['.', ','], ['', '.'], $request->cost_price) : 0;

        $request->merge([
            'price' => $price,
            'cost_price' => $costPrice,
        ]);

        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string',
            'category_id' => 'required|exists:categories,id',
            'price' => 'required|numeric|min:0',
            'cost_price' => 'nullable|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'payment_status' => 'required|in:paid,unpaid',
            'customer_name' => 'nullable|string|max:255',
        ]);

        $data = $request->all();

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $product = Product::findOrFail($id);
        
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product deleted successfully.');
    }
}
