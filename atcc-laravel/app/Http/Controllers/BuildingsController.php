<?php

namespace App\Http\Controllers;

use App\Models\Buildings;
use App\Models\Companies;
use App\Models\Floors;
use App\Models\Rooms;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class BuildingsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth', 'role.permission']);
    }

    /**
     * Show the grid of people.
     *
     * @return Renderable
     */
    public function index(): Renderable
    {
        return view('buildings.index');
    }

    public function floorsIndex(int $building_id): Renderable
    {
        return view('buildings.floors.index', compact('building_id'));
    }

    public function roomsIndex(int $building_id, int $floor_id): Renderable
    {
        return view('buildings.floors.rooms.index', compact('building_id'), compact('floor_id'));
    }

    public function searchBuildings(): JsonResponse
    {
        $buildings = Buildings::orderBy('name')->paginate(15, ['id', 'name', 'company_id']);

        $html = '';
        foreach ($buildings as $building) {
            $building->company_name = Companies::find($building->company_id)->fantasy_name;
            $html .= view('buildings.card', compact('building'));
        }

        return response()->json(['html' => $html, 'next' => $buildings]);
    }

    public function searchFloors(int $building_id, Request $request): JsonResponse
    {
        $floors = Floors::where(['building_id' => $building_id])
            ->orderBy('order')
            ->paginate(15, ['id', 'name', 'order']);

        $html = '';
        foreach ($floors as $floor) {
            $html .= view('buildings.floors.card', compact('floor'), compact('building_id'));
        }

        return response()->json(['html' => $html, 'next' => $floors]);
    }

    public function searchRooms(int $building_id, int $floor_id, Request $request): JsonResponse
    {
        $rooms = Rooms::where(['floor_id' => $floor_id])
            ->orderBy('name')
            ->paginate(15, ['id', 'name', 'is_exit']);

        $html = '';
        foreach ($rooms as $room) {
            $html .= view('buildings.floors.rooms.card', [
                'building_id' => $building_id,
                'floor_id' => $floor_id,
                'room' => $room
            ]);
        }

        return response()->json(['html' => $html, 'next' => $rooms]);
    }

    /**
     * Show the form to create tag.
     *
     * @return Renderable
     */
    public function createBuildingForm(): Renderable
    {
        $companies = $this->getCompaniesPerUser();
        return view('form.building', compact('companies'));
    }

    public function createFloorForm(int $building_id): Renderable
    {
        return view('form.floor', compact('building_id'));
    }

    public function createRoomForm(int $building_id, int $floor_id): Renderable
    {
        return view('form.room', compact('building_id'), compact('floor_id'));
    }
    /**
     * Show the form to edit person.
     *
     * @return Renderable
     */
    public function editBuildingForm(int $id): Renderable | RedirectResponse
    {
        $building = Buildings::find($id);
        $companies = $this->getCompaniesPerUser();

        if ($building) {
            return view('form.building', [
                'building' => $building,
                'companies' => $companies,
            ]);
        }

        return redirect(route('buildings_view_edit', compact('companies')));
    }

    /**
     * Show the form to edit person.
     *
     * @return Renderable
     */
    public function editFloorForm(int $building_id, int $id): Renderable | RedirectResponse
    {
        $floor = Floors::find($id);

        if ($floor) {
            return view('form.floor', compact('floor'), compact('building_id'));
        }

        return redirect(route('floors_view_edit', compact('building_id')));
    }

    /**
     * Show the form to edit person.
     *
     * @return Renderable
     */
    public function editRoomForm(int $building_id, int $floor_id, int $id): Renderable | RedirectResponse
    {
        $room = Rooms::find($id);

        if ($room) {
            return view('form.room', [
                'building_id' => $building_id,
                'floor_id' => $floor_id,
                'room' => $room
            ]);
        }

        return redirect(route('rooms_view_edit', ['building_id' => $building_id, 'floor_id' => $floor_id]));
    }

    protected function getCompaniesPerUser()
    {
        $companies = [];
        if (!(Auth::user()->company_id)) {
            $companies = Companies::orderBy('fantasy_name')->get(['id', 'fantasy_name']);
        }
        return $companies;
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function createBuilding(Request $request): RedirectResponse
    {

        if ($request->validate(Buildings::validator())) {

            Buildings::create($request->all());
            return redirect(route('buildings_index'));
        }
    }

    public function createFloor(Request $request): RedirectResponse
    {
        $request->merge([
            'building_id' => $request->building_id,
        ]);

        if ($request->validate(Floors::validator($request))) {
            Floors::create($request->all());
            return redirect(route('floors_index', ['building_id' => $request->building_id]));
        }
    }

    public function createRoom(Request $request): RedirectResponse
    {
        $request->merge([
            'floor_id' => $request->floor_id,
            'is_exit' => !!$request->is_exit,
        ]);

        if ($request->validate(Rooms::validator())) {
            Rooms::create($request->all());
            return redirect(route('rooms_index', [
                'building_id' => $request->building_id,
                'floor_id' => $request->floor_id,
            ]));
        }
    }

    /**
     * Edit a user instance after a valid registration.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateBuilding(Request $request): RedirectResponse
    {
        $id = $request->id;

        $validators = Buildings::validator();

        if (isset($id) && is_numeric($id) && $request->validate($validators)) {

            $building = Buildings::find($id);
            $building->update($request->all());

            return redirect(route('buildings_index'));
        }
    }

    /**
     * Edit a user instance after a valid registration.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateFloor(Request $request): RedirectResponse
    {
        $id = $request->id;

        $request->merge([
            'building_id' => $request->building_id,
        ]);

        $validators = Floors::validator($request);

        if (isset($id) && is_numeric($id) && $request->validate($validators)) {

            $floor = Floors::find($id);
            $floor->update($request->all());

            return redirect(route('floors_index', ['building_id' => $request->building_id]));
        }
    }

    /**
     * Edit a user instance after a valid registration.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateRoom(Request $request): RedirectResponse
    {
        $id = $request->id;

        $request->merge([
            'floor_id' => $request->floor_id,
            'is_exit' => !!$request->is_exit,
        ]);

        $validators = Rooms::validator();

        if (isset($id) && is_numeric($id) && $request->validate($validators)) {

            $room = Rooms::find($id);
            $room->update($request->all());

            return redirect(route('rooms_index', [
                'building_id' => $request->building_id,
                'floor_id' => $request->floor_id
            ]));
        }
    }

    /**
     * Delete a role instance.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteBuilding(Request $request): JsonResponse
    {
        $id = $request->id;

        if (Buildings::find($id)->delete()) {
            return response()->json(['location' => route('buildings_index')]);
        }
    }

    /**
     * Delete a role instance.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteFloor(Request $request): JsonResponse
    {
        $id = $request->id;

        if (Floors::find($id)->delete()) {
            return response()->json(['location' => route('floors_index', ['building_id' => $request->building_id])]);
        }
    }

    /**
     * Delete a role instance.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteRoom(Request $request): JsonResponse
    {
        $id = $request->id;

        if (Rooms::find($id)->delete()) {
            return response()->json(['location' => route('rooms_index', [
                'building_id' => $request->building_id,
                'floor_id' => $request->floor_id
            ])]);
        }
    }
}
