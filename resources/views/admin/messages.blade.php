@extends('layouts.appbar')



@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
 <div class="side-app">

   <!-- CONTAINER -->
   <div class="main-container container-fluid">

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


    <!-- Row -->
    <div class="row">

     <div class="col-xl-9">
      <div class="card">

            <div class="card-header border-bottom-0">
           <h2 class="card-title">Messages</h2>
           <div class="page-options ms-auto">

              <a href="{{ route('messages', ['status'=>'inbox']) }}" class="btn btn-primary"> Inbox ({{ $in_count }})</a>

              <a href="{{ route('messages', ['status'=>'sent']) }}" class="btn btn-primary"> Sents ({{ $out_count }})</a>

    

                 <a style="color: #ffffff;" class="btn btn-sm btn-danger" data-bs-target="#mark-read" data-bs-toggle="modal"><i class="fa fa-check"></i> Mark all as read ( {{ $messages_count }})</a>


                   <!-- delete modal-->
        <div class="modal fade" id="mark-read">
         <div class="modal-dialog modal-dialog-centered" role="document">
           <div class="modal-content country-select-modal">
             <div class="modal-header">
               <h6 class="modal-title">Confirm you want mark all unread message as read</h6><button aria-label="Close" class="btn-close"
               data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
             </div>
             <div class="modal-body">
               <form class="form-horizontal" action="{{ route('mark_read')}}" method="POST">
                 @csrf
            
                 <div class=" row mb-4">


                  <p>Are you sure you want to mark them?</p>
                </div>


                <div class=" row mb-4">

                 <div class="col-md-9">


                  <input type="submit" value="Yes Proceed" class="btn btn-danger">


                </div>


              </div>



            </form>
          </div>
        </div>
      </div>
    </div>
           </div>
         </div>

        <div class="card-body p-6">
          <div class="inbox-body">
          

            @if($chats->count())
            <div class="table-responsive">
              <table class="table table-inbox table-hover text-nowrap mb-0">
                <tbody>
                  @foreach($chats as $chat)


                  <?php

                  $order =  \App\Models\Order::find($chat->order_id);
                  $order_count =  \App\Models\Order::whereId($chat->order_id)->count();

                  ?>
                  @if($order_count>0)

                  <tr>

                   <td class="view-message dont-show fw-semibold clickable-row" data-href="{{ route('view_message_unread', $chat->id )}}/#chat">
                    message to 
                    @if(is_numeric($chat->message_to))
                    {{ username($chat->message_to)->nickname ?? 'client'}}
                    @else
                    {{ $chat->message_to }}
                    @endif
                  </td>


                  <td class="view-message clickable-row" data-href='{{ route('view_message_unread', $chat->id )}}/#chat'>

                  
                    
                    {!! strip_tags(\Illuminate\Support\Str::limit($chat->messages, 50)) !!}
                  </td>
                  <td class="view-message text-end fw-semibold clickable-row" data-href="{{ route('view_message_unread', $chat->id )}}/#chat">
                    {{ $chat->created_at->diffForHumans() }}
                  </td>
                  @if(Auth::user()->is_admin())
                  @if($chat->feature == '0')
                  <td class="inbox-small-cells"><a href="{{ route('change_user_feature', ['id' => $chat->id] )}}"><i class="fa fa-star-o inbox-started"></i></a></td>
                  @else
                  <td class="inbox-small-cells"><i class="fa fa-star inbox-started"></i></td>
                  @endif
<td>
     <a class="nav-link" data-bs-target="#delete-message{{ $chat->id }}" data-bs-toggle="modal"><i class="fe fe-more-vertical"></i></a> 

          <!-- edit modal-->
          <div class="modal fade" id="delete-message{{ $chat->id }}">
           <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content country-select-modal">
               <div class="modal-header">
                 <h6 class="modal-title">Delete message with #{{ $chat->id }}</h6><button aria-label="Close" class="btn-close"
                 data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
               </div>
               <div class="modal-body">
                 <form class="form-horizontal" action="{{ route('delete_message')}}" method="POST">
                   @csrf
                   <input type="hidden" name="chat_id" value="{{ $chat->id }}">


                   <div class=" row mb-4">
                    <p>Are you sure you want to delete below message?<br>{!! $chat->messages !!}</p>


                  </div>


                  <div class=" row mb-4">

                   <div class="col-md-9">


                    <input type="submit" value="Yes Delete" class="btn btn-danger">


                  </div>


                </div>



              </form>
            </div>
          </div>
        </div>
      </div>
</td>
                   
                  @endif


                </tr>

                @endif

                @endforeach




              </tbody>
            </table>

          </div>
          @else
          <p>No messages</p>
          @endif
        </div>
      </div>
    </div>
    <ul class="pagination mb-4">
     {{$chats->links("pagination::bootstrap-4")}}
   </ul>
 </div>
</div>
<!--End Row -->


</div>
</div>
</div>





@endsection