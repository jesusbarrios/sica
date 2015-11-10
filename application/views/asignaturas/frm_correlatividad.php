<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	
	<script type="text/javascript" src="<?=base_url()?>js/jquery.js"></script>
	
	<script>
		$('document').ready(function(){
		
			$('input[type=text]').keypress(function(e){
			 	$('.ok').hide('slow');
				$('.error').hide('slow');
		    	if(e.which == 13)
		    		return false;
		    });

			$('select').keypress(function(e){
				if(e.which == 13)
					return false;
			}).change(function(e){
				$('.ok').hide('slow');
				$('.error').hide('slow');
			});
			
			$('form').click(function(){
				$('.ok').hide('slow');
				$('.error').hide('slow');
			}).keypress(function() {
				$('.ok').hide('slow');
				$('.error').hide('slow');
			});

			semestres = new Array('Primer', 'Segundo', 'Tercer', 'Cuarto', 'Quinto', 'Sexto', 'Septimo', 'Octavo', 'Noveno', 'Decimo');

			$('#slc_carrera').change(function() { 
				carrera = $(this).val();
				$('#slc_asignatura').html("<option value=''>-----</option>");
				$('#slc_semestre_correlativo').html("<option value=''>-----</option>");
				$('#slc_asignatura_correlativa').html("<option value=''>-----</option>");
				$('#lista').hide('fast');
				$('#msn').hide('fast');
				$('#btn_guardar').attr('disabled', true);

				if(carrera != ''){
					$.post('<?=base_url()?>asignaturas/correlatividad/actualizar_slc_semestre', {slc_carrera : carrera}, function (respuesta) {
						$('#slc_semestre').html(respuesta);
					});
				}else{
					$('#slc_semestre').html("<option value=''>-----</option>");
				}
			});


			$('#slc_semestre').change(function(args) {
				carrera = $('#slc_carrera').val();
				semestre = $(this).val();
				
				if(semestre != ''){
					$.post('<?=base_url()?>asignaturas/correlatividad/actualizar_slc_semestre', {slc_carrera : carrera, slc_semestre : semestre}, function (respuesta) {
						$('#slc_semestre_correlativo').html(respuesta);
					});
				}else{
					$('#slc_semestre_correlativo').html("<option value=''>-----</option>");
				}
				
				/*
				$('#slc_semestre_correlativo option[value=""]').prop('selected', true);
				$('#slc_asignatura_correlativa').html("<option value=''>-----</option>");
				$('#msn').hide('fast');
				$('#btn_guardar').attr('disabled', true);

				cantidad_slc_semestre2 = $('#slc_semestre_correlativo option').length;
				semestre_seleccionado = $('#slc_semestre').val();
				
				$('#lista').hide('fast');

				if(cantidad_slc_semestre2 < semestre_seleccionado){
					for(i = cantidad_slc_semestre2; i < semestre_seleccionado; i ++){
						$('#slc_semestre_correlativo').append(new Option(semestres[i], i, false, false));
					}	
				}else{
					for(i = cantidad_slc_semestre2; i > semestre_seleccionado -1; i --){
						$("#slc_semestre_correlativo option[value=" + i + "]").remove();
					}
				}
*/
				$.post('<?=base_url()?>asignaturas/correlatividad/actualizar_slc_asignatura', {slc_carrera : carrera, slc_semestre : semestre}, function (respuesta) {
					$('#slc_asignatura').html(respuesta);
				});
			});
			
			
			$('#slc_asignatura').change(function(args) {
				carrera = $('#slc_carrera').val();
				semestre = $('#slc_semestre').val();
				asignatura = $(this).val();
				$('#lista').hide('fast');
				$('#msn').hide('fast');
				$('#btn_guardar').attr('disabled', true);
				
				if(asignatura != ''){
					$.post('<?=base_url()?>asignaturas/correlatividad/actualizar_detalle_correlatividad', {slc_carrera : carrera, slc_semestre : semestre, slc_asignatura : asignatura}, function (respuesta) {
						$('#detalle')
						.html(respuesta)
						.show('fast');
					});
				}
			});
			

			$('#slc_semestre_correlativo').change(function(args) {
				carrera = $('#slc_carrera').val();
				semestre_correlativo = $(this).val();
				$('#msn').hide('fast');
				$('#btn_guardar').attr('disabled', true);

				$.post('<?=base_url()?>asignaturas/correlatividad/actualizar_slc_asignatura', {slc_carrera : carrera, slc_semestre : semestre_correlativo}, function (respuesta) {
					$('#slc_asignatura_correlativa').html(respuesta);
				});
			});
			
			$('#slc_asignatura_correlativa').change(function(args) {
				$('#msn').hide('fast');
				
				asignatura_correlativa = $(this).val();
				if(asignatura_correlativa)
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
		    margin: 10px auto;
		    padding: 10 33px;
		    width: 650px;
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
		    width: 200px;
		}

		 .error{
			color: #000000;
		    background: none repeat scroll 0 0 #FF9E9E;
		    border: 1px solid #AA8888;
		    font-size: 13px;
		    margin: 2px;
		    padding: 1px;
		    text-align: left;
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
			echo form_open('');
			echo form_fieldset('Creación de correlatividad');
			
			if($msn)
				echo "<div class=ok>$msn</div>";
		
			//CAMPO CARRERA
			$opciones = array('' => '-----');
			if($carreras){
				foreach($carreras->result() as $row)
					$opciones[$row->id_carrera] = $row->carrera;	
			}

			$this->table->add_row(array(
				form_label('Carrera:'),
				form_dropdown('slc_carrera', $opciones, set_value('slc_carrera'), 'id = slc_carrera autofocus=autofocus') .
				form_error('slc_carrera', '<div class=error>', '</div>')
			));
			
			//CAMPO SEMESTRES
//			$matriz_semestres = array('CPI', 'Primer', 'Segundo', 'Tercer', 'Cuarto', 'Quinto', 'Sexto', 'Septimo', 'Octavo', 'Noveno', 'Decimo');
			$opciones = array('' => '-----');
			if($semestres){
				foreach($semestres->result() as $row){
					$opciones[$row->id_semestre] = $row->semestre;
				}
			}

			$this->table->add_row(array(
				form_label('Semestre:'),
				form_dropdown('slc_semestre', $opciones, set_value('slc_semestre'), 'id = slc_semestre') .
				form_error('slc_semestre', '<div class=error>', '</div>')
			));
			
			//CAMPO ASIGNATURA
			$opciones = array('' => '-----');
			if($asignaturas){
				foreach($asignaturas->result() as $row){
					$opciones[$row->id_asignatura] = $row->asignatura;
				}
			}
			$this->table->add_row(array(
				form_label('Asignatura:'),
				form_dropdown('slc_asignatura', $opciones, set_value('slc_asignatura'), 'id= slc_asignatura') .
				form_error('slc_asignatura', '<div class=error>', '</div>')
			));
			
			//CAMPO SEMESTRES CORRELATIVO
			$opciones = array('' => '-----');
			if($semestres){
 				$i = set_value('slc_semestre');
				foreach($semestres->result() as $row){
					if($i > 0)
						$opciones[$row->id_semestre] = $row->semestre;
					
					$i -= 1;
				}
			}

			$this->table->add_row(array(
				form_label('Semestre correlativo:'),
				form_dropdown('slc_semestre_correlativo', $opciones, set_value('slc_semestre_correlativo'), 'id = slc_semestre_correlativo') .
				form_error('slc_semestre_correlativo', '<div class=error>', '</div>')
			));
			
			//CAMPO ASIGNATURA ANTERIORES
			$opciones = array('' => '-----');
			if($asignaturas_anteriores){
				foreach($asignaturas_anteriores->result() as $row){
					$opciones[$row->id_asignatura] = $row->asignatura;
				}
			}
			$this->table->add_row(array(
				form_label('Asignatura correlativa:'),
				form_dropdown('slc_asignatura_correlativa', $opciones, set_value('slc_asignatura_correlativa'), 'id= slc_asignatura_correlativa') .
				form_error('slc_asignatura_correlativa', '<div class=error>', '</div>')
			));
			
			//CAMPO BOTON
			$boton = array(
				'type' => 'submit',
				'value' => 'Guardar',
				'disabled' => 'disabled',
				'id' => 'btn_guardar',
				'name' => 'btn_guardar',
			);

			$this->table->add_row(array(
				'',
				form_input($boton)
			));

			
			
			//DETALLE
			$this->table->add_row(array(
				array('data' => $detalle, 'id' => 'detalle', 'colspan' => '2')
			));
			
						
			

			
		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0">'));
		echo $this->table->generate();
		
		echo form_fieldset_close();
		echo form_close();
	?>
</body>
</html>