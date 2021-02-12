<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PlaylistController;
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



