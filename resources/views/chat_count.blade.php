  
@if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
<?php
$messages      = \App\Models\Chat::whereAdminMessageRead(0)->orderBy('id', 'desc')->limit(50)->get();
$messages_count  = \App\Models\Chat::whereAdminMessageRead(0)->count();
?>
@else

<?php
$messages = \App\Models\Chat::whereMessageRead(0)->whereMessageTo(Auth::user()->id)->orderBy('id', 'desc')->limit(50)->get();
$messages_count = \App\Models\Chat::whereMessageRead(0)->whereMessageTo(Auth::user()->id)->count();
?>
@endif
@if($messages_count > 0)
<div class="row">
  <div class="col-12">
      <div class="pull-right">  
          <a role="button"  class="btn btn-info" data-bs-toggle="sidebar-right" data-target=".sidebar-right">
              Hi {{ username(Auth::user())->name }}, You have {{ $messages_count }} unread chats
          </a>
      </div>
  </div>
</div>

<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>


 <script>
    $( document ).ready(function() {


      $('body').addClass('timer-alert');
      var message = $("#message").val();
      var title = $("#title").val();
      if (message == "") {
        message = "Your message";
    }
    if (title == "") {
        title = "Your message";
    }
    message += "(close after 2 seconds)";
    swal({
        title: title,
        text: message,
        timer: 2000,
        showConfirmButton: false,
        html:true, title:' Hi {{ username(Auth::user())->name }},', text:'<b>You have {{ $messages_count }} unread chats</b><br> <a href="{{ route("messages")}}" class="btn btn-info" >View Now</a><br><br>(closes after 2 seconds)'
    });


});


</script> 





@endif