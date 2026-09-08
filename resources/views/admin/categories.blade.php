@extends('layouts.appbar')
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"
    integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
</script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
@section('content') <!--app-content open-->
    <div class="main-content app-content mt-0">
        <div class="side-app">

            <!-- CONTAINER -->
            <div class="main-container container-fluid">



                <!-- ROW OPEN -->
                <div class="row row-cards" style="padding-top: 20px;">
                    <div class="col-lg-8 col-xl-8">


                        <div class="card">
                            <div class="card-header">Categories</div>

                            <div class="card-body">
                                <table class="table">
                                    <tbody>
                                        <tr>

                                            <th>Name</th>
                                            <th>Slug</th>
                                            {{-- <th>Description</th> --}}
                                            <th></th>

                                        </tr>
                                        @foreach ($categories as $category)
                                            <tr>
                                                <td><a href="{{ route('shops_filter', $category->category_slug) }}"> {{ $category->name }} </a></td>
                                                <td>{{ $category->category_slug }}</td>
                                                {{-- <td>{!! $category->description !!}</td> --}}
                                                
                                                <td>

                                                    <a href="{{route('edit_category',$category->id)}}" class="btn btn-sm btn-primary badge"><i class="fa fa-edit"></i> Edit</a>

                                                    <a class="btn btn-sm btn-danger badge"
                                                        data-bs-target="#delete-cat{{ $category->id }}"
                                                        data-bs-toggle="modal"><i class="fa fa-edit"></i> Delete</a>

                                                </td>
                                            </tr>

                                            <!-- delete modal-->
                                            <div class="modal fade" id="delete-cat{{ $category->id }}">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content country-select-modal">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title">Delete #{{ $category->id }}
                                                            </h6><button aria-label="Close" class="btn-close"
                                                                data-bs-dismiss="modal" type="button"><span
                                                                    aria-hidden="true">×</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="{{ route('delete_cat') }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="cat_id"
                                                                    value="{{ $category->id }}">

                                                                <div class="row mb-3">

                                                                    <p>Are you sure you want to delete this paper type</p>

                                                                </div>




                                                                <div class="row mb-3">


                                                                    <div class="col-md-12">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Save</button>
                                                                    </div>
                                                                </div>








                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>


                                            <!-- edit modal-->
                                            <div class="modal fade" id="edit-cat{{ $category->id }}">
                                                <div class="modal-dialog modal-fullscreen" role="document">
                                                    <div class="modal-content country-select-modal">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title">Edit Category #{{ $category->id }}</h6>
                                                            <button aria-label="Close" class="btn-close"
                                                                data-bs-dismiss="modal" type="button"><span
                                                                    aria-hidden="true">×</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="{{ route('update_category') }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="cat_id"
                                                                    value="{{ $category->id }}">

                                                                <div class="row mb-3">


                                                                    <div class="col-md-12">
                                                                        <label>Title</label>
                                                                        <input id="title" type="text"
                                                                            class="form-control @error('title') is-invalid @enderror"
                                                                            name="name" value="{{ $category->name }}"
                                                                            placeholder="Title" required
                                                                            autocomplete="title" autofocus>
                                                                    </div>
                                                                </div>
                                                                <div class="row mb-3">
                                                                    <div class="col-sm-12">
                                                                        <label>Meta Description</label>
                                                                        <input type="text" name="meta_description" class="form-control">
                                                                            {{ $category->meta_description }}
                                                                        </input>
                                                            
                                                                    </div>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <label>Select Service</label>
                                                                    <select name="cat_type" class="form-control">
                                                                        <option value="{{ $category->cat_type }}" selected>{{service($category->cat_type)->name ?? " N/A"}}</option>
                                                                        @foreach ($tasks as $category)
                                                                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>

                                                                <div class="row mb-3">
                                                                    <div class="col-sm-12">
                                                                        <label>Description</label>
                                                                        <textarea type="text" name="description" id="summernoted" class="form-control">
                                                                            {{ $category->description }}
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
                                                                </div>

                                                                

                                                                <div class="row mb-3">


                                                                    <div class="col-md-12">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Save</button>
                                                                    </div>
                                                                </div>

                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- Country-selector modal-->
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>







                        <!-- HHHH -->
                    </div>
                    <!-- COL-END -->

                    <div class="col-lg-4 col-xl-4">
                        <div class="card">

                            <div class="card-header">Add Category</div>

                            <div class="card-body">
                                <form method="POST" action="{{ route('new_category') }}">
                                    @csrf

                                    <div class="row mb-3">
                                        <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

                                        <div class="col-md-6">
                                            <input id="name" type="text"
                                                class="form-control @error('name') is-invalid @enderror" name="name"
                                                value="{{ old('name') }}" required autocomplete="name" autofocus>

                                            @error('name')
                                                <span class="invalid-feedback" role="alert">
                                                    <strong>{{ $message }}</strong>
                                                </span>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="row mb-3">
                                        <label for="name" class="col-md-4 col-form-label text-md-end">Category
                                            Type</label>

                                        <div class="col-md-6">
                                            <select name="cat_type" class="form-control">
                                                <option>Select Category</option>
                                                @foreach ($tasks as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="row mb-0">
                                        <div class="col-md-6 offset-md-4">
                                            <button type="submit" class="btn btn-primary">
                                                Submit
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>




                    </div>

                </div>
                <!-- ROW CLOSED -->


            </div>
        </div>
    </div>





@endsection
