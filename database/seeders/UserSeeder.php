<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            ['name' => 'Rani Pratama', 'email' => 'rani@example.com', 'phone' => '081200000101', 'alamat' => 'Jl. Melati No. 12, Bandung', 'poin' => 120],
            ['name' => 'Bima Santoso', 'email' => 'bima@example.com', 'phone' => '081200000102', 'alamat' => 'Jl. Kenanga No. 8, Bandung', 'poin' => 80],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [
                    'name' => $user['name'],
                    'phone' => $user['phone'],
                    'alamat' => $user['alamat'],
                    'password' => Hash::make('password'),
                    'role' => User::ROLE_USER,
                    'poin' => $user['poin'],
                ],
            );
        }
    }
}
