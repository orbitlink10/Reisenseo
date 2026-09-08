  @extends('layouts.appbar')
  <script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js">
  </script>
  @section('content')
      <div class="main-content app-content mt-0">
          <div class="side-app">

              <!-- CONTAINER -->
              <div class="main-container container-fluid">
                  <div class="row">


                      <div class="col-9">


                          @include('flash_msg')
                          <div class="card">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                              <div class="card-header"><strong>Add Product</strong></div>


                              <div class="card-body">
                                  <form method="POST" action="{{ route('anew_product') }}">
                                      @csrf
                                      {{-- <input type="hidden" name="category_id" value="{{ Auth::user()->post_category }}"> --}}
                                      <input type="hidden" name="site_id" value="{{ Auth::user()->site_id }}">


                                      <div class="row mb-3">
                                          <div class="col-md-12">
                                              <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title"
                                                  placeholder="Title" required>

                                                @error('title')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                          </div>
                                      </div>


                                      <!-- Row -->
                                      <div class="row">
                                          <label class="col-md-3 form-label mb-4">Post Description :</label>
                                          <div class="mb-4">
                                              <textarea class="content @error('description') is-invalid @enderror" name="description"></textarea>
                                              @error('description')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                          </div>
                                      </div>
                                      <!--End Row-->

                                      <div class="row mb-3">
                                          <label class="col-md-3 form-label mb-4">Product cost:</label>
                                          <div class="col-md-12">
                                              <input id="title" type="number" value="0" class="form-control @error('cost') is-invalid @enderror"
                                                  name="cost" placeholder="Assignment cost" required>
                                                  @error('cost')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror

                                          </div>
                                      </div>



                                      <div class="row mb-3">

                                          <div class="col-md-12">
                                              <label>Category </label>
                                              <select class="form-control @error('category_id') is-invalid @enderror" name="category_id" required>
                                                <option value="" selected>Select Category</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('category_id')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                          </div>
                                      </div>

                                      {{-- <div class="row mb-3">

                                          <div class="col-md-12">
                                              <label>Select website </label>
                                              <select name="site_id" class="form-control" required>
                                                  @foreach ($sites as $category)
                                                      <option value="{{ $category->id }}">{{ $category->domain_name }}
                                                      </option>
                                                  @endforeach
                                              </select>
                                          </div>
                                      </div> --}}






                                      <div class="row mb-3">


                                          <div class="col-md-8">
                                              <label>Parent page </label>
                                              <select class="form-control" name="parent_page">
                                                  <?php
                                                  $page_name = \App\Models\Page::whereId(21)->first()->name;
                                                  $pages = \App\Models\Page::all();
                                                  ?>
                                                  <option value="{{ Auth::user()->page_id }}" selected>


                                                      {{ $page_name }}



                                                  </option>
                                                  @foreach ($pages as $category)
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
                              <div class="card-header">Recent Products</div>

                              <div class="card-body">


                                  @foreach ($posts as $post)
                                      <h4>
                                        <a href="{{ route('edit_post', $post->id) }}"> Edit</a><br>
                                          <a target="_blank" href="{{ route('shop_description', $post->slug) }}"
                                              class="h4 text-dark">{{ $post->title }}</a>
                                            <br>
                                            <a class="btn btn-sm btn-danger badge"
                                                        data-bs-target="#delete-cat{{ $post->id }}"
                                                        data-bs-toggle="modal"><i class="fa fa-edit"></i> Delete</a>



                                      </h4>
                                      <?php
                                      
                                      $site = \App\Models\Website::find($post->site_id);
                                      
                                      ?>
                                      @if ($site)
                                          <p style="color: green;"><a href="{{ route('edit_post', $post->id) }}"> Edit</a> <br>
                                              @if ($post->site_id)
                                                  | <a style="color: green;" href="https://{{ $site->domain_name }}"
                                                      target="_blank">{{ $site->domain_name }}</a><br>
                                              @endif
                                              <a class="btn btn-sm btn-danger badge"
                                                        data-bs-target="#delete-cat{{ $post->id }}"
                                                        data-bs-toggle="modal"><i class="fa fa-edit"></i> Delete</a>

                                              <!-- delete modal-->
                                            <div class="modal fade" id="delete-cat{{ $post->id }}">
                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                    <div class="modal-content country-select-modal">
                                                        <div class="modal-header">
                                                            <h6 class="modal-title">Delete #{{ $post->id }}
                                                            </h6><button aria-label="Close" class="btn-close"
                                                                data-bs-dismiss="modal" type="button"><span
                                                                    aria-hidden="true">×</span></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="POST" action="{{ route('delete_product') }}"
                                                                enctype="multipart/form-data">
                                                                @csrf
                                                                <input type="hidden" name="cat_id"
                                                                    value="{{ $post->id }}">

                                                                <div class="row mb-3">
                                                                    <p>Are you sure you want to delete this Product</p>

                                                                </div>




                                                                <div class="row mb-3">


                                                                    <div class="col-md-12">
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Delete</button>
                                                                    </div>
                                                                </div>

                                                            </form>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                          </p>
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
                                                  @foreach ($categories as $category)
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
                                                  @foreach ($pages as $category)
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
                                                  @foreach ($sites as $category)
                                                      <option value="{{ $category->id }}">{{ $category->domain_name }}
                                                      </option>
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
      <script src="{{ asset('assets/plugins/wysiwyag/jquery.richtext.js') }}"></script>
      <script src="{{ asset('assets/plugins/wysiwyag/wysiwyag.js') }}"></script>
  @endsection
