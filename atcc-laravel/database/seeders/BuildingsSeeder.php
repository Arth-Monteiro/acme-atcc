<?php

namespace Database\Seeders;

use App\Models\Buildings;
use Illuminate\Database\Seeder;

class BuildingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Buildings::factory()->count(50)->create();
    }
}
