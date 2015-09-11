<h2 class="inside_headers_orange">top pilots</h2>
<table style="width:100%;">
    <?php $pilots=\App\Point::take(5)->orderBy('points', 'desc')->get();?>
    @foreach($pilots as $pilot)
        <tr><td width="90%">CMDR {{$pilot->user->name}}</td><td> <span class="white">{{$pilot->points}}</span></td></tr>
    @endforeach

</table>