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
        $this->cartService = $cartService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
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
        //
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
        return response()->json([
            'method' => 'GET',
        ], 200);
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
        return response()->json([
            'method' => 'PUT',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cart  $cart
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cart $cart)
    {
        return response()->json([
            'method' => 'DELETE',
        ], 200);
    }

    public function user()
    {
        return \Auth::guard('user')->user();
    }
}
