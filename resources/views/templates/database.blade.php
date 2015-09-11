@extends('elite')
@section('title')
    Charts|@parent
@stop
@section('content')
<script>
    var navegator=first=0;
    basenav={};
    basenav[1]='Functional charts';
    basenav[2]='Pie charts';
    basenav[3]='Dotted charts';
    basenav[0]='Common data';
    basenav['func']='ajax';
    var toplimit=3;
    var lowlimit=0;
</script>
<div id="navigation_bar" data="{{csrf_token()}}">
    <div id="button_left"><a href="#"></a></div>
    <div id="button_right"><a href="#"></a></div>
    <h3 id="db_head">Common data</h3>
</div>
<p class="white">Here yoy can find different charts based on our database. To choose other types of charts press left/right buttons on the navigation panel.</p>
<hr>
<div id="2nd_selection">

</div>
<div id="result">

</div>
@stop
@section('scripts')
    @parent
    <script type="text/javascript" src="/js/ajax.js"></script>
    <script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script>
    <script type="text/javascript" src="/js/gray.js"></script>
    <script type="text/javascript" src="/js/drilldown.js"></script>
    <script type="text/javascript" src="/js/navigation.js"></script>
    <script>
        $(function(){
            if (first==0) {
                var token = $('#navigation_bar').attr('data');
                var data = 'form=' + navegator + '&_token=' + token;
                $.ajax({
                    type: 'POST',
                    url: '/ajaform',
                    data: data,
                    success: function (html) {
                        $('#2nd_selection').empty();
                        $('#result').empty();
                        $('#2nd_selection').append(html);
                    },
                    error: function (xhr, str) {
                        alert('Возникла ошибка: ' + data);
                    }
                });
            }
        });
        function closeInfo()
        {
            $('#chartAbout').slideUp(300);
        }
    </script>
@stop