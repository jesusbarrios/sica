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

	    	$('#slc_periodo').focus();

	    	$('#txt_usuario').blur(function() {
	    		$("#detalles").html("<h2>Cargando...</h2>");
	    		usuario 	= $(this).val();
 				$.post('<?=base_url()?>index.php/usuario/asignar_rol/actualizar_detalles', {txt_usuario : usuario}, function (respuesta) {
					$('#detalles').html(respuesta);
				});
    		});

	    	$('#slc_facultad').change(function() {
	  			facultad 	= $(this).val();
   				if(facultad){
   					$.post('<?=base_url()?>index.php/periodos/asignaturas/cargar_slc_sede', {slc_facultad : facultad}, function (respuesta) {
						$('#slc_sede').html(respuesta);
					});
				}else{
					$('#slc_sede').html("<option value=>-----</option>");
					$('#slc_carrera').html("<option value=>-----</option>");
					$('#slc_semestre').html("<option value=>-----</option>");
					$('#slc_asignatura').html("<option value=>-----</option>");
					$('#detalles').html("");
				}
    		});

    		$('#slc_sede').change(function() {
    			facultad 	= $('#slc_facultad').val();
	  			sede 		= $(this).val();
   				if(sede){
   					$.post('<?=base_url()?>index.php/periodos/asignaturas/cargar_slc_carrera', {slc_facultad : facultad, slc_sede : sede}, function (respuesta) {
						$('#slc_carrera').html(respuesta);
					});
				}else{
					$('#slc_carrera').html("<option value=>-----</option>");
					$('#slc_semestre').html("<option value=>-----</option>");
					$('#slc_asignatura').html("<option value=>-----</option>");
					$('#detalles').html("");
				}
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
		if($slc_periodo){
			$this->table->add_row(array(
				form_label('Periodo:', 'slc_periodo'),
				form_dropdown('slc_periodo', $slc_periodo, set_value('slc_periodo'), 'id=slc_periodo')
				. form_error('slc_periodo', '<div class="error">', '</div>'),
			));
		}

		/*
		*FACULTADES
		*/
		if($slc_facultad){
			$this->table->add_row(array(
				form_label('Facultad:', 'slc_facultad'),
				form_dropdown('slc_facultad', $slc_facultad, set_value('slc_facultad'), 'id=slc_facultad')
				. form_error('slc_facultad', '<div class="error">', '</div>'),
			));
		}

		/*
		*SEDES
		*/
		if($slc_sede){
			$this->table->add_row(array(
				form_label('Sede:', 'slc_sede'),
				form_dropdown('slc_sede', $slc_sede, set_value('slc_sede'), 'id=slc_sede $estado_slc_sede')
				. form_error('slc_sede', '<div class="error">', '</div>'),
			));
		}
		
		/*
		*
		CARRERAS
		*
		*/
		if($slc_carrera){
			$this->table->add_row(array(
				form_label('Carrera:', 'slc_carrera'),
				form_dropdown('slc_carrera', $slc_carrera, set_value('slc_carrera'), 'id=slc_carrera $estado_slc_carrera')
				. form_error('slc_carrera', '<div class="error">', '</div>'),
			));
		}

		/*
		*
		SEMESTRES
		*
		*/
		if($slc_semestre){
			$this->table->add_row(array(
				form_label('Semestre:', 'slc_semestre'),
				form_dropdown('slc_semestre', $slc_semestre, set_value('slc_semestre'), 'id=slc_semestre')
				. form_error('slc_semestre', '<div class="error">', '</div>'),
			));
		}

		/*
		*
		ASIGNATURAS
		*
		*/
		if($slc_asignatura){
			$this->table->add_row(array(
				form_label('Asignatura:', 'slc_asignatura'),
				form_dropdown('slc_asignatura', $slc_asignatura, set_value('slc_asignatura'), 'id=slc_asignatura')
				. form_error('slc_asignatura', '<div class="error">', '</div>'),
			));
		}

		/*
		*
		*DOCENTES
		*
		*/
/*		$txt_docente = array(
			'type'			=> 'input',
			'name'			=> 'txt_docente',
			'id'			=> 'txt_docente',
			'maxlength'		=> '100',
			'size'			=> '50',
			'autocomplete'	=> 'Off',
			'list'			=> 'opciones',
			'value'			=> set_value('txt_docente'),
		);
		if(set_value('slc_asignatura') == 'todas' || !set_value('slc_asignatura'))
			$txt_docente['disabled'] = 'disabled';

		$opciones = "<datalist id='opciones'>";
		if($docentes)
//			foreach($docentes->result() as $row)
//				$opciones .= "<option value='$row->nombre $row->apellido $row->documento'>";
			
		$opciones .= "</datalist>";

		$this->table->add_row(array(
			form_label('Docente:', 'txt_docente'),
			form_input($txt_docente) . $opciones
			. form_error('txt_docente', '<div class="error">', '</div>'),
		));

		/*
		*DIAS DE CLASE
		*/


/*		$slc_dia = array('' => '-----', '2' => 'Lunes', '3' => 'Martes', '4' => 'Miercoles', '5' => 'Jueves', '6' => 'Viernes', '7' => 'Sabado', '1' => 'Domingo');
		if((set_value('slc_asignatura') == 'todas' || !set_value('slc_asignatura'))){
			$this->table->add_row(array(
				form_label('Día:', 'slc_dia'),
				form_dropdown('slc_dia', $slc_dia, set_value('slc_dia'), 'id = slc_dia disabled')
				. form_error('slc_dia', '<div class="error">', '</div>'),
			));
		}else{
			$this->table->add_row(array(
				form_label('Día:', 'slc_dia'),
				form_dropdown('slc_dia', $slc_dia, set_value('slc_dia'), 'id=slc_dia' )
				. form_error('slc_dia', '<div class="error">', '</div>'),
			));
		}

		/*
		*DESDE
		*/

/*		$txt_desde = array(
			'type' 		=> 'time',
			'name'		=> 'txt_desde',
			'id'		=> 'txt_desde',
			'maxlength'	=> '10',
			'size'		=> '8',
			'value'		=> set_value('txt_desde'),
		);

		if(set_value('slc_asignatura') == 'todas' || !set_value('slc_asignatura'))
			$txt_desde['disabled'] = 'disabled';

		$this->table->add_row(array(
			form_label('Desde:', 'txt_desde'),
			form_input($txt_desde)
			. form_error('txt_desde', '<div class="error">', '</div>'),
		));

		/*
		*HASTA
		*/

/*		$txt_hasta = array(
			'type' 		=> 'time',
			'name'		=> 'txt_hasta',
			'id'		=> 'txt_hasta',
			'maxlength'	=> '10',
			'size'		=> '8',
			'value'		=> set_value('txt_hasta'),
		);

		if(set_value('slc_asignatura') == 'todas' || !set_value('slc_asignatura'))
			$txt_hasta['disabled'] = 'disabled';

		$this->table->add_row(array(
			form_label('Hasta:', 'txt_hasta'),
			form_input($txt_hasta)
			. form_error('txt_hasta', '<div class="error">', '</div>'),
		));

		/*
		*CIERRE DE INSCRIPCION
		*/

		$txt_cierre = array(
			'type' 		=> 'date',
			'name'		=> 'txt_cierre',
			'id'		=> 'txt_cierre',
			'maxlength'	=> '10',
			'value'		=> set_value('txt_cierre'),
		);

		$this->table->add_row(array(
			form_label('Cierre de inscripción:', 'txt_cierre'),
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
/*
		if($detalles)
			$this->table->add_row(array('data' => $detalles, 'colspan' => 2, 'id' => 'detalles'));
		else
			$this->table->add_row(array('data' => '', 'colspan' => 2, 'id' => 'detalles', 'style' => 'display:none'));
*/		
		$this->table->set_template(array ( 'table_open'  => '<table border="0" cellpadding="2" cellspacing="0" class="cabecera">' ));
		echo $this->table->generate();
		echo form_fieldset_close();
		echo form_close();

	?>
</body>
</html>