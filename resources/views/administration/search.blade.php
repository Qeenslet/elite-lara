@extends('administration.index')
@section('locale')
    <h2>Поиск данных по системе</h2>
    <hr>
    <form method="get" action="{{route('search')}}" class="form-inline">

        <div class="form-group">
            <label for="region">Адрес:</label>
            <input type="text"
                   class="form_add_1 largeSelect"
                   id="region_add"
                   name="address"
                   value="@if(isset($searchData)){{$searchData['address']}}@endif">
        </div>
        <button type="submit" class="btn btn-warning">Поиск по адресу</button>
    </form>
    <hr>
    <form class="form-inline" method="get" action="{{route('search')}}">
        <div class="form-group">
            <label for="star_select">Тип звезды</label>
            <select id="star_select" name="star">
                @foreach (\App\Myclasses\Arrays::allStarsArray() as $num => $one)
                    <option value="{{$num}}">{{$one}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="class_select">Температура</label>
            <select id="class_select" name="class">
                @for($i=0; $i<10; $i++)
                    <option value="{{$i}}">{{$i}}</option>
                @endfor
            </select>
        </div>
        <div class="form-group">
            <label for="size_select">Размер</label>
            <select id="size_select" name="size">
                @foreach(\App\Myclasses\Arrays::sizeTypeArray() as $key=>$value)
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="planet_select">Планета</label>
            <select id="planet_select" name="planet">
                @foreach(\App\Myclasses\Arrays::planetsForCabinet() as $key=>$value)
                    <option value="{{$key}}">{{$value}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="distance_sel">Расстояние:</label>
            <input type="text" id="distance_sel" name="distance">
        </div>
        <button type="submit" class="btn btn-warning">Поиск по параметрам</button>
    </form>
    <hr>
    <form class="form-inline" method="get" action="{{route('search')}}">
        <div class="form-group">
            <label for="user">Пользователь</label>
            <input type="text"
                   class="form_add_1 largeSelect"
                   id="user"
                   name="user"
                   value="@if(isset($searchStats['user'])){{$searchStats['user']}}@endif">
            <button type="submit" class="btn btn-warning">Поиск по пользователю</button>
        </div>
    </form>
    <hr>
    @if(isset($systemDs))
        <?php
        $iterTotal=1;
        $iterLocal=-9;
        ?>
        @foreach($systemDs as $systemD)
            @if($iterLocal==1)
               <a href="javascript:showMore({{$iterTotal}})" class="btn btn-primary" id="btn{{$iterTotal}}"
               @if($iterTotal>11)
                   style="display:none"
               @endif>Еще {{count($systemDs)-$iterTotal}}</a>
                <article id="ammount{{$iterTotal}}" style="display:none">
            @endif
        <h3><a href="javascript:rolldown('{{$systemD->address}}')">{{$systemD->fName}}</a></h3>
        <div id="addr_{{$systemD->address}}" style="display:none;">
        <div class="row" style="margin: 10px;">
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
        </div>
            @if($iterLocal==10)
                 </article>
                <?php $iterLocal=0; ?>
            @endif
            <?php $iterTotal++;
            $iterLocal++;?>
        @endforeach
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
    <script>
        function rolldown(id)
        {
            $('#addr_'+id).slideToggle();
        }
        function showMore(id)
        {
            $('#ammount'+id).slideDown();
            $('#btn'+id).hide();
            var next=id+10;
            $('#btn'+next).show();
        }
    </script>
@stop