@extends('ru.templates.database')
@section('chartforms')
<div class="panel-cabinet" id="chartAbout">
    <div style="margin: 5px; width:100%; height: 10%; position: relative; top:1px;"><a href="javascript:closeInfo();" class="info-close-btn"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></div>
    <br>
    <p>Этот тип графика отображает каждую обнаруженную орбиту отдельной точкой, цветом, соответствующим  типу планеты, и предназначен для отборажения информации по звездам с малым количеством статистики, недостаточным для постройки функционального графика. </p>
    <p>Здесь также можно посмотреть распределение орбит внутри температурного подкласса.</p>
    <p>Для работы с графиком укажите спетральный тип звезды, ее температурный подкласс и размер(класс светимости).</p>
    <p>Присутствует функция зума. Любую зону на графике можно увеличить, выделив область и удерживая при этом нажатой левую клавишу мыши -  ака резиновая рамка.</p>
    <hr>
</div>
<form class="form-inline" method="POST" id="orbit_query" onsubmit="send('orbit_query');" action="javascript:void(null);">
    <input type="hidden" value="{{csrf_token()}}" name="_token">
    <div class="form-group">
        <label for="star_select">Тип звезды</label>
        <select id="star_select" name="starOrb" class="middleSelect">
            @foreach ($count as $num => $one)
                <option value="{{$num}}">{{$one}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="class_select">Температурный подкласс</label>
        <select id="class_select" name="classOrb">
            <option value="999">не важно</option>
            <?php for($i=0; $i<10; $i++) {
                echo "<option value='$i'>$i</option>";
            }?>
        </select>
    </div>
    <div class="form-group">
        <label for="size_select">Размер</label>
        <select id="size_select" name="sizeOrb">
            <option value="999">не важно</option>
            <option value="5">V</option>
            <option value="4">IV</option>
            <option value="3">III</option>
            <option value="6">VI</option>
        </select>
    </div>
    <button type="submit" class="btn btn-warning" id="change_b">Поиск</button>
</form>
<hr>
@stop
@section('scripts')
    @parent
<script>
    $('#star_select').change(function(){
        var select=$('#star_select').val();
        if(select==15 || select==16){
            $("#class_select").val(999).hide();
            $("#size_select").val(999).hide();
        }
        else {
            $("#class_select").show();
            $("#size_select").show();
        }
    })
</script>
    @stop