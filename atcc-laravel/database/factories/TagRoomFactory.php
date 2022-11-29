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
        $building_check = "
            select distinct company_id
            from buildings b
            join floors f on b.id = f.building_id
            join rooms r on f.id = r.floor_id
        ";

        $company = DB::table('companies')
                    ->whereRaw('id IN (SELECT company_id FROM people WHERE company_id IS NOT NULL)')
                    ->whereRaw("id IN ($building_check)")
                    ->inRandomOrder()
                    ->first(['id']);


        $people = People::where(['company_id' => $company->id])
                        ->whereNotNull('tag_id')
                        ->inRandomOrder()
                        ->first(['id', 'tag_id', 'building_id']);


        $room = DB::table('rooms')
                    ->join('floors', 'rooms.floor_id', '=', 'floors.id')
                    ->where(['building_id' => $people->building_id])
                    ->inRandomOrder()->first(['rooms.id']);


        return [
            'tag_id' => $people->tag_id,
            'room_id' => $room->id ?? null,
            'people_id' => $people->id,
        ];
    }
}
