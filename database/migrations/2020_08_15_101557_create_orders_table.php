<?php

use App\enums\OrderStatus;
use App\enums\PaymentMethod;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id');
            $table->bigInteger('driver_id')->nullable();
            $table->string('address');
            $table->string('state');
            $table->string('city');
            $table->string('phone_number');
            $table->enum('payment_type', [
                PaymentMethod::PAYPAL,
                PaymentMethod::STRIPE
            ]);
            $table->enum('order_status', [
                OrderStatus::PENDING,
                OrderStatus::PAYMENT_APPROVED,
                OrderStatus::DISPATCHED,
                OrderStatus::DELIVERED,
                OrderStatus::CANCELLED,
            ]);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
}
