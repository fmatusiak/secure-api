<?php

namespace Database\Factories;

use App\Models\RoutePoint;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoutePointFactory extends Factory
{
    protected $model = RoutePoint::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->word(),
            'latitude' => $this->faker->latitude,
            'longitude' => $this->faker->longitude,
        ];
    }
}
