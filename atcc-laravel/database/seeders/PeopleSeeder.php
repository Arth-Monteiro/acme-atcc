<?php

namespace Database\Seeders;

use App\Models\People;
use Illuminate\Database\Seeder;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($c=1; $c <= rand(2, 10); $c++) {
            People::factory()->create();
        }

    }
}
