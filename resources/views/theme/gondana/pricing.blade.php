@extends('layouts.frontbar')
@section('title')@if( ! empty($title)){{$title}} |@endif @parent @endsection
@section('description') @if( ! empty(get_option(site_id().'_show_13_meta'))){{ substr(trim(preg_replace('/\s\s+/', ' ',strip_tags(get_option(site_id().'_show_13_meta')))),0,160) }}@endif @endsection
@section('content') 

<!-- ROW-6 OPEN -->
<div class="bg-landing section bg-image-style" id="Pricing">
    <div class="container">
        <div class="row">
            <h4 class="text-center fw-semibold">Choose a plan </h4>
            <span class="landing-title"></span>
            <h1 class="text-center fw-semibold">Find the <span class="text-primary">Perfect
            Plan</span> for you.</h1>
            <div class="row">

                <?php
                $packages = \App\Models\Package::orderBy('id', 'asc')->get();
                ?>

                @foreach($packages as $package)

                <div class="col-lg-4 col-xl-4 col-md-8 col-sm-12">
                    <div class="card p-3 pricing-card reveal revealrotate">
                        <div class="card-header d-block text-justified pt-2">
                            <p class="fs-18 fw-semibold mb-1">{{ $package->name }}</p>
                            <p class="text-justify fw-semibold mb-1"> <span
                                class="fs-30 me-2">
                                @if($package->id == '3')

                                @else
                                {{ get_option(site_id().'_currency_sign') }} 
                                @endif
                            </span><span
                            class="fs-30 me-1">{{ $package->amount }}</span><span
                            class="fs-25"><span
                            class="op-0-5 text-muted text-20">/</span>
                            {{ $package->max_units }}</span>
                            <p class="fs-13 mb-1 text-secondary">{{ $package->cpp }}
                            </p>
                        </div>
                        <div class="card-body pt-2">
                            <ul class="text-justify pricing-body ps-0">
                                @if($package->list1)
                                <li><i
                                    class="mdi mdi-checkbox-marked-circle-outline p-2 fs-16 text-secondary"></i>{!! $package->list1!!}</li>
                                    @endif

                                    @if($package->list2)

                                    <li><i
                                        class="mdi mdi-checkbox-marked-circle-outline p-2 fs-16 text-secondary"></i>
                                        {!! $package->list2!!}
                                    </li>
                                    @endif
                                    
                                    @if($package->list3)
                                    <li class="text-muted"><i
                                        class="mdi mdi-checkbox-marked-circle-outline p-2 fs-16 text-secondary"></i>{!! $package->list3!!}
                                    </li>
                                    @endif
                                    
                                    @if($package->list4)
                                    <li class="text-muted"><i
                                        class="mdi mdi-checkbox-marked-circle-outline p-2 fs-16 text-secondary"></i>{!!$package->list4!!}

                                    </li>
                                    @endif
                                    
                                    @if($package->list5)

                                    <li class="text-muted"><i
                                        class="mdi mdi-checkbox-marked-circle-outline p-2 fs-16 text-secondary"></i>{!! $package->list5 !!}
                                    </li>
                                    @endif
                                    
                                    @if($package->list6)


                                    <li class="text-muted"><i
                                        class="mdi mdi-checkbox-marked-circle-outline p-2 fs-16 text-secondary"></i>{!! $package->list6!!}
                                    </li>
                                    @endif
                                    
                                    @if($package->list7)

                                    <li class=text-muted"><i
                                        class="mdi mdi-checkbox-marked-circle-outline p-2 fs-16 text-secondary"></i>{!! $package->list7!!}
                                    </li>
                                    @endif

                                    @if($package->list8)
                                    <li class=text-muted"><i
                                        class="mdi mdi-checkbox-marked-circle-outline p-2 fs-16 text-secondary"></i>{!! $package->list8 !!}
                                    </li>
                                    @endif


                                </ul>
                            </div>

                            @guest
                            <div class="card-footer text-center border-top-0 pt-1">

                               @if($package->id == '3')
                               <a href="{{ route('register') }}" class="btn btn-lg btn-outline-secondary btn-block"> Select</a>
                               @else

                               @if(domain_name() == "gondana.com" or domain_name() == "awasam.com" or domain_name() == "localhost" or domain_name() == "writingtailor.com")




    <a href="{{ route('bregister', ['id' => $package->id ]) }}" class="btn btn-lg btn-outline-secondary btn-block"> Buy Now</a>





                                                <!-- edit modal-->
             <div class="modal fade" id="edit-property{{ $package->id }}">

               <div class="modal-dialog modal-dialog-centered" role="document">
                 <div class="modal-content country-select-modal">
                   <div class="modal-header">
                     <h6 class="modal-title">Buy Package #{{ $package->id }}</h6><button aria-label="Close" class="btn-close"
                     data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                   </div>
                   <div class="modal-body">
                     <form class="form-horizontal" action="{{ route('update_package')}}" method="POST">
                       @csrf
                       <input type="hidden" name="id" value="{{ $package->id }}">

                       <div class=" row mb-4">
                         <label class="col-md-3 form-label">Name</label>
                         <div class="col-md-9">
                           <input type="text" class="form-control" name="name" placeholder="Enter your name">
                         </div>
                       </div>

                       <div class=" row mb-4">
                         <label class="col-md-3 form-label">Phone</label>
                         <div class="col-md-9">
                           <input type="text" class="form-control" name="phone" placeholder="Enter your phone">
                         </div>
                       </div>

                    
                

                    <div class=" row mb-4">

                     <div class="col-md-9">
                      <input type="submit" value="Buy Now" class="btn btn-lg btn-outline-secondary btn-block">
                    </div>


                  </div>



                </form>
              </div>
            </div>
          </div>
        </div>

                               @else

                               <form action="{{ route('subscribe_data')}}" method="POST"> 
                                @csrf
                                <input type="hidden" name="package" value="{{ $package->id }}">

                                <button
                                class="btn btn-lg btn-outline-secondary btn-block">
                                <span class="ms-4 me-4">Select</span>
                            </button>
                        </form>
                          @endif
                        @endif
                    </div>

                    @else

                    @if(Auth::user()->account_status=='0')
                    <div class="card-footer text-center border-top-0 pt-1">

                       @if($package->id == '3')
                       <a href="{{ route('register') }}" class="btn btn-lg btn-outline-secondary btn-block"> Select</a>
                       @else

                       <form action="{{ route('subscribe_data')}}" method="POST"> 
                        @csrf
                        <input type="hidden" name="package" value="{{ $package->id }}">

                        <button
                        class="btn btn-lg btn-outline-secondary btn-block">
                        <span class="ms-4 me-4">Select</span>
                    </button>
                </form>
                @endif
            </div>
            @else
            <p>Your account has an active subscription</p>
            @endif

            @endguest




        </div>
    </div>
    @endforeach






</div>
</div>

<!-- ROW-6 CLOSED -->


<div class="row">
       <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
           <div class="card p-3 pricing-card reveal revealrotate">
    <div class="card-body">
      {!! get_option(site_id().'_show_13_content') !!}  
    </div>
   </div>
       </div>
    
</div>
</div>

@endsection


