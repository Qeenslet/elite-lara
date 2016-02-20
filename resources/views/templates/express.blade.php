<div class="panel-cabinet">
    <h3 class="inside_headers_white">Fast check</h3>
    <h4>Should I scan this planet?</h4>
@if(isset($express))
    @if($express->getResult() > 2)
        <h3><span class="label label-success">Certainly!</span></h3>
    @elseif($express->getResult() > 1)
        <h3><span class="label label-success">Yes!</span></h3>
    @elseif($express->getResult() > 0.5)
        <h3><span class="label label-info">You may</span></h3>
    @elseif($express->getResult() > 0.3)
        <h3><span class="label label-warning">Better no</span></h3>
    @else
        @if(!empty($express->empty))
            <h3><span class="label label-info">We don't have enough data. Better scan it)</span></h3>
        @else
            <h3><span class="label label-danger">No way!</span></h3>
        @endif
    @endif
@endif
    <hr>
<form class="form-inline" method="POST" action="{{route('express')}}">
    <input type="hidden" value="{{csrf_token()}}" name="_token">
    <div class="form-group">
        <label for="star_select">Star type</label>
        <select id="star_select" name="star" class="middleSelect">
            @foreach (\App\Myclasses\Arrays::allStarsArray(true) as $num => $one)
                <option value="{{$num}}">{{$one}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="class_select">Class</label>
        <select id="class_select" name="temperature">
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
        <select id="size_select" name="sizes">
            <option value="100">no matter</option>
            <option value="5">V</option>
            <option value="4">IV</option>
            <option value="3">III</option>
            <option value="6">VI</option>
        </select>
    </div>
    <div class="form-group">
        <label for="planet_select">Planet type</label>
        <select id="planet_select" name="planet">
            <option value="tf">TF-planets</option>
            <option value="4">Water world</option>
            <option value="5">Ammonia world</option>
        </select>
    </div>
    <div class="form-group">
        <label for="distance_sel">Distance:</label>
        <input type="text" id="distance_sel" name="distance">
    </div>
    <div class="form-group">
        <label for="unit_sel">units:</label>
        <select id="unit_sel" name="units">
            <option value="1">AU</option>
            <option value="500">LS</option>
        </select>
    </div>
    <button type="submit" class="btn btn-warning">Give advice</button>
</form></div>