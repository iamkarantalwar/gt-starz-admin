<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStripePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stripe_payments', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('order_id');
            $table->string('txn_id');
            $table->string('payment_status');
            $table->string('price');
            $table->string('customer_id')->nullable();
            $table->string('currency')->nullable();
            $table->string('receipt_email')->nullable();
            $table->string("card_last4");
            $table->string('card_id')->nullable();
            $table->string('card_funding')->nullable();
            $table->string('card_holder_name');
            $table->string('pay_datetime')->nullable();
            $table->string('card_brand');
            $table->string('failure_code')->nullable();
            $table->string('failure_message')->nullable();
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
        Schema::dropIfExists('stripe_payments');
    }
}
