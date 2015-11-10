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
			background-color: #eeeeee;
		    border-radius: 10px 10px 10px 10px;
		    margin: 0 auto;
		    padding: 0 33px 25px 33px;
		    width: 400px;
		}
		legend {
		    background-color: #FFFFFF;
		    border: 1px solid #A0A0A0;
		    border-radius: 7px 7px 7px 7px;
		    padding: 2px 15px;
		}
		label {
		    float: left;
		    margin-top: 20px;
		    padding-right: 7px;
		    text-align: right;
		    vertical-align: top;
		    width: 100px;
		}
		input {
		    margin-top: 20px;
		}
		input[type="submit"] {
		    margin: 20px 65px;
		}
		.msn_error{
		    background: none repeat scroll 0 0 #FF9E9E;
		    border: 1px solid #AA8888;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		}
		
		a{
			font-style: italic;
			margin: 20px 65px;
		}
	</style>
	
</head>

<body>
	<?php
		$usuario = array(
			'name'=> 'txt_usuario',
			'id'=> 'txt_usuario',
			'value'=>$usuario,
			'maxlength'=>'15',
			'autofocus' => 'autofocus',
			'autocomplete' => 'off',
		);

		$clave = array(
			'name'=>'txt_clave',
			'id'=>'txt_clave',
			'value'=>'',
//			'maxlength'=>'15'
		);

		$boton = array(
			'name'=>'',
			'value'=>'Aceptar');


		echo form_open('');

		echo form_fieldset('Registro de Usuario');		

		echo form_label('Cuenta:', $usuario['name']);
		echo form_input($usuario) . "<br>";
		echo form_error($usuario['name'], '<div class="msn_error">', '</div>');			

		echo form_label('Clave:', $clave['name']);
		echo form_password($clave) . "<br>";
		echo form_error($clave['name'], '<div class="msn_error">', '</div>');

		echo form_submit($boton);
		
//		echo "<a href=" . base_url() . "index.phpinscripcion/cpi>Inscripción al CPI</a>";

		echo form_fieldset_close();
		echo form_close();
	?>
</body>
</html>