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
use App\Http\Controllers\CareerController;
use App\Http\Controllers\ContactUsController;
use App\Http\Controllers\SliderController;
use App\Http\Controllers\OptionController;

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

Route::redirect('/cpanel', '/dashboard');


Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        return view('admin.index');
    })->name('dashboard');

    Route::group(['prefix' => 'cpanel'], function () {
        // Users Route
        Route::controller(UserController::class)->group(function () {
            Route::get('/profile', 'profile')->name('profile');
            Route::put('/profile/update', 'profileUpdate')->name('profile.update');
            Route::get('/profile/change-password', 'passwordChange')->name('password.show');
            Route::put('/profile/update-password', 'passwordUpdate')->name('password.update');
        });

        // Types Route
        Route::controller(TypeController::class)->prefix('type')->name('type.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/sort', 'sortByAjax')->name('sort');
            Route::post('/inline_store', 'inline_store')->name('inline_store');
            Route::put('/update', 'update')->name('update');
            Route::delete('/delete', 'destroy')->name('delete');
        });

        // Services Route
        Route::controller(ServiceController::class)->prefix('service')->name('service.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{service}/edit', 'edit')->name('edit');
            Route::post('/{service}', 'update')->name('update');
            Route::delete('/delete', 'destroy')->name('delete');
        });

        // Products Route
        Route::controller(ProductController::class)->prefix('product')->name('product.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{product}/edit', 'edit')->name('edit');
            Route::post('/{product}', 'update')->name('update');
            Route::delete('/delete', 'destroy')->name('delete');
        });

        // Projects Route
        Route::controller(ProjectController::class)->prefix('project')->name('project.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{project}/edit', 'edit')->name('edit');
            Route::post('/{project}', 'update')->name('update');
            Route::delete('/delete', 'destroy')->name('delete');
        });

        // Features Route
        Route::controller(FeatureController::class)->prefix('feature')->name('feature.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{feature}/edit', 'edit')->name('edit');
            Route::post('/{feature}', 'update')->name('update');
            Route::delete('/delete', 'destroy')->name('delete');
        });

        // Clients Route
        Route::controller(ClientController::class)->prefix('client')->name('client.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{client}/edit', 'edit')->name('edit');
            Route::post('/{client}', 'update')->name('update');
            Route::delete('/delete', 'destroy')->name('delete');
        });

        // Pages Route
        Route::controller(PageController::class)->prefix('page')->name('page.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{page}/edit', 'edit')->name('edit');
            Route::post('/{page}', 'update')->name('update');
            Route::delete('/delete', 'destroy')->name('delete');
        });

        // Order Routes
        Route::controller(OrderController::class)->prefix('order')->name('order.')->group(function () {
            Route::get('/', 'index')->name('index');
            // Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{order}', 'show')->name('show');
            Route::delete('/delete', 'destroy')->name('delete');
            Route::put('/accept', 'accept')->name('accept');
            Route::put('/reject', 'reject')->name('reject');
        });

        // Career Routes
        Route::controller(CareerController::class)->prefix('career')->name('career.')->group(function () {
            Route::get('/', 'index')->name('index');
            // Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{career}', 'show')->name('show');
            Route::delete('/delete', 'destroy')->name('delete');
            Route::put('/accept', 'accept')->name('accept');
            Route::put('/reject', 'reject')->name('reject');
        });

        // Contact Us Routes
        Route::controller(ContactUsController::class)->prefix('contact')->name('contact.')->group(function () {
            Route::get('/', 'index')->name('index');
            // Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{contact}', 'show')->name('show');
            Route::delete('/delete', 'destroy')->name('delete');
            Route::put('/reply', 'reply')->name('reply');
        });

        // Slider Routes
        Route::controller(SliderController::class)->prefix('slider')->name('slider.')->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/store', 'store')->name('store');
            Route::get('/{slider}/edit', 'edit')->name('edit');
            Route::post('/{slider}', 'update')->name('update');
            Route::delete('/delete', 'destroy')->name('delete');
        });

        // Option Routes
        Route::controller(OptionController::class)->prefix('option')->name('option.')->group(function () {
            Route::get('/general', 'general')->name('general');
            Route::get('/social', 'social')->name('social');
            Route::get('/contact', 'contact')->name('contact');
            Route::post('/general-update', 'update')->name('general.update');
            Route::post('/social-update', 'update')->name('social.update');
            Route::post('/contact-update', 'update')->name('contact.update');
        });
    });
});
