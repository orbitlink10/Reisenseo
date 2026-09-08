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
                  <h3 class="card-title mb-0">Order Payments</h3>

                  <div class="page-options ms-auto">

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
                                  <th>Order Id</th>

                                  <th>Writer Id</th>
                                  <th>Writer Paid At</th>
                                  <th>Editor Paid At</th>
                                  <th>Pages</th>
                                  <th>Slides</th>
                                  <th>Total</th>
                                  <th>Writer Amount</th>
                                  <th>Editor Amount</th>
                                  <th>Admin Amount </th>
                                </tr>
                              </thead>
                              <tbody>
                                @if($orders->count()>0)
                                <?php 

$admin_total = 0;
                                ?>
                                @foreach($orders as $order)
                                <tr class="border-bottom">
                                  <?php $atotal = $order->order_admin_share + $order->subscription_fee + $order->plagiarism_report_fee + $order->preferred_writer_only_total + $order->top_ten_total;

                                  $admin_total = $admin_total+ $atotal;
                                  ?>
                                  <td><a href="{{ route('view_order', $order->slug )}}" target="_blank">#{{ $order->id }}</a> 
                                  </td>

                                  <td><a target="_blank" href="{{ route('user_info', $order->writer_id )}}">{{ $order->writer_id }} </td></a>
                                  <td>{{ $order->writer_paid_date }} </td>
                                  <td>{{ $order->editor_paid_date }} </td>
                                  <td>{{ $order->word_count }} </td>
                                  <td>{{ $order->slide }} </td>
                                  <td>{{ (int) $order->ccost }} </td>
                                  <td>{{ (int) $order->wcost }} </td>
                                  <td>{{ (int) $order->ecost }} </td>
                                  <td>{{ (int) $atotal }} </td>   

                                </tr>

                               





                                  @endforeach
                                  @else
                                  <tr>No invoice sent</tr>
                                  @endif

                                   <tr class="border-bottom">
                                  <td> </td>
                                    <td> </td>
                                    <td> </td>
                                    <td><strong>Total</strong> </td>
                                    <td>{{ $orders->sum('word_count') }} </td>
                                    <td>{{ $orders->sum('slide') }} </td>
                                    <td>{{ (int) $orders->sum('ccost') }} </td>
                                    <td>{{ (int) $orders->sum('wcost') }} </td>
                                    <td>{{ (int) $orders->sum('ecost') }} </td>
                                    <td>{{ (int) $admin_total }}</td>   

                                  </tr>


                                </tbody>
                              </table>


                            </div>
                          </div>


                        </div>
                      </div>


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