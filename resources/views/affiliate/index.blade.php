@extends('affiliate.affiliate_base_layout')



@section('title')

    <title>{{ env('APP_NAME') }} Partner Program</title>

@endsection



@section('external_resources')

    <link href="/css/affiliate/index.css" rel="stylesheet">



    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap" rel="stylesheet">

    <!-- https://fonts.google.com/specimen/Raleway?query=raleway -->


    <link href="https://fonts.googleapis.com/css2?family=Monda&display=swap" rel="stylesheet">

    <!-- https://fonts.google.com/specimen/Monda?query=monda -->

@endsection


@section('body_container')


    <div class="section col-xs-12 no-padding" id="common">
        <div class="col-xs-12 instruction1">প্রথমে আপনার নিজেকেই স্পষ্ট ভাবে জানতে হবে {{ ENV('APP_NAME') }} এর সকল বৈশিষ্ট ।</div>
        <div CLASS="col-xs-12 no-padding steps">
            <ol>
                <li>
                    <a href="/" target="_blank">{{ $_SERVER['SERVER_NAME'] }}</a> এ যান ।
                    হোমপেইজ এর তথ্য গুলো সব পড়ুন
                </li>
                <li>
                    <div class="col-xs-12 no-padding post-link">
                        পোস্ট / ভিডিও তৈরি করার পর সেটির লিঙ্ক এখানে দিন
                        @if(isset($postLink))
                            <div class="last-provided-link">
                                Last link you provided :
                                <a href="{{ $postLink }}" target="_blank">{{ $postLink }}</a>
                            </div>
                        @endif
                        <input type="text" class="col-xs-12 form form-control" id="last-shareable-post" placeholder="{{ isset($postLink) ? 'Created another video ? Give the link' : 'Video / Post link' }}">
                        <button class="col-xs-8 col-md-3 btn btn-success save-post-btn">Save</button>
                        <div class="success-msg">Link Saved</div>
                        {{--this save button does nothing technically. Actually 'on input change' triggers ajax call to save data. Now here the save button ensures that the user clicks somewhere outside the input field, and then onChange triggers--}}
                    </div>
                </li>
                <li>সেটি review করার পর আমরা আপনাকে ইমেইল করব </li>
            </ol>
        </div>
        <div class="col-xs-12 bottom-line">That's as simple as this !</div>
        <div class="col-xs-12 no-padding contact">
            Contact with developer (if needed)
            <div class="for-mobile">
                {{--As mobile device opens mailto: in apps that are likely to be desired by users--}}
                <a href="mailto:{{ $adminEmail }}">{{ $adminEmail }}</a>
            </div>
            {{--But in PC mostly mailto: will be opened in windows mail client which users don't like to see. So for PC no mailto:, but email address is shown as simple text --}}
            <div class="for-pc">{{ $adminEmail }}</div>
        </div>


        {{ View::make('affiliate.partial.footer') }}
    </div>


@endsection







@section('js')

    <!-- https://codepen.io/run-time/pen/XJNXWV -->

    <script type="text/javascript" src="/js/fingerprint.js"></script>
    <script type="text/javascript" src="/js/library.js"></script>



    <script>
        $(document).ready(function () {

/* this feature has been postponed. I will think later.
and so #simple-curtain is currently display:none; */
            /*
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
            */


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




            var visitorLogId = getCookie("visitorLogId");
            if(! visitorLogId){
                visitorLogId = generateVisitorLogId();
                setCookie("visitorLogId", visitorLogId);
            }

            var intervalTime = 4000  ;
            setInterval(function () {
                $.ajax({
                    url : "/ajax/visit_log/save",
                    type : "post",
                    async : true,
                    data : {
                        _token : "{{ csrf_token() }}", visitorLogId : visitorLogId,
                        current_time : Date.now(), browser : navigator.userAgent,
                        url : urlPath, referredBy : clickedFrom, screenSize : screenSize
                    },
                    success : function (response) {
                        p(response);
                    },error: function (error) {}
                });
            }, intervalTime);



            $('#last-shareable-post').change(function () {
                const postLink = $('#last-shareable-post').val();
                if(postLink){
                    if(postLink.includes('http') || postLink.includes('www.')){
                        $.ajax({
                            url : "/ajax/post_link/save",
                            type : "post",
                            async : true,
                            data : {
                                _token : "{{ csrf_token() }}", 'postLink' : postLink
                            },
                            success : function (response) {
                                $('.last-provided-link').find('a').text(postLink);
                                $('.last-provided-link').find('a').attr('href', postLink);
                                if(response == 1){ /* it should be '==', and not '===' */
                                    p(response);
                                    p('saved');
                                    $('.post-link .success-msg').show().fadeOut(1500);
                                }else{
                                    p('error');
                                    p(response);
                                }
                            },error: function (error) {
                                p(error);
                            }
                        });
                    }else{
                        p('invalid link');
                    }
                }else{
                    p('post link blank');
                }
            });






            function p(data) {

                console.log(data);

            }









        });

    </script>



@endsection