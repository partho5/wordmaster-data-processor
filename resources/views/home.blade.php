@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">

                {{--<div class="card-header">{{ __('Dashboard') }}</div>--}}

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{--{{ __('You are logged in!') }}--}}
                        {{--<hr>--}}

                        <div class="">
                            <p style="font-size: 1.5em">
                                Now go to <a href="{{ route('affiliateDashboard') }}">Partner Program</a>
                            </p>
                        </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
