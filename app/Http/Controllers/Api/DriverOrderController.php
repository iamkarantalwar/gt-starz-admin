<?php

namespace App\Http\Controllers\Api;

use App\enums\OrderStatus;
use App\Events\ChangeOrderStatus;
use App\Http\Controllers\Controller;
use App\Models\Order\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class DriverOrderController extends Controller
{
    // Private Order Service
    private $orderService;

    public function __construct(OrderService $orderService)
    {
        $this->middleware('auth:driver', ['except' => [ 'testOrder' ]]);
        $this->orderService = $orderService;
    }

    public function pendingOrders(Request $request)
    {
        $orders = $this->orderService->getDriverPendingOrders($request->user()->id);
        return response()->json($orders, 200);
    }

    public function completedOrders(Request $request) {
        $orders = $this->orderService->getDriverCompletedOrders($request->user()->id);
        return response()->json($orders, 200);
    }

    public function getDriverOrderDetails(Order $order, Request $request) {
        if($order->driver_id != $request->user()->id) {
            return response()->json([
                'message' => 'You are not authenticated for this action.',
            ], 401);
        } else {
            $details = $this->orderService->getUserOrder($order->id);
            return response()->json($details, 200);
        }
    }

    public function orderDispatched(Order $order, Request $request)
    {
        if($order->driver_id != $request->user()->id) {
            return response()->json([
                'message' => 'You are not authenticated for this action.',
            ], 401);
        } else {
            $details = $this->orderService->update([
                'order_status' => OrderStatus::DISPATCHED
            ], $order);
            event(new ChangeOrderStatus($order));
            if($details) {
                return response()->json([
                    'message' => 'Status updated successfully.'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Status updation failed.'
                ], 400);
            }
        }
    }

    public function orderDelivered(Order $order, Request $request)
    {
        if($order->driver_id != $request->user()->id) {
            return response()->json([
                'message' => 'You are not authenticated for this action.',
            ], 401);
        } else {
            $details = $this->orderService->update([
                'order_status' => OrderStatus::DELIVERED
            ], $order);

            if($details) {
                return response()->json([
                    'message' => 'Status updated successfully.'
                ], 200);
            } else {
                return response()->json([
                    'message' => 'Status updation failed.'
                ], 400);
            }
        }
    }

    public function dispatchedOrders(Request $request)
    {
        $orders = $this->orderService->getDriverDispacthedOrders($request->user()->id);
        return response()->json($orders, 200);
    }

}
