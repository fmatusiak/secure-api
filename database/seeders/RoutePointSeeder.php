<?php

namespace Database\Seeders;

use App\Models\RoutePoint;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoutePointSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RoutePoint::factory()->count(50)->create();
    }
}
