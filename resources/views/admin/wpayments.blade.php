@extends('layouts.appbar')

@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
 <div class="side-app">

   <!-- CONTAINER -->
   <div class="main-container container-fluid">



    <!-- ROW OPEN -->
    <div class="row row-cards" style="padding-top: 20px;">
     <div class="col-lg-12 col-xl-12">

    
      <div class="card">
       <div class="card-header border-bottom-0">
         <h2 class="card-title">Recent approved orders</h2>

         <div class="page-options ms-auto">



          <a href="{{ route('wpayments', ['status'=>'1']) }}" class="btn btn-primary btn-sm"> Unpaid </a>

                    <a href="{{ route('wpayments', ['status'=>'2']) }}" class="btn btn-primary btn-sm"> Paid </a> 
          <?php 
    $now  = \Carbon\Carbon::now();
    $day  =  $now->day;
          ?>

<!--           @if($day > 15 and $day < 20)
          <a class="btn btn-sm btn-warning badge" data-bs-target="#edit-property" data-bs-toggle="modal"><i class="fa fa-edit"></i> Send Invoice
          </a> 
          @endif

          @if($day > 0 and $day < 5)
          <a class="btn btn-sm btn-warning badge" data-bs-target="#edit-property" data-bs-toggle="modal"><i class="fa fa-edit"></i> Send Invoice
          </a> 
          @endif -->


          <!-- edit modal-->
          <div class="modal fade" id="edit-property">
           <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content country-select-modal">
               <div class="modal-header">
                 <h6 class="modal-title">Request payments  KES {{ writer_balance(Auth::user()->id) }} for unpaid orders</h6><button aria-label="Close" class="btn-close"
                 data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
               </div>
               <div class="modal-body">
                 <form class="form-horizontal" action="{{ route('send_invoice')}}" method="POST">
                   @csrf

                   <div class=" row mb-4">

                     <div class="col-md-9">
                      <p>Are you sure you want to submit the request</p>
                    </div>
                  </div>




                  <div class=" row mb-4">

                   <div class="col-md-9">
                    <input type="submit" value="Submit" class="btn btn-primary">
                  </div>


                </div>



              </form>
            </div>
          </div>
        </div>
      </div>

    </div>

  </div>

    @if($payments->count()>0)
  <div class="e-table px-5 pb-5">
   <div class="table-responsive table-lg">
     <table class="table border-top table-bordered mb-0">
       <thead>
         <tr>
           <th class="text-center">
             Order Id
           </th>

           <th>Title</th>
           <th>Amount</th>
           <th>Status</th>
         </tr>
       </thead>
       <tbody>


        @foreach($payments as $property)
        <tr>
         <td class="align-middle text-center">

           #{{ $property->id }}
         </td>

         <td class="text-nowrap align-middle">{{ $property->title }}</td>
         <td class="text-nowrap align-middle"><span>{{price( (int) $property->wcost)}}</span></td>
         <td class="text-nowrap align-middle">
          <div class="mt-sm-1 d-block">
          

           @if($property->payments==1)
            <span class="badge bg-success-transparent rounded-pill text-danger p-2 px-3">unpaid</span>
            @endif

           @if($property->payments==2)
            <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">paid</span>
            @endif

       


          </div>
        </td>



      </tr>




      @endforeach




    </tbody>
  </table>
</div>
</div>
@else
<tr>No recent trasaction</tr>
@endif
</div>


<div class="mb-5">

 <div class="float-end">

   {{$payments->links("pagination::bootstrap-4")}}

 </div>
</div>
</div>
<!-- COL-END -->


</div>
<!-- ROW CLOSED -->


</div>
</div>
</div>





@endsection