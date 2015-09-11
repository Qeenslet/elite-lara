<div class="panel-cabinet" id="chartAbout">
    <div style="margin: 5px; width:100%; height: 10%; position: relative; top:1px;"><a href="javascript:closeInfo();" class="info-close-btn"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></div>
<br>
    <p>Функциональный тип графика, демонстрирует размеры зоны обитания  различных типов планет у конкретного типа звезд.</p>
<p>Для работы с графиком, укажите спектральный тип звезды, ее размер(класс светимости) и температурный подкласс, а также интересующий вас тип планеты.</p>
<p>Шаг а.е.  - шаг орбиты. Крупный шаг хорошо показывает тенденцию типичных орбит, с ним четко видны пики обнаружения орбит, но теряется точность отображения в конкретных цифрах, тк данные округляются. Мелкий шаг хорошо выводит данные как есть, с ним четко видны границы зоны обитания, однако пики не такие выразительные.</p>
<p>На графике будут видны предельные размеры орбит, а его пики покажут расстояние от звезды, на котором шанс встретить искомую экзопланету самый высокий.</p>

    <hr>
</div>
<form class="form-inline" method="POST" id="d_query" onsubmit="send('d_query');" action="javascript:void(null);">
    <input type="hidden" value="{{csrf_token()}}" name="_token">
    <div class="form-group">
        <label for="star_select">Тип звезды</label>
        <select id="star_select" name="star">
            @foreach ($count as $num => $one)
                <option value="{{$num}}">{{$one}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="class_select">Температура</label>
        <select id="class_select" name="class">
            <option value="100">не важно</option>
            <option>0</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
        </select>
    </div>
    <div class="form-group">
        <label for="size_select">Размер</label>
        <select id="size_select" name="size">
            <option value="100">не важно</option>
            <option value="5">V</option>
            <option value="4">IV</option>
            <option value="3">III</option>
            <option value="6">VI</option>
        </select>
    </div>
    <div class="form-group">
        <label for="step_select">Шаг а.е.</label>
        <select id="step_select" name="step">
            <option value="0"></option>
            <option>0.05</option>
            <option>0.1</option>
            <option>0.25</option>
            <option>0.5</option>
            <option>1</option>
            <option>2</option>
        </select>
    </div>
    <div class="form-group">
        <label for="planet_select">Планеты</label>
        <select id="planet_select" name="planet" class="largeSelect">
            <option value="543210">все возможные</option>
            <option value="3">земные</option>
            <option value="3210">земные и пригодные к ТФ</option>
            <option value="14">водные всех типов</option>
        </select>
    </div>
    <button type="submit" class="btn btn-warning">Поиск</button>
</form>
<hr>
<script>
    $('#star_select').change(function(){
        var select=$('#star_select').val();
        if(select==15 || select==16){
            $("#class_select").val(100).hide();
            $("#size_select").val(100).hide();
        }
        else {
            $("#class_select").show();
            $("#size_select").show();
        }
    });
</script>