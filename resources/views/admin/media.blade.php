@extends('layouts.appbar')
<style type="text/css">
  .btn:focus, .btn:active, button:focus, button:active {
  outline: none !important;
  box-shadow: none !important;
}

#image-gallery .modal-footer{
  display: block;
}

.thumb{
  margin-top: 15px;
  margin-bottom: 15px;
}
</style>

<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<!------ Include the above in your HEAD tag ---------->

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
 <div class="side-app">

   <!-- CONTAINER -->
   <div class="main-container container-fluid">

                      <div class="row">

     <div class="col-12">

      @include('flash_msg')
      <div class="card">
        <div class="card-header">

         <?php 


         $uorders = \App\Models\Order::whereStatus('4')->whereWpayments('0')->count();
         $porders = \App\Models\Order::whereStatus('3')->whereWpayments('1')->count();
         $corders = \App\Models\Order::whereStatus('5')->count();



         ?>
         <nav>
           <div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
             <form action="{{route('upload_media')}}" method="post" enctype="multipart/form-data">



              @csrf


              @if (count($errors) > 0)
              <div class="alert alert-danger">
                <ul>
                  @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                  @endforeach
                </ul>
              </div>
              @endif

              <input type="file" name="file" id="chooseFile">

              <button type="submit" name="submit" class="btn btn-primary btn-sm">
                Upload
              </button>
            </form>


          </div>

        </nav>
      </div>

      <div class="card-body">
        <div class="row">
          @foreach($orders as $order)

          <div class="col-lg-3 col-md-4 col-xs-6 thumb">

            <img src="{{ get_option(site_id().'_main_site_url') }}{{$order->file_path}}" width="250">

            <input type="text" value="{{ get_option(site_id().'_main_site_url') }}{{$order->file_path}}" id="myInput">
                        <button onclick="myFunction()">Copy link</button>


                        <script>
  function myFunction() {
  // Get the text field
  var copyText = document.getElementById("myInput");

  // Select the text field
  copyText.select();
  copyText.setSelectionRange(0, 99999); // For mobile devices

  // Copy the text inside the text field
  navigator.clipboard.writeText(copyText.value);
  
  // Alert the copied text

  alert("Image Url Copied: " + copyText.value);
  $("#ModalSelect{{ $order->id}}").modal('hide');

}
</script>
          </div>







        @endforeach

      </div>
      {{ $orders->links() }}
    </div>
  </div>
</div>





</div>


</div>
</div>
</div>





@endsection

@section('page-js')
<script type="text/javascript">
  let modalId = $('#image-gallery');

$(document)
  .ready(function () {

    loadGallery(true, 'a.thumbnail');

    //This function disables buttons when needed
    function disableButtons(counter_max, counter_current) {
      $('#show-previous-image, #show-next-image')
        .show();
      if (counter_max === counter_current) {
        $('#show-next-image')
          .hide();
      } else if (counter_current === 1) {
        $('#show-previous-image')
          .hide();
      }
    }

    /**
     *
     * @param setIDs        Sets IDs when DOM is loaded. If using a PHP counter, set to false.
     * @param setClickAttr  Sets the attribute for the click handler.
     */

    function loadGallery(setIDs, setClickAttr) {
      let current_image,
        selector,
        counter = 0;

      $('#show-next-image, #show-previous-image')
        .click(function () {
          if ($(this)
            .attr('id') === 'show-previous-image') {
            current_image--;
          } else {
            current_image++;
          }

          selector = $('[data-image-id="' + current_image + '"]');
          updateGallery(selector);
        });

      function updateGallery(selector) {
        let $sel = selector;
        current_image = $sel.data('image-id');
        $('#image-gallery-title')
          .text($sel.data('title'));
        $('#image-gallery-image')
          .attr('src', $sel.data('image'));
        disableButtons(counter, $sel.data('image-id'));
      }

      if (setIDs == true) {
        $('[data-image-id]')
          .each(function () {
            counter++;
            $(this)
              .attr('data-image-id', counter);
          });
      }
      $(setClickAttr)
        .on('click', function () {
          updateGallery($(this));
        });
    }
  });

// build key actions
$(document)
  .keydown(function (e) {
    switch (e.which) {
      case 37: // left
        if ((modalId.data('bs.modal') || {})._isShown && $('#show-previous-image').is(":visible")) {
          $('#show-previous-image')
            .click();
        }
        break;

      case 39: // right
        if ((modalId.data('bs.modal') || {})._isShown && $('#show-next-image').is(":visible")) {
          $('#show-next-image')
            .click();
        }
        break;

      default:
        return; // exit this handler for other keys
    }
    e.preventDefault(); // prevent the default action (scroll / move caret)
  });

</script>
@endsection

