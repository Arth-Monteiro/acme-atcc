<?php

namespace Database\Seeders;

use App\Models\Rooms;
use Illuminate\Database\Seeder;

class RoomsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Rooms::factory()->count(50)->create();
    }
}
