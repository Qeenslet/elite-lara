<div id="ajax-response" class="alert alert-success">
    <strong><span class="glyphicon glyphicon-ok" aria-hidden="true"></span></strong> Информация успешно внесена в базу данных!
</div>
<script>
    document.getElementById("show_planet").reset();
    var data='_token={{csrf_token()}}&id={{$aId}}';
    loadSystem(data);
    updateStat(data);
</script>