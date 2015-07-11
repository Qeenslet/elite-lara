@extends('elite')

@section('top-scripts')
<script>
    function resetAll() {
        document.getElementById("star_adder").reset();
        document.getElementById("show_planet").reset();
        document.getElementById('show_star').style.display='none';
        document.getElementById('show_planet').style.display='none';
        document.getElementById('hereStat').innerHTML='';
    }
</script>
@stop

@section ('content')
    <h2 class="inside_headers_white">Добавление в базу данных</h2>
    <p>Привет, <span class="white">{{Auth::user()->name}}</span>! Добро пожаловать на страницу пополнения нашей базы данных!</p>
    <p>В принципе здесь все просто. Заноси данные по каждой планете, которую ты нашел, и которая представляет интерес для сайта и сообщества. Нам нужны данные о планете и звезде, вокруг которой она вращается.</p>
    <p>Каталожные звезды типа HIP, HD, HR заносятся по той же схеме, что и обычные. Имя каталога вносится в поле <span class="white">регион</span>, цифровой код в в поле <span class="white">код</span>.</p>
    <p>Для добавления звезд, имеющих собственное имя, необходимо отметить соответствующий маркер и внести данные о названии звезды.</p>
    <div id="messagies"></div>
    @if (count($errors) > 0)
        @include('errors.display')
    @endif
    <button class="btn btn-danger" onclick="resetAll();">Очистить адрес</button>
    <form class="form-inline" method="POST" onsubmit="addstar();" id="star_adder" action="javascript:void(null);">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
        <h3>Координаты системы</h3>
        <div class="form-group" id="off_normal" style="display: none;">
            <label for="one_name">Название звезды:</label>
            <input type="text" class="form_add_1" id="one_name" name="one_name" placeholder="Monocerotis 20">
        </div>
        <div class="form-group" id="if_normal_1">
            <label for="region_add">Регион:</label>
            <input type="text" class="form_add_1" id="region_add" name="region" placeholder="Plaa Trua" list="regions" autocomplete="on">
            <datalist id="regions">
                @foreach($regions as $one)
                    <option>{{$one->name}}</option>
                @endforeach
            </datalist>
        </div>
        <div class="form-group" id="if_normal_2">
            <label for="code_name">Код:</label>
            <input type="text" class="form_add_1" id="code_name" name="code_name" placeholder="EG-Y D76">
        </div>
        <div class="checkbox">
            <label>
                <input type="checkbox" value="" id="spec">
                Именная звезда
            </label>
        </div>
        <div id='show_star' style='display: none;'>
            <h3>Свойства звезды</h3>
            <div class="form-group">
                <label for="star_sel">Тип звезды:</label>
                <select id="star_sel" name="star">
                    <option></option>
                    @foreach ($stars as $num => $one)
                        <option value="{{$num}}">{{$one}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" id="hideclass">
                <label for="temp_sel">Температурный подкласс:</label>
                <select id="temp_sel" name="class">
                    <option></option>
                    @for($i=0; $i<10; $i++)
                        <option>{{$i}}</option>
                   @endfor
                </select>
            </div>
            <div class="form-group" id="hidesize">
                <label for="size_sel">Размер:</label>
                <select  id="size_sel" name="size">
                    <option></option>
                    @foreach ($sizes as $val => $si)
                        <option value="{{$val}}">{{$si}}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="code_sel">Код в системе:</label>
                <input type="text" id="code_sel" name="code" placeholder="A">
            </div>
            <button type="submit" class="btn btn-warning" id="change_b_star">Добавить звезду</button>
        </div>
    </form>
    <form class="form-inline" id='show_planet' method="POST" onsubmit="addplanet();" action="javascript:void(null);" style="display: none;">
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
    <h4 class="white">Внимание!</h4>
    <strong>Пилоты!</strong>
    <p>Проверьте лишний раз внесенные данные, их будет проще поправить сейчас, чем потом!</p>
@stop
@section('scripts')
    @parent
    <script type="text/javascript" src="/js/baseadd.js"></script>
    <script type="text/javascript" src="/js/addstar.js"></script>
    <script type="text/javascript" src="/js/addplanet.js"></script>
    <script type="text/javascript" src="/js/loadSystem.js"></script>
@stop
@section('left-column')
    @parent
    <div id="hereStat">
    </div>
@stop