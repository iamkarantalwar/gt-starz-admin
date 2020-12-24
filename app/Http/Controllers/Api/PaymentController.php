<?php

namespace App\Http\Controllers\Api;

use App\enums\PaymentMethod;
use App\Models\Order\Order;
use App\Services\PaymentServiceFactory;
use Faker\Provider\ar_SA\Payment;
use Illuminate\Http\Request;

use function PHPSTORM_META\map;

class PaymentController extends Controller
{
    // Private Fields
    private $paymentServiceFactory;

    public function __construct(PaymentServiceFactory $paymentServiceFactory)
    {
        $this->middleware('auth:user');
        $this->paymentServiceFactory = $paymentServiceFactory;
    }

    public function updatePayerId(Request $request, $method = PaymentMethod::STRIPE) {

        $service = $this->paymentServiceFactory->getPaymentService($method);
        if($service == null) {
            return response()->json([
                'message' => 'This payment method is not available yet.'
            ], 401);
        } else {
            $update = $service->changePayerId($request->user(), $request->stripeId);
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
            $confirm = $service->confirmPayment($request->txn_id, $order->id);
            if($confirm) {
                return response()->json([
                    'message' => "Payment information is genuine and confirmed.",
                    'information' => $confirm
                ], 200);
            } else {
                return response()->json([
                    'message' => "Something went wrong. Try again later."
                ], 400);
            }
        }

    }

    public function createPayment(Request $request, Order $order, $method = PaymentMethod::STRIPE) {

        $service = $this->paymentServiceFactory->getPaymentService($method);
        if($service == null) {
            return response()->json([
                'message' => 'This payment method is not available yet.'
            ], 401);
        } else {
            if($method == PaymentMethod::STRIPE) {
                if($request->user()->id == $order->user_id) {
                    $request = $request->all();
                    $paymentCreated = $service->createPayment($request, $order);
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
            } else if($method == PaymentMethod::PAYPAL) {
                if($request->user()->id == $order->user_id) {
                    $request = $request->all();
                    $paymentCreated = $service->createPayment($request, $order);
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
    }

    public function paymentProcess(Request $request, Order $order, $method) {
        $service = $this->paymentServiceFactory->getPaymentService($method);
        if($service == null) {
            return response()->json([
                'message' => 'This payment method is not available yet.'
            ], 401);
        } else {
            $payment = $service->paymentProcess($request->all(), $order);
            if($payment) {
                return response()->json([
                    'message' => 'Payment processed successfully.',
                    'payment' => $payment
                ]);
            } else {
                return response()->json([
                    'message' => 'Something went wrong. Try again later.'
                ], 400);
            }
        }
    }
}
