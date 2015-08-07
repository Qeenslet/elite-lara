<div style="float:right; margin: 10px;">
    <button type="button"
            @if($target->request=='unsent')
                class="btn btn-info"
            @else
            class="disabled btn btn-info"
            @endif
            onclick="someAction('{{route('screenRequest', ['target'=>$target->id])}}', 'Запросить скриншот?')"><span class='glyphicon glyphicon-envelope' aria-hidden='true'></span> Запросить скриншот</button>
    <button type="button" class="btn btn-danger" onclick="someAction('{{route('del-o-prove', ['action'=>'delete', 'target'=>$target->id ])}}', 'Удалить?')"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Отклонить</button>
    <button type="button" class="btn btn-success" onclick="someAction('{{route('del-o-prove', ['action'=>'approve', 'target'=>$target->id ])}}', 'Одобрить?')"><span class='glyphicon glyphicon-ok' aria-hidden='true'></span> Одобрить</button>
</div>
<h2 class="white">Система: {{$target->address}}</h2>
<hr>
<div class="row">
    <div class="col-md-4">
<h3>Ранее было обнаружено:</h3>
@foreach($systemInfo->starsIn as $key=>$value)
    Звезда: {{$value}} <br>
    Планеты:<br>
    @foreach($systemInfo->planetsIn[$key] as $planet)
        {{$planet}} <br>
    @endforeach
@endforeach
    </div>
    <div class="col-md-4">
<h3>Добавляется:</h3>
{{$fullName}}
     </div>
    <div class="col-md-4">
<h3>Причина модерации:</h3>
{{$explanation}}
    </div>
</div>
<h4 class="white">Графики</h4>

<button type="button" class="chart-builder btn btn-primary" id="chart1" data="{{$chartData}}&step={{$step}}&_token={{csrf_token()}}" onclick="sendChart('chart1')">Функциональный график</button>
<button type="button" class="chart-builder btn btn-primary" id="chart3" data="{{$chartData}}&_token={{csrf_token()}}" onclick="sendChart('chart3')">Точечный график</button>
<div id="result"></div>
<div id="chartControl" style="display: none;">
    <p style="text-align: center;">Шаг: <a href="#" onclick="stepUp(0)"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></a>
        <span id="char_dist" data="{{$stepKey}}">{{$step}} а.е.</span>
        <a href="#" onclick="stepUp(1)"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span></a></p>
</div>


<script>
    onestep=$('#char_dist').attr('data');
    steps={};
    steps[1]=0.05;
    steps[2]=0.1;
    steps[3]=0.25;
    steps[4]=0.5;
    steps[5]=1;
    steps[6]=2;
</script>
