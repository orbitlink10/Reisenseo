@extends('layouts.appbar')



@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
   <div class="side-app">

       <!-- CONTAINER -->
       <div class="main-container container-fluid">



        <!-- ROW OPEN -->
        <div class="row row-cards" style="padding-top: 20px;">
        

   <div class="col-lg-8 col-xl-8">
     <div class="card">
       <div class="card-header">
           <h4 class="card-title">Add funds</h4>
       </div>
       <div class="card-body">

        <form class="form-horizontal" method="POST" action="{{ route('make_deposit') }}" enctype="multipart/form-data">
            @csrf
   
            <div class="row">
                <div class="col-sm-12">


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

       <div class="form-group">
        
        
                 
        
        
        <button type="submit" id="button" class="btn btn-primary">Deposit Now</button>
        </div>
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