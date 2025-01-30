<?php

use App\Http\Controllers\JWTAuthController;
use App\Http\Controllers\PostController;
use App\Http\Middleware\JwtMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    /*
    |--------------------------------------------------------------------------
    | JWT Auth Controller
    | No Auth
    |--------------------------------------------------------------------------
    */
    Route::post('/login', [JWTAuthController::class, 'login']);

    Route::middleware([JwtMiddleware::class])->group(function () {
        /*
        |--------------------------------------------------------------------------
        | JWT Auth Controller
        | With Auth
        |--------------------------------------------------------------------------
        */
        Route::get('me', [JWTAuthController::class, 'getUser']);

        /*
        |--------------------------------------------------------------------------
        | Post Controller
        | With Auth
        |--------------------------------------------------------------------------
        */
        Route::get('post', [PostController::class, 'findAll']);
        Route::post('post', [PostController::class, 'store']);
        Route::put('post/{id}', [PostController::class, 'update']);
        Route::delete('post/{id}', [PostController::class, 'destroy']);
    });
});
