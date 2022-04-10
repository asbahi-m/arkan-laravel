<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\FeatureController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\OrderController;

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

    // Types Route
    Route::get('/types/all', [TypeController::class, 'index'])->name('types.all');
    Route::post('/type/inline_store', [TypeController::class, 'inline_store'])->name('type.inline_store');
    Route::put('/type/update', [TypeController::class, 'update'])->name('type.update');
    Route::get('/type/delete', [TypeController::class, 'delete'])->name('type.delete');

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

    // Features Route
    Route::get('/features/all', [FeatureController::class, 'index'])->name('features.all');
    Route::get('/feature/create', [FeatureController::class, 'create'])->name('feature.create');
    Route::post('/feature/store', [FeatureController::class, 'store'])->name('feature.store');
    Route::get('/feature/edit/{feature}', [FeatureController::class, 'edit'])->name('feature.edit');
    Route::post('/feature/update/{feature}', [FeatureController::class, 'update'])->name('feature.update');
    Route::get('/feature/delete', [FeatureController::class, 'delete'])->name('feature.delete');

    // Clients Route
    Route::get('/clients/all', [ClientController::class, 'index'])->name('clients.all');
    Route::get('/client/create', [ClientController::class, 'create'])->name('client.create');
    Route::post('/client/store', [ClientController::class, 'store'])->name('client.store');
    Route::get('/client/edit/{client}', [ClientController::class, 'edit'])->name('client.edit');
    Route::post('/client/update/{client}', [ClientController::class, 'update'])->name('client.update');
    Route::get('/client/delete', [ClientController::class, 'delete'])->name('client.delete');

    // Pages Route
    Route::get('/pages', [PageController::class, 'index'])->name('pages');
    Route::get('/page/create', [PageController::class, 'create'])->name('page.create');
    Route::post('/page/store', [PageController::class, 'store'])->name('page.store');
    Route::get('/page/edit/{page}', [PageController::class, 'edit'])->name('page.edit');
    Route::post('/page/update/{page}', [PageController::class, 'update'])->name('page.update');
    Route::get('/page/delete', [PageController::class, 'delete'])->name('page.delete');

    // Order Route
    Route::controller(OrderController::class)->name('order.')->group(function () {
        Route::get('order', 'index')->name('index');
        // Route::get('order/create', 'create')->name('create');
        Route::post('order/store', 'store')->name('store');
        Route::get('order/{order}', 'show')->name('show');
        Route::delete('order/destroy', 'destroy')->name('destroy');
        Route::put('order/accept', 'accept')->name('accept');
        Route::put('order/reject', 'reject')->name('reject');
    });
});
