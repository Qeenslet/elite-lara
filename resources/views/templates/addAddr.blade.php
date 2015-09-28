<form class="form-inline" method="POST" action="{{route('addAddress')}}" id="address_adder">
    <input type="hidden" name="_token" value="{{csrf_token()}}">
    <h2>Adding new star system</h2>
    <h3>System name</h3>
    <div class="form-group" id="off_normal" style="display: none;">
        <label for="one_name">The star name:</label>
        <input type="text" class="form_add_1" id="one_name" name="one_name" placeholder="Monocerotis 20">
    </div>
    <div class="form-group" id="if_normal_1">
        <label for="region_add">Region:</label>
        <input type="text" class="form_add_1" id="region_add" name="region" placeholder="Plaa Trua" list="regions" autocomplete="on">
        <datalist id="regions">
            @foreach($regions as $one)
                <option>{{$one->name}}</option>
            @endforeach
        </datalist>
    </div>
    <div class="form-group" id="if_normal_2">
        <label for="code_name">Code in the region:</label>
        <input type="text" class="form_add_1" id="code_name" name="code_name" placeholder="EG-Y D76">
    </div>
    <div class="form-group">
        <button class="btn btn-primary" id="spec">The named star</button>
    </div>
    <div>
        <button type="submit" class="btn btn-success"><span class="glyphicon glyphicon-plus"></span> Add</button>
    </div>
</form>
<script>
    $('#spec').click(function(e){
        e.preventDefault();
        $('#if_normal_2').toggle();
        $('#if_normal_1').toggle();
        $('#off_normal').toggle();
        $('#address_adder').trigger( 'reset' );
        if ($('#off_normal').is(':visible') )
        {
            $('#spec').html('Ordinary star');
        }
        else
            $('#spec').html('The named star');
    });
</script>