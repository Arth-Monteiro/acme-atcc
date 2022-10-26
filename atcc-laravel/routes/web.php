<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PanelController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\CompaniesController;
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

Route::get('/home',
    [HomeController::class, 'index']
)->name('home')->middleware('auth');

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
});
//*****************************************

//*****************************************
//Route for PANEL
Route::controller(PanelController::class)->group(function () {
    Route::get('/panel', 'index')->name('panel_index');
    Route::get('/panel/list', 'searchBuildingInfos')->name('panel_list');
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
});
//*****************************************
