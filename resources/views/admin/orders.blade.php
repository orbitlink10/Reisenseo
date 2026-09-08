@extends('layouts.appbar')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
 <div class="side-app">

   <!-- CONTAINER -->
   <div class="main-container container-fluid">
     @include('chat_count')
     <h3>@if( ! empty($title)) {{ $title }} @else Recent Orders @endif</h3>

     <div class="row ">
      <div class="col-12 col-sm-12">
        @if($orders->count()>0)
        @foreach($orders as $order)
        <div class="card">
          <div class="card-body">
           <div class="row">


            <div class="col-sm-3">

              <a href="{{ route('view_order', $order->slug )}}">
                {{ \Illuminate\Support\Str::limit($order->title, 50, '...') }}</a>@if(Auth::user()->is_client())@if($order->personal_note) ({{ $order->personal_note }})@endif @endif<br>

                <span style="font-size: 10px; color: green;">
                 @if(Auth::user()->is_admin() or Auth::user()->is_subadmin() or Auth::user()->is_student())
                 {!! remainingtime($order->order_due) !!}
                 @if($order->status==2) 
                 <br>{!! remainingtime($order->order_eddeadline) !!}<br>
                 {!! remainingtime($order->order_wrdeadline) !!}
                 @endif

                 @endif

                 @if(Auth::user()->is_client())
                 {!! remainingtime($order->order_due) !!}
                 @endif

                 @if(Auth::user()->is_writer())
                 {!! remainingtime($order->order_wrdeadline) !!}
                 @endif


                 @if(Auth::user()->is_editor())
                 {!! remainingtime($order->order_eddeadline) !!}
                 @endif
@if(Auth::user()->is_admin())
                 @if($order->completed_at)

  Completed at {!! remainingtime($order->completed_at) !!}

@endif
@endif
               </span> 

               <span style="font-size: 11px;" class="fw-semibold mt-sm-2 d-block"  >
               <a href="{{ route('view_order', $order->slug )}}">       Order No. {{ $order->id}} | {{ subject($order->category_id) }}, {{ $order->word_count }} 
                @if($order->word_count == 1) page @else pages @endif ({{ $order->word_count*275 }} words)



                @if($order->slide)
                {{ $order->slide }} 
                @if($order->slide == 1) slide @else slides @endif

                @endif

                </a>
    @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
                 @if($order->assigned_by) Assigned by: {{ $order->assigned_by }} @endif
                 @endif
              </span>


            </div>


            @if(Auth::user()->is_admin() or Auth::user()->is_client() or Auth::user()->is_subadmin() or Auth::user()->is_student())

            <div class="col-sm-2">
             <span class="fw-semibold mt-sm-2 d-block">
              @if($order->order_level == 'technical')
              @if($order->ccost>0)
              {{ price((int) $order->ccost) }}
              @else
              {{ price((int) $order->order_budget) }}
              @endif


              @else
              {{price((int) $order->ccost)}}
              @endif

              @if(domain_name() == 'saseni.com')
              (@if(Auth::user()->is_admin())
                <?php
                $total = $order->ccost - $order->wcost - $order->ecost - $order->order_admin_share - $order->subscription_fee - $order->plagiarism_report_fee - $order->preferred_writer_only_total - $order->top_ten_total;
                ?>

                {{ (int) $total }}
                @endif)
                @endif

                <br>
                @if(Auth::user()->is_admin())

                @if($order->payment_way == 0)

                <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3"> Pre pay</span>

                @else
                <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3"> Pay later</span>

                @endif
                @endif
              </span>

              @if($order->order_level == 'normal')

              <span class="badge bg-info-transparent rounded-pill text-success p-2 px-3"> Normal order</span>

              @else
              <span class="badge bg-primary-transparent rounded-pill text-primary p-2 px-3"> Technical Order</span>
              @endif


            </div>
            @endif
            @if(Auth::user()->is_editor())
            <div class="col-sm-2">
              <span
              class="fw-semibold mt-sm-2 d-block">{{price((int) $order->ecost)}}</span>

            </div>
            @endif

            @if(Auth::user()->is_writer())
            <div class="col-sm-2">
              <span
              class="fw-semibold mt-sm-2 d-block">{{price((int) $order->wcost)}}</span>

            </div>
            @endif

            @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
            <div class="col-sm-2">
              <span
              class="fw-semibold mt-sm-2 d-block">Client: @if($order->user_id) <a href="{{ route('user_info', $order->user_id )}}"><span style="font-size: 12px;">{{ username($order->user_id)->name  ?? 'none'}}</span></a> @endif
            </span>
            <span
            class="fw-semibold mt-sm-2 d-block">Editor: <a href="{{ route('user_info', $order->editor_id )}}"><span style="font-size: 12px;">{{ username($order->editor_id)->name ?? 'none' }}</span></a>
          </span>

          @if($order->writer_id)

          <span
          class="fw-semibold mt-sm-2 d-block">Writer: <a href="{{ route('user_info', $order->writer_id )}}"><span style="font-size: 12px;">{{ username($order->writer_id)->name ?? 'none' }}</span></a> 

    <a style="color: green;" href="{{ route('request_writer', ['writer_id' => $order->writer_id])}}">Hire</a>
        </span>


          @endif

        </div>
        @endif



        <div class="col-sm-2">

          @if(Auth::user()->is_client())
          @if($order->editor_id)
          <span
          class="fw-semibold mt-sm-2 d-block">Editor: <a href="{{ route('order', ['editor' => $order->editor_id] )}}"><span style="font-size: 12px;">{{ username($order->editor_id)->name ?? 'none' }}</span></a>
        </span>


        @endif
        @if($order->writer_id)

        <span
        class="fw-semibold mt-sm-2 d-block">Writer: <a href="{{ route('order', ['writer' => $order->writer_id] )}}" target="_blank"><span style="font-size: 12px;">{{ username($order->writer_id)->nickname ?? 'none' }}</span></a>

        <a style="color: green;" href="{{ route('request_writer', ['writer_id' => $order->writer_id])}}">Hire</a>

      </span>


        @endif
        @endif

      </div>




      <div class="col-sm-1">
        <div class="mt-sm-1 d-block">
          @if($order->status==0)                                                                                 
          <span class="badge bg-secondary fs-14 me-2">Pending<br>
            @if(Auth::user()->is_admin() or Auth::user()->is_editor() or Auth::user()->is_subadmin() or $order->order_level == 'technical' or Auth::user()->view_bids == 'YES') 
            <?php
            $bid_count = \App\Models\Bid::whereOrderId($order->id)->count();
            ?>
            @if(!Auth::user()->is_writer())
            <a href="{{ route('view_bids', $order->id )}}">bids({{ $bid_count }}) </a>
            
            @if($order->preferred_writer)
            <p style="color: green;"><a href="{{ route('view_bids', $order->id )}}">Preferred <br>#{{ $order->preferred_writer }} {{ username($order->preferred_writer)->nickname ?? 'none' }}</a> </p>
            @endif 

            @endif
            @endif
          </span>
          @elseif($order->status==1)
          <span class="badge bg-default fs-14 me-2">Available<br>
            @if(Auth::user()->is_admin() or Auth::user()->is_editor() or Auth::user()->is_subadmin() or Auth::user()->view_bids == 'YES') 
            <?php
            $bid_count = \App\Models\Bid::whereOrderId($order->id)->count();
            ?>
  @if(!Auth::user()->is_writer())
            <a href="{{ route('view_bids', $order->id )}}">bids({{ $bid_count }}) </a>
         
            @if($order->preferred_writer)
            
            <p style="color: green;"><a target="_blank" href="{{ route('profile', userslug($order->preferred_writer) )}}">Preferred <br>#{{ $order->preferred_writer }} {{ username($order->preferred_writer)->nickname ?? 'none' }}</a> </p>
            @endif 
               @endif
            @endif
          </span>

          @elseif($order->status==2)
          <span class="badge bg-danger fs-14 me-2">Assigned</span>
          @elseif($order->status==3)
          <span class="badge bg-primary fs-14 me-2">Editing</span>
          @elseif($order->status==4)
          <span class="badge bg-info fs-14 me-2">Completed</span>
          @elseif($order->status==5)
          <span class="badge bg-success fs-14 me-2">Approved</span>
          @elseif($order->status==6)
          <span class="badge bg-success fs-14 me-2">Revision</span>
          @elseif($order->status==7)
          <span class="badge bg-warning fs-14 me-2">Cancelled</span>
          @elseif($order->status==9)
          <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">{{ order_status(9)}}</span>
          @elseif($order->status==8)
          <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">{{ order_status(8)}}</span>
          @endif
        </div>



      </div>

      <div class="col-sm-2">
        <div class="btn-group align-top">
          <?php
          $chats_count = \App\Models\Chat::whereOrderId($order->id)->count();
          ?>
          <a href="{{ route('view_order', $order->slug ) }}/#chat" class="btn btn-sm btn-default badge"><i class="fa fa-comments"></i> {{ $chats_count }}</a>

          @if(Auth::user()->is_admin()  or Auth::user()->is_subadmin())
          @if($order->status!=0) 
          <a href="{{ route('edit_order', $order->id )}}" class="btn btn-sm btn-primary badge"><i class="fa fa-edit"></i> Edit</a> 
          @endif
          @endif

          @if(Auth::user()->is_client() or Auth::user()->is_student())
          @if($order->status==0 or $order->payment_way == 1)
          @if($order->ccost>0)    
          <a class="btn btn-sm btn-success badge" style="color: #ffffff;" data-bs-target="#confirm-order{{ $order->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Pay Now</a>
          @endif 
          @endif
          @endif




          @if(Auth::user()->is_editor())
          @if(!$order->editor_id)
          @if($order->ecost>0)
          @if($order->status==3)
          <a class="btn btn-sm btn-warning badge" data-bs-target="#pick{{ $order->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Pick Order
          </a>

          @endif

          <!-- edit modal--> 
          <div class="modal fade" id="pick{{ $order->id }}">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content country-select-modal">
                <div class="modal-header">
                  <h6 class="modal-title">Pick order #{{ $order->id }}</h6><button aria-label="Close" class="btn-close"
                  data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                </div>


                <div class="modal-body">
                  <form class="form-horizontal" action="{{ route('epick_order')}}" method="POST">
                    @csrf
                    <input type="hidden" name="order_id" value="{{ $order->id }}">
                    <p>Are you sure you want to pick this order</p>
                    @if($order->order_level == 'technical')
                    <div class=" row mb-4">
                     <label class="col-md-4 form-label">My Budget is ( {{ get_option(site_id().'_currency_sign') }})</label>
                     <div class="col-md-8">
                       <input type="number"  class="form-control" name="writer_budget" value="0">
                     </div>
                   </div>

                   @endif
                   <div class=" row mb-4">

                    <div class="col-md-9">
                     <input type="submit" value="Yes, Proceed" class="btn btn-primary">
                   </div>


                 </div>



               </form>
             </div>
           </div>
         </div>
       </div>
       @endif
       @else
       <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Picked</span>       
       @endif
       @endif

       <nav class="nav">

        <div class="dropdown">
          <a class="nav-link" href="javascript:void(0)" data-bs-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><i class="fe fe-more-vertical"></i></a>
          <div class="dropdown-menu dropdown-menu-end">
            @if(!Auth::user()->is_writer())
 

            <a href="{{ route('edit_order', $order->id )}}" class="dropdown-item"><i class="fa fa-edit"></i> Edit Order</a>


@if(Auth::user()->is_admin())
            <a class="dropdown-item" data-bs-target="#delete-order{{ $order->id }}" data-bs-toggle="modal"><i class="fa fa-trash"></i> Delete Order
            </a>

            <a class="dropdown-item" data-bs-target="#cancel-order{{ $order->id }}" data-bs-toggle="modal"><i class="fa fa-trash"></i> Cancel Order
            </a>
@endif
     

            <a class="dropdown-item" data-bs-target="#duplicate-order{{ $order->id }}" data-bs-toggle="modal"><i class="fa fa-clone"></i> Create Similar Order
            </a>


            @endif
          </div>
        </div>
      </nav>




      <!-- delete modal-->
      <div class="modal fade" id="duplicate-order{{ $order->id }}">
       <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content country-select-modal">
           <div class="modal-header">
             <h6 class="modal-title">Confirm you want to duplicate #{{ $order->id }}</h6><button aria-label="Close" class="btn-close"
             data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
           </div>
           <div class="modal-body">
             <form class="form-horizontal" action="{{ route('duplicate_order')}}" method="POST">
               @csrf
               <input type="hidden" name="id" value="{{ $order->id }}">


               <div class=" row mb-4">


                <p>Are you sure you want to duplicate this order?</p>
              </div>


              <div class=" row mb-4">

               <div class="col-md-9">


                <input type="submit" value="Yes Proceed" class="btn btn-info">


              </div>


            </div>



          </form>
        </div>
      </div>
    </div>
  </div>



  <!-- delete modal-->
  <div class="modal fade" id="delete-order{{ $order->id }}">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content country-select-modal">
       <div class="modal-header">
         <h6 class="modal-title">Confirm you want to delete #{{ $order->id }}</h6><button aria-label="Close" class="btn-close"
         data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
       </div>
       <div class="modal-body">
         <form class="form-horizontal" action="{{ route('delete_order')}}" method="POST">
           @csrf
           <input type="hidden" name="id" value="{{ $order->id }}">


           <div class=" row mb-4">


            <p>Are you sure you want to delete this order?</p>
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



  <!-- delete modal-->
  <div class="modal fade" id="cancel-order{{ $order->id }}">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content country-select-modal">
       <div class="modal-header">
         <h6 class="modal-title">Confirm you want to cancel #{{ $order->id }}</h6><button aria-label="Close" class="btn-close"
         data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
       </div>
       <div class="modal-body">
         <form class="form-horizontal" action="{{ route('acancel_order')}}" method="POST">
           @csrf
           <input type="hidden" name="id" value="{{ $order->id }}">


           <div class=" row mb-4">


            <p>Are you sure you want to cancel this order?</p>
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


<!-- edit modal-->
<div class="modal fade" id="confirm-order{{ $order->id }}">
 <div class="modal-dialog modal-dialog-centered" role="document">
   <div class="modal-content country-select-modal">
     <div class="modal-header">
       <h6 class="modal-title">Confirm to allow our writers to work on your project #{{ $order->id }}</h6><button aria-label="Close" class="btn-close"
       data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
     </div>
     <div class="modal-body">
       <form class="form-horizontal" action="{{ route('confirm_order')}}" method="POST">
         @csrf
         <input type="hidden" name="id" value="{{ $order->id }}">
         <div class=" row mb-4">
           <label class="col-md-3 form-label">Title</label>
           <div class="col-md-9">
             <input type="text" class="form-control" name="name" value="{{ $order->title }}" disabled="">
           </div>
         </div>

         <div class=" row mb-4">
           <label class="col-md-3 form-label">Amount ({{ get_currency() }})</label>
           <div class="col-md-9">
             <input type="text"  class="form-control" name="amount" value="{{ $order->ccost }}" disabled="">
           </div>


         </div>


         <div class=" row mb-4">
          @if($order->urgency_id)
          <div class="col-md-9">


            <?php 

            $pricing = \App\Models\Pricing::find($order->urgency_id);
            ?>                                          
            @if($order->word_count <= $pricing->max_page)
            @if(wallet(Auth::user()->id)<$order->ccost)
            <input type="submit" value="Pay {{ get_currency() }} {{ $order->ccost - wallet(Auth::user()->id) }}" class="btn btn-success">
            @else

            <input type="submit" value="Submit" class="btn btn-primary">

            @endif

            @else

            <p class="alert alert-danger"><strong>{!! remainingtime($order->order_due) !!}</strong> <br>Sorry, we can not deliver the task within specified deadline, kindly adjust it if posible</p>

            <a href="{{ route('edit_order', $order->id )}}" class="btn btn-sm btn-primary badge"><i class="fa fa-edit"></i> Edit</a>

            <input type="submit" value="Just Work On It" class="btn btn-primary">

            @endif
          </div>

          @else

          <p class="alert alert-danger"><strong>{!! remainingtime($order->order_due) !!}</strong> <br>Sorry, we can not deliver the task with specified deadline, kindly adjust it if posible</p>

          <input type="submit" value="Just Work On It" class="btn btn-primary">

          @endif


        </div>



      </form>
    </div>
  </div>
</div>
</div>
</div>

</div>

</div>
</div>
</div>
@endforeach
@else
No order available
@endif

{{$orders->links("pagination::bootstrap-4")}}
</div>
</div>


<div class="row ">

  <div class="col-12 col-sm-12">
    @if( ! empty($show_inquiry))  
    @if($show_inquiry == '1')

    <?php


    $torders = \App\Models\Order::whereOrderLevel('technical')->whereStatus(0)->orderBy('id', 'desc')->paginate(50);

      if(Auth::user()->added_by == 'client'){

      $torders = \App\Models\Order::whereOrderLevel('technical')->whereStatus(0)->whereUserId(Auth::user()->user_id)->orderBy('id', 'desc')->paginate(50); 
  }
    ?>

    @if($torders->count()>0)
    @foreach($torders as $order)
    <div class="card">
      <div class="card-body">
        <div class="row">
         <div class="col-sm-1">
          <div class="mt-0 mt-sm-2 d-block">
            <h6
            class="mb-0 fs-14 fw-semibold">
            #{{ $order->id}}</h6>



          </div>

        </div>

        <div class="col-sm-3">
          <a href="{{ route('view_order', $order->slug )}}">
            {{ \Illuminate\Support\Str::limit($order->title, 50, '...') }}</a>@if(Auth::user()->is_client())@if($order->personal_note) ({{ $order->personal_note }})@endif @endif<br>
            <span style="font-size: 10px; color: green;">
             @if(Auth::user()->is_client() or Auth::user()->is_admin() or Auth::user()->is_subadmin() or Auth::user()->is_student())
             {!! remainingtime($order->order_due) !!}
             @if($order->status==2) 
             <br>{!! remainingtime($order->order_eddeadline) !!}<br>
             {!! remainingtime($order->order_wrdeadline) !!}
             @endif

             @endif

             @if(Auth::user()->is_writer())
             {!! remainingtime($order->order_wrdeadline) !!}
             @endif


             @if(Auth::user()->is_editor())
             {!! remainingtime($order->order_eddeadline) !!}
             @endif
           </span> 

           <span style="font-size: 11px;" class="fw-semibold mt-sm-2 d-block"  >                        
            {{ subject($order->category_id) }}

            @if($order->word_count)
            {{ $order->word_count }} 
            @if($order->word_count == 1) page @else pages @endif ({{ $order->word_count*275 }} words)

            @endif

            @if($order->slide)
            {{ $order->slide }} 
            @if($order->slide == 1) slide @else slides @endif
          </span>
          @endif

        </div>


        @if(Auth::user()->is_admin() or Auth::user()->is_client() or Auth::user()->is_subadmin() or Auth::user()->is_student())
        <div class="col-sm-2">
         <span class="fw-semibold mt-sm-2 d-block">
          {{price((int) $order->ccost)}}

          (@if(Auth::user()->is_admin())
            <?php
            $total = $order->ccost - $order->wcost - $order->ecost - $order->order_admin_share - $order->subscription_fee - $order->plagiarism_report_fee - $order->preferred_writer_only_total - $order->top_ten_total;
            ?>

            {{ (int) $total }}
            @endif)

            <br>
            @if(Auth::user()->is_admin())

            @if($order->payment_way == 0)

            <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3"> Pre pay</span>

            @else
            <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3"> Pay later</span>

            @endif
            @endif
          </span>

          @if($order->order_level == 'normal')

          <span class="badge bg-info-transparent rounded-pill text-success p-2 px-3"> Normal order</span>

          @else
          <span class="badge bg-primary-transparent rounded-pill text-primary p-2 px-3"> Technical Order</span>
          @endif


        </div>
        @endif
        @if(Auth::user()->is_editor())
        <div class="col-sm-2">
          <span
          class="fw-semibold mt-sm-2 d-block">{{price((int) $order->ecost)}}</span>

        </div>
        @endif

        @if(Auth::user()->is_writer())
        <div class="col-sm-2">

          @if($order->wcost < 1)

          <span
          class="fw-semibold mt-sm-2 d-block" >Inquiry</span>

        </div>

        @else
        <span
        class="fw-semibold mt-sm-2 d-block">{{price((int) $order->wcost)}}</span>

      </div>

      @endif


      @endif

      @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
      <div class="col-sm-1">
        <span
        class="fw-semibold mt-sm-2 d-block">Editor<br><a href="{{ route('user_info', $order->editor_id )}}">{{ username($order->editor_id)->name ?? 'none' }}</a>
      </span>

    </div>
    @endif

    @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
    <div class="col-sm-1">
      <span
      class="fw-semibold mt-sm-2 d-block">Client<br><a href="{{ route('user_info', $order->user_id )}}">{{ username($order->user_id)->name }}</a>
    </span>

  </div>
  @endif

  @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
  @if($order->writer_id)
  <div class="col-sm-1">
    <span
    class="fw-semibold mt-sm-2 d-block">Writer<a href="{{ route('user_info', $order->writer_id )}}"><br>{{ username($order->writer_id)->name ?? 'none' }}</a></span>

  </div>
  @endif
  @endif

  @if(Auth::user()->is_client())

  @if($order->editor_id)
  <div class="col-sm-1">
    <span
    class="fw-semibold mt-sm-2 d-block">Editor<br><a href="{{ route('user_info', $order->editor_id )}}">{{ username($order->editor_id)->name ?? 'none' }}</a>
  </span>

</div>
@endif
@if($order->writer_id)
<div class="col-sm-2">
  <span
  class="fw-semibold mt-sm-2 d-block">Writer: <a href="{{ route('order', ['writer' => $order->writer_id] )}}" target="_blank">{{ username($order->writer_id)->nickname ?? 'none' }}</a>

 <a style="color: green;" href="{{ route('request_writer', ['writer_id' => $order->writer_id])}}">Hire</a>

</span>

</div>
@endif
@endif




<div class="col-sm-1">
  <div class="mt-sm-1 d-block">
    @if($order->status==0)                                                                                 
    <span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">Pending<br>
      @if(Auth::user()->is_admin() or Auth::user()->is_editor() or Auth::user()->is_subadmin()) 
      <?php
      $bid_count = \App\Models\Bid::whereOrderId($order->id)->count();
      ?>
  @if(!Auth::user()->is_writer())
            <a href="{{ route('view_bids', $order->id )}}">bids({{ $bid_count }}) </a>
            
      @if($order->preferred_writer)
      <p style="color: green;"><a href="{{ route('view_bids', $order->id )}}">Preferred <br>#{{ $order->preferred_writer }} {{ username($order->preferred_writer)->nickname ?? 'none' }}</a> </p>
      @endif 
      @endif
      @endif
    </span>
    @elseif($order->status==1)
    <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Available<br>
      @if(Auth::user()->is_admin() or Auth::user()->is_editor() or Auth::user()->is_subadmin()) 
      <?php
      $bid_count = \App\Models\Bid::whereOrderId($order->id)->count();
      ?>
  @if(!Auth::user()->is_writer())
            <a href="{{ route('view_bids', $order->id )}}">bids({{ $bid_count }}) </a>
          
      @if($order->preferred_writer)
      <p style="color: green;"><a target="_blank" href="{{ route('profile', userslug($order->preferred_writer) )}}">Preferred <br>#{{ $order->preferred_writer }} {{ username($order->preferred_writer)->nickname ?? 'none' }}</a> </p>
      @endif 
        @endif
      @endif
    </span>
    @elseif($order->status==2)
    <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Assigned</span>
    @elseif($order->status==3)
    <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Editing</span>
    @elseif($order->status==4)
    <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Completed</span>
    @elseif($order->status==5)
    <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Approved</span>
    @elseif($order->status==6)
    <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Revision</span>
    @elseif($order->status==7)
    <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">Cancelled</span>
    @endif
  </div>



</div>

<div class="col-sm-2">
  <div class="btn-group align-top">

   @if(Auth::user()->is_admin()  or Auth::user()->is_subadmin())
   @if($order->status!=0) 
   <a href="{{ route('edit_order', $order->id )}}" class="btn btn-sm btn-primary badge"><i class="fa fa-edit"></i> Edit</a> 
   @endif
   @endif

   @if(Auth::user()->is_client() or Auth::user()->is_student())
   @if($order->status==0 or $order->payment_way == 1)
   @if($order->ccost>0)    
   <a class="btn btn-sm btn-success badge" style="color: #ffffff;" data-bs-target="#confirm-order{{ $order->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Pay Now</a>
   @endif 
   @endif
   @endif




   @if(Auth::user()->is_editor())
   @if(!$order->editor_id)
   @if($order->ecost>0)
   @if($order->status==3)
   <a class="btn btn-sm btn-warning badge" data-bs-target="#pick{{ $order->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Pick Order
   </a>
   @endif
   <!-- edit modal--> 
   <div class="modal fade" id="pick{{ $order->id }}">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content country-select-modal">
        <div class="modal-header">
          <h6 class="modal-title">Pick order #{{ $order->id }}</h6><button aria-label="Close" class="btn-close"
          data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
        </div>


        <div class="modal-body">
          <form class="form-horizontal" action="{{ route('epick_order')}}" method="POST">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <p>Are you sure you want to pick this order</p>
            @if($order->order_level == 'technical')
            <div class=" row mb-4">
             <label class="col-md-4 form-label">My Budget is ( {{ get_option(site_id().'_currency_sign') }})</label>
             <div class="col-md-8">
               <input type="number"  class="form-control" name="writer_budget" value="0">
             </div>
           </div>

           @endif
           <div class=" row mb-4">

            <div class="col-md-9">
             <input type="submit" value="Yes, Proceed" class="btn btn-primary">
           </div>


         </div>



       </form>
     </div>
   </div>
 </div>
</div>
@endif
@else
<span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Picked</span>       
@endif
@endif

@if(!Auth::user()->is_writer())
@if($order->status==0 or $order->status==7)
<a href="{{ route('edit_order', $order->id )}}" class="btn btn-sm btn-primary badge"><i class="fa fa-edit"></i> Edit</a>

<a style="color: #ffffff;" class="btn btn-sm btn-danger" data-bs-target="#delete-order{{ $order->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Delete</a>
@endif 
@endif


<!-- delete modal-->
<div class="modal fade" id="delete-order{{ $order->id }}">
 <div class="modal-dialog modal-dialog-centered" role="document">
   <div class="modal-content country-select-modal">
     <div class="modal-header">
       <h6 class="modal-title">Confirm you want to delete #{{ $order->id }}</h6><button aria-label="Close" class="btn-close"
       data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
     </div>
     <div class="modal-body">
       <form class="form-horizontal" action="{{ route('delete_order')}}" method="POST">
         @csrf
         <input type="hidden" name="id" value="{{ $order->id }}">


         <div class=" row mb-4">


          <p>Are you sure you want to delete this order?</p>
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


<!-- edit modal-->
<div class="modal fade" id="confirm-order{{ $order->id }}">
 <div class="modal-dialog modal-dialog-centered" role="document">
   <div class="modal-content country-select-modal">
     <div class="modal-header">
       <h6 class="modal-title">Confirm to allow our writers to work on your project #{{ $order->id }}</h6><button aria-label="Close" class="btn-close"
       data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
     </div>
     <div class="modal-body">
       <form class="form-horizontal" action="{{ route('confirm_order')}}" method="POST">
         @csrf
         <input type="hidden" name="id" value="{{ $order->id }}">
         <div class=" row mb-4">
           <label class="col-md-3 form-label">Title</label>
           <div class="col-md-9">
             <input type="text" class="form-control" name="name" value="{{ $order->title }}" disabled="">
           </div>
         </div>

         <div class=" row mb-4">
           <label class="col-md-3 form-label">Amount ({{ get_currency() }})</label>
           <div class="col-md-9">
             <input type="text"  class="form-control" name="amount" value="{{ $order->ccost }}" disabled="">
           </div>


         </div>


         <div class=" row mb-4">
          @if($order->urgency_id)
          <div class="col-md-9">


            <?php 

            $pricing = \App\Models\Pricing::find($order->urgency_id);
            ?>                                          
            @if($order->word_count <= $pricing->max_page)
            @if(wallet(Auth::user()->id)<$order->ccost)
            <input type="submit" value="Pay {{ get_currency() }} {{ $order->ccost - wallet(Auth::user()->id) }}" class="btn btn-success">
            @else

            <input type="submit" value="Submit" class="btn btn-primary">

            @endif

            @else

            <p class="alert alert-danger"><strong>{!! remainingtime($order->order_due) !!}</strong> <br>Sorry, we can not deliver the task within specified deadline, kindly adjust it if posible</p>

            <a href="{{ route('edit_order', $order->id )}}" class="btn btn-sm btn-primary badge"><i class="fa fa-edit"></i> Edit</a>

            <input type="submit" value="Just Work On It" class="btn btn-primary">

            @endif
          </div>

          @else

          <p class="alert alert-danger"><strong>{!! remainingtime($order->order_due) !!}</strong> <br>Sorry, we can not deliver the task with specified deadline, kindly adjust it if posible</p>

          <input type="submit" value="Just Work On It" class="btn btn-primary">

          @endif


        </div>



      </form>
    </div>
  </div>
</div>
</div>
</div>

</div>
</div>
</div>
</div>
@endforeach

@else
No order inquiry requested
@endif
@endif
@endif

</div>

</div>





</div>
</div>
</div>





@endsection