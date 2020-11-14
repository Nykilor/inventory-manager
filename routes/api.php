<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->resource('item', \App\Http\Controllers\ItemController::class);
Route::middleware('auth:sanctum')->post('item/{item}/dispose', '\App\Http\Controllers\ItemController@dispose');
Route::middleware('auth:sanctum')->resource('category', \App\Http\Controllers\CategoryController::class);
Route::middleware('auth:sanctum')->resource('person', \App\Http\Controllers\PersonController::class);
Route::middleware('auth:sanctum')->resource('categoryAccess', \App\Http\Controllers\CategoryAccessController::class);
Route::middleware('auth:sanctum')->get('user/{user}/categoryAccess', \App\Http\Controllers\UserCategoryAccessController::class);
Route::middleware('auth:sanctum')->resource('localization', \App\Http\Controllers\LocalizationController::class);
Route::middleware('auth:sanctum')->resource('subLocalization', \App\Http\Controllers\SubLocalizationController::class);
