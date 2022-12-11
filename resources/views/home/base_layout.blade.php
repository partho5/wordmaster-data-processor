<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

    @yield('title')

    <!-- development time only -->
    <link rel="stylesheet" href="/bootstrap/bootstrap.min.css">
    <script src="/bootstrap/jquery-1.12.4.min.js"></script>
    <script src="/bootstrap/bootstrap.min.js"></script>

    @yield('external_resources')

    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Langar&display=swap" rel="stylesheet">
    <!-- font-family: 'Langar', cursive; -->

    <link href="https://fonts.googleapis.com/css2?family=Zilla+Slab&display=swap" rel="stylesheet">
    <!-- font-family: 'Zilla Slab', serif; -->

    <style>
        .navbar{
            background-color: #000000;
            border-radius: 0;
        }
        .navbar-brand{
            font-size: 1.2em;
            color: #FFFFFF !important;
            font-family: Comic Sans MS;
        }
        .navbar-brand:hover{
        //color: #0000f2 !important;
        }
        nav .navbar-nav li a{
            color: #FFFFFF !important;
            font-size: 1em ;
            font-family: "Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
        }
        nav .navbar-nav li a:hover{
            background-color: #FFFFFF !important;
            color: #000000 !important;
        }
        .no-padding{
            margin: 0;
            padding: 0;
        }
        .vcenter{
            display: inline-block;
            vertical-align: middle;
            float: none;
        }
    </style>

</head>
<body>

<nav class="navbar navbar-inverse better-bootstrap-nav-left" >
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar"> <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
            <span class="navbar-brand" href="/">{{ env('APP_NAME') }}</span>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="/download">Download {{ env('APP_NAME') }}</a></li>
            </ul>
        </div>
        <!--/.nav-collapse -->
    </div>
    <!--/.container-fluid -->
</nav>

<div class="col-md-12 no-padding col-xs-12" id="body-wrapper">
    <div class="col-md-8 col-md-offset-2" style="padding: 0px">
        @yield('body_container')
    </div>
</div>

<script>
    function p(data) {
        console.log(data);
    }
</script>

@yield('js')

</body>
</html>
