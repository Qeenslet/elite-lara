<h2 class="white">Система: {{$info->fName}}</h2>
<div class="row">
    @foreach($info->starsIn as $id=>$star)
        <div class="col-md-{{12/count($info->starsIn)}}">
            <img src="/media/stars/{{$info->starImages[$id]}}"> {{$star}} {{$info->marks[$id]}}
            <br>
            @foreach($info->planetsIn[$id] as $pId=>$pDesc)
                <div class="panel-cabinet">
                    <img src="/media/planets/{{$info->planetImages[$pId]}}"> {{$pDesc}}<br>
                </div>
            @endforeach
        </div>
    @endforeach

</div>