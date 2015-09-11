@extends('app')
@section('content')
    <form method="post" action="{{route('starpos')}}" class="form-inline">
        <input type="hidden" value="{{csrf_token()}}" name="_token">
    <table class="table table-striped">
        <thead>
        <tr>
            <th>
                Адрес
            </th>
            <th>
                Кол-во звезд
            </th>
            <th>
                Звезды
            </th>
        </tr>
        <thead>
        <tbody>
    @foreach($selected as $one)
        <tr>
            <td>{{$one->region->name}} {{$one->name}}</td>
            <td>{{$one->stars()->count()}}</td>
            <td>
                @foreach($one->stars()->get() as $star)
                    {{$starNames[$star->star]}}{{$star->class}} {{$sizeNames[$star->size]}}
                        <input type="text" class="form-control" name="{{$star->id}}">
                    <br>
                @endforeach
            </td>
        </tr>
    @endforeach
        </tbody>
    </table>
        <button type="submit" class="btn btn-success">Изменить</button>
    </form>
@stop