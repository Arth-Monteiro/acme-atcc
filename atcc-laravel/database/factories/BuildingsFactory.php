<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class BuildingsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => 'Bd. ' . $this->faker->name(),
        ];
    }
}
