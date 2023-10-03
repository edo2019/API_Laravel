<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Contoller\AuthController;

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

Route::post('register',[AuthController::class,'register']);
Route::post('login',[AuthController::class,'login']);

Route::group(['middleware'=>['auth:sanctum']], function(){

    Route::get('user',[AuthController::class,'user']);
    Route::post('logout',[AuthController::class,'logout']);

});