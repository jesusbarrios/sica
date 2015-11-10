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
		
		 table{
			margin: 10px;
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
//		$url = $base_url() . 'asignaturas/crear';
		echo form_open('');
		echo form_fieldset('Creación de periodo');

		if($msn)
			$this->table->add_row(array('data' => $msn, 'colspan' => '2', 'class' => 'ok'));

		//ACTIVIDADES
		if($actividades){
			if($actividades->num_rows() > 1)
				$opciones = array('' => '-----');
			foreach($actividades->result() as $row)
				$opciones[$row->id_actividad] = $row->actividad;
		}else{
			$opciones = array('' => '-----');	
		}
		
		$this->table->add_row(array(
			form_label('Actividad:'),
			form_dropdown('slc_actividad', $opciones, set_value('slc_actividad'), 'id = slc_actividad autofocus=autofocus') .
			form_error('slc_actividad', '<div class=error>', '</div>')
		));


		//FACULTAD
		if($facultades){
			if($facultades->num_rows() > 1)
				$opciones_facultad = array('' => '-----');
			foreach($facultades->result() as $row)
				$opciones_facultad[$row->id_facultad] = $row->facultad;
		}else{
			$opciones_facultad = array('' => '-----');	
		}

		$this->table->add_row(array(
			form_label('Facultad:'),
			form_dropdown('slc_facultad', $opciones_facultad, set_value('slc_facultad'), 'id = slc_facultad') .
			form_error('slc_facultad', '<div class=error>', '</div>')
		));

		//SEDES
		if($sedes){
			if($sedes->num_rows() > 1)
				$opciones_sede = array('' => '-----');
			foreach($sedes->result() as $row)
				$opciones_sede[$row->id_sede] = $row->sede;		
		}else{
			$opciones_sede = array('' => '-----');
		}

		$this->table->add_row(array(
			form_label('Sedes:'),
			form_dropdown('slc_sede', $opciones_sede, set_value('slc_sede'), 'id = slc_sede') .
			form_error('slc_sede', '<div class=error>', '</div>')
		));
		
		//CARRERA
		if($carreras){
			if($carreras->num_rows() > 1)
				$opciones_carrera = array('todas' => 'Todas');
			foreach($carreras->result() as $row)
				$opciones_carrera[$row->id_carrera] = $row->carrera;		
		}else{
			$opciones_carrera = array('' => '-----');
		}

		$this->table->add_row(array(
			form_label('Carrera:'),
			form_dropdown('slc_carrera', $opciones_carrera, set_value('slc_carrera'), 'id = slc_carrera') .
			form_error('slc_carrera', '<div class=error>', '</div>')
		));

		//SEMESTRES
		$opciones_semestre = array(null => '-----', 'impar' => 'Impar', 'par' => 'Par', 'cpi' => 'CPI');
/*		if($semestres){
			if($semestres->num_rows() > 1)
				$opciones['todos'] = 'Todos';
			foreach($semestres->result()  as $row)
				$opciones[$row->id_semestre] = $row->semestre;
		}
*/
		$this->table->add_row(array(
			form_label('Semestre:'),
			form_dropdown('slc_semestre', $opciones_semestre, set_value('slc_semestre'), 'id = slc_semestre') .
			form_error('slc_semestre', '<div class=error>', '</div>')
		));
/*
		//ASIGNATURAS
		if($asignaturas){
			if($asignaturas->num_rows() > 1)
				$opciones = array('todos' => 'Todos');
			foreach($asignaturas->result()  as $row)
				$opciones[$row->id_asignatura] = $row->asignatura;
		}else{
			$opciones = array(null => '-----');
		}

		$this->table->add_row(array(
			form_label('Asignatura:'),
			form_dropdown('slc_asignatura', $opciones, set_value('slc_asignatura'), 'id = slc_asignatura') .
			form_error('slc_asignatura', '<div class=error>', '</div>')
		));
*/
		//PERIODO
		$slc_periodo = array('' => '-----');
		if($creacion){
			$anho	= date('Y', strtotime($creacion));
			for($x = date('Y'); $x >= $anho; $x--)
				$slc_periodo[$x] = $x;
		}

		$this->table->add_row(array(
			form_label('Periodo:'),
			form_dropdown('slc_periodo', $slc_periodo, set_value('slc_periodo'), 'id = slc_periodo') .
			form_error('slc_periodo', '<div class=error>', '</div>')
		));

		//INICIO
		$txt_inicio = array(
			'name'	=> 'txt_inicio',
			'id'	=> 'txt_inicio',
			'value'	=> set_value('txt_inicio'),
			'type'	=> 'date',
		);
		
		$this->table->add_row(array(
			form_label('Inicio:'),
			form_input($txt_inicio) .
			form_error('txt_inicio', '<div class=error>', '</div>')
		));		
		
		//FIN
		$txt_fin = array(
			'name'	=> 'txt_fin',
			'id'	=> 'txt_fin',
			'value'	=> set_value('txt_fin'),
			'type'	=> 'date',
		);
		
		$this->table->add_row(array(
			form_label('Fin:'),
			form_input($txt_fin) .
			form_error('txt_fin', '<div class=error>', '</div>')
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

		$this->table->add_row(array('data' => $detalle, 'colspan' => '2', 'id' => 'detalle'));
/*		
		if($detalle)
			$this->table->add_row(array('data' => $detalle, 'colspan' => '2', 'id' => 'detalle'))	;
		else
			$this->table->add_row(array('data' => '', 'colspan' => '2', 'id' => 'detalle'))	;
*/
		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0">'));
		echo $this->table->generate();
		
		echo form_fieldset_close();
		echo form_close();
	?>
</body>
</html>