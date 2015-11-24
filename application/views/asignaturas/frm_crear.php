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
			

			semestres = new Array('CPI', 'Primer', 'Segundo', 'Tercer', 'Cuarto', 'Quinto', 'Sexto', 'Septimo', 'Octavo', 'Noveno', 'Decimo');

			$('#slc_carrera').change(function() { 
				carrera = $(this).val();
				$('#slc_curso option[value=]').prop('selected', true);
				
				$('#detalle').hide('fast');
				$('#txt_asignatura').val('').attr('readonly', true);
				$('#btn_guardar').attr('disabled', true);

				$.post('<?=base_url()?>index.php/asignaturas/crear/actualizar_slc_curso', {slc_carrera : carrera}, function (respuesta) {
					alert('uno');
					$("#slc_curso").html(respuesta);
				});
			});

			$('#slc_curso').change(function(args) {
				carrera = $('#slc_curso').val();
				semestre = $(this).val();
				$('#txt_asignatura').val('');
				
				if(semestre){
					$('#txt_asignatura').attr('readonly', false);
					$('#btn_guardar').attr('disabled', false);
					$.post('<?=base_url()?>index.php/asignaturas/crear/actualizar_detalle', {slc_carrera : carrera, slc_semestre : semestre}, function (respuesta) {
						$('#detalle')
						.show('fast')
						.html(respuesta);
					});
				}else{
					$('#txt_asignatura').attr('readonly', true);
					$('#btn_guardar').attr('disabled', true);
					$('#detalle').hide('fast');
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
		echo form_open('index.php/asignaturas/crear');
		echo form_fieldset('Creación de asignatura');

//		echo "<div id=frm_msn class=" . $frm_msn_class . ">" . $frm_msn . "</div>";

		//CAMPO CARRERA
		$opciones = array('' => '-----');
		foreach($carreras->result() as $row)
			$opciones[$row->id_carrera] = $row->carrera;	

		$this->table->add_row(array(
			form_label('Carrera:'),
			form_dropdown('slc_carrera', $opciones, set_value('slc_carrera'), 'id = slc_carrera autofocus=autofocus') .
			form_error('slc_carrera', '<div class=error>', '</div>')
		));

		//CAMPO CURSO
		$opciones = array(null => '-----');
		if($cursos){
			foreach($cursos->result()  as $row){
				$opciones[$row->id_curso] = $row->curso;
			}
		}

		$this->table->add_row(array(
			form_label('Curso:'),
			form_dropdown('slc_curso', $opciones, set_value('slc_curso'), 'id = slc_curso') .
			form_error('slc_curso', '<div class=error>', '</div>')
		));

		//CAMPO ASIGNATURA
		$txt_asignatura = array(
			'name' => 'txt_asignatura',
			'id' => 'txt_asignatura',
			'value' => set_value('txt_asignatura'),
			'size' => '70',
			'maxlength' => '100',
			(set_value('txt_asignatura') != "")? 'autofocus' : '' => '',
		);

		if(!set_value('slc_semestre'))
			$txt_asignatura['readonly'] = 'readonly';

		$this->table->add_row(array(
			form_label('Asignatura:'),
			form_input($txt_asignatura) . 
			form_error('txt_asignatura', '<div class=error>', '</div>')
		));

		//CAMPO BOTON
		$boton = array(
			'type' => 'submit',
			'id' => 'btn_guardar',
			'name' => 'btn_guardar',
			'value' => 'Guardar',
		);
		if(!set_value('slc_semestre'))
			$boton['disabled'] = 'disabled';

		$this->table->add_row(array(
			'',
			form_input($boton)
		));
		
		if($detalle)
			$this->table->add_row(array('data' => $detalle, 'colspan' => '2', 'id' => 'detalle'))	;
		else
			$this->table->add_row(array('data' => '', 'colspan' => '2', 'id' => 'detalle'))	;

		$this->table->set_template(array('table_open' => '<table cellspacing= "0", border="0">'));
		echo $this->table->generate();
		
		echo form_fieldset_close();
		echo form_close();
	?>
</body>
</html>