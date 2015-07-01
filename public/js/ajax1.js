$(function(){
$('#1st_selection').change(function() {
								var y;
								$('#query_select option:selected').each(function(){
																		y=$(this).val();
																	});
								y = "form="+y;
								$.ajax({
										type: 'POST',
										url:'ajax',
										data: y,
										success: function(html) {
										$('#2nd_selection').empty();
                                                                                $('#result').empty();
										$('#2nd_selection').append(html);
												},
										error:  function(xhr, str){
										alert('Возникла ошибка: ' + xhr.responseCode);
											}
										});
							});	
});