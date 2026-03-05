@extends('students.layouts.app4')
@section('title')
School
@endsection
@section('css')
<link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="{{ asset('student/demo/dist/css/DatPayment.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('student/example.css') }}">
<style>
  .datpayment-form {
width:55%;
margin-bottom: 100px;
   }
pre {
width:55%;
margin:auto;
}
  form div span {
position: absolute;
z-index: 5;
display: block;
height: 46px;
width: 50px;

text-align: center;
line-height: 50px;
color: #7f7878;
 background-color: transparent !important; 
font-size: 20px;
}
form div {
position: relative;
min-height: 0px !important;
margin-top: 5px !important;
}
.CardField   {
    display: block;
    font-size: 1.2em;
    width: 80%;
    margin: auto;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
    padding: 10px 8px 10px 8px;
    border-radius: 5px;
    border: 1px solid rgba(0, 0, 0, 0.5);
    opacity: .8;
}
</style>
@endsection

@section('content')
<div class="main-panel" style="background: #f8f9fb;">
  <div class="content-wrapper pb-0">
     <div class="container">
       <div class="row">
         <div class="col-md-12">
          <!--stiper credit card-->
          <p style="    text-align: center;">    المبلغ الذي ستقوم بتحويله هو <strong>{{ $amount }}</strong> </p>
          {{-- <form action="{{ route('dashboard.charge') }}" method="POST" id="payment-form" class="datpayment-form">
            @csrf
            <div class="dpf-title">
                <div class="accepted-cards-logo"></div>
            </div>
            <div class="dpf-card-placeholder"></div>
            
            <div class="container"><!--start container-->
              <div class="row">
                <div class="col-md-12">
                  <div class="dpf-input-row">
                    <input type="hidden" name="amount" value="{{ $amount }}">
                    <label class="dpf-input-label">Card Number</label>
                    <div class="dpf-input-container with-icon">
                        <span class="dpf-input-icon"><i class="fa fa-credit-card" aria-hidden="true"></i></span>
                        <input type="text" class="dpf-input" size="20" data-type="number">
                    </div>
                </div>
                </div>
              </div>
               
                
                <div class="">
                  <div class="row" style="justify-content: center;">
                     <div class="col-md-4">
                      <div class="dpf-input-column">
                        <input type="hidden" size="2" data-type="exp_month" placeholder="MM">
                        <input type="hidden" size="2" data-type="exp_year" placeholder="YY">

                        <label class="dpf-input-label">Date expiry</label>
                        <div class="dpf-input-container">
                            <input type="text" class="dpf-input" data-type="expiry">
                        </div>
                    </div>

                     </div>

                     <div class="col-md-4" style="margin-top: -27px;">
                      <div class="dpf-input-column">
                        <label class="dpf-input-label">CVC</label>
                        <div class="dpf-input-container">
                            <input type="text" class="dpf-input" size="4" data-type="cvc">
                        </div>
                    </div>
                     </div>
                  </div>
                </div>
                 <div class="row">
                   <div class="col-md-12">
                    <div class="dpf-input-row">
                      <label class="dpf-input-label">Name</label>
                      <div class="dpf-input-container">
                          <input type="text" size="4" class="dpf-input" data-type="name">
                      </div>
                  </div>
                   </div>
                 </div>
               

                <button type="submit" class="dpf-submit">
                      Submit Payment
                </button>
               
            </div><!--end container-->
        </form> --}}
        <form method="POST" action="{{ route('dashboard.charge') }}"   id="payment-form" class="datpayment-form">
          @csrf
          <div class="dpf-title">
            <div class="accepted-cards-logo"></div>
        </div>
        <div class="dpf-card-placeholder"></div>
          <label for="dpf-title">
              Credit or debit card
            </label>
         <br>
           <input type="hidden" name="amount" value="{{ $amount }}">
            <div id="card-element" style="box-shadow: inset 3px 1px 5px 3px #2824242b;
            border: 2px solid;">
              <!-- a Stripe Element will be inserted here. -->
            </div>
  
            <!-- Used to display form errors -->
            <div id="card-errors" role="alert"></div>
            <br>
            <button  disabled  class="btn dpf-input" style="padding: 10px 30px;
            cursor: pointer;
            margin: auto;
            color: #fff;
           
            top: 0;
            left: 0;
            width: 50%;
            height: 100%;
            border: none;
            margin-left: 130px;
            background-color: #1fd1f9;
            background-image: linear-gradient(315deg, #1fd1f9 0%, #b621fe 74%);
            transition: all 0.3s ease;
            border-radius: 5px;">Submit Payment</button>
          </div>

      </form>
          <!--end stiper credit card-->


       </div> <!--end col-->

     </div>
    
   </div>
 
 </div>
 
   
 </div>



@endsection
@section('js')

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript" src="{{ asset('student/demo/dist/js/DatPayment.js') }}"></script>
<script>
  $(document).ready(function(){
   $('.m11').addClass('active') ;  
 })
</script>
{{-- <script type="text/javascript">

    var payment_form = new DatPayment({
        form_selector: '#payment-form',
        card_container_selector: '.dpf-card-placeholder',

        number_selector: '.dpf-input[data-type="number"]',
        date_selector: '.dpf-input[data-type="expiry"]',
        cvc_selector: '.dpf-input[data-type="cvc"]',
        name_selector: '.dpf-input[data-type="name"]',

        submit_button_selector: '.dpf-submit',

        placeholders: {
            number: '•••• •••• •••• ••••',
            expiry: '••/••',
            cvc: '•••',
            name: 'DUPONT'
        },

        validators: {
            number: function(number){
                return Stripe.card.validateCardNumber(number);
            },
            expiry: function(expiry){
                var expiry = expiry.split(' / ');
                return Stripe.card.validateExpiry(expiry[0]||0,expiry[1]||0);
            },
            cvc: function(cvc){
                return Stripe.card.validateCVC(cvc);
            },
            name: function(value){
                return value.length > 0;
            }
        }
    });

    var demo_log_div = document.getElementById("demo-log");

    payment_form.form.addEventListener('payment_form:submit',function(e){
        var form_data = e.detail;
        payment_form.unlockForm();
        demo_log_div.innerHTML += "<br>"+JSON.stringify(form_data);
    });

    payment_form.form.addEventListener('payment_form:field_validation_success',function(e){
        var input = e.detail;

        demo_log_div.innerHTML += "<br>field_validation_success:"+input.getAttribute("data-type");

    });

    payment_form.form.addEventListener('payment_form:field_validation_failed',function(e){
        var input = e.detail;

        demo_log_div.innerHTML += "<br>field_validation_failed:"+input.getAttribute("data-type");
    });
</script> --}}
<script src="https://js.stripe.com/v3/"></script>

<script>


    window.onload=function(){
        var stripe = Stripe('pk_test_51Jnpp6GG7tPO8qEHtea5xSkbszbYs5oSjwTzFUT357PypAB7EJ1HydWiF9CZp0syOWyp37u6BOTfDnUWjS5lnjds00iMtmqCQt');
var elements = stripe.elements();



var style = {
  base: {
    fontSize: '16px',
    color: '#32325d',
  },
};

var card = elements.create('card', {style: style});

card.mount('#card-element');

// Create a token or display an error when the form is submitted.
const form = document.getElementById('payment-form');
form.addEventListener('submit', async (event) => {
  event.preventDefault();

  const {token, error} = await stripe.createToken(card);

  if (error) {
    // Inform the customer that there was an error.
    const errorElement = document.getElementById('card-errors');
    errorElement.textContent = error.message;
  } else {
    // Send the token to your server.
    stripeTokenHandler(token);
  }
});

const stripeTokenHandler = (token) => {
  // Insert the token ID into the form so it gets submitted to the server
  const form = document.getElementById('payment-form');
  const hiddenInput = document.createElement('input');
  hiddenInput.setAttribute('type', 'hidden');
  hiddenInput.setAttribute('name', 'stripeToken');
  hiddenInput.setAttribute('value', token.id);
  form.appendChild(hiddenInput);

  // Submit the form
  form.submit();
}
    }

</script>


@endsection



