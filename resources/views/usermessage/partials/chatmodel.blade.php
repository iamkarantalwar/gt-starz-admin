

  <!-- Modal -->
  <div class="modal fade chat-model" id="exampleModal{{$message->user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Type Message Here</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body chat-model-body">
          @foreach ($message->user->messages as $message)
          @if ($message->message_type == $type['recieve'])
            <div class="container-chat">
                <img src="{{ asset('assets/img/brand/white1.png') }}" alt="Avatar" style="width:100%;">
                <p>{{$message->message}}</p>
                <span class="time-right">{{$message->created_at->diffForHumans()}}</span>
            </div>
            @else
            <div class="container-chat darker">
                <img src="{{ asset('assets/img/brand/white1.png') }}" alt="Avatar" class="right" style="width:100%;">
                <p>{{$message->message}}</p>
                <span class="time-left">{{$message->created_at->diffForHumans()}}</span>
            </div>
            @endif
          @endforeach
        </div>
        <div class="modal-footer">
                <input type="text" name="message" class="form-control" placeholder="Type Message Here">
                <button class="btn btn-default col-sm-4" onclick="sendMessage('{{$message->user_id}}');">
                    <i class="ni ni-send"></i> Send
                </button>
            </div>
        </div>
      </div>
    </div>
  </div>
<script>
$('.modal').on('shown.bs.modal', function() {
    var body = $(this).find('.modal-body');
    var height = parseInt($(body).height());
    $(body).scrollTop(height);
});

function sendMessage(user_id)
{
    const data = {
            'user_id' : user_id,
            'message': $(`#exampleModal${user_id}`).find('input[name="message"]').val(),
    };
    $(`#exampleModal${user_id}`).find('input[name="message"]').val("");
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $.post('{{ route('usermessages.store') }}', data, function(res) {
            // Change Message
            $(`#message-tr-${data.user_id}`).find('.message').html(`<b>${data.message}</b>`);
            $(`#message-tr-${data.user_id}`).find('.sent-time').html(`<b>Just Now</b>`);
            const userId = res.user_id;
            var messageBox = $(`#exampleModal${userId} .modal-body`);
            const divToAppend = ` <div class="container-chat darker">
                <img src="/assets/img/brand/white1.png" class="right" alt="Avatar" style="width:100%;">
                <p>${data.message}</p>
                <span class="time-left">Just Now</span>
            </div>`;
            messageBox.append(divToAppend);
    });
    return false;
}
</script>
