<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            [
                'login' => 'secure-100',
                'password' => 'secure2050@!',
                'is_admin' => true
            ]
        );

        User::updateOrCreate(
            [
                'login' => 'secure-200',
                'password' => 'secure2050@!',
                'is_admin' => true
            ]
        );
    }
}
