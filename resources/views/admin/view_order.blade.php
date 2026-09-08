@extends('layouts.appbar')

<script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js"></script>
<style>

.sticky-top {
   position: -webkit-sticky;
   position: sticky;
   top: 0;
   padding-top: 80px;
   font-size: 25px;
 }
 .rate {
   float: left;
   height: 75px;
   padding: 0 10px;
 }

 .rate:not(:checked) > input {
   display: none;
 }



 .rate:not(:checked) > label {
   float:right;
   overflow:hidden;
   font-size:15px;
   color:#ccc;
 }

 .rate:not(:checked) > label:before {
   content: '★ ';
 }

 .rate > input:checked ~ label {
   color: #ffc700;
 }
 .rate:not(:checked) > label:hover,
 .rate:not(:checked) > label:hover ~ label {
   color: #deb217;
 }
 .rate > input:checked + label:hover,
 .rate > input:checked + label:hover ~ label,
 .rate > input:checked ~ label:hover,
 .rate > input:checked ~ label:hover ~ label,
 .rate > label:hover ~ input:checked ~ label {
   color: #c59b08;
 }
 .star-rating-complete{
  color: #c59b08;
}
.rating-container .form-control:hover, .rating-container .form-control:focus{
 background: #fff;
 border: 1px solid #ced4da;
}
.rating-container textarea:focus, .rating-container input:focus {
 color: #000;
 }         .rated {
   float: left;
   height: 46px;
   padding: 0 10px;
 }
 .rated:not(:checked) > input {
   position:absolute;
   display: none;
 }
 .rated:not(:checked) > label {
   float:right;
   width:1em;
   overflow:hidden;
   white-space:nowrap;
   cursor:pointer;
   font-size:30px;
   color:#ffc700;
 }
 .rated:not(:checked) > label:before {
   content: '★ ';
 }
 .rated > input:checked ~ label {
   color: #ffc700;
 }
 .rated:not(:checked) > label:hover,
 .rated:not(:checked) > label:hover ~ label {
   color: #deb217;
 }
 .rated > input:checked + label:hover,
 .rated > input:checked + label:hover ~ label,
 .rated > input:checked ~ label:hover,
 .rated > input:checked ~ label:hover ~ label,
 .rated > label:hover ~ input:checked ~ label {
   color: #c59b08;
 }




 .star-rating {
  font-size: 0;
  white-space: nowrap;
  display: inline-block;
  /* width: 250px; remove this */
  height: 50px;
  overflow: hidden;
  position: relative;
  background: url('data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMjBweCIgaGVpZ2h0PSIyMHB4IiB2aWV3Qm94PSIwIDAgMjAgMjAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDIwIDIwIiB4bWw6c3BhY2U9InByZXNlcnZlIj48cG9seWdvbiBmaWxsPSIjREREREREIiBwb2ludHM9IjEwLDAgMTMuMDksNi41ODMgMjAsNy42MzkgMTUsMTIuNzY0IDE2LjE4LDIwIDEwLDE2LjU4MyAzLjgyLDIwIDUsMTIuNzY0IDAsNy42MzkgNi45MSw2LjU4MyAiLz48L3N2Zz4=');
  background-size: contain;
}
.star-rating i {
  opacity: 0;
  position: absolute;
  left: 0;
  top: 0;
  height: 100%;
  /* width: 20%; remove this */
  z-index: 1;
  background: url('data:image/svg+xml;base64,PHN2ZyB2ZXJzaW9uPSIxLjEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IiB3aWR0aD0iMjBweCIgaGVpZ2h0PSIyMHB4IiB2aWV3Qm94PSIwIDAgMjAgMjAiIGVuYWJsZS1iYWNrZ3JvdW5kPSJuZXcgMCAwIDIwIDIwIiB4bWw6c3BhY2U9InByZXNlcnZlIj48cG9seWdvbiBmaWxsPSIjRkZERjg4IiBwb2ludHM9IjEwLDAgMTMuMDksNi41ODMgMjAsNy42MzkgMTUsMTIuNzY0IDE2LjE4LDIwIDEwLDE2LjU4MyAzLjgyLDIwIDUsMTIuNzY0IDAsNy42MzkgNi45MSw2LjU4MyAiLz48L3N2Zz4=');
  background-size: contain;
}
.star-rating input {
  -moz-appearance: none;
  -webkit-appearance: none;
  opacity: 0;
  display: inline-block;
  /* width: 20%; remove this */
  height: 100%;
  margin: 0;
  padding: 0;
  z-index: 2;
  position: relative;
}
.star-rating input:hover + i,
.star-rating input:checked + i {
  opacity: 1;
}
.star-rating i ~ i {
  width: 40%;
}
.star-rating i ~ i ~ i {
  width: 60%;
}
.star-rating i ~ i ~ i ~ i {
  width: 80%;
}
.star-rating i ~ i ~ i ~ i ~ i {
  width: 100%;
}
::after,
::before {
  height: 100%;
  padding: 0;
  margin: 0;
  box-sizing: border-box;
  text-align: center;
  vertical-align: middle;
}

.star-rating.star-5 {width: 250px;}
.star-rating.star-5 input,
.star-rating.star-5 i {width: 20%;}
.star-rating.star-5 i ~ i {width: 40%;}
.star-rating.star-5 i ~ i ~ i {width: 60%;}
.star-rating.star-5 i ~ i ~ i ~ i {width: 80%;}
.star-rating.star-5 i ~ i ~ i ~ i ~i {width: 100%;}

.star-rating.star-3 {width: 150px;}
.star-rating.star-3 input,
.star-rating.star-3 i {width: 33.33%;}
.star-rating.star-3 i ~ i {width: 66.66%;}
.star-rating.star-3 i ~ i ~ i {width: 100%;}


</style>  
@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
 <div class="side-app">

  <!-- CONTAINER -->
  <div class="main-container container-fluid">

    @include('chat_count')
    <!-- ROW OPEN -->
    <div class="row row-cards" style="padding-top: 20px;">




      @if(Auth::user()->is_client() or Auth::user()->is_admin() or Auth::user()->is_subadmin())
      <?php
      $ratings = \App\Models\Review_rating::whereOrderId($order->id)->get();
      ?>
      @if($order->status==4 or $order->status==5) 
      @if($ratings->count()>0) 
      <div class="card">
       <div class="card-body">


        <div class="row">
          @foreach($ratings as $value)
          <div class="col-md-8">
           <p class="font-weight-bold ">Writers Review</p>
           <div class="form-group row">
            <input type="hidden" name="booking_id" value="{{ $value->id }}">
            <div class="col">
             <div class="rated">
              @for($i=1; $i<=$value->star_rating; $i++)                                                      {{-- <input type="radio" id="star{{$i}}" class="rate" name="rating" value="5"/> --}}
              <label class="star-rating-complete" title="text">{{$i}} stars</label>
              @endfor
            </div>
          </div>
        </div>
        <div class="form-group row mt-4">
          <div class="col"><br>
            <p>{{ $value->comments }}</p>
          </div>
        </div>
      </div>
      @endforeach
    </div>

    @else



    @endif




  </div>
</div>
@endif
@endif

</div>



<!-- ROW OPEN -->
<div class="row row-cards">


  <div class="col-lg-8 col-xl-8">


    <div class="card">
     <div class="card-header">


      <h4 class="card-title">
        <span class="badge bg-secondary fs-14 me-2">


          <?php
          if($order->status =='0') {
            echo 'Pending';
          }

          if($order->status =='1') {
            echo 'Available';
          }

          if($order->status =='2') {
            echo 'Assigned';
          }

          if($order->status =='3') {
            echo 'editing';
          }

          if($order->status =='8') {
            echo 'editor revision';
          }

          if($order->status =='4') {
            echo 'completed';
          }

          if($order->status =='5') {
            echo 'Approved';
          }

          if($order->status =='6') {
            echo 'Revision';
          }

          if($order->status =='9') {
            echo 'Dispute Raised';
          }

          if($order->status =='7') {
            echo 'Cancelled';
          }

          ?>
        </span><strong>Order ID: {{$order->id }}</strong>



      </h4>

      <div class="page-options ms-auto">

       <?php 
       $invoices = \App\Models\Invoice::whereOrderId($order->id)->orderBy('id', 'desc')->get();
       $invoice = \App\Models\Invoice::whereOrderId($order->id)->orderBy('id', 'desc')->first();
       ?> 
       @if(Auth::user()->is_admin() or Auth::user()->is_client() or Auth::user()->is_student() or Auth::user()->is_subadmin())
       @if($invoices->count()>0)
       <a href="{{ url('view-invoice/'.$invoice->slug) }}" target="_blank" class="btn btn-sm btn-danger" style="color: #ffffff;"><i class="fa fa-check"></i>Custom Invoice ({{ $invoices->count() }})</a>
       @endif
       @endif


       @if(Auth::user()->is_editor() or Auth::user()->is_admin() or Auth::user()->is_subadmin())
       @if($order->writer_confirm==0)
       <a class="btn btn-sm btn-warning badge" data-bs-target="#accept" data-bs-toggle="modal"><i class="fa fa-check"></i>Not Confirmed</a> 
       @endif
       @if($order->status == 1)
       <?php
       $bid_count = \App\Models\Bid::whereOrderId($order->id)->count();
       ?>
       <a href="{{ route('view_bids', $order->id )}}" class="btn btn-sm btn-success badge"><i class="fa fa-gavel"></i> Bids ({{ $bid_count }})
       </a>
       @endif
       @endif

       @if(Auth::user()->is_writer() or Auth::user()->is_admin())
       @if($order->writer_confirm==0) 

       @if($order->writer_id != 0 or $order->preferred_writer ==Auth::user()->id)
       <a class="btn btn-sm btn-warning badge" data-bs-target="#accept" data-bs-toggle="modal"><i class="fa fa-check"></i> Accept</a> 

       <a class="btn btn-sm btn-danger badge" data-bs-target="#reject" data-bs-toggle="modal"><i class="fa fa-check"></i> Reject</a> 
       @else
       <?php
       $bid = \App\Models\Bid::whereUserId(Auth::user()->id)->whereOrderId($order->id)->first();
       ?>
       @if($bid)
       <a class="btn btn-sm btn-success badge"><i class="fa fa-check"></i> 
       Bid already placed</a> 
       <a style="color: #ffffff;" class="btn btn-sm btn-danger" data-bs-target="#delete-bid{{ $bid->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Cancel Bid</a>

       <!-- delete modal-->
       <div class="modal fade" id="delete-bid{{ $bid->id }}">
         <div class="modal-dialog modal-dialog-centered" role="document">
           <div class="modal-content country-select-modal">
             <div class="modal-header">
               <h6 class="modal-title">Confirm you want to delete bid #{{ $bid->id }}</h6><button aria-label="Close" class="btn-close"
               data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
             </div>
             <div class="modal-body">
               <form class="form-horizontal" action="{{ route('delete_bid')}}" method="POST">
                 @csrf
                 <input type="hidden" name="id" value="{{ $bid->id }}">


                 <div class=" row mb-4">


                  <p>Are you sure you want to delete this bid?</p>
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
     @else

 

     @if(Auth::user()->writer_levels == 0)

@if(can_bid(Auth::user()->id) == 1)
  <a class="btn btn-sm btn-warning badge" data-bs-target="#assign" data-bs-toggle="modal">
      <i class="fa fa-check"></i> 
      Place Bid
     </a> 
     @else
       <a style="color: #ffffff;" class="btn btn-sm btn-info badge"><i class="fa fa-check"></i> You have an active order
     </a>
@endif


   


     @else

     @if(can_bid(Auth::user()->id)>0)
     <a style="color: #ffffff;" class="btn btn-sm btn-danger badge"><i class="fa fa-check"></i> You have an active order
     </a>
     @else
     <a class="btn btn-sm btn-info badge" data-bs-target="#pick" data-bs-toggle="modal"><i class="fa fa-check"></i> Pick Order
     </a> 
     @endif
     @endif



     @endif
     @endif

     <!-- edit modal--> 
     <div class="modal fade" id="pick">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content country-select-modal">
          <div class="modal-header">
            <h6 class="modal-title">Pick order #{{ $order->id }}</h6><button aria-label="Close" class="btn-close"
            data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
          </div>


          <div class="modal-body">
            <form class="form-horizontal" action="{{ route('pick_order')}}" method="POST">
              @csrf
              <input type="hidden" name="order_id" value="{{ $order->id }}">
              <p>Are you sure you want to pick this order</p>
              @if($order->order_level == 'technical')
              <div class=" row mb-4">
               <label class="col-md-4 form-label">My Budget is ( {{ get_currency() }})</label>
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




 <!-- edit modal--> 
 <div class="modal fade" id="assign">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content country-select-modal">
      <div class="modal-header">
        <h6 class="modal-title">Place bid for order #{{ $order->id }}</h6><button aria-label="Close" class="btn-close"
        data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
      </div>


      <div class="modal-body">
        <form class="form-horizontal" action="{{ route('bid_order')}}" method="POST">
          @csrf

          <input type="hidden" name="order_id" value="{{ $order->id }}">



          <p>Assign me this order</p>
          @if($order->order_level == 'technical')
          <div class=" row mb-4">
           <label class="col-md-4 form-label">My Budget is ( {{ get_currency() }})</label>
           <div class="col-md-8">
             <input type="number"  class="form-control" name="writer_budget" value="0">
           </div>
         </div>

         @endif





         <div class=" row mb-4">

          <div class="col-md-9">
           <input type="submit" value="Submit" class="btn btn-primary">
         </div>


       </div>



     </form>
   </div>
 </div>
</div>
</div> 

<!-- edit modal-->
<div class="modal fade" id="reject">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content country-select-modal">
      <div class="modal-header">
        <h6 class="modal-title">Reject order #{{ $order->id }}</h6><button aria-label="Close" class="btn-close"
        data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
      </div>


      <div class="modal-body">
        <form class="form-horizontal" action="{{ route('reject_order')}}" method="POST">
          @csrf

          <input type="hidden" name="order_id" value="{{ $order->id }}">
          <input type="hidden" name="status" value="5">


          <p>Confirm that you are rejecting this order</p>

          <textarea class="form-control" name="reject_reseason" required placeholder="Reseason to reject the order"></textarea>




          <div class=" row mb-4">

            <div class="col-md-9">
              <br>
             <input type="submit" value="Reject" class="btn btn-primary">
           </div>


         </div>



       </form>
     </div>
   </div>
 </div>
</div>



<!-- edit modal-->
<div class="modal fade" id="accept">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content country-select-modal">
      <div class="modal-header">
        <h6 class="modal-title">Accept order #{{ $order->id }}</h6><button aria-label="Close" class="btn-close"
        data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
      </div>



      <div class="modal-body">

        <form class="form-horizontal" action="{{ route('accept_order')}}" method="POST">
          @csrf

          <input type="hidden" name="order_id" value="{{ $order->id }}">
          <input type="hidden" name="status" value="5">
          <p>Confirm that you are working on this order</p>
          <div class=" row mb-4">

            <div class="col-md-9">
             <input type="submit" value="Accept" class="btn btn-primary">
           </div>


         </div>



       </form>
     </div>
   </div>
 </div>
</div>  
@endif

@endif


 


@if(Auth::user()->is_client() or Auth::user()->is_student())
@if($order->status==0)  
@if($order->order_level == 'normal' or $order->ccost > 0)  
<a class="btn btn-sm btn-success badge text-white" data-bs-target="#confirm-order{{ $order->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Click Here To Pay Now</a> 
@endif
@endif
@endif


   @if(Auth::user()->is_admin())
 
 @if($order->status == 1 or $order->status == 2 or $order->status == 3 or $order->status == 4 or $order->status == 5)
      <button type="button" class="btn btn-warning btn-sm" data-toggle="modal" data-target="#cancelModalw">
        Cancel Order
      </button>

      @endif


      <!-- Modal -->
      <div class="modal fade" id="cancelModalw" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Adjust Time</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>

            <div class="modal-body">
              <form role="form" action="{{ route('cancel_order')}}" method="POST">

                      @csrf
                <input value="<?php echo $order->id; ?>" name="order_id" class="border-default form-control"  type="hidden">
                <p>Are you sure you want to cancel this order</p>

                <div class=" row mb-4">

                  <label class="col-md-4 form-label">Cancel Reason</label>

                  <div class="col-md-8">

                    <select class="form-control" name="order_cancelreason">
                      <option>Time Expired</option>
                      <option>Wrong instructions</option>
                      <option>No biddings</option>
                      <option>No responses</option>
                      <option>Poorly Done</option>
                      <option>Low quality</option>
                      <option>Others</option>
                    </select>


                  </div>


               </div>


               <button class="btn btn-info">Cancel Order</button> 
             </form>
           </div>

         </div>
       </div>
     </div>

     @endif

@if(!Auth::user()->is_writer())
@if($order->status==0)
<a href="{{ route('edit_order', $order->id )}}" class="btn btn-sm btn-danger badge"><i class="fa fa-edit"></i> Edit</a>
@endif 

@endif

@if(!Auth::user()->is_writer())
@if($order->status==4)    
<a class="btn btn-primary badge btn-sm" data-bs-target="#edit-property" data-bs-toggle="modal"><i class="fa fa-edit"></i> Revision
</a>

<a class="btn btn-success badge btn-sm" data-bs-target="#approve" data-bs-toggle="modal"><i class="fa fa-check"></i> Approve
</a>


<!-- edit modal-->
<div class="modal fade" id="approve">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content country-select-modal">
      <div class="modal-header">
        <h6 class="modal-title">Approve order #{{ $order->id }}</h6><button aria-label="Close" class="btn-close"
        data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
      </div>


      <div class="modal-body">
        <form class="form-horizontal" action="{{ route('approve_order')}}" method="POST">
          @csrf

          <input type="hidden" name="order_id" value="{{ $order->id }}">
          <input type="hidden" name="status" value="5">


          <p>Are you sure you want approve this order?</p>





          <div class=" row mb-4">

            <div class="col-md-9">
             <input type="submit" value="Proceed" class="btn btn-primary">
           </div>


         </div>



       </form>
     </div>
   </div>
 </div>
</div>  

@endif

@if(Auth::user()->is_admin())

@if(domain_name() != 'saseni.com')

<a class="btn btn-info btn-sm  badge" data-bs-target="#submit_saseni" data-bs-toggle="modal"><i class="fa fa-check"></i> Submit to Saseni
</a>


<!-- edit modal-->
<div class="modal fade" id="submit_saseni">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content country-select-modal">
      <div class="modal-header">
        <h6 class="modal-title">Submit order #{{ $order->id }}</h6><button aria-label="Close" class="btn-close"
        data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
      </div>


      <div class="modal-body">


<form action="https://saseni.com/premotely2" method="POST" enctype="multipart/form-data">
  
@csrf

         <input type="hidden" name="callback_url" value="{{ route('view_order', $order->slug )}}">  
         <input type="hidden" name="order_id" value="<?php echo $order->id; ?>">   
         <input type="hidden" name="user_id" value="<?php echo get_option(site_id().'_saseni_id'); ?>">  
         <input type="hidden" name="website" value="<?php echo $_SERVER['HTTP_HOST']; ?>"> 
         <input type="hidden" name="title" value="<?php echo $order->title; ?>"> 
         <input type="hidden" name="description" value="{{ $order->description }}"> 
         <input type="hidden" name="aclevel" value="<?php echo $order->aclevel; ?>">  
         <input type="hidden" name="order_continuation" value="<?php echo $order->spacing; ?>"> 
         <input type="hidden" name="category_id" value="<?php echo $order->category_id; ?>"> 
         <input type="hidden" name="word_count" value="<?php echo $order->word_count; ?>">


         <input type="hidden" name="ccost" value="<?php echo $order->ccost; ?>"> 
         <input type="hidden" name="order_style" value="<?php echo $order->order_style; ?>"> 
         <input type="hidden" name="slide" value="<?php echo $order->slide; ?>">  
         <input type="hidden" name="paper_id" value="<?php echo $order->paper_id; ?>"> 
         <input type="hidden" name="sources" value="<?php echo $order->sources; ?>"> 
         <input type="hidden" name="personal_note" value="<?php echo $order->personal_note; ?>">


         <input type="hidden" name="order_citation" value="<?php echo $order->order_citation; ?>"> 
         <input type="hidden" name="editor_involved" value="<?php echo $order->editor_involved; ?>"> 
         <input type="hidden" name="preferred_writer" value="0">  
         <input type="hidden" name="plagiarism_report" value="<?php echo $order->plagiarism_report; ?>"> 
         <input type="hidden" name="language" value="<?php echo $order->language; ?>"> 
         <input type="hidden" name="urgency" value="<?php echo $order->urgency; ?>">

         <input type="hidden" name="order_due" value="<?php echo $order->order_wrdeadline; ?>"> 





         <?php $i=1; foreach ($uploads as $files): ?>
         <input type="hidden" name="order_files[]" value="<?php echo $files['file_path'].'##'.$files['name'];?>"> 

       <?php endforeach; ?>



       <button class="btn ops-sm-12 btn-success text-white">Submit your order to Saseni.com </button>
     </form>

   </div>
 </div>
</div>
</div>

@endif

<a class="btn btn-primary badge btn-sm" data-bs-target="#fine" data-bs-toggle="modal"><i class="fa fa-check"></i> Fine
</a>


<!-- edit modal-->
<div class="modal fade" id="fine">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content country-select-modal">
      <div class="modal-header">
        <h6 class="modal-title">Fine Writer for Order No. {{ $order->id }}</h6><button aria-label="Close" class="btn-close"
        data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
      </div>


      <div class="modal-body">
        <form class="form-horizontal" action="{{ route('fine_order')}}" method="POST">
          @csrf

          <input type="hidden" name="order_id" value="{{ $order->id }}">


          <div class=" row mb-4">
           <label class="col-md-4 form-label">Order Fine</label>
           <div class="col-md-8">
             <input type="number"  class="form-control" name="order_fine" value="{{ $order->order_fine }}">
           </div>
         </div>


         <div class=" row mb-4">
           <label class="col-md-4 form-label">Order Fine Reason</label>
           <div class="col-md-8">
            <textarea class="form-control" name="order_finereason">{{ $order->order_finereason }}</textarea>
          </div>
        </div>




        <div class=" row mb-4">

          <div class="col-md-9">
           <input type="submit" value="Proceed" class="btn btn-primary">
         </div>


       </div>



     </form>
   </div>
 </div>
</div>
</div>  

@if($order->status==9)

<a class="btn btn-default badge btn-sm" data-bs-target="#solve" data-bs-toggle="modal"><i class="fa fa-edit"></i> Solve Dispute
</a>

@endif
@endif

@if(Auth::user()->is_client())
<?php
$ratings = \App\Models\Review_rating::whereOrderId($order->id)->get();
?>
@if($order->status==4 or $order->status==5 or $order->status==9 or $order->status==7) 
@if(Auth::user()->is_admin())
<a class="btn btn-default badge btn-sm" data-bs-target="#dispute" data-bs-toggle="modal"><i class="fa fa-edit"></i> Raise Dispute
</a>
@endif

@if($ratings->count()>0)

@else
<a class="btn btn-warning badge btn-sm" data-bs-target="#rate" data-bs-toggle="modal"><i class="fa fa-check"></i> Rate writer
</a>


<!-- edit modal-->
<div class="modal fade" id="rate">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content country-select-modal">
      <div class="modal-header">
        <h6 class="modal-title">Rate this writer by</h6><button aria-label="Close" class="btn-close"
        data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
      </div>


      <div class="modal-body">
        <div class="row">


          <div class="col mt-4">
            <form class="py-2 px-4" action="{{route('reviewstore')}}" style="box-shadow: 0 0 10px 0 #ddd;" method="POST" autocomplete="off">
             @csrf
             <p class="font-weight-bold ">Grammar </p>
             <div class="form-group row">
              <input type="hidden" name="order_id" value="{{ $order->id }}">
              <input type="hidden" name="writer_id" value="{{ $order->writer_id }}">

            </div>
            <div class="form-group row mt-4">
              <div class="col">
               <span class="star-rating star-5">
                <input type="radio" name="grating" value="1"><i></i>
                <input type="radio" name="grating" value="2"><i></i>
                <input type="radio" name="grating" value="3"><i></i>
                <input type="radio" name="grating" value="4"><i></i>
                <input type="radio" name="grating" value="5" checked=""><i></i>
              </span>
            </div>
          </div>


        </div>


        <div class="col mt-4">

         <p class="font-weight-bold ">Following Instructions </p>
         <div class="form-group row">


         </div>
         <div class="form-group row mt-4">
           <div class="col">
             <span class="star-rating star-5">
              <input type="radio" name="frating" value="1"><i></i>
              <input type="radio" name="frating" value="2"><i></i>
              <input type="radio" name="frating" value="3"><i></i>
              <input type="radio" name="frating" value="4"><i></i>
              <input type="radio" name="frating" value="5" checked=""><i></i>
            </span>
          </div>
        </div>


      </div>

      <div class="col mt-4">

       <p class="font-weight-bold ">Keeping Deadline </p>
       <div class="form-group row">


       </div>
       <div class="form-group row mt-4">
         <div class="col">
           <span class="star-rating star-5">
            <input type="radio" name="krating" value="1"><i></i>
            <input type="radio" name="krating" value="2"><i></i>
            <input type="radio" name="krating" value="3"><i></i>
            <input type="radio" name="krating" value="4"><i></i>
            <input type="radio" name="krating" value="5" checked=""><i></i>
          </span>
        </div>
      </div>


    </div>



  </div>

  <div class="row">
   <div class="col mt-4">


     <div class="form-group row">


     </div>
     <div class="form-group row mt-4">
      <div class="col">
       <textarea class="form-control" name="comment" rows="6 " placeholder="Add Comment" maxlength="200"></textarea>
     </div>
   </div>
   <div class="mt-3 text-right">
    <button class="btn btn-sm py-2 px-3 btn-info">Submit
    </button>
  </div>
</form>
</div>
</div>
</div>
</div>
</div>
</div>  

@endif
@endif
@endif



@endif



@if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
<a href="{{ route('view_bids', $order->id )}}" class="btn btn-sm btn-success badge"><i class="fa fa-users"></i>Users
</a>


@endif
@if(Auth::user()->is_writer())

<?php
$orders_count1 = \App\Models\Order::whereWriterId(Auth::user()->id)->whereUserId($order->user_id)->count();
?>

<a target="_blank" href="{{ route('order', ['history' => $order->user_id ])}}" class="btn btn-success badge btn-sm"><i class="fa fa-history"></i> Client History ({{ $orders_count1 }})
</a>

@if($order->status==2 or $order->status =='6' or $order->status =='8')

<a class="btn btn-info  badge btn-lg" data-bs-target="#submit_order" data-bs-toggle="modal"><i class="fa fa-check"></i> Mark as complete
</a>


<!-- edit modal-->
<div class="modal fade" id="submit_order">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content country-select-modal">
      <div class="modal-header">
        <h6 class="modal-title">Submit order #{{ $order->id }}</h6><button aria-label="Close" class="btn-close"
        data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
      </div>


      <div class="modal-body">
        <form class="form-horizontal" method="POST" action="{{ route('change_status') }}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="order_id" value="{{ $order->id }}">
          @if($order->editor_involved == '1' or $order->plagiarism_report == '1')
          <input type="hidden" name="status" value="3">
          @else
          <input type="hidden" name="status" value="4">
          @endif

          <div class=" row mb-4">
            <div class="col-md-12"><span style="color: red;">Before you mark this order complete make sure you have followed all order instructions and uploaded the correct files.</span></div>
            
          </div>
          <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
              <button type="submit" class="btn btn-primary">
               Yes Submit
             </button>
           </div>
         </div>
       </form>
     </div>
   </div>
 </div>
</div>




@endif

@endif
@if(!$order->status==0)

<?php
$messages = \App\Models\Chat::whereOrderId($order->id)->whereFeature('1')->get();
?>
@if($messages->count() > 0)
<a href="#chat"  class="btn btn-success btn-sm"><i class="fa fa-comment"></i> View Messages ({{$messages->count()}})
</a>
@endif 
@endif 
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
           <label class="col-md-3 form-label">Amount ( {{ get_currency() }})</label>
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

            <p class="alert alert-danger"><strong>{!! remainingtime($order->order_due) !!}</strong> <br>Sorry, we can not deliver the task with specified deadline, kindly adjust it if posible</p>

            <a href="{{ route('edit_order', $order->id )}}" class="btn btn-sm btn-primary badge"><i class="fa fa-edit"></i> Edit</a>

            @endif
          </div>

          @else

          <p class="alert alert-danger"><strong>{!! remainingtime($order->order_due) !!}</strong> <br>Sorry, we can not deliver this task within specified deadline, kindly adjust it if posible</p>
          <input type="submit" value="Just Work On It" class="btn btn-primary">

          @endif


        </div>



      </form>
    </div>
  </div>
</div>
</div>


<!-- edit modal-->
<div class="modal fade" id="solve">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content country-select-modal">
      <div class="modal-header">
        <h6 class="modal-title">Solve a dispute for order #{{ $order->id }}</h6><button aria-label="Close" class="btn-close"
        data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="{{ route('solve_dispute')}}" method="POST">
          @csrf

          <input type="hidden" name="order_id" value="{{ $order->id }}">


          <div class=" row mb-4">
            <label class="col-md-3 form-label">Solution</label>
            <div class="col-md-9">
              <select name="dispute_option" class="form-control">
                <option value="{{ $order->dispute_option }}" selected="">{{ dispute($order->dispute_option) }}</option>
                <option value="1">Decline Dispute</option>
                <option value="2" >Full Refund</option>
                <option value="3">{{ dispute(3) }}</option>


              </select>
            </div>
          </div>


          <div class=" row mb-4">
            <label class="col-md-4 form-label">Solution description</label>
            <div class="col-md-12">
              <textarea rows="5" name="dispute_comment" id="dispute2" placeholder="">{{ $order->dispute_comment }}</textarea>
              <script>
                ClassicEditor
                .create( document.querySelector( '#dispute2' ) )
                .catch( error => {
                  console.error( error );
                } );
              </script>

            </div>
          </div>



          <div class=" row mb-4">

            <div class="col-md-9">
              <input type="submit" value="Submit Now" class="btn btn-primary">
            </div>


          </div>



        </form>
      </div>
    </div>
  </div>
</div>


<!-- edit modal-->
<div class="modal fade" id="dispute">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content country-select-modal">
      <div class="modal-header">
        <h6 class="modal-title">Raise a dispute for order #{{ $order->id }}</h6><button aria-label="Close" class="btn-close"
        data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="{{ route('send_dispute')}}" method="POST">
          @csrf

          <input type="hidden" name="order_id" value="{{ $order->id }}">






          <div class=" row mb-4">
            <label class="col-md-4 form-label">Issue Raised</label>
            <div class="col-md-12">
              <textarea rows="5" name="instructions" id="dispute1" placeholder=""></textarea>
              <script>
                ClassicEditor
                .create( document.querySelector( '#dispute1' ) )
                .catch( error => {
                  console.error( error );
                } );
              </script>

            </div>
          </div>



          <div class=" row mb-4">

            <div class="col-md-9">
              <input type="submit" value="Submit Now" class="btn btn-primary">
            </div>


          </div>



        </form>
      </div>
    </div>
  </div>
</div>





<!-- edit modal-->
<div class="modal fade" id="edit-property">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content country-select-modal">
      <div class="modal-header">
        <h6 class="modal-title">Request revision for order #{{ $order->id }}</h6><button aria-label="Close" class="btn-close"
        data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
        <form class="form-horizontal" action="{{ route('send_revision')}}" method="POST">
          @csrf

          <input type="hidden" name="order_id" value="{{ $order->id }}">




          <div class=" row mb-4">
            <label class="col-md-12 form-label">Due in (Hours)</label>
            <div class="col-md-8">
              <input type="number" class="form-control" name="due_in" required="" placeholder="Enter hours eg 2">
            </div>
          </div>


          <div class=" row mb-4">
            <label class="col-md-4 form-label">Instructions</label>
            <div class="col-md-12">


                     <textarea  id="summernote" name="instructions"></textarea>

                     <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
       <script>
        $('#summernote').summernote({
          placeholder: 'Type your instructions here',
          tabsize: 2,
          height: 300,
          toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
            ]
        });
      </script>
            




            </div>
          </div>



          <div class=" row mb-4">

            <div class="col-md-9">
              <input type="submit" value="Submit Now" class="btn btn-primary">
            </div>


          </div>



        </form>
      </div>
    </div>
  </div>
</div>

</div>

<div class="card-body">
@if($order->order_cancelreason)
 <div class="row" style="background-color: #E9E9EA; padding: 20px; margin-bottom: 20px;">
  <p>This order has been cancelled </p><br>
 {{ $order->order_cancelreason  }}
</div>
@endif


 @if(Auth::user()->is_admin() or Auth::user()->is_writer() or Auth::user()->is_subadmin())
 @if($order->order_fine>0)
 <div class="row" style="background-color: #E9E9EA; padding: 20px; margin-bottom: 20px;">
  <p>This order was fined {{ price($order->order_fine ) }}</p><br>
  {!! $order->order_finereason !!}
</div>
@endif
@endif

@if($order->dispute_option>0)
<div class="row" style="background-color: #E9E9EA; padding: 20px; margin-bottom: 20px;">
  <p>Dispute has been solved ({{ dispute($order->dispute_option ) }})</p><br>
  {!! $order->dispute_comment !!}
</div>
@endif

<?php
$revisions = \App\Models\Dispute::whereOrderId($order->id)->orderBy('id', 'desc')->get();
?>
@if($revisions->count()>0)
<div class="row" style="background-color: #FFEAE9; padding: 20px; margin-bottom: 20px;">


  <h4 style="color: #000000;">Issue</h4>


  @foreach($revisions as $revision)
  <div class="col-md-12" style="color: #000000;">
    {!! $revision->issues !!}


    @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
    <a style="color: #ffffff;" class="btn btn-sm btn-info" data-bs-target="#update-revision{{ $revision->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Update
    </a>

    <a style="color: #ffffff;" class="btn btn-sm btn-danger" data-bs-target="#delete-revision{{ $revision->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Delete
    </a>

    <!-- update modal-->
    <div class="modal fade" id="update-revision{{ $revision->id }}">
     <div class="modal-dialog modal-dialog-centered" role="document">
       <div class="modal-content country-select-modal">
         <div class="modal-header">
           <h6 class="modal-title">Confirm you want to update #{{ $revision->id }} revision</h6><button aria-label="Close" class="btn-close"
           data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
         </div>
         <div class="modal-body">
           <form class="form-horizontal" action="{{ route('update_revision')}}" method="POST">
             @csrf
             <input type="hidden" name="id" value="{{ $revision->id }}">


             <div class=" row mb-4">
              <label class="col-md-4 form-label">Instructions</label>
              <div class="col-md-12">
                <textarea rows="5" name="instructions" id="editor{{ $revision->id }}" placeholder="">{!! $revision->instructions !!}</textarea>
                <script>
                  ClassicEditor
                  .create( document.querySelector( '#editor{{ $revision->id }}' ) )
                  .catch( error => {
                    console.error( error );
                  } );
                </script>

              </div>
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
  <div class="modal fade" id="delete-revision{{ $revision->id }}">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content country-select-modal">
       <div class="modal-header">
         <h6 class="modal-title">Confirm you want to delete #{{ $revision->id }} revision</h6><button aria-label="Close" class="btn-close"
         data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
       </div>
       <div class="modal-body">
         <form class="form-horizontal" action="{{ route('delete_revision')}}" method="POST">
           @csrf
           <input type="hidden" name="id" value="{{ $revision->id }}">


           <div class=" row mb-4">


            <p>Are you sure you want to delete this revision?</p>
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

@endif

</div>


<hr style="border-top: 1px solid #000000;">
@endforeach


</div>
@endif




<?php
$revisions = \App\Models\Revision::whereOrderId($order->id)->orderBy('id', 'desc')->get();
?>
@if($revisions->count()>0)
<div class="row" style="background-color: #FFEAE9; padding: 20px; margin-bottom: 20px;">


  <h4 style="color: #000000;">Revisions Instructions</h4>


  @foreach($revisions as $revision)
  <div class="col-md-12" style="color: #000000;">
    {!! $revision->instructions !!}
    @if(Auth::user()->is_writer())
    <div class="alert alert-info">Dear Writer, <br>When revising a paper, always use the edited copy that was sent to the client (Check the latest date). DO NOT use the paper you had sent to the system as a number of edits were done to improve the paper.</div>
    @endif
    Due at: {!! remainingtime($revision->due_at) !!}
    @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
    <a style="color: #ffffff;" class="btn btn-sm btn-info" data-bs-target="#update-revision{{ $revision->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Update
    </a>

    <a style="color: #ffffff;" class="btn btn-sm btn-danger" data-bs-target="#delete-revision{{ $revision->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Delete
    </a>

    <!-- update modal-->
    <div class="modal fade" id="update-revision{{ $revision->id }}">
     <div class="modal-dialog modal-dialog-centered" role="document">
       <div class="modal-content country-select-modal">
         <div class="modal-header">
           <h6 class="modal-title">Confirm you want to update #{{ $revision->id }} revision</h6><button aria-label="Close" class="btn-close"
           data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
         </div>
         <div class="modal-body">
           <form class="form-horizontal" action="{{ route('update_revision')}}" method="POST">
             @csrf
             <input type="hidden" name="id" value="{{ $revision->id }}">


             <div class=" row mb-4">
              <label class="col-md-4 form-label">Instructions</label>
              <div class="col-md-12">
                <textarea rows="5" name="instructions" id="editor{{ $revision->id }}" placeholder="">{!! $revision->instructions !!}</textarea>
                <script>
                  ClassicEditor
                  .create( document.querySelector( '#editor{{ $revision->id }}' ) )
                  .catch( error => {
                    console.error( error );
                  } );
                </script>

              </div>
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
  <div class="modal fade" id="delete-revision{{ $revision->id }}">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content country-select-modal">
       <div class="modal-header">
         <h6 class="modal-title">Confirm you want to delete #{{ $revision->id }} revision</h6><button aria-label="Close" class="btn-close"
         data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
       </div>
       <div class="modal-body">
         <form class="form-horizontal" action="{{ route('delete_revision')}}" method="POST">
           @csrf
           <input type="hidden" name="id" value="{{ $revision->id }}">


           <div class=" row mb-4">


            <p>Are you sure you want to delete this revision?</p>
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

@endif

</div>


<hr style="border-top: 1px solid #000000;">
@endforeach


</div>
@endif


@if($order->language)
<span class="badge bg-primary-transparent rounded-pill text-primary p-2 px-3">Use {{ $order->language }}</span> 
@endif
@if($order->order_level == 'normal')

<span class="badge bg-success-transparent rounded-pill text-success p-2 px-3"> Normal order</span>

@elseif($order->order_level == 'professional')
<span class="badge bg-success-transparent rounded-pill text-success p-2 px-3"> Professioanl Service</span>
@else
<span class="badge bg-primary-transparent rounded-pill text-primary p-2 px-3"> Technical Order</span> 
@if(Auth::user()->is_client() or Auth::user()->is_student())
@if($order->ccost < 1)

<div class="alert alert-info">

  <p>  Thank you for submitting an order. 
    If there are other important details relating to the order, you can mention them in the instructions section or upload any relevant files using the "Upload" files option below.
    Please keep checking for bids on your order. Select and go ahead to pay for the bid that resonates with your budget.
  </p>
</div>
@endif     
@endif 

@if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
@if($order->ccost < 1)
<div class="alert alert-warning"><p>Client is waiting you evaluate this order</p></div>

<a class="btn btn-sm btn-warning badge" data-bs-target="#cost-order{{ $order->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Update order cost
</a> 

<!-- edit modal-->
<div class="modal fade" id="cost-order{{ $order->id }}">
 <div class="modal-dialog modal-dialog-centered" role="document">
   <div class="modal-content country-select-modal">
     <div class="modal-header">
       <h6 class="modal-title">Update cost of order #{{ $order->id }}</h6><button aria-label="Close" class="btn-close"
       data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
     </div>
     <div class="modal-body">
       <form class="form-horizontal" action="{{ route('cost_order')}}" method="POST">
         @csrf
         <input type="hidden" name="order_id" value="{{ $order->id }}">


         <div class=" row mb-4">
           <label class="col-md-3 form-label">Amount ({{Auth::user()->currency_sign}})</label>
           <div class="col-md-9">
             <input type="text"  class="form-control" name="amount" value="{{ $order->ccost }}">
           </div>


         </div>


         <div class=" row mb-4">

           <div class="col-md-9">


            <input type="submit" value="Submit" class="btn btn-primary">


          </div>


        </div>



      </form>
    </div>
  </div>
</div>
</div>
@endif


@endif
@endif

<hr style="border-top: 1px solid #000000;">

@if(Auth::user()->is_admin() or Auth::user()->is_editor() or Auth::user()->is_subadmin())

<div class=" row mb-4">
  <label class="col-md-3 form-label">Client</label>
  <div class="col-md-8">
    <a target="_blank" href="{{ route('user_info', $order->user_id )}}">{{ username($order->user_id )->name }}: #{{ $order->user_id }}</a>
  </div>
</div>


@endif 
@if($order->ccost)
@if(Auth::user()->is_client() or Auth::user()->is_student() or Auth::user()->is_admin() or Auth::user()->is_subadmin())
<div class=" row mb-4">
  <label class="col-md-3 form-label">Order cost</label>
  <div class="col-md-8">
    {{ price($order->ccost)}}
  </div>
</div>
@endif
@endif

@if(Auth::user()->is_writer())
<div class=" row mb-4">
  <label class="col-md-3 form-label">Order cost</label>
  <div class="col-md-8">
    @if($order->wcost < 1)
    <div class="alert alert-danger"><p>The client is waiting for your evaluation for this order. Please place your bid</p></div>

    @else
    {{  price( (int) $order->wcost)}}

    @endif
  </div>
</div>

@endif


@if(Auth::user()->is_editor())
<div class=" row mb-4">
  <label class="col-md-3 form-label">Order cost</label>
  <div class="col-md-8">
    {{ price($order->ecost)}}
  </div>
</div>
<hr style="border-top: 1px solid #000000;">
@endif

@if(Auth::user()->is_client())
@if($order->order_id)
<div class=" row mb-4">
  <label class="col-md-3 form-label">Source Order ID</label>
  <div class="col-md-8">
    {{ $order->order_id }}
  </div>
</div>
<hr style="border-top: 1px solid #000000;">
@endif
@endif

<div class=" row mb-4">
  <label class="col-md-3 form-label">Title</label>
  <div class="col-md-9">
    <p>{{ $order->title }}</p>
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@if($order->order_continuation)

<?php 
$porder = \App\Models\Order::find($order->order_continuation);
?>
<div class=" row mb-4">
  <label class="col-md-3 form-label">Progress delivery from or related to: </label>
  <div class="col-md-9">
    <p><a target="_blank" href="{{ route('view_order', $porder->slug )}}"> Order ID: {{ $order->order_continuation }}</a></p>
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif


@if($order->question_id)

<?php 
$porder = \App\Models\Order::find($order->question_id);
?>
<div class=" row mb-4 alert alert-success">
  <label class="col-md-12 form-label">This is a discustion response to a student, Discussion questions is at <a target="_blank" href="{{ route('view_order', $porder->slug )}}"> Order No. {{ $order->question_id }}</a></label>

</div>
<hr style="border-top: 1px dotted #000000;">
@endif



@if($order->aclevel)
<div class=" row mb-4">
  <label class="col-md-3 form-label">Type of paper: </label>
  <div class="col-md-9">
    <p>{{ paper($order->paper_id) }}<br> {{ aclevel($order->aclevel) }} </p>
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif


@if(Auth::user()->is_admin() or Auth::user()->is_subadmin() or Auth::user()->is_client() or Auth::user()->is_student())
@if($order->order_budget)
<div class=" row mb-4">
  <label class="col-md-3 form-label">Order Budget</label>
  <div class="col-md-9">
    <p>KES {{ $order->order_budget }}</p>
  </div>
</div>
<hr style="border-top: 1px solid #000000;">
@endif
@endif


<div class=" row mb-4">
  <label class="col-md-3 form-label"><strong>Deadline:</strong></label>
  <div class="col-md-9">

    <div class="row">
      @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
      @if($order->urgency)
      <span class="badge bg-primary-transparent rounded-pill text-primary p-2 px-3">Order was posted in urgency of <strong>{{ $order->urgency }}</strong> at <strong>{!! $order->created_at->diffForHumans() !!}</strong> </span>
      @endif
      @endif
      <div class="col-sm-6 alert alert-info">

       @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
       <?php

       $datetime1 = new DateTime(date('Y-m-d H:i:s'));
       $datetime2 = new DateTime($order->order_due);
       $datetime3 = new DateTime($order->order_wrdeadline);
       $datetime4 = new DateTime($order->order_eddeadline);

       if($datetime1 >= $datetime2){
        $interval = $datetime1->diff($datetime2);
        $elapsed = $interval->format('%a days %h hours %i minutes');
        echo "<font color='red'>-".$elapsed .' passed (Actual)</font><br/>';
      }

      if($datetime1 >= $datetime3){
        $winterval = $datetime1->diff($datetime3);
        $welapsed = $winterval->format('%a days %h hours %i minutes');
        echo  "<font color='red'>-".$welapsed .' passed (Writer)</font> <br/>';
      }

      if($datetime1 >= $datetime4){
        $winterval = $datetime1->diff($datetime4);
        $welapsed = $winterval->format('%a days %h hours %i minutes');
        echo  "<font color='red'>-".$welapsed .' passed (Editor)</font> <br/>';
      }

      if($datetime1 <= $datetime2){
        $interval = $datetime1->diff($datetime2);
        $elapsed = $interval->format('%a days %h hours %i minutes');
        echo $elapsed .' (Actual) <br/>';
      }

      if($datetime1 <= $datetime4){
        $interval = $datetime1->diff($datetime4);
        $elapsed = $interval->format('%a days %h hours %i minutes');
        echo $elapsed .' (Editor) <br/>';
      }

      if($datetime1 <= $datetime3){
        $winterval = $datetime1->diff($datetime3);
        $welapsed = $winterval->format('%a days %h hours %i minutes');
        echo $welapsed .' (Writer) <br/>';
      }

      ?>
      @endif

      @if(Auth::user()->is_editor())
      <?php

      $datetime1 = new DateTime(date('Y-m-d H:i:s'));
      $datetime2 = new DateTime($order->order_due);
      $datetime3 = new DateTime($order->order_wrdeadline);
      $datetime4 = new DateTime($order->order_eddeadline);

      if($datetime1 >= $datetime4){
        $interval = $datetime1->diff($datetime4);
        $elapsed = $interval->format('%a days %h hours %i minutes');
        echo "<font color='red'>-".$elapsed .' passed </font><br/>';
      }

      if($datetime1 >= $datetime3){
        $winterval = $datetime1->diff($datetime3);
        $welapsed = $winterval->format('%a days %h hours %i minutes');
        echo  "<font color='red'>-".$welapsed .' passed </font> <br/>';
      }






      if($datetime1 <= $datetime4){
        $interval = $datetime1->diff($datetime4);
        $elapsed = $interval->format('%a days %h hours %i minutes');
        echo $elapsed .' (Editor) <br/>';
      }





      if($datetime1 <= $datetime3){
        $winterval = $datetime1->diff($datetime3);
        $welapsed = $winterval->format('%a days %h hours %i minutes');
        echo $welapsed .' (Writer) <br/>';
      }



      ?>
      @endif

      @if(Auth::user()->is_writer())
      <?php

      $datetime1 = new DateTime(date('Y-m-d H:i:s'));
      $datetime2 = new DateTime($order->order_due);
      $datetime3 = new DateTime($order->order_wrdeadline);
      $datetime4 = new DateTime($order->order_eddeadline);



      if($datetime1 >= $datetime3){
        $winterval = $datetime1->diff($datetime3);
        $welapsed = $winterval->format('%a days %h hours %i minutes');
        echo  "<font color='red'>-".$welapsed .' passed </font> <br/>';
      }



      if($datetime1 <= $datetime3){
        $winterval = $datetime1->diff($datetime3);
        $welapsed = $winterval->format('%a days %h hours %i minutes');
        echo $welapsed .' (Writer) <br/>';
      }

      ?>
      @endif

      @if(Auth::user()->is_client() or Auth::user()->is_student())
      <?php

      $datetime1 = new DateTime(date('Y-m-d H:i:s'));
      $datetime2 = new DateTime($order->order_due);
      $datetime3 = new DateTime($order->order_wrdeadline);
      $datetime4 = new DateTime($order->order_eddeadline);

      if($datetime1 >= $datetime2){
        $interval = $datetime1->diff($datetime2);
        $elapsed = $interval->format('%a days %h hours %i minutes');
        echo "<font color='red'>-".$elapsed .' passed </font><br/>';
      }



      if($datetime1 <= $datetime2){
        $interval = $datetime1->diff($datetime2);
        $elapsed = $interval->format('%a days %h hours %i minutes');
        echo $elapsed;
      }



      ?>
      @endif


      @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())

      <button type="button" class="btn btn-success btn-sm" data-toggle="modal" data-target="#exampleModalw">
        Adjust time
      </button>



     <!-- Modal -->
     <div class="modal fade" id="exampleModalw" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Adjust Time</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <link rel="stylesheet" type="text/css" href="{{ asset('assets/datepicker/jquery.css')}}">

            <script src="{{ asset('assets/datepicker/jquery_002.js')}}"></script>
            <!-- Place this tag in your head or just before your close body tag. -->
            <script src="{{ asset('assets/datepicker/jquery.js')}}"></script>
            <form role="form" action="{{ route('adjust_time')}}" method="POST">

                  @csrf
              <input value="<?php echo $order->id; ?>" name="order_id" class="border-default form-control"  type="hidden">
              <div  class="input-group-btn">

               Current client's deadline:  <?php echo $order->order_due; ?>  
               <hr/>  

             </div>

             <div class="form-group row">
              <label for="staticEmail" class="col-sm-4 col-form-label">Client's Time</label>
              <div class="col-sm-8">
                <input id="datetimepicker1" name="order_deadline" value="<?php echo $order->order_due; ?>" class="border-default form-control"  type="text">  
              </div>
            </div>
            <div class="form-group row">
              <label for="inputPassword" class="col-sm-4 col-form-label">Editor's Time</label>
              <div class="col-sm-8">
                <input id="datetimepicker2" name="order_eddeadline" value="<?php echo $order->order_eddeadline; ?>" class="border-default form-control"  type="text"> 
              </div>
            </div>

            <div class="form-group row">
              <label for="inputPassword" class="col-sm-4 col-form-label">Writer's Time</label>
              <div class="col-sm-8">
                <input id="datetimepicker3" name="order_wrdeadline" value="<?php echo $order->order_wrdeadline; ?>" class="border-default form-control"  type="text"> 
              </div>
            </div>




            <button class="btn btn-info">Adjust time</button> 
          </form>

          <script type="text/javascript">
            $('#datetimepicker1').datetimepicker({
              format:'Y-m-d H:i',
            });
            $('#datetimepicker2').datetimepicker({
              format:'Y-m-d H:i',
            });
            $('#datetimepicker3').datetimepicker({
              format:'Y-m-d H:i',
            });


          </script>
        </div>
      </div>
    </div>
  </div>
  @endif
</div>
@if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
<div class="col-sm-6 alert alert-success">
  <font color='red'>Order cost:</font>  {{ (int) $order->ccost }}/-<br/>
  <font color='red'>Pay writer:</font><span style="font-size: 11px;">  {{ (int) $order->wcost }}/-({{ $order->writer_paid }} 
    @if($order->invoice_id)
    <?php 
    $invoice = \App\Models\Invoice::find($order->invoice_id);
    ?>
    <a target="_blank" href="{{ url('cview-invoice/'.$invoice->slug) }}">Invoice ID {{ $order->invoice_id }}</a> 
  @endif)</span><br/>
  <font color='red'>Pay editor:</font><span style="font-size: 11px;">  {{ (int) $order->ecost }}/-({{ $order->editor_paid }} 
    @if($order->einvoice_id)
    <?php 
    $invoice = \App\Models\Invoice::find($order->einvoice_id);
    ?>
    <a target="_blank" href="{{ url('cview-invoice/'.$invoice->slug) }}">Invoice ID {{ $order->einvoice_id }}</a> 
  @endif)</span><br/>
  @if(Auth::user()->is_admin())
  @if(domain_name() == 'saseni.com')
  <font color='red'>Admin share:</font>  {{ (int) $order->order_admin_share }}/-<br/>
  <font color='red'>Subscription:</font>  {{ (int) $order->subscription_fee }}/-<br/>
  <font color='red'>plagiarism report fee:</font>  {{ (int) $order->plagiarism_report_fee }}/-<br/>
  <font color='red'>preferred writer only total:</font>  {{ (int) $order->preferred_writer_only_total }}/-<br/>
  <font color='red'>Top ten total:</font>  {{ (int) $order->top_ten_total }}/-<br/>
  @endif
  @endif
  <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#prices">
    Adjust Order    (@if(Auth::user()->is_admin())
      <?php
      $total = $order->ccost - $order->wcost - $order->ecost - $order->order_admin_share - $order->subscription_fee - $order->plagiarism_report_fee - $order->preferred_writer_only_total - $order->top_ten_total;
      ?>

      {{ (int) $total }}
      @endif)
    </button>
  </div>




  <!-- Modal -->
  <div class="modal fade" id="prices" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Update Order</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">

     <form role="form" action="{{ route('adjust_prices')}}" method="POST">
          @csrf
              <input value="<?php echo $order->id; ?>" name="order_id" class="border-default form-control"  type="hidden">




        <div class=" row mb-4">
           <label class="col-md-4 form-label">Slug</label>
           <div class="col-md-8">
             <input type="text"  class="form-control" name="slug" value="{{ $order->slug }}">
           </div>
         </div>


          <div class=" row mb-4">
           <label class="col-md-4 form-label">Writer ID</label>
           <div class="col-md-8">
             <input type="text"  class="form-control" name="writer_id" value="{{ $order->writer_id }}">
           </div>
         </div>

            <div class=" row mb-4">
           <label class="col-md-4 form-label">Client ID</label>
           <div class="col-md-8">
             <input type="text"  class="form-control" name="user_id" value="{{ $order->user_id }}">
           </div>
         </div>

            <div class=" row mb-4">
           <label class="col-md-4 form-label">Order cost</label>
           <div class="col-md-8">
             <input type="text"  class="form-control" name="ccost" value="{{ $order->ccost }}">
           </div>
         </div>

        <div class=" row mb-4">
           <label class="col-md-4 form-label">Pay writer:</label>
           <div class="col-md-8">
             <input type="text"  class="form-control" name="wcost" value="{{ $order->wcost }}">
           </div>
         </div>

        <div class=" row mb-4">
           <label class="col-md-4 form-label">Pay editor</label>
           <div class="col-md-8">
             <input type="text"  class="form-control" name="ecost" value="{{ $order->ecost }}">
           </div>
         </div>


       <div class=" row mb-4">
           <label class="col-md-4 form-label">Writer Invoice:</label>
           <div class="col-md-8">
             <input type="text"  class="form-control" name="invoice_id" value="{{ $order->invoice_id }}">
           </div>
         </div>

             <div class=" row mb-4">
           <label class="col-md-4 form-label">Editor Invoice:</label>
           <div class="col-md-8">
             <input type="text"  class="form-control" name="einvoice_id" value="{{ $order->einvoice_id }}">
           </div>
         </div>

          <div class=" row mb-4">
           <label class="col-md-4 form-label">Preferred writer only total</label>
           <div class="col-md-8">
             <input type="text"  class="form-control" name="preferred_writer_only_total" value="{{ $order->preferred_writer_only_total }}">
           </div>
         </div>


     

 

        <div class=" row mb-4">
           <label class="col-md-4 form-label">Order Fine</label>
           <div class="col-md-8">
             <input type="number"  class="form-control" name="order_fine" value="{{ $order->order_fine }}">
           </div>
         </div>


         <div class=" row mb-4">
           <label class="col-md-4 form-label">Order Fine Reason</label>
           <div class="col-md-8">
            <textarea class="form-control" name="order_finereason">{{ $order->order_finereason }}</textarea>
          </div>
        </div>


        <div class=" row mb-4">
           <label class="col-md-4 form-label">Admin share</label>
           <div class="col-md-8">
             <input type="number"  class="form-control" name="order_admin_share" value="{{ $order->order_admin_share }}">
           </div>
         </div>


            <div class=" row mb-4">
           <label class="col-md-4 form-label">Order cancelreason</label>
           <div class="col-md-8">
             <input type="text"  class="form-control" name="order_cancelreason" value="{{ $order->order_cancelreason }}">
           </div>
         </div>

<div style="display: none">

        <div class=" row mb-4">
           <label class="col-md-4 form-label">Subscription</label>
           <div class="col-md-8">
             <input type="number"  class="form-control" name="subscription_fee" value="{{ $order->subscription_fee }}">
           </div>
         </div>


          <div class=" row mb-4">
           <label class="col-md-4 form-label">Writer Payment</label>
           <div class="col-md-8">
             <input type="number"  class="form-control" name="payments" value="{{ $order->payments }}">
           </div>
         </div>



          <div class=" row mb-4">
           <label class="col-md-4 form-label">Editor Payment</label>
           <div class="col-md-8">
             <input type="number"  class="form-control" name="epayments" value="{{ $order->epayments }}">
           </div>
         </div>

          <div class=" row mb-4">
           <label class="col-md-4 form-label">Writer confirmation</label>
           <div class="col-md-8">
             <input type="number"  class="form-control" name="writer_confirm" value="{{ $order->writer_confirm }}">
           </div>
         </div>
       </div>





              <button class="btn btn-info">Adjust Order</button> 
            </form>



      </div>
    </div>
  </div>
</div>
@endif

</div>


</div>
</div>



@if($order->writer_id != '0')
<div class=" row mb-4">
  <label class="col-md-3 form-label">Writer ID:</label>
  <div class="col-md-9">
    @if($order->writer_id)
    <p><a target="_blank" href="{{ route('profile', userslug($order->writer_id) )}}">{{ username($order->writer_id)->nickname ?? 'none' }}: #{{ $order->writer_id }}</a></p>
    @endif
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif


@if($order->preferred_writer)
<div class=" row mb-4">
  <label class="col-md-3 form-label">Preferred Writer ID:</label>
  <div class="col-md-9">

    <p style="color: green;"><a target="_blank" href="{{ route('profile', userslug($order->preferred_writer) )}}"> {{ username($order->preferred_writer)->nickname ?? 'none' }} #{{ $order->preferred_writer }}</a> 



    </p>


    @if($order->preferred_writer_only == '1')
    <p style="color: red;">Work with preffered writer only</p> 
    @endif
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif




@if($order->category_id)
<div class=" row mb-4">
  <label class="col-md-3 form-label">Discipline:</label>
  <div class="col-md-9">

    <p>{{ subject($order->category_id) }}</p>
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif


@if($order->word_count)
<div class=" row mb-4">
  <label class="col-md-3 form-label">Number of pages:</label>
  <div class="col-md-9">
    {{ $order->word_count }} @if($order->word_count == 1) page @else pages @endif 
    (@if($order->order_style==1){{ $order->word_count*275 }}@else {{ $order->word_count*275*2 }} @endif words)<br>
    @if($order->order_style==2)
    Single
    @else
    Double 
    @endif
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif

@if($order->slide)
<div class=" row mb-4">
  <label class="col-md-3 form-label">PowerPoint Slides:</label>
  <div class="col-md-9">
    {{ $order->slide }} slide
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif

@if($order->sources)
<div class=" row mb-4">
  <label class="col-md-3 form-label">Sources to be cited:</label>
  <div class="col-md-9">
    {{ $order->sources }}
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif

@if($order->order_citation)
<div class=" row mb-4">
  <label class="col-md-3 form-label">Paper format:</label>
  <div class="col-md-9">
    {{ $order->order_citation }}
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif

@if(Auth::user()->is_admin())
@if($order->completed_at)
<div class=" row mb-12">
  <label class="col-md-3 form-label">Order was completed:</label>
  <div class="col-md-9">
  {!! remainingtime($order->completed_at) !!}
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif

@endif

@if(Auth::user()->is_editor() or Auth::user()->is_client() or Auth::user()->is_student())

@if($order->created_at)
<div class=" row mb-12">
  <label class="col-md-3 form-label">Order was posted:</label>
  <div class="col-md-9">
    {!! $order->created_at->diffForHumans() !!}
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif

@if($order->plagiarism_report)

<div class=" row mb-4">
  <label class="col-md-3 form-label">Plagiarism Report:</label>
  <div class="col-md-9">
    <span style="color: red;">{{ plagiarism_report($order->plagiarism_report) }}</span>
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif
@endif

@if(Auth::user()->is_client() or Auth::user()->is_student())
@if($order->personal_note)
<div class=" row mb-4">
  <label class="col-md-3 form-label">Personal Note:</label>
  <div class="col-md-9">
    <div class="col-sm-12 alert alert-info">
      <p>{{ $order->personal_note }}</p>
    </div>
  </div>
</div>
<hr style="border-top: 1px dotted #000000;">
@endif
@endif

@if(Auth::user()->is_client())
<div class=" row mb-4">

  <div class="col-md-12">
    <div id="accordion">


      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
          Add Personal Note (eg. I downloaded and submitted the order)
        </button>
      </h5>

      <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
        <div class="card-body">
          <form role="form" name="form" id="myform" action="{{ route('order_clientnote')}}" method="POST">
            <input type="hidden" name="order_id" value="{{ $order->id}}">
            <textarea class="form-control border-default" name="order_clientnote" id="note1" >{{ $order->order_clientnote }} </textarea>

            <script>
              ClassicEditor
              .create( document.querySelector( '#note1' ) )
              .catch( error => {
                console.error( error );
              } );
            </script>
            <br/>
            <button type="submit" class="btn btn-info">Add Note</button>
          </form>

        </div>
      </div>

    </div>
    @if($order->order_clientnote)
    <div class="alert alert-success ops-sm-12">            
      <p> My's Note </p>
      <?php echo $order->order_clientnote; ?> 
    </div>
    @endif
  </div>
</div>

@endif


@if($order->description)
<div class=" row mb-4">
  <hr style="border: 2px;">
  <label class="col-md-3 form-label"><strong>Instructions</strong></label>
  <div class="col-md-12">
    <main> {!! $order->description !!}</main>

  </div>
</div>
@endif

@if(Auth::user()->is_client() or Auth::user()->is_admin())
<div class=" row mb-4">

  <div class="col-md-12">
    <div id="accordion">


      <h5 class="mb-0">
        <button class="btn btn-link collapsed" data-toggle="collapse" data-target="#collapseThree1" aria-expanded="false" aria-controls="collapseThree">
          Add Comment
        </button>
      </h5>

      <div id="collapseThree1" class="collapse" aria-labelledby="headingThree" data-parent="#accordion">
        <div class="card-body">
          <form role="form" name="form" id="myform" action="{{ route('order_clientnotewriter')}}" method="POST">
            <input type="hidden" name="order_id" value="{{ $order->id}}">
            <textarea class="form-control border-default" name="order_clientnotewriter" id="note2" >{{ $order->order_clientnotewriter }} </textarea>

            <script>
              ClassicEditor
              .create( document.querySelector( '#note2' ) )
              .catch( error => {
                console.error( error );
              } );
            </script>
            <br/>
            <button type="submit" class="btn btn-info">Add Comment</button>
          </form>

        </div>
      </div>

    </div>

  </div>
</div>

@endif

@if($order->order_clientnotewriter)
<div class="alert alert-info ops-sm-12">            
  <p> Order Comment </p>

  <span style="font-size: 12px;">  <?php echo $order->order_clientnotewriter; ?> </span>

</div>
@endif

@if(Auth::user()->is_client() or Auth::user()->is_student())
@if($order->status==0)  
@if($order->order_level == 'normal' or $order->ccost > 0)  
<form class="form-horizontal" action="{{ route('confirm_order')}}" method="POST">
 @csrf
 <input type="hidden" name="id" value="{{ $order->id }}">



 <div class=" row mb-4">
  @if($order->urgency_id)
  <div class="col-md-9">
    <?php 

    $pricing = \App\Models\Pricing::find($order->urgency_id);
    ?>                                          
    @if($order->word_count <= $pricing->max_page)
    @if(wallet(Auth::user()->id)<$order->ccost)
    <input type="submit" value="Proceed to make payment for {{ get_currency() }} {{ $order->ccost - wallet(Auth::user()->id) }}" class="btn btn-success">
    @else

    <input type="submit" value="Submit" class="btn btn-primary">

    @endif

    @else

    <p class="alert alert-danger"><strong>{!! remainingtime($order->order_due) !!}</strong> <br>Sorry, we can not deliver the task with specified deadline, kindly adjust it if posible</p>

    <a href="{{ route('edit_order', $order->id )}}" class="btn btn-sm btn-primary badge"><i class="fa fa-edit"></i> Edit</a>

    @endif
  </div>

  @else

  <p class="alert alert-danger"><strong>{!! remainingtime($order->order_due) !!}</strong> <br>Sorry, we can not deliver this task within specified deadline, kindly adjust it if posible</p>
  <input type="submit" value="Just Work On It" class="btn btn-primary">

  @endif


</div>



</form>
@endif
@endif
@endif

@if(Auth::user()->is_writer())
@if($order->status==1)
   <a class="btn btn-sm btn-info badge" data-bs-target="#answer" data-bs-toggle="modal"><i class="fa fa-check"></i> Is there something missing in the instructions?</a> 


   <!-- edit modal-->
<div class="modal fade" id="answer">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content country-select-modal">
      <div class="modal-header">
        <h6 class="modal-title">I need a clrification for order No. {{ $order->id }}</h6><button aria-label="Close" class="btn-close"
        data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
      </div>


      <div class="modal-body">
        <form class="form-horizontal" action="{{ route('answer_order')}}" method="POST">
          @csrf

          <input type="hidden" name="order_id" value="{{ $order->id }}">
          <input type="hidden" name="status" value="5">


          <p>Description</p>

          <textarea class="form-control" name="description" required placeholder="Ask the question or tell us what is missing"></textarea>




          <div class=" row mb-4">

            <div class="col-md-9">
              <br>
             <input type="submit" value="Submit" class="btn btn-primary">
           </div>


         </div>



       </form>
     </div>
   </div>
 </div>
</div>
@endif
@endif



</div>
</div>









<div class="card">
 <div class="card-header border-bottom-0">


 </div>
 <div class="e-table px-5 pb-5">
   <div class="table-responsive table-lg">
     @if($uploads->count()>0)
     <table class="table border-top table-bordered mb-0">
       <tbody>
        <tr>
          <h3>Customer files</h3>
        </tr>

        @foreach($uploads as $upload)
        <?php
        $user = \App\Models\User::whereId($upload->user_id)->first();
        ?>
        <tr>
          <td>{{ $upload->name}}
          </td>
          <td>   <span style="color: green; font-size: 11px;" > Uploaded by {{ $user->user_type }} {{ $upload->created_at->diffForHumans() }}</span></td>

          <td>
            <!-- {{ $upload->file_path }} -->
            <!-- {{ get_option(site_id().'_main_site_url') }}/storage/uploads/{{ $upload->name }} -->
            <a href="{{ $upload->file_path }}" target="_blank" class="btn btn-success btn-sm"><i class="fa fa-download"></i> Download</a>
            @if(Auth::user()->is_admin() or Auth::user()->is_subadmin() or $order->status == 0)
            <a style="color: #ffffff;" class="btn btn-sm btn-danger" data-bs-target="#delete-upload{{ $upload->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Delete</a>
            <!-- delete modal-->
            <div class="modal fade" id="delete-upload{{ $upload->id }}">
             <div class="modal-dialog modal-dialog-centered" role="document">
               <div class="modal-content country-select-modal">
                 <div class="modal-header">
                   <h6 class="modal-title">Confirm you want to delete #{{ $upload->id }} file</h6><button aria-label="Close" class="btn-close"
                   data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                 </div>
                 <div class="modal-body">
                   <form class="form-horizontal" action="{{ route('delete_file')}}" method="POST">
                     @csrf
                     <input type="hidden" name="id" value="{{ $upload->id }}">


                     <div class=" row mb-4">


                      <p>Are you sure you want to delete this file?</p>
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

        @endif

      </td>

    </tr>
    @endforeach



  </tbody>

</table>

@endif

@if($order->status != 5 or Auth::user()->is_admin() or Auth::user()->is_client() or Auth::user()->is_student())

<?php
$cfiles = \App\Models\Upload::whereOrderId($order->id)->where('upload_type', '>=', 0)->count();
?>
@if($cfiles > 0)


<table class="table border-top table-bordered mb-0">
  <tbody>
    <hr>
    <tr>
      <h3>Order files</h3>
    </tr>
    <?php
    $cfiles = \App\Models\Upload::whereOrderId($order->id)->where('upload_type', '>', 2)->orderBy('id', 'desc')->get();
    ?>




    
    @if(Auth::user()->is_editor() or Auth::user()->is_admin() or Auth::user()->is_client() or Auth::user()->is_subadmin() or Auth::user()->is_writer() or Auth::user()->is_student())
    @foreach($cfiles as $upload)
    <tr>
     <?php
     $user = \App\Models\User::whereId($upload->user_id)->first();
     ?>
     <td>{{ $upload->name}}<br>

     </td>
     <td><span style="color: green; font-size: 11px;" >{{ uploadType($upload->upload_type)}} <br>uploaded by {{ $user->user_type }} {{ $upload->created_at->diffForHumans() }} ({{ $upload->created_at }})</span></td>

     <td>

      <a class="btn btn-sm btn-success" target="_blank" href="{{ get_option(site_id().'_main_site_url') }}/storage/uploads/{{ $upload->name }}"><i class="fa fa-download"></i> Download</a>

      @if(Auth::user()->is_editor() or Auth::user()->is_admin() or Auth::user()->is_subadmin())
      <a style="color: #ffffff;" class="btn btn-sm btn-danger" data-bs-target="#delete-order{{ $order->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Delete</a>
      @endif


      <!-- delete modal-->
      <div class="modal fade" id="delete-order{{ $order->id }}">
       <div class="modal-dialog modal-dialog-centered" role="document">
         <div class="modal-content country-select-modal">
           <div class="modal-header">
             <h6 class="modal-title">Confirm you want to delete #{{ $upload->id }} file</h6><button aria-label="Close" class="btn-close"
             data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
           </div>
           <div class="modal-body">
             <form class="form-horizontal" action="{{ route('delete_file')}}" method="POST">
               @csrf
               <input type="hidden" name="id" value="{{ $upload->id }}">


               <div class=" row mb-4">


                <p>Are you sure you want to delete this file?</p>
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

</td>
</tr>
@endforeach
@endif

<?php
$cfiles = \App\Models\Upload::whereOrderId($order->id)->where('upload_type', '<', 3)->get();
?>

<hr>
@if(Auth::user()->is_editor() or Auth::user()->is_admin() or Auth::user()->is_writer() or Auth::user()->is_subadmin())
@foreach($cfiles as $upload)
<tr>
 <?php

 $user = \App\Models\User::whereId($upload->user_id)->first();


 ?>
 <td>{{ $upload->name}}
 </td>
 <td><span style="color: green; font-size: 11px;" >{{ uploadType($upload->upload_type)}} <br>uploaded by  {{ $user->user_type }} {{ $upload->created_at->diffForHumans() }}</span></td>

 <td>
  <a class="btn btn-sm btn-success" target="_blank" href="{{ get_option(site_id().'_main_site_url') }}/storage/uploads/{{ $upload->name }}"><i class="fa fa-download"></i> Download</a>
  @if(Auth::user()->is_editor() or Auth::user()->is_admin() or Auth::user()->is_subadmin())
  <a style="color: #ffffff;" class="btn btn-sm btn-danger" data-bs-target="#delete-order{{ $order->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Delete</a>

  <!-- delete modal-->
  <div class="modal fade" id="delete-order{{ $order->id }}">
   <div class="modal-dialog modal-dialog-centered" role="document">
     <div class="modal-content country-select-modal">
       <div class="modal-header">
         <h6 class="modal-title">Confirm you want to delete #{{ $upload->id }} file</h6><button aria-label="Close" class="btn-close"
         data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
       </div>

       <div class="modal-body">
        <form class="form-horizontal" action="{{ route('delete_file')}}" method="POST">
         @csrf
         <input type="hidden" name="id" value="{{ $upload->id }}">
         <div class=" row mb-4">
          <p>Are you sure you want to delete this file?</p>
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
@endif



</td>

</tr>
@endforeach
@endif

</tbody>
</table>



@endif


<span class="badge bg-secondary fs-14 me-2">Upload order files</span>

<form action="{{route('fileUpload')}}" method="post" enctype="multipart/form-data">

 @csrf
 <input type="hidden" name="order_id" value="{{ $order->id }}">
 <div class=" row mb-4">
  <div class="col-md-12">
    <input type="file" name="file" class="dropify" data-bs-height="180">
  </div>
</div>

<div class="col-xl-6 col-md-6">
  <div class="form-group">
   <div class="form-label">File upload type</div>
   <div class="custom-controls-stacked">
    @if(Auth::user()->is_writer())

    @if($order->editor_involved == '1')
    <label class="custom-control custom-radio-lg">
      <input type="radio" class="custom-control-input" name="upload_type" value="0" checked>
      <span class="custom-control-label">Final document to editor</span>
    </label>
    <label class="custom-control custom-radio-lg">
      <input type="radio" class="custom-control-input" name="upload_type" value="1">
      <span class="custom-control-label">Plagiarism Report to editor</span>
    </label>
    @else
    <label class="custom-control custom-radio-lg">
      <input type="radio" class="custom-control-input" name="upload_type" value="3">
      <span class="custom-control-label">Plagiarism Report to client</span>
    </label>

    <label class="custom-control custom-radio-lg">
      <input type="radio" class="custom-control-input" name="upload_type" value="4" checked>
      <span class="custom-control-label">Final document to client</span>
    </label>
    @endif
    @endif

    @if(Auth::user()->is_editor() or Auth::user()->is_admin() or Auth::user()->is_subadmin())

    <label class="custom-control custom-radio-lg">
      <input type="radio" class="custom-control-input" name="upload_type" value="5" checked>
      <span class="custom-control-label">Order instructions</span>
    </label>


    <label class="custom-control custom-radio-lg">
      <input type="radio" class="custom-control-input" name="upload_type" value="2">
      <span class="custom-control-label">File with comments to writer</span>
    </label>



    <label class="custom-control custom-radio-lg">
      <input type="radio" class="custom-control-input" name="upload_type" value="3">
      <span class="custom-control-label">Plagiarism Report to client</span>
    </label>

    <label class="custom-control custom-radio-lg">
      <input type="radio" class="custom-control-input" name="upload_type" value="4" checked>
      <span class="custom-control-label">Final document to client</span>
    </label>



    <div class=" row mb-4">
      <label class="col-md-5 form-label">Plagiarism Score</label>
      <div class="col-md-7">
        <input type="number" name="plagiarism_score" class="form-control" placeholder="Enter Plagiarism Score
        " value="{{ $order->plagiarism_score}}">
      </div>
    </div>




    @endif


  </div>
</div>
</div>

<button type="submit" name="submit" class="btn btn-primary">
 Upload Files
</button>
</form>


@endif
</div>
</div>
</div>
</div>

<div class="col-lg-4 col-xl-4">

 @if(Auth::user()->id == '3')
 @if($order->status == '0')

 <div class="card">
  <div class="card-body">
    <form class="form-horizontal" method="POST" action="{{ route('change_payment_way') }}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="order_id" value="{{ $order->id }}">


      <div class=" row mb-4">
        <div class="col-md-4">Payments</div>
        <div class="col-md-8">
          <select class="form-control" name="payment_way">
            <option value="{{ $order->payment_way }}" selected>
              <?php
              if($order->payment_way =='0') {
                echo 'Pre Pay';
              }

              if($order->payment_way =='1') {
                echo 'Pay Later';
              }


              ?>

            </option>
            <option value="0">Pre Pay</option>
            <option value="1">Pay Later</option>
          </select>
        </div>
      </div>

      <div class="row mb-0">
        <div class="col-md-6 offset-md-4">
          <button type="submit" class="btn btn-primary btn-sm">
            Update
          </button>
        </div>
      </div>
    </form>
  </div>
</div>

@endif



@endif

@if(Auth::user()->is_admin() or Auth::user()->is_editor() or Auth::user()->is_subadmin())





<div class="card">

  <div class="card-body">


    @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
    <form class="form-horizontal" method="POST" action="{{ route('change_status') }}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="order_id" value="{{ $order->id }}">

      <div class=" row mb-4">
        <div class="col-md-4">Status</div>
        <div class="col-md-8">
          <select class="form-control" name="status">
            <option value="{{ $order->status }}" selected>
              <?php
              if($order->status =='0') {
                echo 'Pending';
              }

              if($order->status =='1') {
                echo 'Available';
              }

              if($order->status =='2') {
                echo 'Assigned';
              }

              if($order->status =='3') {
                echo 'editing';
              }

              if($order->status =='8') {
                echo 'editor revision';
              }

              if($order->status =='4') {
                echo 'completed';
              }

              if($order->status =='5') {
                echo 'Approved';
              }

              if($order->status =='6') {
                echo 'Revision';
              }

              if($order->status =='9') {
                echo 'Dispute Raised';
              }

              if($order->status =='7') {
                echo 'Cancelled';
              }

              ?>

            </option>
            <option value="0">Pending</option>
            <option value="1">Available</option>
            <option value="2">Assigned</option>
            <option value="3">Editing</option>
            <option value="8">Editor Revision</option>
            <option value="4">Completed</option>
            <option value="5">Approved</option>
            <option value="6">Revision</option>
            <option value="9">Dispute</option>
          </select>
        </div>
      </div>

      <div class="row mb-0">
        <div class="col-md-6 offset-md-4">
          <button type="submit" class="btn btn-primary btn-sm">
            Update
          </button>
        </div>
      </div>
    </form>



    @endif


    @if(Auth::user()->is_editor())
    
    <form class="form-horizontal" method="POST" action="{{ route('change_status') }}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="order_id" value="{{ $order->id }}">
      @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
      <div class=" row mb-4">
        <div class="col-md-4">Order cost</div>
        <div class="col-md-8">
          {{ price($order->ccost)}}
        </div>
      </div>
      @endif

      <div class=" row mb-4">
        <div class="col-md-4">Status</div>
        <div class="col-md-8">
          <select class="form-control" name="status">
            <option value="{{ $order->status }}" selected>
              <?php
              

              if($order->status =='1') {
                echo 'Available';
              }

              if($order->status =='2') {
                echo 'Assigned';
              }

              if($order->status =='3') {
                echo 'editing';
              }

              if($order->status =='8') {
                echo 'editor revision';
              }

              if($order->status =='4') {
                echo 'completed';
              }

              

              if($order->status =='6') {
                echo 'Revision';
              }


              ?>

            </option>
            <option value="8">Editor Revision</option>
            <option value="4">Completed</option>
          </select>
        </div>
      </div>

      <div class="row mb-0">
        <div class="col-md-6 offset-md-4">
          <button type="submit" class="btn btn-primary btn-sm">
            Update
          </button>
        </div>
      </div>
    </form>



    @endif

    <hr>

    @if(Auth::user()->is_admin() or Auth::user()->is_subadmin() or Auth::user()->id == '3')
    @if($order->status == '0')
    <form class="form-horizontal" method="POST" action="{{ route('change_payment_way') }}" enctype="multipart/form-data">
      @csrf

      <input type="hidden" name="order_id" value="{{ $order->id }}">


      <div class=" row mb-4">
        <div class="col-md-4">Payments</div>
        <div class="col-md-8">
          <select class="form-control" name="payment_way">
            <option value="{{ $order->payment_way }}" selected>
              <?php
              if($order->payment_way =='0') {
                echo 'Pre Pay';
              }

              if($order->payment_way =='1') {
                echo 'Pay Later';
              }


              ?>

            </option>
            <option value="0">Pre Pay</option>
            <option value="1">Pay Later</option>
          </select>
        </div>
      </div>

      <div class="row mb-0">
        <div class="col-md-6 offset-md-4">
          <button type="submit" class="btn btn-primary btn-sm">
            Update
          </button>
        </div>
      </div>
    </form>

    @endif



    @endif
    




  </div>
</div>






<?php 
$user = \App\Models\User::whereId($order->user_id)->first();
if ($user->account_status == '0') {
  $cost = $order->ccost;
  $cost = $cost/get_option(site_id().'_admin_share');
  $editor_share = $cost * get_option(site_id().'_editor_share');
  $writer_share = $cost * get_option(site_id().'_writer_share');
  $admin_share  = $order->ccost - $cost;
  $order_admin_share  = $cost * get_option(site_id().'_order_admin_share');
}
else{

  $cost = $order->ccost;
  $editor_share = $cost * get_option(site_id().'_editor_share');
  $writer_share = $cost * get_option(site_id().'_writer_share');
  $admin_share  = 0;
  $order_admin_share  = $cost * get_option(site_id().'_order_admin_share');
}
?>
@endif

@if(Auth::user()->is_admin() or Auth::user()->is_subadmin())


@if(!$order->editor_id)
<div class="card" style="margin-bottom: 20px;">
  <div class="card-header">
    <h4 class="card-title">
     Assign order to editor: 
     @if($order->editor_id == '0')
     <span style="color: red;">not yet</span>
     @else
     <span style="color: green;">Assigned</span>
     @endif
   </h4>
 </div>
 <div class="card-body">




  <form class="form-horizontal" method="POST" action="{{ route('assign_editor') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="order_id" value="{{ $order->id }}">

    <div class=" row mb-4">
      <label class="col-md-4 form-label">Assign</label>
      <div class="col-md-8">
        <select class="form-control" name="editor_id">

          <?php
          $writers = \App\Models\User::whereUserType('editor')->get();
          $countwriter = \App\Models\User::whereId($order->editor_id)->count();
          $writer = \App\Models\User::whereId($order->editor_id)->first();
          ?>

          @if($countwriter>0)
          <option value="{{$order->writer_id }}" selected>
           {{$writer->name }}

         </option>
         @endif

         @foreach($writers as $writer)
         <option value="{{ $writer->id }}">{{ $writer->name }}</option>
         @endforeach

       </select>
     </div>
   </div>

   <div class="row mb-0">
    <div class="col-md-6 offset-md-4">

      @if($order->editor_id == '0')
      <button type="submit" class="btn btn-primary btn-sm">
        Assign
      </button>
      @else
      <button type="submit" class="btn btn-success btn-sm">
        Update
      </button>
      @endif
    </div>
  </div>
</form>







</div>
</div>
@endif

@if($invoices->count() <= 0)

<div class="card">
  <div class="card-header">
    <h4 class="card-title">Create custom invoice</h4>
  </div>
  <div class="card-body">

    <form class="form-horizontal" action="{{ route('cinvoice') }}" method="POST">
      @csrf
      <input type="hidden" name="order_id" value="{{ $order->id }}">

      <div class=" row mb-4">
        <label class="col-md-4 form-label">Payment for</label>
        <div class="col-md-8">
          <input type="text" class="form-control" name="item_name" placeholder="payment for ...">
        </div>
      </div>

      <div class=" row mb-4">
        <label class="col-md-4 form-label">Currency</label>
        <div class="col-md-8">

          <?php $current_currency = Auth::user()->currency_sign; ?>

          <select name="currency" class="form-control">
           @foreach(currencies() as $code => $name)
           <option value="{{ $code }}"  {{ get_option(site_id().'_currency_sign') == $code? 'selected':'' }}> {{ $code }} 
           </option>
           @endforeach
         </select>
       </div>
     </div>

     <div class=" row mb-4">
      <label class="col-md-4 form-label">Amount</label>
      <div class="col-md-8">
        <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid phone is required: 0725000000">

         <input  class="input100 border-start-0 ms-0 form-control" name="amount" type="text" placeholder="enter amount...">
       </div>

     </div>
   </div>

   <div class=" row mb-4">
    <div class="col-md-9">
     <input type="submit" value="Save" class="btn btn-primary">
   </div>
 </div>
</form>
</div>
</div>
@else


<div class="card">
  <div class="card-header">
    <h4 class="card-title">Add service to invoice</h4>
  </div>
  <div class="card-body">

   <form class="form-horizontal" action="{{ route('add_service')}}" method="POST">
    @csrf
    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
    <input type="hidden" name="currency" value="{{Auth::user()->currency_sign}}">
    <div class=" row mb-4">
      <label class="col-md-3 form-label">Service Name</label>
      <div class="col-md-9">
        <input type="text" class="form-control" name="service_name" value="{{ $invoice->name }}">
      </div>
    </div>

    <div class=" row mb-4">
      <label class="col-md-3 form-label">Amount</label>
      <div class="col-md-9">
        <input type="text" class="form-control" name="amount" value="{{ $invoice->location }}">
      </div>


    </div>

    <div class=" row mb-4">

      <div class="col-md-9">
       <input type="submit" value="Save" class="btn btn-primary">
     </div>


   </div>



 </form>
</div>
</div>


@endif
@endif


@if(Auth::user()->is_admin() or Auth::user()->is_subadmin() or Auth::user()->is_editor() or Auth::user()->is_writer())

<?php
$comments = \App\Models\Comment::whereOrderId($order->id)->get();
?>





@endif


@if(Auth::user()->is_editor())
@if($order->status >=3)
@if($order->eorder_rating == "")
<div class="card">
  <div class="card-header">
    <h4 class="card-title">Rate this writer as an editor</h4>
  </div>
  <div class="card-body">

    <form class="form-horizontal" action="{{ route('erate_save') }}" method="POST">
      @csrf


      <input type="hidden" name="order_id" value="{{ $order->id }}">

      <div class="col-sm-12">
        <div class="row">
          <input name="order_rating" value="1" type="radio" class="col-sm-1">
          <label for="radio120" class="col-sm-8"> 1/5 (00%-20%)</label>
        </div>

        <div class="row">
          <input name="order_rating" value="2" type="radio" class="col-sm-1">
          <label for="radio120" class="col-sm-8"> 2/5 (20%-40%)</label>
        </div>


        <div class="row">
          <input name="order_rating" value="3" type="radio" class="col-sm-1">
          <label for="radio120" class="col-sm-8"> 3/5 (40%-60%)</label>
        </div>

        <div class="row">
          <input name="order_rating" value="4" type="radio" class="col-sm-1">
          <label for="radio120" class="col-sm-8"> 4/5 (60%-80%)</label>
        </div>


        <div class="row">
          <input name="order_rating" value="5" type="radio" class="col-sm-1">
          <label for="radio120" class="col-sm-8"> 5/5 (80%-99%)</label>
        </div>

      </div>


      <div class="form-group">
        <label for="exampleTextarea">Give your approval comments</label>
        <textarea class="form-control border-default" name="order_ratecomment" id="editor" rows="3"></textarea>
      </div>

      <div class="form-group">
        <button class="btn btn-info">Submit ratings</button>
      </div>

    </form>
  </div>
</div>
@else
Editor comments<br>
{{ $order->eorder_rating}}/5  <br>
{{ $order->eorder_ratecomment }}

@endif

@endif
@endif








@if($order->status > 1)
<div class="sticky-top">
  <div id="chat" style="background-color: #ffffff; padding: 10px; border: solid; border-width: 1px; border-radius: 10px;">


    <div>
      <div class="main-content-app pt-0">
       <div class="main-content-body main-content-body-chat h-100">
        <div class="main-chat-header pt-3 d-block d-sm-flex">

          <div class="main-chat-msg-name mt-2">
            <h6>Messages for order <a href="{{ route('view_order', $order->id )}}">#{{ $order->id }}</a></h6>
            <span style="font-size: 10px;" id="dynamic-content3"></span>

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
          <div class="content-inner" id="box">
            <?php
            $chats = \App\Models\Chat::whereOrderId($order->id)->orderBy('id', 'asc')->get();
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
                $user_count = \App\Models\User::whereId($chat2->message_from)->count();
                ?>
                @if( $user_count>0)
                <div class="main-img-user online"><img alt="avatar" src="{{ $user->get_gravatar(150) ?? 'none' }}">
                  @endif
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

                     @if($user->is_client() or Auth::user()->is_student())
                     client:
                     @endif
                     @endif {!! $chat2->created_at->diffForHumans() !!}</span> <a href="javascript:void(0)"><i class="icon ion-android-more-horizontal"></i>

                      @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())



                      <a class="nav-link" data-bs-target="#delete-message{{ $chat2->id }}" data-bs-toggle="modal"><i class="fe fe-more-horizontal"></i></a> 


                      @endif
                    </a>
                  </div>
                </div>
              </div>
              <br> <br> <br>

              <!-- edit modal-->
              <div class="modal fade" id="delete-message{{ $chat2->id }}">
               <div class="modal-dialog modal-dialog-centered" role="document">
                 <div class="modal-content country-select-modal">
                   <div class="modal-header">
                     <h6 class="modal-title">Delete message with #{{ $chat2->id }}</h6><button aria-label="Close" class="btn-close"
                     data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                   </div>
                   <div class="modal-body">
                     <form class="form-horizontal" action="{{ route('delete_message')}}" method="POST">
                       @csrf
                       <input type="hidden" name="chat_id" value="{{ $chat2->id }}">


                       <div class=" row mb-4">
                        <p>Are you sure you want to delete below message?<br>{!! $chat2->messages !!}</p>


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
          @endforeach
          @else
          <center><h3>No messages available</h3>
            <i class="fa fa-comments-o fa-2xl"></i></center>

            @endif





          </div>


        </div>

        <div class="form-horizontal">




          <input type="hidden" id="order_id" value="{{ $order->id }}">
          <div class=" row mb-4">

            <div class="col-md-12">



              @if(Auth::user()->is_client() or Auth::user()->is_student())

              @if($order->writer_id)
              <div class="selectgroup selectgroup-pills">
                <label class="selectgroup-item">
                  <input type="radio" name="message_to" id="message_to" value="writer" class="selectgroup-input" checked="">
                  <span class="selectgroup-button">
                   Message to Writer
                 </span>
               </label>
             </div>
             @endif
             @if($order->editor_id)

             <div class="selectgroup selectgroup-pills">
              <label class="selectgroup-item">
                <input type="radio" name="message_to" id="message_to" value="editor" class="selectgroup-input">
                <span class="selectgroup-button">
                  Editor
                </span>
              </label>
            </div>

            @endif

            <div class="selectgroup selectgroup-pills">
              <label class="selectgroup-item">
                <input type="radio" name="message_to" id="message_to" value="support" class="selectgroup-input">
                <span class="selectgroup-button">
                 Support
               </span>
             </label>
           </div>

           @endif

           @if(Auth::user()->is_editor())
           @if($order->writer_id)
           <div class="selectgroup selectgroup-pills">
            <label class="selectgroup-item">
              <input type="radio" name="message_to" id="message_to" value="writer" class="selectgroup-input" checked="">
              <span class="selectgroup-button">
               Message to Writer
             </span>
           </label>
         </div>
         @endif

         <div class="selectgroup selectgroup-pills">
          <label class="selectgroup-item">
            <input type="radio" name="message_to" id="message_to" value="client" class="selectgroup-input">
            <span class="selectgroup-button">
             Client
           </span>
         </label>
       </div>

       <div class="selectgroup selectgroup-pills">
        <label class="selectgroup-item">
          <input type="radio" name="message_to" id="message_to" value="support" class="selectgroup-input">
          <span class="selectgroup-button">
           Support
         </span>
       </label>
     </div>

     @endif




     @if(Auth::user()->is_writer())
     <div class="selectgroup selectgroup-pills">
      <label class="selectgroup-item">
        <input type="radio" name="message_to" id="message_to" value="support" class="selectgroup-input">
        <span class="selectgroup-button">
         Message to Support
       </span>
     </label>
   </div>
   <div class="selectgroup selectgroup-pills">
    <label class="selectgroup-item">
      <input type="radio" name="message_to" id="message_to" value="client" class="selectgroup-input" checked="">
      <span class="selectgroup-button">
       Message to Client
     </span>
   </label>
 </div>
 @if($order->editor_id)
 <div class="selectgroup selectgroup-pills">
  <label class="selectgroup-item">
    <input type="radio" name="message_to" id="message_to" value="editor" class="selectgroup-input">
    <span class="selectgroup-button">
     Message to Editor
   </span>
 </label>
</div>
@endif
@endif

@if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
<div class="selectgroup selectgroup-pills">
  <label class="selectgroup-item">
    <input type="radio" name="message_to" id="message_to" value="client" class="selectgroup-input" checked="">
    <span class="selectgroup-button">
     Message to Client
   </span>
 </label>
</div>
@if($order->editor_id)
<div class="selectgroup selectgroup-pills">
  <label class="selectgroup-item">
    <input type="radio" name="message_to" id="message_to" value="editor" class="selectgroup-input">
    <span class="selectgroup-button">
     Message to Editor
   </span>
 </label>
</div>
@endif
@if($order->writer_id)
<div class="selectgroup selectgroup-pills">
  <label class="selectgroup-item">
    <input type="radio" name="message_to" id="message_to" value="writer" class="selectgroup-input">
    <span class="selectgroup-button">
     Message to Writer
   </span>
 </label>
</div>
@endif
@endif

</div>
</div>
@if($order->status != 5)
<textarea class="form-control" id="message" placeholder="Type your message here..." required=""></textarea>

<button id="makePayment" class="btn btn-icon  btn-primary brround"><i class="fa fa-paper-plane-o"></i></button>

<button id="makePaymentDisabled" style="display:none;" class="btn btn-sm btn-success" disabled>Sending...
</button>
<nav class="nav">
</nav>


<div id="modal-loader3" style="display: none; text-align: center;">
  <img src="{{asset('uploads')}}/loader.gif">
</div>

<!-- content will be load here -->                          





@endif

<script type="text/javascript">




</script>


</div>

</div>
</div>
</div>
</div>

@if(Auth::user()->is_writer())

<div class="alert alert-info" style="padding: 20px; margin-top: 20px; margin-bottom: 50px;">
  <center>
    <h4>Note: <br>If client does not respond to your message within 30 min, kindly call support via </h4>
    <h3>{{ get_option(site_id().'_admin_phone') }}</h3>
  </center>
  
</div>

@endif

</div>
</div>
@else

@if(Auth::user()->is_admin() or Auth::user()->is_client() or Auth::user()->is_editor())
<h3>Bids</h3>
<?php

$bids      = \App\Models\Bid::whereOrderId($order->id)->get();
$bid_count = \App\Models\Bid::whereOrderId($order->id)->count();
?>

@if($bid_count>0)



@foreach($bids as $bid)

<?php
$user = \App\Models\User::find($bid->user_id);
$user_count = \App\Models\User::whereId($bid->user_id)->count();
?>



<div class="card" >


  <div class="card-body">
    <div class="row">

      <div class="col-sm-4">
        @if($user_count>0)

        <img alt="avatar" src="{{ $user->get_gravatar(150) ?? 'none' }}" alt="{{ username($user->id)->nickname ?? 'none' }}"> 
        @endif


      </div>

      <div class="col-sm-8">
        <h5>    
          <a href="{{ route('profile', $user->slug )}}">
            {{ username($user->id)->nickname ?? 'none' }} (<span >ID:{{ $user->id }}</span> )
          </a>
        </h5>

        <div>
          <?php
          $count_star_rating = \App\Models\Review_rating::whereWriterId($user->id)->count();
          $sum_star_rating = \App\Models\Review_rating::whereWriterId($user->id)->sum('star_rating');
          if ($count_star_rating!=0) {
           $star_rating = $sum_star_rating/$count_star_rating*100;
         } else{
          $star_rating = 0;
        }

        ?>

        <a href="javascript:void(0)" class="fw-semibold">Average quality score {{ number_format((float)$star_rating, 2, '.', '')  }}%</a><br>


        <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
        <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
        <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
        <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
        <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>


      </div>

      <div class="mt-sm-1 d-block">
        In progress orders<span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">{{ writer_counter($user->id, 2)}}</span><br>

        Completed orders<span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">{{ writer_counter($user->id, 4) }}</span><br>

        Approved orders<span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">
          {{ writer_counter($user->id, 5) }}</span><br>
        </div>

      </div>


      <div class="col-sm-12 text-center">
        <br>
        <?php 
        $ratings   = \App\Models\Review_rating::whereWriterId($user->id)->count();
        $eratings = \App\Models\Order::whereWriterId($user->id)->where('eorder_rating', '!=', '')->count();
        ?> 



        <a href="javascript:void(0)" class="me-4 d-inline-block" data-bs-target="#client-reviews{{ $bid->user_id }}" data-bs-toggle="modal"> ({{ $ratings }}) Client Reviews</a>

        <!-- delete modal-->
        <div class="modal fade" id="client-reviews{{ $bid->user_id }}">
         <div class="modal-dialog modal-dialog-centered" role="document">
           <div class="modal-content country-select-modal">
             <div class="modal-header">
               <h6 class="modal-title">Reviews</h6><button aria-label="Close" class="btn-close"
               data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
             </div>
             <div class="modal-body">

               <?php 
               $ratings_count = \App\Models\Review_rating::whereWriterId($bid->user_id)->count();
               $ratings = \App\Models\Review_rating::whereWriterId($bid->user_id)->orderBy('id', 'desc')->get();
               ?> 

               @if($ratings->count()>0)

               <h3 class="card-title mb-0">Recent reviews <span class="badge bg-secondary fs-14 me-2">{{ $ratings_count }} review </span></h3>


               @foreach($ratings as $rate)

               <div class="card">

                <div class="card-body">
                  <?php 
                  $order2 = \App\Models\Order::find($rate->order_id);
                  $order2_count = \App\Models\Order::whereId($rate->order_id)->count(); 
                  ?> 
                  @if($order2_count > 0)
                  <div class="row">
                    <div class="col-sm-8">
                      <h4>{{ $order2->title }}</h4>
                      <a href="{{ route('view_order', $order2->slug )}}">
                        {{ $rate->comments }}</a><br>
                        <span style="font-size: 10px; color: green;">


                          @if($order2->word_count)
                          <span style="font-size: 11px;" class="fw-semibold mt-sm-2 d-block"  >{!! $rate->created_at->diffForHumans() !!}  {{ $order2->word_count }} 
                            @if($order2->word_count == 1) page @else pages @endif

                            @endif

                            @if($order2->slide)
                            {{ $order2->slide }} 
                            @if($order2->slide == 1) slide @else slides @endif
                          </span>
                          @endif 
                        </span>

                      </div>

                      <div class="col-sm-4">


                        Average quality score  {!! $rate->star_rating*100 !!}%<br>
                        <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
                        <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
                        <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
                        <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
                        <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
                      </div>






                    </div> 
                    @endif                              


                  </div>
                </div>
                @endforeach








                @else
                <tr>No order reviews</tr>
                @endif
              </div>
            </div>
          </div>
        </div>



        <a href="javascript:void(0)" class="me-4 d-inline-block" data-bs-target="#editor-reviews{{ $bid->user_id }}" data-bs-toggle="modal"> ({{ $eratings }}) Editor Reviews</a> 

        <!-- editor-reviews-->
        <div class="modal fade" id="editor-reviews{{ $bid->user_id }}">
         <div class="modal-dialog modal-dialog-centered" role="document">
           <div class="modal-content country-select-modal">
             <div class="modal-header">
               <h6 class="modal-title">Editor Reviews</h6><button aria-label="Close" class="btn-close"
               data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
             </div>

             <div class="modal-body">

               <?php 
               $ratings_count = \App\Models\Order::whereWriterId($bid->user_id)->where('eorder_rating', '!=', '')->count();
               $ratings = \App\Models\Order::whereWriterId($bid->user_id)->where('eorder_rating', '!=', '')->orderBy('id', 'desc')->get();
               ?> 

               @if($ratings->count()>0)

               <h3 class="card-title mb-0">Recent reviews <span class="badge bg-secondary fs-14 me-2">{{ $ratings_count }} review </span></h3>


               @foreach($ratings as $rate)

               <div class="card">

                <div class="card-body">
                  <?php 
                  $order1 = \App\Models\Order::find($rate->id); 
                  ?> 
                  @if($order1->count() > 0)
                  <div class="row">
                    <div class="col-sm-8">
                      <h4>{{ $order1->title }}</h4>
                      <a href="{{ route('view_order', $order1->slug )}}">
                        {{ $rate->eorder_ratecomment }}</a><br>
                        <span style="font-size: 10px; color: green;">


                          @if($order1->word_count)
                          <span style="font-size: 11px;" class="fw-semibold mt-sm-2 d-block"  >{!! $rate->created_at->diffForHumans() !!}  {{ $order1->word_count }} 
                            @if($order1->word_count == 1) page @else pages @endif

                            @endif

                            @if($order1->slide)
                            {{ $order1->slide }} 
                            @if($order1->slide == 1) slide @else slides @endif
                          </span>
                          @endif 
                        </span>

                      </div>

                      <div class="col-sm-4">


                        Average quality score  {!! $rate->eorder_rating !!}/5<br>
                        <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
                        <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
                        <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
                        <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
                        <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
                      </div>






                    </div> 
                    @endif                              


                  </div>
                </div>
                @endforeach
                @else
                <tr>No order reviews</tr>
                @endif
              </div>
            </div>
          </div>
        </div> 
      </div>


      <div class="col-sm-12">
        <br>
        <center>

         <form class="form-horizontal" method="POST" action="{{ route('change_status_assign') }}" enctype="multipart/form-data">
          @csrf
          <input type="hidden" name="order_id" value="{{ $order->id }}">
          <input type="hidden" name="amount" value="{{ $bid->writer_budget }}">
          <input type="hidden" name="writer_id" value="{{ $bid->user_id }}" >



          @if(Auth::user()->is_admin())
          <div class=" row mb-4">
            <div class="col-md-4">Pay (  {{ get_currency() }})</div>
            <div class="col-md-8">
              <input type="number" name="pay_writer" class="form-control" value="{{ $order->wcost }}" required placeholder="Client amount">
            </div>
          </div>

          @endif

          <div class=" row mb-4" style="display: none;">
            <div class="col-md-4">Pay ({{ get_currency() }})</div>
            <div class="col-md-8">
              <input type="number" name="pay_writer" class="form-control" value="{{ $order->wcost }}" required placeholder="Client amount">
            </div>
          </div>



          <div class="row mb-0">
            <div class="col-md-6 offset-md-4">
             @if($order->writer_id == '0')
             <button
             class="btn ripple btn-min w-sm btn-outline-primary me-2 my-auto d-lg-none d-xl-block d-block">
             <span class="ms-4 me-4">Accept {{ get_option(site_id().'_expert_name') }}</span>
           </button>
           @else
           <button type="submit" class="btn btn-success btn-sm">
             Update
           </button>
           @endif

         </div>
       </div>
     </form>




   </center>


 </div>





</div>
</div>
</div>

@endforeach

@endif
@endif


@endif










</div>




</div>


</div>
<!-- ROW CLOSED -->


</div>
</div>
</div>




@endsection
@section('page-js')


<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="{{ asset('assets/js/chat.js')}}"></script>

<!-- FILE UPLOADES JS -->
<script src="{{ asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
<script src="{{ asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>

<!-- INTERNAL File-Uploads Js-->
<script src="{{ asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
<script src="{{ asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
<script src="{{ asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
<script src="{{ asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
<script src="{{ asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>

<!-- Star Rating-1 Js-->
<script src="{{ asset('assets/plugins/ratings-2/jquery.star-rating.js')}}"></script>
<script src="{{ asset('assets/plugins/ratings-2/star-rating.js')}}"></script>



<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script>
 $(document).ready(function(){
  $(document).on('click', '#makePayment', function(e){

    e.preventDefault();

            var order_id    = document.getElementById('order_id').value;   // it will get id of clicked row
            var message_to   = document.getElementById('message_to').value;
            var message  = document.getElementById('message').value;

            // leave it blank before ajax call
            $('#modal-loader3').show();      // load ajax loader
            $('#makePayment').hide();
            $('#makePaymentDisabled').show();
            
            $.ajax({
              url: '{{ route('send_message') }}',
              type: 'post',
              data: 'order_id='+order_id+'&message_to='+message_to+'&message='+message,
              dataType: 'html'
            })
            .done(function(data){
               $('#dynamic-content3').html(data); // load response 
              //window.location = "{{ route('success_deposit', $order->id) }}";
              $('#makePaymentDisabled').hide();
              $('#modal-loader3').hide(); 
              $('#makePayment').show();


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
                timer: 3000,
                showConfirmButton: false,
                html:true, 
                title:' Hi {{ username(Auth::user())->name }},', 
                text:'<b>Your message has been sent</b><br><br><br>(closes after 1 seconds)'
              });

            })
            .fail(function(){
              $('#dynamic-content3').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
              $('#modal-loader3').hide();
              $('#makePaymentDisabled').hide();
              $('#makePayment').show();
            });
            
          });



});

</script>

@if($order->status == 4 or $order->status == 5)
<script>
  $(document).ready(function(){
    $("button").click(function(){
      $("#box").load("{{ route('chat_lists', ['order_id' =>$order->id]) }}");
    });
  });
</script>



<script type="text/javascript">
  function loadlink(){

    // $('#reload').load("{{ route('chat_lists', ['order_id' =>$order->id]) }}");
    $("#box").load("{{ route('chat_lists', ['order_id' =>$order->id]) }}");
//         $('button').click(function() {
//   const audio = new Audio("{{ asset('assets/sound/mix1.wav')}}");
//   audio.play();
// });

}

loadlink();
setInterval(function(){
  loadlink()
}, 60000);
</script> 
@endif

@endsection


