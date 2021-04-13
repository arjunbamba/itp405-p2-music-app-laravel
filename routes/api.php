<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AlbumController;
use App\Http\Controllers\Api\ArtistController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Lecture 4/05
// This is dedicated file for api routes. web.php s for ui based routes
// Don't need alias here b/c there's only one
// Will autocreate all those routes that point to all of the methods wee generated - based on Laravel standard conventions
// Route resource automatically does Route::get('/api/albums/{album}', [AlbumController::class, 'show']);

Route::resource('albums', AlbumController::class);

// Assignment 9
Route::resource('artists', ArtistController::class);
