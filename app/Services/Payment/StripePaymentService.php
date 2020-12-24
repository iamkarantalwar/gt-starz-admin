<?php namespace App\Services\Payment;

use App\enums\OrderStatus;
use App\enums\PaymentMethod;
use App\Models\Payment\StripePayment;
use App\Models\User;
use App\Repositories\Order\OrderRepository;
use App\Repositories\User\UserRepository;

class StripePaymentService implements PaymentServiceInterface
{

    private $userRepository, $stripePayment, $orderRepository, $orderStatus;

    public function __construct(UserRepository $userRepository,
                                StripePayment $stripePayment,
                                OrderRepository $orderRepository,
                                OrderStatus $orderStatus)
    {
        $this->userRepository = $userRepository;
        $this->stripePayment = $stripePayment;
        $this->orderStatus = $orderStatus;
        $this->orderRepository = $orderRepository;
    }

    public function changePayerId(User $user, $stripeId)
    {
        $update = $this->userRepository->update($user, [
            'stripe_id' => $stripeId,
        ]);

        if($update) {
            return true;
        } else {
            return false;
        }
    }

    public function createPayment($data, $order) {
        $data['order_id'] = $order->id;
        $create = $this->stripePayment->updateOrCreate($data);
        if($create) {
            return true;
        } else {
            return false;
        }
    }

    public function confirmPayment($transactionId, $orderId) {

        $stripePaymentObject = $this->stripePayment->where('txn_id', $transactionId)->where('order_id', $orderId)->first();

        // Check if object exist
        if($stripePaymentObject == null) {
            return false;
        } else {
            $stripe = new \Stripe\StripeClient(env('STRIPE_KEY'));
            $confirm = $stripe->paymentIntents->confirm($transactionId);
            if($confirm) {
                $orderUpdate = $this->orderRepository->update([
                    'order_status' => $this->orderStatus->PAYMENT_APPROVED,
                    'payment_type' => PaymentMethod::STRIPE,
                ], $this->orderRepository->getOrderById($orderId));

                $stripePaymentObjectUpdate = $stripePaymentObject->update([
                    'payment_status' => 'DONE'
                ]);

                if($orderUpdate && $stripePaymentObjectUpdate) {
                    return true;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

    }

    public function paymentProcess($data, $order) {

        // Set Stripe Token
        \Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

        $token = $data['stripeToken'];
        $charge = \Stripe\Charge::create([
            'amount' => $order->total,
            'currency' => env('PAYMENT_CURRENCY'),
            'description' => 'Order no. '. $order->id,
            'source' => $token
        ]);

        return $charge;
    }
}
