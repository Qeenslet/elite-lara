@extends('cabinet.cabinetMain')
@section('local')
<div class="panel-cabinet">
<h4>тема: <span class="white">{{$letter->header}}</span></h4>
<h4>от кого: <span class="white">{{$letter->isSender->name}}</span></h4>
<hr>
<div id="letterItself">
  {!!$letter->body!!}
</div>

<hr>
<div id="answerButton">
    @if($letter->sender!=Auth::user()->id)
        <button type="submit" class="btn btn-success" onclick="answer();">Ответить</button>
    @endif
    <button type="submit" class="btn btn-warning" onclick="window.history.back();">Назад</button>
        <button type="button" class="btn btn-danger" onclick="someAction('{{route('cabMailDel', ['id'=>$letter->id])}}', 'Удалить?')">Удалить</button>
</div>
<div id="placeForAnswer" style="display: none;">
    <form class="form-horizontal" method="post" action="{{route('sender')}}">
        <input type="hidden" value="{{csrf_token()}}" name="_token">
        <div class="form-group">
            <input type="text" name="reciever" value="{{$letter->sender}}" style="display:none;">
        </div>
        <div class="form-group">
            <input type="text" name="header" value="Re: {{$letter->header}}" style="display:none;">
        </div>
        <div>
            <textarea id="editor" name="body"></textarea>
        </div>
        <button type="submit" class="btn btn-warning">Отправить</button>
    </form>
</div>
</div>
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
    <script>
        function answer() {
            var content='[quote]'+document.getElementById('letterItself').innerHTML+'[/quote]';
            document.getElementById("answerButton").innerHTML='';
            var obj=document.getElementById("placeForAnswer");
            obj.style.display = "block";
            $(function(){
                $('.wysibb-body').html(content);
            });
        }
    </script>
@stop