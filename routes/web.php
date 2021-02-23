<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\TrackController;
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

Route::get('/', function () {
    return view('welcome');
});

// MVC = Model(Data layer/represents data) View(templates/what we present to users i.e. html files with little php) Controlller (glue between data and view/fetching data and passing it to view)

Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoice.index'); //calls index function from InvoiceController class
Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoice.show');

//ITP 405: Project 2
Route::get('/playlists', [PlaylistController::class, 'index'])  //calls index function from InvoiceController class
    ->name('playlist.index');  

Route::get('/playlists/{id}', [PlaylistController::class, 'show'])
    ->name('playlist.show');

//Lecture 2/8/21
//Saying when I visit /albums, it will go to the AlbumController and run a method called index
Route::get('/albums', [AlbumController::class, 'index'])->name('album.index');
Route::get('/albums/create', [AlbumController::class, 'create'])->name('album.create');
Route::post('/albums', [AlbumController::class, 'store'])->name('album.store');

Route::get('/albums/{id}/edit', [AlbumController::class, 'edit'])->name('album.edit');
Route::post('/albums/{id}', [AlbumController::class, 'update'])->name('album.update');

//ITP 405: Project 3 - CRUD
Route::get('/tracks', [TrackController::class, 'index'])->name('track.index');
Route::get('/tracks/new', [TrackController::class, 'new'])->name('track.new');
Route::post('/tracks', [TrackController::class, 'store'])->name('track.store');

Route::get('/playlists/{id}/edit', [PlaylistController::class, 'edit'])->name('playlist.edit');
Route::post('/playlists/{id}', [PlaylistController::class, 'update'])->name('playlist.update');

