@extends('layouts.frontbar')
@section('title')@if( ! empty($category->display_name)){{$category->display_name}} @endif @endsection
@section('description') @if( ! empty($category->meta_description)){{ $category->meta_description }}@endif @endsection
@section('content') 

<div class="demo-screen-headline main-demo main-demo-1 spacing-top overflow-hidden reveal bg-landing pb-0 bg-image-style" id="home">

    <div class="container px-sm-0">
        <div class="row">
            <div class="col-xl-7 col-lg-7 mb-5 pb-5 animation-zidex pos-relative">
              <!--[shortcode_hello]-->
              <h4 class="fw-semibold mt-7">{{ get_option(site_id().'_tagline') }}</h4>
              <h1 class="text-start fw-bold">  {!! $category->display_name !!}</h1>
              <p class="pb-3" style="font-size: 20px;">
                {!! $category->meta_description !!}

                 <div id="hello-react"></div>
             </p>

             @guest
             <a href="{{ get_option(site_id().'_hero_button_url1') }}"
             class="btn ripple btn-min w-lg mb-3 me-2 btn-primary"><i
             class="fe fe-play me-2"></i> {{ get_option(site_id().'_hero_button_text1') }}
         </a>



         <a href="{{ get_option(site_id().'_hero_button_url2') }}"
         class="btn ripple btn-min w-lg btn-outline-primary mb-3 me-2" target="_blank"><i
         class="fa fa-sign-in me-2"></i>{{ get_option(site_id().'_hero_button_text2') }}
     </a>

     @else
     <a href="{{ route('register')}}"
     class="btn ripple btn-min w-lg btn-outline-primary mb-3 me-2"
     >My Account
 </a>
 @endguest




</div>
<div class="col-xl-5 col-lg-5 my-auto">


    <img src="{{ category_photo($category->id) }}" alt="{{ $category->display_name }}">

    <br><br>
    <table class="table text-nowrap border-dashed mb-0" style="background-color: #E6EFFA; border-radius: 10px;">
        <!-- ROW-11 CLOSED -->
        <?php 
        $projects = \App\Models\Order::whereStatus(5)->count();
        $customers = \App\Models\User::whereUserType('client')->count();
        $freelancers = \App\Models\User::whereUserType('writer')->count();
        $review_count  = \App\Models\Review_rating::count();
        $review_sum  = \App\Models\Review_rating::sum('star_rating');
        $score =  $review_sum/$review_count*100;
        $client_count = \App\Models\Order::distinct('user_id')->count();
        ?>
        <tbody>

            <tr>

                <td class="p-4">
                   <div class="d-flex mb-4 mt-3">
                    <div
                    class="avatar avatar-md bg-secondary-transparent text-secondary bradius me-3">
                    <i class="fe fe-check"></i>
                </div>
                <div class="">
                    <h6 class="mb-1 fw-semibold">{{ $projects }}+</h6>
                    <p class="fw-normal fs-12"> <span class="text-success">Delivered Orders</span>
                    </p>
                </div>
                
            </div>
        </td>
        <td class="p-4">
           <div class="d-flex mb-4 mt-3">
            <div
            class="avatar avatar-md bg-secondary-transparent text-secondary bradius me-3">
            <i class="fe fe-check"></i>
        </div>
        <div class="">
            <h6 class="mb-1 fw-semibold">{{ $client_count }}+</h6>
            <p class="fw-normal fs-12"> <span class="text-success">Customers</span>
            </p>
        </div>
        
    </div>
</td>
<td class="p-4">
 
   <div class="d-flex mb-4 mt-3">
    <div
    class="avatar avatar-md bg-secondary-transparent text-secondary bradius me-3">
    <i class="fe fe-check"></i>
</div>
<div class="">
    <h6 class="mb-1 fw-semibold">{{ (int) $score }}%</h6>
    <p class="fw-normal fs-12"> <span class="text-success">Quality Score</span>
    </p>
</div>

</div>

</td>
</tr>
</tbody>
</table>

</div>
</div>
</div>
</div>





@if(get_option(site_id().'_show_homepage_expert') =='1')

<!-- ROW-4 OPEN -->
<div class="demo-screen-headline main-demo main-demo-1 spacing-top overflow-hidden reveal bg-landing pb-0 bg-image-style" id="home">

    <div class="container px-sm-0">

        <!-- ROW-1 -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
                        <a href="{{ url('order')}}">
                            <div class="card overflow-hidden">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="mt-2">
                                            <h6 class="">Academic Writer Marketplace</h6>
                                            <h2 class="mb-0 number-font">Post A Project</h2>
                                        </div>
                                        <div class="ms-auto">
                                            <div class="chart-wrapper mt-1">
                                                <canvas id="saleschart"
                                                class="h-8 w-9 chart-dropshadow"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-muted fs-12"><span class="text-secondary"><i
                                        class="fe fe-arrow-up-circle  text-secondary"></i> Hire</span>
                                    A Pro from bids</span>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
                        <div class="card overflow-hidden">
                            <a href="{{ route('hire')}}">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="mt-2">
                                            <h6 class="">Browse By Category</h6>
                                            <h2 class="mb-0 number-font">Browse & Hire</h2>
                                        </div>
                                        <div class="ms-auto">
                                            <div class="chart-wrapper mt-1">
                                                <canvas id="profitchart"
                                                class="h-8 w-9 chart-dropshadow"></canvas>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="text-muted fs-12"><span class="text-green"><i
                                        class="fe fe-arrow-up-circle text-green"></i> Check their reviews</span>
                                    </span>
                                </div>
                            </a>
                        </div>
                    </div>

                    <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
                        <div class="card overflow-hidden">
                         <a href="{{ route('latest_reviews')}}">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="mt-2">
                                        <h6 class="">Hear an honest words</h6>
                                        <h2 class="mb-0 number-font">Reviews</h2>
                                    </div>
                                    <div class="ms-auto">
                                        <div class="chart-wrapper mt-1">
                                            <canvas id="leadschart"
                                            class="h-8 w-9 chart-dropshadow"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <span class="text-muted fs-12"><span class="text-pink"><i
                                    class="fe fe-arrow-up-circle text-pink"></i>  From our customers</span>
                                </div>
                            </a>
                        </div>
                    </div>


                </div>
            </div>
        </div>
        <!-- ROW-1 END -->



        <!--app-content open-->
        <div class="main-content mt-0">
            <div class="side-app">

                <!-- CONTAINER -->
                <div class="main-container">
                    <div class="">


                        <!-- ROW-1 OPEN -->
                        <div class="section pb-0" id="how">
                            <div class="container">
                                <div class="row">

                                    <span class="landing-title"></span>
                                    <h2 class="fw-semibold text-center">Your Writing, Your Rules: Saseni's Writer's Hub</h2>

                                    <p class="text-default mb-5 text-center">With Saseni, you're in charge! Manage your writing jobs, choose your own writers, and handle payments easily. It's all about making writing work for you.</p>
                                </div>
                                <div class="row text-center services-statistics landing-statistics">




                                    <div class="col-xl-6 col-md-6 col-lg-6">
                                        <div class="card">
                                            <div class="card-body bg-secondary-transparent">
                                                <div class="counter-status">
                                                    <div
                                                    class="counter-icon bg-secondary-transparent box-shadow-secondary">
                                                    <i class="fe fe-wind text-secondary fs-23"></i>
                                                </div>
                                                <div class="text-body text-center">
                                                    <h4 class="fw-bold">Effortless Writing Order Management System</h4>
                                                    <div class="counter-text">
                                                       <p class="font-weight-normal mb-0 ">Make writing easy with Saseni! We connect you with great Saseni writers and double-check your work for quality
                                                       </p>
                                                   </div>
                                               </div>
                                           </div>
                                       </div>
                                   </div>
                               </div>

                               <div class="col-xl-6 col-md-6 col-lg-6">
                                <div class="card">
                                    <div class="card-body bg-success-transparent">
                                        <div class="counter-status">
                                            <div
                                            class="counter-icon bg-success-transparent box-shadow-success">
                                            <i class="fe fe-user text-success fs-23"></i>
                                        </div>
                                        <div class="text-body text-center">
                                         <h4 class="fw-bold">Writers Management System</h4>
                                         <div class="counter-text">
                                           <p class="font-weight-normal mb-0 ">Be your own boss in the writing world with Saseni! You can manage your writing orders, add your preferred writers, and easily handle payments</p>
                                       </div>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>





                   @if(get_option(site_id().'_how_button_url'))
                   <div class="col-xl-4 col-md-6 col-lg-6">

                   </div>

                   <div class="col-xl-4 col-md-6 col-lg-6" style="margin-bottom: 20px;">
                     <a target="_blank" href="{{ get_option(site_id().'_how_button_url') }}"
                     class="btn ripple btn-min w-sm btn-outline-primary me-2 my-auto d-lg-none d-xl-block d-block"> {!! get_option(site_id().'_how_button_text') !!}
                 </a>


             </div>

             <div class="col-xl-4 col-md-6 col-lg-6">

             </div>
             @endif





         </div>
     </div>
 </div>
 <!-- ROW-1 CLOSED -->




 <div class="row">
    <div class="">


        <h2 class="text-center fw-semibold">Exceptional {!! $category->display_name !!} Writers, All in a Single Hub</h2>
        <p class="text-default mb-5 text-center"> {{ get_option(site_id().'_expert_subheading') }}</p>

        <div class="feature-logos" style="color: #000000;">
           <?php 

           $u = 0;
           ?>
           @foreach($worders as $worder)

           @if($worder->writer_id != $u)

           <?php 

           $u      = $worder->writer_id;
           $writer = \App\Models\User::find($worder->writer_id);
           $writer_count = \App\Models\User::whereId($worder->writer_id)->count();
           $user = \App\Models\User::find($worder->writer_id);

           ?>

           @if($writer_count>0)
           <div class="card" style="margin-bottom: -50px;">
              <div class="card-body">
                  <div class="row">

                    <div class="col-sm-4">
                        <img alt="avatar" src="{{ $writer->get_gravatar(150) }}" height="150" alt="{{ username($user->id)->nickname ?? 'none' }}"> 


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

        </div>





        <div class="col-sm-12 text-center">
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
          <a href="{{ route('profile', $user->slug )}}" class="me-4 d-inline-block"> {{ $ratings }} Client Reviews
          </a> 
          <a href="/profile/{{ $user->slug }}/#editors-review" style="color: green;" class="me-4 d-inline-block" style=""> {{ $eratings }} Editor Reviews
          </a> 
      </div>


      <div class="col-sm-12">
        <br>
        <center>
         <form action="{{ route('request_writer')}}" method="POST"> 
            @csrf
            <input type="hidden" name="writer_id" value="{{ $user->id }}">

            <button
            class="btn ripple btn-min w-sm btn-outline-primary me-2 my-auto d-lg-none d-xl-block d-block">
            <span class="ms-4 me-4">Request {{ get_option(site_id().'_expert_name') }}</span>
        </button>
    </form>
</center>
<div>
    <br><br>
</div>

</div>





</div>
</div>
</div>

@endif
@endif

@endforeach





</div>
</div>
</div>
</div>
</div>

@endif



<div class="demo-screen-headline main-demo main-demo-1 spacing-top overflow-hidden reveal bg-landing pb-0 bg-image-style" id="home">

    <div class="container px-sm-0">

         <div class="row">

                            <span class="landing-title"></span>
                            <h2 class="fw-semibold text-center">Most Recent {!! $category->display_name !!} Orders</h2>
                        </div>
        <div class="row">
      <?php 
$orders = \App\Models\Order::whereCategoryId($category->id)->orderBy('id', 'desc')->limit(5)->get();
      ?>

      @foreach($orders as $order)


<div class="card">
    <div class="card-body">
          <div class="row">
        <div class="col-sm-4">
          
                    Order No. {{ $order->id}} | {{ subject($order->category_id) }}, {{ $order->word_count }} 
                  @if($order->word_count == 1) page @else pages @endif ({{ $order->word_count*275 }} words)



                  @if($order->slide)
                  {{ $order->slide }} 
                  @if($order->slide == 1) slide @else slides @endif

                  @endif

 

           
        </div>
         <div class="col-sm-2">{{ $order->created_at->diffForHumans() }}</div>
        <div class="col-sm-5">{{ $order->title }}</div>

           <div class="col-sm-1">
            @if($order->writer_id)
               <a class="btn btn-sm btn-primary" href="{{ route('profile', username($order->writer_id)->slug )}}">
                Writer
               </a>
               @endif
           </div>
    </div>
    </div>
</div>

      @endforeach


</div>
</div>
</div>





@if(get_option(site_id().'_show_it_works') =='1')
<!--app-content open-->
<div class="main-content mt-0">
    <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container">
            <div class="">


                <!-- ROW-1 OPEN -->
                <div class="section pb-0" id="how">
                    <div class="container">
                        <div class="row">

                            <span class="landing-title"></span>
                            <h2 class="fw-semibold text-center">{{ get_option(site_id().'_how_header') }}</h2>

                            <p class="text-default mb-5 text-center">{{ get_option(site_id().'_how_description') }}</p>
                        </div>
                        <div class="row text-center services-statistics landing-statistics">
                            <div class="col-xl-3 col-md-6 col-lg-6">
                                <div class="card">
                                    <div class="card-body bg-primary-transparent">
                                        <div class="counter-status">
                                            <div
                                            class="counter-icon bg-primary-transparent box-shadow-primary">
                                            <i class="fe fe-layers text-primary fs-23"></i>
                                        </div>
                                        <div class="test-body text-center">

                                           <h4 class="fw-bold">{{ get_option(site_id().'_post_order_header') }}</h4>
                                           <div class="counter-text">
                                            <p class="font-weight-normal mb-0 ">{!! get_option(site_id().'_post_order') !!}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-md-6 col-lg-6">
                        <div class="card">
                            <div class="card-body bg-secondary-transparent">
                                <div class="counter-status">
                                    <div
                                    class="counter-icon bg-secondary-transparent box-shadow-secondary">
                                    <i class="fe fe-wind text-secondary fs-23"></i>
                                </div>
                                <div class="text-body text-center">
                                    <h4 class="fw-bold">{{ get_option(site_id().'_top_wallet_header') }}</h4>
                                    <div class="counter-text">
                                       <p class="font-weight-normal mb-0 ">{!! get_option(site_id().'_top_wallet') !!}
                                       </p>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
               <div class="col-xl-3 col-md-6 col-lg-6">
                <div class="card">
                    <div class="card-body bg-success-transparent">
                        <div class="counter-status">
                            <div
                            class="counter-icon bg-success-transparent box-shadow-success">
                            <i class="fe fe-user text-success fs-23"></i>
                        </div>
                        <div class="text-body text-center">
                         <h4 class="fw-bold">{{ get_option(site_id().'_writer_assigned_header') }}</h4>
                         <div class="counter-text">
                           <p class="font-weight-normal mb-0 ">{!! get_option(site_id().'_writer_assigned') !!}</p>
                       </div>
                   </div>
               </div>
           </div>
       </div>
   </div>
   <div class="col-xl-3 col-md-6 col-lg-6">
    <div class="card">
        <div class="card-body bg-danger-transparent">
            <div class="counter-status">
                <div
                class="counter-icon bg-danger-transparent box-shadow-danger">
                <i class="fe fe-grid text-danger fs-23"></i>
            </div>
            <div class="text-body text-center" >
              <h4 class="fw-bold">{{ get_option(site_id().'_get_paper_header') }}
              </h4>
              <div class="counter-text">
                 <p class="font-weight-normal mb-0 ">{!! get_option(site_id().'_get_paper') !!}
                 </p>
             </div>
         </div>
     </div>
 </div>
</div>
</div>
@if(get_option(site_id().'_how_button_url'))
<div class="col-xl-4 col-md-6 col-lg-6">

</div>

<div class="col-xl-4 col-md-6 col-lg-6" style="margin-bottom: 20px;">
 <a target="_blank" href="{{ get_option(site_id().'_how_button_url') }}"
 class="btn ripple btn-min w-sm btn-outline-primary me-2 my-auto d-lg-none d-xl-block d-block"> {!! get_option(site_id().'_how_button_text') !!}
</a>


</div>

<div class="col-xl-4 col-md-6 col-lg-6">

</div>
@endif





</div>
</div>
</div>
<!-- ROW-1 CLOSED -->
@endif

@if(get_option(site_id().'_show_features') =='1')
<!-- ROW-2 OPEN -->
<div class="sptb section bg-white" id="Features">
    <div class="container">
        <div class="row">

            <span class="landing-title"></span>
            <h2 class="fw-semibold text-center">{{ get_option(site_id().'_feature_header') }}
            </h2>
            <p class="text-default mb-5 text-center">{{ get_option(site_id().'_feature_subheading') }}</p>
            <div class="row mt-7">
                <div class="col-lg-6 col-md-12">
                    <div class="card features main-features main-features-1 wow fadeInUp reveal revealleft"
                    data-wow-delay="0.1s">
                    <div class="bg-img mb-2 text-left">
                        <svg width="50" height="50" xmlns="http://www.w3.org/2000/svg"
                        viewBox="0 0 128 128">
                        <circle cx="64" cy="64" r="64" fill="#42A3DB" />
                        <path fill="#347CBE"
                        d="M85.5 26.6L66.1 61 33.3 98.6 62.6 128H64c33.7 0 61.3-26 63.8-59.1L85.5 26.6z" />
                        <path fill="#CD2F30"
                        d="M73.1 57.7h-16c3.6 18.7 11.1 36.6 22.1 52.5.3-5 1-9.8 1.8-14.5 4.6 1.3 9.2 2.3 13.7 3-9.7-12.2-17-26.1-21.6-41z" />
                        <path fill="#F04D45"
                        d="M54.9 57.7c-4.6 15-11.9 28.9-21.6 40.9 4.5-.7 9.1-1.7 13.7-3 .9 4.7 1.5 9.5 1.8 14.5 11-15.9 18.4-33.8 22.1-52.5h-16z" />
                        <path fill="#FFF"
                        d="M93.5 52c1.8-1.8 1.8-4.7 0-6.5-1.3-1.3-1.7-3.3-1-5 1-2.4-.1-5-2.5-6-1.7-.7-2.8-2.4-2.8-4.3 0-2.5-2.1-4.6-4.6-4.6-1.9 0-3.5-1.1-4.3-2.8-1-2.4-3.7-3.5-6-2.5-1.7.7-3.7.3-5-1-1.8-1.8-4.7-1.8-6.5 0-1.3 1.3-3.3 1.7-5 1-2.4-1-5 .1-6 2.5-.7 1.7-2.4 2.8-4.3 2.8-2.5 0-4.6 2.1-4.6 4.6 0 1.9-1.1 3.5-2.8 4.3-2.4 1-3.5 3.7-2.5 6 .7 1.7.3 3.7-1 5-1.8 1.8-1.8 4.7 0 6.5 1.3 1.3 1.7 3.3 1 5-1 2.4.1 5 2.5 6 1.7.7 2.8 2.4 2.8 4.3 0 2.5 2.1 4.6 4.6 4.6 1.9 0 3.5 1.1 4.3 2.8 1 2.4 3.7 3.5 6 2.5 1.7-.7 3.7-.3 5 1 1.8 1.8 4.7 1.8 6.5 0 1.3-1.3 3.3-1.7 5-1 2.4 1 5-.1 6-2.5.7-1.7 2.4-2.8 4.3-2.8 2.5 0 4.6-2.1 4.6-4.6 0-1.9 1.1-3.5 2.8-4.3 2.4-1 3.5-3.7 2.5-6-.7-1.7-.3-3.7 1-5z" />
                        <path fill="#FFCD0A"
                        d="M64 70.8c-12.2 0-22.1-9.9-22.1-22.1 0-12.2 9.9-22.1 22.1-22.1 12.2 0 22.1 9.9 22.1 22.1 0 12.2-9.9 22.1-22.1 22.1z" />
                        <path fill="#FFF"
                        d="M59.9 61c-.6 0-1.1-.2-1.5-.7l-8.3-9.2c-.7-.8-.7-2.1.1-2.8.8-.7 2.1-.7 2.8.1l6.7 7.5 15.1-18.8c.7-.9 2-1 2.8-.3.9.7 1 2 .3 2.8L61.4 60.2c-.3.5-.9.8-1.5.8z" />
                    </svg>
                </div>
                <div class="text-left">
                    <h4 class="fw-bold">{{ get_option(site_id().'_feature_header1') }}</h4>
                    <p class="mb-0">{{ get_option(site_id().'_feature_description1') }} </p>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-12">
            <div class="card  features main-features main-features-2 wow fadeInUp reveal revealleft"
            data-wow-delay="0.1s">
            <div class="bg-img mb-2 text-left">
                <!-- <img src="../assets/landing/images/features/demo.png" alt=""> -->
                <svg width="50" height="50" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 128 128">
                <circle cx="64" cy="64" r="64" fill="#FFCD0A" />
                <path fill="#F6AF1A"
                d="M127.7 57.7l-26.4-26.4-74.7 58.8L64.5 128c35.1-.3 63.5-28.8 63.5-64 0-2.1-.1-4.2-.3-6.3z" />
                <path fill="#CFD5DF" d="M76.2 102.9H51.8l2-13.6h20.4z" />
                <path fill="#545E70"
                d="M97.1 91.7H30.9c-3.5 0-6.4-2.9-6.4-6.4V36.1c0-3.5 2.9-6.4 6.4-6.4h66.2c3.5 0 6.4 2.9 6.4 6.4v49.3c0 3.5-2.9 6.3-6.4 6.3z" />
                <path fill="#E6E8EB"
                d="M24.5 81.4v4c0 3.5 2.9 6.4 6.4 6.4h66.2c3.5 0 6.4-2.9 6.4-6.4v-4h-79z" />
                <path fill="#49C7EF"
                d="M30.9 74.3c-1 0-1.8-.8-1.8-1.8V36.1c0-1 .8-1.8 1.8-1.8h66.2c1 0 1.8.8 1.8 1.8v36.4c0 1-.8 1.8-1.8 1.8H30.9z" />
                <path fill="#17B6EA" d="M37.8 34.3h52.5v40H37.8z" />
                <path fill="#E6E8EB"
                d="M76.7 105.3H51.3c-1.3 0-2.4-1.1-2.4-2.4 0-1.3 1.1-2.4 2.4-2.4h25.4c1.3 0 2.4 1.1 2.4 2.4-.1 1.3-1.1 2.4-2.4 2.4z" />
                <path fill="#ACB2B9" d="M53.2 91.7l22.7 8.8-1.3-8.8z" />
                <path fill="#FFF"
                d="M75.7 47.8H52.3c-.6 0-1.1-.5-1.1-1.1v-2.9c0-.6.5-1.1 1.1-1.1h23.3c.6 0 1.1.5 1.1 1.1v2.9c0 .6-.4 1.1-1 1.1zM75.7 57.1H52.3c-.6 0-1.1-.5-1.1-1.1v-2.9c0-.6.5-1.1 1.1-1.1h23.3c.6 0 1.1.5 1.1 1.1V56c0 .6-.4 1.1-1 1.1z" />
                <path fill="#FFCD0A"
                d="M62.8 65.9H52.3c-.6 0-1.1-.5-1.1-1.1v-2.9c0-.6.5-1.1 1.1-1.1h10.4c.6 0 1.1.5 1.1 1.1v2.9c0 .6-.4 1.1-1 1.1z" />
                <g fill="#CFD5DF">
                    <circle cx="54.1" cy="45.3" r="1.2" />
                    <circle cx="57.6" cy="45.3" r="1.2" />
                    <circle cx="61" cy="45.3" r="1.2" />
                    <circle cx="64.5" cy="45.3" r="1.2" />
                    <circle cx="67.9" cy="45.3" r="1.2" />
                </g>
                <g fill="#CFD5DF">
                    <circle cx="54.1" cy="54.6" r="1.2" />
                    <circle cx="57.6" cy="54.6" r="1.2" />
                    <circle cx="61" cy="54.6" r="1.2" />
                    <circle cx="64.5" cy="54.6" r="1.2" />
                    <circle cx="67.9" cy="54.6" r="1.2" />
                </g>
                <g fill="#FFF">
                    <path
                    d="M56.9 64.4c-.3.3-.6.4-1 .4s-.8-.1-1-.4c-.3-.3-.4-.6-.4-1s.1-.7.4-1c.3-.3.6-.4 1-.4s.8.1 1 .4c.3.3.4.6.4 1s-.1.7-.4 1zm-.2-1c0-.2-.1-.5-.2-.6-.2-.2-.4-.3-.6-.3s-.4.1-.6.3c-.2.2-.2.4-.2.6 0 .2.1.5.2.6.2.2.4.3.6.3s.4-.1.6-.3c.1-.2.2-.4.2-.6zM58.3 62h.6v1.1l1-1.1h.8l-1.1 1.2c.1.1.3.4.5.7s.4.6.6.8H60l-.8-1.1-.3.4v.8h-.6V62z" />
                </g>
                <circle cx="64" cy="86.6" r="2.8" fill="#545E70" />
                <g fill="#E6E8EB">
                    <path
                    d="M92.6 49.7v9.2c0 1.2 1.6 1.6 2.2.5l2.3-4.6c.2-.3.2-.7 0-1l-2.3-4.6c-.6-1.1-2.2-.7-2.2.5zM36.1 58.9v-9.2c0-1.2-1.6-1.6-2.2-.5l-2.3 4.6c-.2.3-.2.7 0 1l2.3 4.6c.6 1.1 2.2.7 2.2-.5z" />
                </g>
            </svg>
        </div>
        <div class="text-left">
            <h4 class="fw-bold">{{ get_option(site_id().'_feature_header2') }} </h4>
            <p class="mb-0">
               {{ get_option(site_id().'_feature_description2') }}
           </p>
       </div>
   </div>
</div>
<div class="col-lg-6 col-md-12">
    <div class="card features main-features main-features-11 wow fadeInUp reveal revealleft"
    data-wow-delay="0.1s">
    <div class="bg-img mb-2 text-left">
        <svg id="SvgjsSvg1001" width="50" height="50"
        xmlns="http://www.w3.org/2000/svg" version="1.1"
        xmlns:xlink="http://www.w3.org/1999/xlink"
        xmlns:svgjs="http://svgjs.com/svgjs">
        <defs id="SvgjsDefs1002"></defs>
        <g id="SvgjsG1008"><svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 128 128" width="50" height="50">
            <circle cx="64" cy="64" r="64" fill="#bed530"
            class="colorBED530 svgShape"></circle>
            <path fill="#acc437"
            d="M112.8 53.7l-4.6-3.7L85 27l-.9 6.9H77L70 27l-1.3 3.7-6 5.7-9.4-9.4-.9 3.7-8.9 2.3-6-6-5 8.2-3.9 63.7 28.9 28.8c2.2.2 4.4.3 6.6.3 33.7 0 61.4-26.2 63.8-59.3l-15.1-15z"
            class="colorACC437 svgShape"></path>
            <path fill="#ffffff"
            d="M86.5 101.8H34.2c-3.6 0-6.5-2.9-6.5-6.5v-58c0-3.6 2.9-6.5 6.5-6.5h52.3c3.6 0 6.5 2.9 6.5 6.5v58c0 3.6-2.9 6.5-6.5 6.5z"
            class="colorFFF svgShape"></path>
            <path fill="#e6e8eb"
            d="M75.6 78l-9.5 12.3 11.5 11.5h8.8c3.6 0 6.5-2.9 6.5-6.5V67.7L75.6 78z"
            class="colorE6E8EB svgShape"></path>
            <path fill="#e2247e" d="M88.5 58.8h8v31.9h-8z"
            transform="rotate(-135.032 92.483 74.797)"
            class="colorE2247E svgShape"></path>
            <path fill="#ee3e88" d="M82.9 53.2h8v31.9h-8z"
            transform="rotate(-135.032 86.846 69.166)"
            class="colorEE3E88 svgShape"></path>
            <path fill="#f06197" d="M77.2 47.6h8v31.9h-8z"
            transform="rotate(-135.032 81.209 63.535)"
            class="colorF06197 svgShape"></path>
            <path fill="#cfd5df" d="M87 56h23.9v2.2H87z"
            transform="rotate(-135.032 98.922 57.076)"
            class="colorCFD5DF svgShape"></path>
            <path fill="#545e70"
            d="M102.2 43.2l10.5 10.5c1.8 1.8 1.8 4.6 0 6.4l-4.6 4.6-16.8-16.9 4.6-4.6c1.7-1.7 4.6-1.7 6.3 0z"
            class="color545E70 svgShape"></path>
            <path fill="#fcd65e"
            d="M67.1 72l-1.7 16.7c-.1 1.1.8 2 1.9 1.9L84 88.9 67.1 72z"
            class="colorFCD65E svgShape"></path>
            <path fill="#f6af1a"
            d="M65.4 88.7c-.1.6.2 1.1.5 1.5l9.6-9.6-8.4-8.6-1.7 16.7z"
            class="colorF6AF1A svgShape"></path>
            <path fill="#ffcd0a"
            d="M66.1 90.3l12.2-7-5.6-5.6-7 12.2c.2.1.3.3.4.4z"
            class="colorFFCD0A svgShape"></path>
            <path fill="#7d6c7c"
            d="M65.9 83.9l-.5 4.8c-.1 1.1.8 2 1.9 1.9l4.8-.5-6.2-6.2z"
            class="color7D6C7C svgShape"></path>
            <path fill="#5b4b57"
            d="M65.9 83.9l-.5 4.8c-.1.6.2 1.1.5 1.5l3.1-3.1-3.1-3.2z"
            class="color5B4B57 svgShape"></path>
            <path fill="#6b5969"
            d="M68 86l-2.2 3.9c.1.2.2.3.4.4l3.9-2.3-2.1-2z"
            class="color6B5969 svgShape"></path>
            <circle cx="84.1" cy="39.6" r="4.1" fill="#bed530"
            class="colorBED530 svgShape"></circle>
            <circle cx="68.2" cy="39.6" r="4.1" fill="#bed530"
            class="colorBED530 svgShape"></circle>
            <circle cx="52.4" cy="39.6" r="4.1" fill="#bed530"
            class="colorBED530 svgShape"></circle>
            <circle cx="36.5" cy="39.6" r="4.1" fill="#bed530"
            class="colorBED530 svgShape"></circle>
            <path fill="#545e70"
            d="M84.1 40.5c-1.1 0-1.9-.9-1.9-1.9v-10c0-1.1.9-1.9 1.9-1.9 1.1 0 1.9.9 1.9 1.9v10c.1 1.1-.8 1.9-1.9 1.9zM68.3 40.5c-1.1 0-1.9-.9-1.9-1.9v-10c0-1.1.9-1.9 1.9-1.9 1.1 0 1.9.9 1.9 1.9v10c0 1.1-.9 1.9-1.9 1.9zM52.4 40.6c-1.1 0-1.9-.9-1.9-1.9v-10c0-1.1.9-1.9 1.9-1.9 1.1 0 1.9.9 1.9 1.9v10c0 1-.9 1.9-1.9 1.9zM36.5 40.6c-1.1 0-1.9-.9-1.9-1.9v-10c0-1.1.9-1.9 1.9-1.9 1.1 0 1.9.9 1.9 1.9v10c0 1-.8 1.9-1.9 1.9z"
            class="color545E70 svgShape"></path>
        </svg></g>
    </svg>
</div>
<div class="text-left">
    <h4 class="fw-bold">{{ get_option(site_id().'_feature_header3') }}</h4>
    <p class="mb-0">
       {{ get_option(site_id().'_feature_description3') }}
   </p>
</div>
</div>
</div>
<div class="col-lg-6 col-md-12">
    <div class="card features main-features main-features-10 wow fadeInUp reveal revealleft"
    data-wow-delay="0.1s">
    <div class="bg-img mb-2 text-left">
        <svg width="50" height="50" xmlns="http://www.w3.org/2000/svg"
        version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
        xmlns:svgjs="http://svgjs.com/svgjs">
        <defs id="SvgjsDefs1055"></defs>
        <g id="SvgjsG1056"><svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 128 128" width="50" height="50">
            <circle cx="64" cy="64" r="64" fill="#58e1ef"
            class="colorD9B9A9 svgShape"></circle>
            <path fill="#47d4e4"
            d="M71.4 127.6c29.4-3.4 52.7-26.7 56.1-56.1L74.8 18.6 51.9 31.2 31.2 47.4 18.6 74.8l52.8 52.8z"
            class="colorD6AB9A svgShape"></path>
            <path fill="#6b5969"
            d="M64 101.5c-20.7 0-37.5-16.8-37.5-37.5S43.3 26.5 64 26.5s37.5 16.8 37.5 37.5-16.8 37.5-37.5 37.5zm0-70.3c-18.1 0-32.8 14.7-32.8 32.8S45.9 96.8 64 96.8 96.8 82.1 96.8 64 82.1 31.2 64 31.2z"
            class="color6B5969 svgShape"></path>
            <circle cx="64" cy="28.8" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#8663a7"
            d="M64 39.1c-5.6 0-10.2-4.6-10.2-10.2S58.4 18.7 64 18.7s10.2 4.6 10.2 10.2S69.6 39.1 64 39.1z"
            class="color8663A7 svgShape"></path>
            <circle cx="64" cy="99.2" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#3d9c46"
            d="M64 109.4c-5.6 0-10.2-4.6-10.2-10.2S58.4 89 64 89s10.2 4.6 10.2 10.2-4.6 10.2-10.2 10.2z"
            class="color3D9C46 svgShape"></path>
            <circle cx="99.2" cy="64" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#ee3e88"
            d="M99.2 74.2C93.6 74.2 89 69.6 89 64s4.6-10.2 10.2-10.2 10.2 4.6 10.2 10.2-4.6 10.2-10.2 10.2z"
            class="colorEE3E88 svgShape"></path>
            <circle cx="28.8" cy="64" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#ffcd0a"
            d="M28.8 74.2c-5.6 0-10.2-4.6-10.2-10.2s4.6-10.2 10.2-10.2S39.1 58.4 39.1 64s-4.6 10.2-10.3 10.2z"
            class="colorFFCD0A svgShape"></path>
            <path fill="#ffffff"
            d="M98.4 61.8v1.9h2.5v1.5h-2.5v2.7h4.4v1.6h-7.4v-1.6h1.2v-2.7h-1.3v-1.5h1.3v-1.9c0-1.2.3-2.1.9-2.6.6-.5 1.4-.8 2.4-.8 1.3 0 2.3.6 2.9 1.7l-1.2 1c-.4-.7-.9-1-1.6-1-.5 0-.9.1-1.2.4s-.4.7-.4 1.3z"
            class="colorFFF svgShape"></path>
        </svg></g>
    </svg>
</div>
<div class="text-left">
    <h4 class="fw-bold">{{ get_option(site_id().'_feature_header4') }}</h4>
    <p class="mb-0">
      {{ get_option(site_id().'_feature_description4') }}
  </p>
</div>
</div>
</div>

@if(get_option(site_id().'_feature_header5'))
<div class="col-lg-6 col-md-12">
    <div class="card features main-features main-features-10 wow fadeInUp reveal revealleft"
    data-wow-delay="0.1s">
    <div class="bg-img mb-2 text-left">
        <svg width="50" height="50" xmlns="http://www.w3.org/2000/svg"
        version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
        xmlns:svgjs="http://svgjs.com/svgjs">
        <defs id="SvgjsDefs1055"></defs>
        <g id="SvgjsG1056"><svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 128 128" width="50" height="50">
            <circle cx="64" cy="64" r="64" fill="#58e1ef"
            class="colorD9B9A9 svgShape"></circle>
            <path fill="#47d4e4"
            d="M71.4 127.6c29.4-3.4 52.7-26.7 56.1-56.1L74.8 18.6 51.9 31.2 31.2 47.4 18.6 74.8l52.8 52.8z"
            class="colorD6AB9A svgShape"></path>
            <path fill="#6b5969"
            d="M64 101.5c-20.7 0-37.5-16.8-37.5-37.5S43.3 26.5 64 26.5s37.5 16.8 37.5 37.5-16.8 37.5-37.5 37.5zm0-70.3c-18.1 0-32.8 14.7-32.8 32.8S45.9 96.8 64 96.8 96.8 82.1 96.8 64 82.1 31.2 64 31.2z"
            class="color6B5969 svgShape"></path>
            <circle cx="64" cy="28.8" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#8663a7"
            d="M64 39.1c-5.6 0-10.2-4.6-10.2-10.2S58.4 18.7 64 18.7s10.2 4.6 10.2 10.2S69.6 39.1 64 39.1z"
            class="color8663A7 svgShape"></path>
            <circle cx="64" cy="99.2" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#3d9c46"
            d="M64 109.4c-5.6 0-10.2-4.6-10.2-10.2S58.4 89 64 89s10.2 4.6 10.2 10.2-4.6 10.2-10.2 10.2z"
            class="color3D9C46 svgShape"></path>
            <circle cx="99.2" cy="64" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#ee3e88"
            d="M99.2 74.2C93.6 74.2 89 69.6 89 64s4.6-10.2 10.2-10.2 10.2 4.6 10.2 10.2-4.6 10.2-10.2 10.2z"
            class="colorEE3E88 svgShape"></path>
            <circle cx="28.8" cy="64" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#ffcd0a"
            d="M28.8 74.2c-5.6 0-10.2-4.6-10.2-10.2s4.6-10.2 10.2-10.2S39.1 58.4 39.1 64s-4.6 10.2-10.3 10.2z"
            class="colorFFCD0A svgShape"></path>
            <path fill="#ffffff"
            d="M98.4 61.8v1.9h2.5v1.5h-2.5v2.7h4.4v1.6h-7.4v-1.6h1.2v-2.7h-1.3v-1.5h1.3v-1.9c0-1.2.3-2.1.9-2.6.6-.5 1.4-.8 2.4-.8 1.3 0 2.3.6 2.9 1.7l-1.2 1c-.4-.7-.9-1-1.6-1-.5 0-.9.1-1.2.4s-.4.7-.4 1.3z"
            class="colorFFF svgShape"></path>
        </svg></g>
    </svg>
</div>
<div class="text-left">
    <h4 class="fw-bold">{{ get_option(site_id().'_feature_header5') }}</h4>
    <p class="mb-0">
      {{ get_option(site_id().'_feature_description5') }}
  </p>
</div>
</div>
</div>

@endif

@if(get_option(site_id().'_feature_header6'))
<div class="col-lg-6 col-md-12">
    <div class="card features main-features main-features-10 wow fadeInUp reveal revealleft"
    data-wow-delay="0.1s">
    <div class="bg-img mb-2 text-left">
        <svg width="50" height="50" xmlns="http://www.w3.org/2000/svg"
        version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
        xmlns:svgjs="http://svgjs.com/svgjs">
        <defs id="SvgjsDefs1055"></defs>
        <g id="SvgjsG1056"><svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 128 128" width="50" height="50">
            <circle cx="64" cy="64" r="64" fill="#58e1ef"
            class="colorD9B9A9 svgShape"></circle>
            <path fill="#47d4e4"
            d="M71.4 127.6c29.4-3.4 52.7-26.7 56.1-56.1L74.8 18.6 51.9 31.2 31.2 47.4 18.6 74.8l52.8 52.8z"
            class="colorD6AB9A svgShape"></path>
            <path fill="#6b5969"
            d="M64 101.5c-20.7 0-37.5-16.8-37.5-37.5S43.3 26.5 64 26.5s37.5 16.8 37.5 37.5-16.8 37.5-37.5 37.5zm0-70.3c-18.1 0-32.8 14.7-32.8 32.8S45.9 96.8 64 96.8 96.8 82.1 96.8 64 82.1 31.2 64 31.2z"
            class="color6B5969 svgShape"></path>
            <circle cx="64" cy="28.8" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#8663a7"
            d="M64 39.1c-5.6 0-10.2-4.6-10.2-10.2S58.4 18.7 64 18.7s10.2 4.6 10.2 10.2S69.6 39.1 64 39.1z"
            class="color8663A7 svgShape"></path>
            <circle cx="64" cy="99.2" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#3d9c46"
            d="M64 109.4c-5.6 0-10.2-4.6-10.2-10.2S58.4 89 64 89s10.2 4.6 10.2 10.2-4.6 10.2-10.2 10.2z"
            class="color3D9C46 svgShape"></path>
            <circle cx="99.2" cy="64" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#ee3e88"
            d="M99.2 74.2C93.6 74.2 89 69.6 89 64s4.6-10.2 10.2-10.2 10.2 4.6 10.2 10.2-4.6 10.2-10.2 10.2z"
            class="colorEE3E88 svgShape"></path>
            <circle cx="28.8" cy="64" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#ffcd0a"
            d="M28.8 74.2c-5.6 0-10.2-4.6-10.2-10.2s4.6-10.2 10.2-10.2S39.1 58.4 39.1 64s-4.6 10.2-10.3 10.2z"
            class="colorFFCD0A svgShape"></path>
            <path fill="#ffffff"
            d="M98.4 61.8v1.9h2.5v1.5h-2.5v2.7h4.4v1.6h-7.4v-1.6h1.2v-2.7h-1.3v-1.5h1.3v-1.9c0-1.2.3-2.1.9-2.6.6-.5 1.4-.8 2.4-.8 1.3 0 2.3.6 2.9 1.7l-1.2 1c-.4-.7-.9-1-1.6-1-.5 0-.9.1-1.2.4s-.4.7-.4 1.3z"
            class="colorFFF svgShape"></path>
        </svg></g>
    </svg>
</div>
<div class="text-left">
    <h4 class="fw-bold">{{ get_option(site_id().'_feature_header6') }}</h4>
    <p class="mb-0">
      {{ get_option(site_id().'_feature_description6') }}
  </p>
</div>
</div>
</div>

@endif

@if(get_option(site_id().'_feature_header7'))
<div class="col-lg-6 col-md-12">
    <div class="card features main-features main-features-10 wow fadeInUp reveal revealleft"
    data-wow-delay="0.1s">
    <div class="bg-img mb-2 text-left">
        <svg width="50" height="50" xmlns="http://www.w3.org/2000/svg"
        version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
        xmlns:svgjs="http://svgjs.com/svgjs">
        <defs id="SvgjsDefs1055"></defs>
        <g id="SvgjsG1056"><svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 128 128" width="50" height="50">
            <circle cx="64" cy="64" r="64" fill="#58e1ef"
            class="colorD9B9A9 svgShape"></circle>
            <path fill="#47d4e4"
            d="M71.4 127.6c29.4-3.4 52.7-26.7 56.1-56.1L74.8 18.6 51.9 31.2 31.2 47.4 18.6 74.8l52.8 52.8z"
            class="colorD6AB9A svgShape"></path>
            <path fill="#6b5969"
            d="M64 101.5c-20.7 0-37.5-16.8-37.5-37.5S43.3 26.5 64 26.5s37.5 16.8 37.5 37.5-16.8 37.5-37.5 37.5zm0-70.3c-18.1 0-32.8 14.7-32.8 32.8S45.9 96.8 64 96.8 96.8 82.1 96.8 64 82.1 31.2 64 31.2z"
            class="color6B5969 svgShape"></path>
            <circle cx="64" cy="28.8" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#8663a7"
            d="M64 39.1c-5.6 0-10.2-4.6-10.2-10.2S58.4 18.7 64 18.7s10.2 4.6 10.2 10.2S69.6 39.1 64 39.1z"
            class="color8663A7 svgShape"></path>
            <circle cx="64" cy="99.2" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#3d9c46"
            d="M64 109.4c-5.6 0-10.2-4.6-10.2-10.2S58.4 89 64 89s10.2 4.6 10.2 10.2-4.6 10.2-10.2 10.2z"
            class="color3D9C46 svgShape"></path>
            <circle cx="99.2" cy="64" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#ee3e88"
            d="M99.2 74.2C93.6 74.2 89 69.6 89 64s4.6-10.2 10.2-10.2 10.2 4.6 10.2 10.2-4.6 10.2-10.2 10.2z"
            class="colorEE3E88 svgShape"></path>
            <circle cx="28.8" cy="64" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#ffcd0a"
            d="M28.8 74.2c-5.6 0-10.2-4.6-10.2-10.2s4.6-10.2 10.2-10.2S39.1 58.4 39.1 64s-4.6 10.2-10.3 10.2z"
            class="colorFFCD0A svgShape"></path>
            <path fill="#ffffff"
            d="M98.4 61.8v1.9h2.5v1.5h-2.5v2.7h4.4v1.6h-7.4v-1.6h1.2v-2.7h-1.3v-1.5h1.3v-1.9c0-1.2.3-2.1.9-2.6.6-.5 1.4-.8 2.4-.8 1.3 0 2.3.6 2.9 1.7l-1.2 1c-.4-.7-.9-1-1.6-1-.5 0-.9.1-1.2.4s-.4.7-.4 1.3z"
            class="colorFFF svgShape"></path>
        </svg></g>
    </svg>
</div>
<div class="text-left">
    <h4 class="fw-bold">{{ get_option(site_id().'_feature_header7') }}</h4>
    <p class="mb-0">
      {{ get_option(site_id().'_feature_description7') }}
  </p>
</div>
</div>
</div>

@endif

@if(get_option(site_id().'_feature_header8'))
<div class="col-lg-6 col-md-12">
    <div class="card features main-features main-features-10 wow fadeInUp reveal revealleft"
    data-wow-delay="0.1s">
    <div class="bg-img mb-2 text-left">
        <svg width="50" height="50" xmlns="http://www.w3.org/2000/svg"
        version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink"
        xmlns:svgjs="http://svgjs.com/svgjs">
        <defs id="SvgjsDefs1055"></defs>
        <g id="SvgjsG1056"><svg xmlns="http://www.w3.org/2000/svg"
            viewBox="0 0 128 128" width="50" height="50">
            <circle cx="64" cy="64" r="64" fill="#58e1ef"
            class="colorD9B9A9 svgShape"></circle>
            <path fill="#47d4e4"
            d="M71.4 127.6c29.4-3.4 52.7-26.7 56.1-56.1L74.8 18.6 51.9 31.2 31.2 47.4 18.6 74.8l52.8 52.8z"
            class="colorD6AB9A svgShape"></path>
            <path fill="#6b5969"
            d="M64 101.5c-20.7 0-37.5-16.8-37.5-37.5S43.3 26.5 64 26.5s37.5 16.8 37.5 37.5-16.8 37.5-37.5 37.5zm0-70.3c-18.1 0-32.8 14.7-32.8 32.8S45.9 96.8 64 96.8 96.8 82.1 96.8 64 82.1 31.2 64 31.2z"
            class="color6B5969 svgShape"></path>
            <circle cx="64" cy="28.8" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#8663a7"
            d="M64 39.1c-5.6 0-10.2-4.6-10.2-10.2S58.4 18.7 64 18.7s10.2 4.6 10.2 10.2S69.6 39.1 64 39.1z"
            class="color8663A7 svgShape"></path>
            <circle cx="64" cy="99.2" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#3d9c46"
            d="M64 109.4c-5.6 0-10.2-4.6-10.2-10.2S58.4 89 64 89s10.2 4.6 10.2 10.2-4.6 10.2-10.2 10.2z"
            class="color3D9C46 svgShape"></path>
            <circle cx="99.2" cy="64" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#ee3e88"
            d="M99.2 74.2C93.6 74.2 89 69.6 89 64s4.6-10.2 10.2-10.2 10.2 4.6 10.2 10.2-4.6 10.2-10.2 10.2z"
            class="colorEE3E88 svgShape"></path>
            <circle cx="28.8" cy="64" r="14.8" fill="#ffffff"
            class="colorFFF svgShape"></circle>
            <path fill="#ffcd0a"
            d="M28.8 74.2c-5.6 0-10.2-4.6-10.2-10.2s4.6-10.2 10.2-10.2S39.1 58.4 39.1 64s-4.6 10.2-10.3 10.2z"
            class="colorFFCD0A svgShape"></path>
            <path fill="#ffffff"
            d="M98.4 61.8v1.9h2.5v1.5h-2.5v2.7h4.4v1.6h-7.4v-1.6h1.2v-2.7h-1.3v-1.5h1.3v-1.9c0-1.2.3-2.1.9-2.6.6-.5 1.4-.8 2.4-.8 1.3 0 2.3.6 2.9 1.7l-1.2 1c-.4-.7-.9-1-1.6-1-.5 0-.9.1-1.2.4s-.4.7-.4 1.3z"
            class="colorFFF svgShape"></path>
        </svg></g>
    </svg>
</div>
<div class="text-left">
    <h4 class="fw-bold">{{ get_option(site_id().'_feature_header8') }}</h4>
    <p class="mb-0">
      {{ get_option(site_id().'_feature_description8') }}
  </p>
</div>
</div>
</div>

@endif


</div>
</div>
</div>
</div>
<!-- ROW-2 CLOSED -->

@endif
@if(get_option(site_id().'_show_why_us') =='1')
<!-- ROW-3 OPEN -->
<div class="section bg-landing pb-0 bg-image-style" id="About">
    <div class="container">
        <div class="row">

            <span class="landing-title"></span>
            <div class="text-center">
                <h2 class="text-center fw-semibold">{{ get_option(site_id().'_why_header') }}
                </h2>
            </div>
            <div class="col-lg-12">
                <div class="card bg-transparent">
                    <div class="card-body text-dark">
                        <div class="statistics-info">
                            <div class="row">
                                <div class="col-xl-6 col-lg-6 ps-0">
                                    <div class="text-center reveal revealleft mb-3">
                                        <img src="{{ asset('assets/images/landing/business-team-working-on-business-plan2.png')}}"
                                        alt="{{ get_option(site_id().'_site_name') }}" class="br-5" >
                                    </div>
                                    <div style="padding-top: 20px;">
                                       @guest
                                       <a href="{{ get_option(site_id().'_hero_button_url1') }}"
                                       class="btn ripple btn-min w-lg mb-3 me-2 btn-primary"><i
                                       class="fe fe-play me-2"></i> {{ get_option(site_id().'_hero_button_text1') }}
                                   </a>



                                   <a href="{{ get_option(site_id().'_hero_button_url2') }}"
                                   class="btn ripple btn-min w-lg btn-outline-primary mb-3 me-2" target="_blank"><i
                                   class="fa fa-sign-in me-2"></i>{{ get_option(site_id().'_hero_button_text2') }}
                               </a>

                               @else
                               <a href="{{ route('register')}}"
                               class="btn ripple btn-min w-lg btn-outline-primary mb-3 me-2"
                               >My Account
                           </a>
                           @endguest

                       </div>
                       
                   </div>
                   <div class="col-xl-6 col-lg-6 pe-0 my-auto">

                    <div class="ps-5 reveal revealright">
                        <h2 class="text-start fw-semibold fs-25 mb-6">{{ get_option(site_id().'_why_description') }}
                        </h2>
                        <div class="d-flex">
                            <span><svg style="width:20px;height:20px"
                                viewBox="0 0 24 24">
                                <path fill="#6c5ffc"
                                d="M23,12L20.56,9.22L20.9,5.54L17.29,4.72L15.4,1.54L12,3L8.6,1.54L6.71,4.72L3.1,5.53L3.44,9.21L1,12L3.44,14.78L3.1,18.47L6.71,19.29L8.6,22.47L12,21L15.4,22.46L17.29,19.28L20.9,18.46L20.56,14.78L23,12M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9L10,17Z" />
                            </svg></span>
                            <div class="ms-5 mb-4">
                                <h5 class="fw-bold">{{ get_option(site_id().'_support') }}
                                </h5>
                                <p>{{ get_option(site_id().'_support_description') }}</p>
                            </div>
                        </div>
                        <div class="d-flex">
                            <span><svg style="width:20px;height:20px"
                                viewBox="0 0 24 24">
                                <path fill="#6c5ffc"
                                d="M23,12L20.56,9.22L20.9,5.54L17.29,4.72L15.4,1.54L12,3L8.6,1.54L6.71,4.72L3.1,5.53L3.44,9.21L1,12L3.44,14.78L3.1,18.47L6.71,19.29L8.6,22.47L12,21L15.4,22.46L17.29,19.28L20.9,18.46L20.56,14.78L23,12M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9L10,17Z" />
                            </svg></span>
                            <div class="ms-5 mb-4">
                                <h5 class="fw-bold">{{ get_option(site_id().'_satisfaction') }}</h5>
                                <p>
                                 {{ get_option(site_id().'_satisfaction_description') }}
                             </p>
                         </div>
                     </div>
                 </div>
             </div>
         </div>
     </div>
 </div>
</div>
</div>
</div>
</div>
</div>
<!-- ROW-3 CLOSED -->

@endif


@if(get_option(site_id().'_show_services') =='1')

<!-- ROW-3 OPEN -->
<div class="section bg-landing pb-0 bg-image-style" id="About">
  <div class="container">
    <div class="row">

       <div class="text-center">
          <h2 class="text-center fw-semibold">{{ get_option(site_id().'_service') }}
          </h2>
          <p class="text-default mb-5 text-center">{{ get_option(site_id().'_service_description') }}</p>
      </div>


      <div class="col-xl-12 col-md-12">

          <div class="row">
            <div class="col-xl-6">
              <div class="customer-services mb-2">
                {!! get_option(site_id().'_service_box1') !!}
            </div>
        </div>
        <div class="col-xl-6">
          <div class="customer-services mb-2">
             {!! get_option(site_id().'_service_box2') !!}
         </div>
     </div>
     <div class="col-xl-6">
        <div class="customer-services">
           {!! get_option(site_id().'_service_box3') !!}
       </div>
   </div>

   <div class="col-xl-6">
    <div class="customer-services">
       {!! get_option(site_id().'_service_box4') !!}
   </div>
</div>

@if(get_option(site_id().'_how_button_url'))
<div class="col-xl-4 col-md-6 col-lg-6">

</div>

<div class="col-xl-4 col-md-6 col-lg-6"  style="margin-bottom: 20px;">
 <a target="_blank" href="{{ get_option(site_id().'_how_button_url') }}"
 class="btn btn-primary"> {!! get_option(site_id().'_how_button_text') !!}
</a>
</div>

<div class="col-xl-4 col-md-6 col-lg-6">

</div>
@endif


</div>
</div>

</div>
</div>
</div>



@endif


@if(get_option(site_id().'_show_faqs') =='1')
<!-- ROW-7 OPEN -->
<div class="section" id="Faqs">
 <div class="container">
    <div class="row">

        <span class="landing-title"></span>
        <h2 class="text-center fw-semibold">{{ get_option(site_id().'_faq_header') }}</h2>

        <h4 class="text-center fw-semibold">  {{ get_option(site_id().'_faq_description') }}</h4>

        <section class="sptb demo-screen-demo" id="faqs">
            <div class="row align-items-center">
                <div class="col-md-12 col-lg-6">
                    <h2 class="text-start fw-semibold fs-25 mb-6">@lang('app.faq_subtitle1') 
                    </h2>
                    <div class="col-md-12 grid-item  px-0">
                        <div
                        class="card card-collapsed bg-primary-transparent p-0 reveal">
                        <div class="card-header grid-link"
                        data-bs-toggle="card-collapse">
                        <a href="#"
                        class="card-options-collapse h5 fw-bold card-title mb-0"><span
                        class="me-3 fs-18 fw-bold text-primary">01.</span>{{ get_option(site_id().'_faq_header1') }}</a>
                    </div>
                    <div class="card-body pt-0">
                        <p>

                           {{ get_option(site_id().'_faq_description1') }}
                       </p>
                       <p class="mt-2 mb-3">
                        <span class="fw-bold">Note: </span>Please Refer
                        support section for more information.
                    </p>
                    <img onclick="smartsupp('chat:open');">
                    <a class="btn btn-outline-warning tx-13" href="#" onclick="smartsupp('chat:open'); return false;">Chat with us</a>
                </div>
            </div>
        </div>
        <div class="col-md-12 grid-item  px-0">
            <div
            class="card card-collapsed bg-success-transparent p-0 reveal">
            <div class="card-header grid-link"
            data-bs-toggle="card-collapse">
            <a href="#"
            class="card-options-collapse  h5 fw-bold card-title mb-0"><span
            class="me-3 fs-18 fw-bold text-success">02.</span>{{ get_option(site_id().'_faq_header2') }} </a>
        </div>
        <div class="card-body pt-0">
            <p>
              {{ get_option(site_id().'_faq_description2') }} 
          </p>
          <p class="mt-2 mb-3">
            <span class="fw-bold">Note: </span>Please Refer
            support section for more information.
        </p>
        <img onclick="smartsupp('chat:open');">
        <a class="btn btn-outline-warning tx-13" href="#" onclick="smartsupp('chat:open'); return false;">Chat with us</a>
    </div>
</div>
</div>
<div class="col-md-12 grid-item  px-0">
    <div
    class="card card-collapsed bg-secondary-transparent p-0 reveal">
    <div class="card-header grid-link"
    data-bs-toggle="card-collapse">
    <a href="#"
    class="card-options-collapse  h5 fw-bold card-title mb-0"><span
    class="me-3 fs-18 fw-bold text-secondary">03.</span>{{ get_option(site_id().'_faq_header3') }} </a>
</div>
<div class="card-body pt-0">
    <p>
     {{ get_option(site_id().'_faq_description3') }}
 </p>
 <p class="mt-2 mb-3">
    <span class="fw-bold">Note: </span>Please Refer
    support section for more information.
</p>
<img onclick="smartsupp('chat:open');">
<a class="btn btn-outline-warning tx-13" href="#" onclick="smartsupp('chat:open'); return false;">Chat with us</a>
</div>
</div>
</div>
<div class="col-md-12 grid-item  px-0">
    <div
    class="card card-collapsed bg-warning-transparent p-0 reveal">
    <div class="card-header grid-link"
    data-bs-toggle="card-collapse">
    <a href="#"
    class="card-options-collapse  h5 fw-bold card-title mb-0"><span
    class="me-3 fs-18 fw-bold text-warning">04.</span>{{ get_option(site_id().'_faq_header4') }}</a>
</div>
<div class="card-body pt-0">
    <p>
       {{ get_option(site_id().'_faq_description4') }}
   </p>
   <p class="mt-2 mb-3">
    <span class="fw-bold">Note: </span>Please Refer
    support section for more information.
</p>
<img onclick="smartsupp('chat:open');">
<a class="btn btn-outline-warning tx-13" href="#" onclick="smartsupp('chat:open'); return false;">Chat with us</a>
</div>
</div>
</div>
<div class="col-md-12 grid-item  px-0">
    <div
    class="card card-collapsed bg-danger-transparent p-0 reveal">
    <div class="card-header grid-link"
    data-bs-toggle="card-collapse">
    <a href="#"
    class="card-options-collapse  h5 fw-bold card-title mb-0"><span
    class="me-3 fs-18 fw-bold text-danger">05.</span>{{ get_option(site_id().'_faq_header5') }}</a>
</div>
<div class="card-body pt-0">
    <p>
       {{ get_option(site_id().'_faq_description5') }}
   </p>
   <p class="mt-2 mb-3">
    <span class="fw-bold">Note: </span>Please Refer
    support section for more information.
</p>
<img onclick="smartsupp('chat:open');">
<a class="btn btn-outline-warning tx-13" href="#" onclick="smartsupp('chat:open'); return false;">Chat with us</a>
</div>
</div>

</div>
</div>



<div class="col-md-12 col-lg-6">
    <h2 class="text-start fw-semibold fs-25 mb-6">@lang('app.faq_subtitle2') 
    </h2>
    <div class="col-md-12 grid-item  px-0">
        <div
        class="card card-collapsed bg-primary-transparent p-0 reveal">
        <div class="card-header grid-link"
        data-bs-toggle="card-collapse">
        <a href="#"
        class="card-options-collapse h5 fw-bold card-title mb-0"><span
        class="me-3 fs-18 fw-bold text-primary">01.</span>{{ get_option(site_id().'_cfaq_header1') }}</a>
    </div>
    <div class="card-body pt-0">
        <p>
           {{ get_option(site_id().'_cfaq_description1') }}
       </p>
       <p class="mt-2 mb-3">
        <span class="fw-bold">Note: </span>Please Refer
        support section for more information.
    </p>
    <img onclick="smartsupp('chat:open');">
    <a class="btn btn-outline-warning tx-13" href="#" onclick="smartsupp('chat:open'); return false;">Chat with us</a>
</div>
</div>
</div>
<div class="col-md-12 grid-item  px-0">
    <div
    class="card card-collapsed bg-success-transparent p-0 reveal">
    <div class="card-header grid-link"
    data-bs-toggle="card-collapse">
    <a href="#"
    class="card-options-collapse  h5 fw-bold card-title mb-0"><span
    class="me-3 fs-18 fw-bold text-success">02.</span>{{ get_option(site_id().'_cfaq_header2') }} </a>
</div>
<div class="card-body pt-0">
    <p>
      {{ get_option(site_id().'_cfaq_description2') }} 
  </p>
  <p class="mt-2 mb-3">
    <span class="fw-bold">Note: </span>Please Refer
    support section for more information.
</p>
<img onclick="smartsupp('chat:open');">
<a class="btn btn-outline-warning tx-13" href="#" onclick="smartsupp('chat:open'); return false;">Chat with us</a>
</div>
</div>
</div>
<div class="col-md-12 grid-item  px-0">
    <div
    class="card card-collapsed bg-secondary-transparent p-0 reveal">
    <div class="card-header grid-link"
    data-bs-toggle="card-collapse">
    <a href="#"
    class="card-options-collapse  h5 fw-bold card-title mb-0"><span
    class="me-3 fs-18 fw-bold text-secondary">03.</span>{{ get_option(site_id().'_cfaq_header3') }} </a>
</div>
<div class="card-body pt-0">
    <p>
     {{ get_option(site_id().'_cfaq_description3') }}
 </p>
 <p class="mt-2 mb-3">
    <span class="fw-bold">Note: </span>Please Refer
    support section for more information.
</p>
<img onclick="smartsupp('chat:open');">
<a class="btn btn-outline-warning tx-13" href="#" onclick="smartsupp('chat:open'); return false;">Chat with us</a>
</div>
</div>
</div>
<div class="col-md-12 grid-item  px-0">
    <div
    class="card card-collapsed bg-warning-transparent p-0 reveal">
    <div class="card-header grid-link"
    data-bs-toggle="card-collapse">
    <a href="#"
    class="card-options-collapse  h5 fw-bold card-title mb-0"><span
    class="me-3 fs-18 fw-bold text-warning">04.</span>{{ get_option(site_id().'_cfaq_header4') }}</a>
</div>
<div class="card-body pt-0">
    <p>
       {{ get_option(site_id().'_cfaq_description4') }}
   </p>
   <p class="mt-2 mb-3">
    <span class="fw-bold">Note: </span>Please Refer
    support section for more information.
</p>
<img onclick="smartsupp('chat:open');">
<a class="btn btn-outline-warning tx-13" href="#" onclick="smartsupp('chat:open'); return false;">Chat with us</a>
</div>
</div>
</div>
<div class="col-md-12 grid-item  px-0">
    <div
    class="card card-collapsed bg-danger-transparent p-0 reveal">
    <div class="card-header grid-link"
    data-bs-toggle="card-collapse">
    <a href="#"
    class="card-options-collapse  h5 fw-bold card-title mb-0"><span
    class="me-3 fs-18 fw-bold text-danger">05.</span>{{ get_option(site_id().'_cfaq_header5') }}</a>
</div>
<div class="card-body pt-0">
    <p>
       {{ get_option(site_id().'_cfaq_description5') }}
   </p>
   <p class="mt-2 mb-3">
    <span class="fw-bold">Note: </span>Please Refer
    support section for more information.
</p>
<img onclick="smartsupp('chat:open');">
<a class="btn btn-outline-warning tx-13" href="#" onclick="smartsupp('chat:open'); return false;">Chat with us</a>
</div>
</div>

</div>
</div>
</div>
</section>
</div>
</div>
</div>
<!-- ROW-7 CLOSED -->

@endif

@if(get_option(site_id().'_show_testimonials') =='1')

@endif








<div class="demo-screen-headline main-demo main-demo-1 spacing-top overflow-hidden reveal bg-landing pb-0 bg-image-style" id="home">

  <div class="container px-sm-0">
    <h2 class="text-center fw-bold">Are you in search of safe {{ $category->display_name }} writing services or writers to complete your assignment securely?</h2>
    @if(get_option(site_id().'_show_homepage_content') =='1')





    <div class="card-body scroll">
        <!-- content -->
        <div class="content vscroll h-600">

            <div class="row">
               <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                   <div class="card p-3 pricing-card reveal revealrotate">
                    <div class="card-body">
                      {!! $category->description !!}  
                  </div>
              </div>
          </div>

      </div>


  </div>
</div>




@endif


@if(get_option(site_id().'_show_cta') =='1')
<div class="row">
  <div class="col-xl-12 col-lg-12 mb-5 pb-5 animation-zidex pos-relative">


    <h6 class="pb-3 text-center">
    No matter the type of essay that you need help writing, we are here to assist you. Click "GET STARTED" and agree to our terms and conditions; your essay will soon be complete! Don't ask, "Need someone to do {{ $category->display_name }} for me?" when we are already here? 

       <div id="hello-react"></div>
   </h6>
   <center>

<a href="{{ get_option(site_id().'_hero_button_url2') }}"
     class="btn ripple btn-min w-lg btn-outline-primary mb-3 me-2" target="_blank"><i
     class="fa fa-sign-in me-2"></i>{{ get_option(site_id().'_hero_button_text2') }}
 </a>
</center>


</div>

</div>
@endif
</div>
</div>




@endsection
@section('page-js')

@endsection