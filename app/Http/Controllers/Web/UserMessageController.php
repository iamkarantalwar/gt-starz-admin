<?php

namespace App\Http\Controllers\Web;

use App\enums\MessageType;
use App\Events\SendMessageToUserEvent;
use App\Http\Controllers\Controller;
use App\Models\UserMessage;
use App\Repositories\UserMessage\UserMessageRepository;
use Illuminate\Http\Request;
use Illuminate\Pagination\Paginator;

class UserMessageController extends Controller
{
    // Private Fields On The Controller
    private $userMessage;
    public function __construct(UserMessageRepository $userMessage)
    {
        $this->userMessage = $userMessage;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $messages = $this->userMessage->all();
        $messages_with_pagination = new Paginator($messages, config('constant.pagination.web'));
        return view('usermessage.index')->with([
            'messages' => $messages_with_pagination,
            'type' => [
                'send' => MessageType::SEND_MESSAGE_TO_USER,
                'recieve' => MessageType::RECIEVE_MESSAGE_FROM_USER,
            ]
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = $this->userMessage->recieveMessage($request->all(), MessageType::SEND_MESSAGE_TO_USER);
        if($message) {
            event(new SendMessageToUserEvent($message));
            return response()->json($message, 200);
        } else {
            return response()->json([
                'message' => 'Something went wrong. Try again later.'
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\UserMessage  $userMessage
     * @return \Illuminate\Http\Response
     */
    public function edit(UserMessage $userMessage)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\UserMessage  $userMessage
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserMessage $userMessage)
    {
        //
    }
}
