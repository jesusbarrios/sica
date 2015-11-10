<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<link rel="stylesheet" href="<?=base_url()?>css/frm_login.css" type="text/css" />
	
	<script src="<?=base_url();?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function() {
			$('#btn_cancelar').click(function() {				
				$('#txt_sede')
				.val('')
				.focus();
				$('#msn').hide();
			});
			$('form').keypress(function() {
				$('#msn').hide('slow');
				$('.error').hide('slow');
				$('.ok').hide('slow');
			}).click(function() {
				$('#msn').hide('slow');
				$('.error').hide('slow');
				$('.ok').hide('slow');
			});
		});
	</script>
	<style>
		 fieldset{
			background-color: #EEEEEE;
		    border-radius: 10px 10px 10px 10px;
		    font-size: 11px;
		    margin: 0 auto;
		    padding: 10 33px;
		    width: 300px;
		    font-size: 13px;
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
		    margin-top: 0px;
		    padding-right: 0px;
		    text-align: right;
		    vertical-align: top;
		    width: 140px;
		}

		input {
			margin: 0px 3px 0px 0px;
		}

		input[type="button"], input[type="submit"]  {
		    cursor: pointer;
 		    margin: 0px 10px 0px 0px; 
		}

		.error{
			color: #000000;
		    background: none repeat scroll 0 0 #FF9E9E;
		    border: 1px solid #AA8888;
		    font-size: 12px;
		    margin: 2px;
		    padding: 1px 3px;
		    text-align: left;
		}

		.ok{
			color: #000000;
		    background: none repeat scroll 0 0 #9EFF9E;
		    border: 1px solid #88AA88;
		    font-size: 12px;
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
		
		table{
			margin: 10px auto;
		}
		
		table td{
			padding: 5px 5px;
		}
	</style>
	
</head>

<body>
	<?php
		
		echo form_open('sedes/crear', array('id' => 'frm_agregar'));
		echo form_fieldset('Creación de nueva sede');
		
		//MENSAJE
		if($msn)
			echo "<div id=msn class=ok>$msn</div>";
		
		//CAMPO: NOMBRE DE LA SEDE
		$txt_sede = array(
			'type' => 'text',
			'name' => 'txt_sede',
			'id' => 'txt_sede',
			'size' => '50',
			'maxlength' => '45',
			'autofocus' => 'autofocus',
			'value' => set_value('txt_sede'),
		);
		
		$this->table->add_row(array(
			form_label('Nombre:'),
			form_input($txt_sede) .
			form_error('txt_sede', '<div class="error">', '</div>')
		));

		//BOTON GUARDAR
		$btn_guardar = array(
			'id' => 'btn_guardar',
			'type' => 'submit',
			'value' => 'Guardar',
//			'disabled' => 'disabled',
		);

		$btn_cancelar = array(
			'id' => 'btn_cancelar',
			'type' => 'button',
			'value' => 'Cancelar'
		);

		$this->table->add_row(array(
			null,
			form_input($btn_guardar) . 
			form_input($btn_cancelar)
		));
		
		$this->table->add_row(array('data' => $detalle, 'colspan' => '2', 'id' => 'detalle'));
		
		$this->table->set_template(array ( 'table_open'  => '<table border="0" cellpadding="0" cellspacing="0" class="tbl_detalles">' ));
		echo $this->table->generate();		
		echo form_fieldset_close();
		echo form_close();

	?>
</body>
</html>