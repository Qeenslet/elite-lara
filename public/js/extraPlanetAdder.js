var lockerRock = 0;
var lockerGas = 0;
var lockerDigit = 0;

function blockKey()
{
    $('#addExtraData').addClass('disabled');
}

function releaseKey()
{
    $('#forErrors').html('');
    $('#addExtraData').removeClass('disabled');
}

function displayVals()
{
    var multipleValues = $( "#multiple_gas" ).val();

    $('#'+multipleValues).show();

}

function checkPercentsGas()
{
    var percent = 0;
    $('.resetMe').each(
        function(){
            value = $(this).val() / 1;
            percent += value;
        }
    );
    percent = looseRound(percent);
    if (percent > 100)
    {
        lockerGas = 1;
        locker();
        toMuchGas();
    }
    else
        lockerGas = 0;
        locker();

}

function checkPercentsRock()
{
    var percent = 0;
    $('.rockSolid').each(
        function()
        {
            value = $(this).val() / 1;
            percent += value;
        }
    );
    percent = looseRound(percent);
    if (percent > 100)
    {
        lockerRock = 1;
        locker();
        toMuchRock();
    }
    else
        lockerRock = 0;
        locker();
}

function checkDigits()
{
    var reg = /[^0-9.-]/;
    val = $(this).val();
    if(reg.test(val))
    {
       lockerDigit = 1;
       locker();
       digitalWarning();
    }
    else
       lockerDigit = 0;
       locker();

}

function locker()
{
    if (lockerDigit == 1 || lockerGas == 1 || lockerRock == 1)
        blockKey();
    else
        releaseKey();
}

function looseRound(number)
{
    number *= 1000;
    number = Math.round(number);
    return number / 1000;
}

$( "#multiple_gas" ).change( displayVals );
$('.resetMe').change( checkPercentsGas );
$('.rockSolid').change( checkPercentsRock );
$('.digits').change( checkDigits );

$('#clearList').click(function(e){
    e.preventDefault();
    $('.gasses').hide();
    $('.resetMe').each(
        function(){
            $(this).val('0');
        }
    );
    $('#multiple_gas').val('0');
    checkPercentsGas();
});

