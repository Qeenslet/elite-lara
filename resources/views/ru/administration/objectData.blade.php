<h3 class="white">Редкатирование объекта</h3>
<h4 class="white">Изменение</h4>
@if($data['type']=='star')
    <?php
    $starData=\App\Myclasses\StarInfo::getFromDb($data['id']);
    $stars=\App\Myclasses\Arrays::allStarsArray(true);
    $sizes=\App\Myclasses\Arrays::sizeTypeArray();
    ?>
    <h5>Предоставил данные: <span class="white">{{$starData->user->name}}</span></h5>
    <form class="form-inline" method="get" action="{{route('changeObject')}}">
        <input type="hidden" value="{{$data['id']}}" name="id">
        <input type="hidden" value="star" name="type">
        <input type="hidden" value="change" name="action">
        <label for="starD"> Звезда:</label>
        <select name="star" id="starD">
            <option value="{{$starData->star}}">{{$stars[$starData->star]}}</option>
            @foreach($stars as $key=>$value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        </select>
        <label for="classD"> Класс</label>
        <select name="class" id="classD">
            <option>{{$starData->class}}</option>
            @for($n=0; $n<10; $n++)
                <option value="{{$n}}">{{$n}}</option>
            @endfor
        </select>
        <label for="sizeD"> Размер</label>
        <select name="size" id="sizeD">
            <option value="{{$starData->size}}">{{$sizes[$starData->size]}}</option>
            @foreach($sizes as $key=>$value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        </select>
        <label for="codeD"> Код в системе</label>
        <input type="text" name="code" value="{{$starData->code}}" id="codeD">
        <button type="submit" class="btn btn-warning">Изменить</button>
    </form>
    <h4 class="white">Удаление</h4>
    <form method="get" action="{{route('changeObject')}}">
        <input type="hidden" value="{{$data['id']}}" name="id">
        <input type="hidden" value="star" name="type">
        <input type="hidden" value="delete" name="action">
        <button type="submit" class="btn btn-danger">Удалить</button>
    </form>
@endif

@if($data['type'] == 'multi')
    <?php
    $centerData=\App\Baricenter::find($data['id']);
    $markedStars = $centerData->stars()->get();
    $allStars = $centerData->address->stars()->get();
    ?>
    <form class="form-inline" method="get" action="{{route('changeObject')}}">
        <input type="hidden" value="{{$data['id']}}" name="id">
        <input type="hidden" value="{{$data['type']}}" name="type">
        <input type="hidden" value="change" name="action">
        <p>Звезды в барицентре</p>
        <ul>
            @foreach($markedStars as $star)
                <li>{{\App\Myclasses\Arrays::nameStar($star)}}</li>
            @endforeach
        </ul>
        <label for="stars">Новые звезды для барицентра</label>
        <select name="stars[]" id="stars" multiple="multiple">
            @foreach($allStars as $star)
                <option value="{{$star->id}}">{{\App\Myclasses\Arrays::nameStar($star)}}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-warning">Изменить</button>
    </form>
    <h4 class="white">Удаление</h4>
    <form method="get" action="{{route('changeObject')}}">
        <input type="hidden" value="{{$data['id']}}" name="id">
        <input type="hidden" value="{{$data['type']}}" name="type">
        <input type="hidden" value="delete" name="action">
        <button type="submit" class="btn btn-danger">Удалить</button>
    </form>
@endif

@if($data['type'] == 'planet' || $data['type'] == 'bari')
    <?php
    switch($data['type'])
    {
        case 'planet':
            $planetData=\App\Planet::find($data['id']);
            break;
        default:
            $planetData=\App\Bariplanet::find($data['id']);
            break;
    }
    $planets=\App\Myclasses\Arrays::planetsForCabinet();
    ?>
    <h5>Предоставил данные: <span class="white">{{$planetData->user->name}}</span></h5>
    <form class="form-inline" method="get" action="{{route('changeObject')}}">
        <input type="hidden" value="{{$data['id']}}" name="id">
        <input type="hidden" value="{{$data['type']}}" name="type">
        <input type="hidden" value="change" name="action">
        <label for="planetD">Планета</label>
        <select name="planet" id="planetD">
            <option value="{{$planetData->planet}}">{{$planets[$planetData->planet]}}</option>
            @foreach($planets as $key=>$value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        </select>
        <label for="distanceD">Расстояние</label>
        <input type="text" name="distance" value="{{$planetData->distance}}" id="distanceD">
        <label for="markD">Орбита</label>
        <select name="mark" id="markD">
            <option>{{$planetData->mark}}</option>
            <option>sin</option>
            <option>bin</option>
            <option>tri</option>
            <option>qua</option>
            <option>sat</option>
        </select>
        @if($data['type'] == 'planet')
            <label for="showHide">Настройки индексации</label>
            <select name="show" id="showHide" class="middleSelect">
                @if($planetData->show == 'true')
                    <option value="true">Оставить видимой</option>
                    <option value="false">Спрятать</option>
                @else
                    <option value="false">Оставить спрятанной</option>
                    <option value="true">Открыть для индексации</option>
                @endif

            </select>
        @endif
        <button type="submit" class="btn btn-warning">Изменить</button>
    </form>
    <h4 class="white">Удаление</h4>
    <form method="get" action="{{route('changeObject')}}">
        <input type="hidden" value="{{$data['id']}}" name="id">
        <input type="hidden" value="{{$data['type']}}" name="type">
        <input type="hidden" value="delete" name="action">
        <button type="submit" class="btn btn-danger">Удалить</button>
    </form>
@endif