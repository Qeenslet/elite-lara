@extends('elite')
@section('content')
    <h2>Панель администрирования</h2>
    <div class="cabmenu">
        <?php $admRouts=\App\Myclasses\Arrays::adminRouts();
        $curRoute = \Route::currentRouteName();
        ?>
        @foreach($admRouts as $name =>$value)
            @if($name==$curRoute)
                <a href="{{route($name)}}" id="chosenOne">{{$value}}</a>
            @else
                <a href="{{route($name)}}">{{$value}}</a>
            @endif

        @endforeach
    </div>
    @yield('locale')
@stop
@section('scripts')
    @parent
    <script type="text/javascript" src="/js/moderationselect.js"></script>
    <script type="text/javascript" src="/js/modercharts.js"></script>
    <script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript" src="/js/gray.js"></script>
    <script type="text/javascript" src="/js/drilldown.js"></script>
    <script type="text/javascript" src="/js/someAction.js"></script>
    <script type="text/javascript" src="/js/navigation.js"></script>

@stop