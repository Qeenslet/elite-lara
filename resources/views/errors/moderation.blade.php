<div id="ajax-response" class="alert alert-warning">
    <strong><span class="glyphicon glyphicon-alert" aria-hidden="true"></span></strong> Внесенная вами планета не прошла статистическую проверку и была добавлена в список на модерацию. Один из модераторов сайта в ближайшее время
    рассмотрит ее. Возможно для одобрения данных потребуется скриншот с карты данной системы.
</div>
<script>
    document.getElementById("show_planet").reset();
    var data='_token={{csrf_token()}}&id={{$aId}}';
    loadSystem(data);
    updateStat(data);
</script>