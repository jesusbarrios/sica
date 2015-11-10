<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.js"></script>
	<script type="text/javascript">
    	$(document).ready(function () {
	    	$('form').keypress(function(e){
	    		$('.msn_error').hide('fast');
	    	}).click(function(e){
	    		$('.msn_error').hide('fast');
	    	});
	    });
	</script>

	<link rel="stylesheet" href="<?=base_url()?>css/frm_login.css" type="text/css" />
	<style>
		fieldset{
			background-color: #EEEEEE;
		    border-radius: 10px 10px 10px 10px;
		    color: #FF0000;
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
		    margin-top: 20px;
		    padding-right: 7px;
		    text-align: right;
		    vertical-align: top;
		    width: 150px;
		}
		input {
			margin: 20px 3px 0px 0px;
		}
		input[type="submit"] {
		    cursor: pointer;
		    margin: 20px 200px;
		}
		.msn_error{
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
		echo form_open('');
		echo form_fieldset('Cambio de clave');
		
		if(isset($mensaje))	
			echo "<div class='frm_ok'>" . $mensaje . "</div>";

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

		echo form_label('Usuario:', 'txt_usuario');
		echo form_input($txt_usuario) . "*<br>";
		echo form_error('txt_usuario', '<div class="msn_error">', '</div>');
		echo "<datalist id='opciones'>";
			if($personas)
				foreach($personas->result() as $row)
					echo "<option value='$row->nombre $row->apellido $row->documento'>";
			
		echo "</datalist>";
		
		
		$clave_nueva = array(
		'name'=>'txt_clave1',
		'id'=>'txt_clave1',
		'maxlength'=>'15',
		'size'=>'15');
		echo form_label('Clave:', $clave_nueva['name']);
		echo form_password($clave_nueva) . "*<br>";
		echo form_error($clave_nueva['name'], '<div class="msn_error">', '</div>');
		
		$clave_confirmar = array(
		'name'=>'txt_clave2',
		'id'=>'txt_clave2',
		'maxlength'=>'15',
		'size'=>'15');
		echo form_label('Confirmar clave:', $clave_confirmar['name']);
		echo form_password($clave_confirmar) . "*<br>";
		echo form_error($clave_confirmar['name'], '<div class="msn_error">', '</div>');
		
		$boton = array(
		'name'=>'',
		'value'=>'Aceptar');	
		echo form_submit($boton);
			
		echo form_fieldset_close();
		echo form_close();

	?>
</body>
</html>