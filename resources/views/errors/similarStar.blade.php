<div id="ajax-response" class="alert alert-warning">
    <strong><span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span></strong> Данная звезда уже была внесена в базу. Кроме нее в этой системе нам уже известны следующие объекты:<br>
    @foreach($message->starsIn as $key=>$value)
        Звезда: {{$value}} <br>
        Планеты:<br>
        @foreach($message->planetsIn[$key] as $planet)
                        {{$planet}} <br>
        @endforeach
    @endforeach
</div>
<script>
    document.getElementById("show_planet").reset();
</script>