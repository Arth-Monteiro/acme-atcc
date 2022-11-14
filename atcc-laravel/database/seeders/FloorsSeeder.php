<?php

namespace Database\Seeders;

use App\Models\Floors;
use Illuminate\Database\Seeder;

class FloorsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($c=1; $c <= 50; $c++) {
            Floors::factory()->create();
        }
    }
}
