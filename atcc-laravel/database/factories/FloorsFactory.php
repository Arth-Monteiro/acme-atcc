<?php

namespace Database\Factories;

use App\Models\Buildings;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class FloorsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $buildings = Buildings::all(['id']);
        $building = $buildings[rand(0,  count($buildings)-1)]->id;

        $level = DB::select(DB::raw("
            select f.order
            from floors f
            where f.building_id = $building
            order by f.order desc;
        "));

        $level = empty($level) ? 0 : $level[0]->order + 1;
        $name = $level === 0 ? 'Térreo' : "{$level}º Andar";
        
        return [
            'name' => $name,
            'order' => $level,
            'building_id' =>  $building,
        ];
    }
}
