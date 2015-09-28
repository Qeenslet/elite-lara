$('.extraP').click(function(e){
    e.preventDefault();
    target = $(this).attr('data');
    object = $(this).attr('data-object');

    $('#'+object+target).slideToggle();
    setTimeout(changeName, 500, target, object);
});