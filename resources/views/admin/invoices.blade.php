     @extends('layouts.appbar')

     @section('content') 


     <!--app-content open-->
     <div class="main-content app-content mt-0">
      <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">

          <!-- ROW-4 -->
          <div class="row" style="padding-top: 20px;">
            <div class="col-12 col-sm-12">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title mb-0">Invoices</h3>

                  <div class="page-options ms-auto">
                    @if(Auth::user()->is_writer())
                    <!--     {{  get_wtotal(Auth::user()->id) - get_intotal(Auth::user()->id) }} -->


                    @endif

                    <a href="{{ route('invoices_pending') }}" class="btn btn-primary"> Pending ({{ $pending_invoice }})
                    </a>

                    <a href="{{ route('invoices_paid') }}" class="btn btn-primary"> Paid ({{ $paid_invoice }})
                    </a>

                    <a href="{{ route('invoices', ['status'=>'2']) }}" class="btn btn-primary"> Cancelled ({{ $cancelled_invoice }})
                    </a>


                    <a href="{{ route('invoices', ['dates'=>'2']) }}" class="btn btn-primary"> Filter By Dates
                    </a>



                  </div>

                  @if(Auth::user()->is_admin())
                  <div class="page-options ms-auto">
                    <a class="btn btn-sm btn-primary badge" data-bs-target="#edit-property" data-bs-toggle="modal"><i class="fa fa-edit"></i> Generate Invoice</a> 

                    <a class="btn btn-sm btn-primary badge" data-bs-target="#send-sms" data-bs-toggle="modal"><i class="fa fa-comment"></i> Send SMS</a> 
                  </div>
                  @endif

                  <!-- edit modal-->
                  <div class="modal fade" id="send-sms">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                      <div class="modal-content country-select-modal">
                        <div class="modal-header">
                          <h6 class="modal-title">Send Payment SMS</h6><button aria-label="Close" class="btn-close"
                          data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                        </div>
                        <div class="modal-body">
                          <form class="form-horizontal" action="{{ route('send_sms')}}" method="POST">
                            @csrf


                            <div class=" row mb-4">
                              <label class="col-md-4 form-label">Send To:</label>
                              <div class="col-md-8">

                                <select class="form-control" name="message_to" required="">
                                 <option value="1">All Unpaid Invoices</option>


                               </select>
                             </div>
                           </div>

                           <div class=" row mb-4">
                            <label class="col-md-4 form-label">Message:</label>
                            <div class="col-md-8">


                             <textarea class="form-control" name="message" required="">Hi, </textarea>
                           </div>
                         </div>





                         <div class=" row mb-4">

                          <div class="col-md-9">
                           <input type="submit" value="Send Now" class="btn btn-primary">
                         </div>


                       </div>



                     </form>
                   </div>
                 </div>
               </div>
             </div>


             <!-- edit modal-->
             <div class="modal fade" id="edit-property">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content country-select-modal">
                  <div class="modal-header">
                    <h6 class="modal-title">Create invoices for all users and editors</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                  </div>
                  <div class="modal-body">
                    <form class="form-horizontal" action="{{ route('admin_generate_invoices')}}" method="POST">

                      @csrf

                      <div class=" row mb-4"> <label class="col-md-4 form-label">Select User Type:</label>
                        <div class="col-md-8">
                          <select class="form-control" name="user_type" required="">
                            <option value="">Select User Type</option>
                            <option value="writer">Writer</option>
                            <option value="editor">Editor</option>
                          </select>
                        </div>
                      </div>



                      <div class=" row mb-4">

                        <div class="col-md-9">
                         <input type="submit" value="Generate Invoices" class="btn btn-primary">
                       </div>


                     </div>



                   </form>
                 </div>
               </div>
             </div>
           </div>



         </div>


         <div class="card-body pt-4">
          <div class="grid-margin">
            <div class="">
              <div class="panel panel-primary">

                <div class="panel-body tabs-menu-body border-0 pt-0">
                 <div class="tab-content">
                  <div class="tab-pane active" id="tab5">
                    <div class="table-responsive">
                      <table id="data-table"
                      class="table table-bordered text-nowrap mb-0">
                      <thead class="border-top">
                        <tr>
                          <th class="bg-transparent border-bottom-0"
                          style="width: 5%;">Tracking Id</th>
                          <th
                          class="bg-transparent border-bottom-0">
                          Name 
                        </th>

                        <th
                        class="bg-transparent border-bottom-0">
                        Phone 
                      </th>

                      <th
                      class="bg-transparent border-bottom-0">
                    Pay Day</th>
                    <th
                    class="bg-transparent border-bottom-0">
                  Amount</th>

                  <th class="bg-transparent border-bottom-0"
                  style="width: 10%;">Status</th>
                  <th class="bg-transparent border-bottom-0"
                  style="width: 5%;">Action</th>
                </tr>
              </thead>
              <tbody>
                @if($invoices->count()>0)
                @foreach($invoices as $invoice)
                <tr class="border-bottom">

                  <td class="text-center">
                    <div class="mt-0 mt-sm-2 d-block">
                      <h6
                      class="mb-0 fs-14 fw-semibold">
                      #{{ $invoice->id}}<br>
                      @if($invoice->confirmed == 'unconfirmed' or $invoice->confirmed == 'confirmed')
                      <span style="color: red;">{{ $invoice->confirmed }}</span>
                      @else
                      <span style="color: green; ">{{ $invoice->confirmed }}</span>
                      @endif

                    </h6>
                  </div>
                </td>

                <td>
                  <div class="d-flex">

                   <?php
                   $user = \App\Models\User::find($invoice->user_id);
                   ?>

                   @if($user->is_editor())
                   <a href="{{ route('einvoices', ['user_id' => $invoice->user_id ]) }}"> 
                    {{ username($invoice->user_id)->name }} ({{ $invoice->user_id }})

                  </a>
                  @else

                  <a href="{{ route('invoices', ['user_id' => $invoice->user_id ]) }}"> 
                    {{ username($invoice->user_id)->name }} ({{ $invoice->user_id }})

                  </a>

                  @endif



                </div>
              </td>

              <td>
                <div class="d-flex"> 
                  @if(username($invoice->user_id)->phone)
                  Mpesa No. {{ username($invoice->user_id)->phone }}<br>
                  @endif
                  @if(username($invoice->user_id)->equity_bank)
                  Equity A/C. {{ username($invoice->user_id)->equity_bank }}
                  @endif
                </div>
              </td>

              <td>
                @if(Auth::user()->is_admin())
                <a href="{{ route('order_payments', ['filter' => 1, 'day' => $invoice->day, 'month' => $invoice->month, 'year' => $invoice->year])}}">
                  <span class="mt-sm-2 d-block">
                    @if($invoice->invoice_type=='system')
                    {{ $invoice->day }} {{ month($invoice->month )}} {{$invoice->year}}  
                    @else
                    {{ $invoice->created_at }}
                    @endif
                  </span>

                </a>
                @else
                   @if($invoice->invoice_type=='system')
                    {{ $invoice->day }} {{ month($invoice->month )}} {{$invoice->year}}  
                    @else
                    {{ $invoice->created_at }}
                    @endif
                @endif
              </td>

              <?php
              $tinvoice = \App\Models\Order::whereInvoiceId($invoice->id)->sum('wcost');
              ?>

              @if($tinvoice>0)



              <td>
 <span class="fw-semibold mt-sm-2 d-block">{{  price( (int) $invoice->total) }}<br>

                @if(price( (int) $tinvoice) == price( (int) $invoice->total) )

                <!-- {{  price( (int) $tinvoice) }} -->

                @else
                <span style="color: red;">  {{  price( (int) $tinvoice) }}</span>
                @endif


               <!--      <br>
                {{ price( get_wtotal($invoice->user_id) - get_intotal($invoice->user_id)) }} -->





              </span>
            </td>

            @endif



            <?php
            $einvoice = \App\Models\Order::whereEinvoiceId($invoice->id)->sum('ecost');
            ?>
            @if($einvoice>0)            
            <td>
              @if(Auth::user()->is_admin() or Auth::user()->is_editor())


              <span class="fw-semibold mt-sm-2 d-block">{{  price( (int) $invoice->total) }}<br>


                @if(price( (int) $einvoice) == price( (int) $invoice->total) )
                <!-- {{  price( (int) $einvoice) }} -->

                @else
                <span style="color: red;">  {{  price( (int) $einvoice) }}</span>
                @endif


               <!--      <br>
                {{ price( get_ewtotal($invoice->user_id) - get_eintotal($invoice->user_id)) }} -->
              </span>
              @endif

            </td>

            @endif



            <td>
              <div class="mt-sm-1 d-block">
               @if($invoice->status==0)                                                                                 
               <span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">Pending</span>
               @elseif($invoice->status==1)
               <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Paid</span>
               @else($invoice->status==2)
               <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">Cancelled</span>
               @endif
             </div>
           </td>
           <td>
            <div class="g-2">



              <a target="_blank" href="{{ url('cview-invoice/'.$invoice->slug) }}" class="btn text-primary btn-sm"
                data-bs-toggle="tooltip"
                data-bs-original-title="View Invoice"><span
                class="fe fe-eye fs-14"></span>
              </a>
              @if(Auth::user()->is_admin())
              <a class="btn btn-sm btn-success badge" data-bs-target="#edit-property{{ $invoice->id }}" 
                data-bs-toggle="modal"><i class="fa fa-edit"></i> manage</a>
                @endif 

              </div>
            </td>
          </tr>

          <!-- edit modal-->
          <div class="modal fade" id="edit-property{{ $invoice->id }}">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content country-select-modal">
                <div class="modal-header">
                  <h6 class="modal-title">Update invoice #{{ $invoice->id }}</h6><button aria-label="Close" class="btn-close"
                  data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                </div>

                <div class="modal-body">
                  <form class="form-horizontal" action="{{ route('update_invoice')}}" method="POST">
                    @csrf
                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                    <input type="hidden" name="currency" value="{{Auth::user()->currency_sign}}">


                    <div class=" row mb-4">
                      <label class="col-md-3 form-label">Amount (KES)</label>
                      <div class="col-md-9">
                        <input type="text" class="form-control" name="amount" value="{{ $invoice->total }}">
                      </div>


                    </div>

                    <div class=" row mb-4">
                      <label class="col-md-3 form-label">Total Paid (KES)</label>
                      <div class="col-md-9">
                        <input type="text" class="form-control" name="total_paid" value="{{ $invoice->total_paid }}">
                      </div>
                    </div>


                    <div class=" row mb-4">
                      <label class="col-md-3 form-label">Comment</label>
                      <div class="col-md-9">
                        <textarea  class="form-control" name="comment">{{ $invoice->comment }}</textarea>
                      </div>
                    </div>

                    <div class=" row mb-4">
                      <label class="col-md-3 form-label">Status</label>
                      <div class="col-md-9">
                        <select class="form-control" name="status">
                          <option value="{{ $invoice->status }}">
                            @if($invoice->status==0)                                                                                 
                            <span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">Pending</span>
                            @elseif($invoice->status==1)
                            <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Paid</span>
                            @else($invoice->status==2)
                            <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">Cancelled</span>
                            @endif
                          </option>
                          <option value="0">Pending</option>
                          <option value="1">Paid</option>
                          <option value="2">Cancelled</option>
                        </select>

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



         @endforeach
         @else
         <tr>No invoice sent</tr>
         @endif
         <tr>
          <th class="bg-transparent border-bottom-0"
          style="width: 5%;"></th>
          <th
          class="bg-transparent border-bottom-0">
        </th>

        <?php


        ?>

        <th
        class="bg-transparent border-bottom-0">
        Total Unpaid:<br>
        Already Paid:<br>
        Suppose to be paid:<br>
        Over Payment: <br>
        Payment to be Processed: 

      </th>
      <th class="border-bottom-0">
       <span style="color: orange;">  {{ price((int) $sum_pinvoices)}} <br></span>
       {{ price((int) $sum_invoices) }} <br>
       {{ price((int) $sum_sinvoices) }}<br>

       <span style="color: red;">{{ price((int) ( $sum_invoices - $sum_sinvoices)) }} </span> <br>
       <span style="color: green;">{{ price((int) ($sum_pinvoices + ($sum_sinvoices - $sum_invoices ) )) }} </span> 

     </th>

     <th class="border-bottom-0"
     style="width: 10%;"></th>
     <th class="bg-transparent border-bottom-0"
     style="width: 5%;"></th>
   </tr>

 </tbody>
</table>


</div>
</div>


</div>
</div>

{{$invoices->links("pagination::bootstrap-4")}}
</div>
</div>
</div>
</div>
</div>

<div class="card-footer text-end">

  <button type="button" class="btn btn-success mb-1" onclick="javascript:window.print();"><i class="si si-printer"></i> Print Invoice</button>

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
  <script src="http://www.position-absolute.com/creation/print/jquery.printPage.js"></script>

  <a href="{{ URL::to('dashboard/invoices')}}" class="btnPrint"> Print </a>
  <script type="text/javascript">
    $(document).ready(function() {
      $('.btnPrint').printPage();
    });
  </script>
</div>
</div>



</div>
<!-- CONTAINER END -->
</div>
</div>
<!--app-content close-->

@endsection