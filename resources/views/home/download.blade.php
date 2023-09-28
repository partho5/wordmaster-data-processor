@extends('home.base_layout')



@section('title')

    <title>Download {{ env('APP_NAME') }}</title>

@endsection



@section('external_resources')

    <link href="/css/home/download.css" rel="stylesheet">



    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap" rel="stylesheet">

    <!-- https://fonts.google.com/specimen/Raleway?query=raleway -->



    <link href="https://fonts.googleapis.com/css2?family=Monda&display=swap" rel="stylesheet">

    <!-- https://fonts.google.com/specimen/Monda?query=monda -->

@endsection



@section('body_container')

    <div class="version-container col-xs-12 col-md-8 col-md-offset-2">

        <div class="vname col-xs-12 no-padding">

            <u> Version <span class="version">1.11</span> </u> <sup>Latest</sup>

        </div>

        <a class="download-btn col-xs-6 col-xs-offset-3" href="https://play.google.com/store/apps/details?id=com.wordmas.wordmaster">

            Download

        </a>



        {{--<div class="col-xs-12 no-padding feature-set">--}}

            {{--<div class="change-log-label">What's new :</div>--}}

            {{--<div class="change-log">--}}

                {{--<ul>--}}

                    {{--<li>kjb jhbhbhj </li>--}}

                    {{--<li>kjb jhbhbhj </li>--}}

                    {{--<li>kjb jhbhbhj </li>--}}

                {{--</ul>--}}

            {{--</div>--}}

        {{--</div>--}}



        <div class="col-xs-12 no-padding feature-set">

            <div class="change-log-label">Features :</div>

            <div class="change-log">

                <ol>

                    <li>

                        যে মোস্ট ইম্পরট্যান্ট ওয়ার্ডগুলো থেকে BCS, Bank সহ যেকোনো সরকারি চাকরির পরীক্ষায় <span class="highlight">কমন</span> আসে এরকম <span class="highlight">2902</span> টি ওয়ার্ড এর কালেকশন

                    </li>

                    <li>

                        প্রতি 20 টি ওয়ার্ড পড়ার পর আপনাকে <span class="highlight">রিভিশন</span> দেওয়ার কথা স্মরণ করিয়ে দিবে । এভাবে রিভিশন দিলে আপনি কখনোই word ভুলতে পারবেন না

                    </li>

                    <li>

                        যখন ইচ্ছা তখন <span class="highlight">MCQ Test</span> দিতে পারবেন । এর ফলে নিজের দূর্বলতা গুলো খুঁজে পাবেন, অর্থাৎ প্রিপারেশন হবে নিখুঁত

                    </li>

                    <li>

                        বিগত 20 বছরের <span class="highlight">প্রশ্ন ব্যাংক</span> যুক্ত করা হয়েছে । ওয়ার্ড গুলো সব মুখস্ত করার পর বিগত বছরের প্রশ্নগুলো দেখলে বুঝবেন ভোকাবুলারির জ্ঞানে আপনার ধারে কছে খুব কম মানুষই রয়েছে

                    </li>

                    <li>

                        প্রত্যেকটি ওয়ার্ড এর পাশে তার <span class="highlight">parts of speech</span> দেওয়া হয়েছে । parts of speech না জানলে লিখতে গেলে গ্রামাটিক্যাল ভুল হয়ে যেতে পারে

                    </li>

                    <li>

                        কোন কোন word এর <span class="highlight">একাধিক অর্থ</span> থাকে, যেটা না জানলে বাক্য পড়ে অর্থ বোঝা যায় না । যেসব ওয়ার্ডের একাধিক অর্থ আছে সেগুলো দেওয়া হয়েছে

                    </li>

                    <li>

                        word শেখার সবচেয়ে ইফেক্টিভ হাতিয়ার হচ্ছে <span class="highlight">sentence</span> । কিভাবে ব্যবহার করতে হয় তা হৃদয়ঙ্গম করার জন্য প্রত্যেকটি ওয়ার্ড এর সাথে তিন-চারটি করে সেন্টেন্স দেওয়া হয়েছে

                    </li>

                    <li>

                        প্রত্যেকটি word এর <span class="highlight">synonym</span> লিস্ট দেওয়া হয়েছে যেগুলো Oxford Languages থেকে সংগ্রহীত

                    </li>

                    <li>

                        বেশি গুরুত্বপূর্ণ কিংবা কনফিউজিং ওয়ার্ডগুলোর <span class="highlight">English definition</span> দেওয়া হয়েছে যা কনসেপ্ট স্বচ্ছ করবে

                    </li>

                    <li>

                        <span class="highlight">Cambridge Dictionary ও Oxford Dictionary</span> কে রেফারেন্স হিসেবে ব্যবহার করা হয়েছে

                    </li>

                    <!-- <li>

                        synonym ওয়ার্ড এর উপর ক্লিক করলে <span class="highlight">word details</span> দেখাবে

                    </li> -->

                    <li>

                        word মনে না পড়লে <span class="highlight">search</span> অপশন ব্যবহার করে বাংলা ও ইংলিশ উভয় ওয়ার্ড খুঁজতে পারবেন

                    </li>

                </ol>

            </div>

        </div>



    </div>



@endsection







@section('js')

    <!-- https://codepen.io/run-time/pen/XJNXWV -->

    <script type="text/javascript" src="/js/fingerprint.js"></script>

    <script type="text/javascript" src="/js/library.js"></script>



    <script>

        $(document).ready(function () {







            var visitorLogId = getCookie("visitorLogId");
            if(! visitorLogId){
                visitorLogId = generateVisitorLogId();
                setCookie("visitorLogId", visitorLogId);
            }


            var intervalTime = 5000  ;

            setInterval(function () {

                $.ajax({

                    url : "/ajax/visit_log/save",

                    type : "post",

                    async : true,

                    data : {

                        _token : "{{ csrf_token() }}", visitorLogId : visitorLogId,

                        current_time : Date.now(), browser : navigator.userAgent,

                        url : window.location.pathname

                    },

                    success : function (response) {

                        p(response);

                    },error: function (error) {}

                });

            }, intervalTime);



        });

    </script>



@endsection