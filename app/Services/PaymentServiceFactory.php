<?php namespace App\Services;

use App\enums\PaymentMethod;
use App\Services\Payment\PaypalPaymentService;
use App\Services\Payment\StripePaymentService;

class PaymentServiceFactory
{
    private $stripePaymentService, $paypalPaymentService;

    public function __construct(StripePaymentService $stripePaymentService,
                                PaypalPaymentService $paypalPaymentService)
    {
        $this->stripePaymentService = $stripePaymentService;
        $this->paypalPaymentService = $paypalPaymentService;
    }

   public function getPaymentService($paymentMethod) {
        if($paymentMethod == PaymentMethod::STRIPE) {
            return $this->stripePaymentService;
        } else if($paymentMethod == PaymentMethod::PAYPAL) {
            return $this->paypalPaymentService;
        } else {
            return null;
        }
   }
}
