<h2 class="white">Система: {{$info->getSystemName()}}</h2>
<table style="width: 100%">
    @foreach($info->getAllCenters() as $center)
        <tr>
            <td style="width: 50%">
                @foreach ($info->getOneCenter($center) as $centerObject)
                      <img src="/media/stars/{{$centerObject['image']}}"> {{$centerObject['name']}}
                @endforeach
            </td>
            <td>
                @foreach($info->getCenterPlanets($center) as $id=>$planet)
                    <img src="/media/planets/{{$planet['image']}}"> {{$planet['name']}}<br>
                @endforeach
            </td>
    @endforeach
</table>