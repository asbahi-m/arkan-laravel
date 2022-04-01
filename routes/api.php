<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\admin\TypeController;
use App\Http\Controllers\admin\ServiceController;
use App\Http\Controllers\admin\ProjectController;
use App\Http\Controllers\admin\ProductController;

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
Route::get('/types', [TypeController::class, 'view']);

// Services API's
Route::get('/services', [ServiceController::class, 'view']);
Route::get('/service/{id}', [ServiceController::class, 'show']);

// Projects API's
Route::get('/projects', [ProjectController::class, 'view']);
Route::get('/projects/latest', [ProjectController::class, 'latest']);
Route::get('/project/{id}', [ProjectController::class, 'show']);

// Products API's
Route::get('/products', [ProductController::class, 'view']);
