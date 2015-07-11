function loadSystem(data1){
    $.ajax({
        type: 'POST',
        url:'/ajaxstat',
        data: data1,
        success: function(html) {
            $('#hereStat').empty();
            $('#hereStat').append(html);
        },
        error: function(data){
            $('#hereStat').empty();
            $('#hereStat').html(data);
        }
    });
}
