@extends('cabinet.cabinetMain')
@section('title')
    Mail|@parent
@stop
@section('local')
    <div id="navigation_bar">
        <div id="button_left"><a href="{{route('usermail', ['folder'=>$navigation['left']])}}"></a></div>
        <div id="button_right"><a href="{{route('usermail', ['folder'=>$navigation['right']])}}"></a></div>
        <h3 id="db_head">{{$navigation['current']}}</h3>
    </div>

    @section('mailbox')

    @show
@stop