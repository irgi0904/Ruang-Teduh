<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CafeSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'cafe_name',
        'cafe_logo',
        'cafe_address',
        'cafe_phone',
        'cafe_email',
        'tax_percentage',
        'currency',
        'timezone',
        'business_hours',
        'is_open',
    ];

    protected $casts = [
        'tax_percentage' => 'decimal:2',
        'business_hours' => 'json', 
        'is_open' => 'boolean',
    ];

    public static function getSettings()
    {
        return static::first() ?? static::create([
            'cafe_name' => 'Ruang Teduh',
            'cafe_address' => 'Jl. Cerita No. 123, Jakarta',
            'cafe_phone' => '021-12345678',
            'cafe_email' => 'info@ruangteduh.test',
            'tax_percentage' => 10,
            'currency' => 'IDR',
            'timezone' => 'Asia/Jakarta',
            'is_open' => true,
        ]);
    }
}