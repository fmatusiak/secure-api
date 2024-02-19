<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::inRandomOrder()->take(10)->get();
        $groups = Group::inRandomOrder()->take(50)->get();

        foreach ($groups as $group) {
            $group->users()->attach($users);
        }
    }
}
