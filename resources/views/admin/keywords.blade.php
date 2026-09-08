@extends('layouts.appbar')

@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
 <div class="side-app">

   <!-- CONTAINER -->
   <div class="main-container container-fluid">



    <!-- ROW OPEN -->
    <div class="row row-cards" style="padding-top: 20px;">

<div class="col-lg-12 col-xl-12">
 <div class="card">
  
   <div class="card-body">
     <form class="form-horizontal" action="{{ route('save_keyword')}}" method="POST">
       @csrf

       <div class=" row">
         <label class="col-md-2 form-label">
Add Keyword
</label>
         <div class="col-md-3">
           <input type="text" class="form-control" name="keyword" placeholder="Type keyword.....">
         </div>
    
        
         <div class="col-md-3">
           <input type="text" class="form-control" name="page_url" placeholder="page url">
         </div>
     
        <div class="col-md-2">
          <input type="submit" value="Add" class="btn btn-primary">
        </div>
      </div>

    </form>
  </div>
</div>
</div>


     <div class="col-lg-12 col-xl-12">


       <div class="card">
         <div class="card-header border-bottom-0">
           <h2 class="card-title">All Links</h2>

         </div>
         <div class="e-table px-5 pb-5">
           <div class="table-responsive table-lg">
             <table class="table border-top table-bordered mb-0">
               <thead>
                 <tr>
                   <th class="text-center">
                     ID
                   </th>

                   <th>Keyword</th>
                   <th>Url</th>
                   <th>links</th>
                   <th class="text-center">Actions</th>
                 </tr>
               </thead>
               <tbody>

                @if($keywords->count()>0)
                @foreach($keywords as $keyword)
                <tr>
                 <td class="align-middle text-center">

                   #{{ $keyword->id }}
                 </td>

                 <td class="text-nowrap align-middle">{{ $keyword->keyword }}</td>
                 <td class="text-nowrap align-middle"><span>{{ $keyword->page_url}}</span></td>
                 <td class="text-nowrap align-middle">

                  <a class="btn btn-sm btn-primary badge" data-bs-target="#show-links{{ $keyword->id }}" data-bs-toggle="modal"> {{ $keyword->internal_links }}
                  </a> 


                  <?php 

                  $links = \App\Models\Link::whereKeywordId($keyword->id)->get();

                  ?>

                  @if($links->count() > 0)
                  <!-- edit modal-->
                  <div class="modal fade" id="show-links{{ $keyword->id }}">
                   <div class="modal-dialog modal-dialog-centered" role="document">
                     <div class="modal-content country-select-modal">
                       <div class="modal-header">
                         <h6 class="modal-title">Show links #{{ $keyword->id }}</h6><button aria-label="Close" class="btn-close"
                         data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                       </div>
                       <div class="modal-body">
                         <div class="row row-cards">
                          @foreach($links as $link)

                          <?php 

                          $post = \App\Models\Post::find($link->post_id);

                          ?>

                          <div class="col-lg-8 col-xl-8">
                            @if($link->post_id == 0)
                            <a href="{{ url('/')}}"> Homepage </a>
                            @else
                            <a href="{{ route('page_single', $post->slug ) }}"> {{ $post->title }} </a>
                            @endif

                          </div>


                          @endforeach
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Country-selector modal-->

                @endif

              </td>



              <td class="text-center align-middle">
               <div class="btn-group align-top">

                 <a class="btn btn-sm btn-primary badge" data-bs-target="#edit-keyword{{ $keyword->id }}" data-bs-toggle="modal"><i class="fa fa-edit"></i> Edit</a> 

                 <a class="btn btn-sm btn-success badge" data-bs-target="#edit-generate{{ $keyword->id }}" data-bs-toggle="modal"> Generate</a>

                 <a class="btn btn-sm btn-danger badge" data-bs-target="#delete{{ $keyword->id }}" data-bs-toggle="modal"> Delete</a>




               </div>
             </td>
           </tr>


                <!-- edit modal-->
           <div class="modal fade" id="delete{{ $keyword->id }}">
             <div class="modal-dialog modal-dialog-centered" role="document">
               <div class="modal-content country-select-modal">
                 <div class="modal-header">
                   <h6 class="modal-title">Edit keyword #{{ $keyword->id }}</h6><button aria-label="Close" class="btn-close"
                   data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                 </div>
                 <div class="modal-body">
                   <form class="form-horizontal" action="{{ route('delete_keyword')}}" method="POST">
                     @csrf
                     <input type="hidden" name="id" value="{{ $keyword->id }}">
                   <p>Are you sure you want to delete?</p>
                     

                     <div class=" row mb-4">

                       <div class="col-md-9">
                        <input type="submit" value="Yes" class="btn btn-primary">
                      </div>


                    </div>



                  </form>
                </div>
              </div>
            </div>
          </div>


           <!-- edit modal-->
           <div class="modal fade" id="edit-keyword{{ $keyword->id }}">
             <div class="modal-dialog modal-dialog-centered" role="document">
               <div class="modal-content country-select-modal">
                 <div class="modal-header">
                   <h6 class="modal-title">Edit keyword #{{ $keyword->id }}</h6><button aria-label="Close" class="btn-close"
                   data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                 </div>
                 <div class="modal-body">
                   <form class="form-horizontal" action="{{ route('update_keyword')}}" method="POST">
                     @csrf
                     <input type="hidden" name="id" value="{{ $keyword->id }}">
                     <div class=" row mb-4">
                       <label class="col-md-3 form-label">Keyword</label>
                       <div class="col-md-9">
                         <input type="text" class="form-control" name="keyword" value="{{ $keyword->keyword }}">
                       </div>
                     </div>

                     <div class=" row mb-4">
                       <label class="col-md-3 form-label">Page url</label>
                       <div class="col-md-9">
                         <input type="text" class="form-control" name="page_url" value="{{ $keyword->page_url }}">
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


          <!-- edit modal-->
          <div class="modal fade" id="edit-generate{{ $keyword->id }}">
           <div class="modal-dialog modal-dialog-centered" role="document">
             <div class="modal-content country-select-modal">
               <div class="modal-header">
                 <h6 class="modal-title">Generate Link #{{ $keyword->id }}</h6><button aria-label="Close" class="btn-close"
                 data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
               </div>
               <div class="modal-body">
                 <form class="form-horizontal" action="{{ route('generate_link')}}" method="POST">
                   @csrf
                   <input type="hidden" name="id" value="{{ $keyword->id }}">
                   <div class=" row mb-4">
                     <label class="col-md-3 form-label">Keyword</label>
                     <div class="col-md-9">
                       <input type="text" class="form-control" name="keyword" value="{{ $keyword->keyword }}">
                     </div>
                   </div>

                   <div class=" row mb-4">
                     <label class="col-md-3 form-label">Page url</label>
                     <div class="col-md-9">
                       <input type="text" class="form-control" name="page_url" value="{{ $keyword->page_url }}">
                     </div>
                   </div>



                   <div class=" row mb-4">
                     <label class="col-md-3 form-label">Content</label>
                     <div class="col-md-9">
                       <select name="content" class="form-control">
                         <option value="0">Homepage</option>
                         <option value="1">Post or Pages</option>
                       </select>
                     </div>
                   </div>

                   <?php
                   $websites = \App\Models\Website::all();
                   ?>

                   <div class="row mb-4">
                     <label class="col-md-3 form-label">Website</label>
                     <div class="col-md-9">
                      <select class="form-control" name="site_id">
                        @foreach($websites as $website)
                        <option value="{{ $website->id }}">{{ $website->domain_name }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>


                  <div class=" row mb-4">

                   <div class="col-md-9">
                    <input type="submit" value="Generate" class="btn btn-primary">
                  </div>


                </div>



              </form>
            </div>
          </div>
        </div>
      </div>
      <!-- Country-selector modal-->

      @endforeach
      @else
      <tr>No keyword added</tr>
      @endif



    </tbody>
  </table>
</div>
</div>
</div>
<div class="mb-5">

 <div class="float-end">

  {!! $keywords->links() !!}

</div>
</div>
</div>
<!-- COL-END -->


</div>
<!-- ROW CLOSED -->


</div>
</div>
</div>





@endsection