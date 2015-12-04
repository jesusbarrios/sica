<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function(){
			$('.eliminar').click(function() { 
				facultad 	= $('#slc_facultad').val();
				carrera 	= $('#slc_carrera').val();
				asignatura1	= $('#slc_asignatura1').val();
				asignatura2	= this.id;
				$.post('<?=base_url()?>index.php/asignaturas/correlatividad/obtener_nombre', {slc_facultad : facultad, slc_carrera : carrera, slc_asignatura : asignatura2}, function (nombre) {
					if(confirm('Seguro que quieres eliminar la correlatividad "' + nombre + '"')){
						$.post('<?=base_url()?>index.php/asignaturas/correlatividad/eliminar', {slc_facultad : facultad, slc_carrera : carrera, slc_asignatura1 : asignatura1, slc_asignatura2 : asignatura2}, function (respuesta) {
							alert(respuesta)
							$('#detalles').html(respuesta);
						});	
					}
				});
			});
		});
	</script>
	
	<style>
		.eliminar{
			color: red;
		}
		.eliminar:hover{
			cursor : pointer;
		}
		table.lista{
			margin: 10px auto;
		}
		table.lista td{
			padding: 3px;
		}
	</style>
	
</head>

<body>
<?php
	//MENSAJE
	if($msn)
		echo "<div id=msn class=ok>$msn</div>";

	if($correlatividades){
		$contador = 1;
		foreach($correlatividades->result() as $row){
			$this->table->add_row(array(
					$contador ++,
					$row->curso,
					$row->asignatura,
					'<span class=eliminar id=' . $row->id_asignatura . '>Eliminar</span>',
				));	
		}
		$this->table->set_heading(array('N<sup>ro</sup>', 'Cursos', 'Asignaturas', 'Opciones'));	
		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="1" class=lista>'));
		echo $this->table->generate();	
	}
?>
</body>
</html>