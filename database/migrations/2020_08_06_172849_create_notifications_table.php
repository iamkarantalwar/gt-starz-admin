<?php

use App\enums\NotificationType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->enum('notification_type', [
                NotificationType::NEW_DRIVER,
                NotificationType::NEW_USER,
                NotificationType::NEW_ORDER,
                NotificationType::USER_MESSAGE,
            ]);
            $table->string('message');
            $table->string('notificationable_id');
            $table->string('notificationable_type');
            $table->boolean('read')->default(false);
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
        Schema::dropIfExists('notifications');
    }
}
