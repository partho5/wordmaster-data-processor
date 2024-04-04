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
        nav .navbar-nav li a{
            color: #FFFFFF !important;
            font-family: "Lucida Grande", "Lucida Sans Unicode", Verdana, Arial, Helvetica, sans-serif;
        }
        nav .navbar-nav li a:hover{
            background-color: #FFFFFF !important;
            color: #000000 !important;
        }




        .dropdown-submenu {
            position: relative;
                > a::after {
                      display: block;
                      content: "";
                      float: right;
                      width: 0;
                      height: 0;
                      border-color: transparent;
                      border-style: solid;
                      border-width: 4px 0 4px 4px;
                      border-left-color: #000;
                      margin-top: 6px;
                      margin-right: -10px;
                  }
                > ul.dropdown-menu {
                      position: absolute;
                      left: 100%;
                      top: 0;
                      margin-left: 5px;
                  }
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






<!-- navbar -->
<nav class="navbar navbar-default">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="/">{{ env('APP_NAME') }}</a>
    </div>
    <div id="navbar" class="navbar-collapse collapse">
        <ul class="nav navbar-nav">
            <li><a href="/admin/tom">Admin</a></li>
            <li><a href="/admin/tom/visit_log/show">Web Visitor Log</a></li>
            <li><a href="/admin/tom/app_user_activity/show">App User activity</a></li>
            <li><a href="/admin/notific">Notification</a></li>


            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Others<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="/admin/tom/affiliate_approval/show">Affiliate Approval</a></li>
                    <li><a href="{{ route('appUpgradeInstructionPage') }}">Upgrade App Version</a></li>
                    <li><a href="/admin/tom/display_index/show">Display index</a></li>
                    <li><a href="/admin/tom/chat/user/all">Chat List</a></li>
                </ul>
            </li>


            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Backup<span class="caret"></span></a>
                <ul class="dropdown-menu">
                    <li><a href="/test/backup/dropbox" target="_blank" class="">Save to dropbox</a></li>
                    <li><a href="/admin/tom/sentence/search" target="_blank" class="">Search Sentence</a></li>

                    <!--
                    <li class="dropdown-submenu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Submenu</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Erfahrungsberichte</a></li>
                            <li><a href="#">Europäische Kooperationspartner</a></li>
                        </ul>
                    </li>
                    <li class="dropdown-submenu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Submenu</a>
                        <ul class="dropdown-menu">
                            <li><a href="#">Erfahrungsberichte</a></li>
                            <li><a href="#">Europäische Kooperationspartner</a></li>
                        </ul>
                    </li>
                    <li role="separator" class="divider"></li>
                    <li class="dropdown-header">Nav header</li>
                    <li><a href="#">Separated link</a></li>
                    <li><a href="#">One more separated link</a></li>
                    -->

                </ul>
            </li>
        </ul>
    </div>
</nav>











<div class="col-md-12 no-padding col-xs-12" id="body-wrapper">
    @yield('body_container')
</div>

<script>

    jQuery(document).ready(function($){
        $(document).on('click', 'li.dropdown a[data-toggle="dropdown"]', function(event) {
            event.preventDefault();
            var $submenu = $(this).siblings('ul.dropdown-menu');
            $submenu.css('background-color', '#000');
            $submenu.css('color', '#000');
        });


        $('li.dropdown-submenu a[data-toggle="dropdown"]').on('click', function(event) {
            event.preventDefault();
            event.stopPropagation();
            $('li.dropdown-submenu').not($(this).parent()).removeClass('open');
            $(this).parent().toggleClass('open');
        });

    });


    function p(data) {
        console.log(data);
    }
</script>

@yield('js')

</body>
</html>
