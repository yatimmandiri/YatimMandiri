<?php

use App\Http\Controllers\Api\V1\CampaignController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\FaqController;
use App\Http\Controllers\Api\V1\RekeningController;
use App\Http\Controllers\Api\V1\SliderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    Route::resource('sliders', SliderController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('faqs', FaqController::class);
    Route::resource('rekenings', RekeningController::class);
    Route::resource('campaigns', CampaignController::class);
});
