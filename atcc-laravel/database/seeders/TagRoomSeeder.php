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
        $possible = DB::select(DB::raw('
            select
                t.id as tag_id,
                r.id as room_id
            from tags t
            join buildings b on t.company_id = b.company_id
            join floors f on b.id = f.building_id
            join rooms r on f.id = r.floor_id;
        '));

        foreach ($possible as $pos) {
            TagRoom::create([
                'tag_id' => $pos->tag_id,
                'room_id' => $pos->room_id,
            ]);
        }
    }
}
