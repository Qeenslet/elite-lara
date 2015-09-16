@extends('eliteRu')
@section('title')
    Графики|@parent
@stop
@section('content')

    <div id="navigation_bar">
        <div id="button_left"><a href="{{route('database', ['chart'=>$navigator['left']])}}"></a></div>
        <div id="button_right"><a href="{{route('database', ['chart'=>$navigator['right']])}}"></a></div>
        <h3 id="db_head">{{$navBar[$chart]}}</h3>
    </div>
<p class="white">Этот раздел выводит различные типы графиков по обнаруженным планетам и звездам. Для перехода к другому типу графика нажимайте горизонтальные  стрелки влево-вправо на навигационной панели сверху. </p>
<hr>
@section('chartforms')
@show
<div id="result">

</div>
@stop
@section('scripts')
    @parent
    <script type="text/javascript" src="/js/ajax.js"></script>
    <script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript" src="/js/gray.js"></script>
    <script type="text/javascript" src="/js/drilldown.js"></script>
    <script>
        function closeInfo()
        {
            $('#chartAbout').slideUp(300);
        }
    </script>
@stop