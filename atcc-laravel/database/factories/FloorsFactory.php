<?php

namespace Database\Factories;

use App\Models\Buildings;
use Illuminate\Database\Eloquent\Factories\Factory;

class FloorsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $buildings = Buildings::all(['id']);
        $total_buildings = count($buildings);

        return [
            'name' => $this->faker->name(),
            'order' => $this->faker->numberBetween(0, 10),
            'building_id' =>  $buildings[rand(0,  $total_buildings-1)],
        ];
    }
}
