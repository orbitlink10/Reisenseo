     @extends('layouts.appbar')
<script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js"></script>
     @section('content')      <!--app-content open-->
     <div class="main-content app-content mt-0">
      <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">



         <!-- ROW OPEN -->
         <div class="row row-cards" style="padding-top: 20px;">
          @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())
          <div class="col-lg-8 col-xl-8">
            <div class="card">
              <div class="card-header">
                <h4 class="card-title">User Info</h4>
                <div class="page-options ms-auto">
                  <a href="{{ route('login_as', $user->id )}}" class="btn btn-sm btn-success badge"><i class="fa fa-sign-in"></i> Login
                  </a> 
                  <!-- <a class="btn btn-sm btn-warning badge" data-bs-target="#confirm-order{{ $user->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Topup Wallet </a>  -->

                  <a class="btn btn-sm btn-info badge" data-bs-target="#password-change{{ $user->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Update Password </a>

                  @if($user->user_type == 'writer')
                  <a target="_blank" href="{{ route('profile', $user->slug )}}" class="btn btn-sm btn-success badge"><i class="fa fa-check"></i> View Profile</a> 
                  @endif


                  @if($user->user_type == 'client')
                  <a target="_blank" href="{{ route('payments', ['user_id' => $user->id ] )}}" class="btn btn-sm btn-success badge"><i class="fa fa-check"></i> View Payments</a> 
                  @endif


                                    <!-- edit modal-->
                  <div class="modal fade" id="password-change{{ $user->id }}">
                   <div class="modal-dialog modal-dialog-centered" role="document">
                     <div class="modal-content country-select-modal">
                       <div class="modal-header">
                         <h6 class="modal-title">Change password for  user #{{ $user->id }}</h6><button aria-label="Close" class="btn-close"
                         data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                       </div>
                       <div class="modal-body">
                         <form class="form-horizontal" action="{{ route('change_password2')}}" method="POST">
                           @csrf
                           <input type="hidden" name="id" value="{{ $user->id }}">
       <div class="wrap-input100 validate-input input-group" id="Password-toggle">
                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                            <i class="zmdi zmdi-eye" aria-hidden="true"></i>
                        </a>
                        <input class="input100 border-start-0 ms-0 form-control @error('password') is-invalid @enderror" name="password" type="password" value="{{ old('password') }}" placeholder="Password" required autocomplete="new-password">

                        
                    </div>

                    <div class="wrap-input100 validate-input input-group" id="Password-toggle">
                        <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                            <i class="zmdi zmdi-eye" aria-hidden="true"></i>
                        </a>
                        <input class="input100 border-start-0 ms-0 form-control" name="password_confirmation" type="password" value="{{ old('password_confirmation') }}" placeholder="Password Confirmation" required autocomplete="new-password">
                    </div>


                          <div class=" row mb-4">

                           <div class="col-md-9">
                            <input type="submit" value="Update" class="btn btn-primary">
                          </div>


                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>


                  <!-- edit modal-->
                  <div class="modal fade" id="confirm-order{{ $user->id }}">
                   <div class="modal-dialog modal-dialog-centered" role="document">
                     <div class="modal-content country-select-modal">
                       <div class="modal-header">
                         <h6 class="modal-title">Top up wallet for  user #{{ $user->id }}</h6><button aria-label="Close" class="btn-close"
                         data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                       </div>


                       <div class="modal-body">
                         <form class="form-horizontal" action="{{ route('top_wallet')}}" method="POST">
                           @csrf
                           <input type="hidden" name="id" value="{{ $user->id }}">

                           <div class=" row mb-4">
                            <label class="col-md-4 form-label">Amount</label>
                            <div class="col-md-8">
                              <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid phone is required: 0725000000">
                                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                  {{Auth::user()->currency_sign}}
                                </a>
                                <input  class="input100 border-start-0 ms-0 form-control" name="amount"  type="text">
                              </div>





                            </div>
                          </div>


                        <div class=" row mb-4">
                            <label class="col-md-4 form-label">Top Reason</label>
                            <div class="col-md-8">
                               <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid phone is required: 0725000000">
                          <select name="comments"  class="input100 border-start-0 ms-0 form-control">
                                <option>Failed Payment</option>
                                <option>Other</option>
                          </select>
                       
                              </div>


                            </div>
                          </div>


                           <div class=" row mb-4">
                            <label class="col-md-4 form-label">Pin</label>
                            <div class="col-md-8">
                              <div class="wrap-input100 validate-input input-group">

                                <input  class="input100 border-start-0 ms-0 form-control" name="pin"  type="password">
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
                </div>
              </div>
            </div>
          </div>

          
          <div class="card-body">

           <?php 

           $warnings = \App\Models\Warning::whereUserId($user->id)->get();
           ?> 

           @if($user->user_type == 'writer')
           @if($user->account_status == '2')
           <p> Unsuspension ends after  
            <span><p style="color: green;" id="demo1"></p> </span>
            <?php

            $created_at = \Carbon\Carbon::parse($user->subscribe_end);
            $current_time = \Carbon\Carbon::now();

            ?>

            {{ \Carbon\Carbon::parse($current_time)->diffInHours($created_at,false) }} hours
          </p>

          @endif
          @endif
          @if($user->user_type == 'client' or $user->user_type == 'writer')

          <p> Account expires after  
            <span><p style="color: green;" id="demo1"></p> </span>
            <?php

            $created_at = \Carbon\Carbon::parse($user->subscribe_end);
            $current_time = \Carbon\Carbon::now();

            ?>

            {{ \Carbon\Carbon::parse($current_time)->diffInHours($created_at,false) }} hours
          </p>



          <div class=" row mb-4">
            <label class="col-md-4 form-label">Wallet Balance</label>
            <div class="col-md-8">
              <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid phone is required: 0725000000">
                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                  {{Auth::user()->currency_sign}} 
                </a>
                <input  class="input100 border-start-0 ms-0 form-control" name="wallet" value="{{ wallet($user->id)}}" disabled="" type="text" value="0">
              </div>

            </div>
          </div>

          @endif



          <div class=" row mb-4">
            <label class="col-md-4 form-label">Merchant ID</label>
            <div class="col-md-8">

              <input type="text" disabled class="form-control" name="id" value="{{ $user->id }}">
            </div>
          </div>


                  <div class=" row mb-4">
            <label class="col-md-4 form-label">Country</label>
            <div class="col-md-8">

              <input type="text" disabled class="form-control" name="id" value="{{ $user->country }}">
            </div>
          </div>

          <div class=" row mb-4">
            <label class="col-md-4 form-label">Name</label>
            <div class="col-md-8">

              <input type="text" disabled class="form-control" name="id" value="{{ $user->name }}">
            </div>
          </div>

          <div class=" row mb-4">
            <label class="col-md-4 form-label">Email</label>
            <div class="col-md-8">

              <input type="text" disabled class="form-control" name="id" value="{{ $user->email }}">
            </div>
          </div>

          <div class=" row mb-4">
            <label class="col-md-4 form-label">Phone</label>
            <div class="col-md-8">

              <input type="text" disabled class="form-control" name="id" value="{{ $user->phone }}">
            </div>
          </div>



          <div class=" row mb-4">
            <label class="col-md-4 form-label">Subcription </label>
            <div class="col-md-8">

              <input type="text" disabled class="form-control" name="account_status" value="{{ accountStatus($user->account_status) }}">
            </div>
          </div>

          <div class=" row mb-4">
            <label class="col-md-4 form-label">Package </label>
            <div class="col-md-8">

              <input type="text" disabled class="form-control" name="package" value="{{ package($user->package)->name ?? 'none'}}">
            </div>
          </div>



          @if($user->user_type == 'writer')
          <div class=" row mb-4">
            <label class="col-md-4 form-label">About Info </label>
            <div class="col-md-8">

              {!! $user->about !!}
            </div>
          </div>

          @endif


        </div>
      </div>

      <div class="card">
        <div class="card-header">
          <h3 class="card-title mb-0">Recent orders for {{ username($user->id)->name }} <span class="badge bg-secondary fs-14 me-2">{{ username($user->id)->user_type }} </span></h3>



          <div class="page-options ms-auto">


            <form style="display: none;" id="form" action="" method="post">
              <select  class="form-control select2 w-100" onchange ="calculate(this.form);">



              </select>

            </form>

            <form method='get'  id='myform' action="{{ route('dashboard') }}">

             <select name='q' id='lang' class="form-control"> 
               <option value="0">Filter by status</option>
               <option value="0">pending</option>
               <option value="1">available</option>
               <option value="2">in progress</option>
               <option value="3">editing</option>
               <option value="4">completed</option>
               <option value="2">aproved</option>
               <option value="3">revision</option>
               <option value="4">cancelled</option>

             </select> 
           </form>

           <!-- Script --> 
           <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
           <script type='text/javascript'> 
            $(document).ready(function(){
              $('#lang').change(function(){
                        // Call submit() method on <form id='myform'>
                        $('#myform').submit();
                      });
            });
          </script>




        </div>



      </div>
      <div class="card-body pt-4">
        <div class="grid-margin">
          <div class="">
            <div class="panel panel-primary">
              <div class="tab-menu-heading border-0 p-0">
                <div class="tabs-menu1">

                </div>
              </div>

              <div>
                @if($orders->count()>0)
                <div class="row">
                 <div class="col-sm-2">
                  <h4 class="bg-transparent border-bottom-0">Id</h4>

                </div>

                <div class="col-sm-3">
                  <h4 class="bg-transparent border-bottom-0">Title</h4>

                </div>

                <div class="col-sm-1">
                  <h4 class="bg-transparent border-bottom-0">pages</h4>

                </div>

                <div class="col-sm-2">
                  <h4 class="bg-transparent border-bottom-0">Amount</h4>

                </div>
           




                <div class="col-sm-2">
                  <h4 class="bg-transparent border-bottom-0">Status</h4>

                </div>

                <div class="col-sm-2">
                  <h4 class="bg-transparent border-bottom-0">Action</h4>

                </div>
                <div><hr style="border-top: 1px solid #000000;"></div>

              </div>


              <div class="row">

                @foreach($orders as $order)
                <div class="col-sm-2">
                  <div class="mt-0 mt-sm-2 d-block">
                    <h6
                    class="mb-0 fs-14 fw-semibold">
                    #{{ $order->id}}</h6>
                  </div>

                </div>

                <div class="col-sm-3">
                  <a href="{{ route('view_order', $order->slug )}}">
                    {{ \Illuminate\Support\Str::limit($order->title, 50, '...') }}</a><br>
                    <span style="font-size: 10px; color: green;">
                     @if(Auth::user()->is_client() or Auth::user()->is_admin())
                     {!! remainingtime($order->order_due) !!}
                     @endif

                     @if(Auth::user()->is_writer())
                     {!! remainingtime($order->order_wrdeadline) !!}
                     @endif


                     @if(Auth::user()->is_editor())
                     {!! remainingtime($order->order_eddeadline) !!}
                     @endif
                   </span>

                 </div>

                 <div class="col-sm-1">
                  <div class="mt-0 mt-sm-1 d-block">
                    <span
                    class="fw-semibold mt-sm-2 d-block">{{ $order->word_count }}</span>
                  </div>

                </div>
                @if(Auth::user()->is_admin() or Auth::user()->is_client())
                <div class="col-sm-2">
                  <span
                  class="fw-semibold mt-sm-2 d-block">{{price($order->ccost)}}</span>

                </div>
                @endif
                @if(Auth::user()->is_editor())
                <div class="col-sm-2">
                  <span
                  class="fw-semibold mt-sm-2 d-block">{{price($order->ecost)}}</span>

                </div>
                @endif

                @if(Auth::user()->is_writer())
                <div class="col-sm-2">
                  <span
                  class="fw-semibold mt-sm-2 d-block">{{price($order->wcost)}}</span>

                </div>
                @endif

    




                <div class="col-sm-2">
                  <div class="mt-sm-1 d-block">
                    @if($order->status==0)                                                                                 
                    <span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">Pending</span>
                    @elseif($order->status==1)
                    <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Available</span>
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


                    @if(Auth::user()->is_client())
                    @if($order->status==0)    
                    <a class="btn btn-sm btn-warning badge" data-bs-target="#confirm-order{{ $order->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Confirm</a> 
                    @endif
                    @endif


                    <a href="{{ route('view_order', $order->slug )}}" class="btn btn-sm btn-success badge"><i class="fa fa-eye"></i> View
                    </a>

                    @if(!Auth::user()->is_writer())
                    @if($order->status==0)
                    <a href="{{ route('edit_order', $order->id )}}" class="btn btn-sm btn-primary badge"><i class="fa fa-edit"></i> Edit</a>
                    @endif 
                    @endif



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
                               <label class="col-md-3 form-label">Amount ({{Auth::user()->currency_sign}})</label>
                               <div class="col-md-9">
                                 <input type="text"  class="form-control" name="amount" value="{{ $order->ccost }}" disabled="">
                               </div>


                             </div>


                             <div class=" row mb-4">

                               <div class="col-md-9">
                                @if(Auth::user()->wallet<$order->ccost)
                                <input type="submit" value="Top Up Amount {{Auth::user()->currency_sign}} {{ $order->ccost - Auth::user()->wallet }}" class="btn btn-success">
                                @else

                                <input type="submit" value="Submit" class="btn btn-primary">

                                @endif
                              </div>


                            </div>



                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

              </div>


              <hr style="border-top: 1px solid #000000;">


              @endforeach





            </div>




            @else
            <tr>No order available</tr>
            @endif
          </div>


                    {{$orders->links("pagination::bootstrap-4")}}

        </div>
      </div>
    </div>
  </div>
</div>



@if($user->is_writer())

<div class="card">
  <div class="card-header">
    <div class="card-title">Writers Subject</div>
  </div>
  <div class="card-body">
   <?php 

   $my_subjects = \App\Models\User_subject::whereUserId($user->id)->get();
   ?> 
   @if($my_subjects->count()>0)    
   <div class="tags">
     @foreach($my_subjects as $subject)                                                 
     <a href="javascript:void(0)" class="tag">{{ $subject->subject_name}}</a>
     @endforeach
   </div>

   @else
   No subject selected
   @endif
 </div>
</div>






<?php 
$ratings_count = \App\Models\Review_rating::whereWriterId($user->id)->count();
$ratings = \App\Models\Review_rating::whereWriterId($user->id)->get();
?> 







@if($ratings->count()>0)

<h3 class="card-title mb-0">Recent reviews <span class="badge bg-secondary fs-14 me-2">{{ $ratings_count }} review </span></h3>


@foreach($ratings as $rate)

<div class="card">

  <div class="card-body">
    <?php 
    $order = \App\Models\Order::find($rate->order_id); 
      $order_count = \App\Models\Order::whereId($rate->order_id)->count(); 
    ?> 
    @if($order_count > 0)
    <div class="row">
      <div class="col-sm-8">
        <h4>{{ $order->title }}</h4>
        <a href="{{ route('view_order', $order->slug )}}">
          {{ $rate->comments }}</a><br>
          <span style="font-size: 10px; color: green;">


            @if($order->word_count)
            <span style="font-size: 11px;" class="fw-semibold mt-sm-2 d-block"  >{!! $rate->created_at->diffForHumans() !!}  {{ $order->word_count }} 
              @if($order->word_count == 1) page @else pages @endif

              @endif

              @if($order->slide)
              {{ $order->slide }} 
              @if($order->slide == 1) slide @else slides @endif
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



  <div class="card">
    <div class="card-header">
      <div class="card-title">Writer Warning</div>
    </div>
    <div class="card-body">
     <?php 

     $warnings = \App\Models\Warning::whereUserId($user->id)->get();
     ?> 
     @if($warnings->count()>0)    
     <div>
       @foreach($warnings as $warning)                                                 
       <a href="javascript:void(0)">{!! $warning->message !!}</a> <br>
       saved {!! $warning->created_at->diffForHumans() !!}
       
       <hr style="border-top: 1px solid #000000;">
       @endforeach
     </div>

     @else
     Writer has no warning
     @endif
   </div>
 </div>


 @endif



</div>


<div class="col-lg-4 col-xl-4">

 @if($user->user_type == 'client' or $user->user_type == 'writer') 
 <div class="card">
  <div class="card-header">
    <h4 class="card-title">Manage user subscription</h4>
  </div>
  <div class="card-body">
    <form class="form-horizontal" action="{{ route('update_user_info')}}" method="POST">
      @csrf

      <input type="hidden" name="id" value="{{ $user->id }}">

      <div class=" row mb-4">
        <label class="col-md-4 form-label">Subscription Status </label>
        <div class="col-md-8">

          <select class="form-control" name="account_status">
            <option value="{{ $user->account_status }}" selected="">{{ accountStatus($user->account_status) }}</option>

            <option value="0">{{ accountStatus(0) }}</option>
            <option value="1" >{{ accountStatus(1) }}</option>
          </select>
        </div>
      </div>


    <div class=" row mb-4">
        <label class="col-md-4 form-label">Record Payment </label>
        <div class="col-md-8">

          <select class="form-control" name="package_payment">
          

            <option value="NO">NO</option>
            <option value="YES">YES</option>
          </select>
        </div>
      </div>


      <div class=" row mb-4">
        <label class="col-md-4 form-label">Package </label>
        <div class="col-md-8">

          <select class="form-control" name="package">
           <option value="{{ $user->package }}" selected="">{{ package($user->package)->name ?? 'none' }}
           </option>
           <?php
           $packages = \App\Models\Package::all();
           ?>
           @foreach($packages as $package)
           <option value="{{ $package->id }}">{{ $package->name }}</option>
           @endforeach
         </select>

       </div>
     </div>


     <link rel="stylesheet" type="text/css" href="{{ asset('assets/datepicker/jquery.css')}}">
     <script src="{{ asset('assets/datepicker/jquery_002.js')}}"></script>
     <script src="{{ asset('assets/datepicker/jquery.js')}}"></script>


     <div class=" row mb-4">
      <label class="col-md-4 form-label">Subscription Start </label>
      <div class="col-md-8">

        <input type="text" id="datetimepicker1" class="form-control" name="subscribe_start" value="{{ $user->subscribe_start }}">
      </div>
    </div>

    <div class=" row mb-4">
      <label class="col-md-4 form-label">Subscription End </label>
      <div class="col-md-8">

        <input type="text" id="datetimepicker2" class="form-control" name="subscribe_end" value="{{ $user->subscribe_end }}">
      </div>
    </div>

    <script type="text/javascript">
      $('#datetimepicker1').datetimepicker({
        format:'Y-m-d H:i',
      });
      $('#datetimepicker2').datetimepicker({
        format:'Y-m-d H:i',
      });


    </script>


    <div class=" row mb-4">

      <div class="col-md-9">
       <input type="submit" value="Save all" class="btn btn-primary">
     </div>


   </div>

 </form>



</div>
</div>

@endif


@if($user->user_type == 'writer') 

<div class="card">
  <div class="card-header">
    <h3 class="card-title">Manage Writer Info</h3>
  </div>
  <div class="card-body">
   <form action="{{ route('aedit_profile')}}" method="POST" enctype="multipart/form-data">

     @csrf

    <input type="hidden" name="user_id" value="{{ $user->id }}">


    <div class=" row mb-4">
      <label class="col-md-5 form-label">Account Status </label>
      <div class="col-md-7">

        <select class="form-control" name="account_status">
          <option value="{{ $user->account_status }}" selected="">{{ writerStatus($user->account_status) }}</option>

          <option value="0">{{ writerStatus(0) }}</option>
          <option value="1" >{{ writerStatus(1) }}</option>
          <option value="2" >{{ writerStatus(2) }}</option>
        </select>
      </div>
    </div>

    <div class=" row mb-4">
      <label class="col-md-5 form-label">Nick Name </label>
      <div class="col-md-7">

        <input type="text"  class="form-control" name="nickname" value="{{ $user->nickname }}">
      </div>
    </div>

    <div class=" row mb-4">
      <label class="col-md-5 form-label">Mpesa Number </label>
      <div class="col-md-7">

        <input type="text"  class="form-control" name="phone" value="{{ $user->phone }}">
      </div>
    </div>




    <div class="form-group">
      <label class="form-label">User Bio</label>
      <textarea class="form-control" name="about" rows="6">{{ $user->about  }}</textarea>
    </div>


    <div class=" row mb-4">
      <label class="col-md-4 form-label">Profile Photo </label>
      <div class="col-md-8">

        <input type="file" class="form-control" id="photo" name="photo" class="filestyle" >
      </div>
    </div>





    <button href="javascript:void(0)" class="btn btn-success my-1">Save</button>


  </form>


</div>

</div>


  <div class="card panel-theme">
    <div class="card-header">
     <div class="float-start">
      <h3 class="card-title">Orders Status</h3>
    </div>
    <div class="clearfix"></div>
  </div>
  <div class="card-body no-padding">
   <?php 
   $user = \App\Models\User::whereId($user->id)->first();
   ?>     
<ul class="list-group">


<li class="list-group-item justify-content-between"><a href="javascript:void(0)"><i class="fe fe-chevron-right"></i> In progress</a>
  <span class="badgetext badge bg-warning rounded-pill">{{ writer_counter($user->id, 2)}} orders<br></span>
</li>   

 <li class="list-group-item justify-content-between">
     <a href="javascript:void(0)"><i class="fe fe-chevron-right"></i> Revision</a> 
       <span class="badgetext badge bg-danger rounded-pill">{{ writer_counter($user->id, 6)}} orders<br></span>
</li>  


 <li class="list-group-item justify-content-between">
     <a href="javascript:void(0)"><i class="fe fe-chevron-right"></i> Completed</a>
     <span class="badgetext badge bg-primary rounded-pill">{{ writer_counter($user->id, 4)}} orders<br></span> 
</li>


 <li class="list-group-item justify-content-between">
     <a href="javascript:void(0)"><i class="fe fe-chevron-right"></i> Approved</a>
     <span class="badgetext badge bg-success rounded-pill">{{ writer_counter($user->id, 5)}} orders<br></span> 
</li> 



   </ul>
 </div>
</div>



<div class="card">
  <div class="card-header">
    <h4 class="card-title">Suspend/Send Warnings </h4>
  </div>
  <div class="card-body">
    <form class="form-horizontal" action="{{ route('suspend_user')}}" method="POST">
      @csrf
      <input type="hidden" name="user_id" value="{{ $user->id }}">


      <div class=" row mb-4">
        <label class="col-md-12 form-label">Number of days (0 to mean unsuspend)</label>
        <div class="col-md-12">

          <input type="number" value="0" class="form-control" name="suspension_days">
        </div>
      </div>



      



      <div class="form-group">
        <label class="form-label">Reason: </label>
  <textarea id="editor1" name="message"></textarea>

         

           <script>
            ClassicEditor
            .create( document.querySelector( '#editor1' ) )
            .catch( error => {
              console.error( error );
            } );
          </script>
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

@if($user->user_type == 'writer') 


<div class="card">
  <div class="card-header">Select subject writer offers</div>

  <div class="card-body">



   <form method="POST" action="{{ route('asave_service') }}">
    @csrf


    <input type="hidden" name="user_id" value="{{ $user->id }}">    

    <div class="row mb-3">
      <div class="col-md-6">
       @if($categories->count() > 0)
       @foreach($categories as $category)
       <?php
       $s_count = \App\Models\User_subject::whereSubjectId($category->id)->whereUserId($user->id)->count();
       ?>

       @if($s_count>0)
       @else

       <label> <input type="checkbox" value="{{ $category->id }}" name="amenities[{{$category->id}}]"> {{ $category->name }} </label><br>

       @endif


       @endforeach
       @endif

     </div>
   </div>








   <div class="row">
    <div class="col-md-8">
      <button type="submit" class="btn btn-primary">
       Add Selected
     </button>


   </div>
 </div>
</form>
</div>
</div>
@endif



</div>
@endif
</div>



</div>


</div>
<!-- ROW CLOSED -->


</div>
</div>
</div>


<script>
// Set the date we're counting down to
var countDownDate = new Date("{{ $user->subscribe_end }}").getTime();

// Update the count down every 1 second
var x = setInterval(function() {

  // Get today's date and time
  var now = new Date().getTime();

  // Find the distance between now and the count down date
  var distance = countDownDate - now;

  // Time calculations for days, hours, minutes and seconds
  var days = Math.floor(distance / (1000 * 60 * 60 * 24));
  var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
  var seconds = Math.floor((distance % (1000 * 60)) / 1000);

  // Output the result in an element with id="demo"
  document.getElementById("demo1").innerHTML = days + "d " + hours + "h "
  + minutes + "m " + seconds + "s ";

  // If the count down is over, write some text 
  if (distance < 0) {
    clearInterval(x);
    document.getElementById("demo1").innerHTML = "EXPIRED";
  }
}, 1000);
</script>


@endsection