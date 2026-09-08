     @extends('layouts.appbar')

     @section('content')      <!--app-content open-->
     <div class="main-content app-content mt-0">
      <div class="side-app">

        <!-- CONTAINER -->
        <div class="main-container container-fluid">



         <!-- ROW OPEN -->
         <div class="row row-cards" style="padding-top: 20px;">

          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Account Settings</h3>
            </div>
            <div class="card-body">
              <div class="card-pay">
                <ul class="tabs-menu nav">
                 <li class=""><a href="#tab20" class="payment-icon active" data-bs-toggle="tab">Pricing</a></li>
                 <li><a href="#tab21" data-bs-toggle="tab" class="payment-icon">Subjects</a></li>
                 <li><a href="#tab22" data-bs-toggle="tab" class="payment-icon">  Paper Type </a></li>
                 <li><a href="#tab23" data-bs-toggle="tab" class="payment-icon">   Transaction Charges</a></li>
               </ul>

               <div class="tab-content">
                <div class="tab-pane active show" id="tab20">
                 <div class="card-header">Add pricing</div>

                 <div class="card-body">
                  <form method="POST" action="{{ route('new_pricing') }}">
                    @csrf

                    <div class="row mb-3">
                      <label for="name" class="col-md-4 col-form-label text-md-end">Value(KES)</label>

                      <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="pricing_value" value="{{ old('pricing_value') }}" required autocomplete="name" autofocus placeholder="0.0">

                        @error('name')
                        <span class="invalid-feedback" role="alert">
                          <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="name" class="col-md-4 col-form-label text-md-end">Pricing urgency</label>

                      <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="pricing_urgency" value="{{ old('pricing_urgency') }}" required autocomplete="name" autofocus placeholder="1">


                      </div>
                    </div>

                    <div class="row mb-3">
                      <label for="name" class="col-md-4 col-form-label text-md-end">Pricing duration</label>

                      <div class="col-md-6">
                        <select name="pricing_duration" class="form-control">

                          <option value="Hours">Hours</option>
                          <option value="Days">Days</option> 
                        </select>
                      </div>
                    </div>



                    <div class="row mb-3">
                      <label for="name" class="col-md-4 col-form-label text-md-end">Category Type</label>

                      <div class="col-md-6">
                        <select name="site_type" class="form-control">

                          <option value="0">Academic</option>
                          <option value="1">Article</option>
                          <option value="4">Professional</option>  
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


                <div><br></div>

                <div class="card">
                  <div class="card-header">Categories</div>

                  <div class="card-body">
                   <table class="table">
                     <tbody>
                       <tr>
                         <th>Value</th>
                         <th>Urgency </th>
                         <th>Type </th>
                         <th>Max pages </th>
                         <th>Status</th>
                         <th></th>

                       </tr>
                       @foreach($pricing as $category)
                       <tr>
                         <td> {{ price($category->pricing_value) }}</td>
                         <td>{{ $category->pricing_urgency }} {{ $category->pricing_duration }}</td>
                         <td>

                          @if($category->site_type=='0')
                          Academic
                          @endif

                          @if($category->site_type=='1')
                          Article
                          @endif



                          @if($category->site_type=='4')
                          Buyer
                          @endif

                        </td>
                        <td>{{ $category->max_page }}</td>

                        <td>

                          @if($category->status=='0')
                          Inactive
                          @endif

                          @if($category->status=='1')
                          Active
                          @endif





                        </td>
                        <td class="text-center align-middle">
                         <div class="btn-group align-top">

                           <a class="btn btn-sm btn-primary badge" data-bs-target="#edit-property{{ $category->id }}" data-bs-toggle="modal"><i class="fa fa-edit"></i> Edit</a> 





                         </div>
                       </td>
                     </tr>


                     <!-- edit modal-->
                     <div class="modal fade" id="edit-property{{ $category->id }}">
                       <div class="modal-dialog modal-dialog-centered" role="document">
                         <div class="modal-content country-select-modal">
                           <div class="modal-header">
                             <h6 class="modal-title">Edit Price #{{ $category->id }}</h6><button aria-label="Close" class="btn-close"
                             data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                           </div>
                           <div class="modal-body">
                             <form class="form-horizontal" action="{{ route('update_pricing')}}" method="POST">
                               @csrf
                               <input type="hidden" name="pricing_id" value="{{ $category->id }}">



                               <div class=" row mb-4">
                                 <label class="col-md-4 form-label">Value</label>
                                 <div class="col-md-8">
                                   <input type="text" class="form-control" name="pricing_value" value="{{ $category->pricing_value }}" required="">
                                 </div>


                               </div>

                               <div class=" row mb-4">
                                 <label class="col-md-4 form-label">Pricing urgency</label>
                                 <div class="col-md-8">
                                   <input type="text" class="form-control" name="pricing_urgency" value="{{ $category->pricing_urgency }}" required="">
                                 </div>


                               </div>

                               <div class=" row mb-4">
                                 <label class="col-md-4 form-label">Max Pages</label>
                                 <div class="col-md-8">
                                   <input type="text" class="form-control" name="max_page" value="{{ $category->max_page }}" >
                                 </div>


                               </div>

                               <div class=" row mb-4">
                                 <label class="col-md-4 form-label">Pricing duration</label>
                                 <div class="col-md-8">
                                  <select name="pricing_duration" class="form-control">
                                    <option value="{{ $category->pricing_duration }}" selected="">


                                      {{ $category->pricing_duration }}


                                    </option>

                                    <option value="Hours">Hours</option>
                                    <option value="Days">Days</option> 
                                  </select>
                                </div>
                              </div>





                              <div class=" row mb-4">
                               <label class="col-md-4 form-label">Category Type</label>
                               <div class="col-md-8">

                                 <select class="form-control" name="site_type" required="">
                                  <option value="{{ $category->site_type }}" selected="">

                                    @if($category->site_type==0)                                   <span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">Academic</span>
                                    @elseif($category->site_type==1)
                                    <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">Article</span>
                                    @endif



                                  </option>
                                  <option value="0">Academic</option>
                                  <option value="1">Article</option>


                                </select>
                              </div>
                            </div>

                            <div class=" row mb-4">
                             <label class="col-md-4 form-label">Active</label>
                             <div class="col-md-8">

                               <select class="form-control" name="status" required="">
                                <option value="{{ $category->status }}" selected="">

                                  @if($category->status==0)                                   <span class="badge bg-warning-transparent rounded-pill text-warning p-2 px-3">inactive</span>
                                  @elseif($category->status==1)
                                  <span class="badge bg-success-transparent rounded-pill text-success p-2 px-3">active</span>
                                  @endif



                                </option>
                                <option value="0">Inactive</option>
                                <option value="1">Active</option>


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




              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>

    <div>     
    </div>


    <div class="tab-pane" id="tab21">
      <div class="card">

        <div class="card-header">Add Subject</div>

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
                  <option value="1">Article</option>  
                  <option value="0">Academic</option>
                  <option value="4">Buyer</option>
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

      <div><br></div>

      <div class="card">
        <div class="card-header">Categories</div>

        <div class="card-body">
         <table class="table">
           <tbody>
             <tr>

               <th>Name</th>
               <th>Value</th>
               <th>Site Type</th>
               <th></th>

             </tr>
             @foreach($categories as $category)
             <tr>
               <td>{{ $category->name}}</td>
               <td>{{ $category->pvalue}}</td>
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
</div>

<div class="tab-pane" id="tab22">
    <div class="card">

        <div class="card-header">Add Paper Type</div>

        <div class="card-body">
          <form method="POST" action="{{ route('new_paper_type') }}">
            @csrf

            <div class="row mb-3">
              <label for="name" class="col-md-4 col-form-label text-md-end">Name</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

      
              </div>
            </div>


            <div class="row mb-3">
              <label for="name" class="col-md-4 col-form-label text-md-end">Paper type price value</label>

              <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('pptype_pvalue') is-invalid @enderror" name="pptype_pvalue" value="{{ old('pptype_pvalue') }}" required autocomplete="name" autofocus>

           
              </div>
            </div>

            <div class="row mb-3">
              <label for="name" class="col-md-4 col-form-label text-md-end">Category Type</label>

              <div class="col-md-6">
                <select name="cat_type" class="form-control">
                  <option value="1">Article</option>  
                  <option value="0">Academic</option>
                  <option value="4">Professional</option>
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

      <div><br></div>

      <div class="card">
        <div class="card-header">Paper Types</div>

        <div class="card-body">
         <table class="table">
           <tbody>
             <tr>

               <th>Name</th>
               <th>Value</th>
               <th>Site Type</th>
               <th></th>

             </tr>
             @foreach($papers as $category)
             <tr>
               <td>{{ $category->pptype_name}}</td>
               <td>{{ $category->pptype_pvalue}}</td>
               <td>                  @if($category->cat_type=='0')
                Academic
                @endif

                @if($category->cat_type=='1')
                Article
                @endif



                @if($category->cat_type=='4')
                Professional
              @endif</td>
              <td>
                <a class="btn btn-sm btn-primary badge" data-bs-target="#edit-paper{{ $category->id }}" data-bs-toggle="modal"><i class="fa fa-edit"></i> Edit</a> 

                 <a class="btn btn-sm btn-danger badge" data-bs-target="#delete-paper{{ $category->id }}" data-bs-toggle="modal"><i class="fa fa-edit"></i> Delete</a> 

              </td>
            </tr>

                        <!-- delete modal-->
            <div class="modal fade" id="delete-paper{{ $category->id }}">
             <div class="modal-dialog modal-dialog-centered" role="document">
               <div class="modal-content country-select-modal">
                 <div class="modal-header">
                   <h6 class="modal-title">Delete Paper Type #{{ $category->id }}</h6><button aria-label="Close" class="btn-close"
                   data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                 </div>
                 <div class="modal-body">
                   <form method="POST" action="{{ route('delete_paper') }}" enctype="multipart/form-data">
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
            <div class="modal fade" id="edit-paper{{ $category->id }}">
             <div class="modal-dialog modal-dialog-centered" role="document">
               <div class="modal-content country-select-modal">
                 <div class="modal-header">
                   <h6 class="modal-title">Edit Paper Type #{{ $category->id }}</h6><button aria-label="Close" class="btn-close"
                   data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                 </div>
                 <div class="modal-body">
                   <form method="POST" action="{{ route('update_paper') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="cat_id" value="{{ $category->id }}">

                    <div class="row mb-3">


                      <div class="col-md-12">
                        <label>Name</label>
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="name" value="{{ $category->pptype_name }}" placeholder="Title" required autocomplete="title" autofocus>
                      </div>
                    </div>


                    <div class="row mb-3">


                      <div class="col-md-12">
                        <label>pvalue</label>
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="pvalue" value="{{ $category->pptype_pvalue }}" placeholder="Title" required autocomplete="title" autofocus>
                      </div>
                    </div>




                    <div class="row mb-3">


                      <div class="col-md-12">
                        <label>Site Type</label>
                        <select name="cat_type" class="form-control">
                          <option selected value="{{ $category->cat_type }}">
                            @if($category->cat_type=='0')
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
</div>



<div class="tab-pane" id="tab23">
    <div class="card">

        <div class="card-header">Trasaction Charges</div>

        <div class="card-body">
          <form method="POST" action="{{ route('new_charges') }}">
            @csrf

            <div class="row mb-3">
              <label for="name" class="col-md-4 col-form-label text-md-end">Amount From</label>
              <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="amount_from" value="{{ old('name') }}" required autocomplete="name" autofocus>
              </div>
            </div>


            <div class="row mb-3">
              <label for="name" class="col-md-4 col-form-label text-md-end">Charges</label>
              <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('pptype_pvalue') is-invalid @enderror" name="charges" value="{{ old('pptype_pvalue') }}" required autocomplete="name" autofocus>
              </div>
            </div>


                        <div class="row mb-3">
              <label for="name" class="col-md-4 col-form-label text-md-end">Max amount</label>
              <div class="col-md-6">
                <input id="name" type="text" class="form-control @error('pptype_pvalue') is-invalid @enderror" name="max" value="{{ old('max') }}" required autocomplete="max" autofocus>
              </div>
            </div>


            <div class="row mb-3">
              <label for="name" class="col-md-4 col-form-label text-md-end">Money To</label>
               <div class="col-md-6">
                <select name="amount_to" class="form-control">
                  <option value="1">Mpesa</option>  
                  <option value="2">Equity</option>
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

      <div><br></div>

      <div class="card">
        <div class="card-header">Charges</div>

        <div class="card-body">
         <table class="table">
           <tbody>
             <tr>

               <th>Amount From</th>
               <th>Charges</th>
                         <th>Max amount</th>
               <th>Amount To</th>
               <th></th>

             </tr>
             @foreach($charges as $category)
             <tr>
               <td>{{ $category->amount_from}}</td>
               <td>{{ $category->charges}}</td>
                <td>{{ $category->max}}</td>
             <td>{{ $category->amount_to}}</td>
              <td>
                <a class="btn btn-sm btn-primary badge" data-bs-target="#edit-charge{{ $category->id }}" data-bs-toggle="modal"><i class="fa fa-edit"></i> Edit</a> 

                 <a class="btn btn-sm btn-danger badge" data-bs-target="#delete-paper{{ $category->id }}" data-bs-toggle="modal"><i class="fa fa-edit"></i> Delete</a> 

              </td>
            </tr>

                        <!-- delete modal-->
            <div class="modal fade" id="delete-paper{{ $category->id }}">
             <div class="modal-dialog modal-dialog-centered" role="document">
               <div class="modal-content country-select-modal">
                 <div class="modal-header">
                   <h6 class="modal-title">Delete Paper Type #{{ $category->id }}</h6><button aria-label="Close" class="btn-close"
                   data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                 </div>
                 <div class="modal-body">
                   <form method="POST" action="{{ route('delete_paper') }}" enctype="multipart/form-data">
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
            <div class="modal fade" id="edit-charge{{ $category->id }}">
             <div class="modal-dialog modal-dialog-centered" role="document">
               <div class="modal-content country-select-modal">
                 <div class="modal-header">
                   <h6 class="modal-title">Edit charges #{{ $category->id }}</h6><button aria-label="Close" class="btn-close"
                   data-bs-dismiss="modal" type="button"><span aria-hidden="true">×</span></button>
                 </div>
                 <div class="modal-body">
                   <form method="POST" action="{{ route('update_charges') }}" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="cat_id" value="{{ $category->id }}">

                    <div class="row mb-3">


                      <div class="col-md-12">
                        <label>Amount From</label>
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="amount_from" value="{{ $category->amount_from }}" placeholder="Amount From" required autocomplete="title" autofocus>
                      </div>
                    </div>


                    <div class="row mb-3">


                      <div class="col-md-12">
                        <label>Charges</label>
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="charges" value="{{ $category->charges }}" placeholder="Charges" required autocomplete="title" autofocus>
                      </div>
                    </div>


                            <div class="row mb-3">


                      <div class="col-md-12">
                        <label>Max Amount</label>
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="max" value="{{ $category->max }}" placeholder="max" required autocomplete="title" autofocus>
                      </div>
                    </div>




                    <div class="row mb-3">


                      <div class="col-md-12">
                        <label>Money To</label>
                        <select name="amount_to" class="form-control">
                          <option selected value="{{ $category->amount_to }}">
                           {{ $category->amount_to }}
                          </option>
                          <option value="1">Mpesa </option>
                          <option value="2">Equity Bank</option>


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
</div>
</div>
</div>
</div>
</div>







</div>
<!-- ROW CLOSED -->


</div>
</div>
</div>





@endsection