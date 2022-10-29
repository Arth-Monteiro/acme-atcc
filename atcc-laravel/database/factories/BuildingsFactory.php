<?php

namespace Database\Factories;

use App\Models\Companies;
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
            'company_id' => Companies::inRandomOrder()->first(['id']),
        ];
    }
}
