<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.js"></script>
	<script type="text/javascript">
    	$(document).ready(function () {
	    	$('form').keypress(function(e){
	    		$('.error').hide('fast');
	    		$('.ok').hide('fast');
	    	}).click(function(e){
	    		$('.error').hide('fast');
	    		$('.ok').hide('fast');
	    	});

	    	$('#txt_usuario').blur(function() {
	    		$("#detalles").html("<h2>Cargando...</h2>");
	    		usuario 	= $(this).val();
 				$.post('<?=base_url()?>index.php/usuario/asignar_rol/actualizar_detalles', {txt_usuario : usuario}, function (respuesta) {
					$('#detalles').html(respuesta);
				});
    		});

	    	$('#slc_facultad').change(function() {
	  			facultad 	= $(this).val();
   				if(facultad){
   					$.post('<?=base_url()?>index.php/usuario/asignar_rol/actualizar_slc_sede', {slc_facultad : facultad}, function (respuesta) {
						$('#slc_sede').html(respuesta);
					});
				}else{
					$('#slc_sede').html("<option value=>-----</option>");
				}
    		});
	    });
	</script>

	<link rel="stylesheet" href="<?=base_url()?>css/frm_login.css" type="text/css" />
	<style>
		fieldset{
			background-color: #EEEEEE;
		    border-radius: 10px 10px 10px 10px;
		    font-size: 11px;
		    margin: 0 auto;
		    padding: 0 10px;
		    width: 700px;
		}
		legend {
		    background-color: #FFFFFF;
		    border: 1px solid #A0A0A0;
		    border-radius: 7px 7px 7px 7px;
		    color: #000000;
		    font-size: 15px;
		    font-weight: bold;
		    padding: 2px 20px;
		}
		label {
		    color: #000000;
		    float: left;
		    font-size: 15px;
		    padding-right: 7px;
		    text-align: right;
		    width: 150px;
		}

		td{
			vertical-align: top;
		}

		input[type="submit"] {
		    cursor: pointer;
		}
		.error{
			color: #000000;
		    background: none repeat scroll 0 0 #FF9E9E;
		    border: 1px solid #AA8888;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: left;
		}

		.ok{
			color: #000000;
		    background: none repeat scroll 0 0 #9EFF9E;
		    border: 1px solid #88AA88;
		    font-size: 15px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		}
		.obligatorio {
		    color: #FF0000;
		    float: left;
		    font-size: 11px;
		    margin-top: 20px;
		    padding: 0 2px;
		}

		table{
			margin: 10px auto;
		}

		#detalles{
			text-align: center;
		}
	</style>
	
</head>

<body>
	<?php
		echo form_open('');
		echo form_fieldset('Asignacion de rol');
		
		if($mensaje)	
			echo "<div class='ok'>" . $mensaje . "</div>";

		/*
		*
		*PERSONAS
		*
		*/
		$txt_usuario = array(
			'name'			=> 'txt_usuario',
			'id'			=> 'txt_usuario',
			'maxlength'		=> '100',
			'size'			=> '50',
			'autofocus'		=> 'autofocus',
			'autocomplete'	=> 'Off',
			'list'			=> 'opciones',
			'value'			=> set_value('txt_usuario'),
		);

		$opciones = "<datalist id='opciones'>";
		if($personas)
			foreach($personas->result() as $row)
				$opciones .= "<option value='$row->nombre $row->apellido $row->documento'>";
			
		$opciones .= "</datalist>";

		$this->table->add_row(array(
			form_label('Usuario:', 'txt_usuario'),
			form_input($txt_usuario) . $opciones
			. form_error('txt_usuario', '<div class="error">', '</div>'),
		));

		/*
		*FACULTADES
		*/
		$slc_facultad = array('' => '-----');
		if($facultades){
			foreach($facultades->result() as $row)
				$slc_facultad[$row->id_facultad] = $row->facultad;
		}

		$this->table->add_row(array(
			form_label('Facultad:', 'slc_facultad'),
			form_dropdown('slc_facultad', $slc_facultad, set_value('slc_facultad'), 'id=slc_facultad')
			. form_error('slc_facultad', '<div class="error">', '</div>'),
		));

		/*
		*SEDES
		*/
		$slc_sede = array('' => '-----');
		if($sedes){
			foreach($sedes->result() as $row)
				$slc_sede[$row->id_sede] = $row->sede;
		}

		$this->table->add_row(array(
			form_label('Sede:', 'slc_sede'),
			form_dropdown('slc_sede', $slc_sede, set_value('slc_sede'), 'id=slc_sede')
			. form_error('slc_sede', '<div class="error">', '</div>'),
		));
		
		/*
		*
		ROLES
		*
		*/
		$slc_rol = array('' => '-----');
		foreach($roles->result() as $row){
			$slc_rol[$row->id_rol] = $row->rol;
		}

		$this->table->add_row(array(
			form_label('Rol:', 'slc_rol'),
			form_dropdown('slc_rol', $slc_rol)
			. form_error('slc_rol', '<div class="error">', '</div>'),
		));
		
		$boton = array(
			'name'=>'',
			'value'=>'Aceptar',
		);	

		$this->table->add_row(array(
			false,
			form_submit($boton),
		));

		if($detalles)
			$this->table->add_row(array('data' => $detalles, 'colspan' => 2, 'id' => 'detalles'));
		else
			$this->table->add_row(array('data' => '', 'colspan' => 2, 'id' => 'detalles', 'style' => 'display:none'));
		
		$this->table->set_template(array ( 'table_open'  => '<table border="0" cellpadding="2" cellspacing="0" class="">' ));
		echo $this->table->generate();
		echo form_fieldset_close();
		echo form_close();

	?>
</body>
</html>