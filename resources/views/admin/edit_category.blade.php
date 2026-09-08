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
                                Update Category
                                <div class="page-options ms-auto">
                                    {{-- Example preview links are commented out --}}
                                    {{-- <a target="_blank" href="{{ post_path($post->id) }}" class="btn btn-primary btn-sm">Preview</a> --}}
                                    {{-- <a target="_blank" href="{{ route('shop_description', $post->slug) }}" class="btn btn-primary btn-sm">Preview</a> --}}
                                </div>
                            </div>
                            <div class="card-body">
                                <form method="POST" action="{{ route('update_category') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" name="cat_id" value="{{ $category->id }}">
                                    <div class="row mb-3">
                                        <div class="col-md-12">
                                            <label>Title</label>
                                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="name" value="{{ $category->name }}" placeholder="Title" required autocomplete="title" autofocus>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-sm-12">
                                            <label>Meta Description</label>
                                            <textarea type="text" name="meta_description" class="form-control">{{ $category->meta_description }}</textarea>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <label>Select Service</label>
                                        <select name="cat_type" class="form-control">
                                            <option value="{{ $category->cat_type }}" selected>{{ service($category->cat_type)->name ?? "N/A" }}</option>
                                            @foreach ($tasks as $task)
                                                <option value="{{ $task->id }}">{{ $task->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="row mb-3">
                                        <label>Description</label>
                                        <div class="form-group {{ $errors->has('post_content') ? 'has-error' : '' }}">
                                            <div class="col-sm-12">
                                                <main>
                                                    <textarea id="editor1" name="description">{{ $category->description }}</textarea>
                                                </main>
                                            </div>
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
    <script>
        // Ensure this script runs after CKEditor script is loaded
        document.addEventListener("DOMContentLoaded", function() {
            ClassicEditor
                .create(document.querySelector('#editor1'))
                .catch(error => {
                    console.error(error);
                });
        });
    </script>
@endsection

@section('page-js')
    <!-- INTERNAL WYSIWYG Editor JS -->
    <script src="{{ asset('assets/plugins/wysiwyag/jquery.richtext.js') }}"></script>
    <script src="{{ asset('assets/plugins/wysiwyag/wysiwyag.js') }}"></script>
@endsection
