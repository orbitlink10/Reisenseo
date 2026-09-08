@extends('layouts.appbar')
<script src="https://cdn.ckeditor.com/ckeditor5/11.1.1/classic/ckeditor.js"></script>

<style type="text/css">
    
    .sticky-top {
  position: fixed !important;
  margin-top: 10%;
}

.pricecalculate h5, .pricecalculate h3 {
    margin-top: 0px;
    margin-bottom: 0px;
    border-bottom: 1px dotted #333;
    font-size: 18px;
    text-transform: uppercase;
    padding: 10px 0px;
    font-size: 22px;
}

.pricecalculate {
    background-color: #f0fcff;
    border: 1px solid rgba(0,0,100,.09);
    border-radius: 4px;
    -webkit-box-shadow: 0 5px 15px rgba(0,0,100,.1),0 0 5px rgba(0,0,200,.08);
    box-shadow: 0 5px 15px rgba(0,0,100,.1),0 0 5px rgba(0,0,200,.08);
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    color: #405d6c;
    padding: 20px;
}


</style>

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
           <h4 class="card-title">Add New order</h4>
       </div>
               <div class="card-body">
       <div class="card-pay">
           <ul class="tabs-menu nav">
                 <li class=""><a href="{{ route('add_order') }}" class="payment-icon">Normal Order</a>
                 </li>
                 <li>
                  <a href="{{ route('new_technical_order') }}" class="payment-icon active">Technical Order</a>
                </li>
<!--                 <li>
                  <a href="#tab22" data-bs-toggle="tab" class="payment-icon">  Free Inquiry</a>
                </li> -->
           </ul>

          <form class="form-horizontal" method="POST" action="{{ route('technical_order') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="order_level" value="technical">
            <div class="row">
                <div class="col-sm-12">


                   <div class=" row mb-4">
                    <label class="col-md-3 form-label">Title</label>
                    <div class="col-md-9">
                        <input type="" name="title" class="form-control" placeholder="Enter title" required="">
                    </div>
                </div>

                <div class=" row mb-4">
                    <label class="col-md-3 form-label"><strong>Urgency:</strong></label>
                    <div class="col-md-9">
                        <select name="client_deadline1" class="form-control" required=""  onchange ="calculate(this.form);">
                     
                            <?php foreach ($prices as $urgency): ?>
                             <option value="<?php echo $urgency['pricing_value']; ?>"> <?php echo $urgency['pricing_urgency']; ?> <?php echo $urgency['pricing_duration']; ?>  </option>
                         <?php endforeach; ?>
                      
                     </select>
                    </div>
                </div>

             <div class=" row mb-4">
                    <label class="col-md-3 form-label">Paper Type</label>
                    <div class="col-md-9">
                        <select name="paper_id" class="form-control" onchange ="calculate(this.form);">
                            <option>Select Paper Type</option>
                            <option value="1" selected="">General</option>
                            <?php foreach ($papers as $pptype): ?>
                              <option value="<?php echo $pptype['id']; ?>"> <?php echo $pptype['pptype_name']; ?>  </option>
                          <?php endforeach; ?>
                      </select>
                    </div>
                </div>
        
        
                <div class=" row mb-4">
                    <label class="col-md-3 form-label">Subject</label>
                    <div class="col-md-9">
                        <select name="order_type1" class="form-control" onchange ="calculate(this.form);">
                            <option>Select subject</option>
                            <option value="1" selected="">General</option>
                            <?php foreach ($categories as $pptype): ?>
                              <option value="<?php echo $pptype['id']; ?>"> <?php echo $pptype['name']; ?>  </option>
                          <?php endforeach; ?>
                      </select>
                    </div>
                </div>
        
<div class=" row mb-4">
                    <label class="col-md-3 form-label">Description:</label>
                    <div class="col-md-9">
                        <textarea id="editor2" class="form-control" name="description"></textarea>
                    </div>
                </div>



     <div class=" row mb-4">
        <label class="col-md-3 form-label">Project Budget</label>
        <div class="col-md-9">
          <div class="wrap-input100 validate-input input-group" data-bs-validate="Valid phone is required: 0725000000">
            <a href="javascript:void(0)" class="input-group-text bg-white text-muted">
             {{ get_currency() }}
            </a>
 <input class="input100 border-start-0 ms-0 form-control" name="order_budget" type="text" value="0">
          </div>
      </div>
      </div>

                 <script>
        ClassicEditor
        .create( document.querySelector( '#editor2' ) )
        .catch( error => {
          console.error( error );
        } );
      </script>

       <div class=" row mb-4">
          <label class="col-md-3 form-label">Upload Additional Files</label>
    <div class="col-md-12">
      

     <input type="file"  class="form-control" name="photos[]" multiple />
    </div>
  </div>
        
   <div class=" row mb-4">
                    <label class="col-md-3 form-label">Personal Note (optional):</label>
                    <div class="col-md-9">
                        <textarea id="editor1" class="form-control" name="personal_note" placeholder="Here you can put the order number from source or unique idenfier of your order"></textarea>
                    </div>
                </div>
        
        
        <div class="form-group">
        
        

                  <input type="hidden" name= due_in1 class="form-control">
        
        
        <button type="submit" id="button" class="btn btn-primary">Submit Now</button>
      
        </div>
        </div> 
        </div>
        </form>
      </div>
  </div>
    </div>
</div>

</div>
<!-- ROW CLOSED -->

<script type="text/javascript">
    function calculate(f) {

        var due_in = f.client_deadline1.options[f.client_deadline1.selectedIndex].text;

        f.due_in1.value=due_in;
       
    }
</script>
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
   <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
    <script>
        var dropzone = new Dropzone('#file-upload', {
            previewTemplate: document.querySelector('#preview-template').innerHTML,
            parallelUploads: 3,
            thumbnailHeight: 150,
            thumbnailWidth: 150,
            maxFilesize: 5,
            filesizeBase: 1500,
            thumbnail: function (file, dataUrl) {
                if (file.previewElement) {
                    file.previewElement.classList.remove("dz-file-preview");
                    var images = file.previewElement.querySelectorAll("[data-dz-thumbnail]");
                    for (var i = 0; i < images.length; i++) {
                        var thumbnailElement = images[i];
                        thumbnailElement.alt = file.name;
                        thumbnailElement.src = dataUrl;
                    }
                    setTimeout(function () {
                        file.previewElement.classList.add("dz-image-preview");
                    }, 1);
                }
            }
        });
        
        var minSteps = 6,
            maxSteps = 60,
            timeBetweenSteps = 100,
            bytesPerStep = 100000;
        dropzone.uploadFiles = function (files) {
            var self = this;
            for (var i = 0; i < files.length; i++) {
                var file = files[i];
                totalSteps = Math.round(Math.min(maxSteps, Math.max(minSteps, file.size / bytesPerStep)));
                for (var step = 0; step < totalSteps; step++) {
                    var duration = timeBetweenSteps * (step + 1);
                    setTimeout(function (file, totalSteps, step) {
                        return function () {
                            file.upload = {
                                progress: 100 * (step + 1) / totalSteps,
                                total: file.size,
                                bytesSent: (step + 1) * file.size / totalSteps
                            };
                            self.emit('uploadprogress', file, file.upload.progress, file.upload
                                .bytesSent);
                            if (file.upload.progress == 100) {
                                file.status = Dropzone.SUCCESS;
                                self.emit("success", file, 'success', null);
                                self.emit("complete", file);
                                self.processQueue();
                            }
                        };
                    }(file, totalSteps, step), duration);
                }
            }
        }
    </script>

    <!-- FILE UPLOADES JS -->
<script src="{{ asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
<script src="{{ asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>

 <!-- INTERNAL File-Uploads Js-->
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
    <script src="{{ asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
    <script src="{{ asset('assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>
    @endsection
