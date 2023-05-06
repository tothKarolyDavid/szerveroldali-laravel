<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\GameController;
use App\Http\Controllers\TeamController;
use App\Http\Controllers\LeaderboardController;
use App\Http\Controllers\FavoritesController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\PlayerController;

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

Route::resource('games', GameController::class);

Route::resource('teams', TeamController::class);

Route::resource('leaderboard', LeaderboardController::class);

Route::resource('favorites', FavoritesController::class);

Route::resource('events', EventController::class);

Route::resource('players', PlayerController::class);




Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/', function () {
    return view('home');
})->name('home');


// Route::get('/posts/create', function () {
//     return view('posts.create');
// });

// Route::get('/posts/x', function () {
//     return view('posts.show');
// });

// Route::get('/posts/x/edit', function () {
//     return view('posts.edit');
// });

// // -----------------------------------------

// Route::get('/categories/create', function () {
//     return view('categories.create');
// });

// Route::get('/categories/x', function () {
//     return view('categories.show');
// });

// -----------------------------------------

Auth::routes();
