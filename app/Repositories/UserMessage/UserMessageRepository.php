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
        return $this->userMessage->orderBy('id', 'DESC')->paginate(config('constant.pagination.web'));
    }

    public function getUserMessages($user)
    {
        return $this->userMessage->with(['user'])->get()->where('user_id', $user->id);
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
}
