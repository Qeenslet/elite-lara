<p>Здесь можно увидеть процентное распределение планет определенных видов в зависимости от типов, размеров и температурных характеристик звезд.</p>
<form class="form-inline" method="POST" id="where_query" onsubmit="send('where_query');" action="javascript:void(null);">
    <input type="hidden" value="{{csrf_token()}}" name="_token">
    <div class="form-group">
        <label for="style_select">Планеты</label>
        <select id="style_select" name="style" class="largeSelect">
            <option selected="selected"></option>
            <option value="1">Все пригодные для жизни и ТФ</option>
            <option value="2">Т-металлик</option>
            <option value="3">Т-водные</option>
            <option value="4">Водные</option>
            <option value="5">Аммиачные</option>
            <option value="6">Земного типа</option>
        </select>
    </div>
    <button type="submit" class="btn btn-warning" id="change_b">Поиск</button>
</form>