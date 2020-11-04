<?php namespace App\Services\Payment;

class StripePaymentService
{
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
