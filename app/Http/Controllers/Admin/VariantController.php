<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Variant;
use Illuminate\Http\Request;

class VariantController extends Controller
{
    public function index()
    {
        $variants = Variant::latest()->paginate(15);
        return view('admin.variants.index', compact('variants'));
    }

    public function create()
    {
        return view('admin.variants.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:size,temperature,sweetness',
            'price_adjustment' => 'required|numeric',
            'is_available' => 'boolean',
        ]);

        Variant::create($validated);

        return redirect()->route('admin.variants.index')
            ->with('success', 'Varian berhasil ditambahkan');
    }

    public function edit(Variant $variant)
    {
        return view('admin.variants.edit', compact('variant'));
    }

    public function update(Request $request, Variant $variant)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:size,temperature,sweetness',
            'price_adjustment' => 'required|numeric',
            'is_available' => 'boolean',
        ]);

        $variant->update($validated);

        return redirect()->route('admin.variants.index')
            ->with('success', 'Varian berhasil diperbarui');
    }

    public function destroy(Variant $variant)
    {
        $variant->delete();

        return redirect()->route('admin.variants.index')
            ->with('success', 'Varian berhasil dihapus');
    }
}