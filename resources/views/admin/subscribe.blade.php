@extends('layouts.appbar')



@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
   <div class="side-app">

       <!-- CONTAINER -->
       <div class="main-container container-fluid">



        <!-- ROW OPEN -->
        <div class="row row-cards" style="padding-top: 20px;">

          <?php 
$subscriptions = \App\Models\Subscription::whereUserId(Auth::user()->id)->get();
?> 
  <div class="col-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title mb-0">Recent subscriptions</h3>
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
              @if($subscriptions->count()>0)
           


            <div class="row">

              @foreach($subscriptions as $order)
           

              <div class="col-sm-3">
              Start: {{ $order->subscribe_start }}

               </div>

                 <div class="col-sm-3">
            End:  {{ $order->subscribe_end }}

               </div>

                <div class="col-sm-3">
            Plan:  {{ package($order->package_id)->name }}

               </div>

                  <div class="col-sm-3">
            Status:  Expired {{ $order->created_at->diffForHumans() }}

               </div>

            

       
            <hr style="border-top: 1px solid #000000;">


            @endforeach



          </div>




          @else
          <tr>No previous subscriptions</tr>
          @endif
        </div>

      </div>
    </div>
  </div>
</div>
</div>
</div>
        

<h3>Select your suitable plan below</h3>



       <?php
       if(Auth::user()->is_client()){
       $packages = \App\Models\Package::orderBy('id', 'asc')->where('amount', '>', 250)->whereType('plan')->get();
       } else{
   $packages = \App\Models\Package::orderBy('id', 'asc')->where('amount', '>', 250)->whereType('writer')->get();
       }

       ?>



@if(Auth::user()->account_status=='0')
        @foreach($packages as $package)
        <div class="col-lg-4">
                    <div class="card p-3 pricing-card">
                        <div class="card-header d-block text-justified pt-2">
                            <p class="fs-18 fw-semibold mb-1">{{ $package->name }}</p>
                            <p class="text-justify fw-semibold mb-1"> <span
                                class="fs-30 me-2">KES</span><span
                                class="fs-30 me-1">{{ $package->amount }}</span><span
                                class="fs-25"><span
                                class="op-0-5 text-muted text-20">/</span>
                                {{ $package->max_units }}</span>
                            <p class="fs-13 mb-1 text-secondary">Best Writers</p>
                        </div>
                        <div class="card-body pt-2">
                            <ul class="text-justify pricing-body ps-0">
                                 <li><i
                                    class="mdi mdi-checkbox-marked-circle-outline p-2 fs-16 text-secondary"></i>{!! $package->list1!!}</li>
                                    <li><i
                                        class="mdi mdi-checkbox-marked-circle-outline p-2 fs-16 text-secondary"></i>
                                        {!! $package->list2!!}
                                    </li>
                                    <li class="mdi mdi-checkbox-marked-circle-outline p-2 fs-16 text-secondary"></i>{!! $package->list3!!}
                                    </li>
                                    <li class="text-muted"><i
                                        class="mdi mdi-checkbox-marked-circle-outline p-2 fs-16 text-secondary"></i>{!!$package->list4!!}

                                    </li>

                                    <li class="text-muted"><i
                                        class="mdi mdi-checkbox-marked-circle-outline p-2 fs-16 text-secondary"></i>{!! $package->list5 !!}
                                    </li>


                                    <li class="text-muted"><i
                                        class="mdi mdi-checkbox-marked-circle-outline p-2 fs-16 text-secondary"></i>{!! $package->list6!!}
                                    </li>

                                    <li class=text-muted"><i
                                        class="mdi mdi-checkbox-marked-circle-outline p-2 fs-16 text-secondary"></i>{!! $package->list7!!}
                                    </li>
                                    @if($package->list8)
                                        <li class=text-muted"><i
                                        class="mdi mdi-checkbox-marked-circle-outline p-2 fs-16 text-secondary"></i>{!! $package->list8 !!}
                                    </li>
                                    @endif
                                </ul>
                            </div>
                            <div class="card-footer text-center border-top-0 pt-1">

                                 @if($package->id == '3')
                                 
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
                    </div>
                </div>
        @endforeach
        @else
        <p>Your account has an active subscription</p>
         <p> Account expires after  {{ days(Auth::user()->subscribe_end, Auth::user()->subscribe_start)}} days</p>



        @endif






</div>
<!-- ROW CLOSED -->


</div>
</div>
</div>





@endsection