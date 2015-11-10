<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.js"></script>
    
    <script> 
	    $(document).ready(function () {
		    $('#slc_periodo').focus();
    		$('#btn_imprimir').attr('disabled', true);
    		$('form').keypress(function(e){
	    		if(e == 13)
	    			return false;
	    	});
	    	$('select').keypress(function(e){
		    	if(e.which == 13)
		    		return false;
		    });
		    
		    $('#slc_periodo').change(function() {
	  			periodo = $(this).val();
	  			if(periodo){
	    			$.post('<?=base_url()?>index.php/reportes/inscripcion/actualizar_slc_facultad', {slc_periodo : periodo}, function (respuesta) {
						$('#slc_facultad').html(respuesta);
					})
				}else{
					$('#slc_facultad').html("<option value=>-----</option>");
				}

				$('#slc_sede').html("<option value=>-----</option>");
				$('#slc_carrera').html("<option value=>-----</option>");
				$('#slc_semestre').html("<option value=>-----</option>");
				$('#slc_asignatura').html("<option value=>-----</option>");
				$('#detalle').html('');
    		});

			$('#slc_facultad').change(function() {
	  			periodo 	= $('#slc_periodo').val();
	  			facultad 	= $(this).val();
   				if(facultad){
   					$.post('<?=base_url()?>index.php/reportes/inscripcion/actualizar_slc_sede', {slc_periodo : periodo, slc_facultad : facultad}, function (respuesta) {
						$('#slc_sede').html(respuesta);
					});
				}else{
					$('#slc_sede').html("<option value=>-----</option>");
				}

				$('#slc_carrera').html("<option value=>-----</option>");
				$('#slc_semestre').html("<option value=>-----</option>");
				$('#slc_asignatura').html("<option value=>-----</option>");
				$('#detalle').html('');
    		});

    		$('#slc_sede').change(function() {
	  			periodo 	= $('#slc_periodo').val();
	  			facultad 	= $('#slc_facultad').val();
	  			sede 		= $(this).val();
   				if(sede){
   					$.post('<?=base_url()?>index.php/reportes/inscripcion/actualizar_slc_carrera', {slc_periodo : periodo, slc_facultad : facultad, slc_sede : sede}, function (respuesta) {
						$('#slc_carrera').html(respuesta);
					});
				}else{
					$('#slc_carrera').html("<option value=>-----</option>");
				}
				
				$('#slc_semestre').html("<option value=>-----</option>");
				$('#slc_asignatura').html("<option value=>-----</option>");
				$('#detalle').html('');
    		});

    		$('#slc_carrera').change(function() {
	  			periodo 	= $('#slc_periodo').val();
	  			facultad 	= $('#slc_facultad').val();
	  			sede 		= $('#slc_sede').val();
	  			carrera 	= $(this).val();
   				if(carrera){
   					$.post('<?=base_url()?>index.php/reportes/inscripcion/actualizar_slc_semestre', {slc_periodo : periodo, slc_facultad : facultad, slc_sede : sede, slc_carrera : carrera}, function (respuesta) {
						$('#slc_semestre').html(respuesta);
					});
				}else{
					$('#slc_semestre').html("<option value=>-----</option>");
				}

				$('#slc_asignatura').html("<option value=>-----</option>");
				$('#detalle').html('');
    		});

    		$('#slc_semestre').change(function() {
	  			periodo 	= $('#slc_periodo').val();
	  			facultad 	= $('#slc_facultad').val();
	  			sede 		= $('#slc_sede').val();
	  			carrera 	= $('#slc_carrera').val();
	  			semestre 	= $(this).val();
	  			if(semestre){
	   				$.post('<?=base_url()?>index.php/reportes/inscripcion/actualizar_slc_asignatura', {slc_periodo : periodo, slc_facultad : facultad, slc_sede : sede, slc_carrera : carrera, slc_semestre : semestre}, function (respuesta) {
						var datos = $.parseJSON(respuesta);
						$('#slc_asignatura').html(datos['slc_asignatura']);
						$('#detalle').html(datos['detalle']);
					});
				}else{
					$('#slc_asignatura').html("<option value=>-----</option>");
					$('#detalle').html(" ");
				}
    		});

    		$('#slc_asignatura').change(function() {
	  			periodo 	= $('#slc_periodo').val();
	  			facultad 	= $('#slc_facultad').val();
	  			sede 		= $('#slc_sede').val();
	  			carrera 	= $('#slc_carrera').val();
	  			semestre 	= $('#slc_semestre').val();
	  			asignatura 	= $(this).val();
   				if(asignatura){
   					$.post('<?=base_url()?>index.php/reportes/inscripcion/actualizar_detalle', {slc_periodo : periodo, slc_facultad : facultad, slc_sede : sede, slc_carrera : carrera, slc_semestre : semestre, slc_asignatura : asignatura}, function (respuesta) {
						$('#detalle').html(respuesta);
					});
				}else{
					$('#detalle').html(' ');
				}
    		});
    	});
    </script>
    
	<style>
		fieldset{
			background-color: #EEEEEE;
		    border-radius: 10px 10px 10px 10px;
		    margin: 0 auto;
		    padding: 0 33px;
		    width: 550px;
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
		table{
			margin:  auto;
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
		}
		.frm_alert{
			color: #000000;
		    background: none repeat scroll 0 0 #ffff00;
		    border: 1px solid #888800;
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
		.campo_obligatorio{
		    color: #FF0000;
		    float: left;
		    font-size: 11px;
		    margin-top: 20px;
		    padding: 0 2px;
		}
		
		.tbl_detalles{
			margin: 10px auto;
		}
		
		.tbl_detalles td label{
			width: 100%;
			text-align: left;
			margin: 1px 5px;
		}
	</style>
	
</head>

<body>
<?php
	echo form_open();
		echo form_fieldset('Reporte de inscripciones');

		//PERIODO
		if($periodos){
//			if($periodos->num_rows() > 1)
			$slc_periodo = array(null => '-----');
			foreach($periodos->result() as $row)
					$slc_periodo[$row->id_periodo] = $row->id_periodo;
		}else
			$slc_periodo = array(null => '-----');

		$this->table->add_row(
			form_label('Periodo:'),
			form_dropdown('slc_periodo', $slc_periodo, set_value('slc_periodo'), 'id=slc_periodo') . 
			form_error('slc_periodo', '<div class="frm_error">', '</div>')
		);

		/*
		*FACULTADES
		*/

		$slc_facultad = array(null => '-----');
			
		$this->table->add_row(
			form_label('Facultad:'),
			form_dropdown('slc_facultad', $slc_facultad, set_value('slc_facultad'), 'id=slc_facultad') . 
			form_error('slc_facultad', '<div class="frm_error">', '</div>')
		);
		
		/*
		*SEDE
		*/
		$slc_sede = array(null => '-----');

		$this->table->add_row(
			form_label('Sede:'),
			form_dropdown('slc_sede', $slc_sede, set_value('slc_sede'), 'id=slc_sede') . 
			form_error('slc_sede', '<div class="frm_error">', '</div>')
		);

		/*
		*CARRERA
		*/
		$slc_carrera = array(null => '-----');

		$this->table->add_row(
			form_label('Carrera:'),
			form_dropdown('slc_carrera', $slc_carrera, set_value('slc_carrera'), 'id=slc_carrera') .
			form_error('slc_carrera', '<div class="frm_error">', '</div>')
		);


		/*
		*SEMESTRES
		*/
		$slc_semestre = array(null => '-----');

		$this->table->add_row(
			form_label('Semestre:'),
			form_dropdown('slc_semestre', $slc_semestre, set_value('slc_semestre'), 'id=slc_semestre') .
			form_error('slc_semestre', '<div class="frm_error">', '</div>')
		);

		/*
		*ASIGNATURAS
		*/
		$slc_asignatura = array(null => '-----');

		$this->table->add_row(
			form_label('Asignatura:'),
			form_dropdown('slc_asignatura', $slc_asignatura, set_value('slc_asignatura'), 'id=slc_asignatura') .
			form_error('slc_asignatura', '<div class="frm_error">', '</div>')
		);

		$this->table->add_row(
			array('data' => '', 'id'=>'detalle', 'colspan' => '2')
		);

		$btn_imprimir = array(
			'name'=>'btn_imprimir',
			'id'=>'btn_imprimir',
			'value'=>'Imprimir',
		);

		$btn_cancelar = array(
//			'type' => 'button',
			'name'=>'btn_cancelar',
			'id'=>'btn_cancelar',
			'value'=>'Cancelar'
		);
		
		$this->table->add_row(array(
			NULL,
			form_submit($btn_imprimir) . form_submit($btn_cancelar)
		));

		$this->table->set_template(array ( 'table_open'  => '<table border="0" cellpadding="2" cellspacing="0" class="">' ));
		echo $this->table->generate();

		echo form_fieldset_close();
		echo form_close();		
?>
</body>
</html>