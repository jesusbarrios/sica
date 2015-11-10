<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function(){
			
			$('.eliminar').click(function() { 
				id = this.id;
				
				$.post('<?=base_url()?>index.php/carreras/obtener_nombre/' + id, '', function (carrera) {

					if(confirm("Seguro que quieres eliminar la carrera " + carrera)){
					
						$.post('<?=base_url()?>index.php/carreras/eliminar/' + id, '', function (respuesta) {
							
							$.post('<?=base_url()?>index.php/carreras/actualizar_lista/' + carrera, '', function (respuesta) {	
								$('#lista').html(respuesta)
							});
						});	
					}
				});
			});
		});
	</script>
	
</head>

<body>
<?php
	echo form_fieldset('Reporte de Carreras');
	
	if($carreras){
	
		$contador = 1;
		
		$this->load->model('m_carreras', 'carreras');
		
		foreach($carreras->result() as $row){
			
			$this->table->add_row(array(
				$contador ++,
				$row->carrera,
//				'<span class=eliminar id=' . $row->id_carrera . '>Eliminar</span>'
			));	
		}
		
		$this->table->set_heading(array('N<sup>ro</sup>', 'Carreras',));	
		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="1">'));
		echo $this->table->generate();	

		
	}else if(isset($mensaje)){
		echo $mensaje;
	}
	echo form_fieldset_close();
	
?>
</body>
</html>