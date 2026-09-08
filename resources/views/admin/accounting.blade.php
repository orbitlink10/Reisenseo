@extends('layouts.appbar')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
   <div class="side-app">

     <!-- CONTAINER -->
     <div class="main-container container-fluid">
       <div class="col-lg-12 col-xl-12">

           <?php
           $total_wallet_balance = \App\Models\User::whereUserType('client')->sum('wallet');
           $unpaid_available    =  \App\Models\Order::whereStatus(1)->wherePayments(0)->whereWriterPaid('unpaid')->sum('wcost');
           $unpaid_inprogress   =  \App\Models\Order::whereStatus(2)->wherePayments(0)->whereWriterPaid('unpaid')->sum('wcost');
           $unpaid_editing     =  \App\Models\Order::whereStatus(3)->wherePayments(0)->whereWriterPaid('unpaid')->sum('wcost');
           $unpaid_revision    =  \App\Models\Order::whereStatus(6)->wherePayments(0)->whereWriterPaid('unpaid')->sum('wcost');
           $unpaid_completed     =  \App\Models\Order::whereStatus(4)->wherePayments(0)->whereWriterPaid('unpaid')->sum('wcost');
           $unpaid_approved      =  \App\Models\Order::whereStatus(5)->wherePayments(1)->whereWriterPaid('unpaid')->sum('wcost');

           $total_unpaid = $unpaid_available + $unpaid_inprogress + $unpaid_editing + $unpaid_revision + $unpaid_completed + $unpaid_approved;


           //get earning

           $total_payments_amount = \App\Models\Payment::whereStatus('1')->wherePaymentSource('subscription')->sum('amount');
           $total_expense = \App\Models\Expense::sum('amount');

           $total_order_fee             = \App\Models\Order::whereStatus(5)->where('subscription_fee', '>', '0')->sum('subscription_fee');
           $total_admin_share           =  \App\Models\Order::whereStatus(5)->where('order_admin_share', '>', '0')->sum('order_admin_share');
           $plagiarism_report_fee       =  \App\Models\Order::whereStatus(5)->sum('plagiarism_report_fee');
           $preferred_writer_only_total =  \App\Models\Order::whereStatus(5)->sum('preferred_writer_only_total');
           $top_ten_total               =  \App\Models\Order::whereStatus(5)->sum('top_ten_total');

           $total = $total_payments_amount+$total_order_fee+$total_admin_share+$plagiarism_report_fee + $preferred_writer_only_total + $top_ten_total-$total_expense;


//total paylater

           $pay_later_available  =  \App\Models\Order::whereStatus(1)->wherePaymentWay(1)->sum('ccost');
           $pay_later_inprogress =  \App\Models\Order::whereStatus(2)->wherePaymentWay(1)->sum('ccost');
           $pay_later_editing    =  \App\Models\Order::whereStatus(3)->wherePaymentWay(1)->sum('ccost');
           $pay_later_revision   =  \App\Models\Order::whereStatus(6)->wherePaymentWay(1)->sum('ccost');

           $pay_later_completed  =  \App\Models\Order::whereStatus(4)->wherePaymentWay(1)->sum('ccost');
           $pay_later_approved   =  \App\Models\Order::whereStatus(5)->wherePaymentWay(1)->sum('ccost');

           $total_pay_later = $pay_later_available + $pay_later_inprogress + $pay_later_editing +$pay_later_revision+ $pay_later_completed + $pay_later_approved;
           ?>


           <div class="card">

               <div class="card-header border-bottom-0">
                <h2 class="card-title">Alpha Paybill</h2>

            </div>
            <div class="card-body">
                <table class="table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Payment</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>

                        <tr>
                            <td>Amount in Clients Wallet</td>
                            <td>{{ (int) $total_wallet_balance }}</td>
                        </tr>

                        <tr>
                            <td>Total Unpaid Orders</td>
                            <td>{{ (int) $total_unpaid }}</td>
                        </tr>


                        <tr>
                            <td>Total Earnings</td>
                            <td>{{ (int) $total }}</td>
                        </tr>

                        <tr>
                            <td>Total Pay Later</td>
                            <td>- {{ (int) $total_pay_later }}</td>
                        </tr>




                    </tbody>




                    <tfoot>
                        <tr>
                            <th>Total</th>
                            <th>KES {{ (int) ($total_wallet_balance + $total_unpaid + $total - $total_pay_later) }}</th>
                        </tr>
                    </tfoot> 
                </table>

            </div>

        </div>


        <?php
                         $total_payments_amount1 = \App\Models\Payment::select(DB::raw("
                    SUM(IF(payment_source = 'TopUp Wallet', amount, 0)) as credit_total1,
                    SUM(IF(payment_source = 'Wallet TopUp', amount, 0)) as credit_total2,
                    SUM(IF(payment_source = 'Admin Wallet TopUp', amount, 0)) as credit_total3,
                    SUM(IF(payment_source = 'account balancing', amount, 0)) as credit_total4,
                    SUM(IF(payment_source = 'custom invoice', amount, 0)) as credit_total5,
                    SUM(IF(payment_source = 'subscription', amount, 0)) as credit_total7,
                    SUM(IF(payment_source = 'Order Refund', amount, 0)) as credit_total6
                    "))
                 ->whereStatus('1')
                 ->first();

           $total_payments_amount2 = \App\Models\Payment::whereStatus('1')->wherePaybill('awasam')->sum('amount');

        ?>



                   <div class="card">

               <div class="card-header border-bottom-0">
                <h2 class="card-title">Awasam Paybill</h2>

            </div>
            <div class="card-body">
                <table class="table table-hover table-bordered">
                    <thead class="thead-dark">
                        <tr>
                            <th>Payment</th>
                            <th>Amount</th>
                        </tr>
                    </thead>
                    <tbody>


                        <tr>
                            <td>Alpha Trasactions</td>
                            <td>{{ (int) $total_payments_amount1 }}</td>
                        </tr>


                          <tr>
                            <td>Awasam Trasactions</td>
                            <td>{{ (int) $total_payments_amount2 }}</td>
                        </tr>


                    </tbody>

                </table>

            </div>

        </div>





        <!-- ROW OPEN -->
        <div class="row row-cards" style="padding-top: 20px;">
           <div class="col-lg-12 col-xl-12">


             <div class="card">

               <div class="card-header border-bottom-0">
                 <h2 class="card-title">Accounting</h2>
                 <?php
                 $total_wallet_balance = \App\Models\User::whereUserType('client')->sum('wallet');
                 $debit_totals = \App\Models\Payment::select(DB::raw("
                    SUM(IF(payment_source = 'Order paid', amount, 0)) as debit_total1,
                    SUM(IF(payment_source = 'Pay Later', amount, 0)) as debit_total2,
                    SUM(IF(payment_source = 'invoice paid', amount, 0)) as debit_total3,
                    SUM(IF(payment_source = 'Wallet Deduction', amount, 0)) as debit_total4,
                    SUM(IF(payment_source = 'custom invoice wallet deduction', amount, 0)) as debit_total5
                    "))
                 ->whereStatus('1')
                 ->first();

                 $credit_totals = \App\Models\Payment::select(DB::raw("
                    SUM(IF(payment_source = 'TopUp Wallet', amount, 0)) as credit_total1,
                    SUM(IF(payment_source = 'Wallet TopUp', amount, 0)) as credit_total2,
                    SUM(IF(payment_source = 'Admin Wallet TopUp', amount, 0)) as credit_total3,
                    SUM(IF(payment_source = 'account balancing', amount, 0)) as credit_total4,
                    SUM(IF(payment_source = 'custom invoice', amount, 0)) as credit_total5,
                    SUM(IF(payment_source = 'subscription', amount, 0)) as credit_total7,
                    SUM(IF(payment_source = 'Order Refund', amount, 0)) as credit_total6
                    "))
                 ->whereStatus('1')
                 ->first();


                 $total_debit = $debit_totals->debit_total1 + $debit_totals->debit_total2 + $debit_totals->debit_total3 
                 + $debit_totals->debit_total4 + $debit_totals->debit_total5;
                 $total_credit = $credit_totals->credit_total1 + $credit_totals->credit_total2 + $credit_totals->credit_total3 
                 + $credit_totals->credit_total4 + $credit_totals->credit_total5 + $credit_totals->credit_total6 + $credit_totals->credit_total7;
                 ?>


             </div>




             <div class="card-body">
              <div class="row">

<!-- All Credit: {{ $total_credit }}<br>
All Debit:  {{ $total_debit }}<br>
Difference: {{ $total_credit - $total_debit }}<br> -->

<!-- Total Wallet Balance: KES {{  $total_wallet_balance }} -->


<table class="table table-hover table-bordered">
    <thead class="thead-dark">
        <tr>
            <th>Payment Source</th>
            <th>Debit</th>
            <th>Credit</th>
        </tr>
    </thead>
    <tbody>

        <tr>
            <td>'Order paid'</td>
            <td>{{$debit_totals->debit_total1}}</td>
            <td>N/A</td>
        </tr>
        <tr>
            <td>'Pay Later'</td>
            <td>{{$debit_totals->debit_total2}}</td>
            <td>N/A</td>
        </tr>
        <tr>
            <td>'invoice paid'</td>
            <td>{{$debit_totals->debit_total3}}</td>
            <td>N/A</td>
        </tr>
        <tr>
            <td>'Wallet Deduction'</td>
            <td>{{$debit_totals->debit_total4}}</td>
            <td>N/A</td>
        </tr>
        <tr>
            <td>'custom invoice wallet deduction'</td>
            <td>{{$debit_totals->debit_total5}}</td>
            <td>N/A</td>
        </tr>
        <tr>
            <td>'TopUp Wallet'</td>
            <td>N/A</td>
            <td>{{$credit_totals->credit_total1}}</td>
        </tr>
        <tr>
            <td>'Wallet TopUp'</td>
            <td>N/A</td>
            <td>{{ (int) $credit_totals->credit_total2}}</td>
        </tr>
        <tr>
            <td>'Admin Wallet TopUp'</td>
            <td>N/A</td>
            <td>{{$credit_totals->credit_total3}}</td>
        </tr>
<!--         <tr>
            <td>'account balancing'</td>
            <td>N/A</td>
            <td>{{$credit_totals->credit_total4}}</td>
        </tr> -->
        <tr>
            <td>'custom invoice'</td>
            <td>N/A</td>
            <td>{{$credit_totals->credit_total5}}</td>
        </tr>
        <tr>
            <td>'Order Refund'</td>
            <td>N/A</td>
            <td>{{$credit_totals->credit_total6}}</td>
        </tr>

        <tr>
            <td>'Subscriptions'</td>
            <td>N/A</td>
            <td>{{$credit_totals->credit_total7}}</td>
        </tr>


    </tbody>

    <tfoot>
        <tr>
            <th>Total Amount in Wallet </th>
            <th>KES {{ (int) $total_wallet_balance }}</th>
            <th></th>
        </tr>
    </tfoot> 


<!--     <tfoot>
        <tr>
            <th>Total</th>
            <th>{{$total_debit}}</th>
            <th>{{$total_credit}}</th>
        </tr>
    </tfoot> -->
</table>





</div>

</div>


</div>

<div class="mb-5">

   <div class="float-end">




   </div>
</div>
</div>

<?php


$total_payments_amount = \App\Models\Payment::whereStatus('1')->wherePaymentSource('subscription')->sum('amount');
$total_expense = \App\Models\Expense::sum('amount');

$total_order_fee             = \App\Models\Order::whereStatus(5)->where('subscription_fee', '>', '0')->sum('subscription_fee');
$total_admin_share           =  \App\Models\Order::whereStatus(5)->where('order_admin_share', '>', '0')->sum('order_admin_share');
$plagiarism_report_fee       =  \App\Models\Order::whereStatus(5)->sum('plagiarism_report_fee');
$preferred_writer_only_total =  \App\Models\Order::whereStatus(5)->sum('preferred_writer_only_total');
$top_ten_total               =  \App\Models\Order::whereStatus(5)->sum('top_ten_total');

$total = $total_payments_amount+$total_order_fee+$total_admin_share+$plagiarism_report_fee + $preferred_writer_only_total + $top_ten_total-$total_expense;

$unpaid_available    =  \App\Models\Order::whereStatus(1)->wherePayments(0)->whereWriterPaid('unpaid')->sum('wcost');
$unpaid_inprogress   =  \App\Models\Order::whereStatus(2)->wherePayments(0)->whereWriterPaid('unpaid')->sum('wcost');
$unpaid_editing     =  \App\Models\Order::whereStatus(3)->wherePayments(0)->whereWriterPaid('unpaid')->sum('wcost');
$unpaid_revision    =  \App\Models\Order::whereStatus(6)->wherePayments(0)->whereWriterPaid('unpaid')->sum('wcost');
$unpaid_completed     =  \App\Models\Order::whereStatus(4)->wherePayments(0)->whereWriterPaid('unpaid')->sum('wcost');
$unpaid_approved      =  \App\Models\Order::whereStatus(5)->wherePayments(1)->whereWriterPaid('unpaid')->sum('wcost');



$total_unpaid = $unpaid_available + $unpaid_inprogress + $unpaid_editing + $unpaid_revision + $unpaid_completed + $unpaid_approved;

$unpaid_inprogress = $unpaid_available + $unpaid_inprogress + $unpaid_editing + $unpaid_revision;

$pay_later_available  =  \App\Models\Order::whereStatus(1)->wherePaymentWay(1)->sum('ccost');
$pay_later_inprogress =  \App\Models\Order::whereStatus(2)->wherePaymentWay(1)->sum('ccost');
$pay_later_editing    =  \App\Models\Order::whereStatus(3)->wherePaymentWay(1)->sum('ccost');
$pay_later_revision   =  \App\Models\Order::whereStatus(6)->wherePaymentWay(1)->sum('ccost');

$pay_later_completed  =  \App\Models\Order::whereStatus(4)->wherePaymentWay(1)->sum('ccost');
$pay_later_approved   =  \App\Models\Order::whereStatus(5)->wherePaymentWay(1)->sum('ccost');

$total_pay_later = $pay_later_available + $pay_later_inprogress + $pay_later_editing +$pay_later_revision+ $pay_later_completed + $pay_later_approved;

$total_paid_writer     =  \App\Models\Order::wherePayments(2)->sum('wcost');
$total_paid_editor     =  \App\Models\Order::whereEpayments(2)->sum('ecost');





?>



<div>
    <h1>Admin Earnings</h1>
    <!-- Canvas to render the bar chart -->
    <canvas id="barChart"></canvas>

    <script>
        // Get the calculated values from your PHP variables
        const totalOrderFee = <?php echo $total_order_fee; ?>;
        const totalAdminShare = <?php echo $total_admin_share; ?>;
        const plagiarismReportFee = <?php echo $plagiarism_report_fee; ?>;
        const preferredWriterTotal = <?php echo $preferred_writer_only_total; ?>;
        const topTenTotal = <?php echo $top_ten_total; ?>;
        const subscriptions = <?php echo $total_payments_amount; ?>;

        // Get the canvas element
        const barChartCanvas = document.getElementById('barChart');

        // Create the bar chart using Chart.js
        new Chart(barChartCanvas, {
            type: 'bar',
            data: {
                labels: ['Total Order Fee', 'Total Admin Share', 'Plagiarism Report Fee', 'Preferred Writer Total', 'Top Ten Total', 'Subscriptions'],
                datasets: [{
                    label: 'Amount',
                    data: [totalOrderFee, totalAdminShare, plagiarismReportFee, preferredWriterTotal, topTenTotal, subscriptions],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.5)',
                        'rgba(54, 162, 235, 0.5)',
                        'rgba(255, 206, 86, 0.5)',
                        'rgba(75, 192, 192, 0.5)',
                        'rgba(153, 102, 255, 0.5)',
                        ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                        ],
                    borderWidth: 1,
                }],
            },
            options: {
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            precision: 0, // Show whole numbers only on the y-axis
                        },
                    },
                },
            },
        });
    </script>
</div>



</div>
<!-- ROW CLOSED -->
</div>
</div>
</div>
@endsection