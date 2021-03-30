<?php

use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\EloquentAlbumController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\TrackController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

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

// MVC = Model(Data layer/represents data) View(templates/what we present to users i.e. html files with little php) Controlller (glue between data and view/fetching data and passing it to view)

Route::get('/', function () {
    return view('welcome');
});

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

Route::get('/login', [AuthController::class, 'loginForm'])->name('auth.loginForm'); // LECTURE 03/01/21
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');    // LECTURE 03/01/21
Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');

Route::view('/maintenance', 'maintenance')->name('maintenance');

Route::middleware(['admin-maintenance'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::post('/admin', [AdminController::class, 'update'])->name('admin.update');
});

Route::middleware(['custom-auth'])->group(function() {

    // LECTURE 03/15/21: WK 9 MIGRATIONS P2, MASS ASSIGNMENT, MIDDLEWARE
    Route::middleware(['not-blocked'])->group(function() {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index'); // Lecture 03/01
        Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoice.index'); //calls index function from InvoiceController class
        Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoice.show');
    });
    
    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout'); // Lecture 03/01
    Route::view('/blocked', 'blocked')->name('blocked');
    Route::get('/eloquent/albums/create', [EloquentAlbumController::class, 'create'])->name('eloquent_album.create');
    Route::get('/eloquent/albums/{id}/edit', [EloquentAlbumController::class, 'edit'])->name('eloquent_album.edit');

});

//ITP 405: Project 6 - Migrations/Middleware
Route::middleware(['maintenance-mode'])->group(function() {
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoice.index'); //calls index function from InvoiceController class
    Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoice.show');

    //ITP 405: Project 2
    Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlist.index');  //calls index function from InvoiceController class  
    Route::get('/playlists/{id}', [PlaylistController::class, 'show'])->name('playlist.show');

    //ITP 405: Project 3 - CRUD
    Route::get('/tracks', [TrackController::class, 'index'])->name('track.index');
    Route::get('/tracks/new', [TrackController::class, 'new'])->name('track.new');
    Route::post('/tracks', [TrackController::class, 'store'])->name('track.store');

    Route::get('/playlists/{id}/edit', [PlaylistController::class, 'edit'])->name('playlist.edit');
    Route::post('/playlists/{id}', [PlaylistController::class, 'update'])->name('playlist.update');

    //Lecture 2/8/21
    //Saying when I visit /albums, it will go to the AlbumController and run a method called index
    Route::get('/albums', [AlbumController::class, 'index'])->name('album.index');
    Route::get('/albums/create', [AlbumController::class, 'create'])->name('album.create');
    Route::post('/albums', [AlbumController::class, 'store'])->name('album.store');

    Route::get('/albums/{id}/edit', [AlbumController::class, 'edit'])->name('album.edit');
    Route::post('/albums/{id}', [AlbumController::class, 'update'])->name('album.update');

    //ITP 405: Project 5 - ORM w/ Eloquent
    Route::get('/eloquent/albums', [EloquentAlbumController::class, 'index'])->name('eloquent_album.index');
    //Route::get('/eloquent/albums/create', [EloquentAlbumController::class, 'create'])->name('eloquent_album.create');
    Route::post('/eloquent/albums', [EloquentAlbumController::class, 'store'])->name('eloquent_album.store');

    //Route::get('/eloquent/albums/{id}/edit', [EloquentAlbumController::class, 'edit'])->name('eloquent_album.edit');
    Route::post('/eloquent/albums/{id}', [EloquentAlbumController::class, 'update'])->name('eloquent_album.update');

    // LECTURE 03/01/21: Migrations/authentications - stopped at 00:37:50
    // Auth class methods learned: Auth::user (ProfileController), Auth::check() (view main.blade), Auth::login($user) (RegistrationController), Auth::logout() (AuthController)
    // Protect routes using Middleware; 
    // Middleware: functions that run before our route, classes with a handle method that runs before a set of routes
    Route::get('/register', [RegistrationController::class, 'index'])->name('registration.index');
    Route::post('/register', [RegistrationController::class, 'register'])->name('registration.create');

});

if (env('APP_ENV') !== 'local') {
    URL::forceScheme('https');
}

// In general, route::..() = we create a URL, map it to a controller that returns a view
