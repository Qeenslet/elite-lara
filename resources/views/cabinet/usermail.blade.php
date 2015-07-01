@extends('cabinet.cabinetMain')
@section('local')
    <script>
        var navegator=first=4;
        basenav={};
        basenav[4]='Входящие';
        basenav[5]='Исходящие';
        basenav[6]='Новое письмо';
        basenav['func']='ajax';
        var toplimit=6;
        var lowlimit=4;
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
            if (first==4) {
                var token = $('#navigation_bar').attr('data');
                var data = 'form=' + navegator + '&_token=' + token;
                $.ajax({
                    type: 'POST',
                    url: '/ajaform',
                    data: data,
                    success: function (html) {
                        $('#2nd_selection').empty();
                        $('#2nd_selection').append(html);
                    },
                    error: function (xhr, str) {
                        alert('Возникла ошибка: ' + data);
                    }
                });
            }
        })
    </script>
@stop