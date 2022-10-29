<?php

namespace Database\Factories;

use App\Models\Companies;
use App\Models\Tags;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $status = Tags::STATUS;
        $sub_status = Tags::SUB_STATUS;
        $access_level = Tags::ACCESS_LEVEL;

        return [
            'code' => $this->faker->uuid(),
            'status' => $status[rand(0, count($status) -1)],
            'sub_status' => $sub_status[rand(0, count($sub_status) -1)],
            'access_level' => $access_level[rand(0, count($access_level) -1)],
            'company_id' => Companies::inRandomOrder()->first(['id']),
        ];
    }
}
