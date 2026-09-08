@extends('layouts.frontbar')
@section('title')@if( ! empty($title)){{$title}} |@endif @parent @endsection
@section('content') 

<!-- ROW-6 OPEN -->
<div class="bg-landing section bg-image-style" id="Pricing">
  <div class="container">
    <div class="row">
      <span class="landing-title"></span>
      <h1 class="text-center fw-semibold">Welcome to <span class="text-primary"> {{ domain_name() }} </span> connect</h1>
      <div class="row">

                            <div class="col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <i class="fa fa-users text-primary fa-3x"></i>
                                   
                                        <h2 class="mb-2 number-font">Our Writers</h2>
                                        <p class="text-muted">Our writers are handpicked for their extensive knowledge, expertise, and passion for their respective academic fields. Every Saseni writer brings something unique to the table, whether it's an in-depth understanding of a scientific domain or a flair for creative literary expression.</p>
                                        <br>
                                                    <a href="{{ route('experts')}}"
           class="btn ripple btn-min w-lg btn-outline-primary mb-3 me-2"
            >Browse & Hire
          </a>
                                    </div>
                                </div>
                            </div>


                          <div class="col-sm-6 col-md-4 col-lg-6 col-xl-6">
                                <div class="card">
                                    <div class="card-body text-center">
                                        <i class="fa fa-user text-primary fa-3x"></i>
                             
                                        <h2 class="mb-2 number-font">Editors</h2>
                                        <p class="text-muted">At Saseni Connect, quality is not merely an aspiration; it's a commitment. Our editors play a crucial role in this promise by thoroughly reviewing and refining each paper. Saseni editors meticulously examine every document for coherence, grammar, punctuation, and style.</p>

 <br>
                                        <a href="/editors"
           class="btn ripple btn-min w-lg btn-outline-primary mb-3 me-2"
            > Browse & Hire
          </a>
                                    </div>
                                </div>
                            </div>

                                                 









   </div>


   <div class="row">
 <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
     <div class="card p-3 pricing-card reveal revealrotate">
        <div class="card-body">
          {!! get_option(site_id().'_show_4_content') !!}  
      </div>
  </div>
</div>

</div>


 </div>
</div>
</div>
<!-- ROW-6 CLOSED -->

@endsection


