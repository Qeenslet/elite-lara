@extends('elite')
@section('title')
    {{$content->en_name}}|@parent
@stop
@section('content')
    <article>
    <h2 class="inside_headers_white">{{$content->en_name}}</h2>
    {!!$content->en_body!!}
    </article>
@stop