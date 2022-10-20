<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware(['auth:sanctum'])->group(function () {

    Route::get('favorite_index', [FavoriteController::class,'index'])->name('favorite_index');

    Route::get('favorite_edit/{id}', [FavoriteController::class,'edit'])->name('favorite_edit');

    Route::post('favorite_store', [FavoriteController::class,'store'])->name('favorite_store');

    Route::patch('favorite_update/{id}', [FavoriteController::class,'update'])->name('favorite_update');

    Route::delete('favorite_delete/{id}', [FavoriteController::class,'delete'])->name('favorite_delete');

});
