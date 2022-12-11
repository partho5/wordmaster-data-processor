<!DOCTYPE html>
<html>
<head>
	<title>Test</title>

    <link rel="stylesheet" href="/bootstrap/bootstrap.min.css">
    <link rel="stylesheet" href="/css/test.css">
    <script src="/bootstrap/jquery-1.12.4.min.js"></script>
    <script src="/bootstrap/bootstrap.min.js"></script>

    <link rel="preconnect" href="https://fonts.gstatic.com">

    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300&display=swap" rel="stylesheet">
    <!-- https://fonts.google.com/specimen/Source+Sans+Pro -->

    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap" rel="stylesheet">
    <!-- https://fonts.google.com/specimen/Raleway?query=raleway -->

    <link href="https://fonts.googleapis.com/css2?family=Monda&display=swap" rel="stylesheet">
    <!-- https://fonts.google.com/specimen/Monda?query=monda -->

    <style type="text/css">
        .no-padding{
            padding: 0;
            margin: 0;
        }
    </style>

</head>
<body>

<div class="col-md-12 no-padding">
    <div id="content" class="col-md-6 col-md-offset-3">
        @foreach($data as $i=>$obj)
            @if(count($obj)>0)
            <div class="col-md-12 no-padding word-container" id="w{{ $i }}" style="margin-top: 3em">
                <span class="hidden word">{{ $obj[0]['word'] }}</span>
                <span class="hidden frequency">{{ count($obj) }}</span>
                <div class="title">{{ $obj[0]['word'] }}</div>
                <div class="meaning">{{ $obj[0]['meaning'] }}</div>
                @foreach($obj as $j=>$item)
                    <div class="exam-info text-left">
                        <img src="/images/icon/arrow.png" class="bullet">
                        {{ $item['exam'] }} - {{ $item['post'] }} - {{ $item['year'] }}
                    </div>
                @endforeach
            </div>
            @endif
        @endforeach
    </div>
    <button id="save-btn">Save as image</button>
</div>

<script src="/js/html2canvas.min.js"></script>
<script type="text/javascript">
	$(document).ready(function(){

        //$('.word-container').eq(0).addClass('theme'+8);

        var allImgData = [];
	    $('#save-btn').click(function () {
            allImgData = [];
            // $('.word-container').each(function (i) {
            //     console.log("-------------"+new Date());
            //     var themeNo = getRandomInt(0,9);
            //     //$('.word-container').eq(i).find('.title').append(" "+themeNo);
            //     $('.word-container').eq(i).addClass('theme'+themeNo);
            //     var word = $(this).find('.word').text();
            //     var frequency = $(this).find('.frequency').text();
            //     html2canvas($('#w'+i+'').get(0)).then( function (canvas) {
            //         var data = canvas.toDataURL('image/png');
            //         //console.log(data);
            //         allImgData.push({'data':data,
            //                 'word':word, 'frequency':frequency});
            //     });
            // });

            setTimeout(function(){
                //console.log(allImgData[0]);
                var c=0;
                setInterval(function(){
                    var themeNo = getRandomInt(0,9);
                    //$('.word-container').eq(i).find('.title').append(" "+themeNo);
                    $('.word-container').eq(c).addClass('theme'+themeNo);
                    var word = $('.word-container').eq(c).find('.word').text();
                    var frequency = $('.word-container').eq(c).find('.frequency').text();
                    html2canvas($('#w'+c+'').get(0)).then( function (canvas) {
                        var data = canvas.toDataURL('image/png');
                        //console.log(data);
                        //allImgData.push({'data':data,'word':word, 'frequency':frequency});
                        //console.log(word+" - "+frequency);

                        $.ajax({
                            url:'/test/t/ajax',type:'post', async:false,
                            data:{
                                _token:"{{ csrf_token() }}", data:data,
                                word:word, frequency:frequency
                            }, success:function (response) {
                                console.log("saved "+response);
                            }, error: function (e) {
                                console.log(e);
                            }
                        });
                    });

                    
                    //console.log(allImgData[c]['word']+" - "+allImgData[c]['frequency']);
                    ++c;
                }, 50);
            }, 400);
        });



	    //https://stackoverflow.com/questions/1527803/generating-random-whole-numbers-in-javascript-in-a-specific-range
        function getRandomInt(min, max) {
            min = Math.ceil(min);
            max = Math.floor(max);
            return Math.floor(Math.random() * (max - min + 1)) + min;
        }



    });
</script>
</body>
</html>