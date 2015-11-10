<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.js"></script>
    
    <script> 
	    $(document).ready(function () {
		    $('#slc_sede').focus();
    		$('#btn_imprimir').attr('disabled', true);
    		$('form').keypress(function(e){
	    		if(e == 13)
	    			return false;
	    	});
	    	$('select').keypress(function(e){
		    	if(e.which == 13)
		    		return false;
		    });

    		$('#slc_sede').change(function() {
    			sede = $('#slc_sede').val();
	    		$.post('<?=base_url()?>index.php/inscripcion/reporte/actualizar_slc_carrera', {slc_sede : sede}, function (respuesta) {
					var datos = $.parseJSON(respuesta);
					$('#slc_carrera').html(datos['carreras']);
					$('#slc_semestre').html(datos['semestres']);
					$('#slc_asignatura').html(datos['asignaturas'])
					$('#detalles').html('');
				});
				$('#btn_imprimir').attr( "disabled", true );
    		})

    		$('#slc_carrera').change(function() {
    			sede = $('#slc_sede').val();
    			carrera = $('#slc_carrera').val();
	    		$.post('<?=base_url()?>index.php/inscripcion/reporte/actualizar_slc_semestre', {slc_sede : sede, slc_carrera : carrera}, function (respuesta) {
	    			var datos = $.parseJSON(respuesta);

					$('#slc_semestre').html(datos['semestres']);
					$('#slc_asignatura').html(datos['asignaturas']);
					$('#detalles').html('');
				});
				$('#btn_imprimir').attr( "disabled", true );
    		})
    		
    		$('#slc_semestre').change(function() {
    			sede = $('#slc_sede').val();
    			carrera = $('#slc_carrera').val();
    			semestre = $('#slc_semestre').val();
	    		$.post('<?=base_url()?>index.php/inscripcion/reporte/actualizar_slc_asignatura', {slc_sede : sede, slc_carrera : carrera, slc_semestre : semestre}, function (respuesta) {
					$('#slc_asignatura').html(respuesta);
					$('#detalles').html('');
				});

				$('#btn_imprimir').attr( "disabled", true );
    		})
    		
    		$('#slc_asignatura').change(function() {
    			asignatura = $('#slc_asignatura').val();
				if(asignatura){
					$('#btn_imprimir').attr( "disabled", false );
					$('#slc_oportunidad').attr( "disabled", false );
					$('#detalles').show();
				}else{
					$('#btn_imprimir').attr( "disabled", true );
					$('#slc_oportunidad').attr( "disabled", true );
					$('#detalles').hide();
				}
    		})

    		$('#slc_oportunidad').change(function() {
    			sede = $('#slc_sede').val();
    			carrera = $('#slc_carrera').val();
    			semestre = $('#slc_semestre').val();
    			asignatura = $('#slc_asignatura').val();
    			oportunidad = $('#slc_oportunidad').val();
	    		$.post('<?=base_url()?>index.php/inscripcion/reporte/cargar_detalles', {slc_sede : sede, slc_carrera : carrera, slc_semestre : semestre, slc_asignatura : asignatura, slc_oportunidad : oportunidad}, function (respuesta) {
					$('#detalles').html(respuesta);
				});
				if(asignatura){
					$('#btn_imprimir').attr( "disabled", false );
					$('#detalles').show();
				}else{
					$('#btn_imprimir').attr( "disabled", true );
					$('#detalles').hide();
				}
    		})
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
		echo form_fieldset('Reporte de inscripcion para evaluación final');
		/*
		*SEDE
		*/
		if($sedes){
			if($sedes->num_rows() > 1)
				$slc_sede = array(null => '-----');
			foreach($sedes->result() as $row)
				$slc_sede[$row->id_sede] = $row->ciudad;	
		}else{
			$slc_sede = array(null => '-----');
		}

		$this->table->add_row(
			form_label('Sede:'),
			form_dropdown('slc_sede', $slc_sede, set_value('slc_sede'), 'id=slc_sede') . 
			form_error('slc_sede', '<div class="frm_error">', '</div>')
		);

		/*
		*CARRERA
		*/
		if($carreras){
			if($carreras->num_rows() > 1)
				$slc_carrera = array(null => '-----');
			foreach($carreras->result() as $row)
				$slc_carrera[$row->id_carrera] = $row->carrera;
		}else{
			$slc_carrera = array(null => '-----');
		}

		$this->table->add_row(
			form_label('Carrera:'),
			form_dropdown('slc_carrera', $slc_carrera, set_value('slc_carrera'), 'id=slc_carrera') .
			form_error('slc_carrera', '<div class="frm_error">', '</div>')
		);

		//SEMESTRE
		if($semestres){
			if($semestres->num_rows() > 1)
				$slc_semestre = array(null => '-----');
			foreach($semestres->result() as $row)
				if($row->id_semestre > 0)
					$slc_semestre[$row->id_semestre] = $row->semestre;
		}else
			$slc_semestre = array(null => '-----');

		$this->table->add_row(
			form_label('Semestre:'),
			form_dropdown('slc_semestre', $slc_semestre, set_value('slc_semestre'), 'id=slc_semestre') . 
			form_error('slc_semestre', '<div class="frm_error">', '</div>')
		);

		//ASIGNATURAS
		if($asignaturas){
			if($asignaturas->num_rows() > 1)
				$slc_asignatura = array(null => '-----');
			foreach($asignaturas->result() as $row)
				if($row->id_semestre > 0)
					$slc_asignatura[$row->id_asignatura] = $row->asignatura;
		}else
			$slc_asignatura = array(null => '-----');

		$this->table->add_row(
			form_label('Asignatura:'),
			form_dropdown('slc_asignatura', $slc_asignatura, set_value('slc_asignatura'), 'id=slc_asignatura') . 
			form_error('slc_asignatura', '<div class="frm_error">', '</div>')
		);
		
		//OPORTUNIDADES
		if($oportunidades){
//			if($oportunidades->num_rows() > 1)
			$slc_oportunidad = array(null => '-----');
			foreach($oportunidades->result() as $row)
				$slc_oportunidad[$row->id_oportunidad] = $row->oportunidad;
		}else
			$slc_oportunidad = array(null => '-----');

		$this->table->add_row(
			form_label('Oportunidad:'),
			form_dropdown('slc_oportunidad', $slc_oportunidad, set_value('slc_oportunidad'), 'id=slc_oportunidad') . 
			form_error('slc_oportunidad', '<div class="frm_error">', '</div>')
		);
		
		

		$this->table->add_row(
			array('data' => $detalles, 'id'=>'detalles', 'colspan' => '2')
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