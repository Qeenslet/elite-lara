$(function() {
    $('.masslink').bind('click', function(e){
            e.preventDefault();
            var data='#'+$(this).attr('data');
            if ($(data).is(":hidden")) {
                $(data).slideDown();
            }
            else {
                $(data).slideUp();
            };
    });
    
})