@extends('layouts.frontbar')
@section('title')@if( ! empty($title)){{$title}} |@endif @parent @endsection

@section('description') @if( ! empty($user->about)){{ substr(trim(preg_replace('/\s\s+/', ' ',strip_tags($user->about) )),0,160) }}@endif  @endsection

@section('content') 
<!-- ROW-1 OPEN -->
<div class="section pb-0" style="background-color: #F0F0F5;">
	<div class="container">

    @if(get_option(site_id().'_enable_dc') == 1)        

    <?php
    $w_count = \App\Models\Order::whereWriterId($user->id)->where('plagiarism_score', '>', '0')->whereStatus(5)->count();
    $w_count_plagiarism = \App\Models\Order::whereWriterId($user->id)->whereStatus(5)->where('plagiarism_score', '>', '0')->sum('plagiarism_score');
    if ($w_count>0) {
      $p_score = $w_count_plagiarism/$w_count;
    }
    else{

     $p_score = '0';
   }






   $o_count = \App\Models\Order::whereWriterId($user->id)->count();

   $o_progress = \App\Models\Order::whereStatus(2)->distinct('writer_id')->count();

   ?>  

   <?php
   $count_star_rating = \App\Models\Review_rating::whereWriterId($user->id)->count();
   $sum_star_rating = \App\Models\Review_rating::whereWriterId($user->id)->sum('star_rating');
   if ($count_star_rating!=0) {
     $star_rating = $sum_star_rating/$count_star_rating*100;
   } else{
    $star_rating = 0;
  }

  ?>

  <div class="row">


    <h1> Writer's profile </h1>
    <!-- COL END -->
    <div class="col-sm-6 col-lg-6 col-md-12 col-xl-4">
      <div class="card">
        <div class="row">
          <div class="col-4">
            <div class="card-img-absolute circle-icon bg-primary text-center align-self-center box-primary-shadow bradius">
              <img src="{{ asset('assets/images/svgs/circle.svg')}}" alt="img" class="card-img-absolute">
              <i class="fa fa-star fs-30  text-white mt-4"></i>
            </div>
          </div>
          <div class="col-8">
            <div class="card-body p-4">
              <h2 class="mb-2 fw-normal mt-2">{{ (int) $p_score }}%</h2>
              <h5 class="fw-normal mb-0">Plagiarism average score</h5>
            </div>
          </div>
        </div>
      </div>
    </div>

 


    <!-- COL END -->
    <div class="col-sm-6 col-lg-6 col-md-12 col-xl-4">
      <div class="card">
        <div class="row">
          <div class="col-4">
            <div class="card-img-absolute  circle-icon bg-success align-items-center text-center box-success-shadow bradius">
              <img src="{{ asset('assets/images/svgs/circle.svg')}}" alt="img" class="card-img-absolute">
              <i class="fa fa-star fs-30 text-white mt-4"></i>
            </div>
          </div>
          <div class="col-8">
            <div class="card-body p-4">
              <h2 class="mb-2 fw-normal mt-2">{{ number_format((float)$star_rating, 2, '.', '')  }}%</h2>
              <h5 class="fw-normal mb-0">Average quality score</h5>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- COL END -->

    <div class="col-sm-6 col-lg-6 col-md-12 col-xl-4">
      <div class="card">
        <div class="row">
          <div class="col-4">
            <div class="card-img-absolute circle-icon bg-danger align-items-center text-center box-danger-shadow bradius">
              <img src="{{ asset('assets/images/svgs/circle.svg')}}" alt="img" class="card-img-absolute">
              <i class=" lnr lnr-cart fs-30 text-white mt-4"></i>
            </div>
          </div>
          <div class="col-8">
            <div class="card-body p-4">
              <h2 class="mb-2 fw-normal mt-2">{{ $o_count }}</h2>
              <h5 class="fw-normal mb-0">Total Orders</h5>
            </div>
          </div>
        </div>
      </div>
    </div>

 
    <!-- COL END -->
  </div>
  <!-- ROW CLOSED -->

  <!-- ROW-1 OPEN -->
  <div class="row">
   <div class="col-xl-3">
    <div class="card">

     <div class="card-body">
      <div class="text-center chat-image mb-5">
       <div class="avatar avatar-xxl chat-profile mb-3 brround">
        <a class="" href=""><img alt="avatar" src="{{ $user->get_gravatar(150) }}" class="brround"></a>
      </div>
      <div class="text-center main-chat-msg-name">

       <h5 class="mb-1 text-dark fw-semibold">{{ $user->nickname }} (Id: {{ $user->id }})</h5>





       <a href="javascript:void(0)" class="fw-semibold">Average quality score {{ number_format((float)$star_rating, 2, '.', '')  }}%</a><br>


       <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
       <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
       <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
       <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
       <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a><br>
       Member since: {{ $user->created_at->diffForHumans()}}
     </div>
     <span class="badge bg-secondary fs-14 me-2">{{ accountStatus($user->account_status) }}</span>
     <div><br></div>



     <form action="{{ route('request_writer')}}" method="POST"> 
       @csrf
       <input type="hidden" name="writer_id" value="{{ $user->id }}">

       <button
       class="text-center btn ripple btn-min w-sm btn-outline-primary">
       <span class="ms-4 me-4">Invite to order</span>
     </button>
   </form>
 </div>




</div>



</div>





<div class="card panel-theme">
  <div class="card-header">
   <div class="float-start">
    <h3 class="card-title">About</h3>
  </div>
  <div class="clearfix"></div>
</div>
<div class="card-body no-padding">
 {{ $user->about }}
</div>
</div>

@if(domain_name()=='saseni.com')
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
 <!--     @foreach($warnings as $warning)                                                 
     <a href="javascript:void(0)" style="color: red;">{{ $warning->message}}</a> <br>
     saved {!! $warning->created_at->diffForHumans() !!}

     <hr style="border-top: 1px solid #000000;">
     @endforeach -->

    Warnings ({{ $warnings->count() }})
   </div>

   @else
   Writer has no warning
   @endif
 </div>
</div>

@endif
</div>
<?php 
$ratings_count = \App\Models\Review_rating::whereWriterId($user->id)->count();

//$ratings = \App\Models\Review_rating::whereWriterId($user->id)->orderBy('id', 'desc')->paginate(10, ['*'], 'client');

$ratings = \App\Models\Review_rating::whereWriterId($user->id)->orderBy('id', 'desc')->get();

?> 

<div class="col-xl-6">

  <div>
    <h2>Reviews submitted by {{ domain_name() }} clients</h2>

    <h3 class="card-title">All clients reviews are placed in real-time. No moderation applied. </h3>


    @if($ratings->count()>0)





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
            <a href="">
              {{ $rate->comments }}</a><br>
              <span style="font-size: 10px; color: green;">


               @if($order->word_count)
               <span style="font-size: 11px;" class="fw-semibold mt-sm-2 d-block"  >
                {{ subject($order->category_id) ?? 'General' }},   {!! $rate->created_at->diffForHumans() !!},  {{ $order->word_count }} 
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
            <span style="font-size: 10px; color: green;">
              @if($rate->gstar_rating)
              Grammar score {{ number_format((float)$rate->gstar_rating/5*100, 2, '.', '')  }}%<br>
              @endif
              @if($rate->fstar_rating)
              Following Instructions {{ number_format((float)$rate->fstar_rating/5*100, 2, '.', '')  }}%<br>
              @endif
              @if($rate->kstar_rating)
              Keeping Deadline {{ number_format((float)$rate->kstar_rating/5*100, 2, '.', '')  }}%<br>
              @endif
              <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
              <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
              <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
              <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
              <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
            </span>
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

  <?php 
  $ratings_count = \App\Models\Order::whereWriterId($user->id)->where('eorder_rating', '!=', '')->count();

 // $ratings = \App\Models\Order::whereWriterId($user->id)->where('eorder_rating', '!=', '')->orderBy('id', 'desc')->paginate(10, ['*'], 'editor');

    $ratings = \App\Models\Order::whereWriterId($user->id)->where('eorder_rating', '!=', '')->orderBy('id', 'desc')->get();
  ?> 


@if(domain_name()=='saseni.com')
  <div id="editors-review">

    <div><br><br><hr></div>
    <h2>Reviews submitted by {{ domain_name() }} editors</h2>

    <h3 class="card-title">All editors reviews are placed in real-time. No moderation applied. </h3>


    @if($ratings->count()>0)





    @foreach($ratings as $rate)

    <div class="card">

      <div class="card-body">
        <?php 
        $order = \App\Models\Order::find($rate->id); 
        ?> 
        @if($order->count() > 0)
        <div class="row">
          <div class="col-sm-8">
            <h4>{{ $order->title }}</h4>
            <a href="">
              {{ $rate->eorder_ratecomment }}</a><br>
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
           <span style="font-size: 10px; color: green;">
             Average quality score  {!! $rate->eorder_rating !!}/5<br>
             <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
             <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
             <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
             <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
             <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
           </span>
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

 @endif
</div>




<div class="col-xl-3">

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

    <li class="list-group-item justify-content-between">
     <a href="javascript:void(0)"><i class="fe fe-chevron-right"></i> Cancelled</a>
     <span class="badgetext badge bg-danger rounded-pill">{{ writer_counter($user->id, 7)}} orders<br></span> 
   </li> 



 </ul>
</div>
</div>


@if(domain_name()=='saseni.com')
<?php 
$worders = \App\Models\Order::whereWriterId($user->id)->select('category_id')->distinct()->get(); 
?> 

<div class="card panel-theme">
  <div class="card-header">
    <div class="float-start">
      <h3 class="card-title">Disciplines</h3>
    </div>
    <div class="clearfix"></div>
  </div>
  <div class="card-body no-padding">
    <ul class="list-group">

      @foreach($worders as $order)

      <?php 

      $worder_count = \App\Models\Order::whereWriterId($user->id)->whereCategoryId($order->category_id)->count(); 
      ?> 

      <li class="list-group-item border-0 p-0"><a href="javascript:void(0)"><i class="fe fe-chevron-right"></i> {{ subject($order->category_id) }}</a>

       <span class="product-label">{{ $worder_count }} orders<br></span> 

     </li>

     @endforeach

   </ul>
 </div>
</div>


<?php 
$worders = \App\Models\Order::whereWriterId($user->id)->select('aclevel')->distinct()->get(); 
?> 

<div class="card panel-theme">
  <div class="card-header">
    <div class="float-start">
      <h3 class="card-title">Academic Level</h3>
    </div>
    <div class="clearfix"></div>
  </div>
  <div class="card-body no-padding">
    <ul class="list-group">

      @foreach($worders as $order)

      <?php 
      $worder_count = \App\Models\Order::whereWriterId($user->id)->whereAclevel($order->aclevel)->count(); 
      ?> 

      <li class="list-group-item border-0 p-0"><a href="javascript:void(0)"><i class="fe fe-chevron-right"></i> {{ aclevel($order->aclevel) }} </a>
        <span class="product-label">{{ $worder_count }} orders<br></span> 
      </li>

      @endforeach

    </ul>
  </div>
</div>

<?php 
$worders = \App\Models\Order::whereWriterId($user->id)->select('urgency')->distinct()->get(); 
?> 



<div class="card panel-theme">
  <div class="card-header">
    <div class="float-start">
      <h3 class="card-title">Urgency</h3>
    </div>
    <div class="clearfix"></div>
  </div>
  <div class="card-body no-padding">
    <ul class="list-group">

      @foreach($worders as $order)

      <?php 
      $worder_count = \App\Models\Order::whereWriterId($user->id)->whereUrgency($order->urgency)->count(); 
      ?> 

      <li class="list-group-item border-0 p-0"><a href="javascript:void(0)"><i class="fe fe-chevron-right"></i> {{ $order->urgency }} </a>
        <span class="product-label">{{ $worder_count }} orders<br></span> 
      </li>

      @endforeach

    </ul>
  </div>
</div>

@endif

</div>

</div>
<!-- ROW-1 CLOSED -->


@endif

@if(get_option(site_id().'_enable_dc') == 0)
<?php
$p_score = 0;
$star_rating = 95;
$o_count = 125;


?>

<div class="row">
 <!-- COL END -->
 <div class="col-sm-6 col-lg-6 col-md-12 col-xl-4">
  <div class="card">
    <div class="row">
      <div class="col-4">
        <div class="card-img-absolute circle-icon bg-primary text-center align-self-center box-primary-shadow bradius">
          <img src="{{ asset('assets/images/svgs/circle.svg')}}" alt="img" class="card-img-absolute">
          <i class="fa fa-star fs-30  text-white mt-4"></i>
        </div>
      </div>
      <div class="col-8">
        <div class="card-body p-4">
          <h2 class="mb-2 fw-normal mt-2">{{ (int) $p_score }}%</h2>
          <h5 class="fw-normal mb-0">Plagiarism average score</h5>
        </div>
      </div>
    </div>
  </div>
</div>


<!-- COL END -->
<div class="col-sm-6 col-lg-6 col-md-12 col-xl-4">
  <div class="card">
    <div class="row">
      <div class="col-4">
        <div class="card-img-absolute  circle-icon bg-success align-items-center text-center box-success-shadow bradius">
          <img src="{{ asset('assets/images/svgs/circle.svg')}}" alt="img" class="card-img-absolute">
          <i class="fa fa-star fs-30 text-white mt-4"></i>
        </div>
      </div>
      <div class="col-8">
        <div class="card-body p-4">
          <h2 class="mb-2 fw-normal mt-2">{{ number_format((float)$star_rating, 2, '.', '')  }}%</h2>
          <h5 class="fw-normal mb-0">Average quality score</h5>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- COL END -->
<div class="col-sm-6 col-lg-6 col-md-12 col-xl-4">
  <div class="card">
    <div class="row">
      <div class="col-4">
        <div class="card-img-absolute circle-icon bg-danger align-items-center text-center box-danger-shadow bradius">
          <img src="{{ asset('assets/images/svgs/circle.svg')}}" alt="img" class="card-img-absolute">
          <i class=" lnr lnr-cart fs-30 text-white mt-4"></i>
        </div>
      </div>
      <div class="col-8">
        <div class="card-body p-4">
          <h2 class="mb-2 fw-normal mt-2">{{ $o_count }}</h2>
          <h5 class="fw-normal mb-0">Total Orders</h5>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- COL END -->
</div>
<!-- ROW CLOSED -->
<?php 
$url = 'https://saseni.com/api/v1/user?user_id='.$id; 
$json = get_user_data($url);
$user = json_decode($json, true);

//echo $user['name'];
?>


<!-- ROW-1 OPEN -->
<div class="row">
  <div class="col-xl-4">
    <div class="card">

      <div class="card-body">
        <div class="text-center chat-image mb-5">

          <div class="avatar avatar-xxl chat-profile mb-3 brround">
            <a class="" href=""><img alt="avatar" src="https://saseni.com/storage/uploads/avatar/{{ $user['photo']}}" class="brround"></a>
          </div>


          <div class="text-center main-chat-msg-name">
           <h5 class="mb-1 text-dark fw-semibold">{{ $user['nickname'] }} (Id: {{ $user['id'] }})</h5>
           <a href="javascript:void(0)" class="fw-semibold">Average quality score {{ number_format((float)$star_rating, 2, '.', '')  }}%</a><br>


           <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
           <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
           <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
           <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
           <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a><br>
           Member since: {{ $user['created_at'] }}
         </div>


         <span class="badge bg-secondary fs-14 me-2">{{ accountStatus($user['account_status']) }}</span>
         <div><br></div>



         <form action="{{ route('request_writer')}}" method="POST"> 
          @csrf
          <input type="hidden" name="writer_id" value="{{ $user['id'] }}">

          <button
          class="text-center btn ripple btn-min w-sm btn-outline-primary">
          <span class="ms-4 me-4">Request Writer</span>
        </button>
      </form>
    </div>




  </div>



</div>
<div class="card panel-theme">
  <div class="card-header">
    <div class="float-start">
      <h3 class="card-title">About</h3>
    </div>
    <div class="clearfix"></div>
  </div>
  <div class="card-body no-padding">
    {{ $user['about'] }}
  </div>
</div>


</div>
<?php 
       // $ratings_count = \App\Models\Review_rating::whereWriterId($user->id)->count();

       // $ratings = \App\Models\Review_rating::whereWriterId($user->id)->orderBy('id', 'desc')->paginate(20);;
?> 

<div class="col-xl-8">


</div>
</div>
<!-- ROW-1 CLOSED -->





@endif 




</div>
<!-- ROW-1 CLOSED -->




@endsection