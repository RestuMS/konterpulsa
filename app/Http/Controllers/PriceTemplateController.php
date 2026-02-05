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
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'provider' => 'required|string',
            'pattern' => 'required|string',
            'cost_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        PriceTemplate::create($request->all());

        return redirect()->route('price-templates.index')->with('success', 'Template harga berhasil ditambahkan.');
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
            'pattern' => 'required|string',
            'cost_price' => 'required|numeric|min:0',
            'price' => 'required|numeric|min:0',
        ]);

        $priceTemplate->update($request->all());

        return redirect()->route('price-templates.index')->with('success', 'Template harga berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PriceTemplate $priceTemplate)
    {
        $priceTemplate->delete();
        return redirect()->route('price-templates.index')->with('success', 'Template harga berhasil dihapus.');
    }
}
