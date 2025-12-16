<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
       
        $adminRole = Role::where('name', 'admin')->first();
        $kasirRole = Role::where('name', 'kasir')->first();
        $penggunaRole = Role::where('name', 'pengguna')->first();

       
        User::create([
            'name' => 'Admin Ruang Teduh',
            'email' => 'admin@mail.com', 
            'password' => Hash::make('password'), 
            'role_id' => $adminRole->id, 
            'phone' => '08123456789',
            'address' => 'Kantor Pusat',
        ]);
        
      
        User::create([
            'name' => 'Kasir Ruang Teduh',
            'email' => 'kasir@mail.com',
            'password' => Hash::make('password'),
            'role_id' => $kasirRole->id, 
            'phone' => '08987654321',
            'address' => 'Meja Kasir Utama',
        ]);
        
    
        User::create([
            'name' => 'Pelanggan Biasa',
            'email' => 'user@mail.com',
            'password' => Hash::make('password'), 
            'role_id' => $penggunaRole->id, 
            'phone' => '08555555555',
            'address' => 'Rumah Pelanggan',
        ]);
    }
}