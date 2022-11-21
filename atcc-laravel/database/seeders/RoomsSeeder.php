<?php

namespace Database\Seeders;

use App\Models\Floors;
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
        $floors = Floors::all(['id']);

        $rooms = [
            [
                'name' => 'Recepção',
                'blueprint' => '<rect x="26" y="26" width="150" height="100"/><text x="101" y="70" dominant-baseline="middle" text-anchor="middle">{room_name}</text><text x="101" y="90" dominant-baseline="middle" text-anchor="middle">{room_count}</text>'
            ],
            [
                'name' => 'Sala de Descanso',
                'blueprint' => '<rect x="178" y="26" width="120" height="100"/><text x="238" y="70" dominant-baseline="middle" text-anchor="middle">{room_name}</text><text x="238" y="90" dominant-baseline="middle" text-anchor="middle">{room_count}</text>'
            ],
            [
                'name' => 'Copa',
                'blueprint' => '<rect x="300" y="26" width="75" height="100"/><text x="337" y="70" dominant-baseline="middle" text-anchor="middle">{room_name}</text><text x="337" y="90" dominant-baseline="middle" text-anchor="middle">{room_count}</text>'
            ],
            [
                'name' => 'Escritório 1',
                'blueprint' => '<rect x="26" y="128" width="100" height="100"/><text x="76" y="170" dominant-baseline="middle" text-anchor="middle">{room_name}</text><text x="76" y="190" dominant-baseline="middle" text-anchor="middle">{room_count}</text>'
            ],
            [
                'name' => 'Escritório 2',
                'blueprint' => '<rect x="26" y="230" width="100" height="100"/><text x="76" y="270" dominant-baseline="middle" text-anchor="middle">{room_name}</text><text x="76" y="290" dominant-baseline="middle" text-anchor="middle">{room_count}</text>'
            ],
            [
                'name' => 'Sala de Reunião',
                'blueprint' => '<rect x="190" y="230" width="185" height="100"/><text x="282.5" y="270" dominant-baseline="middle" text-anchor="middle">{room_name}</text><text x="282.5" y="290" dominant-baseline="middle" text-anchor="middle">{room_count}</text>'
            ],
            [
                'name' => 'Espaço Compartilhado',
                'blueprint' => '<polygon points="128,128 375,128 375,228 188,228 188,330 128,330 128,128"/><text x="251.5" y="170" dominant-baseline="middle" text-anchor="middle">{room_name}</text><text x="251.5" y="190" dominant-baseline="middle" text-anchor="middle">{room_count}</text>'
            ]
        ];

        foreach ($floors as $floor) {
            foreach ($rooms as $room) {
                Rooms::create(
                    $room + [
                        'floor_id' => $floor->id,
                        'is_exit' => ($room['name'] === 'Recepção'),
                    ]
                );
            }
        }
    }
}
