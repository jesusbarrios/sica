<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>js/jquery-ui.js"></script>
    <script type="text/javascript" src="<?php echo base_url()?>js/inscripcion.js"></script>

	<style>
		fieldset{
			background-color: #EEEEEE;
		    border-radius: 10px 10px 10px 10px;
		    color: #FF0000;
		    font-size: 11px;
		    margin: 0 auto;
		    padding: 1 33px;
		    width: 570px;
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
		input, select {
			margin: 20px 3px 0px 0px;
		}
		input[type="submit"] {
		    cursor: pointer;
		    margin: 20px 145px;
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
		.campo_obligatorio {
		    color: #FF0000;
		    float: left;
		    font-size: 11px;
		    margin-top: 20px;
		    padding: 0 2px;
		}
	</style>
	
</head>

<body>
	<?php

		$periodo_academico = array(
			'name'=>'txt_periodo_academico',
			'id'=>'txt_periodo_academico',
			'maxlength'=>'4',
			'size' => '4',
			'readonly' => 'readonly',
			'value' => date("Y"));
			
		$documento = array(
			'name'=>'txt_documento',
			'id'=>'txt_documento',
			'maxlength'=>'15',
			'size'=>'15');
		
		$nombre = array(
			'name'=>'txt_nombre',
			'id'=>'txt_nombre',
			'maxlength'=>'25',
			'size'=>'25');
			
		$apellido = array(
			'name'=>'txt_apellido',
			'id'=>'txt_apellido',
			'maxlength'=>'25',
			'size'=>'25');
			
		$nacionalidad = array(
			'name'=>'txt_nacionalidad',
			'id'=>'txt_nacionalidad',
			'maxlength'=>'20',
			'size'=>'20');
			
		$fecha_nacimiento = array(
			'name'=>'txt_fecha_nacimiento',
			'id'=>'txt_fecha_nacimiento',
			'maxlength'=>'45',
			'size'=>'45');
			
		$boton = array(
			'name'=>'',
			'value'=>'Aceptar');

		$boton_buscar = array(
			'name'=>'btn_buscar',
			'id'=>'btn_buscar',
			'type' => 'button',
			'value'=>'Buscar');

		echo form_open('inscripcion/semestre/guardar');
		echo form_fieldset('Inscripción a semestre');
		
		if(isset($mensaje))	
			echo "<div class='frm_ok'>" . $mensaje . "</div>";
			
		
		echo form_label('Nro documento:', $documento['id']);
		echo form_input($documento);
		echo form_error($documento['name'], '<div class="frm_error">', '</div>');
		echo form_input($boton_buscar);
		echo "<br>";


/*
		echo form_label('Periodo academico:', $periodo_academico['id']);
		echo form_input($periodo_academico);
		echo form_error($periodo_academico['name'], '<div class="frm_error">', '</div>');
		echo "<br>";
		
		echo form_label('Sede:', 'slc_sede');
		echo "<select name='slc_sede' id='slc_sede' autofocus=autofocus>";
			foreach($sedes as $row)
				echo "<option value=$row->id_sede>$row->ciudad</option>";
		echo "</select>";
		echo "<br>";
		
		echo form_label('Carrera:', 'slc_carrera');
		echo "<select name='slc_carrera' id='slc_carrera'>";
		foreach($carreras as $row)
			echo "<option value= $row->id_carrera> $row->carrera </option>";
		echo "</select>";
		echo "<br>";
		
		echo form_label('Nombre:', $nombre['id']);
		echo form_input($nombre);
		echo form_error($nombre['name'], '<div class="frm_error">', '</div>');
		echo "<br>";
		
		echo form_label('Apellido:', $apellido['id']);
		echo form_input($apellido);
		echo form_error($apellido['name'], '<div class="frm_error">', '</div>');
		echo "<br>";
		
		echo form_label('Nacionalidad:', $nacionalidad['id']);
		echo form_input($nacionalidad);
		echo form_error($nacionalidad['name'], '<div class="frm_error">', '</div>');
		echo "<br>";
		
		echo form_label('Fecha de nacimiento:', $fecha_nacimiento['id']);
		echo form_input($fecha_nacimiento);
		echo form_error($fecha_nacimiento['name'], '<div class="frm_error">', '</div>');
		echo "<br>";
		
		echo form_label('Genero:', 'slc_genero');
		echo "<select id=slc_genero name=slc_genero>";
		echo "<option value=0>-----</option>";
		echo "<option value=masculino>Masculino</option>";
		echo "<option value=femenino>Femenino</option>";
		echo "</select>";
		echo form_error('slc_genero', '<div class="frm_error">', '</div>');
		echo "<br>";

		echo form_label('Tipo de ingreso:', 'slc_tipo_ingreso');
		echo "<select id=slc_tipo_ingreso name=slc_tipo_ingreso>";
		echo "<option value=cpi>CPI</option>";
		echo "<option value=beca>Beca</option>";
		echo "<option value=convalidacion>Convalidacion</option>";
		echo "</select>";
		echo form_error('slc_tipo_ingreso', '<div class="frm_error">', '</div>');
		echo "<br>";
		
		echo form_submit($boton);
			
		echo form_fieldset_close();
		echo form_close();
		
*/

?>
</body>
</html>