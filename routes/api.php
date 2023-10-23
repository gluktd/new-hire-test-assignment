<?php

use App\Http\Controllers\RandomUserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::controller(RandomUserController::class)
    ->prefix('random-user')
    ->group(function () {
        Route::post('/data', 'getRandomUserData')->name('random-user.data');
        Route::get('/versions', 'getAvailableVersions')->name('random-user.versions');
        Route::get('/fields', 'getAvailableFields')->name('random-user.fields');
        Route::get('/custom-fields', 'getAvailableCustomFields')->name('random-user.custom_fields');
    });
