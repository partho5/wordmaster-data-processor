<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Partner Proposal</title>

    <link rel="stylesheet" href="/bootstrap/bootstrap.min.css">
    <script src="/bootstrap/jquery-1.12.4.min.js"></script>
    <script src="/bootstrap/bootstrap.min.js"></script>
    <link href="/css/affiliate/landing-page.css" rel="stylesheet">


    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@400&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Monda&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali&display=swap" rel="stylesheet">

</head>
<body>
    <div class="col-xs-12 no-padding text-center" id="page-content">
        <div class="section section1 sect-welcome col-xs-12 no-padding" id="">
            <div class="welcome">Welcome To</div>
            <h2>{{ ENV('APP_NAME') }} Partner Program</h2>
        </div>

        <div class="section section2 col-xs-12 no-padding" id="">
            <div class="col-xs-12 col-md-4 no-padding pad-ls">
                <div class="col-xs-12 col-md-12 no-padding">
                    <img src="/images/skill2money.png" alt=""  class="img img-responsive">
                </div>
            </div>
            <div class="col-xs-12 col-md-8 no-padding pad-ls text">
                <h3>Turn your skill into money</h3>
                <div class="col-xs-12 no-padding desc">
                    যদি আপনার ইংরেজিতে বিশেষ করে Vocabulary তে দক্ষতা থাকে তবে আপনার জন্য আমরা একটি প্রস্তাবনা নিয়ে এসেছি ।
                    যারা তাদের ইংরেজির দক্ষতা ব্যবহার করে ফেইসবুকে পোস্ট করেন বা ইউটিউবে ভিডিও তৈরি করেন,
                    {{ ENV('APP_NAME') }} অর্জিত রেভিনিউ এর একটা অংশ তাদের সাথে শেয়ার করে ।
                </div>
            </div>
        </div>

        <div class="section section3 col-xs-12 no-padding" id="">
            <div class="col-xs-12 col-md-8 no-padding pad-ls text transform">
                <h3>You get 15-25 Tk per app sale</h3>
                <div class="col-xs-12 no-padding desc">
                    আপনার একটি পোস্ট বা ভিডিও তে প্রদত্ত লিঙ্ক থেকে অ্যাপটি যখন কেউ ক্রয় করবে, ইন্সট্যান্টলি আপনি রেভিনিউ
                    এর শেয়ার পেয়ে যাবেন । একটি পোস্ট দেখে যদি 1000 মানুষ ক্রয় করে, তো ওই একটি পোস্ট থেকে আপনার
                    আয় হবে 24,250 টাকা ।
                </div>
            </div>
            <div class="col-xs-12 col-md-4 text-right no-padding pad-ls">
                <div class="col-xs-12 col-md-12 no-padding">
                    <img src="/images/rev_share.png" alt=""  class="img img-responsive">
                </div>
            </div>
        </div>


        <div class="section section4 col-xs-12 col-md-12 no-padding" id="">
            <div class="col-md-4 left ">
                <div class="col-xs-12 inner">
                    এই স্যাম্পল ভিডিও টি দেখুন । আমি ব্যাখ্যা করেছি {{ ENV('APP_NAME') }} কেন/কীভাবে বেস্ট
                </div>
            </div>
            <div class="col-md-4 middle " id="inst-vid">
                <div class="col-xs-12 inner">
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/Pnf-qCY1idI" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                </div>
            </div>
            <div class="col-md-4 right ">
                <div class="col-xs-12 inner">
                    আপনার কাজ হবে অনুরূপ ভিডিও তৈরি করে Facebook / Youtube এ শেয়ার করা । আর সেটাই হবে আপনার বাড়তি ইনকাম সোর্স ।
                </div>
            </div>
        </div>

        <div class="section section5 col-xs-12 col-md-12 " id="">
            <p class="p1">You just need to register</p>
            <p>Don't waste a minute !</p>
            <a href="/register" class="reg-container col-md-4 col-md-offset-4 btn">
                Join Partner Program
            </a>
        </div>

        {{ View::make('affiliate.partial.footer') }}

    </div>

<script type="text/javascript" src="/js/fingerprint.js"></script>
<script type="text/javascript" src="/js/library.js"></script>

<script type="text/javascript">
    $(document).ready(function(){
        $(document).ready(function () {






            var urlPath = window.location.pathname; //url path except base domain
            var queryString = window.location.search;
            var urlParams = new URLSearchParams(queryString);
            var clickedFrom = urlParams.get('clk');//this way gets url parameter written using ?param=value
            var screenSize = screen.width+'x'+screen.height;

            if(clickedFrom === null){
                //direct link clicked
            }else if(clickedFrom === "app"){
                //
            }


            var fp = new Fingerprint({
                canvas: true,
                ie_activex: true,
                screen_resolution: true
            });

            var fingerprint = fp.get();
            setCookie("visitorLogId", fingerprint);

            var intervalTime = 2000  ;
            setInterval(function () {
                $.ajax({
                    url : "/ajax/visit_log/save",
                    type : "post",
                    async : true,
                    data : {
                        _token : "{{ csrf_token() }}", visitorLogId : getCookie("visitorLogId"),
                        current_time : Date.now(), browser : navigator.userAgent,
                        url : urlPath, referredBy : clickedFrom, screenSize : screenSize
                    },
                    success : function (response) {
                        p(response);
                    },error: function (error) {}
                });
            }, intervalTime);


        });


        function p(data) {
            console.log(data);
        }
    })
</script>

</body>
</html>