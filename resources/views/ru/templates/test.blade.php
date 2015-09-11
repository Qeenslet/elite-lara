@extends('eliteRu')
@section('title')
    Работа с базой данных|@parent
@stop
@section('content')
    @if (count($errors) > 0)
        @include('errors.display')
    @endif

    @if(isset($result))
        @if($result=='ok')
            @include('responses.success')
        @endif
        @if($result=='moder')
            @include('responses.moderation')
        @endif
        @if($result=='fail')
            @include('responses.dbfail')
        @endif
        @if($result=='sameStar')
            @include('responses.sameStar')
        @endif
        @if($result=='samePlanet')
            @include('responses.samePlanet')
        @endif
        @if($result=='sameBary')
            @include('responses.sameBary')
        @endif
    @endif
    <h2 class="inside_headers_white">Работа с базой данных</h2>
    @if(isset($welcome))
    <div class="panel-cabinet" id="localAbout">
        <div style="margin: 5px; width:100%; height: 10%; position: relative; top:1px;"><a href="javascript:closeInfo();" class="info-close-btn"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></div>
        <br>
        <p>Привет, <span class="white">{{Auth::user()->name}}</span>! Добро пожаловать на страницу работы с нашей базой данных!</p>
        <p>Можно искать информацию о системах, которые уже есть в базе, а можно дополнить информацию об этих системах или внести данные о совершенно новых звездах и планетах</p>
        <p>Сначала нужно добавить адрес системы, для этого нужно ввести имя региона и код в регионе. Каталожные звезды типа HIP, HD, HR заносятся по той же схеме, что и обычные. Имя каталога вносится в поле <span class="white">регион</span>, цифровой код в в поле <span class="white">код</span>.</p>
        <p>Для добавления звезд, имеющих собственное имя, необходимо нажать соответствующую кнопку и внести данные о названии звезды.</p>
    </div>
    @endif
    <hr>
    <form method="get" action="{{route('searchadd')}}" class="form-inline">

        <div class="form-group">
            <label for="region">Адрес:</label>
            <input type="text"
                   class="form_add_1 largeSelect"
                   id="region"
                   name="address">
        </div>
        <button type="submit" class="btn btn-warning"><span class="glyphicon glyphicon-search"></span> Поиск в базе</button>
    </form>
    <hr>
        <button class="btn btn-success" id="addNew"><span class="glyphicon glyphicon-plus"></span> Новый адрес</button>
    @if(isset($systemDs))
        @foreach($systemDs as $systemD)
            <h3>{{$systemD->getSystemName()}}</h3>
            @if(!$systemD->getAllCenters())
               <h4>Система пуста!</h4>
            @else
                <table class="panel-cabinet">
                    @foreach($systemD->getAllCenters() as $center)
                        <tr>
                            <td style="width: 40%">
                                @foreach ($systemD->getOneCenter($center) as $centerObject)
                                    <div class="panel-cabinet pointed" data="_token={{csrf_token()}}&type={{$centerObject['type']}}&id={{$centerObject['id']}}">
                                        <img src="/media/stars/{{$centerObject['image']}}"> {{$centerObject['name']}}
                                    </div>
                                @endforeach
                            </td>
                            <td style="width: 40%">
                                @foreach($systemD->getCenterPlanets($center) as $id=>$planet)
                                    <div class="panel-cabinet pointed" data="_token={{csrf_token()}}&type={{$planet['type']}}&id={{$id}}">
                                        <img src="/media/planets/{{$planet['image']}}"> {{$planet['name']}}<br>
                                    </div>
                                @endforeach
                            </td>
                            <td>
                                <button class="btn btn-warning addNewPlanet" data="addr_id={{$systemD->getAddrId()}}&id={{$systemD->getCenterId($center)}}&type={{$systemD->getType($center)}}">
                                    <span class="glyphicon glyphicon-plus"></span>
                                    Новая планета</button>
                            </td>
                        </tr>
                    @endforeach
                </table>
            @endif
            <button class="btn btn-danger" id="addNewStar" data="id={{$systemD->getAddrId()}}"><span class="glyphicon glyphicon-plus"></span> Новая звезда</button>
            @if(count($systemD->getAllCenters())>1)
                <button class="btn btn-primary" id="addBarycenter" data="id={{$systemD->getAddrId()}}"><span class="glyphicon glyphicon-plus"></span> Новый барицентр</button>
            @endif
        @endforeach
    @endif
@stop
@section('scripts')
    @parent
    <script type="text/javascript" src="/js/newBaseAdder.js"></script>
    <script>
        setTimeout(function(){
            $('#result-response').fadeOut(1000);
            $('#form-error').fadeOut(1000);
        },5000);
        @if(isset($nothing))
            alert('Ничего не было найдено');
        @endif

        function closeInfo()
        {
            $('#localAbout').slideUp(300);
        }
    </script>
@stop