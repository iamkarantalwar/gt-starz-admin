

  <!-- Modal -->
  <div class="modal fade" id="exampleModal{{$message->user->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Type Message Here</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          @foreach ($message->user->messages as $message)
            @if ($message->type == $type['send'])
                <div class="row">
                    <div class="col-md-2">
                        <img src="{{ asset('assets/img/brand/white1.png') }}" class="img-rounded">
                    </div>
                    <div class="col-md-8">
                        {{$message->message}}
                    </div>
                </div>
            @else
            <div class="row">
                <div class="col-md-8">
                    {{$message->message}}
                </div>
                <div class="col-md-2">
                    <img src="{{ asset('assets/img/brand/white1.png') }}" class="img-rounded">
                </div>
            </div>

            @endif
          @endforeach
        </div>
        <div class="modal-footer">
                <input type="text" name="" class="form-control" placeholder="Type Message Here" id="">
                <button class="btn btn-default col-sm-4">
                    <i class="ni ni-send"></i> Send
                </button>

            </div>
        </div>
      </div>
    </div>
  </div>
