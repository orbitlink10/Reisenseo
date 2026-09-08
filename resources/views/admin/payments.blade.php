@extends('layouts.appbar')

@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
   <div class="side-app">

       <!-- CONTAINER -->
       <div class="main-container container-fluid">



        <!-- ROW OPEN -->
        <div class="row row-cards" style="padding-top: 20px;">
           <div class="col-lg-7 col-xl-7">


               <div class="card">
                   <div class="card-header border-bottom-0">
                       <h2 class="card-title">Recent Trasaction</h2>

                       <div class="page-options ms-auto">
                        <!-- Wallet {{ price(username(Auth::user()->id)->wallet) }} -->
                    </div>

                </div>
                <div class="e-table px-5 pb-5">
                   <div class="table-responsive table-lg">
                       <table class="table border-top table-bordered mb-0">
                           <thead>
                               <tr>
                                   <th class="text-center">
                                       ID
                                   </th>

                                   <th>Pay Reason</th>
                                   @if(Auth::user()->is_admin())
                                   <th>User Id</th>
                                   @endif
                                   <th>Debit</th>
                                   <th>Credit</th>

                                   <th>Balance</th>
                                   <th></th>

                               </tr>
                           </thead>
                           <tbody>

                            <?php
                            $debit_total = 0;
                            $credit_total = 0;
                            $total = 0;
                            ?>


                            @if($payments->count()>0)
                            @foreach($payments as $property)
                            <?php
                            $total   = $total +$property->balance;
                            $user_id = $property->user_id;
                            ?>


                            <tr>
                               <td class="align-middle text-center">

                                   #{{ $property->id }}
                               </td>

                               <td class="text-nowrap align-middle">{{ $property->payment_source }}  {{ $property->order_id}}<br>
                                 <span style="font-size: 10px;">{!! $property->created_at !!}</span></td>
                                 @if(Auth::user()->is_admin())
                                 <td  class="text-nowrap align-middle"><a target="_blank" href="{{ route('user_info', $property->user_id )}}">{{ $property->user_id }}</a>

                                 </td>

                                 @endif
                                 <td class="text-nowrap align-middle">
                                    <span>

                                        @if($property->payment_source == 'Order paid' or $property->payment_source == 'Pay Later'  or $property->payment_source == 'invoice paid' or $property->payment_source == 'Wallet Deduction' or $property->payment_source == 'custom invoice wallet deduction')

                                        {{price($property->amount)}}


                                        <?php

                                        $debit_total = $debit_total + $property->amount;
                                        ?>

                                        @endif

                                    </span>
                                </td>




                                <td class="text-nowrap align-middle">
                                    <span>

                                        @if($property->payment_source == 'TopUp Wallet' or $property->payment_source == 'Wallet TopUp' or $property->payment_source == 'Admin Wallet TopUp'  or $property->payment_source == 'account balancing' or $property->payment_source == 'custom invoice' or $property->payment_source == 'Order Refund')
                                        {{price($property->amount)}}

                                        <?php
                                        $credit_total = $credit_total +$property->amount;
                                        ?>
                                        @endif
                                    </span>
                                </td>



                                
                                <td class="align-middle text-center">

                                   {{ $property->balance }}
                               </td>

                               @if(Auth::user()->is_admin())
                               <td class="text-center align-middle">
                                   <div class="btn-group align-top">

                                       <a class="btn btn-sm btn-primary badge" data-bs-target="#edit-property{{ $property->id }}" data-bs-toggle="modal"><i class="fa fa-edit"></i> Edit</a> 



                                   </div>
                               </td>
                               @endif

                               

                           </tr>




                           <!-- edit modal-->
                           <div class="modal fade" id="edit-property{{ $property->id }}">
                               <div class="modal-dialog modal-dialog-centered" role="document">
                                   <div class="modal-content country-select-modal">
                                       <div class="modal-header">
                                           <h6 class="modal-title">Edit Package #{{ $property->id }}</h6><button aria-label="Close" class="btn-close"
                                           data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                                       </div>
                                       <div class="modal-body">
                                           <form class="form-horizontal" action="{{ route('update_package')}}" method="POST">
                                               @csrf
                                               <input type="hidden" name="id" value="{{ $property->id }}">
                                               <div class=" row mb-4">
                                                   <label class="col-md-3 form-label">Name</label>
                                                   <div class="col-md-9">
                                                       <input type="text" class="form-control" name="name" value="{{ $property->name }}">
                                                   </div>
                                               </div>

                                               <div class=" row mb-4">
                                                   <label class="col-md-3 form-label">Amount ({{Auth::user()->currency_sign}})</label>
                                                   <div class="col-md-9">
                                                       <input type="text" class="form-control" name="amount" value="{{ $property->amount }}">
                                                   </div>


                                               </div>
                                               <div class=" row mb-4">
                                                   <label class="col-md-3 form-label">Maximum Units</label>
                                                   <div class="col-md-9">
                                                       <input type="text" class="form-control" name="max_units" value="{{ $property->max_units }}">
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
                          <!-- Country-selector modal-->



                          @endforeach

                          <tr>
                           <td class="align-middle text-center"></td>
                           <td class="align-middle text-center"></td>
                           @if(Auth::user()->is_admin())
                           <td class="align-middle text-center"></td>
                           @endif
                           <td>{{ price($debit_total)}}</td>
                           <td>{{ price($credit_total)}}</td>
                           <td>{{ price(wallet($user_id))}}
                           </td>
                           <td>
                           </td>

                       </tr>
                       @else
                       <tr>No recent trasaction</tr>
                       @endif



                   </tbody>
               </table>
           </div>
       </div>
   </div>



   <div class="mb-5">

       <div class="float-end">

         {{$payments->links("pagination::bootstrap-4")}}

     </div>
 </div>
</div>
<!-- COL-END -->

<div class="col-lg-5 col-xl-5">

 <div class="card">
   <div class="card-header">
       <h4 class="card-title">Add funds</h4>


   </div>
   <div class="card-body">
       <form class="form-horizontal" action="{{ route('add_fund')}}" method="POST">
           @csrf




           <div class=" row mb-4">
            <label class="col-md-3 form-label">Amount</label>
            <div class="col-md-9">
              <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid phone is required: 0725000000">
                <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                 {{ get_option(site_id().'_currency_sign') }}
             </a>
             <input class="input100 border-start-0 ms-0 form-control" name="amount" type="text" value="0">
         </div>
     </div>
 </div>


 <div class=" row mb-4">

   <div class="col-md-9">
      <input type="submit" value="Proceed" class="btn btn-primary">
  </div>


</div>



</form>
</div>
</div>


<?php 
// aproved orders
$aorders_sum   = \App\Models\Order::whereUserId(Auth::user()->id)->whereStatus(5)->sum('ccost'); 
$aorders_count = \App\Models\Order::whereUserId(Auth::user()->id)->whereStatus(5)->count(); 


// completed orders
$corders_sum   = \App\Models\Order::whereUserId(Auth::user()->id)->whereStatus(4)->sum('ccost'); 
$corders_count = \App\Models\Order::whereUserId(Auth::user()->id)->whereStatus(4)->count(); 


// inprogress orders
$iorders_sum   = \App\Models\Order::whereUserId(Auth::user()->id)->whereStatus(2)->sum('ccost'); 
$iorders_count = \App\Models\Order::whereUserId(Auth::user()->id)->whereStatus(2)->count(); 


// editing orders
$eorders_sum   = \App\Models\Order::whereUserId(Auth::user()->id)->whereStatus(3)->sum('ccost'); 
$eorders_count = \App\Models\Order::whereUserId(Auth::user()->id)->whereStatus(3)->count(); 


// available orders
$aiorders_sum   = \App\Models\Order::whereUserId(Auth::user()->id)->whereStatus(1)->sum('ccost'); 
$aiorders_count = \App\Models\Order::whereUserId(Auth::user()->id)->whereStatus(1)->count(); 
?> 



<div class="card panel-theme">
  <div class="card-header">
    <div class="float-start">
      <h3 class="card-title">Paid orders</h3>
  </div>
  <div class="clearfix"></div>
</div>
<div class="card-body no-padding">

    <table class="table">
        <tr>
            <th>Status</th>
            <th>count</th>
            <th>Total</th>
        </tr>

        <tr>
            <td>Approved </td>
            <td>{{ $aorders_count }}</td>
            <td>{{ price($aorders_sum)  }}</td>
        </tr>

        <tr>
            <td>Completed </td>
            <td>{{ $corders_count }}</td>
            <td>{{ price($corders_sum)  }}</td>
        </tr>

        <tr>
            <td>In progress </td>
            <td>{{ $iorders_count + $eorders_count + $aiorders_count }}</td>
            <td>{{ price($iorders_sum + $eorders_sum + $aiorders_sum)  }}</td>
        </tr>
    </table>

</div>
</div>



<?php 
$worders = \App\Models\Payment::whereUserId(Auth::user()->id)->select('pay_reason')->distinct()->whereStatus(1)->get(); 

?> 



<div class="card panel-theme">
  <div class="card-header">
    <div class="float-start">
      <h3 class="card-title">Success Trasaction Made</h3>
  </div>
  <div class="clearfix"></div>
</div>
<div class="card-body no-padding">
  <table class="table">
    <tr>
        <th>Pay reason</th>
        <th>count</th>
        <th>Total</th>
    </tr>





    @foreach($worders as $order)

    <?php 
    $worder_count = \App\Models\Payment::whereUserId(Auth::user()->id)->wherePayReason($order->pay_reason)->whereStatus(1)->count(); 
    $tsum    = \App\Models\Payment::whereUserId(Auth::user()->id)->wherePayReason($order->pay_reason)->whereStatus(1)->sum('amount'); 
    ?> 

    <tr>
        <td>{{ $order->pay_reason }} </td>
        <td>{{ $worder_count }} trasactions</td>
        <td>{{ price($tsum)  }}</td>
    </tr>





    @endforeach
</table>

</div>
</div>



</div>
</div>
<!-- ROW CLOSED -->


</div>
</div>
</div>





@endsection