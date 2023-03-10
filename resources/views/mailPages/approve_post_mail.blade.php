<html>
<head>
    <title>Approve Post</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    <style>
        #content{
            text-align: center;
            border: 1px solid #dedede;
        }
        .header{
            background-color: rgba(250, 253, 231, 0.8);
            padding: 1em;
            border-bottom: 1px solid #dedede;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        .appname{
            font-weight: bold;
            font-size: 2em;
        }
        .header .p1{
            font-size: 1.3em;
            margin-top: 8px;
        }
        .msg-container{
            padding: 1em 2em;
            text-align: left;
            font-weight: 300;
            font-family: "Raleway", Serif;
        }
        .username{
            text-align: left;
            font-size: 1.3em;
        }
        .msg-content{
            font-size: 1.2em;
        }
        .msg-container .p2{
            margin-top: 2em;
        }
        .msg-content .affiliate-link{
            margin-top: 8px;
            font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
        }
        .footer{
            padding: 4px 2em;
        }
        .footer .p1{
            font-size: 1.3em;
            background-color: #000;
            color: #e6e480;
            padding: 0.5em 0;
            font-family: "Roboto Slab";
            font-weight: 300;
        }
    </style>
</head>
<body>
<div id="content" class="">
    <div class="header">
        <div class="appname">{{ $data['appName'] }}</div>
        <div class="p1">Partner Program</div>
    </div>
    <div class="msg-container">
        <div class="username">Dear {{ $data['userName'] }}</div>
        <div class="msg-content">
            <p>{{ $data['msg'] }}</p>
            <div>
                <div><b>Your affiliate link :</b></div>
                <div class="affiliate-link">
                    <a href="{{ $data['affiliateLink'] }}" target="_blank">{{ $data['affiliateLink'] }}</a>
                </div>
            </div>
        </div>
        <p class="p2">
            Don't hesitate to ask. If you want to learn more just reply this email.
        </p>
    </div>
    <div class="footer">
        <div class="p1">Thank You Partner</div>
    </div>
</div>
</body>
</html>
