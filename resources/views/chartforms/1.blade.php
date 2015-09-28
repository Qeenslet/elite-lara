@extends('templates.database')
@section('chartforms')
<div class="panel-cabinet" id="chartAbout">
    <div style="margin: 5px; width:100%; height: 10%; position: relative; top:1px;"><a href="javascript:closeInfo();" class="info-close-btn"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></div>
<br>
    <p>This is a chart that represents the habitable zones of different planets and star types.</p>
<p>To work with the chart select the spectral type of the star, its size and temperature class, and choose you desired type of planet.</p>
<p>Step AU represent the resolution of the horizontal scale which displays the distance of a planet from its star. A large step represents the trend of typical orbits.
    The peaks are clearly visible but you lose granularity due to the smoothing. A lower step represents data as it is, the limits of the habitable zone are clearly visible, but the peaks are not that pronounced.</p>

    <hr>
</div>
<form class="form-inline" method="POST" id="d_query" onsubmit="send('d_query');" action="javascript:void(null);">
    <input type="hidden" value="{{csrf_token()}}" name="_token">
    <div class="form-group">
        <label for="star_select">Star type</label>
        <select id="star_select" name="star" class="middleSelect">
            @foreach ($count as $num => $one)
                <option value="{{$num}}">{{$one}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="class_select">Class</label>
        <select id="class_select" name="class">
            <option value="100">no matter</option>
            <option>0</option>
            <option>1</option>
            <option>2</option>
            <option>3</option>
            <option>4</option>
            <option>5</option>
            <option>6</option>
            <option>7</option>
            <option>8</option>
            <option>9</option>
        </select>
    </div>
    <div class="form-group">
        <label for="size_select">Size</label>
        <select id="size_select" name="size">
            <option value="100">no matter</option>
            <option value="5">V</option>
            <option value="4">IV</option>
            <option value="3">III</option>
            <option value="6">VI</option>
        </select>
    </div>
    <div class="form-group">
        <label for="step_select">Step AU</label>
        <select id="step_select" name="step">
            <option value="0"></option>
            <option>0.05</option>
            <option>0.1</option>
            <option>0.25</option>
            <option>0.5</option>
            <option>1</option>
            <option>2</option>
        </select>
    </div>
    <div class="form-group">
        <label for="planet_select">Planets</label>
        <select id="planet_select" name="planet" class="largeSelect">
            <option value="543210">all available</option>
            <option value="3">earth-likes</option>
            <option value="3210">earth-likes and suitable for TF</option>
            <option value="14">water worlds of all types</option>
        </select>
    </div>
    <button type="submit" class="btn btn-warning">Search</button>
</form>
<hr>
@stop
@section('scripts')
    @parent
    <script>
        $('#star_select').change(function(){
            var select=$('#star_select').val();
            if(select==15 || select==16){
                $("#class_select").val(100).hide();
                $("#size_select").val(100).hide();
            }
            else {
                $("#class_select").show();
                $("#size_select").show();
            }
        });
    </script>
@stop