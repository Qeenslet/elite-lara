<form class="form-inline" method="POST" action="{{route('express')}}">
    <input type="hidden" value="{{csrf_token()}}" name="_token">
    <div class="form-group">
        <label for="star_select">Star type</label>
        <select id="star_select" name="star" class="middleSelect">
            @foreach (\App\Myclasses\Arrays::allStarsArray(true) as $num => $one)
                <option value="{{$num}}">{{$one}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="distance_sel">Distance:</label>
        <input type="text" id="distance_sel" name="distance">
    </div>
    <div class="form-group">
        <label for="unit_sel">units:</label>
        <select id="unit_sel" name="units">
            <option value="1">AU</option>
            <option value="500">LS</option>
        </select>
    </div>
    <button type="submit" class="btn btn-warning">Search</button>
</form>