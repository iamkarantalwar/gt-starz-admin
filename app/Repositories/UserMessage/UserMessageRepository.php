<?php

namespace App\Repositories\UserMessage;

use App\enums\MessageType;
use App\Models\UserMessage;
use Illuminate\Support\Facades\DB as DB;

class UserMessageRepository implements UserMessageRepositoryInterface
{
    // Protected Fields
    private $userMessage;

    public function __construct(UserMessage $userMessage)
    {
        $this->userMessage = $userMessage;
    }

    public function all()
    {
        $user_ids = $this->userMessage->select('user_id')->distinct('user_id')->get()->pluck('user_id');
        $userMessages = $this->userMessage;
        return $messages = $user_ids->map(function($id) use ($userMessages) {
                        return $userMessages->where('user_id', $id)->orderBy('id', 'desc')->first();
        });
    }

    public function getUserMessages($user)
    {
        return $this->userMessage->get()->where('user_id', $user->id);
    }

    public function sendMessage($data, string $type)
    {
        $message = $this->userMessage->create([
                'user_id' => $data['user_id'],
                'message_type' => $type,
                'message' => $data['message'],
        ]);

        if($message) {
            return $message;
        } else {
            return null;
        }
    }

    public function recieveMessage($data, string $type) {
        $message = $this->userMessage->create([
            'user_id' => $data['user_id'],
            'message_type' => $type,
            'message' => $data['message'],
        ]);

        if($message) {
            return $message;
        } else {
            return null;
        }
    }
}
