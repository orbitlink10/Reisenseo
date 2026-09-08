     @extends('layouts.appbar')
     <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
     @section('content')      <!--app-content open-->
     <div class="main-content app-content mt-0">
      <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">




          @include('chat_count')

          @if(Auth::user()->is_admin())

          <div class="row" style="margin-top: 20px;">

            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Recent Statistics</h3>
                </div>
                <div class="card-body">
                  <div class="chart-container">
                    <canvas id="chartLine2" class="h-275"></canvas>
                  </div>
                </div>
              </div>
            </div>


            <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Daily Deposits</h3>
                </div>
                <div class="card-body">
                  <div class="chart-container">
                    <canvas id="chartLine10" class="h-275"></canvas>
                  </div>
                </div>
              </div>
            </div>

            <?php
            $order_count = \App\Models\Order::where(DB::raw('date(created_at)'), $date0)->count();
            $order_count1 = \App\Models\Order::where(DB::raw('date(created_at)'), $date1)->count();
            $order_count2 = \App\Models\Order::where(DB::raw('date(created_at)'), $date2)->count();
            $order_count3 = \App\Models\Order::where(DB::raw('date(created_at)'), $date3)->count();
            $order_count4 = \App\Models\Order::where(DB::raw('date(created_at)'), $date4)->count();
            $order_count5 = \App\Models\Order::where(DB::raw('date(created_at)'), $date5)->count();
            $order_count6 = \App\Models\Order::where(DB::raw('date(created_at)'), $date6)->count();
            $order_count7 = \App\Models\Order::where(DB::raw('date(created_at)'), $date7)->count();
            ?>


            <?php
            $payment_count = \App\Models\Payment::where(function($query) use ($date0) {
              $query->where(DB::raw('date(created_at)'), $date0)
              ->where(function($query) {
                $query->where('payment_source', 'TopUp Wallet')
                ->orWhere('payment_source', 'Wallet TopUp')->whereStatus(1);
              });
            })->sum('amount');
            $payment_count1 = \App\Models\Payment::where(function($query) use ($date1) {
              $query->where(DB::raw('date(created_at)'), $date1)
              ->where(function($query) {
                $query->where('payment_source', 'TopUp Wallet')
                ->orWhere('payment_source', 'Wallet TopUp')->whereStatus(1);
              });
            })->sum('amount');
            $payment_count2 = \App\Models\Payment::where(function($query) use ($date2) {
              $query->where(DB::raw('date(created_at)'), $date2)
              ->where(function($query) {
                $query->where('payment_source', 'TopUp Wallet')
                ->orWhere('payment_source', 'Wallet TopUp')->whereStatus(1);
              });
            })->sum('amount');
            $payment_count3 = \App\Models\Payment::where(function($query) use ($date3) {
              $query->where(DB::raw('date(created_at)'), $date3)
              ->where(function($query) {
                $query->where('payment_source', 'TopUp Wallet')
                ->orWhere('payment_source', 'Wallet TopUp')->whereStatus(1);
              });
            })->sum('amount');
            $payment_count4 = \App\Models\Payment::where(function($query) use ($date4) {
              $query->where(DB::raw('date(created_at)'), $date4)
              ->where(function($query) {
                $query->where('payment_source', 'TopUp Wallet')
                ->orWhere('payment_source', 'Wallet TopUp')->whereStatus(1);
              });
            })->sum('amount');
            $payment_count5 = \App\Models\Payment::where(function($query) use ($date5) {
              $query->where(DB::raw('date(created_at)'), $date5)
              ->where(function($query) {
                $query->where('payment_source', 'TopUp Wallet')
                ->orWhere('payment_source', 'Wallet TopUp')->whereStatus(1);
              });
            })->sum('amount');
            $payment_count6 = \App\Models\Payment::where(function($query) use ($date6) {
              $query->where(DB::raw('date(created_at)'), $date6)
              ->where(function($query) {
                $query->where('payment_source', 'TopUp Wallet')
                ->orWhere('payment_source', 'Wallet TopUp')->whereStatus(1);
              });
            })->sum('amount');
            $payment_count7 = \App\Models\Payment::where(function($query) use ($date7) {
              $query->where(DB::raw('date(created_at)'), $date7)
              ->where(function($query) {
                $query->where('payment_source', 'TopUp Wallet')
                ->orWhere('payment_source', 'Wallet TopUp')->whereStatus(1);
              });
            })->sum('amount');
            
            ?>


            <?php
            $user_count = \App\Models\User::whereUserType('client')->where(DB::raw('date(created_at)'), $date0)->count();
            $user_count1 = \App\Models\User::whereUserType('client')->where(DB::raw('date(created_at)'), $date1)->count();
            $user_count2 = \App\Models\User::whereUserType('client')->where(DB::raw('date(created_at)'), $date2)->count();
            $user_count3 = \App\Models\User::whereUserType('client')->where(DB::raw('date(created_at)'), $date3)->count();
            $user_count4 = \App\Models\User::whereUserType('client')->where(DB::raw('date(created_at)'), $date4)->count();
            $user_count5 = \App\Models\User::whereUserType('client')->where(DB::raw('date(created_at)'), $date5)->count();
            $user_count6 = \App\Models\User::whereUserType('client')->where(DB::raw('date(created_at)'), $date6)->count();
            $user_count7 = \App\Models\User::whereUserType('client')->where(DB::raw('date(created_at)'), $date7)->count();
            ?>  

            <?php
            $suser_count = \App\Models\Payment::wherePaymentSource('subscription')->whereStatus(1)->where(DB::raw('date(created_at)'), $date0)->count();
            $suser_count1 = \App\Models\Payment::wherePaymentSource('subscription')->whereStatus(1)->where(DB::raw('date(created_at)'), $date1)->count();
            $suser_count2 = \App\Models\Payment::wherePaymentSource('subscription')->whereStatus(1)->where(DB::raw('date(created_at)'), $date2)->count();
            $suser_count3 = \App\Models\Payment::wherePaymentSource('subscription')->whereStatus(1)->where(DB::raw('date(created_at)'), $date3)->count();
            $suser_count4 = \App\Models\Payment::wherePaymentSource('subscription')->whereStatus(1)->where(DB::raw('date(created_at)'), $date4)->count();
            $suser_count5 = \App\Models\Payment::wherePaymentSource('subscription')->whereStatus(1)->where(DB::raw('date(created_at)'), $date5)->count();
            $suser_count6 = \App\Models\Payment::wherePaymentSource('subscription')->whereStatus(1)->where(DB::raw('date(created_at)'), $date6)->count();
            $suser_count7 = \App\Models\Payment::wherePaymentSource('subscription')->whereStatus(1)->where(DB::raw('date(created_at)'), $date7)->count();

            $suser_countsum = \App\Models\Payment::wherePaymentSource('subscription')->whereStatus(1)->where(DB::raw('date(created_at)'), $date0)->sum('amount');
            $suser_countsum1 = \App\Models\Payment::wherePaymentSource('subscription')->whereStatus(1)->where(DB::raw('date(created_at)'), $date1)->sum('amount');
            $suser_countsum2 = \App\Models\Payment::wherePaymentSource('subscription')->whereStatus(1)->where(DB::raw('date(created_at)'), $date2)->sum('amount');
            $suser_countsum3 = \App\Models\Payment::wherePaymentSource('subscription')->whereStatus(1)->where(DB::raw('date(created_at)'), $date3)->sum('amount');
            $suser_countsum4 = \App\Models\Payment::wherePaymentSource('subscription')->whereStatus(1)->where(DB::raw('date(created_at)'), $date4)->sum('amount');
            $suser_countsum5 = \App\Models\Payment::wherePaymentSource('subscription')->whereStatus(1)->where(DB::raw('date(created_at)'), $date5)->sum('amount');
            $suser_countsum6 = \App\Models\Payment::wherePaymentSource('subscription')->whereStatus(1)->where(DB::raw('date(created_at)'), $date6)->sum('amount');
            $suser_countsum7 = \App\Models\Payment::wherePaymentSource('subscription')->whereStatus(1)->where(DB::raw('date(created_at)'), $date7)->sum('amount');


            $payment_count  = $payment_count + $suser_countsum;
            $payment_count1 = $payment_count1 + $suser_countsum1;
            $payment_count2 = $payment_count2 + $suser_countsum2;
            $payment_count3 = $payment_count3 + $suser_countsum3;
            $payment_count4 = $payment_count4 + $suser_countsum4;
            $payment_count5 = $payment_count5 + $suser_countsum5;
            $payment_count6 = $payment_count6 + $suser_countsum6;
            $payment_count7 = $payment_count7 + $suser_countsum7;


            $credit_totals_by_date = \App\Models\Payment::where('status', '1')
            ->where(function ($query) {
              $query->whereIn('payment_source', ['TopUp Wallet', 'Wallet TopUp', 'Admin Wallet TopUp','custom invoice', 'subscription', 'Order Refund']);
            })
            ->selectRaw('payment_source, DATE(created_at) as date, SUM(amount) as total_amount')
    ->groupBy('payment_source', 'date', 'created_at') // Add created_at to the GROUP BY clause
    ->orderBy('date')
    ->get();


    ?>  



    <div>
      <?php
      $credit_totals_by_date = \App\Models\Payment::where('status', '1')
      ->where(function ($query) {
        $query->whereIn('payment_source', ['TopUp Wallet', 'Wallet TopUp', 'Admin Wallet TopUp','custom invoice', 'subscription', 'Order Refund']);
      })
      ->selectRaw('payment_source, DATE(created_at) as date, SUM(amount) as total_amount')
    ->groupBy('payment_source', 'date', 'created_at') // Add created_at to the GROUP BY clause
    ->orderBy('date')
    ->get();


    ?>  



       <div class="col-lg-12 col-md-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Transaction Trends by Payment Source</h3>
                </div>
                <div class="card-body">
    <div class="row justify-content-between">
        <button class="btn btn-primary col-auto" id="previousButton">Previous</button>
        <input type="range" min="0" max="100" value="0" id="slider" class="custom-range col-8">
        <button class="btn btn-primary col-auto" id="nextButton">Next</button>
    </div>
    <canvas id="depositChart" width="800" height="400" class="mt-4"></canvas>
                </div>
              </div>
            </div>





<script>
    var data = <?php echo json_encode($credit_totals_by_date); ?>;
    
    var dates = [];
    var datasets = {};
    var windowSize = 30;  // Change this to your desired window size
    var slider = document.getElementById("slider");

    data.forEach(item => {
        if (!dates.includes(item.date)) {
            dates.push(item.date);
        }

        if (!datasets[item.payment_source]) {
            datasets[item.payment_source] = {
                label: item.payment_source,
                data: [],
                borderColor: getRandomColor(),
                fill: false,
            };
        }

        datasets[item.payment_source].data.push(item.total_amount);
    });

    dates = [...dates].reverse();
    Object.values(datasets).forEach(dataset => {
        dataset.data = [...dataset.data].reverse();
    });

    // Initialize the slider max value with the length of dates
    slider.max = dates.length - windowSize;

    var ctx = document.getElementById('depositChart').getContext('2d');
    var myChart;

    function updateChart() {
        if (myChart) {
            myChart.destroy();
        }

        var windowStart = parseInt(slider.value);

        myChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: dates.slice(windowStart, windowStart + windowSize),
                datasets: Object.values(datasets).map(dataset => ({
                    ...dataset,
                    data: dataset.data.slice(windowStart, windowStart + windowSize)
                })),
            },
            // options remain the same...
        });
    }

    updateChart();

    // Update the chart when the slider changes
    slider.oninput = function() {
        updateChart();
    };

    document.getElementById('previousButton').onclick = function() {
        slider.value = Math.min(parseInt(slider.value) + 1, dates.length - windowSize);
        updateChart();
    };

    document.getElementById('nextButton').onclick = function() {
        slider.value = Math.max(parseInt(slider.value) - 1, 0);
        updateChart();
    };

    function getRandomColor() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
</script>



  <?php

  $users = \App\Models\User::whereUserType('admin')->get();

  ?>

  <div class="row" style="margin-top: 20px;">
    <div class="col-md-12">
      <div class="card" style="margin-bottom: 30px;">

        <div class="table-content table-responsive shadow-md">
          <table class="table  bg-white rounded-xxl ">

            <tbody>
             <thead>
               <tr>
                <th>Admins</th>
                <th>Today Post</th>
                <th>Previous Day</th>
                <th>2 Days Ago</th>
                <th>3 Days Ago</th>
                <th>4 Days Ago</th>
                <th>5 Days Ago</th>
                <th>6 Days Ago</th>
                <th>7 Days Ago</th>

              </tr>


              @foreach($users as $user)
              <?php
              $Page_count = \App\Models\Post::whereWriterId($user->id)->where(DB::raw('date(created_at)'), $date0)->count();
              $Page_count1 = \App\Models\Post::whereWriterId($user->id)->where(DB::raw('date(created_at)'), $date1)->count();

              $Page_count2 = \App\Models\Post::whereWriterId($user->id)->where(DB::raw('date(created_at)'), $date2)->count();

              $Page_count3 = \App\Models\Post::whereWriterId($user->id)->where(DB::raw('date(created_at)'), $date3)->count();

              $Page_count4 = \App\Models\Post::whereWriterId($user->id)->where(DB::raw('date(created_at)'), $date4)->count();

              $Page_count5 = \App\Models\Post::whereWriterId($user->id)->where(DB::raw('date(created_at)'), $date5)->count();

              $Page_count6 = \App\Models\Post::whereWriterId($user->id)->where(DB::raw('date(created_at)'), $date6)->count();

              $Page_count7 = \App\Models\Post::whereWriterId($user->id)->where(DB::raw('date(created_at)'), $date7)->count();


              ?>  
              <tr>
               <td>{{ $user->name}}</td>
               <td>{{ $Page_count }}</td>
               <td>{{ $Page_count1 }}</td>
               <td>{{ $Page_count2 }}</td>
               <td>{{ $Page_count3 }}</td>
               <td>{{ $Page_count4 }}</td>

               <td>{{ $Page_count5 }}</td>
               <td>{{ $Page_count6 }}</td>
               <td>{{ $Page_count7 }}</td>


             </tr>



             @endforeach

           </thead>
         </tbody>
       </table>
     </div>

   </div>





 </div>
</div>


@endif




@if(Auth::user()->is_client() or Auth::user()->is_student())






<!-- ROW-1 -->
<div class="row">

  <div class="col-lg-12 col-md-12">
    <div class="card">
      <div class="card-header">
       <h1 class="page-title">Thank you for signing up! We are happy to have you on board!</h1>
     </div>
     <div class="card-body">
      <div class="chart-container">
        <canvas id="chartLine2" class="h-275"></canvas>
      </div>
    </div>
  </div>
</div>

<?php
$order_count = \App\Models\Order::whereUserId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date0)->count();
$order_count1 = \App\Models\Order::whereUserId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date1)->count();
$order_count2 = \App\Models\Order::whereUserId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date2)->count();
$order_count3 = \App\Models\Order::whereUserId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date3)->count();
$order_count4 = \App\Models\Order::whereUserId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date4)->count();
$order_count5 = \App\Models\Order::whereUserId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date5)->count();
$order_count6 = \App\Models\Order::whereUserId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date6)->count();
$order_count7 = \App\Models\Order::whereUserId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date7)->count();
?>





<div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
  <div class="card-body ">


    <div class="example">

      @if(Auth::user()->is_client())

      @if(Auth::user()->account_status == '0')

      @if(domain_name() == 'saseni.com')

      <div style="display: {{ get_option(site_id().'_enable_dc') == 1 ? 'block' : 'none' }}" class="border border-secondary p-5 br-5">
        <span class="badge bg-secondary fs-14 me-2">Note:</span>
        <span> You don't have an active subscription. You will be charged 3% of every order you post. Kindly click below button to subscribe. </span>



        <a href="{{ route('subscribe')}}" class="btn btn-warning"> <span>Get a Premium account</span>

        </a>

        <a href="{{ route('add_order')}}" class="btn btn-primary mt-1 mb-1 me-3">
          <span>Place New Order</span>
        </a>

      </div>
      @endif

      @else
      <div class="border border-secondary p-5 br-5" style="display: {{ get_option(site_id().'_enable_dc') == 1 ? 'block' : 'none' }}">
        <span class="badge bg-secondary fs-14 me-2">Hurry Up!</span>
        <span>Your subscription ends after </span>
        <span id="timer-outputpattern" class="h3 text-secondary">
          <p id="demo3"></p>
        </span>

        <a href="{{ route('add_order')}}" class="btn btn-primary mt-1 mb-1 me-3">
          <span>Place New Order</span>
        </a>
      </div>
      @endif

      @endif

    </div>
  </div>


</div>

<div class="alert alert-info" style="display: {{ get_option(site_id().'_enable_dc') == 1 ? 'block' : 'none' }}">
  Note that the writers can only bid on an order when its in available status. Always CONFIRM all your orders in pending status ASAP before time runs out
</div>
</div>
<!-- ROW-1 END -->

@endif



<!-- ROW-4 -->
<div class="row" style="padding-top: 20px;">


  @if(Auth::user()->is_client() or Auth::user()->is_student())
  <div class="col-lg-8 col-md-12 col-sm-12">
    <div class="card">
      <div class="card-header">
        <h3 class="card-title mb-0">Recent approved orders with writers not rated</h3>



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

                @foreach($orders as $order)

                <div class="col-sm-2">
                  <div class="mt-0 mt-sm-2 d-block">
                    <h6
                    class="mb-0 fs-14 fw-semibold">
                    #{{ $order->id}}</h6>
                  </div>
                </div>

                <div class="col-sm-4">
                  <a href="{{ route('view_order', $order->slug )}}">
                    {{ \Illuminate\Support\Str::limit($order->title, 50, '...') }}</a><br>
                    <span style="font-size: 10px; color: green;">
                     @if(Auth::user()->is_client() or Auth::user()->is_admin() or Auth::user()->is_student())
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

                 <div class="col-sm-2">
                  <div class="mt-0 mt-sm-1 d-block">
                    @if($order->word_count)
                    <span style="font-size: 11px;" class="fw-semibold mt-sm-2 d-block"  >{{ $order->word_count }} 
                      @if($order->word_count == 1) page @else pages @endif

                      @endif

                      @if($order->slide)
                      {{ $order->slide }} 
                      @if($order->slide == 1) slide @else slides @endif
                    </span>
                    @endif
                  </div>

                </div>
                @if(Auth::user()->is_admin())
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

                @if(Auth::user()->is_admin())
                <div class="col-sm-1">
                  <span
                  class="fw-semibold mt-sm-2 d-block"><a href="{{ route('user_info', $order->user_id )}}">#{{ $order->user_id }}</a></span>

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




                    <a href="{{ route('view_order', $order->slug )}}" class="btn btn-sm btn-success badge"><i class="fa fa-eye"></i> Rate writer
                    </a>



                  </div>

                </div>


                <hr style="border-top: 1px solid #000000;">


                @endforeach



              </div>




              @else
              <tr>No order available</tr>
              @endif
            </div>

          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="col-lg-4 col-md-12 col-sm-12">

 <?php 
 $ratings_count = \App\Models\Review_rating::whereUserId(Auth::user()->id)->count();
 $ratings = \App\Models\Review_rating::whereUserId(Auth::user()->id)->limit(10)->orderBy('id', 'desc')->get();
 ?> 


 @if($ratings->count()>0)

 <h3 class="card-title mb-0">My recent reviews <span class="badge bg-secondary fs-14 me-2">{{ $ratings_count }} review </span></h3>


 @foreach($ratings as $rate)

 <div class="card">

  <div class="card-body">
    <?php 
    $order = \App\Models\Order::find($rate->order_id); 
    $order_count = \App\Models\Order::whereId($rate->order_id)->get();
    ?> 
    @if($order_count->count() > 0)
    <div class="row">
      <div class="col-lg-8 col-md-12 col-sm-12">
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

        <div class="col-lg-8 col-md-12 col-sm-12">


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

@endif


@if(Auth::user()->is_editor())


<div class="col-lg-12 col-md-12">
  <div class="card">
    <div class="card-header">
     <h1 class="page-title">Order Statistics</h1>
   </div>
   <div class="card-body">
    <div class="chart-container">
      <canvas id="chartLine2" class="h-275"></canvas>
    </div>
  </div>
</div>
</div>

<?php
$order_count  = \App\Models\Order::whereEditorId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date0)->count();
$order_count1 = \App\Models\Order::whereEditorId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date1)->count();
$order_count2 = \App\Models\Order::whereEditorId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date2)->count();
$order_count3 = \App\Models\Order::whereEditorId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date3)->count();
$order_count4 = \App\Models\Order::whereEditorId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date4)->count();
$order_count5 = \App\Models\Order::whereEditorId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date5)->count();
$order_count6 = \App\Models\Order::whereEditorId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date6)->count();
$order_count7 = \App\Models\Order::whereEditorId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date7)->count();
?>


<div class="col-lg-8 col-md-12 col-sm-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title mb-0">Recent approved orders with writers not rated</h3>



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

              @foreach($orders as $order)

              <div class="col-sm-2">
                <div class="mt-0 mt-sm-2 d-block">
                  <h6
                  class="mb-0 fs-14 fw-semibold">
                  #{{ $order->id}}</h6>
                </div>
              </div>

              <div class="col-sm-4">
                <a href="{{ route('view_order', $order->slug )}}">
                  {{ \Illuminate\Support\Str::limit($order->title, 50, '...') }}</a><br>
                  <span style="font-size: 10px; color: green;">
                   @if(Auth::user()->is_client() or Auth::user()->is_admin() or Auth::user()->is_student())
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

               <div class="col-sm-2">
                <div class="mt-0 mt-sm-1 d-block">
                  @if($order->word_count)
                  <span style="font-size: 11px;" class="fw-semibold mt-sm-2 d-block"  >{{ $order->word_count }} 
                    @if($order->word_count == 1) page @else pages @endif

                    @endif

                    @if($order->slide)
                    {{ $order->slide }} 
                    @if($order->slide == 1) slide @else slides @endif
                  </span>
                  @endif
                </div>

              </div>
              @if(Auth::user()->is_admin())
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

              @if(Auth::user()->is_admin())
              <div class="col-sm-1">
                <span
                class="fw-semibold mt-sm-2 d-block"><a href="{{ route('user_info', $order->user_id )}}">#{{ $order->user_id }}</a></span>

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




                  <a href="{{ route('view_order', $order->slug )}}" class="btn btn-sm btn-success badge"><i class="fa fa-eye"></i> Rate writer
                  </a>



                </div>

              </div>


              <hr style="border-top: 1px solid #000000;">


              @endforeach



            </div>




            @else
            <tr>No order available</tr>
            @endif
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
</div>


<div class="col-lg-4 col-md-12 col-sm-12">

 <?php 
 $ratings_count = \App\Models\Review_rating::whereUserId(Auth::user()->id)->count();
 $ratings = \App\Models\Review_rating::whereUserId(Auth::user()->id)->limit(10)->orderBy('id', 'desc')->get();
 ?> 

 
 @if($ratings->count()>0)

 <h3 class="card-title mb-0">My recent reviews <span class="badge bg-secondary fs-14 me-2">{{ $ratings_count }} review </span></h3>


 @foreach($ratings as $rate)

 <div class="card">

  <div class="card-body">
    <?php 
    $order = \App\Models\Order::find($rate->order_id); 
    ?> 
    @if($order->count() > 0)
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
</div>

@endif


@if(Auth::user()->is_writer())

<div class="col-lg-12 col-md-12">
  <div class="card">
    <div class="card-header">
     <h1 class="page-title">Thank you for signing up! We are happy to have you on board!</h1>
   </div>
   <div class="card-body">
    <div class="chart-container">
      <canvas id="chartLine2" class="h-275"></canvas>
    </div>
  </div>
</div>



</div>

<?php
$order_count  = \App\Models\Order::whereWriterId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date0)->count();
$order_count1 = \App\Models\Order::whereWriterId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date1)->count();
$order_count2 = \App\Models\Order::whereWriterId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date2)->count();
$order_count3 = \App\Models\Order::whereWriterId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date3)->count();
$order_count4 = \App\Models\Order::whereWriterId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date4)->count();
$order_count5 = \App\Models\Order::whereWriterId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date5)->count();
$order_count6 = \App\Models\Order::whereWriterId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date6)->count();
$order_count7 = \App\Models\Order::whereWriterId(Auth::user()->id)->where(DB::raw('date(created_at)'), $date7)->count();
?>

<div class="col-lg-8 col-md-12 col-sm-12">
  <div class="card">
    <div class="card-header">
      <h3 class="card-title mb-0">Recent orders</h3>



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
                   @if(Auth::user()->is_client() or Auth::user()->is_admin() or Auth::user()->is_student())
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

               <div class="col-sm-2">
                <div class="mt-0 mt-sm-1 d-block">
                  @if($order->word_count)
                  <span style="font-size: 11px;" class="fw-semibold mt-sm-2 d-block"  >{{ $order->word_count }} 
                    @if($order->word_count == 1) page @else pages @endif

                    @endif

                    @if($order->slide)
                    {{ $order->slide }} 
                    @if($order->slide == 1) slide @else slides @endif
                  </span>
                  @endif
                </div>

              </div>
              @if(Auth::user()->is_admin())
              <div class="col-sm-2">
                <span
                class="fw-semibold mt-sm-2 d-block">{{price( (int) $order->ccost)}}</span>

              </div>
              @endif
              @if(Auth::user()->is_editor())
              <div class="col-sm-2">
                <span
                class="fw-semibold mt-sm-2 d-block">{{price((int) $order->ecost)}}</span>

              </div>
              @endif

              @if(Auth::user()->is_writer())
              <div class="col-sm-2">
                <span
                class="fw-semibold mt-sm-2 d-block">{{price((int) $order->wcost)}}</span>

              </div>
              @endif

              @if(Auth::user()->is_admin())
              <div class="col-sm-1">
                <span
                class="fw-semibold mt-sm-2 d-block"><a href="{{ route('user_info', $order->user_id )}}">#{{ $order->user_id }}</a></span>

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




              <hr style="border-top: 1px solid #000000;">


              @endforeach



            </div>




            @else
            <tr>No order available</tr>
            @endif
          </div>

        </div>
      </div>
    </div>
  </div>
</div>
</div>


<div class="col-lg-4 col-md-12 col-sm-12">

 <?php 
 $ratings_count = \App\Models\Review_rating::whereWriterId(Auth::user()->id)->count();
 $ratings = \App\Models\Review_rating::whereWriterId(Auth::user()->id)->limit(10)->orderBy('id', 'desc')->get();
 ?> 

 
 @if($ratings->count()>0)

 <h3 class="card-title mb-0">My recent reviews <span class="badge bg-secondary fs-14 me-2">{{ $ratings_count }} review </span></h3>


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

        @if($rate->gstar_rating)
        >Grammar score {{ number_format((float)$rate->gstar_rating/5*100, 2, '.', '')  }}%<br>
        @endif
        @if($rate->fstar_rating)
        >Following Instructions {{ number_format((float)$rate->fstar_rating/5*100, 2, '.', '')  }}%<br>
        @endif
        @if($rate->kstar_rating)
        >Keeping Deadline {{ number_format((float)$rate->kstar_rating/5*100, 2, '.', '')  }}%<br>
        @endif
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



          Average quality score  {{ number_format((float)$rate->star_rating*100, 2, '.', '')  }}%<br>

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

@endif



<!-- ROW-4 END -->
</div>
<!-- CONTAINER END -->
</div>
</div>
<!--app-content close-->
@endsection

@section('page-js')


@if(Auth::user()->is_admin())
<script>

  $(function() {
    "use strict";

    /*LIne-Chart */
    var ctx = document.getElementById("chartLine2").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["Today", "Previous Day", "2 Days Ago", "3 Days Ago", "4 Days Ago", "5 Days Ago", "6 Days Ago", "7 Days Ago"],
        datasets: [{
          label: 'Users',
          data: ["{{ $user_count }}", "{{ $user_count1 }}", "{{ $user_count2 }}", "{{ $user_count3 }}", "{{ $user_count4 }}"," {{ $user_count5 }}", "{{ $user_count6 }}", "{{ $user_count7 }}"],
          borderWidth: 2,
          backgroundColor: 'transparent',
          borderColor: '#6c5ffc',
          borderWidth: 3,
          pointBackgroundColor: '#ffffff',
          pointRadius: 2
        }, {
          label: 'Orders',
          data: ["{{ $order_count }}", "{{ $order_count1 }}", "{{ $order_count2 }}", "{{ $order_count3 }}", "{{ $order_count4 }}", "{{ $order_count5 }}", "{{ $order_count6 }}", "{{ $order_count7 }}"],
          borderWidth: 2,
          backgroundColor: 'transparent',
          borderColor: '#05c3fb',
          borderWidth: 3,
          pointBackgroundColor: '#ffffff',
          pointRadius: 2
        }, {
          label: 'Subscriptions',
          data: ["{{ $suser_count }}", "{{ $suser_count1 }}", "{{ $suser_count2 }}", "{{ $suser_count3 }}", "{{ $suser_count4 }}", "{{ $suser_count5 }}", "{{ $suser_count6 }}", "{{ $suser_count7 }}"],
          borderWidth: 2,
          backgroundColor: 'transparent',
          borderColor: '#09AD95',
          borderWidth: 3,
          pointBackgroundColor: '#ffffff',
          pointRadius: 2
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,

        scales: {
          xAxes: [{
            ticks: {
              fontColor: "#9ba6b5",
            },
            display: true,
            gridLines: {
              color: 'rgba(119, 119, 142, 0.2)'
            }
          }],
          yAxes: [{
            ticks: {
              fontColor: "#9ba6b5",
            },
            display: true,
            gridLines: {
              color: 'rgba(119, 119, 142, 0.2)'
            },
            scaleLabel: {
              display: false,
              labelString: 'Thousands',
              fontColor: 'rgba(119, 119, 142, 0.2)'
            }
          }]
        },
        legend: {
          labels: {
            fontColor: "#9ba6b5"
          },
        },
      }
    });



  });

</script>

<script>

  $(function() {
    "use strict";

    /*LIne-Chart */
    var ctx = document.getElementById("chartLine10").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["Today", "Previous Day", "2 Days Ago", "3 Days Ago", "4 Days Ago", "5 Days Ago", "6 Days Ago", "7 Days Ago"],
        datasets: [{
          label: 'Payments',
          data: ["{{ $payment_count }}", "{{ $payment_count1 }}", "{{ $payment_count2 }}", "{{ $payment_count3 }}", "{{ $payment_count4 }}"," {{ $payment_count5 }}", "{{ $payment_count6 }}", "{{ $payment_count7 }}"],
          borderWidth: 2,
          backgroundColor: 'transparent',
          borderColor: '#6c5ffc',
          borderWidth: 3,
          pointBackgroundColor: '#ffffff',
          pointRadius: 2
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,

        scales: {
          xAxes: [{
            ticks: {
              fontColor: "#9ba6b5",
            },
            display: true,
            gridLines: {
              color: 'rgba(119, 119, 142, 0.2)'
            }
          }],
          yAxes: [{
            ticks: {
              fontColor: "#9ba6b5",
            },
            display: true,
            gridLines: {
              color: 'rgba(119, 119, 142, 0.2)'
            },
            scaleLabel: {
              display: false,
              labelString: 'Thousands',
              fontColor: 'rgba(119, 119, 142, 0.2)'
            }
          }]
        },
        legend: {
          labels: {
            fontColor: "#9ba6b5"
          },
        },
      }
    });



  });

</script>
@endif

@if(Auth::user()->is_client() or Auth::user()->is_student() or Auth::user()->is_editor() or Auth::user()->is_writer())
<script>

  $(function() {
    "use strict";

    /*LIne-Chart */
    var ctx = document.getElementById("chartLine2").getContext('2d');
    var myChart = new Chart(ctx, {
      type: 'line',
      data: {
        labels: ["Today", "Previous Day", "2 Days Ago", "3 Days Ago", "4 Days Ago", "5 Days Ago", "6 Days Ago", "7 Days Ago"],
        datasets: [{
          label: 'Orders',
          data: ["{{ $order_count }}", "{{ $order_count1 }}", "{{ $order_count2 }}", "{{ $order_count3 }}", "{{ $order_count4 }}", "{{ $order_count5 }}", "{{ $order_count6 }}", "{{ $order_count7 }}"],
          borderWidth: 2,
          backgroundColor: 'transparent',
          borderColor: '#05c3fb',
          borderWidth: 3,
          pointBackgroundColor: '#ffffff',
          pointRadius: 2
        }]
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,

        scales: {
          xAxes: [{
            ticks: {
              fontColor: "#9ba6b5",
            },
            display: true,
            gridLines: {
              color: 'rgba(119, 119, 142, 0.2)'
            }
          }],
          yAxes: [{
            ticks: {
              fontColor: "#9ba6b5",
            },
            display: true,
            gridLines: {
              color: 'rgba(119, 119, 142, 0.2)'
            },
            scaleLabel: {
              display: false,
              labelString: 'Thousands',
              fontColor: 'rgba(119, 119, 142, 0.2)'
            }
          }]
        },
        legend: {
          labels: {
            fontColor: "#9ba6b5"
          },
        },
      }
    });



  });

</script>
@endif

<script>
// Set the date we're counting down to
  var countDownDate = new Date("{{ Auth::user()->subscribe_end }}").getTime();

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

  // Output the result in an element with id="demo2"
    document.getElementById("demo3").innerHTML = days + "d " + hours + "h "
    + minutes + "m " + seconds + "s ";

  // If the count down is over, write some text 
    if (distance < 0) {
      clearInterval(x);
      document.getElementById("demo3").innerHTML = "EXPIRED";
    }
  }, 1000);
</script>

@endsection