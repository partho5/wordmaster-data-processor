@extends('affiliate.affiliate_base_layout')



@section('title')

    <title>{{ env('APP_NAME') }} Partner Program</title>

@endsection



@section('external_resources')

    <link href="/css/partner/partnerHome.css" rel="stylesheet">



    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap" rel="stylesheet">

    <!-- https://fonts.google.com/specimen/Raleway?query=raleway -->


    <link href="https://fonts.googleapis.com/css2?family=Monda&display=swap" rel="stylesheet">

    <!-- https://fonts.google.com/specimen/Monda?query=monda -->

@endsection


@section('body_container')


    <div class="section col-xs-12 no-padding" id="common">
        Partnership Program is still under development. <br>
        Anyway you can share Job Vocabulary with your friends if you like.
    </div>

@endsection







@section('js')

    <!-- https://codepen.io/run-time/pen/XJNXWV -->

    <script type="text/javascript" src="/js/fingerprint.js"></script>

    <script type="text/javascript" src="/js/library.js"></script>



    <script>
        $(document).ready(function () {


            $('.site-link .copy-btn').click(function () {
                var domainText = $('.site-link .base-domain').text();
                copyToClipboard(domainText);

                $('.copied-info').animate({
                    'top' : '6em',
                    'opacity' : 1
                }, function () {
                    $(this).animate({
                        'opacity' : 0
                    }, 3000);
                });
            });

            $('.inspire-affiliate button').click(function () {
                $('#simple-curtain').slideUp(400);
            });


            function copyToClipboard(text) {
                var $temp = $("<input>");
                $("body").append($temp);
                $temp.val(text).select();
                document.execCommand("copy");
                $temp.remove();
            }


            var urlPath = window.location.pathname; //url path except base domain
            var queryString = window.location.search;
            var urlParams = new URLSearchParams(queryString);
            var clickedFrom = urlParams.get('clk');//this way gets url parameter written using ?param=value

            if(clickedFrom === null){
                //direct link clicked
                $('#simple-curtain').hide();
            }else if(clickedFrom === "app"){
                //no action required
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
                        url : '/partner', referredBy : referredBy
                    },
                    success : function (response) {
                        p(response);
                    },error: function (error) {}
                });
            }, intervalTime);







            function p(data) {

                console.log(data);

            }









        });

    </script>



@endsection