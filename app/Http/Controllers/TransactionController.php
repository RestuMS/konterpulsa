<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\TransactionDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transactions = Transaction::with('user')->latest()->paginate(10);
        return view('transactions.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource (POS System).
     */
    public function create()
    {
        $products = Product::where('stock', '>', 0)->get();
        return view('transactions.create', compact('products'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Handle "Single Item" manual entry (from Tambah Transaksi form)
        if ($request->has('product_id') || $request->has('custom_price') || $request->has('custom_product_name')) {
            $cartItem = [
                'id' => $request->product_id, // Can be null
                'qty' => 1,
                'custom_name' => $request->custom_product_name, // Capture the typed name
            ];

            if ($request->has('custom_price')) {
               $cartItem['custom_price'] = $request->custom_price;
            }

            $request->merge([
                'cart' => [$cartItem],
                'payment_method' => $request->payment_method ?? 'cash', 
            ]);
        }

        $request->validate([
            'payment_method' => 'required|string',
            'cart' => 'required|array|min:1',
            'cart.*.id' => 'nullable|exists:products,id', // Make ID nullable
            'cart.*.qty' => 'required|integer|min:1',
            'customer_phone' => 'nullable|string',
            'customer_name' => 'nullable|string',
            'status' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $totalAmount = 0;
            $details = [];

            foreach ($request->cart as $item) {
                $productId = $item['id'] ?? null;
                $customName = $item['custom_name'] ?? 'Custom Item';
                $qty = $item['qty'];
                
                // Determine price and name
                $price = 0;
                $productName = $customName;

                if ($productId) {
                    $product = Product::lockForUpdate()->find($productId);
                    if ($product->stock < $qty) {
                        throw new \Exception("Stock not sufficient for {$product->name}");
                    }
                    // Use custom price if provided, else product price
                    $price = isset($item['custom_price']) ? $item['custom_price'] : $product->price;
                    $productName = $product->name;
                    
                    // Deduct Stock
                    $product->stock -= $qty;
                    $product->save();
                } else {
                    // Custom Item (No Product ID)
                    $price = $item['custom_price'] ?? 0;
                }

                $subtotal = $price * $qty;
                $totalAmount += $subtotal;

                $details[] = [
                    'product_id' => $productId,
                    'product_name' => $productName,
                    'quantity' => $qty,
                    'price' => $price,
                ];
            }

            // Create Transaction
            $transaction = Transaction::create([
                'invoice_number' => 'TRX-' . strtoupper(Str::random(10)),
                'user_id' => auth()->id(),
                'customer_phone' => $request->customer_phone,
                'customer_name' => $request->customer_name,
                'total_amount' => $totalAmount,
                'payment_method' => $request->payment_method,
                'status' => $request->status ?? 'completed',
                'payment_status' => $request->payment_status ?? 'paid',
                'notes' => $request->notes,
            ]);

            // Create Details
            foreach ($details as $detail) {
                $transaction->details()->create($detail);
            }

            DB::commit();

            if ($request->ajax()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Transaction successful!',
                    'redirect' => route('transactions.index') // Redirect to Dashboard Transaksi (Index)
                ]);
            }

            // Standard redirect for manual form -> Dashboard Transaksi
            return redirect()->route('transactions.index')->with('success', 'Transaksi Berhasil!');

        } catch (\Exception $e) {
            DB::rollBack();
            if ($request->ajax()) {
                return response()->json(['success' => false, 'message' => $e->getMessage()], 400);
            }
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $transaction = Transaction::with(['details.product', 'user'])->findOrFail($id);
        return view('transactions.show', compact('transaction'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Display a listing of unpaid transactions (Kasbon).
     */
    public function unpaid()
    {
        $transactions = Transaction::with('user')
            ->where('payment_status', 'unpaid')
            ->latest()
            ->paginate(10);
            
        return view('transactions.unpaid', compact('transactions'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $transaction = Transaction::findOrFail($id);
        $transaction->delete();
        
        return redirect()->route('transactions.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
