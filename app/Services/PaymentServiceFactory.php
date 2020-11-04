<?php namespace App\Services;

use App\enums\PaymentMethod;
use App\Services\Payment\PaypalPaymentService;
use App\Services\Payment\StripePaymentService;

class PaymentServiceFactory
{
   public function getPaymentService($paymentMethod) {
        if($paymentMethod == PaymentMethod::STRIPE) {
            return new StripePaymentService();
        } else if($paymentMethod == PaymentMethod::PAYPAL) {
            return new PaypalPaymentService();
        } else {
            return null;
        }
   }
}
