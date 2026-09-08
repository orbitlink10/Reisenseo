@extends('layouts.frontbar')
@section('title')@if( ! empty($title)){{$title}} @endif @endsection
@section('description') @if( ! empty($post->description)){{ substr(trim(preg_replace('/\s\s+/', ' ',strip_tags($post->description) )),0,160) }}@endif  @endsection



@section('social-meta')

@if($post->parent_page == 5)
<link rel="canonical" href="{{ route('blog_single', $post->slug) }}" />
@elseif($post->parent_page == 7)
<link rel="canonical" href="{{ route('question_single', $post->slug)}}" />
@elseif($post->parent_page == 10)
<link rel="canonical" href="{{ route('sample_single', $post->slug)}}" />
@elseif($post->parent_page == 12)
<link rel="canonical" href="{{ route('programming_single', $post->slug)}}" />
@else
<link rel="canonical" href="{{ route('blog_single', $post->slug) }}" />
@endif



<meta property="og:title" content="{{ $post->keywords }}">
<meta property="og:description" content="{{ substr(trim(preg_replace('/\s\s+/', ' ',strip_tags($post->meta_description) )),0,160) }}">


@if($post->parent_page == 5)
<meta property="og:url" content="{{ route('blog_single', $post->slug) }}">
@elseif($post->parent_page == 7)

<meta property="og:url" content="{{ route('question_single', $post->slug)}}">
@elseif($post->parent_page == 10)
<meta property="og:url" content="{{ route('sample_single', $post->slug)}}">
@elseif($post->parent_page == 12)
<meta property="og:url" content="{{ route('programming_single', $post->slug)}}">
@else
<meta property="og:url" content="{{ route('blog_single', $post->slug) }}">
@endif


<meta name="twitter:card" content="summary_large_image">
<!--  Non-Essential, But Recommended -->
<meta name="og:site_name" content="">
@endsection
@section('content')



<!--app-content open-->
<div>
    <div>

        <!-- CONTAINER -->
        <div class="container">



            <div class="row">

                @if(Auth::check())
                @if(Auth::user()->is_admin())
                <a target="_blank" href="{{ route('edit_post', $post->id) }}">Edit Page</a>
                @endif
                @endif


                <div class="col-xl-8">
                    <div class="card">


                        <div class="card-body">
                            <h1>{{ $post->title }}</h1>
                            <hr style="background-color: #c3c5cf;">
                            {!! $post->description !!}



                            <div><br></div>
                            @if($post->cost > 0)

      <a class="btn text-answer-btn btn-primary" style="box-sizing: border-box; color: #ffffff; background: #de1c1c; text-decoration: none; appearance: button; display: inline-block; font-weight: 400; text-align: center; vertical-align: middle; user-select: none; border: 1px solid transparent; padding: 6px 12px; font-size: 18px; line-height: 1.42857; border-radius: 4px; transition: all 0.8s ease-in-out 0s; margin-bottom: 0px; white-space: nowrap; touch-action: manipulation; cursor: pointer;" href="{{ url('order')}}" type="button">Hire an expert for a simalar project starting at {{ price($post->cost) }}</a>

                           @endif



                       </div>
                   </div>



               </div>
               <div class="col-xl-4">
                <div class="card">
                    <div class="card-body">
                       <form action="{{ route('qpost')}}" method="GET">
                        <div class="input-group mb-2">
                            <input type="text" name="q" class="form-control border-end-0" placeholder="Search ...">
                            <button class="btn input-group-text bg-transparent border-start-0 text-muted">
                                <i class="fe fe-search" aria-hidden="true"></i>
                            </button>
                        </div>


                    </form>

                </div>
            </div>

   <!--          <div class="card">
                <div class="card-header">
                    <div class="card-title">Services</div>
                </div>
                <div class="card-body">
                    <ul class="list-group">
                        @foreach($services as $service)
                        <li class="list-group-item border-0 p-0"><a href="javascript:void(0)"><i class="fe fe-chevron-right"></i> {{ $service->name }}</a> <span class="product-label"><br></span> 
                        </li>

                        @endforeach

                    </ul>
                </div>
            </div> -->

    <!--         <div class="card">
                <div class="card-header">
                    <div class="card-title">Professional Experts</div>
                </div>
                <div class="card-body">
                    <div class="">


                       @foreach($users as $user)
                       <div class="d-flex overflow-visible">
                        <img class="avatar bradius avatar-xl me-3" src="{{ $user->get_gravatar(150) }}" alt="avatar-img">
                        <div class="media-body valign-middle">
                            <a href="{{ route('profile', $user->slug )}}" class="fw-semibold text-dark">{{ $user->nickname }}
                            </a>
                            <p class="text-muted mb-0">  Completed orders<span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">{{ writer_counter($user->id, 4) + writer_counter($user->id, 5)}}</span><br>
                                In progress orders<span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">{{ writer_counter($user->id, 2)}}</span>
                            </p>
                        </div>
                    </div>

                    @endforeach                            


                </div>
            </div>
        </div> -->


        @include('theme.gondana.sidebar') 




    </div>
</div>
</div>
<!-- CONTAINER CLOSED -->
</div>
</div>
<!--app-content closed-->
</div>


                                        @endsection