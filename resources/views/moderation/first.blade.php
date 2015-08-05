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
                <div class="panel-heading">География визитов за все время</div>
                <div class="panel-body">
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
                        scale:{{$locations->cityCounts[$city['id']]*0.5}},
                        label:"{{$city['name_ru']}}",
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
@stop