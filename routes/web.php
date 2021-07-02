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

//==============Frontend===============
Route::group([
    'namespace' => 'Frontend',
    'prefix' => '/',
], function () {
    Route::get('/', 'HomeController@index')
        ->name('frontend.index');

    Route::get('product/{slug}', 'ProductController@show')
        ->name('frontend.product.show');

    Route::get('category/{slug}', 'CategoryController@show')
        ->name('frontend.category');

    Route::get('cart', 'CartController@index')
        ->name('frontend.cart.index');

    Route::post('cart/add', 'CartController@add')
        ->name('frontend.cart.add');

    Route::post('cart/update', 'CartController@update')
        ->name('frontend.cart.update');

    Route::get('cart/remove/{id}', 'CartController@remove')
        ->name('frontend.cart.remove');

    Route::get('cart/destroy', 'CartController@destroy')
        ->name('frontend.cart.destroy');

    Route::get('checkout', 'CheckoutController@index')
        ->name('frontend.checkout');

    Route::post('/', 'PayController@pay')
        ->name('frontend.pay');

    Route::get('account', 'UserController@edit')
        ->name('frontend.account');

    Route::get('order', 'UserController@order')
        ->name('frontend.order');

    Route::get('/search', 'ProductController@search')
        ->name('frontend.product.search');

    Route::post('/autocomplete-ajax', 'ProductController@autocomplete_ajax')
        ->name('frontend.product.searchauto');
});
//=====================================


//=========Đăng nhập - Đăng ký=========
Route::get('login', 'Auth\LoginController@showLoginForm')
    ->name('login.form');

Route::get('login/admin', 'Auth\LoginController@showLoginFormAdmin')
    ->name('login');

Route::post('login', 'Auth\LoginController@login')
    ->name('login.store');

Route::get('logout', 'Auth\LogoutController@logout')
    ->name('logout');

Route::get('register', 'Auth\RegisterController@showRegisterForm')
    ->name('register.form');

Route::post('register', 'Auth\RegisterController@register')
    ->name('register.store');
//=====================================


//===============Backend===============
Route::group([
    'namespace' => 'Backend',
    'prefix' => 'admin',
    'middleware' => ['auth', 'check_admin', 'preventBackHistory'],
], function () {
    // Dashboard
    Route::get('/', 'DashboardController@index')
        ->name('backend.dashboard');

    Route::post('/option', 'DashboardController@option')
        ->name('backend.option');

    // Quản lý sản phẩm
    Route::group(['prefix' => 'product'], function () {
        Route::get('/', 'ProductController@index')
            ->name('backend.product.index');

        Route::get('/create', 'ProductController@create')
            ->name('backend.product.create');

        Route::post('/', 'ProductController@store')
            ->name('backend.product.store');

        Route::get('/filter', 'ProductController@filter')
            ->name('backend.product.filter');

        Route::get('/edit/{product}', 'ProductController@edit')
            ->name('backend.product.edit')
            ->middleware('can:update,product');

        Route::match(['put', 'patch'], '/{id}', 'ProductController@update')
            ->name('backend.product.update');

        Route::delete('/{product}', 'ProductController@destroy')
            ->name('backend.product.destroy')
            ->middleware('can:delete,product');
    });

    // Quản lý người dùng
    Route::group(['prefix' => 'user'], function () {
        Route::get('/', 'UserController@index')
            ->name('backend.user.index');

        Route::get('/create', 'UserController@create')
            ->name('backend.user.create');

        Route::post('/', 'UserController@store')
            ->name('backend.user.store');

        Route::get('/{user}', 'UserController@show')
            ->name('backend.user.show');

        Route::get('/edit/{user}', 'UserController@edit')
            ->name('backend.user.edit')
            ->middleware('can:update,user');

        Route::match(['put', 'patch'], '/{id}', 'UserController@update')
            ->name('backend.user.update');

        Route::delete('/{user}', 'UserController@destroy')
            ->name('backend.user.destroy')
            ->middleware('can:delete,user');
    });

    // Quản lý danh mục
    Route::group(['prefix' => 'category'], function () {
        Route::get('/', 'CategoryController@index')
            ->name('backend.category.index');

        Route::get('/create', 'CategoryController@create')
            ->name('backend.category.create');

        Route::post('/', 'CategoryController@store')
            ->name('backend.category.store');

        Route::get('/edit/{category}', 'CategoryController@edit')
            ->name('backend.category.edit')
            ->middleware('can:update,category');

        Route::match(['put', 'patch'], '/{id}', 'CategoryController@update')
            ->name('backend.category.update');

        Route::delete('/{category}', 'CategoryController@destroy')
            ->name('backend.category.destroy')
            ->middleware('can:delete,category');
    });

    // Quản lý thương hiệu
    Route::group(['prefix' => 'trademark'], function () {
        Route::get('/', 'TrademarkController@index')
            ->name('backend.trademark.index');

        Route::get('/create', 'TrademarkController@create')
            ->name('backend.trademark.create');

        Route::post('/', 'TrademarkController@store')
            ->name('backend.trademark.store');

        Route::get('/edit/{trademark}', 'TrademarkController@edit')
            ->name('backend.trademark.edit')
            ->middleware('can:update,trademark');

        Route::match(['put', 'patch'], '/{id}', 'TrademarkController@update')
            ->name('backend.trademark.update');

        Route::delete('/{trademark}', 'TrademarkController@destroy')
            ->name('backend.trademark.destroy')
            ->middleware('can:delete,trademark');
    });

    //Quản lý đơn hàng
    Route::group(['prefix' => 'order'], function () {
        Route::get('/', 'OrderController@index')
            ->name('backend.order.index');

        Route::get('/show/{order}', 'OrderController@show')
            ->name('backend.order.show');

        Route::match(['put', 'patch'], '/{id}', 'OrderController@update')
            ->name('backend.order.update');

        Route::delete('/{order}', 'OrderController@destroy')
            ->name('backend.order.destroy');
    });

    //Thống kê doanh thu
    Route::group(['prefix' => 'statistic'], function () {
        Route::get('/', 'StatisticController@index')
            ->name('backend.statistic.index');

        Route::post('/filte-by-date', 'StatisticController@filterByDate')
            ->name('backend.statistic.day');

        Route::post('/filte-option', 'StatisticController@filterOption')
            ->name('backend.statistic.option');
    });
});
//=====================================


Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');
