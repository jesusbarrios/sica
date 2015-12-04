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
		table.detalles{
			margin:10px auto;
		}
		table.detalles .eliminar{
			color: red;
		}
		table.detalles .eliminar:hover{
			cursor : pointer;
		}
		table.detalles td{
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
		$contador = 1;
		foreach($facultades->result() as $row){
			$usuarios = $this->user->get_usuarios($row->id_facultad);
			$carreras = $this->m_carreras->get_carreras($row->id_facultad);
			$this->table->add_row(array(
				$contador ++,
				$row->facultad,
				date('d/m/Y', strtotime($row->creacion)),
				($carreras || $usuarios)? 'En uso' : '<span class=eliminar id=' . $row->id_facultad . '>Eliminar</span>',
			));	
		}
		
		if($facultades->num_rows() > 1)
			$this->table->set_heading(array('N<sup>ro</sup>', 'Facultades', 'Fechas de creación', 'Operaciones'));	
		else
			$this->table->set_heading(array('N<sup>ro</sup>', 'Facultad', 'Fecha de creación', 'Operacion'));	
			
		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="1" class=detalles>'));
		echo $this->table->generate();	
		
	}

?>
</body>
</html>