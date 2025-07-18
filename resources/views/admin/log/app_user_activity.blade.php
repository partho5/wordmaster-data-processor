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
        body { font-family: Arial, sans-serif; margin: 20px; }
        .user-section { margin-bottom: 40px; border: 2px solid #ddd; padding: 20px; border-radius: 8px; }
        .user-header { background: #f5f5f5; padding: 15px; margin: -20px -20px 20px -20px; border-radius: 6px 6px 0 0; }
        .user-info { display: flex; gap: 30px; flex-wrap: wrap; }
        .user-info span { font-weight: bold; }
        .logs-table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        .logs-table th, .logs-table td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        .logs-table th { background: #f8f9fa; font-weight: bold; }
        .logs-table tr:nth-child(even) { background: #f9f9f9; }
        .activity-cell { font-weight: bold; color: #007bff; }
        .duration-cell { color: #28a745; font-weight: bold; }
        .timestamp { font-size: 0.9em; color: #666; }
        .no-logs { text-align: center; color: #999; font-style: italic; padding: 20px; }
        .summary { background: #e9ecef; padding: 10px; margin-bottom: 10px; border-radius: 4px; }
    </style>

</head>
<body>

<div id="container">
    <h2 class="text-center">App User Log</h2>
    <div>
        {{--<?php $osV['21']='Lollipop 5.0'; $osV['22']='Lollipop 5.1'; $osV['23']='Marshmallow'; $osV['24']='Nougat 7.0'; $osV['25']='Nougat 7.1+'; $osV['26']='Oreo 8.0'; $osV['27']='Oreo 8.1';$osV['28']='Pie 9.0'; $osV['29']='Android 10'; $osV['30']='Android 11'; $osV['31']='Android 12'; $osV['32']='Android 12 L'; $osV['33']='Android 13' ?>--}}

        {{--@foreach($logData as $userId=>$logs)--}}
            {{--<div class="col-xs-12 col-md-12 user">--}}
                {{--<span class="uid">user id : {{ $userId }} </span>--}}
                {{--<span class="device-name">{{ @\App\Models\User::find($userId)->device_name }}</span>--}}
                {{--<span class="os-v">{{ @$osV[\App\Models\User::find($userId)->os_version] }}</span>--}}
            {{--</div>--}}
            {{--@foreach($logs as $rows)--}}
                {{--@foreach($rows as $row)--}}
                    {{--<div class="log col-xs-12 col-md-12">--}}
                        {{--<div class="col-xs-6 col-md-2">{{ $row['start'] }}</div>--}}
                        {{--<div class="col-xs-6 col-md-1 diff">{{ $row['diff'] }} sec</div>--}}
                        {{--<div class="col-xs-6 col-md-2 ">{{ $row['end'] }}</div>--}}
                        {{--<div class="col-xs-6 col-md-4">{{ $row['activity'] }}  {{ $row['details'] }}</div>--}}
                        {{--<div class="col-xs-6 col-md-2">{{ $row['wordIndex'] }}</div>--}}
                    {{--</div>--}}
                {{--@endforeach--}}
            {{--@endforeach--}}
        {{--@endforeach--}}


        @if(empty($processedData))
            <div class="no-logs">No user activity data found.</div>
        @else
            @foreach($processedData as $userData)
                <div class="user-section">
                    <div class="user-header">
                        <div class="user-info">
                            <span>User ID: {{ $userData['user_id'] }}</span>
                            <span>Device: {{ $userData['device_name'] }}</span>
                            <span>OS: {{ $userData['os_version'] }}</span>
                            <span>Total Activities: {{ count($userData['logs']) }}</span>
                        </div>
                    </div>

                    @if(empty($userData['logs']))
                        <div class="no-logs">No activity logs for this user.</div>
                    @else
                        <table class="logs-table">
                            <thead>
                            <tr>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Duration</th>
                                <th>Activity</th>
                                <th>Details</th>
                                <th>Word Index</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($userData['logs'] as $log)
                                <tr>
                                    <td class="timestamp">{{ $log['start_time'] }}</td>
                                    <td class="timestamp">{{ $log['end_time'] }}</td>
                                    <td class="duration-cell">{{ $log['duration'] }}</td>
                                    <td class="activity-cell">{{ $log['activity'] }}</td>
                                    <td>{{ $log['details'] ?: '-' }}</td>
                                    <td>{{ round($log['word_index']/1000) }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>

                        <div class="summary">
                            <strong>Quick Stats:</strong>
                            App Launches: {{ collect($userData['logs'])->where('activity', 'app launch')->count() }} |
                            Clicks: {{ collect($userData['logs'])->where('activity', 'click')->count() }} |
                            Exits: {{ collect($userData['logs'])->where('activity', 'exit')->count() }} |
                            Pauses: {{ collect($userData['logs'])->where('activity', 'onPause')->count() }}
                        </div>
                    @endif
                </div>
            @endforeach
        @endif


    </div>
</div>


<script>
    $(document).ready(function () {

    });
</script>

</body>
</html>
