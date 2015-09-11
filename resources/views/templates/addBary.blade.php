<h3>Barycenter data</h3>
<p>Please choose the stars which create the barycenter</p>
<form id="addBary" action="{{route('addBary')}}" method="POST" class="form-inline">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="address" value="{{$addrId}}">
    <label for="stars">Stars selection</label>
    <select name="stars[]" id="stars" multiple="multiple">
        @foreach($converter->getAllCenters() as $one)
            @foreach($converter->getOneCenter($one) as $star)
                @if($star['type']!='multi')
                    <option value="{{$star['id']}}">{{$star['name']}}</option>
                @endif
            @endforeach
        @endforeach
    </select>
    <div>
        <button type="submit" class="btn btn-warning" id="change_b_star">Add barycenter</button>
    </div>
</form>