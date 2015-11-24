<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function(){
			
			$('.eliminar').click(function() { 
				id = this.id;
				if($('#slc_facultad'))
					id_facultad = $('#slc_facultad').val();
				else
					id_facultad = false;
				$.post('<?=base_url()?>index.php/carreras/crear/obtener_nombre', {slc_facultad : id_facultad, id : id}, function (carrera) {
					if(confirm('Seguro que quieres eliminar la carrera "' + carrera + '"')){
						$.post('<?=base_url()?>index.php/carreras/crear/eliminar', {slc_facultad : id_facultad, id : id}, function (respuesta) {
								$('#detalle').html(respuesta);
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

	if($carreras){
		$contador = 1;
		foreach($carreras->result() as $row){
			$cant_cursos = 0;
			$cursos = $this->m_carreras->get_cursos($row->id_facultad, $row->id_carrera);
			if($cursos)
				$cant_cursos = $cursos->num_rows() - 1;

			$inscripciones  = $this->m_inscripciones_curso->get_inscripciones($row->id_facultad, false, $row->id_carrera);
			$asignaturas = $this->m_asignaturas->get_asignaturas($row->id_facultad, $row->id_carrera);
			$relacion = $this->m_carreras->get_relacion_sede_carrera($row->id_facultad, $row->id_carrera);
//$asignaturas = false;

			if($inscripciones || $asignaturas || $relacion){
				$eliminar = false;
			}else{
				$eliminar = true;
			}
			$this->table->add_row(array(
					$contador ++,
					$row->carrera,
					array('data' => $cant_cursos, 'style' => 'text-align:center'),
					($eliminar)? '<span class=eliminar id=' . $row->id_carrera . '>Eliminar</span>' :'En uso',
				));	
		}
		$this->table->set_heading(array('N<sup>ro</sup>', 'Carreras', 'Cursos', 'Opciones'));	
		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="1" class=lista>'));
		echo $this->table->generate();	
		
	}else{
		echo 'No hay carreras registrado';
	}
?>
</body>
</html>