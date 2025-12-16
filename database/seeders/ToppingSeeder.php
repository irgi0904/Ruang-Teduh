<?php

namespace Database\Seeders;

use App\Models\Topping;
use Illuminate\Database\Seeder;

class ToppingSeeder extends Seeder
{
    public function run(): void
    {
        $toppings = [
            ['name' => 'Extra Shot Espresso', 'price' => 8000, 'is_available' => true],
            ['name' => 'Whipped Cream', 'price' => 5000, 'is_available' => true],
            ['name' => 'Caramel Sauce', 'price' => 5000, 'is_available' => true],
            ['name' => 'Chocolate Sauce', 'price' => 5000, 'is_available' => true],
            ['name' => 'Vanilla Syrup', 'price' => 5000, 'is_available' => true],
            ['name' => 'Hazelnut Syrup', 'price' => 5000, 'is_available' => true],
            ['name' => 'Extra Cheese Foam', 'price' => 7000, 'is_available' => true],
            ['name' => 'Brown Sugar Boba', 'price' => 8000, 'is_available' => true],
            ['name' => 'Jelly Rainbow', 'price' => 5000, 'is_available' => true],
            ['name' => 'Oreo Crumble', 'price' => 6000, 'is_available' => true],
        ];

        foreach ($toppings as $topping) {
            Topping::create($topping);
        }
    }
}