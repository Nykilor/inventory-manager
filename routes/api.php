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

//TODO supper user account that can do all the stuff without given privilage inside the category_access
//TODO deletion of "mistake" categories and items
//TODO soft deletion ?

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('foo', function () {
    return 'bar';
});

Route::middleware('auth:sanctum')->resource('item', \App\Http\Controllers\ItemController::class);
Route::middleware('auth:sanctum')->resource('category', \App\Http\Controllers\CategoryController::class);
