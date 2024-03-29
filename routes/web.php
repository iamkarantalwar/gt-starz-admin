<?php

use App\Models\Product\Product;
use App\Models\Product\ProductOption;
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
Route::get('/data', function () {
       return Product::with(['skus', 'skus.images','skus.productValues' ,'skus.productValues.productOption', 'skus.productValues.productValue'])->get();
})->name('welcome');

Route::get('/', 'HomeController@index')->middleware('auth')->name('welcome');

Route::group(['namespace' => 'Web', 'middleware' => 'auth'], function () {

    Route::resource('categories', 'CategoryController');
    Route::resource('banners', 'BannerController');
    //User Routes
    Route::get('users', 'UserController@index')->name('users.index');
    Route::get('users/{user}/changestatus/{status}', 'UserController@changeApprovalStatus')->name('users.changestatus');
    //Driver Routes
    Route::resource('drivers', 'DriverController');
    Route::get('drivers/{driver}/changestatus/{status}', 'DriverController@changeApprovalStatus')->name('drivers.changestatus');
    //Product Routes
    Route::resource('products', 'ProductController');
    //User Messages Routes
    Route::resource('usermessages', 'UserMessageController');
    //Orders
    Route::resource('orders', 'OrderController');
});

Auth::routes(['register' => false]);

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/payment', ['as' => 'payment', 'uses' => 'PaymentController@payWithpaypal']);
Route::get('/payment/status',['as' => 'status', 'uses' => 'PaymentController@getPaymentStatus']);
