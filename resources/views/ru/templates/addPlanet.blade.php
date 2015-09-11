<form class="form-inline" id='show_planet' method="POST" action="{{route('addPlanet')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="address" value="{{$addrId}}">
    <input type="hidden" name="object" value="{{$type}}">
    <input type="hidden" name="objectId" value="{{$objId}}">
    <h3>Данные по планете</h3>
    <div class="form-group">
        <label for="planet_sel">Тип планеты:</label>
        <select id="planet_sel" name="planet">
            @foreach ($planets as $num => $one)
                <option value="{{$num}}">{{$one}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="unit_sel">Расстояние:</label>
        <select id="unit_sel" name="units">
            <option value="1">а.е.</option>
            <option value="500">св. сек.</option>
        </select>
    </div>
    <div class="form-group">
        <input type="text" id="distance_sel" name="distance">
    </div>
    <div class="form-group">
        <label for="position_sel">Орбита:</label>
        <select name="mark">
            <option value="sin">одиночная</option>
            <option value="bin">в паре</option>
            <option value="tri">тройная</option>
            <option value="sat">спутник</option>
            <option value="qua">4-е и более</option>

        </select>
    </div>

    <button type="submit" class="btn btn-warning" id="change_b_planet">Добавить планету</button>
</form>