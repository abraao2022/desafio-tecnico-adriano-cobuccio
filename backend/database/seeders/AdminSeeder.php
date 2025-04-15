<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Admin;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $adminUser = User::where('type', 'admin')->first();

        if ($adminUser) {
            Admin::create([
                'user_id' => $adminUser->id,
                'role' => 'master',
                'notes' => 'Administrador principal do sistema.',
            ]);
        }
    }
}
