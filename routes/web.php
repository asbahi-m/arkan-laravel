<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;

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
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');

    Route::get('/dashboard-old', function () {
        return view('dashboard');
    })->name('dashboard.old');

    // Users Route
    Route::get('/profile', function () {
        return view('admin.user.profile');
    })->name('profile');
    Route::post('/profile/update', [UserController::class, 'profileUpdate'])->name('profile.update');
    Route::get('/user/change-password', function() {
        return view('admin.user.change-password');
    })->name('user.password');
    Route::post('/user/password/update', [UserController::class, 'passwordUpdate'])->name('password.update');

    // Services Route
    Route::get('/services/all', [ServiceController::class, 'index'])->name('services.all');
    Route::get('/service/create', [ServiceController::class, 'create'])->name('service.create');
    Route::post('/service/store', [ServiceController::class, 'store'])->name('service.store');
    Route::get('/service/edit/{service}', [ServiceController::class, 'edit'])->name('service.edit');
    Route::post('/service/update/{service}', [ServiceController::class, 'update'])->name('service.update');
    Route::get('/service/delete', [ServiceController::class, 'delete'])->name('service.delete');

    // Products Route
    Route::get('/products/all', [ProductController::class, 'index'])->name('products.all');
    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::post('/product/store', [ProductController::class, 'store'])->name('product.store');
    Route::get('/product/edit/{product}', [ProductController::class, 'edit'])->name('product.edit');
    Route::post('/product/update/{product}', [ProductController::class, 'update'])->name('product.update');
    Route::get('/product/delete', [ProductController::class, 'delete'])->name('product.delete');

    // Projects Route
    Route::get('/projects/all', [ProjectController::class, 'index'])->name('projects.all');
    Route::get('/project/create', [ProjectController::class, 'create'])->name('project.create');
    Route::post('/project/store', [ProjectController::class, 'store'])->name('project.store');
    Route::get('/project/edit/{project}', [ProjectController::class, 'edit'])->name('project.edit');
    Route::post('/project/update/{project}', [ProjectController::class, 'update'])->name('project.update');
    Route::get('/project/delete', [ProjectController::class, 'delete'])->name('project.delete');
});
