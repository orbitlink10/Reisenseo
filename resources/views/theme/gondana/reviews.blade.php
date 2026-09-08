@extends('layouts.frontbar')
@section('title')@if( ! empty($title)){{$title}} |@endif @parent @endsection
@section('description') @if( ! empty(get_option(site_id().'_show_14_meta'))){{ substr(trim(preg_replace('/\s\s+/', ' ',strip_tags(get_option(site_id().'_show_14_meta')))),0,160) }}@endif @endsection
@section('content') 

<div class="demo-screen-headline main-demo main-demo-1 spacing-top overflow-hidden reveal bg-landing pb-0 bg-image-style" id="home">

    <div class="container px-sm-0">
        <div class="row">
            <div class="col-xl-7 col-lg-7 mb-5 pb-5 animation-zidex pos-relative">
        
                <h1 class="text-start fw-bold">Instant real reviews about {{ domain_name() }} {{ get_option(site_id().'_expert_name') }}s</h1>
                <h6 class="pb-3">
                 {{ domain_name() }} values every opinion and works to improve it each day.
               </h6>

               <a href="{{ route('register')}}"
               class="btn ripple btn-min w-lg mb-3 me-2 btn-primary"><i
               class="fe fe-check me-2"></i> 100% verified reviews 
           </a>
           <a href="{{ route('login')}}"
           class="btn ripple btn-min w-lg btn-outline-primary mb-3 me-2" target="_blank"><i
           class="fa fa-check me-2"></i>No moderation
       </a>

        <a href="{{ route('register')}}"
               class="btn ripple btn-min w-lg mb-3 me-2 btn-primary"><i
               class="fe fe-check me-2"></i> Real customers. Real orders. 
           </a>
   </div>
   <div class="col-xl-5 col-lg-5 my-auto">
    <img src="assets/images/landing/market4.png" alt="">
</div>
</div>
</div>
</div>


<!-- ROW-1 OPEN -->
<div class="section pb-0" style="background-color: #F0F0F5;">
	<div class="container">

		<!-- ROW-1 OPEN -->
		<div class="row">
			
		

		<div class="col-xl-12">


		
					@if($reviews->count()>0)



					

						@foreach($reviews as $rate)
<?php 
		$ratings_count = \App\Models\Review_rating::whereWriterId($rate->id)->count();

		$ratings = \App\Models\Review_rating::whereWriterId($rate->id)->orderBy('id', 'desc')->paginate(20);;
		?> 

							<div class="card">

				<div class="card-body">
<?php 
$order = \App\Models\Order::find($rate->order_id); 
$order_count = \App\Models\Order::whereId($rate->order_id)->count(); 
?> 
@if($order_count > 0)
<div class="row">
<div class="col-sm-1">
   <?php  
$writer = \App\Models\User::find($rate->writer_id);
$writer_count = \App\Models\User::whereId($rate->writer_id)->count();

            ?>  

                    <?php
        $count_star_rating = \App\Models\Review_rating::whereWriterId($rate->writer_id)->count();
        $sum_star_rating = \App\Models\Review_rating::whereWriterId($rate->writer_id)->sum('star_rating');
        if ($count_star_rating!=0) {
             $star_rating = $sum_star_rating/$count_star_rating*100;
        } else{
              $star_rating = 0;
        }
      
        ?>           

                <div class="avatar avatar-xxl chat-profile mb-3 brround pull-right ">

                	@if($writer_count>0)
                    <a  href="{{ route('profile', $writer->id ?? '0' )}}"> <img alt="avatar" src="{{ $writer->get_gravatar(50) }}" class="brround"> <span style="margin-top: 10px;">{{ $writer->nickname }}</span>
                    	</a>

                    	@endif
                   

                   
<br>

<span style="font-size: 11px;"> <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a> {{ number_format((float)$star_rating, 2, '.', '')  }}%</span>
                  

                </div>
 </div>

<div class="col-sm-6">
<h4>{{ $order->title }}</h4>
							<a href="">
								{{ $rate->comments }}</a><br>
								<span style="font-size: 10px; color: green;">
							

									  @if($order->word_count)
<span style="font-size: 11px;" class="fw-semibold mt-sm-2 d-block"  >
		{{ subject($order->category_id) ?? 'General' }},	 {!! $rate->created_at->diffForHumans() !!},  {{ $order->word_count }} 
                              @if($order->word_count == 1) page @else pages @endif
                        
                            @endif

                            @if($order->slide)
                             {{ $order->slide }} 
                              @if($order->slide == 1) slide @else slides @endif 
                            </span>
                            @endif | #{{ $order->id }}
								</span>

							</div>

								<div class="col-sm-4">


Average quality score <br> {{ number_format((float)$rate->star_rating*100, 2, '.', '')  }}%<br>
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
		<!-- ROW-1 CLOSED -->


		<div class="row">
 <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
     <div class="card p-3 pricing-card reveal revealrotate">
        <div class="card-body">
          {!! get_option(site_id().'_show_14_content') !!}  
      </div>
  </div>
</div>

</div>

	</div>
	<!-- ROW-1 CLOSED -->




	@endsection