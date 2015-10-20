/**
 * Created by egorg_000 on 20.10.2015.
 */
$('#region_add').keypress(function()
{
    string = $('#region_add').val();
    if(string.length > 1 && string.length < 3)
    {
        data = 'string='+string;
        token = $("#_token").val();
        data += '&_token='+token;
        $.ajax({
            'type':'POST',
            'url':'/getregionletter',
            'data':data,
            'success':function(data){
                $('#regions').empty();
                $('#regions').append(data);

            },
            'error':function(msg){
                $('#result').append(msg)}
        });
    }
});