<html>
<!-- To make Layer checkout responsive on your checkout page.-->
<meta name="viewport" content="width=device-width, initial-scale=1" />

<!--Please add either of the following script to your HTML depending upon your environment-->

<!--For Sandbox--> 
<script id="context" type="text/javascript" src="https://sandbox-payments.open.money/layer"></script>
<meta name="csrf-token" content="{{ csrf_token() }}">
<body>
    <h1>Payment Details</h1>
    <h2>amount: {{$amount}}</h2>
    <h2>currency: {{$currency}}</h2>
    <h2>email_id: {{$email}}</h2>
    <h2>contact_number: {{$phoneNo}}</h2>
    
    @if($payment_token)
    <button id="checkoutButton">Checkout</button>
    @else
    <button type="button" onclick="window.location='{{route('tokenGeneration')}}'">Next</button>
    @endif
    <script>
    // Bind Layer.checkout initialization script to a button click event
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    document.getElementById('checkoutButton').addEventListener('click', function() {
      Layer.checkout({
          token: '{{ $payment_token }}',
          accesskey: '{{env('API_ACCESS_KEY')}}',
          theme: {
              logo : "https://open-logo.png",
              color: "#3d9080",
              error_color : "#ff2b2b"
          }
      },
      function(response) {
          if (response.status == "captured") {
              // response.payment_token_id
              // response.payment_id
              window.location.href = '{{ route('sendMail') }}';
          } else if (response.status == "created") {
              // Handle created status
          } else if (response.status == "pending") {
              // Handle pending status
          } else if (response.status == "failed") {
              window.location.href = '{{ route('home') }}';
          } else if (response.status == "cancelled") {
              window.location.href = "cancel_redirect_url";
          }
      },
      function(err) {
          // Handle integration errors
          return err;
      });
    });
  </script>
</body>
</html>