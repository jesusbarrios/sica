<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<style>
		fieldset{
			background-color: #EEEEEE;
		    border-radius: 10px 10px 10px 10px;
		    color: #FF0000;
		    font-size: 11px;
		    margin: 0 auto;
		    padding: 0 33px;
		    width: 520px;
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
		    margin-top: 20px;
		    padding-right: 7px;
		    text-align: right;
		    vertical-align: top;
		    width: 140px;
		}
		input {
		    margin: 20px 3px 0px 0px;
		}
		input[type="submit"] {
		    cursor: pointer;
		    margin: 20px 140px;
		}
		.frm_error{
			color: #000000;
		    background: none repeat scroll 0 0 #FF9E9E;
		    border: 1px solid #AA8888;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		}
		.frm_ok{
			color: #000000;
		    background: none repeat scroll 0 0 #9EFF9E;
		    border: 1px solid #88AA88;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		}
	</style>
	
</head>

<body>
	<?php
		$atributos = array('name'=> 'frm_modificardatospersonal', 'id'=> 'frm_modificardatospersonal');
		echo form_open('user/modificardatospersonal/guardar', $atributos);
			
		$documento = array(
			'name'=> 'txt_documento',
			'id'=>'txt_documento',
			'value' => $documento,
			'readonly'=>'readonly',
			'size' => '15');
			
		$nombre_apellido = array(
			'name'=>'txt_nombre_apellido',
			'id'=>'txt_nombre_apellido',
			'value'=>$nombre_apellido,
			'readonly'=>'readonly',
			'size'=>'50');
		
		$alias = array(
			'name'=>'txt_alias',
			'id'=>'txt_alias',
			'maxlength'=>'25',
			'value'=>$alias,
			'autofocus'=>'autofocus',
			'size'=>'25');

		$telefono_fijo = array(
			'name'=>'txt_telefono_fijo',
			'id'=>'txt_telefono_fijo',
			'maxlength'=>'15',
			'value'=>$telefono_fijo,
			'size'=>'15');
			
		$telefono_movil = array(
			'name'=>'txt_telefono_movil',
			'id'=>'txt_telefono_movil',
			'maxlength'=>'15',
			'value'=>$telefono_movil,
			'size'=>'15');

		$email = array(
			'name'=>'txt_email',
			'id'=>'txt_email',
			'maxlength'=>'50',
			'value'=>$email,
			'size'=>'50');

		$direccion = array(
			'name' => 'txt_direccion',
			'id' => 'txt_direccion',
			'maxlength' => '50',
			'value' => $direccion,
			'size' => '50');

		$localidad = array(
			'name' => 'txt_localidad',
			'id' => 'txt_localidad',
			'maxlength' => '30',
			'value' => $localidad,
			'size' => '30');

		$boton = array(
			'value'=>'Aceptar');

		echo form_fieldset('Modificación de datos personal');
		
		if(isset($mensaje))
			echo "<div class='frm_ok'>" . $mensaje . "</div>";
		
		echo form_label('Documento:', $documento['name']);
		echo form_input($documento) . "<br>";
		
		echo form_label('Nombres y Apellidos:', $nombre_apellido['name']);
		echo form_input($nombre_apellido) . "<br>";
			
		echo form_label('Alias:', $alias['name']);
		echo form_input($alias) . "*<br>";
		echo form_error($alias['name'], '<div class="frm_error">', '</div>');

		echo form_label('Nro teléfono fijo:', $telefono_fijo['name']);
		echo form_input($telefono_fijo) . "<br>";
		echo form_error($telefono_fijo['name'], '<div class="frm_error">', '</div>');
		
		echo form_label('Nro teléfono movil:', $telefono_movil['name']);
		echo form_input($telefono_movil) . "*<br>";
		echo form_error($telefono_movil['name'], '<div class="frm_error">', '</div>');
		
		echo form_label('Email:', $email['name']);
		echo form_input($email) . "*<br>";
		echo form_error($email['name'], '<div class="frm_error">', '</div>');

		echo form_label('Dirección particular:', $direccion['name']);
		echo form_input($direccion) . "*<br>";
		echo form_error($direccion['name'], '<div class="frm_error">', '</div>');
		
		echo form_label('Localidad:', $localidad['name']);
		echo form_input($localidad) . "*<br>";
		echo form_error($localidad['name'], '<div class="frm_error">', '</div>');

		echo form_submit($boton);
			
		echo form_fieldset_close();
		echo form_close();

	?>
	<div id="manual" style="display:none;">
		<p><b>Alias:</b> Es para uso personal. Será reflejado en el menu. La cantidad mínima y máxima de caracteres son 5 y 25 respectivamente. El primer nombre y el primer apellido son los valores por defecto.</p>
		<p><b>Teléfono:</b> Todos los caracteres deben ser enteros, no acepta caracteres especiales como () . - etc... La cantidad máxima de caracteres es 15.</p>
		<p><b>Email:</b> Debe respetar sus partes, ejemplo: usuario@cyt.uni.edu.py ó usuario@dominio.com. La cantidad máxima de caracteres es 50.</p>
		
	</div>
</body>
</html>