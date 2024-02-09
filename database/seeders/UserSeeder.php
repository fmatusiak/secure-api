<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'login' => 'user-100',
                'password' => 'user2050@!',
                'is_admin' => false
            ]
        );

        User::updateOrCreate(
            [
                'login' => 'user-200',
                'password' => 'user2050@!',
                'is_admin' => false
            ]
        );

        User::updateOrCreate(
            [
                'login' => 'user-300',
                'password' => 'user2050@!',
                'is_admin' => false
            ]
        );
    }
}
