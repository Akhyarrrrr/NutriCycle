<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class PetugasSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'petugas@nutricycle.com'],
            [
                'name' => 'Petugas NutriCycle',
                'phone' => '081200000002',
                'alamat' => 'Depo NutriCycle',
                'password' => Hash::make('password'),
                'role' => User::ROLE_PETUGAS,
                'poin' => 0,
            ],
        );
    }
}
