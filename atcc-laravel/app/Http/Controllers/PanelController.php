<?php

namespace App\Http\Controllers;

use App\Models\Buildings;
use App\Models\Floors;
use App\Models\Rooms;
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
        return view('panel.index');
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
