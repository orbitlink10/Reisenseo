@extends('layouts.appbar')

@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
 <div class="side-app">

   <!-- CONTAINER -->
   <div class="main-container container-fluid">



    <!-- ROW OPEN -->
    <div class="row row-cards" style="padding-top: 20px;">
      
      @if(Auth::user()->is_admin() or Auth::user()->is_client() or Auth::user()->is_subadmin() or Auth::user()->is_student())
      @if($invoices->count()>0)
      
      <div class="col-8 col-sm-8">
        <div class="card">
          <div class="card-header">
            <h3 class="card-title mb-0">Custom invoices</h3>
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




                    <div class="row">

                      @foreach($invoices as $invoice)


                      <div class="col-sm-4">
                        {{ $invoice->comments }}<br>
                        Sent {{ $invoice->created_at->diffForHumans() }}

                      </div>

                      <div class="col-sm-1">
                        <?php
                        $order_count = \App\Models\Order::whereId($invoice->order_id)->get();                      
                        $order = \App\Models\Order::find($invoice->order_id);
                        ?>
                        @if($order_count->count()>0)
                        <a href="{{ route('view_order', $order->slug )}}">  {{ $invoice->order_id }}</a>
                        @endif
                      </div>

                      <div class="col-sm-2">
                        <?php
                        $total_services_amount = \App\Models\Iservice::whereInvoiceId($invoice->id)->sum('amount');
                        ?>

                        <span class="fw-semibold mt-sm-2 d-block">{{ $invoice->currency }} {{ $total_services_amount }}</span>

                      </div>

                      <div class="col-sm-2">
                       {{ invoice_status($invoice->status) }}

                     </div>

                     @if(Auth::user()->is_admin())

                     <div class="col-sm-3">
                       <a href="{{ url('view-invoice/'.$invoice->slug) }}" class="btn btn-sm btn-success badge"
                        data-bs-toggle="tooltip"
                        data-bs-original-title="View Invoice"><span
                        class="fe fe-eye fs-14"></span>
                      </a>

                      <a class="btn btn-sm btn-primary badge" data-bs-target="#edit-property{{ $invoice->id }}" 
                        data-bs-toggle="modal"><i class="fa fa-edit"></i></a> 

                        <a class="btn btn-sm btn-warning badge" data-bs-target="#edit-property{{ $invoice->id }}" 
                          data-bs-toggle="modal"><i class="fa fa-plus"></i></a>
                          <!-- edit modal-->
                          <div class="modal fade" id="edit-property{{ $invoice->id }}">
                            <div class="modal-dialog modal-dialog-centered" role="document">
                              <div class="modal-content country-select-modal">
                                <div class="modal-header">
                                  <h6 class="modal-title">Add service #{{ $invoice->id }}</h6><button aria-label="Close" class="btn-close"
                                  data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                  <form class="form-horizontal" action="{{ route('add_service')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                                    <input type="hidden" name="currency" value="{{Auth::user()->currency_sign}}">
                                    <div class=" row mb-4">
                                      <label class="col-md-3 form-label">Service Name</label>
                                      <div class="col-md-9">
                                        <input type="text" class="form-control" name="service_name" value="{{ $invoice->name }}">
                                      </div>
                                    </div>

                                    <div class=" row mb-4">
                                      <label class="col-md-3 form-label">Amount</label>
                                      <div class="col-md-9">
                                        <input type="text" class="form-control" name="amount" value="{{ $invoice->location }}">
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
                       </div>

                       @endif




                       @if($invoice->status == 0)
                       @if(Auth::user()->is_client() or Auth::user()->is_student())
                       <div class="col-sm-2">

                    <!--     <a href="{{ url('view-invoice/'.$invoice->slug) }}" class="btn btn-sm btn-success badge"
                          data-bs-toggle="tooltip"
                          data-bs-original-title="View Invoice"><span
                          class="fe fe-eye fs-14"></span>
                        </a> -->

                        <a class="btn btn-sm btn-warning badge" data-bs-target="#pay-invoice{{ $invoice->id }}" data-bs-toggle="modal"><i class="fa fa-check"></i> 
                          Pay
                        </a>
                        <!-- edit modal-->
                        <div class="modal fade" id="pay-invoice{{ $invoice->id }}">
                         <div class="modal-dialog modal-dialog-centered" role="document">
                           <div class="modal-content country-select-modal">
                             <div class="modal-header">
                               <h6 class="modal-title">Make Payment for invoice #{{ $invoice->id }}</h6><button aria-label="Close" class="btn-close"
                               data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                             </div>
                             <div class="modal-body">
                               <form class="form-horizontal" action="{{ route('confirm_invoice')}}" method="POST">
                                 @csrf
                                 <input type="hidden" name="id" value="{{ $invoice->id }}">
                                 <div class=" row mb-4">
                                   <label class="col-md-3 form-label">Pay for</label>
                                   <div class="col-md-9">
                                     <input type="text" class="form-control" name="name" value="{{ $invoice->comments }}" disabled="">
                                   </div>
                                 </div>

                                 <div class=" row mb-4">
                                   <label class="col-md-3 form-label">Amount ({{ get_currency() }})</label>
                                   <div class="col-md-9">
                                     <input type="text"  class="form-control" name="amount" value="{{ $invoice->total }}" disabled="">
                                   </div>


                                 </div>


                                 <div class=" row mb-4">

                                   <div class="col-md-9">
                                    @if(wallet(Auth::user()->id) < $invoice->total)
                                      <input type="submit" value="Pay {{ get_currency() }} {{ $invoice->total - wallet(Auth::user()->id) }}" class="btn btn-success">
                                      @else
                                      <input type="submit" value="Submit" class="btn btn-primary">

                                      @endif
                                    </div>


                                  </div>



                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                      @endif
                      @endif



                      <hr style="border-top: 1px solid #000000;">


                      @endforeach



                    </div>


                    {{$invoices->links("pagination::bootstrap-4")}}




                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
      </div>

      @endif
      @endif

      <div class="col-lg-4 col-xl-4">
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
                   {{ get_currency() }}
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
  </div>
</div>
<!-- ROW CLOSED -->


</div>
</div>
</div>





@endsection