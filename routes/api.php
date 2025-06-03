<?php
use App\Http\Controllers\{GenreController, PlatformController, GameController, ReviewController};

Route::apiResource('genres', GenreController::class);
Route::apiResource('platforms', PlatformController::class);
Route::apiResource('games', GameController::class);
Route::apiResource('reviews', ReviewController::class);
