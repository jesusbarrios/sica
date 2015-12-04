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

	if($carreras){
		$contador = 1;
		foreach($carreras->result() as $row){
			$cursos 	= $this->m_cursos->get_cursos($row->id_facultad, $row->id_carrera);
			$asignaturas= $this->m_asignaturas->get_asignaturas($row->id_facultad, $row->id_carrera);
			$relaciones = $this->m_carreras->get_relacion_sede_carrera($row->id_facultad, false, $row->id_carrera);

			if($cursos)
				$cant_cursos 	= $cursos->num_rows();
			else
				$cant_cursos 	= 0;
			if($asignaturas)
				$cant_asignaturas = $asignaturas->num_rows();
			else
				$cant_asignaturas = 0;

			$this->table->add_row(array(
					$contador ++,
					$row->codigo,
					$row->carrera,
					array('data' => $cant_cursos, 'style' => 'text-align:center'),
					array('data' => $cant_asignaturas, 'style' => 'text-align:center'),
					($cursos || $relaciones)? 'En uso' : '<span class=eliminar id=' . $row->id_carrera . '>Eliminar</span>',
				));	
		}
		$this->table->set_heading(array('N<sup>ro</sup>', 'Códigos', 'Carreras', 'Cursos', 'Asignaturas', 'Opciones'));	
		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="1" class=lista>'));
		echo $this->table->generate();	
	}
?>
</body>
</html>