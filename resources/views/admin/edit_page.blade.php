@extends('layouts.appbar')
<script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js">
</script>


<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
</script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>



@section('content')


    <div class="main-content app-content mt-0">
        <div class="side-app">

            <!-- CONTAINER -->
            <div class="main-container container-fluid">
                <div class="row">
                    <div class="col-lg-9">
                        @include('flash_msg')
                        <div class="card">
                            <div class="card-header">Update page

                                <div class="page-options ms-auto">
                                    <a class="btn btn-sm btn-info badge" target="_blank"
                                        href="{{ route('page_single', $post->slug) }}">Preview</a>

                                    <a class="btn btn-sm btn-success badge" data-bs-target="#accept"
                                        data-bs-toggle="modal"><i class="fa fa-check"></i> Add Content</a>




                                    <!-- edit modal-->
                                    <div class="modal fade" id="accept">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content country-select-modal">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Add Content</h6><button aria-label="Close"
                                                        class="btn-close" data-bs-dismiss="modal" type="button"><span
                                                            aria-hidden="true">×</span></button>
                                                </div>



                                                <div class="modal-body">

                                                    <form class="form-horizontal" action="{{ route('add_content') }}"
                                                        method="POST">
                                                        @csrf

                                                        <input type="hidden" name="post_id" value="{{ $post->id }}">
                                                        <p>Add Content</p>
                                                        <div class=" row mb-4">

                                                            <div class="col-md-12">
                                                                <textarea name="description" id="summernote" class="form-control">
    
              </textarea>
                                                            </div>


                                                        </div>


                                                        <div class="col-md-3">
                                                            <button type="submit" class="btn btn-primary btn-sm">
                                                                Save
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>



                                </div>
                            </div>

                            <div class="card-body">




                                @foreach ($templates as $template)
                                    <div class="table-responsive">
                                        <table class="table text-nowrap">
                                            <thead class="table-primary">

                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td scope="row">{!! $template->description !!}</td>
                                                    <td>
                                                        <div class="hstack gap-2 fs-15">

                                                            <a href="javascript:void(0);"
                                                                class="btn btn-icon btn-sm btn-info-transparent rounded-pill"
                                                                data-bs-target="#edit{{ $template->id }}"
                                                                data-bs-toggle="modal"><i class="ri-edit-line"></i>
                                                            </a>


                                                            <a href="javascript:void(0);"
                                                                class="btn btn-icon btn-sm btn-info-transparent rounded-pill"
                                                                data-bs-target="#image{{ $template->id }}"
                                                                data-bs-toggle="modal"><i class="ri-image-line"></i>
                                                            </a>



                                                            <a href="javascript:void(0);"
                                                                class="btn btn-icon btn-sm btn-danger-transparent rounded-pill"
                                                                data-bs-target="#delete{{ $template->id }}"
                                                                data-bs-toggle="modal"><i class="ri-delete-bin-line"></i>
                                                            </a>

                                                        </div>
                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td> <?php
                                                    $logo = \App\Models\Upload::whereContentId($template->id)
                                                        ->whereStatus('1')
                                                        ->first();
                                                    ?>
                                                        @if ($logo)
                                                            <img src="{{ url('/') }}{{ $logo->file_path }}"
                                                                alt="" title="" width="800">
                                                        @else
                                                        @endif
                                                    </td>
                                                    <td></td>
                                                </tr>

                                            </tbody>
                                        </table>
                                    </div>


                                    <!-- edit modal-->
                                    <div class="modal fade" id="delete{{ $template->id }}">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content country-select-modal">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Delete Content</h6><button aria-label="Close"
                                                        class="btn-close" data-bs-dismiss="modal" type="button"><span
                                                            aria-hidden="true">×</span></button>
                                                </div>



                                                <div class="modal-body">

                                                    <form class="form-horizontal" action="{{ route('delete_content') }}"
                                                        method="POST">
                                                        @csrf

                                                        <input type="hidden" name="id" value="{{ $template->id }}">

                                                        <p>Are you sure you want to delete the content?</p>



                                                        <div class="col-md-3">
                                                            <button type="submit" class="btn btn-primary btn-sm">
                                                                Yes
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>





                                    <!-- edit modal-->
                                    <div class="modal fade" id="image{{ $template->id }}">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content country-select-modal">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Add Image</h6><button aria-label="Close"
                                                        class="btn-close" data-bs-dismiss="modal" type="button"><span
                                                            aria-hidden="true">×</span></button>
                                                </div>



                                                <div class="modal-body">

                                                    <?php
                                                    $logo = \App\Models\Upload::whereContentId($template->id)
                                                        ->whereStatus('1')
                                                        ->first();
                                                    ?>
                                                    @if ($logo)
                                                        <img src="{{ url('/') }}{{ $logo->file_path }}"
                                                            alt="" title="" width="800">
                                                    @else
                                                        <p>Upload media</p>
                                                    @endif


                                                    <form action="{{ route('upload_pmedia') }}" method="post"
                                                        enctype="multipart/form-data">



                                                        @csrf
                                                        <input type="hidden" name="post_id"
                                                            value="{{ $post->id }}">
                                                        <input type="hidden" name="content_id"
                                                            value="{{ $template->id }}">
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
                                                        <button type="submit" name="submit"
                                                            class="btn btn-primary btn-sm">
                                                            Upload
                                                        </button>
                                                    </form>



                                                </div>
                                            </div>
                                        </div>
                                    </div>





                                    <!-- edit modal-->
                                    <div class="modal fade" id="edit{{ $template->id }}">
                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                            <div class="modal-content country-select-modal">
                                                <div class="modal-header">
                                                    <h6 class="modal-title">Update Content</h6><button aria-label="Close"
                                                        class="btn-close" data-bs-dismiss="modal" type="button"><span
                                                            aria-hidden="true">×</span></button>
                                                </div>



                                                <div class="modal-body">

                                                    <form class="form-horizontal" action="{{ route('update_content') }}"
                                                        method="POST">
                                                        @csrf

                                                        <input type="hidden" name="id"
                                                            value="{{ $template->id }}">
                                                        <p>Add Content</p>
                                                        <div class=" row mb-4">

                                                            <div class="col-md-12">
                                                                <textarea id="summernote{{ $template->id }}" name="description">{{ $template->description }}</textarea>
                                                                <script>
                                                                    $('#summernote{{ $template->id }}').summernote({
                                                                        placeholder: 'Type your instructions here',
                                                                        tabsize: 2,
                                                                        height: 300,
                                                                        toolbar: [
                                                                            ['style', ['style']],
                                                                            ['font', ['bold', 'underline', 'clear']],
                                                                            ['color', ['color']],
                                                                            ['para', ['ul', 'ol', 'paragraph']],
                                                                            ['table', ['table']],
                                                                            ['insert', ['link', 'picture', 'video']],
                                                                            ['view', ['fullscreen', 'codeview', 'help']]
                                                                        ]
                                                                    });
                                                                </script>
                                                            </div>


                                                        </div>


                                                        <div class="col-md-3">
                                                            <button type="submit" class="btn btn-primary btn-sm">
                                                                Save
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach





                                <form method="POST" action="{{ route('update_page') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="page_id" value="{{ $post->id }}">

                                    <div class="form-group">

                                        <div class="col-sm-12">
                                            <textarea name="description" id="summernoted" class="form-control">
                {{ $post->description }}
              </textarea>


                                            <script>
                                                $('#summernoted').summernote({
                                                    placeholder: 'Type your instructions here',
                                                    tabsize: 2,
                                                    height: 300,
                                                    toolbar: [
                                                        ['style', ['style']],
                                                        ['font', ['bold', 'underline', 'clear']],
                                                        ['color', ['color']],
                                                        ['para', ['ul', 'ol', 'paragraph']],
                                                        ['table', ['table']],
                                                        ['insert', ['link', 'picture', 'video']],
                                                        ['view', ['fullscreen', 'codeview', 'help']]
                                                    ]
                                                });
                                            </script>


                                        </div>

                                        <div class="col-sm-12">

                                            <label>
                                                Why Choose Us
                                            </label>
                                            <textarea name="header1" id="summernoted1" class="form-control"
                                                placeholder="All-in-one SEO solution for your business">
              {{ $post->header1 }}
          </textarea>


                                            <textarea name="description1" id="summernoted1" class="form-control"
                                                placeholder="Elevate your business's digital visibility with our comprehensive all-in-one SEO solution. Streamline optimization processes,
enhance search engine rankings, and drive organic traffic to
fuel your online success.">
              {{ $post->description1 }}
              </textarea>


                                        </div>



                                        <div class="col-sm-12">

                                            <label> About us </label>
                                            <textarea name="description2" id="summernoted1" class="form-control">
         {{ $post->description2 }}
              </textarea>


                                        </div>



                                        <div class="col-sm-12">

                                            <label> Feature 1 </label>
                                            <textarea name="feature1" id="summernoted1" class="form-control">
      {{ $post->feature1 }}
              </textarea>


                                        </div>



                                        <div class="col-sm-12">

                                            <label> Feature 2 </label>
                                            <textarea name="feature2" id="summernoted1" class="form-control">
           {{ $post->feature2 }}
              </textarea>


                                        </div>


                                        <div class="col-sm-12">

                                            <label> Feature 3 </label>
                                            <textarea name="feature3" id="summernoted1" class="form-control">
     {{ $post->feature3 }}
              </textarea>


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
                                        <input id="title" type="text"
                                            class="form-control @error('title') is-invalid @enderror" name="title"
                                            value="{{ $post->title }}" placeholder="Title" required
                                            autocomplete="title" autofocus>
                                        @error('title')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>
                                </div>


                                @if ($post->site_id)
                                    <div class="row mb-3">

                                        <div class="col-md-12">
                                            <select name="site_id" class="form-control" required>
                                                <option value="{{ $post->site_id }}" selected>
                                                    <?php
                                                    $site = \App\Models\Website::whereId($post->site_id)->first();
                                                    ?>
                                                    {{ $site->domain_name }}
                                                </option>
                                                @foreach ($sites as $category)
                                                    <option value="{{ $category->id }}">{{ $category->domain_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <div class="row mb-3">

                                        <div class="col-md-12">
                                            <select name="site_id" class="form-control" required>
                                                <option>Select website</option>
                                                @foreach ($sites as $category)
                                                    <option value="{{ $category->id }}">{{ $category->domain_name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif








                                <div class="form-group">
                                    <div class="col-md-6">
                                        <label for="show_in_header_menu" class="checkbox-inline">
                                            <input type="checkbox" value="1" id="show_in_header_menu"
                                                name="show_in_header_menu" {{ $post->show_in_header_menu ? 'checked' : '' }}>
                                            @lang('app.show_in_header_menu')
                                        </label>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="show_in_footer_menu" class="checkbox-inline">
                                            <input type="checkbox" value="1" id="show_in_footer_menu"
                                                name="show_in_footer_menu" {{ $post->show_in_footer_menu ? 'checked' : '' }}>
                                            @lang('app.show_in_footer_menu')
                                        </label>
                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <input id="title" type="text"
                                            class="form-control @error('title') is-invalid @enderror" name="keywords"
                                            value="{{ $post->keywords }}" autocomplete="title" autofocus
                                            placeholder="Focus keywords">

                                    </div>
                                </div>


                                <div class="row mb-3">
                                    <div class="form-group">
                                        <label><strong>Meta description:</strong></label>
                                        <textarea class="form-control" name="meta_description">{{ $post->meta_description }}</textarea>
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


                                @if ($post->type == 'page')
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label>Parent Page</label>
                                            <select class="form-control" name="parent_page">
                                                <?php
                                                $posts = \App\Models\Page::all();
                                                $page = \App\Models\Page::whereId($post->parent_page)->first();
                                                ?>

                                                <option value="{{ $post->parent_page }}" selected>{{ $page->name }}
                                                </option>
                                                @foreach ($posts as $page)
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
                                                $page = \App\Models\Page::whereId($post->parent_page)->first();
                                                ?>

                                                <option value="{{ $post->parent_page }}" selected>{{ $page->name }}
                                                </option>
                                                @foreach ($posts as $page)
                                                    <option value="{{ $page->id }}">{{ $page->name }}</option>
                                                @endforeach
                                            </select>

                                        </div>
                                    </div>
                                @endif

                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <label>Icon </label>
                                        <input type="text" class="form-control" name="ti_icon"
                                            value="{{ $post->ti_icon }}" placeholder="eg. ti_user">


                                    </div>
                                </div>

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
                                $logo = \App\Models\Upload::wherePostId($post->id)
                                    ->whereStatus('1')
                                    ->first();
                                ?>
                                @if ($logo)
                                    <img src="{{ url('/') }}{{ $logo->file_path }}" alt="" title=""
                                        height="50">
                                @else
                                    <p>Upload media</p>
                                @endif


                                <form action="{{ route('upload_pmedia') }}" method="post"
                                    enctype="multipart/form-data">



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


@endsection


@section('page-js')
    <!-- INTERNAL WYSIWYG Editor JS -->
    <script src="{{ asset('assets/plugins/wysiwyag/jquery.richtext.js') }}"></script>
    <script src="{{ asset('assets/plugins/wysiwyag/wysiwyag.js') }}"></script>

    <!-- INTERNAL SUMMERNOTE Editor JS -->
    <script src="{{ asset('assets/plugins/summernote/summernote1.js') }}"></script>
    <script src="{{ asset('assets/js/summernote.js') }}"></script>
@endsection
