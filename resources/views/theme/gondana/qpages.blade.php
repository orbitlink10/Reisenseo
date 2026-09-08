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
           <h1>Services</h1>

           <div class="row">
             @foreach($posts as $post)       


             <div class="col-sm-4">
              <div class="card">
                <div class="card-body">

                  <div class="mb-2 text-center">
                    <?php
                    $logo =\App\Models\Upload::wherePostId($post->id)->whereStatus('1')->first();
                    ?>
                    @if($logo)
                    <img src="{{ url('/') }}{{ $logo->file_path }}" alt="" title="" width="300">


                    @else

                    <img src="https://awasam.com/assets/images/landing/market5.png" alt="" width="300" title="">
                    @endif


<div><br></div>

                    <a href="{{ post_path($post->id) }}"  class="h4 text-dark">{!! strip_tags(\Illuminate\Support\Str::limit($post->title, 30)) !!}</a>



                    <div>
                     <img src="{{ username($post->writer_id)->get_gravatar(30) }}"  />
                      <a href="javascript:void(0)" class="me-4 d-inline-block">{{ username($post->writer_id)->name }}</a> 
                      <a href="javascript:void(0)" class="fw-semibold"><i class="fa fa-clock-o"></i> {{ $post->created_at->diffForHumans() }}</a> 


                  </div>


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