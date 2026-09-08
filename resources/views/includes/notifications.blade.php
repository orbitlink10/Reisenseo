        <!-- Sidebar-right -->
        <div class="sidebar sidebar-right sidebar-animate">
            <div class="panel panel-primary card mb-0 shadow-none border-0">
                <div class="tab-menu-heading border-0 d-flex p-3">
                    <div class="card-title mb-0"><i class="fe fe-bell me-2"></i><span class=" pulse"></span>Notifications</div>
                    <div class="card-options ms-auto">
                        <a href="javascript:void(0);" class="sidebar-icon text-end float-end me-3 mb-1" data-bs-toggle="sidebar-right" data-target=".sidebar-right"><i class="fe fe-x text-white"></i></a>
                    </div>
                </div>
                <div class="panel-body tabs-menu-body latest-tasks p-0 border-0">
                    <div class="tabs-menu border-bottom">
                        <!-- Tabs -->
                        <ul class="nav panel-tabs">

                            <li><a href="#side2" class="active" data-bs-toggle="tab"><i class="fe fe-message-circle"></i> Chat</a></li>
                            <li><a href="#side3" data-bs-toggle="tab"><i class="fe fe-anchor me-1"></i>Orders Timeline</a></li>

                        </ul>
                    </div>
                    <div class="tab-content">

                        <div class="tab-pane active" id="side2">
                            <div class="list-group list-group-flush">

                                <!-- FULL-SCREEN -->
                                @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
                                <div>
                                 <?php
                                 $messages = \App\Models\Chat::whereAdminMessageRead(0)->orderBy('id', 'desc')->limit(50)->get();
                                 ?>
                                 <div class="pt-3 fw-semibold ps-5"><a href="{{ route('messages')}}"> {{ $messages->count() }} Recent messages</a></div>

<div class="p-4 bg-light border">
    <div class="toast-container">
                                 @foreach($messages as $message)
                                 <?php
                                 $message_user = \App\Models\User::find($message->user_id);
                                 ?>
                                 <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                                        <div class="toast-header">
                                            <img src="{{ $message_user->get_gravatar(150) }}" alt="" class="me-2" height="18">
                                            <strong class="me-auto">
                                             @if(Auth::user()->id == $message_user->id)you: @else

                                             @if($message_user->is_writer())
                                             <a target="_blank" href="{{ route('profile', $message_user->id )}}">writer:</a> 
                                             @endif
                                             @if($message_user->is_admin())
                                             support
                                             @endif
                                             @if($message_user->is_editor())
                                             editor
                                             @endif

                                             @if($message_user->is_client())
                                             client
                                             @endif
                                             @endif
                                         </strong>
                                         <small class="text-muted">{!! $message->created_at->diffForHumans() !!}</small>
                                         <button aria-label="Close" class="btn-close fs-20"><span aria-hidden="true">×</span></button>
                                     </div>
                                     <div class="toast-body">
                                         <a href="{{ route('view_message_unread', $message->id )}}/#chat">
                                      {{ $message->messages }}<br>
                                      <small class="text-muted"> Order ID. {{ $message->order_id }}</small></a>
                                     
                                    </div>
                                </div>


                                    @endforeach
                                       </div>
                        </div>
                                </div>

                                @endif


                                <!-- FULL-SCREEN -->
                                @if(Auth::user()->is_client() or Auth::user()->is_writer() or Auth::user()->is_editor() )
                                <div>
                                 <?php
                                 $messages = \App\Models\Chat::whereMessageRead(0)->whereMessageTo(Auth::user()->id)->orderBy('id', 'desc')->limit(50)->get();
                                 ?>

                         <div class="pt-3 fw-semibold ps-5"><a href="{{ route('messages')}}"> {{ $messages->count() }} Recent messages</a></div>


                                 <div class="p-4 bg-light border">
                                    <div class="toast-container">

                                     @foreach($messages as $message)
                                     <?php
                                     $message_user = \App\Models\User::find($message->user_id);
                                     ?>
                                     <div class="toast show" role="alert" aria-live="assertive" aria-atomic="true" data-bs-autohide="false">
                                        <div class="toast-header">
                                            <img src="{{ $message_user->get_gravatar(150) }}" alt="" class="me-2" height="18">
                                            <strong class="me-auto">
                                             @if(Auth::user()->id == $message_user->id)you: @else

                                             @if($message_user->is_writer())
                                             <a target="_blank" href="{{ route('profile', $message_user->id )}}">writer:</a> 
                                             @endif
                                             @if($message_user->is_admin())
                                             support
                                             @endif
                                             @if($message_user->is_editor())
                                             editor
                                             @endif

                                             @if($message_user->is_client())
                                             client
                                             @endif
                                             @endif
                                         </strong>
                                         <small class="text-muted">{!! $message->created_at->diffForHumans() !!}</small>
                                         <button aria-label="Close" class="btn-close fs-20"><span aria-hidden="true">×</span></button>
                                     </div>
                                     <div class="toast-body">
                                         <a href="{{ route('view_message_unread', $message->id )}}/#chat">
                                      {{ $message->messages }}<br>
                                      <small class="text-muted"> Order ID. {{ $message->order_id }}</small></a>
                                     
                                    </div>
                                </div>

                                @endforeach



                            </div>
                        </div>

                        </div>

                        @endif





                    </div>
                </div>

                <div class="tab-pane" id="side3">
                    <ul class="task-list timeline-task">

                     <?php
                     $orders_timeline = \App\Models\Order::whereUserId(Auth::user()->id)->orderBy('id', 'desc')->limit(50)->get();
                     ?>          

                     @foreach($orders_timeline as $item)

                     <li class="d-sm-flex mt-4">
                        <div>
                            <i class="task-icon1"></i>
                            <h6 class="fw-semibold">Order No. {{ $item->id }} @if($item->status==0)                                                                                 
                                <span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">Pending</span>
                                @elseif($item->status==1)
                                <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Available</span>@elseif($item->status==2)
                                <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Assigned</span>
                                @elseif($item->status==3)
                                <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Editing</span>
                                @elseif($item->status==4)
                                <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Completed</span>
                                @elseif($item->status==5)
                                <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Approved</span>
                                @elseif($item->status==6)
                                <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Revision</span>
                                @elseif($item->status==7)
                                <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">Cancelled</span>
                            @endif </h6>
                            <a href="{{ route('view_order', $item->id )}}"> <h6 class="fw-semibold">{{ $item->title }}</h6></a>
                            <p class="text-muted fs-12">
                                <span class="text-muted fs-11 mx-2 fw-normal">posted {!! $item->created_at->diffForHumans() !!}</span></p>
                            </div>

                        </li>

                        @endforeach

                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
        <!--/Sidebar-right-->


        



