@extends('administration.index')
@section('title')
    Systems for moderation|@parent
@stop
@section('locale')
    @foreach($forModeration as $one)
        <div class="pointed panel-cabinet" data="{{$one->id}}&_token={{csrf_token()}}">
            <b>{{$one->address}}</b> | CMDR {{$one->user->name}} | {{$status[$one->type]}} | {{Carbon\Carbon::now()->diffInHours($one->created_at)}} hours ago
        </div>
    @endforeach
@stop
@section('scripts')
    @parent
    <script type="text/javascript" src="/js/moderationselect.js"></script>
@stop