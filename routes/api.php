<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;


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

Route::post('login', [AuthController::class,'login'])->name('login');
Route::post('register', [AuthController::class,'register'])->name('register');

Route::middleware(['auth:sanctum'])->group(function () {
    //Favorites
    Route::get('favorite_index', [FavoriteController::class,'index'])->name('favorite_index');

    Route::get('favorite_edit/{id}', [FavoriteController::class,'edit'])->name('favorite_edit');

    Route::post('favorite_store', [FavoriteController::class,'store'])->name('favorite_store');

    Route::patch('favorite_update/{id}', [FavoriteController::class,'update'])->name('favorite_update');

    Route::delete('favorite_delete/{id}', [FavoriteController::class,'delete'])->name('favorite_delete');

    //Users
    Route::get('user_edit/{id}', [UserController::class,'edit'])->name('user_edit');

    Route::patch('user_update/{id}', [UserController::class,'update'])->name('user_update');

});





