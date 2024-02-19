<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Route;
use App\Models\RoutePoint;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RouteRoutePointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $routes = Route::inRandomOrder()->take(50)->get();
        $points = RoutePoint::inRandomOrder()->take(50)->get();

        foreach ($routes as $route) {

            $order = 1;
            foreach ($points as $point) {
                $route->routePoints()->attach($point, ['order' => $order]);
                $order++;
            }
        }
    }
}
