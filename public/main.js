
    $('.upload-image-input').change( function(e) {
        let input = this;
        var url = input.value;
        var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
        if (input.files && input.files[0] && (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) {
            var reader = new FileReader();

            reader.onload = function (e) {
                var imageBox = $(input).closest('div').parent('div').find('.uploaded-image');
                console.log($(imageBox));
                $(imageBox).attr('src', e.target.result);
            }

            reader.readAsDataURL(input.files[0]);
        }else{
            swal('Check Your Image Format.');
        }
    })

$('.ask-before-delete').click( function() {
    let title = $(this).attr('title').split(" ");
    title = title[title.length-1];
    swal({
        title: "Are you sure?",
        text: "Once deleted, you will not be able to recover this "+title,
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          let form = $(this).closest('tr').find('form').submit();
        } else {
          swal("Your "+title+" file is safe!");
        }
      });
});

$('.confirm-approval-change').click( function(e) {
    e.preventDefault();
    const link = $(this).attr('href');
    console.log(link);
    const title = $(this).attr('title');
    swal({
        title: "Are you sure?",
        text: "You want to "+title,
        icon: "warning",
        buttons: true,
        dangerMode: true,
      })
      .then((willDelete) => {
        if (willDelete) {
          window.location.href = link;
        } else {
          swal("Nothing is affected.");
        }
      });

});

