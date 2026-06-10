<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@nutricycle.com'],
            [
                'name' => 'Admin NutriCycle',
                'phone' => '081200000001',
                'alamat' => 'Kantor NutriCycle',
                'password' => Hash::make('password'),
                'role' => User::ROLE_ADMIN,
                'poin' => 0,
            ],
        );
    }
}
