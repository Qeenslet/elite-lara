@extends('ru.administration.index')
@section('title')
    Почта|@parent
@stop
@section('locale')
    <script>
        var navegator=first=7;
        basenav={};
        basenav[7]='Входящие';
        basenav[8]='Исходящие';
        basenav[9]='Новое письмо';
        basenav['func']='ajax';
        var toplimit=9;
        var lowlimit=7;
    </script>
    <div id="navigation_bar" data="{{csrf_token()}}">
        <div id="button_left"><a href="#"></a></div>
        <div id="button_right"><a href="#"></a></div>
        <h3 id="db_head">Входящие</h3>
    </div>
    <div id="2nd_selection">

    </div>

@stop
@section('scripts')
    @parent
    <script>
        $(function(){
            if (first==7) {
                var token = $('#navigation_bar').attr('data');
                var data = 'form=' + navegator + '&_token=' + token;
                refresh(data);

            }
        });

        function refresh(data){
            $.ajax({
                type: 'POST',
                url: '/ajaform',
                data: data,
                success: function (html) {
                    $('#2nd_selection').empty();
                    $('#2nd_selection').append(html);
                },
                error: function (xhr, str) {
                    alert('Возникла ошибка');
                }
            });
        }
    </script>
@stop