<h2 class="white">Star extra data</h2>

<form id="addStar" action="{{route('addStarExtra')}}" method="POST" class="form-inline">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="star_id" value="{{$starId}}">
    <div class="form-group">
        <label for="star_age">Star age, millions of years:</label>
        <input id="star_age" name="age" type="text"
        @if(isset($sData))
               value="{{$sData->age}}"
        @endif>
    </div>
    <div class="form-group">
        <label for="star_mass">Solar masses</label>
        <input id="star_mass" name="smass" type="text"
        @if(isset($sData) && isset($sData->smass))
               value="{{$sData->smass}}">
        @endif>
    </div>
    <div class="form-group">
        <label for="star_rad">Solar radius</label>
        <input id="star_rad" name="srad" type="text"
        @if(isset($sData) && isset($sData->srad))
               value="{{$sData->srad}}">
        @endif>
    </div>
    <div class="form-group">
        <label for="star_temp">Surface temperature, K</label>
        <input id="star_temp" name="temperature" type="text"
        @if(isset($sData) && isset($sData->temperature))
               value="{{$sData->temperature}}">
        @endif>
    </div>
    <div>
        <button type="submit" class="btn btn-warning" id="change_b_star">Add data</button>
    </div>
</form>