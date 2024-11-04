<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'Produk 1',
            'description' => 'Deskripsi Produk 1',
            'price' => 100000,
            'image_url' => 'https://via.placeholder.com/300',
        ]);

        Product::create([
            'name' => 'Produk 2',
            'description' => 'Deskripsi Produk 2',
            'price' => 200000,
            'image_url' => 'https://via.placeholder.com/300',
        ]);
    }
}

