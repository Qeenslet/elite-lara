@extends('app')
@section('top-style')
    @parent
    <script src="{{ asset('/ammap/ammap.js') }}" type="text/javascript"></script>
    <link rel="stylesheet" href="{{ asset('/ammap/ammap.css') }}" type="text/css" media="all" />
    <script src="/ammap/maps/js/worldLow.js" type="text/javascript"></script>
@stop
@section('content')
    <div class="row">
        <div class="col-md-7">
            <div class="panel panel-warning">
                <div class="panel-heading">География визитов за последнюю неделю</div>
                <div class="panel-body" id="mapBody">
                    <div id="mapdiv" style="width: 900px; height: 600px;"></div>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Пополнение базы за 24 часа</div>
                <div class="panel-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th>
                                Имя
                            </th>
                            <th>
                                Добавлено звезд
                            </th>
                            <th>
                                Добавлено планет
                            </th>
                        </tr>
                        <thead>
                        <tbody>
                        @foreach($users as $user)
                            @if($amount=$user->hasFindings($user->id))
                                <tr>

                                    <td>
                                        {{$user->name}}
                                    </td>
                                    <td>
                                        {{$amount['stars']}}
                                    </td>
                                    <td>
                                        {{$amount['planets']}}
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="panel panel-warning">

                <div class="panel-body">
                    <div id="littleChart" style="width: 100%; height: auto;"></div>
                </div>
            </div>
            <div class="panel panel-success">
                <div class="panel-heading">Общие данные по сайту</div>
                <div class="panel-body">
                    <p>Всего пользователей в системе: {{\App\User::count()}}</p>
                    <p>Всего писем: {{\App\Letter::count()}}</p>
                    <p>Систем, ожидающих модерации: {{\App\Moderation::count()}}</p>
                </div>
            </div>
            <div class="panel panel-primary">
                <div class="panel-heading">Статистика по базе звезд и планет</div>
                <div class="panel-body">
                    <ul>
                        <li><span class="white">{{$latest['total']}}</span> планет</li>
                        <li><span class="white">{{$latest['sys']}}</span> звездных систем</li>
                        <li><span class="white">{{$latest['tf']}}</span> пригодных для жизни планет</li>
                        <li><span class="white">{{$latest['reg']}}</span> регионов охвачено</li>
                        <li><span class="white">{{$latest['latest']}}</span> новых объекта за сутки</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scripts')
    @parent
    <script>
        var w = window.innerWidth;
        changeWidth(w);
        setInterval(function(){
            newW=window.innerWidth;
            if(newW!=w) {
                w=newW;
                changeWidth(w);
            }
        }, 2);
        function changeWidth(w) {
            if (w < 768) {
                wR = w * 0.85;
            }
            else {
                wR = w * 0.45;
            }
            hR = wR / 1.5;
            $('#mapdiv').css('width', wR).css('height', hR);
        }
    </script>
    <script>
        AmCharts.ready(function() {
            // create AmMap object
            var map = new AmCharts.AmMap();
            // set path to images
            map.pathToImages = "/ammap/images/";

            /* create data provider object
             map property is usually the same as the name of the map file.

             getAreasFromMap indicates that amMap should read all the areas available
             in the map data and treat them as they are included in your data provider.
             in case you don't set it to true, all the areas except listed in data
             provider will be treated as unlisted.
             */
            var dataProvider = {
                map: "worldLow",
                areas:[
                    @foreach($locations->countries as $one)
                    {id:"{{$one}}"},
                    @endforeach
                ],
                images:[
                    @foreach($locations->cities as $city)
                    {latitude:{{$city['lat']}},
                        longitude:{{$city['lon']}},
                        type:"circle", color:"#6c00ff",
                        scale:{{$locations->cityCounts[$city['id']]*0.01+0.5}},

                        labelShiftY:2,
                        title:"{{$city['name_ru']}}",
                        description:"Количество уникальных пользователей: {{$locations->cityCounts[$city['id']]}}"},
                    @endforeach
                ]
            };
            // pass data provider to the map object
            map.dataProvider = dataProvider;

            /* create areas settings
             * autoZoom set to true means that the map will zoom-in when clicked on the area
             * selectedColor indicates color of the clicked area.
             */
            map.areasSettings = {
                autoZoom: true,
                selectedColor: "#CC0000"
            };

            // let's say we want a small map to be displayed, so let's create it
            map.smallMap = new AmCharts.SmallMap();

            // write the map to container div
            map.write("mapdiv");
        });
    </script>
    <script>
        $(function () {
            $('#littleChart').highcharts({
                chart: {
                    type: 'spline'
                },
                title: {
                    text: 'Наполнение базы данных за неделю'
                },
                credits: {
                    enabled: false
                },
                xAxis: {
                    categories: [
                        @foreach($statData->getTotal() as $key=>$value)
                        '{{$key}}',
                        @endforeach
                ]
                },
                yAxis: {
                    title: {
                        text: 'Кол-во'
                    },
                    min: 0
                },
                tooltip: {
                    headerFormat: '<b>{series.name}</b><br>',
                },

                plotOptions: {
                    spline: {
                        marker: {
                            enabled: true
                        }
                    }
                },

                series: [{
                    name: "Всего",
                    data: [
                        @foreach($statData->getGrowth() as $value)
                        [{{$value}}],
                        @endforeach
                    ]
                }, {
                        name: "Добавлено звезд",
                        data: [
                            @foreach($statData->getStars() as $value)
                            [{{$value}}],
                            @endforeach
                        ]
                    }, {
                    name: "Добавлено планет",
                    data: [
                        @foreach($statData->getPlanets() as $value)
                        [{{$value}}],
                        @endforeach
                    ]
                }
                ]
            });
        });
    </script>
@stop