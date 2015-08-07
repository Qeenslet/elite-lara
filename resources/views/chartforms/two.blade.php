<div class="panel-cabinet" id="chartAbout">
    <div style="margin: 5px; width:100%; height: 10%; position: relative; top:1px;"><a href="javascript:closeInfo();" class="info-close-btn"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></div>
    <br>
    <p>Круговая диаграмма отображает количество обнарухенных  экзопланет возле каждого типа звезды , и сравнивает их с другими звездами.</p>
    <p>Для начала работы укажите тип экзопланет.</p>
    <p>График интерактивный, имеет три уровня вложенности. Кликните курсором мыши по интересующей вас части круговой диаграммы  и перейдите на более детализированный уровень по данному типу звезды. Кнопка "Назад" вернет вас на уровень выше.</p>
    <p>На первом уровне отображается соотношение обнаруженных орбит среди звезд разделенных по спектральному  типу, без учета размера(класса светимости) и температурного подкласса.</p>
    <p>На втором уровне отображается распределение обнаруженных планет внутри выбранного спектрального типа звезды в зависимости от  размера(класса светимости) звезды.</p>
    <p>На третьем уровне выбран спектральный тип звезды, ее размер (класс светимости) и теперь отображается распределение планет в зависимости от температурного подкласса.</p>

    <hr>
</div>
<form class="form-inline" method="POST" id="where_query" onsubmit="send('where_query');" action="javascript:void(null);">
    <input type="hidden" value="{{csrf_token()}}" name="_token">
    <div class="form-group">
        <label for="style_select">Планеты</label>
        <select id="style_select" name="style" class="largeSelect">
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
<hr>