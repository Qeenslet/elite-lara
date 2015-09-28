@extends('elite')
@section ('auth-contol')
    @if(!Auth::check())
        <a href="{{url('auth/login')}}" class="btn bttn btn-success">Вход </a> <a href="{{url('auth/register')}}" class="btn bttn btn-primary"> Регистрация</a>
    @endif
@stop
@section('langChange')
    <div class="dropdown">
        <button class="btn langs dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
            Русский
            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1" style="background-color: #d95e21">
            <li><a href="{{route('lang.switch', 'en')}}">English</a></li>
        </ul>
    </div>
@stop
@section ('top-menu')
    @if(Auth::check())
        @include('ru.interface.nav-reg')

    @else
        @include('ru.interface.nav-unreg')
    @endif
@stop
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
    <div id="tooltip" class='panel-cabinet' style="display: none;">

    </div>
@stop
@section('footer')
    <div class="col-sm-4">
        <h4>ED Exoplanets</h4>
        <p>Идея и воплощение: </p>
        <p>CMDR <span class="white">Hamster Libre </span></p>
        <p>CMDR <span class="white">Grey Wolfhound</span></p>
        <p>&copy; 2015</p>
    </div>
    <div class="col-sm-5">
        <h4>Подкиньте на хостинг</h4>
        <script src="/js/paypal-button.min.js?merchant=koi_1@mail.ru"
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
@stop