<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function(){
			$('select').change(function(){
				$('.error').hide('slow');
				$('.ok').hide('slow');
			}).keypress(function(e) {
				if(e.which == 13)
					return false;
			});
				
			$('form').click(function() {
				$('.ok').hide('slow');
				$('.error').hide('slow');	
			});
			
			$('#slc_sede').change(function() { 
				sede = $(this).val();
				if($('#slc_carrera').val() && sede)
					$('#btn_guardar').attr('disabled', false);
				else
					$('#btn_guardar').attr('disabled', true);
				if($('#slc_facultad'))
					facultad = $('#slc_facultad').val();
				else
					facultad = false;
				$.post('<?=base_url()?>index.php/carreras/habilitar/actualizar_detalle', {slc_facultad : facultad, slc_sede : sede}, function (respuesta) {
					$('#detalles').html(respuesta).show();
				});
			}).focus();	
			
			$('#slc_facultad').change(function() { 
				sede = $('#slc_sede').val();
				facultad = $(this).val();
				$.post('<?=base_url()?>index.php/carreras/habilitar/actualizar_slc_carrera', {slc_facultad : facultad}, function (respuesta) {
					$('#slc_carrera').html(respuesta);
				});
				$.post('<?=base_url()?>index.php/carreras/habilitar/actualizar_detalle', {slc_facultad : facultad, slc_sede : sede}, function (respuesta) {
					$('#detalles').html(respuesta).show();
				});
			});	
			
			$('#slc_carrera').change(function() { 
				if($('#slc_sede').val() && $(this).val())
					$('#btn_guardar').attr('disabled', false);
				else
					$('#btn_guardar').attr('disabled', true);
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
		table td{
			padding: 2px 0px;
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
		
	</style>
	
</head>

<body>
	<?php
		
		
		echo form_open();
		echo form_fieldset('Habilitación de carrera');
		
		//MENSAJE
		if($msn)
			echo "<div class=ok>$msn</div>";


		/*
		*
		*FACULTADES
		*
		*/
		if($facultades){
			if($facultades->num_rows() > 1)
				$opcionnes = array('' => '-----');
			foreach($facultades->result() as $row)	
				$opcionnes[$row->id_facultad] = $row->facultad;
			$this->table->add_row(array(
				form_label('Facultad:'),
				form_dropdown('slc_facultad', $opcionnes, set_value('slc_facultad'), 'id=slc_facultad') .
				form_error('slc_facultad', '<div class="error">', '</div>')
			));
		}
		
		/*
		*
		*SEDES
		*
		*/

		if($sedes){
			if($sedes->num_rows() > 1)
				$opcionnes = array('' => '-----');
			foreach($sedes->result() as $row)
				$opcionnes[$row->id_sede] = $row->sede;
		
			$this->table->add_row(array(
				form_label('Sede:'),
				form_dropdown('slc_sede', $opcionnes, set_value('slc_sede'), 'id=slc_sede') .
				form_error('slc_sede', '<div class="error">', '</div>')
			));
		}else{
			$opcionnes = array('' => '-----');
		}

		/*
		*
		*CARRERAS
		*
		*/
		if($carreras){
			if($carreras->num_rows() > 1)
				$opcionnes = array('' => '-----');
			foreach($carreras->result() as $row){	
				$opcionnes[$row->id_carrera] = $row->carrera;
			}
		}else
			$opcionnes = array('' => '-----');

		$this->table->add_row(array(
			form_label('Carreras:'),
			form_dropdown('slc_carrera', $opcionnes, set_value('slc_carrera'), 'id=slc_carrera') .
			form_error('slc_carrera', '<div class="error">', '</div>')
		));

		//BOTON GUARDAR
		$btn_guardar = array(
			'id' => 'btn_guardar',
			'type' => 'submit',
			'value' => 'Guardar',
//			'disabled' => 'true',
		);

		$this->table->add_row(array(
			null,
			form_input($btn_guardar)
		));

		$this->table->add_row(array(
			array('data' => $detalles, 'colspan' => '2', 'id' => 'detalles'),
		));

		$this->table->set_template(array('table_open' => '<table cellspacing= "3", border="0" class="frm">'));
		$this->table->set_caption('');
		echo $this->table->generate();		
		echo form_fieldset_close();
		echo form_close();

	?>
</body>
</html>