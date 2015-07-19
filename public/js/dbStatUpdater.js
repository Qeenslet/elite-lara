function updateStat(msg){
    $.ajax({
        type: 'POST',
        url:'/ajaxdbstat',
        data: msg,
        success: function(html) {
            $('#stats').empty();
            $('#stats').append(html);
        },
        error:  function(e){
            console.log(e);
        }
    });
}
