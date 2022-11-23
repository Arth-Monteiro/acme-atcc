<?php

namespace Database\Factories;

use App\Models\Companies;
use App\Models\People;
use App\Models\Tags;
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
        $company = DB::table('companies')
                    ->whereRaw('id IN (SELECT company_id FROM people WHERE company_id IS NOT NULL)')
                    ->inRandomOrder()
                    ->first(['id']);

        $people = People::where(['company_id' => $company->id])
                        ->whereRaw('tag_id is not null')
                        ->inRandomOrder()
                        ->first(['id', 'tag_id']);

        $room = DB::table('rooms')
                    ->join('floors', 'rooms.floor_id', '=', 'floors.id')
                    ->join('buildings', 'floors.building_id', '=', 'buildings.id')
                    ->inRandomOrder()->first(['rooms.id']);

        return [
            'tag_id' => $people->tag_id,
            'room_id' => $room->id,
            'people_id' => $people->id,
        ];
    }
}
