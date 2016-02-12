@extends('app')
@section('content')
    <form class="form-inline" id="forma">
        <input type="hidden" value="{{csrf_token()}}" name="_token">
        <div class="form-group">
            <label for="planet_select">планеты</label>
            <select id="planet_select" name="planet" class="middleSelect">
                <option value="0">T-мталлик</option>
                <option value="1">T-водный</option>
                <option value="3">Землеподобные</option>
                <option value="4">Водные</option>
                <option value="5">Аммиачные</option>
            </select>
        </div>
        <div class="form-group">
            <label for="compare_select">Параметр</label>
            <select id="compare_select" name="type">
                <option value="g">гравитация</option>
                <option value="s">размер</option>
                <option value="t">температура</option>
                <option value="m">масса</option>
                <option value="p">давление</option>
                <option value="a">атмосфера</option>
                <option value="v">вулканизм</option>
                <option value="sg">газ</option>
                <option value="so">орбита</option>
            </select>
        </div>
        <div class="form-group" id="show_gas" style="display: none;">
            <label for="gas_select">Газы</label>
            <select id="gas_select" name="gas">
                @foreach(\App\Myclasses\Arrays::atmosphereComposition() as $key => $v)
                    <option value="{{$key}}">{{$v}}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group" id="show_orb" style="display: none;">
            <label for="orbit_select">Параметры орбиты</label>
            <select id="orbit_select" name="orbit">
                <option value="orbP">период обращения</option>
                <option value="mAxis">полуось</option>
                <option value="ecce">эксцентриситет</option>
                <option value="incl">наклонение</option>
                <option value="rotP">период обращения</option>
                <option value="peri">перицентр</option>
                <option value="aTilt">наклон оси</option>
            </select>
        </div>
        <button type="button" class="btn btn-warning" onclick="sendMe()">Search</button>
    </form>
<div id="result"></div>
@stop
@section('scripts')
    @parent
    <script>
        $('#compare_select').change(function ()
        {
            var move = $(this).val();
            if (move == 'sg')
            {
                $('#show_gas').show();
                $('#show_orb').hide();
            }
            else if (move == 'so')
            {
                $('#show_orb').show();
                $('#show_gas').hide();
            }
            else
            {
                $('#show_gas').hide();
                $('#show_orb').hide();
            }
        });

        function sendMe()
        {
            var message = $('#forma').serialize();
            $.ajax({
                type: "POST",
                url: '/moderation/uniter',
                data: message,
                success: function(data)
                {
                    $('#result').empty();
                    $('#result').append(data);
                },error:  function(data){
                    console.log(data);
                },
                dataType: 'html'
            });
        }
    </script>
@stop