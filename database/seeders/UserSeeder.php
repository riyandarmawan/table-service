<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();

        $user->create([
            'name' => 'Administrator',
            'username' => 'administrator',
            // 'email' => 'administrator@gmail.com',
            'password' => Hash::make('administrator'),
            'role' => 'administrator',
        ]);

        $user->create([
            'name' => 'Kasir',
            'username' => 'kasir',
            // 'email' => 'kasir@gmail.com',
            'password' => Hash::make('kasir'),
            'role' => 'kasir',
        ]);

        $user->create([
            'name' => 'Waiter',
            'username' => 'waiter',
            // 'email' => 'waiter@gmail.com',
            'password' => Hash::make('waiter'),
            'role' => 'waiter',
        ]);

        $user->create([
            'name' => 'Owner',
            'username' => 'owner',
            // 'email' => 'owner@gmail.com',
            'password' => Hash::make('owner'),
            'role' => 'owner',
        ]);
    }
}
