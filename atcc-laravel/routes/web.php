<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PeopleController;
use App\Http\Controllers\TagsController;
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
//
//Route::get('/', function () {
//    return view('welcome');
//});

Auth::routes();

Route::get('/', fn ()  => redirect('/about'));
Route::get('/about', fn () => view('about'));

Route::get('/home',
    [HomeController::class, 'index']
)->name('home')->middleware('auth');

//*****************************************
//Route for PEOPLE
Route::get('/people',
    [PeopleController::class, 'index']
)->name('list_people');

Route::get('/people/create',
    [PeopleController::class, 'createForm']
)->name('view_create_person');

Route::get('/people/{id}',
    [PeopleController::class, 'editForm']
)->name('view_edit_person');

Route::post('/people',
    [PeopleController::class, 'create']
)->name('post_person');

Route::post('/people/{id}',
    [PeopleController::class, 'update']
)->name('put_person');
//*****************************************

//*****************************************
// Route for TAGS

Route::get('/tags',
    [TagsController::class, 'index']
)->name('list_tags');

Route::get('/tags/create',
    [TagsController::class, 'createForm']
)->name('view_create_tag');

Route::get('/tags/{id}',
    [TagsController::class, 'editForm']
)->name('view_edit_tag');

Route::post('/tags',
    [TagsController::class, 'create']
)->name('post_tag');

Route::post('/tags/{id}',
    [TagsController::class, 'update']
)->name('put_tag');

//*****************************************
