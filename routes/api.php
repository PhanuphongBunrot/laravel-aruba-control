<?php

use App\Http\Controllers\CheckMasterController;
use App\Http\Controllers\InfoController;
use App\Http\Controllers\ViewipController;
use App\Http\Controllers\ViewonoffController;
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
Route::get('checkM',[CheckMasterController::class,'check']);
Route::get('view',[ViewonoffController::class,'view']);
Route::get('info',[InfoController::class,'info']);
Route::get('viewip',[ViewipController::class,'viewip']);
