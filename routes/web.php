<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MessageController;

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

Route::get('/oldhome', function () {
    return view('welcome');
});


//NEW HOME
Route::get('/', [HomeController::class, 'index']);
//Route::get('/', 'HomeController@index');


///// MESSAGES 
Route::post('/create', [MessageController::class, 'create']);
Route::get('/message/{id}', [MessageController::class, 'view']);


Route::get('/greeting', function () {
    return 'Hello World';
});

Route::get('/sql-count', [TestController::class, 'countAll']);

Route::get('/sql-select', [TestController::class, 'getSql']);



///// TABLE EDIT ROUTES O={======>

Route::get('/table', [TestController::class, 'getTable']);
Route::post('label/{labelid}/change', [TestController::class, 'changeLabel']);
Route::post('label/{labelid}/insert', [TestController::class, 'insertLabel']);
Route::post('label/{labelid}/update', [TestController::class, 'updateLabel']);
Route::post('label/{labelid}/delete', [TestController::class, 'deleteLabel']);


Route::get('/game', function () {
    return view('game');
});

//Route::get('/new-game', 'App\Http\Controllers\GameController@generateNumber');
Route::post('/new-game', [\App\Http\Controllers\GameController::class, 'newGame']);

Route::get('/check/{guess}', [\App\Http\Controllers\GameController::class, 'checkNumber']);

Route::get('/give-up', [\App\Http\Controllers\GameController::class, 'giveUp']);

Route::get('/edit-name/{name}', [\App\Http\Controllers\GameController::class, 'editName']);

Route::get('/get-top/{category}', [\App\Http\Controllers\GameController::class, 'getTop']);

