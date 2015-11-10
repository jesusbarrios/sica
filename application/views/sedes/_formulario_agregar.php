<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<link rel="stylesheet" href="<?=base_url()?>css/frm_login.css" type="text/css" />
	<script src="<?=base_url();?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function() {
			alert('ok')
			$('#btn_cancelar').click(function() {				
				$('#txt_sede')
				.val('')
				.focus();
				
				$('.ok').hide();
			});
		});
	</script>
	<style>
		#frm_agregar fieldset{
			background-color: #fffeff;
		    border-radius: 10px 10px 10px 10px;
		    font-size: 11px;
		    margin: 0 auto;
		    padding: 10 33px;
		    width: 400px;
		    font-size: 13px;
		}
		#frm_agregar legend {
		    background-color: #FFFFFF;
		    border: 1px solid #A0A0A0;
		    border-radius: 7px 7px 7px 7px;
		    color: #000000;
		    font-size: 15px;
		    font-weight: bold;
		    padding: 2px 20px;
		}
		#frm_agregar label {
		    color: #000000;
		    float: left;
		    font-size: 15px;
		    margin-top: 0px;
		    padding-right: 0px;
		    text-align: right;
		    vertical-align: top;
		    width: 140px;
		}
		#frm_agregar input {
			margin: 0px 3px 0px 0px;
		}
		#frm_agregar input[type="submit"] {
		    cursor: pointer;
/* 		    margin: 20px 125px; */
		}
		#frm_agregar .frm_error{
			color: #000000;
		    background: none repeat scroll 0 0 #FF9E9E;
		    border: 1px solid #AA8888;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		}
		#frm_agregar .frm_ok{
			color: #000000;
		    background: none repeat scroll 0 0 #9EFF9E;
		    border: 1px solid #88AA88;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		}
		#frm_agregar .campo_obligatorio {
		    color: #FF0000;
		    float: left;
		    font-size: 11px;
		    margin-top: 20px;
		    padding: 0 2px;
		}
		
		#frm_agregar table{
			margin: 10px auto;
		}
		
		#frm_agregar table td{
			padding: 5px 3px;
		}
	</style>
	
</head>

<body>
	<?php
		
		
		echo form_open();
		echo form_fieldset();
		
		
		if($carreras){
		
			//OPCIONES DE CARRERAS A AGREGAR
			$opciones = array();
			foreach($carreras as $row)
				$opciones[$row->id_carrera] = $row->carrera;
					
					
			//BOTON CREAR CARRERA
			$btn_crear = array(
				'id' => 'btn_crear',
				'type' => 'button',
				'value' => 'Crear nueva carrera'
			);
			
			$this->table->add_row(array(
				form_label('Carrera:'),
				form_dropdown('slc_carrera', $opciones, false, 'id=slc_carrera')
				. form_input($btn_crear)
			));
			
			
			
			
			//CAMPO: FECHA DE CREACION
			$txt_fecha_creacion = array(
				'type' => 'date',
				'id' => 'txt_fecha_creacion',
				'name' => 'txt_fecha_creacion',
			);
			$this->table->add_row(array(
				form_label('Fecha de creación:'),
				form_input($txt_fecha_creacion)
			));
			
			
			//BOTON AGREGAR
			$btn_guardar = array(
				'id' => 'btn_guardar',
				'type' => 'button',
				'value' => 'Guardar'
			);
		
		}else{
			//BOTON CREAR CARRERA
			$btn_crear = array(
				'id' => 'btn_crear',
				'type' => 'button',
				'value' => 'Crear nueva carrera'
			);
			
			$this->table->add_row(array(
				false,
				form_input($btn_crear)
			));

			
		}
		
		$this->table->add_row(array(
			null,
			form_input($btn_guardar)
		));
		
		
		echo $this->table->generate();		
		echo form_fieldset_close();
		echo form_close();

	?>
</body>
</html>