@extends('layouts.frontbar')

@section('content')



<!--app-content open-->
<div class="container">
    <div class="">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">



            <!-- Row -->
            <div class="row">

                <div class="col-xl-8">
                    <div class="card">
                        <div class="card-body pb-0">
                            <form action="{{ route('qpost')}}" method="GET">
                                <div class="input-group mb-2">
                                    <input name="q" type="text" class="form-control" placeholder="Searching.....">
                                    <button  class="input-group-text btn btn-primary">Search</button>
                                </div>
                            </form>
                            <div class="tabs-menu search-tabs">
                                <ul class="nav panel-tabs">
                                    <li><a href="#tab5" class="active" data-bs-toggle="tab">All</a></li>
                                    <li><a href="{{ url('experts')}}"  class="text-dark">Experts</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body p-5">
                         
                            <p class="text-muted mb-0 ps-3">About {{ $results->count() }} results</p>
                        </div>
                    </div>
                    <div class="panel-body tabs-menu-body p-0 border-0">
                        <div class="tab-content">
                            <div class="tab-pane active" id="tab5">
                             @foreach($posts as $post)       


                             <div class="card">
                                <div class="card-body">
                                   <div class="mb-2">

                                    @if($post->parent_page == 5)
                                    <a href="{{ route('blog_single', $post->slug)}}"  class="h4 text-dark">{{ $post->title}}</a>
                                    @elseif($post->parent_page == 7)
                                    <a href="{{ route('question_single', $post->slug)}}"  class="h4 text-dark">{{ $post->title}}</a>
                                    @elseif($post->parent_page == 10)
                                    <a href="{{ route('sample_single', $post->slug)}}"  class="h4 text-dark">{{ $post->title}}</a>
                                    @elseif($post->parent_page == 12)
                                    <a href="{{ route('programming_single', $post->slug)}}"  class="h4 text-dark">{{ $post->title}}</a>
                                    @else
                                    <a href="{{ route('page_single', $post->slug)}}"  class="h4 text-dark">{{ $post->title}}</a>
                                    @endif
                                    
                                </div>
                                <!-- <a href="{{ route('blog_single', $post->slug)}}" target="_blank" class="text-primary">{{ url('/')}}/questions/{{ $post->slug }}</a> -->
                                <p class="text-muted mt-2 mb-2">{!! strip_tags(\Illuminate\Support\Str::limit($post->description, 200)) !!}</p>
                                <div>
                                                    <!--     <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
                                                        <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
                                                        <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
                                                        <a href="javascript:void(0)"><i class="fa fa-star text-yellow fs-16"></i></a>
                                                        <a href="javascript:void(0)"><i class="fa fa-star-o text-yellow fs-16"></i></a> -->
                                                        <!--    <a href="javascript:void(0)" class="me-4 d-inline-block"> (48) Reviews</a> -->
                                                        <!--  <a href="javascript:void(0)" class="fw-semibold">USD-$24</a> -->
                                                    </div>
                                                </div>
                                            </div>


                                            @endforeach


                                        </div>
                                        
                                        
                                        
                                    </div>
                                </div>
                                <div class="text-center">
                                    <div class="mb-5">
                                        <ul class="pagination justify-content-center">
                                          
                                           {{$posts->links("pagination::bootstrap-4")}}
                                       </ul>
                                   </div>
                               </div>
                           </div>

                           <div class="col-xl-4">
   @include('theme.gondana.sidebar') 
                           </div>
                       </div>
                       <!-- End Row -->
                   </div>
                   <!-- CONTAINER CLOSE -->

               </div>
           </div>
           @endsection