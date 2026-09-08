@extends('layouts.frontbar')

@section('content')



<!--app-content open-->
<div class="container">
    <div class="">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">
            <!-- ROW-1 OPEN -->
            <div class="row">
                <div class="col-xl-12">

                    @if(Auth::check())
                    @if(Auth::user()->is_admin())
                    <a target="_blank" href="{{ route('edit_training', $product->id) }}">Edit Program</a>
                    @endif
                    @endif


                    <div class="card">
                        <div class="card-body">
                            <div class="row row-sm">
                                <div class="col-xl-5 col-lg-12 col-md-12">
                                    <div class="row">
                                        <div class="col-xl-12">

                                            <div class="product-carousel">

                                                <div id="Slider" class="carousel slide border" data-bs-ride="false">
                                                    <div class="">
                                                      <?php $i=0; ?>
                                                      @foreach($uploads as $upload)
                                                      @if($i==0)
                                                      <div class="carousel-item active">
                                                        @else
                                                        <div class="carousel-item">  
                                                            @endif

                                                            <img src="{{ url('/') }}/{{ $upload->file_path }}" alt="img" class="img-fluid mx-auto d-block">
                                                            <div class="text-center mt-5 mb-5 btn-list">
                                                            </div>
                                                        </div>
                                                        <?php $i=$i+1; ?>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>


                                            <div class="clearfix carousel-slider">
                                                <div id="thumbcarousel" class="carousel slide" data-bs-interval="t">
                                                    <div class="carousel-inner">
                                                        <ul class="carousel-item active">
                                                            <?php $x=0; ?>
                                                            @foreach($uploads as $upload)
                                                            <li data-bs-target="#Slider" data-bs-slide-to="{{ $x }}" class="thumb active m-2"><img src="{{ url('/') }}/{{ $upload->file_path }}" alt="img"></li>
                                                            <?php $x=$x+1; ?> 
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                                <div class="details col-xl-7 col-lg-12 col-md-12 mt-4 mt-xl-0">
                                    <div class="mt-2 mb-4">
                                        <h3 class="mb-3 fw-semibold">{{ $product->title }}</h3>




                                        <h3 class="mb-4"><span class="me-2 fw-bold fs-25">{{ price($product->cost) }}</span><span><!-- <del class="fs-18 text-muted">$599</del> --></span></h3>



                                        <hr>
                                        <h4 class="mt-4"><b> Description</b></h4>
                                        <p>{!! $product->meta_description !!}</p>


                                        <div class="btn-list mt-4">


  <a href="{{ route('pregister', ['id' => $product->id ]) }}"
                                         class="btn ripple btn-min w-lg btn-outline-primary mb-3 me-2"><i
                                         class="fa fa-sign-in me-2"></i>Apply Now
                                     </a>
        

                     


<img onclick="smartsupp('chat:open');">
<a class="btn ripple btn-min w-lg mb-3 me-2 btn-primary" href="#" onclick="smartsupp('chat:open'); return false;">Get In Tounch</a>


                                      
                                 </div>
                             </div>
                         </div>
                     </div>
                 </div>
             </div>
         </div>

                              






     </div>

             <div class="col-xl-12 col-md-12">
                                <div class="card productdesc">
                                    <div class="card-body">
                                        <div class="panel panel-primary">
                                            <div class=" tab-menu-heading">
                                                <div class="tabs-menu1">
                                                    <!-- Tabs -->
                                                    <ul class="nav panel-tabs">
                                                        <li><a href="#tab5" class="active" data-bs-toggle="tab">{{ $product->title }} Overview</a></li>
                                                        <li><a href="#tab6" data-bs-toggle="tab">What you’ll learn</a></li>
                                                        <li><a href="#tab7" data-bs-toggle="tab">Requirements</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="panel-body tabs-menu-body">
                                                <div class="tab-content">

                                                    <div class="tab-pane active" id="tab5">
              {!! $product->description !!}
                                                    </div>

                                                    <div class="tab-pane pt-5" id="tab6">
                                                        <div class="table-responsive">
                                                          
                                                        </div>
                                                    </div>
                                                    <div class="tab-pane" id="tab7">
                                                  
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>







                                                                <?php
  $services =\App\Models\Service::wherePostId($product->id)->get();

?>

       @if($services->count()>0)
                            <div class="col-xl-12 col-md-12">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title"></div>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">

      


              @foreach($services as $new)
                                            <div class="col-xl-6">
                                                <div class="customer-services mb-2">
                                                    <div class="icon-content">
                                                        <span><i class="bi bi-check"></i></span>
                                                        <h4>{{ $new->name }}</h4>
                                                    </div>
                                                {!! $new->description !!}
                                                </div>
                                            </div>
                                                       @endforeach
                               
                                        </div>
                                    </div>
                                </div>
                            </div>

                               @endif


 </div>
 <!-- CONTAINER CLOSE -->





</div>
</div>
@endsection