<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserCreatedEvent implements ShouldBroadcast
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
          'user' => $this->user->name,
          'message' => 'New User Added. Approve or Disapprove Now.',
          'url' => route('users.index'),
          'created_at' => $this->user->created_at->diffForHumans()];
  }

  public function broadcastOn()
  {
      return ['gt-starz'];
  }

  public function broadcastAs()
  {
      return 'user-created';
  }
}
