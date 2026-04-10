<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    // Menonaktifkan model events saat seeder berjalan jika menggunakan trait ini, 
    // tapi lebih baik dikomen jika ingin event created() di model tetap jalan (opsional)
    // use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat akun Admin dummy
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password'), 
            'role' => 'admin',
        ]);

        // Membuat akun User/Staff dummy
        User::create([
            'name' => 'User Biasa',
            'email' => 'user@user.com',
            'password' => Hash::make('password'), 
            'role' => 'staff',
        ]);

        // Membuat data kategori dummy
        $elektronik = Category::create([
            'name' => 'Elektronik',
            'division_pj' => 'Tefa',
        ]);

        $alatDapur = Category::create([
            'name' => 'Alat Dapur',
            'division_pj' => 'Sarpras',
        ]);

        // Membuat data barang (items) dummy sesuai referensi
        Item::create([
            'category_id' => $alatDapur->id,
            'name' => 'Piring',
            'total' => 100,
            'repair' => 0,
            'lending' => 0,
        ]);

        Item::create([
            'category_id' => $elektronik->id,
            'name' => 'Komputer',
            'total' => 130,
            'repair' => 0,
            'lending' => 0,
        ]);

        Item::create([
            'category_id' => $elektronik->id,
            'name' => 'Laptop',
            'total' => 210,
            'repair' => 0,
            'lending' => 0,
        ]);

        Item::create([
            'category_id' => $alatDapur->id,
            'name' => 'Gelas',
            'total' => 89,
            'repair' => 0,
            'lending' => 0,
        ]);
        
        // (Opsional) Membuat 10 user random dengan factory
        // User::factory(10)->create();
    }
}
