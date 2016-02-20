@extends('eliteRu')
@section('title')
    {{$content->name}}|@parent
@stop
@section('content')
    @if($content->id == 1)
        @include('ru.templates.express')
    @endif
    <article>
    <h2 class="inside_headers_white">{{$content->name}}</h2>
    {!!$content->body!!}
    </article>
@stop