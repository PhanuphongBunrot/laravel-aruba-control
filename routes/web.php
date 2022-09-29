<?php

use App\Http\Controllers\DeathTimeController;
use App\Http\Controllers\Inputcontroller;
use App\Http\Controllers\MongoController;
use App\Http\Controllers\RequestArubaApi;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\ViewonoffController;
use Illuminate\Support\Facades\Route;
use Jenssegers\Mongodb\Queue\MongoConnector;
use League\Flysystem\RootViolationException;
use Symfony\Component\HttpKernel\DataCollector\DataCollector;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('input');
});
Route::get('/tl',[DataCollector::class,'timeline']);
Route::get('db',[MongoController::class,'mongo']);
Route::get('stu',[StatusController::class,'stu']);
Route::get('dea',[DeathTimeController::class,'Death']);
Route::post('input',[Inputcontroller::class,'input']);
Route::get('view',[ViewonoffController::class,'view']);
Route::get('req',[RequestArubaApi::class,'reqaruba']);
Route::view('inputmaster','input');
