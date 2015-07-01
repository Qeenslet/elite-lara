
    function sendChart(aim){
        var data = $('#'+aim).attr('data');
        var cshow=0;
        (aim=='chart1')?cshow=1:cshow=0;

        $.ajax({
            'type':'POST',
            'url':'/ajamoder/charts',
            'data':data,
            'success':function(data){
                $('#result').empty();
                $('#result').append(data);
                if(cshow==1) $('#chartControl').show();
                else $('#chartControl').hide();

            },
            'error':function(msg){
                $('#result').append(msg)}
        });

    };

    function stepUp(i) {
        onestep/=1;
        var data=$('#chart3').attr('data');
        if(i==0) onestep-=1;
        if(i==1) onestep+=1;

        if (onestep>6) onestep=6;
        if (onestep<1) onestep=1;

        $('#char_dist').html(steps[onestep]+' а.е.');
        $.ajax({
            'type':'POST',
            'url':'/ajamoder/charts',
            'data':data+'&step='+steps[onestep],
        'success':function(data){
            $('#result').empty();
            $('#result').append(data);

        },
        'error':function(msg){
            $('#result').append(msg)}
    });
    }