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

//TODO deletion of "mistake" categories and items, it should only allow to delete a category if it has no items inside of itself
//TODO fix the ItemShowResoure so it shows valid person data on disposed_b_person_id column and so it shows the is_disposed column
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('foo', function () {
    return 'bar';
});

Route::middleware('auth:sanctum')->resource('item', \App\Http\Controllers\ItemController::class);
Route::middleware('auth:sanctum')->post('item/{item}/dispose', '\App\Http\Controllers\ItemController@dispose');
Route::middleware('auth:sanctum')->resource('category', \App\Http\Controllers\CategoryController::class);
Route::middleware('auth:sanctum')->resource('person', \App\Http\Controllers\PersonController::class);
