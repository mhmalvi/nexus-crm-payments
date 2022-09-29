<html lang="en">
<head>
<!-- Latest compiled and minified CSS -->
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


</head>
<body>
    <div id="aba_main_modal" class="aba-modal">		
	<div class="aba-modal-content">
    <!-- Following is the form where the values are passed in hidden, which will be used for payment.-->
            <form method="POST" target="aba_webservice" action="{{ $payment['api_url'] }}" id="aba_merchant_request">
                <input type="hidden" id="hash" name="hash" value="{{$payment['hashedTransactionId']}}">
                <input type="hidden" id="tran_id" name="tran_id" value="{{$payment['transactionId']}}">
                <input type="hidden" id="amount" name="amount" value="{{$payment['amount']}}">
                <input type="hidden" id="firstname" name="firstname" value="{{$payment['firstName']}}">
                <input type="hidden" id="lastname" name="lastname" value="{{$payment['lastName']}}">
                <input type="hidden" id="phone" name="phone" value="{{$payment['phone']}}">
                <input type="hidden" id="email" name="email" value="{{$payment['email']}}">
                @if(isset($payment['items']))
                    <input type="hidden" id="items" name="items" value="{{$payment['items']}}">
                @endif    
            </form>
    <!--Form End-->        
        </div>
    </div>
    <!--Add your code for the checkout Page Here-->
    <div class="container" style="margin-top: 75px;margin: 0 auto;">
            <div style="width: 250px;margin: 0 auto;">
                    @if(isset($payment['items_arr']) and !empty($payment['items_arr']))
                    <table class="table-bordered">
                    <tr>
                    <td>Item</td>
                    <td>Quantity</td>
                    <td>Price</td>
                    </tr>
                    @foreach($payment['items_arr'] as $item)
                    <tr>
                    <td>{{$item['name']}}</td>
                    <td>{{$item['quantity']}}</td>
                    <td>{{$item['price']}}</td>
                    </tr>
                    @endforeach
                    </table>
                    @endif
                    <h2>TOTAL: {{$payment['amount']}} USD</h2>
                    <!-- Checkout button for payment -->
                    <a href="{{ route('checkout') }}" class="btn btn-info">Payment with Eway</a>
            </div>
    </div>

    <!-- jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Latest compiled JavaScript -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <!--Open Checkout popup on click of checkout button-->
  
</body>
</html>