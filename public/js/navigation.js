$(function(){

function moveNav(a) {
  first=1;
  if (a=='l') --navegator;
  if (a=='r') ++navegator;
  if (navegator<lowlimit) navegator=toplimit;
  if (navegator>toplimit) navegator=lowlimit;
  changeLegend(navegator);
  if (basenav['func']=='ajax') {
      var token=$('#navigation_bar').attr('data');
      var data='form='+navegator+'&_token='+token;
      $.ajax({
	type: 'POST',
	url:'/ajaform',
        data: data,
	success: function(html) {
	$('#2nd_selection').empty();
        $('#result').empty();
        $('#2nd_selection').append(html);
		},
        error:  function(xhr, str){
	alert('Возникла ошибка: ' + data);
		}
    });
  };
};
function changeLegend(navegator) {
 var legLeft=navegator-1;
 var legRght=navegator+1;
 if (legLeft<lowlimit) legLeft=toplimit;
 if (legLeft>toplimit) legLeft=lowlimit;
 if (legRght<lowlimit) legRght=toplimit;
 if (legRght>toplimit) legRght=lowlimit;
    $('#button_left').attr('title', basenav[legLeft]);
    $('#button_right').attr('title', basenav[legRght]);
    $('#db_head').text(basenav[navegator]);
};

$('#button_left').bind('click', function(event){
                            if (basenav['func']=='url') return true;
                            event.preventDefault();
                            moveNav('l');
                           });
$('#button_right').bind('click', function(even){
                            if (basenav['func']=='url') return true;
                            even.preventDefault();
                            moveNav('r')});    
})
