<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Route;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RouteUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $routes = Route::inRandomOrder()->take(50)->get();
        $users = User::inRandomOrder()->take(10)->get();

        foreach ($routes as $route) {
            $route->users()->attach($users);
        }
    }
}
