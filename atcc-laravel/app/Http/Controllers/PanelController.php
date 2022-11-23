<?php

namespace App\Http\Controllers;

use App\Models\Companies;
use App\Models\Buildings;
use App\Models\Floors;
use App\Models\Rooms;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
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
    public function index(): Renderable
    {
        $where = [];
        if (!!($company_id = Auth::user()->company_id)) {
            $where = ['company_id' => $company_id];
        }

        $buildings = Buildings::where($where)
                        ->whereRaw('exists(select id from floors where building_id = buildings.id)')
                        ->orderBy('name')
                        ->get();

        foreach ($buildings as $building){
            $building->floors = Floors::where(['building_id' => $building->id])->orderBy('order', 'desc')->get();
        }

        return view('home',['buildings' => $buildings]);
    }

    /**
     * Gets the rooms on the selected floor
     *
     * @return JSON
     */
    public function searchRooms(Request $request): JsonResponse
    {
        $rooms = Rooms::where(['floor_id' => $request->floor_id])->orderBy('name')->get();
        return response()->json(['rooms' => $rooms]);
    }

    /**
     * Gets the people inside the selected room
     *
     * @return JSON
     */
    public function searchPeople(Request $request): JsonResponse
    {
        $where_company = '';
        if (!!($company_id = Auth::user()->company_id)) {
            $where_company = "AND tr.company_id = $company_id";
        }

        $people = DB::select("
                SELECT
                    tr.created_at,
                    p.*
                FROM mv_tag_room tr
                JOIN people p ON tr.people_id = p.id
                WHERE tr.room_id = {$request->room_id} $where_company;
        ");;


        return response()->json(['people' => $people]);
    }

    /**
     * Gets the amount of people in each place based on traffic records
     *
     * @return JsonResponse
     */
    public function getCount(): JsonResponse
    {
        $where = '';
        if (!!($company_id = Auth::user()->company_id)) {
            $where = "WHERE tr.company_id = $company_id";
        }

        $tag_room = DB::select("
            SELECT tr.room_id, r.floor_id, f.building_id
            FROM mv_tag_room tr
            LEFT JOIN rooms r ON tr.room_id = r.id
            LEFT JOIN floors f ON r.floor_id = f.id
            LEFT JOIN buildings b ON b.id = f.building_id
            $where
            ORDER BY tr.tag_id, tr.people_id, tr.created_at DESC;
        ");;

        $count = [];
        foreach ($tag_room as $item) {

            if (!empty($item->building_id)) {
                if (isset($count[$item->building_id])) {
                    $count[$item->building_id]['total'] += 1;
                } else {
                    $count[$item->building_id]['total'] = 1;
                }

                if (isset($count[$item->building_id][$item->floor_id])) {
                    $count[$item->building_id][$item->floor_id]['total'] += 1;
                } else {
                    $count[$item->building_id][$item->floor_id]['total'] = 1;
                }

                if (isset($count[$item->building_id][$item->floor_id][$item->room_id])) {
                    $count[$item->building_id][$item->floor_id][$item->room_id]['total'] += 1;
                } else {
                    $count[$item->building_id][$item->floor_id][$item->room_id]['total'] = 1;
                }
            }

        }

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
