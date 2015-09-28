@extends('templates.database')
@section('chartforms')
<div class="panel-cabinet" id="chartAbout">
    <div style="margin: 5px; width:100%; height: 10%; position: relative; top:1px;"><a href="javascript:closeInfo();" class="info-close-btn"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></div>
    <br>
    <p>This pie chart represents the percentage of the different planet types discovered  in the star systems of different star types in comparison with the total amount of planets.</p>
    <p>You should select the planet type(s) you are interested in</p>
    <p>The chart has two levels of drilldown so you can dig deeper into each for more information about each star type, class, and size.</p>

    <hr>
</div>
<form class="form-inline" method="POST" id="where_query" onsubmit="send('where_query');" action="javascript:void(null);">
    <input type="hidden" value="{{csrf_token()}}" name="_token">
    <div class="form-group">
        <label for="style_select">Planets</label>
        <select id="style_select" name="style" class="largeSelect">
            <option value="1">All suitable for life and TF</option>
            <option value="2">T-high metal</option>
            <option value="3">T-water worlds</option>
            <option value="4">Water worlds</option>
            <option value="5">Ammonia worlds</option>
            <option value="6">Earth-likes</option>
        </select>
    </div>
    <button type="submit" class="btn btn-warning" id="change_b">Search</button>
</form>
<hr>
    @stop