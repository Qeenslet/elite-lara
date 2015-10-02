@extends('cabinet.cabinetMain')
@section('local')
    <table style="width: 100%; padding: 5px;">
        <tr>
            <th style="width:30%; padding: 10px"><span class="white">Name</span></th>
            <th style="width:30%; padding: 10px"><span class="white">Points</span></th>
            <th style="width:30%; padding: 10px"><span class="white">Stars</span></th>
            <th style="width:30%; padding: 10px"><span class="white">Planets</span></th>
        </tr>
    @foreach($points as $point)
        <tr>
            <td><h4>{{$point->user->name}}</h4></td>
            <td>{{$point->points}}</td>
            <td>{{$point->stars}}</td>
            <td>{{$point->planets}}</td>
        </tr>

    @endforeach
    </table>
@stop