@extends('administration.index')
@section('locale')
    <h2>Поиск данных по системе</h2>
    <form method="get" action="{{route('search')}}" class="form-inline">

        <div class="form-group">
            <label for="region">Адрес:</label>
            <input type="text"
                   class="form_add_1"
                   id="region_add"
                   name="address"
                   value="@if(isset($searchData)){{$searchData['address']}}@endif">
        </div>
        <button type="submit" class="btn btn-warning">Поиск данных</button>
    </form>
    @if(isset($systemD))
        <div class="row" style="margin: 10px;">
            <h2>{{$systemD->fName}}</h2>
            @foreach($systemD->starsIn as $id=>$star)
                <div class="col-md-{{12/count($systemD->starsIn)}}">
                    <div class="panel-cabinet pointed" data="_token={{csrf_token()}}&type=star&id={{$id}}">
                    <img src="/media/stars/{{$systemD->starImages[$id]}}"> {{$star}}
                    </div>
                    @foreach($systemD->planetsIn[$id] as $pId=>$pDesc)
                        <div class="panel-cabinet pointed" data="_token={{csrf_token()}}&type=planet&id={{$pId}}">
                            <img src="/media/planets/{{$systemD->planetImages[$pId]}}"> {{$pDesc}}<br>
                        </div>
                    @endforeach
                </div>
            @endforeach

        </div>
        <button class="btn btn-danger" onclick="someAction('{{route('delete', ['target'=>$systemD->address])}}', 'Удалить?')">Удалить</button>
    @endif
    @if(isset($nothing))
        <script>
            alert('{{$nothing}}}')
        </script>
    @endif
    @if(isset($selRep))
        <script>
            alert('{{$selRep}}')
        </script>
    @endif
@stop
@section('scripts')
    @parent
    <script type="text/javascript" src="/js/searchSelect.js"></script>
@stop