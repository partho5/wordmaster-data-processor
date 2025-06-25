<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Payment Successful | {{ env('APP_NAME') }} </title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />


    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>


    <link rel="stylesheet" href="/css/payment/payment_success.css">


    <!-- Google Tag Manager -->
    {{--<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':--}}
            {{--new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],--}}
            {{--j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=--}}
            {{--'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);--}}
        {{--})(window,document,'script','dataLayer','GTM-M3PNQL9C');</script>--}}
    <!-- End Google Tag Manager -->


    <!-- Meta Pixel Code -->
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
            n.callMethod.apply(n,arguments):n.queue.push(arguments)};
            if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
            n.queue=[];t=b.createElement(e);t.async=!0;
            t.src=v;s=b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t,s)}(window, document,'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '615829604664137');


        function generateUniqueEventId() {
            const timestamp = Date.now(); // Get the current timestamp
            const randomString = Math.random().toString(36).substring(2, 8); // Generate a random string
            const eventId = 'click_dl_' + timestamp + '_' + randomString; // Combine timestamp and random string
            return eventId;
        }

        function getQueryParam(param) {
            const urlParams = new URLSearchParams(window.location.search);
            return urlParams.get(param);
        }

        const eventId = generateUniqueEventId();
        const fbclid = getQueryParam('fbclid');

        fbq('trackCustom', 'PurchaseComplete', {
            platform: 'web',
            value: 290,
            currency: 'BDT',
        }, {
            eventID: eventId
        });

        // Run only if capiSent is not set
        if (!localStorage.getItem('capiSent')){
            $.ajax({
                type: 'POST',
                url: '/api/capi/purchase-complete',
                data: {
                    event_id: eventId,
                    value: 290,
                    currency: 'BDT',
                    platform: 'web',
                    fbclid: fbclid,
                },
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (res) {
                    console.log('CAPI sent:', res);
                    // Set flag to prevent duplicates
                    localStorage.setItem('capiSent', 'true');
                },
                error: function (err) {
                    console.error('CAPI failed:', err);
                }
            });
        }

    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=615829604664137&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Meta Pixel Code -->


</head>
<body>



<div class="container no-padding">
    <header>
        <div class="app-name">{{ env('APP_NAME') }}</div>
    </header>

    <main>
        <div class="success-card">
            <img src="/images/green_tick_in_circle.png" alt="Success" class="success-icon">
            <h1>Payment Successful !</h1>
            <p class="message">
                <span class="bonus">Bonus:</span> you get access to <br>
                <a href="/download/pdf" target="_blank" class="pdf-link">330 high frequency words PDF ⬇</a>
                for short preparation
            </p>
            <p class="instruction">অ্যাপ টি exit করে আবার open করুন</p>
            {{--<a href="#" class="action-button">Start Learning</a>--}}
        </div>
    </main>

    <footer>
        <p class="support-text">যেকোনো সমস্যা হলে Message করুন</p>
        {{--<p>--}}
            {{--<a href="https://www.facebook.com/vocabulary.pro7" target="_blank">Facebook Page</a>--}}
        {{--</p>--}}

        <p>Click on <a href="mailto:{{ env('ADMIN_EMAIL') }}?subject=Problem from user id {{ request()->query('userId') }}&body=My problem is: " class="email-link">{{ env('ADMIN_EMAIL') }}</a></p>
    </footer>
</div>




<script type="text/javascript" src="/js/fingerprint.js"></script>
<script type="text/javascript" src="/js/library.js"></script>

<script>
    $(document).ready(function (){

        let visitorLogId = getCookie("visitorLogId");
        if(! visitorLogId){
            visitorLogId = generateVisitorLogId();
            setCookie("visitorLogId", visitorLogId);
        }



        /*
         * case when user visited from this browser for downloading app.
         * Not applicable if user visited from facebook webview while downloading. because for payment, fb webview won't be used, rather chrome browser will be opened
         * */
        let referredBy = getCookie('referredBy');
        if(typeof referredBy === 'undefined'){
            referredBy = 'app';
        }
        let meta = '';


        let intervalTime = 4000*10000; // temporarily a big value so that cant work
        setInterval(function () {
            p("referredBy="+referredBy);
            $.ajax({
                url : "/ajax/visit_log/save",
                type : "post",
                async : true,
                data : {
                    _token : "{{ csrf_token() }}", visitorLogId : visitorLogId,
                    current_time : Date.now(), browser : navigator.userAgent,
                    url : window.location.href, referredBy : referredBy, meta : meta || null
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
