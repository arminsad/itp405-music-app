<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PlaylistController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\TrackController;
use App\Http\Controllers\AlbumeloController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\SettingsController;
use App\Models\Artist;
use App\Models\Track;
use App\Models\Genre;

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

Route::get('/eloquent', function() {
    //  QUERYING
    
    // return view('eloquent.tracks', [
    //     'tracks' => Track::all(),
    // ]);
    
    // return view('eloquent.artists', [
    //     'artists' => Artist::orderBy('name', 'desc')->get(),
    // ]);

    // return view('eloquent.tracks', [
    //     'tracks' => Track::where('unit_price', '>', 0.99)->orderBy('name')->get(),
    // ]);

    // return view('eloquent.artist', [
    //     'artist' => Artist::find(3),
    // ]);

    // CREATING
    // $genre = new Genre();
    // $genre->name = 'Hip Hop';
    // $genre->save();

    // DELETING
    // $genre = Genre::find(30);
    // $genre->delete();

    //UPDATING
    // $genre = Genre::where('name', '=', 'Alternative and Punk')->first();
    // $genre->name = 'Alternative & Punk';
    // $genre->save();

    //RELATIONSHIPS
    // return view('eloquent.has-many', [
    //     'artist' => Artist::find(50), //Metallica
    // ]);

    // return view('eloquent.belongs-to', [
    //     'album' => Album::find(152), //Master of Puppets
    // ]);

    // EAGER LOADING
    return view('eloquent.eager-loading', [
    //     'tracks' => Track::where('unit_price', '>', 0.99)
    //     ->orderBy('name')
    //     ->limit(5)
    //     ->get(),
    // ]);

    // Fixes the N+1 problem via Eager Loading
        'tracks' => Track::with(['album'])
        ->where('unit_price', '>', 0.99)
        ->orderBy('name')
        ->limit(5)
        ->get(),
    ]);
});

Route::get('/', function () {
    return view('welcome');
});



Route::get('/login', [AuthController::class, 'loginForm'])->name('auth.loginForm');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');


Route::middleware(['custom-auth'])->group(function (){
    Route::middleware(['not-blocked'])->group(function () {
        Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
        Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices.index');
        Route::get('/invoices/{id}', [InvoiceController::class, 'show'])->name('invoices.show');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('auth.logout');
    Route::view('/blocked', 'blocked')->name('blocked');

    Route::middleware(['admin'])->group(function (){
        Route::get('/admin', [SettingsController::class, 'index'])->name('admin');
        Route::post('/admin', [SettingsController::class, 'toggle'])->name('toggle');
    });
});

Route::middleware(['maintenance'])->group(function (){
    Route::get('/playlists', [PlaylistController::class, 'index'])->name('playlists.index');
    Route::get('/playlists/{id}', [PlaylistController::class, 'show'])->name('playlists.show');
    Route::get('/albums', [AlbumController::class, 'index'])->name('album.index');
    Route::get('/albums/create', [AlbumController::class, 'create'])->name('album.create');
    Route::post('/albums', [AlbumController::class, 'store'])->name('album.store');
    Route::get('/albums/{id}/edit', [AlbumController::class, 'edit'])->name('album.edit');
    Route::post('/albums/{id}', [AlbumController::class, 'update'])->name('album.update');

    Route::get('/tracks', [TrackController::class, 'index'])->name('track.index');
    Route::get('/tracks/create', [TrackController::class, 'create'])->name('track.create');
    Route::post('/tracks', [TrackController::class, 'store'])->name('track.store');
    Route::get('/playlists/{id}/edit', [PlaylistController::class, 'edit'])->name('playlists.edit');
    Route::post('/playlists/{id}', [PlaylistController::class, 'update'])->name('playlists.update');

    Route::get('/albumselo', [AlbumeloController::class, 'index'])->name('albumelo.index');
    Route::get('/albumselo/create', [AlbumeloController::class, 'create'])->name('albumelo.create');
    Route::post('/albumselo', [AlbumeloController::class, 'store'])->name('albumelo.store');
    Route::get('/albumselo/{id}/edit', [AlbumeloController::class, 'edit'])->name('albumelo.edit');
    Route::post('/albumselo/{id}', [AlbumeloController::class, 'update'])->name('albumelo.update');

    Route::get('/register', [RegistrationController::class, 'index'])->name('registration.index');
    Route::post('/register', [RegistrationController::class, 'register'])->name('registration.create');
});
Route::view('/maintenance', 'maintenance')->name('maintenance');