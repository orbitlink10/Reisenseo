@extends('layouts.appbar')



@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
 <div class="side-app">

   <!-- CONTAINER -->
   <div class="main-container container-fluid">




    <!-- Row -->
    <div class="row">

     <div class="col-xl-9">
      <div class="card">

            <div class="card-header border-bottom-0">
           <h2 class="card-title">Sms Notification</h2>
           <div class="page-options ms-auto">

              <a href="#" class="btn btn-primary btn-sm"> Sms Balance ({{ sms_balance() }}) </a>

              <a class="btn btn-success badge btn-sm" style="color: #ffffff;" data-bs-target="#buysms" data-bs-toggle="modal"><i class="fa fa-edit"></i> Buy Sms</a>

                       <!-- edit modal-->
                <div class="modal fade" id="buysms">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content country-select-modal">
                      <div class="modal-header">
                        <h6 class="modal-title">Buy Sms</h6><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                      </div>
                      <div class="modal-body">

                       <form class="form-horizontal" action="https://awaspay.com/buysms" method="POST">
                        @csrf
                        <input type="hidden" name="user_id" value="3">
                        <input type="hidden" name="callback_url" value="{{ route('sms_success')}}">
                        <input type="hidden" name="currency" value="KES">
                        <div class=" row mb-4">
                          <label class="col-md-4 form-label">Amount</label>
                          <div class="col-md-8">
                            <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid phone is required: 0725000000">
                              <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                {{Auth::user()->currency_sign}}
                              </a>
                              <input  class="input100 border-start-0 ms-0 form-control" name="amount" type="text">
                            </div>

                          </div>
                        </div>



                  



                        <div class=" row mb-4">

                          <div class="col-md-9">
                            <input type="submit" value="Pay now" class="btn btn-success">
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


                
            

                  <tr>

                   <td class="view-message dont-show fw-semibold clickable-row" data-href="{{ route('view_message_unread', $chat->id )}}/#chat">
                    Sms sent by 
                   
                    {{ username($chat->user_id)->nickname ?? 'client'}}
                   
                  </td>


                  <td class="view-message clickable-row" data-href='{{ route('view_message_unread', $chat->id )}}/#chat'>

                  
                    
                    {!! strip_tags(\Illuminate\Support\Str::limit($chat->message, 100)) !!}
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