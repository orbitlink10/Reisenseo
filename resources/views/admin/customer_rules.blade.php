@extends('layouts.appbar')

@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
   <div class="side-app">

     <!-- CONTAINER -->
     <div class="main-container container-fluid">

        <h1>
            Recommendations
        </h1>


        <!-- ROW-2 OPEN -->
        <div class="row">
         
            <div class="col-sm-12 col-md-12 col-lg-12 col-xl-12">
                <div class="card">
                    <div class="card-body">
                       {!! get_option(site_id().'_customer_rule') !!}
                   </div>
               </div>
           </div>
           
           
       </div>
       <!-- ROW-2 CLOSE -->


   </div>
</div>
</div>





@endsection