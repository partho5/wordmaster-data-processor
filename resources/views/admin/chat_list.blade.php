@extends('admin.base_layout')

@section('title')
    <title>Chat List</title>
@endsection

@section('external_resources')
    <link rel="stylesheet" href="/css/admin/chat_list.css">
@endsection

@section('body_container')
    <div class="col-md-12 text-center">
        {{--@foreach($usersNonRead as  $chatUser)--}}
        {{--<div class="col-md-6 col-md-offset-3 col-xs-12 text-left device non-read">--}}
            {{--<a class="device-id" href="/admin/tom/chat/user?device_id={{ $chatUser->device_id }}" target="_blank"> {{ $chatUser->device_id }} </a>--}}
            {{--<div> phone model <i>android version</i> </div>--}}
        {{--</div>--}}
        {{--@endforeach--}}

        {{--@foreach($usersRead as  $chatUser)--}}
            {{--<div class="col-md-6 col-md-offset-3 col-xs-12 text-left device">--}}
                {{--<a class="device-id" href="/admin/tom/chat/user?device_id={{ $chatUser->device_id }}" target="_blank"> {{ $chatUser->device_id }} </a>--}}
                {{--<div> phone model <i>android version</i> </div>--}}
            {{--</div>--}}
        {{--@endforeach--}}


        <?php $osV['21']='Lollipop 5.0'; $osV['22']='Lollipop 5.1'; $osV['23']='Marshmallow'; $osV['24']='Nougat 7.0'; $osV['25']='Nougat 7.1+'; $osV['26']='Oreo 8.0'; $osV['27']='Oreo 8.1';$osV['28']='Pie 9.0'; $osV['29']='Android 10'; $osV['30']='Android 11'; ?>

        @foreach($users as  $deviceId=>$device)
            <div class="col-md-6 col-md-offset-3 col-xs-12 text-left device">
                <a class="device-id" href="/admin/tom/chat/user?device_id={{ $deviceId }}" target="_blank"> {{ $deviceId }} </a>
                @foreach($device as $info)
                    @if(! $info->seen_at)
                        <!-- i.e. there's unseen msg -->
                        <span class="green-dot"></span>
                        <div> {{ $info->device_name }} <i style="color: #219610">{{ $osV['23'] }}</i> </div>
                        @break
                    @endif
                @endforeach
            </div>
        @endforeach
    </div>
@endsection


@section('js')
    <script>
        $(document).ready(function () {

        });
    </script>
@endsection