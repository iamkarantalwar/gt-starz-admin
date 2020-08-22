<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserApprovedEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $user;

    public function __construct($user)
    {
        $this->user = $user;
    }

    public function broadcastWith()
    {
      return [
          'message' => 'User Approved Successfully.',
          'user' => $this->user
      ];
    }

    public function broadcastOn()
    {
        return ['gt-starz'];
    }

    public function broadcastAs()
    {
        return 'user-approved'.$this->user->id;
    }
}
