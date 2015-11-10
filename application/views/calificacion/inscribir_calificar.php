<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">

	<script type="text/javascript" src="<?php echo base_url()?>js/jquery.js"></script>
	
	<script>
		$(document).ready(function () {
			$('#slc_sede').change(function() { 
				sede = $(this).val();
				if(sede != ''){
				
					$.post('<?=base_url()?>index.php/calificacion/actualizar_slc_carrera', {sede : sede}, function (data) {
//					alert(data)		
//						var datos = $.parseJSON(data);
//						$('#slc_carrera').html(datos['carreras']);
						
						$('#slc_carrera').html(data);
					});
				}else{
					$('#slc_carrera').html("<option value=''>-----</option>");	
				}
				
				$('#slc_semestre').html("<option value=''>-----</option>");
				$('#detalles').html("");
			});
			
			$('#slc_carrera').change(function() { 
				carrera = $(this).val();
				if(carrera != ''){
					$.post('<?=base_url()?>index.php/calificacion/actualizar_slc_semestre', {carrera : carrera}, function (respuesta) {
						$('#slc_semestre').html(respuesta);
					});
				}else{
					$('#slc_semestre').html("<option value=''>-----</option>");
				}
				$('#detalles').html("");
			});
			
			$('#slc_semestre').change(function() { 
				semestre = $(this).val();
				carreras = $('#slc_carrera').val();
				if(semestre != ''){
					$.post('<?=base_url()?>index.php/calificacion/actualizar_inscribir_calificar_detalles', {carrera : carrera, semestre : semestre}, function (respuesta) {
						$('#detalles').html(respuesta);
						$('#btn_cancelar').hide();
					});
				}else{
					$('#detalles').html("");
					$('#btn_cancelar').show();
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
		    width: 500px;
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
		input {
			margin: 0px 3px 0px 0px;
		}
		input[type="submit"] {
		    cursor: pointer;
/* 		    margin: 20px 125px; */
		}
		.frm_aviso{
			color: #000000;
		    background: none repeat scroll 0 0 #FF9E9E;
		    border: 1px solid #AA8888;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: center;
		}
		.frm_error{
			color: #000000;
		    background: none repeat scroll 0 0 #FF9E9E;
		    border: 1px solid #AA8888;
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
	</style>
	
</head>

<body>
	<?php

		echo form_open();
		echo form_fieldset('Inscribir a semestre y cargar calificaciones');
		
		if($mensaje_aviso)
			echo "<div class='frm_aviso'>" . $mensaje_aviso . "</div>";
		if($mensaje_ok)
			echo "<div class='frm_ok'>" . $mensaje_ok . "</div>";


		$documento = array(
			'type' => 'number',
			'name'=>'txt_documento',
			'id'=>'txt_documento',
			'maxlength'=>'10',
			'size'=>'10',
			'autofocus'=>'autofocus',
			'value' => set_value('txt_documento'),
		
		);

		$this->table->add_row(array(
			form_label('N<sup>ro</sup> de documento:', 'txt_documento'),
			form_input($documento) . 
			form_error('txt_documento', '<div class="frm_error">', '</div>')
		));

		if($persona){
			$row = $persona->row_array();
	
			$this->table->add_row(array(
				form_label('Estudiante:', ''),
				$row['nombre'] . ' ' . $row['apellido']
			));
			
			//CAMPO SEDE
			if($sedes){
				if($sedes->num_rows() > 1)
					$opciones = array(null => '-----');
				else
					$opciones = array();
				
				foreach($sedes->result() as $row)
					$opciones[$row->id_sede] = $row->ciudad;	
			}

			$this->table->add_row(array(
				form_label('Sede:', ''),
				form_dropdown('slc_sede', $opciones, set_value('slc_sede'), 'id=slc_sede')
			));

			//CAMPO CARRERA
			if($carreras){
				if($carreras->num_rows() > 1)
					$opciones_carrera = array(null => '-----');
				else
					$opciones_carrera = array();

				foreach($carreras->result() as $row)
					$opciones_carrera[$row->id_carrera] = $row->carrera;	
			}else{
				$opciones_carrera = array(null => '-----');
			}
			
			$this->table->add_row(array(
				form_label('Carrera:', ''),
				form_dropdown('slc_carrera', $opciones_carrera, set_value('slc_carrera'), 'id=slc_carrera')
			));

			//CAMPO SEMESTRE
			if($semestres){
				if($semestres->num_rows() > 1)
					$opciones_semestre = array(null => '-----');
				else
					$opciones_semestre = array();

				foreach($semestres->result() as $row)
					$opciones_semestre[$row->id_carrera] = $row->carrera;	
			}else{
				$opciones_semestre = array(null => '-----');
			}

			$this->table->add_row(array(
				form_label('Semestre:', ''),
				form_dropdown('slc_semestre', $opciones_semestre, set_value('slc_semestre'), 'id=slc_semestre')
			));

			$boton = array(
				'name'	=> 'btn_cancelar',
				'id'	=> 'btn_cancelar',
				'value'	=> 'Cancelar'
			);

			$this->table->add_row(array(
				NULL,
				form_submit($boton)
			));
		}else{
			$boton = array(
				'name'=>'',
				'value'=>'Buscar'
			);

			$this->table->add_row(array(
				NULL,
				form_submit($boton)
			));	
		}

		echo $this->table->generate();
		
		echo "<div id=detalles></div>";

		echo form_fieldset_close();
		echo form_close();
	?>
</body>
</html>