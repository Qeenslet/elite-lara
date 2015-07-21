@extends('app')
@section('content')
    <h2>Статистика по базе</h2>
    <ul>
        <li><span class="white">{{$latest['total']}}</span> планет</li>
        <li><span class="white">{{$latest['sys']}}</span> звездных систем</li>
        <li><span class="white">{{$latest['tf']}}</span> пригодных для жизни планет</li>
        <li><span class="white">{{$latest['reg']}}</span> регионов охвачено</li>
        <li><span class="white">{{$latest['latest']}}</span> новых объекта за сутки</li>
    </ul>
<h2>Всего пользователей в базе: {{\App\User::count()}}</h2>
<h2>Всего писем: {{\App\Letter::count()}}</h2>
    <h2>Систем, ожидающих модерации: {{\App\Moderation::count()}}</h2>
    <h3>Пополнение базы за 24 часа</h3>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>
                Имя
            </th>
            <th>
                Добавлено звезд
            </th>
            <th>
                Добавлено планет
            </th>
        </tr>
        <thead>
        <tbody>
            @foreach($users as $user)
                @if($amount=$user->hasFindings($user->id))
            <tr>

                <td>
                {{$user->name}}
                </td>
                <td>
                    {{$amount['stars']}}
                </td>
                <td>
                    {{$amount['planets']}}
                </td>
            </tr>
                @endif
            @endforeach
        </tbody>
    </table>
@stop