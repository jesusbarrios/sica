<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<link rel="stylesheet" href="<?=base_url()?>css/frm_login.css" type="text/css" />
	<style>
		fieldset{
			background-color: #EEEEEE;
		    border-radius: 10px 10px 10px 10px;
//		    color: #FF0000;
//		    font-size: 11px;
		    margin: 0 auto;
		    padding: 0 33px;
		    width: 350px;
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
		input {
			margin: 0px 3px 0px 0px;
		}
		input[type="submit"] {
		    cursor: pointer;
/* 		    margin: 20px 125px; */
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
		
		


		echo form_open();
		echo form_fieldset('Carga de calificaciones');
		
		if(isset($mensaje))	
			echo "<div class='frm_ok'>" . $mensaje . "</div>";


		$documento = array(
			'type' => 'number',
			'name'=>'txt_documento',
			'id'=>'txt_documento',
			'maxlength'=>'10',
			'size'=>'10',
			'autofocus'=>'autofocus',
			'value' => set_value('txt_documento'),
		
		);

		$this->table->add_row(array(
			form_label('N<sup>ro</sup> de documento:', 'txt_documento'),
			form_input($documento) . 
			form_error('txt_documento', '<div class="frm_error">', '</div>')
		));
		
		if($persona){
			$row = $persona->row_array();
	
			$this->table->add_row(array(
				form_label('Estudiante:', ''),
				$row['nombre'] . ' ' . $row['apellido']
			));
			
			
			
			$boton = array(
				'name'=>'',
				'value'=>'Aceptar'
			);
			
			$this->table->add_row(array(
				NULL,
				form_submit($boton)
			));
			
		}else{
			$boton = array(
				'name'=>'',
				'value'=>'Buscar'
			);
			
			$this->table->add_row(array(
				NULL,
				form_submit($boton)
			));	
		}
			
		
		
		
		echo $this->table->generate();
			
		echo form_fieldset_close();
		echo form_close();

	?>
</body>
</html>