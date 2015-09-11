<div class="panel-cabinet" id="chartAbout">
    <div style="margin: 5px; width:100%; height: 10%; position: relative; top:1px;"><a href="javascript:closeInfo();" class="info-close-btn"><span class="glyphicon glyphicon-remove" aria-hidden="true"></span></a></div>
    <br>
    <p>This plot represents each discovered planet with a dot. It's color represents the type of the planet. </p>
    <p>You can zoom in any area mark it with the left button of the mouse pressed.</p>
    <hr>
</div>
<form class="form-inline" method="POST" id="orbit_query" onsubmit="send('orbit_query');" action="javascript:void(null);">
    <input type="hidden" value="{{csrf_token()}}" name="_token">
    <div class="form-group">
        <label for="star_select">Star type</label>
        <select id="star_select" name="starOrb">
            @foreach ($count as $num => $one)
                <option value="{{$num}}">{{$one}}</option>
            @endforeach
        </select>
    </div>
    <div class="form-group">
        <label for="class_select">Class</label>
        <select id="class_select" name="classOrb">
            <option value="999">no matter</option>
            <?php for($i=0; $i<10; $i++) {
                echo "<option value='$i'>$i</option>";
            }?>
        </select>
    </div>
    <div class="form-group">
        <label for="size_select">Size</label>
        <select id="size_select" name="sizeOrb">
            <option value="999">no matter</option>
            <option value="5">V</option>
            <option value="4">IV</option>
            <option value="3">III</option>
            <option value="6">VI</option>
        </select>
    </div>
    <button type="submit" class="btn btn-warning" id="change_b">Search</button>
</form>
<hr>
<script>
    $('#star_select').change(function(){
        var select=$('#star_select').val();
        if(select==15 || select==16){
            $("#class_select").val(999).hide();
            $("#size_select").val(999).hide();
        }
        else {
            $("#class_select").show();
            $("#size_select").show();
        }
    })
</script>