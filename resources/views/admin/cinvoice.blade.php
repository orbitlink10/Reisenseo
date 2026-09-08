@extends('layouts.frontbar')
@section('title')@if( ! empty($title)){{$title}} |@endif @parent @endsection


@section('social-meta')
<link rel="canonical" href="{{ route('experts') }}" />
@endsection
@section('content') 

  <?php
  $total = 0;
  ?>
  @foreach($services as $service)


  <?php

  $total = $total+$service->amount;
  ?>
  @endforeach


<!-- ROW-1 OPEN -->
<div class="section pb-0" style="background-color: #F0F0F5;">
    <div class="container">
      
    <div class="row row-cards" style="padding-top: 20px;">
     <div class="col-lg-8 col-xl-8">
      <div class="card">
       <div class="card-header">
        <h3 class="card-title">Invoice #{{$order->id}}: {{ $order->created_at }}</h3>
      </div>
      <div class="card-body">
        <div class="card-pay">
            
        <table class="table border-top table-bordered mb-0">

             <thead>
                               <tr>
                                   <th>
                                       Order ID
                                   </th>

                                   <th>Pay Day</th>
                                  
                                   <th>Fine</th>
                                   <th>Amount</th>

                                   <th>Status</th>

                               </tr>
                           </thead>


                            <tbody>
                              <?php
                              $user = \App\Models\User::find($order->user_id);
                              ?>
                              @if($services->count()>0)
                              <?php
                              $total = 0;
                              $fine_total = 0;
                              ?>
                              @foreach($services as $service)
                              <tr>


                                <?php

                                $porder = \App\Models\Order::find($service->id);


                                ?>

                                <td>
                           <a target="_blank" href="{{ route('view_order', $porder->slug )}}"> Order #{{ $service->id }} 
                                </a>
                              </td>

                              <td>

                                

                             @if($user->is_writer())
                                  {{  $porder->writer_paid_date }}
                                  @endif

                                  @if($user->is_editor())
                                  {{  $porder->editor_paid_date }}
                                  @endif
                                </td>


                                <td>

                                      @if($user->user_type== 'writer')
                                  @if($porder->order_fine)
                                  {{ $user->currency_sign }} {{ $porder->order_fine }}
                                  @else
                                  0
                                  @endif
                                   @endif
                                </td>

                                <td> 
                                  @if($user->user_type== 'writer')
                                  {{ $user->currency_sign }} {{ (int) $service->wcost }}
                                  @else
                                  {{ $user->currency_sign }} {{ (int) $service->ecost }}
                                  @endif
                                </td>

                                <td>
                                    @if($user->is_writer())
                                    {{  $porder->writer_paid }}
                                    @endif

                                    @if($user->is_editor())
                                    {{  $porder->editor_paid }}
                                    @endif
                                </td>


                       
                              </tr>
                              @if($user->user_type== 'writer')
                              <?php 
                              $total = $total+$service->wcost; 
                              $fine_total = $fine_total + $porder->order_fine;


                              ?>

                              @else
                              <?php $total = $total+$service->ecost; ?>
                              @endif

                            


                              @endforeach
                              @else
                              <tr>
                                <td>{{ $order->item_name }}</td>
                                <td class="alignright">
                                 @if($order->currency=='2')Ksh @endif @if($order->currency=='1')$ @endif
                                 {{ $order->item_name }}</td>
                               </tr>
                               @endif

                         

                            </tbody>
                          </table>

     
     


    
       </div>
     </div>
   </div>


 </div>
 <!-- COL-END -->


 <div class="col-xl-4 col-md-12">

  <div class="card cart">

    <div class="card-body">
      <h3 class="card-title">{{ $order->payment_source }}</h3>

      <ul class="list-group border br-7 mt-5">

     


        <li class="list-group-item border-0">
          Total order cost
          <span class="h6 fw-bold mb-0 float-end">{{ $user->currency_sign }} {{ (int) $total }}</span>
        </li>
        <li class="list-group-item border-0">
          Fine
          <span class="h6 fw-bold mb-0 float-end">{{ $user->currency_sign }} {{  $fine_total }}</span>
        </li>

        <li class="list-group-item border-0">
          Trasactional Charges
          <span class="h6 fw-bold mb-0 float-end">{{ $user->currency_sign }} {{  charges($total- $fine_total) }}</span>
        </li>

        <li class="list-group-item border-0">
          Total
          <span class="h4 fw-bold mb-0 float-end">{{ $user->currency_sign }} {{ (int) $total- $fine_total - charges($total- $fine_total) }}</span>
        </li>
      </ul>
    </div>

  </div>
</div>


</div>
<!-- ROW CLOSED -->




</div>
<!-- ROW-1 CLOSED -->
</div>





@endsection