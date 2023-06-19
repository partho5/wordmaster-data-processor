<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Buy {{ env('APP_NAME') }} </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>




    <link rel="stylesheet" href="/css/payment/buy_app.css">



</head>
<body>



<div id="page" class="col-xs-12 no-padding">
    <div id="content" class="col-xs-12 no-padding ">
        <div class="section1 col-xs-12 ">
            <span class="app-name">{{ env('APP_NAME') }}</span>
        </div>

        <div class="section2 col-xs-12 no-padding">
            <div id="coupon-container" class="col-xs-12 no-padding hidden">
                <div class="col-xs-12 no-padding">Coupon Code <small style="color: #737373">(if you have)</small> </div>
                <div class="col-xs-8 col-xs-offset-2">
                    <input type="text" id="coupon-code" class="form-control" placeholder="you can skip it">
                </div>
                <div class="col-xs-8 col-xs-offset-2 text-center">
                    <button class="btn btn-primary" id="apply-coupon-btn">Apply</button>
                </div>
                <div class="col-xs-12 no-padding" id="concession"></div>
            </div>

            <div class="col-xs-12">
                পেমেন্ট মেথড
                <select id="payment-method-holder">
                    <option value="bKash">bKash (send money)</option>
                </select>
            </div>

            <div id="steps" class="col-xs-12">
                <ol>
                    <li>“send money” অপশনে যান </li>
                    <li>Enter number : <span class="field bkash-num"></span> </li>
                    <li>Amount : <span class="field payable-amount"></span> </li>
                    <li>bKash মেসেজ থেকে প্রাপ্ত TrxID টা Copy করে এনে এখানে লিখুন <input type="text" id="trxId" placeholder="TrxID"> </li>
                    <li>Click <button class="btn btn-success verify-btn">Verify Payment</button> </li>
                </ol>
            </div>

            <div class="logs col-xs-12">
                <div class="loading">
                    <img src="/images/loader1.gif" alt="Loading..." style="width: 100%">
                    <div class="text-center">please wait</div>
                </div>
                <div class="col-xs-12 msg-success text-center">Verified. Please Exit and Reopen app</div>
                <div class="col-xs-12 msg-error text-center">
                    একটু দেখুন তো :
                    <ol>
                        <li>TrxId ঠিক মত লিখেছেন কিনা </li>
                        <li>ঠিক <span>{{ $netAmountToPay }}</span> টাকা send করেছেন কিনা</li>
                    </ol>
                </div>
            </div>

        </div>

        <div class="section3 col-xs-12 no-padding text-center">
            <h3>Payment Successful !</h3>
            <p class="p1">Now start learning vocabulary</p> <br>
            <h4 class="instruction2">অ্যাপ টি exit করে আবার open করুন</h4>
        </div>


        <footer>
            <div class="col-xs-12 text-center">
                যেকোনো সমস্যা হলে ইমেইল করুন
                <div>
                    Click on &nbsp; <a href="mailto:{{ env('ADMIN_EMAIL') }}?subject=Problem from user id {{ request()->query('userId') }}&body=My problem is: ">{{ env('ADMIN_EMAIL') }}</a>
                </div>
            </div>
        </footer>

    </div>
</div>






<script>
    $(document).ready(function (){


        var payableAmount = 150;
        payableAmount = payableAmount - 5;//5 tk bkash send money charge
        var  bkashNum = "01811971068";
        var paymentMethod = "bKash";


        $('.payable-amount').text(payableAmount);
        $('.bkash-num').text(bkashNum);


        $('#apply-coupon-btn').click(function () {
            //NOT implemented yet
            var code = $('#coupon-code').val();
        });


        var userId = new URLSearchParams(window.location.search).get('userId');

        $('.verify-btn').click(function () {
            var trxId = $('#trxId').val().trim();
            var code = $('#coupon-code').val(); //not implemented yet
            var THIS = $(this);
            var verified = localStorage.getItem('verified7');
            if(verified == 1){
                $('.msg-success').text("Already Verified !");
                $('.msg-success').show();
            }else{
                if(trxId.length == 10){
                    //bKash transaction id length is 10 character

                    $('.msg-error').hide();//in case currently being shown
                    $('.loading').show();

                    THIS.prop('disabled', true);//prevent multiple click on this button
                    $.ajax({
                        url : '/buy/app/payment/verify',
                        type : 'post',
                        data : {
                            '_token' : "{{ csrf_token() }}", userId : userId, trxId : trxId
                        }, success : function (response) {
                            p(response);
                            if(response.isValid == 1){
                                //success
                                $('.loading, .msg-error').hide();//in case currently being shown
                                $('.section1 .app-name, .section2').hide();
                                $('.section3').fadeIn();
                                //localStorage.setItem('verified7', 1);
                            }else {
                                $('.loading').hide();//in case currently being shown
                                $('.msg-error').fadeIn();
                                THIS.prop('disabled', false);//re enable button to become clickable
                            }
                        }, error: function (error) {
                            p(error);
                            alert("Error occurred ! Please contact support");
                        }
                    });
                }else{
                    //p(trxId.length);
                    $('.loading').hide();//in case currently being shown
                    $('.msg-error').fadeIn();
                    THIS.prop('disabled', false);//re enable button to become clickable
                }
            }
        });




        function p(data) {
            console.log(data);
        }

    });

</script>
</body>
</html>