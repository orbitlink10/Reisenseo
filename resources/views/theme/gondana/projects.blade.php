@extends('layouts.frontbar')

@section('content')


<div style="background-color: #F8F9FB;">
<!--app-content open-->
<div class="container">
    <div class="">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">

@if(get_option(site_id().'_show_2_content'))
          <div class="row">
             <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
                 <div class="card p-3 pricing-card reveal revealrotate">
                    <div class="card-body">
                      {!! get_option(site_id().'_show_2_content') !!}  
                  </div>
              </div>
          </div>

      </div>

      @endif


      <!-- Row -->
      <div class="row">

        <div class="col-xl-12">
          <br><br>
           <h1>{{ $title }}</h1>

           <div class="row">
             @foreach($posts as $post)       


             <div class="col-sm-4">
              <div class="card">
                <div class="card-body">

                  <div class="mb-2 text-center">
                 
                    @if($post->image_url)
                    <img src="{{ $post->image_url }}" alt="" title="" width="300">


                    @else

                    <img src="https://awasam.com/assets/images/landing/market5.png" alt="" width="300" title="">
                    @endif


<div><br></div>

                    <a href="https://{{ $post->domain_name }}" target="_blank"  class="h4 text-dark">{{ $post->domain_name }}</a>





              </div>



          </div>
      </div>

  </div>




  @endforeach
</div>





<div class="text-center">
    <div class="mb-5">
        <ul class="pagination justify-content-center">

           {{$posts->links("pagination::bootstrap-4")}}
       </ul>
   </div>
</div>
</div>


</div>
<!-- End Row -->
</div>
<!-- CONTAINER CLOSE -->

</div>
</div>
</div>
@endsection