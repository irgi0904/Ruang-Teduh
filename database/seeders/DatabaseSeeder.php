<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            CategorySeeder::class,
            ProductSeeder::class,
            ToppingSeeder::class,
            VariantSeeder::class,
            ProductRelationSeeder::class,
            CafeSettingSeeder::class,
        ]);
    }
}