<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function(){
			 $('input[type=text]').keypress(function(e){
			 	$('.error').hide('slow');
		    	if(e.which == 13)
		    		return false;
		    });

			$('select').keypress(function(e){
				if(e.which == 13)
					return false;
			}).change(function(e){
				$('.error').hide('slow');
			});
			
			$('#slc_facultad').change(function() { 
				actividad	= $('#slc_actividad').val();
				facultad 	= $(this).val();

				if(facultad){
					$.post('<?=base_url()?>index.php/periodos/crear/actualizar_slc_sede', {slc_actividad : actividad, slc_facultad : facultad}, function (respuesta) {
						var datos = $.parseJSON(respuesta);
						$("#slc_sede").html(datos['slc_sede']);
						$("#slc_carrera").html(datos['slc_carrera']);
						$("#slc_semestre").html(datos['slc_semestre']);
						$("#slc_periodo").html(datos['slc_periodo']);
						$("#detalle").html(datos['detalle']);
					});
				}else{
					$("#slc_sede").html('<option value="">-----</option>');
					$("#slc_carrera").html('<option value="">-----</option>');
					$("#slc_semestre").html('<option value="">-----</option>');
					$("#slc_periodo").html('<option value="">-----</option>');
					$("#detalle").html('');
				}
			});

			$('#slc_sede').change(function() {
				actividad 		= $('#slc_actividad').val();
				if($('#slc_facultad').val())
					facultad	= $('#slc_facultad').val();
				else
					facultad 	= false;

				sede 		= $(this).val();
				carrera 	= $('#slc_carrera').val();
				semestre 	= $('#slc_semestre').val();
				periodo 	= $('#slc_periodo').val();
				if(sede){
					$.post('<?=base_url()?>index.php/periodos/crear/actualizar_slc_carrera', {slc_actividad : actividad, slc_facultad : facultad, slc_sede : sede, slc_carrera : carrera, slc_semestre : semestre, slc_periodo : periodo}, function (respuesta) {
						var datos = $.parseJSON(respuesta);
						$("#slc_carrera").html(datos['slc_carrera']);
						$("#slc_semestre").html(datos['slc_semestre']);
						$("#slc_periodo").html(datos['slc_periodo']);
						$("#detalle").html(datos['detalle']);
					});
				}else{
					$("#slc_carrera").html('<option value="">-----</option>');
					$("#slc_semestre").html('<option value="">-----</option>');
					$("#slc_periodo").html('<option value="">-----</option>');
					$("#detalle").html('');
				}
			});


			$('#slc_carrera').change(function() { 
				actividad 	= $("#slc_actividad").val();
				if($('#slc_facultad').val())
					facultad	= $('#slc_facultad').val();
				else
					facultad 	= false;
				sede 		= $('#slc_sede').val();
				carrera 	= $(this).val();
				semestre 	= $('#slc_semestre').val();
				periodo 	= $('#slc_periodo').val();
				if(carrera){
					$.post('<?=base_url()?>index.php/periodos/crear/actualizar_slc_semestre', {slc_actividad : actividad, slc_facultad : facultad, slc_sede: sede, slc_carrera : carrera, slc_semestre : semestre, slc_periodo : periodo}, function (respuesta) {
						var datos = $.parseJSON(respuesta);
						$("#slc_semestre").append(datos['slc_semestre']);
						$("#slc_periodo").html(datos['slc_periodo']);
						$("#detalle").html(datos['detalle']);
					});

				}else{
					$('#slc_semestre')
					.append('<option value="">-----</option>');
					$('#detalle').html('');
				}
			});

			$('#slc_semestre').change(function(args) {
				actividad 	= $("#slc_actividad").val();
				facultad 	= $('#slc_facultad').val();
				sede 		= $('#slc_sede').val();
				carrera 	= $('#slc_carrera').val();
				semestre 	= $(this).val();
				periodo 	= $('#slc_periodo').val();

				if(periodo){
					$.post('<?=base_url()?>index.php/periodos/crear/actualizar_detalle', {slc_actividad : actividad, slc_facultad : facultad, slc_sede : sede, slc_carrera : carrera, slc_semestre : semestre, slc_periodo : periodo}, function (respuesta) {
						$('#detalle').html(respuesta);
					});
				}else{
					$('#detalle').html('');
				}
			})

			$('#slc_periodo').change(function(args) {
				actividad 	= $('#slc_actividad').val();
				facultad 	= $('#slc_facultad').val();
				sede 		= $('#slc_sede').val();
				carrera 	= $('#slc_carrera').val();
				semestre 	= $('#slc_semestre').val();
				periodo 	= $(this).val();
				
				if(sede){
					$.post('<?=base_url()?>index.php/periodos/crear/actualizar_detalle', {slc_actividad : actividad, slc_facultad : facultad, slc_sede : sede, slc_carrera : carrera, slc_semestre : semestre, slc_periodo : periodo}, function (respuesta) {
						$('#detalle').html(respuesta);
					});
				}else{
					$('#detalle').html('');
				}
			})
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
		    margin-top: 0px;
		    padding-right: 7px;
		    text-align: right;
		    vertical-align: top;
		    width: 140px;
		}

		table.cabecera .error{
			color: #000000;
		    background: none repeat scroll 0 0 #FF9E9E;
		    border: 1px solid #AA8888;
		    font-size: 13px;
		    margin: 2px;
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
			padding: 5px 3px;
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