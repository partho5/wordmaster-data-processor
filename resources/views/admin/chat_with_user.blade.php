@extends('admin.base_layout')

@section('title')
    <title>Chat</title>
@endsection

@section('external_resources')
    <link rel="stylesheet" href="/css/admin/chat_with_user.css">
@endsection

@section('body_container')
    <div class="col-md-12 text-center no-padding">
        <div id="chat-container" class="col-xs-12 no-padding text-left">
            @foreach($chat as  $msg)
                @if($msg->from_user_id)
                    <span class="hidden" id="user-id">{{ $msg->from_user_id }}</span>

                    <div class="col-xs-12  user-msg-wrapper">
                        <div class="col-xs-2 no-padding about-msg">
                            <span class="time">12:34 pm &nbsp; </span>
                            <span class="seen"></span>
                        </div>

                        <div class="single-msg col-xs-10">
                            <span class="username-label">User</span>
                            <span class="msg"> {{ $msg->msg }} </span>
                        </div>
                    </div>
                @else
                    <div class="col-xs-12 admin-msg-wrapper">
                        <div class="single-msg col-xs-10">
                            <span class="username-label">Admin</span>
                            <span class="msg"> {{ $msg->msg }} </span>
                        </div>

                        <div class="col-xs-2 no-padding about-msg">
                            <span class="time">&nbsp; 2:34 pm</span>
                            <span class="seen"></span>
                        </div>
                    </div>
                @endif
            @endforeach
        </div>


        <div id="write-field-wrapper" class="col-xs-12 ">
            <div class="col-xs-10 no-padding">
                <textarea  id="msg-field" rows="2" autofocus="true" class="form-control"></textarea>
            </div>
            <div class="col-xs-2 no-padding" id="send-btn">
                <div class="btn">send</div>
            </div>
        </div>

    </div>
@endsection


@section('js')
    <script>
        $(document).ready(function () {
            $('#send-btn').click(function () {
                var msg = $('#msg-field').val();
                if(msg){
                    var dom = "<div class=\"col-xs-12 admin-msg-wrapper\">\n" +
                        "                        <div class=\"single-msg col-xs-10\">\n" +
                        "                            <span class=\"username-label\">Admin</span>\n" +
                        "                            <span class=\"msg\"> "+msg+" </span>\n" +
                        "                        </div>\n" +
                        "\n" +
                        "                        <div class=\"col-xs-2 no-padding about-msg\">\n" +
                        "                            <span class=\"time\">&nbsp;just now</span>\n" +
                        "                        </div>\n" +
                        "                    </div>";
                    $('#chat-container').append(dom);
                    $('#msg-field').val('');
                    sendMsgToServer(msg);
                }
            });

            function sendMsgToServer(msg) {
                $.ajax({
                    url : '/chat/insert/adminMsg',
                    type : 'post',
                    data : {
                        msg : msg, user_id : $('#user-id').text().trim()
                    }, success : function (response) {
                        p(response);
                    }, error : function (err) {
                        p("ajax sendMsgToServer() "+err);
                    }
                });
            }
        });
    </script>
@endsection