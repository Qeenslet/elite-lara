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
            @if(!Auth::check())
                <a href="{{url('auth/login')}}" class="btn bttn btn-success">Вход </a> <a href="{{url('auth/register')}}" class="btn bttn btn-primary"> Регистрация</a>
            @endif
        @show
        <div style="float: right;">
            <div class="dropdown">
                <button class="btn langs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                    Русский
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style="background-color: #d95e21">
                    <li><a href="{{route('lang.switch', 'en')}}">English</a></li>
                </ul>
            </div>
        </div>
        <div class="topmenu">
        @section ('top-menu')
            @if(Auth::check())
                @include('ru.interface.nav-reg')

            @else
                @include('ru.interface.nav-unreg')
            @endif
        @show
        </div>
        <div class="row-eq-height">
            <div class="col-md-4">
                    @section('left-column')
                    @if(Auth::check())
                    <div class="left-top">
                        @include('ru.interface.pilotRank')
                    </div>
                    @endif
                    <div class="left-top">
                        @include('ru.interface.rating')
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
            <div class="col-sm-4">
                <h4>ED Exoplanets</h4>
                <p>Идея и воплощение: </p>
                <p>CMDR <span class="white">Hamster Libre </span></p>
                <p>CMDR <span class="white">Grey Wolfhound</span></p>
                <p>&copy; 2015</p>
            </div>
            <div class="col-sm-5">
                <h4>Подкиньте на хостинг</h4>
                <script src="/js/paypal-button.min.js?merchant=admin@ed-exoplanets.net"
                        data-button="donate"
                        data-name="My product"
                        data-amount="2.00"
                        async
                        ></script>
                <iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/small.xml?account=410011706716098&quickpay=small&yamoney-payment-type=on&button-text=04&button-size=s&button-color=black&targets=%D0%9F%D0%BE%D0%B6%D0%B5%D1%80%D1%82%D0%B2%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B5+%D0%BD%D0%B0+%D1%80%D0%B0%D0%B7%D0%B2%D0%B8%D1%82%D0%B8%D0%B5+%D1%81%D0%B0%D0%B9%D1%82%D0%B0&default-sum=50&successURL=http%3A%2F%2Fed-exoplanets.net%2F" width="156" height="31"></iframe>
                <iframe frameborder="0" allowtransparency="true" scrolling="no" src="https://money.yandex.ru/embed/small.xml?account=410011706716098&quickpay=small&any-card-payment-type=on&button-text=04&button-size=s&button-color=black&targets=%D0%9F%D0%BE%D0%B6%D0%B5%D1%80%D1%82%D0%B2%D0%BE%D0%B2%D0%B0%D0%BD%D0%B8%D0%B5+%D0%BD%D0%B0+%D1%80%D0%B0%D0%B7%D0%B2%D0%B8%D1%82%D0%B8%D0%B5+%D1%81%D0%B0%D0%B9%D1%82%D0%B0&default-sum=50&successURL=http%3A%2F%2Fed-exoplanets.net%2F" width="156" height="31"></iframe>
            </div>
            <div class="col-sm-3">
                <h4>Контакты</h4>
                <p>Email: <a href="mailto:admin@ed-exoplanets.net" class="white">admin@ed-exoplanets.net</a></p>
            </div>
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