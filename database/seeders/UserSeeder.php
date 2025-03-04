<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Josias Bueno',
            'email' => 'josias@email.com',
            'password' => bcrypt('123456'),
            'plan' => 'free',
            'role' => 'admin',
            'fidelity' => 0,
            'remaining_hints' => 0,
            'remaining_errors' => 0,
        ]);
    }
}
