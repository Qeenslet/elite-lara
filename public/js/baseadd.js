$(function() {
    var region=$('#region_add');
    var code=$('#code_name');
    var one=$('#one_name');
    var temp;
    var size;
    var select;
    //функция отслеживает отображение поля именной звезды
    $('#spec').change(function(){
	if ($('#spec').prop('checked')){
            $('#off_normal').show();
            $('#region_add').val('');
            $('#code_name').val('');
            $('#temp_sel').val('');
            $('#size_sel').val('');
            $('#star_sel').val('');
            check_form();
            $('#if_normal_1').hide();
            $('#if_normal_2').hide();
        }						
	else {
            $('#one_name').val('');
            $('#off_normal').hide();
            check_form();
            $('#if_normal_1').show();
            $('#if_normal_2').show();
        }
    });
    // функция прячет и показывает класс и размер в пункте свойств звезды для черных дыр и нейтронок
    $('#star_sel').change(function(){
        $('#star_sel option:selected').each(function(){
            select=undefined;
            select=$(this).val();
            if (select==='0') select+=0.5;
        });
    if (select==15||select==16) {
        $('#hidesize').fadeOut(200);
        $('#hideclass').fadeOut(200);
        $('#temp_sel').val('');
        $('#size_sel').val('');
           check_appear();
        }
    else {
        $('#hidesize').fadeIn(200);
        $('#hideclass').fadeIn(200);
        check_appear();
        }
        
    });
    //служебная функция записывает значение в переменную для температуры звезды
    $('#temp_sel').change(function(){
        $('#temp_sel option:selected').each(function(){
            temp=undefined;
            temp=$(this).val();
            if (temp==='0') temp+=0.5;
        });
        check_appear();
    });
   
    //служебная функция записывает в переменную размер звезды
    $('#size_sel').change(function(){
        $('#size_sel option:selected').each(function(){
            size=undefined;
            size=$(this).val();
            if (size==='0') size+=0.5;
        });
        check_appear();
    });
    //функция управляет появлением поля для внесения данных о планете
    function check_appear() {
    if((temp>0 && size>0 && select>0) || select==15 || select==16 ) {
        show_planet();
    }
    else {
        hide_planet();
    }
    }
    
    $('.form_add_1').each(function(){
        var form1=$(this);
        form1.find('.form_add_1').addClass('undone');
    });
    $('.form_add_1').change(function(){
        check_form();
        temp=size=select=0;
    });
    function check_form() {
    $('.form_add_1').each(function(){
        
            if($(this).val() !=''){
                $(this).addClass('done');
                $(this).removeClass('undone');
            }
            else {
                $(this).addClass('undone');
                $(this).removeClass('done');
            }
            if ((region.hasClass('done') && code.hasClass('done')) || one.hasClass('done')) {
                show_star();
            }
            else hide_star();
        
        
    });
    }
    function show_star() {
        $('#show_star').slideDown();
        $('#change_b_star').addClass('disabled');
    }
    function hide_star() {
        $('#show_star').slideUp();
        hide_planet();
        $('#temp_sel').val('');
        $('#size_sel').val('');
        $('#star_sel').val('');
    }
    
    function show_planet() {
        $('#show_planet').slideDown();
        $('#change_b_star').removeClass('disabled');
    }
    function hide_planet() {
        $('#show_planet').slideUp();
        $('#change_b_star').addClass('disabled');
    }
});