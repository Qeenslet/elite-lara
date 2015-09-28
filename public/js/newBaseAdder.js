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
    var data;
    var modal;
    var closer;

    function openModal()
    {
        data = 'go=1';
        modal = fx.initModal();
        closer="<span class='glyphicon glyphicon-remove' aria-hidden='true'></span>";
        $('<a>').attr('href', '#')
            .addClass('modal-close-btn')
            .html(closer)
            .click(function(event){
                event.preventDefault();
                modal.remove();
                $('#jquery-overlay').remove();
            })
            .appendTo(modal);
    }

    function sendTo(addr)
    {
        $.ajax({
            'type':'GET',
            'url': addr,
            'data':data,
            'success':function(data){
                modal.append(data);

            },
            'error':function(msg){
                modal.append(msg)}
        });
    }

    $('#addNew').click(function(cc){
        cc.preventDefault();
        openModal();
        sendTo('/getaddr');

    });

    $('#addNewStar').click(function(cc){
        cc.preventDefault();
        openModal();
        data=$('#addNewStar').attr('data');
        sendTo('/getstar');
    });

    $('.addNewPlanet').click(function(cc){
        cc.preventDefault();
        openModal();
        data=$(this).attr('data');
        sendTo('/getplanet');
    });

    $('#addBarycenter').click(function(cc){
        cc.preventDefault();
        openModal();
        data=$('#addBarycenter').attr('data');
        sendTo('/getbary');
    });
    $('.starsS').click(function(cc){
        cc.preventDefault();
        openModal();
        data=$(this).attr('data');
        sendTo('/getstardata');
    });

    $('.planetsS').click(function(cc){
        cc.preventDefault();
        openModal();
        data=$(this).attr('data');
        sendTo('/getplanetdata');
    });
})
