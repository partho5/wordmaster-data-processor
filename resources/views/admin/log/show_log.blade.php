<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Visitor Log</title>

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
        .device-token{

        }
        .duration{
            margin-left: 1em;
            font-size: 1.2em;
            color: #138295;
        }
        .url{
            margin-left: 1em;
            color: #000;
        }
        .meta{
            margin-left: 1em;
            color: #999;
        }
    </style>

</head>
<body>

<div id="container">
    <h2 class="text-center">Visitor Log</h2>
    <?php $i=1; ?>
    @foreach ($groups as $group)
        <div class="device-token">
            <h4>Device Token : {{ $group[0]->device_token }}  <small>browser</small> : {{ $group[0]->client }}</h4>
            @foreach ($group as $log)
                <p>
                    <small>[{{ $i++ }}]</small> <span>{{ date('d M, y -- h:i A', $log->reading_start_at/1000) }}</span>
                    <span class="duration">{{  (new \App\Http\Controllers\Library())->secondHumanReadable( round(($log->reading_end_at - $log->reading_start_at)/1000) ) }}</span>
                    <span class="url">{{ $log->url }}</span>
                    <span class="ref">ref={{ $log->referred_by }}</span>
                    <span class="meta">{{ $log->meta }}</span>
                </p>
            @endforeach
        </div>
    @endforeach
</div>


<script>
    $(document).ready(function () {

    });
</script>

</body>
</html>
