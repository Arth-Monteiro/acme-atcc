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
        Floors::factory()->count(50)->create();
    }
}
