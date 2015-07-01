@extends('app')
@section('content')
    <h1>Пользователи</h1>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>
                Имя
            </th>
            <th>
                Допуск к базе
            </th>
            <th>
                Админ
            </th>
            <th>
                Модератор
            </th>
        </tr>
        <thead>
        <tbody>
    @foreach($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>
                    @if($user->roles()->where('id', 1)->first())
                        @if($user->id==1)
                        ---
                        @else
                        <a href="{{route('setrole', ['action'=>'cancel', 'role'=>1, 'user'=>$user->id])}}" class="btn btn-danger" >Лишить доступа</a>
                        @endif
                    @else
                        <a href="{{route('setrole', ['action'=>'give', 'role'=>1, 'user'=>$user->id])}}" class="btn btn-success" >Снять бан</a>
                    @endif
                </td>
                <td>
                    @if($user->roles()->where('id', 2)->first())
                        @if($user->id==1)
                            ---
                        @else
                        <a href="{{route('setrole', ['action'=>'cancel', 'role'=>2, 'user'=>$user->id])}}" class="btn btn-danger" >Разжаловать</a>
                        @endif
                    @else
                        <a href="{{route('setrole', ['action'=>'give', 'role'=>2, 'user'=>$user->id])}}" class="btn btn-success" >Назначить</a>
                    @endif
                </td>
                <td>
                    @if($user->roles()->where('id', 3)->first())
                        @if($user->id==1)
                            ---
                        @else
                        <a href="{{route('setrole', ['action'=>'cancel', 'role'=>3, 'user'=>$user->id])}}" class="btn btn-danger" >Разжаловать</a>
                        @endif
                    @else
                        <a href="{{route('setrole', ['action'=>'give', 'role'=>3, 'user'=>$user->id])}}" class="btn btn-success" >Назначить</a>
                    @endif
                </td>
            </tr>
    @endforeach
        </tbody>
    </table>
@stop