<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function(){
			$('.eliminar').click(function() { 
				$('#slc_carrera').val(null);
				sede = $('#slc_sede').val();
				id = this.id;
				$.post('<?=base_url()?>index.php/carreras/habilitar/obtener_nombre', {id_sede : sede, id_carrera : id}, function (respuesta) {
					var datos = $.parseJSON(respuesta);
					if(confirm('Seguro que quieres eliminar la relación "' + datos['sede'] + '" - "' + datos['carrera'] + '"')){
						$.post('<?=base_url()?>index.php/carreras/habilitar/eliminar', {id_sede : sede, id_carrera : id}, function (respuesta) {
							$.post('<?=base_url()?>index.php/carreras/habilitar/actualizar_detalle', {slc_sede : sede, slc_carrera : id, sede : datos['sede'], carrera : datos['carrera']}, function (respuesta) {
								$('#detalles').html(respuesta)
							});
						});	

					}

				});
			});
		});
	</script>
	
	<style>
		table.detalles{
			margin: 10px auto;
		}
		
		.eliminar, .desabilitar{
			color:red;
			cursor : pointer;
		}
		.habilitar{
			color: green;
			cursor:pointer;
		}
		
/*		.eliminar:hover .desabilitar:hover{
			cursor : pointer;
		}
*/	</style>
	
</head>

<body>
<?php
		
	if($relaciones){
	
		$contador = 1;
		
		$this->load->model('m_carreras', 'carreras');
		
		foreach($relaciones->result() as $row){
		
//			$inscripciones = $this->carreras->get_inscripcion_asignatura($row->id_facultad, $row->id_sede, $row->id_carrera);
			
/*			if($inscripciones){
				$this->table->add_row(array(
					$contador ++,
					$row->id_carrera . '- ' . $row->carrera,
					'En uso',
				));	
			}else{
*/				$this->table->add_row(array(
					$contador ++,
					$row->carrera,
					($inscripciones)? '-' : '<span class=eliminar id=' . $row->id_carrera . '>Eliminar</span>',
					($row->estado)? '<span class=desabilitar id=' . $row->id_carrera . '>Desabilitar</span>' : '<span class=habilitar id=' . $row->id_carrera . '>Habilitar</span>',
				));	

//			}
	
		}
		
		$this->table->set_heading(array('N<sup>ro</sup>', 'Carreras', array('data' => 'Opciones', 'colspan' => '2')));	
		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="1" class="detalles">'));
		$this->table->set_caption('Lista de Carreras');
	
	}else{
		$this->table->set_heading('No hay carrera relaciona con la sede');
	}
	echo $this->table->generate();	
?>
</body>
</html>