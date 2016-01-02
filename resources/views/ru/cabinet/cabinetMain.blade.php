@extends('eliteRu')
@section('title')
    Кабинет|@parent
@stop
@section('styles')
    @parent
    <link href="/time/styles/glDatePicker.default.css" rel="stylesheet" type="text/css">
@stop
@section('content')
    <h2>Личный кабинет</h2>
    <div class="cabmenu">
        <?php $cabRouts=\App\Myclasses\Arrays::cabinetRouts();
              $curRoute = \Route::currentRouteName();
        ?>
        @foreach($cabRouts as $name =>$value)
            @if($name==$curRoute)
                    <a href="{{route($name)}}" id="chosenOne">{{$value}}</a>
                @else
                    <a href="{{route($name)}}">{{$value}}</a>
                @endif

        @endforeach
    </div>
    @yield('local')
@stop
@section('scripts')
    @parent
    <script type="text/javascript" src="/js/cabinetselect.js"></script>
    <script type="text/javascript" src="/js/someAction.js"></script>
    <script src="/time/glDatePicker.min.js"></script>

@stop