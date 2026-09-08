@extends('layouts.appbar')
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<style type="text/css">

  .sticky-top {
   margin-top: 10%;
   position: -webkit-sticky;
   position: sticky;
   top: 0;
   padding: 10px;
   margin-right: 40%;
   font-size: 25px;
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



/* Container style */
.bg-light {
  background-color: #f5f5f5;
}

/* Custom file input */
.custom-file {
  position: relative;
}

.custom-file-input {
  position: relative;
  z-index: 2;
  width: 100%;
  height: calc(1.5em + 0.75rem + 2px);
  margin: 0;
  opacity: 0;
}

.custom-file-label {
  position: absolute;
  top: 0;
  right: 0;
  left: 0;
  z-index: 1;
  height: calc(1.5em + 0.75rem + 2px);
  padding: 0.375rem 0.75rem;
  line-height: 1.5;
  color: #495057;
  background-color: #fff;
  border: 1px solid #ced4da;
  border-radius: 0.25rem;
}

.custom-file-input:focus ~ .custom-file-label {
  border-color: #80bdff;
  box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
}

/* Styling for selected files */
#selectedFiles {
  margin-top: 10px;
  font-size: 14px;
  color: #6c757d;
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
                 <li class=""><a href="#tab20" class="payment-icon active" data-bs-toggle="tab">Normal Order</a>
                 </li>
                 
                 <li>
                  <a href="{{ route('new_technical_order') }}" class="payment-icon">Technical Order</a>
                </li>

                @if(get_option(site_id().'_enable_professional_service') == 'professional')
                <li>
                  <a href="{{ route('new_professional_service') }}"  class="payment-icon">  Professional Service</a>
                </li> 
                @endif
              </ul>

              <form id="fupForm" class="form-horizontal" method="POST" action="{{ route('cnew_order') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_level" value="normal">
                <div class="row">
                  <div class="col-sm-12">


                    <div class=" row mb-4">
                      <label class="col-md-3 form-label">Academic Level</label>
                      <div class="col-md-9">
                       <div class="selectgroup selectgroup-pills">

                        <?php foreach ($levels as $aclevel): ?>
                          <label class="selectgroup-item">
                            <input type="radio" name="aclevel" id="aclevel" value="<?php echo $aclevel['aclevel_value']; ?>" class="selectgroup-input" <?php echo $aclevel['aclevel_checked']; ?> onchange ="calculate(this.form);">
                            <span class="selectgroup-button">
                              {{ $aclevel->aclevel_name }}
                            </span>
                          </label>
                        <?php endforeach; ?>
                      </div>
                    </div>
                  </div>



                  <div class=" row mb-4">
                    <label class="col-md-3 form-label">Assignment topic</label>
                    <div class="col-md-9">
                      <input type="" name="title" class="form-control" placeholder="Enter title" required="">
                    </div>
                  </div>

                  <div class=" row mb-4">
                    <label class="col-md-3 form-label"><strong>Urgency:</strong></label>
                    <div class="col-md-9">
                      <select name="client_deadline" class="form-control" required=""  onchange ="calculate(this.form);">

                        <?php foreach ($prices as $urgency): ?>
                         <option value="<?php echo $urgency['pricing_value']; ?>"> <?php echo $urgency['pricing_urgency']; ?> <?php echo $urgency['pricing_duration']; ?>  </option>
                       <?php endforeach; ?>

                     </select>
                   </div>
                 </div>

                 <div class=" row mb-4">
                  <label class="col-md-3 form-label"> Assignment type: </label>
                  <div class="col-md-9">
                    <select name="paper_id" class="form-control" onchange ="calculate(this.form);">

                      <option value="1" selected="">Essay (Any Type)</option>
                      <?php foreach ($papers as $pptype): ?>
                        <option value="<?php echo $pptype['pptype_pvalue']; ?>"> <?php echo $pptype['pptype_name']; ?>  </option>
                      <?php endforeach; ?>
                    </select>

                    <div class="well" id="response" style="display: none;">
                      <div><br></div>

                      <select name="question_id" class="form-control select2-show-search form-select" data-placeholder="Choose previous order with Discussion Question">
                        <option label="Choose previous order with Discussion Question"></option>

                        <?php
                        $orders = \App\Models\Order::whereUserId(Auth::user()->id)->orderBy('id', 'desc')->get();
                        ?>
                        @foreach($orders as $order)
                        <option value="{{ $order->id }}">{{ $order->id }} - {{ $order->title }}</option>
                        @endforeach
                      </select>
                    </div>
                  </div>
                </div>







                <div class=" row mb-4">
                  <label class="col-md-3 form-label">Subject</label>
                  <div class="col-md-9">
                    <select name="order_type" class="form-control" onchange ="calculate(this.form);">
                      <option>Select subject</option>
                      <option value="1" selected="">General</option>
                      <?php foreach ($categories as $pptype): ?>
                        <option value="<?php echo $pptype['id']; ?>"> <?php echo $pptype['name']; ?>  </option>
                      <?php endforeach; ?>
                    </select>
                  </div>
                </div>




                <div class=" row mb-4">
                  <label class="col-md-3 form-label">Spacing:</label>
                  <div class="col-md-9">
                    <select class="form-control select2" name=price onchange ="calculate(this.form);">

                      <option  selected>select Spacing</option>

                      <option selected="" value="1">Double</option>
                      <option value="2">Single</option>
                    </select> 
                  </div>
                </div>

                <div class=" row mb-4">
                  <label class="col-md-3 form-label"> Assignment size: </label>
                  <div class="col-md-9">
                    <select class="form-control select2" name=page onchange ="calculate(this.form);">

                      <option value="0" selected=""> 0 pages</option>
                      <option value="0.5"> 0.5 page ({{ 0.5*275 }} words)</option>
                      <?php foreach (range(1, get_option(site_id().'_max_pages'), 0.5) as $x) {  ?>
                       <option value="<?php echo $x; ?>"> <?php echo $x; ?> pages ({{ $x*275 }} words)</option>
                     <?php } ?>
                   </select>
                 </div>
               </div>

               <div class=" row mb-4">
                <label class="col-md-3 form-label"></label>
                <div class="col-md-9">
                  <select class="form-control select2" name=slide onchange ="calculate(this.form);">

                    <option value="0" selected=""> 0 slide</option>
                    <?php foreach (range(1, get_option(site_id().'_max_pages'), 1) as $x) {  ?>
                     <option value="<?php echo $x; ?>"> <?php echo $x; ?> slides</option>
                   <?php } ?>
                 </select>
               </div>
             </div>



             <div class=" row mb-4">
              <label class="col-md-3 form-label">Number of sources </label>
              <div class="col-md-3">
                <div class="input-group">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="sources">
                      <span class="glyphicon glyphicon-minus"></span>
                    </button>
                  </span>
                  <input type="text" name="sources" class="form-control input-number" value="0" min="0" max="100">
                  <span class="input-group-btn">
                    <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="sources">
                      <span class="glyphicon glyphicon-plus"></span>
                    </button>
                  </span>
                </div>
              </div>
            </div>

            <div class=" row mb-4">
              <label class="col-md-3 form-label">Citation </label>
              <div class="col-md-9">

                <div class="selectgroup selectgroup-pills">
                  <label class="selectgroup-item">
                    <input type="radio" name="order_citation" id="order_citation" value="APA 6th Ed" class="selectgroup-input">
                    <span class="selectgroup-button">
                     APA 6th Ed
                   </span>
                 </label>
               </div>

               <div class="selectgroup selectgroup-pills">
                <label class="selectgroup-item">
                  <input type="radio" name="order_citation" id="order_citation" value="APA 7th Ed" class="selectgroup-input" checked>
                  <span class="selectgroup-button">
                    APA 7th Ed
                  </span>
                </label>
              </div>

              <div class="selectgroup selectgroup-pills">
                <label class="selectgroup-item">
                  <input type="radio" name="order_citation" id="order_citation" value="MLA" class="selectgroup-input">
                  <span class="selectgroup-button">
                    MLA
                  </span>
                </label>
              </div>

              <div class="selectgroup selectgroup-pills">
                <label class="selectgroup-item">
                  <input type="radio" name="order_citation" id="order_citation" value="Havard" class="selectgroup-input">
                  <span class="selectgroup-button">
                    Havard
                  </span>
                </label>
              </div>

              <div class="selectgroup selectgroup-pills">
                <label class="selectgroup-item">
                  <input type="radio" name="order_citation" id="order_citation" value="Chicago" class="selectgroup-input">
                  <span class="selectgroup-button">
                    Chicago
                  </span>
                </label>
              </div>

              <div class="selectgroup selectgroup-pills">
                <label class="selectgroup-item">
                  <input type="radio" name="order_citation" id="order_citation" value="Turabian" class="selectgroup-input">
                  <span class="selectgroup-button">
                    Turabian
                  </span>
                </label>
              </div>

              <div class="selectgroup selectgroup-pills">
                <label class="selectgroup-item">
                  <input type="radio" name="order_citation" id="order_citation" value="Other" class="selectgroup-input">
                  <span class="selectgroup-button">
                    Other
                  </span>
                </label>
              </div>



            </div>
          </div>


          <div class=" row mb-4">
            <label class="col-md-3 form-label"> Assignment language:  </label>
            <div class="col-md-9">

              <div class="selectgroup selectgroup-pills">
                <label class="selectgroup-item">
                  <input type="radio" name="language" id="order_citation" value="USA English" class="selectgroup-input" checked>
                  <span class="selectgroup-button">
                   English (US)
                 </span>
               </label>
             </div>

             <div class="selectgroup selectgroup-pills">
              <label class="selectgroup-item">
                <input type="radio" name="language" id="order_citation" value="UK English" class="selectgroup-input">
                <span class="selectgroup-button">
                  English (UK)
                </span>
              </label>
            </div>




          </div>
        </div>


        <div class=" row mb-4">
          <label class="col-md-12 form-label">Is this a continuation of previous paper? Yes <input type="checkbox" id="myCheck" onclick="myFunction()" /></label>

        </div>





        <div class="well" id="text" style="display: none;">

         <div class=" row mb-4">
          <label class="col-md-3 form-label">Choose previous order</label>
          <div class="col-md-9">
            <select name="order_continuation" class="form-control select2-show-search form-select" data-placeholder="Choose previous order">
              <option label="Choose previous order"></option>

              <?php
              $orders = \App\Models\Order::whereUserId(Auth::user()->id)->orderBy('id', 'desc')->get();
              ?>
              @foreach($orders as $order)
              <option value="{{ $order->id }}">{{ $order->id }} - {{ $order->title }}</option>
              @endforeach
            </select>
          </div>
        </div>




      </div>

      
      <script>
        function myFunction() {
          var checkBox = document.getElementById("myCheck");
          var text = document.getElementById("text");
          if (checkBox.checked == true){
            text.style.display = "block";
          } else {
           text.style.display = "none";
         }
       }
     </script>



     <div class=" row mb-4">
      <label class="col-md-3 form-label">Description:</label>
      <div class="col-md-12">
       <textarea  id="summernote" name="description"></textarea>
       <script>
        $('#summernote').summernote({
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




  <div class="bg-light p-4 rounded">
    <h5 class="mb-4">Upload Files</h5>
    <div class="custom-file">
      <input type="file" class="custom-file-input" id="customFile" name="photos[]" multiple>
      <label class="custom-file-label" for="customFile">Choose files</label>
    </div>
    <small class="form-text text-muted">You can upload multiple files. Maximum file size: 100MB each.</small>
    <div id="selectedFiles" class="mt-3"></div>
  </div>




  <script>
    document.getElementById('customFile').addEventListener('change', function (e) {
      const files = e.target.files;
      let fileList = '';
      for (let i = 0; i < files.length; i++) {
        fileList += files[i].name + '<br>';
      }
      document.getElementById('selectedFiles').innerHTML = fileList;
    });
  </script>




  @if(Auth::user()->is_student())
  <div class=" row mb-4" style="display: none">
    <label class="col-md-3 form-label">Personal Note (optional):</label>
    <div class="col-md-9">
      <textarea id="editor1" class="form-control" name="personal_note" placeholder="Here you can put the order number from source or unique idenfier of your order"></textarea>
    </div>
  </div>

  @if(Auth::user()->account_status == '1')
  <div class=" row mb-4" style="display: none">
    <label class="col-md-12 form-label">Editor Involved (<span style="color: green;">OPTIONAL</span>):</label>
    <div class="col-md-9">
      <select class="form-control select2" name=editor_involved onchange ="calculate(this.form);">

        <option selected="" value="1">YES</option>
        <option value="0.8">NO</option>
      </select> 
    </div>
  </div>
  @else

  <div class=" row mb-4" style="display: none">
    <label class="col-md-12 form-label">Editor Involved (<span style="color: green;">OPTIONAL</span>):</label>
    <div class="col-md-9">
      <select class="form-control select2" name=editor_involved onchange ="calculate(this.form);">

        <option selected="" value="1">YES</option>
        <option value="0.875">NO</option>
      </select> 
    </div>
  </div>

  @endif 


  <div class=" row mb-4" style="display: none">
    <label class="col-md-12 form-label">Get Plagiarism Report (<span style="color: green;">OPTIONAL</span>):</label>
    <div class="col-md-9">
      <select class="form-control select2" name=plagiarism_report onchange ="calculate(this.form);">

        <option selected="" value="1">YES</option>
        <option value="0">NO</option>
      </select> 
    </div>
  </div>
  @else


  <div class=" row mb-4" style="display: {{ get_option(site_id().'_enable_dc') == 1 ? 'block' : 'none' }}">
    <label class="col-md-3 form-label">Personal Note (optional):</label>
    <div class="col-md-9">
      <textarea id="editor1" class="form-control" name="personal_note" placeholder="Here you can put the order number from source or unique idenfier of your order"></textarea>
    </div>
  </div>



  @if(Auth::user()->account_status == '1')
  <div class=" row mb-4" style="display: {{ get_option(site_id().'_enable_dc') == 1 ? 'block' : 'none' }}">
    <label class="col-md-12 form-label">Editor Involved (<span style="color: green;">OPTIONAL</span>):</label>
    <div class="col-md-9">
      <select class="form-control select2" name=editor_involved onchange ="calculate(this.form);">

        <option selected="" value="1">YES</option>
        <option value="0.8">NO</option>
      </select> 
    </div>
  </div>
  @else

  <div class=" row mb-4" style="display: {{ get_option(site_id().'_enable_dc') == 1 ? 'block' : 'none' }}">
    <label class="col-md-12 form-label">Editor Involved (<span style="color: green;">OPTIONAL</span>):</label>
    <div class="col-md-9">
      <select class="form-control select2" name=editor_involved onchange ="calculate(this.form);">

        <option selected="" value="1">YES</option>
        <option value="0.875">NO</option>
      </select> 
    </div>
  </div>

  @endif 


  <div class=" row mb-4">
    <label class="col-md-12 form-label">Get Plagiarism Report (<span style="color: green;">OPTIONAL</span>):</label>
    <div class="col-md-9">
      <select class="form-control select2" name=plagiarism_report onchange ="calculate(this.form);">

        <option selected="" value="1">YES</option>
        <option value="0">NO</option>
      </select> 
    </div>
  </div>

  @endif



  @if(session()->get('writer_id'))

  <div class=" row mb-4">
    <label class="col-md-3 form-label">Preferred Writer ID</label>
    <div class="col-md-9">
      <input type="number" name="preferred_writer" class="form-control" placeholder="Enter title" value="{{ session()->get('writer_id') }}">
    </div>
  </div>

  <div class=" row mb-4">
    <label class="col-md-12 form-label" style="color: red;">Work with preferred writer only:</label>
    <div class="col-md-9">
      <select class="form-control select2" name=preferred_writer_only onchange ="calculate(this.form);">

        <option value="1">YES</option>
        <option value="0" selected="">NO</option>
      </select> 
    </div>
  </div>

  <div class=" row mb-4" style="display: none;">
    <label class="col-md-12 form-label" style="color: green;">Hire only among top 10 writers:</label>
    <div class="col-md-9">
      <select class="form-control select2" name=top_ten onchange ="calculate(this.form);">

        <option value="0">YES</option>
        <option value="0" selected="">NO</option>
      </select> 
    </div>
  </div>

  @else


  <div class=" row mb-4">
    <label class="col-md-12 form-label">Work with preferred writer? Yes <input type="checkbox" id="my" onclick="myWriter()" /> </label>

  </div>

  <div class="well" id="text1" style="display: none;">

    <div class=" row mb-4">
      <label class="col-md-12 form-label" style="color: green;">Choose writer</label>
      <div class="col-md-9">
        <select name="preferred_writer" class="form-control select2-show-search form-select">
          <option value="">Select a writer</option>
          <?php 
          $worders = \App\Models\User::whereAccountStatus(1)->whereUserType('writer')->get(); 
          ?>
          @foreach ($worders as $writer)
          <option value="{{ $writer->id }}">
            {{ $writer->nickname }} (ID: {{ $writer->id }})
            <span class="text-muted">
              ({{ writer_counter($writer->id, 2) }} in progress, {{ writer_counter($writer->id, 4) }} completed, {{ writer_counter($writer->id, 5) }} approved)
            </span>
          </option>
          @endforeach
        </select> 
      </div>
    </div>





  </div>
  <script>
    function myWriter() {
      var my = document.getElementById("my");
      var text1 = document.getElementById("text1");
      if (my.checked == true){
        text1.style.display = "block";
      } else {
       text1.style.display = "none";
     }
   }
 </script>






 <div class=" row mb-4" style="display: none;">
  <label class="col-md-12 form-label" style="color: red;">Work with preferred writer only:</label>
  <div class="col-md-9">
    <select class="form-control select2" name=preferred_writer_only onchange ="calculate(this.form);">

      <option selected="" value="0">YES</option>
      <option value="0">NO</option>
    </select> 
  </div>
</div>

<div class=" row mb-4">
  <label class="col-md-12 form-label" style="color: green;">Hire only among top 10 writers:</label>
  <div class="col-md-9">
    <select class="form-control select2" name=top_ten onchange ="calculate(this.form);">

      <option value="1">YES</option>
      <option value="0" selected="">NO</option>
    </select> 
  </div>
</div>

@endif


<div class="form-group">
  <input type="hidden" name = total class="form-control">
  <input type="hidden" name= due_in class="form-control">
  <input type="hidden" name= paper class="form-control">

  <button type="submit" id="settings_save_btn56" class="btn btn-primary submitBtn">Submit Now</button>

  <div id="spinner-border" style="display:none;" class="spinner-border" role="status">
    <span class="visually-hidden">Loading...</span>
  </div>

</div>
</div> 
</div>
</form>
</div>
</div>
</div>
</div>

<div class="col-lg-4 col-xl-4">
  <div class="sticky-top">
    <div class="pricecalculate">
      <div>

        <div class="">

          <div class="row">
            <div class="col-sm-12">









              <div style="font-size: 15px; font-weight: bold" class="topicright"> </div>
              <div class="col_aclevelright"></div>
              <hr style="margin-bottom: 0px" />
              <div class="order_tpaperright"></div>
              <div class="order_subjectright"></div>

              <div class="row">
                <div class="col-sm-7"><div class="order_pagesright float-left"></div></div>
                <div class="col-sm-5 font-weight-bold"><div class="totalsumright"> </div></div>
              </div>

              <div class="row">
                <div class="col-sm-7"><div class="order_slidesright"></div></div>
                <div class="col-sm-5 font-weight-bold"><div class="order_slidesrightprice"></div></div>
              </div>

              <div class="row">
                <div class="col-sm-7"><div class="order_discountright"></div></div>
                <div class="col-sm-5 font-weight-bold"><div class="order_discountrightprice"></div></div>
              </div>

              <hr style="margin-bottom: 0px" />
              <div class="row">
                <div class="col-sm-12 font-weight-bold"> Total price </div>
                <div class="col-sm-12 text-success font-weight-bold"><h4 id="display"> {{ get_currency() }} 0</h4></div>

              </div>


              <input id="words" type="hidden" value="275" style="width: 100px;border: 0px solid #fff;text-align: right" />
              <input id="addontotal" type="hidden"  name="addontotal" value="0" id="df" readonly>
              <input type="hidden" name="cpn_value" id="cpn_value" class="form-control" value="1">
              <div class="alert alert-danger print-error-msg" style="display:none">    </div>

              <script type="text/javascript">


                $(document).ready(function() {

                  $(".btn-submit").click(function(e){

                    e.preventDefault();

                    var _token = $("input[name='_token']").val();
                    var cpn_name = $("input[name='cpn_name']").val();

                    $.ajax({

                      url: "order/coupon",

                      type:'POST',

                      dataType: "json",

                      data: {cpn_name:cpn_name},

                      success: function(data) {

                        if($.isEmptyObject(data.error)){


                          $(".print-error-msg").css('display','block');

                          $(".print-error-msg").html(data.success);

                        }else{

    //Get
                          var bla = $('#order_amount').val();
                          var code = data.error;
                          var num  = parseFloat(code)*parseFloat(bla);
                          var discount_amount  = parseFloat(bla) - parseFloat(num);
                          var discount_amnt  = discount_amount.toFixed(2);
                          var n_dic = num.toFixed(2);

                          $(".success-msg").css('display','block');
                          $(".order_discountright").html('Discount');
                          $(".order_discountrightprice").html('-$' + discount_amnt);

                          $(".orderamountc").html(n_dic);

                          $('input[name="cpn_value"]').val(code);
                          $('input[name="cpn_namedb"]').val(cpn_name);
                          $('input[name="order_coupon"]').val(code);

                          $('input[name="order_amount"]').val(n_dic);
                          $(".coupon_area").css('display','none');
                          $(".print-error-msg").css('display','none');
                        }

                      }

                    });


                  }); 


                });


              </script>





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



@if(Auth::user()->account_status == '1')
<script type="text/javascript">
  function calculate(f) {

    var amount = 0;
    var order_type = 1;
    var editor_involved =f.editor_involved.options[f.editor_involved.selectedIndex].value;
    var plagiarism_report =f.plagiarism_report.options[f.plagiarism_report.selectedIndex].value;  
    var price = f.price.options[f.price.selectedIndex].value;
    var page = f.page.options[f.page.selectedIndex].value;
    var client_deadline = f.client_deadline.options[f.client_deadline.selectedIndex].value;
    var due_in = f.client_deadline.options[f.client_deadline.selectedIndex].text;
    var paper = f.paper_id.options[f.paper_id.selectedIndex].text;
    var paper_id = f.paper_id.options[f.paper_id.selectedIndex].value;
    var order_type = f.order_type.options[f.order_type.selectedIndex].value;
    var slide = f.page.options[f.slide.selectedIndex].value;
    var amount = client_deadline;
    var preferred_writer_only  =f.preferred_writer_only.options[f.preferred_writer_only.selectedIndex].value;
    var aclevel = document.querySelector('input[name="aclevel"]:checked').value;

    var preferred_writer_only_amount = "<?php echo get_option(site_id().'_preferred_writer_only'); ?>";
    var preferred_writer_only = preferred_writer_only*preferred_writer_only_amount*page;
    var plagiarism_report_cost = "<?php echo get_option(site_id().'_plagiarism_report'); ?>";

    var top_ten  =f.top_ten.options[f.top_ten.selectedIndex].value;
    var top_ten_cost = "<?php echo get_option(site_id().'_top_ten'); ?>";
    var top_ten_cost = top_ten*top_ten_cost*page;


    <?php $cat_id = "<script>document.write(order_type)</script>"?>   
    <?php $category = \App\Models\Category::find(1)->pvalue; ?>

    var order_type = "<?php echo $category; ?>";
    var ppt_slide_cost = "<?php echo get_option(site_id().'_ppt_slide_cost'); ?>";
    var total=order_type*price*paper_id*aclevel;
    if (page != 0) {
      var page = amount*page;
      var total=total*page*editor_involved;

    }
    else{
      var total=total-1;
    }

    if (slide != 0) {
      var slide = slide*ppt_slide_cost;
      var total=total + slide;
    }

    var plagiarism_report = plagiarism_report*plagiarism_report_cost;
    var total = total+ plagiarism_report + preferred_writer_only + top_ten_cost;

    var total = total.toFixed(2);

    f.total.value=total;
    f.due_in.value=due_in;
    f.paper.value=paper;
    var dollar = "{{ get_currency() }} ";

    document.getElementById('display').innerHTML =dollar.concat(total);
    //question id
    var paper_id = f.paper_id.options[f.paper_id.selectedIndex].text;
    var response = document.getElementById("response");
    if (paper_id == 'Discussion Response'){
      response.style.display = "block";
    } else {
     response.style.display = "none";
   }
 }
</script>
@else
<script type="text/javascript">
  function calculate(f) {
    var amount = 0;
    var order_type = 1;
    var editor_involved =f.editor_involved.options[f.editor_involved.selectedIndex].value;
    var plagiarism_report =f.plagiarism_report.options[f.plagiarism_report.selectedIndex].value; 
    var preferred_writer_only  =f.preferred_writer_only.options[f.preferred_writer_only.selectedIndex].value;
    var price = f.price.options[f.price.selectedIndex].value;
    var page = f.page.options[f.page.selectedIndex].value;
    var client_deadline = f.client_deadline.options[f.client_deadline.selectedIndex].value;
    var due_in = f.client_deadline.options[f.client_deadline.selectedIndex].text;
    var paper = f.paper_id.options[f.paper_id.selectedIndex].text;
    var paper_id = f.paper_id.options[f.paper_id.selectedIndex].value;
    var order_type = f.order_type.options[f.order_type.selectedIndex].value;
    var slide = f.page.options[f.slide.selectedIndex].value;
    var amount = client_deadline;

    var top_ten  =f.top_ten.options[f.top_ten.selectedIndex].value;
    var top_ten_cost = "<?php echo get_option(site_id().'_top_ten'); ?>";
    var top_ten_cost = top_ten*top_ten_cost*page;

    var aclevel = document.querySelector('input[name="aclevel"]:checked').value;


    <?php $cat_id = "<script>document.write(order_type)</script>"?>   
    <?php $category = \App\Models\Category::find(1)->pvalue; ?>

    var order_type = "<?php echo $category; ?>";
    var admin_share = "<?php echo get_option(site_id().'_admin_share'); ?>";
    var ppt_slide_cost = "<?php echo get_option(site_id().'_ppt_slide_cost'); ?>";
    var preferred_writer_only_amount = "<?php echo get_option(site_id().'_preferred_writer_only'); ?>";
    var preferred_writer_only = preferred_writer_only*preferred_writer_only_amount*page;


    var total=order_type*price*paper_id*aclevel;
    if (page != 0) {
      var page = amount*page;

      var total=total*page*editor_involved;

    }
    else{
      var total=total-1;
    }

    if (slide != 0) {
      var slide = slide*ppt_slide_cost;
      var total=total + slide;
    }

    var total = total*admin_share;
    var plagiarism_report_cost = "<?php echo get_option(site_id().'_plagiarism_report'); ?>";

    var plagiarism_report = plagiarism_report*plagiarism_report_cost;
    var total = total+ plagiarism_report + preferred_writer_only +top_ten_cost;

    var total = total.toFixed(2);

    f.total.value=total;
    f.due_in.value=due_in;
    f.paper.value=paper;
    var dollar = "{{ get_currency() }} ";

    document.getElementById('display').innerHTML =dollar.concat(total);

    //question id
    var paper_id = f.paper_id.options[f.paper_id.selectedIndex].text;
    var response = document.getElementById("response");
    if (paper_id == 'Discussion Response'){
      response.style.display = "block";
    } else {
     response.style.display = "none";
   }


 }
</script>
@endif


@if(Auth::user()->is_student())
<script type="text/javascript">
  function calculate(f) {
    var amount = 0;
    var order_type = 1;
    var editor_involved =f.editor_involved.options[f.editor_involved.selectedIndex].value;
    var plagiarism_report =f.plagiarism_report.options[f.plagiarism_report.selectedIndex].value; 
    var price = f.price.options[f.price.selectedIndex].value;
    var paper = f.paper_id.options[f.paper_id.selectedIndex].text;
    var paper_id = f.paper_id.options[f.paper_id.selectedIndex].value;
    var page = f.page.options[f.page.selectedIndex].value;
    var client_deadline = f.client_deadline.options[f.client_deadline.selectedIndex].value;
    var due_in = f.client_deadline.options[f.client_deadline.selectedIndex].text;
    var order_type = f.order_type.options[f.order_type.selectedIndex].value;
    var slide = f.page.options[f.slide.selectedIndex].value;
    var amount = client_deadline;



    <?php $cat_id = "<script>document.write(order_type)</script>"?>   
    <?php $category = \App\Models\Category::find(1)->pvalue; ?>

    var order_type = "<?php echo $category; ?>";
    var admin_share = "<?php echo get_option(site_id().'_admin_share'); ?>";
    var ppt_slide_cost = "<?php echo get_option(site_id().'_ppt_slide_cost'); ?>";
    var conversion_rate = "<?php echo get_option(site_id().'_conversion_rate'); ?>";



    var total=order_type*price;
    if (page != 0) {
      var page = amount*page;

      var total=total*page*editor_involved;

    }
    else{
      var total=total-1;
    }

    if (slide != 0) {
      var slide = slide*ppt_slide_cost;
      var total=total + slide;
    }

    var total = total*admin_share*conversion_rate;
    var plagiarism_report_cost = "<?php echo get_option(site_id().'_plagiarism_report'); ?>";
    var plagiarism_report = plagiarism_report*plagiarism_report*conversion_rate;
    var total = total+ plagiarism_report;

    var total = total.toFixed(2);

    f.total.value=total;
    f.due_in.value=due_in;
    f.paper.value=paper;
    var dollar = "{{ get_currency() }} ";

    document.getElementById('display').innerHTML =dollar.concat(total);

    //question id
    var paper_id = f.paper_id.options[f.paper_id.selectedIndex].text;
    var response = document.getElementById("response");
    if (paper_id == 'Discussion Response'){
      response.style.display = "block";
    } else {
     response.style.display = "none";
   }
 }
</script>
@endif





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

<script type="text/javascript">
  //plugin bootstrap minus and plus
//http://jsfiddle.net/laelitenetwork/puJ6G/
  $('.btn-number').click(function(e){
    e.preventDefault();

    fieldName = $(this).attr('data-field');
    type      = $(this).attr('data-type');
    var input = $("input[name='"+fieldName+"']");
    var currentVal = parseInt(input.val());
    if (!isNaN(currentVal)) {
      if(type == 'minus') {

        if(currentVal > input.attr('min')) {
          input.val(currentVal - 1).change();
        } 
        if(parseInt(input.val()) == input.attr('min')) {
          $(this).attr('disabled', true);
        }

      } else if(type == 'plus') {

        if(currentVal < input.attr('max')) {
          input.val(currentVal + 1).change();
        }
        if(parseInt(input.val()) == input.attr('max')) {
          $(this).attr('disabled', true);
        }

      }
    } else {
      input.val(0);
    }
  });
  $('.input-number').focusin(function(){
   $(this).data('oldValue', $(this).val());
 });
  $('.input-number').change(function() {

    minValue =  parseInt($(this).attr('min'));
    maxValue =  parseInt($(this).attr('max'));
    valueCurrent = parseInt($(this).val());

    name = $(this).attr('name');
    if(valueCurrent >= minValue) {
      $(".btn-number[data-type='minus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
      alert('Sorry, the minimum value was reached');
      $(this).val($(this).data('oldValue'));
    }
    if(valueCurrent <= maxValue) {
      $(".btn-number[data-type='plus'][data-field='"+name+"']").removeAttr('disabled')
    } else {
      alert('Sorry, the maximum value was reached');
      $(this).val($(this).data('oldValue'));
    }


  });
  $(".input-number").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
    if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A
     (e.keyCode == 65 && e.ctrlKey === true) || 
             // Allow: home, end, left, right
     (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
     return;
 }
        // Ensure that it is a number and stop the keypress
 if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
  e.preventDefault();
}
});
</script>

<script type="text/javascript">
  $(document).on("click", "#click", function(e) {
    swal('Congratulations!', 'Your message has been succesfully sent', 'success');
  });
</script>

<!-- FILE UPLOADES JS -->
<script src="{{ asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
<script src="{{ asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>
<!-- INTERNAL WYSIWYG Editor JS -->
<script src="{{ asset('assets/plugins/wysiwyag/jquery.richtext.js')}}"></script>
<script src="{{ asset('assets/plugins/wysiwyag/wysiwyag.js')}}"></script>







<!-- SELECT2 JS -->
<script src="{{ asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script src="{{ asset('assets/js/select2.js')}}"></script>


<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>




<script type="text/javascript">
  $(document).ready(function(e){
    // Submit form data via Ajax
    $("#fupForm").on('submit', function(e){
      e.preventDefault();
      Swal.fire({
        title: 'Uploading...',
        html: 'Please wait...',
        allowOutsideClick: false,
        showConfirmButton: false,
        didOpen: () => {
          Swal.showLoading()
        },
      });
      $.ajax({
        xhr: function() {
          var xhr = new window.XMLHttpRequest();
          xhr.upload.addEventListener("progress", function(evt) {
            if (evt.lengthComputable) {
              var percentComplete = ((evt.loaded / evt.total) * 100);
              Swal.update({ html: `Upload progress: ${percentComplete.toFixed(2)}%` });
            }
          }, false);
          return xhr;
        },
        type: 'POST',
        url: '{{ route("cnew_order") }}',
        data: new FormData(this),
        dataType: 'json',
        contentType: false,
        cache: false,
        processData: false,
        beforeSend: function(){
          $('.submitBtn').attr("disabled","disabled");
          $('#fupForm').css("opacity",".5");
        },
        success: function(data) {
          if (data.success == 1){
            Swal.fire({
              icon: 'success',
              showConfirmButton: false,
              allowOutsideClick: false,
              title: data.msg,
              html: '<b>We have a writer available to work on it. Now that you have created an order, it is in the Pending phase. Click "Pay Now" and make the payment for our writer to begin working on the order</b><br><br> <form class="form-horizontal" action="{{ route("confirm_order")}}" method="POST"> @csrf <input type="hidden" name="id" value="'+data.order_id+'"> <button class="btn btn-success">Pay Now</button><a href="{{ url("/") }}/dashboard/view-order/'+data.slug+'" class="btn btn-info" >Preview Order</a> <a href="{{ url("/") }}/dashboard/edit-order/'+data.order_id+'" class="btn btn-warning" >Edit</a></form>'
            });
          }
        },
        error: function(err) {
          var errMsg;
          if (err.status === 413) {
            errMsg = 'The uploaded file is too large. Please upload a smaller file.';
          } else {
            errMsg = err.statusText + ' (' + err.status + '): ';
          }
          Swal.fire({
            icon: 'error',
            title: 'Oops...',
            text: errMsg,
          });
          console.log(err);
        },

        complete: function() {
          $('.submitBtn').removeAttr("disabled");
          $('#fupForm').css("opacity","");
        }
      });
    });

    // File type validation
    $("#photos").change(function() {
      var file = this.files[0];
      var fileType = file.type;
      var match = ['application/pdf', 'application/msword', 'application/vnd.ms-office', 'image/jpeg', 'image/png', 'image/jpg'];
      if(!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]) || (fileType == match[3]) || (fileType == match[4]) || (fileType == match[5]))){
        Swal.fire({
          icon: 'error',
          title: 'Oops...',
          text: 'Sorry, only PDF, DOC, JPG, JPEG, & PNG files are allowed to upload.'
        });
        $("#photos").val('');
        return false;
      }
    });
  });
</script>


@endsection


