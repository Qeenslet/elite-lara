@extends('app')
@section('content')
<h2>Всего: {{$total}}</h2>
<h2>Принято в базу: {{$oks}}</h2>
<h2>Ошибок: {{$fails}}</h2>
<h2>Не распознались</h2>
<table class="table table-striped">
    @foreach($repFails as $key=>$one)
      <tr>
          <td>{{$key}}</td><td>{{$one}}</td>
      </tr>
    @endforeach
</table>
<h2>На модерацию</h2>
<table class="table table-striped">
    @foreach($repModer as $key=>$one)
        <tr>
            <td>{{$key}}</td><td>{{$one}}</td>
        </tr>
    @endforeach
</table>
<h2>Аналоги</h2>
<table class="table table-striped">
    @foreach($repSim as $key=>$one)
        <tr>
            <td>{{$key}}</td><td>{{$one}}</td>
        </tr>
    @endforeach
</table>
@stop