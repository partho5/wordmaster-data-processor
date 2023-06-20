<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>যে 330 টি word থেকে সবচেয়ে বেশি কমন আসে</title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

    <style>
        #download{
            margin-top: 2em;
        }
        #download .btn{
            background-color: #00aa11;
            padding: 0.4em 2em;
        }
        #download a{
            text-decoration: none;
            color: #fff;
        }
        .scr-shot{
            margin-top:1em;
            border: 1px solid #ddd;
        }
        .dn-status{
            display: none;
        }
    </style>
</head>
<body>

<div class="container">
    <div class="col-md-12 text-center">
        <h2>যে 330 টি word থেকে সবচেয়ে বেশি কমন আসে</h2>

        <div id="download">
            <div class="btn">
                <a href="?type=1">Download pdf</a>
            </div>
            <div class="dn-status">Downloading...</div>
        </div>
        <div class="col-md-12 text-center scr-shot">
            <img src="/images/330words.png" class="img-responsive center-block" alt="">
        </div>
    </div>
</div>

<script type="text/javascript" src="/js/fingerprint.js"></script>
<script type="text/javascript" src="/js/library.js"></script>
<script>
    $(document).ready(function () {
        $('#download .btn').click(function () {
            $('.dn-status').fadeIn();
            setTimeout(function () {
                $('.dn-status').hide();
            }, 2000);

            //save download log
            var fp = new Fingerprint({

                canvas: true,

                ie_activex: true,

                screen_resolution: true

            });



            var fingerprint = fp.get();
            setCookie("visitorLogId", fingerprint);
            var screenSize = screen.width+'x'+screen.height;

            $.ajax({
                url : "/ajax/visit_log/save",
                type : "post",
                async : true,
                data : {
                    _token : "{{ csrf_token() }}", visitorLogId : getCookie("visitorLogId"),
                    current_time : Date.now(), browser : navigator.userAgent,
                    url : window.location.pathname, referredBy : "", screenSize : screenSize,
                },
                success : function (response) {
                    console.log(response);
                },error: function (error) {}
            });


        });
    });
</script>
</body>
</html>