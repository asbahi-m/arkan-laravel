<?php

use Illuminate\Support\Facades\Route;

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

    Route::get('/profile', function() {
        return view('admin.user.profile');
    })->name('profile');

    Route::get('/user/change-password', function() {
        return view('admin.user.change-password');
    })->name('user.password');
});
