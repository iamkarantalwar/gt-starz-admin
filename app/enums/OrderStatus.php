<?php

namespace App\enums;

class OrderStatus
{
    const PENDING = "PENDING";
    const PAYMENT_APPROVED = "PAYMENT_APPROVED";
    const DISPATCHED = "DISPATCHED";
    const DELIVERED = "DELIVERED";
    const CANCELLED = "CANCELLED";
}
