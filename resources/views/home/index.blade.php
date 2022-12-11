<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Word Master</title>

        {{--<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">--}}
        {{--<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>--}}
        {{--<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}

        <!-- development time only -->
        <link rel="stylesheet" href="/bootstrap/bootstrap.min.css">
        <script src="/bootstrap/jquery-1.12.4.min.js"></script>
        <script src="/bootstrap/bootstrap.min.js"></script>


        <script src="/js/jquery.slides.min.js"></script>

        <link href="https://fonts.googleapis.com/css?family=Nunito:300,600" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">

        <link href="/css/home/index.css" rel="stylesheet">

    </head>
    <body>
    <script>
        var onlyWords = [];
    </script>

    @if( ! isset($_COOKIE['currentReadingWord']) )
    <div class="custom-alert">
        <div class="msg">
            <div class="part1">
                <p class='p1'>Saifur's + Word Smart 1 & 2</p>
                এর সব words এখানে আছে <br> <br>
                এছাড়া newspaper, comprehension ইত্যাদি পড়তে গিয়ে যেসব words প্রয়োজনীয় মনে হয়েছে তা আমি collect করেছি
            </div>
            <div class="part2">
                <p class="my-hr"> &nbsp; </p>
                <p class="p1">collected by : Partho Protim</p>
                <p class="my-hr"> &nbsp; </p>
            </div>
            <div class="btn-wrapper">
                <button class="start-reading">Start Reading</button>
            </div>
        </div>
    </div>
    @endif

        <div id="slideContainer">
            @foreach($allWords as $word)
                <div class="col-xs-12 col-md-6 col-md-offset-3 no-padding body-content" id="eachSlide">
                    <div class="col-xs-12 no-padding word-wrapper" id="">
                        <div class="base-word col-xs-10 no-padding">
                            <script>
                                onlyWords.push("<?php echo $word['word'] ?>");
                            </script>
                            {{ ucfirst($word['word']) }}
                            @foreach($word['parts_of_speech'] as $pof)
                                <span class="parts-of-speech">({{ $pof->parts_of_speech }})</span>
                            @endforeach
                        </div>
                        <div class="note-icon col-xs-1 no-padding">
                            <img src="/images/light_bulb1.jpg" alt="note" width="20px" height="20px">
                        </div>
                        @foreach($word['meanings'] as $meaning)
                            <div class="bangla-meaning col-xs-12">
                                <p class="meaning-label">Meaning : </p>
                                <p class="">{{ $meaning->bangla_meaning }}</p>
                            </div>
                        @endforeach
                    </div>


                    <div class="col-xs-12 no-padding " id="mnemonics-wrapper">
                        <div class="heading col-xs-10 no-padding"><span>Mnemonics</span></div>
                        <div class="note-icon col-xs-1 no-padding">
                            <img src="/images/light_bulb1.jpg" alt="note" width="20px" height="20px">
                        </div>
                        <div class="col-xs-12 no-padding mnemonic">mnemonics will be here</div>
                    </div>


                    <div class="col-xs-12 no-padding " id="derived-words-wrapper">
                        <div class="heading col-xs-10 no-padding"><span>Same origin / Derived words</span></div>
                        <div class="note-icon col-xs-1 no-padding">
                            <img src="/images/light_bulb1.jpg" alt="note" width="20px" height="20px">
                        </div>
                        <div class="col-xs-12 no-padding">
                            <ul>
                                <li>derived words will be here</li>
                            </ul>
                        </div>
                    </div>

                    <div class="col-xs-12 no-padding" id="usage-wrapper">
                        <div class="heading col-xs-10 no-padding"><span>Usage in sentence</span></div>
                        <div class="note-icon col-xs-1 no-padding">
                            <img src="/images/light_bulb1.jpg" alt="note" width="20px" height="20px">
                        </div>
                        <div class="col-xs-12 no-padding">
                            <ul>
                                @if(isset($word['uses']))
                                    @foreach($word['uses'] as $use)
                                        <li>{{ $use['sentence'] }}</li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                    <div class="col-xs-12 no-padding" id="synonym-wrapper">
                        <div class="heading col-xs-10 no-padding"><span>Synonymous words</span></div>
                        <div class="note-icon col-xs-1 no-padding">
                            <img src="/images/light_bulb1.jpg" alt="note" width="20px" height="20px">
                        </div>
                        <div class="col-xs-12 no-padding">
                            <ul>
                                @if(isset($word['synonyms']))
                                    @foreach($word['synonyms'] as $i=>$synonym)
                                        <?php $len = count($word['synonyms']) ?>
                                        <span class="{{ $synonym['is_base_word'] == 1 ? "main-word-listed":"" }}">{{ $synonym['word'] }}</span> {{ $i == $len-1 ? "" : "," }}
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>

                </div>
            @endforeach
        </div>

        <div id="bottom-info" class="col-xs-12 no-padding">
            <div id="navigation-bar" class="col-xs-12 no-padding">
                <div class="col-xs-6 no-padding text-left prevBtn" id="">
                    <span><< swipe Left</span>
                </div>
                <div class="col-xs-6 no-padding text-right nextBtn " id="">
                    <span> >>  swipe Right</span>
                </div>
            </div>

            <p id="info-content" class="no-padding text-center">Think you are reading book, so better to disconnect internet</p>
        </div>

<!-- https://codepen.io/run-time/pen/XJNXWV -->
<script type="text/javascript" src="/js/fingerprint.js"></script>

        <script>
            $(document).ready(function () {
//                var url_string = "http://www.example.com/t.html?a=1&b=3&c=m2-m3-m4-m5"; //window.location.href
//                var url = new URL(url_string);
//                var c = url.searchParams.get("c");
//                $(".meaning-label").text(c);


                p("onLoad page >>> currentReadingWord : "+getCookie("currentReadingWord"));
                p(onlyWords);

                $(".start-reading").click(function () {
                    $(".custom-alert").hide();
                });

                $('#slideContainer').slidesjs({
                    width: window.innerWidth,
                    height: $(".body-content").height() + 300,
                    callback: {
                        loaded: function() { },
                        start: function() {},
                        complete: function(n) {
                            setCookie("currentReadingWord", onlyWords[n-1]);
                            //p("on slide change >>> currentReadingWord : "+getCookie("currentReadingWord"));
                            //$(".meaning-label").text(n+"---"+onlyWords.length);
                            if(onlyWords.length == n){
                                alert("Reload for more words");
                                location.reload();
                            }

                            //var newUrl = (window.location.origin)+""+(window.location.pathname)+"?w=";
                            //window.history.pushState('', '', newUrl);
                        },
                    },
                    start : Math.floor(onlyWords.length/2)-2,
                });
                $(".slidesjs-previous, .slidesjs-next, .slidesjs-pagination-item").hide();

                $(".prevBtn").click(function () {
                    $(".slidesjs-previous").click();
                });
                $(".nextBtn").click(function () {
                    $(".slidesjs-next").click();
                });


                var fp = new Fingerprint({
                  canvas: true,
                  ie_activex: true,
                  screen_resolution: true
                });

                var fingerprint = fp.get();
                setCookie("visitorLogId2", fingerprint);

                var intervalTime = 5000  ;
                setInterval(function () {
                    $.ajax({
                        url : "/ajax/visit_log/save",
                        type : "post",
                        async : true,
                        data : {
                            _token : "{{ csrf_token() }}", visitorLogId : getCookie("visitorLogId2"),
                            current_time : Date.now(), browser : fingerprint_browser()
                        },
                        success : function (response) {
                            p(response);
                        },error: function (error) {}
                    });
                }, intervalTime);


                function p(data) {
                    console.log(data);
                }

                function setCookie(cookieName, cookieVal) {

                    //document.cookie = cookieName+"="+cookieVal+";expires=01 Jan 2100";

                    //another style
                    var days = 20000;
                    var date = new Date();
                    date.setDate(date.getDate() + days);
                    var expireTime = date.toUTCString();
                    document.cookie = cookieName+"="+cookieVal+";expires="+expireTime+";path=/";
                }

                function getCookie(cookieName) {
                    var nameEQ = cookieName + "=";
                    var ca = document.cookie.split(';');
                    for(var i=0;i < ca.length;i++) {
                        var c = ca[i];
                        while (c.charAt(0)==' ') c = c.substring(1,c.length);
                        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
                    }
                    return null;
                }

                Date.prototype.addDays = function (days) {
                    var date = new Date(this.valueOf());
                    date.setDate(date.getDate() + days);
                    return date;
                }

            });
        </script>

    </body>
</html>
