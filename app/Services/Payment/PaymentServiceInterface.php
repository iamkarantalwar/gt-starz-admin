<?php namespace App\Services\Payment;

use App\Models\Order\Order;
use App\Models\User;

interface PaymentServiceInterface
{
    public function createPayment($data, Order $order);
    public function changePayerId(User $user, $id);
    public function confirmPayment($transactionId, $orderId);
}
