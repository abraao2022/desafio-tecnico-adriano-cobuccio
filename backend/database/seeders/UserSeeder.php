<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Cria 5 usuários comuns
        User::factory()->count(5)->create([
            'type' => 'customer',
        ]);

        User::create([
            'name' => 'Customer Master',
            'email' => 'customer@adrianocobuccio.com',
            'password' => Hash::make('customer123'),
            'cpf' => '11111111111',
            'type' => 'customer',
        ]);

        // Cria 1 admin fixo
        User::create([
            'name' => 'Admin Master',
            'email' => 'admin@carteira.com',
            'password' => Hash::make('admin123'),
            'cpf' => '00000000000',
            'type' => 'admin',
        ]);
    }
}
