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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([

    'middleware' => 'api',
    'namespace' => '\App\Http\Controllers',
    'prefix' => 'user'

], function ($router) {

    Route::post('signup', 'UserAuthController@signup');
    Route::post('login', 'UserAuthController@login');
    Route::post('logout', 'UserAuthController@logout');
    Route::post('refresh', 'UserAuthController@refresh');
    Route::post('me', 'UserAuthController@me');
    Route::post('payload', 'UserAuthController@payload');
});


Route::group([

    'middleware' => 'api',
    'namespace' => '\App\Http\Controllers',
    'prefix' => 'driver'

], function ($router) {

    Route::post('signup', 'DriverAuthController@signup');
    Route::post('login', 'DriverAuthController@login');
    Route::post('logout', 'DriverAuthController@logout');
    Route::post('refresh', 'DriverAuthController@refresh');
    Route::post('me', 'DriverAuthController@me');
    Route::post('payload', 'DriverAuthController@payload');
});