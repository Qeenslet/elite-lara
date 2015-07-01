<p>Здесь можно посмотреть кривую распределения любого типа планет, имеющихся в базе по расстоянию от звезды. Можно выбрать тип звезды и ее размер. Разделения на температурные подклассы нет.</p>
<form class="form-inline" method="POST" id="d_query" onsubmit="send('d_query');" action="javascript:void(null);">
    <input type="hidden" value="{{csrf_token()}}" name="_token">
    <div class="form-group">
        <label for="star_select">Тип звезды</label>
        <select id="star_select" name="star">
            <option></option>
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
        <label for="class_select">Размер</label>
        <select id="class_select" name="size">
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
            <option value="3">земные</option>
            <option value="3210">земные и пригодные к ТФ</option>
            <option value="210">пригодные к ТФ без земных</option>
            <option value="4">водные не пригодные к ТФ</option>
            <option value="5">аммиачные</option>
            <option value="543210">все возможные</option>
        </select>
    </div>
    <button type="submit" class="btn btn-warning">Поиск</button>
</form>
