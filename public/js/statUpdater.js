function statUpdater(id) 
{
    var pilotId="id="+id;
    $.ajax({
				type: 'POST',
				url:'ajax/statUpdater',
				data: pilotId,
				success: function(html) {
					$('#personalStat').empty();
					$('#personalStat').append(html);
				},
				error:  function(xhr, str){
                alert('Возникла ошибка: ' + xhr.responseCode);
            }
		});
}


