  @extends('layouts.appbar')
  <script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js"></script>
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


                        <div class="card-body">
                            <form method="POST" action="{{ route('anew_page') }}">
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
                                        <textarea id="summernote" name="description"></textarea>

                                       
                                    </div>
                                </div>
                                <!--End Row-->

                      

                          <div class="row mb-3">


                            <div class="col-md-8">
                                <label>Parent page </label>
                                <select class="form-control" name="parent_page">
                                 <?php
                                 $page_name = \App\Models\Page::whereId(Auth::user()->page_id)->first()->name;
                                 $pages = \App\Models\Page::all();
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

        <div class="card">
            <div class="card-header">Recent Posts</div>

            <div class="card-body">


             @foreach($posts as $post)
             <h4> <a target="_blank" href="{{ route('page_single', $post->slug) }}">{{ $post->title}}</a>
             </h4>  
             <?php 

             $site = \App\Models\Website::find($post->site_id);


             ?>
             @if($site)
             <p style="color: green;"><a href="{{ route('edit_page', $post->id) }}"> Edit</a> @if($post->site_id)| <a style="color: green;" href="https://{{ $site->domain_name }}" target="_blank">{{ $site->domain_name }}</a>@endif</p>
             @endif
             <hr>



             @endforeach


             <div class="d-flex justify-content-center">
                {!! $posts->links() !!}
            </div>


        </div>
    </div>
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
                  <option value="{{ Auth::user()->post_category }}" selected>
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
             $pages = \App\Models\Page::all();
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

    <!-- INTERNAL SUMMERNOTE Editor JS -->
    <script src="{{ asset('assets/plugins/summernote/summernote1.js')}}"></script>
    <script src="{{ asset('assets/js/summernote.js')}}"></script>

@endsection
