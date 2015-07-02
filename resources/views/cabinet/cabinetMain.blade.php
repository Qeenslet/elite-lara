@extends('elite')
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
    <script type="text/javascript" src="/js/navigation.js"></script>
    <script type="text/javascript" src="/js/someAction.js"></script>

@stop