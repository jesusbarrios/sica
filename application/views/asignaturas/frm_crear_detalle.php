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
				curso 		= $('#slc_curso').val();
				asignatura 	= this.id;
				$.post('<?=base_url()?>index.php/asignaturas/crear/obtener_nombre', {slc_facultad : facultad, slc_carrera : carrera, slc_curso : curso, id : asignatura}, function (nombre) {
					if(confirm('Seguro que quieres eliminar la asignatura "' + nombre + '"')){
						$.post('<?=base_url()?>index.php/asignaturas/crear/eliminar', {slc_facultad : facultad, slc_carrera : carrera, slc_curso : curso, id : asignatura}, function (respuesta) {
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

	if($asignaturas){
		$contador = 1;
		foreach($asignaturas->result() as $row){
			$correlatividades  = $this->m_asignaturas->get_correlatividades($row->id_facultad, $row->id_carrera, $row->id_curso, $row->id_asignatura);
			$correlatividades2 = $this->m_asignaturas->get_correlatividades($row->id_facultad, $row->id_carrera, false, false, $row->id_curso, $row->id_asignatura);

			if($correlatividades)
				$cant_correlatividades1 = $correlatividades->num_rows();
			else
				$cant_correlatividades1 = 0;

			if($correlatividades2)
				$cant_correlatividades2 = $correlatividades2->num_rows();
			else
				$cant_correlatividades2 = 0;

			$this->table->add_row(array(
					$contador ++,
					$row->codigo,
					$row->asignatura,
					$cant_correlatividades1,
					$cant_correlatividades2,
					($correlatividades || $correlatividades2)? 'En uso' : '<span class=eliminar id=' . $row->id_asignatura . '>Eliminar</span>',
				));	
		}
		$this->table->set_heading(array('N<sup>ro</sup>', 'Código', 'Asignaturas', array('data' => 'Correlatividades', 'colspan' => 2), 'Opciones'));	
		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="1" class=lista>'));
		echo $this->table->generate();	
	}
?>
</body>
</html>