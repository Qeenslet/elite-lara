@extends('app')
@section('content')
    <table class="table table-striped">
        <thead>
        <tr>
            <th>
                Адрес
            </th>
            <th>
                Кол-во звезд
            </th>
        </tr>
        <thead>
        <tbody>
    @foreach($selected as $one)
        <tr><td>{{$one->region->name}} {{$one->name}}</td><td>{{$one->stars()->count()}}</td></tr>
    @endforeach
        </tbody>
    </table>
@stop