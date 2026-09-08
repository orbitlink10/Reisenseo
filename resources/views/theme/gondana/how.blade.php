@extends('layouts.frontbar')
@section('title')@if( ! empty($title)){{$title}} |@endif @parent @endsection
@section('description') @if( ! empty(get_option(site_id().'_show_3_meta'))){{ substr(trim(preg_replace('/\s\s+/', ' ',strip_tags(get_option(site_id().'_show_3_meta')))),0,160) }}@endif @endsection
@section('content') 

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
                                            <h5 class="font-weight-normal mb-0 ">{!! get_option(site_id().'_post_order') !!}</h5>
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
                                        <h5 class="font-weight-normal mb-0 ">{!! get_option(site_id().'_top_wallet') !!}
                                        </h5>
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
                                <h5 class="font-weight-normal mb-0 ">{!! get_option(site_id().'_writer_assigned') !!}</h5>
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
                        <h5 class="font-weight-normal mb-0 ">{!! get_option(site_id().'_get_paper') !!}
                        </h5>
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
               class="btn btn-primary"> {!! get_option(site_id().'_how_button_text') !!}
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
<div class="container">

<div class="row">
       <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
           <div class="card p-3 pricing-card reveal revealrotate">
    <div class="card-body">
      {!! get_option(site_id().'_show_3_content') !!}  
    </div>
   </div>
</div>
    
</div>
</div>
</div>
@endsection


