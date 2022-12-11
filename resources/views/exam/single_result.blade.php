@extends('exam.base_layout')

@section('title')
    <title>Details Result</title>
@endsection

@section('external_resources')
    <script type="text/javascript" src="/js/library.js"></script>
    <style>
        #question-container ul li{
            list-style-type: none;
        }
        ul .option{
            padding: 0 2px 2px 4px;
            border-radius: 50%;
        }
        .correct{
            color: #00c700;
        }
        .wrong{
            background: rgba(241, 137, 132, 0.19);
        }
        .answered{
            background: #000;
        }
    </style>
@endsection

@section('body_container')
    <div class="col-md-6 col-md-offset-3 col-xs-12" id="content" style="padding: 4px">
        <div id="question-container" class="col-xs-12 no-padding">
            @foreach($qa as $i=>$obj)
                <div class="question {{ $obj->answered_option != $obj->correct_option && !empty($obj->answered_option) ? 'wrong':'' }}">
                    <div class="q"> <b>({{ $i+1 }})</b> {{ $obj->question }}</div>
                    <ul>
                        <li class="{{ $obj->option1 === $obj->correct_option ? 'correct':'' }}"> <span class="option {{ $obj->option1 == $obj->answered_option ? 'answered':'' }}">a.</span> <span>{{ $obj->option1 }}</span> </li>
                        <li class="{{ $obj->option2 === $obj->correct_option ? 'correct':'' }}"> <span class="option {{ $obj->option2 == $obj->answered_option ? 'answered':'' }}">b.</span> <span>{{ $obj->option2 }}</span> </li>
                        <li class="{{ $obj->option3 === $obj->correct_option ? 'correct':'' }}"> <span class="option {{ $obj->option3 == $obj->answered_option ? 'answered':'' }}">c.</span> <span>{{ $obj->option3 }}</span> </li>
                        <li class="{{ $obj->option4 === $obj->correct_option ? 'correct':'' }}"> <span class="option {{ $obj->option4 == $obj->answered_option ? 'answered':'' }}">d.</span> <span>{{ $obj->option4 }}</span> </li>
                    </ul>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection