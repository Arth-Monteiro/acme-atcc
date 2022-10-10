<?php

namespace Database\Factories;

use App\Models\People;
use App\Models\Tags;
use Illuminate\Database\Eloquent\Factories\Factory;

class PeopleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $qualification = People::QUALIFICATION;
        $blood_type = People::BLOOD_TYPES;

        $name = $this->faker->name();

        return [
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName(),
            'cpf' => preg_replace('/[+-.()\s]/', '', $this->faker->phoneNumber()),
            'email' => substr($this->faker->email(), 0, 20),
            'cellphone'=> preg_replace('/[+-.()\s]/', '', $this->faker->phoneNumber()),
            'blood_type' =>$blood_type[rand(0, count($blood_type) -1)],
            'emergency_contact' => preg_replace('/[+-.()\s]/', '', $this->faker->phoneNumber()),
            'company' => $this->faker->company(),
            'job_title' => substr($this->faker->jobTitle(), 0, 20),
            'qualification' => $qualification[rand(0, count($qualification) -1)],
            'insert_by' => $name,
            'tag_id' => $this->faker->unique()->numberBetween(1, Tags::count()),
            'update_by' => $name,
        ];
    }
}
