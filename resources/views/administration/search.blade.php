@extends('administration.index')
@section('locale')
    <h2>Поиск данных по системе</h2>
    <form method="post" action="{{route('search')}}" class="form-inline">
        <input type="hidden" value="{{csrf_token()}}" name="_token">
        <div class="form-group">
            <label for="region">Регион:</label>
            <input type="text" class="form_add_1" id="region_add" name="region" placeholder="Plaa Trua" list="regions" autocomplete="on" value="{{ old('region') }}">
            <datalist id="regions">
                @foreach($regions as $one)
                    <option>{{$one->name}}</option>
                @endforeach
            </datalist>
        </div>
        <div class="form-group">
            <label for="code">Код:</label>
            <input type="text" class="form_add_1" id="code" name="code" placeholder="EG-Y D76" value="{{ old('code') }}">
        </div>
        <button type="submit" class="btn btn-warning">Поиск данных</button>
    </form>
    @if(isset($systemD))
        <div class="row" style="margin: 10px;">
            <h2>Ранее в системе было найдено:</h2>
            @foreach($systemD->starsIn as $id=>$star)
                <div class="col-md-{{12/count($systemD->starsIn)}}">
                    <img src="/media/stars/{{$systemD->starImages[$id]}}"> {{$star}}
                    <br>
                    @foreach($systemD->planetsIn[$id] as $pId=>$pDesc)
                        <div class="panel-cabinet">
                            <img src="/media/planets/{{$systemD->planetImages[$pId]}}"> {{$pDesc}}<br>
                        </div>
                    @endforeach
                </div>
            @endforeach

        </div>
    @endif
    @if(isset($nothing))
        <script>
            alert('{{$nothing}}}')
        </script>
    @endif
@stop