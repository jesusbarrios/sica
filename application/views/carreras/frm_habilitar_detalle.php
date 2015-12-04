<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function(){
			$('.eliminar').click(function() { 
				if($('#slc_facultad'))
					facultad = $('#slc_facultad').val();
				else
					facultad = false;
				sede = $('#slc_sede').val();
				carrera = this.id;
				$.post('<?=base_url()?>index.php/carreras/habilitar/obtener_nombre', {slc_facultad : facultad, slc_sede : sede, slc_carrera : carrera}, function (respuesta) {
					var datos = $.parseJSON(respuesta);
					if(confirm('Seguro que quieres eliminar la relación "' + datos['sede'] + '" - "' + datos['carrera'] + '"')){
						$.post('<?=base_url()?>index.php/carreras/habilitar/eliminar', {slc_facultad : facultad, slc_sede : sede, slc_carrera : carrera}, function (respuesta) {
							$('#detalles').html(respuesta)
						});	
					}
				});
			});
			
			$('.desabilitar').click(function() { 
				if($('#slc_facultad'))
					facultad = $('#slc_facultad').val();
				else
					facultad = false;
				sede = $('#slc_sede').val();
				carrera = this.id;
				$.post('<?=base_url()?>index.php/carreras/habilitar/obtener_nombre', {slc_facultad : facultad, slc_sede : sede, slc_carrera : carrera}, function (respuesta) {
					var datos = $.parseJSON(respuesta);
					if(confirm('Seguro que quieres desabilitar la relación "' + datos['sede'] + '" - "' + datos['carrera'] + '"')){
						$.post('<?=base_url()?>index.php/carreras/habilitar/cambiar_estado', {slc_facultad : facultad, slc_sede : sede, slc_carrera : carrera, estado : 0}, function (respuesta) {
							$('#detalles').html(respuesta)
						});	
					}
				});
			});
			
			$('.habilitar').click(function() { 
				if($('#slc_facultad'))
					facultad = $('#slc_facultad').val();
				else
					facultad = false;
				sede = $('#slc_sede').val();
				carrera = this.id;
				$.post('<?=base_url()?>index.php/carreras/habilitar/obtener_nombre', {slc_facultad : facultad, slc_sede : sede, slc_carrera : carrera}, function (respuesta) {
					var datos = $.parseJSON(respuesta);
					if(confirm('Seguro que quieres habilitar la relación "' + datos['sede'] + '" - "' + datos['carrera'] + '"')){
						$.post('<?=base_url()?>index.php/carreras/habilitar/cambiar_estado', {slc_facultad : facultad, slc_sede : sede, slc_carrera : carrera, estado : 1}, function (respuesta) {
							$('#detalles').html(respuesta)
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
		foreach($relaciones->result() as $row){
			$inscripciones 	= $this->m_inscripciones->get_inscripciones(false, $row->id_facultad, $row->id_sede);
			$this->table->add_row(array(
				$contador ++,
				$row->carrera,
				date('d/m/Y', strtotime($row->creacion)),
				($inscripciones)? '-----' : '<span class=eliminar id=' . $row->id_carrera . '>Eliminar</span>',
				($row->estado)? '<span class=desabilitar id=' . $row->id_carrera . '>Desabilitar</span>' : '<span class=habilitar id=' . $row->id_carrera . '>Habilitar</span>',
			));
		}
		$this->table->set_heading(array('N<sup>ro</sup>', 'Carreras', 'Fechas de creación', array('data' => 'Opciones', 'colspan' => '2')));	
		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="1" class="detalles">'));
		$this->table->set_caption('Detalles de carreras habilitadas');
		echo $this->table->generate();
	}
?>
</body>
</html>