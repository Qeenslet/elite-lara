<h3>Planet details</h3>
@foreach($planet['extra'] as $key=>$value)
    @if($key == 'composition')
       <span class='white'>Composition:</span>
       <ul>
        @foreach($value as $item=>$percent)
            <li>{{$item}} {{$percent}}</li>
        @endforeach
        </ul>
        <?php continue; ?>
    @endif

    @if($key == 'atmosphereC')
        <span class='white'>Atmosphere composition:</span>
        <ul>
            @foreach($value as $item=>$percent)
                <li>{{$item}} {{$percent}}</li>
            @endforeach
        </ul>
        <?php continue; ?>
    @endif
    @if($key == 'Tidally locked' && $value == 'no')
        <?php continue; ?>
    @endif
    @if($key == 'price, credits:' && $value == 0)
        <?php continue; ?>
    @endif
    @if($key == 'Tidally locked')
        <span class='white'>{{$key}}</span>
        <?php continue; ?>
    @endif
    <span class='white'>{{$key}}</span> {{$value}} </br>
@endforeach
