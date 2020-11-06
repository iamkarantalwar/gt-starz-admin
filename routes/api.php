<?php

use App\Events\MyEvent;
use App\Events\UserCreated;
use App\Models\Order\Order;
use Illuminate\Broadcasting\Broadcasters\PusherBroadcaster;
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
    'namespace' => '\App\Http\Controllers\Api',
    'prefix' => 'user'

], function ($router) {

    //Authentication
    Route::post('signup', 'UserAuthController@signup');
    Route::post('login', 'UserAuthController@login');
    Route::post('logout', 'UserAuthController@logout');
    Route::post('updateprofile', 'UserAuthController@updateProfile');
    Route::post('refresh', 'UserAuthController@refresh');
    Route::post('me', 'UserAuthController@me');
    Route::post('payload', 'UserAuthController@payload');
    //Update Password
    Route::post('updatepassword', 'UserAuthController@updatePassword');
    //Forgot Password
    Route::post('forgotpassword', 'UserAuthController@sendForgotPasswordOtp');
    Route::post('verifyotp', 'UserAuthController@verifyForgotPasswordOtp');
    Route::post('resetpassword', 'UserAuthController@resetPassword');
    //Get Categories
    Route::get('categories/', 'CategoryController@getCategories');
    //Get Banner Images
    Route::get('banners/', 'BannerController@getBannerImages');
    //Get Products Api
    Route::get('categories/{category}/products', 'CategoryController@getProducts');
    Route::resource('products', 'ProductController');
    //User Messages Routes
    Route::resource('messages', 'UserMessageController');
    // Order Routes
    Route::resource('orders', 'OrderController');
    Route::post('orders/{order}/details', 'OrderController@orderDetails');
    // Cart Routes
    Route::post('cart', 'CartController@index');
    Route::resource('carts', 'CartController');
    Route::post('cart/afterlogin', 'CartController@afterLogin');
    Route::get('test-order', 'OrderController@testOrder');
    Route::get('delete-all-orders', function(){
        $orders = Order::all();
        foreach ($orders as $order) {
           $order->delete();
        }
        return response()->json([
            'message' => 'All orders has been deleted',
        ], 200);
    });
    Route::post('orders/{order}/requestrefund', 'OrderController@requestRefund');
    Route::post('orders/{order}/ratedriver', 'OrderController@rateDriver');

    // Payment
    Route::post('payment/{method}/{orderId}', 'PaymentController@paymentProcess');
    Route::post('payment/create/{order}', 'PaymentController@createStripePayment');
    Route::put('updatestripeid', 'PaymentController@updateStripeId');
    Route::post('payment/success/{method}/{order}', 'PaymentController@confirmPayment');

});


Route::group([

    'middleware' => 'api',
    'namespace' => '\App\Http\Controllers\Api',
    'prefix' => 'driver'

], function ($router) {

    Route::post('signup', 'DriverAuthController@signup');
    Route::post('login', 'DriverAuthController@login');
    Route::post('logout', 'DriverAuthController@logout');
    Route::post('refresh', 'DriverAuthController@refresh');
    Route::post('me', 'DriverAuthController@me');
    Route::post('payload', 'DriverAuthController@payload');
    Route::post('updateprofile', 'DriverAuthController@updateProfile');
     //Update Password
     Route::post('updatepassword', 'DriverAuthController@updatePassword');
     //Forgot Password
     Route::post('forgotpassword', 'DriverAuthController@sendForgotPasswordOtp');
     Route::post('verifyotp', 'DriverAuthController@verifyForgotPasswordOtp');
     Route::post('resetpassword', 'DriverAuthController@resetPassword');
     Route::post('orders/pending', 'DriverOrderController@pendingOrders');
     Route::post('orders/completed', 'DriverOrderController@completedOrders');
     Route::post('orders/dispatched', 'DriverOrderController@dispatchedOrders');
     Route::post('orders/{order}', 'DriverOrderController@getDriverOrderDetails');
     Route::post('orders/{order}/dispatched', 'DriverOrderController@orderDispatched');
     Route::post('orders/{order}/delivered', 'DriverOrderController@orderDelivered');

});
