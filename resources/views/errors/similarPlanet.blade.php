<div id="ajax-response" class="alert alert-danger">
    <strong><span class="glyphicon glyphicon-alert" aria-hidden="true"></span></strong> {{$message}}
</div>
@if(isset $aId)
<script>
    var data='_token={{csrf_token()}}&id={{$aId}}';
    loadSystem(data);
</script>
@endif