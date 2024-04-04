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

            @if(isset($appPrice) && isset($paymentCharge) && isset($netAmountToPay))
                <div class="col-xs-12 payment-charge-notice">
                    Send Money চার্জ বহন করবে {{ env('APP_NAME') }} <br>
                    তাই আপনি সেন্ড করবেন ({{ $appPrice }}-{{ $paymentCharge }}) = {{ $netAmountToPay }} Tk
                </div>
            @endif

            <div id="steps" class="col-xs-12">
                <div class="heading1">
                    <span>ক্রয়ের পদ্ধতি :</span>
                </div>
                <ol>
                    <li class="bkash-app">
                        <img src="/images/icon/bkash-app-icon.png" class="icon" alt="bkash app">
                        bKash অ্যাপে যান
                    </li>
                    <li class="send-money">
                        <img src="/images/icon/bkash-send-money-icon.jpg" class="icon" alt="send money">
                        “সেন্ড মানি” অপশনে যাবেন
                    </li>
                    <li class="bkash-num-li">
                        নাম্বার বসাবেন : <span class="field bkash-num"></span>
                        <span class="success-msg">নাম্বারটি copy করা হয়েছে</span>
                    </li>
                    <li>পরিমাণ ৳‎ : <span class="field payable-amount">{{ $netAmountToPay }}</span> </li>
                    <li>bKash থেকে মেসেজ আসবে। সেখান থেকে TrxID টা Copy করে এনে এখানে লিখুন <input type="text" id="trxId" placeholder="TrxID"> </li>
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
            <img src="/images/green_tick_in_circle.png" class="tick">
            <h3>Payment Successful !</h3>
            <p class="p1">
                Now start learning vocabulary. <br>
                <b>Bonus</b> : you get access to <a href="/download/pdf" target="_blank">330 high frequency words PDF</a> for short preparation
            </p> <br>
            <h4 class="instruction2">অ্যাপ টি exit করে আবার open করুন</h4>
        </div>


        <footer>
            <div class="col-xs-12 text-center">
                যেকোনো সমস্যা হলে ইমেইল করুন
                <div>
                    Click on &nbsp;
                    <a href="mailto:{{ env('ADMIN_EMAIL') }}?subject=Problem from user id {{ request()->query('userId') }}&body=My problem is: ">{{ env('ADMIN_EMAIL') }}</a>
                </div>
            </div>
        </footer>

    </div>
</div>




<script type="text/javascript" src="/js/fingerprint.js"></script>
<script type="text/javascript" src="/js/library.js"></script>

<script>
    $(document).ready(function (){


        //var payableAmount = 150;
        //payableAmount = payableAmount - 5;//5 tk bkash send money charge
        var  bkashNum = "01811971069";
        var paymentMethod = "bKash";


        //$('.payable-amount').text(payableAmount);
        $('.bkash-num').text(bkashNum);


        $('#apply-coupon-btn').click(function () {
            //NOT implemented yet
            var code = $('#coupon-code').val();
        });


        var userId = new URLSearchParams(window.location.search).get('userId');
        userId = parseInt(userId); //3 characters have been concatenated at the end of userId to prevent possible accidental modification of get parameter. Even if last character get modified we still get the userId by parseInt
        //p("userId="+userId);
        var meta = 'userId='+userId; //sent in ajax call meta data


        $('#payment-method-holder').click(function () {
            meta+= 'clicked payment method';
        });


        /*
         * case when user visited from this browser for downloading app.
         * Not applicable if user visited from facebook webview while downloading. because for payment, fb webview won't be used, rather chrome browser will be opened
         * */
        var referredBy = getCookie('referredBy');
        if(typeof referredBy === 'undefined'){
            referredBy = 'app';
        }


        $('.verify-btn').click(function () {
            var trxId = $('#trxId').val().trim();
            var code = $('#coupon-code').val(); //not implemented yet
            var THIS = $(this);
            var verifiedStatusCookieName = 'verified7';
            var verified = getCookie(verifiedStatusCookieName); // 'verified7' is just a unique identifier

            if(false && verified === 1){ /* false &  -will always skip this section, tentatively */
                $('.msg-success').text("Already Verified !");
                $('.msg-success').show();
            }else{
                if(trxId.length === 10){
                    //bKash transaction id length is 10 character

                    $('.msg-error').hide();//in case currently being shown
                    $('.loading').show();

                    THIS.prop('disabled', true);//prevent multiple click on this button
                    $.ajax({
                        url : '/buy/app/payment/verify',
                        type : 'post',
                        data : {
                            '_token' : "{{ csrf_token() }}", userId : userId, trxId : trxId, referredBy : referredBy
                        }, success : function (response) {
                            p(response);
                            if(response.isValid == 1){
                                //success
                                $('.loading, .msg-error').hide();//in case currently being shown
                                $('.section1 .app-name, .section2').hide();
                                $('.section3').fadeIn();
                                setCookie(verifiedStatusCookieName, 1);
                            }else {
                                $('.loading').hide();//in case currently being shown
                                $('.msg-error').fadeIn();
                                THIS.prop('disabled', false);//re enable button to become clickable

                                $('.payment-charge-notice, #steps .heading1').slideUp(); // to ensure error msg section is visible without scrolling
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

                    $('.payment-charge-notice, #steps .heading1').slideUp(); // to ensure error msg section is visible without scrolling
                }
            }

            meta+= ' TrxId='+trxId
        });




        $('.bkash-num').click(function() {
            const amountText = $(this).text();
            copyToClipboard(amountText);
            //p('Amount copied: ' + amountText);
            $('.bkash-num-li .success-msg').show();
            $('.bkash-num-li .success-msg').animate({
                bottom : '12em'
            }, 500, function () {
                var $this = $(this);
                setTimeout(function () {
                    $this.css('bottom', '-50em');
                }, 2000);
            });
        });




        var visitorLogId = getCookie("visitorLogId");
        if(! visitorLogId){
            visitorLogId = generateVisitorLogId();
            setCookie("visitorLogId", visitorLogId);
        }




        var intervalTime = 4000  ;
        setInterval(function () {
            p("referredBy="+referredBy);
            $.ajax({
                url : "/ajax/visit_log/save",
                type : "post",
                async : true,
                data : {
                    _token : "{{ csrf_token() }}", visitorLogId : visitorLogId,
                    current_time : Date.now(), browser : navigator.userAgent,
                    url : window.location.pathname, referredBy : referredBy, meta : meta || null
                },
                success : function (response) {
                    p(response);
                    meta = '';
                },error: function (error) {
                    meta+= 'error='+error
                }
            });
        }, intervalTime);




        function p(data) {
            console.log(data);
        }

    });

</script>
</body>
</html>