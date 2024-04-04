@extends('affiliate.affiliate_base_layout')



@section('title')

    <title>{{ env('APP_NAME') }} Partner Program</title>

@endsection



@section('external_resources')

    <link href="/css/affiliate/dashboard.css" rel="stylesheet">


    <script src="{{ asset('react-components/affiliate/static/js/main.ca27c644.js') }}"></script>



    <link href="https://fonts.googleapis.com/css2?family=Raleway:wght@300&display=swap" rel="stylesheet">

    <!-- https://fonts.google.com/specimen/Raleway?query=raleway -->


    <link href="https://fonts.googleapis.com/css2?family=Monda&display=swap" rel="stylesheet">

    <!-- https://fonts.google.com/specimen/Monda?query=monda -->

@endsection


@section('body_container')


    <div class="section col-xs-12 no-padding" id="content">
        dashboard sales report will be shown here (when becomes available)
    </div>


@endsection







@section('js')

    <!-- https://codepen.io/run-time/pen/XJNXWV -->

    <script type="text/javascript" src="/js/fingerprint.js"></script>
    <script type="text/javascript" src="/js/library.js"></script>



    <script>
        $(document).ready(function () {





            function p(data) {
                console.log(data);
            }


        });

    </script>



@endsection