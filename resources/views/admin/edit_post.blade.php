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
            Update Post

<div class="page-options ms-auto">
         
            {{-- <a target="_blank" href="{{ post_path($post->id) }}"  class="btn btn-primary btn-sm">Preview
            </a> --}}
            <a target="_blank" href="{{ route('shop_description', $post->slug) }}"  class="btn btn-primary btn-sm">Preview
            </a>
          </div>

          </div>

          <div class="card-body">
            <form method="POST" action="{{ route('updatesingle_post') }}" enctype="multipart/form-data">
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

              


             
            <div class="row mb-3">

              <div class="col-md-12">
               <select name="site_id" class="form-control" required>
                <option value="{{$post->site_id}}">Selet Website</option>
                @foreach($sites as $category)
                <option value="{{ $category->id }}">{{ $category->domain_name }}</option>

                @endforeach
              </select>
            </div>
          </div>




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


  {{-- <div class="row mb-3">
   <div class="col-md-12">
    <label>Category</label>
    <select class="form-control" name="category_id">
      <?php
      $categories = \App\Models\Sub_category::all();
      ?>
<option value="{{ $post->category_id }}" selected>{{ $post->category_id }}</option>
      @foreach($categories as $category)
      <option value="{{ $category->id }}">{{ $category->name }}</option>
      @endforeach
    </select>
 </div>
</div> --}}

<div class="row mb-3">

  <div class="col-md-12">
      <label>Select Category </label>
      <select class="form-control" name="category_id">
        <option value="{{ $post->category_id }}" selected>{{category($post->category_id)->name ?? "N/A"}}</option>
        @foreach ($cat as $category)
            <option value="{{ $category->id }}">{{ $category->name }}</option>
        @endforeach
    </select>
  </div>
</div>



  <div class="row mb-3">
   <div class="col-md-12">
    <label>Sub Category</label>
    <select class="form-control" name="sub_category">
      <?php
      $sub_categories = \App\Models\Sub_category::all();
      ?>

  <option value="{{ $post->sub_category }}" selected>{{ $post->sub_category }}</option>
      @foreach($sub_categories as $sub_category)
      <option value="{{ $sub_category->id }}">{{ $sub_category->name }}</option>
      @endforeach
    </select>
 </div>
</div>

<div class="row mb-3">
 <div class="col-md-12">
  <label>Icon </label>
  <input type="text" class="form-control" name="ti_icon" value="{{ $post->ti_icon }}" placeholder="eg. ti_user">


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
    <p>Upload media (329x245)</p>
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