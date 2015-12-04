<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function(){
			if($('#slc_facultad'))
				$('#slc_facultad').focus();
			else
				$('#txt_carrera').focus();

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
				if($('#slc_facultad').val())
					$('#slc_facultad').val('').focus();
				else
					$('#txt_carrera').focus();
				$('#txt_codigo').val('');
				$('#txt_carrera').val('');
				$('#slc_tipo').val('');
				$('#detalles').html('');
			});
			
			$('#slc_facultad').change(function() {
				id = $(this).val();
				$.post('<?=base_url()?>index.php/carreras/crear/actualizar_detalle', {slc_facultad : id}, function (respuesta) {
					$('#detalles').html(respuesta);
				});
			})
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
		    margin: 2px 0px;
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
		
		table.frm{
			margin: 10px auto;
		}

		table.frm td{
			padding: 3px;
			vertical-align: top;
		}
	</style>
	
</head>

<body>
	<?php
		
		
		echo form_open('');
		echo form_fieldset('Creación de carrera');
		
		//MENSAJE
		if($msn){
			echo "<div id=msn class=ok>$msn</div>";
		}
		
		if($facultades){
			$slc_facultad = array('' => '-----');
			foreach($facultades->result() as $row){
				$slc_facultad[$row->id_facultad] = $row->facultad;
			}
			
			$this->table->add_row(array(
				form_label('Facultad:', 'slc_facultad'),
				form_dropdown('slc_facultad', $slc_facultad, set_value('slc_facultad'), 'id="slc_facultad"') .
				form_error('slc_facultad', '<div class="error">', '</div>')
			));
		}

		//CAMPO: CODIGO
		$txt_codigo = array(
			'type' => 'text',
			'name' => 'txt_codigo',
			'id' => 'txt_codigo',
			'value' => set_value('txt_codigo'),
			'size' => '10',
			'maxlength' => '10',
		);
		
		$this->table->add_row(array(
			form_label('Código:', 'txt_codigo'),
			form_input($txt_codigo) .
			form_error('txt_codigo', '<div class="error">', '</div>')
		));
		
		//CAMPO: NOMBRE DE LA CARRERA
		$txt_carrera = array(
			'type' => 'text',
			'name' => 'txt_carrera',
			'id' => 'txt_carrera',
			'value' => set_value('txt_carrera'),
			'size' => '75',
			'maxlength' => '100',
		);
		
		$this->table->add_row(array(
			form_label('Nombre:'),
			form_input($txt_carrera) .
			form_error('txt_carrera', '<div class="error">', '</div>')
		));

		//TIPO
		$slc_tipo = array('' => '-----', 'Semestral' => 'Semestral', 'Anual' => 'Anual', 'Modular' => 'Modular');
		
		$this->table->add_row(array(
			form_label('Tipo:', 'slc_tipo'),
			form_dropdown('slc_tipo', $slc_tipo, set_value('slc_tipo'), 'id=slc_tipo') .
			form_error('slc_tipo', '<div class="error">', '</div>')
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
			array('data' => $detalle, 'colspan' => '2', 'id' => 'detalles'),
		));	
		
		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0", class= "frm">'));
		echo $this->table->generate();		
		echo form_fieldset_close();
		echo form_close();

	?>
</body>
</html>