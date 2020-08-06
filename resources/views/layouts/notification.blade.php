<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>
   // $('.notification-count').html(3);
    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('d69a18ce9429eb10e084', {
      cluster: 'ap2'
    });

    var channel = pusher.subscribe('gt-starz');
    channel.bind('my-event', function(data) {
      alert(JSON.stringify(data));
    });

    var channel = pusher.subscribe('gt-starz');
    channel.bind('user-created', function(data) {
        console.log('dfsfd');
        console.log(data);
     console.log(data.data);
      //Add Notification at bottom
      const notification = `
                <div class="list-group list-group-flush" >
                    <a href="${data.url}" class="list-group-item list-group-item-action">
                      <div class="row align-items-center">
                        <div class="col-auto">
                          <!-- Avatar -->
                          <img alt="Image placeholder" src="{{ asset('assets/img/brand/white1.png') }}" class="avatar rounded-circle">
                        </div>
                        <div class="col ml--2">
                          <div class="d-flex justify-content-between align-items-center">
                            <div>
                            <h4 class="mb-0 text-sm">${data.user}</h4>
                            </div>
                            <div class="text-right text-muted">
                            <small>${data.created_at}</small>
                            </div>
                          </div>
                      <p class="text-sm mb-0">${data.message}</p>
                        </div>
                      </div>
                    </a>
                </div>`;
        $('#notifications').prepend(notification);
        const prevNotificationsCount = parseInt($('.notification-count').html());
        $('.notification-count').html(prevNotificationsCount + 1);
    });
</script>
