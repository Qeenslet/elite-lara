<h2>Star data</h2>
<form id="addStar" action="{{route('addStar')}}" method="POST" class="form-inline">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <input type="hidden" name="address" value="{{$addrId}}">
    <div class="form-group">
        <label for="star_sel">Star type:</label>
        <select id="star_sel" name="star" class="middleSelect">
            <option></option>
            @foreach ($stars as $num => $one)
                <option value="{{$num}}">{{$one}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group" id="hideclass">
        <label for="temp_sel">Temperature class:</label>
        <select id="temp_sel" name="class">
            <option></option>
            @for($i=0; $i<10; $i++)
                <option>{{$i}}</option>
            @endfor
        </select>
    </div>
    <div class="form-group" id="hidesize">
        <label for="size_sel">Size:</label>
        <select  id="size_sel" name="size">
            <option></option>
            @foreach ($sizes as $val => $si)
                <option value="{{$val}}">{{$si}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="code_sel">Code in the system:</label>
        <input type="text" id="code_sel" name="code" placeholder="A">
    </div>
    <div>
    <button type="submit" class="btn btn-warning" id="change_b_star">Add star</button>
    </div>
</form>
<script>
    $('#addStar').change(function()
    {
        var sVal=$('#star_sel').val()
        if(sVal==15 || sVal==16) {
           $('#hideclass').hide();
           $('#hidesize').hide();
        }
        else {
            $('#hideclass').show();
            $('#hidesize').show();
        }
    });
</script>