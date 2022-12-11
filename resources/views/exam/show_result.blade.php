@extends('exam.base_layout')

@section('title')
    <title>Exam Result</title>
@endsection

@section('external_resources')
    <link href="/css/exam/result.css" rel="stylesheet">
    <script type="text/javascript" src="/js/library.js"></script>
@endsection

@section('body_container')
    <div class="col-md-6 col-md-offset-3 col-xs-12" id="content" style="padding: 4px">
        <div id="exam-info" class="col-xs-12 no-padding">
            {{--<div class='exam col-xs-12 hidden' data-test-id='' id='template'>--}}
                {{--<span>Mini Test</span> <small style='color: #949494'>held at</small>--}}
                {{--<span class='exam-date'>27 Jan, 2021</span>--}}
                {{--<div> <small>Time taken</small> : <span>18 min 23 sec</span> </div>--}}
                {{--<br>--}}
                {{--<div class='col-xs-12 no-padding'>--}}
                    {{--<div class='col-xs-9'>Number of questions</div>--}}
                    {{--<div class='col-xs-3'>20</div>--}}
                {{--</div>--}}

                {{--<div class='col-xs-12 no-padding'>--}}
                    {{--<div class='col-xs-9'>Answered</div>--}}
                    {{--<div class='col-xs-3'>18</div>--}}
                {{--</div>--}}

                {{--<div class='col-xs-12 no-padding'>--}}
                    {{--<div class='col-xs-9'>Correct</div>--}}
                    {{--<div class='col-xs-3'>17</div>--}}
                {{--</div>--}}

                {{--<div class='col-xs-12 no-padding' style='border-top: 1px solid #c5c5c5'>--}}
                    {{--<div class='col-xs-9'>Obtained mark</div>--}}
                    {{--<div class='col-xs-3'>16.5</div>--}}
                {{--</div>--}}
            {{--</div>--}}
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {

            var testIds = [];
            var correctMark = 1, incorrectMinus = 0.25;

            loadResult('');

            var c=0;
            function loadResult(prevTestId) {
                p('sending request with testId='+prevTestId);
                $.ajax({
                    type:'post',
                    url:'/student/exam/ajax/fetch_result',
                    data:{
                        _token:"{{ csrf_token() }}", prevTestId:prevTestId
                    }, success : function (response) {
                        p(response);
                        if(response.hasOwnProperty('testIds')){
                            //on first ajax call, just get testIds. then I will send each ajax request with each testId
                            testIds = response['testIds'];
                        }

                        if(response.hasOwnProperty('qa')){
                            var s = new Date(response['examStart']);
                            var e = new Date(response['examEnd']);
                            var diff = readableTime( Math.round(Math.abs(e-s)/1000) );

                            var correct = 0, incorrect = 0, answered = 0, totalQ = 0;
                            for(var i in response['qa']){
                                if(response['qa'][i]['answered_option']){
                                    //p(response['qa'][i]['answered_option']+' vs '+response['qa'][i]['correct_option']);
                                    ++answered;
                                    if(response['qa'][i]['answered_option'] == response['qa'][i]['correct_option']){
                                        ++correct;
                                    }else{
                                        ++incorrect;
                                    }
                                }else{
                                    //not answered this question
                                }
                                ++totalQ;
                            }
                            //p('cor='+correct+'--inco'+incorrect+'--ans='+answered);
                            var markObtained = correct*correctMark - incorrect*incorrectMinus;

                            var dom = "<div class='exam col-xs-12' data-test-id=''>\n" +
                                "                <span>Mini Test</span> <small style='color: #949494'>held at</small>\n" +
                                "                <span class='exam-date'>"+dateUsingMonthName(response['examStart'])+" <small class='time'>"+formatAmPm( new Date(response['examStart']) )+"</small> </span>\n" +
                                "                <div> <small>Time taken</small> : <span>"+diff+"</span> </div>\n" +
                                "                <br>\n" +
                                "                <div class='col-xs-12 no-padding'>\n" +
                                "                    <div class='col-xs-9 labels'>Number of questions</div>\n" +
                                "                    <div class='col-xs-3 val'>"+totalQ+"</div>\n" +
                                "                </div>\n" +
                                "\n" +
                                "                <div class='col-xs-12 no-padding'>\n" +
                                "                    <div class='col-xs-9 labels'>Answered</div>\n" +
                                "                    <div class='col-xs-3 val'>"+answered+"</div>\n" +
                                "                </div>\n" +
                                "\n" +
                                "                <div class='col-xs-12 no-padding'>\n" +
                                "                    <div class='col-xs-9 labels'>Correct</div>\n" +
                                "                    <div class='col-xs-3 val'>"+correct+"</div>\n" +
                                "                </div>\n" +
                                "\n" +
                                "                <div class='col-xs-12 no-padding'>\n" +
                                "                    <div class='col-xs-9 labels'>Incorrect <small>(-"+incorrectMinus+" for each)</small></div>\n" +
                                "                    <div class='col-xs-3 val'>"+incorrect+"</div>\n" +
                                "                </div>\n" +
                                "\n" +
                                "                <div class='col-xs-12 no-padding' style='border-top: 1px solid #c5c5c5'>\n" +
                                "                    <div class='col-xs-9 labels'>Obtained mark</div>\n" +
                                "                    <div class='col-xs-3 val'>"+markObtained+"</div>\n" +
                                "                </div>\n" +
                                "                <div class='col-xs-12 no-padding details'> <a href='/student/exam/result/"+response['testId']+"' target='_blank'>details</a> </div>\n" +
                                "            </div>";

                            $('#exam-info').append(dom);
                            $('.exam').fadeIn(500);
                        }

                        if(c < testIds.length ){
                            loadResult(testIds[c]);
                        }
                        ++c;
                    }, error: function (e) {
                        p(e);
                    }
                });
            }


            function formatAmPm(date) {
                var hours = date.getHours();
                var minutes = date.getMinutes();
                var ampm = hours >= 12 ? 'pm' : 'am';
                hours = hours % 12;
                hours = hours ? hours : 12; // the hour '0' should be '12'
                minutes = minutes < 10 ? '0'+minutes : minutes;
                var strTime = hours + ':' + minutes + ' ' + ampm;
                return strTime;
            }


            function dateUsingMonthName(dateStr) {
                var monthNames = ["January", "February", "March", "April", "May", "June",
                    "July", "August", "September", "October", "November", "December"
                ];
                var d = new Date(dateStr);
                var date = d.getDate()+" "+monthNames[d.getDay()]+", "+ (d.getFullYear()+"").substr(2,4);
                return date;
            }


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