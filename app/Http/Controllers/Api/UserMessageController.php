<?php

namespace App\Http\Controllers\Api;

use App\enums\MessageType;
use App\Events\RecieveMessageFromUserEvent;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserMessageRequest;
use App\Models\UserMessage;
use App\Repositories\UserMessage\UserMessageRepository;
use Illuminate\Http\Request;

class UserMessageController extends Controller
{
    //Private Fields
    private $userMessage;

    public function __construct(UserMessageRepository $userMessage)
    {
        $this->middleware('auth:user', ['except' => []]);
        $this->userMessage = $userMessage;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $messages = $this->userMessage->getUserMessages($request->user());
        return response()->json($messages, 200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return abort(404);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserMessageRequest $request)
    {
        $data = [
            'message' => $request->message,
            'user_id' => $request->user()->id,
        ];

        $message = $this->userMessage->sendMessage($data, MessageType::RECIEVE_MESSAGE_FROM_USER);
        if($message) {
            event(new RecieveMessageFromUserEvent($message));
            return response()->json($message, 200);
        } else {
            return response()->json([
                'message' => 'Something went wrong. Try again later',
            ], 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\UserMessage  $userMessage
     * @return \Illuminate\Http\Response
     */
    public function show(UserMessage $userMessage)
    {
        return abort(404);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserMessage  $userMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(UserMessage $userMessage)
    {
        return abort(404);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\UserMessage  $userMessage
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserMessage $userMessage)
    {
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserMessage  $userMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserMessage $userMessage)
    {
        return abort(404);
    }
}
