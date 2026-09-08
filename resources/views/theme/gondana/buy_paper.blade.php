@extends('layouts.frontbar')
@section('title')@if( ! empty($title)){{$title}} |@endif @parent @endsection


@section('social-meta')
<link rel="canonical" href="{{ route('experts') }}" />
@endsection
@section('content') 




<!-- ROW-1 OPEN -->
<div class="section pb-0" style="background-color: #F0F0F5;">
    <div class="container">
      
    <div class="row row-cards" style="padding-top: 20px;">
     <div class="col-lg-8 col-xl-8">
      <div class="card">
       <div class="card-header">
        <h3 class="card-title">Buy Answer</h3>
      </div>
      <div class="card-body">
        <div class="card-pay">
          <ul class="tabs-menu nav">
       
            <li><a href="#tab21" data-bs-toggle="tab" class="payment-icon active"><svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><path d="M19.6542969,7.5869141c-0.2009888-0.2196655-0.4307251-0.4111938-0.6829224-0.569397c0.2329712-1.2444458-0.1186523-2.5269165-0.9537964-3.4784546c-0.9375-1.0605469-2.5751953-1.5986328-4.8681641-1.5986328H7.2646484c-0.6590576,0.0014038-1.2197266,0.480957-1.3232422,1.1318359l-2.453125,15.5898438c-0.0911865,0.5485229,0.279541,1.0670776,0.828064,1.1582642c0.0548706,0.0090942,0.1104126,0.0136719,0.1660767,0.0136108h3.0460815l-0.1593628,1.0136719c-0.0817261,0.5153809,0.2698364,0.9993896,0.7852173,1.0811157c0.0480957,0.0076294,0.0967407,0.0115356,0.1454468,0.0116577h3.0634766c0.6047363,0.0022583,1.12146-0.4353638,1.218689-1.0322266l0.6065063-3.8271484l0.0409546-0.2167969c0.0169067-0.1159668,0.116272-0.2019653,0.2333984-0.2021484h0.4580078c3.6289062,0,5.8027344-1.7197266,6.4619141-5.1123047C20.7811279,10.1879883,20.5109253,8.7180176,19.6542969,7.5869141z M7.8912964,17.5264893l-0.2067261,1.3065186l-3.2089844-0.0107422L6.9296875,3.2236328c0.0270996-0.1637573,0.1690063-0.2837524,0.335022-0.2832031h5.8847656c1.9941406,0,3.3798828,0.4238281,4.1162109,1.2587891c0.7022095,0.8255005,0.9553833,1.942627,0.6777344,2.9902344l0.0020752,0.0003052l-0.0001221,0.0006714c-0.0166016,0.1054688-0.0351562,0.2138672-0.0566406,0.3251953l-0.0010376,0.0029297c-0.6494141,3.3476562-2.7207031,4.9755859-6.3330078,4.9755859H9.8271484c-0.661499-0.0014648-1.2243652,0.4816284-1.3232422,1.1357422L7.8912964,17.5264893z M19.4003906,11.359375c-0.5625,2.8955078-2.3544922,4.3027344-5.4794922,4.3027344h-0.4580078c-0.6051636-0.0033569-1.1224976,0.4347534-1.21875,1.0322266l-0.6152344,3.8729858l-0.0322266,0.1708984c-0.017334,0.1160889-0.1170044,0.2020874-0.234375,0.2021484l-3.0048828,0.0644531l0.6048584-3.8487549l0.5338135-3.3699951l-0.0040894-0.0006104l0.0001831-0.0012817c0.024353-0.1663208,0.1668701-0.2897339,0.335022-0.289978h1.7275391c3.9599609,0,6.3896484-1.8076172,7.2275391-5.375c0.0419922,0.0410156,0.0820312,0.0830078,0.1201172,0.1259766C19.5513916,9.1461182,19.7360229,10.3009644,19.4003906,11.359375z"/></svg> Paypal</a>
            </li>
         
      

     
          </ul>
 
          <div class="tab-content">
            <div style="">
              <div class="tab-pane active show" id="tab21">

                <div id="smart-button-container">
                  <div style="text-align: center;">
                    <div id="paypal-button-container"></div>
                  </div>
                </div>
                <script src="https://www.paypal.com/sdk/js?client-id={{ get_option(site_id().'_paypal_client_id') }}&enable-funding=venmo&currency=USD" data-sdk-integration-source="button-factory"></script>
                <script>
                  function initPayPalButton() {
                    paypal.Buttons({
                      style: {
                        shape: 'rect',
                        color: 'gold',
                        layout: 'vertical',
                        label: 'paypal',

                      },

                      createOrder: function(data, actions) {
                        return actions.order.create({
                          purchase_units: [{"amount":{"currency_code":"USD","value":{{ $order->cost }}}}]
                        });
                      },

                      onApprove: function(data, actions) {
                        return actions.order.capture().then(function(orderData) {

            // Full available details
                          console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));

            // Show a success message within this page, e.g.
                          const element = document.getElementById('paypal-button-container');
                          element.innerHTML = '';
                          element.innerHTML = '<h3>Thank you for your payment!</h3>';
                          window.location = "{{ route('success_buy', $order->id) }}";

            // Or go to another URL:  actions.redirect('thank_you.html');

                        });
                      },

                      onError: function(err) {
                        console.log(err);
                      }
                    }).render('#paypal-button-container');
                  }
                  initPayPalButton();
                </script>
              </div>
            </div>

          </div>


    
       </div>
     </div>
   </div>


 </div>
 <!-- COL-END -->


 <div class="col-xl-4 col-md-12">

  <div class="card cart">

    <div class="card-body">
      <h3 class="card-title">{{ $order->payment_source }}</h3>

      <ul class="list-group border br-7 mt-5">

     


        <li class="list-group-item border-0">
          Paper cost
          <span class="h6 fw-bold mb-0 float-end">USD {{ $order->cost }}</span>
        </li>
        <li class="list-group-item border-0">
          Discount
          <span class="h6 fw-bold mb-0 float-end">0%</span>
        </li>

        <li class="list-group-item border-0">
          Total
          <span class="h4 fw-bold mb-0 float-end">USD {{ $order->cost }}</span>
        </li>
      </ul>
    </div>

  </div>
</div>


</div>
<!-- ROW CLOSED -->




</div>
<!-- ROW-1 CLOSED -->
</div>


<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<script>
 $(document).ready(function(){



  $(document).on('click', '#makePayment', function(e){

    e.preventDefault();

            var phone    = document.getElementById('phone').value;   // it will get id of clicked row
            var amount   = document.getElementById('amount').value;
            var account  = document.getElementById('account').value;
            var pay_type = document.getElementById('pay_type').value;

            $('#dynamic-content3').html('<p align="center" style="color:#000000;"><strong>Heads up!</strong> Request sent to your mobile Phone. Check your phone and put your mpesa pin.</p>'); // leave it blank before ajax call
            $('#modal-loader3').show();      // load ajax loader
            $('#makePayment').hide();
            $('#makePaymentDisabled').show();
            
            $.ajax({
              url: '{{url('cmpesa')}}',
              type: 'get',
              data: 'phone='+phone+'&amount='+amount+'&account='+account+'&pay_type='+pay_type,
              dataType: 'html'
            })
            .done(function(data){
               $('#dynamic-content3').html(data); // load response 
            //  window.location = "{{ route('success_deposit', $order->id) }}";

             })
            .fail(function(){
              $('#dynamic-content3').html('<i class="glyphicon glyphicon-info-sign"></i> Something went wrong, Please try again...');
              $('#modal-loader3').hide();
              $('#makePaymentDisabled').hide();
              $('#makePayment').show();
            });
            
          });



});

</script>


<script>
  $(document).ready(function(){

            /**
             * Send order data to server
             */
   $('#settings_save_btn').click(function(e){
    e.preventDefault();

    var this_btn = $(this);
    this_btn.attr('disabled', 'disabled');

    var form_data = this_btn.closest('form').serialize();
    $.ajax({

      url : '{{ route('cmpesa') }}',
      type: "POST",
      data: form_data,
      success : function (data) {
        var order_id = 14;
        if (data.success == 1){

          this_btn.removeAttr('disabled');

          swal({
            showConfirmButton: false,
            html:true, 
            title: data.msg, 
            text:'<p align="center" style="color:#000000;"><strong>Heads up!</strong> Request sent to your mobile Phone. Check your phone and put your mpesa pin.</p><br> After you have made the payment click below button to proceed <br><form class="form-horizontal" action="{{ route("confirm_payment")}}" method="POST"> @csrf <input type="hidden" name="id" value="'+data.transactionId+'"> <input type="hidden" name="payment_id" value="{{ $order->id }}">  <button  class="btn btn-success">Proceed</button></form>'
        });
        }
      }
    });
  });



 });
</script>


@endsection