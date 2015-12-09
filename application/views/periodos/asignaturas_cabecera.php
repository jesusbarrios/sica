<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.js"></script>
	<script type="text/javascript">
    	$(document).ready(function () {
	    	$('form').keypress(function(e){
	    		$('.error').hide('fast');
	    		$('.ok').hide('fast');
	    	}).click(function(e){
	    		$('.error').hide('fast');
	    		$('.ok').hide('fast');
	    	});

	    	$('#slc_facultad').change(function() {
	    		$('#detalles').html("");
	    		$('#slc_sede').html("<option value=>-----</option>");
				$('#slc_carrera').html("<option value=>-----</option>");
				$('#slc_tipo_curso').val('');
				$('#txt_apertura').html(' ');
				$('#txt_cierre').html(' ');
	  			facultad 	= $(this).val();
				$.post('<?=base_url()?>index.php/periodos/asignaturas/actualizar_slc_sede', {slc_facultad : facultad}, function (respuesta) {
					$('#slc_sede').html(respuesta);
				});
    		});

    		$('#slc_sede').change(function() {
    			$('#detalles').html("");
				$('#slc_carrera').html("<option value=>-----</option>");
				$('#slc_tipo_curso').val('');
				$('#txt_apertura').html(' ');
				$('#txt_cierre').html(' ');
				facultad 	= $('#slc_facultad').val();
				sede 		= $(this).val();
				$.post('<?=base_url()?>index.php/periodos/asignaturas/actualizar_slc_carrera', {slc_facultad : facultad, slc_sede : sede}, function (respuesta) {
					$('#slc_carrera').html(respuesta);
				});
    		});

    		$('#slc_carrera').change(function() {
    			facultad 	= $('#slc_facultad').val();
	  			carrera		= $(this).val();
   				if(carrera){
   					$.post('<?=base_url()?>index.php/periodos/asignaturas/cargar_slc_semestre', {slc_facultad : facultad, slc_carrera : carrera}, function (respuesta) {
						$('#slc_semestre').html(respuesta);
					});
				}else{
					$('#slc_semestre').html("<option value=>-----</option>");
					$('#slc_asignatura').html("<option value=>-----</option>");
					$('#detalles').html("");
				}
    		});

    		$('#slc_semestre').change(function() {
    			facultad 	= $('#slc_facultad').val();
	  			carrera		= $('#slc_carrera').val();
	  			semestre	= $(this).val();
   				if(semestre){
   					$.post('<?=base_url()?>index.php/periodos/asignaturas/cargar_slc_asignatura', {slc_facultad : facultad, slc_carrera : carrera, slc_semestre : semestre}, function (respuesta) {
						$('#slc_asignatura').html(respuesta);
						
					});
				}else{
					$('#slc_asignatura').html("<option value=>-----</option>");
					$('#detalles').html("");
				}
    		});

    		$('#slc_asignatura').change(function() {
    			facultad 	= $('#slc_facultad').val();
    			sede 		= $('#slc_sede').val();
	  			carrera		= $('#slc_carrera').val();
	  			semestre	= $('#slc_semestre').val();
	  			asignatura	= $(this).val();
   				if(asignatura){
   					$.post('<?=base_url()?>index.php/periodos/asignaturas/actualizar_detalles', {slc_facultad : facultad, slc_sede : sede, slc_carrera : carrera, slc_semestre : semestre, slc_asignatura : asignatura}, function (respuesta) {
						$('#detalles').html(respuesta);
					});
					
				}
				if(asignatura == 'todas' || !asignatura){
					$('#txt_docente').attr('disabled', true);
					$('#slc_dia').attr('disabled', true);
					$('#txt_desde').attr('disabled', true);
					$('#txt_hasta').attr('disabled', true);
				}else{
					$('#txt_docente').attr('disabled', false);
					$('#slc_dia').attr('disabled', false);
					$('#txt_desde').attr('disabled', false);
					$('#txt_hasta').attr('disabled', false);
				}
    		});
	    });
	</script>

	<link rel="stylesheet" href="<?=base_url()?>css/frm_login.css" type="text/css" />
	<style>
		fieldset{
			background-color: #EEEEEE;
		    border-radius: 10px 10px 10px 10px;
		    font-size: 11px;
		    margin: 0 auto;
		    padding: 0 10px;
		    width: 700px;
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
		    padding-right: 7px;
		    text-align: right;
		    width: 150px;
		}

		table.cabecera td{
			vertical-align: top;
		}

		table.cabecera input[type="submit"] {
		    cursor: pointer;
		}
		table.cabecera .error{
			color: #000000;
		    background: none repeat scroll 0 0 #FF9E9E;
		    border: 1px solid #AA8888;
		    font-size: 13px;
		    margin: 2px 0px;
		    padding: 1px;
		    text-align: left;
		}

		table.cabecera .ok{
			color: #000000;
		    background: none repeat scroll 0 0 #9EFF9E;
		    border: 1px solid #88AA88;
		    font-size: 15px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		}
		table.cabecera .obligatorio {
		    color: #FF0000;
		    float: left;
		    font-size: 11px;
		    margin-top: 20px;
		    padding: 0 2px;
		}

		table.cabecera{
			margin: 10px auto;
		}

		table.cabecera #detalles{
			text-align: center;
		}
	</style>
	
</head>

<body>
	<?php
		echo form_open('');
		echo form_fieldset('Habilitación de inscripcion semestral');
		
		//MENSAJE
		if($mensaje){
			$this->table->add_row(array(
				array('data' => $mensaje, 'colspan' => 2, 'class' => 'ok'),
			));
		}
		
		/*
		*PERIODOS
		*/
		$slc_periodo = array('' => '-----');
		if($periodos)
			foreach ($periodos->result() as $periodos_)
				$slc_periodo[$periodos_->id_periodo] = $periodos_->id_periodo;

		$this->table->add_row(array(
			form_label('Periodo:', 'slc_periodo'),
			form_dropdown('slc_periodo', $slc_periodo, set_value('slc_periodo'), 'id=slc_periodo')
			. form_error('slc_periodo', '<div class="error">', '</div>'),
		));

		/*
		*FACULTADES
		*/
		if($facultades){
			 $slc_facultad = array('' => '-----');
			foreach ($facultades->result() as $facultades_)
				$slc_facultad[$facultades_->id_facultad] = $facultades_->facultad;
			$this->table->add_row(array(
				form_label('Facultad:', 'slc_facultad'),
				form_dropdown('slc_facultad', $slc_facultad, set_value('slc_facultad'), 'id=slc_facultad')
				. form_error('slc_facultad', '<div class="error">', '</div>'),
			));
		}

		/*
		*SEDES
		*/
		$slc_sede = array('' => '-----');
		if($sedes)
			foreach ($sedes->result() as $sedes_) 
				$slc_sede[$sedes_->id_sede] = $sedes_->sede;
		$this->table->add_row(array(
			form_label('Sede:', 'slc_sede'),
			form_dropdown('slc_sede', $slc_sede, set_value('slc_sede'), 'id=slc_sede $estado_slc_sede')
			. form_error('slc_sede', '<div class="error">', '</div>'),
		));

		
		/*
		*
		CARRERAS
		*
		*/
		$slc_carrera = array('' => '-----');
		if($carreras)
			foreach ($carreras->result() as $carreras_) 
				$slc_carrera[$carreras_->id_carrera] = $carreras_->carrera;
		$this->table->add_row(array(
			form_label('Carrera:', 'slc_carrera'),
			form_dropdown('slc_carrera', $slc_carrera, set_value('slc_carrera'), 'id=slc_carrera $estado_slc_carrera')
			. form_error('slc_carrera', '<div class="error">', '</div>'),
		));


		/*
		*
		SEMESTRES
		*
		*/
		$slc_tipo_curso = array(
			''		=> '-----',
			'CPI'	=> 'CPI',
			'Impar'	=> 'Impar',
			'Par'	=> 'Par',
		);
		$this->table->add_row(array(
			form_label('Tipo de curso:', 'slc_tipo_curso'),
			form_dropdown('slc_tipo_curso', $slc_tipo_curso, set_value('slc_tipo_curso'), 'id=slc_tipo_curso')
			. form_error('slc_tipo_curso', '<div class="error">', '</div>'),
		));

		$txt_apertura = array(
			'type' 		=> 'date',
			'name'		=> 'txt_apertura',
			'id'		=> 'txt_apertura',
			'maxlength'	=> '10',
			'value'		=> set_value('txt_apertura'),
		);

		$this->table->add_row(array(
			form_label('Apertura:', 'txt_apertura'),
			form_input($txt_apertura)
			. form_error('txt_apertura', '<div class="error">', '</div>'),
		));

		$txt_cierre = array(
			'type' 		=> 'date',
			'name'		=> 'txt_cierre',
			'id'		=> 'txt_cierre',
			'maxlength'	=> '10',
			'value'		=> set_value('txt_cierre'),
		);

		$this->table->add_row(array(
			form_label('Cierre:', 'txt_cierre'),
			form_input($txt_cierre)
			. form_error('txt_cierre', '<div class="error">', '</div>'),
		));

		/*
		*BOTON
		*/
		$boton = array(
			'name'=>'',
			'value'=>'Aceptar',
		);	

		$this->table->add_row(array(
			false,
			form_submit($boton),
		));
		$this->table->add_row(array('data' => $detalles, 'colspan' => 2, 'id' => 'detalles'));

		$this->table->set_template(array ( 'table_open'  => '<table border="0" cellpadding="2" cellspacing="0" class="cabecera">' ));
		echo $this->table->generate();
		echo form_fieldset_close();
		echo form_close();

	?>
</body>
</html>