<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function(){
			
			$('.eliminar').click(function() { 
				id = this.id;
				$.post('<?=base_url()?>index.php/facultades/crear/obtener_nombre', {id : id}, function (respuesta) {

					if(confirm('Seguro que quieres eliminar la facultad "' + respuesta + '"')){
					
						$.post('<?=base_url()?>index.php/facultades/crear/eliminar', {id : id}, function (respuesta) {
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

	if($facultades){
		$this->load->model('m_facultad', '', TRUE);
		$contador = 1;
		foreach($facultades->result() as $row){
			$carreras = $this->m_carreras->get_carrera($row->id_facultad);
			if($carreras){
				$eliminar = false;
			}else{
				$eliminar = true;
			}
			$this->table->add_row(array(
					$contador ++,
					$row->facultad,
					date('d/m/Y', strtotime($row->creacion)),
					($eliminar)? '<span class=eliminar id=' . $row->id_facultad . '>Eliminar</span>' :'En uso',
				));	
		}
		
		if($facultades->num_rows() > 1)
			$this->table->set_heading(array('N<sup>ro</sup>', 'Facultades', 'Fechas de creación', 'Operaciones'));	
		else
			$this->table->set_heading(array('N<sup>ro</sup>', 'Facultad', 'Fecha de creación', 'Operacion'));	
			
		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="1" class=lista>'));
		echo $this->table->generate();	
		
	}else{
		echo 'No hay facultad registrado';
	}

?>
</body>
</html>