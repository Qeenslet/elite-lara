@extends('elite')
@section('title')
    {{$content->name}}|@parent
@stop
@section('content')
    <article>
    <h2 class="inside_headers_white">{{$content->name}}</h2>
    {!!$content->body!!}
    </article>
@stop