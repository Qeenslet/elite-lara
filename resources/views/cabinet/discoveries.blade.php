@extends('cabinet.cabinetMain')
@section('title')
    Discoveries|@parent
@stop
@section('local')
    <h3>The systems you added to database</h3>
    <h4>Extra filters</h4>
    <form class="form-inline" method="GET" action="" id="address_adder">
        <div class="form-group">
            <label for="start">Start date</label>
            <input type="text"  id="start" name="start" value="{{$s}}">
        </div>
        <div class="form-group">
            <label for="end">End date</label>
            <input type="text"  id="end" name="end" value="{{$e}}">
        </div>
        <div>
            <button type="submit" class="btn btn-warning">Search</button>
        </div>
    </form>
    @foreach($findings as $singleSystem)
        <div class="pointed panel-cabinet" data="address={{$singleSystem->address_id}}&user={{Auth::user()->id}}&_token={{csrf_token()}}">
            <b>{{$singleSystem->address->region->name}}</b> {{$singleSystem->address->name}} <span style="float: right">{{\Carbon\Carbon::parse($singleSystem->created_at)->toDayDateTimeString()}}</span>
        </div>
    @endforeach
    {!!$findings->render()!!}
@stop
@section('scripts')
    @parent
    <script>
        $('#start').glDatePicker();
        $('#end').glDatePicker();
    </script>
@stop