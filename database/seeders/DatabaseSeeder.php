<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminUserSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(RouteSeeder::class);
        $this->call(RouteUserSeeder::class);
        $this->call(RoutePointSeeder::class);
        $this->call(RouteRoutePointSeeder::class);
        $this->call(GroupSeeder::class);
        $this->call(UserGroupSeeder::class);
    }
}
