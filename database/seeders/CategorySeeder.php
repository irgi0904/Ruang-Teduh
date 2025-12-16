<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Kopi Signature',
                'slug' => 'kopi-signature',
                'description' => 'Kopi spesial dengan cerita di setiap tegukan',
                'icon' => '☕',
                'is_active' => true,
            ],
            [
                'name' => 'Non Coffee',
                'slug' => 'non-coffee',
                'description' => 'Minuman hangat tanpa kafein',
                'icon' => '🍵',
                'is_active' => true,
            ],
            [
                'name' => 'Makanan Ringan',
                'slug' => 'makanan-ringan',
                'description' => 'Camilan untuk menemani ceritamu',
                'icon' => '🍰',
                'is_active' => true,
            ],
            [
                'name' => 'Minuman Dingin',
                'slug' => 'minuman-dingin',
                'description' => 'Kesegaran di setiap momen',
                'icon' => '🧋',
                'is_active' => true,
            ],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}