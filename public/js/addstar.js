function addstar()
{
    //Получаем параметры из формы
	var msg = $('#star_adder').serialize();
	//Передаем их исполняющему файлу
		$.ajax({
				type: 'POST',
				url:'/ajaxadd',
				data: msg,
				success: function(html) {
					$('#messagies').empty();
					$('#messagies').append(html);
                    setTimeout(function(){
                        $('#ajax-response').fadeOut(1000);
                    },4000);
				},
                error: function(data){
                var errors = data.responseJSON;
                    errorsHtml = '<div class="alert alert-danger" id="ajax-response"><ul>';

                    $.each( errors, function( key, value ) {
                        errorsHtml += '<li>' + value[0] + '</li>'; //showing only the first error.
                    });
                    errorsHtml += '</ul></di>';
                    $('#messagies').empty();
                    $('#messagies').html(errorsHtml);
                    setTimeout(function(){
                        $('#ajax-response').fadeOut(1000);
                    },10000);

                }

		});
}


