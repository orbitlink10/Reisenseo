     @extends('layouts.appbar')

     @section('content')      <!--app-content open-->
     <div class="main-content app-content mt-0">
      <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">
          <!-- ROW-4 -->
          <div class="row" style="padding-top: 20px;">
            <div class="col-8 col-sm-8">
              <div class="card">
                <div class="card-header">
                 <?php
                 $bid_count = \App\Models\Bid::whereOrderId($order->id)->count();
                 ?>
                 <h3 class="card-title mb-0"> 
                  <span class="badge bg-secondary fs-14 me-2">Bids ({{ $bid_count }})</span>
                  Order ID: <a href="{{ route('view_order', $order->slug )}}">{{ $order->id}} ({{ $order-> title }})</a> </h3>
                  <div class="page-options ms-auto">
                    <a href="{{ route('view_order', $order->slug )}}" class="btn btn-info badge btn-sm"><i class="fa fa-check"></i> Back to Order
                    </a>
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




                          @if($order->top_ten > 0)
                          <span class="badge bg-primary-transparent rounded-pill text-primary p-2 px-3">Hire only among top 10 writers</span> <br>
                          @endif

                          @if($order->preferred_writer_only > 0)
                          <span class="badge bg-primary-transparent rounded-pill text-primary p-2 px-3">Work with preferred writer only</span> <br>
                          @endif

                          <?php
                          $bid = \App\Models\User::find($order->preferred_writer);
                          $bid_count = \App\Models\User::whereId($order->preferred_writer)->count();
                          ?>

                          @if(Auth::user()->is_admin())

                          @if($bid_count>0)

                          <tr>Preferred Writer</tr>
                          <hr style="border-top: 1px solid #000000;">


                          <div class="row">



                           <div class="col-sm-2">
                            <p><a href="{{ route('user_info', $bid->id )}}">#{{ $bid->id}} {{ username($bid->id)->nickname ?? 'none' }}(@if(Auth::user()->is_admin())

                              {{ username($bid->id)->name ?? 'none' }}

                              @endif

                            )</a>  </p>

                          </div>

                          <?php 
                          $ratings = \App\Models\Review_rating::whereWriterId($bid->id)->count();
                          $eratings = \App\Models\Order::whereWriterId($bid->id)->where('eorder_rating', '!=', '')->count();
                          ?> 

                          <div class="col-sm-3">
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
                                   $ratings_count = \App\Models\Review_rating::whereWriterId($bid->id)->count();
                                   $ratings = \App\Models\Review_rating::whereWriterId($bid->id)->orderBy('id', 'desc')->get();

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


                            

                            <a href="javascript:void(0)" class="me-4 d-inline-block" data-bs-target="#editor-reviews{{ $bid->id }}" data-bs-toggle="modal"> ({{ $eratings }}) Editor Reviews</a> 

                            <!-- editor-reviews-->
                            <div class="modal fade" id="editor-reviews{{ $bid->id }}">
                             <div class="modal-dialog modal-dialog-centered" role="document">
                               <div class="modal-content country-select-modal">
                                 <div class="modal-header">
                                   <h6 class="modal-title">Editor Reviews</h6><button aria-label="Close" class="btn-close"
                                   data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                                 </div>

                                 <div class="modal-body">

                                   <?php 
                                   $ratings_count = \App\Models\Order::whereWriterId($bid->id)->where('eorder_rating', '!=', '')->count();
                                   $ratings = \App\Models\Order::whereWriterId($bid->id)->where('eorder_rating', '!=', '')->orderBy('id', 'desc')->get();
                                   ?> 

                                   @if($ratings->count()>0)
                                   <h3 class="card-title mb-0">Recent reviews 
                                    <span class="badge bg-secondary fs-14 me-2">{{ $ratings_count }} review </span>
                                  </h3>


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


                          <div class="col-sm-3">


                            <?php 
                            $user = \App\Models\User::whereId($bid->id)->first();
                            ?>        

                            In progress <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">{{ writer_counter($user->id, 2)}}</span><br>
                            Revision <span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">{{ writer_counter($user->id, 6)}}</span><br>
                            Completed <span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">{{ writer_counter($user->id, 4)}}</span><br>
                            Approved <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">{{ writer_counter($user->id, 5)}}</span><br>
                            Cancelled <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">{{ writer_counter($user->id, 7)}}</span><br>




                          </div>

                          <div class="col-sm-1">

                            @if(!Auth::user()->is_writer())
                            @if($order->status==1 or $order->status==0)

                            <a class="btn btn-sm btn-warning badge" data-bs-target="#confirm-order{{ $bid->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> Assign</a> 

                            @endif 
                            @endif






                            <!-- edit modal-->
                            <div class="modal fade" id="confirm-order{{ $bid->id }}">
                             <div class="modal-dialog modal-dialog-centered" role="document">
                               <div class="modal-content country-select-modal">
                                 <div class="modal-header">
                                   <h6 class="modal-title">Confirm to assign {{ username($bid->id)->name }} bid #{{ $bid->id }}</h6><button aria-label="Close" class="btn-close"
                                   data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                                 </div>
                                 <div class="modal-body">
                                  <form class="form-horizontal" method="POST" action="{{ route('change_status_assign') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="order_id" value="{{ $order->id }}">


                                    <div class=" row mb-4">
                                      <div class="col-md-4">Writer id</div>
                                      <div class="col-md-8">
                                        <input type="hidden" name="writer_id" class="form-control" value="{{ $bid->id }}" >
                                      </div>
                                    </div>

<!-- @if(order->order_level == "technical")
    @if($bid->writer_budget)<p>{{ get_currency() }} {{ $bid->writer_budget }}</p>@endif
@endif -->

                                    @if(Auth::user()->is_admin())
                                    @if($bid->writer_budget)<p>{{ get_currency() }} {{ $bid->writer_budget }}</p>@endif
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
                                       <button type="submit" class="btn btn-primary btn-sm">
                                        Assign
                                      </button>
                                      @else
                                      <button type="submit" class="btn btn-success btn-sm">
                                       Assign
                                     </button>
                                     @endif

                                   </div>
                                 </div>
                               </form>
                             </div>
                           </div>
                         </div>
                       </div>
                     </div>




                     <hr style="border-top: 1px solid #000000;">


                   </div>
                   @endif

                     @endif








                   @if($bids->count()>0)


                   <div class="row">

                    @foreach($bids as $bid)

                    <?php
                    $user = \App\Models\User::find($bid->user_id);
                    $user_count = \App\Models\User::whereId($bid->user_id)->count();
                    ?>



                    <div class="col-6 col-sm-6">
                      <div class="card" >
                        <div class="card-body">
                          <div class="row">

                            <div class="col-sm-4">


                              <img alt="avatar" src="{{ $user->get_gravatar(150) ?? 'none' }}" alt="{{ username($user->id)->nickname ?? 'none' }}"> 



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
                                
        @if($order->order_level == "technical")
    @if($bid->writer_budget)<p>{{ get_currency() }} {{ $bid->writer_budget }}</p>@endif
@endif

                                @if(Auth::user()->is_admin())
                                <p>{{ get_currency() }} {{ $bid->writer_budget }}</p>
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
                                   Hire
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
               </div>


               @endforeach



             </div>




             @else
             <tr>No bids available</tr>
             @endif
           </div>

         </div>
       </div>
     </div>
   </div>
 </div>
</div>

<div class="col-4 col-sm-4">
 @if(Auth::user()->is_admin() or Auth::user()->is_subadmin())

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
        Assign
      </button>
      @endif
    </div>
  </div>
</form>







</div>
</div>


@endif



@if(Auth::user()->is_admin() or Auth::user()->is_editor() or Auth::user()->is_subadmin())

<div class="card" style="padding-top: 20px;">
  <div class="card-header">
    <h4 class="card-title">
     Assign order to writer:
     @if($order->writer_id == '0')
     <span style="color: red;">not yet</span>
     @else
     <span style="color: green;">Assigned</span>
     @endif

   </h4>
 </div>
 <div class="card-body">




  <form class="form-horizontal" method="POST" action="{{ route('change_status_assign') }}" enctype="multipart/form-data">
    @csrf
    <input type="hidden" name="order_id" value="{{ $order->id }}">



    <div class=" row mb-4">
      <div class="col-md-4">Assign</div>
      <div class="col-md-8">
        <select class="form-control" name="writer_id">


          <?php
          if(Auth::user()->is_editor()){
            $writers = \App\Models\User::whereUserType('writer')->whereEditorId($order->editor_id)->orderBy('name', 'asc')->get();
          }
          else{
            $writers = \App\Models\User::whereUserType('writer')->orderBy('name', 'asc')->get();
          }
          

          $writer = \App\Models\User::whereId($order->writer_id)->first();
          ?>

          @if($order->writer_id)
          <option value="{{$order->writer_id }}" selected>
           {{$writer->name }}

         </option>
         @endif
         <option value="0">Re Assign</option>
         @foreach($writers as $writer)
         <option value="{{ $writer->id }}">{{ $writer->name }} ({{ $writer->id }})</option>
         @endforeach

       </select>
     </div>
   </div>

   <div class="row mb-0">
    <div class="col-md-6 offset-md-4">
     @if($order->writer_id == '0')
     <button type="submit" class="btn btn-primary btn-sm">
      Assign
    </button>
    @else
    <button type="submit" class="btn btn-success btn-sm">
     Assign
   </button>
   @endif

 </div>
</div>
</form>







</div>
</div>

<div class="card" style="padding-top: 20px;">
  <div class="card-header">
    <h4 class="card-title">
      Send SMS to writer:
    </h4>
  </div>
  <div class="card-body">




    <form class="form-horizontal" method="POST" action="{{ route('sms_writer') }}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="order_id" value="{{ $order->id }}">



      <div class=" row mb-4">
        <div class="col-md-3">Writer</div>
        <div class="col-md-9">
          <select class="form-control" name="writer_id">


            <?php
            if(Auth::user()->is_editor()){
              $writers = \App\Models\User::whereUserType('writer')->orderBy('name', 'asc')->get();
            }
            else{
              $writers = \App\Models\User::whereUserType('writer')->orderBy('name', 'asc')->get();
            }


            $writer = \App\Models\User::whereId($order->writer_id)->first();
            ?>

            @if($order->writer_id)
            <option value="{{$order->writer_id }}" selected>
             {{$writer->name }}  {{$writer->phone }}

           </option>
           @endif

           @foreach($writers as $writer)
           <option value="{{ $writer->id }}">{{ $writer->name }} {{$writer->phone }} ({{ $writer->id }} )</option>
           @endforeach

         </select>
       </div>
     </div>

     <div class=" row mb-4">
      <label class="col-md-4 form-label">Message:</label>
      <div class="col-md-8">


       <textarea class="form-control" name="message" required="">Hi, </textarea>
     </div>
   </div>

   <div class="row mb-0">
    <div class="col-md-6 offset-md-4">
     @if($order->writer_id == '0')
     <button type="submit" class="btn btn-primary btn-sm">
      Assign
    </button>
    @else
    <button type="submit" class="btn btn-success btn-sm">
     Assign
   </button>
   @endif

 </div>
</div>
</form>







</div>
</div>
@if(Auth::user()->is_admin())
<div class="card" style="padding-top: 20px;">
  <div class="card-header">
    <h4 class="card-title">
      Send SMS to client:
    </h4>
  </div>
  <div class="card-body">
    <form class="form-horizontal" method="POST" action="{{ route('sms_writer') }}" enctype="multipart/form-data">
      @csrf
      <input type="hidden" name="order_id" value="{{ $order->id }}">



      <div class=" row mb-4">
        <div class="col-md-3">Client</div>
        <div class="col-md-9">
          <select class="form-control" name="writer_id">


            <?php
            if(Auth::user()->is_editor()){
              $writers = \App\Models\User::whereUserType('client')->whereEditorId($order->editor_id)->orderBy('name', 'asc')->get();
            }
            else{
              $writers = \App\Models\User::whereUserType('client')->orderBy('name', 'asc')->get();
            }


            $writer = \App\Models\User::whereId($order->user_id)->first();
            ?>

            @if($order->writer_id)
            <option value="{{$order->writer_id }}" selected>
             {{$writer->name }}  {{$writer->phone }}

           </option>
           @endif

           @foreach($writers as $writer)
           <option value="{{ $writer->id }}">{{ $writer->name }} {{$writer->phone }} ({{ $writer->id }} )</option>
           @endforeach

         </select>
       </div>
     </div>

     <div class=" row mb-4">
      <label class="col-md-4 form-label">Message:</label>
      <div class="col-md-8">


       <textarea class="form-control" name="message" required="">Hi, </textarea>
     </div>
   </div>

   <div class="row mb-0">
    <div class="col-md-6 offset-md-4">
     @if($order->writer_id == '0')
     <button type="submit" class="btn btn-primary btn-sm">
      Assign
    </button>
    @else
    <button type="submit" class="btn btn-success btn-sm">
     Assign
   </button>
   @endif

 </div>
</div>
</form>







</div>
</div>




@endif

@endif
</div>



<!-- ROW-4 END -->
</div>
<!-- CONTAINER END -->
</div>
</div>
<!--app-content close-->
@endsection