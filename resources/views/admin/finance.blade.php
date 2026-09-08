     @extends('layouts.appbar')

     @section('content')      <!--app-content open-->
     <div class="main-content app-content mt-0">
      <div class="side-app">


        <!-- CONTAINER -->
        <div class="main-container container-fluid">

          <!-- ROW-4 -->
          <div class="row" style="padding-top: 20px;">
            <div class="col-12 col-sm-12">
              <div class="card">
                <div class="card-header">

                 <div>

                  <form style="display: none;" id="form" action="" method="post">
                    <select  class="form-control select2 w-100" onchange ="calculate(this.form);">
                      <option>Select Building</option>
                      <?php
                      $buildings = \App\Models\Order::whereUserId(Auth::user()->id)->get();
                      ?>
                      @foreach($buildings as $building)
                      <option value="{{ $building->id }}">{{$building->name}} </option>
                      @endforeach


                    </select>

                  </form>

                  <form method='get'  id='myform' action="{{ route('finance') }}">

                   <select name='invoicemonth' id='lang' class="form-control"> 
                     <option value="">Filter by month</option>
                     <option value="1">{{ month(1) }}</option>
                     <option value="2">{{ month(2) }}</option>
                     <option value="3">{{ month(3) }}</option>
                     <option value="4">{{ month(4) }}</option>
                     <option value="5">{{ month(5) }}</option>
                     <option value="6">{{ month(6) }}</option>
                     <option value="7">{{ month(7) }}</option>
                     <option value="8">{{ month(8) }}</option>
                     <option value="9">{{ month(9) }}</option>
                     <option value="10">{{ month(10) }}</option>
                     <option value="11">{{ month(11) }}</option>
                     <option value="12">{{ month(12) }}</option>


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



              <div class="page-options ms-auto">
                <a class="btn btn-primary btn-sm badge" data-bs-target="#withdraw" data-bs-toggle="modal"> Withdraw </a> 

                <a class="btn btn-warning btn-sm badge" data-bs-target="#edit-property" data-bs-toggle="modal"> Add Expense</a> 

                  <a href="{{ route('mpesa_transactions')}}" class="btn btn-success btn-sm badge"> Mpesa Trasactions</a> 


          <a href="{{ route('payments')}}" class="btn btn-info btn-sm badge"> All Trasactions</a>
          
          <a class="btn btn-primary btn-sm badge" data-bs-target="#balance-account" data-bs-toggle="modal"> Balance Accounts </a> 
             


              </div>



                     <!-- edit modal-->
              <div class="modal fade" id="balance-account">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content country-select-modal">
                    <div class="modal-header">
                      <h6 class="modal-title">Balance Account</h6><button aria-label="Close" class="btn-close"
                      data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
              

<p>Are you sure you want to balance clients payment account</p>

<a href="{{ route('balance_account')}}" class="btn btn-primary">Proceed </a>


                 



              
                   </div>
                 </div>
               </div>
             </div>



              <!-- edit modal-->
              <div class="modal fade" id="withdraw">
                <div class="modal-dialog modal-dialog-centered" role="document">
                  <div class="modal-content country-select-modal">
                    <div class="modal-header">
                      <h6 class="modal-title">Add new withdraw</h6><button aria-label="Close" class="btn-close"
                      data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                      <form class="form-horizontal" action="{{ route('create_withdraw')}}" method="POST">
                        @csrf


                        <input type="hidden" name="transaction_type" value="1">


                        <div class=" row mb-4">
                          <label class="col-md-4 form-label">Select Month:</label>
                          <div class="col-md-8">
                            <select class="form-control" name="current_month" required="">
                              <option value="1">January</option>
                              <option value="2">February</option>
                              <option value="3">March</option>
                              <option value="4">April</option>
                              <option value="5">May</option> 
                              <option value="6">June</option>
                              <option value="7">July</option>
                              <option value="8">August</option> 
                              <option value="9">September</option>
                              <option value="10">Octomber</option>
                              <option value="11">November</option>
                              <option value="12">December</option>

                            </select>
                          </div>
                        </div>

                        <div class=" row mb-4">
                          <label class="col-md-4 form-label">Amount</label>
                          <div class="col-md-8">
                            <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid phone is required: 0725000000">
                              <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                {{Auth::user()->currency_sign}}
                              </a>
                              <input  class="input100 border-start-0 ms-0 form-control" name="amount" type="text" value="0">
                            </div>

                          </div>
                        </div>

                        <div class=" row mb-4">
                          <label class="col-md-4 form-label">special note</label>
                          <div class="col-md-8">
                            <input type="text" class="form-control" name="name" placeholder="Special note" required="">
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





             <!-- edit modal-->
             <div class="modal fade" id="edit-property">
              <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content country-select-modal">
                  <div class="modal-header">
                    <h6 class="modal-title">Add new expense</h6><button aria-label="Close" class="btn-close"
                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                  </div>
                  <div class="modal-body">

                    <form class="form-horizontal" action="{{ route('create_expense')}}" method="POST">
                      @csrf


                      <input type="hidden" name="transaction_type" value="0">


                      <div class=" row mb-4">
                        <label class="col-md-4 form-label">Select Month:</label>
                        <div class="col-md-8">
                          <select class="form-control" name="current_month" required="">
                            <option value="1">January</option>
                            <option value="2">February</option>
                            <option value="3">March</option>
                            <option value="4">April</option>
                            <option value="5">May</option> 
                            <option value="6">June</option>
                            <option value="7">July</option>
                            <option value="8">August</option> 
                            <option value="9">September</option>
                            <option value="10">Octomber</option>
                            <option value="11">November</option>
                            <option value="12">December</option>

                          </select>
                        </div>
                      </div>

                      <div class=" row mb-4">
                        <label class="col-md-4 form-label">Amount</label>
                        <div class="col-md-8">
                          <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid phone is required: 0725000000">
                            <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                              {{Auth::user()->currency_sign}}
                            </a>
                            <input  class="input100 border-start-0 ms-0 form-control" name="amount" type="text" value="0">
                          </div>

                        </div>
                      </div>

                      <div class=" row mb-4">
                        <label class="col-md-4 form-label">Expense note</label>
                        <div class="col-md-8">
                          <input type="text" class="form-control" name="name" placeholder="expense note" required="">
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

       </div>
     </div>
     <?php
     $total = $total_payments_amount+$total_order_fee+$total_admin_share+$plagiarism_report_fee + $preferred_writer_only_total + $top_ten_total;
     ?>
     <!-- ROW-1 -->
     <div class="row">
      <div class="col-lg-12 col-md-12 col-sm-12 col-xl-12">
        <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
            <div class="card overflow-hidden">
              <div class="card-body">
                <div class="d-flex">

                  <div class="mt-2">
                    <h6 class="">Revenues</h6>
                    <h2 class="mb-0 number-font">
                    {{ price((int) $total) }}</h2>
                  </div>

                  <div class="ms-auto">
                    <div class="chart-wrapper mt-1">
                      <canvas id="saleschart"
                      class="h-8 w-9 chart-dropshadow"></canvas>
                    </div>
                  </div>
                </div>
                <span class="text-muted fs-12"><span class="text-secondary"><i
                  class="fe fe-arrow-up-circle  text-secondary"></i> 5%</span>
                Last week</span>
              </div>
            </div>
          </div>
          <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
            <div class="card overflow-hidden">
              <div class="card-body">
                <div class="d-flex">
                  <div class="mt-2">
                    <h6 class="">Withdraws/Expenses</h6>
                    <h2 class="mb-0 number-font">{{price((int) $total_expense) }}</h2>
                  </div>
                  <div class="ms-auto">
                    <div class="chart-wrapper mt-1">
                      <canvas id="leadschart"
                      class="h-8 w-9 chart-dropshadow"></canvas>
                    </div>
                  </div>
                </div>
                <span class="text-muted fs-12"><span class="text-pink"><i
                  class="fe fe-arrow-down-circle text-pink"></i> 0.75%</span>
                Last 6 days</span>
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
            <div class="card overflow-hidden">
              <div class="card-body">
                <div class="d-flex">
                  <div class="mt-2">
                    <h6 class=""> Balance </h6>
                    <h2 class="mb-0 number-font"> {{price((int) $total- (int) $total_expense) }}</h2>
                  </div>
                  <div class="ms-auto">
                    <div class="chart-wrapper mt-1">
                      <canvas id="costchart"
                      class="h-8 w-9 chart-dropshadow"></canvas>
                    </div>
                  </div>
                </div>
                <span class="text-muted fs-12"><span class="text-warning"><i
                  class="fe fe-arrow-up-circle text-warning"></i> 0.6%</span>
                Last year</span>
              </div>
            </div>
          </div>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
            <div class="card overflow-hidden">
              <div class="card-body">
                <div class="d-flex">

                  <div class="mt-2">
                    <h6 class="">Subscriptions</h6>
                    <h2 class="mb-0 number-font">
                    {{ price((int) $total_payments_amount) }}</h2>
                  </div>

                  <div class="ms-auto">
                    <div class="chart-wrapper mt-1">
                      <canvas id="saleschart"
                      class="h-8 w-9 chart-dropshadow"></canvas>
                    </div>
                  </div>
                </div>
                <span class="text-muted fs-12"><span class="text-secondary"><i
                  class="fe fe-arrow-up-circle  text-secondary"></i> 5%</span>
                Last week</span>
              </div>
            </div>
          </div>


          <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
            <div class="card overflow-hidden">
              <div class="card-body">
                <div class="d-flex">
                  <div class="mt-2">
                    <h6 class="">Subscription per Order </h6>
                    <h2 class="mb-0 number-font"> {{price((int) $total_order_fee) }}</h2>
                  </div>
                  <div class="ms-auto">
                    <div class="chart-wrapper mt-1">
                      <canvas id="costchart"
                      class="h-8 w-9 chart-dropshadow"></canvas>
                    </div>
                  </div>
                </div>
                <span class="text-muted fs-12"><span class="text-warning"><i
                  class="fe fe-arrow-up-circle text-warning"></i> 0.6%</span>
                Last year</span>
              </div>
            </div>
          </div>


          <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
            <div class="card overflow-hidden">
              <div class="card-body">
                <div class="d-flex">
                  <div class="mt-2">
                    <h6 class="">System Share</h6>
                    <h2 class="mb-0 number-font"> {{price((int) $total_admin_share) }}</h2>
                  </div>
                  <div class="ms-auto">
                    <div class="chart-wrapper mt-1">
                      <canvas id="costchart"
                      class="h-8 w-9 chart-dropshadow"></canvas>
                    </div>
                  </div>
                </div>
                <span class="text-muted fs-12"><span class="text-warning"><i
                  class="fe fe-arrow-up-circle text-warning"></i> 0.6%</span>
                Last year</span>
              </div>
            </div>
          </div>
          <?php 
          $sms_count = \App\Models\Option::find(1)->sms_count;
          ?>

          <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
            <div class="card overflow-hidden">
              <div class="card-body">
                <div class="d-flex">
                  <div class="mt-2">
                    <h6 class="">Sms Usage </h6>
                    <h2 class="mb-0 number-font">{{ get_option(site_id().'_currency_sign') }} {{ $sms_count }}</h2>
                  </div>
                  <div class="ms-auto">
                    <div class="chart-wrapper mt-1">
                      <canvas id="costchart"
                      class="h-8 w-9 chart-dropshadow"></canvas>
                    </div>
                  </div>
                </div>

                <a class="btn btn-success btn-sm badge" data-bs-target="#sms" data-bs-toggle="modal"><i class="fa fa-edit"></i> Pay Sms</a>

                

                <!-- edit modal-->
                <div class="modal fade" id="sms">
                  <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content country-select-modal">
                      <div class="modal-header">
                        <h6 class="modal-title">Pay Sms</h6><button aria-label="Close" class="btn-close"
                        data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                      </div>
                      <div class="modal-body">

                       <form class="form-horizontal" action="{{ route('create_expense')}}" method="POST">
                        @csrf
                        <input type="hidden" name="transaction_type" value="2">
                        <div class=" row mb-4">
                          <label class="col-md-4 form-label">Select Month:</label>
                          <div class="col-md-8">
                            <select class="form-control" name="current_month" required="">
                              <option value="1">January</option>
                              <option value="2">February</option>
                              <option value="3">March</option>
                              <option value="4">April</option>
                              <option value="5">May</option> 
                              <option value="6">June</option>
                              <option value="7">July</option>
                              <option value="8">August</option> 
                              <option value="9">September</option>
                              <option value="10">Octomber</option>
                              <option value="11">November</option>
                              <option value="12">December</option>

                            </select>
                          </div>
                        </div>

                        <div class=" row mb-4">
                          <label class="col-md-4 form-label">Amount</label>
                          <div class="col-md-8">
                            <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid phone is required: 0725000000">
                              <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
                                {{Auth::user()->currency_sign}}
                              </a>
                              <input  class="input100 border-start-0 ms-0 form-control" name="amount" type="text" value="{{ $sms_count }}">
                            </div>

                          </div>
                        </div>

                        <div class=" row mb-4">
                          <label class="col-md-4 form-label">Expense note</label>
                          <div class="col-md-8">
                            <input type="text" class="form-control" name="name" placeholder="expense note" value="Sms Expense">
                          </div>


                        </div>




                        <div class=" row mb-4">

                          <div class="col-md-9">
                            <input type="submit" value="Pay now" class="btn btn-success">
                         </div>


                       </div>



                     </form>
                   </div>
                 </div>
               </div>
             </div>




           </div>
         </div>
       </div>

 


              <?php 
              $savings_count = \App\Models\Option::find(1)->saseni_savings;

              ?>

              <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
                <div class="card overflow-hidden">
                  <div class="card-body">
                    <div class="d-flex">
                      <div class="mt-2">
                        <h6 class="">Saseni Savings </h6>
                        <h2 class="mb-0 number-font">KSH {{ $savings_count }}</h2>
                      </div>
                      <div class="ms-auto">
                        <div class="chart-wrapper mt-1">
                          <canvas id="costchart"
                          class="h-8 w-9 chart-dropshadow"></canvas>
                        </div>
                      </div>
                    </div>
                    <span class="text-muted fs-12"><span class="text-warning"><i
                      class="fe fe-arrow-up-circle text-warning"></i> 0.6%</span>
                    Last year</span>
                  </div>
                </div>
              </div>


                          <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
                <div class="card overflow-hidden">
                  <div class="card-body">
                    <div class="d-flex">
                      <div class="mt-2">
                        <h6 class="">Unpaid InProgress </h6>
                        <h2 class="mb-0 number-font"> {{ price( (int) $unpaid_inprogress)  }}</h2>
                      </div>
                      <div class="ms-auto">
                        <div class="chart-wrapper mt-1">
                          <canvas id="costchart"
                          class="h-8 w-9 chart-dropshadow"></canvas>
                        </div>
                      </div>
                    </div>
                    <span class="text-muted fs-12"><span class="text-warning"><i
                      class="fe fe-arrow-up-circle text-warning"></i> 0.6%</span>
                    Last year</span>
                  </div>
                </div>
              </div>


            <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
                <div class="card overflow-hidden">
                  <div class="card-body">
                    <div class="d-flex">
                      <div class="mt-2">
                        <h6 class="">Unpaid Completed </h6>
                        <h2 class="mb-0 number-font"> {{ price( (int) $unpaid_completed)  }}</h2>
                      </div>
                      <div class="ms-auto">
                        <div class="chart-wrapper mt-1">
                          <canvas id="costchart"
                          class="h-8 w-9 chart-dropshadow"></canvas>
                        </div>
                      </div>
                    </div>
                    <span class="text-muted fs-12"><span class="text-warning"><i
                      class="fe fe-arrow-up-circle text-warning"></i> 0.6%</span>
                    Last year</span>
                  </div>
                </div>
              </div>


              <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
                <div class="card overflow-hidden">
                  <div class="card-body">
                    <div class="d-flex">
                      <div class="mt-2">
                        <h6 class="">Unpaid Approved </h6>
                        <h2 class="mb-0 number-font">{{ price( (int) $unpaid_approved) }}</h2>
                      </div>
                      <div class="ms-auto">
                        <div class="chart-wrapper mt-1">
                          <canvas id="costchart"
                          class="h-8 w-9 chart-dropshadow"></canvas>
                        </div>
                      </div>
                    </div>
                    <span class="text-muted fs-12"><span class="text-warning"><i
                      class="fe fe-arrow-up-circle text-warning"></i> 0.6%</span>
                    Last year</span>
                  </div>
                </div>
              </div>


               <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
                <div class="card overflow-hidden">
                  <div class="card-body">
                    <div class="d-flex">
                      <div class="mt-2">
                        <h6 class="">Total Unpaid </h6>
                        <h2 class="mb-0 number-font">{{ price( (int) $total_unpaid ) }}</h2>
                      </div>
                      <div class="ms-auto">
                        <div class="chart-wrapper mt-1">
                          <canvas id="costchart"
                          class="h-8 w-9 chart-dropshadow"></canvas>
                        </div>
                      </div>
                    </div>
                    <span class="text-muted fs-12"><span class="text-warning"><i
                      class="fe fe-arrow-up-circle text-warning"></i> 0.6%</span>
                    Last year</span>
                  </div>
                </div>
              </div>

            <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
                <div class="card overflow-hidden">
                  <div class="card-body">
                    <div class="d-flex">
                      <div class="mt-2">
                        <h6 class="">Pay later completed </h6>
                        <h2 class="mb-0 number-font">{{ price( (int) $pay_later_completed) }}</h2>
                      </div>
                      <div class="ms-auto">
                        <div class="chart-wrapper mt-1">
                          <canvas id="costchart"
                          class="h-8 w-9 chart-dropshadow"></canvas>
                        </div>
                      </div>
                    </div>
                    <span class="text-muted fs-12"><span class="text-warning"><i
                      class="fe fe-arrow-up-circle text-warning"></i> 0.6%</span>
                    Last year</span>
                  </div>
                </div>
              </div>


              <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
                <div class="card overflow-hidden">
                  <div class="card-body">
                    <div class="d-flex">
                      <div class="mt-2">
                        <h6 class="">Pay later approved </h6>
                        <h2 class="mb-0 number-font">{{ price( (int) $pay_later_approved) }}</h2>
                      </div>
                      <div class="ms-auto">
                        <div class="chart-wrapper mt-1">
                          <canvas id="costchart"
                          class="h-8 w-9 chart-dropshadow"></canvas>
                        </div>
                      </div>
                    </div>
                    <span class="text-muted fs-12"><span class="text-warning"><i
                      class="fe fe-arrow-up-circle text-warning"></i> 0.6%</span>
                    Last year</span>
                  </div>
                </div>
              </div> 


                    <?php

       $paylater_count  = \App\Models\Order::whereStatus(5)->wherePaymentWay(1)->sum('ccost');
       $lpaylater_count = \App\Models\Order::whereStatus(5)->wherePaymentWay(1)->whereUserId('3')->sum('ccost');
       $apaylater_count = \App\Models\Order::whereStatus(5)->wherePaymentWay(1)->whereUserId('5')->sum('ccost');

       ?>

       <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
        <div class="card overflow-hidden">
          <div class="card-body">
            <div class="d-flex">
              <div class="mt-2">
                <h6 class="">Total Pay later </h6>
                <h2 class="mb-0 number-font">{{ price((int) $total_pay_later) }}</h2>
              </div>
              <div class="ms-auto">
                <div class="chart-wrapper mt-1">
                  <canvas id="costchart"
                  class="h-8 w-9 chart-dropshadow"></canvas>
                </div>
              </div>
            </div>
            <span class="text-muted fs-12">

              <span class="text-warning">
                <i class="fe fe-arrow-up-circle text-warning"></i> Alpha:</span>
                <a href="{{ route('order', ['pay'=> '5']) }}">   {{ $apaylater_count }}</a></span>

                <span class="text-muted fs-12">

                  <span class="text-warning">
                    <i class="fe fe-arrow-up-circle text-warning"></i> Lucy approved orders: </span>
                    <a href="{{ route('order', ['pay'=> '3']) }}">{{ $lpaylater_count }}</a>  </span>


                  </div>
                </div>
              </div>



             


            <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
                <div class="card overflow-hidden">
                  <div class="card-body">
                    <div class="d-flex">
                      <div class="mt-2">
                        <h6 class="">Total paid to writer</h6>
                        <h2 class="mb-0 number-font">{{ price((int) $total_paid_writer) }}</h2>
                      </div>
                      <div class="ms-auto">
                        <div class="chart-wrapper mt-1">
                          <canvas id="costchart"
                          class="h-8 w-9 chart-dropshadow"></canvas>
                        </div>
                      </div>
                    </div>
                    <span class="text-muted fs-12"><span class="text-warning"><i
                      class="fe fe-arrow-up-circle text-warning"></i> 0.6%</span>
                    Last year</span>
                  </div>
                </div>
              </div>



            <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
                <div class="card overflow-hidden">
                  <div class="card-body">
                    <div class="d-flex">
                      <div class="mt-2">
                        <h6 class="">Total paid to editor</h6>
                        <h2 class="mb-0 number-font">{{ price((int) $total_paid_editor) }}</h2>
                      </div>
                      <div class="ms-auto">
                        <div class="chart-wrapper mt-1">
                          <canvas id="costchart"
                          class="h-8 w-9 chart-dropshadow"></canvas>
                        </div>
                      </div>
                    </div>
                    <span class="text-muted fs-12"><span class="text-warning"><i
                      class="fe fe-arrow-up-circle text-warning"></i> 0.6%</span>
                    Last year</span>
                  </div>
                </div>
              </div>


                         <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
                <div class="card overflow-hidden">
                  <div class="card-body">
                    <div class="d-flex">
                      <div class="mt-2">
                        <h6 class="">Total paid to writers & editors</h6>
                        <h2 class="mb-0 number-font">{{ price((int) $total_paid_editor + (int) $total_paid_writer) }}</h2>
                      </div>
                      <div class="ms-auto">
                        <div class="chart-wrapper mt-1">
                          <canvas id="costchart"
                          class="h-8 w-9 chart-dropshadow"></canvas>
                        </div>
                      </div>
                    </div>
                    <span class="text-muted fs-12"><span class="text-warning"><i
                      class="fe fe-arrow-up-circle text-warning"></i> 0.6%</span>
                    Last year</span>
                  </div>
                </div>
              </div>





          

              <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
                <div class="card overflow-hidden">
                  <div class="card-body">
                    <div class="d-flex">
                      <div class="mt-2">
                        <h6 class="">Plagiarism Report </h6>
                        <h2 class="mb-0 number-font">KSH {{ $plagiarism_report_fee }}</h2>
                      </div>
                      <div class="ms-auto">
                        <div class="chart-wrapper mt-1">
                          <canvas id="costchart"
                          class="h-8 w-9 chart-dropshadow"></canvas>
                        </div>
                      </div>
                    </div>
                    <span class="text-muted fs-12"><span class="text-warning"><i
                      class="fe fe-arrow-up-circle text-warning"></i> 0.6%</span>
                    Last year</span>
                  </div>
                </div>
              </div>


              <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
                <div class="card overflow-hidden">
                  <div class="card-body">
                    <div class="d-flex">
                      <div class="mt-2">
                        <h6 class="">Preferred writer only total </h6>
                        <h2 class="mb-0 number-font">KSH {{ $preferred_writer_only_total }}</h2>
                      </div>
                      <div class="ms-auto">
                        <div class="chart-wrapper mt-1">
                          <canvas id="costchart"
                          class="h-8 w-9 chart-dropshadow"></canvas>
                        </div>
                      </div>
                    </div>
                    <span class="text-muted fs-12"><span class="text-warning"><i
                      class="fe fe-arrow-up-circle text-warning"></i></span>
                   <a href="{{ route('order', ['q' => '11']) }}">View</a></span>
                  </div>
                </div>
              </div>


                            <div class="col-lg-6 col-md-6 col-sm-12 col-xl-4">
                <div class="card overflow-hidden">
                  <div class="card-body">
                    <div class="d-flex">
                      <div class="mt-2">
                        <h6 class="">Top ten total </h6>
                        <h2 class="mb-0 number-font">KSH {{ $top_ten_total }}</h2>
                      </div>
                      <div class="ms-auto">
                        <div class="chart-wrapper mt-1">
                          <canvas id="costchart"
                          class="h-8 w-9 chart-dropshadow"></canvas>
                        </div>
                      </div>
                    </div>
                    <span class="text-muted fs-12"><span class="text-warning"><i
                      class="fe fe-arrow-up-circle text-warning"></i> 0.6%</span>
                          <a href="{{ route('order', ['q' => '12']) }}">View</a></span>
                  </div>
                </div>
              </div>


            </div>
          </div>
        </div>
        <!-- ROW-1 END -->





        <div class="col-12 col-sm-12">
         

<div class="row">
 <div class="col-lg-8 col-xl-8">


  <div class="card">
    <div class="card-header border-bottom-0">
      <h2 class="card-title">Expenses</h2>
      <div class="page-options ms-auto">
        <select class="form-control select2 w-100">
          <option value="asc">Latest</option>
          <option value="desc">Oldest</option>
        </select>
      </div>
    </div>
    <div class="e-table px-5 pb-5">
      <div class="table-responsive table-lg">
       @if($expenses->count()>0)
       <table class="table border-top table-bordered mb-0">
        <thead>
          <tr>
            <th class="text-center">
              ID
            </th>

            <th>Note</th>
            <th>Amount</th>
            <th>Date</th>
            <th class="text-center">Actions</th>
          </tr>
        </thead>
        <tbody>


         @foreach($expenses as $property)
         <tr>
          <td class="align-middle text-center">

            #{{ $property->id }}
          </td>

          <td class="text-nowrap align-middle">
            <a href="">{{ $property->name }}</a></td>
            <td class="text-nowrap align-middle"><span>{{ price($property->amount) }}</span></td>
            <td class="text-nowrap align-middle"><span>{{ month($property->month) }} {{ $property->year }}</span></td>

            <td class="text-center align-middle">
              <div class="btn-group align-top">

                <a class="btn btn-sm btn-primary badge" data-bs-target="#edit-property{{ $property->id }}" data-bs-toggle="modal"><i class="fa fa-edit"></i> Manage</a> 



              </div>
            </td>
          </tr>


          <!-- edit modal-->
          <div class="modal fade" id="edit-property{{ $property->id }}">
            <div class="modal-dialog modal-dialog-centered" role="document">
              <div class="modal-content country-select-modal">
                <div class="modal-header">
                  <h6 class="modal-title">Edit expense #{{ $property->id }}</h6><button aria-label="Close" class="btn-close"
                  data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                </div>
                <div class="modal-body">
                  <form class="form-horizontal" action="{{ route('update_expense')}}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $property->id }}">
                    <div class=" row mb-4">
                      <label class="col-md-3 form-label">Amount</label>
                      <div class="col-md-9">
                        <input type="text" class="form-control" name="amount" value="{{ $property->amount }}">
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




       </tbody>
     </table>
     @else
     <tr>No expense on this month</tr>
     @endif
   </div>
 </div>
</div>
<div class="mb-5">

  <div class="float-end">

     {{$expenses->links("pagination::bootstrap-4")}}

 </div>
</div>
</div>
<!-- COL-END -->
</div>



<!-- ROW-4 END -->
</div>
<!-- CONTAINER END -->
</div>
</div>
<!-- CHART-CIRCLE JS-->
<script src="{{ asset('assets/js/circle-progress.min.js')}}"></script>
<!--app-content close-->
<script src="{{ asset('assets/plugins/peitychart/jquery.peity.min.js')}}"></script>
<script src="{{ asset('assets/plugins/peitychart/peitychart.init.js')}}"></script>
<!-- INTERNAL CHARTJS CHART JS-->
<script src="{{ asset('assets/plugins/chart/Chart.bundle.js')}}"></script>
<script src="{{ asset('assets/plugins/chart/rounded-barchart.js')}}"></script>
<script src="{{ asset('assets/plugins/chart/utils.js')}}"></script>

<!-- INTERNAL APEXCHART JS -->
<script src="{{ asset('assets/js/apexcharts.js')}}"></script>
<script src="{{ asset('assets/plugins/apexchart/irregular-data-series.js')}}"></script>

<!-- INTERNAL Vector js -->
<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-2.0.2.min.js')}}"></script>
<script src="{{ asset('assets/plugins/jvectormap/jquery-jvectormap-world-mill-en.js')}}"></script>

<!-- SPARKLINE JS-->
<script src="{{ asset('assets/js/jquery.sparkline.min.js')}}"></script>



@endsection