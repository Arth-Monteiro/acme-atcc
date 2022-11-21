<?php

use App\Http\Controllers\BuildingsController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\CompaniesController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', fn ()  => redirect('/about'));
Route::get('/about', fn () => view('about'));
Route::get('/home', fn ()  => redirect('/panel'));

//*****************************************
//Route for ROLES
Route::controller(RolesController::class)->group(function () {
    Route::get('/roles', 'index')->name('roles_index');
    Route::get('/roles/list', 'searchRoles')->name('roles_list');
    Route::get('/roles/create', 'createForm')->name('roles_view_create');
    Route::get('/roles/{id}', 'editForm')->name('roles_view_edit');

    // POST
    Route::post('/roles', 'create')->name('roles_post');
    Route::post('/roles/{id}', 'update')->name('roles_put');

    // DELETE
    Route::delete('/roles/{id}', 'delete')->name('roles_delete');
});
//*****************************************

//*****************************************
//Route for COMPANIES
Route::controller(CompaniesController::class)->group(function () {
    Route::get('/companies', 'index')->name('companies_index');
    Route::get('/companies/list', 'searchCompanies')->name('companies_list');
    Route::get('/companies/create', 'createForm')->name('companies_view_create');
    Route::get('/companies/{id}', 'editForm')->name('companies_view_edit');

    // POST
    Route::post('/companies', 'create')->name('companies_post');
    Route::post('/companies/{id}', 'update')->name('companies_put');

    // DELETE
    Route::delete('/companies/{id}', 'delete')->name('companies_delete');
});
//*****************************************

//*****************************************
//Route for BUILDINGS
Route::controller(BuildingsController::class)->group(function () {
    Route::get('/buildings', 'index')->name('buildings_index');
    Route::get('/buildings/list', 'searchBuildings')->name('buildings_list');
    Route::get('/buildings/create', 'createBuildingForm')->name('buildings_view_create');
    Route::get('/buildings/{id}', 'editBuildingForm')->name('buildings_view_edit');

    // POST
    Route::post('/buildings', 'createBuilding')->name('buildings_post');
    Route::post('/buildings/{id}', 'updateBuilding')->name('buildings_put');

    // DELETE
    Route::delete('/buildings/{id}', 'deleteBuilding')->name('buildings_delete');


    //*****************************************
    //Route for FLOORS
    $floor_base = '/buildings/{building_id}/floors';
    Route::get($floor_base, 'floorsIndex')->name('floors_index');
    Route::get("$floor_base/list", 'searchFloors')->name('floors_list');
    Route::get("$floor_base/create", 'createFloorForm')->name('floors_view_create');
    Route::get("$floor_base/{id}", 'editFloorForm')->name('floors_view_edit');

    // POST
    Route::post($floor_base, 'createFloor')->name('floors_post');
    Route::post("$floor_base/{id}", 'updateFloor')->name('floors_put');

    // DELETE
    Route::delete("$floor_base/{id}", 'deleteFloor')->name('floors_delete');
    //*****************************************

    //*****************************************
    //Route for ROOMS
    $room_base = '/buildings/{building_id}/floors/{floor_id}/rooms';
    Route::get($room_base, 'roomsIndex')->name('rooms_index');
    Route::get("$room_base/list", 'searchRooms')->name('rooms_list');
    Route::get("$room_base/create", 'createRoomForm')->name('rooms_view_create');
    Route::get("$room_base/{id}", 'editRoomForm')->name('rooms_view_edit');

    // POST
    Route::post($room_base, 'createRoom')->name('rooms_post');
    Route::post("$room_base/{id}", 'updateRoom')->name('rooms_put');

    // DELETE
    Route::delete("$room_base/{id}", 'deleteRoom')->name('rooms_delete');
    //*****************************************
});
//*****************************************

//*****************************************
//Route for COMPANIES
Route::controller(UsersController::class)->group(function () {
    Route::get('/users', 'index')->name('users_index');
    Route::get('/users/list', 'searchUsers')->name('users_list');
    Route::get('/users/create', 'createForm')->name('users_view_create');
    Route::get('/users/{id}', 'editForm')->name('users_view_edit');

    // POST
    Route::post('/users', 'create')->name('users_post');
    Route::post('/users/{id}', 'update')->name('users_put');

    // DELETE
    Route::delete('/users/{id}', 'delete')->name('users_delete');
});
//*****************************************

//*****************************************
//Route for PANEL
Route::controller(PanelController::class)->group(function () {
    Route::get('/panel', 'index')->name('panel_index');
    Route::get('/panel/list', 'searchBuildingInfos')->name('panel_list');
    Route::get('/panel/rooms', 'searchRooms')->name('panel_rooms');
    Route::get('/panel/people', 'searchPeople')->name('panel_people');
    Route::get('/panel/count', 'getCount')->name('panel_count');
});
//*****************************************

//*****************************************
//Route for PEOPLE
Route::controller(PeopleController::class)->group(function () {
    // GET
    Route::get('/people', 'index')->name('people_index');
    Route::get('/people/list', 'searchPeople')->name('people_list');
    Route::get('/people/create', 'createForm')->name('people_view_create');
    Route::get('/people/{id}', 'editForm')->name('people_view_edit');

    // POST
    Route::post('/people', 'create')->name('people_post');
    Route::post('/people/{id}', 'update')->name('people_put');

    // DELETE
    Route::delete('/people/{id}', 'delete')->name('people_delete');


    Route::get('/people/{people_id}/tag/{tag_id}', 'setViewTagForPerson')->name('people_view_tag');
    Route::post('/people/{people_id}/tag/{tag_id}', 'setTagForPerson')->name('people_tag_post');
    Route::delete('/people/{people_id}/tag/{tag_id}', 'removeTagForPerson')->name('people_tag_delete');
});
//*****************************************

//*****************************************
// Route for TAGS
Route::controller(TagsController::class)->group(function () {
    // GET
    Route::get('/tags','index')->name('tags_index');
    Route::get('/tags/list', 'searchTags')->name('tags_list');
    Route::get('/tags/create', 'createForm')->name('tags_view_create');
    Route::get('/tags/{id}', 'editForm')->name('tags_view_edit');

    // POST
    Route::post('/tags', 'create')->name('tags_post');
    Route::post('/tags/{id}', 'update')->name('tags_put');

    // DELETE
    Route::delete('/tags/{id}', 'delete')->name('tags_delete');
});
//*****************************************
