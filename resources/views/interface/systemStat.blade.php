<div class="left-top">
    <h2 class="inside_headers_orange">Данные по системе</h2>
    <h4 class="white" style="text-align: center">{{$address->fName}}</h4>
    @foreach($address->starsIn as $id=>$star)
        <div class="panel-cabinet">
            <img src="/media/stars/{{$address->starImages[$id]}}"
                 style="height: 25px; width: auto; float: left;"
                 title="{{$star}}"
                 class="leftStars pointed"
                 dstar="{{\App\Star::find($id)->star}}"
                    dsize="{{\App\Star::find($id)->size}}"
                 dclass="{{\App\Star::find($id)->class}}"
                    dcode="{{\App\Star::find($id)->code}}">
            @foreach($address->planetsIn[$id] as $pId=>$pDesc)
                    <img src="/media/planets/{{$address->planetImages[$pId]}}" style="height: 10px; width: auto; float: left" title="{{$pDesc}}">
            @endforeach
        </div>
    @endforeach
    <br>
    <p>Отсюда можно выбрать звезду для ввода данных по планетам</p>
</div>
<script>
    $('.leftStars').click(function(){
        appStar=$(this).attr('dstar');
        appSize=$(this).attr('dsize');
        appClass=$(this).attr('dclass');
        appCode=$(this).attr('dcode');
        $('#star_sel').val(appStar);
        $('#size_sel').val(appSize);
        $('#temp_sel').val(appClass);
        $('#code_sel').val(appCode);
    });
</script>