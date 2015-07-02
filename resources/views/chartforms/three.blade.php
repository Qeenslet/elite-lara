<p>На этом типе графиков можно увидеть реальное распределение планет по удалению от звезды.</p>
<form class="form-inline" method="POST" id="orbit_query" onsubmit="send('orbit_query');" action="javascript:void(null);">
    <input type="hidden" value="{{csrf_token()}}" name="_token">
    <div class="form-group">
        <label for="star_select">Тип звезды</label>
        <select id="star_select" name="starOrb">
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