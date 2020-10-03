<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\User\OrderRequest;
use App\Models\Order\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // Private Order Service
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->middleware('auth:user');
        $this->orderService = $orderService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $orders = $this->orderService->getUserOrders($request->user()->id);
        return response()->json($orders, 200);
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
    public function store(OrderRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = $request->user()->id;
        $response = $this->orderService->createOrder($data);
        if($response) {
            return response()->json([
                'message' => 'Order Created Successfully',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Something went wrong.'
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        //
    }

    public function orderDetails(Order $order, Request $request)
    {
        if($request->user()->id == $order->user_id) {
            $details = $this->orderService->getOrderDetails($order->id);
            return response()->json($details, 200);
        } else {
            return response()->json([
                'message' => 'You are not authorised for this action.'
            ], 401);
        }
    }
}
