<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function(){
			$('form').keypress(function(e){   
		    	if(e == 13)
		    		return false;
		    }).click(function(){
		    	$('.error').hide('fast');
		    	$('.ok').hide('fast');
		    });
		    
		    $('input[type=text]').keypress(function(e){
		    	if(e.which == 13)
		    		return false;
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
		table.cabecera label {
		    color: #000000;
		    float: left;
		    font-size: 15px;
		    padding-right: 7px;
		    text-align: right;
		    vertical-align: top;
		    width: 100%;
		}

		table.cabecera .error{
			color: #000000;
		    background: none repeat scroll 0 0 #FF9E9E;
		    border: 1px solid #AA8888;
		    font-size: 13px;
		    margin: 2px 0px;
		    padding: 1px;
		    text-align: center;
		}
		table.cabecera .ok{
			color: #000000;
		    background: none repeat scroll 0 0 #9EFF9E;
		    border: 1px solid #88AA88;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		}
		
		table.cabecera .campo_obligatorio {
		    color: #FF0000;
		    float: left;
		    font-size: 11px;
		    margin-top: 20px;
		    padding: 0 2px;
		}
		
		table.cabecera{
			margin: 10px auto;
		}
		
		table.cabecera td{
			padding: 5px 0px;
			vertical-align: top;
		}
	</style>
</head>

<body>
	<?php
//		$url = $base_url() . 'asignaturas/crear';
		echo form_open('');
		echo form_fieldset('Creación de periodo');

		if($mensaje)
				$this->table->add_row(array('data' => $mensaje, 'colspan' => '2', 'class' => 'ok'));

		//PERIODO
		$txt_periodo = array(
			'type' 		=> 'text',
			'name'		=> 'txt_periodo',
			'id' 		=> 'txt_periodo',
			'value'		=> set_value('txt_periodo'),
			'size' 		=> '4',
			'maxlength'	=> '4',
		);
		
		$this->table->add_row(array(
			form_label('Periodo:', 'txt_periodo'),
			form_input($txt_periodo) .
			form_error('txt_periodo', '<div class=error>', '</div>')
		));

		//BOTON GUARDAR
		$boton = array(
			'type' 	=> 'submit',
			'id' 	=> 'btn_guardar',
			'name' 	=> 'btn_guardar',
			'value' => 'Guardar',
		);

		$this->table->add_row(array(
			false,
			form_input($boton)
		));

		$this->table->add_row(array('data' => $detalles, 'colspan' => '2', 'id' => 'detalles'));

		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0" class="cabecera">'));
		echo $this->table->generate();
		
		echo form_fieldset_close();
		echo form_close();
	?>
</body>
</html>