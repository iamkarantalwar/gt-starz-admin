<?php

namespace App\Http\Controllers;

use App\Models\Order\Order;
use App\Services\PaymentServiceFactory;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Private Fields
    private $paymentServiceFactory;

    public function __construct(PaymentServiceFactory $paymentServiceFactory)
    {
        $this->paymentServiceFactory = $paymentServiceFactory;
    }

    public function paymentProcess(Request $request, $method, Order $order) {
        $service = $this->paymentServiceFactory->getPaymentService($method);
        if($service == null) {
            return response()->json([
                'message' => 'This payment method is not available yet.'
            ], 401);
        } else {
            $payment = $service->paymentProcess($request->all(), $order);
            return response()->json($payment, 200);
        }
    }
}
