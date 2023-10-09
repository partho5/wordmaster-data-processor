@extends('admin.base_layout')

@section('title')
    <title>Affiliate Post Approval</title>
@endsection

@section('external_resources')
    <link rel="stylesheet" href="/css/admin/affiliate_approval.css">

    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@300;400;500&display=swap" rel="stylesheet">
@endsection

@section('body_container')
    <div class="col-md-12 text-center">
        <h2><span>Affiliate Post Approval</span></h2>


        <div style="background: rgba(220,218,75,0.2); border: 1px solid #dcdb89; ">
            <div>Gmail API: <b>{{ LaravelGmail::user() }}</b></div>
            @if(LaravelGmail::check())
                <a href="{{ url('oauth/gmail/logout') }}" class="hidden">Logout</a>
            @else
                <a href="{{ url('oauth/gmail') }}">Login</a>
            @endif
        </div>


        <div class="col-md-12 col-xs-12 no-padding">
            @if(count($posts)>0)
            <table class="table text-center">
                <tr>
                    <th class="text-center">Name</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Post Link</th>
                    <th class="text-center">Approval</th>
                </tr>
                @foreach($posts as $post)
                    <tr postId="{{ $post->postId }}" userid="{{ $post->uid }}">
                        <td class="name">{{ $post->name }}</td>
                        <td class="email">
                            <div class="gen-info">
                                <span class="address">{{ $post->email }}</span>
                                <span class="request-time">requested at <span class="date-time">{{ $post->created_at }}</span></span>
                            </div>
                            <textarea class="50" rows="3">{{ $emailMsg }}</textarea>
                            <button class="btn btn-default send">
                                <img src="/images/icon/send_mail.png" class="icon send-mail-icon" alt="">
                                Send Mail & Approve
                            </button>
                        </td>
                        <td class="post-link">
                            <a href="{{ $post->postLink }}" title="{{ $post->postLink }}" target="_blank">{{ substr($post->postLink, 0, 20) }}....</a>
                        </td>
                        <td class="approval-status"></td>
                    </tr>
                @endforeach
            </table>
            @else
                <div>No affiliate posts to approve</div>
            @endif
        </div>
    </div>
@endsection


@section('js')
    <script>
        $(document).ready(function () {

            $('.email button').click(function(){
                const THIS = $(this);
                const postId = $(this).parents('tr').attr('postId');
                const userId = $(this).parents('tr').attr('userid');
                const email = $(this).parents('tr').find('.email').find('.address').text();
                const msg = $(this).parents('tr').find('.email').find('textarea').val();
                const userName = $(this).parents('tr').find('.name').text();

                if(postId && email){
                    $.ajax({
                        url : '/admin/tom/ajax/post/send_approval_mail',
                        type : 'post',
                        data : {
                            '_token' : "{{ csrf_token() }}",
                            userId : userId, postId : postId, email : email, userName : userName, msg : msg
                        }, success : function (response) {
                            console.log(response);
                            if(response === 'ok'){
                                THIS.parents('tr').find('.approval-status').text('Approved');
                                THIS.parents('tr').find('img.send-mail-icon').attr('src', '/images/icon/blue-tick.svg');
                            }
                        }, error : function (error) {
                            console.log("error :");
                            console.log(error);
                            //alert(error);
                        }
                    });
                }else{
                    alert("post id or email missing !");
                }
            });

        });
    </script>
@endsection