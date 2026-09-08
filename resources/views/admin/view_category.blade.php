@extends('layouts.appbar')
     <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous">
     </script>
     <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
     <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js">
     </script>
@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
 <div class="side-app">

   <!-- CONTAINER -->
   <div class="main-container container-fluid">



    <!-- ROW OPEN -->
    <div class="row row-cards" style="padding-top: 20px;">
     <div class="col-lg-8 col-xl-8">


       <div class="card">
        
         <div class="card-header border-bottom-0">
           <h2 class="card-title">Services</h2>
           <div class="page-options ms-auto">


          </div>


        </div>


             @if($tasks->count()>0)

  
   <div class="card-body">
    <div class="row">
       <hr style="border-top: 1px solid #000000;">
            @foreach($tasks as $user)
               <div class="col-sm-1">

                <a href="{{ route('user_info', $user->id )}}">{{ $user->id }}</a>
               </div>
          <div class="col-sm-5">
              {{ $user->name }}<br>

          </div>
           <div class="col-sm-3"> 
            <span>
                 <div class="mt-sm-1 d-block">
                   @if($user->status==0)                                                                                 
                   <span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">Pending</span>
                   @elseif($user->status==1)
                   <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Completed</span>

                   @elseif($user->status==2)
                <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">Working on it</span>

                 @elseif($user->status==3)
                <span class="badge bg-info-transparent rounded-pill text-info p-2 px-3">Working perfect</span>
                @elseif($user->status==4)
                <span class="badge bg-danger-transparent rounded-pill text-danger p-2 px-3">Not Working</span>
                   @endif
                 </div>
               </span>
             </div>
            <div class="col-sm-3">
                <div class="btn-group align-top">

@if(Auth::user()->is_admin())
                   <a class="btn btn-sm btn-primary badge" data-bs-target="#edit-property{{ $user->id }}" data-bs-toggle="modal"><i class="fa fa-edit"></i> update</a> 
                   @endif

                  

    <!-- edit modal-->
             <div class="modal fade" id="edit-property{{ $user->id }}">
               <div class="modal-dialog modal-dialog-centered" role="document">
                 <div class="modal-content country-select-modal">
                   <div class="modal-header">
                     <h6 class="modal-title">Edit user #{{ $user->id }}</h6><button aria-label="Close" class="btn-close"
                     data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                   </div>
                   <div class="modal-body">
                     <form class="form-horizontal" action="{{ route('update_task')}}" method="POST">
                       @csrf
                       <input type="hidden" name="id" value="{{ $user->id }}">
                       

                       

                        <div class=" row mb-4">
                         <label class="col-md-4 form-label">Description</label>
                         <div class="col-md-8">
                           
                           <textarea class="form-control" name="description">{{ $user->description }}</textarea>
                         </div>


                       </div>

                       <div class=" row mb-4">
                         <label class="col-md-4 form-label">Label</label>
                         <div class="col-md-8">
                      <select name="label"  class="form-control">
                            <option value="{{ $user->label }}">{{ $user->label }} </option>
                            <option value="issue">issue</option>
                            <option value="order">order</option>
                            <option value="project">project</option>
                            <option value="reading">reading</option>
                      </select>
                         </div>


                       </div>



                       <div class=" row mb-4">
                         <label class="col-md-4 form-label">Status</label>
                         <div class="col-md-8">
                          <select name="status" class="form-control">
                            <option value="{{ $user->status }}">
                              @if($user->status==0)
                              pending
                              @elseif($user->status==2)
                              Working on it
                              @else
                              Done
                              @endif
                            </option>
                            <option value="1">Done</option>
                             <option value="2"> Working on it</option>
                             <option value="3"> Working perfect</option>
                              <option value="4"> Not Working</option>
                          </select>
                         </div>


                       </div>

                  
                    <div class=" row mb-4">

                     <div class="col-md-9">
                      <input type="submit" value="Save" class="btn btn-primary">
                    </div>


                  </div>



                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- Country-selector modal-->

                 </div>
            </div>
            <hr style="border-top: 1px solid #000000;">
            @endforeach
          </div>
          
        </div>
    
   @else
        <tr>No users</tr>
        @endif
</div>

<div class="mb-5">

 <div class="float-end">

 
   {{$tasks->links("pagination::bootstrap-4")}}

</div>
</div>




      <div class="card">
        <div class="card-header">Categories</div>

        <div class="card-body">
         <table class="table">
           <tbody>
             <tr>

               <th>Name</th>
               <th>Display Name</th>
               <th>Image</th>
               <th></th>

             </tr>
             @foreach($categories as $category)
             <tr>
               <td>{{ $category->name}}</td>
               <td>{{ $category->display_name }}</td>
               <td>
<img src="{{ $category->photo_url }}" width="200">
            </td>
              <td>

 <a class="btn btn-sm btn-primary badge" data-bs-target="#edit-cat{{ $category->id }}" data-bs-toggle="modal"><i class="fa fa-edit"></i> Edit</a> 

          <a class="btn btn-sm btn-danger badge" data-bs-target="#delete-cat{{ $category->id }}" data-bs-toggle="modal"><i class="fa fa-edit"></i> Delete</a> 

              </td>
            </tr>

                        <!-- delete modal-->
            <div class="modal fade" id="delete-cat{{ $category->id }}">
             <div class="modal-dialog modal-dialog-centered" role="document">
               <div class="modal-content country-select-modal">
                 <div class="modal-header">
                   <h6 class="modal-title">Delete Paper Type #{{ $category->id }}</h6><button aria-label="Close" class="btn-close"
                   data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                 </div>
                 <div class="modal-body">
                   <form method="POST" action="{{ route('delete_cat') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="cat_id" value="{{ $category->id }}">

                    <div class="row mb-3">

<p>Are you sure you want to delete this paper type</p>
                    
                    </div>


             

                    <div class="row mb-3">


                      <div class="col-md-12">
                       <button type="submit" class="btn btn-primary">Save</button>
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
                     <h6 class="modal-title">Edit Subject #{{ $category->id }}</h6><button aria-label="Close" class="btn-close"
                     data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                   </div>
                   <div class="modal-body">
                     <form method="POST" action="{{ route('update_category') }}" enctype="multipart/form-data">
                      @csrf
                      <input type="hidden" name="cat_id" value="{{ $category->id }}">

                      <div class="row mb-3">


                        <div class="col-md-12">
                          <label>Name</label>
                          <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="name" value="{{ $category->name }}" placeholder="Title" required autocomplete="title" autofocus>
                        </div>
                      </div>



                      <div class="row mb-3">


                        <div class="col-md-12">
                          <label>Display Name</label>
                          <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="display_name" value="{{ $category->display_name }}" placeholder="Title" required autocomplete="title" autofocus>
                        </div>
                      </div>


                      <div class="row mb-3">


                        <div class="col-md-12">
                          <label>pvalue</label>
                          <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="pvalue" value="{{ $category->pvalue }}" placeholder="Title" required autocomplete="title" autofocus>
                        </div>
                      </div>


                      <div class="row mb-3">
                        <div class="col-md-12">
                         <textarea id="summernote{{ $category->id }}" name="description" >{{ $category->description }}</textarea>
                         <script>
                          $('#summernote{{ $category->id }}').summernote({
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
                          <label>Meta Description</label>
                          <textarea  type="text" class="form-control" name="meta_description"  placeholder="meta description"  autocomplete="title" autofocus>{{ $category->meta_description }}</textarea>
                        </div>
                      </div>



      <div class="form-group  {{ $errors->has('photo')? 'has-error':'' }}">
        <label class="col-sm-4 control-label">Feature Image (800x400)</label>
        <div class="col-sm-8">
          <input type="file" id="photo" name="photo" class="filestyle" >
          {!! $errors->has('photo')? '<p class="help-block">'.$errors->first('photo').'</p>':'' !!}
        </div>
      </div>








                    <div class="row mb-3">


                      <div class="col-md-12">
                        <label>Site Type</label>
                        <select name="cat_type" class="form-control">
                          <option selected value="{{ $category->cat_type }}">
                            @if($category->site_type=='0')
                            Academic
                            @else
                            Article
                            @endif
                          </option>
                          <option value="0">Academic </option>
                          <option value="1">Article</option>


                        </select>
                      </div>
                    </div>

                    <div class="row mb-3">


                      <div class="col-md-12">
                       <button type="submit" class="btn btn-primary">Save</button>
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



      <div class="card">
        <div class="card-header">Sub Categories</div>

        <div class="card-body">
         <table class="table">
           <tbody>
             <tr>

               <th>Name</th>
               <th>Value</th>
               <th>Site Type</th>
               <th></th>

             </tr>
             @foreach($sub_categories as $category)
             <tr>
               <td>{{ $category->name}}</td>
               <td>{{ subject($category->cat_id) }}</td>
               <td>                  @if($category->cat_type=='0')
                Academic
                @endif

                @if($category->cat_type=='1')
                Article
                @endif



                @if($category->cat_type=='4')
                Buyer
              @endif</td>
              <td>
                <a class="btn btn-sm btn-primary badge" data-bs-target="#edit-cat{{ $category->id }}" data-bs-toggle="modal"><i class="fa fa-edit"></i> Edit</a> 

          <a class="btn btn-sm btn-danger badge" data-bs-target="#delete-cat{{ $category->id }}" data-bs-toggle="modal"><i class="fa fa-edit"></i> Delete</a> 

              </td>
            </tr>

                        <!-- delete modal-->
            <div class="modal fade" id="delete-cat{{ $category->id }}">
             <div class="modal-dialog modal-dialog-centered" role="document">
               <div class="modal-content country-select-modal">
                 <div class="modal-header">
                   <h6 class="modal-title">Delete Paper Type #{{ $category->id }}</h6><button aria-label="Close" class="btn-close"
                   data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                 </div>
                 <div class="modal-body">
                   <form method="POST" action="{{ route('delete_cat') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="cat_id" value="{{ $category->id }}">

                    <div class="row mb-3">

<p>Are you sure you want to delete this paper type</p>
                    
                    </div>


             

                    <div class="row mb-3">


                      <div class="col-md-12">
                       <button type="submit" class="btn btn-primary">Save</button>
                     </div>
                   </div>








                 </form>

               </div>
             </div>
           </div>
         </div>


            <!-- edit modal-->
            <div class="modal fade" id="edit-cat{{ $category->id }}">
             <div class="modal-dialog modal-dialog-centered" role="document">
               <div class="modal-content country-select-modal">
                 <div class="modal-header">
                   <h6 class="modal-title">Edit Price #{{ $category->id }}</h6><button aria-label="Close" class="btn-close"
                   data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                 </div>
                 <div class="modal-body">
                   <form method="POST" action="{{ route('update_cat') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="cat_id" value="{{ $category->id }}">

                    <div class="row mb-3">


                      <div class="col-md-12">
                        <label>Name</label>
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="name" value="{{ $category->name }}" placeholder="Title" required autocomplete="title" autofocus>
                      </div>
                    </div>


                    <div class="row mb-3">


                      <div class="col-md-12">
                        <label>pvalue</label>
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="pvalue" value="{{ $category->pvalue }}" placeholder="Title" required autocomplete="title" autofocus>
                      </div>
                    </div>




                    <div class="row mb-3">


                      <div class="col-md-12">
                        <label>Site Type</label>
                        <select name="cat_type" class="form-control">
                          <option selected value="{{ $category->cat_type }}">
                            @if($category->site_type=='0')
                            Academic
                            @else
                            Article
                            @endif
                          </option>
                          <option value="0">Academic </option>
                          <option value="1">Article</option>


                        </select>
                      </div>
                    </div>

                    <div class="row mb-3">


                      <div class="col-md-12">
                       <button type="submit" class="btn btn-primary">Save</button>
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
    <div class="card-header">
     <h4 class="card-title">Add a new service</h4>
   </div>
   <div class="card-body">
     <form class="form-horizontal" action="{{ route('add_service')}}" method="POST">
       @csrf


      <div class=" row mb-4">
       <label class="col-md-4 form-label">Name</label>
       <div class="col-md-8">
        <input class="form-control" type="text" name="name" required="">
       </div>


     </div>











     <div class=" row mb-4">

       <div class="col-md-9">
        <input type="submit" value="Save" class="btn btn-primary">
      </div>


    </div>



  </form>
</div>
</div>


 <div class="card">

        <div class="card-header">Add Category</div>

        <div class="card-body">
          <form method="POST" action="{{ route('new_category') }}">
            @csrf

            <div class="row mb-3">
              <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="name" class="col-md-4 col-form-label text-md-end">Category Type</label>

              <div class="col-md-6">
                <select name="cat_type" class="form-control">
  <option>Select Category</option>
                  @foreach($tasks as $category)
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


       <div class="card">

        <div class="card-header">Add Sub Category</div>

        <div class="card-body">
          <form method="POST" action="{{ route('new_sub_category') }}">
            @csrf

            <div class="row mb-3">
              <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                @error('name')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>

            <div class="row mb-3">
              <label for="name" class="col-md-4 col-form-label text-md-end">Category Type</label>

              <div class="col-md-6">
                <select name="cat_type" class="form-control">

                  <option>Select Category</option>

                  @foreach($categories as $category)

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