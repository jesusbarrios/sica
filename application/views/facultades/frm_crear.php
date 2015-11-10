<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function(){
			$('form').click(function() {
				$('.error').hide('slow');
		    	$('#msn').hide('slow');
		    	$('.ok').hide('slow');
			});
			$('input[type=text]').keypress(function(e) {
				if(e.which == 13)
		    		return false;
		    	
		    	$('.error').hide('slow');
		    	$('#msn').hide('slow');
			});
			
			$('#btn_cancelar').click(function() {				
				$('#txt_carrera')
				.val('')
				.focus();
				$('#msn').hide();
				
				$('#txt_cursos').val('');
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
		    text-align: right;
		    vertical-align: top;
		    width: 140px;
		}
		input {

		}
		input[type="submit"] {
		    cursor: pointer;
/* 		    margin: 20px 125px; */
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
	</style>
	
</head>

<body>
	<?php
		echo form_open('');
		echo form_fieldset('Creación de facultades');
		
		//MENSAJE
		if($msn){
			echo "<div id=msn class=ok>$msn</div>";
		}
		
		//FACULTAD
		$txt_facultad = array(
			'type' 		=> 'text',
			'name' 		=> 'txt_facultad',
			'id' 		=> 'txt_facultad',
			'autofocus' => 'autofocus',
			'value' 	=> set_value('txt_facultad'),
			'size' 		=> '50',
			'maxlength' => '100',
		);
		
		$this->table->add_row(array(
			form_label('Nombre:'),
			form_input($txt_facultad) .
			form_error('txt_facultad', '<div class="error">', '</div>')
		));

		//CREACION
		$txt_creacion = array(
			'type' 		=> 'date',
			'name' 		=> 'txt_creacion',
			'id' 		=> 'txt_creacion',
			'autofocus'	=> 'autofocus',
			'value' 	=> set_value('txt_creacion'),
		);
		
		$this->table->add_row(array(
			form_label('Creación:'),
			form_input($txt_creacion) .
			form_error('txt_creacion', '<div class="error">', '</div>')
		));
		
		//BOTON GUARDAR
		$btn_guardar = array(
			'id' => 'btn_guardar',
			'type' => 'submit',
			'value' => 'Guardar'
		);
		
		//BOTON GUARDAR
		$btn_cancelar = array(
			'id' => 'btn_cancelar',
			'type' => 'button',
			'value' => 'Cancelar'
		);
		
		$this->table->add_row(array(
			null,
			form_input($btn_guardar) . form_input($btn_cancelar)
		));
		
		$this->table->add_row(array(
			array('data' => $detalle, 'colspan' => '2', 'id' => 'detalle'),
		));	
		
		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0">'));
		echo $this->table->generate();		
		echo form_fieldset_close();
		echo form_close();

	?>
</body>
</html>