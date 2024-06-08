<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::create([
            "id" => 1,
            "name" => "Producto 1",
            "description" => "Descripción del producto 1",
            "price" => 1000,
            "image" => "producto1.jpg",
            "stockInitial" => 10,
            "stockCurrent" => 10,
            "status" => "in_stock",
        ]);


        Product::create([
            "id" => 2,
            "name" => "Producto 2",
            "description" => "Descripción del producto 2",
            "price" => 500,
            "image" => "producto2.png",
            "stockInitial" => 10,
            "stockCurrent" => 10,
            "status" => "in_stock",
        ]);
    }
}
