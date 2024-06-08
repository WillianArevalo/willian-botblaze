<?php

namespace Database\Seeders;

use App\Models\Movement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MovementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Movement::create([
            "product_id" => 1,
            "typeMovement" => "input",
            "quantity" => 10,
            "description" => "Initial stock",
            "date" => now()
        ]);

        Movement::create([
            "product_id" => 2,
            "typeMovement" => "input",
            "quantity" => 10,
            "description" => "Initial stock",
            "date" => now()
        ]);
    }
}
