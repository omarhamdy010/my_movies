<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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
Route::group(
    [
        'prefix' => \Mcamara\LaravelLocalization\Facades\LaravelLocalization::setLocale(),
        'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]
    ], function(){

    Route::get('/', function () {

        return view('welcome');

    });

    Route::prefix('dashboard')->middleware('auth')->group(function () {

        Route::resource('users', \App\Http\Controllers\UserController::class)->except('show');
        Route::resource('products', \App\Http\Controllers\ProductsController::class)->except('show');
        Route::resource('categories', \App\Http\Controllers\CategoryController::class)->except('show');
        Route::resource('dashboard', \App\Http\Controllers\DashboardController::class)->except('show');
        Route::resource('fronts', \App\Http\Controllers\FrontController::class)->except('show');
        Route::get('product.proajax', 'App\Http\Controllers\ProductsController@proajax')->name('product.proajax');
        Route::get('categories.catajax', 'App\Http\Controllers\CategoryController@catajax')->name('categories.catajax');
        Route::get('users-ajax', 'App\Http\Controllers\UserController@ajax')->name('users.ajax');
        Route::get('categories/{id}', 'App\Http\Controllers\CategoryController@destroy');
        Route::get('products/{id}', [\App\Http\Controllers\ProductsController::class, 'destroy']);
        Route::get('users/{id}', [\App\Http\Controllers\UserController::class, 'destroy']);

        Route::get('cart', [\App\Http\Controllers\FrontController::class, 'cart'])->name('cart');
        Route::get('add-to-cart/{id}', [\App\Http\Controllers\FrontController::class, 'addToCart'])->name('add.to.cart');
        Route::patch('update-cart', [\App\Http\Controllers\FrontController::class, 'updatetocart'])->name('updatetocart');
        Route::delete('remove-from-cart', [\App\Http\Controllers\FrontController::class, 'remove'])->name('remove.from.cart');

    });

    Auth::routes();
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

    Route::get('dashboard/home', 'App\Http\Controllers\DashboardController@handleAdmin')->name('dashboard.route')->middleware('admin');
});
