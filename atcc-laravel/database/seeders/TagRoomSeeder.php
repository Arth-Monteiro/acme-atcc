<?php

namespace Database\Seeders;

use App\Models\Companies;
use App\Models\TagRoom;
use App\Models\Tags;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagRoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        TagRoom::factory()->count(rand(1, 20))->create();
    }
}
