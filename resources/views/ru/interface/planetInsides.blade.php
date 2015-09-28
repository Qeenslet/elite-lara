<h3>Данные по планете</h3>
@foreach($planet['extra'] as $key=>$value)
    @if($key == 'composition')
       <span class='white'>Состав планеты:</span>
       <ul>
        @foreach($value as $item=>$percent)
            <li>{{$item}} {{$percent}}</li>
        @endforeach
        </ul>
        <?php continue; ?>
    @endif

    @if($key == 'atmosphereC')
        <span class='white'>Состав атмосферы:</span>
        <ul>
            @foreach($value as $item=>$percent)
                <li>{{$item}} {{$percent}}</li>
            @endforeach
        </ul>
        <?php continue; ?>
    @endif
    @if($key == 'Приливный захват' && $value == 'no')
        <?php continue; ?>
    @endif
    @if($key == 'цена в кредитах: ' && $value == 0)
        <?php continue; ?>
    @endif
    @if($key == 'Приливный захват')
        <span class='white'>{{$key}}</span>
        <?php continue; ?>
    @endif
    <span class='white'>{{$key}}</span> {{$value}} </br>
@endforeach
