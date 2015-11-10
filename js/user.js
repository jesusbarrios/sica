

$(document).ready(function () {	
	$('.delete').on('click', function() {
	
		var id = $(this).attr('id');

		$.ajax({
			url : 'http://localhost/sica/user/rol/delete',
			type : 'POST',
			data : { id_rol : id},
 
			success:function (data) {
                            
				$('#lista').html(data);
			}
		});
	});
});