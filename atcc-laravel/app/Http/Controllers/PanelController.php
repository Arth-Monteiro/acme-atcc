<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Buildings;
use App\Models\Floors;
use App\Models\Rooms;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;

class PanelController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        $buildings = Buildings::all();

        foreach ($buildings as $building){
            $building->floors = Floors::where(['building_id' => $building->id])->orderBy('level', 'desc')->get();
        }

        return view('home',['buildings' => $buildings]);
    }

    /**
     * Gets the rooms on the selected floor
     *
     * @return JSON
     */
    public function searchRooms(Request $request)
    {
        $rooms = Rooms::where(['floor_id' => $request->floor_id])->orderBy('name')->get();
        return response()->json(['rooms' => $rooms]);
    }

    /**
     * Gets the people inside the selected room
     *
     * @return JSON
     */
    public function searchPeople(Request $request)
    {
        $people = DB::table('tag_room')
                      ->join('people', 'tag_room.tag_id', '=', 'people.tag_id')
                      ->select('tag_room.created_at', 'people.*')
                      ->where(['tag_room.room_id' => $request->room_id])
                      ->get();
        return response()->json(['people' => $people]);
    }

    /**
     * Gets the amount of people in each place based on traffic records
     *
     * @return JSON
     */
    public function getCount(){
        $count = DB::table('tag_room')
                      ->join('rooms', 'tag_room.room_id', '=', 'rooms.id')
                      ->join('floors', 'rooms.floor_id', '=', 'floors.id')
                      ->select('tag_room.room_id', 'rooms.floor_id', 'floors.building_id')
                      ->get();
        return response()->json(['count' => $count]);
    }

    public function searchBuildingInfos()
    {
        $buildings = Buildings::paginate(15, ['id', 'name']);
        
        foreach ($buildings as $building){
            $floors = Floors::where(['building_id' => $building->id])->get();

            foreach ($floors as $floor) {
                $floor->rooms =  Rooms::where(['floor_id' => $floor->id])->get();
            }

            $building->floors = $floors;
        }

        return response()->json(['buildings' => $buildings ]);
    }
}
