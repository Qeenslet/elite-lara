<h2 class="white">Система: {{$info->getSystemName()}}</h2>
<table style="width: 100%">
    @foreach($info->getAllCenters() as $center)
        <tr>
            <td style="width: 50%; padding:5px">
                @foreach ($info->getOneCenter($center) as $centerObject)
                    <table style="width:100%;">
                        <tr>
                            <td>
                                <img src="/media/stars/{{$centerObject['image']}}"> {{$centerObject['name']}}
                            </td>
                            @if(isset($centerObject['extra']))
                                <td>
                                    <div id="s{{$centerObject['id']}}" style="display: none;">
                                        @include('ru.interface.starInsides')
                                    </div>
                                    <button class="btn btn-primary extraP" type="submit" data="{{$centerObject['id']}}" data-object="s" id="bs{{$centerObject['id']}}">Открыть данные по звезде</button>
                                </td>
                            @endif
                        </tr>
                    </table>
                @endforeach
            </td>
            <td>
                @foreach($info->getCenterPlanets($center) as $id=>$planet)
                    <table style="width: 100%;">
                        <tr>
                            <td style="padding: 5px;">
                                <img src="/media/planets/{{$planet['image']}}"> {{$planet['name']}}
                            </td>
                            @if(isset($planet['extra']))
                                <td>
                                    <div id="p{{$id}}" style="display: none;">
                                        @include('ru.interface.planetInsides')
                                    </div>
                                    <button class="btn btn-primary extraP" type="submit" data="{{$id}}" data-object="p" id="bp{{$id}}">Открыть данные по планете</button>
                                </td>
                            @endif
                        </tr>
                    </table>
                @endforeach
            </td>
        </tr>
    @endforeach
</table>
<script type="text/javascript" src="/js/cabinetShowExtra.js"></script>
<script>
    function changeName(id, object)
    {
        switch(object)
        {
            case 'p':
                var name = 'планете';
                break;
            default:
                var name = 'звзде';

        }
        if($('#'+object+id).is(':visible'))
        {
            $('#b'+object+id).html('Скрыть данные по '+name);
        }
        else
        {
            $('#b'+object+id).html('Открыть данные по '+name);
        }
    }
</script>