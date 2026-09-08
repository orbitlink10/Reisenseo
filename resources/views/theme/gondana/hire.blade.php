@extends('layouts.frontbar')
@section('title')@if( ! empty($title)){{$title}} |@endif @parent @endsection
@section('content') 

<!-- ROW-6 OPEN -->
<div class="bg-landing section bg-image-style" id="Pricing">
  <div class="container">
    <div class="row">
      <span class="landing-title"></span>
      <h1 class="text-center fw-semibold">Browse <span class="text-primary"> {{ domain_name() }} writers</span> by subject!</h1>
      <div class="row">

        <?php
        $posts = \App\Models\Category::orderBy('id', 'asc')->get();
        ?>

        @foreach($posts as $post)

                <?php
        $subject_count = \App\Models\Order::whereCategoryId($post->id)->count();
        ?>

        <div class="col-lg-4 col-xl-4 col-md-8 col-sm-12">
          <a href="">
          <div class="card">
           

           <div class="card-body">




             <div class="text-center">

              <a href="{{ route('experts', ['subject' => $post->id ]) }}">
                 <h4>{{ $post->name }} ({{ $subject_count }})</h4>   

   </a>

           </div>


         </div>
       </div>
       </a>
     </div>


     @endforeach










   </div>


   <div class="row">
 <div class="col-lg-12 col-xl-12 col-md-12 col-sm-12">
     <div class="card p-3 pricing-card reveal revealrotate">
        <div class="card-body">
          {!! get_option(site_id().'_show_21_content') !!}  
      </div>
  </div>
</div>

</div>


 </div>
</div>
</div>
<!-- ROW-6 CLOSED -->

@endsection


