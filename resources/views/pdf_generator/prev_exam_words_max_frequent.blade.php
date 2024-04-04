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
            //display: none;
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
        .meaning{
            font-size: 1em;
            color: #c92dc8;
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

        .prev-exams ul li{
            color: #848484;
            font-size: 0.6em;
            font-family: cursive;
        }

        .word-wrapper{
            //position: relative;
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
            margin-top: 20px;
            margin-left: 0.5em;
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
        <h3>বিগত ২৩ বছরে সবচেয়ে বেশী আসা words গুলো</h3>
        <div class="description">
            <div class="p1">Bangladesh Bank, Gov't Banks, Private Banks & BCS questions have been taken to analyze</div>
            <br> <br>
            <p style=" font-size: 1.3em">যদিও এগুলো পর্যাপ্ত নয়, তবে লাস্ট মুহূর্তে দেখে যাওয়ার জন্য বেস্ট</p>
            <p style="color: #e07f31; font-size: 0.8em; font-family: Arial, Helvetica, sans-serif">Top {{ count($data) }} words</p>
            <p style="font-size: 0.6em">Disclaimer: This is an AI generated document</p>
        </div>
    </div>

    <div class="page_break"></div>

    @foreach($data as $index => $word)
        <div class="word-wrapper col-md-12">
            <div style="margin-left: 0.5em">
                <div class="word">
                    {{ $word['word'] }}
                </div>

                @if(isset($word['meaning']))
                    <div class="meaning">{!! $word['meaning'] !!}</div>
                @endif
            </div>

            <div class="prev-exams ">
                @if(isset($word['exam']))
                    <ul>
                        @foreach($word['exam'][0] as $exam)
                            <li>{{ $exam['exam'] }} | {{ $exam['postName'] }} | {{ $exam['year'] }}</li>
                        @endforeach
                    </ul>
                @endif
            </div>

            @if($index >= 5 && $index % 4 == 1)
                <div class="promotional-link">
                    2900+ words এর কমপ্লিট প্রিপারেশন এখানে
                    <img src="/images/icon/finger_tap_click.png" class="icon">
                    <a href="{{ $appLink.'_clicked_full-content-here' }}">jovoc.com</a>
                    <img src="/images/icon/finger_tap_click.png" class="icon">
                </div>
            @endif


        </div>
    @endforeach

</div>
</body>
</html>