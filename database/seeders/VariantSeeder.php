<?php

namespace Database\Seeders;

use App\Models\Variant;
use Illuminate\Database\Seeder;

class VariantSeeder extends Seeder
{
    public function run(): void
    {
        $variants = [
            ['name' => 'Regular', 'type' => 'size', 'price_adjustment' => 0, 'is_available' => true],
            ['name' => 'Large', 'type' => 'size', 'price_adjustment' => 5000, 'is_available' => true],
            ['name' => 'Extra Large', 'type' => 'size', 'price_adjustment' => 10000, 'is_available' => true],
            ['name' => 'Hot', 'type' => 'temperature', 'price_adjustment' => 0, 'is_available' => true],
            ['name' => 'Iced', 'type' => 'temperature', 'price_adjustment' => 3000, 'is_available' => true],
            ['name' => 'Normal Sugar', 'type' => 'sweetness', 'price_adjustment' => 0, 'is_available' => true],
            ['name' => 'Less Sugar', 'type' => 'sweetness', 'price_adjustment' => 0, 'is_available' => true],
            ['name' => 'Extra Sugar', 'type' => 'sweetness', 'price_adjustment' => 0, 'is_available' => true],
            ['name' => 'No Sugar', 'type' => 'sweetness', 'price_adjustment' => 0, 'is_available' => true],
        ];

        foreach ($variants as $variant) {
            Variant::create($variant);
        }
    }
}