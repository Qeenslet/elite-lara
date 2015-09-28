function changeBack()
{
    var number = Math.random() * (7 - 1) + 1;
    number = parseInt(number);
    var url = 'url(/media/background/screen-' + number + '.jpg';
    $('body').css('background-image', url);
}

