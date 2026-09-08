@extends('layouts.frontbar')
@section('title')@if( ! empty($title)){{$title}} |@endif @parent @endsection


@section('social-meta')
<link rel="canonical" href="{{ route('page_single', $post->slug) }}" />
<meta property="og:title" content="{{ $post->keywords }}">
<meta property="og:description" content="{{ substr(trim(preg_replace('/\s\s+/', ' ',strip_tags($post->meta_description) )),0,160) }}">

<meta property="og:url" content="{{ route('page_single', $post->slug) }}">
<meta name="twitter:card" content="summary_large_image">
<!--  Non-Essential, But Recommended -->
<meta name="og:site_name" content="">
@endsection




@section('content')

<!-- Service-section -->
<section class="service-section pt-100 pb-70">
  <div class="container">
    <div class="row">
@if(Auth::check())
@if(Auth::user()->is_admin())
      <a target="_blank" href="{{ route('edit_page', $post->id) }}">Edit Page</a>
@endif
@endif

      <div class="col-xl-8">
        <div class="card">
          <div class="card-body">

            <h1>{{ $post->title }}</h1>

            <hr style="background-color: #c3c5cf;">

            <?php
            $logo =\App\Models\Upload::wherePostId($post->id)->whereStatus('1')->first();
            ?>
            @if($logo)
            <img src="{{ url('/') }}{{ $logo->file_path }}" alt="{{ $post->title}}" title="{{ $post->title}}">
            @else

            @endif


            {!! $post->description !!}



      
<div class="card">
  <br>
   <h3 style="color: green;">Here is the full answer</h3> 
  <div class="card-body">
  
 {!! $post->post_answer !!}
  </div>
</div>
  




          </div>
        </div>



      </div>


      

      <div class="col-lg-4 pb-30">

       @include('theme.saseni.sidebar')    


     </div>



   </div>
 </div>
</section>
<!-- Service-section -->


@endsection

@section('page-js')

<script>
  @if(session('success'))
  toastr.success('{{ session('success') }}', '<?php echo trans('app.success') ?>', toastr_options);
  @endif
</script>
@endsection