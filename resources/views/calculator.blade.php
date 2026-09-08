<div class="card border-0 shadow">
  <div class="card-body"><h4 class="ctitle">Calculate the price</h4><div>
    <form method="GET" action="{{ route('register') }}" enctype="multipart/form-data">
      @csrf
      <div class="row">
        <div class="col-sm-12">
         <div class="css-1g6gooi">
          <select name="client_deadline" class="form-control"  onchange ="calculate(this.form);">

            <?php foreach ($prices as $urgency): ?>
             <option name="order_deadline" value="<?php echo $urgency['pricing_value']; ?>"> <?php echo $urgency['pricing_urgency']; ?> <?php echo $urgency['pricing_duration']; ?>  </option>
           <?php endforeach; ?>
         </select>
       </div>

       <div class="css-1g6gooi">
         <select name="order_type" class="form-control"  onchange ="calculate(this.form);">
          <option>Select type document</option>
          <option value="1" selected="">Essay</option>
          <?php foreach ($categories as $pptype): ?>
            <option value="<?php echo $pptype['pvalue']; ?>"> <?php echo $pptype['name']; ?>  </option>
          <?php endforeach; ?>
        </select>
      </div>




      <div style="display: none;" class="form-group">
       <select class="form-control select2" name=price onchange ="calculate(this.form);">

        <option  selected>select Spacing</option>

        <option selected="" value="1">Double</option>
        <option value="2">Single</option>
      </select> 
    </div>



    <div class="css-1g6gooi">
     <select class="form-control select2" name=page onchange ="calculate(this.form);">

       <option value="1"> Select words/Pages </option>
       <option value="1" selected=""> 1 Page (275 words)</option>
       <?php foreach (range(1, 30, 1) as $x) {  ?>
        <option value="<?php echo $x; ?>"> <?php echo $x; ?> Pages  (<?php echo $x*275; ?> words)</option>
      <?php } ?>
    </select>
  </div>



  <div class="css-1g6gooi">
   <select class="form-control select2" name=page onchange ="calculate(this.form);">

     <option value="1"> Select words</option>
     <?php foreach (range(1, 30, 1) as $x) {  ?>
      <option value="<?php echo $x; ?>"> <?php echo $x*50; ?> words</option>
    <?php } ?>
  </select>
</div>






<div class="css-1g6gooi">

  <table  class="table">
    <tbody>
      <tr style="height:14px;">
        <td>
         <span class="off">15% OFF</span>

         <input type="hidden" name = total class="form-control">
       </td>
       <td>
         <h3 id="display"> </h3>
       </td>

     </tr>
   </tbody>
 </table>
 <center><button type="submit"  class="btn btn-primary btn-lg">Order Now</button></center>



</div>
</div> 
</div>
</form>
</div>

</div>
</div>
