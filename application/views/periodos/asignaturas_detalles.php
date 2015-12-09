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
		#lista fieldset{
			background-color: #EEEEEE;
		    border-radius: 10px 10px 10px 10px;
		    font-size: 11px;
		    margin: 0 auto;
		    padding: 10 33px;
		    width: 600px;
		    font-size: 13px;
		}

		#lista legend {
		    background-color: #FFFFFF;
		    border: 1px solid #A0A0A0;
		    border-radius: 7px 7px 7px 7px;
		    color: #000000;
		    font-size: 15px;
		    font-weight: bold;
		    padding: 2px 20px;
		}

		#lista table{
			margin: 10px auto;
		}

		#lista table td{
			padding: 1px 10px;
		}

		#lista table td span.eliminar{
			color: #bb0000;
			text-decoration: underline;
			cursor: pointer;
		}

		#lista table tr:hover{
			background-color: #ffeeee;
		}
		
		.eliminar{
			color : red;
		}
		
		.eliminar:hover{
			cursor: pointer;
		}
	</style>
</head>

<body>
<?php
	if($inscripciones){
		$contador = 1;
		foreach ($inscripciones->result() as $row) {
			$inscripcion_detalles = $this->m_inscripciones->get_detalles_inscripcion($row->id_periodo, $row->id_facultad, $row->id_sede, $row->id_carrera, $row->id_curso);
			$this->table->add_row(array(
				$contador ++,
				$row->curso,
				($row->estado)? 'Deshabilitar' : 'Habilitar',
				($inscripciones)? 'En uso' : 'Eliminar',
			));
		}
		$this->table->set_heading(array('Item', 'Cursos', array('data' => 'Opciones', 'colspan' => 2)));
		$this->table->set_template(array ( 'table_open'  => '<table border="1" cellpadding="2" cellspacing="0" class="detalles">' ));
		echo $this->table->generate();
	}
?>
</body>
</html>