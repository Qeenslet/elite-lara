@extends('app')
@section('content')
    <h2>Редактирование текстов сайта</h2>
    <p>Выберите текст для редактирования</p>
    @foreach($texts as $text)
        <div style="margin: 10px">
        <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#collapse_{{$text->id}}" aria-expanded="false" aria-controls="collapse_{{$text->id}}">
            {{$text->name}}
        </button>
            </div>
        <div id="collapse_{{$text->id}}" class="collapse">
        <form class="form-horizontal" method="post" action="{{route('changeText')}}">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" value="{{$text->id}}" name="id">
            <div class="form-group">
                <label for="name_{{$text->id}}" class="col-sm-2 control-label">Заголовок</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="name_{{$text->id}}" name="name" value="{{$text->name}}">
                </div>
            </div>
            <div class="form-group">
                <label for="body_{{$text->id}}" class="col-sm-2 control-label">Содержание</label>
                <div class="col-sm-10">
                    <textarea class="form-control" rows="10" id="body_{{$text->id}}" name="body">{!!$text->body!!}</textarea>
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-2"></div>
                <div class="col-sm-10">
                    <button type="submit" class="btn btn-success">Изменить</button>
                </div>
            </div>

        </form>
        </div>
    @endforeach
@stop