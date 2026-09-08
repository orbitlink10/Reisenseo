<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <?php
  $total = 0;
  ?>
  @foreach($services as $service)


  <?php

  $total = $total+$service->amount;
  ?>
  @endforeach

  <!--  This file has been downloaded from bootdey.com @bootdey on twitter -->
  <!--  All snippets are MIT license http://bootdey.com/license -->
  <title>Payment Request of  @if($order->currency=='2')Ksh @endif @if($order->currency=='1')USD @endif {{$total }} </title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://code.jquery.com/jquery-1.10.2.min.js"></script>
  <link href="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
  <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
  <link href="assets/img/favicon.png" rel="icon">

  <style type="text/css">
/* -------------------------------------
    GLOBAL
    A very basic CSS reset
    ------------------------------------- */
    * {
      margin: 0;
      padding: 0;
      font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif;
      box-sizing: border-box;
      font-size: 14px;
    }

    img {
      max-width: 100%;
    }

    body {
      -webkit-font-smoothing: antialiased;
      -webkit-text-size-adjust: none;
      width: 100% !important;
      height: 100%;
      line-height: 1.6;
    }

    /* Let's make sure all tables have defaults */
    table td {
      vertical-align: top;
    }

/* -------------------------------------
    BODY & CONTAINER
    ------------------------------------- */
    body {
      background-color: #f6f6f6;
    }

    .body-wrap {
      background-color: #f6f6f6;
      width: 100%;
    }

    .container {
      display: block !important;
      max-width: 600px !important;
      margin: 0 auto !important;
      /* makes it centered */
      clear: both !important;
    }

    .content {
      max-width: 600px;
      margin: 0 auto;
      display: block;
      padding: 20px;
    }

/* -------------------------------------
    HEADER, FOOTER, MAIN
    ------------------------------------- */
    .main {
      background: #fff;
      border: 1px solid #e9e9e9;
      border-radius: 3px;
    }

    .content-wrap {
      padding: 20px;
    }

    .content-block {
      padding: 0 0 20px;
    }

    .header {
      width: 100%;
      margin-bottom: 20px;
    }

    .footer {
      width: 100%;
      clear: both;
      color: #999;
      padding: 20px;
    }
    .footer a {
      color: #999;
    }
    .footer p, .footer a, .footer unsubscribe, .footer td {
      font-size: 12px;
    }

/* -------------------------------------
    TYPOGRAPHY
    ------------------------------------- */
    h1, h2, h3 {
      font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif;
      color: #000;
      margin: 40px 0 0;
      line-height: 1.2;
      font-weight: 400;
    }

    h1 {
      font-size: 32px;
      font-weight: 500;
    }

    h2 {
      font-size: 24px;
    }

    h3 {
      font-size: 18px;
    }

    h4 {
      font-size: 14px;
      font-weight: 600;
    }

    p, ul, ol {
      margin-bottom: 10px;
      font-weight: normal;
    }
    p li, ul li, ol li {
      margin-left: 5px;
      list-style-position: inside;
    }

/* -------------------------------------
    LINKS & BUTTONS
    ------------------------------------- */
    a {
      color: #1ab394;
      text-decoration: underline;
    }

    .btn-primary {
      text-decoration: none;
      color: #FFF;
      background-color: #1ab394;
      border: solid #1ab394;
      border-width: 5px 10px;
      line-height: 2;
      font-weight: bold;
      text-align: center;
      cursor: pointer;
      display: inline-block;
      border-radius: 5px;
      text-transform: capitalize;
    }

/* -------------------------------------
    OTHER STYLES THAT MIGHT BE USEFUL
    ------------------------------------- */
    .last {
      margin-bottom: 0;
    }

    .first {
      margin-top: 0;
    }


    .alignright {
      text-align: right;
    }

    .alignleft {
      text-align: left;
    }

    .clear {
      clear: both;
    }

/* -------------------------------------
    ALERTS
    Change the class depending on warning email, good email or bad email
    ------------------------------------- */
    .alert {
      font-size: 16px;
      color: #000000;
      font-weight: 500;
      padding: 20px;
      text-align: center;
      border-radius: 3px 3px 0 0;
    }
    .alert a {
      color: #fff;
      text-decoration: none;
      font-weight: 500;
      font-size: 16px;
    }
    .alert.alert-warning {
      background: #f8ac59;
    }
    .alert.alert-bad {
      background: #ed5565;
    }
    .alert.alert-good {
      background: #1ab394;
    }

/* -------------------------------------
    INVOICE
    Styles for the billing table
    ------------------------------------- */
    .invoice {
      margin: 40px auto;
      text-align: left;
      width: 80%;
    }
    .invoice td {
      padding: 5px 0;
    }
    .invoice .invoice-items {
      width: 100%;
    }
    .invoice .invoice-items td {
      border-top: #eee 1px solid;
    }
    .invoice .invoice-items .total td {
      border-top: 2px solid #333;
      border-bottom: 2px solid #333;
      font-weight: 700;
    }

/* -------------------------------------
    RESPONSIVE AND MOBILE FRIENDLY STYLES
    ------------------------------------- */
    @media only screen and (max-width: 640px) {
      h1, h2, h3, h4 {
        font-weight: 600 !important;
        margin: 20px 0 5px !important;
      }

      h1 {
        font-size: 22px !important;
      }

      h2 {
        font-size: 18px !important;
      }

      h3 {
        font-size: 16px !important;
      }

      .container {
        width: 100% !important;
      }

      .content, .content-wrap {
        padding: 10px !important;
      }

      .invoice {
        width: 100% !important;
      }
    }

  </style>

  
</head>
<body>
  <table class="body-wrap">
    <tbody><tr>
      <td></td>
      <td class="container" width="600">
        <div class="content">
          <table class="main" width="100%" cellpadding="0" cellspacing="0">
            <tbody><tr>
              <td class="content-wrap aligncenter">
                <table width="100%" cellpadding="0" cellspacing="0">
                  <tbody><tr>
                    <td class="content-block">
                      <h2>Pay Invoice</h2>
                    </td>
                  </tr>
                  <tr>
                    <td class="content-block">
                      <table class="invoice">
                        <tbody><tr>
                          <td>Invoice #{{$order->id}}<br>{{ $order->created_at }}</td>
                        </tr>
                        <tr>
                          <td>
                            <table class="invoice-items" cellpadding="0" cellspacing="0">
                              <tbody>
                              <?php
                     $user = \App\Models\User::find($order->user_id);
                          ?>
                                @if($services->count()>0)
                                <?php
                                $total = 0;
                                ?>
                                @foreach($services as $service)
                                <tr>
                                  <td>{{ $service->service_name }}</td>
                                  <td class="alignright"> {{ $order->currency }} {{ $service->amount }}</td>
                                </tr>

                                <?php
                                
                                $total = $total+$service->amount;
                                ?>
                                @endforeach
                                @else
                                <tr>
                                  <td>{{ $order->item_name }}</td>
                                  <td class="alignright">
                                   @if($order->currency=='2'){{ $order->currency }} @endif @if($order->currency=='1')$ @endif
                                   {{ $order->item_name }}</td>
                                 </tr>
                                 @endif

                                 <tr class="total">
                                  <td class="alignright" width="80%">Total</td>
                                  <td class="alignright">  {{ $order->currency }} {{ $total }}</td>
                                </tr>

                              </tbody></table>
                            </td>
                          </tr>
                        </tbody></table>
                      </td>
                    </tr>
                    @include('flash_msg')

                    @if($order->status=='0')
                    <tr>
                      <td class="content-block">
                        @if(session('transactionId'))
                        @include('payments.success-mpesa')

                        @else
                        <div id="pay-options">
                          <h4>Select Payment Option</h4> 
                          @if($services->count()>0)
                          <?php
                          $amount = $total;
                          ?>
                          @else
                          <?php
                          $amount = $order->amount;
                          ?>
                          @endif
                          <?php
  $user = \App\Models\User::find($order->user_id);
  ?>
                          @if($order->currency =='KES')
                          <input type="button" class="btn btn-primary" name="answer" value="Lipa Na Mpesa" onclick="showMpesa()" />
                       
                          @else
                          <input type="button" class="btn btn-primary" name="answer" value="PayPal, Debit or Credit Card" onclick="showPaypal()" />
                          @endif
                        </div>

                        <div id="mpesa"  style="display:none;" class="answer_list" > 
                         <h4>Pay amount {{ $order->currency }} <strong>{{ $amount }}</strong> for invoice #{{$order->id}}</h4>
                         <hr>


                         <div class="container">
                           <div class="job-edit-pro">

                            <div class="row">


                              <div class="form-group" style="padding: 10px;">
                                <label  class="col-sm-12 control-label">Mpesa No:</label>
                                <div class="col-sm-8">
                                  <input type="text" class="form-control"  id="phone" placeholder="Mobile Number (2547XXXXXXXX)"  required="">
                                  
                                  <input type="hidden" id="amount" placeholder="amt" value="{{ $amount }}">
                                  <input type="hidden" id="pay_type" placeholder="amt" value="invoice">
                                  <input type="hidden" id="account" placeholder="account" value="{{ $order->id }}">
                                </div>

                                <div class="col-sm-4">
                                  <label class="control-label"><p>&nbsp;</p></label>
                                  <button id="makePayment" class="btn btn-sm btn-primary">Make Payment</button>
                                  <button id="makePaymentDisabled" style="display:none;" class="btn btn-sm btn-success" disabled>Processing...
                                  </button>
                                </div>
                              </div>
                              



                            </div>


                            <div id="modal-loader3" style="display: none; text-align: center;">
                              <img src="{{asset('uploads')}}/loader.gif">
                            </div>

                            <!-- content will be load here -->                          
                            <div id="dynamic-content3" style="padding: 10px; color: #000000;"></div><br/>

                            @if(count($errors->all()))
                            <div class="alert custom-dark-alert-danger alert-dismissible">
                              <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                              @foreach ($errors->all() as $error)
                              <p><strong><i class="fa fa-times"></i></strong> {{ $error }}</p>
                              @endforeach
                            </div>
                            @endif
                          </div>
                        </div>
                      </div>


                      <div id="paypal-pay"  style="display:none;" class="answer_list" >
                        <h4>Pay amount {{ $order->currency }} {{ $amount }} for invoice #{{$order->id}}</h4>
                        <div id="smart-button-container">
                          <div style="text-align: center;">
                            <div id="paypal-button-container"></div>
                          </div>
                        </div>
                      </div>

                      @endif
                    </td>
                  </tr>


                  @else
                  <p style="color: green;">Invoice Paid</p>
                  @endif

                </tbody></table>
              </td>
            </tr>
          </tbody></table>
          <div class="footer">
            <table width="100%">
              <tbody><tr>
                <td class="aligncenter content-block">Questions? Email <a href="mailto:">support@ {{ domain_name() }}</a></td>
                <td class="aligncenter content-block"><a href="{{ url('/')}}">Home</a></td>
              </tr>
            </tbody></table>
          </div></div>
        </td>
        <td></td>
      </tr>
    </tbody></table>

    <script type="text/javascript">
      function showMpesa() {
       document.getElementById('mpesa').style.display = "block";
       document.getElementById('paypal-pay').style.display = "none";
       document.getElementById('pay-options').style.display = "none";
     }

     function showPaypal() {
       document.getElementById('paypal-pay').style.display = "block";
       document.getElementById('mpesa').style.display = "none";
       document.getElementById('pay-options').style.display = "none";
     }

     function showOptions() {
      document.getElementById('pay-options').style.display = "block";
    }
  </script>

  <?php
  $user = \App\Models\User::find($order->user_id);
  ?>
  <script src="https://www.paypal.com/sdk/js?client-id={{ get_option(site_id().'_paypal_client_id') }}&enable-funding=venmo&currency={{ $order->currency }}" data-sdk-integration-source="button-factory">
  </script>

  <script type="text/javascript">
    $(document).ready(function() {
      $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
      });
    });
  </script>
  @if($order->status=='0')

  @if($order->currency!='KES') 
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
            purchase_units: [{"amount":{"currency_code":"{{ $order->currency }}","value":'{{ $amount }}'}}]
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

            window.location = "{{ url('ipaid/'.$order->slug) }}";
            
          });
        },

        onError: function(err) {
          console.log(err);
        }
      }).render('#paypal-button-container');
    }
    initPayPalButton();
  </script>
  @endif

  @endif

 <script>
   $(document).ready(function(){



    $(document).on('click', '#makePayment', function(e){

      e.preventDefault();

            var phone    = document.getElementById('phone').value;   // it will get id of clicked row
            var amount   = document.getElementById('amount').value;
            var account  = document.getElementById('account').value;
            var pay_type = document.getElementById('pay_type').value;

            $('#dynamic-content3').html('<p align="center" style="color:#000000;"><strong>Heads up!</strong> Request sent to your mobile Phone. Proceed by paying from your mobile phone.</p>'); // leave it blank before ajax call
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
            
              console.log(data);  
              $('#dynamic-content3').html('');    
              $('#dynamic-content3').html(data); // load response 
              $('#modal-loader3').hide();     // hide ajax loader 
              $('#makePaymentDisabled').hide();
              $('#makePayment').show();

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





</body>
</html>