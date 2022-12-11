@extends('exam.base_layout')

@section('title')
    <title>Test My Vocabulary</title>
@endsection

@section('external_resources')
    <link href="/css/exam/index.css" rel="stylesheet">
    <script type="text/javascript" src="/js/library.js"></script>
@endsection

@section('body_container')
    <div class="col-md-6 col-md-offset-3 col-xs-12" id="content">
        <div id="intro">
            <p class="p1">I am going to test myself for a <br> <strong>strong preparation</strong> </p>
            <div class="instruction">
                <div style="font-size: 0.8em">
                    <hr>
                    You need to know these
                    <button class="btn btn-dark ins-btn" data-toggle="collapse" data-target="#ins-list">Instructions</button>
                    <hr>
                </div>

                <ul class="collapse" id="ins-list">
                    <li> নির্ধারিত সময়ের মধ্যে উত্তর  submit না  করলে  স্বয়ংক্রিয়ভাবে submit হয়ে যাবে  </li>
                    <li>কতগুলো প্রশ্নে পরীক্ষা দিতে চান সেটা পরবর্তী পেজে সিলেক্ট করবেন</li>
                </ul>
            </div>
        </div>

        <div id="get-question" class="col-xs-12 no-padding text-center" style="margin-top:4em">
            <div class="text-left p1">well, now </div>
            <button class="btn-get">Get Question Paper</button>

            <div class="text-left col-xs-12  panel panel-hidden">
                <div class="col-xs-8 no-padding">Number of questions</div>
                <div class="col-xs-4">
                    <input type="number" min="1" max="1000" value="50" id="num-of-q" class="form-control">
                </div>
                <p class="text-center" style="color: #0c5460"><i>the more, the better.....</i></p>
                <div class="col-xs-12" style="margin-top:2em">
                    <button class="btn btn-primary fetch-btn col-xs-6 col-xs-offset-3" >Okk, Start Exam</button>
                </div>
            </div>
        </div>

        <div id="exam" class="col-xs-12 no-padding" style="margin-top:2em">
            <p class="text-center p1">Word Master is preparing question for you</p>
            <p class="text-center p2"> <b>Exam will start in 1 minute</b> </p>
            <div class="clock" style="display: none"></div>

            <div class="col-xs-12 no-padding" id="about-question" style="display: none">
                <div class="col-xs-6 no-padding" id="totQ">Total questions: 20</div>
                <div class="col-xs-6 no-padding text-right" id="totTime">Time: 15 minutes</div>
            </div>

            <div id="question-container" class="col-xs-12 no-padding" style="margin-top: 1em; display: none">
                {{--<div class="question">--}}
                    {{--<div class="q"> <span>(1)</span> What is the synonym of affluent ?</div>--}}
                    {{--<ol>--}}
                        {{--<li> <input type="radio" name="qid2"> <span>option 1</span> </li>--}}
                        {{--<li> <input type="radio" name="qid2"> <span>option 2</span> </li>--}}
                        {{--<li> <input type="radio" name="qid2"> <span>option 3</span> </li>--}}
                        {{--<li> <input type="radio" name="qid2"> <span>option 4</span> </li>--}}
                    {{--</ol>--}}
                {{--</div>--}}
            </div>
        </div>

        <div class="col-xs-12" id="after-exam">
            <p class="p1" style="display: none">
                You can find your result <a href="/student/exam/result">here</a>
            </p>
        </div>

    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {
            
            var url = new URL(window.location.href);
            var deviceId = url.searchParams.get('deviceId');
            var maxdi = url.searchParams.get('maxdi');

            setCookie('deviceId', deviceId);//android deviceId

            $('.btn-get').click(function () {
                $('#intro, #get-question .p1, #get-question .btn-get').slideUp(200);
                $('#get-question .panel').removeClass('panel-hidden').addClass('panel-shown');
            });

            var examStartedAt = '', examId = 0;

            $('#get-question .fetch-btn').click(function(){
                $('#get-question').fadeOut();
                $('.navbar').hide();
                $('#exam').show();

                $.ajax({
                    type:'post',
                    url:'/student/exam/ajax/fetch_question',
                    data:{
                        _token: "{{ csrf_token() }}", deviceId:deviceId, maxdi:maxdi,
                         numOfQ: $('#num-of-q').val()
                    }, success:function (response) {
                        p(response);
                        examId = response['examId'];
                        response = response['questionSets'];
                        var len = response.length;
                        if(len>0){
                            if(len<10){
                                alert("Till now you have read only "+len+" words. Please read at least 10 words and then test yourself again");
                            }
                            $('#exam .p1, #exam .p2').show();
                            $('#totQ').text("Total questions : "+len);
                            var totTime = Math.ceil(len);
                            $('#totTime').text("Time : "+totTime+" minutes");
                            $('#about-question, #question-container').fadeIn();

                            var dom = "";
                            for(var i in response){
                                i = parseInt(i);
                                dom+= "<div class='question' data-q-id='"+response[i]['id']+"' id='qNo"+response[i]['id']+"'>\n" +
                                    "                    <div class='q'> <span>("+(i+1)+")</span> &nbsp;"+response[i]['question']+"</div>\n" +
                                    "                    <ol>\n" +
                                    "                        <li> <input type='radio' name='qid"+response[i]['id']+"'> <span>"+response[i]['option1']+"</span> </li>\n" +
                                    "                        <li> <input type='radio' name='qid"+response[i]['id']+"'> <span>"+response[i]['option2']+"</span> </li>\n" +
                                    "                        <li> <input type='radio' name='qid"+response[i]['id']+"'> <span>"+response[i]['option3']+"</span> </li>\n" +
                                    "                        <li> <input type='radio' name='qid"+response[i]['id']+"'> <span>"+response[i]['option4']+"</span> </li>\n" +
                                    "                    </ol>\n" +
                                    "                </div>";
                            }
                            dom+= "<button class='btn btn-success col-xs-8 col-xs-offset-2' id='submit-ans'>Submit answer</button>";
                            $('#question-container').html(dom);

                            var d = new Date( new Date().getTime() );
                            examStartedAt = d.toJSON().slice(0,10)+" "+(d+"").slice(16,25);//date time

                            $('#exam .p1, #exam .p2').hide();
                            $('.clock').fadeIn();

                            var t = totTime*60;//sec
                            var interval = setInterval(function () {
                                $('.clock').text(readableTime(t--));
                                if(t == -1){
                                    clearInterval(interval);
                                    $('.clock').text("Time Up");
                                    $('#submit-ans').click();
                                }
                            }, 1000);
                        }else{
                            alert("Please read at least 10 words and then test yourself again");
                        }
                    }, error: function (e) {
                        p(e);
                        alert("Oops ! Error occurred. Please reload and try again");
                    }
                });
            });



            $(document).on('click', '#submit-ans', function () {
                var answerSheet = [];
                $('.question').each(function () {
                    var qId = $(this).data('q-id');
                    var selected = null;
                    $("#qNo"+qId).find('ol li').each(function () {
                        if( $(this).find("input[type='radio']").is(':checked') ){
                            selected = $(this).text().trim();
                        }
                    });
                    //p(qId+"  > "+selected);
                    var qa = {'qId':qId, 'answeredOption':selected};
                    answerSheet.push(qa);
                });
                //p(answerSheet);

                var url = new URL(window.location.href);
                var deviceId = url.searchParams.get('deviceId');

                $(this).hide();
                $('#question-container').fadeOut(1000);
                $('.navbar').show();
                $('.clock, #about-question').fadeOut();

                $.ajax({
                    type:'post',
                    url:'/student/exam/ajax/submit_answer',
                    data:{
                        _token: "{{ csrf_token() }}", answerSheet : answerSheet, examId : examId
                    }, success:function (response) {
                        p(response);
                        $('#after-exam .p1').fadeIn();
                    }, error: function (e) {
                        p("Oops ! error occurred.");
                    }
                });
            });


            function readableTime(totalSeconds) {
                var h=0, m=0, s=0;
                h = Math.floor(totalSeconds / 3600);
                totalSeconds = totalSeconds % 3600;
                m = Math.floor(totalSeconds / 60);
                s = totalSeconds % 60;

                h = h < 10 ? '0'+h : h ;
                m = m < 10 ? '0'+m : m ;
                s = s < 10 ? '0'+s : s ;

                h = h > 0 ? h+" hour " : "";
                m = m > 0 ? m+" min " : "";
                s = s > 0 ? s+" sec " : "";
                return h+m+s;
            }

        });
    </script>
@endsection