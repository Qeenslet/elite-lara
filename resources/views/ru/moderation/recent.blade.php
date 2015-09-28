@extends('app')
@section('content')
    <datalist id="regions">
        @foreach(\App\Region::all() as $one)
            <option>{{$one->name}}</option>
        @endforeach
    </datalist>
    <form method="get" action="{{route('recent')}}" class="form-inline">
        <div class="form-group">

            <label for="region_search">Регион</label>
            <input type="text" class="form-control" name="region" id="region_search" list="regions" autocomplete="on">

        </div>
        <button type="submit" class="btn btn-default">Найти</button>
    </form>
    @if(isset($address))
    <table class="table table-striped">
        <thead>
        <tr>
            <th>
                Адрес
            </th>
            <th>
                Объекты
            </th>
        </tr>
        <thead>
        <tbody>
        @foreach($address as $one)
            <?php $content=new \App\Myclasses\Insides\Converter($one->id); ?>
            <tr>
                <td>
                    <h4>{{$content->getSystemName()}}</h4>
                    <form method="post" action="{{route('changeData')}}" class="form-horizontal">
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        <input type="hidden" name="adrId" value="{{$one->id}}">
                        <input type="text" name="region" list="regions" autocomplete="on"
                               class="form-control" value="{{$one->region->name}}">
                        <input type="text" name="address" value="{{$one->name}}"
                               class="form-control">
                        <button type="submit" class="btn btn-success">Изменить</button>
                    </form>
                </td>
                @if(!$content->getAllCenters())
                    <td>
                        <h4>Система пуста!</h4>
                    </td>
                @else
                <td>
                    @foreach($content->getAllCenters() as $center)
                        @foreach ($content->getOneCenter($center) as $centerObject)
                            Звезда:{{$centerObject['name']}}<br>
                        @endforeach
                        Планеты:<br>
                        @foreach($content->getCenterPlanets($center) as $planet)
                            {{$planet['name']}} <br>
                        @endforeach
                    @endforeach
                </td>
                @endif
            </tr>
        @endforeach
        </tbody>
    </table>
    @endif
@stop