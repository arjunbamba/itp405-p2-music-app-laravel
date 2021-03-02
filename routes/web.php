<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\EloquentAlbumController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;

use App\Models\Artist;
use App\Models\Track;
use App\Models\Genre;
use App\Models\Album;
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

//ITP 405: Project 5 - ORM w/ Eloquent
Route::get('/eloquent/albums', [EloquentAlbumController::class, 'index'])->name('eloquent_album.index');
Route::get('/eloquent/albums/create', [EloquentAlbumController::class, 'create'])->name('eloquent_album.create');
Route::post('/eloquent/albums', [EloquentAlbumController::class, 'store'])->name('eloquent_album.store');

Route::get('/eloquent/albums/{id}/edit', [EloquentAlbumController::class, 'edit'])->name('eloquent_album.edit');
Route::post('/eloquent/albums/{id}', [EloquentAlbumController::class, 'update'])->name('eloquent_album.update');


//ITP 405: Project 3 - CRUD
Route::get('/tracks', [TrackController::class, 'index'])->name('track.index');
Route::get('/tracks/new', [TrackController::class, 'new'])->name('track.new');
Route::post('/tracks', [TrackController::class, 'store'])->name('track.store');

Route::get('/playlists/{id}/edit', [PlaylistController::class, 'edit'])->name('playlist.edit');
Route::post('/playlists/{id}', [PlaylistController::class, 'update'])->name('playlist.update');

//Lecture 02/22/21: ORM
Route::get('eloquent', function() {
    // QUERYING
    // Artist::all();

    // return view('eloquent.tracks', [
    //     'tracks' => Track::all(), //inline querying - fetching
    // ]);

    // return view('eloquent.artists', [
    //     // 'artists' => Artist::all(), //inline querying - fetching
    //     'artists' => Artist::orderBy('name', 'desc')->get(), //asc is default if no 2nd arg
    // ]);

    // return view('eloquent.tracks', [
    //     //if you have conditions, use get
    //     'tracks' => Track::where('unit_price', '>', 0.99)->orderBy('name')->get(),
    // ]);

    //find single artist
    // return view('eloquent.artist', [
    //     'artist' => Artist::find(3),
    // ]);

    // CREATING
    //instance of model class corresponds to single row in db table
    // $genre = new Genre();
    // $genre->name = 'Hip Hop';
    // $genre->save(); 

    // DELETING
    // $genre = Genre::find(26);
    // $genre->delete();

    // UPDATING
    // $genre = Genre::where('name', '=', 'Alternative and Punk')->first();
    // $genre->name = 'Alternative & Punk';
    // $genre->save();

    // RELATIONSHIPS
    // return view('eloquent.has-many', [
    //     'artist' => Artist::find(50), // Metallica
    // ]);

    // return view('eloquent.belongs-to', [
    //     'album' => Album::find(152), // Master of Puppets
    // ]);

    // EAGER LOADING
    return view('eloquent.eager-loading', [
        // Has the N+1 problem
        // 'tracks' => Track::where('unit_price', '>', 0.99)
        //     ->orderBy('name')
        //     ->limit(5)
        //     ->get(),
        
        //Fixes the N+1 problem via Eager Loading
        'tracks' => Track::with('album')
            ->where('unit_price', '>', 0.99)
            ->orderBy('name')
            ->limit(5)
            ->get(),
    ]);

});

