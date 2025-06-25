@extends('home.base_layout')



@section('title')

    <title>Bank + BCS + Any Job Exam + Higher Study - with {{ config('app.name') }}</title>
    <link rel="icon" type="image/png" href="/images/jovoc_app_logo.png">


    <meta property="og:type" content="website">
    <meta property="fb:app_id" content="1472570683494634">
    <meta property="og:title" content="যে 2900 words শিখলে কোনো Exam এ আটকাবেন না — কারণ ঘুরে ফিরে এগুলো থেকেই আসে ">

    <!-- <meta property="og:title" content="যে 2900 words থেকে সব পরীক্ষায় কমন আসে। 3-4 টা বইয়ের সমান information এই একটি অ্যাপে"> -->

    <meta property="og:description" content="(1)Explanation (2)Example Sentence (3)Guarenteed memorizing (4)Question Bank (5)Synonyms (6)Revision (7)Exam">
    <meta property="og:image" content="https://vocabulary.jovoc.com/images/jovoc-og.png">
    <meta property="og:url" content="https://vocabulary.jovoc.com">


    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="https://vocabulary.jovoc.com/images/jovoc-og.png">
    <meta name="twitter:title" content="Job Vocabulary - Improve Your Vocabulary for Job Exams">
    <meta name="twitter:description" content="Enhance your vocabulary for job exams with Job Vocabulary app. Learn common words, synonyms, example sentences, and more. Prepare effectively for BCS, bank, and government job exams.">
    <meta name="twitter:image" content="https://vocabulary.jovoc.com/images/jovoc-og.png">



    <meta name="description" content="Enhance your vocabulary for job exams with Job Vocabulary app. Learn common words, synonyms, example sentences, and more. Prepare effectively for BCS, bank, and government job exams.">
    <meta name="keywords" content="Job Vocabulary, vocabulary preparation, job exams, BCS, bank jobs, government jobs, word memorizing, example sentences, synonyms, সরকারী চাকরী, ভোকাবুলারি প্রস্তুতি, Sairfurs vocabulary pdf, word smart 1, word smart 2 pdf, ওয়ার্ড মনে রাখার টেকনিক, মুখস্ত করারা কৌশল, rivision, MCQ test, parts of speech">
    <meta name="author" content="Job Vocabulary">



    {{--<meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" /> --}}

    {{--<meta http-equiv="Pragma" content="no-cache" /> --}}

    {{--<meta http-equiv="Expires" content="0" />--}}




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
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
                   src="https://www.facebook.com/tr?id=615829604664137&ev=PageView&noscript=1"
        /></noscript>
    <!-- End Meta Pixel Code -->


@endsection



@section('external_resources')

    <link href="/css/home/featuredHome.css?v=2" rel="stylesheet">



    {{--<link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap" rel="stylesheet">--}}

    <!-- https://fonts.google.com/specimen/Raleway?query=raleway -->



    <link href="https://fonts.googleapis.com/css2?family=Monda&display=swap" rel="stylesheet">

    <!-- https://fonts.google.com/specimen/Monda?query=monda -->

@endsection



@section('body_container')

    <div class="section col-xs-12 main-pitch">
        <div class="infographic-container">
            <!-- Hero Section -->
            <div class="hero-text">
                <h1>যেকোনো প্রতিযোগিতামূলক পরীক্ষায় Vocabulary অংশে সবারই কিছু না কিছু জায়গায় সমস্যা হয়।</h1>
            </div>

            <!-- Problems Grid -->
            <div class="problems-grid">
                <div class="problem-card">
                    <p>কোন শব্দগুলো আসলে কমন পড়ে?</p>
                </div>
                <div class="problem-card">
                    <p>মুখস্থ করলেও মনে থাকে না কেন?</p>
                </div>
                <div class="problem-card">
                    <p>Sentence ব্যবহার না জানলে কী হয়?</p>
                </div>
                <div class="problem-card">
                    <p>ভুল Synonym বা অর্থ বুঝে পরীক্ষায় মার খাই কেন?</p>
                </div>
            </div>

            <!-- Solution Section -->
            <div class="solution-section">
                <div class="solution-content">
                    <span class="search-icon">🔍</span>
                    <p>আমরা <span class="highlight">BCS, ব্যাংক, IELTS, GRE, GMAT, TOEFL সহ সকল পরীক্ষার প্রশ্নপত্র বিশ্লেষণ করে</span> দেখেছি — Vocabulary অংশে মানুষ মূলত এই কিছু নির্দিষ্ট সমস্যায় আটকে যায়।</p>
                </div>
            </div>

            <!-- Final Solution -->
            <div class="final-solution">
                তাই, আমরা রিসার্চ করে এই সমস্যাগুলোর <strong>এক্স্যাক্ট সমাধান তৈরি করেছি – এক অ্যাপে 👇</strong>
            </div>
        </div>
    </div>

    <div class="section col-xs-12 banner banner-top">
        <img src="https://mindilaxyz.s3-accelerate.amazonaws.com/2025/05/job-and-higher-study-cover.png" width="100%" alt="govt job and higher study cover">
    </div>

    <div class="section col-xs-12 " id="common">

        <div class="title col-xs-10 col-xs-offset-1">94-100 % common</div>

        <div class="col-xs-12 content">

            <div id="commonStat" class="col-xs-12 text-center">


                <div id="bar-chart" style="margin-bottom: 1em">

                    <div class="graph">

                        <ul class="x-axis">

                            <li><span>2001-2010</span></li>

                            <li><span>2010-2025</span></li>

                        </ul>

                        <ul class="y-axis">

                            <li><span>100%</span></li>

                            <li><span>95%</span></li>

                            <li><span>90%</span></li>

                            <li><span>85%</span></li>

                            <li><span>80%</span></li>

                        </ul>

                        <div class="bars">

                            <div class="bar-group group1">

                                <div class="bar bar-1 stat-1" style="height: 94%;">

                                    <span>4080</span>

                                </div>

                                <div class="bar bar-2 stat-2" style="height: 96%;">

                                    <span>5680</span>

                                </div>

                                <div class="bar bar-3 stat-3" style="height: 88%;">

                                    <span>1040</span>

                                </div>

                            </div>

                            <div class="bar-group">

                                <div class="bar bar-4 stat-1" style="height: 91%;">

                                    <span>6080</span>

                                </div>

                                <div class="bar bar-5 stat-2" style="height: 97%;">

                                    <span>6880</span>

                                </div>

                                <div class="bar bar-6 stat-3" style="height: 88%;">

                                    <span>1760</span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>



            </div>

            <div>

                <span style="font-size: 0.8em">বিগত বছর গুলোতে -</span> <br/>

                <div style="font-size: 0.7em">
                    <img src="/images/icon/tick-orange.svg" class="icon"> <span class="fontCourier">BCS</span> এ কমন ছিল <span class="fontRoman">94-100%</span>  <br/>

                    <img src="/images/icon/tick-oliv.svg" class="icon"> বাংলাদেশ ব্যাংক এ <span class="fontRoman">96-100%</span> <br/>

                    <img src="/images/icon/tick-paste.svg" class="icon"> অন্যান্য  ব্যাংক  ও সরকারি চাকরির পরীক্ষায়ও প্রচুর কমন
                </div>

            </div>

        </div>

    </div>







    {{--<div class="section col-xs-12 " id="remembering">--}}

        {{--<div class="title col-xs-10 col-xs-offset-1">--}}

            {{--Revision + Exam <br/> <small>= words মনে থাকতে বাধ্য</small>--}}

        {{--</div>--}}

        {{--<div class="col-xs-12 content no-padding">--}}

            {{--<div class="col-xs-12 text-center no-padding" id="brain-container">--}}

                {{--<img src="/images/super-brain.jpg" alt="word memorizing" style="width: 100%; height: 100%">--}}

                {{--<span class="center-words">curmudgeon</span>--}}

                {{--<span class="center-words">Amalgamate</span>--}}

                {{--<span class="center-words">debacle</span>--}}

                {{--<span class="center-words">Curtail</span>--}}

            {{--</div>--}}

            {{--<div class="col-xs-12 no-padding" style="margin: 0.6em 8px">--}}

                {{--systematic ভাবে নিয়মিত <b style="color: #0000d5">রিভিশন</b> + বার বার--}}

                {{--<b style="color: #0000d5">পরীক্ষা</b> দেওয়ার ব্যবস্থা রয়েছে ; যার ফলে ---}}

                {{--<br/> ব্রেইনে দৃঢ়ভাবে গেঁথে যাবে &nbsp; |Sure|--}}

            {{--</div>--}}

        {{--</div>--}}

    {{--</div>--}}



    <div class="section col-xs-12" id="words-quantity">
        @include('home.partial.svg.purple_svg')
        <div class="title col-xs-10 col-xs-offset-1">সবচেয়ে গুরুত্বপূর্ণ 2900+ words</div>
        <div class="col-xs-12 text-center content no-padding">
            এই words গুলো আয়ত্ত করবেন । জীবনে Vocabulary তে আটকাবেন না !
        </div>
    </div>


    <div class="section col-xs-12">
        <div class="responsive-video-portrait">
            <iframe src="https://www.youtube.com/embed/itGCtzQR9wA" allowfullscreen></iframe>
        </div>
    </div>


    <div class="section col-xs-12 " id="question-bank">

        <div class="title col-xs-10 col-xs-offset-1">
            23 বছরের প্রশ্ন ব্যাংক <br>
            <small style="color: #777">for Job seekers</small>
        </div>

        <div class="col-xs-12 content no-padding">

            <div class="col-xs-12">

                <p>আলাদা করে কোনো প্রশ্ন ব্যাংকের বই কিনতে হবে না</p>

                <p>2001 - 2023 পর্যন্ত বাংলাদেশ ব্যাংক, সরকারি ব্যাংক, প্রাইভেট ব্যাংক, বিসিএস এ আসা সকল Vocabulary কালেকশন রয়েছে</p>

                <p class="hidden">
                    আবার নতুন পরীক্ষার প্রশ্ন পেতে বইয়ের নতুন এডিশন কেনা লাগে । কিন্তু এই App আপডেট দিলেই Free তে নতুন প্রশ্নের Vocabulary
                    সব পেয়ে যাবেন। যেমন- Bangladesh Bank AD 2023 পরীক্ষার পরের দিনেই Vocabulary গুলো Question Bank
                    সেকশনে অ্যাড করে দেওয়া হয়েছে
                </p>

            </div>

        </div>

    </div>



    <div class="section col-xs-12 banner banner-top">
        <img src="/images/preparation-types.png" width="100%" alt="govt job and higher study cover">
    </div>



    <div class="section col-xs-12 " id="diction">

        <div class="title col-xs-10 col-xs-offset-1">Writing এ বেশি মার্ক তুলতে</div>

        <div class="col-xs-12 content">

            <p style="font-size: 0.8em">রোহিঙ্গাদের উপর নির্যাতন করায় সারা বিশ্ব <b>তীব্র নিন্দা জানিয়েছে</b></p>

            <p>এখন, নিন্দা করা এর ইংরেজি vilify, criticize, revile, condemn, censure, berate , denounce, decry...ইত্যাদি হতে  পারে ।</p>

            এর থেকে ইচ্ছামত একটা word বসিয়ে দিলেই কিন্তু হবে না ।

            <i>প্রত্যেকটা word  আলাদা আলাদা ভাবপ্রকাশ করে ।</i>

            সেই ভাব গুলো জানতে হবে <br/><br>

            <p class="highlight"><b>{{ config('app.name') }}</b> তে প্রত্যেকটি word এর specific  meaning দেওয়া হয়েছে</p>

        </div>

    </div>




    <div class="section col-xs-12">
        @include('home.partial.svg.orange_svg')
        <div class="col-xs-12 content">
            <div class="text-center" style="font-size: 1em; padding-bottom: 8px; color: #000ae9">
                4-5 টা ভোকাবুলারি বই এর তথ্য এই একটি App এ !
            </div>
        </div>
    </div>




    <div class="section col-xs-12" id="mnemonic">
        <div class="title col-xs-10 col-xs-offset-1">মনে রাখার Tricks</div>
        <div class="col-xs-12 no-padding content">
            <div class="col-xs-12">
                <p>যদি এমনিতে মনে রাখতে পারেন সেটাই ভাল। আর যদি ভুলে যান ? Tricks তো আছেই ।</p>
                <p class="text-center text-small">উদাহরণ হিসেবে এটি দেখুন :</p>
            </div>
            {{--<div class="col-xs-6 no-padding">--}}
                {{--<img src="/images/words/abnegate.jpg" alt="abnegate" width="100%">--}}
            {{--</div>--}}
            {{--<div class="col-xs-6 no-padding bdr-left">--}}
                {{--<img src="/images/words/accountability.jpg" alt="accountability" width="100%">--}}
            {{--</div>--}}
            <div class="col-xs-12 no-padding">
                <img src="/images/words/accomplice.png" alt="accomplice" width="100%">
            </div>
        </div>
    </div>



    <div class="section col-xs-12 " id="exampleSentence">

        <div class="title col-xs-10 col-xs-offset-1">How to use in sentence</div>

        <div class="col-xs-12 content">

            <p style="font-size: 0.8em; margin-top: 10px">Sentence না পড়লে, লিখতে এবং বলতে গেলে জানা word ও আটকে যাবে, আর তাই-</p>

            <p>প্রত্যেকটি ওয়ার্ড এর জন্য 3-4 টি করে Example Sentence রয়েছে</p>

        </div>

    </div>



    <div class="section col-xs-12 " id="synonym">
        <div class="title col-xs-10 col-xs-offset-1">Synonym</div>
        <div class="col-xs-12 content no-padding">
            <div class="col-xs-12">
                <p>প্রত্যেকটি word এর যত উল্লেখযোগ্য Synonym আছে, যেগুলো পরীক্ষায় আসে, সেগুলোর লিস্ট</p>
            </div>
        </div>
    </div>




    <div class="section col-xs-12 " id="remembering">

        <div class="title col-xs-10 col-xs-offset-1">

            Revision + Exam System<br/> <small style="color: #000">= words মনে থাকতে বাধ্য</small>

        </div>

        <div class="col-xs-12 content no-padding">

            <div class="col-xs-12 text-center no-padding" id="brain-container">

                <img src="/images/super-brain.jpg" alt="word memorizing" style="width: 100%; height: 100%">

                <span class="center-words">curmudgeon</span>

                <span class="center-words">Amalgamate</span>

                <span class="center-words">debacle</span>

                <span class="center-words">Curtail</span>

            </div>

            <div class="col-xs-12 no-padding" style="margin: 0.6em 8px">
                বই থেকে MCQ Test দেয়া যায় না । কিন্তু App টি তে যতগুলো words পড়বেন, সেই কয়টার মধ্যে থেকে <b style="color: #0000d5">MCQ Test</b> দিতে পারবেন।
                <br><br>আবার প্রতি 20 টি words পড়ার পর  App টি আপনাকে <b style="color: #0000d5">Revision</b> দেওয়াবে, পদ্ধতিটা ও বেশ দারুণ !
                <br>
                <div class="col-xs-12 text-center">
                    <img src="/images/icon/golden_trophy.png" class="trophy" alt="effective">
                </div>
            </div>

            <div class="col-xs-12 text-center" style="margin-top: 0.5em; color: orangered">
                মস্তিষ্কে স্থায়ী ভাবে গেঁথে ফেলতে বই এর চেয়ে effective !
            </div>

        </div>

    </div>




    <div class="col-xs-12 section" id="download">
        <div class="content text-center">
            <!-- <p>Download <b>{{ config('app.name') }}</b> :</p> -->
            {{--<p class="p1">কিনবেন কিনা সেটা পরের কথা, কিন্তু ইনস্টল করে যাচাই করে দেখুন</p>--}}
            <p class="p1">
                {{--কেনার আগে ইন্সটল করে পড়ে দেখার সুযোগ রয়েছে--}}
                4-5 টি Vocabulary বই এর তথ্য জাস্ট একটি বইয়ের মূল্যে !!
            </p>
            @if(isset($appDistributionThrough))
                @if($appDistributionThrough === 'playstore')
                        <a href="https://play.google.com/store/apps/details?id=com.wordmas.wordmaster&referrer=utm_source%3Dfacebook%26utm_medium%3Dppm%26utm_campaign%3Dad-june-25">
                            <img src="/images/playstore-link.png" alt="Download App" >
                        </a>
                @elseif($appDistributionThrough === 'apk')
                        <div class="col-xs-12">
                            <a href="/apk/latest-version-app.apk" class="apk">
                                <div class="title" style="all:unset; font-size:1.4em">Download</div>
                            </a>
                        </div>
                @endif
            @endif

            <p class="p2 hidden">
                <img class="icon icon-love" src="/images/icon/love_symbol_red.png">
                ঢাবির একদল গবেষক শিক্ষার্থীদের একটি উদ্যোগ
                <img class="icon icon-love" src="/images/icon/love_symbol_red.png">
            </p>
        </div>
    </div>


    <div class="col-xs-12 col-md-12 no-padding" id="footer">
        <div class="content text-center">
            <div>Your feedback is important to us</div>
            <span>Contact Developer : </span>
            <div>
                Click on &nbsp; <a href="mailto:{{ env('ADMIN_EMAIL') }}">{{ env('ADMIN_EMAIL') }}</a>
            </div>

            <div class="contacts col-xs-12">
                <div class="contact col-xs-6">
                    <img src="/images/icon/fb-logo.png" alt="" class="icon icon-fb">
                    <a href="https://www.facebook.com/profile.php?id=61550346235580" target="_blank">Facebook</a>
                </div>

                <div class="contact col-xs-6">
                    <img src="/images/icon/youtube-logo.png" alt="" class="icon icon-tube">
                    <a target="_blank">YouTube</a>
                </div>
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

            var wordsLeft = ["abandon", "dextrous", "baffle", "chasm"];

            var wordsRight = ["zest", "terse", "poignant", "litany"];

            if(navigator.userAgent.includes("Android 12")){
                // UPDATE: now it supports android 12
                //$('#trial').html("<b style='color:red'>If your android version is 12 or higher, the app is NOT compatible with your device !!</b>");
            }else{
                //$('#trial').append("<br>Download it...");
            }


            var baseDomain = new URL(window.location.href).hostname;
            var urlPath = window.location.pathname; //url path except base domain
            var queryString = window.location.search;
            var urlParams = new URLSearchParams(queryString);

            //here we use 'p' instead of 'ref'
            var referredBy = urlParams.get('p');//this way gets url parameter written using ?param=value

            var postLink = urlParams.get('post');//the URL where the website link was written/posted

            //check if url contains reference (use p instead of ref).
            //Along with "domain.com?p=referenceName" this pattern we also use "domain.com/p/referenceName" this pattern. Because in youtube description ?p= this type url parameter is omitted. But /url/ style works.
            if(urlPath.includes("/p/")){
                var refValue = urlPath.substring(urlPath.indexOf("p")+2); //this approach gets optional url parameter p(reference parameter) value.
            }
            //console.log(referredBy+" "+refValue);
            if(referredBy === null){
                referredBy = refValue;
            }

            setCookie('referredBy', referredBy);



            // Remove URL parameters without page reloading, so that only base domain is visible to user.
            // !!!!!!!!       But do this only after storing all URL params in variables.       !!!!!!!
            //window.history.replaceState({}, document.title, window.location.pathname);

            //window.history.replaceState({}, document.title, extractDomainNameFromFullUrl());

            if(referredBy !== undefined){
                //attach that referredBy parameter to /download url
                var downLink = $(".navbar-nav a[href*='/download']");
                downLink.attr('href', "download?p="+referredBy);
            }



            function extractDomainNameFromFullUrl() {
                var directoryPath = window.location.pathname;
                var fullUrl = window.location.href;
                //p(directoryPath);
                var replaceWhat = directoryPath;
                if(directoryPath === '/'){
                    //otherwise one slash from "http://" will get replaced !
                    replaceWhat = "";
                }
                var urlExceptDirectoryPath = (fullUrl).replace(replaceWhat, '');
                var fullDomain = urlExceptDirectoryPath.split("?")[0];
                //p(fullDomain);
                return fullDomain;
            }



            var dom = "";

            for(var i=0; i<4;i++){

                var top = 2*i;

                var inclination = i<=1 ? 'downward' : 'upward';

                dom+= "<span class='fly fly-left "+inclination+"' style='top: "+top+"em'> <span class='word'>"+wordsLeft[i]+"</span> </span>";

            }

            $('#brain-container').append(dom);



            for(var i=0; i<4;i++){

                var top = 2*i;

                var inclination = i<=1 ? 'downward' : 'upward';

                dom+= "<span class='fly fly-right "+inclination+"' style='top: "+top+"em'> <span class='word'>"+wordsRight[i]+"</span> </span>";

            }

            $('#brain-container').append(dom);



            setTimeout(function(){

                $('.center-words').fadeIn();

            },3000);




            //$('.title').addClass('scaleup');



            if (!window.IntersectionObserver) {

                $('.title').css('opacity', 1).css('transform', 'scale(1)');

                $('.section .content').css('opacity', 1);

            }






            try{
                var fp = new Fingerprint({
                    canvas: true,
                    ie_activex: true,
                    screen_resolution: true
                });
            }catch (e){

            }



            var visitorLogId = getCookie("visitorLogId");
            if(! visitorLogId){
                visitorLogId = generateVisitorLogId();
                setCookie("visitorLogId", visitorLogId);
            }

            var screenSize = screen.width+'x'+screen.height;
            if(! screen.width){
                screenSize = "window.inner:"+window.innerWidth+'x'+window.innerHeight;
            }
            //p("screenSize="+screenSize);

            var metaData = '';
            if(postLink){
                p('added postLink');
                metaData += 'postLink="' + postLink + '"';
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
                        url : window.location.href, referredBy : referredBy, screenSize : screenSize,
                        meta: metaData
                    },
                    success : function (response) {
                        p("log: intervalTime");
                        p(response);

                        metaData = '';
                        postLink = '';
                    },error: function (error) {}
                });
            }, intervalTime);





            const elements = document.querySelectorAll('.title');

            elements.forEach(element=>{

                element.classList.remove('scaleup');

            const observer = new IntersectionObserver(entries=>{

                    entries.forEach(entry => {

                    //$('.title').text("isIntersecting :"+entry.isIntersecting+" intersectionRatio  "+entry.intersectionRatio );

                    if(entry.isIntersecting || entry.intersectionRatio>0){

                element.classList.add('scaleup');



                //console.log( $(element).text() +" > ajax");

                //this ajax call sends only 'section view' info
                /*
                $.ajax({

                    url : "/ajax/visit_log/save",

                    type : "post",

                    async : true,

                    data : {

                        _token : "{{ csrf_token() }}", visitorLogId : visitorLogId,

                        current_time : Date.now(),

                        //browser : navigator.userAgent,
                        //url : '/', referredBy : referredBy,
                        meta: $(element).text() === '' ? null : "section view="+($(element).text())

                    },

                    success : function (response) {
                        p("log: section view");
                        p(response);

                    },error: function (error) {}

                });
                */


                return;

            }

            element.classList.remove('scaleup');

        });

        });

            observer.observe(element);

        });







            const secContents = document.querySelectorAll('.content');

            secContents.forEach(content=>{

                content.classList.remove('appear');

            const observer = new IntersectionObserver(entries=>{

                    entries.forEach(entry=>{

                    if(entry.isIntersecting || entry.intersectionRatio>0){

                content.classList.add('appear');

                return;

            }

            content.classList.remove('appear');

        });

        });

            observer.observe(content);

        });










            $('#download').click(function (e) {

                e.preventDefault();

                var href = $(this).find('a').attr('href');

                if(! href){

                    href = $(this).find('a').prop('href');

                }

                //p( href );

                $.ajax({

                    url : "/ajax/visit_log/save",

                    type : "post",

                    async : true,

                    data : {

                        _token : "{{ csrf_token() }}", visitorLogId : visitorLogId,

                        current_time : Date.now(), browser : navigator.userAgent,

                        url : href, referredBy : referredBy,

                    },

                    success : function (response) {

                        //p(response);

                    },error: function (error) {}

                });


                const eventId = 'click_dl_' + Date.now(); // or any unique string
                fbq('trackCustom', 'ClickDownloadApp', {
                    button: 'PlayStoreLink',
                    platform: 'web'
                }, {
                    eventID: eventId
                });


                window.location = href;

            });





            function p(data) {

                console.log(data);

            }









        });

    </script>

    <script>
        /**
         * Facebook Click ID (fbclid) Appender
         *
         * This script automatically detects the 'fbclid' parameter from the current page URL
         * and appends it to the Google Play Store download link for proper attribution tracking.
         *
         * How it works:
         * 1. Extracts fbclid from current URL parameters
         * 2. Finds the Google Play Store link element
         * 3. Appends fbclid to the existing referrer parameters
         * 4. Updates the link href attribute
         */

// Function to get URL parameter by name
        function getUrlParameter(name) {
            // Create regex pattern to match the parameter
            const regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)');
            const results = regex.exec(window.location.href);

            // Return decoded parameter value or null if not found
            if (!results) return null;
            if (!results[2]) return '';
            return decodeURIComponent(results[2].replace(/\+/g, ' '));
        }

        // Function to append fbclid to the Google Play Store link
        function appendFbclidToPlayStoreLink() {
            // Get fbclid from current URL
            const fbclid = getUrlParameter('fbclid');

            // Only proceed if fbclid exists
            if (!fbclid) {
                //console.log('No fbclid found in URL');
                return;
            }

            // Find the Google Play Store link (you can adjust the selector as needed)
            const playStoreLink = document.querySelector('a[href*="play.google.com"]');

            if (!playStoreLink) {
                //console.log('Google Play Store link not found');
                return;
            }

            // Get current href
            let currentHref = playStoreLink.getAttribute('href');

            // Check if fbclid is already in the URL to avoid duplicates
            if (currentHref.includes('fbclid=')) {
                //console.log('fbclid already exists in the link');
                return;
            }

            // Append fbclid to the referrer parameter
            // The referrer parameter already contains UTM parameters, so we add fbclid with %26 (encoded &)
            const updatedHref = currentHref + '%26fbclid%3D' + encodeURIComponent(fbclid);

            // Update the link href
            playStoreLink.setAttribute('href', updatedHref);

//            console.log('Successfully appended fbclid to Play Store link');
//            console.log('Updated URL:', updatedHref);
        }

        // Execute when DOM is fully loaded
        document.addEventListener('DOMContentLoaded', function() {
            appendFbclidToPlayStoreLink();
        });

        // Alternative: If you need to run this after the page is fully loaded (including images)
        // window.addEventListener('load', function() {
        //     appendFbclidToPlayStoreLink();
        // });

        // Optional: If you want to manually trigger this function later
        // You can call: appendFbclidToPlayStoreLink();
    </script>

@endsection
