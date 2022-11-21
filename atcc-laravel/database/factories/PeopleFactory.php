<?php

namespace Database\Factories;

use App\Models\Buildings;
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

        $companies = DB::select(DB::raw('
            select c.id as id, b.id as building_id
            from companies c
            join tags t on c.id = t.company_id
            join buildings b on c.id = b.company_id
        '));

        $company = $companies[rand(0, count($companies) -1)];
        $company_id = $company->id;
        $building_id = $company->building_id;

        $tags = DB::select(DB::raw("
            select t.id
            from tags t
            left join people p on t.id = p.tag_id
            where t.company_id = $company_id and p.tag_id isnull;
        "));

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
            'tag_id' => $tags[rand(0, $total_tags-1)]->id ?? null,
            'company_id' => $company_id,
            'building_id' => $building_id,
            'update_by' => $name,
        ];
    }
}
