<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create an admin user
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'Admin',
            'alamat' => 'Admin Street, Admin City',
            'nomor_hp' => '081234567890',
            'tanggal_lahir' => '1980-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'desa' => null, 
        ]);

        // Create a camat user
        User::create([
            'name' => 'Camat User',
            'email' => 'camat@example.com',
            'password' => bcrypt('password'),
            'role' => 'Camat',
            'alamat' => 'Camat Street, Camat City',
            'nomor_hp' => '081234567891',
            'tanggal_lahir' => '1985-01-01',
            'jenis_kelamin' => 'Laki-laki',
            'desa' => null,
        ]);

        // Create desa users
        $desaNames = ['Cijayana', 'Jagabaya', 'Karangwangi', 'Mekarmukti', 'Mekarsari'];

        foreach ($desaNames as $desa) {
            User::create([
                'name' => "{$desa} User",
                'email' => strtolower("{$desa}@example.com"),
                'password' => bcrypt('password'),
                'role' => 'Desa',
                'alamat' => "{$desa} Street, {$desa} City",
                'nomor_hp' => '081234567892',
                'tanggal_lahir' => '1990-01-01',
                'jenis_kelamin' => 'Laki-laki',
                'desa' => $desa,
            ]);
        }
    }
}
