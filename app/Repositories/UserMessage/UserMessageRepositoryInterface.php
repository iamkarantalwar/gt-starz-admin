<?php

namespace App\Repositories\UserMessage;

interface UserMessageRepositoryInterface
{
    public function all();
    public function sendMessage($data, string $type);
}
