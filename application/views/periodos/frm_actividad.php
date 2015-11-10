<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function() {
			$('form').click(function() {
				$('.error').hide('slow');
				$('.ok').hide('slow');
			}).keypress(function() {
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
		    margin: 10px auto;
		    padding: 10 33px;
		    width: 600px;
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
		    padding-right: 7px;
		    text-align: right;
		    vertical-align: top;
		    width: 140px;
		}

		 .error{
			color: #000000;
		    background: none repeat scroll 0 0 #FF9E9E;
		    border: 1px solid #AA8888;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		}
		 .ok{
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
		
		table #detalle table{
			margin: 0px auto;
		}
		table #msn{
			text-align: center;
			
		}
		
		 table td{
			padding: 5px 3px;
		}
		
		h3.titulo{
			border-bottom : solid 1px #ffffee;
			text-align: center;
		}
	</style>
</head>

<body>
	<?php
		echo form_open('');
		echo form_fieldset('Creación de actividades');
		
		if($msn)
			$this->table->add_row(array('data' => $msn, 'colspan' => '2', 'class' => 'ok'))	;
		//ACTIVIDAD
		$txt_actividad = array(
			'id'		=> 'txt_actividad',
			'name'		=> 'txt_actividad',
			'tyep'		=> 'text',
			'size'		=> '70',
			'maxlength'	=> 150,
			'autofocus'	=> 'autofocus',
			'value'		=> set_value('txt_actividad'),
		);

		$this->table->add_row(array(
			form_label('Actividad:', 'txt_actividad'),
			form_input($txt_actividad) .
			form_error('txt_actividad', '<div class=error>', '</div>')
		));		

		//CAMPO BOTON
		$boton = array(
			'type' 	=> 'submit',
			'id' 	=> 'btn_guardar',
			'name' 	=> 'btn_guardar',
			'value' => 'Guardar',
		);
		$this->table->add_row(array(
			'',
			form_input($boton)
		));

		$this->table->add_row(array('data' => $detalle, 'colspan' => '2', 'id' => 'detalle'))	;

		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0" class="frm">'));
		echo $this->table->generate();
		
		echo form_fieldset_close();
		echo form_close();
	?>
</body>
</html>