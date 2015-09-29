/**
 * Created by egorg_000 on 27.09.2015.
 */
coord = $('#stats').offset();
$('.extra').mouseover(function(eventObject)
    {
        data_tooltip = $(this).attr("data-tooltip");
        scrolled = window.pageYOffset;
        if (coord.top > scrolled)
            shift = 0;
        else
            shift = scrolled - coord.top;
        //if(firstmeasure > scrolled + 200) shift = 0;
        $("#tooltip").html(data_tooltip)
            .css({
                "top" : shift
            })
            .show();
    }).mouseout(function () {

    $("#tooltip").hide()
        .html("")
        .css({
            "top" : 0
        })
});