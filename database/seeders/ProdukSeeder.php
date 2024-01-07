<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProdukSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // $imagePath = storage_path('app/public/image_produk/');
        // File::copy(database_path('path/to/your/image.jpg'), $imagePath . '088822334455.jpg');

        DB::table('produk')->insert([
            'name_produk'=>'Baju Pria',
            'price'=>'499000',
            'desc'=>'Baju Pria Usia 18 Tahun Keatas',
            'image'=>'image_produk/produk.png',
        ]);
    }
}
