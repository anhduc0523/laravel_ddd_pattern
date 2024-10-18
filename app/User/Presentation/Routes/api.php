<?php

use App\User\Presentation\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;

Route::prefix('v1')->group(function () {
    Route::prefix('users')->group(function () {
        Route::post('/', [UserController::class, 'store']);
        Route::get('/{id}', [UserController::class, 'getUserById']);
        Route::get('/email/{email}', [UserController::class, 'getUserByEmail']);
        Route::put('/{id}', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'delete']);
    });
});
