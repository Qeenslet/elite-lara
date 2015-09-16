@extends('ru.cabinet.usermail')
@section('mailbox')
<form class="form-horizontal" method="post" action="{{route('sender')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <div class="form-group">
        <label for="whom">Кому:</label>
        <input type="text" id="whom" name="reciever" list="pilots" autocomplete="on">
        <datalist id="pilots">
            @foreach($users as $user)
                <option>{{$user->name}}</option>
            @endforeach
        </datalist>
    </div>
    <div class="form-group">
        <label for="subject">Тема:</label>
        <input type="text" id="subject" name="header" placeholder="Без темы">
    </div>
    <div>
        <textarea id="editor" name="body"></textarea>
    </div>
    <button type="submit" class="btn btn-warning">Отправить</button>
</form>
@stop
@section('scripts')
    @parent
    <script>
        var wbbOpt = {
            buttons: "bold,italic,underline,|,img,link,|,quote"
        }
        $(function() {
            $("#editor").wysibb(wbbOpt);
        })
    </script>
@stop