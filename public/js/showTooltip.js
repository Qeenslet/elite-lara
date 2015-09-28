/**
 * Created by egorg_000 on 27.09.2015.
 */
$('.extra').mouseover(function(eventObject)
    {
        data_tooltip = $(this).attr("data-tooltip");

        $("#tooltip").html(data_tooltip)
            .css({
                "top" : eventObject.pageY - 350,
                "left" : eventObject.pageX - 600
            })
            .show();
    }).mouseout(function () {

    $("#tooltip").hide()
        .html("")
        .css({
            "top" : 0,
            "left" : 0
        })
});