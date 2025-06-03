<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthController;

// Rotas Públicas
Route::get('/', function () {
    return view('games.index'); 
});

// Autenticação
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout'); // Mudei para GET

// Rotas Protegidas
Route::middleware(['auth'])->group(function () {
    // Platforms
    Route::resource('platforms', PlatformController::class)->except(['index', 'show']);
    Route::get('/platforms/create', [PlatformController::class, 'create'])->name('platforms.create');
    
    // Genres
    Route::resource('genres', GenreController::class)->except(['index', 'show']);
    
    // Games
    Route::resource('games', GameController::class)->except(['index', 'show']);
});

// Rotas Públicas (index)
Route::get('/platforms', [PlatformController::class, 'indexView'])->name('platforms.index');
Route::get('/genres', [GenreController::class, 'indexView'])->name('genres.index');
Route::get('/games', [GameController::class, 'indexView'])->name('games.index');

// Reviews
Route::get('/reviews', function () {
    return view('reviews.index');
});