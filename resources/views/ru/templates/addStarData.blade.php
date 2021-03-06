<h2 class="white">Дополнительные данные по звезде</h2>
<form id="addStar" action="{{route('addStarExtra')}}" method="POST" class="form-inline">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="star_id" value="{{$starId}}">
    <div class="form-group">
        <label for="star_age">Возраст, в миллионах лет</label>
        <input id="star_age" name="age" type="text"
        @if(isset($sData))
               value="{{$sData->age}}"
        @endif>
    </div>
    <div class="form-group">
        <label for="star_mass">Солнечных масс</label>
        <input id="star_mass" name="smass" type="text"
        @if(isset($sData) && isset($sData->smass))
               value="{{$sData->smass}}">
        @endif
    </div>
    <div class="form-group">
        <label for="star_rad">Солнечных радиусов</label>
        <input id="star_rad" name="srad" type="text"
        @if(isset($sData) && isset($sData->srad))
               value="{{$sData->srad}}">
        @endif
    </div>
    <div class="form-group">
        <label for="star_temp">Температура поверхности, K</label>
        <input id="star_temp" name="temperature" type="text"
        @if(isset($sData) && isset($sData->temperature))
               value="{{$sData->temperature}}">
        @endif
    </div>
    <div>
        <button type="submit" class="btn btn-warning" id="change_b_star">Добавить данные</button>
    </div>
</form>