<!Doctype html>
<html lang="ru">
<head>
    <title>
        @section('title')
        {{$title}}
        @show
    </title>
    <meta name="Description" content="">
    <meta charset = "utf-8">
    <meta name="keywords" content="">
    <meta name="">
    @section ('styles')
    <link type="text/css" href="/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link type="text/css" href="/css/style.css" rel="stylesheet" />
    <link type="text/css" href="http://fonts.googleapis.com/css?family=Jura|Play&amp;subset=latin,cyrillic-ext,cyrillic" rel="stylesheet" />
    <link type="text/css" href="/css/default/wbbtheme.css" rel="stylesheet" />
    @show
    @section('top-scripts')
    @show
</head>
<body>
    <div class="container">
        <h1><a href="/" id="header">{{$title}}</a></h1>
        @section ('auth-contol')
            @if(Auth::check())
                <p>CMDR: <span class="white">{{Auth::user()->name}}</span></p>
                @if(Auth::user()->isModerator())
                    <a href="{{route('moderation')}}">Moderation panel </a> |
                @endif
                @if(Auth::user()->isAdmin())
                    <a href="{{route('administration')}}">Control panel </a> |
                @endif
                <a href="{{route('cabinet')}}">Cabinet </a> | <a href="{{url('auth/logout')}}"> Exit</a>
            @else
                <a href="{{url('auth/login')}}">Sign in </a> | <a href="{{url('auth/register')}}"> Registration</a>
            @endif
        @show
        <div style="float: right;">
            <a href="{{route('lang.switch', 'ru')}}">EN <span class="glyphicon glyphicon-arrow-right"></span> RU</a>
        </div>
        <div class="topmenu">
        @section ('top-menu')
            @if(Auth::check())
                @include('interface.nav-reg')

            @else
                @include('interface.nav-unreg')
            @endif
        @show
        </div>
        <div class="row-eq-height">
            <div class="col-md-4">
                    @section('left-column')
                    @if(Auth::check())
                    <div class="left-top">
                        @include('interface.pilotRank')
                    </div>
                    @endif
                    <div class="left-top">
                        @include('interface.rating')
                    </div>
                    <div id="stats">
                    </div>
                    @show
                </div>
                <div class="col-md-8">
                    @yield('content')
            </div>
        </div>
        <div id="footer">
            <p>All rights reserved &copy; 2015</p>
        </div>
    </div>
    @section('scripts')
        <script type="text/javascript" src="/js/jquery-2.1.3.min.js"></script>
        <script type="text/javascript" src="/bootstrap/js/bootstrap.js"></script>
        <script type="text/javascript" src="/js/dbStatUpdater.js"></script>
        <script type="text/javascript" src="/js/cabinet.js"></script>
        <script type="text/javascript" src="/js/jquery.wysibb.min.js"></script>
        <script>
            firstStat=1;
            if(firstStat==1) {
                data='_token={{csrf_token()}}';
                updateStat(data);
                firstStat++;
            }
        </script>
    @show
</body>
@if (isset($loginfo))
    <script>
        alert('{{$loginfo}}');
    </script>
@endif