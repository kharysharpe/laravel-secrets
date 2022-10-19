<?php

use App\Http\Controllers\RetrieveSecretController;
use App\Http\Controllers\StoreSecretController;
use Illuminate\Http\Request;
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

// Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::name('secrets.')->middleware(['auth:sanctum'])->prefix('v1')->group(
    function () {
        Route::post('/secrets', StoreSecretController::class)->name('store');
        Route::get('/secrets', RetrieveSecretController::class)->name('retrieve');
    }
);
