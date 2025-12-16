<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Topping;
use Illuminate\Http\Request;

class ToppingController extends Controller
{
    public function index()
    {
        $toppings = Topping::latest()->paginate(15);
        return view('admin.toppings.index', compact('toppings'));
    }

    public function create()
    {
        return view('admin.toppings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'is_available' => 'boolean',
        ]);

        Topping::create($validated);

        return redirect()->route('admin.toppings.index')
            ->with('success', 'Topping berhasil ditambahkan');
    }

    public function edit(Topping $topping)
    {
        return view('admin.toppings.edit', compact('topping'));
    }

    public function update(Request $request, Topping $topping)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'is_available' => 'boolean',
        ]);

        $topping->update($validated);

        return redirect()->route('admin.toppings.index')
            ->with('success', 'Topping berhasil diperbarui');
    }

    public function destroy(Topping $topping)
    {
        $topping->delete();

        return redirect()->route('admin.toppings.index')
            ->with('success', 'Topping berhasil dihapus');
    }
}