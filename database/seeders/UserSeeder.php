<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            "name" => "Administrador",
            "email" => "admin@gmail.com",
            "password" => Hash::make("admin"),
            "role" => "admin",
            "photo" => "https://ui-avatars.com/api/?name=Administrador&color=7F9CF5&background=EBF4FF",
            "status" => "active",
        ]);
    }
}
