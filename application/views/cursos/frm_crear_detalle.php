<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function(){
			$('.eliminar').click(function() { 
				facultad= $('#slc_facultad').val();
				carrera = $('#slc_carrera').val();
				curso 	= this.id;
				$.post('<?=base_url()?>index.php/cursos/crear/obtener_nombre', {slc_facultad : facultad, slc_carrera : carrera, id : curso}, function (nombre) {
					if(confirm('Seguro que quieres eliminar el curso "' + nombre + '"')){
						$.post('<?=base_url()?>index.php/cursos/crear/eliminar', {slc_facultad : facultad, slc_carrera : carrera, id : curso}, function (respuesta) {
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

	if($cursos){
		$contador = 1;
		foreach($cursos->result() as $row){
			$asignaturas = $this->m_asignaturas->get_asignaturas($row->id_facultad, $row->id_carrera, $row->id_curso);
			if($asignaturas)
				$cant_asignaturas	= $asignaturas->num_rows();
			else
				$cant_asignaturas	= 0;

			$this->table->add_row(array(
					$contador ++,
					$row->curso,
					$row->tipo_curso,
					array('data' => $cant_asignaturas, 'style' => 'text-align:center'),
					($asignaturas)? 'En uso' : '<span class=eliminar id=' . $row->id_curso . '>Eliminar</span>',
				));	
		}
		$this->table->set_heading(array('N<sup>ro</sup>', 'Cursos', 'Tipos', 'Asignaturas', 'Opciones'));	
		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="1" class=lista>'));
		echo $this->table->generate();	
	}	
?>
</body>
</html>