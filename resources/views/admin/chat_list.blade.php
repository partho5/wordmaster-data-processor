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



        @foreach($users as  $deviceId=>$device)
            <div class="col-md-6 col-md-offset-3 col-xs-12 text-left device">
                <a class="device-id" href="/admin/tom/chat/user?device_id={{ $deviceId }}" target="_blank"> {{ $deviceId }} </a>
                @foreach($device as $info)
                    @if(! $info->seen_at)
                        <!-- i.e. there's unseen msg -->
                        <span class="green-dot"></span>
                        <div> {{ $info->device_name }} </div>
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