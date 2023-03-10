<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>App User Log</title>

{{--<link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">--}}
{{--<script src="https://code.jquery.com/jquery-1.12.4.min.js"></script>--}}
{{--<script src="https://netdna.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>--}}

<!-- development time only -->
    <link rel="stylesheet" href="/bootstrap/bootstrap.min.css">
    <script src="/bootstrap/jquery-1.12.4.min.js"></script>
    <script src="/bootstrap/bootstrap.min.js"></script>


    <link href="https://fonts.googleapis.com/css?family=Nunito:300,600" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@500&display=swap" rel="stylesheet">

    <style>
        #container{
            padding: 8px;
        }
        .log:nth-child(2n+1){
            background-color: #dededebb;
        }
        .log:nth-child(2n){
            //background-color: #ccc;
        }
        .user{
            background: #00bd00;
            text-align: center;
        }
        .user .uid{
            color: #e5e05d;
        }
        .user .device-name{
            color: #f2f2f2;
            padding: 0 1em;
        }
        .user .os-v{
            color: #3511b8;
        }
        .diff{
            color: #047AB8;
        }
    </style>

</head>
<body>

<div id="container">
    <h2 class="text-center">App User Log</h2>
    <div>
        <?php $osV['21']='Lollipop 5.0'; $osV['22']='Lollipop 5.1'; $osV['23']='Marshmallow'; $osV['24']='Nougat 7.0'; $osV['25']='Nougat 7.1+'; $osV['26']='Oreo 8.0'; $osV['27']='Oreo 8.1';$osV['28']='Pie 9.0'; $osV['29']='Android 10'; $osV['30']='Android 11'; $osV['31']='Android 12'; $osV['32']='Android 12 L'; $osV['33']='Android 13' ?>

        @foreach($logData as $userId=>$logs)
            <div class="col-xs-12 col-md-12 user">
                <span class="uid">user id : {{ $userId }} </span>
                <span class="device-name">{{ \App\Models\User::find($userId)->device_name }}</span>
                <span class="os-v">{{ @$osV[\App\Models\User::find($userId)->os_version] }}</span>
            </div>
            @foreach($logs as $rows)
                @foreach($rows as $row)
                    <div class="log col-xs-12 col-md-12">
                        <div class="col-xs-6 col-md-2 hidden"></div>
                        <div class="col-xs-6 col-md-2">{{ $row['start'] }}</div>
                        <div class="col-xs-6 col-md-1 diff">{{ $row['diff'] }} sec</div>
                        <div class="col-xs-6 col-md-2 ">{{ $row['end'] }}</div>
                        <div class="col-xs-6 col-md-1">{{ $row['activity'] }}  {{ $row['details'] }}</div>
                        <div class="col-xs-6 col-md-2">{{ $row['wordIndex'] }}</div>
                    </div>
                @endforeach
            @endforeach
        @endforeach
    </div>
</div>


<script>
    $(document).ready(function () {

    });
</script>

</body>
</html>
