<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.js"></script>
    
    <script>
    	$(document).ready(function () {

    		$('form').keypress(function(e){   
		    	if(e == 13){
			    	return false;
		    }
		  });
		
		  $('input:text').keypress(function(e){
		    if(e.which == 13){
		      return false;
		    }
		  });
		 
		  //no funciona 
		  $('checkbox').keypress(function(e){
			  if(e.which == 13){
				  return false;
			}
		  });

		  $('select').keypress(function(e){
		    if(e.which == 13){
		      return false;
		    }
		  });

		  if ($("#mensaje").length > 0){
			  $('#slc_semestre').focus();
			  $('#txt_documento').prop( "readonly", true );
			  $('#btn_buscar').prop( "disabled", true );
			  $('#btn_aceptar').prop( "disabled", false );
		}else{
			$('#txt_documento').prop( "readonly", false ).focus();
			$('#btn_buscar').prop( "disabled", false );
			$('#btn_aceptar').prop( "disabled", true );
	    }
    		
    		$('#btn_buscar').click(function() {
    			documento = $('#txt_documento').val();
	    		$.post('<?=base_url()?>index.php/inscripcion/semestre/autocompletar_campos', {txt_documento : documento}, function (respuesta) {
//	    			alert(respuesta);
					var datos = $.parseJSON(respuesta);
					if(datos['apellido']){
//					alert(respuesta);
						$('#txt_documento').prop( "readonly", true );
						$('#txt_apellido').val(datos['apellido']);
						$('#txt_nombre').val(datos['nombre']);
						$('#slc_sede').html(datos['sedes']).focus();
						$('#slc_carrera').html(datos['carreras']);
						$('#slc_semestre').html(datos['semestres']);
						$('#btn_buscar').prop( "disabled", true );
						$('#detalles').html('');
					}else{
						alert('El documento no esta registrado');
						$('#txt_documento').focus().prop("readonly", false);
					}
				});
				$('#btn_aceptar').prop( "disabled", true );
				
				if ($("#mensaje").length > 0)
					$("#mensaje").hide();
    		})
    		
    		$('#slc_sede').change(function() {
    			documento = $('#txt_documento').val();
    			sede = $('#slc_sede').val();
	    		$.post('<?=base_url()?>index.php/inscripcion/semestre/actualizar_slc_carrera', {txt_documento : documento, slc_sede : sede}, function (respuesta) {
					var datos = $.parseJSON(respuesta);
//					alert(respuesta);
					$('#slc_carrera').html(datos['carreras']);
					$('#slc_semestre').html(datos['semestres']);
					$('#detalles').html('');
				});
				$('#btn_aceptar').prop( "disabled", true );
				if ($("#mensaje").length > 0)
					$("#mensaje").hide();
    		})
    		
    		$('#slc_carrera').change(function() {
    			carrera = $('#slc_carrera').val();
	    		$.post('<?=base_url()?>index.php/inscripcion/semestre/actualizar_slc_semestre', {slc_carrera : carrera}, function (respuesta) {
					$('#slc_semestre').html(respuesta);
					$('#detalles').html('');
				});
				$('#btn_aceptar').prop( "disabled", true );
				
				if ($("#mensaje").length > 0)
					$("#mensaje").hide();
    		})
    		
    		$('#slc_semestre').change(function() {
    			documento = $('#txt_documento').val();
    			sede = $('#slc_sede').val();
    			carrera = $('#slc_carrera').val();
    			semestre = $('#slc_semestre').val();
	    		$.post('<?=base_url()?>index.php/inscripcion/semestre/cargar_detalles', {slc_sede : sede, slc_carrera : carrera, slc_semestre : semestre, txt_documento : documento}, function (respuesta) {
					$('#detalles').html(respuesta);
				});
				
				if(semestre)
					$('#btn_aceptar').prop( "disabled", false );
				else
					$('#btn_aceptar').prop( "disabled", true );
					
				if ($("#mensaje").length > 0)
					$("#mensaje").hide();
    		})
    		
    		$('#btn_cancelar').click(function() {
    		
    			$.post('<?=base_url()?>index.php/inscripcion/semestre/cancelar', function (r) {
	    			alert(r)
    			})
/*    			$('#txt_documento').val('').focus().prop("readonly", false);
    			$('#txt_nombre').val('');
    			$('#txt_apellido').val('');
    			$('#slc_sede').html('<option value=NULL>-----</option>');
	    		$('#slc_carrera').html('<option value=NULL>-----</option>');
				$('#slc_semestre').html('<option value=NULL>-----</option>');
				$('#detalles').html('');
				$('#btn_aceptar').prop( "disabled", true );
				$('#btn_buscar').prop( "disabled", false );
				
				if ($("#mensaje").length > 0)
					$("#mensaje").hide();
*/	    		
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
		.campo_obligatorio {
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
		echo form_fieldset('Inscripción a semestre');

		if($mensaje == 'sin_cambio')	
			echo "<div class='frm_alert' id='mensaje'>No hubo cambios.</div>";
		else if($mensaje == 'existe')	
			echo "<div class='frm_alert' id='mensaje'>Esta inscripción ya existe.</div>";
		else if($mensaje == 'exitoso')
			echo "<div class='frm_ok' id='mensaje'>La inscripción fue exitosa.</div>";

		$documento = array(
			'type' => 'number',
			'name'=>'txt_documento',
			'id'=>'txt_documento',
			'maxlength'=>'10',
			'size'=>'10',
			'value' => set_value('txt_documento'),
		);

		$boton = array(
			'type' => 'button',
			'id' => 'btn_buscar',
			'name' => 'btn_buscar',
			'value' => 'Buscar'
		);

		$this->table->add_row(array(
			form_label('N<sup>ro</sup> de documento:', 'txt_documento'),
			form_input($documento) . form_submit($boton) .
			form_error('txt_documento', '<div class="frm_error">', '</div>')
		));
		
		$apellido = array(
			'type' => 'text',
			'name'=>'txt_apellido',
			'id'=>'txt_apellido',
			'maxlength'=>'20',
			'size'=>'25',
			'value' => ($apellido)? $apellido : set_value('txt_apellido'),
			'readonly' => 'readonly',
		);
		
		$this->table->add_row(array(
			form_label('Apellido:', ''),
			form_input($apellido)
		));
		
		$nombre = array(
			'type' => 'text',
			'name'=>'txt_nombre',
			'id'=>'txt_nombre',
			'maxlength'=>'20',
			'size'=>'25',
			'value' => ($nombre)? $nombre : set_value('txt_nombre'),
			'readonly' => 'readonly',
		);
		
		$this->table->add_row(array(
			form_label('Nombre:', ''),
			form_input($nombre)
		));


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
		$this->table->add_row(
			array('data' => $detalles, 'id'=>'detalles', 'colspan' => '2')
		);
		

		

		$btn_aceptar = array(
			'name'=>'btn_aceptar',
			'id'=>'btn_aceptar',
			'value'=>'Aceptar',
		);
		
		$btn_cancelar = array(
//			'type' => 'button',
			'name'=>'btn_cancelar',
			'id'=>'btn_cancelar',
			'value'=>'Cancelar'
		);
		
		$this->table->add_row(array(
			NULL,
			form_submit($btn_aceptar) . form_submit($btn_cancelar)
		));
			
		
		
		$this->table->set_template(array ( 'table_open'  => '<table border="0" cellpadding="2" cellspacing="0" class="">' ));
		echo $this->table->generate();
			
		echo form_fieldset_close();
		echo form_close();		
?>
</body>
</html>