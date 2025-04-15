<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::where('type', 'customer')->get();

        foreach ($users as $user) {
            Customer::create([
                'user_id' => $user->id,
                'balance' => rand(1000, 5000) / 100,
                'phone_number' => fake()->phoneNumber(),
                'blocked' => false,
            ]);
        }

        Customer::create([
            'user_id' => 6,
            'balance' => 1000,
            'phone_number' => '123456789',
            'blocked' => false,
        ]);
    }
}
