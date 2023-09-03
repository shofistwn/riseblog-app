<?php

use App\Http\Controllers\Api\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('v1')
    ->middleware(['api'])
    ->group(function () {

        Route::prefix('auth')
            ->controller(AuthController::class)
            ->group(function () {

                Route::middleware(['jwt.guest'])
                    ->group(function () {
                        Route::post('register', 'register');
                        Route::post('login', 'login');
                    });

                Route::middleware(['jwt.authenticated'])
                    ->group(function () {
                        Route::post('logout', 'logout');
                        Route::post('refresh', 'refresh');
                    });
            });

    });