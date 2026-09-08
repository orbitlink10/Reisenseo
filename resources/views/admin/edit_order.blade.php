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
    <div class="row row-cards" style="padding-top: 20px;">


     <div class="col-lg-8 col-xl-8">
       <div class="card">
         <div class="card-header">
           <h4 class="card-title">Edit order #{{ $order->id }}</h4>
         </div>
         <div class="card-body">

          <form class="form-horizontal" method="POST" action="{{ route('update_order') }}" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="order_id" value="{{ $order->id }}">
            <input type="hidden" name="site_type" value="0">
            <div class="row">
              <div class="col-sm-12">

               <div class=" row mb-4">
                <label class="col-md-3 form-label">Academic Level</label>
                <div class="col-md-9">
                 <div class="selectgroup selectgroup-pills">

                  @if($order->aclevel)

                    <?php
    $level = \App\Models\Level::find($order->aclevel);
  ?>
                    <label class="selectgroup-item">
                      <input type="radio" checked="" name="aclevel" id="aclevel" value="{{ $level->aclevel_value }}" class="selectgroup-input" <?php echo $level->aclevel_checked; ?> onchange ="calculate(this.form);">
                      <span class="selectgroup-button">
                        {{ $level->aclevel_name }}
                      </span>
                    </label>
                  @endif

                  <?php foreach ($levels as $aclevel): ?>
                    <label class="selectgroup-item">
                      <input type="radio" name="aclevel" id="aclevel" value="<?php echo $aclevel['aclevel_value']; ?>" class="selectgroup-input" onchange ="calculate(this.form);">
                      <span class="selectgroup-button">
                        {{ $aclevel->aclevel_name }}
                      </span>
                    </label>
                  <?php endforeach; ?>
                </div>
              </div>
            </div>


            <div class=" row mb-4">
              <label class="col-md-3 form-label">Title</label>
              <div class="col-md-9">
                <input type="text" name="title" class="form-control" value="{{ $order->title }}" required="">
              </div>
            </div>

            <div class=" row mb-4">
              <label class="col-md-3 form-label"><strong>Urgency:</strong></label>
              <div class="col-md-9">
                <span style="color: green;">{!! remainingtime($order->order_due) !!}</span>
                <select name="client_deadline" class="form-control" required=""  onchange ="calculate(this.form);">
                  <?php 
                  if($order->ccost != 0){
                    if(Auth::user()->account_status == '1'){
                      if ($order->word_count!=0) {
                       $cost = $order->ccost/$order->word_count;
                     }
                     else{
                      $cost = $order->ccost;
                    }

                  } else{
                   $admin_share = get_option(site_id().'_admin_share');
                   $cost = $order->ccost/$order->word_count;
                   $cost = $cost/$admin_share; 
                 }
               }
               else{
                $cost = 0;
              }

              ?>
              <option value="{{ $cost }}">{!! $order->order_due !!}</option>

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
            @if($order->paper_id)
            <option value="{{ $order->paper_id }}" selected="">{{ paper($order->paper_id) }}</option>
            @endif
            <option value="1">General</option>
            <?php foreach ($papers as $pptype): ?>
              <option value="<?php echo $pptype['id']; ?>"> <?php echo $pptype['pptype_name']; ?>  </option>
            <?php endforeach; ?>
          </select>
        </div>
      </div>


      <div class=" row mb-4">
        <label class="col-md-3 form-label">Subject</label>
        <div class="col-md-9">
          <select name="order_type" class="form-control" onchange ="calculate(this.form);">
            @if($order->category_id)
            <option value="{{ $order->category_id }}" selected="">{{ subject($order->category_id) }}</option>
            @else
            <option value="" selected="">Not Defined</option>
            @endif

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

            <option value="{{ $order->order_style }}"  selected>

              @if($order->order_style==2)
              Single
              @else
              Double 
              @endif

            </option>

            <option value="1">Double</option>
            <option value="2">Single</option>
          </select> 
        </div>
      </div>

      <div class=" row mb-4">
        <label class="col-md-3 form-label">Number of pages:</label>
        <div class="col-md-3">
         <div class="input-group">
          <span class="input-group-btn">
            <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="page">
              <span class="glyphicon glyphicon-minus"></span>
            </button>
          </span>
          <input type="text" name="page" class="form-control input-number" value="{{ $order->word_count }}" min="0" max="100">
          <span class="input-group-btn">
            <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="page">
              <span class="glyphicon glyphicon-plus"></span>
            </button>
          </span>
        </div>
      </div>
    </div>


    <div class=" row mb-4">
      <label class="col-md-3 form-label">PowerPoint Slides:</label>
      <div class="col-md-3">
       <div class="input-group">
        <span class="input-group-btn">
          <button type="button" class="btn btn-danger btn-number"  data-type="minus" data-field="slide">
            <span class="glyphicon glyphicon-minus"></span>
          </button>
        </span>
        <input type="text" name="slide" class="form-control input-number" value="{{ $order->slide }}" min="0" max="100">
        <span class="input-group-btn">
          <button type="button" class="btn btn-success btn-number" data-type="plus" data-field="slide">
            <span class="glyphicon glyphicon-plus"></span>
          </button>
        </span>
      </div>
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
        <input type="text" name="sources" class="form-control input-number" value="{{ $order->sources }}" min="0" max="100">
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
      <div class="form-group opclick row">

        <div class="row" data-toggle="buttons">
          @if($order->order_citation)
          <label class="col-sm-3 btn btn-default active">
            <input type="radio" name="order_citation" value="{{ $order->order_citation }}" checked>{{ $order->order_citation }}
          </label>
          @endif

          <label class="col-sm-3 btn btn-default">
            <input type="radio" name="order_citation" value="APA 6th Ed">APA 6th Ed
          </label>
          <label class="col-sm-3 btn btn-default">
            <input type="radio" name="order_citation" value="APA 7th Ed">APA 7th Ed
          </label>

          <label class="btn btn-default col-sm-2">
            <input type="radio"  name="order_citation" value="MLA">MLA
          </label>
          <label class="btn btn-default col-sm-2">
            <input type="radio" name="order_citation" value="Havard">Havard
          </label>        
          <label class="btn btn-default col-sm-2">
            <input type="radio" name="order_citation" value="Chicago">Chicago
          </label>        
          <label class="btn btn-default col-sm-2">
            <input type="radio"   name="order_citation" value="Turabian">Turabian
          </label>          
          <label class="btn btn-default col-sm-2">
            <input type="radio"  name="order_citation" value="Other">Other
          </label>
        </div>

      </div>
    </div>
  </div>


  <div class=" row mb-4">
    <label class="col-md-3 form-label">Language </label>
    <div class="col-md-9">
      <div class="form-group opclick row">

        <div class="row" data-toggle="buttons">
          @if($order->language)
          <label class="col-sm-3 btn btn-default active">
            <input type="radio" name="language" value="{{ $order->language }}" checked>{{ $order->language }}
          </label>
          @endif

          <label class="col-sm-3 btn btn-default">
            <input type="radio" name="language" value="USA English">USA English
          </label>
          <label class="col-sm-3 btn btn-default">
            <input type="radio" name="language" value="UK English">UK English
          </label>


        </div>

      </div>
    </div>
  </div>

  <div class=" row mb-4">
    <label class="col-md-3 form-label">Description:</label>
    <div class="col-md-9">
      <textarea class="content" name="description">{{ $order->description}}</textarea>
    </div>
  </div>

  <script>
    ClassicEditor
    .create( document.querySelector( '#editor1' ) )
    .catch( error => {
      console.error( error );
    } );
  </script>



  <div class=" row mb-4" style="display: {{ get_option(site_id().'_enable_dc') == 1 ? 'block' : 'none' }}">
    <label class="col-md-3 form-label">Personal Note (optional):</label>
    <div class="col-md-9">
      <textarea id="editor1" class="form-control" name="personal_note" placeholder="Here you can put the order number from source or unique idenfier of your order">{{ $order->personal_note }}</textarea>
    </div>
  </div>

  @if(Auth::user()->account_status == '1')
  <div class=" row mb-4" style="display: {{ get_option(site_id().'_enable_dc') == 1 ? 'block' : 'none' }}">
    <label class="col-md-12 form-label">Editor Involved (OPTIONAL):</label>
    <div class="col-md-8">
      <select class="form-control select2" name=editor_involved onchange ="calculate(this.form);">
       <option selected="" value="{{ $order->editor_involved }}">
         @if($order->editor_involved==0.8)
         NO
         @elseif($order->editor_involved==1)
         Yes
         @endif
       </option>
       <option value="1">YES</option>
       <option value="0.8">NO</option>
     </select> 
   </div>
 </div>
 @else

 <div class=" row mb-4" style="display: {{ get_option(site_id().'_enable_dc') == 1 ? 'block' : 'none' }}">
  <label class="col-md-12 form-label">Editor Involved (OPTIONAL):</label>
  <div class="col-md-8">
    <select class="form-control select2" name=editor_involved onchange ="calculate(this.form);">
     <option selected="" value="{{ $order->editor_involved }}">
       @if($order->editor_involved==0.875)
       NO
       @elseif($order->editor_involved==1)
       Yes
       @endif
     </option>
     <option value="1">YES</option>
     <option value="0.875">NO</option>
   </select> 
 </div>
</div>

@endif


<div class=" row mb-4" style="display: {{ get_option(site_id().'_enable_dc') == 1 ? 'block' : 'none' }}">
  <label class="col-md-12 form-label">Get Plagiarism Report (OPTIONAL):</label>
  <div class="col-md-8">
    <select class="form-control select2" name=plagiarism_report onchange ="calculate(this.form);">
     <option selected="" value="{{ $order->plagiarism_report }}">
       @if($order->plagiarism_report==0)
       NO
       @elseif($order->plagiarism_report==1)
       Yes
       @endif
     </option>
     <option value="1">YES</option>
     <option value="0">NO</option>
   </select> 
 </div>
</div>



<div class=" row mb-4">
  <div class="col-md-3">Prefered Writer</div>
  <div class="col-md-9">
    <select class="form-control" name="preferred_writer">



      <?php
      $writers = \App\Models\User::whereUserType('writer')->orderBy('name', 'asc')->get(); 
      $writer  = \App\Models\User::whereId($order->preferred_writer)->first();
      ?>

      @if($order->preferred_writer)
      <option value="{{ $order->preferred_writer }}" selected>
       {{ $writer->name }}

     </option>
     @endif
     <option value="0">Select Preffered Writer</option>
     @foreach($writers as $writer)
     <option value="{{ $writer->id }}">{{ $writer->name }} ({{ $writer->id }})</option>
     @endforeach

   </select>
 </div>
</div>

@if($order->preferred_writer)

<div class=" row mb-4">
  <label class="col-md-12 form-label" style="color: red;">Work with preferred writer only:</label>
  <div class="col-md-9">
    <select class="form-control select2" name=preferred_writer_only >
      <option value="{{ $order->preferred_writer_only }}" selected="">

        @if($order->preferred_writer_only == '1') 
        YES
        @else
        NO
        @endif

      </option>
      <option value="1">YES</option>
      <option value="0">NO</option>
    </select> 
  </div>
</div>

@else
<div class=" row mb-4">
  <label class="col-md-12 form-label" style="color: green;">Hire only among top 10 writers:</label>
  <div class="col-md-9">
    <select class="form-control select2" name=top_ten >
     <option value="{{ $order->top_ten }}" selected="">

      @if($order->top_ten == '1') 
      YES
      @else
      NO
      @endif

    </option>
    <option value="1">YES</option>
    <option value="0">NO</option>
  </select> 
</div>
</div>

@endif




<div class="form-group">


  <input type="hidden" name = total class="form-control">
  <input type="hidden" name= due_in class="form-control">


  <button type="submit" id="button" class="btn btn-primary">Update Now</button>

</div>


</div> 
</div>
</form>
</div>
</div>


<div class="card">
  <div class="card-body">
    <table class="table">
      <tbody>
        <tr>
         <h3>Uploaded order files</h3>
       </tr>

       @foreach($uploads as $upload)
       <tr>
        <td>

 {{ \Illuminate\Support\Str::limit($upload->name, 50, '...') }}

        </td>
        <td>{{ uploadType($upload->upload_type)}}</td>
        <td>

          <?php
          $user = \App\Models\User::whereId($upload->user_id)->first();
          ?>

          {{ $user->user_type }}
        </td>
        <td><a href="{{ $upload->file_path }}">Download</a></td>

      </tr>
      @endforeach

      <?php
      $cfiles = \App\Models\Upload::whereOrderId($order->id)->where('upload_type', '>', 2)->get();
      ?>

      <hr>
      @if(Auth::user()->is_editor() or Auth::user()->is_admin() or Auth::user()->is_client())
      @foreach($cfiles as $upload)
      <tr>
        <td>{{ $upload->name}}</td>
        <td>{{ uploadType($upload->upload_type)}}</td>
        <td>

          <?php

          $user = \App\Models\User::whereId($upload->user_id)->first();


          ?>

          {{ $user->user_type }}
        </td>
        <td><a href="{{ $upload->file_path }}">Download</a></td>

      </tr>
      @endforeach
      @endif

      <?php
      $cfiles = \App\Models\Upload::whereOrderId($order->id)->where('upload_type', '<', 3)->get();
      ?>

      <hr>
      @if(Auth::user()->is_editor() or Auth::user()->is_admin() or Auth::user()->is_writer())
      @foreach($cfiles as $upload)
      <tr>
        <td>{{ $upload->name}}</td>
        <td>{{ uploadType($upload->upload_type)}}</td>
        <td>

          <?php

          $user = \App\Models\User::whereId($upload->user_id)->first();


          ?>

          {{ $user->user_type }}
        </td>
        <td><a href="{{ $upload->file_path }}">Download</a></td>

      </tr>
      @endforeach
      @endif

    </tbody>
  </table>

  <h3>Upload order files</h3>
  <form action="{{route('fileUpload')}}" method="post" enctype="multipart/form-data">
   @csrf
   <input type="hidden" name="order_id" value="{{ $order->id }}">
   @if ($message = Session::get('success'))
   <div class="alert alert-success">
     <strong>{{ $message }}</strong>
   </div>
   @endif
   @if (count($errors) > 0)
   <div class="alert alert-danger">
     <ul>
       @foreach ($errors->all() as $error)
       <li>{{ $error }}</li>
       @endforeach
     </ul>
   </div>
   @endif

   <div class=" row mb-4">
    <div class="col-md-12">
      <input type="file" name="file" class="dropify" data-bs-height="180">
    </div>
  </div>

  <div class="col-xl-6 col-md-6">
    <div class="form-group">
     <div class="form-label">File upload type</div>
     <div class="custom-controls-stacked">
      @if(Auth::user()->is_writer())
      <label class="custom-control custom-radio-lg">
        <input type="radio" class="custom-control-input" name="upload_type" value="0" checked>
        <span class="custom-control-label">Final document to editor</span>
      </label>
      <label class="custom-control custom-radio-lg">
        <input type="radio" class="custom-control-input" name="upload_type" value="1">
        <span class="custom-control-label">Plagiarism Report to editor</span>
      </label>
      @endif

      @if(Auth::user()->is_editor() or Auth::user()->is_admin())
      <label class="custom-control custom-radio-lg">
        <input type="radio" class="custom-control-input" name="upload_type" value="2">
        <span class="custom-control-label">File with comments to writer</span>
      </label>



      <label class="custom-control custom-radio-lg">
        <input type="radio" class="custom-control-input" name="upload_type" value="3">
        <span class="custom-control-label">Plagiarism Report to client</span>
      </label>

      <label class="custom-control custom-radio-lg">
        <input type="radio" class="custom-control-input" name="upload_type" value="4" checked>
        <span class="custom-control-label">Final document to client</span>
      </label>





      @endif


    </div>
  </div>
</div>

<button type="submit" name="submit" class="btn btn-primary">
 Upload Files
</button>
</form>



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
              <div class="ops_aclevelright"></div>
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
                <div class="col-sm-12 text-success font-weight-bold"><h4 id="display"> {{ get_option(site_id().'_currency_sign') }} {{ $order->ccost }}</h4></div>

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


<script type="text/javascript">
  function calculate(f) {
    var due_in = f.client_deadline.options[f.client_deadline.selectedIndex].text;

    f.due_in.value=due_in;
  }
</script>


<script src="{{ asset('ckeditor/ckeditor.js') }}"></script>
<script>
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace( 'post_content' );
      </script>


      @endsection

      @section('page-js')


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

    <!-- INTERNAL WYSIWYG Editor JS -->
    <script src="{{ asset('assets/plugins/wysiwyag/jquery.richtext.js')}}"></script>
    <script src="{{ asset('assets/plugins/wysiwyag/wysiwyag.js')}}"></script>


    @endsection
