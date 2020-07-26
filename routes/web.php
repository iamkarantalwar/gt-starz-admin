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



Route::group(['namespace' => 'Web', 'middleware' => 'auth'], function () {

    Route::get('/', function () {
        return view('welcome');
    });

    Route::resource('categories', 'CategoryController');
    Route::resource('banners', 'BannerController');
    Route::get('users', 'UserController@index')->name('users.index');
    Route::get('users/{user}/changestatus/{status}', 'UserController@changeApprovalStatus')->name('users.changestatus');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');
