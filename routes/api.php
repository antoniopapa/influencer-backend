<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Common
Route::post('login', 'AuthController@login');
Route::post('register', 'AuthController@register');

Route::group([
    'middleware' => 'auth:api',
], function () {
    Route::post('logout', 'AuthController@logout');
    Route::get('user', 'AuthController@user');
    Route::put('users/info', 'AuthController@updateInfo');
    Route::put('users/password', 'AuthController@updatePassword');
});

Route::prefix('admin')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');

    Route::middleware(['auth:api', 'scope:admin'])->group(function () {
        Route::post('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        Route::put('users/info', 'AuthController@updateInfo');
        Route::put('users/password', 'AuthController@updatePassword');

        Route::namespace('Admin')->group(function () {
            Route::get('chart', 'DashboardController@chart');
            Route::post('upload', 'ImageController@upload');
            Route::get('export', 'OrderController@export');

            Route::apiResource('users', 'UserController');
            Route::apiResource('roles', 'RoleController');
            Route::apiResource('products', 'ProductController');
            Route::apiResource('orders', 'OrderController')->only('index', 'show');
            Route::apiResource('permissions', 'PermissionController')->only('index');
        });
    });
});


// Influencer
Route::prefix('influencer')->group(function () {
    Route::post('login', 'AuthController@login');
    Route::post('register', 'AuthController@register');
    Route::get('products', 'Influencer\ProductController@index');

    Route::middleware(['auth:api', 'scope:influencer'])->group(function () {
        Route::post('logout', 'AuthController@logout');
        Route::get('user', 'AuthController@user');
        Route::put('users/info', 'AuthController@updateInfo');
        Route::put('users/password', 'AuthController@updatePassword');

        Route::namespace('Influencer')->group(function () {
            Route::post('links', 'LinkController@store');
            Route::get('stats', 'StatsController@index');
            Route::get('rankings', 'StatsController@rankings');
        });
    });
});

// Checkout
Route::group([
    'prefix' => 'checkout',
    'namespace' => 'Checkout',
], function () {
    Route::get('links/{code}', 'LinkController@show');
    Route::post('orders', 'OrderController@store');
    Route::post('orders/confirm', 'OrderController@confirm');
});
