<?php

namespace Database\Factories;

use App\Models\People;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class TagRoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $company = DB::table('companies as c')
                    ->join('buildings as b', 'c.id', '=', 'b.company_id')
                    ->whereRaw('b.id in (select building_id from people where building_id is not null)')
                    ->whereRaw("b.id in (select building_id from floors f join rooms r on f.id = r.floor_id)")
                    ->inRandomOrder()
                    ->first(['c.id as id', 'b.id as building_id']);


        $people = People::where(['company_id' => $company->id])
                        ->whereNotNull('tag_id')
                        ->inRandomOrder()
                        ->first(['id', 'tag_id', 'building_id']);


        $room = DB::table('rooms')
                    ->join('floors', 'rooms.floor_id', '=', 'floors.id')
                    ->where(['building_id' => $company->building_id])
                    ->inRandomOrder()->first(['rooms.id']);


        return [
            'tag_id' => $people->tag_id,
            'room_id' => $room->id ?? null,
            'people_id' => $people->id,
        ];
    }
}
