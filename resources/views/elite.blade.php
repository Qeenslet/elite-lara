<!Doctype html>
<html lang="ru">
<head>
    <title>
        @section('title')
            ED Exoplanets
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
        <link rel="shortcut icon" href="/media/favicon.ico" type="image/x-icon" />
    @show

    <!--include('counter')-->
</head>
<body>
    <div class="container">
        <img src="/media/site_logo.png" style="float:left; margin: 5px;"><h1><a href="/" id="header">ED Exoplanets</a></h1>
        @section ('auth-contol')
            @if(!Auth::check())
                <a href="{{url('auth/login')}}" class="btn bttn btn-success">Sign in </a> <a href="{{url('auth/register')}}" class="btn bttn btn-primary"> Registration</a>
            @endif
        @show
        <div style="float: right;">
            @section('langChange')
                <div class="dropdown">
                    <button class="btn langs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                        English
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style="background-color: #d95e21">
                        <li><a href="{{route('lang.switch', 'ru')}}">Русский</a></li>
                    </ul>
                </div>
            @show
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
                        <div id="tooltip" class='panel-cabinet' style="display: none;">

                        </div>
                    @show
                </div>
                <div class="col-md-8">
                    @yield('content')
            </div>
        </div>
        <div id="footer">
            @section('footer')
                <div class="col-sm-4">
                    <h4>ED Exoplanets</h4>
                    <p>The idea and realisation: </p>
                    <p>CMDR <span class="white">Hamster Libre </span></p>
                    <p>CMDR <span class="white">Grey Wolfhound</span></p>
                    <p>&copy; 2015</p>
                </div>
                <div class="col-sm-5">
                    <h4>Help us get better</h4>
                    <script src="/js/paypal-button.min.js?merchant=koi_1@mail.ru"
                        data-button="donate"
                        data-name="My product"
                        data-amount="2.00"
                        async
                    ></script>
                </div>
                <div class="col-sm-3">
                    <h4>Contact us</h4>
                    <p>Email: <a href="mailto:admin@ed-exoplanets.net" class="white">admin@ed-exoplanets.net</a></p>
                </div>
            @show
        </div>
    </div>
    @section('scripts')
        <script type="text/javascript" src="/js/jquery-2.1.3.min.js"></script>
        <script type="text/javascript" src="/bootstrap/js/bootstrap.js"></script>
        <script type="text/javascript" src="/js/dbStatUpdater.js"></script>
        <script type="text/javascript" src="/js/cabinet.js"></script>
        <script type="text/javascript" src="/js/jquery.wysibb.min.js"></script>
        <script type="text/javascript" src="/js/wallpaperChanger.js"></script>
        <script>
            changeBack();
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