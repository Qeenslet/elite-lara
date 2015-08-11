@extends('cabinet.cabinetMain')
@section('title')
    Находки|@parent
@stop
@section('local')
    <h3>Добавленные вами в базу данных системы</h3>
    @foreach($findings as $singleSystem)
        <div class="pointed panel-cabinet" data="address={{$singleSystem->address_id}}&user={{Auth::user()->id}}&_token={{csrf_token()}}">
            <b>{{$singleSystem->address->region->name}}</b> {{$singleSystem->address->name}} <span style="float: right">{{\Carbon\Carbon::parse($singleSystem->created_at)->toDayDateTimeString()}}</span>
        </div>
    @endforeach
    {!!$findings->render()!!}
@stop