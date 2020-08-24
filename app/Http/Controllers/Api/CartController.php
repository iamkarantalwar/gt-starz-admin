<?php

namespace App\Http\Controllers\Api;

use App\Models\Cart;
use App\Services\CartService;
use Illuminate\Http\Request;

class CartController extends Controller
{
    private $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->user()) {
            $this->cartService->updateCart($request->all(), $request->user()->id);
        }
        if($request->cart) {
            $response = $this->cartService->getCartProducts($request->cart);
        } else {
            $response = $this->cartService->getCartProducts($request->all());
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
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return abort(404);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function show(Cart $cart)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function edit(Cart $cart)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cart $cart)
    {
        //
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
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Cart $cart)
    {
        if($request->user()) {
            $delete = $this->cartService->removeItemFromCart($cart, $request->user()->id);
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
}
