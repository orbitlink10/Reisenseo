@extends('layouts.appbar')

@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
 <div class="side-app">

   <!-- CONTAINER -->
   <div class="main-container container-fluid">

                        <div class="row ">
        <div class="col-xl-8">
<h3 class="card-title">All reviews are placed in real-time. No moderation applied. </h3>

        
                    @if($reviews->count()>0)



                    

                        @foreach($reviews as $rate)

                            <div class="card">

                <div class="card-body">
<?php 
$order = \App\Models\Order::find($rate->order_id); 
?> 
@if($order->count() > 0)
<div class="row">
<div class="col-sm-8">
<h4>{{ $order->title }}</h4>
                            <a href="{{ route('view_order', $order->id )}}">
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
                




            </div>
                        </div>


</div>
</div>
</div>





@endsection