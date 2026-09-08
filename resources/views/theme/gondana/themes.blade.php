@extends('layouts.frontbar')

@section('content')



<!--app-content open-->
<div class="container">
  <div class="">

    <!-- CONTAINER -->
    <div class="main-container container-fluid">



      <!-- Row -->
      <div class="row" style="margin-top: 30px;">

        <div class="col-xl-12">



          <div class="panel-body tabs-menu-body p-0 border-0">
            <div class="tab-content">
             <h1 class="">Academic Writing Website Script Themes</h1>
             <div class="tab-pane active" id="tab5">
              <div class="row">
               @foreach($themes as $theme)    

                  
                <div class="col-xl-6 col-lg-6 mb-5 pb-5 animation-zidex pos-relative">

                <div class="card">

                  <div class="card-body h-100">

                    <img class="d-block w-100 br-5" alt="" src="{{ $theme->image }}" data-bs-holder-rendered="true">

                    <h3 class="card-title">{{ $theme->name }}</h3>

                    <a target="_blank" href="{{ $theme->demo_url }}"
                      class="btn btn-primary"> Click here to preview demo
                   </a>
                     </div>
               </div>
             </div>


            @endforeach

           </div>
         </div>



       </div>
     </div>
     <div class="text-center">
      <div class="mb-5">
        <ul class="pagination justify-content-center">

         {{$themes->links("pagination::bootstrap-4")}}
       </ul>
     </div>
   </div>
 </div>


</div>
<!-- End Row -->


<div class="container">
  <div class="row">

    <span class="landing-title"></span>
    <h2 class="fw-semibold text-center">Demo Logins</h2>

    <p class="text-default mb-5 text-center">Logins as a writer, client, editor, and admin</p>
  </div>
  <div class="row text-center services-statistics landing-statistics">
    <div class="col-xl-3 col-md-6 col-lg-6">
      <div class="card">
        <div class="card-body bg-primary-transparent">
          <div class="counter-status">
            <div class="counter-icon bg-primary-transparent box-shadow-primary">
              <i class="fe fe-layers text-primary fs-23"></i>
            </div>
            <div class="test-body text-center">

             <h4 class="fw-bold">Admin Account</h4>
             <div class="counter-text">
              <h5 class="font-weight-normal mb-0 ">Demo logins<br>
                Email: admin@demo.com Password: 12345678
                <br><br>
                <a target="_blank" href="https://demo.gondana.com/admin" class="btn btn-primary"> Demo Preview
           </a>
              </h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6 col-lg-6">
    <div class="card">
      <div class="card-body bg-secondary-transparent">
        <div class="counter-status">
          <div class="counter-icon bg-secondary-transparent box-shadow-secondary">
            <i class="fe fe-wind text-secondary fs-23"></i>
          </div>
          <div class="text-body text-center">
            <h4 class="fw-bold">Client Account</h4>
            <div class="counter-text">
              <h5 class="font-weight-normal mb-0 ">Demo logins<br>
                Email: client@demo.com Password: 12345678 <br><br>

              </h5>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="col-xl-3 col-md-6 col-lg-6">
    <div class="card">
      <div class="card-body bg-success-transparent">
        <div class="counter-status">
          <div class="counter-icon bg-success-transparent box-shadow-success">
            <i class="fe fe-user text-success fs-23"></i>
          </div>
          <div class="text-body text-center">
           <h4 class="fw-bold">Writer Account</h4>
           <div class="counter-text">
            <h5 class="font-weight-normal mb-0 ">Demo logins<br>
              Email: writer@demo.com Password: 12345678<br><br>
            </h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<div class="col-xl-3 col-md-6 col-lg-6">
  <div class="card">
    <div class="card-body bg-danger-transparent">
      <div class="counter-status">
        <div class="counter-icon bg-danger-transparent box-shadow-danger">
          <i class="fe fe-grid text-danger fs-23"></i>
        </div>
        <div class="text-body text-center">
          <h4 class="fw-bold">Editor Account
          </h4>
          <div class="counter-text">
            <h5 class="font-weight-normal mb-0 ">Demo logins<br>
              Email: editor@demo.com Password: 12345678 <br><br>

            </h5>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>





</div>


  <div class="row">
 <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
     <div class="card p-3 pricing-card reveal revealrotate">
        <div class="card-body">
          {!! get_option(site_id().'_show_18_content') !!}  
      </div>
  </div>
</div>

</div>


</div>


</div>
<!-- CONTAINER CLOSE -->

</div>
</div>




<!-- Perfect SCROLLBAR JS-->
<script src="{{ asset('assets/plugins/p-scroll/perfect-scrollbar.js')}}"></script>
<script src="{{ asset('assets/plugins/p-scroll/pscroll.js')}}"></script>
<script src="{{ asset('assets/plugins/p-scroll/pscroll-1.js')}}"></script>


@endsection