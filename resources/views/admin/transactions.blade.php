     @extends('layouts.appbar')

     @section('content')      <!--app-content open-->
     <div class="main-content app-content mt-0">
        <div class="side-app">


            <!-- CONTAINER -->
            <div class="main-container container-fluid">

                <!-- ROW-4 -->
                <div class="row" style="padding-top: 20px;">
                  




    <h3>Mpesa Transactions</h3>

<div class="col-12 col-sm-12">
    <div class="card">
  
        <div class="card-header">

            <div class="card-body pt-4">
                <div class="grid-margin">
                    <div class="">
                        <div class="panel panel-primary">

                            <div class="panel-body tabs-menu-body border-0 pt-0">
                             <div class="tab-content">
                                <div class="tab-pane active" id="tab5">
                                    <div class="table-responsive">
                                       @if($transactions->count()>0)
                                       <table id="data-table"
                                       class="table table-bordered text-nowrap mb-0">
                                       <thead class="border-top">
                                        <tr>
                                            <th class="bg-transparent border-bottom-0"
                                            style="width: 5%;">Id</th>
                                            <th
                                            class="bg-transparent border-bottom-0">
                                        User</th>

                                        <th
                                        class="bg-transparent border-bottom-0">
                                    Trasaction</th>
                                    <th
                                    class="bg-transparent border-bottom-0">
                                Date</th>

                                <th class="bg-transparent border-bottom-0"
                                style="width: 10%;">Amount</th>

                            </tr>
                        </thead>
                        <tbody>

                            @foreach($transactions as $invoice)
                            <tr class="border-bottom">
                                <td class="text-center">
                                    <div class="mt-0 mt-sm-2 d-block">
                                        <h6
                                        class="mb-0 fs-14 fw-semibold">
                                        #{{ $invoice->id}}</h6>
                                    </div>
                                </td>

                                                                <td>
                                    <div class="d-flex">
                                        <a href="">
                                     +{{ $invoice->phone }}
</a>
                                 </div>
                             </td>

                                <td>
                                    <div class="d-flex">
                                        <a href="">
             {{ $invoice->MpesaReceiptNumber }}
</a>
                                 </div>
                             </td>

                             <td>
                                <span class="mt-sm-2 d-block">
                                    {{ $invoice->updated_at }}
                                </span>
                            </td>
                            <td>
                                {{ $invoice->Amount }}


                            </td>

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
                        @if($invoice->status==0) 
                         <td class="text-center align-middle">
                            <div class="btn-group align-top">
                                <a class="btn btn-sm btn-primary badge" data-bs-target="#edit-finance{{ $invoice->id }}" data-bs-toggle="modal"><i class="fa fa-edit"></i> Manage</a> 
                            </div>
                        </td>
                        @endif
                    </tr>


                    <!-- edit modal-->
                    <div class="modal fade" id="edit-finance{{ $invoice->id }}">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content country-select-modal">
                                <div class="modal-header">
                                    <h6 class="modal-title">Aprove this payment #{{ $invoice->id }}</h6><button aria-label="Close" class="btn-close"
                                    data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                                </div>
                                <div class="modal-body">
                                   <form class="form-horizontal" action="{{ route('approve_payment')}}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $invoice->id }}">
                                    <div class=" row mb-4">
                                       <p>Are you sure you want to approve this payment</p>
                                    </div>





                                    <div class=" row mb-4">

                                        <div class="col-md-9">
                                         <input type="submit" value="Yes proceed" class="btn btn-primary">
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
     <tr>No subscription for this month</tr>
     @endif
 </div>
</div>


</div>
</div>


{{$transactions->links("pagination::bootstrap-4")}}
</div>
</div>
</div>
</div>
</div>
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