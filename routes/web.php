<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GameController;
use App\Http\Controllers\PlatformController;
use App\Http\Controllers\GenreController;
use App\Http\Controllers\AuthController;

// Página inicial
Route::get('/', [GameController::class, 'indexView'])->name('home');

// Rotas de visualização públicas (para as views Blade)
Route::get('/games/view', [GameController::class, 'indexView'])->name('games.index');
Route::get('/platforms/view', [PlatformController::class, 'indexView'])->name('platforms.index');
Route::get('/genres/view', [GenreController::class, 'indexView'])->name('genres.index');

// Rotas de API públicas (somente leitura e criação)
Route::resource('games', GameController::class)->only(['index', 'store', 'show', 'create', 'edit']);
Route::resource('platforms', PlatformController::class)->only(['index', 'store', 'show', 'create', 'edit']);
Route::resource('genres', GenreController::class)->only(['index', 'store', 'show', 'create', 'edit']);

// Rotas de autenticação
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rotas protegidas por autenticação (ações sensíveis)
Route::middleware('auth')->group(function () {
    Route::put('/games/{game}', [GameController::class, 'update'])->name('games.update');
    Route::delete('/games/{game}', [GameController::class, 'destroy'])->name('games.destroy');

    Route::post('/platforms', [PlatformController::class, 'store'])->name('platforms.store');
    Route::put('/platforms/{platform}', [PlatformController::class, 'update'])->name('platforms.update');
    Route::delete('/platforms/{platform}', [PlatformController::class, 'destroy'])->name('platforms.destroy');

    Route::post('/genres', [GenreController::class, 'store'])->name('genres.store');
    Route::put('/genres/{genre}', [GenreController::class, 'update'])->name('genres.update');
    Route::delete('/genres/{genre}', [GenreController::class, 'destroy'])->name('genres.destroy');
});
