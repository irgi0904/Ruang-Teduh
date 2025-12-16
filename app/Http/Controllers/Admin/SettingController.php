<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CafeSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = CafeSetting::getSettings();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'cafe_name' => 'required|string|max:255',
            'cafe_address' => 'nullable|string',
            'cafe_phone' => 'nullable|string|max:20',
            'cafe_email' => 'nullable|email|max:255',
            'tax_percentage' => 'required|numeric|min:0|max:100',
            'currency' => 'required|string|max:10',
            'is_open' => 'boolean',
        ]);

        $settings = CafeSetting::first();
        
        if ($settings) {
            $settings->update($validated);
        } else {
            CafeSetting::create($validated);
        }

        return back()->with('success', 'Pengaturan berhasil diperbarui');
    }
}