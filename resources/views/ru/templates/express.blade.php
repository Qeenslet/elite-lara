<div class="panel-cabinet">
    <h3 class="inside_headers_white">Быстрая проверка</h3>
    <h4>Есть ли смысл сканировать планету?</h4>
    @if(isset($express))
        @if($express->getResult() > 2)
            <h3><span class="label label-success">Однозначно да!</span></h3>
        @elseif($express->getResult() > 1)
            <h3><span class="label label-success">Да!</span></h3>
        @elseif($express->getResult() > 0.5)
            <h3><span class="label label-info">Можешь рискнуть</span></h3>
        @elseif($express->getResult() > 0.3)
            <h3><span class="label label-warning">Не стоит</span></h3>
        @else
            @if(!empty($express->empty))
                <h3><span class="label label-info">У нас нет данных по этой комбинации, так что лучше просканить ее</span></h3>
            @else
                <h3><span class="label label-danger">Однозначно нет!</span></h3>
            @endif
        @endif
    @endif
    <hr>
    <form class="form-inline" method="POST" action="{{route('express')}}">
        <input type="hidden" value="{{csrf_token()}}" name="_token">
        <div class="form-group">
            <label for="star_select">Звезда</label>
            <select id="star_select" name="star" class="middleSelect">
                @foreach (\App\Myclasses\Arrays::allStarsArray(true) as $num => $one)
                    <option value="{{$num}}">{{$one}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="class_select">Класс</label>
            <select id="class_select" name="temperature">
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
            <label for="size_select">Размер</label>
            <select id="size_select" name="sizes">
                <option value="100">не важно</option>
                <option value="5">V</option>
                <option value="4">IV</option>
                <option value="3">III</option>
                <option value="6">VI</option>
            </select>
        </div>
        <div class="form-group">
            <label for="planet_select">Тип планеты</label>
            <select id="planet_select" name="planet">
                <option value="tf">для жизни</option>
                <option value="4">Водные</option>
                <option value="5">Аммиачные</option>
            </select>
        </div>
        <div class="form-group">
            <label for="distance_sel">Расстояние:</label>
            <input type="text" id="distance_sel" name="distance">
        </div>
        <div class="form-group">
            <label for="unit_sel">единицы:</label>
            <select id="unit_sel" name="units">
                <option value="1">АЕ</option>
                <option value="500">св.сек</option>
            </select>
        </div>
        <button type="submit" class="btn btn-warning">Дай совет!</button>
    </form></div>