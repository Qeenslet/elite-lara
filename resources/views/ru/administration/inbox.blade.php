@extends('ru.administration.adminmail')
@section('mailbox')
@if (count($errors) > 0)
    @include('ru.errors.display')
@endif
<table width="100%">
    <td width="10%"><span class="white">Метка</span></td>
    <td width="20%"><span class="white">От кого</span></td>
    <td width="50%"><span class="white">Тема</span></td>
    <td width="20%"><span class="white">Дата</span></td></tr>
</table>
<form action="{{route('massDeleteAdmin')}}" method="GET">
@foreach($letters as $letter)
    <div class="elite-checkbox" style="float: left; margin-top: 15px">
            <input type="checkbox" name="{{$letter->id}}" id="l{{$letter->id}}">
            <label for="l{{$letter->id}}"></label>
    </div>
    <div class="letterLine">
        <table width="90%" class="{{$letter->status}}">
            <a href="#">
                <tr onclick="window.location.href='{{url('administration/mail?letter='.$letter->id)}}'; return false">
                    <td width="25%">{{$letter->isSender->name}}</td>
                    <td width="50%">{{$letter->header}}</td>
                    <td width="20%">{{\Carbon\Carbon::parse($letter->created_at)->toDayDateTimeString()}}</td></tr>
            </a>
        </table>
</div>
@endforeach
    <div>
        <button type="submit" class="btn btn-danger">Удалить отмеченные</button>
    </div>
</form>
@stop