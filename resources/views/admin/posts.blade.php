  @extends('layouts.appbar')
  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
  @section('content') 

  <div class="main-content app-content mt-0">
    <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">
            <div class="row">


                <div class="col-9">


                    @include('flash_msg')
                    <div class="card">
                        <div class="card-header"><strong>Add Post</strong></div>
  
                <div class="page-options ms-auto">
<form method="POST" action="{{ route('anew_post') }}">
                              <button type="submit" class="btn btn-primary">
                       Publish
                    </button>
                          </div>


                        <div class="card-body">
                          
                                @csrf
                                <input type="hidden" name="category_id" value="{{ Auth::user()->post_category }}">
                                <input type="hidden" name="site_id" value="{{ Auth::user()->site_id }}">



                              <div class="row mb-3">
                                <div class="col-md-12">
                                    <input id="title" type="text" class="form-control" name="title"  placeholder="Title" required>
                                </div>
                            </div>


                            <!-- Row -->
                            <div class="row">
                                <label class="col-md-3 form-label mb-4">Post Description :</label>
                                <div class="mb-4">
                                   <textarea  id="summernote" name="description"></textarea>
                                   <script>
                                      $('#summernote').summernote({
                                        placeholder: 'Hello stand alone ui',
                                        tabsize: 2,
                                        height: 500,
                                        toolbar: [
                                          ['style', ['style']],
                                          ['font', ['bold', 'underline', 'clear']],
                                          ['color', ['color']],
                                          ['para', ['ul', 'ol', 'paragraph']],
                                          ['table', ['table']],
                                          ['insert', ['link', 'picture', 'video']],
                                          ['view', ['fullscreen', 'codeview', 'help']],
                                          ['fontsize', ['fontsize']],
                                          ['fontname', ['fontname']]
                                          ],
                                    });
                                </script>
                            </div>
                        </div>
                        <!--End Row-->

                  

                       <div class="row mb-3">
                           <label class="col-md-3 form-label mb-4">Cost:</label>
                           <div class="col-md-12">
                              <input id="title" type="number" value="0" class="form-control" name="cost"  placeholder="Assignment cost">
                          </div>
                      </div>





            <div class="row mb-3">

                    <div class="col-md-12">

                    <label>Website  </label>
                            <select class="form-control" name="site_id">
          <option value="{{ Auth::user()->site_id }}" selected>
           <?php
           $site_name = \App\Models\Website::whereId(Auth::user()->site_id)->first()->domain_name;
           $sites = \App\Models\Website::all();
           ?>

           {{ $site_name }}



       </option>  
       @foreach($sites as $category)
       <option value="{{ $category->id }}">{{ $category->domain_name }}</option>
       @endforeach
   </select>
                </div>
            </div>



            <div class="row mb-0">
                <div class="col-md-12">
                    <button type="submit" class="btn btn-primary">
                        Submit Post
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<div><br></div>
@if($posts->count() > 0)
<div class="card">
    <div class="card-header">Recent Posts</div>

    <div class="card-body">


       @foreach($posts as $post)
       <h4> 

       <a target="_blank" href="{{ post_path($post->id) }}"  class="h4 text-dark">{{ $post->title}}</a>



    </h4>  
    <?php 

    $site = \App\Models\Website::find($post->site_id);


    ?>

    <p style="color: green;">

        @if($post->source_id)

        S-ID {{ $post->source_id }}

        @endif
  <a class="btn btn-sm btn-info badge" href="{{ route('edit_post', $post->id) }}"> <i class="fa fa-edit"></i></a>
        <a class="btn btn-sm btn-warning badge" data-bs-target="#delete-post{{ $post->id }}" data-bs-toggle="modal"><i class="fa fa-trash"></i>
        </a> 


        @if($site)
        @if($post->site_id)| 
        <a style="color: green;" href="https://{{ $site->domain_name }}" target="_blank">{{ $site->domain_name }}</a>
        @endif

        @endif
        <div class="modal fade" id="delete-post{{ $post->id }}">
          <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content country-select-modal">
               <div class="modal-header">
                 <h6 class="modal-title">Delete post #{{ $post->id }}</h6><button aria-label="Close" class="btn-close"
                 data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
             </div>
             <div class="modal-body">
                 <form class="form-horizontal" action="{{ route('delete_post')}}" method="POST">
                   @csrf

                   <input type="hidden" name="id" value="{{ $post->id }}">

                   <p>Are you sure want to delete this post?</p>


                   <div class=" row mb-4">

                     <div class="col-md-9">
                        <input type="submit" value="Yes" class="btn btn-danger">
                    </div>


                </div>



            </form>
        </div>
    </div>
</div>
</div>


</p>

<hr>



@endforeach


<div class="d-flex justify-content-center">

 {{$posts->links("pagination::bootstrap-4")}}

</div>


</div>
</div>

@endif
</div>
<div class="col-md-3">


  <div class="card">
    <div class="card-header"><strong>Set defaults:</strong> </div>

    <div class="card-body">
     <form method="POST" action="{{ route('update_default') }}">
        @csrf



        <div class="row mb-3">


            <div class="col-md-8">
                <select class="form-control" name="post_cat">
                  <option value="{{ Auth::user()->post_category ?? 'none' }}" selected>
                   <?php
                   $cat_name = \App\Models\Category::whereId(Auth::user()->post_category)->first()->name;

                   ?>

                   {{ $cat_name }}



               </option>  
               @foreach($categories as $category)
               <option value="{{ $category->id }}">{{ $category->name }}</option>
               @endforeach
           </select>

       </div>


   </div>

   <div class="row mb-3">


    <div class="col-md-8">
        <label>Parent page </label>
        <select class="form-control" name="page_id">
           <?php
           $page_name = \App\Models\Page::whereId(Auth::user()->page_id)->first()->name;

           $pages = \App\Models\Page::wherePostType('post')->get();

           ?>
           <option value="{{ Auth::user()->page_id }}" selected>


               {{ $page_name }}



           </option>  
           @foreach($pages as $category)
           <option value="{{ $category->id }}">{{ $category->name }}</option>
           @endforeach
       </select>

   </div>


</div>

<div class="row mb-3">


    <div class="col-md-8">
        <label>Website</label>
        <select class="form-control" name="site_id">
          <option value="{{ Auth::user()->site_id }}" selected>
           <?php
           $site_name = \App\Models\Website::whereId(Auth::user()->site_id)->first()->domain_name;
           $sites = \App\Models\Website::all();
           ?>

           {{ $site_name }}



       </option>  
       @foreach($sites as $category)
       <option value="{{ $category->id }}">{{ $category->domain_name }}</option>
       @endforeach
   </select>

</div>

<div class="col-md-3">
    <button type="submit" class="btn btn-primary btn-sm">
        Save
    </button>
</div>
</div>
<div class="row mb-0">

</div>
</form>
</div>
</div>

</div>






</div>
</div>
</div>
</div>



@endsection

@section('page-js')

<!-- INTERNAL WYSIWYG Editor JS -->
<script src="{{ asset('assets/plugins/wysiwyag/jquery.richtext.js')}}"></script>
<script src="{{ asset('assets/plugins/wysiwyag/wysiwyag.js')}}"></script>



@endsection
