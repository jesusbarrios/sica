<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.js"></script>
	<script type="text/javascript">
    	$(document).ready(function () {

	    	$('.deshabilitar').click(function() {
	    		usuario 	= $('#txt_usuario').val();
	    		campo 		= $(this).attr('value');

	    		facultad 	= $('.facultad_' + campo).attr('value');
	    		sede 		= $('.sede_' + campo).attr('value');
	    		rol 		= $('.rol_' + campo).attr('value');
	    		$("#detalles").html("<h2>Cargando...</h2>");

   				if(usuario && facultad && sede && rol){
   					$.post('<?=base_url()?>index.php/usuario/asignar_rol/cambiar_estado', {txt_usuario : usuario, slc_facultad : facultad, slc_sede : sede, slc_rol : rol, estado : '0'}, function (respuesta) {
						$('#detalles').html(respuesta);
					});
				}else{
					alert('Esta operación requiere todos los datos');
				}
    		});

    		$('.habilitar').click(function() {
	    		usuario 	= $('#txt_usuario').val();
	    		campo 		= $(this).attr('value');

	    		facultad 	= $('.facultad_' + campo).attr('value');
	    		sede 		= $('.sede_' + campo).attr('value');
	    		rol 		= $('.rol_' + campo).attr('value');

	    		$("#detalles").html("<h2>Cargando...</h2>");

   				if(usuario && facultad && sede && rol){
   					$.post('<?=base_url()?>index.php/usuario/asignar_rol/cambiar_estado', {txt_usuario : usuario, slc_facultad : facultad, slc_sede : sede, slc_rol : rol, estado : '1'}, function (respuesta) {
						$('#detalles').html(respuesta);
					});
				}else{
					alert('Esta operación requiere todos los datos');
				}
    		});

    		$('.eliminar').click(function() {
	    		usuario 	= $('#txt_usuario').val();
	    		campo 		= $(this).attr('value');

	    		facultad 	= $('.facultad_' + campo).attr('value');
	    		sede 		= $('.sede_' + campo).attr('value');
	    		rol 		= $('.rol_' + campo).attr('value');

	    		$("#detalles").html("<h2>Cargando...</h2>");

   				if(usuario && facultad && sede && rol){
   					$.post('<?=base_url()?>index.php/usuario/asignar_rol/eliminar', {txt_usuario : usuario, slc_facultad : facultad, slc_sede : sede, slc_rol : rol, estado : '1'}, function (respuesta) {
						$('#detalles').html(respuesta);
					});
				}else{
					alert('Esta operación requiere todos los datos');
				}
    		});
	    });
	</script>

	<link rel="stylesheet" href="<?=base_url()?>css/frm_login.css" type="text/css" />

	<style>
		span.deshabilitar, span.habilitar, span.eliminar{
			cursor: pointer;
		}
		table.detalles td{
			padding: 1px;
		}
	</style>
</head>

<body>
	<?php
		
		if($usuarios){
			foreach ($usuarios->result() as $row) {
				$campo = $row->id_persona . $row->id_facultad . $row->id_sede . $row->id_rol;
				$sp_facultad 	= 'facultad_' . $campo;
				$sp_sede 		= 'sede_' . $campo;
				$sp_rol 		= 'rol_' . $campo; 

				if($row->usuario_estado){
					$this->table->add_row(array(
						"<span class='$sp_facultad' value= $row->id_facultad >$row->facultad</span>",
						"<span class='$sp_sede' value= $row->id_sede >$row->sede</span>",
						"<span class='$sp_rol' value= $row->id_rol >$row->rol</span>",
						"<span value=$campo class='deshabilitar'>Deshabilitar</span>",
						"<span value=$campo class='eliminar' >Eliminar</span>",
					));
				}else{
					$this->table->add_row(array(
						"<span class='$sp_facultad' value= $row->id_facultad >$row->facultad</span>",
						"<span class='$sp_sede' value= $row->id_sede >$row->sede</span>",
						"<span class='$sp_rol' value= $row->id_rol >$row->rol</span>",
						"<span value=$campo class='habilitar'>Habilitar</span>",
						"<span value=$campo class='eliminar' >Eliminar</span>",
					));
				}
			}
			if($usuarios->num_rows() > 1)
				$this->table->set_heading('Facultades', 'Sedes', 'Roles', array('data' => 'Opciones', 'colspan' => 2));
			else
				$this->table->set_heading('Facultad', 'Sede', 'Rol', array('data' => 'Opciones', 'colspan' => 2));
			$this->table->set_template(array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="0" class="">' ));
		}else{
			$this->table->add_row(array('No hay usuario relacionado con la persona.'));
		}

		echo $this->table->generate();
		
	?>
</body>
</html>