@extends('layouts.appbar')
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>


@section('content')      <!--app-content open-->
<div class="main-content app-content mt-0">
 <div class="side-app">

   <!-- CONTAINER -->
   <div class="main-container container-fluid">



    <!-- ROW OPEN -->
    <div class="row row-cards">
  

        <div class="col-lg-8 col-xl-8">
         <div class="card">
           <div class="card-header">
             <h4 class="card-title">Apply to become our writer</h4>
           </div>
           <div class="card-body">
             <div class="card-pay">
            

              <form id="fupForm" class="form-horizontal" method="POST" action="{{ route('new_applicant') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_level" value="normal">
                <div class="row">
                  <div class="col-sm-12">


          



                  <div class=" row mb-4">
                    <label class="col-md-3 form-label">Full Name</label>
                    <div class="col-md-9">
                      <input type="" name="name" class="form-control" placeholder="Enter full name" required="">
                    </div>
                  </div>

             
             

                <div class=" row mb-4">
                  <label class="col-md-3 form-label">Applying For:</label>
                  <div class="col-md-9">
                    <select class="form-control select2" name="applying_for" required>

                   

                      <option selected="" value="Normal Orders">Normal Orders</option>
                      <option value="Technical Orders">Technical Orders</option>


                    </select> 
                  </div>
                </div>



      



       



 

  <div class=" row mb-4">
    <label class="col-md-3 form-label">Write your story:</label>
    <div class="col-md-12">
     <textarea  id="summernote" name="description" required></textarea>
     <script>
      $('#summernote').summernote({
        placeholder: 'Your story: In about 100-150 words, please give a detailed account of your writing journey. Dates, companies, and individuals worked with need to be stated.  Please note that you only get one shot at this. Thus, you need to be truthful and thorough',
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


                  <div class=" row mb-4">
                    <label class="col-md-12 form-label">Url for companies worked for (Optional)</label>
                    <div class="col-md-12">
                     <textarea class="form-control" name="url_companies" placeholder="Eg. www.saseni.com"></textarea>
                    </div>
                  </div>


                  <div class=" row mb-4">
                    <label class="col-md-12 form-label">Url for your writer profile (Optional)</label>
                    <div class="col-md-12">
                     <textarea class="form-control" name="url_profiles" placeholder="Eg. www.saseni.com/profile/rabin-nyaga-261"></textarea>
                    </div>
                  </div>





    <div class=" row mb-4">
      <label class="col-md-12 form-label">Attach atleast 5 samples of the work you have worked</label>
      <div class="col-md-12">


       <input type="file"  class="form-control" name="photos[]" required multiple />
     </div>
   </div>

  <button type="submit" id="settings_save_btn56" class="btn btn-primary submitBtn">Submit Now</button>


</div>
<!-- ROW CLOSED -->


</div>
</div>
</div>


@endsection


