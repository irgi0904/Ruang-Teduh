<?php

namespace Database\Seeders;

use App\Models\CafeSetting;
use Illuminate\Database\Seeder;

class CafeSettingSeeder extends Seeder
{
    public function run(): void
    {
        CafeSetting::create([
            'cafe_name' => 'Ruang Teduh',
            'cafe_address' => 'Jl. Cerita No. 123, Jakarta Selatan',
            'cafe_phone' => '021-12345678',
            'cafe_email' => 'info@ruangteduh.test',
            'tax_percentage' => 10,
            'currency' => 'IDR',
            'timezone' => 'Asia/Jakarta',
            'business_hours' => json_encode([
                'monday' => ['open' => '08:00', 'close' => '22:00'],
                'tuesday' => ['open' => '08:00', 'close' => '22:00'],
                'wednesday' => ['open' => '08:00', 'close' => '22:00'],
                'thursday' => ['open' => '08:00', 'close' => '22:00'],
                'friday' => ['open' => '08:00', 'close' => '23:00'],
                'saturday' => ['open' => '09:00', 'close' => '23:00'],
                'sunday' => ['open' => '09:00', 'close' => '22:00'],
            ]),
            'is_open' => true,
        ]);
    }
}