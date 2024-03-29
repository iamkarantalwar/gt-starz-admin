@if($messages->count() > 0)
    @foreach ($messages as $message)
    <tr id="message-tr-{{$message->user_id}}">
        <th scope="row">
            {{ $loop->iteration }}
        </th>
        <td class="budget">
            {{ $message->user->name}}
        </td>
        <td class="budget">
            {{ $message->user->email}}
        </td>
        <td class="message">
            {{ $message->message }}
        </td>
        <td class="sent-time">
            {{ $message->created_at->diffForHumans() }}
        </td>
        <td>
            <button class="btn btn-default" data-toggle="modal" data-target="#exampleModal{{$message->user->id}}">
                <i class="ni ni-send"></i> Reply
            </button>
        </td>
        @include('usermessage.partials.chatmodel')
    </tr>
    @endforeach
@else
<tr colspan="4">
    <td>
        <b>No Message Available</b>
    </td>
</tr>
@endif

