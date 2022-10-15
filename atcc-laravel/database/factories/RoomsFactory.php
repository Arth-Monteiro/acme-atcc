<?php

namespace Database\Factories;

use App\Models\Floors;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoomsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $floors = Floors::all(['id']);
        $total_floors = count($floors);

        return [
            'name' => $this->faker->name(),
            'is_exit' => $this->faker->boolean(),
            'blueprint' => 'blueprint',
            'floor_id' => $floors[rand(0, $total_floors-1)]
        ];
    }
}
