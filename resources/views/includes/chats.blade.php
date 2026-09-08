<?php
$chats = \App\Models\Chat::whereOrderId($order_id)->orderBy('id', 'asc')->get();
?>
@if($chats->count()>0)
@foreach($chats as $chat2)
@if(Auth::user()->id == $chat2->user_id)

<div class="media flex-row-reverse chat-right">
  @else
  <div class="media chat-left"> 
    @endif


    <?php
    $user = \App\Models\User::whereId($chat2->message_from)->first();
    ?>
    
    <div class="main-img-user online"><img alt="avatar" src="{{ $user->get_gravatar(150) }}">

    </div>

    
    <div class="media-body">
      <div class="main-msg-wrapper">
        {!! $chat2->messages !!}
        
      </div>

      


      <div>

        <span> 

         @if(Auth::user()->id == $chat2->user_id)you: @else
         
         @if($user->is_writer())
         <a target="_blank" href="{{ route('profile', $user->slug )}}">writer:</a> 
         @endif
         @if($user->is_admin())
         support:
         @endif
         @if($user->is_editor())
         editor:
         @endif

         @if($user->is_client())
         client:
         @endif
         @endif {!! $chat2->created_at->diffForHumans() !!}
       </span> 
@if($chat2->message_read == 0)
       <span>, not seen</span>
       @else
     <span style="color: green;">, seen</span>   
@endif





          @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
          
      @endif
    </a>
  </div>
</div>
</div>
<br> <br> <br>
@endforeach
@else
<center><h3>No messages available</h3>
  <i class="fa fa-comments-o fa-2xl"></i></center>

  @endif
</div>

