<form class="form-inline" id='show_planet' method="POST" action="{{route('addPlanet')}}">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="address" value="{{$addrId}}">
    <input type="hidden" name="object" value="{{$type}}">
    <input type="hidden" name="objectId" value="{{$objId}}">
    <h3>Planet data</h3>
    <div class="form-group">
        <label for="planet_sel">Planet type:</label>
        <select id="planet_sel" name="planet">
            @foreach ($planets as $num => $one)
                <option value="{{$num}}">{{$one}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="unit_sel">Distance:</label>
        <select id="unit_sel" name="units">
            <option value="1">AU</option>
            <option value="500">LS</option>
        </select>
    </div>
    <div class="form-group">
        <input type="text" id="distance_sel" name="distance">
    </div>
    <div class="form-group">
        <label for="position_sel">Orbit</label>
        <select name="mark">
            <option value="sin">single</option>
            <option value="bin">binary</option>
            <option value="tri">triple</option>
            <option value="sat">sattelite</option>
            <option value="qua">quadruple</option>

        </select>
    </div>

    <button type="submit" class="btn btn-warning" id="change_b_planet">Add planet</button>
</form>