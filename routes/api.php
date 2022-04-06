<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProductController;

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

// Types API's
Route::get('/types', [TypeController::class, 'viewAPI']);

// Services API's
Route::get('/services', [ServiceController::class, 'viewAPI']);
Route::get('/service/{id}', [ServiceController::class, 'showAPI']);

// Projects API's
Route::get('/projects', [ProjectController::class, 'viewAPI']);
Route::get('/projects/latest', [ProjectController::class, 'latestAPI']);
Route::get('/project/{id}', [ProjectController::class, 'showAPI']);

// Products API's
Route::get('/products', [ProductController::class, 'viewAPI']);
