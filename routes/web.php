<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceController;

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

});
