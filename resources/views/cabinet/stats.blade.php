@extends('cabinet.cabinetMain')
@section('local')
    <div class="panel-cabinet">
        <img src="/media/{{$myRank->logo}}" alt="rank" style="float:left;">
        <h4 class="rank">{{\Auth::user()->name}}</h4>
        <h4 class="rank">{{$myRank->rank}}</h4>
        <h5 class="rank">баллов: {{$myRank->scores}}</h5>
        <h3>Добавлено в базу данных:</h3>
        <p>Звезд: {{$myRank->stars}}</p>
        <p>Планет: {{$myRank->planets}}</p>
        <h4 class="white">Прогресс до следующего ранга</h4>
        <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="{{$myRank->progression}}" aria-valuemin="0" aria-valuemax="100" style="width:{{$myRank->progression}}%;">
                {{$myRank->progression}}%
            </div>
        </div>
    </div>
@stop