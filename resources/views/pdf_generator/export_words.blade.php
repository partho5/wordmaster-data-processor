<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <link rel="stylesheet" href="/bootstrap/bootstrap.min.css">
    <script src="/bootstrap/jquery-1.12.4.min.js"></script>
    <script src="/bootstrap/bootstrap.min.js"></script>


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

        .container{
            //font-family: "Chandrabati";
            font-family: "Noto Sans", sans-serif;
            padding-left: 1em;
        }
        .no-padding{
            padding: 0;
            margin: 0;
        }

        .word-wrapper{
            padding: 1em;
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
        }
        #intro h1{
            font-size: 6em;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        #intro h3{
            background-color: #00acc8;
            color: #fff;
            margin: 0 2em;
            padding: 8px 0;
        }
        #intro .description{
            margin-top: 2em;
            font-size: 1.3em;
        }
        #intro .description .p1{
            color: #00acc8;
            font-size: 1.2em;
        }
        .word{
            //background-color: #f9f9f9;
            color: #ff0000;
            //font-weight: bold;
            font-size: 1.4em;
        }
        .pof{
            color: #a8a8a8;
            font-size: 0.5em;
            font-weight: lighter;
        }
        .meanings ul li{
            font-size: 1.3em;
            color: #000;
        }
        .definition-label span, .sent-label span, .mnemonic-label span{
            border-bottom: 1px solid #000;
        }
        .oxford, .cambridge{
            color: #089ebf;
            padding-right: 5px;
        }
        .sentences{
            margin-top: 1em;
        }
        .mnemonic .content{
            margin-top: 0.3em;
            font-size: 1.2em;
        }
        .page_break { page-break-before: always; }
    </style>

</head>
<body>
    <div class="container col-md-12 no-padding">
        <div id="intro">
            <h1>Job Vocabulary</h1> <br>
            <h3>High frequency 330 words</h3>
            <div class="description">
                <div class="p1">মূল অ্যাপে আছে 2900 words</div>
                <br>
                Bank, BCS সহ যেকোন সরকারি চাকরি এবং IELTS, Gmat, GRE সবকিছুই কভার হয়ে যাবে একটি অ্যাপ থেকে ! আর সেখানে আরো অনেক ডিটেইলস রয়েছে
                <br> <br>
                <p style="color: #f00">মূল অ্যাপটি পাবেন এখানে : <a href="jovoc.com">jovoc.com</a></p>

            </div>
        </div>
        <div class="page_break"></div>


    @foreach($data as $word)
            <div class="word-wrapper">
                <div class="word">
                    {{ $word['word'] }}
                    @if(isset($word['pof']))
                        <span class="pof">({{ $word['pof'] }})</span>
                    @endif
                </div>

                <div class="meanings">
                    <ul>
                        @foreach($word['meanings'] as $meaning)
                            @if(isset($meaning) && $meaning != "")
                                <li>{{ $meaning }}</li>
                            @endif
                        @endforeach
                    </ul>
                </div>

                <div class="definitions">
                    <div class="definition-label">
                        <span>Definition : </span>
                    </div>
                    @foreach($word['definitions'] as $definition)
                        <div>{!! $definition !!}</div>
                    @endforeach
                </div>

                <div class="sentences">
                    <div class="sent-label"><span>How to use in sentence : </span></div>
                    <div>
                        <ol>
                            @foreach($word['sentence'] as $sentence)
                                <li>{{ $sentence }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>

                @if(isset($word['mnemonic']))
                    <div class="mnemonic">
                        <div class="mnemonic-label"><span>Mnemonic / মনে রাখার টেকনিক</span></div>
                        <div class="content">{!! $word['mnemonic'] !!}</div>
                    </div>
                @endif

            </div>
        @endforeach
    </div>
</body>
</html>