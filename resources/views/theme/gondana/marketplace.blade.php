@extends('layouts.frontbar')
@section('title')@if( ! empty($title)){{$title}} |@endif @parent @endsection
@section('content') 

<!-- ROW-6 OPEN -->
<div class="bg-landing section bg-image-style" id="Pricing">
  <div class="container">
    <div class="row">
      <span class="landing-title"></span>
      <h1 class="text-center fw-semibold">Welcome to the <span class="text-primary">{{ domain_name() }} </span> marketplace!</h1>
      <div class="row">

        <?php
        $posts = \App\Models\Post::whereType('product')->orderBy('id', 'asc')->get();
        ?>

        @foreach($posts as $post)

        <div class="col-lg-4 col-xl-4 col-md-8 col-sm-12">
          <a href="{{ route('shop_description', $post->slug)}}">
          <div class="card p-3 pricing-card reveal revealrotate">
           

           <div class="card-body">


             <?php
             $logo =\App\Models\Upload::wherePostId($post->id)->whereStatus('1')->first();
             ?>
             @if($logo)

             <img class="lazyImg" src="{{ get_option(site_id().'_main_site_url') }}{{ $logo->file_path }}" alt="{{ parentpage($post->parent_page) }}">
             @endif

             <div style="margin-top: 20px;" class="text-center">
                 <h4>{{ $post->title }}</h4>   

              <h4>{{ price($post->cost)}}</h4>

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


