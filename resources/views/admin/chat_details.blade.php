@extends('layouts.appbar')



@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
 <div class="side-app">

   <!-- CONTAINER -->
   <div class="main-container container-fluid">



    <!-- Row -->
    <div class="row" style="padding-top: 20px;">

      <div class="col-xl-9">

        <div class="card">
          <div class="main-content-app pt-0">
           <div class="main-content-body main-content-body-chat h-100">
            <div class="main-chat-header pt-3 d-block d-sm-flex">

              <div class="main-chat-msg-name mt-2">
                <h6>Messages for order <a href="{{ route('view_order', $chat->order_id )}}">#{{ $chat->order_id }}</a></h6>
               
              </div>
              <nav class="nav">

                <div class="dropdown">
                  <a class="nav-link" href="javascript:void(0)" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-horizontal"></i></a>
                  <div class="dropdown-menu dropdown-menu-end">
                    <a class="dropdown-item" href="javascript:void(0)"><i class="fe fe-phone-call me-1"></i> Phone Call</a>
                    <a class="dropdown-item" href="javascript:void(0)"><i class="fe fe-video me-1"></i> Video Call</a>
                    <a class="dropdown-item" href="javascript:void(0)"><i class="fe fe-user-plus me-1"></i> Add Contact</a>
                    <a class="dropdown-item" href="javascript:void(0)"><i class="fe fe-trash-2 me-1"></i> Delete</a>
                  </div>
                </div>
              </nav>
            </div>
            <!-- main-chat-header -->
            <div class="main-chat-body flex-2" id="ChatBody">
              <div class="content-inner">
            

             



                @foreach($chats as $chat2)
                @if(Auth::user()->id == $chat2->user_id)
               
                   <div class="media flex-row-reverse chat-right">
                @else
                    <div class="media chat-left"> 
                @endif
            
               
                  <div class="main-img-user online"><img alt="avatar" src="{{ asset('assets/images/users/1.jpg')}}"></div>
                  <div class="media-body">
                    <div class="main-msg-wrapper">
                      {!! $chat2->messages !!}
                    </div>

                    <div>
                      <span> @if(Auth::user()->id == $chat2->user_id)you: @else
                        <?php
                 $user = \App\Models\User::whereId($chat2->message_from)->first();
                        ?>
                        @if($user->is_writer())
                        writer:
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
                        @endif {!! $chat2->created_at->diffForHumans() !!}</span> <a href="javascript:void(0)"><i class="icon ion-android-more-horizontal"></i></a>
                    </div>
                  </div>
                </div>
                <br> <br> <br>
                @endforeach





              </div>
            </div>
            <form class="form-horizontal" action="{{ route('reply_message')}}" method="POST">
              @csrf

              <input type="hidden" name="chat_id" value="{{ $chat->id }}">
              <div class="main-chat-footer">
                <input class="form-control" name="message" placeholder="Type your message here..." type="text">
                <a class="nav-link" data-bs-toggle="tooltip" href="javascript:void(0)" title="Attach a File"><i class="fe fe-paperclip"></i></a>
                <button type="submit" class="btn btn-icon  btn-primary brround"><i class="fa fa-paper-plane-o"></i></button>
                <nav class="nav">
                </nav>
              </div>
            </form>
          </div>
        </div>
      </div>


   
</div>
</div>
<!--End  Row -->


</div>
</div>
</div>





@endsection

@section('page-js')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="{{ asset('assets/js/chat.js')}}"></script>
@endsection