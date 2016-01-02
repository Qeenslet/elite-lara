@extends('ru.cabinet.cabinetMain')
@section('title')
    Находки|@parent
@stop
@section('local')
    <h3>Добавленные вами в базу данных системы</h3>
    <h4>Фильтр по датам</h4>
    <form class="form-inline" method="GET" action="" id="address_adder">
        <div class="form-group">
            <label for="start">Начало</label>
            <input type="text"  id="start" name="start" value="{{$s}}">
        </div>
        <div class="form-group">
            <label for="end">Конец</label>
            <input type="text"  id="end" name="end" value="{{$e}}">
        </div>
        <div>
            <button type="submit" class="btn btn-warning">Поискh</button>
        </div>
    </form>
    @foreach($findings as $singleSystem)
        <div class="pointed panel-cabinet" data="address={{$singleSystem->address_id}}&user={{Auth::user()->id}}&_token={{csrf_token()}}">
            <b>{{$singleSystem->address->region->name}}</b> {{$singleSystem->address->name}} <span style="float: right">{{\Carbon\Carbon::parse($singleSystem->created_at)->format('d.m.Y / H:i')}}</span>
        </div>
    @endforeach
    {!!$findings->render()!!}
@stop
@section('scripts')
    @parent
    <script>
        $('#start').glDatePicker({dowOffset: 1,
            monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
            dowNames: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб']});
        $('#end').glDatePicker({dowOffset: 1,
            monthNames: ['Январь', 'Февраль', 'Март', 'Апрель', 'Май', 'Июнь', 'Июль', 'Август', 'Сентябрь', 'Октябрь', 'Ноябрь', 'Декабрь'],
            dowNames: ['Вс', 'Пн', 'Вт', 'Ср', 'Чт', 'Пт', 'Сб']});
    </script>
@stop