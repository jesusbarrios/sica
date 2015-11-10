<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function(){
			$('.eliminar').click(function(args) {
				carrera = $('#slc_carrera').val();
				semestre = $('#slc_semestre').val();
				asignatura = this.id;
				$('#frm_msn').hide();
				
				$.post('<?=base_url()?>asignaturas/crear/obtener_nombre_asignatura', {slc_carrera : carrera, slc_semestre : semestre, asignatura : asignatura}, function (nombre_asignatura) {

					if(confirm('Desea eliminar la asignatura "' + nombre_asignatura + '"?')){

						$.post('<?=base_url()?>asignaturas/crear/eliminar', {slc_carrera : carrera, slc_semestre : semestre, asignatura : asignatura}, function (respuesta) {		
								$('#detalle')
								.html(respuesta)
								.show('fast')
						});
					}
				});
			})
		});
	</script>

	<style>
		table.detalles{
			margin: 10px auto;
		}
		
		 table.detalles td{
			padding: 5px 3px;
		}
		
		table.detalles span.eliminar{
			color: #bb0000;
			text-decoration: underline;
			cursor: pointer;
		}
	</style>
</head>

<body>
<?php
	if($periodos){
		$contador = 1;
		foreach($periodos->result() as $row){
		}
	}else{
		$this->table->set_heading(array('No hay periodos registrado'));
	}

	$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0" class="detalles">'));
	echo $this->table->generate();
?>
</body>
</html>