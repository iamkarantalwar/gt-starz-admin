<?php

namespace App\Http\Controllers;

use App\enums\PaymentMethod;
use App\Models\Order\Order;
use App\Services\PaymentServiceFactory;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Private Fields
    private $paymentServiceFactory;

    public function __construct(PaymentServiceFactory $paymentServiceFactory)
    {
        $this->middleware('auth:user');
        $this->paymentServiceFactory = $paymentServiceFactory;
    }

    public function updateStripeId(Request $request, $method = PaymentMethod::STRIPE) {

        $service = $this->paymentServiceFactory->getPaymentService($method);
        if($service == null) {
            return response()->json([
                'message' => 'This payment method is not available yet.'
            ], 401);
        } else {
            $update = $service->changeUserStripeId($request->user(), $request->stripeId);
            if($update) {
                return response()->json([
                    'message' => "Stripe ID updated successfully."
                ], 200);
            } else {
                return response()->json([
                    'message' => "Something went wrong. Try again later."
                ], 400);
            }
        }

    }

    public function confirmTransactionStatus(Request $request, Order $order, $method = PaymentMethod::STRIPE) {

        $service = $this->paymentServiceFactory->getPaymentService($method);
        if($service == null) {
            return response()->json([
                'message' => 'This payment method is not available yet.'
            ], 401);
        } else {
            $confirm = $service->confirmStripePayment($request->txn_id, $order->id);
            if($confirm) {
                return response()->json([
                    'message' => "Payment information is genuine and confirmed."
                ], 200);
            } else {
                return response()->json([
                    'message' => "Something went wrong. Try again later."
                ], 400);
            }
        }

    }

    public function createStripePayment(Request $request, Order $order, $method = PaymentMethod::STRIPE) {

        $service = $this->paymentServiceFactory->getPaymentService($method);
        if($service == null) {
            return response()->json([
                'message' => 'This payment method is not available yet.'
            ], 401);
        } else {
            if($request->user()->id == $order->user_id) {
                $request = $request->all();
                $request['order_id'] = $order->id;
                $paymentCreated = $service->createPayment($request);
                if($paymentCreated) {
                    return response()->json([
                        'message' => 'Payment Created successfully',
                        'payment' => $paymentCreated
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'Something went wrong. Try again later.'
                    ], 400);
                }
            } else {
                return response()->json([
                    'message' => 'You are not authenticated to create this payment.'
                ], 400);
            }
        }
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
