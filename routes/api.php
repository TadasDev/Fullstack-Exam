<?php

use App\Http\Controllers\Api\PriceListApiController;
use App\Http\Controllers\Api\RegionApiController;
use App\Http\Controllers\Api\UserApiController;
use App\Http\Controllers\Api\FishingLicenceApiController;
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

//Public routes
Route::post('/register', [UserApiController::class, 'register'])
    ->name('register.api');

Route::post('/login', [UserApiController::class, 'login'])
    ->name('login.api');

//Authenticated routes
Route::post('/logout', [UserApiController::class, 'logout'])
    ->name('logout.api')->middleware('auth:sanctum');

Route::patch('/profile/edit', [UserApiController::class, 'editProfile'])
    ->name('editProfile.api')->middleware('auth:sanctum');

Route::get('/fishing-licence', [FishingLicenceApiController::class,'index'])->name('index.api')
    ->middleware('auth:sanctum');
Route::post('/buy-licence', [FishingLicenceApiController::class,'create'])->name('create.api')
    ->middleware('auth:sanctum');

Route::get('/list-of-regions', [RegionApiController::class,'listOfRegions'])->name('listOfRegions.api')
    ->middleware('auth:sanctum');

Route::get('/price-list', [PriceListApiController::class,'priceList'])->name('priceList.api')
    ->middleware('auth:sanctum');




