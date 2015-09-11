@extends('cabinet.cabinetMain')
@section('title')
    Discoveries|@parent
@stop
@section('local')
    <h3>The systems you added to database</h3>
    @foreach($findings as $singleSystem)
        <div class="pointed panel-cabinet" data="address={{$singleSystem->address_id}}&user={{Auth::user()->id}}&_token={{csrf_token()}}">
            <b>{{$singleSystem->address->region->name}}</b> {{$singleSystem->address->name}} <span style="float: right">{{\Carbon\Carbon::parse($singleSystem->created_at)->toDayDateTimeString()}}</span>
        </div>
    @endforeach
    {!!$findings->render()!!}
@stop