$(document).ready(function () {
	
	$('#slc_sede').on('change', function() {
		var id = $(this).val();
		$.ajax({
			url : 'http://localhost/sica/funciones/cargar_slc_carrera',
			type : 'POST',
			data : { id_sede : id},
			success:function (data) {
				$('#slc_carrera').html(data);
				$('#lista').html("");
			}
		});
	});
/*	
	$('#slc_carrera').on('change', function() {
		var id_universidad = 1;
		var id_facultad = 1;
		var id_sede = $('#slc_sede').val();
		var id_carrera = $(this).val();
		var id_semestre = 1;
		var anho = 2013;
		$.ajax({
			url : 'http://localhost/sica/funciones/cargar_lista_semestre',
			type : 'POST',
			data : { id_universidad : id_universidad, id_facultad : id_facultad, id_sede : id_sede, id_carrera : id_carrera, id_semestre : id_semestre, anho : anho},
			success:function (data) {
				$('#lista').html(data);
			}
		});
	});

/*	
	$('#slc_sexo').on('change', function() {
		sexo = $(this).val();
		if(sexo == "masculino"){
		
			datos = "<option>Soltero</option><option>Casado</option>Divorciado</option><option>Viudo</option>";
			
		}else if(sexo == "femenino"{
			datos = "<option>Soltero</option><option>Casado</option>Divorciado</option><option>Viudo</option>";
		}else{
			datos = "<option>Soltero/a</option><option>Casado/a</option>Divorciado/a</option><option>Viudo/a</option>";
		}

		$('#slc_estado_cilvil').html(data);

	});
	
*/
	
	$()
	
});