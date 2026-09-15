<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Membuat admin hanya jika belum ada, sehingga data admin Native tetap aman.
        if (! Admin::where('email', 'admin@gmail.com')->exists()) {
            Admin::create([
                'nama' => 'Administrator',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('admin123'),
            ]);
        }
    }
}
