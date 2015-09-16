@extends('administration.index')
@section('title')
    Почта|@parent
@stop
@section('locale')
    <div id="navigation_bar">
        <div id="button_left"><a href="{{route('adminmail', ['folder'=>$navigation['left']])}}"></a></div>
        <div id="button_right"><a href="{{route('adminmail', ['folder'=>$navigation['right']])}}"></a></div>
        <h3 id="db_head">{{$navigation['current']}}</h3>
    </div>
    @section('mailbox')
    @show

@stop