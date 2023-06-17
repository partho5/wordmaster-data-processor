<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <link rel="stylesheet" href="/bootstrap/bootstrap.min.css">
    <script src="/bootstrap/jquery-1.12.4.min.js"></script>
    <script src="/bootstrap/bootstrap.min.js"></script>


    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+Bengali&display=swap" rel="stylesheet">

    <style>
        @font-face {
            font-family: 'Chandrabati';
            font-display: block;
            //src: url({{ storage_path('fonts/NotoSansBengali-Regular.ttf') }}) format('truetype');
            src: url({{ storage_path('fonts/NotoSansBengali-Regular.ttf') }}) format('woff');
        }

        @font-face {
            font-family: 'SutonnyOMJ';
            font-display: block;
            src: url({{ storage_path('fonts/SutonnyMJ.ttf') }}) format('truetype');
        }

        @font-face {
            font-family: 'Noto Sans';
            font-display: block;
            src: url({{ storage_path('fonts/NotoSansBengali-Regular.ttf') }}) format('truetype');
        }

        @page { margin: 0px; }
        body { margin: 0px; }

        .container{
            //font-family: "Chandrabati";
            //font-family: "Noto Sans", sans-serif;
            //padding-left: 1em;
            font-size: 3em;
            font-family: 'Noto Sans Bengali', sans-serif;
        }
        .no-padding{
            padding: 0;
            margin: 0;
        }

        .word-wrapper{
            padding: 1em 0;
            border-bottom: 1px solid #e2e2e2;
        }
        .word-wrapper:nth-child(2n){
            background-color: rgba(253, 252, 240, 0.73);
        }
        .word-wrapper:nth-child(2n+1){
            background-color: rgba(244, 253, 248, 0.62);
        }

        #intro{
            text-align: center;
            font-family: 'Noto Sans Bengali', sans-serif;
            //padding-top: 2em;
            display: none;
        }
        #intro h1{
            font-size: 2.5em;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
            color: #f00;
        }
        #intro h3{
            background-color: #00acc8;
            color: #fff;
            margin: 0 1em;
            padding: 16px 0;
            font-size: 1em;
        }
        #intro .description{
            margin-top: 2em;
            margin-bottom: 4em;
            font-size: 1em;
        }
        #intro .description .p1{
            color: #00acc8;
            font-size: 1.2em;
        }
        #intro a{
            text-decoration: none;
            color: #00f;
        }
        .word{
            //background-color: #f9f9f9;
            color: #ff0000;
            //font-weight: bold;
            font-size: 1.5em;
        }
        .pof{
            color: #7d7d7d;
            font-size: 0.4em;
            font-weight: lighter;
        }
        .meanings ul li{
            font-size: 1em;
            color: #000;
        }
        .definition-label span, .sent-label span, .mnemonic-label span, .syno-label span{
            border-bottom: 1px solid #000;
        }
        .mnemonic-label span{
            border-color: #dc47dc;
            background-color: rgba(255, 222, 254, 0.82);
        }
        .definitions{
            margin-top: 1em;
            font-size: 0.8em;
        }
        .oxford, .cambridge{
            color: #089ebf;
            padding-right: 5px;
        }
        .sentences{
            margin-top: 1em;
        }
        .mnemonic{
            margin-top: 1em;
        }
        .mnemonic .content{
            margin-top: 0.3em;
            //font-size: 1.2em !important;
        }
        .synonyms{
            margin-top: 1em;
        }

        .word-wrapper{
            position: relative;
        }
        .advertise{
            position: absolute;
            top: 0.1em;
            right: 0.1em;
            text-align: center;
            font-size: 1em;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        .advertise .app-name{
            background-color: #0003f6;
            color: #ffffff;
            padding: 2px 20px;
            border-radius: 15px;
        }
        .advertise .p2{
            margin-top: 3px;
            font-size: 0.8em;
            color: #c92dc8;
            font-family: cursive;
        }
        .promotional-link{
            font-size: 1em;
            color: #c92dc8;
            font-family: cursive;
            //margin-bottom: 15px;
        }
        .advertise .p2 a, .promotional-link a{
            text-decoration: none;
            color: #0000ff;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        .advertise img.icon, .promotional-link img.icon{
            width: 30px;
            height: auto;
        }

        .page_break { page-break-before: always; }
    </style>

    {{-- !!!!!!!!!!!
    convert webpage to pdf using  https://webtopdf.com/
    font size is compliant with this converter site
    !!!!!!!!!  --}}



</head>
<body>
    <div class="container col-md-12 no-padding">
        <div id="intro" class="col-md-12">
            <h1>Job Vocabulary</h1> <br>
            <h3>High frequency 330 words</h3>
            <div class="description">
                <div class="p1">মূল অ্যাপে আছে 2900 words</div>
                <br>
                Bank, BCS সহ যেকোন সরকারি চাকরি এবং IELTS, Gmat, GRE সবকিছুই কভার হয়ে যাবে একটি অ্যাপ থেকে ! আর সেখানে আরো অনেক ডিটেইলস রয়েছে
                <br> <br>
                <p style="color: #f00; font-size: 1.3em">মূল অ্যাপটি পাবেন এখানে : <a href="{{ $appLink }}">jovoc.com</a></p>

            </div>
        </div>
        <div class="page_break"></div>


        @foreach($data as $index => $word)
            <div class="word-wrapper">
                <div class="word">
                    {{ $word['word'] }}
                    @if(isset($word['pof']))
                        <span class="pof">({{ $word['pof'] }})</span>
                    @endif
                </div>



                @if($index % 2 == 1)
                    <div class="advertise">
                        <div class="app-name">Job Vocabulary</div>
                        {{--<div class="p2 hidden">--}}
                            {{--full content at--}}
                            {{--<img src="/images/icon/finger_tap_click.png" class="icon">--}}
                            {{--<a href="{{ $appLink }}">jovoc.com</a>--}}
                            {{--<img src="/images/icon/finger_tap_click.png" class="icon">--}}
                        {{--</div>--}}
                    </div>
                @elseif(false && $index % 3 == 1)
                    {{--<div class="advertise">--}}
                        {{--<div class="app-name hidden">Job Vocabulary</div>--}}
                        {{--<div class="p2">--}}
                            {{--full content at--}}
                            {{--<img src="/images/icon/finger_tap_click.png" class="icon">--}}
                            {{--<a href="{{ $appLink }}">jovoc.com</a>--}}
                            {{--<img src="/images/icon/finger_tap_click.png" class="icon">--}}
                        {{--</div>--}}
                    {{--</div>--}}
                @endif



                @if(isset($word['meanings']))
                    <div class="meanings">
                        <ul>
                            @foreach($word['meanings'] as $meaning)
                                @if(isset($meaning) && $meaning != "")
                                    <li>{!! $meaning !!}</li>
                                @endif
                            @endforeach
                        </ul>
                    </div>

                    @if($index > 3 && $index % 3 == 1)
                        <div class="promotional-link">
                            full content at
                            <img src="/images/icon/finger_tap_click.png" class="icon">
                            <a href="{{ $appLink.'-full-content-here' }}">jovoc.com</a>
                            <img src="/images/icon/finger_tap_click.png" class="icon">
                        </div>
                    @endif
                @endif

                @if( isset($word['definitions']) && count($word['definitions']) > 0 )
                    <div class="definitions">
                        <div class="definition-label">
                            <span>Definition : </span>
                        </div>
                        @foreach($word['definitions'] as $definition)
                            <div>{!! $definition !!}</div>
                            @break
                        @endforeach
                    </div>
                @endif


                @if(isset($word['mnemonic']) && "" != $word['mnemonic'])
                    <div class="mnemonic">
                        <div class="mnemonic-label"><span>Mnemonic / মনে রাখার টেকনিক</span></div>
                        @if($index <= 100)
                            <div class="content">{!! $word['mnemonic'] !!}</div>
                        @else
                            <div class="content">
                                full content available at <a href="{{ $appLink }}">jovoc.com</a>
                            </div>
                        @endif
                    </div>
                @endif


                @if(isset($word['sentence']) && count($word['sentence']) > 0)
                    <div class="sentences">
                        <div class="sent-label"><span>Use in sentence</span></div>
                        <div>
                            <ol>
                                @foreach($word['sentence'] as $sentence)
                                    <li>{{ $sentence }}</li>
                                @endforeach
                            </ol>
                        </div>
                    </div>
                @endif

                @if(isset($word['synonyms']))
                    <div class="synonyms">
                        <div class="syno-label"><span>Synonym</span></div>
                        <div>
                            @foreach($word['synonyms'] as $si => $synonym)
                                <span> {{ $synonym }} {{ $si < count($word['synonyms'])-1 ? "," : "" }} </span>
                            @endforeach
                        </div>
                    </div>
                @endif


            </div>
        @endforeach
    </div>
</body>
</html>