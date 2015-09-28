<h2 class="white">Дполнительные данные по планете</h2>
<form id="addStar" action="{{route('addPlanetExtra')}}" method="POST" class="form-horizontal">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="planet_id" value="{{$pId}}">
    <input type="hidden" name="planet_type" value="{{$type}}">

    <div class="col-lg-4">
        <h3>Общее</h3>
        <div class="form-group">
            <label for="e_mass" class="col-md-4 control-label">Масса, в массах Земли:</label>
            <div class="col-md-6">
                <input id="e_mass" name="mass" type="text" value="@if(isset($pData) && $pData->mass > 0){{$pData->mass}}@endif" class="digits">
            </div>
        </div>

        <div class="form-group">
            <label for="rad" class="col-md-4 control-label">Радиус, км:</label>
            <div class="col-md-6">
                <input id="rad" name="radius" type="text" value="@if(isset($pData) && $pData->radius > 0){{$pData->radius}}@endif" class="digits">
            </div>
        </div>

        <div class="form-group">
            <label for="temp" class="col-md-4 control-label">Температура поверхности, K</label>
            <div class="col-md-6">
                <input id="temp" name="temperature" type="text" value="@if(isset($pData) && $pData->temperature > 0){{$pData->temperature}}@endif" class="digits">
            </div>
        </div>

        <div class="form-group">
            <label for="press" class="col-md-4 control-label">Давление, атмосферы</label>
            <div class="col-md-6">
                <input id="press" name="pressure" type="text" value="@if(isset($pData) && $pData->pressure > 0){{$pData->pressure}}@endif" class="digits">
            </div>
        </div>


        <div class="form-group">

                <select id="volcanism" name="volcanism" class="largeSelect">
                    @foreach (\App\Myclasses\Arrays::volcanism() as $num => $one)
                        <option value="{{$num}}">{{$one}}</option>
                    @endforeach
                </select>


        </div>
        <div class="form-group">

                <select id="atmosphere_type" name="atm_type" class="largeSelect">
                    @foreach (\App\Myclasses\Arrays::atmosphereType() as $num => $one)
                        <option value="{{$num}}">{{$one}}</option>
                    @endforeach
                </select>

        </div>
        <hr>
        <div class="form-group">
            <label for="price" class="col-md-4 control-label">Цена от Universal Cartographics</label>
            <div class="col-md-6">
                <input id="price" name="price" type="text" value="@if(isset($pData) && $pData->price > 0){{$pData->price}}@endif" class="digits">
            </div>
        </div>

    </div>
    <div class="col-lg-4">
        <h3>Состав атмосферы, %</h3>

        <select id="multiple_gas" class="largeSelect" name="ignoreMe">
            <option value="0" disabled selected>Выберите газ</option>
            @foreach(\App\Myclasses\Arrays::atmosphereComposition() as $key=>$value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        </select>

        @foreach(\App\Myclasses\Arrays::atmosphereComposition() as $key=>$value)

            <div class="form-group gasses" id="{{$key}}" style="
            @if (isset($pData) && $pData->atmosphere->$key > 0 )
            @else
                    display: none;
            @endif
                    ">
                <label for="a_{{$key}}" class="col-md-4 control-label">{{$value}}</label>
                <div class="col-md-6">
                    <input id="a_{{$key}}" name="{{$key}}" type="text"
                    @if (isset($pData) && $pData->atmosphere->$key > 0 )
                           value="{{$pData->atmosphere->$key}}"
                           @else
                           value="0"
                           @endif
                           class="resetMe digits">
                </div>
            </div>

        @endforeach
        <div>
            <button type="submit" class="btn btn-primary" id="clearList">Очистить список</button>
        </div>

        <h3>Состав планеты, %</h3>
        @foreach(\App\Myclasses\Arrays::planetComposition() as $key=>$value)
            <div class="form-group">
                <label for="{{$key}}" class="col-md-4 control-label">{{$value}}</label>
                <div class="col-md-6">
                    <input id="{{$key}}" name="{{$key}}" type="text"
                    @if(isset($pData))
                           value = "{{$pData->composition->$key}}"
                           @else
                           value = "0"
                           @endif
                           class="rockSolid digits">
                </div>
            </div>
        @endforeach
    </div>

    <div class="col-lg-4">

        <h3>Данные об орбите</h3>
        <div class="form-group">
            <label for="orbPeriod" class="col-md-4 control-label">Сидерический пер. обр.</label>
            <div class="col-md-6">
                <input id="orbPeriod" name="orbP" type="text" value="@if(isset($pData) && $pData->orbit->orbP > 0){{$pData->orbit->orbP}}@endif" class="digits">
            </div>
        </div>

        <div class="form-group">
            <label for="mAxis" class="col-md-4 control-label">Главная полуось</label>
            <div class="col-md-6">
                <input id="mAxis" name="mAxis" type="text" value="@if(isset($pData) && $pData->orbit->mAxis > 0){{$pData->orbit->mAxis}}@endif" class="digits">
            </div>
        </div>

        <div class="form-group">
            <label for="eccentricity" class="col-md-4 control-label">Эксцентриситет орбиты</label>
            <div class="col-md-6">
                <input id="eccentricity" name="ecce" type="text" value="@if(isset($pData) && $pData->orbit->ecce > 0){{$pData->orbit->ecce}}@endif" class="digits">
            </div>
        </div>

        <div class="form-group">
            <label for="inclination" class="col-md-4 control-label">Наклонение орбиты</label>
            <div class="col-md-6">
                <input id="inclination" name="incl" type="text" value="@if(isset($pData) && isset($pData->orbit->incl)){{$pData->orbit->incl}}@endif" class="digits">
            </div>
        </div>

        <div class="form-group">
            <label for="periapsis" class="col-md-4 control-label">Аргумент перицентра</label>
            <div class="col-md-6">
                <input id="periapsis" name="peri" type="text" value="@if(isset($pData) && isset($pData->orbit->peri)){{$pData->orbit->peri}}@endif" class="digits">
            </div>
        </div>

        <div class="form-group">
            <label for="rotPeriod" class="col-md-4 control-label">Период обращения</label>
            <div class="col-md-6">
                <input id="rotPeriod" name="rotP" type="text" value="@if(isset($pData) && $pData->orbit->rotP > 0){{$pData->orbit->rotP}}@endif" class="digits">
            </div>
        </div>

        <div class="form-group">
            <label for="aTilt" class="col-md-4 control-label">Наклон оси вращения</label>
            <div class="col-md-6">
                <input id="aTilt" name="aTilt" type="text" value="@if(isset($pData) && isset($pData->orbit->aTilt)){{$pData->orbit->aTilt}}@endif" class="digits">
            </div>
        </div>

        <div class="elite-checkbox">
            <input type="checkbox" name="locked" id="locked"
            @if(isset($pData) && $pData->orbit->locked == 'locked')
                   checked
                    @endif>
            <label for="locked">Приливной захват</label>
        </div>
    </div>
    <br style="clear:both" />
    <ul id="forErrors"></ul>
    <div>
        <button type="submit" class="btn btn-warning" id="addExtraData">Внести данные</button>
    </div>
</form>
<script type="text/javascript" src="/js/extraPlanetAdder.js"></script>
<script>
    @if(isset($pData) && $pData->volcanism >= 0)
        $('#volcanism').val('{{$pData->volcanism}}');
    @endif

    @if(isset($pData) && $pData->atm_type >= 0)
        $('#atmosphere_type').val('{{$pData->atm_type}}');
    @endif
    function toMuchGas()
    {
        $('#forErrors').append('<li class="white">Процент газов в составе атмосферы выше 100%!</li>');
    }

    function toMuchRock()
    {
        $('#forErrors').append('<li class="white">Процент веществ в составе планеты выше 100%!</li>');
    }

    function digitalWarning()
    {
        $('#forErrors').append('<li class="white">В поля формы можно доавблять только цифровое значение!!! (Десятичную дробь отделяют точкой, а не запятой)</li>');
    }
</script>