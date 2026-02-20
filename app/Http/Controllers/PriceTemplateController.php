<?php

namespace App\Http\Controllers;

use App\Models\PriceTemplate;
use Illuminate\Http\Request;

class PriceTemplateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $templates = PriceTemplate::orderBy('provider')->orderBy('pattern')->get();
        return view('price_templates.index', compact('templates'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('price_templates.create');
    }

    /**
     * Store a newly created resource in storage (supports bulk).
     */
    public function store(Request $request)
    {
        $request->validate([
            'provider' => 'required|string',
            'category' => 'required|string',
            'items' => 'required|array|min:1',
            'items.*.pattern' => 'required|string',
            'items.*.cost_price' => 'required|numeric|min:0',
            'items.*.price' => 'required|numeric|min:0',
        ]);

        $provider = $request->provider;
        $category = $request->category;
        $items = $request->items;

        $saved = 0;
        $duplicates = [];

        foreach ($items as $item) {
            // Skip empty patterns
            if (empty(trim($item['pattern']))) continue;

            // Cek duplikat
            $exists = PriceTemplate::where('provider', $provider)
                ->where('pattern', $item['pattern'])
                ->exists();

            if ($exists) {
                $duplicates[] = $item['pattern'];
                continue;
            }

            PriceTemplate::create([
                'provider' => $provider,
                'category' => $category,
                'pattern' => $item['pattern'],
                'cost_price' => $item['cost_price'],
                'price' => $item['price'],
            ]);
            $saved++;
        }

        if ($saved === 0 && count($duplicates) > 0) {
            return redirect()->back()
                ->withInput()
                ->with('duplicate', 'Semua produk sudah ada: ' . implode(', ', $duplicates));
        }

        $msg = $saved . ' template harga berhasil ditambahkan!';
        if (count($duplicates) > 0) {
            $msg .= ' (' . count($duplicates) . ' dilewati karena sudah ada: ' . implode(', ', $duplicates) . ')';
        }

        return redirect()->route('price-templates.index')->with('success', $msg)->with('action', 'store');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PriceTemplate $priceTemplate)
    {
        return view('price_templates.edit', compact('priceTemplate'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PriceTemplate $priceTemplate)
    {
        $request->validate([
            'provider' => 'required|string',
            'category' => 'required|string',
            'pattern' => 'required|string',
            'cost_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        // Cek duplikat: provider + pattern yang sama (kecuali record ini sendiri)
        $exists = PriceTemplate::where('provider', $request->provider)
            ->where('pattern', $request->pattern)
            ->where('id', '!=', $priceTemplate->id)
            ->exists();

        if ($exists) {
            return redirect()->back()
                ->withInput()
                ->with('duplicate', 'Template harga untuk "' . $request->provider . ' - ' . $request->pattern . '" sudah ada di data lain!');
        }

        $priceTemplate->update($request->all());

        return redirect()->route('price-templates.index')->with('success', 'Template harga berhasil diperbarui!')->with('action', 'update');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PriceTemplate $priceTemplate)
    {
        $priceTemplate->delete();
        return redirect()->route('price-templates.index')->with('success', 'Template harga berhasil dihapus!')->with('action', 'delete');
    }
}
