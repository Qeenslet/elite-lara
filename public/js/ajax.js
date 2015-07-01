function send(from)
{
    var addr="#"+from;	
    //Получаем параметры из формы
	var msg = $(addr).serialize();
	//Передаем их исполняющему файлу
		$.ajax({
				type: 'POST',
				url:'/ajachart',
				data: msg,
				success: function(html) {
					$('#result').empty();
					$('#result').append(html);
				},
				error:  function(xhr, str){
                alert('Возникла ошибка: ' + xhr.responseCode);
            }
		});
}