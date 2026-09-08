@extends('layouts.appbar')
<script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js"></script>
@section('content')


<div class="main-content app-content mt-0">
  <div class="side-app">

    <!-- CONTAINER -->
    <div class="main-container container-fluid">
      <div class="row">



       <div class="col-lg-9">
         @include('flash_msg')
         <div class="card">
          <div class="card-header">
            Update Product

<div class="page-options ms-auto">

            <a target="_blank" href="{{ route('training_description', $post->slug)}}"  class="btn btn-primary btn-sm">{{ $post->slug}}</a>
      
          </div>

          </div>

          <div class="card-body">
            <form method="POST" action="{{ route('updatesingle_product') }}" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="page_id" value="{{ $post->id }}">

              <div class="row mb-3">


                <div class="col-md-12">
                  <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $post->title }}" placeholder="Title" required autocomplete="title" autofocus>
                  @error('title')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                  @enderror
                </div>
              </div>


              @if($post->site_id)
              <div class="row mb-3">

                <div class="col-md-12">
                 <select name="site_id" class="form-control" required>
                  <option value="{{ $post->site_id }}" selected >
                    <?php
                    $site = \App\Models\Website::whereId($post->site_id)->first();
                    ?>
                    {{ $site ->domain_name }}
                  </option>
                  @foreach($sites as $category)
                  <option value="{{ $category->id }}">{{ $category->domain_name }}</option>

                  @endforeach
                </select>
              </div>
            </div>
            @else
            <div class="row mb-3">

              <div class="col-md-12">
               <select name="site_id" class="form-control" required>
                <option>Select website</option>
                @foreach($sites as $category)
                <option value="{{ $category->id }}">{{ $category->domain_name }}</option>

                @endforeach
              </select>
            </div>
          </div>
          @endif




          <div class="form-group {{ $errors->has('post_content')? 'has-error':'' }}">

            <div class="col-sm-12">
              <main>


               <textarea class="content" name="description">{{ $post->description }}</textarea>

             </main>
           </div>

           <script>
            ClassicEditor
            .create( document.querySelector( '#editor1' ) )
            .catch( error => {
              console.error( error );
            } );
          </script>


          <!-- Row -->
          <div class="row">
            <label class="col-md-3 form-label mb-4">Post Answer :</label>
            <div class="mb-4">
             <textarea id="post1" name="post_answer"> {{ $post->post_answer }}</textarea>
             <script>
              ClassicEditor
              .create( document.querySelector( '#post1' ) )
              .catch( error => {
                console.error( error );
              } );
            </script>
          </div>
        </div>




        <div class="form-group">
          <div class="col-md-6">
            <label for="show_in_header_menu" class="checkbox-inline">
              <input type="checkbox" value="1" id="show_in_header_menu" name="show_in_header_menu" {{ $post->show_in_header_menu? 'checked':'' }}>
              @lang('app.show_in_header_menu')
            </label>
          </div>
          <div class="col-md-6">
            <label for="show_in_footer_menu" class="checkbox-inline">
              <input type="checkbox" value="1" id="show_in_footer_menu" name="show_in_footer_menu"  {{ $post->show_in_footer_menu? 'checked':'' }}>
              @lang('app.show_in_footer_menu')
            </label>
          </div>
        </div>








      </div>
    </div>




  </div>

<?php
  $services =\App\Models\Service::wherePostId($post->id)->get();

?>
                             <!-- ROW-2 OPEN -->
        <div class="row ">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Additional services</h3>
                    </div>

                    @if($services->count()>0)
                    <div class="card-body">
                        <div class="accordion" id="accordionExample">

                          @foreach($services as $new)
                          


                          <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree{{ $new->id }}" aria-expanded="false" aria-controls="collapseThree">
                                  {{ $new->name }}
                              </button>
                          </h2>
                          <div id="collapseThree{{ $new->id }}" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExample">
                            <div class="accordion-body" style="background-color: #CACBCC;">
                                {!! $new->description !!}
                            </div>
                        </div>
                    </div>

                    @endforeach


                    
                </div>

                @else
                No note added
                @endif
            </div>
  

        </div>


        
    </div>
</div>



</div>


<div class="col-md-3">

       



  <div class="card">
    <div class="card-header"><strong>SEO Optimization:</strong> </div>

    <div class="card-body">




      <div class="row mb-3">
       <div class="col-md-12">
        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="keywords" value="{{ $post->keywords }}"  autocomplete="title" autofocus placeholder="Focus keywords">

      </div>
    </div>


    <div class="row mb-3">
      <div class="form-group">
       <label><strong>Meta description:</strong></label>
       <textarea  class="form-control" name="meta_description">{{ $post->meta_description }}</textarea>
     </div>
   </div>


   <div class="row mb-3">
     <div class="col-md-12">
      <label>Type</label>
      <select class="form-control" name="post_type">
        <option value="{{ $post->type }}" selected>{{ $post->type }}</option>
        <option value="post">post</option>
        <option value="page">page</option>
      </select>

    </div>
  </div>

  @if($post->type=='page')
  <div class="row mb-3">
   <div class="col-md-12">
    <label>Parent Page</label>
    <select class="form-control" name="parent_page">
      <?php
      $posts = \App\Models\Page::all();
      $page =\App\Models\Page::whereId($post->parent_page)->first();
      ?>

      <option value="{{ $post->parent_page }}" selected>{{ $page->name }}</option>
      @foreach($posts as $page)
      <option value="{{ $page->id }}">{{ $page->name }}</option>
      @endforeach
    </select>

  </div>
</div>

@else
<div class="row mb-3">
 <div class="col-md-12">
  <label>Parent Page</label>
  <select class="form-control" name="parent_page">
    <?php
    $posts = \App\Models\Page::all();
    $page =\App\Models\Page::whereId($post->parent_page)->first();
    ?>

    <option value="{{ $post->parent_page }}" selected>{{ $page->name }}</option>
    @foreach($posts as $page)
    <option value="{{ $page->id }}">{{ $page->name }}</option>
    @endforeach
  </select>

</div>
</div>
@endif

<div class="row mb-3">
 <div class="col-md-12">
  <label>Icon </label>
  <input type="text" class="form-control" name="ti_icon" value="{{ $post->ti_icon }}" placeholder="eg. ti_user">


</div>
</div>


<div class="row mb-3">
 <div class="col-md-12">
  <label>Live Demo URL </label>

  <input type="text" class="form-control" name="demo_url" value="{{ $post->demo_url }}" placeholder="eg. ti_user">


</div>
</div>

<div class="row mb-3">
 <label>Paper cost:</label>
 <div class="col-md-12">
  <input id="title" type="number" class="form-control" name="cost" value="{{ $post->cost }}" >
</div>
</div>

@if($post->parent_page == '17')

<div class="row mb-3">
 <label>Academic Level:</label>
 <div class="col-md-12">
  <input id="title" type="number" class="form-control" name="level_id" value="{{ $post->level_id }}" >
</div>
</div>


<div class="row mb-3">
 <label>pages:</label>
 <div class="col-md-12">
  <input id="title" type="number" class="form-control" name="pages" value="{{ $post->pages }}" >
</div>
</div>

@endif


<div class="col-md-3">
  <button type="submit" class="btn btn-primary btn-sm">
   Update
 </button>
</div>




</form>



</div>




</div>


<div class="card">
                        <div class="card-header"><strong>Add Service</strong></div>


                        <div class="card-body">
                            <form method="POST" action="{{ route('anew_service') }}">
                                @csrf
                                <input type="hidden" name="post_id" value="{{ $post->id }}">

                          <div class="row mb-3">
                            <div class="col-md-12">
                                <input id="title" type="text" class="form-control" name="name"  placeholder="Title" required>
                            </div>
                        </div>


                        <!-- Row -->
                        <div class="row">
                            <label class="col-md-12 form-label mb-4">Description :</label>
                            <div class="mb-4">
                                <textarea id="post_content1" name="description"></textarea>
                                        <script>
            ClassicEditor
            .create( document.querySelector( '#post_content1' ) )
            .catch( error => {
              console.error( error );
            } );
          </script>
                            </div>
                        </div>
                        <!--End Row-->

              






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
  <div class="card-header"><strong>Media</strong> </div>

  <div class="card-body">


    <?php
    $logo =\App\Models\Upload::wherePostId($post->id)->whereStatus('1')->first();
    ?>
    @if($logo)
    <img src="{{ url('/') }}{{ $logo->file_path }}" alt="" title="" height="50">

    <p>{{ url('/') }}{{ $logo->file_path }}</p>
    @else
    <p>Upload media</p>
    @endif


    <form action="{{route('upload_pmedia')}}" method="post" enctype="multipart/form-data">



      @csrf
      <input type="hidden" name="post_id" value="{{ $post->id }}">
      @if ($message = Session::get('success'))
      <div class="alert alert-success">
        <strong>{{ $message }}</strong>
      </div>
      @endif
      @if (count($errors) > 0)
      <div class="alert alert-danger">
        <ul>
          @foreach ($errors->all() as $error)
          <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
      @endif
      <div class="custom-file">
        <input type="file" name="file" id="chooseFile">
      </div>
      <button type="submit" name="submit" class="btn btn-primary btn-sm">
        Upload
      </button>
    </form>

  </div>
</div>


</div>
</div>
</div>
</div>
</div>
</div>

<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace( 'post_content' );
      </script>
      @endsection

      @section('page-js')

      <!-- INTERNAL WYSIWYG Editor JS -->
      <script src="{{ asset('assets/plugins/wysiwyag/jquery.richtext.js')}}"></script>
      <script src="{{ asset('assets/plugins/wysiwyag/wysiwyag.js')}}"></script>

      @endsection