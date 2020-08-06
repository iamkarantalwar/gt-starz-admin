<?php

namespace App\Services;

use App\Models\User;
use App\Events\UserCreatedEvent;
use Illuminate\Database\Eloquent\Model;

class DashboardNotificationService
{
    //Notification Type
    private $notification, $notificationType;

    public function __construct($notificationType, Model $notification)
    {
        $this->notificationType = $notificationType;
        $this->notification = $notification;
    }

    public function newUserAdded(User $user)
    {
        $notification = $this->notification->create([
            'notification_type' => $this->notificationType,
            'notificationable_type' => 'App\Models\User',
            'notificationable_id' => $user->id,
            'message' => 'New User Added. Approve or Disapprove Now.'
        ]);

        if($notification) {
            event(new UserCreatedEvent($user));
            return $notification;
        }

    }
}
