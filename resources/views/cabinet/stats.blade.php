@extends('cabinet.cabinetMain')
@section('local')
    <div class="panel-cabinet">
        <img src="/media/{{$myRank->logo}}" alt="rank" style="float:left;">
        <h4 class="rank">{{\Auth::user()->name}}</h4>
        <h4 class="rank">{{$myRank->rank}}</h4>
        <h5 class="rank">points: {{$myRank->scores}}</h5>
        <h3>Added to the database:</h3>
        <p>Stars: {{$myRank->stars}}</p>
        <p>Planets: {{$myRank->planets}}</p>
        <h4 class="white">Progress to the next rank</h4>
        <div class="progress">
            <div class="progress-bar" role="progressbar" aria-valuenow="{{$myRank->progression}}" aria-valuemin="0" aria-valuemax="100" style="width:{{$myRank->progression}}%;">
                {{$myRank->progression}}%
            </div>
        </div>
    </div>
@stop