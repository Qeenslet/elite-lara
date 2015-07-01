$(function(){
    var fx = {
        'initModal':function(){
            if($('.modal-window').length==0){
                $('<div>').attr('id', 'jquery-overlay')
                    .fadeIn('slow')
                    .appendTo('body');
                return $('<div>').addClass('modal-window').appendTo('body');
            }
            else {
                return $('.modal-window')
            }
        }

    }
    $('.pointed').bind('click', function(e){
        e.preventDefault();
        var data = $(this).attr('data');
        var modal = fx.initModal();
        var closer="<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
        $('<a>').attr('href', '#')
            .addClass('modal-close-btn')
            .html(closer)
            .click(function(event){
                event.preventDefault();
                modal.remove();
                $('#jquery-overlay').remove();
            })
            .appendTo(modal);


        $.ajax({
            'type':'POST',
            'url':'/ajamoder',
            'data':'target='+data,
            'success':function(data){
                modal.append(data);

            },
            'error':function(msg){
                modal.append(msg)}
        });

    });
});
