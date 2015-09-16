@extends('administration.adminmail')
@section('mailbox')
<table width="100%">
    <td width="30%"><span class="white">To whom</span></td>
    <td width="50%"><span class="white">Topic</span></td>
    <td width="20%"><span class="white">Date</span></td></tr>
</table>
@foreach($letters as $letter)
    <div class="letterLine">
        <table width="100%">
            <a href="#">
                <tr onclick="window.location.href='{{url('administration/mail?letter='.$letter->id)}}'; return false">
                    <td width="25%">{{$letter->isReciever->name}}</td>
                    <td width="50%">{{$letter->header}}</td>
                    <td width="20%">{{\Carbon\Carbon::parse($letter->created_at)->toDayDateTimeString()}}</td></tr>
            </a>
        </table>
    </div>
@endforeach
    @stop