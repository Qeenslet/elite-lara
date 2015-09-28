<div style="float:right; margin: 10px;">
    <button type="button"
            @if($target->request=='unsent')
                class="btn btn-info"
            @else
            class="disabled btn btn-info"
            @endif
            onclick="someAction('{{route('screenRequest', ['target'=>$target->id])}}', 'Request a screenshot?')"><span class='glyphicon glyphicon-envelope' aria-hidden='true'></span> Request a screenshot</button>
    <button type="button" class="btn btn-danger" onclick="someAction('{{route('del-o-prove', ['action'=>'delete', 'target'=>$target->id ])}}', 'Delete?')"><span class='glyphicon glyphicon-remove' aria-hidden='true'></span> Do not approve</button>
    <button type="button" class="btn btn-warning" onclick="someAction('{{route('del-o-prove', ['action'=>'restrict', 'target'=>$target->id ])}}', 'Approve with restrictions?')"><span class='glyphicon glyphicon-warning-sign' aria-hidden='true'></span> Approve with restrictions</button>
    <button type="button" class="btn btn-success" onclick="someAction('{{route('del-o-prove', ['action'=>'approve', 'target'=>$target->id ])}}', 'Approve?')"><span class='glyphicon glyphicon-ok' aria-hidden='true'></span> Approve</button>
</div>
<h2 class="white">System: {{$target->address}}</h2>
<hr>
<div class="row">
    <div class="col-md-4">
<h3>Previously were discovered:</h3>
@foreach($systemInfo->getAllCenters() as $center)
    @foreach ($systemInfo->getOneCenter($center) as $centerObject)
        Star:{{$centerObject['name']}}<br>
    @endforeach
    Planets:<br>
    @foreach($systemInfo->getCenterPlanets($center) as $planet)
        {{$planet['name']}} <br>
    @endforeach
@endforeach
    </div>
    <div class="col-md-4">
<h3>Is added:</h3>
{{$fullName}}
     </div>
    <div class="col-md-4">
<h3>Moderation reason:</h3>
{{$explanation}}
    </div>
</div>
<h4 class="white">Charts</h4>

<button type="button" class="chart-builder btn btn-primary" id="chart1" data="{{$chartData}}&step={{$step}}&_token={{csrf_token()}}" onclick="sendChart('chart1')">Functional chart</button>
<button type="button" class="chart-builder btn btn-primary" id="chart3" data="{{$chartData}}&_token={{csrf_token()}}" onclick="sendChart('chart3')">Dotted plot</button>
<div id="result"></div>
<div id="chartControl" style="display: none;">
    <p style="text-align: center;">Step: <a href="#" onclick="stepUp(0)"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span></a>
        <span id="char_dist" data="{{$stepKey}}">{{$step}} au</span>
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
