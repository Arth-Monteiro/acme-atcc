<?php

namespace Database\Factories;

use App\Models\Companies;
use App\Models\People;
use App\Models\Tags;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

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

        $tags= DB::select(DB::raw('
            select t.id
            from tags t
            left join people p on t.id = p.tag_id
            where p.tag_id isnull
        '));

        $total_tags = count($tags);

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
            'tag_id' => $tags[rand(0, $total_tags-1)]->id,
            'company_id' => Companies::inRandomOrder()->first(['id']),
            'update_by' => $name,
        ];
    }
}
