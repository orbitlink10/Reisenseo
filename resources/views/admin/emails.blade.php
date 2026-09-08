  @extends('layouts.appbar')
<script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js"></script>
     @section('content') 

     <div class="main-content app-content mt-0">
        <div class="side-app">

            <!-- CONTAINER -->
            <div class="main-container container-fluid">

                  <div class="row">
    @include('flash_msg')

            <div class="col-md-6">
            <div class="card">
                <div class="card-header">Email per website </div>

                <div class="card-body">
                <form method="POST" action="{{ route('email_website') }}">
                        @csrf

                        <div class="row mb-3">
                            

                            <div class="col-md-12">

                              <select class="form-control" name="site_id">
         
<?php
$websites = \App\Models\Website::all();
?>

@foreach($websites as $website)

            <option value="{{ $website->id }}">{{ $website->domain_name }}</option>

            @endforeach


          </select>

                            </div>
                        </div>


                        <div class="row mb-3">

                            <div class="col-md-12">
                                <input id="domain_name" type="text" class="form-control" name="topic" placeholder="Enter topic">

                            </div>
                        </div>

                    

                        <div class="row">
                                            <label class="col-md-3 form-label mb-4">Email Body :</label>
                                            <div class="mb-4">
<textarea id="post" name="message"></textarea>
                 <script>
        ClassicEditor
        .create( document.querySelector( '#post' ) )
        .catch( error => {
          console.error( error );
        } );
      </script>
                                            </div>
                                        </div>


                 
                    


                     

                        <div class="row">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary">
                                Send
                                </button>

                              
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Email per user type </div>

                <div class="card-body">
                <form method="POST" action="{{ route('email_clients') }}">
                        @csrf

                        <div class="row mb-3">
                            

                            <div class="col-md-12">
                              <select class="form-control" name="user_type">
                                <option>Select User Type</option>
                                 <option value="writer">Writers</option>
                                 <option value="editor">Editors</option>
                                 <option value="client">Clients</option>
                                 <option value="student">student</option>
</select>

                            </div>
                        </div>


                        <div class="row mb-3">

                            <div class="col-md-12">
                                <input id="domain_name" type="text" class="form-control" name="topic" placeholder="Enter topic">

                            </div>
                        </div>

                    

                        <div class="row">
                                            <label class="col-md-3 form-label mb-4">Email Body :</label>
                                            <div class="mb-4">
<textarea id="post1" name="message"></textarea>
                 <script>
        ClassicEditor
        .create( document.querySelector( '#post1' ) )
        .catch( error => {
          console.error( error );
        } );
      </script>
                                            </div>
                                        </div>


                 
                    


                     

                        <div class="row">
                            <div class="col-md-8">
                                <button type="submit" class="btn btn-primary">
                                Send
                                </button>

                              
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header">Email single user </div>

                <div class="card-body">
                <form method="POST" action="{{ route('email_client') }}" enctype="multipart/form-data">
                        @csrf

                        <div class="row mb-3">
                        

                            <div class="col-md-12">
                              <select class="form-control" name="client_id">
                                <option>Select Client</option>
                                @foreach($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->email }} ({{ client_site($client->site_id)->domain_name ?? 'none' }})</option>
                                @endforeach
</select>

                            </div>
                        </div>


                        <div class="row mb-3">

                            <div class="col-md-12">
                                <input id="domain_name" type="text" class="form-control" name="topic" placeholder="Enter topic">

                            </div>
                        </div>

                        <div class="row">
                                            <label class="col-md-3 form-label mb-4">Email Body :</label>
                                            <div class="mb-4">
<textarea id="post2" name="message"></textarea>
                 <script>
        ClassicEditor
        .create( document.querySelector( '#post2' ) )
        .catch( error => {
          console.error( error );
        } );
      </script>
                                            </div>
                                        </div>


              

                    


                     

                        <div class="row">
                            <div class="col-md-8 ">
                                <button type="submit" class="btn btn-primary">
                                Send
                                </button>

                              
                            </div>
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



    @endsection
