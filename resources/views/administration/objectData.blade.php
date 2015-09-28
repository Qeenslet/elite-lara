<h3 class="white">Editing the object</h3>
<h4 class="white">Changes</h4>
@if($data['type']=='star')
    <?php
    $starData=\App\Myclasses\StarInfo::getFromDb($data['id']);
    $stars=\App\Myclasses\Arrays::allStarsArray(true);
    $sizes=\App\Myclasses\Arrays::sizeTypeArray();
    ?>
    <h5>Provided the data: <span class="white">{{$starData->user->name}}</span></h5>
    <form class="form-inline" method="get" action="{{route('changeObject')}}">
        <input type="hidden" value="{{$data['id']}}" name="id">
        <input type="hidden" value="star" name="type">
        <input type="hidden" value="change" name="action">
        <label for="starD"> Star:</label>
        <select name="star" id="starD">
            <option value="{{$starData->star}}">{{$stars[$starData->star]}}</option>
            @foreach($stars as $key=>$value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        </select>
        <label for="classD"> Class</label>
        <select name="class" id="classD">
            <option>{{$starData->class}}</option>
            @for($n=0; $n<10; $n++)
                <option value="{{$n}}">{{$n}}</option>
            @endfor
        </select>
        <label for="sizeD"> Size</label>
        <select name="size" id="sizeD">
            <option value="{{$starData->size}}">{{$sizes[$starData->size]}}</option>
            @foreach($sizes as $key=>$value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        </select>
        <label for="codeD"> Code in the system</label>
        <input type="text" name="code" value="{{$starData->code}}" id="codeD">
        <button type="submit" class="btn btn-warning">Change</button>
    </form>
    <h4 class="white">Delete</h4>
    <form method="get" action="{{route('changeObject')}}">
        <input type="hidden" value="{{$data['id']}}" name="id">
        <input type="hidden" value="star" name="type">
        <input type="hidden" value="delete" name="action">
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
@endif

@if($data['type'] == 'multi')
    <?php
    $centerData=\App\Baricenter::find($data['id']);
    $markedStars = $centerData->stars()->get();
    $allStars = $centerData->address->stars()->get();
    ?>
    <form class="form-inline" method="get" action="{{route('changeObject')}}">
        <input type="hidden" value="{{$data['id']}}" name="id">
        <input type="hidden" value="{{$data['type']}}" name="type">
        <input type="hidden" value="change" name="action">
        <p>Barycenter of the stars</p>
        <ul>
            @foreach($markedStars as $star)
                <li>{{\App\Myclasses\Arrays::nameStar($star)}}</li>
            @endforeach
        </ul>
        <label for="stars">Select stars in the system to assign</label>
        <select name="stars[]" id="stars" multiple="multiple">
            @foreach($allStars as $star)
                <option value="{{$star->id}}">{{\App\Myclasses\Arrays::nameStar($star)}}</option>
            @endforeach
        </select>
        <button type="submit" class="btn btn-warning">Change</button>
    </form>
    <h4 class="white">Delete</h4>
    <form method="get" action="{{route('changeObject')}}">
        <input type="hidden" value="{{$data['id']}}" name="id">
        <input type="hidden" value="{{$data['type']}}" name="type">
        <input type="hidden" value="delete" name="action">
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
@endif

@if($data['type'] == 'planet' || $data['type'] == 'bari')
    <?php
            switch($data['type'])
            {
                case 'planet':
                    $planetData=\App\Planet::find($data['id']);
                    break;
                default:
                    $planetData=\App\Bariplanet::find($data['id']);
                    break;
            }
    $planets=\App\Myclasses\Arrays::planetsForCabinet();
    ?>
    <h5>Provided the data: <span class="white">{{$planetData->user->name}}</span></h5>
    <form class="form-inline" method="get" action="{{route('changeObject')}}">
        <input type="hidden" value="{{$data['id']}}" name="id">
        <input type="hidden" value="{{$data['type']}}" name="type">
        <input type="hidden" value="change" name="action">
        <label for="planetD">Planet</label>
        <select name="planet" id="planetD">
            <option value="{{$planetData->planet}}">{{$planets[$planetData->planet]}}</option>
            @foreach($planets as $key=>$value)
                <option value="{{$key}}">{{$value}}</option>
            @endforeach
        </select>
        <label for="distanceD">Distance</label>
        <input type="text" name="distance" value="{{$planetData->distance}}" id="distanceD">
        <label for="markD">Mark</label>
        <select name="mark" id="markD">
                <option>{{$planetData->mark}}</option>
                 <option>sin</option>
                 <option>bin</option>
                 <option>tri</option>
                 <option>qua</option>
                 <option>sat</option>
        </select>
        @if($data['type'] == 'planet')
            <label for="showHide">Indexation scope</label>
            <select name="show" id="showHide" class="middleSelect">
                @if($planetData->show == 'true')
                    <option value="true">Keep displaying it</option>
                    <option value="false">Hide it</option>
                @else
                    <option value="false">Keep hiding it</option>
                    <option value="true">Display it</option>
                @endif

            </select>
        @endif
        <button type="submit" class="btn btn-warning">Change</button>
    </form>
    <h4 class="white">Delete</h4>
    <form method="get" action="{{route('changeObject')}}">
        <input type="hidden" value="{{$data['id']}}" name="id">
        <input type="hidden" value="{{$data['type']}}" name="type">
        <input type="hidden" value="delete" name="action">
        <button type="submit" class="btn btn-danger">Delete</button>
    </form>
@endif