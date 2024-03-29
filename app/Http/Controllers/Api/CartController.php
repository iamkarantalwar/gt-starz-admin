<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->middleware('auth:user', [ 'except' => [ 'index' ] ]);
        $this->cartService = $cartService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(!$this->user()) {
            if($request->cart) {
                $response = $this->cartService->getCartProducts($request->cart);
            } else {
                $response = $this->cartService->getCartProducts($request->all());
            }
        } else {
            $userCartItems = $this->cartService->getUserCart($this->user()->id);
            $userCartItemsInFormat = $userCartItems->map(function($cartItem) {
                return collect([
                    'id' => $cartItem->id,
                    'productId' => $cartItem->product_id,
                    'skuId' => $cartItem->sku_id,
                    'quantity' => $cartItem->quantity,
                ]);
            })->toArray();
           $response = $this->cartService->getCartProducts($userCartItemsInFormat);
        }

        return response()->json($response, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return response()->json([
            'message' => 'Page Not Found'
        ], 404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if($this->user()) {
            $create = $this->cartService->addToCart($request->all(), $this->user()->id);
            return $create;
            if($create) {
                return response()->json($create, 200);
            } else {
                return response()->json([
                    'message' => 'Something Went Wrong. Try Again Later.'
                ], 400);
            }
        } else {
            return response()->json([
                'message' => 'You are not authorised for this action.'
            ], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        return response()->json($cart, 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        if($this->user() && $cart->user_id == $this->user()->id) {
            $update = $this->cartService->updateCartItem($cart, $request->all());
            if($update) {
                return response()->json([
                    'message' => 'Item Updated Successfully.'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Something went wrong. Try again later.'
                ], 401);
            }
        } else {
            return response()->json([
                'message' => 'You are not authorised for this action.'
            ], 401);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        if($this->user() && $cart->user_id == $this->user()->id) {
            $delete = $this->cartService->removeItemFromCart($cart);
            if($delete) {
                return response()->json([
                    'message' => 'Item Removed Successfully.'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Something went wrong. Try again later.'
                ], 401);
            }
        } else {
            return response()->json([
                'message' => ' Not Authorised For This Action'
            ], 401);
        }
    }

    public function afterLogin(Request $request)
    {
        if(!$this->user()) {
            return response()->json([
                'message' => ' Not Authorised For This Action'
            ], 401);
        } else {
            $cart = $request->cart ? collect($request->cart) : collect($request->all());
            $response = $this->cartService->addItemsToCartAfterLogin($cart, $this->user()->id);
            if($response) {
                return response()->json([
                    'message' => 'Cart added successfully.'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Something went wrong. Try again later.'
                ], 400);
            }
        }
    }

    public function user()
    {
        return \Auth::guard('user')->user();
    }
}
